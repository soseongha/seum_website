<?php
session_start();
require_once($_SERVER["DOCUMENT_ROOT"].'/template/db.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/template/footer.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/template/header.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/template/session.php');

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>세움 다음세대 연구소 | 콘텐츠</title>
        <meta name="keyword" content="세움 다음세대 연구소, 세움, 다음세대, 다음세대 연구소, 연구소, 메타버스, 콘텐츠, seum, dusd, dusdlab, seumlab, metaverse, contents">
        <meta name="description" content="세움 다음세대 연구소 콘텐츠">
        <meta name="author" content="세움 다음세대 연구소">
        <meta property="og:type" content="website"> 
        <meta property="og:title" content="세움 다음세대 연구소">
        <meta property="og:description" content="세움 다음세대 연구소 콘텐츠">
        <meta property="og:image" content="image/icon/open_graph_image.png">
        <link rel="canonical" href="/page/contents/contents.php">
        <link rel="stylesheet" href="/style.css">
        <link rel="shortcut icon" href="/image/favicon/favicon.ico">
        <script src="/web.js"></script>
    </head>
    <body>
        <?=printLoginCode()?>
        <?=$header_elem1?>
        <?=$header_elem2?>
        <div id="content_box">
            <div id="contents">
                <div class="nextLine"></div>
                <div id="contents_title">
                    <h1><a href="/page/contents/contents.php">콘텐츠</a></h1>
                </div>
                <div class="nextLine"></div>
                <ul id="contents_list">
                    <?php

                    /*DB에 연결하기*/
                    $conn = db_connect();
                    if($conn == false){
                        error_log(mysqli_error($conn));//서버의 logs/error라는 파일에 에러 상세정보가 저장됨
                        echo "<script>alert('게시글 표시 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.'); window.history.go(-1);</script>";
                        exit;
                    }

                    /*페이지네이션 준비*/
                    $page_bt_code = '';

                    $sql = 'SELECT COUNT(*) FROM post WHERE type="contents"';
                    $query = mysqli_query($conn, $sql);
                    $result = mysqli_fetch_array($query);
                    
                    $LIST_SIZE = 9; //한 페이지에 들어갈 게시물 수
                    $MORE_PAGE = 3; //양 옆으로 표시할 페이지 링크 수
                    
                    $page = isset($_GET['page'])? $_GET['page'] : 1;//현재 페이지
                    $offset = ( $page - 1 ) * $LIST_SIZE; //읽기 시작할 게시물 순서
                    $total_post = $result[0];//게시물의 전체 개수
                    $total_page = ceil($total_post / $LIST_SIZE);//페이지의 전체 개수


                    /*현재 페이지부터 하위 $MORE_PAGE개의 페이지 링크 생성*/
                    for($i = 0 ; $i < $MORE_PAGE; $i++){

                        $taget_pg = $page - $MORE_PAGE + $i;
                        if($taget_pg > 0){

                            $page_bt_code .= '<a href="/page/contents/contents.php?page='.$taget_pg.'">'.$taget_pg.'</a>';
                        }
                    }
                    
                    /*현재 페이지의 링크 생성*/
                    $page_bt_code .= '<a href="/page/contents/contents.php?page='.$page.'">['.$page.']</a>';
                
                    /*현재 페이지부터 상위 $MORE_PAGE개의 페이지 링크 생성*/
                    for($i = 0 ; $i < $MORE_PAGE; $i++){

                        $taget_pg = $page + $i + 1;
                        if($taget_pg <= $total_page){

                            $page_bt_code .= '<a href="/page/contents/contents.php?page='.$taget_pg.'">'.$taget_pg.'</a>';
                        }
                    }

                    

                    /*sql문 작성하기(10개의 post 불러오기)*/
                    $sql = 'SELECT id, type, title, option, author, created, view
                        FROM post WHERE type="contents" ORDER BY FIELD (option, "t", ""), created DESC LIMIT '.$offset.', '.$LIST_SIZE.';';

                    /*DB와 통신하기*/
                    $query1 = mysqli_query($conn, $sql);
                    if($query1 == false){
                        error_log(mysqli_error($conn));
                        echo "<script>alert('게시글 표시 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.'); window.history.go(-1);</script>";
                        exit;
                    }
                    $order = $offset + 0;

                    /*query 하나를 fetch하기를 반복한다.*/
                    while($one_post = mysqli_fetch_array($query1)){
    
                        $order++;
                        //title변수에 DB에서 가져온 title을 선택
                        $title = htmlspecialchars($one_post["title"]);
                        $title_cut = $title;
                        if(mb_strlen($title, 'utf-8')>25)
                        {
                            //title이 35을 넘어서면 ...표시
                            $title_cut=str_replace($title,mb_substr($title,0,25,"utf-8")."...",$title);
                        }
                     
                        /*썸네일이 있으면 표시*/
                        $sql = 'SELECT file_name
                        FROM post_file WHERE post_number='.$one_post['id'].' AND detail_type="thumbnail" LIMIT 1;';
                        $query2 = mysqli_query($conn, $sql);
                        if($query2 == false){
                            error_log(mysqli_error($conn));
                            echo "<script>alert('게시글 표시 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.'); window.history.go(-1);</script>";
                            exit;
                        }
                        $result =  mysqli_fetch_array($query2);

                        if($result == NULL){
                            $filtered_file_name = "basic.png";
                        }
                        else{
                            $file_name = $result['file_name'];
                            $filtered_file_name = htmlspecialchars($file_name);
                        }

                        $is_fixed = "";
                        /*상단 고정이라면*/
                        if( strchr($one_post['option'], 't') ){
                            $is_fixed = '<strong class="cont_fix">고정</strong>';
                        }

                    ?>
                
                    <li>
                        <a href="/page/post/show.php?type=contents&id=<?=$one_post['id']?>">
                            <img src="/upload/file/<?=$filtered_file_name?>">
                            <div class="front_box">
                                <p class="shadow_box"></p>
                                <p class="con_title"><?=$is_fixed?><?=$title_cut?></p>
                                <p class="con_author"><?=$one_post['author']?></p>
                                <p class="view_icon"></p>
                                <p class="con_view"><?=$one_post['view']?></p>
                            </div>
                        </a>
                    </li>
                    
                    <?php } ?>
                </ul>
                <div class="nextLine"></div>
                <div id="page_bt">
                    <?=$page_bt_code?>
                </div>
                <div class="nextLine"></div>
                <div id="write_bt">
                    <?=printWriteButton("contents")?>
                </div>
            </div>
        </div>
        <?=$footer?>
    </body>
</html>

