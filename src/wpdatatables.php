<?php

/**
 * Main file of the extension.
 *
 * ---------------------------------------------------------------------------------|
 * Copyright 2016-17  J.D. Grimes  (email : jdg@codesymphony.co)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2 or later, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 * ---------------------------------------------------------------------------------|
 *
 * @package WordPoints_WPDataTables
 * @version 1.1.1
 * @author  J.D. Grimes <jdg@codesymphony.co>
 * @license GPLv2+
 */

wordpoints_register_extension(
	'
		Extension Name: wpDataTables
		Author:         WordPoints
		Author URI:     https://wordpoints.org/
		Extension URI:  https://wordpoints.org/extensions/wpdatatables/
		Version:        1.1.1
		License:        GPLv2+
		Description:    Integrates with the wpDataTables plugin
		Text Domain:    wordpoints-wpdatatables
		Domain Path:    /languages
		Server:         wordpoints.org
		ID:             919
		Namespace:      WPDataTables
	'
	, __FILE__
);

WordPoints_Class_Autoloader::register_dir( dirname( __FILE__ ) . '/classes/' );

/**
 * The apps related functions for this extension.
 *
 * @since 1.0.0
 */
require_once dirname( __FILE__ ) . '/includes/apps.php';

/**
 * Hooks up the actions and filters for this extension.
 *
 * @since 1.0.0
 */
require_once dirname( __FILE__ ) . '/includes/actions.php';

// EOF
