<?php
    require $_SERVER['DOCUMENT_ROOT'].'/model/JwtApiCall.php';

    $eventId = $_GET['eventId'];

    if (isset($eventId)) {
        $responseData = JwtApiCall("https://sellstory.kro.kr:30621/event/memberPurchaseReq", 
        "POST", 
        array(
            "eventId" => $eventId
        ), 
        $_SESSION['token']);
        
        if ($responseData['result'] == 'fail') {
            echo "<script>alert('".$responseData['message']."');location.href='../view/match?event_id=".$eventId."'</script>";
        } elseif ($responseData['result'] == 'success') {
            echo "<script>alert('".$responseData['message']."');history.back();</script>";
        }
    }

?>