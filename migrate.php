<?php


require_once __DIR__ . '/core/DB.php';


use core\DB;

$pdo = DB::connect();

function getMigrationFiles($pdo) {


	//папка с миграциями
	$dir = __DIR__ . '/migrations/';
	//массив из всех файлов .sql
	$allFiles = glob($dir . '*.sql');


	//объект пдо который получил данные
	$query = $pdo->query("SHOW TABLES LIKE 'versions'");

	//извлекаем данные из объекта в виде массива результатов
	$data = $query->fetchAll();

	//если ничего нет, база пустая
	if(!count($data)) {
		//возвращаем файлы для миграции
		return $allFiles;
	}

	//иначе создаю массив в кот сохраню названия файлов, которые были применены + директорию
	$versionsFiles = array();
	//выбрать поля name из каждой строки таблицы versions
	$data = $pdo->query('SELECT `name` FROM `versions`');
	foreach ($data as $row) {
		array_push($versionsFiles, $dir.$row['name']);
	}

 	//возвращается расхождения массивов, те названия файлов которых не было в allFiles
	return array_diff($allFiles, $versionsFiles);

}


function migrate($pdo, $file) {

	//написанные нами запросы (migrations 000 001 002)
	//вытаскивается все содержимое из файла (текст)
	$command = file_get_contents($file);
	//выполянется запрос
	$pdo->exec($command);

	//берем полное имя файла директория-файл-рассширение
	$baseName = basename($file);
	//подготавливает запрос   (:basename) - маркер, вот тут будет переменная
	$query = $pdo->prepare('INSERT INTO `versions` (`name`) VALUES(:basename)');
	//берет название маркера и закрепляет за ним переменную, в типе PDO::константа

	//прикрепляет запрос   PDO:: обращаемся к статическим методам этого класса
	$query->bindParam(':basename', $baseName, PDO::PARAM_STR);
	//отправить запрос
	$query->execute();
}



	//выбираем список файлов
	$files = getMigrationFiles($pdo);

	//если нечего мигрировать, база в актуальном сост
	if(empty($files)) {
				//база актуальна
		echo 'The base is up to date'.PHP_EOL;
	}else {
		//иначе прогоняем файл через функцию migrate()
		foreach ($files as $file) {
			migrate($pdo, $file);
		}		//миграции успешно применены
		echo 'Migrations applied successfully'.PHP_EOL;
	}
