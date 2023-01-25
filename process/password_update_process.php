<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/template/db.php');
/*세션 시작*/
session_start();

/*DB 연결*/
$conn = db_connect();

/*보안처리*/
$escapedCurPwd = mysqli_real_escape_string($conn, $_POST['cur_pwd']);
$escapedNewPwd = mysqli_real_escape_string($conn, $_POST['new_pwd']);
$escapedCrctPwd = mysqli_real_escape_string($conn, $_POST['crct_pwd']);

/*DB에서 현재 유저정보 가져오기*/
if($conn == false){
    error_log(mysqli_error($conn));//서버의 logs/error라는 파일에 에러 상세정보가 저장됨
    echo "<script>alert('비밀번호 저장 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.'); window.history.go(-1);</script>";
    exit;
}
$sql = "SELECT password FROM member WHERE id='{$_SESSION['id']}' LIMIT 1;";
$query = mysqli_query($conn, $sql);
if($query == false){
    echo "<script>alert('비밀번호 저장 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.'); window.history.go(-1);</script>";
    exit;
}
$result = mysqli_fetch_array($query);
$memberPwd = $result['password'];

/*칸이 비어있다면 리다이렉션*/
if( empty($_POST['cur_pwd']) || empty($_POST['new_pwd']) || empty($_POST['crct_pwd']) ){
    echo "<script>alert('입력칸이 비어있습니다.'); window.history.go(-1);</script>";
    exit;
}
/*현재 비밀번호가 틀렸으면 리다이렉션*/
else if( !password_verify($escapedCurPwd, $memberPwd) ){
    echo "<script>alert('현재 비밀번호가 일치하지 않습니다.'); window.history.go(-1);</script>";
    exit;
}
/*새 비밀번호와 새 비밀번호 확인이 다르면 리다이렉션*/
else if( $escapedNewPwd != $escapedCrctPwd ){
    echo "<script>alert('새 비밀번호와 새 비밀번호 확인이 일치하지 않습니다.'); window.history.go(-1);</script>";
    exit;
}
/*새 비밀번호가 유효하지 않으면 리다이렉션*/
else if( !preg_match('/(?=.*[a-zA-Z].*)(?=.*[0-9].*)(^[0-9a-zA-Z!@#$%^&+=]{8,20}$)/',$escapedNewPwd) ){
    echo "<script>alert('새 비밀번호가 유효하지 않습니다. 조건을 준수하여 다시 작성해주세요.'); window.history.go(-1);</script>";
    exit;
}

/*비밀번호 암호화*/
$encryptPwd = password_hash($escapedNewPwd,PASSWORD_DEFAULT);

/*새로운 비밀번호 DB에 저장하기*/
$sql = "UPDATE member
        SET 
        password='{$encryptPwd}' 
        WHERE id='{$_SESSION['id']}';
        ";
$query = mysqli_query($conn, $sql);
if($query == false){
    echo "<script>alert('비밀번호 저장 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.'); window.history.go(-1);</script>";
    exit;
}
else{
    echo "<script>alert('새 비밀번호가 저장되었습니다.'); window.history.go(-1);</script>";
    exit;
}

?>