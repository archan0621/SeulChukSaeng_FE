<?php
$real_api = "https://sellstory.kro.kr:30621/";
$test_api = "https://sellstory.kro.kr:30622/";
$my_host = $_SERVER['HTTP_HOST'];
$my_api = "";

if ($my_host  == 'seulchuksaeng.com') {
    $my_api = $real_api;
} else {
    $my_api = $test_api;
}
global $my_api;
?>