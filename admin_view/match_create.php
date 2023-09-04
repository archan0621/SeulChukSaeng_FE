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
                    <p class="list_title"><i class="fa-regular fa-futbol"></i> 경기 생성</p>
                </div>
                <div class="match_create_wrap">
                    <form action="../admin_control/match_create" method="post">
                        <div><p>경기 제목</p><input type="text" name="match_title" id="match_title" class="match_title" placeholder="경기 제목을 입력해주세요"></div>
                        <div><p>경기 위치</p><input type="text" name="match_location" id="match_location" class="match_location" placeholder="경기 위치를 선택해주세요"></div>
                        <div>
                            <p>경기 종류</p>
                            <select name="member_gender" id="member_gender" class="admin_member_gender" onchange="changeGender(this)">
                                <option value="none">경기종류를 선택해주세요</option>
                                <option value="MALE" class="select" id="select">남자</option>
                                <option value="FEMALE" class="select" id="select">여자</option>
                            </select>
                        </div>
                        <div><p>시작 시간</p><input type="datetime-local" name="match_start_time" id="match_start_time" class="match_start_time" placeholder="시작 시간 선택해주세요"></div>
                        <div><p>종료 시간</p><input type="datetime-local" name="match_end_time" id="match_end_time" class="match_end_time" placeholder="종료 시간 선택해주세요"></div>
                        <div><p>개인 활동비</p><input type="text" name="match_money" id="match_money" class="match_money" placeholder="개인 활동비를 입력해주세요"></div>
                        <div><p>유의사항</p><input type="text" name="match_description" id="match_description" class="match_description" placeholder="경기 유의사항을 작성해주세요"></div>
                        <div class="match_create_btn_wrap"><button type="submit" class="match_create_btn">경기 생성</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const changeGender = (target) => {
        const member_gender = document.getElementById('member_gender');
        if (target.value == 'MALE' || target.value == 'FEMALE') {
            member_gender.classList.add('select_on');
        } else {
            member_gender.classList.remove('select_on');
        }
    }
</script>
<?php
    }
?>