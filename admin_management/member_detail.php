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

        $memberId = $_GET['id'];
        $get_member_detail = JwtApiCall($my_api."member/memberDetail", "POST", array('memberId' => $memberId), $_SESSION['token']);
        $warnPoint = $get_member_detail['memberInfo']['warnPoint'];
        $warnings = intdiv($warnPoint, 3); // warnPoint를 3으로 나눈 몫을 구함 (경고 횟수)
        $cautions = $warnPoint % 3; // warnPoint를 3으로 나눈 나머지를 구함 (주의 횟수)
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
        </div>
        <div class="index_main">
            <div class="admin_list">
                <div>
                    <p class="member_detail_title">부원 개별 관리 상세 페이지</p>
                </div>
                <div class="member_detail_wrap">
                    <div class="member_tier_wrap">
                        <div class="member_detail">
                            <div>
                                <p class="name"><?=$get_member_detail['memberInfo']['name']?> <?=$get_member_detail['memberInfo']['gender'] == 'MALE' ? '(남)' : '(여)'?></p>
                                <p class="phone">TEL <?=$get_member_detail['memberInfo']['phone']?></p>
                            </div>
                            <div class="warn_point_wrap">
                                <div class="warn_point warn_point_1"><p><?=$warnings?></p><p class="warn_point_title">경고</p></div>
                                <div class="line"></div>
                                <div class="warn_point warn_point_2"><p><?=$cautions?></p><p class="warn_point_title">주의</p></div>
                            </div>
                        </div>
                    </div>
                    <a href="javascript:;" onclick="rule()" class="rule">>>> 슬축생 패널티 규칙</a>
                    <div class="match_rate_wrap">
                        <div class="match_rate_title"><?=$get_member_detail['memberInfo']['name']?> 부원 <?=$get_member_detail['rate']['totalGame']?>회 중 <?=$get_member_detail['rate']['joinedGame']?>회 참여</div>
                        <div class="match_rate_main">
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
                </div>
                <div class="match_game_title">
                    <p>참여 경기 목록</p>
                </div>
                <div class="joinend_game_list_wrap">
                    <div class="joinend_game_list">
                        <?php foreach ($get_member_detail['joinedGame'] as $item) { ?>
                        <p>
                            <a href="javascript:;" onclick="joined_game(<?=$item['eventId']?>, '<?=$item['eventTitle']?>', <?=$memberId?>)"><?=$item['eventTitle']?></a>
                            <a href="javascript:;" onclick="joined_game(<?=$item['eventId']?>, '<?=$item['eventTitle']?>', <?=$memberId?>)"><i class="fa-solid fa-chevron-right"></i></a>
                        </p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="joined_game_lity" class="lity-hide joined_game_lity">
    <div>
        <div>
            <div class="joined_game_title">
                <p class="txt_center">참여 경기 상세 조회</p>
            </div>
        </div>
        <div class="joinend_game_wrap" id="joinend_game_wrap">
            <div class="joinend_game" id="joinend_game"></div>
            <div class="btn_wrap">
                <div class="attend_process_btn" id="attend_process_btn"></div>
                <div class="close_btn">
                    <a href="javascript:;" data-lity-close>닫기</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="rule_lity" class="lity-hide rule_lity">
    <div>
        <div>
            <div class="rule_title">
                <p><i class="fa-regular fa-futbol"></i> 슬축생 패널티 규칙 <i class="fa-regular fa-futbol"></i></p>
                <p><a href="javascript:;" data-lity-close>X</a></p>
            </div>
        </div>
        <div class="rule_main_wrap" id="rule_main_wrap">
            <div class="rule_noti">
                <p>💦 주의 : 3회당 경고 1회</p>
                <p>💦 경고 2회 : 동아리 퇴출(회비환급X)</p>
            </div>
            <div class="rule_main">
                <p>1. 투표 미참여 <span class="warn_1">주의 1회</span></p>
                <p>2. 20분 이상 경기 지각 시 <span class="warn_1">주의 1회</span></p>
                <p>3. 명단 확정 후 불참 통보/노쇼 시 <span class="warn_1">경고 1회</span></p>
                <p>4. 경기 3번 연속 미참여 <span class="warn_2">경고 1회</span></p>
            </div>
        </div>
    </div>
</div>
<script>
    function rule() {
        lity('#rule_lity');
    }
    function joined_game(eventId, eventTitle, memberId) {
        $.ajax({
            url: '../admin_data/joinend_game_detail.php', 
            method: 'POST',
            data: { cmd: 'joinedGame', eventId: eventId, eventTitle: eventTitle, memberId: memberId },
            success: function(response) {
                lity('#joined_game_lity');
                $('.joined_game_lity').parent().parent().addClass('joined_game_lity_wrap');
                document.querySelector('#joinend_game').innerHTML = response;
                document.querySelector('#attend_process_btn').innerHTML = '<a href="../admin_control/attend_process?eventId='+eventId+'&memberId='+memberId+'">직권 출석 처리</a>';
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
                        name: '경기 미출석', 
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