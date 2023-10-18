<?php
    require $_SERVER['DOCUMENT_ROOT'].'/model/JwtApiCall.php';
    include '../loading/loading.php';

    $_SERVER['REQUEST_URI'] == "/" ? require 'config/config.php' : require '../config/config.php';
    global $my_api;

    $eventId = $_POST['eventId'];

    if (isset($eventId)) {
        $responseData = JwtApiCall($my_api."event/memberPurchaseReq", 
        "POST", 
        array(
            "eventId" => $eventId
        ), 
        $_SESSION['token']);
        
        if ($responseData['result'] == 'fail') {
            echo $responseData['message'];
        } elseif ($responseData['result'] == 'success') {
            echo $responseData['message'];
        }
    }

?>