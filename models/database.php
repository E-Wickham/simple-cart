<?php
namespace models;
class Database {
    private static $user = 'masterAdmin';
    private static $pass = 'bulbasaurAdmin';
    private static $dsn = 'mysql:host=bulbasaur-db.ckohzdqyvmzm.ca-central-1.rds.amazonaws.com;dbname=bulbasaur_db';
    private static $dbcon;

    private function __construct() {
    }

    //get pdo connection
    public static function getDb() {
        if(!isset(self::$dbcon)) {
            try {
                self::$dbcon = new \PDO(self::$dsn, self::$user, self::$pass);
                self::$dbcon->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                self::$dbcon->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
            } catch (\PDOException $e) {
                $msg = $e->getMessage();
                include '../error.php';
                exit();
            }
        }
    return self::$dbcon;
    }
}
