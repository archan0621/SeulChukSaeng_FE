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
        <div class="header_wrap">
            <div class="header">
                <div>
                    <a href="/" class="font_en">SeulChukSaeng</a>
                </div>
                <div class="user_info">
                    <?php if (isset($_SESSION['userRole']) && $_SESSION['userRole'] == 'ADMIN') { ?>
                    <p><a href="../admin_view/index">관리자 메뉴</a></p>
                    <?php  } ?>
                    <p><a href="#"><?=$_SESSION['member_id']?>님</a></p>
                    <p><a href="../view_control/signout">로그아웃</a></p>
                </div>
            </div>
        </div>
        <div class="index_main">
            <div class="admin_list">
                <div class="list_title_wrap"><p class="list_title">사용할 메뉴를 선택해주세요</p></div>
                <div class="txt_center admin_panel_wrap">
                   <a href="javascript:;" onclick="no_function()" class="member_management">
                        <div class="icon"><i class="fa-solid fa-user"></i></div>
                        <div class="match_info_txt"><p>부원 관리</p></div>
                    </a>
                   <a href="match" class="match_management">
                        <div class="icon"><i class="fa-regular fa-futbol"></i></div>
                        <div class="match_info_txt"><p>경기 관리</p></div>
                    </a>
                   <a href="javascript:;" onclick="no_function()" class="budgets_management">
                        <div class="icon"><i class="fa-solid fa-dollar-sign"></i></div>
                        <div class="match_info_txt"><p>회비 관리</p></div>
                    </a>
                   <a href="javascript:;" onclick="no_function()" class="notice_management">
                        <div class="icon"><i class="fa-solid fa-volume-high"></i></div>
                        <div class="match_info_txt"><p>공지 관리</p></div>
                    </a>
                </div>
            </div>
            <div>
                <div class="list_title_wrap surver_log_wrap"><p class="list_title">서버 로그</p><p class="list_title"><a href="javascript:;" onclick="reload()"><i class="fa-solid fa-rotate"></i>새로고침</a></p></div>
                <div class="surver_log">
                    <!-- 서버로그 -->
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