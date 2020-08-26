<?php

//что то вроде рабочей папки
namespace core;


class View {

	//$content_view - то что подключаем, страница которая должна отобразиться
	//$template_view - лайаут, то что не меняется
	public function generate($content_view, $template_view, $data = null) {


		if(is_array($data)) {
			//создает из массива переменные
			//['name' => 'Igor'] -> name = 'Igor'
			//для того что бы не всегда передавать массив data, а передавать любой ассоциативный массив (?=)?)
			extract($data, EXTR_OVERWRITE);

			//если такие переменные есть она их перезапишет
		}
		//подгружается лайаут(баграунд)
		include 'views/'.$template_view; 
	}

}
