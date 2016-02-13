<?php
/**
 * Created by PhpStorm.
 * User: Игорёк
 * Date: 13.02.2016
 * Time: 16:01
 */
namespace  common\helpers;

class ArrayHelper extends \yii\helpers\ArrayHelper
{
    public static $delimiter = '.';

    public static function setValue(& $array, $path, $value, $delimiter = NULL)
    {
        if (!$delimiter) {
            $delimiter = ArrayHelper::$delimiter;
        }
        // Split the keys by delimiter
        $keys = explode($delimiter, $path);
        // Set current $array to inner-most array path
        while (count($keys) > 1) {
            $key = array_shift($keys);
            if (ctype_digit($key)) {
                // Make the key an integer
                $key = (int)$key;
            }
            if (!isset($array[$key])) {
                $array[$key] = array();
            }
            $array = &$array[$key];
        }
        // Set key on inner-most array
        $array[array_shift($keys)] = $value;
    }
}