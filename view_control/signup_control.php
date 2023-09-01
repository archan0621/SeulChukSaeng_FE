<?php
  require $_SERVER['DOCUMENT_ROOT'].'/model/RestApiCall.php';

  if (!$_POST['member_id']) {
    echo "<script>alert('아이디를 입력해주세요');history.back();</script>";
  } elseif (!$_POST['member_pw']) {
    echo "<script>alert('비밀번호를 입력해주세요');history.back();</script>";
  } elseif (!$_POST['member_name']) {
    echo "<script>alert('이름을 입력해주세요');history.back();</script>";
  } elseif (!$_POST['member_mobile']) {
    echo "<script>alert('전화번호를 입력해주세요');history.back();</script>";
  } elseif (!$_POST['member_gender']) {
    echo "<script>alert('성별을 입력해주세요');history.back();</script>";
  } elseif (!$_POST['member_code']) {
    echo "<script>alert('회원 인증 코드를 입력해주세요');history.back();</script>";
  } else {
    $member_id = $_POST['member_id'];
    $member_pw = $_POST['member_pw'];
    $member_name = $_POST['member_name'];
    $member_mobile = $_POST['member_mobile'];
    $member_gender = $_POST['member_gender'];
    $member_code = $_POST['member_code'];
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $responseData = RestApiCall("https://sellstory.kro.kr:30621/member/join", 
      CURLOPT_POST, 
      array(
        "id" => $member_id,
        "password" => $member_pw, 
        "name" => $member_name, 
        "phone" => $member_mobile,
        "gender" => $member_gender,
        "verifyCode" => $member_code
        )
      );
      }
  
    if ($responseData['result'] == 'fail') {
      echo "<script>alert('".$responseData['message']."');history.back();</script>";
    } elseif ($responseData['result'] == 'success') {
      echo "<script>alert('".$responseData['message']."');location.href='/';</script>";
    }
  }

?>
