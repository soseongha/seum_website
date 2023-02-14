<?php
/*htaccess 등을 이용해서 접근 금지 처리할 것!!!*/
function db_connect(){

    $conn = mysqli_connect('localhost','server_name','password','server_name');/*실서버에서의 정보로 변경 요망!!!*/
    
    return $conn;
}


?>
