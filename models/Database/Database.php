<?php
class Database
{   
    private static $database;
    public static function connect($web)
    {
        if (self::$database == null) {
            $DATABASE_HOST = 'localhost';
            $DATABASE_USER = 'root';
            $DATABASE_PASS = '';
            $DATABASE_NAME = 'moonvie';
            $db = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
            if (mysqli_connect_errno()) {
                if ($web) {
                    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
                } else {
                    $resp = array("title" => "connect to database", "status" => false);
                    exit(json_encode($resp));
                }
            }
            self::$database=$db;
            return self::$database;
        }
        else{
            return self::$database;
        }
    }

}
