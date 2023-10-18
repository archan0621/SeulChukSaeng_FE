<?php
    $event_id = $_POST['eventId'];
    $list_type = $_POST['listType'];
    if (isset($event_id) && isset($list_type)) {
        require $_SERVER['DOCUMENT_ROOT'].'/model/JwtApiCall.php';
        $_SERVER['REQUEST_URI'] == "/" ? require 'config/config.php' : require '../config/config.php';
        global $my_api;

        $memberSearch = JwtApiCall($my_api."event/".$list_type, "POST", array('eventId' => $event_id), $_SESSION['token']);

        function comparePlayers($player1, $player2) {
            $sortA = $player1['memberName'];
            $sortB = $player2['memberName'];

            return strcmp($sortA, $sortB);
        }
    
        usort($memberSearch['memberList'], 'comparePlayers');

        if ($memberSearch['result'] == 'fail' && $memberSearch['message'] == '만료된 토큰으로 JWT 요청시도') {
            echo "<script>alert('세션이 만료되었습니다. 다시 로그인해주세요.');location.href='../view_control/signout';</script>";
        } else {
            foreach ($memberSearch['memberList'] as $item) {
                if ($_POST['func'] == 'add_player') {
                    echo "<a href=\"../admin_control/add_match_player?memberId={$item['memberId']}&event_id={$event_id}\">{$item['memberName']}</a><br/>";
                } elseif ($_POST['func'] == 'minus_player') {
                    echo "<a href=\"../admin_control/minus_match_player?memberId={$item['memberId']}&event_id={$event_id}\">{$item['memberName']}</a><br/>";
                } elseif ($_POST['func'] == 'list_player') {
                    if($item['attendance']) {
                        if ($item['attendance'] == 'LATE') {
                            $item['attendance'] = '지각';
                        } else {
                            $item['attendance'] = $item['attendance'] == 'ABSENT' ? '미출석' : '출석';
                        }
                    } else {
                        $item['attendance'] = '';
                    }

                    if($item['purchaseStatus']) {
                        if ($item['purchaseStatus'] == 'NOT_PURCHASED') {
                            $item['purchaseStatus'] = '미납';
                        } else {
                            $item['purchaseStatus'] = $item['purchaseStatus'] == 'WAITING' ? '확인 대기중' : '납부 완료';
                        }
                    } else {
                        $item['purchaseStatus'] = '';
                    }
                    echo "{$item['memberName']} / {$item['attendance']} / {$item['purchaseStatus']}<br/>";
                } elseif ($_POST['func'] == 'expenses_player') {
                    echo "<div class=\"expenses_ok_btn_wrap\"><a href=\"../admin_control/expenses_match_player?event_id={$event_id}\">{$item['memberName']}</a><a class=\"expenses_ok_btn\" href=\"../admin_control/expenses_match_player?memberId={$item['memberId']}&event_id={$event_id}\">확인</a><br/>";
                } else {
                    echo "데이터를 불러오지 못했습니다.<br/>";
                }
            }
        }
    }
?>