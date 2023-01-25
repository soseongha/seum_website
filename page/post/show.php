<?php
session_start();
require_once($_SERVER["DOCUMENT_ROOT"].'/template/autolink.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/template/db.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/template/footer.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/template/header.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/template/session.php');

/*파라미터 확인*/
if(!isset($_GET['id'])){
    echo "<script>alert('잘못된 접근입니다.'); location.href='/index.php'</script>";
}
if(!isset($_GET['type'])){
    echo "<script>alert('잘못된 접근입니다.'); location.href='/index.php'</script>";
}

/*보안처리*/
$conn = db_connect();
if($conn == false){
    error_log(mysqli_error($conn));//서버의 logs/error라는 파일에 에러 상세정보가 저장됨
    echo "<script>alert('게시글 표시 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.'); window.history.go(-1);</script>";
    exit;
}
$escapedId = mysqli_real_escape_string($conn, $_GET['id']);
$escapedType = mysqli_real_escape_string($conn, $_GET['type']);

/*단어 조정*/
$type_word = '';
$path_type = '';
switch($escapedType){
    case "contents":
        $type_word = "콘텐츠";
        $path_type = "contents";
        break;
    case "notice":
        $type_word = "공지사항";
        $path_type = "community";
        break;
    case "reference":
        $type_word = "자료실";
        $path_type = "community";
        break;
    case "qna":
        $type_word = "문의사항";
        $path_type = "community";
        break;
    case "faq":
        $type_word = "FAQ";
        $path_type = "community";
        break;
    default:
        echo "<script>alert('잘못된 접근입니다.'); location.href='/index.php'</script>";
}

/*sql문 작성하기(조회수 올리기)*/
$sql = "UPDATE post SET view=view+1 WHERE id={$escapedId};";
$query = mysqli_query($conn, $sql);

/*sql문 작성하기(post 불러오기)*/
$sql = "SELECT * FROM post WHERE id={$escapedId};";

/*DB와 통신하기*/
$query = mysqli_query($conn, $sql);
$post = mysqli_fetch_array($query);

if($post == NULL){
    error_log(mysqli_error($conn));
    echo "<script>alert('게시글이 존재하지 않습니다.'); location.href='/index.php';</script>";
}


/*sql문 작성하기(post_file 불러오기)*/
$sql = "SELECT * FROM post_file WHERE post_number={$escapedId}";

/*DB와 통신하기*/
$query = mysqli_query($conn, $sql);

$files = [];
while($one_file = mysqli_fetch_array($query)){
    $files[] = $one_file; 
}

/*이미지 파일, 첨부 파일 세팅하기*/
$image_code = '';
$attch_code = '';
for($i = 0; $i < count($files); $i += 1){

    $detail_type = $files[$i]['detail_type'];
    if($detail_type == "image"){

        $filteredFileName = htmlspecialchars($files[$i]['file_name']);
        $image_code .= '<p><img src="/upload/file/'.$filteredFileName.'"></p>';
    }
    else if($detail_type == "attachment"){

        $attch_code .= '<p><a href="/upload/file/'.$filteredFileName.'" download>'.$filteredFileName.'</a></p>';
    }
}

/*htmlspecialchars로 인해 사라진 링크, 자동으로 걸어주기*/
/*text에서 "\n"을 <br>로 치환해서 출력하기*/
$hasLinkText = autolink( htmlspecialchars($post['text']) );
$hasBrText = str_replace("\n", "<br>", $hasLinkText);

/*타입이 "콘텐츠"가 아니라면 이미지를 block 형식으로*/
$isBlock = "";
if($type_word != "콘텐츠"){
    $isBlock = 'class="image_block"';
}
else{
    $isBlock = 'class="image_grid"';
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>세움 다음세대 연구소 | <?=htmlspecialchars($post['title'])?></title>
        <meta name="keyword" content="세움 다음세대 연구소, 세움, 다음세대, 다음세대 연구소, 연구소, 메타버스, 게시글, seum, dusd, dusdlab, seumlab, metaverse, introduction, greetings, post">
        <meta name="description" content="세움 다음세대 연구소 게시글">
        <meta name="author" content="세움 다음세대 연구소">
        <meta property="og:type" content="website"> 
        <meta property="og:title" content="세움 다음세대 연구소">
        <meta property="og:description" content="세움 다음세대 연구소 게시글">
        <meta property="og:image" content="image/icon/open_graph_image.png">
        <link rel="canonical" href="/page/post/show.php?type=notice&id=1">
        <link rel="stylesheet" href="/style.css">
        <link rel="shortcut icon" href="/image/favicon/favicon.ico">
        <script src="/web.js"></script>
    </head>
    <body>
        <?=printLoginCode()?>
        <?=$header_elem1?>
        <?=$header_elem2?>
        <div id="content_box">
            <div id="type">
                <h1><a href="/page/<?=$path_type?>/<?=$path_type?>.php?type=<?=$escapedType?>"><?=$type_word?></a></h1>
            </div>
            <div id="show_box">
                <h2><?=htmlspecialchars($post['title'])?></h2>
                <div id="post_bar">
                    작성자: <?=$post['author']?>
                    조회수: <?=$post['view']?>
                    작성일: <?=$post['created']?>
                </div>
                <div id="updt_and_dlt">
                    <?=printUpdtDltPost($post['author'], $escapedId, $escapedType)?>
                </div>
                <div id="text_area">
                    <?=$hasBrText?>
                </div>
                <div id="image_show" <?=$isBlock?>>
                    <?=$image_code?>
                </div>
                <div id="attch_show">
                    [첨부파일]
                    <?=$attch_code?>
                </div>
            </div>
        </div>
        <?=$footer?>
    </body>
</html>