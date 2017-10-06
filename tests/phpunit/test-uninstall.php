<?php

/**
 * Uninstall test case.
 *
 * @package WordPoints_WPDataTables\PHPUnit\Tests
 * @since 1.0.0
 */

/**
 * Tests uninstalling the extension.
 *
 * @since 1.0.0
 *
 * @coversNothing
 */
class WordPoints_WPDataTables_Uninstall_Test
	extends WordPoints_PHPUnit_TestCase_Extension_Uninstall {

	/**
	 * Test installation and uninstallation.
	 *
	 * @since 1.0.0
	 */
	public function test_uninstall() {

		$this->uninstall();

		$this->assertUninstalledPrefix( 'wordpoints_wpdatatables' );
	}
}

// EOF
