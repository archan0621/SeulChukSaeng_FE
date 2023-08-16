<?php
    include '../tpl/body_tpl.php';
    function html_body() {
?>
<div class="page_wrap">
    <div class="page">
        <div class="txt_center signup_wrap">
            <div class="signup_header">
                <img src="../img/logo.png" alt="슬축생 로고" class="logo_img">
                <h2 class="font_en">SeulChukSaeng</h2>
                <p class="header_noti txt_gray">어서오세요<br>새로운 부원은 언제나 환영이야!</p>
            </div>
            <div class="signup_main">
                <form action="/view_control/signup_control" method="post">
                    <input type="text" name="member_id" id="member_id" class="m_b_16" placeholder="아이디를 입력해주세요">
                    <input type="password" name="member_pw" id="member_pw" class="m_b_16" placeholder="비밀번호를 입력해주세요">
                    <input type="text" name="member_name" id="member_name" class="m_b_16" placeholder="이름을 입력해주세요">
                    <input type="text" oninput="autoHyphen(this)" maxlength="13" name="member_mobile" id="member_mobile" class="m_b_16" placeholder="전화번호를 입력해주세요 (번호만 입력)">
                    <select name="member_gender" id="member_gender" class="m_b_16" onchange="changeGender(this)">
                        <option value="none">성별을 선택해주세요</option>
                        <option value="MALE" class="select" id="select">남자</option>
                        <option value="FEMALE" class="select" id="select">여자</option>
                    </select>
                    <input type="text" name="member_code" id="member_code" class="m_b_16" placeholder="회원인증 코드를 입력해주세요">
                    <button type="submit" class="signup_submit">회원가입</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    const autoHyphen = (target) => {
        target.value = target.value;
        target.value = target.value.replace(/[^0-9]/g, '');
        target.value = target.value.replace(/^(\d{2,3})(\d{3,4})(\d{4})$/, `$1-$2-$3`);
    }
    const changeGender = (target) => {
        const member_gender = document.getElementById('member_gender');
        if (target.value == 'MALE' || target.value == 'FEMALE') {
            member_gender.classList.add('select_on');
        } else {
            member_gender.classList.remove('select_on');
        }
    }
</script>
<?php
    }
?>