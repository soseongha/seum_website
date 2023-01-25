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
        <title>세움 다음세대 연구소 | 인사말</title>
        <meta name="keyword" content="세움 다음세대 연구소, 세움, 다음세대, 다음세대 연구소, 연구소, 메타버스, 소개, 인사말, seum, dusd, dusdlab, seumlab, metaverse, introduction, greetings">
        <meta name="description" content="세움 다음세대 연구소 인사말">
        <meta name="author" content="세움 다음세대 연구소">
        <meta property="og:type" content="website"> 
        <meta property="og:title" content="세움 다음세대 연구소">
        <meta property="og:description" content="세움 다음세대 연구소 인사말">
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
            <div id="greetings">
                <div class="nextLine"></div>
                <div id="box_of_2">
                    <div id="vision_img">
                        <img src="/image/greetings_image/greetings.png">
                    </div>
                    <div id="vision_p">
                        <p>코로나19 사태를 겪으며 우리는 타인과 마주하지 않고 어디까지 일상생활을 영위할 수 있는지, 그 가능성과 한계를 체감하였습니다. 이미 메타버스는 현실 세계의 일부가 된 것입니다. 일상에 없어서는 안 될 카카오톡, 네비게이션은 물론이며 에어비앤비, 배달의민족 또한 우리가 경험하고 있는 현실입니다. 그러므로 교회는 메타버스가 가져올 거대한 변화를 현실로 받아들여야만 합니다. 나아가 메타버스를 통해 역사하시는 하나님의 계획에 대해 질문해야 합니다.

                            초대교회 때 로마가 만들어 놓은 도로망과 항로는 세계 선교를 위한 하나님의 섭리였습니다. 20세기에 들어와 전기, 전화, 비행기, 라디오, 텔레비전, 의료용 백신, 인터넷과 같은 기술의 발전은 세계복음화의 주요 도구들이었습니다. 메타버스 역시 인간이 만든 것이지만, 다른 측면에서 보면 하나님의 섭리입니다. 지구촌의 모든 교회와 그리스도인이 메타버스 안에서 강하게 연결되면 지구촌 전체에 하나님 나라를 확장하게 될 것입니다. 

                            메타버스라는 파도에 올라타 사역을 확장해야 합니다.

                            메타버스 시대에 그리스도인들은 무엇을 준비해야 할까요? 
                            메타버스 시대에 다음세대를 위해 우리가 해야 할 일이 무엇일까요?
                            지역교회는 어떻게 이 변화에 대처해야 할까요? 
                            이러한 질문에 대답을 하고자 [세움 다음세대연구소]를 시작하게 되었습니다.

                            지구촌 선교와 다음세대를 위한 신앙 교육의 메타버스 사역은 예수님의 사역 방법과 다르지 않습니다. 우리는 그것을 실현해 나가고자 노력하고 있습니다.

                            세움 다음세대연구소 대표 박충권목사(수원 진흥교회 담임목사)
                        </p>
                    </div>
                </div>
                <div class="nextLine"></div>
            </div>
        </div>
        <?=$footer?>
    </body>
</html>