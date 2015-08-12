<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace common\helpers;

/**
 * StringHelper
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @author Alex Makarov <sam@rmcreative.ru>
 * @since 2.0
 */
class StringHelper extends BaseStringHelper
{
    public static $translit_table = array(
		'а' => 'a', 	'А' => 'A',
		'б' => 'b', 	'Б' => 'B',
		'в' => 'v', 	'В' => 'V',
		'г' => 'g', 	'Г' => 'G',
		'д' => 'd', 	'Д' => 'D',
		'е' => 'e', 	'Е' => 'E',
		'ж' => 'zh',	'Ж' => 'Zh',
		'з' => 'z',		'З' => 'Z',
		'и' => 'i',		'И' => 'I',
		'й' => 'y',		'Й' => 'Y',
		'к' => 'k',		'К' => 'K',
		'л' => 'l',		'Л' => 'L',
		'м' => 'm',		'М' => 'M',
		'н' => 'n',		'Н' => 'N',
		'о' => 'o',		'О' => 'O',
		'п' => 'p',		'П' => 'P',
		'р' => 'r',		'Р' => 'R',
		'с' => 's',		'С' => 'S',
		'т' => 't',		'Т' => 'T',
		'у' => 'u',		'У' => 'U',
		'ф' => 'f',		'Ф' => 'F',
		'х' => 'h',		'Х' => 'H',
		'ц' => 'c',		'Ц' => 'C',
		'ч' => 'ch',	'Ч' => 'Ch',
		'ш' => 'sh',	'Ш' => 'Sh',
		'щ' => 'sch',	'Щ' => 'Sch',
		'ъ' => '',		'Ъ' => '',
		'ы' => 'y',		'Ы' => 'Y',
		'ь' => '',		'Ь' => '',
		'э' => 'e',		'Э' => 'E',
		'ю' => 'yu',	'Ю' => 'Yu',
		'я' => 'ya',	'Я' => 'Ya',
		'і' => 'i',		'І' => 'I',
		'ї' => 'yi',	'Ї' => 'Yi',
		'є' => 'e',		'Є' => 'E'
	);

	public static function translit($str)
	{
		$str = preg_replace('{[ |.]+}', '_', $str);
		$str = iconv('UTF-8', 'UTF-8//IGNORE', strtr($str, self::$translit_table));
		return preg_replace(array('/[^0-9a-zA-Z_\-]+/', '{[_]+}', '{[-]+}'), array('', '_', '-'), $str);
	}

	public static function clean($str)
	{
		return preg_replace(array('/[^(\w)|(\x7F-\xFF)|(\s)|(\-)]/', '{[_]+}', '{[ ]+}', '{[\-]+}'), array('', '_', ' ', '-'), $str);
	}

	public static function declension($forms, $count, $lang = NULL)
	{
		if (is_string($forms))
		{
			$forms = array_map('trim', explode(';', $forms));
		}
		switch (count($forms))
		{
			case 1:
					$forms[1] = $forms[0];
			case 2:
					$forms[2] = $forms[1];
		}

		switch ($lang === NULL ? I18n::$lang : $lang)
		{
			case 'en-us':
					return $forms[$count == 1 ? 0 : 1];

			case 'ru-ru':
					$mod100 = $count % 100;
					switch ($count % 10)
					{
						case 1:
								return $forms[$mod100 == 11 ? 2 : 0];
						case 2:
						case 3:
						case 4:
								return $forms[(($mod100 > 10) AND ($mod100 < 20)) ? 2 : 1];
						case 5:
						case 6:
						case 7:
						case 8:
						case 9:
						case 0:
								return $forms[2];
					}

			default:
					return $forms[0];
		}
	}
}