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
			static::_normalizeParams($params);
			$callback = function($a, $b) use($params) {
				$result = 0;
				foreach ($params as $param) {
					$valA = static::_getValue($param['field'], $a);
					$valB = static::_getValue($param['field'], $b);
					if ($valA > $valB) {
						$result = 1;
					} elseif ($valA < $valB) {
						$result = -1;
					}
					if ($result !== 0) {
						if (strtolower($param['direction']) === 'desc') {
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

	/**
	 * Extract value from subject by path/attribute/method/callable
	 * 
	 * @param string|callable $from
	 * @param mixed $subject
	 * @return mixed
	 * @throws InvalidArgumentException
	 */
	protected static function _getValue($from, $subject) {
		$value = null;
		switch (true) {
			case is_array($subject):
				$value = Set::get($subject, $from);
				break;
			case is_object($subject):
				if (isset($subject->$from)) {
					$value = $subject->$from;
				} elseif (method_exists($subject, $from)) {
					$value = $subject->{$from}();
				} else {
					throw new InvalidArgumentException('Method or attribute does not exists: ' . $from);
				}
				break;
			case is_numeric($subject) || is_string($subject):
				$value = $subject;
				break;
			case is_callable($from):
				$value = call_user_func($from, $subject);
				break;
			default:
				throw new InvalidArgumentException('Wrong type: ' . gettype($subject));
		}

		if (is_array($value)) {
			$value = count($value);
		}

		return $value;
	}

	/**
	 * Normalize params
	 * 
	 * @param array $params
	 * @return array
	 */
	protected static function _normalizeParams(array &$params) {
		array_walk($params, function(&$value, $key) {
			if (!is_array($value)) {
				$value = array(
					'field' => $key,
					'direction' => $value
				);
			}
		});
	}

}
