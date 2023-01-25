<?php
session_start();
require_once($_SERVER["DOCUMENT_ROOT"].'/template/db.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/template/footer.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/template/header.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/template/session.php');

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
    echo "<script>alert('접근 권한이 없습니다.'); window.history.go(-1);</script>";
    exit;
}

/*보안처리*/
$conn = db_connect();
if($conn == false){
    error_log(mysqli_error($conn));//서버의 logs/error라는 파일에 에러 상세정보가 저장됨
    echo "<script>alert('페이지 표시 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.'); window.history.go(-1);</script>";
    exit;
}
$escapedType = mysqli_real_escape_string($conn, $_GET['type']);


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

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>세움 다음세대 연구소 | 글 작성</title>
        <meta name="keyword" content="세움 다음세대 연구소, 세움, 다음세대, 다음세대 연구소, 연구소, 메타버스, seum, dusd, dusdlab, seumlab, metaverse">
        <meta name="description" content="세움 다음세대 연구소 글 작성">
        <meta name="author" content="세움 다음세대 연구소">
        <meta property="og:type" content="website"> 
        <meta property="og:title" content="세움 다음세대 연구소">
        <meta property="og:description" content="세움 다음세대 연구소 글 작성">
        <meta property="og:image" content="image/icon/open_graph_image.png">
        <link rel="canonical" href="/page/post/write.php?type=notice">
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
                    <form enctype="multipart/form-data" action="/process/write_process.php?type=<?=$escapedType?>" method="post">
                        <table>
                            <tr>
                                <td>제목</td>
                                <td class="essential">*</td>
                                <td>
                                    <textarea name="title" id="title" maxlength="100" required></textarea>
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
                                <td><input type="file" name="thumbnail" accept="image/*" /></td>
                            </tr>
                            <tr>
                                <td>텍스트 내용</td>
                                <td class="essential">*</td>
                                <td>
                                    <textarea name="text" id="text" required></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>이미지 내용</td>
                                <td class="essential"></td>
                                <td>
                                    <input type="file" name="image_0" accept="image/*" />
                                    <input type="hidden" name="img_file_count" id="img_hidden_count" value="0"/>
                                    <button type="button" id="image_add_bt">+추가</button>
                                </td>
                            </tr>
                            <tr>
                                <td>첨부 파일</td>
                                <td class="essential"></td>
                                <td>
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
    </body>
</html>