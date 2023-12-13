<?php
    include '../tpl/body_tpl.php';
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
                            <div class="match_rate" id="match_rate">
                                <div class="chart" id="all_chart"></div>
                            </div>
                            <p>경기 전체 참여율</p>
                        </div>
                        <div class="match_joined_rate">
                            <div class="match_rate">
                                <div class="chart" id="joined_chart"></div>
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
                        <p><a href="javascript:;" onclick="joined_game(<?=$item['eventId']?>, '<?=$item['eventTitle']?>', <?=$memberId?>)"><?=$item['eventTitle']?></a></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="joined_game_lity" class="lity-hide popup_wrap joined_game_lity">
    <div class="popup">
        <div class="popup_header">
            <div class="popup_header_left">
                <p>참여 경기 상세 조회</p>
            </div>
            <div class="popup_header_right">
                <button class="lity-close" type="button" aria-label="Close (Press escape to close)" data-lity-close>닫기 <i class="fa-solid fa-x"></i></button>
            </div>
        </div>
        <div class="popup_content player_list joinend_game_wrap" id="joinend_game_wrap">
            <div class="joinend_game" id="joinend_game"></div>
            <div class="attend_process_btn" id="attend_process_btn"></div>
        </div>
    </div>
</div>
<script>
    function joined_game(eventId, eventTitle, memberId) {
        $.ajax({
            url: '../admin_data/joinend_game_detail.php', 
            method: 'POST',
            data: { cmd: 'joinedGame', eventId: eventId, eventTitle: eventTitle, memberId: memberId },
            success: function(response) {
                lity('#joined_game_lity');
                $('.joined_game_lity').parent().parent().addClass('joined_game_lity_wrap');
                document.querySelector('#joinend_game').innerHTML = response;
                document.querySelector('#attend_process_btn').innerHTML = '<a href="../admin_control/attend_process?eventId='+eventId+'&memberId='+memberId+'"><i class="fa-solid fa-circle-check"></i>직권 출석 처리</a>';
            }
        });
    }
    $(function () {
        const colors_all_chart = ['#BDE7FF', '#BEFFBD', '#FFBDBD', '#CCCCCC'];
        const colors_joined_chart = ['#BEFFBD', '#F9FC87', '#FFBDBD', '#CCCCCC'];

        Highcharts.chart('all_chart', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie',
                width: 200,
                height: 200
            },
            title: {
                text: '',
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.0f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    colors: colors_all_chart,
                    borderRadius: 5,
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b><br>{point.percentage:.0f} %',
                        distance: -50,
                    }
                }
            },

            series: [{
                name: '참여 경기 수',
                data: [
                        <?php if (($get_member_detail['rate']['joinedGame'] == $get_member_detail['rate']['totalGame']) && $get_member_detail['rate']['joinedGame'] > 0) { ?>
                        {
                            name: '경기 참여율',
                            y: 100,
                            color: colors_all_chart[1]
                        }
                        <?php } elseif (($get_member_detail['rate']['joinedGame'] < $get_member_detail['rate']['totalGame']) && ($get_member_detail['rate']['joinedGame'] > 0)) { ?>
                        {
                            name: '전체 경기',
                            y: <?=100 - $get_member_detail['rate']['joinedGame'] / $get_member_detail['rate']['totalGame'] * 100?>,
                            color: colors_all_chart[0]
                        },
                        {
                            name: '경기 참여율',
                            y: <?=$get_member_detail['rate']['joinedGame'] / $get_member_detail['rate']['totalGame'] * 100?>,
                            color: colors_all_chart[1]
                        }
                        <?php } else { ?>                
                        {
                            name: '경기 미참석',
                            y: 100,
                            color: colors_all_chart[3]
                        }
                        <?php } ?>
            ]
            }]
        });
        
        Highcharts.chart('joined_chart', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie',
                width: 200,
                height: 200
            },
            title: {
                text: '',
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.0f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    colors: colors_joined_chart,
                    borderRadius: 5,
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b><br>{point.percentage:.0f} %',
                        <?=$get_member_detail['rate']['joinedGame'] == $get_member_detail['rate']['absentGame'] ? 'distance: -50,' : 'distance: -25,'?>
                        style: {
                            <?=$get_member_detail['rate']['joinedGame'] == $get_member_detail['rate']['absentGame'] ? 'fontSize: "11px"' : 'fontSize: "9px"'?>
                        },
                        filter: {
                            property: 'percentage',
                            operator: '>',
                            value: 3
                        }
                    },
                }
            },
            series: [{
                name: '참여 경기 참여율',
                data: [
                    <?php if ($get_member_detail['rate']['joinedGame'] == $get_member_detail['rate']['absentGame']) { ?>
                    { 
                        name: '경기 미참석', 
                        y: 100,
                        color: colors_joined_chart[3]
                    }
                    <?php } else { ?>
                    {
                        name: '출석(정상) 경기 수', 
                        y: <?=$get_member_detail['rate']['attendedGame'] ?? 0?>,
                        color: colors_joined_chart[0],
                    },
                    { 
                        name: '출석(지각) 경기 수', 
                        y: <?=$get_member_detail['rate']['lateGame'] ?? 0?>,
                        color: colors_joined_chart[1]
                    },
                    { 
                        name: '미출석 경기 수', 
                        y: <?=$get_member_detail['rate']['absentGame'] ?? 0?>,
                        color: colors_joined_chart[2]
                    }
                    <?php } ?>
                ]
            }]
        });
    });
</script>
<?php
    }
?>