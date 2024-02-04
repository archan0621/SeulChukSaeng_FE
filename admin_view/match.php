<?php
    include '../tpl/body_tpl.php';
    function html_body() {
        global $_SESSION, $my_api;
        if (!isset($_SESSION['token']) || $_SESSION['userRole'] != 'ADMIN') {
            header('Location: /');
        }
        if (isset($_SESSION['token'])) {
            require $_SERVER['DOCUMENT_ROOT'].'/model/JwtApiCall.php';
            $get_event_list = JwtApiCall($my_api."event/list", "POST", array(''), $_SESSION['token']);
            class event_dto {
                private $event_id;
                private $event_title;
                private $event_gender;
                private $event_location;
                private $event_money;
                private $event_start_time;

                public function __construct($event_id, $event_title, $event_gender, $event_location, $event_money, $event_start_time) {
                    $this->event_id = $event_id;
                    $this->event_title = $event_title;
                    $this->event_gender = $event_gender;
                    $this->event_location = $event_location;
                    $this->event_money = $event_money;
                    $this->event_start_time = $event_start_time;
                }
                public function get_event_id() {
                    return $this->event_id;
                }
            
                public function get_event_title() {
                    return $this->event_title;
                }

                public function get_event_gender() {
                    if ($this->event_gender == "FEMALE"){
                        return "여성 매치";
                    } else {
                        return "남성 매치";
                    }
                }
                public function get_event_location()  {
                    return $this->event_location;
                }

                public function get_event_money() {
                    return $this->event_money."원";
                }

                public function get_event_start_time() {
                    // ISO 8601 형식의 날짜 및 시간을 DateTime 객체로 변환
                    $start_time = new DateTime($this->event_start_time);
                
                    // 오후/오전, 시간 및 분 추출
                    $afternoon_time = $start_time->format('A') === 'AM' ? '오전' : '오후';
                    $hour = $start_time->format('g');
                    $minute = $start_time->format('i');
                    $month = $start_time->format('n');
                    $day = $start_time->format('j');
                
                    // 포맷에 맞춰서 날짜와 시간을 반환
                    return $month . '월 ' . $day . '일 ' . $afternoon_time . ' ' . $hour . '시 ' . $minute . '분';
                }
            }
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
                <div class="list_title_wrap match_list_title">
                    <p class="list_title"><i class="fa-regular fa-futbol"></i> 경기 목록</p>
                    <a href="match_create" class="list_title"> 경기 추가</a>
                </div>
                <div class="match_list_wrap">
                    <?php for ($i = 0; $i < $get_event_list['showcaseCount']; $i++) { 
                        $event_dto = new event_dto($get_event_list['eventShowcase'][$i]['eventId'], $get_event_list['eventShowcase'][$i]['eventTitle'], $get_event_list['eventShowcase'][$i]['gender'], $get_event_list['eventShowcase'][$i]['location'], $get_event_list['eventShowcase'][$i]['money'], $get_event_list['eventShowcase'][$i]['startTime']);
                        $event_dto_id = $event_dto->get_event_id();
                        $event_dto_event = $event_dto->get_event_title(); 
                        $event_dto_gender = $event_dto->get_event_gender();
                        $event_dto_location = $event_dto->get_event_location();
                        $event_dto_money = $event_dto->get_event_money();
                        $event_dto_startTime = $event_dto->get_event_start_time();?>
                        <a href="/view/match?event_id=<?= $event_dto_id ?>" class="list match_list_item">
                            <div class="match_list_item_title">
                                <?= $event_dto_event ?>
                            </div>
                            <div class="match_list_item_info">
                                <span class="list_main_item"><?= $event_dto_gender ?></span>
                                <span class="list_main_item"><?= $event_dto_location ?> </span>
                                <span class="list_main_item"><?= $event_dto_money ?></span>
                                <span class="list_main_item"><?= $event_dto_startTime ?></span>
                            </div>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    }
?>