<?php

namespace Core\Lib;

use Exception;

class Database {

    private static $dbhost;
    private static $dbuser;
    private static $dbpass;
    private static $dbname;
    private static $dbdriver;

    private static $conn;
    
    function __construct()
    {
        self::initialCheck();   
        self::connect();
    }


    //check for credentials
    protected static function initialCheck()
    {
        $host   = env('DB_HOST');
        $user   = env('DB_USERNAME');
        $pass   = env('DB_PASSWORD');
        $driver = env('DB_DRIVER');
        $name   = env('DB_NAME');

        if(!$host
        || !$user
        || !$driver
        || !$name) {
            throw new Exception("Credentails not found for database. Please check your .env file.", 1);
        }else{
            self::$dbhost   = $host;
            self::$dbuser   = $user;
            self::$dbpass   = $pass;
            self::$dbname   = $name;
            self::$dbdriver = $driver;
        }

        if(!in_array(self::$dbdriver, \PDO::getAvailableDrivers())) {
            throw new Exception(self::$dbdriver." driver is not enabled.", 1);
        }        
    }

    //make a connection to the database
    private static function connect()
    {
        try {
            self::$conn = new \PDO(self::$dbdriver.":host=".self::$dbhost.";dbname=".self::$dbname, self::$dbuser, self::$dbpass);
            // set the PDO error mode to exception
            self::$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return  self::$conn;
          } catch(\PDOException $e) {
            throw new Exception("Connection failed >> ".$e->getMessage(), 1);
          }
    }

    //create db
    public function newDatabase($dbname)
    {
        $dbname = sanitize($dbname);

        try {
            $sql = "CREATE DATABASE ". $dbname;
            self::$conn->exec($sql);
            return true;
          } catch(\PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
          }
    }

    //create table
    public function newTable($table, array $columns)
    {
        $table = sanitize($table);

        try {
            $sql = "CREATE TABLE ". $table ."(";
            
            if(is_array($columns)){
                $count = 0;
                foreach($columns as $column){
                    switch($column['type']) {
                        case 'int' : 
                            $sql .= $column['name'].' INT UNSIGNED';
                            if(isset($column['auto_increment']) && $column['auto_increment']) {
                                $sql .= ' AUTO_INCREMENT PRIMARY KEY';
                            }
                            break;
                        case 'string': 
                            $sql .= $column['name']. ' VARCHAR';
                            if(isset($column['length']) && $column['length']) {
                                $sql .= '('.$column['length'].')';
                            }else{
                                $sql .= '(255)';
                            }
                            break;
                        case 'timestamp':
                            $sql .= $column['name']. ' TIMESTAMP DEFAULT CURRENT_TIMESTAMP';
                            
                            if(isset($column['update']) && $column['update']) {
                                $sql .= ' ON UPDATE CURRENT_TIMESTAMP';
                            }
                            break;
                        default: 
                            $sql .= $column['name']. ' '. strtoupper($column['type']);
                            if(isset($column['length']) && $column['length']) {
                                $sql .= '('.$column['length'].')';
                            }
                    }

                    if(isset($column['null']) && $column['null']) {
                        $sql .= ' NULL';
                    }else{
                        $sql .= ' NOT NULL';
                    }
                    
                    if(isset($column['default']) && $column['default']) {
                        $sql .= $column['type'] === 'int ' ? ' DEFAULT('.$column['default'].')' : ' DEFAULT(\''.$column['default'].'\')';
                    }

                    $count++;

                    if($count < count($columns)) {
                        $sql .= ', ';
                    }
                }

                $sql .= ' )';
            }else{
                throw new Exception("Columns are not valid. Please check.", 1);
            }

            self::$conn->exec($sql);
            return true;
          } catch(\PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
          }
    }
}