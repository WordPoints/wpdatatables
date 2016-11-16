<?php

/**
 * Test case for the entity classes.
 *
 * @package WordPoints_WPDataTables\PHPUnit\Tests
 * @since 1.0.0
 */

/**
 * Tests the entity classes.
 *
 * @since 1.0.0
 *
 * @covers WordPoints_WPDataTables_Entity_Row
 * @covers WordPoints_WPDataTables_Entity_Row_User
 * @covers WordPoints_WPDataTables_Entity_Row_Attr
 */
class WordPoints_WPDataTables_All_Entities_Test
	extends WordPoints_PHPUnit_TestCase_Entities {

	/**
	 * The data for the table used in this test.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	protected $table;

	/**
	 * Provides a list of entities.
	 *
	 * @since 1.0.0
	 *
	 * @return array The list of entities to test.
	 */
	public function data_provider_entities() {

		$factory = $this->factory = new WP_UnitTest_Factory();
		$factory->wordpoints = WordPoints_PHPUnit_Factory::$factory;

		$this->table = $this->factory->wordpoints->wpdatatables_table->create_and_get(
			array(
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

		$userid_column_id = $this->table['userid_column_id'];
		$entities         = array(
			'wpdatatables_row' => array(
				array(
					'class'          => 'WordPoints_WPDataTables_Entity_Row',
					'slug'           => "wpdatatables_row\\{$this->table['id']}",
					'id_field'       => 'wdt_ID',
					'human_id_field' => 'wdt_ID',
					'storage_info'   => array(
						'type' => 'db',
						'info' => array(
							'type'       => 'table',
							'table_name' => $this->table['mysql_table_name'],
						),
					),
					'create_func'    => array( $this, 'create_row' ),
					'delete_func'    => array( $this, 'delete_row' ),
					'children'       => array(
						'wpdatatables_row_attr\\' . $userid_column_id => array(
							'class' => 'WordPoints_WPDataTables_Entity_Row_User',
							'primary' => "wpdatatables_row\\{$this->table['id']}",
							'related' => 'user',
							'storage_info' => array(
								'type' => 'db',
								'info' => array(
									'type' => 'field',
									'field' => 'user',
								),
							),
						),
						'wpdatatables_row_attr\\' . ( $userid_column_id + 1 ) => array(
							'class' => 'WordPoints_WPDataTables_Entity_Row_Attr',
							'data_type' => 'integer',
							'storage_info' => array(
								'type' => 'db',
								'info' => array(
									'type' => 'field',
									'field' => 'integer',
								),
							),
						),
						'wpdatatables_row_attr\\' . ( $userid_column_id + 2 ) => array(
							'class' => 'WordPoints_WPDataTables_Entity_Row_Attr',
							'data_type' => 'text',
							'storage_info' => array(
								'type' => 'db',
								'info' => array(
									'type' => 'field',
									'field' => 'string',
								),
							),
						),
					),
				),
			),
		);

		return $entities;
	}

	/**
	 * Create a row in the table.
	 *
	 * @since 1.0.0
	 *
	 * @return object The row object.
	 */
	protected function create_row() {

		global $wpdb;

		$wpdb->query(
			"INSERT INTO `{$this->table['mysql_table_name']}` () VALUES ()"
		);

		$row = $wpdb->get_row(
			"
				SELECT * 
				FROM `{$this->table['mysql_table_name']}` 
				WHERE `wdt_ID` = {$wpdb->insert_id}
			"
		);

		$row->wdt_ID = (int) $row->wdt_ID;

		return $row;
	}

	/**
	 * Delete a row from the table.
	 *
	 * @since 1.0.0
	 *
	 * @param int $id The ID of the row to delete.
	 *
	 * @return bool Whether the row was deleted successfully.
	 */
	protected function delete_row( $id ) {

		global $wpdb;

		return (bool) $wpdb->delete(
			$this->table['mysql_table_name']
			, array( 'wdt_ID' => $id )
		);
	}
}

// EOF
