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
        <title>세움 다음세대 연구소 | 연혁</title>
        <meta name="keyword" content="세움 다음세대 연구소, 세움, 다음세대, 다음세대 연구소, 연구소, 메타버스, 소개, 연혁, seum, dusd, dusdlab, seumlab, metaverse, introduction, history">
        <meta name="description" content="세움 다음세대 연구소 연혁">
        <meta name="author" content="세움 다음세대 연구소">
        <meta property="og:type" content="website"> 
        <meta property="og:title" content="세움 다음세대 연구소">
        <meta property="og:description" content="세움 다음세대 연구소 연혁">
        <meta property="og:image" content="image/icon/open_graph_image.png">
        <link rel="stylesheet" href="/style.css">
        <link rel="canonical" href="/page/introducyion/history.php">
        <link rel="shortcut icon" href="/image/favicon/favicon.ico">
        <script src="/web.js"></script>
    </head>
    <body>
        <?=printLoginCode()?>
        <?=$header_elem1?>
        <?=$header_elem2?>
        <div id="content_box">
            <div id="history">
                <div class="nextLine"></div>
                <img src="/image/history_image/history_image_1.png">
                <div class="nextLine"></div>
            </div>
        </div>
        <?=$footer?>
    </body>
</html>