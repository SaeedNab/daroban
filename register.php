<?php
header("Content-type: application/json; charset=utf-8");

include 'DatabaseQueries.php';

$response = array();
if (isset($_POST['nation_code']) && isset($_POST['password']) && $_POST['mobile']){
    if (empty($_POST['nation_code'])){
        $response = [
            'statusCode'=>400,
            'message'=>'کد ملی وارد نشده است'
        ];
        echo json_encode($response);
    }
    elseif (empty($_POST['password'])){
        $response = [
            'statusCode'=>400,
            'message'=>'پسورد وارد نشده است'
        ];
        echo json_encode($response);
    }
    elseif (empty($_POST['mobile'])){
        $response = [
            'statusCode'=>400,
            'message'=>'شماره موبایل وارد نشده است'
        ];
        echo json_encode($response);
    }

    else{
        $nation_code = $_POST['nation_code'];
        $password = $_POST['password'];
        $mobile = $_POST['mobile'];
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
        elseif (strlen($_POST['mobile'])!=11){
            $response = [
                'statusCode'=>400,
                'message'=>'شماره موبایل باید یازده رقمی باشد'
            ];
            echo json_encode($response);
        }
        else{
            $db = new DatabaseQueries();
            $db->insertUser($nation_code,$mobile,$password);

            $response = [
                'statusCode'=>200,
                'message'=>'عملیات ثبت نام با موفقیت انجام شد'
            ];

            echo json_encode($response);




        }
    }
}







?>