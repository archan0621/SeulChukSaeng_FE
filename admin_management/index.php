<?php
    include '../tpl/body_tpl.php';
    function html_body() {
        global $_SESSION, $my_api;
        if (!isset($_SESSION['token']) || $_SESSION['userRole'] != 'ADMIN') {
            header('Location: /');
        }
        
        require $_SERVER['DOCUMENT_ROOT'].'/model/JwtApiCall.php';
        $get_member_list = JwtApiCall($my_api."member/memberList", "POST", array(''), $_SESSION['token']);

        $male_list = [];
        $female_list = [];
        foreach ($get_member_list['memberList'] as $item) {
            if ($item['gender'] == 'MALE') {
                array_push($male_list, $item);
            } else {
                array_push($female_list, $item);
            }
        }

        function comparePlayers($player1, $player2) {
            $sortA = $player1['name'];
            $sortB = $player2['name'];

            return strcmp($sortA, $sortB);
        }
    
        usort($male_list, 'comparePlayers');
        usort($female_list, 'comparePlayers');
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
                <div class="list_title_wrap admin_management_wrap">
                    <p class="list_title"><i class="fa-solid fa-user"></i>부원 개별 관리</p>
                    <div>
                        <input type="text" name="search_member" id="search_member" class="search_member" placeholder="이름을 입력해주세요">
                        <i class='fa-solid fa-magnifying-glass'></i>
                    </div>
                </div>
                <div>
                    <div class="management_member_list">
                        <?php foreach ($male_list as $item) { ?>
                        <p><a href="member_detail?id=<?=$item['id']?>"><?=$item['name']?> / 남자 / <?=$item['phone']?> / <?=$item['warnPoint']?>회</a></p>
                        <?php } ?>
                        <div class="line"></div>
                        <?php foreach ($female_list as $item) { ?>
                        <p><a href="member_detail?id=<?=$item['id']?>"><?=$item['name']?> / 여자 / <?=$item['phone']?> / <?=$item['warnPoint']?>회</a></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    }
?>