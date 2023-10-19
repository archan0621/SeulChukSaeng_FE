<?php
    require $_SERVER['DOCUMENT_ROOT'].'/model/JwtApiCall.php';
    include '../loading/loading.php';
    $_SERVER['REQUEST_URI'] == "/" ? require 'config/config.php' : require '../config/config.php';
    global $my_api;

    $eventId = $_GET['eventId'];

    if (isset($eventId)) {
        loading_page(true);
        $responseData = JwtApiCall($my_api."event/remove", 
        "POST", 
        array(
            "eventId" => $eventId
        ), 
        $_SESSION['token']);
        
        if ($responseData['result'] == 'fail') {
            loading_page(false);
            echo "<script>alert('".$responseData['message']."');location.href='../admin_view/match';</script>";
        } elseif ($responseData['result'] == 'success') {
            loading_page(false);
            echo "<script>alert('".$responseData['message']."');location.href='../admin_view/match';</script>";
        }
    }

?>