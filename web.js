
var String = {

    getSecondLastChild:function(link){
        var spliter = "/";
        var trimmedLink = link.split(spliter);
        var secondLastChild;
        for(let i = 0; true ; i++){
            if(trimmedLink[i] == null){
                secondLastChild = trimmedLink[i-2];
                break; 
            }
        }
        return secondLastChild;
    }
}


/*메뉴바에서 현재 페이지 표시 메뉴 색 바꾸기*/
var Menu = {
    
    initCurrentMenu:function(){
        //var currentLink = document.location.href;
        var currentHref= String.getSecondLastChild(document.location.pathname);
        var menus = document.querySelectorAll("#menu h4 a");
        if(menus.length != 0){ //querySelectorAll()은 결과가 없으면 빈 nodeList를 반환함
            for(let i = 0; true; i++){
                
                var tempHref = String.getSecondLastChild(menus[i].pathname);
                if(tempHref == currentHref){
                    menus[i].style.color = 'white';
                    menus[i].style.fontWeight = '900';
                    break;
                }
            }
        }
    }

}

/*signup.php에서 아이디 유효성 검사하는 버튼*/
var IdButton = {

    initIdButton :function(){
        var idButton = document.querySelector("#id_button");

        if(idButton){
            idButton.addEventListener('click',function(event){
                var userId = document.getElementById("real_id").value;
                if(userId)
                {
                    url = "idcheck.php?id="+userId;
                    window.open(url,"idcheck"," top: 20, left:20, width=500, height:500, resizable=no, scrollbars=no, titlebar=yes");
                }
                else{
                    alert("아이디를 입력하세요.");
                }
            });
        }
    },

    correctId :function(){ //중복이 아닐 경우, 아이디 확정

        if(document.getElementById("real_id").value != null){
            document.getElementById("real_id").readOnly= true;
            document.getElementById("real_id").style.backgroundColor = "rgb(245, 245, 245)";
            document.getElementById("id_button").readOnly = true;
            document.getElementById("idcheck").value = "checked";

        }
        else{
            alert("error!");
        }
    }
}


/*signip.php에서 비밀번호 유효성을 검사하는 input 태그*/
var PasswordInput = {

    initPasswordInput: function(){
        
        password_reg = /(?=.*[a-zA-Z].*)(?=.*[0-9].*)(^[0-9a-zA-Z!@#$%^&+=]{8,20}$)/;
        passwordInput = document.getElementById("password_input");
        passwordMsg = document.getElementById("password_msg");

        passwordInput.addEventListener('focus', function(event){

            passwordMsg.style.display = "block";
        })

        passwordInput.addEventListener('blur', function(event){

            passwordMsg.style.display = "none";
        })

        passwordInput.addEventListener('input', function(event){

            
            if(password_reg.test(event.target.value)){
                passwordMsg.innerHTML = "사용가능한 비밀번호입니다.";
                passwordMsg.style.color = "green";
            }
            else{
                passwordMsg.innerHTML = "비밀번호는 8글자 이상 20글자 이하의 알파벳, 숫자, 특수문자(!@#$%^&+=\)만으로 구성되며, 알파벳과 숫자가 반드시 포함되어야 합니다.";
                passwordMsg.style.color = "red";
            }
        })
    }

}


/*signip.php과 myprivacy.php에서 전화번호 입력 시 포커스를 자동 넘김하는 input 태그*/
var PhoneInput = {

    initPhoneInput:function(){

        phone_reg_fir = /^[0-9]{3}$/;
        phone_reg_mid = /^[0-9]{4}$/;
        phone_reg_fin = /^[0-9]{4}$/;
        var phone_fir = document.getElementById("phone_fir");
        var phone_mid = document.getElementById("phone_mid");
        var phone_fin = document.getElementById("phone_fin");

        phone_fir.addEventListener('input',function(event){
            if(phone_reg_fir.test(event.target.value)){
                phone_mid.focus();
                phone_mid.select();
            }
        });
        phone_mid.addEventListener('input',function(event){
            if(phone_reg_mid.test(event.target.value)){
                phone_fin.focus();
                phone_fin.select();
            }
        });
        phone_fin.addEventListener('input',function(event){
            if(phone_reg_fin.test(event.target.value)){
                phone_fin.blur();
            }
        });

    }

}


/*signup.php에서 우편번호 검색하는 버튼*/
var PostSearchButton = {

    search_post_id:function(){

        new daum.Postcode({
            oncomplete: function(data) {
                var addr = ''; // 주소 변수
                var extraAddr = ''; // 참고항목 변수
    
                addr = data.roadAddress;
                
                // 우편번호와 주소 정보를 해당 필드에 넣는다.
                document.getElementById('post_id').value = data.zonecode;
                document.getElementById("auto_address").value = addr;
                document.getElementById('post_id').readOnly = true;
                document.getElementById("auto_address").readOnly = true;
                document.getElementById("post_id").style.backgroundColor = "rgb(245, 245, 245)";
                document.getElementById("auto_address").style.backgroundColor = "rgb(245, 245, 245)";
                document.getElementById("post_check").value = "checked";

                document.getElementById("detail_address").focus();
            }
        }).open();
    }
}

/*signup.php에서 이메일 직접입력 때 버튼*/
var DirectButton = {
    /*직접입력 클릭 시, select 대신 input을 display한다.*/
    initDirectButton:function(){
    
        var email_select = document.getElementById("email_select");
        var direct_input = document.getElementById("direct_input");

        if(email_select){
            email_select.addEventListener('change',function(event){
                
                if(this.options[this.selectedIndex].value == "direct"){
                    email_select.style.display = "none";
                    direct_input.style.display = "inline-block";
                }
            })
        }
    }
}


var image_file_count = 0;
var attachment_file_count = 0;

/*write.php에서 파일 추가 버튼 조작*/
var FileAddButton = {


    initFileAddButtons: function(){
        var image_add_bt = document.getElementById("image_add_bt");
        var attachment_add_bt = document.getElementById("attachment_add_bt");

        if(image_add_bt && attachment_add_bt){

            image_add_bt.addEventListener('click',function(){

                //input[type=hidden]를 선택
                var img_hidden_count = document.getElementById("img_hidden_count");
                
                //카운트를 +1
                image_file_count += 1;
                img_hidden_count.value = image_file_count.toString();

                //input[type=file] 엘리먼트 추가
                var new_file_tag = document.createElement('input');
                new_file_tag.setAttribute('type','file');
                var file_tag_name = 'image_'+(image_file_count.toString());
                new_file_tag.setAttribute('name',file_tag_name);
                new_file_tag.setAttribute('id',file_tag_name);
                new_file_tag.setAttribute('accept',"image/*");
                this.parentNode.appendChild(new_file_tag);

                //처음 추가하는 거라면, 삭제 버튼 생성
                if(image_file_count == 1){
                    var new_delete_tag = document.createElement('button');
                    new_delete_tag.setAttribute('type','button');
                    new_delete_tag.setAttribute('class','delete_bt');
                    new_delete_tag.addEventListener('click',function(){
                        
                        var img_hidden_count = document.getElementById("img_hidden_count");

                        this.previousElementSibling.remove();
                        if(image_file_count == 1){
                        this.remove();
                        }
                        //카운트를 -1
                        image_file_count -= 1;
                        img_hidden_count.value = image_file_count.toString();
                    });
                    new_delete_tag.innerHTML="-삭제";
                    this.parentNode.appendChild(new_delete_tag);
                }
                //처음 추가하는 게 아니라면, 삭제 버튼 옮기기
                else{
                    var exist_delete_tag = document.getElementById(file_tag_name).previousElementSibling;
                    this.parentNode.appendChild(exist_delete_tag);
                }   
            });
            attachment_add_bt.addEventListener('click',function(){
                
                //input[type=hidden]를 선택
                var attachment_hidden_count = document.getElementById("attachment_hidden_count");
                                
                //카운트를 +1
                attachment_file_count += 1;
                attachment_hidden_count.value = attachment_file_count.toString();

                //input[type=file] 엘리먼트 추가
                var new_file_tag = document.createElement('input');
                new_file_tag.setAttribute('type','file');
                var file_tag_name = 'attachment_'+(attachment_file_count.toString());
                new_file_tag.setAttribute('name',file_tag_name);
                new_file_tag.setAttribute('id',file_tag_name);
                this.parentNode.appendChild(new_file_tag);

                //처음 추가하는 거라면, 삭제 버튼 생성
                if(attachment_file_count == 1){
                    var new_delete_tag = document.createElement('button');
                    new_delete_tag.setAttribute('type','button');
                    new_delete_tag.setAttribute('class','delete_bt');
                    new_delete_tag.addEventListener('click',function(){
                        this.previousElementSibling.remove();
                        if(attachment_file_count == 1){
                            this.remove();
                        }
                        attachment_file_count -= 1;
                        attachment_hidden_count.value = attachment_file_count.toString();
                    });
                    new_delete_tag.innerHTML="-삭제";
                    this.parentNode.appendChild(new_delete_tag);
                }
                //처음 추가하는 게 아니라면, 삭제 버튼 옮기기
                else{
                    var exist_delete_tag = document.getElementById(file_tag_name).previousElementSibling;
                    this.parentNode.appendChild(exist_delete_tag);
                } 
            });

        }
    }

    
}


/*update.php에서 이미 존재하던 파일을 삭제하는 버튼*/
function hideFile(event, TYPE){

    THUMB_TYPE = 1;
    IMAGE_TYPE = 2;
    ATTCH_TYPE = 3;

    if( TYPE == THUMB_TYPE ){//파일이 썸네일 타입이면

        del_bt = event.target;
        parent = del_bt.parentNode;
        hidden = del_bt.nextElementSibling;
    
        parent.style.display = "none";
        del_bt.style.display = "none";
        hidden.value = "yes";
    
        new_thumb = document.getElementById('thumbnail');
        new_thumb.style.display = "block";
    }
    else if( TYPE == IMAGE_TYPE ||  TYPE ==  ATTCH_TYPE ){//파일이 이미지, 첨부파일 타입이면

        del_bt = event.target;
        parent = del_bt.parentNode;
        hidden = del_bt.nextElementSibling;
    
        parent.style.display = "none";
        del_bt.style.display = "none";
        hidden.value = "yes";
    }
}


/*index.php에서 카드 클릭 시 레이어팝업 띄우기*/
function openPopup(event){

    var figure_li = event.currentTarget.parentNode;
    var figure_ol = figure_li.parentNode;
    var figure_list = [...figure_ol.children];

    var index = figure_list.indexOf(figure_li);

    var popup_ol = document.getElementById("popup_ol");
    var popup_list = [...popup_ol.children];
    var popup = popup_list[index].children[0];
    var popup_layer = popup.children[0];

    popup.style.visibility = "visible";
    popup_layer.className = "popup_layer show";
}
/*index.php에서 닫기 클릭 시 레이어팝업 닫기*/
function closePopup(event){

    var popup = event.target.parentNode.parentNode.parentNode;
    var popup_layer = popup.children[0];

    popup.style.visibility = "hidden";

    popup_layer.className = "popup_layer";

}


/*mypage.php에서 개인정보 수정 시작하는 버튼*/
var UpdtStrtButton = {
    
    initUpdtStrtButton: function(){

        var updt_strt_bt = document.getElementById("updt_strt_bt");
        
        if(updt_strt_bt){

            updt_strt_bt.addEventListener('click',function(event){
                document.getElementsByClassName("phone_input")[0].disabled = false;
                document.getElementsByClassName("phone_input")[1].disabled = false;
                document.getElementsByClassName("phone_input")[2].disabled = false;
                document.getElementById("post_id").disabled = false;
                document.getElementById("search_post_button").disabled = false;
                document.getElementById("auto_address").disabled = false;
                document.getElementById("detail_address").disabled = false;
                document.getElementById("email_front").disabled = false;
                document.getElementById("email_back").disabled = false;

                this.disabled = true;
                document.getElementById("submit_bt").disabled = false;
            })

        }
    }
}

/*스크롤 맨 위로 옮기는 버튼*/
var TopButton = {

    initTopButton:function(){
        var topButton = document.getElementById("top_button");

        if(topButton){
            window.addEventListener('scroll',function(event){
                var currentScrollTop = document.documentElement.scrollTop;
                if(currentScrollTop > 50){
                    topButton.style.display = 'block';
                }
                else{
                    topButton.style.display = 'none';
                }
            });

            var topButtonImg = topButton.childNodes[1];
            topButtonImg.addEventListener('click',function(e){
                scrollTo({top:0, behavior:'smooth'});
            });
        }

    }
}

