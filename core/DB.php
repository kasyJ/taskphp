<?php
/**
 * Created by PhpStorm.
 * User: Oleg
 * Date: 10.07.20
 * Time: 17:50
 */

namespace core;

/**
 * Database settings
 */
class DB {
	static public $host = 'localhost';
	static public $user = 'root';
	static public $pass = '';
	static public $dbname = 'taskphp';

	/** @return \PDO */
	static public function connect(): \PDO {
		$host       = self::$host;
		$user       = self::$user;
		$pass       = self::$pass;
		$dbname     = self::$dbname;
		$connection = "mysql:host={$host};dbname={$dbname};";
		$options    = [
			\PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
			\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
			\PDO::ATTR_EMULATE_PREPARES   => false,
		];

		return new \PDO( $connection, $user, $pass, $options );
	}
}
