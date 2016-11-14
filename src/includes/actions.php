<?php

/**
 * Hooks up the module's actions and filters.
 *
 * @package WordPoints_WPDataTables
 * @since   1.0.0
 */

add_action( 'wordpoints_init_app_registry-apps-entities', 'wordpoints_wpdatatables_entities_init' );

add_action( 'wordpoints_init_app_registry-hooks-actions', 'wordpoints_wpdatatables_hook_actions_init' );
add_action( 'wordpoints_init_app_registry-hooks-events', 'wordpoints_wpdatatables_hook_events_init' );

// EOF
