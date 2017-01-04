<?php

/**
 * Test case for the module's apps related functions.
 *
 * @package WordPoints_WPDataTables\PHPUnit\Tests
 * @since 1.0.0
 */

/**
 * Tests the module's apps related functions.
 *
 * @since 1.0.0
 */
class WordPoints_WPDataTables_Apps_Functions_Test
	extends WordPoints_PHPUnit_TestCase_Hooks {

	/**
	 * @since 1.0.0
	 */
	public function tearDown() {

		global $wpdb;

		// Reset the database connection to drop the temporary tables created during
		// the tests.
		$wpdb->close();
		$wpdb->db_connect();

		parent::tearDown();
	}

	/**
	 * Test getting the tables for auto-integration.
	 *
	 * @since 1.0.0
	 *
	 * @covers ::wordpoints_wpdatatables_get_tables_for_auto_integration
	 */
	public function test_get_tables_for_auto_integration() {

		$this->factory->wordpoints->wpdatatables_table->create();
		$editable_ids = $this->factory->wordpoints->wpdatatables_table->create_many(
			2
			, array( 'editable' => 1 )
		);

		$this->assertEquals(
			$editable_ids
			, wordpoints_wpdatatables_get_tables_for_auto_integration()
		);
	}

	/**
	 * Test getting the tables for auto-integration.
	 *
	 * @since 1.0.0
	 *
	 * @covers ::wordpoints_wpdatatables_get_tables_for_auto_integration
	 */
	public function test_get_tables_for_auto_integration_filter() {

		$this->factory->wordpoints->wpdatatables_table->create();
		$editable_ids = $this->factory->wordpoints->wpdatatables_table->create_many(
			2
			, array( 'editable' => 1 )
		);

		$mock = new WordPoints_PHPUnit_Mock_Filter( array( 5 ) );
		$mock->add_filter( 'wordpoints_wpdatatables_tables_for_auto_integration' );

		$this->assertEquals(
			array( 5 )
			, wordpoints_wpdatatables_get_tables_for_auto_integration()
		);

		$this->assertEquals( 1, $mock->call_count );
		$this->assertEquals( array( $editable_ids ), $mock->calls[0] );
	}

	/**
	 * Test entities registration function.
	 *
	 * @since 1.0.0
	 *
	 * @covers ::wordpoints_wpdatatables_entities_init
	 */
	public function test_entities_init() {

		$this->mock_apps();

		$this->factory->wordpoints->wpdatatables_table->create();
		$table_data = $this->factory->wordpoints->wpdatatables_table->create_and_get(
			array(
				'editable' => 1,
				'user_id_column' => 'user',
				'columns' => array(
					array(
						'name' => 'User',
						'type' => 'int',
						'possible_values' => '',
						'default_value' => '0',
					),
					array(
						'name' => 'Integer',
						'type' => 'integer',
						'possible_values' => '',
						'default_value' => '0',
					),
					array(
						'name' => 'String',
						'type' => 'string',
						'possible_values' => '',
						'default_value' => '',
					),
				),
			)
		);

		$table_id = $table_data['id'];
		$user_col_id = $table_data['userid_column_id'];

		$registry = wordpoints_entities();
		$children = $registry->get_sub_app( 'children' );

		wordpoints_wpdatatables_entities_init( $registry );

		$this->assertTrue( $registry->is_registered( "wpdatatables_row\\{$table_id}" ) );

		$this->assertTrue(
			$children->is_registered(
				"wpdatatables_row\\{$table_id}"
				, "wpdatatables_row_attr\\{$user_col_id}"
			)
		);
		$this->assertTrue(
			$children->is_registered(
				"wpdatatables_row\\{$table_id}"
				, 'wpdatatables_row_attr\\' . ( $user_col_id + 1 )
			)
		);
		$this->assertTrue(
			$children->is_registered(
				"wpdatatables_row\\{$table_id}"
				, 'wpdatatables_row_attr\\' . ( $user_col_id + 2 )
			)
		);
	}

	/**
	 * Test hook actions registration function.
	 *
	 * @since 1.0.0
	 *
	 * @covers ::wordpoints_wpdatatables_hook_actions_init
	 */
	public function test_hook_actions_init() {

		$this->mock_apps();

		$mock = new WordPoints_PHPUnit_Mock_Filter( array( 5, 7 ) );
		$mock->add_filter( 'wordpoints_wpdatatables_tables_for_auto_integration' );

		$registry = new WordPoints_Hook_Actions();

		wordpoints_wpdatatables_hook_actions_init( $registry );

		$this->assertTrue( $registry->is_registered( 'wpdatatables_row_create\\5' ) );
		$this->assertTrue( $registry->is_registered( 'wpdatatables_row_delete\\5' ) );

		$this->assertTrue( $registry->is_registered( 'wpdatatables_row_create\\7' ) );
		$this->assertTrue( $registry->is_registered( 'wpdatatables_row_delete\\7' ) );
	}

	/**
	 * Test hook events registration function.
	 *
	 * @since 1.0.0
	 *
	 * @covers ::wordpoints_wpdatatables_hook_events_init
	 */
	public function test_hook_events_init() {

		$this->mock_apps();

		$mock = new WordPoints_PHPUnit_Mock_Filter( array( 5, 7 ) );
		$mock->add_filter( 'wordpoints_wpdatatables_tables_for_auto_integration' );

		$registry = wordpoints_hooks()->get_sub_app( 'events' );

		wordpoints_wpdatatables_hook_events_init( $registry );

		$this->assertEventRegistered(
			'wpdatatables_row_create\\5'
			, array( 'wpdatatables_row\\5' )
		);

		$this->assertEventRegistered(
			'wpdatatables_row_create\\7'
			, array( 'wpdatatables_row\\7' )
		);
	}
}

// EOF
