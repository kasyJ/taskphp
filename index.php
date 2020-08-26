<?php

use \core\Router;

spl_autoload_register(function($class_name){

	//проверяем что бы пользователь не запросил не существующий класс
	$class = str_replace('\\', '/', $class_name) . '.php';

	//если есть такой файл
	if(file_exists($class)) {
		require_once($class);
	} else {
		Router::ErrorPage404();
	}

});

//запускаем сессию для авторизованных пользователей
session_start();
Router::start();