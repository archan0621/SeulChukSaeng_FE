<?php
    include '../tpl/body_tpl.php';
    function html_body() {
        global $_SESSION;
        if (!isset($_SESSION['userRole']) || $_SESSION['userRole'] == 'USER') {
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
                <div class="list_title_wrap member_list">
                    <p class="list_title"><i class="fa-solid fa-user"></i> 부원 목록</p>
                    <div><input type="text" name="search_member" id="search_member" class="search_member" placeholder="이름을 입력해주세요"></div>
                </div>
                <div class="txt_center">
                   <table class="member_list_table">
                        <thead>
                            <th>이름</th>
                            <th>전화번호</th>
                            <th>성별</th>
                            <th>누적경고</th>
                            <th></th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>박종하</td>
                                <td>010-1234-5678</td>
                                <td>남자</td>
                                <td>12회</td>
                                <td>자세히 보기</td>
                            </tr>
                        </tbody>
                   </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    }
?>