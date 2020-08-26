<?php


namespace core;


// не один контроллер не может быть создан без этих методов и свойств
abstract class Controller {

	public $model;
	public $view;

	//каждый контроллер готов будет подгружать виды
	public function __construct() {
		$this->view = new View();
	}

	abstract public function action_index($params = []);

}
