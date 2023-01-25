<?php

/*로그인 상태라면 회원정보를, 아니라면 로그인 링크를 띄우는 코드*/
function printLoginCode(){

    $loginCode='';
        
    if( !isset($_SESSION['isLogin']) || $_SESSION['isLogin'] == false){
        $loginCode = '
        <div id="loginBox">
            <a href="/page/certification/login.php">로그인</a>
            <a href="/page/certification//signup.php">회원가입</a>
        </div>
        ';
    }
    else if($_SESSION['isLogin'] == true){
        $filteredName = htmlspecialchars($_SESSION['name']);
        $loginCode = '
        <div id="memberBox">
            <a href="/page/mypage/myprivacy.php">'.$filteredName.'님</a>
            <a href="/process/logout_process.php">로그아웃</a>
        </div>
        ';
    }
    return $loginCode;
}

/*권한 확인 후 글쓰기 버튼이 보이게 하는 코드*/
function printWriteButton($type){
    
    $write_bt_code = '';
    if( isset($_SESSION['isLogin']) && $_SESSION['isLogin'] == true && isset($_SESSION['authority']) && $_SESSION['authority'] == "master"){
        
        $write_bt_code = '
            <a href="/page/post/write.php?type='.$type.'"><button>글쓰기</button></a>
            <div class="nextLine"></div>
            ';
    }
    else if( $type == "qna" && isset($_SESSION['isLogin']) && $_SESSION['isLogin'] == true && isset($_SESSION['authority']) && $_SESSION['authority'] == "member"){
        
        $write_bt_code = '
            <a href="/page/post/write.php?type='.$type.'"><button>글쓰기</button></a>
            <div class="nextLine"></div>
            ';
    }

    return $write_bt_code;
    
}

/*이 게시글의 저자라면, 글 수정, 삭제 링크를 띄우는 코드*/
function printUpdtDltPost($author, $post_id, $type){

    $updt_dlt_code = '';
    if( isset($_SESSION['isLogin']) && $_SESSION['isLogin'] == true && isset($_SESSION['id']) && $_SESSION['id'] == $author){

        $updt_dlt_code .= '
            <a href="/page/post/update.php?type='.$type.'&id='.$post_id.'">[글 수정]</a>
            <a href="/process/delete_process.php?id='.$post_id.'">[글 삭제]</a>
            ';
    }
    return $updt_dlt_code;

}

?>