<?php

/**
 * Create row hook event class.
 *
 * @package WordPoints_WPDataTables
 * @since 1.0.0
 */

/**
 * An event that fires when a new row is added to a table.
 *
 * @since 1.0.0
 */
class WordPoints_WPDataTables_Hook_Event_Row_Create
	extends WordPoints_Hook_Event
	implements WordPoints_Hook_Event_ReversingI {

	/**
	 * @since 1.0.0
	 */
	public function get_title() {

		$table_title = $this->get_table_title();

		if ( $table_title ) {

			// translators: table name.
			return sprintf(
				__( 'Add Row to %s', 'wordpoints-wpdatatables' )
				, $table_title
			);

		} else {
			return __( 'Add Row to Table', 'wordpoints-wpdatatables' );
		}
	}

	/**
	 * @since 1.0.0
	 */
	public function get_description() {
		return __( 'Adding a row to a table.', 'wordpoints-wpdatatables' );
	}

	/**
	 * @since 1.0.0
	 */
	public function get_reversal_text() {
		return __( 'Row deleted.', 'wordpoints-wpdatatables' );
	}

	/**
	 * Get the title of the entity.
	 *
	 * This is useful to interpolate into your event title and description.
	 *
	 * @since 1.0.0
	 *
	 * @return string The title of the entity.
	 */
	protected function get_table_title() {

		$parts = wordpoints_parse_dynamic_slug( $this->slug );

		if ( ! $parts['dynamic'] ) {
			return false;
		}

		$table = wdt_get_table_by_id( (int) $parts['dynamic'] );

		if ( empty( $table['title'] ) ) {
			return false;
		}

		return $table['title'];
	}
}

// EOF
