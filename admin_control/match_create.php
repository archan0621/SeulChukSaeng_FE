<?php
    require $_SERVER['DOCUMENT_ROOT'].'/model/JwtApiCall.php';

    if (!$_POST['match_title']) {
        echo "<script>alert('제목을 입력해주세요');history.back();</script>";
    } elseif (!$_POST['match_location']) {
        echo "<script>alert('위치를 입력해주세요');history.back();</script>";
    } elseif (!$_POST['member_gender'] || $_POST['member_gender'] == 'none') {
        echo "<script>alert('경기종류를 선택해주세요');history.back();</script>";
    } elseif (!$_POST['match_start_time']) {
        echo "<script>alert('시작시간을 입력해주세요');history.back();</script>";
    } elseif (!$_POST['match_end_time']) {
        echo "<script>alert('종료시간을 입력해주세요');history.back();</script>";
    } elseif (!$_POST['match_money']) {
        echo "<script>alert('활동비를 입력해주세요');history.back();</script>";
    } elseif (!$_POST['match_description']) {
        echo "<script>alert('유의사항을 입력해주세요');history.back();</script>";
    }  else {
        $title = $_POST['match_title'];
        $location = $_POST['match_location'];
        $gender = $_POST['member_gender'];
        $money = $_POST['match_money'];
        $start_time = $_POST['match_start_time'];
        $end_time = $_POST['match_end_time'];
        $description = $_POST['match_description'];
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $responseData = JwtApiCall("https://sellstory.kro.kr:30621/event/create", 
            "POST", 
            array(
                "title" => $title,
                "location" => $location, 
                "gender" => $gender, 
                "money" => $money,
                "startTime" => $start_time,
                "endTime" => $end_time,
                "description" => $description
            ), 
            $_SESSION['token']);
        }
    
      if ($responseData['result'] == 'fail') {
        echo "<script>alert('".$responseData['message']."');</script>";
        header("Location: ../admin_view/match");
      } elseif ($responseData['result'] == 'success') {
        echo "<script>alert('".$responseData['message']."');location.href='../admin_view/index';</script>";
      }
?>