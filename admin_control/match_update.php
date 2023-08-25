<?php
    require $_SERVER['DOCUMENT_ROOT'].'/model/JwtApiCall.php';

    if ($_POST['cmd'] == 'apply' && $_POST['newTitle'] && $_POST['eventId']) {
        $responseData = JwtApiCall("https://sellstory.kro.kr:30621/event/update", 
        "POST", 
        array(
            "eventId"=> $_POST['eventId'],
            "title" => $_POST['newTitle'],
            "location" => '경기위치 테스트',
            "gender" => 'MALE',
            "money" => 8000,
            "startTime" => '2022-08-02T10:00:00',
            "endTime"=> '2022-08-03T12:00:00',
            "description"=> '유의사항 테스트'
        ), 
        $_SESSION['token']);
    
        if ($responseData['result'] == 'fail') {
            echo $responseData['message'];
        } elseif ($responseData['result'] == 'success') {
            echo $responseData['message'];
        }
    }
?>