<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/template/db.php');

/*세션 시작*/
session_start();

/*보안처리*/
$conn = db_connect();
if($conn == false){
    error_log(mysqli_error($conn));//서버의 logs/error라는 파일에 에러 상세정보가 저장됨
    echo "<script>alert('게시글 삭제 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.'); window.history.go(-1);</script>";
    exit;
}
$escapedPostNum = mysqli_real_escape_string($conn, $_GET['id']);


/*db 연결해서 이 post의 저자 정보 가져오기*/
$sql = 'SELECT author FROM post WHERE id='.$escapedPostNum.' LIMIT 1;';
$query = mysqli_query($conn, $sql);
if($query == false){
    error_log(mysqli_error($conn));
    echo "<script>alert('게시글 삭제 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.'); window.history.go(-1);</script>";
    exit;
}
$author = mysqli_fetch_array($query)['author'];


/*권한 확인*/
if( !isset($_SESSION['isLogin']) || $_SESSION['isLogin'] == false){
    echo "<script>alert('로그인 상태가 아니어서 게시글을 삭제할 수 없습니다.'); window.history.go(-1);</script>";
    exit;
}
if( !isset($author) || !isset($escapedPostNum) ){
    echo "<script>alert('잘못된 접근입니다.'); window.history.go(-1);</script>";
    exit;
}
if( $_SESSION['id'] != $author ){
    echo "<script>alert('게시글의 저자가 아니므로 게시글을 삭제할 수 없습니다.'); window.history.go(-1);</script>";
    exit;
}

/*게시글 삭제*/
$sql = 'DELETE FROM post WHERE id='.$escapedPostNum.' LIMIT 1;';
$query = mysqli_query($conn, $sql);
if($query == false){
    error_log(mysqli_error($conn));
    echo "<script>alert('게시글 삭제 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.'); window.history.go(-1);</script>";
    exit;
}

/*게시글 파일 삭제*/
$sql = 'SELECT file_name FROM post_file WHERE post_number='.$escapedPostNum.';';
$query = mysqli_query($conn, $sql);
$file_names = [];
$path = $_SERVER["DOCUMENT_ROOT"]."/upload/file/";

if($query == false){
    error_log(mysqli_error($conn));
    echo "<script>alert('게시글 삭제 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.'); window.history.go(-1);</script>";
    exit;
}

while($one_file = mysqli_fetch_array($query)){
    $file_names[] = $one_file;
}

for($i = 0 ; $i < count($file_names); $i++){
    unlink($path.$file_names[$i]['file_name']);
}

/*게시글 파일의 DB 정보 삭제*/
$sql = 'DELETE FROM post_file WHERE post_number='.$escapedPostNum.';';
$query = mysqli_query($conn, $sql);
if($query == false){
    error_log(mysqli_error($conn));
    echo "<script>alert('게시글 삭제 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.'); window.history.go(-1);</script>";
    exit;
}


/*게시글 전체 삭제 완료!*/
echo "<script>alert('게시글이 정상적으로 삭제되었습니다.'); location.href='/index.php';</script>";
exit;

?>