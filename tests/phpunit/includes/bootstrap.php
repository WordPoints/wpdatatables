<?php

/**
 * PHPUnit tests bootstrap.
 *
 * @package WordPoints_WPDataTables\PHPUnit
 * @since 1.0.0
 */

WordPoints_Dev_Lib_PHPUnit_Class_Autoloader::register_dir(
	dirname( __FILE__ ) . '/../classes'
	, 'WordPoints_WPDataTables_PHPUnit_'
);

$factory = WordPoints_PHPUnit_Factory::$factory;
$factory->register( 'wpdatatables_table', 'WordPoints_WPDataTables_PHPUnit_Factory_For_Table' );

// EOF
