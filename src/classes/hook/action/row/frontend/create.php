<?php

/**
 * Frontend create row hook action class.
 *
 * @package WordPoints_WPDataTables
 * @since 1.0.0
 */

/**
 * Represents the action that fires when a row is created on the frontend.
 *
 * @since 1.0.0
 */
class WordPoints_WPDataTables_Hook_Action_Row_Frontend_Create
	extends WordPoints_Hook_Action {

	/**
	 * @since 1.0.0
	 */
	public function should_fire() {

		global $wpdb;

		if ( ! isset( $_POST['formdata']['table_id'] ) ) { // WPCS: CSRF OK.
			return false;
		}

		$id_field = $wpdb->get_var(
			$wpdb->prepare(
				"
					SELECT `orig_header`
					FROM `{$wpdb->prefix}wpdatatables_columns`
					WHERE `table_id` = %d
						AND `id_column` = 1
				"
				, (int) $_POST['formdata']['table_id'] // WPCS: CSRF OK.
			)
		); // WPCS: cache OK.

		if ( ! empty( $_POST['formdata'][ $id_field ] ) ) { // WPCS: CSRF OK.
			return false;
		}

		return parent::should_fire();
	}
}

// EOF
