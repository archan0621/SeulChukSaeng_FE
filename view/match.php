<?php
    include '../tpl/body_tpl.php';
    function html_body() {
        global $_SESSION;
        if (!isset($_SESSION['member_id'])) {
            header("location: ../view_control/signout");
        }
        $event_id = $_GET['event_id'];
        require $_SERVER['DOCUMENT_ROOT'].'/model/JwtApiCall.php';
        $get_event = JwtApiCall("https://sellstory.kro.kr:30621/event/read", "POST", array('eventId' => $event_id), $_SESSION['token']);
        class event_dto {
            private $eventId;
            private $title;
            private $gender;
            private $money;
            private $description;
            private $startTime;
            private $endTime;
            private $location;

            public function __construct($eventId, $title, $gender, $money, $description, $startTime, $endTime, $location) {
                $this->eventId = $eventId;
                $this->title = $title;
                $this->gender = $gender;
                $this->money = $money;
                $this->description = $description;
                $this->startTime = $startTime;
                $this->endTime = $endTime;
                $this->location = $location;
            }
            public function get_event_id() {
                return $this->eventId;
            }
        
            public function get_event_title() {
                return $this->title;
            }

            public function get_event_gender() {
                return $this->gender;
            }

            public function get_event_money() {
                return $this->money;
            }

            public function get_event_description() {
                return $this->description;
            }

            public function get_event_startTime() {
                $this->startTime = strtotime($this->startTime);
                $hour = date("H", $this->startTime);
                $minute = date("i", $this->startTime);

                if ($hour <= 12) {
                    $this->startTime = '오전 ' . $hour . ':' . $minute;
                } else {
                    $hour -= 12;
                    $this->startTime = '오후 ' . $hour . ':' . $minute;
                }

                return $this->startTime;
            }

            public function get_event_endTime() {
                $this->endTime = strtotime($this->endTime);
                $hour = date("H", $this->endTime);
                $minute = date("i", $this->endTime);

                if ($hour <= 12) {
                    $this->endTime = '오전 ' . $hour . ':' . $minute;
                } else {
                    $hour -= 12;
                    $this->endTime = '오후 ' . $hour . ':' . $minute;
                }

                return $this->endTime;
            }

            public function get_event_location() {
                return $this->location;
            }

        }
        $event_dto = new event_dto($get_event['readResult']['eventId'], $get_event['readResult']['title'], $get_event['readResult']['gender'], $get_event['readResult']['money'], $get_event['readResult']['description'], $get_event['readResult']['startTime'], $get_event['readResult']['endTime'], $get_event['readResult']['location']);
        $event_dto_id = $event_dto->get_event_id();
        $event_dto_title = $event_dto->get_event_title();
        $event_dto_gender = $event_dto->get_event_gender();
        $event_dto_money = $event_dto->get_event_money();
        $event_dto_description = $event_dto->get_event_description();
        $event_dto_startTime = $event_dto->get_event_startTime();
        $event_dto_endTime = $event_dto->get_event_endTime();
        $event_dto_location = $event_dto->get_event_location();
        if ($event_dto_gender == 'MALE') {
            $event_dto_gender = '남자 경기';
        } elseif ($event_dto_gender == 'FEMALE') {
            $event_dto_gender = '여자 경기';
        } else {
            $event_dto_gender = '혼성 경기';
        }
?>
<div class="page_wrap">
    <div class="page">
        <div class="header_wrap">
            <div class="header">
                <div>
                    <a href="/" class="font_en">SeulChukSaeng</a>
                </div>
                <div class="user_info">
                    <p><a href="#"><?=$_SESSION['member_id']?>님</a></p>
                    <p><a href="../view_control/signout">로그아웃</a></p>
                </div>
            </div>
        </div>
        <div class="txt_center match_wrap">
            <div class="match_title"><?=$event_dto->get_event_title()?></div>
            <div class="match_info">
                <div class="match_gender">
                    <div class="icon"><i class="fa-solid fa-person"></i></div>
                    <div class="match_info_txt">
                        <p>경기종류</p>
                        <p><?=$event_dto_gender?></p>
                    </div>
                </div>
                <div class="match_expenses">
                    <div class="icon"><i class="fa-solid fa-dollar-sign"></i></div>
                    <div class="match_info_txt">
                        <p>활동비</p>
                        <p><?=$event_dto_money?>원</p>
                    </div>
                </div>
                <div class="match_start">
                    <div class="icon"><i class="fa-solid fa-clock"></i></div>
                    <div class="match_info_txt">
                        <p>시작시간</p>
                        <p><?=$event_dto_startTime?></p>
                    </div>
                </div>
                <div class="match_end">
                    <div class="icon"><i class="fa-solid fa-clock"></i></div>
                    <div class="match_info_txt">
                        <p>종료시간</p>
                        <p><?=$event_dto_endTime?></p>
                    </div>
                </div>
            </div>
            <div class="member_check_wrap">
                <div class="member_check">
                    <div class="attendance_check">
                        <div class="icon"><i class="fa-solid fa-user-check"></i></div>
                        <div class="attendance_check_txt"><a href="#">출석 확인</a></div>
                    </div>
                    <div class="expenses_check">
                        <div class="icon"><i class="fa-solid fa-hand-holding-dollar"></i></div>
                        <div class="expenses_check_txt"><a href="#">납부 확인</a></div>
                    </div>
                    <div class="player_check">
                        <div class="icon"><i class="fa-solid fa-user"></i></div>
                        <div class="player_check_txt"><a href="javascript:;" onclick="player_check_lity();">참여인원</a></div>
                    </div>
                </div>
            </div>
            <div class="match_notice_wrap">
                <div class="match_notice">
                    <div class="match_notice_title">추가 안내 사항</div>
                    <div class="match_notice_des"><?=$event_dto_description?></div>
                </div>
            </div>
            <div class="match_address_wrap">
                <div class="match_address">
                    <div class="icon"><i class="fa-solid fa-map-pin"></i></div>
                    <div class="match_address_txt"><?=$event_dto_location?></div>
                </div>
            </div>
            <div class="match_map_wrap">
                <div class="match_map">
                </div>
            </div>
        </div>
    </div>
</div>
<div id="player_check_lity" class="lity-hide popup_wrap">
    <div class="popup">
        <div class="popup_header">
            <div class="popup_header_left">
                <i class="fa-solid fa-user"></i>
                <p>참여인원 목록</p>
            </div>
            <div class="popup_header_right">
                <button class="lity-close" type="button" aria-label="Close (Press escape to close)" data-lity-close="">닫기 <i class="fa-solid fa-x"></i></button>
            </div>
        </div>
        <div class="popup_content player_list">
            박종하,박종하,박종하,박종하,박종하,박종하,박종하,박종하,박종하,박종하,박종하
        </div>
    </div>
</div>
<script>
    function player_check_lity() {
        lity('#player_check_lity');
    }
</script>
<?php
    }
?>