<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/template/db.php');
/*세션 시작*/
session_start();

/*DB 연결*/
$conn = db_connect();
if($conn == false){
    error_log(mysqli_error($conn));//서버의 logs/error라는 파일에 에러 상세정보가 저장됨
    echo "<script>alert('탈퇴 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.'); window.history.go(-1);</script>";
    exit;
}

/*보안처리*/
$escapedWidrlPwd = mysqli_real_escape_string($conn, $_POST['widrl_pwd']);

/*DB에서 현재 유저정보 가져오기*/
if($conn == false){
    error_log(mysqli_error($conn));//서버의 logs/error라는 파일에 에러 상세정보가 저장됨
    echo "<script>alert('탈퇴  과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.'); window.history.go(-1);</script>";
    exit;
}
$sql = "SELECT password FROM member WHERE id='{$_SESSION['id']}' LIMIT 1;";
$query = mysqli_query($conn, $sql);
if($query == false){
    echo "<script>alert('탈퇴  과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.'); window.history.go(-1);</script>";
    exit;
}
$result = mysqli_fetch_array($query);
$memberPwd = $result['password'];

/*칸이 비어있다면 리다이렉션*/
if( empty($_POST['widrl_pwd']) ){
    echo "<script>alert('입력칸이 비어있습니다.'); window.history.go(-1);</script>";
    exit;
}
/*현재 비밀번호가 틀렸으면 리다이렉션*/
else if( !password_verify($escapedWidrlPwd, $memberPwd) ){
    echo "<script>alert('현재 비밀번호가 일치하지 않습니다.'); window.history.go(-1);</script>";
    exit;
}

/*member table에서 정보 삭제*/
$sql = "DELETE FROM member WHERE id='{$_SESSION['id']}' LIMIT 1;";
$query = mysqli_query($conn, $sql);
if($query == false){
    echo "<script>alert('탈퇴  과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.'); window.history.go(-1);</script>";
    exit;
}

/*post table에서 정보 post id 가져오기*/
$sql = "SELECT id FROM post WHERE author='{$_SESSION['id']}';";
$query = mysqli_query($conn, $sql);
if($query == false){
    echo "<script>alert('탈퇴  과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.'); window.history.go(-1);</script>";
    exit;
}
$post_ids = [];
while($one_post_id = mysqli_fetch_array($query)){
    $post_ids[] = $one_post_id;
}

/*post table에서 정보 삭제*/
$sql = "DELETE FROM post WHERE author='{$_SESSION['id']}';";
$query = mysqli_query($conn, $sql);
if($query == false){
    echo "<script>alert('탈퇴  과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.'); window.history.go(-1);</script>";
    exit;
}

/*post_file table에서 정보 삭제*/
for($i = 0; isset($post_ids[$i]); $i++){
    $sql = "DELETE FROM post_file WHERE post_number={$post_ids[$i]['id']};";
    $query = mysqli_query($conn, $sql);
    if($query == false){
        echo "<script>alert('탈퇴  과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.'); window.history.go(-1);</script>";
        exit;
    }
}

/*세션 끝내기*/
session_destroy();

/*리다이렉션*/
echo "<script>alert('탈퇴가 정상적으로 완료되었습니다.'); location.href = '/index.php';</script>";
exit;
?>