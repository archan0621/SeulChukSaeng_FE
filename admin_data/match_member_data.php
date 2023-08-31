<?php
    $event_id = $_POST['eventId'];
    $list_type = $_POST['listType'];
    if (isset($event_id) && isset($list_type)) {
        require $_SERVER['DOCUMENT_ROOT'].'/model/JwtApiCall.php';
        $memberSearch = JwtApiCall("https://sellstory.kro.kr:30621/event/".$list_type, "POST", array('eventId' => $event_id), $_SESSION['token']); //미참여인원
        foreach ($memberSearch['memberList'] as $item) {
            if ($_POST['func'] == 'add_player') {
                echo "<a href=\"../admin_control/add_match_player?memberId={$item['memberId']}&event_id={$event_id}\">{$item['memberName']}</a><br/>";
            } elseif ($_POST['func'] == 'minus_player') {
                echo "<a href=\"../admin_control/minus_match_player?memberId={$item['memberId']}&event_id={$event_id}\">{$item['memberName']}</a><br/>";
            } elseif ($_POST['func'] == 'list_player') {
                echo "{$item['memberName']}<br/>";
            } elseif ($_POST['func'] == 'expenses_player') {
                echo "<a href=\"../admin_control/expenses_match_player?event_id={$event_id}\">{$item['memberName']}</a><a class=\"expenses_ok_btn\" href=\"../admin_control/expenses_match_player?memberId={$item['memberId']}&event_id={$event_id}\">확인</a><br/>";
            } else {
                echo "데이터를 불러오지 못했습니다.<br/>";
            }
        }
    }
?>