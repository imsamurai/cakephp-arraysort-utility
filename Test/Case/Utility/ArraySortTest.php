<?php

/**
 * Author: imsamurai <im.samuray@gmail.com>
 * Date: 18.06.2012
 * Time: 14:59:04
 * Format: http://book.cakephp.org/2.0/en/development/testing.html
 */
App::uses('ArraySort', 'ArraySort.Utility');

class ArraySortTest extends CakeTestCase {

	public function setUp() {
		parent::setUp();
	}

	/**
	 * Test multisort
	 *
	 * @param string $testable
	 * @param mixed  $expected
	 * @dataProvider testMultisortProvider
	 */
	public function testMultisort($testable, $expected, $sort) {
		if (empty($testable)) {
			$testable = $expected;
			if (is_string(key($testable)[0])) {
				$ashuffle = function (&$array) {
					$keys = array_keys($array);
					shuffle($keys);
					$array = array_merge(array_flip($keys), $array);
					return true;
				};
				$ashuffle($testable);
			} else {
				shuffle($testable);
			}	
		}

		$this->assertNotSame($expected, $testable);
		$this->assertSame($expected, ArraySort::multisort($testable, $sort));
	}

	/**
	 * data provider for testMultisortProvider
	 *
	 * @return array
	 */
	public static function testMultisortProvider() {
		return array(
			// set #0
			array(
				array(
					array(
						'trend' => 'France',
						'count' => 181
					),
					array(
						'trend' => 'Brazil',
						'count' => 121
					),
					array(
						'trend' => 'India',
						'count' => 601
					)
				),
				array(
					array(
						'trend' => 'India',
						'count' => 601
					),
					array(
						'trend' => 'France',
						'count' => 181
					),
					array(
						'trend' => 'Brazil',
						'count' => 121
					)
				),
				array('count' => 'desc')
			),
			// set #1
			array(
				array(),
				array(
					'item1' => 1,
					'item2' => 2,
					'item3' => 3,
					'item4' => 4,
					'item5' => 5
				),
				array('sort' => 'asc')
			),
			// set #2
			array(
				array(),
				array(1, 2, 3, 4, 5, 6, 7, 8, 9),
				array('sort' => 'asc')
			),
			// set #3
			array(
				array(),
				array(
					'item1' => array(
						'weight' => 4,
						'diff' => array(
							1 => 10,
							7 => -5,
							30 => 0
						)
					),
					'item2' => array(
						'weight' => 3,
						'diff' => array(
							1 => 10,
							7 => -5,
							30 => 0
						)
					),
					'item3' => array(
						'weight' => 3,
						'diff' => array(
							1 => 8,
							7 => -5,
							30 => 0
						)
					),
					'item4' => array(
						'weight' => 3,
						'diff' => array(
							1 => 8,
							7 => -10,
							30 => 0
						)
					),
					'item5' => array(
						'weight' => 3,
						'diff' => array(
							1 => 8,
							7 => -10,
							30 => -1
						)
					),
					'item6' => array(
						'weight' => 2,
						'diff' => array(
							1 => 3,
							7 => 4,
							30 => 5
						)
					),
					'item7' => array(
						'weight' => 1,
						'diff' => array(
							1 => 30,
							7 => 40,
							30 => 50
						)
					),
					'item8' => array(
						'weight' => 1,
						'diff' => array(
							1 => false,
							7 => false,
							30 => false
						)
					)
				),
				array(
					'weight' => 'desc',
					'diff.1' => 'desc',
					'diff.7' => 'desc',
					'diff.30' => 'desc'
				)
			)
		);
	}
}