<?php

/**
 * A table factory for use in the unit tests.
 *
 * @package WordPoints_WPDataTables\PHPUnit
 * @since 1.0.0
 */

/**
 * Factory for tables.
 *
 * @since 1.0.0
 *
 * @method int create( $args = array(), $generation_definitions = null )
 * @method array create_and_get( $args = array(), $generation_definitions = null )
 * @method int[] create_many( $count, $args = array(), $generation_definitions = null )
 */
class WordPoints_WPDataTables_PHPUnit_Factory_For_Table
	extends WP_UnitTest_Factory_For_Thing {

	/**
	 * Construct the factory with a factory object.
	 *
	 * Sets up the default generation definitions.
	 *
	 * @since 1.0.0
	 */
	public function __construct( $factory = null ) {

		parent::__construct( $factory );

		$this->default_generation_definitions = array(
			'name' => new WP_UnitTest_Generator_Sequence( 'Table name %s' ),
		);
	}

	/**
	 * Create a table.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args {
	 *        Optional arguments to use.
	 *
	 *        @type string $name  The name of the table.
	 * }
	 *
	 * @return int The ID of the table.
	 */
	public function create_object( $args ) {

		global $wpdb;

		if ( ! class_exists( 'wpDataTableConstructor' ) ) {

			/**
			 * The table constructor.
			 *
			 * Normally only loaded in the admin.
			 *
			 * @since 1.0.0
			 */
			require_once WDT_ROOT_PATH . 'source/class.constructor.php';
		}

		if ( ! isset( $args['columns'] ) ) {
			$args['columns'] = array();
		}

		// Create a new Constructor object
		$constructor = new wpDataTableConstructor();

		$table_id = $constructor->generateManualTable( $args );

		if ( ! empty( $args['editable'] ) ) {

			$wpdb->update(
				$wpdb->prefix . 'wpdatatables'
				, array( 'editable' => 1 )
				, array( 'id' => $table_id )
			);
		}

		if ( ! empty( $args['user_id_column'] ) ) {

			$column_id = $wpdb->get_var(
				$wpdb->prepare(
					"
						SELECT `id`
						FROM `{$wpdb->prefix}wpdatatables_columns`
						WHERE `table_id` = %d
							AND `orig_header` = %s
					"
					, $table_id
					, $args['user_id_column']
				)
			);

			$wpdb->update(
				$wpdb->prefix . 'wpdatatables'
				, array( 'userid_column_id' => $column_id )
				, array( 'id' => $table_id )
			);
		}

		return $table_id;
	}

	/**
	 * Update a table.
	 *
	 * @since 1.0.0
	 *
	 * @param int   $id     The ID of the table.
	 * @param array $fields The fields to update.
	 *
	 * @return bool Whether the table was updated successfully.
	 */
	public function update_object( $id, $fields ) {

		global $wpdb;

		return (bool) $wpdb->update(
			$wpdb->prefix . 'wpdatatables'
			, $fields
			, array( 'id' => $id )
		);
	}

	/**
	 * Get a table by ID.
	 *
	 * @since 1.0.0
	 *
	 * @param int $id The table ID.
	 *
	 * @return array The table data.
	 */
	public function get_object_by_id( $id ) {

		return wdt_get_table_by_id( $id );
	}
}

// EOF
