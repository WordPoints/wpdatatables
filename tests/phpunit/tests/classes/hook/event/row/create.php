<?php

/**
 * Test case for the Row Create hook event.
 *
 * @package WordPoints_WPDataTables\PHPUnit\Tests
 * @since 1.0.0
 */

/**
 * Tests the Row Create hook event.
 *
 * @since 1.0.0
 *
 * @covers WordPoints_WPDataTables_Hook_Event_Row_Create
 */
class WordPoints_WPDataTables_Hook_Event_Row_Create_Test
	extends WordPoints_PHPUnit_TestCase_Hook_Event {

	/**
	 * @since 1.0.0
	 */
	protected $event_class = 'WordPoints_WPDataTables_Hook_Event_Row_Create';

	/**
	 * @since 1.0.0
	 */
	protected $event_slug = 'wpdatatables_row_create';

	/**
	 * @since 1.0.0
	 */
	protected $expected_targets = array();

	/**
	 * An app that is used during the tests.
	 *
	 * @since 1.0.0
	 *
	 * @var WordPoints_App
	 */
	protected static $_backup_app;

	/**
	 * Data for a table used during the tests.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	protected static $table_data;

	/**
	 * @since 1.0.0
	 */
	public static function tearDownAfterClass() {

		parent::tearDownAfterClass();

		self::$_backup_app = null;
	}

	/**
	 * @since 1.0.0
	 */
	public function setUp() {

		self::$backup_app = WordPoints_App::$main;
		WordPoints_App::$main = self::$_backup_app;

		parent::setUp();

		$this->set_expected_targets();

		// Mark the table as editable again. (See data_provider_targets().)
		global $wpdb;

		$wpdb->update(
			$wpdb->prefix . 'wpdatatables'
			, array( 'editable' => 1 )
			, array( 'id' => self::$table_data['id'] )
		);
	}

	/**
	 * Set the expected targets for this event.
	 *
	 * @since 1.0.0
	 */
	protected function set_expected_targets() {

		$table_id          = self::$table_data['id'];
		$user_id_column_id = self::$table_data['userid_column_id'];

		$this->event_slug .= "\\{$table_id}";
		$this->expected_targets = array(
			array(
				"wpdatatables_row\\{$table_id}",
				"wpdatatables_row_attr\\{$user_id_column_id}",
				'user',
			),
		);
	}

	/**
	 * @since 1.0.0
	 */
	public function data_provider_targets() {

		$factory = $this->factory = new WP_UnitTest_Factory();
		$factory->wordpoints = WordPoints_PHPUnit_Factory::$factory;

		self::$table_data = $this->factory->wordpoints->wpdatatables_table->create_and_get(
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
				),
			)
		);

		$this->set_expected_targets();

		self::$backup_app = WordPoints_App::$main;
		WordPoints_App::$main = self::$_backup_app = new WordPoints_App( 'apps' );

		wordpoints_init_hooks();

		$targets = parent::data_provider_targets();

		WordPoints_App::$main = self::$backup_app;
		self::$backup_app = null;

		// Mark the table as not editable so that it doesn't affect the other tests.
		global $wpdb;

		$wpdb->update(
			$wpdb->prefix . 'wpdatatables'
			, array( 'editable' => 0 )
			, array( 'id' => self::$table_data['id'] )
		);

		return $targets;
	}

	/**
	 * @since 1.0.0
	 */
	protected function fire_event( $arg, $reactor_slug ) {

		$_POST['formdata'] = array(
			'table_id' => self::$table_data['id'],
			'wdt_ID' => '0',
		);

		$mock = new WordPoints_PHPUnit_Mock_Filter();
		$mock->add_action( 'wpdatatables_after_frontent_edit_row', 10, 2 );

		add_action(
			'wpdatatables_after_frontent_edit_row'
			, array( $this, 'throw_exception' )
			, 100
		);

		wp_set_current_user( $this->factory->user->create() );

		try {
			wdt_save_table_frontend();
		} catch ( WordPoints_WPDataTables_PHPUnit_Exception $e ) {
			unset( $e );
		}

		$row_id = $mock->calls[0][1];

		// Updating a row should not award points again.
		$_POST['formdata']['wdt_ID'] = $row_id;

		try {
			wdt_save_table_frontend();
		} catch ( WordPoints_WPDataTables_PHPUnit_Exception $e ) {
			unset( $e );
		}

		return $row_id;
	}

	/**
	 * @since 1.0.0
	 */
	protected function reverse_event( $arg_id, $index ) {

		add_action(
			'wpdatatables_before_delete_row'
			, array( $this, 'throw_exception' )
			, 100
		);

		$_POST = array(
			'table_id' => self::$table_data['id'],
			'id_key' => 'wdt_ID',
			'id_val' => $arg_id,
		);

		try {
			wdt_delete_table_row();
		} catch ( WordPoints_WPDataTables_PHPUnit_Exception $e ) {
			unset( $e );
		}
	}

	/**
	 * Throw an exception.
	 *
	 * @since 1.0.0
	 *
	 * @throws WordPoints_WPDataTables_PHPUnit_Exception An exception.
	 */
	public function throw_exception() {
		throw new WordPoints_WPDataTables_PHPUnit_Exception();
	}
}

// EOF
