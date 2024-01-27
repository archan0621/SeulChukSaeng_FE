<?php
    include '../tpl/body_tpl.php';
    function html_body() {
        global $_SESSION;
        if (!isset($_SESSION['token']) || $_SESSION['userRole'] != 'ADMIN') {
            header('Location: /');
        }
?>
<div class="page_wrap">
    <div class="bg_white page">
        <div class="header_wrap admin_header_wrap">
            <div class="header admin_header">
                <div>
                    <a href="/"><img src="/img/admin_logo.png" class="admin_logo"></a>
                    <?php if (isset($_SESSION['userRole']) && $_SESSION['userRole'] == 'ADMIN') { ?>
                    <p><a href="../admin_view/index" class="txt_underline">관리자 메뉴</a></p>
                    <?php  } ?>
                </div>
                <div class="user_info">
                    <p><a href="#" class="txt_700"><?=$_SESSION['member_id']?>님</a></p>
                    <p><a href="../view_control/signout" class="admin_logout">로그아웃</a></p>
                </div>
            </div>
        </div>
        <div class="index_main admin_main">
            <div class="txt_center admin_list">
                <div class="admin_title_wrap"><p class="admin_title">사용할 메뉴를 선택해주세요</p></div>
                <div class="txt_center admin_panel_wrap">
                   <a href="member" class="member_management">
                       <div>
                            <p class="member_management_title">부원 관리</p>
                            <p class="member_management_noti">최근 유저 활동, 부원 목록, 통계</p>
                        </div>
                        <div class="icon"><i class="fa-regular fa-user"></i></div>
                    </a>
                    <a href="match" class="match_management">
                       <div>
                            <p class="match_management_title">경기 관리</p>
                            <p class="match_management_noti">경기 목록, 생성, 설정</p>
                        </div>
                        <div class="icon"><i class="fa-regular fa-futbol"></i></div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function reload() {
        location.reload();
    }
    function no_function() {
        alert('공사 중입니다!');
    }
</script>
<?php
    }
?>