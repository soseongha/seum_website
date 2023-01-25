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
        <title>세움 다음세대 연구소 | 연구소 개요</title>
        <meta name="keyword" content="세움 다음세대 연구소, 세움, 다음세대, 다음세대 연구소, 연구소, 메타버스, 소개, 개요, seum, dusd, dusdlab, seumlab, metaverse, introduction, overview">
        <meta name="description" content="세움 다음세대 연구소 개요">
        <meta name="author" content="세움 다음세대 연구소">
        <meta property="og:type" content="website"> 
        <meta property="og:title" content="세움 다음세대 연구소">
        <meta property="og:description" content="세움 다음세대 연구소 개요">
        <meta property="og:image" content="image/icon/open_graph_image.png">
        <link rel="stylesheet" href="/style.css">
        <link rel="canonical" href="/page/introducyion/greetings.php">
        <link rel="shortcut icon" href="/image/favicon/favicon.ico">
        <script src="/web.js"></script>
    </head>
    <body>
        <?=printLoginCode()?>
        <?=$header_elem1?>
        <?=$header_elem2?>
        <div id="content_box">
            <div id="introduction">
                <div class="nextLine"></div>

                <div class="section">
                    <input type="radio" name="slide" id="slide01" checked>
                    <input type="radio" name="slide" id="slide02">
                    <input type="radio" name="slide" id="slide03">
                    <div class="slidewrap">
                        
                        <ul class="slidelist">
                            <!-- 슬라이드 영역 -->
                            <li class="slideitem">
                                <a>
                                    <img src="/image/intro_image/intro_1.jpg">
                                </a>
                            </li>
                            <li class="slideitem">
                                <a>
                                    <img src="/image/intro_image/intro_2.jpg">
                                </a>
                            </li>
                            <li class="slideitem">
                                <a>
                                    <img src="/image/intro_image/intro_3.jpg">
                                </a>
                            </li class="slideitem">

                            <!-- 좌,우 슬라이드 버튼 -->
                            <div class="slide-control">
                                <div>
                                    <label for="slide03" class="left"></label>
                                    <label for="slide02" class="right"></label>
                                </div>
                                <div>
                                    <label for="slide01" class="left"></label>
                                    <label for="slide03" class="right"></label>
                                </div>
                                <div>
                                    <label for="slide02" class="left"></label>
                                    <label for="slide01" class="right"></label>
                                </div>
                            </div>

                        </ul>
                        <!-- 페이징 -->
                        <ul class="slide-pagelist">
                            <li><label for="slide01"></label></li>
                            <li><label for="slide02"></label></li>
                            <li><label for="slide03"></label></li>
                        </ul>
                    </div>
                </div>
                <div class="nextLine"></div>
                <div class="nextLine"></div>
            </div>
        </div>
        <?=$footer?>
    </body>
</html>