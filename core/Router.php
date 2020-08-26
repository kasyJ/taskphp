<?php

//в одном пространстве имен можем подключать
namespace core;

class Router {

	static public function start() {

		$controller_name = 'task';
		$action_name = 'index';

		//url до гет запроса
		$URIParts = explode('?', $_SERVER['REQUEST_URI']);
		$routes = explode('/', $URIParts[0]);

		//переданное имя контроллера
		if(!empty($routes[1])) {
			$controller_name = $routes[1];
			//переданный медот контроллера
			if(!empty($routes[2])) {
				$action_name = $routes[2];
			}
		}

		//добавляем префикс из namespace \controllers
		$controller_name = '\controllers\Controller_' .ucfirst($controller_name);
		$action_name = 'action_'.$action_name;

		//создаем объект этого класса
		$controller = new $controller_name;
		$action = $action_name;

		//если в классе есть метод, вызываем его
		if (method_exists($controller, $action)) {
			parse_str($URIParts[1]??'', $params);
			$controller->$action($params);
		} else {
			self::ErrorPage404();
		}


	}

	//страница 404
		static public function ErrorPage404() {
			//получаем наш виртуальный хост (домен)
			$host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
			//передаем статус ответа 404 и перенаправляем пользователя на страницу 404
			// header('HTTP/1.1 404 Not Found');
			// header("Status: 404 Not Found");
			// header('Location:' . $host . '404');
		}

}
