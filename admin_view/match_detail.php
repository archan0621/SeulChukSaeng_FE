<?php
    include '../tpl/body_tpl.php';
    function html_body() {
        global $_SESSION;
        if (!isset($_SESSION['member_id'])) {
            header("location: ../view_control/signout");
        }
        $event_id = $_GET['event_id'];
        require $_SERVER['DOCUMENT_ROOT'].'/model/JwtApiCall.php';
        
        include '../admin_data/match_data.php';
        $event_info = match_data($event_id);

        $not_match_player = JwtApiCall("https://sellstory.kro.kr:30621/event/memberNoList", "POST", array('eventId' => $event_id), $_SESSION['token']); //미참여인원
        $match_player = JwtApiCall("https://sellstory.kro.kr:30621/event/memberList", "POST", array('eventId' => $event_id), $_SESSION['token']); //참여인원
?>
<div class="page_wrap">
    <div class="page">
        <div class="header_wrap">
            <div class="header">
                <div>
                    <a href="/" class="font_en">SeulChukSaeng</a>
                </div>
                <div class="user_info">
                    <?php if (isset($_SESSION['userRole']) && $_SESSION['userRole'] == 'ADMIN') { ?>
                    <p><a href="/admin_view/index">관리자 메뉴</a></p>
                    <?php  } ?>
                    <p><a href="#"><?=$_SESSION['member_id']?>님</a></p>
                    <p><a href="../view_control/signout">로그아웃</a></p>
                </div>
            </div>
        </div>
        <div class="txt_center match_wrap">
            <div class="admin_match_title">
                <div><?=$event_info['event_dto_title']?></div>
                <div class="admin_match_modify"><a href="javascript:;" onclick="match_change()">경기 수정</a><a href="javascript:;">경기 삭제</a></div>
            </div>
            <div class="match_info">
                <div class="match_gender">
                    <div class="icon"><i class="fa-solid fa-person"></i></div>
                    <div class="match_info_txt">
                        <p>경기종류</p>
                        <p><?=$event_info['event_dto_gender']?></p>
                    </div>
                </div>
                <div class="match_expenses">
                    <div class="icon"><i class="fa-solid fa-dollar-sign"></i></div>
                    <div class="match_info_txt">
                        <p>활동비</p>
                        <p><?=$event_info['event_dto_money']?>원</p>
                    </div>
                </div>
                <div class="match_start">
                    <div class="icon"><i class="fa-solid fa-clock"></i></div>
                    <div class="match_info_txt">
                        <p>시작시간</p>
                        <p><?=$event_info['event_dto_startTime']?></p>
                    </div>
                </div>
                <div class="match_end">
                    <div class="icon"><i class="fa-solid fa-clock"></i></div>
                    <div class="match_info_txt">
                        <p>종료시간</p>
                        <p><?=$event_info['event_dto_endTime']?></p>
                    </div>
                </div>
            </div>
            <div class="match_info admin_match_info">
                <a href="javascript:;" onclick="add_player()" class="add_player">
                    <div class="icon"><i class="fa-solid fa-plus"></i></div>
                    <div class="match_info_txt">
                        <p>참여인원 추가</p>
                    </div>
                </a>
                <a href="javascript:;" onclick="minus_player()" class="minus_player">
                    <div class="icon"><i class="fa-solid fa-circle-minus"></i></div>
                    <div class="match_info_txt">
                        <p>참여인원 삭제</p>
                    </div>
                </a>
                <a href="javascript:;" onclick="list_player()" class="list_player">
                    <div class="icon"><i class="fa-solid fa-list-ul"></i></div>
                    <div class="match_info_txt">
                        <p>참여인원 목록</p>
                    </div>
                </a>
                <a href="javascript:;" onclick="expenses_player()" class="expenses_player">
                    <div class="icon"><i class="fa-solid fa-hand-holding-dollar"></i></div>
                    <div class="match_info_txt">
                        <p>납부 확인 요청</p>
                    </div>
                </a>
            </div>
            <div class="match_notice_wrap">
                <div class="match_notice">
                    <div class="match_notice_title">추가 안내 사항</div>
                    <div class="match_notice_des"><?=$event_info['event_dto_description']?></div>
                </div>
            </div>
            <div class="match_address_wrap">
                <div class="match_address">
                    <div class="icon"><i class="fa-solid fa-map-pin"></i></div>
                    <div class="match_address_txt"><?=$event_info['event_dto_location']?></div>
                </div>
            </div>
            <div class="match_map_wrap">
                <div class="match_map">
                </div>
            </div>
        </div>
    </div>
</div>
<div id="add_player_lity" class="lity-hide popup_wrap">
    <div class="popup">
        <div class="popup_header">
            <div class="popup_header_left">
                <i class="fa-solid fa-user-plus"></i>
                <p>참여인원 추가</p>
            </div>
            <div class="popup_header_right">
                <button class="lity-close" type="button" aria-label="Close (Press escape to close)" data-lity-close>닫기 <i class="fa-solid fa-x"></i></button>
            </div>
        </div>
        <div class="popup_content player_list">
            <?php foreach ($not_match_player['memberList'] as $item) { ?>
            <a href="../admin_control/add_match_player?memberId=<?=$item['memberId']?>&event_id=<?=$event_id?>"><?=$item['memberName']?></a><br>
            <?php } ?>
        </div>
    </div>
</div>
<div id="minus_player_lity" class="lity-hide popup_wrap">
    <div class="popup">
        <div class="popup_header">
            <div class="popup_header_left">
                <i class="fa-solid fa-user-minus"></i>
                <p>참여인원 삭제</p>
            </div>
            <div class="popup_header_right">
                <button class="lity-close" type="button" aria-label="Close (Press escape to close)" data-lity-close>닫기 <i class="fa-solid fa-x"></i></button>
            </div>
        </div>
        <div class="popup_content player_list">
            <?php foreach ($match_player['memberList'] as $item) { ?>
                <a href="../admin_control/minus_match_player?memberId=<?=$item['memberId']?>&event_id=<?=$event_id?>"><?=$item['memberName']?></a><br>
            <?php } ?>
        </div>
    </div>
</div>
<div id="list_player_lity" class="lity-hide popup_wrap">
    <div class="popup">
        <div class="popup_header">
            <div class="popup_header_left">
                <i class="fa-solid fa-user"></i>
                <p>참여인원 목록</p>
            </div>
            <div class="popup_header_right">
                <button class="lity-close" type="button" aria-label="Close (Press escape to close)" data-lity-close>닫기 <i class="fa-solid fa-x"></i></button>
            </div>
        </div>
        <div class="popup_content player_list">
            <?php foreach ($match_player['memberList'] as $item) { ?>
            <p><?=$item['memberName']?></p>
            <?php } ?>
        </div>
    </div>
</div>
<div id="expenses_player_lity" class="lity-hide popup_wrap">
    <div class="popup">
        <div class="popup_header">
            <div class="popup_header_left">
                <i class="fa-solid fa-user"></i>
                <p>납부 확인 요청</p>
            </div>
            <div class="popup_header_right">
                <button class="lity-close" type="button" aria-label="Close (Press escape to close)" data-lity-close>닫기 <i class="fa-solid fa-x"></i></button>
            </div>
        </div>
        <div class="popup_content player_list">
            ???
        </div>
    </div>
</div>
<div id="match_change_lity" class="lity-hide popup_wrap match_change_lity">
    <div class="popup">
        <div class="popup_header">
            <div class="popup_header_left">
                <i class="fa-solid fa-futbol"></i>
                <p>경기 수정</p>
            </div>
            <div class="popup_header_right">
                <button class="lity-close" type="button" aria-label="Close (Press escape to close)" data-lity-close>닫기 <i class="fa-solid fa-x"></i></button>
            </div>
        </div>
        <div class="popup_content match_change player_list">
            <form action="../admin_control/match_update" method="post">
                <input type="hidden" name="match_id" id="match_id" class="match_id" value=<?=$event_info['event_dto_id']?>>
                <div><p>경기 제목</p><input type="text" name="match_title" id="match_title" class="match_title" value="<?=$event_info['event_dto_title']?>"></div>
                <div><p>경기 위치</p><input type="text" name="match_location" id="match_location" class="match_location" value="<?=$event_info['event_dto_location']?>"></div>
                <div>
                    <p>경기 종류</p>
                    <select name="member_gender" id="member_gender" class="admin_member_gender">
                        <option value="<?=$event_info['event_dto_gender'] == '남자 경기' ? 'MALE' : 'FEMALE'?>"><?=$event_info['event_dto_gender'] == '남자 경기' ? '남자' : '여자'?></option>
                        <option value="<?=$event_info['event_dto_gender'] == '남자 경기' ? 'FEMALE' : 'MALE'?>" class="select" id="select"><?=$event_info['event_dto_gender'] == '남자 경기' ? '여자' : '남자'?></option>
                    </select>
                </div>
                <div><p>시작 시간</p><input type="datetime-local" name="match_start_time" id="match_start_time" class="match_start_time" value="<?=$event_info['event_dto_startTime_datetimeLocal']?>"></div>
                <div><p>종료 시간</p><input type="datetime-local" name="match_end_time" id="match_end_time" class="match_end_time" value="<?=$event_info['event_dto_endTime_datetimeLocal']?>"></div>
                <div><p>개인 활동비</p><input type="text" name="match_money" id="match_money" class="match_money" value="<?=$event_info['event_dto_money']?>"></div>
                <div><p>유의사항</p><input type="text" name="match_description" id="match_description" class="match_description" value="<?=$event_info['event_dto_description']?>"></div>
                <div class="match_change_btn_wrap"><button type="submit" class="match_change_btn">경기 수정</button></div>
            </form>
        </div>
    </div>
</div>
<script>
    function add_player() {
        lity('#add_player_lity');
    }
    function minus_player() {
        lity('#minus_player_lity');
    }
    function list_player() {
        lity('#list_player_lity');
    }
    function expenses_player() {
        lity('#expenses_player_lity');
    }
    function match_change() {
        lity('#match_change_lity');
        $('.match_change_lity').parent().parent().addClass('match_change_lity_wrap');
    }
</script>
<?php
    }
?>