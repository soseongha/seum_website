<?php
session_start();
require_once($_SERVER["DOCUMENT_ROOT"].'/template/footer.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/template/header.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/template/session.php');

if(isset($_SESSION['isLogin']) && $_SESSION['isLogin'] == true){
    echo "<script>alert('현재 로그인 상태입니다. 로그아웃 후 시도해주세요.'); location.href = '/index.php';</script>";
    exit;
}
?>

</script>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>세움 다음세대 연구소 | 회원가입</title>
        <meta name="keyword" content="세움 다음세대 연구소, 세움, 다음세대, 다음세대 연구소, 연구소, 메타버스, 회원가입, seum, dusd, dusdlab, seumlab, metaverse, signup">
        <meta name="description" content="세움 다음세대 연구소 회원가입">
        <meta name="author" content="세움 다음세대 연구소">
        <link rel="stylesheet" href="/style.css">
        <link rel="canonical" href="/page/certification/signup.php">
        <link rel="shortcut icon" href="/image/favicon/favicon.ico">
        <script src="/web.js"></script>
        <meta name="google-site-verification" content="T1vKL3WksJo27BVgDuzlvHAb04zyimVie51NVSuk5S0" />
        <meta property="og:type" content="website"> 
        <meta property="og:title" content="세움 다음세대 연구소">
        <meta property="og:description" content="세움 다음세대 연구소 회원가입">
        <meta property="og:image" content="image/icon/open_graph_image.png">
    </head>
    <!-- PostSearchButton에 필요한 API호출(다음 우편번호 서비스) -->
    <script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
    <body>
        <?=printLoginCode()?>
        <?=$header_elem1?>
        <div id="content_box">
            <div id="signup">
                <form name="signup" action="/process/signup_process.php" method="post" autocomplete="off">
                    <div class="nextLine"></div>
                    <div class="nextLine"></div>
                    <h4>[회원가입]</h4>
                    <div class="nextLine"></div>
                    <h3>■ 회원가입 이용약관</h3>
                    <div class="scrollBox">
                        <p>
                        <br><br><br>
                        제 1 장 총 칙<br><br><br><br>

                        

                        제 1 조 (목적)<br>
                        이 약관은 세움 다음세대 연구소(이하 "사이트"라 합니다)에서 제공하는 인터넷서비스(이하 "서비스"라 합니다)의 이용 조건 및 절차에 관한 기본적인 사항을 규정함을 목적으로 합니다.<br><br><br><br>

                        

                        제 2 조 (약관의 효력 및 변경)<br>
                        ① 이 약관은 서비스 화면이나 기타의 방법으로 이용고객에게 공지함으로써 효력을 발생합니다.<br>
                        ② 사이트는 이 약관의 내용을 변경할 수 있으며, 변경된 약관은 제1항과 같은 방법으로 공지 또는 통지함으로써 효력을 발생합니다.<br><br><br><br>

                        

                        제 3 조 (용어의 정의)<br>
                        이 약관에서 사용하는 용어의 정의는 다음과 같습니다.<br>
                        ① 회원 : 사이트와 서비스 이용계약을 체결하거나 이용자 아이디(ID)를 부여받은 개인 또는 단체를 말합니다.<br>
                        ② 신청자 : 회원가입을 신청하는 개인 또는 단체를 말합니다.<br>
                        ③ 아이디(ID) : 회원의 식별과 서비스 이용을 위하여 회원이 정하고 사이트가 승인하는 문자와 숫자의 조합을 말합니다.<br>
                        ④ 비밀번호 : 회원이 부여 받은 아이디(ID)와 일치된 회원임을 확인하고, 회원 자신의 비밀을 보호하기 위하여 회원이 정한 문자와 숫자의 조합을 말합니다.<br>
                        ⑤ 해지 : 사이트 또는 회원이 서비스 이용계약을 취소하는 것을 말합니다.<br><br><br><br>

                        

                        제 2 장 서비스 이용계약<br><br><br><br>

                        

                        제 4 조 (이용계약의 성립)<br>
                        ① 이용약관 하단의 동의 버튼을 누르면 이 약관에 동의하는 것으로 간주됩니다.<br>
                        ② 이용계약은 서비스 이용희망자의 이용약관 동의 후 이용 신청에 대하여 사이트가 승낙함으로써 성립합니다.<br><br><br><br>

                        

                        제 5 조 (이용신청)<br>
                        ① 신청자가 본 서비스를 이용하기 위해서는 사이트 소정의 가입신청 양식에서 요구하는 이용자 정보를 기록하여 제출해야 합니다.<br>
                        ② 가입신청 양식에 기재하는 모든 이용자 정보는 모두 실제 데이터인 것으로 간주됩니다. 실명이나 실제 정보를 입력하지 않은 사용자는 법적인 보호를 받을 수 없으며, 서비스의 제한을 받을 수 있습니다.<br><br><br><br>

                        

                        제 6 조 (이용신청의 승낙)<br>
                        ① 사이트는 신청자에 대하여 제2항, 제3항의 경우를 예외로 하여 서비스 이용신청을 승낙합니다.<br>
                        ② 사이트는 다음에 해당하는 경우에 그 신청에 대한 승낙 제한사유가 해소될 때까지 승낙을 유보할 수 있습니다.<br>
                        가. 서비스 관련 설비에 여유가 없는 경우<br>
                        나. 기술상 지장이 있는 경우<br>
                        다. 기타 사이트가 필요하다고 인정되는 경우<br>
                        ③ 사이트는 신청자가 다음에 해당하는 경우에는 승낙을 거부할 수 있습니다.<br>
                        가. 다른 개인(사이트)의 명의를 사용하여 신청한 경우<br>
                        나. 이용자 정보를 허위로 기재하여 신청한 경우<br>
                        다. 사회의 안녕질서 또는 미풍양속을 저해할 목적으로 신청한 경우<br>
                        라. 기타 사이트 소정의 이용신청요건을 충족하지 못하는 경우<br><br><br><br>

                        

                        제 7 조 (이용자정보의 변경)<br>
                        회원은 이용 신청시에 기재했던 회원정보가 변경되었을 경우에는, 온라인으로 수정하여야 하며 변경하지 않음으로 인하여 발생되는 모든 문제의 책임은 회원에게 있습니다.<br><br><br><br>

                        

                        제 3 장 계약 당사자의 의무<br><br><br><br>

                        

                        제 8 조 (사이트의 의무)<br>
                        ① 사이트는 회원에게 각 호의 서비스를 제공합니다.<br>
                        가. 신규서비스와 도메인 정보에 대한 뉴스레터 발송<br>
                        나. 추가 도메인 등록시 개인정보 자동 입력<br>
                        다. 도메인 등록, 관리를 위한 각종 부가서비스<br>
                        ② 사이트는 서비스 제공과 관련하여 취득한 회원의 개인정보를 회원의 동의없이 타인에게 누설, 공개 또는 배포할 수 없으며, 서비스관련 업무 이외의 상업적 목적으로 사용할 수 없습니다. 단, 다음 각 호의 1에 해당하는 경우는 예외입니다.<br>
                        가. 전기통신기본법 등 법률의 규정에 의해 국가기관의 요구가 있는 경우<br>
                        나. 범죄에 대한 수사상의 목적이 있거나 정보통신윤리 위원회의 요청이 있는 경우<br>
                        다. 기타 관계법령에서 정한 절차에 따른 요청이 있는 경우<br>
                        ③ 사이트는 이 약관에서 정한 바에 따라 지속적, 안정적으로 서비스를 제공할 의무가 있습니다.<br><br><br><br>

                        

                        제 9 조 (회원의 의무)<br>
                        ① 회원은 서비스 이용 시 다음 각 호의 행위를 하지 않아야 합니다.<br>
                        가. 다른 회원의 ID를 부정하게 사용하는 행위<br>
                        나. 서비스에서 얻은 정보를 사이트의 사전승낙 없이 회원의 이용 이외의 목적으로 복제하거나 이를 변경, 출판 및 방송 등에 사용하거나 타인에게 제공하는 행위<br>
                        다. 사이트의 저작권, 타인의 저작권 등 기타 권리를 침해하는 행위<br>
                        라. 공공질서 및 미풍양속에 위반되는 내용의 정보, 문장, 도형 등을 타인에게 유포하는 행위<br>
                        마. 범죄와 결부된다고 객관적으로 판단되는 행위<br>
                        바. 기타 관계법령에 위배되는 행위<br>
                        ② 회원은 관계법령, 이 약관에서 규정하는 사항, 서비스 이용 안내 및 주의 사항을 준수하여야 합니다.<br>
                        ③ 회원은 내용별로 사이트가 서비스 공지사항에 게시하거나 별도로 공지한 이용 제한 사항을 준수하여야 합니다.<br><br><br><br>

                        

                        제 4 장 서비스 제공 및 이용<br><br><br><br>

                        

                        제 10 조 (회원 아이디(ID)와 비밀번호 관리에 대한 회원의 의무)<br>
                        ① 아이디(ID)와 비밀번호에 대한 모든 관리는 회원에게 책임이 있습니다. 회원에게 부여된 아이디(ID)와 비밀번호의 관리소홀, 부정사용에 의하여 발생하는 모든 결과에 대한 전적인 책임은 회원에게 있습니다.<br>
                        ② 자신의 아이디(ID)가 부정하게 사용된 경우 또는 기타 보안 위반에 대하여, 회원은 반드시 사이트에 그 사실을 통보해야 합니다.<br><br><br><br>

                        

                        제 11 조 (서비스 제한 및 정지)<br>
                        ① 사이트는 전시, 사변, 천재지변 또는 이에 준하는 국가비상사태가 발생하거나 발생할 우려가 있는 경우와 전기통신사업법에 의한 기간통신 사업자가 전기통신서비스를 중지하는 등 기타 불가항력적 사유가 있는 경우에는 서비스의 전부 또는 일부를 제한하거나 정지할 수 있습니다.<br>
                        ② 사이트는 제1항의 규정에 의하여 서비스의 이용을 제한하거나 정지할 때에는 그 사유 및 제한기간 등을 지체없이 회원에게 알려야 합니다.<br><br><br><br>

                        

                        제5장 계약사항의 변경, 해지<br><br><br><br>

                        

                        제 12 조 (정보의 변경)<br>
                        회원이 주소, 비밀번호 등 고객정보를 변경하고자 하는 경우에는 홈페이지의 회원정보 변경 서비스를 이용하여 변경할 수 있습니다.<br><br><br><br>

                        

                        제 13 조 (계약사항의 해지)<br>
                        회원은 서비스 이용계약을 해지할 수 있으며, 해지할 경우에는 본인이 직접 서비스를 통하거나 전화 또는 온라인 등으로 사이트에 해지신청을 하여야 합니다. 사이트는 해지신청이 접수된 당일부터 해당 회원의 서비스 이용을 제한합니다. 사이트는 회원이 다음 각 항의 1에 해당하여 이용계약을 해지하고자 할 경우에는 해지조치 7일전까지 그 뜻을 이용고객에게 통지하여 소명할 기회를 주어야 합니다.<br>
                        ① 이용고객이 이용제한 규정을 위반하거나 그 이용제한 기간 내에 제한 사유를 해소하지 않는 경우<br>
                        ② 정보통신윤리위원회가 이용해지를 요구한 경우<br>
                        ③ 이용고객이 정당한 사유 없이 의견진술에 응하지 아니한 경우<br>
                        ④ 타인 명의로 신청을 하였거나 신청서 내용의 허위 기재 또는 허위서류를 첨부하여 이용계약을 체결한 경우<br>
                        사이트는 상기 규정에 의하여 해지된 이용고객에 대해서는 별도로 정한 기간동안 가입을 제한할 수 있습니다.<br><br><br><br>

                        

                        제6장 손해배상<br><br><br><br>

                        

                        제 14 조 (면책조항)<br>
                        ① 사이트는 회원이 서비스 제공으로부터 기대되는 이익을 얻지 못하였거나 서비스 자료에 대한 취사선택 또는 이용으로 발생하는 손해 등에 대해서는 책임이 면제됩니다.<br>
                        ② 사이트는 회원의 귀책사유나 제3자의 고의로 인하여 서비스에 장애가 발생하거나 회원의 데이터가 훼손된 경우에 책임이 면제됩니다.<br>
                        ③ 사이트는 회원이 게시 또는 전송한 자료의 내용에 대해서는 책임이 면제됩니다.<br>
                        ④ 상표권이 있는 도메인의 경우, 이로 인해 발생할 수도 있는 손해나 배상에 대한 책임은 구매한 회원 당사자에게 있으며, 사이트는 이에 대한 일체의 책임을 지지 않습니다.<br><br><br><br>

                        

                        제 15 조 (관할법원)<br><br><br><br>

                        

                        서비스와 관련하여 사이트와 회원간에 분쟁이 발생할 경우 사이트의 본사 소재지를 관할하는 법원을 관할법원으로 합니다.<br><br><br><br>

                        

                        [부칙]<br><br><br><br>

                        

                        (시행일) 이 약관은 2022년 08월부터 시행합니다.<br><br><br><br>
                        </p>
                    </div>
                    <div class="check_box">
                        <input type="checkbox" id="service_term" name="service_term" value="checked"><label for="service_term"></label>(필수) 이용 약관에 동의합니다.
                    </div>
                    <div class="nextLine"></div>
                    <h3>■ 개인정보 수집 및 이용 동의</h3>
                    <div class="scrollBox">
                        <p>
                        <br><br>
                        < 세움 다음세대 연구소 >('seumlab.com'이하 '세움 다음세대 연구소')은(는) 「개인정보 보호법」 제30조에 따라 정보주체의 개인정보를 보호하고 이와 관련한 고충을 신속하고 원활하게 처리할 수 있도록 하기 위하여 다음과 같이 개인정보 처리방침을 수립·공개합니다.<br><br>

                        ○ 이 개인정보처리방침은 2022년 8월 23부터 적용됩니다.<br><br><br>


                        제1조(개인정보의 처리 목적)<br><br>

                        < 세움 다음세대 연구소 >('seumlab.com'이하 '세움 다음세대 연구소')은(는) 다음의 목적을 위하여 개인정보를 처리합니다. 처리하고 있는 개인정보는 다음의 목적 이외의 용도로는 이용되지 않으며 이용 목적이 변경되는 경우에는 「개인정보 보호법」 제18조에 따라 별도의 동의를 받는 등 필요한 조치를 이행할 예정입니다.<br><br>

                        1. 홈페이지 회원가입 및 관리<br><br>

                        회원 가입의사 확인, 회원제 서비스 제공에 따른 본인 식별·인증, 회원자격 유지·관리, 서비스 부정이용 방지 목적으로 개인정보를 처리합니다.<br><br><br>


                        2. 게시판 서비스 제공<br><br>

                        콘텐츠 제공을 목적으로 개인정보를 처리합니다. 문의게시판 등의 게시판 이용을 위해 사용합니다.<br><br>


                        3. 마케팅 및 광고에의 활용<br><br>

                        신규 서비스(제품) 개발 및 맞춤 서비스 제공, 이벤트 및 광고성 정보 제공 및 참여기회 제공 등을 목적으로 개인정보를 처리합니다.<br><br><br>




                        제2조(개인정보의 처리 및 보유 기간)<br><br>

                        ① < 세움 다음세대 연구소 >은(는) 법령에 따른 개인정보 보유·이용기간 또는 정보주체로부터 개인정보를 수집 시에 동의받은 개인정보 보유·이용기간 내에서 개인정보를 처리·보유합니다.<br><br>

                        ② 각각의 개인정보 처리 및 보유 기간은 다음과 같습니다.<br><br>

                        1.< 홈페이지 회원가입 및 관리 ><br>
                        < 홈페이지 회원가입 및 관리 >와 관련한 개인정보는 최근 <1년>간 로그인 이력이 없을 경우, 그 즉시 파기됩니다.<br>
                        또한, 개인정보 파기 30일 전 회원정보의 이메일 주소로 안내 메일이 발송됩니다.<br>
                        1년간 로그인 이력이 없어 개인정보가 파기될 시에, 회원이 홈페이지에서 작성한 글은 별도로 삭제되지 않습니다.<br>
                        보유근거 : 정보통신서비스 제공자등은 정보통신서비스를 1년의 기간 동안 이용하지 않는 경우에는 이용자의 개인정보를 해당 기관 경과 후 즉시 파기하거나 다른 이용자의 개인정보와 분리하여 별도로 저장·관리해야 합니다(「개인정보 보호법」 제39조의6제1항 본문 및 「개인정보 보호법 시행령」 제48조의5제1항 본문).<br><br><br>
                        
                        2. < 게시판 서비스 제공 ><br>
                        < 서비스 제공 >과 관련한 개인정보는 탈퇴 및 이탈 후에도 한정적으로 사용될 수 있습니다.<br><br><br>


                        3.< 마케팅 및 광고에의 활용 ><br>
                        < 마케팅 및 광고에의 활용 >와 관련한 개인정보는 최근 <1년>간 로그인 이력이 없을 경우, 그 즉시 파기됩니다.<br><br><br>


                        제3조(처리하는 개인정보의 항목)<br><br>

                        ① < 세움 다음세대 연구소 >은(는) 다음의 개인정보 항목을 처리하고 있습니다.<br><br>

                        1< 홈페이지 회원가입 및 관리 ><br>
                        필수항목 : 이메일, 휴대전화번호, 비밀번호, 로그인ID, 성별, 이름, 서비스 이용 기록, 접속 로그, 쿠키<br>
                        선택항목 : 자택주소<br><br><br>


                        2. < 게시판 서비스 제공 ><br>
                        필수항목: 로그인ID<br><br><br>


                        3. 마케팅 및 광고에의 활용<br>
                        필수항목 : 이메일, 휴대전화번호, 로그인ID, 성별, 이름, 서비스 이용 기록, 접속 로그, 쿠키<br>
                        선택항목 : 자택주소<br><br><br>


                        신규 서비스(제품) 개발 및 맞춤 서비스 제공, 이벤트 및 광고성 정보 제공 및 참여기회 제공 등을 목적으로 개인정보를 처리합니다.<br><br><br>



                        제4조(개인정보를 자동으로 수집하는 장치의 설치·운영 및 그 거부에 관한 사항)<br><br><br>



                        ① 세움 다음세대 연구소 은(는) 이용자에게 개별적인 맞춤서비스를 제공하기 위해 이용정보를 저장하고 수시로 불러오는 ‘쿠키(cookie)’를 사용합니다.<br>
                        ② 쿠키는 웹사이트를 운영하는데 이용되는 서버(http)가 이용자의 컴퓨터 브라우저에게 보내는 소량의 정보이며 이용자들의 PC 컴퓨터내의 하드디스크에 저장되기도 합니다.<br>
                        가. 쿠키의 사용 목적 : 이용자가 방문한 각 서비스와 웹 사이트들에 대한 방문 및 이용형태, 인기 검색어, 보안접속 여부, 등을 파악하여 이용자에게 최적화된 정보 제공을 위해 사용됩니다.<br>
                        나. 쿠키의 설치•운영 및 거부 : 웹브라우저 상단의 도구>인터넷 옵션>개인정보 메뉴의 옵션 설정을 통해 쿠키 저장을 거부 할 수 있습니다.<br>
                        다. 쿠키 저장을 거부할 경우 맞춤형 서비스 이용에 어려움이 발생할 수 있습니다.<br><br><br>



                        제5조(추가적인 이용·제공 판단기준)<br><br>

                        < 세움 다음세대 연구소 > 은(는) ｢개인정보 보호법｣ 제15조제3항 및 제17조제4항에 따라 ｢개인정보 보호법 시행령｣ 제14조의2에 따른 사항을 고려하여 정보주체의 동의 없이 개인정보를 추가적으로 이용·제공할 수 있습니다.<br>
                        이에 따라 < 세움 다음세대 연구소 > 가(이) 정보주체의 동의 없이 추가적인 이용·제공을 하기 위해서 다음과 같은 사항을 고려하였습니다.<br>
                        ▶ 개인정보를 추가적으로 이용·제공하려는 목적이 당초 수집 목적과 관련성이 있는지 여부<br><br>

                        ▶ 개인정보를 수집한 정황 또는 처리 관행에 비추어 볼 때 추가적인 이용·제공에 대한 예측 가능성이 있는지 여부<br><br>

                        ▶ 개인정보의 추가적인 이용·제공이 정보주체의 이익을 부당하게 침해하는지 여부<br><br>

                        ▶ 가명처리 또는 암호화 등 안전성 확보에 필요한 조치를 하였는지 여부<br><br>

                        ※ 추가적인 이용·제공 시 고려사항에 대한 판단기준은 사업자/단체 스스로 자율적으로 판단하여 작성·공개함<br><br><br><br>


                        </p>
                    </div>
                    <div class="check_box">
                        <input type="checkbox" id="privacy_term" name="privacy_term" value="checked"><label for="privacy_term"></label>(필수) 개인 정보 수집 및 이용 동의에 동의합니다.
                    </div>
                    <div class="nextLine"></div>
                    <div class="nextLine"></div>
                    <h3>■ 상세정보 입력</h3>
                    <table>
                        <tr>
                            <td>아이디</td>
                            <td class="essential">*</td>
                            <td>
                                <input class="signup_input" type="text" name="id" id="real_id" placeholder="아이디" value="">
                                <button id="id_button"type="button">중복 확인</button>
                                <input type="hidden" name="idcheck" id="idcheck" value="non_checked">
                                <script>
                                    function correct(){
                                        IdButton.correctId();
                                    }
                                </script>
                            </td>
                        </tr>
                        <tr>
                            <td>비밀번호</td>
                            <td class="essential">*</td>
                            <td>
                                <input class="signup_input" id="password_input" type="password" name="password" placeholder="비밀번호">
                                <p id="password_msg"></p>
                            </td>
                        </tr>
                        <tr>
                            <td>비밀번호 확인</td>
                            <td class="essential">*</td>
                            <td><input class="signup_input" type="password" name="password_check" placeholder="비밀번호 확인"></td>
                        </tr>
                        <tr>
                            <td>이름</td>
                            <td class="essential">*</td>
                            <td><input class="signup_input" type="text" name="name" placeholder="이름"></td>
                        </tr>
                        <tr>
                            <td>성별</td>
                            <td class="essential">*</td>
                            <td>
                                <input type="radio" id="male" name="gender" value="male">
                                <label for="male">남</label>
                                <input type="radio" id="female" name="gender" value="female">
                                <label for="male">여</label>
                            </td>
                        </tr>
                        <tr>
                            <td>휴대폰 번호</td>
                            <td class="essential">*</td>
                            <td>
                                <input class="phone_input" id="phone_fir" type="text" name="phone_fir"> -
                                <input class="phone_input" id="phone_mid" type="text" name="phone_mid"> -
                                <input class="phone_input" id="phone_fin" type="text" name="phone_fin">
                            </td>
                        </tr>
                        <tr>
                            <td>주소</td>
                            <td class="essential">*</td>
                            <td>
                                <input class="signup_input" type="text" name="post_id" id="post_id" placeholder="우편번호">
                                <button onclick="PostSearchButton.search_post_id();" id="search_post_button" type="button">우편번호 찾기</button>
                                <input type="hidden" name="post_check" id="post_check" value="non_checked">
                                <input class="signup_input" type="text" name="auto_address" id="auto_address" placeholder="주소">
                                <input class="signup_input" type="text" name="detail_address" id="detail_address" placeholder="상세주소">
                            </td>
                        </tr>
                        <tr>
                            <td>이메일</td>
                            <td class="essential">*</td>
                            <td>
                                <input type="text" name="email" placeholder="이메일">
                                @
                                <select id ="email_select" name="emadress">
                                    <option value="naver.com">naver.com</option>
                                    <option value="nate.com">nate.com</option>
                                    <option value="hanmail.com">hanmail.com</option>
                                    <option value="gmail.com">gmail.com</option>
                                    <option value="direct">직접 입력</option>
                                </select>
                                <input type="text" id="direct_input" name="direct_input" placeholder="직접 입력">
                            </td>
                        </tr>
                    </table>
                    <div class="nextLine"></div>
                    <input type="submit" value="회원가입하기">
                </form>
                <div class="nextLine"></div>
                <div class="nextLine"></div>
            </div>
        </div>
        <?=$footer?>
        <script>PasswordInput.initPasswordInput();</script>
        <script>PhoneInput.initPhoneInput();</script>
    </body>
</html>
