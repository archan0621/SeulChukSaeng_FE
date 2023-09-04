<?php
    require $_SERVER['DOCUMENT_ROOT'].'/model/JwtApiCall.php';
    $_SERVER['REQUEST_URI'] == "/" ? require 'config/config.php' : require '../config/config.php';
    global $my_api;

    $eventId = $_GET['eventId'];
    $memberId = $_GET['memberId'];

    if (isset($eventId) && isset($memberId)) {
        $responseData = JwtApiCall($my_api."event/memberAttend", 
        "POST", 
        array(
            "eventId" => $eventId,
            "memberId" => $memberId
        ), 
        $_SESSION['token']);
        
        if ($responseData['result'] == 'fail') {
            echo "<script>alert('".$responseData['message']."');history.back();</script>";
        } elseif ($responseData['result'] == 'success') {
            echo "<script>alert('".$responseData['message']."');history.back();</script>";
        }
    }

?>