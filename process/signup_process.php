<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/template/db.php');

/*세션 시작*/
session_start();
/*이용 약관, 개인정보에 동의하지 않았다면 리다이렉션*/
if( !isset($_POST['service_term']) || !isset($_POST['privacy_term']) || !($_POST['service_term'] == "checked" && $_POST['privacy_term'] == "checked") ){
    echo "<script>alert('이용 약관, 개인정보 동의서에 동의해주세요.');window.history.go(-1);window.history.go(-1);</script>";
    exit;
}
/*아이디 중복확인이 안되었다면 리다이렉션*/
else if( !isset($_POST['idcheck']) || $_POST['idcheck'] != "checked"){
    echo "<script>alert('아이디 중복 확인을 해주세요.');window.history.go(-1);window.history.go(-1);</script>";
    exit;
}
/*우편번호 찾기가 안되었다면 리다이렉션*/
else if( !isset($_POST['post_check']) || $_POST['post_check'] != "checked"){
    echo "<script>alert('우편번호 찾기를 해주세요.');window.history.go(-1);window.history.go(-1);</script>";
    exit;
}
/*상세정보 입력칸이 비어있다면 리다이렉션*/
else if( empty($_POST['password']) || empty($_POST['password_check']) || empty($_POST['name']) || empty($_POST['password_check']) || empty($_POST['gender']) || empty($_POST['phone_fir']) || empty($_POST['phone_mid']) || empty($_POST['phone_fin']) || empty($_POST['post_id']) || empty($_POST['auto_address']) || empty($_POST['email']) ){
    echo "<script>alert('필수 상세정보를 입력해주세요.'); window.history.go(-1);window.history.go(-1);</script>";
    exit;
}
/*아이디 유효성 검사*/
else if( !preg_match('/^[a-zA-Z]{1}[0-9a-zA-Z_]{3,19}$/',$_POST['id']) ){
    echo "<script>alert('아이디는 4글자 이상 20글자 이하의 알파벳, 숫자, 언더바(_)만으로 구성되어야 합니다.');window.history.go(-1);</script>";
    exit;
}
/*비밀번호 유효성 검사*/
else if($_POST['password'] != $_POST['password_check']){
    echo "<script>alert('비밀번호와 비밀번호 재입력이 일치하지 않습니다.');window.history.go(-1);</script>";
    exit;
}
else if( !preg_match('/(?=.*[a-zA-Z].*)(?=.*[0-9].*)(^[0-9a-zA-Z!@#$%^&+=]{8,20}$)/',$_POST['password']) ){
    echo "<script>alert('비밀번호는 8글자 이상 20글자 이하의 알파벳, 숫자, 특수문자(!@#$%^&+=\)만으로 구성되며, 알파벳과 숫자가 반드시 포함되어야 합니다.');window.history.go(-1);</script>";
    exit;
}
/*이름 유효성 검사*/
else if( !preg_match('/^[가-힣]{1,20}$/',$_POST['name']) ){
    echo "<script>alert('이름은 1글자 이상 20글자 이하의 한글로 작성되어야 합니다.');window.history.go(-1);</script>";
    exit;
}
/*휴대폰 번호 유효성 검사*/
else if( !preg_match('/^[0-9]{2,3}$/',$_POST['phone_fir']) ){
    echo "<script>alert('휴대폰 번호가 유효하지 않습니다.');window.history.go(-1);</script>";
    exit;
}
else if( !preg_match('/^[0-9]{3,4}$/',$_POST['phone_mid']) ){
    echo "<script>alert('휴대폰 번호가 유효하지 않습니다.');window.history.go(-1);</script>";
    exit;
}
else if( !preg_match('/^[0-9]{4}$/',$_POST['phone_fin']) ){
    echo "<script>alert('휴대폰 번호가 유효하지 않습니다.');window.history.go(-1);</script>";
    exit;
}
/*상세주소 유효성 검사*/
else if( !empty($_POST['detail_address']) ){ 
    if( !preg_match('/^[0-9a-zA-Z가-힣~!@#$%^&+=\(\),.\-_ ]{1,50}$/',$_POST['detail_address']) ){
        echo "<script>alert('상세주소가 유효하지 않습니다. 50글자 이상이거나, 유효하지 않은 특수기호가 있습니다.');window.history.go(-1);</script>";
        exit;
    }
}
/*이메일 유효성 검사*/
else if ( !preg_match('/^[0-9a-zA-Z_-]+$/',$_POST['email']) ){
    echo "<script>alert('이메일의 앞부분이 유효하지 않습니다. 알파벳, -(하이픈), _(언더바)로 구성되었는지 확인하세요.');window.history.go(-1);</script>";
    exit;
}
else if($_POST['emadress'] == 'direct'){

    if( !preg_match('/^([0-9a-zA-Z_-]+)(\.[0-9a-zA-Z_-]+){1,2}$/', $_POST['direct_input']) ){
        echo "<script>alert('이메일의 도메인 부분이 유효하지 않습니다.');window.history.go(-1);</script>";
        exit;
    }

}



/*DB에 연결하기*/
$conn = db_connect();
if($conn == false){
    error_log(mysqli_error($conn));//서버의 logs/error라는 파일에 에러 상세정보가 저장됨
    echo "<script>alert('회원가입 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.'); window.history.go(-1);</script>";
    exit;
}

/*보안처리*/
$escapedId = mysqli_real_escape_string($conn, $_POST['id']);
$escapedPwd = mysqli_real_escape_string($conn, $_POST['password']);
$escapedName = mysqli_real_escape_string($conn, $_POST['name']);
$escapedPhoneFir = mysqli_real_escape_string($conn, $_POST['phone_fir']);
$escapedPhoneMid = mysqli_real_escape_string($conn, $_POST['phone_mid']);
$escapedPhoneFin = mysqli_real_escape_string($conn, $_POST['phone_fin']);
$escapedPostId = mysqli_real_escape_string($conn, $_POST['post_id']);
$escapedAutoAddress = mysqli_real_escape_string($conn, $_POST['auto_address']);

/*gender와 phone, email, address 정보 재가공*/
$gender = ($_POST['gender'] == 'female')? 1:0; /*여자: 1 남자:0*/
$escapedPhone = $escapedPhoneFir.'-'.$escapedPhoneMid.'-'.$escapedPhoneFin;
$escapedEmail = "";

if($_POST['emadress'] == 'direct'){
    $escapedEmail = mysqli_real_escape_string($conn, $_POST['email']."@".$_POST['direct_input']);
}
else{
    $escapedEmail = mysqli_real_escape_string($conn, $_POST['email']."@".$_POST['emadress']);
}

$escapedDetailAddress = "";
if( !empty($_POST['detail_address']) ){
    $escapedDetailAddress = mysqli_real_escape_string($conn, $_POST['detail_address']);
}

/*비밀번호 암호화*/
$encryptPwd = password_hash($escapedPwd,PASSWORD_DEFAULT);

/*sql문 작성하기*/
$sql = "INSERT INTO member (id, password, name, gender, phone, post_id, auto_address, detail_address, email, created, timestamp) 
        VALUES(
            '{$escapedId}',    
            '{$encryptPwd}', 
            '{$escapedName}', 
            {$gender}, 
            '{$escapedPhone}',
            '{$escapedPostId}',
            '{$escapedAutoAddress}',
            '{$escapedDetailAddress}', 
            '{$escapedEmail}',
            NOW(),
            NOW()
            );
        ";
/*DB와 통신하기*/
$query = mysqli_query($conn, $sql);
if($query == false){
    error_log(mysqli_error($conn));
    echo "<script>alert('회원가입 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.'); window.history.go(-1);</script>";
    exit;
}
else{
    echo "<script>alert('회원가입이 완료되었습니다.'); location.href='/index.php';</script>";
}

?>