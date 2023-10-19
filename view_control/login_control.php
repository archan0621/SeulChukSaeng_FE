<?php
  require $_SERVER['DOCUMENT_ROOT'].'/model/RestApiCall.php';
  require $_SERVER['DOCUMENT_ROOT'].'/model/JwtApiCall.php';
  include '../loading/loading.php';
  $_SERVER['REQUEST_URI'] == "/" ? require 'config/config.php' : require '../config/config.php';
  global $my_api;

  if (!$_POST['member_id']) {
    echo "<script>alert('아이디를 입력해주세요');history.back();</script>";
  } elseif (!$_POST['member_pw']) {
    echo "<script>alert('비밀번호를 입력해주세요');history.back();</script>";
  } else {
    loading_page(true);

    $member_id = $_POST['member_id'];
    $member_pw = $_POST['member_pw'];
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $responseData = RestApiCall($my_api."member/login", CURLOPT_POST, array("loginId" => $member_id, 'password' => $member_pw));
    }
  
    if ($responseData['result'] == 'success') {
      /* 유저 이름 조회 */
      $get_user_name = JwtApiCall($my_api."member/getUserName", "GET", array(''), $responseData['token']);
      
      if ($get_user_name['result'] == 'success') {
        $_SESSION['token'] = $responseData['token'];
        $_SESSION['member_id'] = $get_user_name['message'];
        $_SESSION['userRole'] = $get_user_name['userRole'];
        loading_page(false);
        header("Location: /");
      } elseif ($get_user_name['result'] == 'fail') {
        loading_page(false);
        echo "<script>alert('".$get_user_name['message']."');history.back();</script>";
      }
    } elseif ($responseData['result'] == 'fail') {
      loading_page(false);
      echo "<script>alert('".$responseData['message']."');history.back();</script>";
    }
  }
?>
