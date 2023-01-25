<?php
session_start();
require_once($_SERVER["DOCUMENT_ROOT"].'/template/db.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/template/footer.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/template/header.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/template/session.php');

if( !isset($_SESSION['isLogin']) || $_SESSION['isLogin'] == false ){
    echo "<script>alert('로그인 후 이용 가능합니다.'); location.href = '/page/certification/login.php';</script>";
    exit;
}
else if( isset($_SESSION['isLogin']) && $_SESSION['isLogin'] == true ){
 
    $id = $_SESSION['id'];

    /*DB에 연결하기*/
    $conn = db_connect();
    if($conn == false){
        error_log(mysqli_error($conn));//서버의 logs/error라는 파일에 에러 상세정보가 저장됨
        echo "<script>alert('페이지 표시 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.'); window.history.go(-1);</script>";
        exit;
    }

    /*페이지네이션 준비*/
    $page_bt_code = '';

    $sql = 'SELECT COUNT(*) FROM post WHERE author="'.$id.'"';
    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_array($query);
    
    $LIST_SIZE = 10; //한 페이지에 들어갈 게시물 수
    $MORE_PAGE = 3; //양 옆으로 표시할 페이지 링크 수
    
    $page = isset($_GET['page'])? $_GET['page'] : 1;//현재 페이지
    $offset = ( $page - 1 ) * $LIST_SIZE; //읽기 시작할 게시물 순서
    $total_post = $result[0];//게시물의 전체 개수
    $total_page = ceil($total_post / $LIST_SIZE);//페이지의 전체 개수


    /*현재 페이지부터 하위 $MORE_PAGE개의 페이지 링크 생성*/
    for($i = 0 ; $i < $MORE_PAGE; $i++){

        $taget_pg = $page - $MORE_PAGE + $i;
        if($taget_pg > 0){

            $page_bt_code .= '<a href="/page/mypage/mypost.php?page='.$taget_pg.'">'.$taget_pg.'</a>';
        }
    }
    
    /*현재 페이지의 링크 생성*/
    $page_bt_code .= '<a href="/page/community/community.php?page='.$page.'">['.$page.']</a>';

    /*현재 페이지부터 상위 $MORE_PAGE개의 페이지 링크 생성*/
    for($i = 0 ; $i < $MORE_PAGE; $i++){

        $taget_pg = $page + $i + 1;
        if($taget_pg <= $total_page){

            $page_bt_code .= '<a href="/page/mypage/mypost.php?page='.$taget_pg.'">'.$taget_pg.'</a>';
        }
    }
    
}
else{
    echo "<script>alert('잘못된 접근입니다.'); location.href = '/page/certification/login.php';</script>";
    exit;
}
  
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>세움 다음세대 연구소 | 내가 쓴 글</title>
        <meta name="keyword" content="세움 다음세대 연구소, 세움, 다음세대, 다음세대 연구소, 연구소, 메타버스, 내가 쓴 글, seum, dusd, dusdlab, seumlab, metaverse, mypost, post">
        <meta name="description" content="세움 다음세대 연구소 내가 쓴 글">
        <meta name="author" content="세움 다음세대 연구소">
        <meta property="og:type" content="website"> 
        <meta property="og:title" content="세움 다음세대 연구소">
        <meta property="og:description" content="세움 다음세대 연구소 내가 쓴 글">
        <meta property="og:image" content="image/icon/open_graph_image.png">
        <link rel="stylesheet" href="/style.css">
        <link rel="canonical" href="/page/mypage/mypost.php">
        <link rel="shortcut icon" href="/image/favicon/favicon.ico">
        <script src="/web.js"></script>

    </head>
    <body>
        <?=printLoginCode()?>
        <?=$header_elem1?>
        <?=$header_elem2?>
        <div id="content_box">
            <div id="mypage">
                <div class="nextLine"></div>
                <div id="flex_box">
                    <div id="mypage_nav">
                        <ul>
                            <li><a href="/page/mypage/myprivacy.php">개인정보 관리</a></li>
                            <li><a href="/page/mypage/mypost.php">내가 쓴 글</a></li>
                        </ul>
                    </div>
                    <div id="mypage_main">
                        <div id="mypost_show">
                            <h2>■ 내가 쓴 글</h2>
                            <div class="pg_dt_box">
                                <table id="post_table">
                                    <thead>
                                        <tr>
                                            <th width="70">번호</th>  
                                            <th width="100">타입</th>  
                                            <th width="500">제목</th>   
                                            <th width="120">작성자</th>   
                                            <th width="200">작성일</th>   
                                            <th width="100">조회수</th>   
                                        </tr>
                                    </thead>
                                        <?php

                                        /*sql문 작성하기(10개의 post 불러오기)*/
                                        $sql = 'SELECT * FROM post WHERE author="'.$id.'" LIMIT '.$offset.', '.$LIST_SIZE.';';

                                        /*DB와 통신하기*/
                                        $query = mysqli_query($conn, $sql);
                                        $order = $offset + 0;
                                        while($one_post = mysqli_fetch_array($query)){
                        
                                            $order++;
                                            //title변수에 DB에서 가져온 title을 선택
                                            $title = htmlspecialchars($one_post["title"]);
                                            if(strlen($title)>30)
                                            {
                                                //title이 30을 넘어서면 ...표시
                                                $title=str_replace($one_post["title"],mb_substr($one_post["title"],0,30,"utf-8")."...",$one_post["title"]);
                                            }

                                        ?>
                                    <tbody>
                                        <tr>
                                            <td width="70"><?=$order?></td>
                                            <td width="100"><?=$one_post['type']?></td>
                                            <td id="td_title" width="500"><a href="/page/post/show.php?type=<?=$one_post['type']?>&id=<?=$one_post['id']?>"><?=$title?></a></td>
                                            <td width="120"><?=$one_post['author']?></td>
                                            <td width="200"><?=$one_post['created']?></td>
                                            <td width="100"><?=$one_post['view']?></td>
                                        </tr>
                                    </tbody>
                                    <?php } ?>
                                </table>
                                <div id="page_bt">
                                    <?=$page_bt_code?>
                                </div>
                            </div>      
                        </div>          
                    </div>
                </div>  
                <div class="nextLine"></div>
            </div>
        </div>
        <?=$footer?>
        <script>UpdtStrtButton.initUpdtStrtButton();</script>
        <!-- PostSearchButton에 필요한 API호출(다음 우편번호 서비스) -->
        <script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
    </body>
</html>