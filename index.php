<?php
session_start();
require_once('template/db.php');
require_once('template/footer.php');
require_once('template/header.php');
require_once('template/session.php');

/*DB에 연결하기*/
$conn = db_connect();
if($conn == false){
    error_log(mysqli_error($conn));//서버의 logs/error라는 파일에 에러 상세정보가 저장됨
    echo "<script>alert('게시글 표시 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.'); location.href=index.php;</script>";
    exit;
}

/*sql문 작성하기(contents 타입의 post 불러오기)*/
$sql = 'SELECT post.id, title, file_name FROM post LEFT JOIN post_file  
    ON post.id = post_number WHERE type = "contents" AND detail_type = "thumbnail" 
    ORDER BY FIELD (option, "t", ""), post.created DESC;';

/*DB와 통신하기*/
$query = mysqli_query($conn, $sql);
if($query == false){
error_log(mysqli_error($conn));
echo "<script>alert('게시글 표시 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.'); location.href=index.php;</script>";
exit;
}
$posts = [];
while($one_post = mysqli_fetch_array($query)){
    $posts[] = $one_post;
}

/*--$figure_create를 생성--*/
$figure_create = "";
$i = 0;

$figure_create .= "<ol id='figure_ol'>";

while($i < count($posts)){

    $filtered_file_name = htmlspecialchars($posts[$i]['file_name']);
    $filtered_title = htmlspecialchars($posts[$i]["title"]);
    $figure_create .= 
    '<li>
        <a href="/page/post/show.php?id='.$posts[$i]['id'].'&type=contents">
            <div class="hover">
                <div class="card">
                    <figure>
                        <img src="/upload/file/'.$filtered_file_name.'">
                        <figcaption>'.$filtered_title.'</figcaption>
                    </figure>
                </div>
            </div>
        </a>
    </li>
    ';
    
    $i = $i + 1;
}

$figure_create .= "</ol>";

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>세움 다음세대 연구소</title>
        <link rel="stylesheet" href="/style.css">
        <script src="/web.js"></script>
        <link rel="canonical" href="/index.php">
        <link rel="shortcut icon" href="/image/favicon/favicon.ico">
        <meta name="keyword" content="세움 다음세대 연구소, 세움, 다음세대, 다음세대 연구소, 연구소, 메타버스, seum, dusd, dusdlab, seumlab, metaverse">
        <meta name="description" content="세움 다음세대 연구소 메인 페이지: 세움 다음세대 연구소는 다음세대를 위한 콘텐츠를 연구 및 제작합니다.">
        <meta name="author" content="세움 다음세대 연구소">
        <meta name="google-site-verification" content="T1vKL3WksJo27BVgDuzlvHAb04zyimVie51NVSuk5S0" />
        <meta property="og:type" content="website"> 
        <meta property="og:title" content="세움 다음세대 연구소">
        <meta property="og:description" content="세움 다음세대 연구소 메인 페이지">
        <meta property="og:image" content="image/icon/open_graph_image.png">
    </head>
    <body>
        <?=printLoginCode()?>
        <?=$header_elem1?>
        <?=$header_elem2?>
        <div id="content_box">
            <div id="index">
                <h1>세움 다음세대 연구소</h1>
                <h5>세움 다음세대 연구소는 다음세대를 위한 콘텐츠를 연구 및 제작합니다.</h5>
                <h4>(이미지를 클릭하시면 각 콘텐츠에 대한 내용을 확인하실 수 있습니다.)</h4>
                <div id="mansonry">
                    <?=$figure_create?>
                </div>
                <div class="nextLine"></div>
            </div>
        </div>
        <div id="popup_box">
        </div>
        <?=$footer?>
    </body>
</html>

'<li>
        <div class="popup">
            <div class="popup_layer"> <!--팝업창-->
                <div class="text_area"><!--텍스트 영역-->
                    <strong class="title">'.$title.'</strong>
                    <p class="text">'.$detail.'</p>
                </div>
                <div class="btn_area"><!--버튼 영역-->
                    <button type="button" name="button" class="btn" onclick="closePopup(event);">닫기</button>
                </div>
            </div>
            <div class="popup_dimmed"></div> <!--반투명 배경-->
        </div>
    </li>
    ';