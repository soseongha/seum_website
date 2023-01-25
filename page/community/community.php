<?php
session_start();
require_once($_SERVER["DOCUMENT_ROOT"].'/template/db.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/template/footer.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/template/header.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/template/session.php');

if( !isset($_GET['type']) ){
    echo "<script>alert('잘못된 접근입니다.'); location.href='/index.php'</script>";
}

/*DB에 연결하기*/
$conn = db_connect();
if($conn == false){
    error_log(mysqli_error($conn));//서버의 logs/error라는 파일에 에러 상세정보가 저장됨
    echo "<script>alert('게시글 삭제 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요.'); window.history.go(-1);</script>";
    exit;
}

/*보안처리*/
$escapedType = mysqli_real_escape_string($conn, $_GET['type']);

/*단어 보정*/
$community_word = '';
switch($escapedType){
    case "notice":
        $community_word = "공지사항";
        break;
    case "reference":
        $community_word = "자료실";
        break;
    case "qna":
        $community_word = "문의사항";
        break;
    case "faq":
        $community_word = "FAQ";
        break;
    default:
        echo "<script>alert('잘못된 접근입니다.'); location.href='/index.php'</script>";
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>세움 다음세대 연구소 | 커뮤니티 - <?=$community_word?></title>
        <meta name="keyword" content="세움 다음세대 연구소, 세움, 다음세대, 다음세대 연구소, 연구소, 메타버스, 커뮤니티, 공지사항, 자료실, 문의사항, FAQ, seum, dusd, dusdlab, seumlab, metaverse">
        <meta name="description" content="세움 다음세대 연구소 커뮤니티">
        <meta name="author" content="세움 다음세대 연구소">
        <meta property="og:type" content="website"> 
        <meta property="og:title" content="세움 다음세대 연구소">
        <meta property="og:description" content="세움 다음세대 연구소 커뮤니티">
        <meta property="og:image" content="image/icon/open_graph_image.png">
        <link rel="canonical" href="/page/community/community.php">
        <link rel="stylesheet" href="/style.css">
        <link rel="shortcut icon" href="/image/favicon/favicon.ico">
        <script src="/web.js"></script>
    </head>
    <body>
        <?=printLoginCode()?>
        <?=$header_elem1?>
        <?=$header_elem2?>
        <div id="content_box">
            <div id="community">
                <div id="type">
                    <h1><a href="/page/community/community.php?type=<?=$escapedType?>"><?=$community_word?></a></h1>
                </div>
                <div class="nextLine"></div>
                <table id="post_table">
                    <thead>
                        <tr>
                            <th width="70">번호</th>    
                            <th width="500">제목</th>   
                            <th width="120">작성자</th>   
                            <th width="200">작성일</th>   
                            <th width="100">조회수</th>   
                        </tr>
                    </thead>
                        <?php

                        /*페이지네이션 준비*/
                        $page_bt_code = '';

                        $sql = $escapedType == "qna"? 'SELECT COUNT(*) FROM post WHERE type="'.$escapedType.'" AND option="q"' : 'SELECT COUNT(*) FROM post WHERE type="'.$escapedType.'"';
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

                                $page_bt_code .= '<a href="/page/community/community.php?type='.$escapedType.'&page='.$taget_pg.'">'.$taget_pg.'</a>';
                            }
                        }
                        
                        /*현재 페이지의 링크 생성*/
                        $page_bt_code .= '<a href="/page/community/community.php?type='.$escapedType.'&page='.$page.'">['.$page.']</a>';
                    
                        /*현재 페이지부터 상위 $MORE_PAGE개의 페이지 링크 생성*/
                        for($i = 0 ; $i < $MORE_PAGE; $i++){

                            $taget_pg = $page + $i + 1;
                            if($taget_pg <= $total_page){

                                $page_bt_code .= '<a href="/page/community/community.php?type='.$escapedType.'&page='.$taget_pg.'">'.$taget_pg.'</a>';
                            }
                        }

                        

                        /*sql문 작성하기(10개의 post 불러오기)*/
                        $sql = $escapedType == "qna"? 'SELECT * FROM post WHERE type="'.$escapedType.'" AND option="q" ORDER BY created DESC LIMIT '.$offset.', '.$LIST_SIZE.';' : 'SELECT * FROM post WHERE type="'.$escapedType.'" ORDER BY FIELD (option, "t", ""), created DESC LIMIT '.$offset.', '.$LIST_SIZE.';';

                        /*DB와 통신하기*/
                        $query = mysqli_query($conn, $sql);
                        $order = $offset + 0;
                        while($one_post = mysqli_fetch_array($query)){
                            
                            

                            $order++;
                            //title변수에 DB에서 가져온 title을 선택
                            $title = htmlspecialchars($one_post["title"]);
                            $title_cut = $title;
                            if(strlen($title)>30)
                            {
                                //title이 30을 넘어서면 ...표시
                                $title_cut=str_replace($title,mb_substr($title,0,30,"utf-8")."...",$title);
                            }

                            $is_fixed = "";
                            /*상단 고정이라면*/
                            if( strchr($one_post['option'], 't') ){
                                $is_fixed = '<strong class="comm_fix">고정</strong>';
                            }

                            /*qna게시판이라면 이 question에 대한 answer가 있는지 확인*/
                            $sql_c = 'SELECT COUNT(*) FROM post WHERE type="'.$escapedType.'" AND option="a" AND link='.$one_post['id'].';';
                            $query_c = mysqli_query($conn, $sql_c);
                            $result_c = mysqli_fetch_array($query_c);
                            $answer_count = $result_c[0];

                            /*qna게시판이라면 이 question post에 대한 answer post를 출력*/
                            $answer_hide = 'class="hide"';
                            $title_cut_a = '';
                            $answer_post = $one_post;
                            $is_answer = "";

                            if( $escapedType == "qna" && $answer_count > 0 ){

                                $answer_hide = '';

                                /*answer post를 DB에서 가져오기*/
                                $sql_a = 'SELECT * FROM post WHERE type="'.$escapedType.'" AND option="a" AND link='.$one_post['id'].' LIMIT 1;';
                                $query_a = mysqli_query($conn, $sql_a);
                                $answer_post = mysqli_fetch_array($query_a);

                                /*answer post의 타이틀 다듬기*/
                                $title_a = htmlspecialchars($answer_post["title"]);
                                $title_cut_a = $title_a;
                                if(strlen($title_a)>30)
                                {
                                    //title이 30을 넘어서면 ...표시
                                    $title_cut_a=str_replace($title_a,mb_substr($title_a,0,30,"utf-8")."...",$title_a);
                                }

                                /*answer post의 타이틀 앞에 표식 넣기*/
                                $is_answer = '<strong class="comm_fix">↳ RE </strong>';
                                
                                    
                            }
                        ?>
                    <tbody>
                        <tr>
                        <td width="70"><?=$order?></td>
                        <td width="500"><a href="/page/post/show.php?type=<?=$escapedType?>&id=<?=$one_post['id']?>"><?=$is_fixed?><?=$title_cut?></a></td>
                        <td width="120"><?=$one_post['author']?></td>
                        <td width="200"><?=$one_post['created']?></td>
                        <td width="100"><?=$one_post['view']?></td>
                        </tr>
                        <tr <?=$answer_hide?>>
                        <td width="70"><?php if($escapedType == "qna" && $answer_count > 0){echo ++$order;}else{echo $order;} ?></td>
                        <td width="500"><a href="/page/post/show.php?type=<?=$escapedType?>&id=<?=$answer_post['id']?>"><?=$is_answer?><?=$title_cut_a?></a></td>
                        <td width="120"><?=$answer_post['author']?></td>
                        <td width="200"><?=$answer_post['created']?></td>
                        <td width="100"><?=$answer_post['view']?></td>
                        </tr>
                    </tbody>
                    <?php } ?>
                </table>
                <div id="page_bt">
                    <?=$page_bt_code?>
                </div>
                <div class="nextLine"></div>
                <div id="write_bt">
                    <?=printWriteButton($escapedType)?>
                </div>
            </div>
        </div>
        <?=$footer?>
    </body>
</html>

