<?php
    include '../tpl/body_tpl.php';
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['joined_game'])) {
        // POST 요청의 필요한 데이터 확인
        $cmd = $_POST['joined_game'];
        $eventId = $_POST['eventId'];
        $memberId = $_POST['memberId'];
    
        // 여기서 요청 처리
        // 필요한 작업 수행
    
        // 응답 보내기 (예시로 'Success'를 응답으로 보냄)
        echo 'Success';
        return $cmd;
    }
    function html_body() {
        global $_SESSION, $my_api;
        if (!isset($_SESSION['token']) || $_SESSION['userRole'] != 'ADMIN') {
            header('Location: /');
        }
        require $_SERVER['DOCUMENT_ROOT'].'/model/JwtApiCall.php';

        $memberId = $_GET['id'];
        $get_member_detail = JwtApiCall($my_api."member/memberDetail", "POST", array('memberId' => $memberId), $_SESSION['token']);
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
                    <p class="list_title"><i class="fa-solid fa-user"></i>부원 개별 관리 상세 페이지</p>
                </div>
                <div class="member_detail_wrap">
                    <div class="member_tier_wrap">
                        <div><img src="../img/tier.png" alt="멤버 티어"></div>
                        <div class="member_detail">
                            <p>이름: <?=$get_member_detail['memberInfo']['name']?></p>
                            <p>전화번호: <?=$get_member_detail['memberInfo']['phone']?></p>
                            <p>성별: <?=$get_member_detail['memberInfo']['gender'] == 'MALE' ? '남자' : '여자'?></p>
                            <p>경고 횟수: <?=$get_member_detail['memberInfo']['warnPoint']?></p>
                        </div>
                    </div>
                    <div class="match_rate_wrap">
                        <div class="match_total_rate">
                            <div class="match_rate">
                                <p>전체 경기 수: <?=$get_member_detail['rate']['totalGame']?></p>
                                <p>참여 경기 수: <?=$get_member_detail['rate']['joinedGame']?></p>
                                <p>경기 전체 참여율: <?=$get_member_detail['rate']['totalGame'] / $get_member_detail['rate']['joinedGame'] * 100?>%</p>
                            </div>
                            <p>경기 전체 참여율</p>
                        </div>
                        <div class="match_joined_rate">
                            <div class="match_rate">
                                <p>참여 경기 수: <?=$get_member_detail['rate']['joinedGame']?></p>
                                <p>출석(정상) 경기 수: <?=$get_member_detail['rate']['attendedGame']?></p>
                                <p>출석(지각) 경기 수: <?=$get_member_detail['rate']['lateGame'] ?? '0'?></p>
                                <p>미출석 경기 수: <?=$get_member_detail['rate']['absentGame']?></p>
                                <p>참여 경기 참여율: <?=intval(($get_member_detail['rate']['attendedGame'] + $get_member_detail['rate']['lateGame']) / $get_member_detail['rate']['joinedGame'] * 100)?>%</p>
                            </div>
                            <p>참여 경기 참여율</p>
                        </div>
                    </div>
                </div>
                <div class="list_title_wrap">
                    <p class="list_title">참여 경기 목록</p>
                </div>
                <div class="joinend_game_list_wrap">
                    <div class="joinend_game_list">
                        <?php foreach ($get_member_detail['joinedGame'] as $item) { ?>
                        <p><a href="javascript:;" onclick="no_function()"><?=$item['eventTitle']?></a></p>
                        <?php } ?>
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