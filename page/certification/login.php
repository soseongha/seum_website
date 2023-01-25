<?php
session_start();
require_once($_SERVER["DOCUMENT_ROOT"].'/template/footer.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/template/header.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/template/session.php');

if(isset($_SESSION['isLogin']) && $_SESSION['isLogin'] == true){
    echo "<script>alert('이미 로그인 상태입니다.'); location.href = '/index.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>세움 다음세대 연구소 | 로그인</title>
        <meta name="keyword" content="세움 다음세대 연구소, 세움, 다음세대, 다음세대 연구소, 연구소, 메타버스, 로그인, seum, dusd, dusdlab, seumlab, metaverse, login">
        <meta name="description" content="세움 다음세대 연구소 로그인">
        <meta name="author" content="세움 다음세대 연구소">
        <link rel="stylesheet" href="/style.css">
        <link rel="canonical" href="/page/certification/login.php">
        <link rel="shortcut icon" href="/image/favicon/favicon.ico">
        <script src="/web.js"></script>
        <meta name="google-site-verification" content="T1vKL3WksJo27BVgDuzlvHAb04zyimVie51NVSuk5S0" />
        <meta property="og:type" content="website"> 
        <meta property="og:title" content="세움 다음세대 연구소">
        <meta property="og:description" content="세움 다음세대 연구소 로그인">
        <meta property="og:image" content="image/icon/open_graph_image.png">
    </head>
    <body>
        <?=printLoginCode()?>
        <?=$header_elem1?>
        <div id="content_box">
            <div class="nextLine"></div>
            <div id="login">
                <h4>[로그인]</h4>
                <form name="login" action="/process/login_process.php" method="post" autocomplete="off">
                <p><input type="text" name="id" placeholder="아이디"></p>
                <p><input type="password" name="password" placeholder="비밀번호"></p>
                <p><input type="submit" value="로그인"></p>
                </form>
            </div>
            <div id="signup_link">
                <p>아직 회원이 아니라면?</p>
                <p><a href="/page/certification//signup.php">회원가입하기</a></p>
            </div>
            <div class="nextLine"></div>
        </div>
        <?=$footer?>
    </body>
</html>