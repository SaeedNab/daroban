<?php
include "DatabaseQueries.php";
header("Content-type: application/json; charset=utf-8");

$connection = new DatabaseConnection();
$response = array();
    if (isset($_POST['nation_code']) && isset($_POST['password'])){
        if (empty($_POST['nation_code'])){
            $response = [
                'statusCode'=>400,
                'message'=>'کد ملی وارد نشده است'
            ];
            echo json_encode($response);
        }
        if (empty($_POST['password'])){
            $response = [
                'statusCode'=>400,
                'message'=>'پسورد وارد نشده است'
            ];
            echo json_encode($response);
        }
        else{
            $nation_code = $_POST['nation_code'];
            $password = $_POST['password'];
            if (strlen($nation_code)!=10){
                $response = [
                    'statusCode'=>400,
                    'message'=>'کد ملی نامعتبر است.'
                ];
                echo json_encode($response);
            }
            elseif (strlen($password)<8){
                $response = [
                    'statusCode'=>400,
                    'message'=>'پسورد باید بیشتر از هشت کاراکتر باشد.'
                ];
                echo json_encode($response);
            }
            else{
                $db = new DatabaseQueries();
                $result = $db->getUser($nation_code,$password);
                if ($result != 'false'){
                    $response = [
                        'statusCode'=>200,
                        'message'=>'عملیات ورود با موفقیت انجام شد',
                        'token'=> $result
                    ];
                    echo json_encode($response);

                }
                else{
                    $response = [
                        'statusCode'=>400,
                        'message'=>'نام کاربری یا کلمه عبور اشتباه است'
                    ];
                    echo json_encode($response);
                }




            }
        }
    }else{
        $response = [
            'statusCode'=>400,
            'message'=>'پارامتر ها به درستی ارسال نشده اند.'
            ];
        echo json_encode($response);
    }







?>