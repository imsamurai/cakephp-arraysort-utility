<?php
/**
 * Description of Array
 *
 * @author imsamurai
 */
class ArraySort {

    /**
     * @param $params associative array key is field to sort by, value is desc or asc
     * you can yse Set (Hash) notation for fields
     */
    public static function multisort($array, $params) {
        $is_numeric = is_numeric(implode('', array_keys($array)));
        if (is_array($params)) {
            $callback = function($a, $b) use($params) {
                        $result = 0;
                        foreach ($params as $field => $direction) {
                            $val_a = Set::get($a, $field);
                            $val_b = Set::get($b, $field);
                            if (is_array($val_a)) {
                                $val_a = count($val_a);
                            }
                            if (is_array($val_b)) {
                                $val_b = count($val_b);
                            }
                            if ($val_a > $val_b) {
                                $result = 1;
                            } else if ($val_a < $val_b) {
                                $result = -1;
                            }
                            if ($result !== 0) {
                                if (strtolower($direction) === 'desc')
                                    $result*=-1;
                                break;
                            }
                        }
                        return $result;
                    };
            if ($is_numeric)
                usort($array, $callback);
            else
                uasort($array, $callback);

        } else if (is_string($params)) {
            if ($is_numeric) {
                (strtolower($params) === 'desc') ? rsort($array) : sort($array);
            } else {
                (strtolower($params) === 'desc') ? arsort($array) : asort($array);
            }
        }
        return $array;
    }

}