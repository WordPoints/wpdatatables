<?php

/**
 * Table row entity class.
 *
 * @package WordPoints_WPDataTables
 * @since 1.0.0
 */

/**
 * Represents a table row.
 *
 * @since 1.0.0
 */
class WordPoints_WPDataTables_Entity_Row
	extends WordPoints_Entity
	implements WordPoints_Entityish_StoredI {

	/**
	 * The ID of the table this row type is for.
	 *
	 * @since 1.0.0
	 *
	 * @var int
	 */
	protected $table_id;

	/**
	 * @since 1.0.0
	 */
	public function __construct( $slug ) {

		parent::__construct( $slug );

		$this->table_id = (int) substr( $this->slug, 17 /* wpdatatables_row\ */ );
	}

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		// TODO
		return __( 'Row', 'wordpoints-wpdatatables' );
	}

	/**
	 * @since 1.0.0
	 */
	protected function get_entity( $id ) {

		global $wpdb;

		return $wpdb->get_row( // WPCS: unprepared SQL OK.
			$wpdb->prepare( // WPCS: unprepared SQL OK.
				'
					SELECT *
					FROM ' . wordpoints_escape_mysql_identifier( $this->get_table_name() ) . '
					WHERE ' . wordpoints_escape_mysql_identifier( $this->get_id_field() ) . ' = %s
				'
				, $id
			)
		); // WPCS: cache OK.
	}

	/**
	 * @since 1.0.0
	 */
	public function get_id_field() {

		global $wpdb;

		return $wpdb->get_var(
			$wpdb->prepare(
				"
					SELECT `orig_header`
					FROM `{$wpdb->prefix}wpdatatables_columns`
					WHERE `table_id` = %d
				"
				, $this->table_id
			)
		); // WPCS: cache OK.
	}

	/**
	 * @since 1.0.0
	 */
	protected function get_entity_human_id( $entity ) {
		// TODO
		return $this->get_entity_id( $entity );
	}

	/**
	 * @since 1.0.0
	 */
	public function get_storage_info() {
		return array(
			'type' => 'db',
			'info' => array(
				'type'       => 'table',
				'table_name' => $this->get_table_name(),
			),
		);
	}

	/**
	 * @since 1.0.0
	 */
	public function get_the_id() {
		return (int) parent::get_the_id();
	}

	/**
	 * Get the name of the table in the database that this row type is for.
	 *
	 * @since 1.0.0
	 *
	 * @return string The name of the database table.
	 */
	protected function get_table_name() {

		$table_data = wdt_get_table_by_id( $this->table_id );

		return $table_data['mysql_table_name'];
	}
}

// EOF
