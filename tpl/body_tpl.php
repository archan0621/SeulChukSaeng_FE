<?php
    $_SERVER['REQUEST_URI'] == "/" ? require 'config/config.php' : require 'config/config.php';
    global $_SESSION;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>슬축생</title>
    <link rel="stylesheet" href="/style/style.css">
    <link rel="stylesheet" href="/style/admin.css">
    <link rel="stylesheet" href="/style/color.css">
    <link rel="stylesheet" href="/style/base.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Suez+One&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@500&family=Suez+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lity/2.4.1/lity.min.css">
    <script src="https://kit.fontawesome.com/c73bb93925.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lity/2.4.1/lity.min.js"></script>
    <script type="text/javascript" src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=oekl5d5mdq&submodules=geocoder"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script>
    (function(j,ennifer) {
        j['dmndata']=[];j['jenniferFront']=function(args){window.dmndata.push(args)};
        j['dmnaid']=ennifer;j['dmnatime']=new Date();j['dmnanocookie']=false;j['dmnajennifer']='JENNIFER_FRONT@INTG';
    }(window, '6b231e62'));
    </script>
    <script async src="https://d-collect.jennifersoft.com/6b231e62/demian.js"></script>
</head>
<body>
    <?=html_body();?>
</body>
</html>