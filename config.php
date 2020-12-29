<?php

class DatabaseConnection
{
    public static $HOSTNAME = "localhost";
    public static $USERNAME = "root";
    public static $PASSWORD = "";
    public static $DATABASE = "daroban";

    public function connectDatabase()
    {
        try {
            $conn = new PDO("mysql:host=" . self::$HOSTNAME . ";dbname=" . self::$DATABASE, self::$USERNAME, self::$PASSWORD);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $conn;

        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();

        }
        return false;
    }
    public function __construct()
    {



    }

    public function generateToken():string
    {
        $chars = 'qwertyuiopasdfghjklzxcvbnm123456789';
        $str = '';
        for($i = 0;$i<30;$i++){
            $rand = rand(0,34);
            $str[$i] = $chars[$rand];

        }
        return $str;
    }
}
