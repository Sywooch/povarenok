<?php

namespace app\functions;

class Functions
{
	function count_with_text($count,$texts = array(),$with_text = false) 
	{

		$razryad = $count;
		
		if ($count > 20) $razryad = $count % 10;
		$text = $texts[0];
		if ( $razryad == 1 ) $text = $texts[1]; 
		if (( $razryad > 1 ) and ($razryad <= 4)) $text = $texts[2]; 

		if ($with_text) $text = $count.' '.$text;
		return $text;
		
	}
		

	function translit($str) 
	{
	  $tr = Array (
		'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g',  'д' => 'd', 'е' => 'e',
		'ё' => 'yo', 'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k',
		'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r',
		'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
		'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch', 'ъ' => '', 'ы' => 'y', 'ь' => '',
		'э' => 'e', 'ю' => 'yu', 'я' => 'ya',

		'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G',  'Д' => 'D', 'Е' => 'E',
		'Ё' => 'YO', 'Ж' => 'ZH', 'З' => 'Z', 'И' => 'I', 'Й' => 'Y', 'К' => 'K',
		'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O', 'П' => 'P', 'Р' => 'R',
		'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
		'Ч' => 'CH', 'Ш' => 'SH', 'Щ' => 'SCH', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '',
		'Э' => 'E', 'Ю' => 'YU', 'Я' => 'YA'
	  );

	  return strtr($str, $tr);
	}

	function create_file_name($name) 
	{
		return preg_replace(Array('/[^a-z0-9\-_.\s]+/iu', '/\s/'), '_', $this->translit($name));
	}

	function translit_path($name) 
	{
		return preg_replace(Array('/[^a-z0-9\-_.\s]+/iu', '/\s/'), '-', mb_strtolower($this->translit($name)));
	}
	
	
}



