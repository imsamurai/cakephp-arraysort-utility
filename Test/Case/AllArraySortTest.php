<?php

/**
 * Description of Array
 *
 * @author imsamurai
 */

/**
 * AllArraySortTest
 * 
 * @package ArraySortTest
 * @subpackage Test
 */
class AllArraySortTest extends PHPUnit_Framework_TestSuite {

	/**
	 * Suite define the tests for this suite
	 *
	 * @return void
	 */
	public static function suite() {
		$suite = new CakeTestSuite('All ArraySort Tests');

		$path = App::pluginPath('ArraySort') . 'Test' . DS . 'Case' . DS;
		$suite->addTestDirectoryRecursive($path);
		return $suite;
	}

}
