<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/template/db.php');

echo "<script>window.resizeTo(300,300);</script>";

/*보안처리*/
$conn = db_connect();
if($conn == false){
    error_log(mysqli_error($conn));//서버의 logs/error라는 파일에 에러 상세정보가 저장됨
    echo "연결 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.";
}
$escapedId = mysqli_real_escape_string($conn, $_GET['id']);

/*중복 아이디가 있는지 검사*/
$sql = "SELECT * FROM member WHERE id='{$escapedId}';";
$query = mysqli_query($conn, $sql);
$result = mysqli_fetch_array($query);
$specialId = htmlspecialchars($escapedId);

if($result == false){
    echo '<u style="color:red;">'.$specialId.'</u>는 사용 가능한 아이디입니다.';
    ?>
    <p><input type="button" value="확인" onclick="opener.parent.correct(); window.close();"></p>
    <?php
}
else{
    echo '<u style="color:red;">'.$specialId."</u>는 중복된 아이디입니다.";
    ?>
    <p><input type="button" value="확인" onclick="window.close();"></p>
    <?php
}

?>
