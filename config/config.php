<?php
$real_api = "https://sellstory.kro.kr:30621/";
$test_api = "https://sellstory.kro.kr:30622/";
$my_api = "";
$real_mode = false;
$is_maintenance = false; // true => 점검 O / false => 점검 X

if ($real_mode) {
    $my_api = $real_api;
} else {
    $my_api = $test_api;
}
global $my_api, $is_maintenance;
?>