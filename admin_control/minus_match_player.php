<?php
    require $_SERVER['DOCUMENT_ROOT'].'/model/JwtApiCall.php';
    $_SERVER['REQUEST_URI'] == "/" ? require 'config/config.php' : require '../config/config.php';
    global $my_api;

    $eventId = $_GET['event_id'];
    $memberId = $_GET['memberId'];

    if (isset($eventId) && isset($memberId)) {
        if ($memberId) {
            $responseData = JwtApiCall($my_api."event/memberRemove", 
            "POST", 
            array(
                "eventId" => $eventId,
                "memberId" => $memberId
            ), 
            $_SESSION['token']);
        }
        
        if ($responseData['result'] == 'fail') {
            echo "<script>alert('".$responseData['message']."');</script>";
            header("Location: ../admin_view/match");
        } elseif ($responseData['result'] == 'success') {
            echo "<script>alert('".$responseData['message']."');history.back();</script>";
        }
    }

?>