<?php

/**
 * Test case for the Frontend Create Row hook event.
 *
 * @package WordPoints_WPDataTables\PHPUnit\Tests
 * @since 1.0.0
 */

/**
 * Tests the Frontend Create Row hook action.
 *
 * @since 1.0.0
 *
 * @covers WordPoints_WPDataTables_Hook_Action_Row_Frontend_Create
 */
class WordPoints_WPDataTables_Hook_Action_Row_Frontend_Create_Test
	extends WordPoints_PHPUnit_TestCase {

	/**
	 * Test that it should fire when the POST data is correct.
	 *
	 * @since 1.0.0
	 */
	public function test_should_fire() {

		$_POST['formdata'] = array(
			'table_id' => $this->factory->wordpoints->wpdatatables_table->create(),
			'wdt_ID'   => '0',
		);

		$action = new WordPoints_WPDataTables_Hook_Action_Row_Frontend_Create(
			'test'
			, array()
		);

		$this->assertTrue( $action->should_fire() );
	}

	/**
	 * Test that it shouldn't fire when it is an update to a row.
	 *
	 * @since 1.0.0
	 */
	public function test_should_fire_update() {

		$_POST['formdata'] = array(
			'table_id' => $this->factory->wordpoints->wpdatatables_table->create(),
			'wdt_ID'   => '5',
		);

		$action = new WordPoints_WPDataTables_Hook_Action_Row_Frontend_Create(
			'test'
			, array()
		);

		$this->assertFalse( $action->should_fire() );
	}

	/**
	 * Test that it shouldn't fire when the table ID isn't set.
	 *
	 * @since 1.0.0
	 */
	public function test_should_fire_no_table() {

		$_POST['formdata'] = array(
			'wdt_ID' => '',
		);

		$action = new WordPoints_WPDataTables_Hook_Action_Row_Frontend_Create(
			'test'
			, array()
		);

		$this->assertFalse( $action->should_fire() );
	}
}

// EOF
