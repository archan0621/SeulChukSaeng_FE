<?php
    require $_SERVER['DOCUMENT_ROOT'].'/model/JwtApiCall.php';
    include '../loading/loading.php';
    $_SERVER['REQUEST_URI'] == "/" ? require 'config/config.php' : require '../config/config.php';
    global $my_api;

    $eventId = $_GET['eventId'];
    $memberId = $_GET['memberId'];

    if (isset($eventId) && isset($memberId)) {
        loading_page(true);
        $responseData = JwtApiCall($my_api."event/memberForceAttend", 
        "POST", 
        array(
            "eventId" => $eventId,
            "memberId" => $memberId
        ), 
        $_SESSION['token']);
        
        if ($responseData['result'] == 'fail') {
            loading_page(false);
            echo "<script>alert('".$responseData['message']."');history.back();</script>";
        } elseif ($responseData['result'] == 'success') {
            loading_page(false);
            echo "<script>alert('".$responseData['message']."');history.back();</script>";
        }
    }

?>