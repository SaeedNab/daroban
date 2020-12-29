<?php
include "config.php";

class DatabaseQueries
{

    public function __construct()
    {

    }


    public function insertUser(string $nation_code, string $mobile, string $password): bool
    {
        $database = new DatabaseConnection();
        $conn = $database->connectDatabase();
        $hashed = password_hash($password,PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (nation_code, password, mobile)
  VALUES (:nation_code, :password, :mobile)");
        $stmt->bindParam(':nation_code', $nation_code);
        $stmt->bindParam(':password', $hashed);
        $stmt->bindParam(':mobile', $mobile);
        $result = $stmt->execute();
        return $result;
    }

    public function getUser(string $nation_code,string $password):string
    {
        $database = new DatabaseConnection();
        $conn = $database->connectDatabase();
        $hashed = password_hash($password,PASSWORD_DEFAULT);
        $stmt = $conn->prepare("select * from users where nation_code = :nation_code");
        $stmt->bindParam(':nation_code',$nation_code,PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result===false){
            $message = 'کاربری با این نام کاربری یافت نشد.';
            return "false";
        }
        else{

            $validPassword = password_verify($password,$result['password']);
            if ($validPassword){
                $id = $result['id'];
                $token = $database->generateToken();
                $isInserted = $this->insertToken($token,$id);
                return $token;
            }
            else{
                return "false";
            }

        }





    }

    public function insertToken(string $token,int $id):bool
    {
        $database = new DatabaseConnection();
        $conn = $database->connectDatabase();
        $stmt = $conn->prepare("update users set token = :token where id = :id");
        $stmt->bindParam(':token',$token,PDO::PARAM_STR);
        $stmt->bindParam(':id',$id,PDO::PARAM_STR);
        $result = $stmt->execute();
        return $result;
    }
    public function getToken(int $id):string
    {
        $database = new DatabaseConnection();
        $conn = $database->connectDatabase();
        $stmt = $conn->prepare("select token from users where id = :id");
        $stmt->bindParam(':id',$id,PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['token'];
    }


}