<?php

/**
 * Author: imsamurai <im.samuray@gmail.com>
 * Date: 18.06.2012
 * Time: 14:59:04
 * Format: http://book.cakephp.org/2.0/en/development/testing.html
 */
App::uses('ArraySort', 'ArraySort.Utility');

/**
 * ArraySortTest
 * 
 * @package ArraySortTest
 * @subpackage Utility
 */
class ArraySortTest extends CakeTestCase {

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
			),
			// set #4
			array(
				array(
					'item1' => $Obj1 = new ArraySortTestObject(4, 2),
					'item2' => $Obj2 = new ArraySortTestObject(6, 3),
					'item3' => $Obj3 = new ArraySortTestObject(1, 1),
					'item4' => $Obj4 = new ArraySortTestObject(2, 5)
				),
				array(
					'item4' => $Obj4,
					'item2' => $Obj2,
					'item1' => $Obj1,
					'item3' => $Obj3
				),
				array(
					'count' => 'desc'
				)
			),
			// set #4
			array(
				array(
					'item1' => $Obj1 = new ArraySortTestObject(4, 2),
					'item2' => $Obj2 = new ArraySortTestObject(6, 3),
					'item3' => $Obj3 = new ArraySortTestObject(1, 1),
					'item4' => $Obj4 = new ArraySortTestObject(2, 5)
				),
				array(
					'item4' => $Obj4,
					'item2' => $Obj2,
					'item1' => $Obj1,
					'item3' => $Obj3
				),
				array(
					array(
						'field' => array('ArraySortTestObject2', 'count'),
						'direction' => 'asc'
					)
				)
			),
			// set #5
			array(
				array(
					'item1' => $Obj1 = new ArraySortTestObject(4, 2),
					'item2' => $Obj2 = new ArraySortTestObject(6, 3),
					'item3' => $Obj3 = new ArraySortTestObject(1, 1),
					'item4' => $Obj4 = new ArraySortTestObject(2, 5)
				),
				array(
					'item4' => $Obj4,
					'item2' => $Obj2,
					'item1' => $Obj1,
					'item3' => $Obj3
				),
				array(
					array(
						'field' => array('ArraySortTestObject2', 'count'),
						'order' => 'asc'
					)
				)
			),
			// set #5
			array(
				array(
					'item1' => array(
						'field' => 2
					),
					'item2' => array(
						'field' => 20
					),
				),
				array(
					'item2' => array(
						'field' => 20
					),
					'item1' => array(
						'field' => 2
					)
				),
				array(
					'field' => array(
						'order' => 'desc'
					)
				)
			),
		);
	}

	/**
	 * Test caching search fields
	 * 
	 * @param array $data
	 * @param array $params
	 * 
	 * @dataProvider cacheProvider
	 */
	public function testCache(array $data, array $params) {
		$Data = array_map(function($elem) {
			$Elem = new ArraySortTestCachedObject($elem['weight'], $elem['count']);
			return $Elem;
		}, $data);
		ArraySort::multisort($Data, $params);
	}

	/**
	 * Data provider for 
	 * 
	 * @return array
	 */
	public function cacheProvider() {
		return array(
			//set #0
			array(
				//data
				array(
					array(
						'weight' => 0,
						'count' => 1
					),
					array(
						'weight' => 10,
						'count' => 0
					),
					array(
						'weight' => 10,
						'count' => 0
					),
					array(
						'weight' => 4,
						'count' => 8
					),
					array(
						'weight' => 9,
						'count' => 6
					),
					array(
						'weight' => 44,
						'count' => 8
					),
				),
				//sort
				array(
					'weight' => 'desc',
					'count' => 'asc'
				)
			)
		);
	}

}

//@codingStandardsIgnoreStart
/**
 * ArraySortTestObject
 * 
 * @package ArraySortTest
 * @subpackage Utility
 */
class ArraySortTestObject {

	/**
	 * Constructor
	 * 
	 * @param int $weight
	 * @param int $count
	 */
	public function __construct($weight, $count) {
		$this->_weight = $weight;
		$this->_count = $count;
	}

	/**
	 * Count
	 * 
	 * @return int
	 */
	public function count() {
		return $this->_count;
	}

	/**
	 * Weight
	 * 
	 * @return int
	 */
	public function weight() {
		return $this->_weight;
	}

}

/**
 * ArraySortTestCachedObject
 * 
 * @package ArraySortTest
 * @subpackage Utility
 */
class ArraySortTestCachedObject extends ArraySortTestObject {

	/**
	 * Run counts
	 *
	 * @var array
	 */
	protected $_run = array(
		'count' => false,
		'weight' => false
	);

	/**
	 * {@inheritdoc}
	 * 
	 * @return int
	 * @throws Exception
	 */
	public function count() {
		if ($this->_run['count']) {
			throw new Exception('Method count must be callad only once');
		}
		$this->_run['count'] = true;
		return parent::count();
	}

	/**
	 * {@inheritdoc}
	 * 
	 * @return int
	 * @throws Exception
	 */
	public function weight() {
		if ($this->_run['weight']) {
			throw new Exception('Method weight must be callad only once');
		}
		$this->_run['weight'] = true;
		return parent::weight();
	}

}

/**
 * ArraySortTestObject2
 * 
 * @package ArraySortTest
 * @subpackage Utility
 */
class ArraySortTestObject2 {

	/**
	 * Count
	 * 
	 * @param ArraySortTestObject $Object
	 * @return int
	 */
	public static function count(ArraySortTestObject $Object) {
		return -1 * $Object->count();
	}

}

//@codingStandardsIgnoreEnd