<?php
    include 'tpl/body_tpl.php';
    function html_body() {
        global $_SESSION, $my_api;
        if (isset($_SESSION['token'])) {
            require $_SERVER['DOCUMENT_ROOT'].'/model/JwtApiCall.php';
            $get_event_list = JwtApiCall($my_api."event/list", "POST", array(''), $_SESSION['token']);
            class event_dto {
                private $event_id;
                private $event_title;

                public function __construct($event_id, $event_title) {
                    $this->event_id = $event_id;
                    $this->event_title = $event_title;
                }
                public function get_event_id() {
                    return $this->event_id;
                }
            
                public function get_event_title() {
                    return $this->event_title;
                }
            }
        }
        $id = '';
        $pw = '';
        $checked = false;
        if(isset($_COOKIE['save_login'])) {
            $user_data = unserialize($_COOKIE['save_login']);
            $id = $user_data['member_id'];
            $pw = $user_data['member_pw'];
            $checked = true;
        }
?>
<div class="page_wrap">
    <?php if (isset($_SESSION['member_id'])) { ?>
        <div class="bg_white page">
            <div class="header_wrap admin_header_wrap">
                <div class="header admin_header">
                    <div>
                        <a href="/"><img src="/img/admin_logo.png" class="admin_logo"></a>
                        <?php if (isset($_SESSION['userRole']) && $_SESSION['userRole'] == 'ADMIN') { ?>
                        <p><a href="../admin_view/" class="txt_underline">관리자 메뉴</a></p>
                        <?php  } ?>
                    </div>
                    <div class="user_info">
                        <p><a href="../view/my_info" class="txt_700"><?=$_SESSION['member_id']?>님</a></p>
                        <p><a href="../view_control/signout" class="admin_logout">로그아웃</a></p>
                    </div>
                </div>
            </div>
            <div class="index_main">
                <div class="list_wrap match_list">
                    <div class="list_title_wrap"><p class="list_title">매치 목록</p></div>
                    <div class="list_main">
                        <div>
                            <?php for ($i = 0; $i < $get_event_list['showcaseCount']; $i++) { 
                            $event_dto = new event_dto($get_event_list['eventShowcase'][$i]['eventId'], $get_event_list['eventShowcase'][$i]['eventTitle']);
                            $event_dto_id = $event_dto->get_event_id();
                            $event_dto_event = $event_dto->get_event_title();?>
                            <a href="/view/match?event_id=<?=$event_dto_id?>" class="list"><?=$event_dto_event?></a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="list_wrap notice_list">
                    <a href="javascript:;" onclick="no_function()" class="list_title_wrap"><p class="list_title">공지사항</p></a>
                    <div class="list_main">
                        <div>
                            <!-- 공지사항 리스트 -->
                        </div>
                    </div>
                </div>
                <div class="list_wrap budgets_list">
                    <a href="javascript:;" onclick="no_function()" class="list_title_wrap"><p class="list_title">회비 사용 내역</p></a>
                    <div class="list_main">
                        <div>
                            <!-- 회비 리스트 -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="bg_white page">
            <div class="txt_center login_wrap">
                <div class="login_header">
                    <img src="img/logo.png" alt="슬축생 로고" class="logo_img">
                    <h2 class="font_en">SeulChukSaeng</h2>
                    <p class="header_noti">환영합니다!!<br>슬기로운 축구생활 멤버 페이지 입니다</p>
                </div>
                <div class="login_main">
                    <form action="view_control/login_control" method="post">
                        <input type="text" name="member_id" id="member_id" class="m_b_16" value="<?=$id ?: ''?>" placeholder="아이디">
                        <input type="password" name="member_pw" id="member_pw" class="m_b_16" value="<?=$pw ?: ''?>" placeholder="비밀번호">
                        <div class="save_login_wrap">
                            <input type="checkbox" name="save_login" value="save_login" <?=$checked ? 'checked' : ''?> id="save_login" class="m_b_16">
                            <label for="save_login">로그인 정보 기억하기</label>
                        </div>
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
<script>
    function no_function() {
        alert('공사 중입니다!');
    }
</script>
<?php
    }
?>