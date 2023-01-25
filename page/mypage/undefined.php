<?php
session_start();
require_once($_SERVER["DOCUMENT_ROOT"].'/template/footer.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/template/header.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/template/session.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>세움 다음세대 연구소 | 위치 및 문의</title>
        <meta name="keyword" content="세움 다음세대 연구소, 세움, 다음세대, 다음세대 연구소, 연구소, 메타버스, seum, dusd, dusdlab, seumlab, metaverse">
        <meta name="description" content="세움 다음세대 연구소 위치 및 문의">
        <meta name="author" content="세움 다음세대 연구소">
        <meta property="og:type" content="website"> 
        <meta property="og:title" content="세움 다음세대 연구소">
        <meta property="og:description" content="세움 다음세대 연구소 위치 및 문의">
        <meta property="og:image" content="image/icon/open_graph_image.png">
        <link rel="shortcut icon" href="/image/favicon/favicon.ico">
        <link rel="canonical" href="/page/mypage/undefined.php">
        <link rel="stylesheet" href="/style.css">
        <script src="/web.js"></script>

    </head>
    <body>
        <?=printLoginCode()?>
        <?=$header_elem1?>
        <?=$header_elem2?>
        <div id="content_box">
            <div id="question">
                <h3>위치 및 문의</h3>
            </div>
            <div id="question_grid">
                <div id="map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3175.188350584744!2d126.98831581515873!3d37.26696047985513!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x357b42e4bf066695%3A0xa977de9734c941b4!2z7KeE7Z2l6rWQ7ZqM!5e0!3m2!1sko!2skr!4v1649743224624!5m2!1sko!2skr" width="500" height="400" style="border:solid 1px rgba(128,128,128,0.5);" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <div id="inquiry">
                    <h4>Address:<br>경기도 수원시 권선구 서둔동 44-1</h4>
                    <h4> E-mail:<br>dusdlab@gmail.com</h4>
                    <h4>후원계좌:<br>000000-00-000000</h4>
                </div>
            </div>
        </div>
        <?=$footer?>
    </body>
</html>