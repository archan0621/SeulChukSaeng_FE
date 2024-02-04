<?php
    include '../tpl/body_tpl.php';
    function html_body() {
        global $_SESSION, $my_api, $is_maintenance;
        if ($is_maintenance) {
            header('Location: /maintenance');
        }
        if (!isset($_SESSION['token']) || $_SESSION['userRole'] != 'ADMIN') {
            header('Location: /');
        }
        
        require $_SERVER['DOCUMENT_ROOT'].'/model/JwtApiCall.php';
        $get_member_list = JwtApiCall($my_api."member/memberList", "POST", array(''), $_SESSION['token']);

        $gender = '';
        if (isset($_GET['gender'])) {
            if ($_GET['gender'] == 'male') {
                $gender = 'male';
            } else if ($_GET['gender'] == 'female') {
                $gender = 'female';
            } else {
                $gender = '';
            }
        }

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
        <div class="header_wrap admin_header_wrap">
            <div class="header admin_header">
                <div>
                    <a href="../admin_view/" class="m_r_16 admin_index_return"><i class="fa-solid fa-chevron-left"></i></a>
                    <?php if (isset($_SESSION['userRole']) && $_SESSION['userRole'] == 'ADMIN') { ?>
                    <p><a href="../admin_view/">관리자 메뉴</a></p>
                    <?php  } ?>
                </div>
                <div class="user_info">
                    <p><a href="../view/my_info" class="txt_700"><?=$_SESSION['member_id']?>님</a></p>
                    <p><a href="../view_control/signout" class="admin_logout">로그아웃</a></p>
                </div>
            </div>
            <div class="search_member_wrap">
                <input type="text" name="search_member" id="search_member" class="search_member" placeholder="이름을 입력해주세요">
                <p class="icon"><i class='fa-solid fa-magnifying-glass'></i></p>
            </div>
        </div>
        <div class="index_main">
            <div class="admin_list">
                <div class="admin_management_wrap">
                    <div class="admin_management_toggle">
                        <a href="../admin_management/" class="<?=$gender == '' ? 'on' : ''?>">전체</a>
                        <a href="../admin_management?gender=male" class="<?=$gender == 'male' ? 'on' : ''?>">남자</a>
                        <a href="../admin_management?gender=female" class="<?=$gender == 'female' ? 'on' : ''?>">여자</a>
                    </div>
                    <div>
                        <div class="management_member_list">
                            <div class="member_info">
                                <p>이름</p>
                                <p>성별</p>
                                <p>경고</p>
                                <p>정보</p>
                            </div>
                            <div class="member_list">
                                <?php if ($gender == '' || $gender == 'male') { ?>
                                    <?php foreach ($male_list as $item) { ?>
                                    <div><p><?=$item['name']?></p><p>남자</p><p><?=$item['warnPoint']?>회</p><p><a href="member_detail?id=<?=$item['id']?>">자세히</a></p></div>
                                    <?php } ?>
                                <?php } ?>
                                <?php if ($gender == '') { ?>
                                <p class="line"></p>
                                <?php } ?>
                                <?php if ($gender == '' || $gender == 'female') { ?>
                                    <?php foreach ($female_list as $item) { ?>
                                    <div><p><?=$item['name']?></p><p>여자</p><p><?=$item['warnPoint']?>회</p><p><a href="member_detail?id=<?=$item['id']?>">자세히</a></p></div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
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