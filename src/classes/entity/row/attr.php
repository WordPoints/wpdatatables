<?php

/**
 * Table row entity attribute class.
 *
 * @package WordPoints_WPDataTables
 * @since 1.0.0
 */

/**
 * Represents a table row attribute.
 *
 * @since 1.0.0
 */
class WordPoints_WPDataTables_Entity_Row_Attr
	extends WordPoints_Entity_Attr_Field {

	/**
	 * @since 1.0.0
	 */
	protected $storage_type = 'db';

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

		// Set the field.
		$this->field = $this->column_data['orig_header'];

		// Set the data type.
		switch ( $this->column_data['column_type'] ) {

			case 'int':
				$this->data_type = 'integer';
			break;

			case 'string':
			default:
				$this->data_type = 'text';
		}
	}

	/**
	 * @since 1.0.0
	 */
	public function get_title() {
		return $this->column_data['display_header'];
	}
}

// EOF
