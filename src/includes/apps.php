<?php

/**
 * Apps related functions.
 *
 * @package WordPoints_WPDataTables
 * @since   1.0.0
 */

/**
 * Get the list of tables to automatically integrate with.
 *
 * @since 1.0.0
 *
 * @return array The IDs of the tables to integrate with.
 */
function wordpoints_wpdatatables_get_tables_for_auto_integration() {

	global $wpdb;

	$ids = $wpdb->get_col(
		"
			SELECT `id`
			FROM `{$wpdb->prefix}wpdatatables`
			WHERE `editable` = 1
		"
	); // WPCS: cache OK.

	/**
	 * Filter the list of tables to automatically integrate with.
	 *
	 * @since 1.0.0
	 *
	 * @param array $ids The IDs of the tables to integrate with.
	 */
	return apply_filters(
		'wordpoints_wpdatatables_tables_for_auto_integration'
		, array_map( 'absint', $ids )
	);
}

/**
 * Register entities when the entities app is initialized.
 *
 * @since 1.0.0
 *
 * @WordPress\action wordpoints_init_app_registry-apps-entities
 *
 * @param WordPoints_App_Registry $entities The entities app.
 */
function wordpoints_wpdatatables_entities_init( $entities ) {

	$children = $entities->get_sub_app( 'children' );

	foreach ( wordpoints_wpdatatables_get_tables_for_auto_integration() as $table_id ) {

		$entities->register( "wpdatatables_row\\{$table_id}", 'WordPoints_WPDataTables_Entity_Row' );

		$table = wdt_get_table_by_id( $table_id );
		$columns = wdt_get_columns_by_table_id( $table_id );

		foreach ( $columns as $column ) {

			if ( $column->id_column ) {
				continue;
			}

			if ( $column->id === $table['userid_column_id'] ) {
				$class = 'WordPoints_WPDataTables_Entity_Row_User';
			} else {
				$class = 'WordPoints_WPDataTables_Entity_Row_Attr';
			}

			$children->register(
				"wpdatatables_row\\{$table_id}"
				, "wpdatatables_row_attr\\{$column->id}"
				, $class
			);
		}
	}
}

/**
 * Register hook actions when the action registry is initialized.
 *
 * @since 1.0.0
 *
 * @WordPress\action wordpoints_init_app_registry-hooks-actions
 *
 * @param WordPoints_Hook_Actions $actions The action registry.
 */
function wordpoints_wpdatatables_hook_actions_init( $actions ) {

	foreach ( wordpoints_wpdatatables_get_tables_for_auto_integration() as $table_id ) {

		$actions->register(
			"wpdatatables_row_create\\{$table_id}"
			, 'WordPoints_WPDataTables_Hook_Action_Row_Frontend_Create'
			, array(
				'action' => 'wpdatatables_after_frontent_edit_row',
				'data'   => array(
					'arg_index' => array( "wpdatatables_row\\{$table_id}" => 1 ),
				),
			)
		);

		$actions->register(
			"wpdatatables_row_delete\\{$table_id}"
			, 'WordPoints_Hook_Action'
			, array(
				'action' => 'wpdatatables_before_delete_row',
				'data'   => array(
					'arg_index' => array( "wpdatatables_row\\{$table_id}" => 0 ),
				),
			)
		);
	}
}

/**
 * Register hook events when the event registry is initialized.
 *
 * @since 1.0.0
 *
 * @WordPress\action wordpoints_init_app_registry-hooks-events
 *
 * @param WordPoints_Hook_Events $events The event registry.
 */
function wordpoints_wpdatatables_hook_events_init( $events ) {

	foreach ( wordpoints_wpdatatables_get_tables_for_auto_integration() as $table_id ) {

		$events->register(
			"wpdatatables_row_create\\{$table_id}"
			, 'WordPoints_WPDataTables_Hook_Event_Row_Create'
			, array(
				'actions' => array(
					'toggle_on'  => "wpdatatables_row_create\\{$table_id}",
					'toggle_off' => "wpdatatables_row_delete\\{$table_id}",
				),
				'args'    => array(
					"wpdatatables_row\\{$table_id}" => 'WordPoints_Hook_Arg',
				),
			)
		);
	}
}

// EOF
