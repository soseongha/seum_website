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

    /*sql문 작성하기(현재 유저정보 가져오기)*/
    $sql = 'SELECT * FROM  member WHERE id="'.$id.'" LIMIT 1;';
    $query = mysqli_query($conn, $sql);
    $user = mysqli_fetch_array($query);

    /*user 정보 가공하기(gender, phone, email)*/
    $gender ='';
    if($user['gender'] == 1){
        $gender ='여자';
    }
    else{
        $gender ='남자';
    }
    $phoneFir = strtok($user['phone'], '-');
    $phoneMid = strtok('-');
    $phoneFin = strtok('-');
    $filteredEmail = htmlspecialchars($user['email']);
    $email_front = strtok($filteredEmail, '@');
    $email_back = strtok('@');

    /*보안처리*/
    $filteredName = htmlspecialchars($user['name']);
    $filteredPostId = htmlspecialchars($user['post_id']);
    $filteredAutoAddress = htmlspecialchars($user['auto_address']);
    $filteredDetailAddress  = htmlspecialchars($user['detail_address']);
}
  
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>세움 다음세대 연구소 | 내 정보</title>
        <meta name="keyword" content="세움 다음세대 연구소, 세움, 다음세대, 다음세대 연구소, 연구소, 메타버스, 내 정보, seum, dusd, dusdlab, seumlab, metaverse, myprivacy, privacy">
        <meta name="description" content="세움 다음세대 연구소 내 정보">
        <meta name="author" content="세움 다음세대 연구소">
        <meta property="og:type" content="website"> 
        <meta property="og:title" content="세움 다음세대 연구소">
        <meta property="og:description" content="세움 다음세대 연구소 내 정보">
        <meta property="og:image" content="image/icon/open_graph_image.png">
        <link rel="stylesheet" href="/style.css">
        <link rel="canonical" href="/page/mypage/myprivacy.php">
        <link rel="shortcut icon" href="/image/favicon/favicon.ico">
        <script src="/web.js"></script>
        <!-- PostSearchButton에 필요한 API호출(다음 우편번호 서비스) -->
        <script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
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
                        <div id="privacy_show">
                            <h2>■ 개인정보</h2>
                            <div class="pg_dt_box">
                                <form id="privacy_update_form" name="privacy_update" action="/process/privacy_update_process.php" method="post" autocomplete="off">
                                    <table>
                                        <tr>
                                            <td><p class="bolder">아이디:</p></td>
                                            <td><?=$user['id']?></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td><p class="bolder">이름:</p></td>
                                            <td><?=$filteredName?></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td><p class="bolder">성별:</p></td>
                                            <td><?=$gender?></td>
                                            <td><p class="bolder">전화번호:</p></td>
                                            <td>
                                                <input id="phone_fir" class="phone_input" type="text" name="phone_fir" value="<?=$phoneFir?>" disabled> -
                                                <input id="phone_mid" class="phone_input" type="text" name="phone_mid" value="<?=$phoneMid?>" disabled> -
                                                <input id="phone_fin" class="phone_input" type="text" name="phone_fin" value="<?=$phoneFin?>" disabled>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><p class="bolder">주소:</p></td>
                                            <td>
                                                <input type="text" name="post_id" id="post_id" placeholder="우편번호" value="<?=$filteredPostId?>" disabled>
                                                <button onclick="PostSearchButton.search_post_id();" id="search_post_button" type="button" disabled>우편번호 찾기</button>
                                                <input type="hidden" name="post_check" id="post_check" value="non_checked">
                                            </td>
                                            <td><input type="text" name="auto_address" id="auto_address" placeholder="주소" value="<?=$filteredAutoAddress?>" disabled></td>
                                            <td><input type="text" name="detail_address" id="detail_address" placeholder="상세주소" value="<?=$filteredDetailAddress?>" disabled></td>
                                        </tr>
                                        <tr>
                                            <td><p class="bolder">이메일:</p></td>
                                            <td>
                                                <input type="text" id="email_front" name="email_front" placeholder="이메일" value="<?=$email_front?>" disabled>
                                            </td>
                                            <td>
                                                <p class="bolder">@</p>
                                                <input type="text" id="email_back" name="email_back" placeholder="직접 입력" value="<?=$email_back?>" disabled>
                                            </td>
                                            <td></td>
                                        </tr>
                                    </table>
                                    <div id="bts">
                                        <button id="updt_strt_bt" type="button">수정</button>
                                        <input id="submit_bt" type="submit" value="저장" disabled>
                                    </div>
                                </form>
                            </div>
                            <div class="nextLine"></div>
                        </div>
                        <div id="update_pwd">
                            <h2>■ 비밀번호 변경</h2>
                            <div class="pg_dt_box">
                                <form id ="pwd_update_form" name="pwd_update" action="/process/password_update_process.php" method="post" autocomplete="off">
                                    <div id="pwd_explain">
                                        <p>비밀번호는 8글자 이상 20글자 이하의 알파벳, 숫자, 특수문자(!@#$%^&+=\)만으로 구성되며, 알파벳과 숫자가 무조건 포함되어야 합니다.</p>
                                    </div>
                                    <table>
                                        <tr>
                                            <td><p>현재 비밀번호</p></td>
                                            <td><input class="pwd_udpt" type="password" name="cur_pwd" placeholder="현재 비밀번호 입력"></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td><p>새 비밀번호</p></td>
                                            <td><input class="pwd_udpt" type="password" name="new_pwd" placeholder="새 비밀번호 입력"></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td><p>새 비밀번호 확인</p></td>
                                            <td><input class="pwd_udpt" type="password" name="crct_pwd" placeholder="새 비밀번호 확인"></td>
                                            <td><input type="submit" value="저장"></td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                            <div class="nextLine"></div>
                        </div>
                        <div id="withdrawal">
                            <h2>■ 회원 탈퇴</h2>
                            <div class="pg_dt_box">
                                <form id ="widrl_form" name="withdrawal" action="/process/withdrawal_process.php" method="post" autocomplete="off">
                                    <div id="widrl_explain">
                                        <p>탈퇴 시, 세움 다음세대 연구소에서 작성한 모든 글과 활동 내역 및 개인정보가 즉시 삭제됩니다. 삭제된 정보는 다시 복구할 수 없습니다.</p>
                                    </div>
                                    <div class="check_box">
                                        <input type="checkbox" id="widrl_term" name="widrl_term" value="checked"><label for="widrl_term"></label>(필수) 위 주의사항에 동의합니다.
                                    </div>
                                    <div id="widrl_pwd_box">
                                        <p>현재 비밀번호</p>
                                        <input type="password" name="widrl_pwd" placeholder="비밀번호 입력">
                                    </div>
                                    <input type="submit" value="탈퇴">
                                </form>
                            </div>
                          <div class="nextLine"></div>
                        </div>
                    </div>
                </div>
                <div class="nextLine"></div>
            </div>
        </div>
        <?=$footer?>
        <script>UpdtStrtButton.initUpdtStrtButton();</script>
        <script>PhoneInput.initPhoneInput();</script>
    </body>
</html>