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
                    <a href="../admin_view/" class="m_r_16 admin_index_return"><i class="fa-solid fa-chevron-left"></i></a>
                    <?php if (isset($_SESSION['userRole']) && $_SESSION['userRole'] == 'ADMIN') { ?>
                    <p><a href="../admin_view/">관리자 메뉴</a></p>
                    <?php  } ?>
                </div>
                <div class="user_info">
                    <p><a href="../view/my_info" class="txt_700"><?=$_SESSION['member_id']?>님</a></p>
                    <p><a href="../view_control/signout" class="admin_logout">로그아웃</a></p>
                </div>
            </div>
        </div>
        <div class="index_main">
            <div class="admin_list">
                <div class="admin_member_management_wrap">
                    <div>
                        <p class="admin_member_management_title">사용할 메뉴를 선택해주세요</p>
                        <div class="admin_member_management_menu">
                            <a href="../admin_management" class="member_management_link">
                                <div class="icon"><i class="fa-regular fa-user"></i></div>
                                <p>부원 목록</p>
                            </a>
                            <a href="javascript:;" onclick="no_function()" class="member_management_link">
                                <div class="icon"><i class="fa-solid fa-chart-column"></i></div>
                                <p>전체 통계</p>
                            </a>
                        </div>
                        <div class="user_log">
                            <div class="user_log_title">
                                <p>최근 유저 활동</p>
                                <a href="javascript:;" onclick="reload()" class="icon"><i class="fa-solid fa-rotate-right"></i></a>
                            </div>
                            <div class="user_log_txt">

                            </div>
                        </div>
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
    function reload() {
        location.reload();
    }
</script>
<?php
    }
?>