<?php
/*세션 시작하기*/
session_start();

/*세션 끝내기*/
$return = session_destroy();

/*리다이렉션*/
if( $return ){
    echo "<script>alert('성공적으로 로그아웃 했습니다.'); location.href = '/index.php';</script>";
    exit;
}
else{
    echo "<script>alert('[실패] 로그아웃에 실패했습니다.'); location.href = '/index.php';</script>";
    exit;
}
?>
