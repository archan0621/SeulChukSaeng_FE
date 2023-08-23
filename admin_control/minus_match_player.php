<?php
    require $_SERVER['DOCUMENT_ROOT'].'/model/JwtApiCall.php';

    $eventId = $_GET['event_id'];
    $memberId = $_GET['memberId'];

    if (isset($eventId) && isset($memberId)) {
        if ($memberId) {
            $responseData = JwtApiCall("https://sellstory.kro.kr:30621/event/memberRemove", 
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