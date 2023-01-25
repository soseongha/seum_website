<?php
session_start();
require_once($_SERVER["DOCUMENT_ROOT"].'/template/db.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/template/footer.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/template/header.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/template/session.php');

/*권한 확인*/
if( !isset($_SESSION['isLogin']) || $_SESSION['isLogin'] == false){
    echo "<script>alert('로그인 상태가 아니어서 게시글을 수정할 수 없습니다.'); window.history.go(-1);</script>";
    exit;
}
if( !isset($_SESSION['id']) || !isset($_GET['type']) ){
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
    echo "<script>alert('접근 권한이 없습니다.'); window.history.go(-1);</script>";
    exit;
}

/*보안처리*/
$conn = db_connect();
if($conn == false){
    error_log(mysqli_error($conn));//서버의 logs/error라는 파일에 에러 상세정보가 저장됨
    echo "<script>alert('게시글 업데이트 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.'); window.history.go(-1);</script>";
    exit;
}
$escapedPostNum = mysqli_real_escape_string($conn, $_GET['id']);
$escapedType = mysqli_real_escape_string($conn, $_GET['type']);

/*db 연결해서 이 post의 정보 가져오기*/
$sql = 'SELECT * FROM post WHERE id='.$escapedPostNum.' LIMIT 1;';

$query = mysqli_query($conn, $sql);

if($query == false){
    error_log(mysqli_error($conn));
    echo "<script>alert('게시글 업데이트 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.'); window.history.go(-1);</script>";
    exit;
}
$post = mysqli_fetch_array($query);


/*저자 맞는지 확인*/
if( $_SESSION['id'] != $post['author'] ){
    echo "<script>alert('게시글의 저자가 아니므로 게시글을 수정할 수 없습니다.'); window.history.go(-1);</script>";
    exit;
}


/*권한이 qna_master, qna_member일 경우, 옵션과 썸네일 숨기기*/
$option_hide = '';
$link_hide = '';
$thumb_hide = '';
if( $authority == "qna_member" || $authority == "qna_master" ){
    $option_hide = 'class="hide"';
    $thumb_hide = 'class="hide"';
}

/*권한이 qna_master일 경우, '답변할 문의사항 선택' 표시하기*/
$select_options = '';
if( $authority == "qna_master" ){
    
    $link_hide = '';
    $sql = 'SELECT * FROM post WHERE type="'.$escapedType.'" AND option="q";';
    $query = mysqli_query($conn, $sql);
    while($one_post = mysqli_fetch_array($query)){
        $select_options .= '<option value="'.$one_post['id'].'">'.$one_post['title'].'</option>';
    }
    
}
else{
    $link_hide = 'class="hide"';
}

/*파일 불러오기*/
$sql = "SELECT * FROM post_file WHERE post_number={$escapedPostNum}";

$query = mysqli_query($conn, $sql);

$files = [];
while($one_file = mysqli_fetch_array($query)){
    $files[] = $one_file; 
}

/*파일들 표시하기*/
$thumb_code = '';
$image_code = '';
$attch_code = '';

$thumb_count = 0;
$image_count = 0;
$attch_count = 0;

$THUMB_TYPE = 1;
$IMAGE_TYPE = 2;
$ATTCH_TYPE = 3;


for($i = 0; $i < count($files); $i += 1){

    $detail_type = $files[$i]['detail_type'];
    $filteredFileName = htmlspecialchars($files[$i]['file_name']);
    if($detail_type == "thumbnail"){//썸네일이 있으면 썸네일 이름을 display
        $thumb_code .= '<p>'.$filteredFileName.'<button type="button" class="delete_bt" onclick="hideFile(event,'.$THUMB_TYPE.');">-삭제</button><input type="hidden" name="is_thumb_del"><input type="hidden" name="thumb_file_id" value='.$files[$i]['id'].'></p>';
        $thumb_code .= '<input type="file" style="display:none" id="thumbnail" name="thumbnail" accept="image/*" />';
        $thumb_count++;
    }
    else if($detail_type == "image"){

        $image_code .= '<p>'.$filteredFileName.'<button type="button" class="delete_bt" onclick="hideFile(event, '.$IMAGE_TYPE.');">-삭제</button><input type="hidden" name="is_img_del[]"><input type="hidden" name="img_file_id[]" value='.$files[$i]['id'].'></p>';
        $image_count++;
    }
    else if($detail_type == "attachment"){

        $attch_code .= '<p>'.$filteredFileName.'<button type="button" class="delete_bt" onclick="hideFile(event, '.$ATTCH_TYPE.');">-삭제</button><input type="hidden" name="is_attch_del[]"><input type="hidden" name="attch_file_id[]" value='.$files[$i]['id'].'></p>';
        $attch_count++;
    }
}

if( $thumb_count == 0 ){ //썸네일이 없으면 input[type=file]을 display
    $thumb_code .= '<input type="file" style="display:block" id="thumbnail" name="thumbnail" accept="image/*" />';
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>세움 다음세대 연구소 - 글 수정</title>
        <meta name="keyword" content="세움 다음세대 연구소, 세움, 다음세대, 다음세대 연구소, 연구소, 메타버스, seum, dusd, dusdlab, seumlab, metaverse">
        <meta name="description" content="세움 다음세대 연구소 글 수정">
        <meta name="author" content="세움 다음세대 연구소">
        <meta property="og:type" content="website"> 
        <meta property="og:title" content="세움 다음세대 연구소">
        <meta property="og:description" content="세움 다음세대 연구소 글 수정">
        <meta property="og:image" content="image/icon/open_graph_image.png">
        <link rel="canonical" href="/page/post/update.php?type=notice&id=1">
        <link rel="shortcut icon" href="/image/favicon/favicon.ico">
        <link rel="stylesheet" href="/style.css">
        <script src="/web.js"></script>
        <meta name="google-site-verification" content="T1vKL3WksJo27BVgDuzlvHAb04zyimVie51NVSuk5S0" />
    </head>
    <body>
        <?=printLoginCode()?>
        <?=$header_elem1?>
        <div id="content_box">
            <div id="write">
                <div class="nextLine"></div>
                <div class="nextLine"></div>
                <h4>게시글 작성</h4>
                <div class="nextLine"></div>
                <div id="write_area">
                    <form enctype="multipart/form-data" action="/process/update_process.php?type=<?=$escapedType?>&id=<?=$escapedPostNum?>" method="post">
                        <table>
                            <tr>
                                <td>제목</td>
                                <td class="essential">*</td>
                                <td>
                                    <textarea name="title" id="title" maxlength="100" required><?=htmlspecialchars($post['title'])?></textarea>
                                </td>
                            </tr>
                            <tr <?=$option_hide?>>
                                <td>옵션</td>
                                <td class="essential"></td>
                                <td>
                                    <input type="checkbox" id="top_fixed" name="option" value="top_fixed">
                                    <label for="top_fixed"></label>
                                    <label for="male">상단 고정</label>
                                </td>
                            </tr>
                            <tr <?=$link_hide?>>
                                <td>답변할 문의사항 선택</td>
                                <td class="essential">*</td>
                                <td>
                                    <select id ="q_select" name="q_select">
                                        <?=$select_options?>
                                    </select>
                                </td>
                            </tr>
                            <tr <?=$thumb_hide?>>
                                <td>썸네일</td>
                                <td class="essential"></td>
                                <td><?=$thumb_code?></td>
                            </tr>
                            <tr>
                                <td>텍스트 내용</td>
                                <td class="essential">*</td>
                                <td>
                                    <textarea name="text" id="text" required><?=htmlspecialchars($post['text'])?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>이미지 내용</td>
                                <td class="essential"></td>
                                <td>
                                    <?=$image_code?>
                                    <input type="hidden" name="img_origin_count" id="img_origin_count" value=<?=$image_count?>>
                                    <input type="file" name="image_0" accept="image/*" />
                                    <input type="hidden" name="img_file_count" id="img_hidden_count" value="0"/>
                                    <button type="button" id="image_add_bt">+추가</button>
                                </td>
                            </tr>
                            <tr>
                                <td>첨부 파일</td>
                                <td class="essential"></td>
                                <td>
                                    <?=$attch_code?>
                                    <input type="hidden" name="attch_origin_count" id="attch_origin_count" value=<?=$attch_count?>>
                                    <input type="file" name="attachment_0" />
                                    <input type="hidden" name="attachment_file_count" id="attachment_hidden_count" value="0">
                                    <button type="button" id="attachment_add_bt">+추가</button>
                                </td>
                            </tr>
                            
                        </table>
                        <div class="nextLine"></div>
                        <div class="nextLine"></div>
                        <input type="submit" value="게시">
                    </form>
                </div>
                <div class="nextLine"></div>
                <div class="nextLine"></div>
            </div>
        </div>
        <?=$footer?>
        <?php 

        /*표시할 정보 재가공*/
        if( strchr($post['option'],'t') ){
            echo "<script>document.getElementById('top_fixed').checked = true;</script>";
        }

        ?>
    </body>
</html>