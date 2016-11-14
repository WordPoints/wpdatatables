<?php

/**
 * PHPUnit tests bootstrap functions.
 *
 * @package WordPoints_WPDataTables\PHPUnit
 * @since 1.0.0
 */

// We currently have to load the plugin here, see
// https://github.com/WordPoints/dev-lib/issues/161.
$loader = WordPoints_PHPUnit_Bootstrap_Loader::instance();
$loader->add_plugin( 'wpdatatables/wpdatatables.php' );

// EOF
