<?php
$real_api = "https://sellstory.kro.kr:30621/";
$test_api = "https://sellstory.kro.kr:30622/";
$my_api = "";
$real_mode = false;

if ($real_mode) {
    $my_api = $real_api;
} else {
    $my_api = $test_api;
}
global $my_api;
?>