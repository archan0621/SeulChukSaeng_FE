<?php
    require $_SERVER['DOCUMENT_ROOT'].'/model/JwtApiCall.php';
    $_SERVER['REQUEST_URI'] == "/" ? require 'config/config.php' : require '../config/config.php';
    global $my_api;

    $eventId = $_POST['eventId'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    if (isset($eventId) && isset($latitude) && isset($longitude)) {
        $responseData = JwtApiCall($my_api."event/memberAttend", 
        "POST", 
        array(
            "eventId" => $eventId,
            "lat" => $latitude,
            "lng" => $longitude,
        ), 
        $_SESSION['token']);
        
        if ($responseData['result'] == 'fail') {
            echo $responseData['message'];
        } elseif ($responseData['result'] == 'success') {
            echo $responseData['message'];
        }
    }

?>