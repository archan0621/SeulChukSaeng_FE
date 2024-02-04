<?php
    include 'tpl/body_tpl.php';
    function html_body() {
        global $is_maintenance;
        if (!$is_maintenance) {
            header('Location: /');
        }
?>
<style>
    .maintenance_wrap {
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .maintenance {
        border: 8px solid #d9d9d9;
        padding: 30px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .logo {
        width: 120px;
        height: 120px;
        margin-bottom: 40px;
    }
    .maintenance_txt {
        font-size: 20px;
        font-weight: 700;
        text-align: center;
        margin-bottom: 20px;
    }
</style>
<div class="maintenance_wrap">
    <div class="maintenance">
        <img src="/img/logo.png" class="logo" alt="슬축생 로고">
        <div class="maintenance_txt">
            3.x기 활동은 모두 완료되었습니다.<br/>
            4기때 좋은 모습으로 만나요~!
        </div>
        <div class="football_cat">
            <img src="/img/football_cat.gif" alt="축구 움짤">
        </div>
    </div>
</div>
<?php
    }
?>