<?php
    include '../tpl/body_tpl.php';
    function html_body() {
        global $_SESSION, $is_maintenance;
        if ($is_maintenance) {
            header('Location: /maintenance');
        }
        if (!isset($_SESSION['member_id'])) {
            header("location: ../view_control/signout");
        }
        $event_id = $_GET['event_id'];
        require $_SERVER['DOCUMENT_ROOT'].'/model/JwtApiCall.php';
        
        include '../admin_data/match_data.php';
        $event_info = match_data($event_id);
?>
<div class="page_wrap">
    <div class="page">
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
        <div class="txt_center match_wrap">
            <div class="admin_match_title">
                <div><?=$event_info['event_dto_title']?></div>
                <div class="admin_match_modify"><a href="javascript:;" onclick="match_change()">경기 수정</a><a href="../admin_control/match_delete?eventId=<?=$event_id?>">경기 삭제</a></div>
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
                    <div id="match_address_txt" class="match_address_txt"><?=$event_info['event_dto_location']?></div>
                </div>
            </div>
            <div class="match_map_wrap">
                <div id="map" class="match_map"></div>
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
        <div class="popup_content player_list" id="add_player"></div>
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
        <div class="popup_content player_list" id="minus_player"></div>
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
        <div class="popup_content player_list" id="player_list"></div>
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
        <div class="popup_content player_list" id="expenses_player"></div>
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
                <div>
                    <p>경기 위치</p>
                    <div class="admin_match_location_wrap">
                        <input type="text" name="match_location" id="match_location" class="match_location" value="<?=$event_info['event_dto_location']?>">
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
    function add_player() {
        $.ajax({
            url: '../admin_data/match_member_data.php', 
            method: 'POST',
            data: { eventId: <?=$event_id?>, listType: 'memberNoList', func: 'add_player' },
            success: function(response) {
                lity('#add_player_lity');
                document.querySelector('#add_player').innerHTML = response;
            }
        });
    }
    function minus_player() {
        $.ajax({
            url: '../admin_data/match_member_data.php', 
            method: 'POST',
            data: { eventId: <?=$event_id?>, listType: 'memberList', func: 'minus_player' },
            success: function(response) {
                lity('#minus_player_lity');
                document.querySelector('#minus_player').innerHTML = response;
            }
        });
    }
    function list_player() {
        $.ajax({
            url: '../admin_data/match_member_data.php', 
            method: 'POST',
            data: { eventId: <?=$event_id?>, listType: 'memberList', func: 'list_player' },
            success: function(response) {
                lity('#list_player_lity');
                document.querySelector('#player_list').innerHTML = response;
            }
        });
    }
    function expenses_player() {
        $.ajax({
            url: '../admin_data/match_member_data.php', 
            method: 'POST',
            data: { eventId: <?=$event_id?>, listType: 'memberPurchaseList', func: 'expenses_player' },
            success: function(response) {
                lity('#expenses_player_lity');
                document.querySelector('#expenses_player').innerHTML = response;
            }
        });
    }
    function match_change() {
        lity('#match_change_lity');
        $('.match_change_lity').parent().parent().addClass('match_change_lity_wrap');
    }
    function matchLocation() {
        var address = document.getElementById('match_address_txt').textContent;
        var centerCoord = new naver.maps.LatLng(37.5666102, 126.9783881);
        var map = new naver.maps.Map('map', {
            center: centerCoord,
            zoom: 15
        });

        naver.maps.Service.geocode({
            address: address
        }, function(status, response) {
            if (status === naver.maps.Service.Status.OK) {
                var result = response.result;
                var firstItem = result.items[0];
                var coords = new naver.maps.LatLng(firstItem.point.y, firstItem.point.x);

                map.setCenter(coords);

                var marker = new naver.maps.Marker({
                    position: coords,
                    map: map
                });

                naver.maps.Event.addListener(marker, 'click', function() {
                    var naverMapURL = 'https://map.naver.com/?dlevel=11&lat=' + coords._lat + '&lng=' + coords._lng;
                    window.open(naverMapURL, '_blank');
                });
            } else {
                alert('주소를 찾을 수 없습니다.');
            }
        });
    }
    window.onload = matchLocation;
    naver.maps.onJSContentLoaded = matchLocation;
</script>
<?php
    }
?>