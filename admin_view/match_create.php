<?php
    include '../tpl/body_tpl.php';
    function html_body() {
        global $_SESSION, $is_maintenance;
        if ($is_maintenance) {
            header('Location: /maintenance');
        }
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
            <div class="admin_list">
                <div class="list_title_wrap">
                    <p class="list_title"><i class="fa-regular fa-futbol"></i> 경기 생성</p>
                </div>
                <div class="match_create_wrap">
                    <form action="../admin_control/match_create" method="post">
                        <div><p>경기 제목</p><input type="text" name="match_title" id="match_title" class="match_title" placeholder="경기 제목을 입력해주세요"></div>
                        <div>
                            <p>경기 위치</p>
                            <div class="admin_match_location_wrap">
                                <input type="text" name="match_location" id="match_location" class="match_location" placeholder="경기 위치를 입력해주세요">
                                <select name="match_location_select" id="match_location_select" class="admin_match_location_select" onchange="changeMatchLocation(this)">
                                    <option value="none">직접 입력</option>
                                    <option value="서울시 강남구 도곡동 산21" class="select" id="select">중대부고</option>
                                    <option value="서울 송파구 올림픽로 240 잠실롯데마트 제타플렉스동 R층" class="select" id="select">잠실 로꼬스타디움</option>
                                    <option value="한강로3가 40-999" class="select" id="select">용산 더베이스</option>
                                </select>
                            </div>
                        </div>
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
    const changeMatchLocation = (target) => {
        const match_location_select = document.getElementById('match_location_select');
        const match_location = document.getElementById('match_location');
        if (target.value != 'none') {
            match_location_select.classList.add('select_on');
            match_location.value = target.value;
        } else {
            match_location_select.classList.remove('select_on');
            match_location.value = '';
        }
    }

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