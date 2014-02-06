<?php

/**
 * Description of Array
 *
 * @author imsamurai
 */
class ArraySort {

	/**
	 * Sort array by multiple fields
	 * 
	 * @param array $array Array to sort
	 * @param $params associative array key is field to sort by, value is desc or asc
	 * you can yse Set (Hash) notation for fields
	 */
	public static function multisort($array, $params) {
		$isNumeric = is_numeric(implode('', array_keys($array)));
		if (is_array($params)) {
			$callback = function($a, $b) use($params) {
				$result = 0;
				foreach ($params as $field => $direction) {
					$valA = Set::get($a, $field);
					$valB = Set::get($b, $field);
					if (is_array($valA)) {
						$valA = count($valA);
					}
					if (is_array($valB)) {
						$valB = count($valB);
					}
					if ($valA > $valB) {
						$result = 1;
					} elseif ($valA < $valB) {
						$result = -1;
					}
					if ($result !== 0) {
						if (strtolower($direction) === 'desc') {
							$result *= -1;
						}
						break;
					}
				}
				return $result;
			};
			if ($isNumeric) {
				usort($array, $callback);
			} else {
				uasort($array, $callback);
			}
		} elseif (is_string($params)) {
			if ($isNumeric) {
				(strtolower($params) === 'desc') ? rsort($array) : sort($array);
			} else {
				(strtolower($params) === 'desc') ? arsort($array) : asort($array);
			}
		}
		return $array;
	}

}
