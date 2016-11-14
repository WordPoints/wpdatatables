<?php

/**
 * Table row user entity relationship class.
 *
 * @package WordPoints_WPDataTables
 * @since 1.0.0
 */

/**
 * Represents the relationship between a table row and a user.
 *
 * @since 1.0.0
 */
class WordPoints_WPDataTables_Entity_Row_User
	extends WordPoints_Entity_Relationship_Stored_Field {

	/**
	 * @since 1.0.0
	 */
	protected $storage_type = 'db';

	/**
	 * @since 1.0.0
	 */
	protected $related_entity_slug = 'user';

	/**
	 * The data for the column this attribute represents.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	protected $column_data;

	/**
	 * @since 1.0.0
	 */
	public function __construct( $slug ) {

		parent::__construct( $slug );

		$parts = wordpoints_parse_dynamic_slug( $slug );

		$this->column_data = wdt_get_column_data( (int) $parts['dynamic'] );

		$this->related_ids_field = $this->column_data['orig_header'];

		$this->primary_entity_slug = "wpdatatables_row\\{$this->column_data['table_id']}";
	}

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return $this->column_data['display_header'];
	}
}

// EOF
