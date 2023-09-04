<?php
    include '../tpl/body_tpl.php';
    function html_body() {
        global $_SESSION, $my_api;
        if (!isset($_SESSION['userRole']) || $_SESSION['userRole'] == 'USER') {
            header('Location: /');
        }
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
                <div class="list_title_wrap match_list_title">
                    <p class="list_title"><i class="fa-regular fa-futbol"></i> 경기 목록</p>
                    <a href="match_create" class="list_title"> 경기 추가</a>
                </div>
                <div class="match_list_wrap">
                    <?php for ($i = 0; $i < $get_event_list['showcaseCount']; $i++) { 
                        $event_dto = new event_dto($get_event_list['eventShowcase'][$i]['eventId'], $get_event_list['eventShowcase'][$i]['eventTitle']);
                        $event_dto_id = $event_dto->get_event_id();
                        $event_dto_event = $event_dto->get_event_title();?>
                        <div class="admin_match_list">
                        <a href="/admin_view/match_detail?event_id=<?=$event_dto_id?>" class="list"><?=$event_dto_event?></a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    }
?>