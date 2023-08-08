<?php
    include 'tpl/body_tpl.php';
    function html_body() {
        global $_SESSION;
?>
<div class="page_wrap">
    <?php if (isset($_SESSION['member_id'])) { ?>
        <div class="bg_white page">
            <div class="header_wrap">
                <div class="header">
                    <div>
                        <p class="font_en">SeulChukSaeng</p>
                    </div>
                    <div class="user_info">
                        <p><?=$_SESSION['member_id']?>님</p>
                        <p><a href="view_control/signout">로그아웃</a></p>
                    </div>
                </div>
            </div>
            <div class="index_main">
                <div class="list_wrap match_list">
                    <div class="list_title_wrap"><p class="list_title">매치 목록</p></div>
                    <div class="list_main">
                        <div>
                            <p class="list">매치 목록1매치 목록1매치 목록1매치 목록1매치 목록1매치 목록1매치 목록1매치 목록1매치 목록1매치 목록1</p>
                            <p class="list">매치 목록2</p>
                            <p class="list">매치 목록3</p>
                            <p class="list">매치 목록4</p>
                        </div>
                    </div>
                </div>
                <div class="list_wrap notice_list">
                    <div class="list_title_wrap"><p class="list_title">공지사항</p></div>
                    <div class="list_main">
                        <div>
                            <p class="list">공지사항1공지사항1공지사항1공지사항1공지사항1공지사항1공지사항1공지사항1공지사항1공지사항1</p>
                            <p class="list">공지사항2</p>
                            <p class="list">공지사항3</p>
                            <p class="list">공지사항4</p>
                        </div>
                    </div>
                </div>
                <div class="list_wrap budgets_list">
                    <div class="list_title_wrap"><p class="list_title">회비 사용 내역</p></div>
                    <div class="list_main">
                        <div>
                            <p class="list">회비1회비1회비1회비1회비1회비1회비1회비1회비1회비1</p>
                            <p class="list">회비2</p>
                            <p class="list">회비3</p>
                            <p class="list">회비4</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="bg_white page">
            <div class="txt_center login_wrap">
                <div class="login_header">
                    <h2 class="font_en">SeulChukSaeng</h2>
                    <p class="header_noti">환영합니다!!<br>슬기로운 축구생활 멤버 페이지 입니다</p>
                </div>
                <div class="login_main">
                    <form action="view_control/login_control" method="post">
                        <input type="text" name="member_id" id="member_id" class="m_b_16" placeholder="아이디">
                        <input type="password" name="member_pw" id="member_pw" class="m_b_16" placeholder="비밀번호">
                        <button type="submit" class="login_submit">로그인</button>
                    </form>
                </div>
                <div class="go_signup_wrap">
                    <a href="/view/signup" class="go_signup">아니 아직 계정이 없다구요? 이걸 누르세요</a>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<?php
    }
?>