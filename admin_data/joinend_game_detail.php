<?php
    if (isset($_POST['cmd']) && $_POST['cmd'] == 'joinedGame') {
        $event_id = $_POST['eventId'];
        $member_id = $_POST['memberId'];
        $event_title = $_POST['eventTitle'];

        $_SERVER['REQUEST_URI'] == "/" ? require 'config/config.php' : require '../config/config.php';
        global $my_api;
        require $_SERVER['DOCUMENT_ROOT'].'/model/JwtApiCall.php';

        $get_joined_detail = JwtApiCall($my_api."event/memberEventDetail", "POST", array('eventId' => $event_id, 'memberId' => $member_id), $_SESSION['token']);
        
        $get_joined_detail_attend = '';
        echo "<p class=\"joinend_game_title\">$event_title</p>";   
        if ($get_joined_detail['attend'] == 'ATTEND' || $get_joined_detail['attend'] == 'LATE') {
            $get_joined_detail_attend = $get_joined_detail['attend'] == 'ATTEND' ? '출석' : '지각';
            echo "<p class=\"joinend_game_attend\">출석 : $get_joined_detail_attend</p>";   
        } else {
            $get_joined_detail_attend = '미출석';
            echo "<p class=\"joinend_game_attend\">출석 : $get_joined_detail_attend</p>";   
        }

        $get_joined_detail_purchaseStatus = '';
        if ($get_joined_detail['purchaseStatus'] == 'PURCHASED' || $get_joined_detail['purchaseStatus'] == 'WAITING') {
            $get_joined_detail_purchaseStatus = $get_joined_detail['purchaseStatus'] == 'PURCHASED' ? '납부' : '납부 확인중';
            echo "<p class=\"joinend_game_attend\">납부 여부 : $get_joined_detail_purchaseStatus</p>";   
        } else {
            $get_joined_detail_purchaseStatus = '미납부';
            echo "<p class=\"joinend_game_attend\">납부 여부 : $get_joined_detail_purchaseStatus</p>";   
        }
    }
?>