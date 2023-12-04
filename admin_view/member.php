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
                <div class="list_title_wrap">
                    <p class="list_title">사용할 메뉴를 선택해주세요</p>
                </div>
                <div class="txt_center member_management_wrap">
                   <a href="../admin_management/" class="member_management">
                        <div class="icon"><i class="fa-solid fa-user"></i></div>
                        <div class="match_info_txt"><p>부원 개별 관리</p></div>
                    </a>
                   <a href="javascript:;" onclick="no_function()" class="all_management">
                        <div class="icon"><i class="fa-solid fa-chart-column"></i></div>
                        <div class="match_info_txt"><p>전체 통계</p></div>
                    </a>
                </div>
                <div>
                    <div class="list_title_wrap">
                        <p class="list_title">최근 유저 활동</p>
                    </div>
                    <div class="user_log">
                        <!-- 유저 로그 -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function no_function() {
        alert('공사 중입니다!');
    }
</script>
<?php
    }
?>