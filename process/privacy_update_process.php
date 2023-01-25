<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/template/db.php');

/*세션 시작*/
session_start();
/*우편번호 찾기가 안되었다면 리다이렉션*/
if( !isset($_POST['post_check']) || $_POST['post_check'] != "checked"){
    echo "<script>alert('우편번호 찾기를 해주세요.');window.history.go(-1);</script>";
    exit;
}
/*상세정보 입력칸이 비어있다면 리다이렉션*/
else if( empty($_POST['phone_fir']) ||  empty($_POST['phone_mid']) ||  empty($_POST['phone_fin']) || empty($_POST['post_id']) || empty($_POST['auto_address']) || empty($_POST['email_front']) || empty($_POST['email_back']) ){
    echo "<script>alert('필수 상세정보를 입력해주세요.'); window.history.go(-1);window.history.go(-1);</script>";
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
    if( !preg_match('/^[0-9a-zA-Z가-힣!@#$%^&+=\(\),.\-_ ]{1,50}$/',$_POST['detail_address']) ){
        echo "<script>alert('상세주소가 유효하지 않습니다. 50글자 이상이거나, 유효하지 않은 특수기호가 있습니다.');window.history.go(-1);</script>";
        exit;
    }
}
/*이메일 유효성 검사*/
else if ( !preg_match('/^[0-9a-zA-Z_-]+$/',$_POST['email_front']) ){
    echo "<script>alert('이메일의 앞부분이 유효하지 않습니다. 알파벳, -(하이픈), _(언더바)로 구성되었는지 확인하세요.');window.history.go(-1);</script>";
    exit;
}
else if( !preg_match('/^([0-9a-zA-Z_-]+)(\.[0-9a-zA-Z_-]+){1,2}$/', $_POST['email_back']) ){
    echo "<script>alert('이메일의 도메인 부분이 유효하지 않습니다.');window.history.go(-1);</script>";
    exit;
}

/*DB에 연결하기*/
$conn = db_connect();
if($conn == false){
    error_log(mysqli_error($conn));//서버의 logs/error라는 파일에 에러 상세정보가 저장됨
    echo "<script>alert('개인정보 저장 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.'); window.history.go(-1);</script>";
    exit;
}

/*보안처리*/
$escapedPhoneFir = mysqli_real_escape_string($conn, $_POST['phone_fir']);
$escapedPhoneMid = mysqli_real_escape_string($conn, $_POST['phone_mid']);
$escapedPhoneFin = mysqli_real_escape_string($conn, $_POST['phone_fin']);
$escapedPostId = mysqli_real_escape_string($conn, $_POST['post_id']);
$escapedAutoAddress = mysqli_real_escape_string($conn, $_POST['auto_address']);
$escapedEmailFront = mysqli_real_escape_string($conn, $_POST['email_front']);
$escapedEmailBack = mysqli_real_escape_string($conn, $_POST['email_back']);

/*phone, email, address 정보 재가공*/
$escapedPhone = $escapedPhoneFir.'-'.$escapedPhoneMid.'-'.$escapedPhoneFin;
$escapedEmail = "";
$escapedEmail = $escapedEmailFront."@".$escapedEmailBack;

$escapedDetailAddress = "";
if( !empty($_POST['detail_address']) ){
    $escapedDetailAddress = mysqli_real_escape_string($conn, $_POST['detail_address']);
}

/*sql문 작성하기*/
$sql = "UPDATE member
        SET 
        phone='{$escapedPhone}', 
        post_id='{$escapedPostId}', 
        auto_address='{$escapedAutoAddress}', 
        detail_address='{$escapedDetailAddress}', 
        email='{$escapedEmail}'
        WHERE id='{$_SESSION['id']}';
        ";
        
/*DB와 통신하기*/
$query = mysqli_query($conn, $sql);
if($query == false){
    error_log(mysqli_error($conn));
    echo "<script>alert('개인정보 저장 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.'); window.history.go(-1);</script>";
    exit;
}
else{
    echo "<script>alert('개인정보 저장이 완료되었습니다.'); window.history.go(-1);</script>";
}

?>