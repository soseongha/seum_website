<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/template/db.php');

/*세션 시작*/
session_start();

/*권한 확인*/
if( !isset($_GET['type']) ){
    echo "<script>alert('잘못된 접근입니다.'); window.history.go(-1);</script>";
    exit;
}

$authority = ""; 
if( $_GET['type'] != "qna" && isset($_SESSION['isLogin']) && $_SESSION['isLogin'] == true && isset($_SESSION['authority']) && $_SESSION['authority'] == "master" ){
    $authority = "master"; 
}
else if( $_GET['type'] == "qna" && isset($_SESSION['isLogin']) && $_SESSION['isLogin'] == true && isset($_SESSION['authority']) && $_SESSION['authority'] == "member" ){
    $authority = "qna_member"; 
}
else if( $_GET['type'] == "qna" && isset($_SESSION['isLogin']) && $_SESSION['isLogin'] == true && isset($_SESSION['authority']) && $_SESSION['authority'] == "master" ){
    $authority = "qna_master"; 
}
else{
    echo "<script>alert('접근 권한이 없습니다.'); location.href='/index.php';</script>";
    exit;
}

/*DB에 연결하기*/
$conn = db_connect();
if($conn == false){
    error_log(mysqli_error($conn));//서버의 logs/error라는 파일에 에러 상세정보가 저장됨
    echo "<script>alert('게시글 수정  과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.'); window.history.go(-1);</script>";
    exit;
}

/*보안처리*/
$escapedType = mysqli_real_escape_string($conn, $_GET['type']);

/*post TABLE에 넣을 정보 가공*/
$escapedTitle = mysqli_real_escape_string($conn, $_POST['title']);
$option = '';
if($authority == "qna_master"){
    $option .= 'a';
}
else if($authority == "qna_member"){
    $option .= 'q';
}
else{
    if(isset($_POST['option'])){
        if(strstr($_POST['option'],'top_fixed')){
            $option .= 't';
        }
    }
}
$link = -1;
if($authority == "qna_master"){
    $link = mysqli_real_escape_string($conn, $_POST['q_select']);
}
$escapedText =  mysqli_real_escape_string($conn, $_POST['text']);
$author = $_SESSION['id'];


/*sql문 작성하기*/
$sql = "INSERT INTO post (type, title, option, link, text, author, created) 
        VALUES(
            '{$escapedType}',    
            '{$escapedTitle}', 
            '{$option}', 
            {$link},
            '{$escapedText}', 
            '{$author}', 
            NOW()
            );
        ";

/*DB와 통신하기*/
$query = mysqli_query($conn, $sql);

if($query == false){
    error_log(mysqli_error($conn));
    echo "<script>alert('게시글 저장 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.'); location.href='/index.php';</script>";
    exit;
}
/*post TABLE에서 현재 게시물의 id값 가져오기*/
$cur_post_id = mysqli_insert_id($conn);

/*썸네일 파일 저장*/
if( $authority != "qna_master" && $authority != "qna_member" ){
    if(isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] != UPLOAD_ERR_NO_FILE){
        insert_file("thumbnail",$_FILES['thumbnail'], $cur_post_id);
    }
}
/*이미지 파일 저장*/
$img_file_count = (int)($_POST['img_file_count']);
for($i = 0; $i < $img_file_count + 1; $i++){

    $tmp_name = 'image_'.$i;
    if(isset($_FILES[$tmp_name]) && $_FILES[$tmp_name]['error'] != UPLOAD_ERR_NO_FILE){
        insert_file("image",$_FILES[$tmp_name], $cur_post_id);
    }
}

/*첨부 파일 저장*/
$attachment_file_count = (int)($_POST['attachment_file_count']);
for($i = 0; $i < $attachment_file_count + 1; $i++){
    $tmp_name = 'attachment_'.$i;
    if(isset($_FILES[$tmp_name]) && $_FILES[$tmp_name]['error'] != UPLOAD_ERR_NO_FILE){
        insert_file("attachment",$_FILES[$tmp_name], $cur_post_id);
    }
}
if($escapedType == "contents"){
    echo "<script>alert('게시글 저장이 완료되었습니다.'); location.href='/page/contents/contents.php';</script>";
}
else{
    echo "<script>alert('게시글 저장이 완료되었습니다.'); location.href='/page/community/community.php?type=$escapedType';</script>";
}

/*------------------------------------------------------------------------------------------------
- 이름      :get_uniq_filename()
- 파라미터  :파일의 이름 $fn, 파일 저장된 경로 $pn
- 반환값    :중복되지 않는 파일 이름 리턴
- 기능      :해당 디렉토리에 이 파일과 중복된 파일이 있다면, 중복되지 않는 이름을 찾아 리턴한다.
---------------------------------------------------------------------------------------------------*/
function get_uniq_filename($fn, $pn){
    $file_ext = substr(strrchr($fn, "."), 1); // 확장자 추출 
    $file_name = substr($fn, 0, strlen($fn) - strlen($file_ext) - 1); // 화일명 추출   
    $ret = "$file_name.$file_ext";
    $file_count = 0;
    while(file_exists($pn.$ret)) // 화일명이 중복되지 않을때 까지 반복  
    {
        $file_count++;
        $ret = $file_name."_".$file_count.".".$file_ext; // 화일명뒤에 (_1 ~ n)의 값을 붙여서....  
    }
        return($ret); // 중복되지 않는 화일명 리턴
}

/*------------------------------------------------------------------------------------------------
- 이름      :insert_file()
- 파라미터  :파일의 디테일 타입 $dtype, 파일의 포인터 $file, 파일의 주인인 게시글 번호 $post_number
- 반환값    :X
- 기능      :post_file TABLE에 file 하나를 저장하는 함수
---------------------------------------------------------------------------------------------------*/
function insert_file($dtype, $file, $post_number){

    
    /*파일 내 위치로 옮기기*/
    $uploaddir = $_SERVER["DOCUMENT_ROOT"].'/upload/file/';
    $uniq_filename = get_uniq_filename(basename($file['name']), $uploaddir);
    $uploadfile = $uploaddir.$uniq_filename;
 
    if (!move_uploaded_file($file['tmp_name'], $uploadfile)) {
    
        echo "<script>alert('파일 업로드 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.'); location.href='/index.php';</script>";
        exit;
    }

    /*DB에 연결하기*/
    $conn = db_connect();
    if($conn == false){
        error_log(mysqli_error($conn));
        echo "<script>alert('게시글 저장 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.'); location.href='/index.php';</script>";
        exit;
    }

    /*post_file TABLE에 넣을 정보 가공*/
    $detail_type = $dtype;
    $escaped_file_name = mysqli_real_escape_string($conn, $uniq_filename);
    $path = $uploadfile;

    /*sql문 작성하기*/
    $sql = "INSERT INTO post_file (post_number, detail_type, path, file_name) 
            VALUES(
                {$post_number},
                '{$detail_type}',
                '{$path}',
                '{$escaped_file_name}'
            );";

    /*DB와 통신하기*/
    $query = mysqli_query($conn, $sql);

    if($query == false){
        error_log(mysqli_error($conn));
        echo "<script>alert('게시글 저장 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.'); location.href='/index.php';</script>";
        exit;
    }
}

?>