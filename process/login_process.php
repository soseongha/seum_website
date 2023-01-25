<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/template/db.php');
/*세션 시작*/
session_start();

/*칸이 비어있다면 리다이렉션*/
if( empty($_POST['id']) || empty($_POST['password']) ){
    echo "<script>alert('아이디나 비밀번호가 비어있습니다.'); location.href='/page/certification/login.php';</script>";
    exit;
}

/*DB에서 가져온 정보*/
$conn = db_connect();
$escapedId = mysqli_real_escape_string($conn, $_POST['id']);
$escapedPwd = mysqli_real_escape_string($conn, $_POST['password']);
if($conn == false){
    error_log(mysqli_error($conn));//서버의 logs/error라는 파일에 에러 상세정보가 저장됨
    echo "<script>alert('연결 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.'); window.history.go(-1);</script>";
    exit;
}
$sql = "SELECT * FROM member WHERE id='{$escapedId}';";
$query = mysqli_query($conn, $sql);
if($query == false){
    echo "<script>alert('연결 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.'); window.history.go(-1);</script>";
    exit;
}
$member = mysqli_fetch_array($query);
if($member == NULL){
    echo "<script>alert('존재하지 않는 아이디입니다.'); window.history.go(-1);</script>";
    exit;
}
$memberPwd = $member['password'];

/*패스워드 맞는지 확인*/
if( password_verify($escapedPwd, $memberPwd) ){
    $_SESSION['id'] = $member['id'];
    $_SESSION['name'] = $member['name'];
    $_SESSION['isLogin'] = true;
    $_SESSION['authority'] = $member['authority'];

    /*타임스탬프(로그인 기록) 찍기*/
    $sql2 = "UPDATE member
            SET timestamp = NOW()
            WHERE id='{$member['id']}';
            ";
            
    $query2 = mysqli_query($conn, $sql2);
    if($query2 == false){
        error_log(mysqli_error($conn));
        echo "<script>alert('로그인 실패: 관리자에게 문의해주세요.'); window.history.go(-1);</script>";
        exit;
    }
    echo "<script>alert('로그인되었습니다.'); location.href='/index.php';</script>";
    exit;
}
else{
    echo "<script>alert('로그인 실패: 비밀번호를 확인하세요.'); window.history.go(-1);</script>";
    exit;
}

?>