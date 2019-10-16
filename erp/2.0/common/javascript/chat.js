var ajax = oAjax();
var aMsg = oAjax();
var sMsg = oAjax();
var aCSt = oAjax();
var chatMeId = null;  //id de timer das mensagens
var chatlistId = null;//id de timer da lista
var chating = null;
var userid = new Array();

/*
function oAjax(){
  var temp = null;
  //ajax = null;
    if (window.XMLHttpRequest) {
        temp = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        try {
            temp = new ActiveXObject("Msxml2.XMLHTTP.4.0");
        } catch(e) {
            try {
                temp = new ActiveXObject("Msxml2.XMLHTTP.3.0");
            } catch(e) {
                try {
                    temp = new ActiveXObject("Msxml2.XMLHTTP");
                } catch(e) {
                    try {
                        temp = new ActiveXObject("Microsoft.XMLHTTP");
                    } catch(e) {
                        temp = false;
                    }
                }
            }
        }
  }
 return temp;
}
*/
/***********************************************************************************************/
// --> LISTA DE USUÁRIOS
/***********************************************************************************************/
function getChatList(id){
    var url = "common/get_chat_list.php?id="+id;
    url = url + "&cache=" + new Date().getTime();
    ajax.open("GET", url, true);
    ajax.onreadystatechange = getChatList_reply;
    ajax.send(null);
}

function getChatList_reply(){
    var usl = document.getElementById("userlist");
    var cst = document.getElementById("chatstatus");
if(ajax.readyState == 4){
    var msg = ajax.responseText;
	var users = msg.split("£");
	var txt = "";
	txt += "<table width=100%>";
	txt += "<tr>";
	txt += "<td align=center><img src='images/sci-user-list-text.png' border=0></td>";
	txt += "</tr>";
	for(x=0;x<users.length-1;x++){
        var ulist = users[x].split("|");
        userid[x] = ulist[0];
        var status = "<img src='images/sci-offline.png' border=0 alt='Offline' title='Offline'>";
        if(ulist[2] == 1){
            status = "<img src='images/sci-online.png' border=0 alt='Online' title='Online'>";
        }
        txt += "<tr>";
        if(chating == ulist[0]){
            txt += "<td class='text roundborderselectedinv'id='lname"+ulist[0]+"'>";
        }else{
            txt += "<td class='text' id='lname"+ulist[0]+"'>";
        }
        if(ulist[5] > 0){
            txt += status + " " + "<a href='javascript:chatMe("+ulist[0]+", "+ulist[4]+");'>" + ulist[1] + " <img src='images/new-msg1.png' border=0 alt='"+ulist[5]+" mensagens' title='"+ulist[5]+" mensagens'></a>";
        }else{
            txt += status + " " + "<a href='javascript:chatMe("+ulist[0]+", "+ulist[4]+");'>" + ulist[1] + "</a>";
        }
        txt += "</td>";
        txt += "</tr>";
	}
	txt += "</table>";

    if (usl == null || usl == "undefined"){
        //not to do!
    }else{
        usl.innerHTML = txt;
        cst.innerHTML = "";
        //document.getElementById("userlist").innerHTML = txt;
	    //document.getElementById("chatstatus").innerHTML = "";
	}
}else{
    if(ajax.readyState==1){
        if (cst == null || cst == "undefined"){
            //not to do!
        }else{
             cst.innerHTML = "Aguarde, atualizando lista de contatos...";
            //document.getElementById("chatstatus").innerHTML = "Aguarde, atualizando lista de contatos...";
        }
    }
}
}

//GAMBI TO SCROLLDOWN
function scrollToBottom(elm_id){
    var elm = document.getElementById(elm_id);
	try{
		elm.scrollTop = elm.scrollHeight;
	}catch(e){
		var f = document.createElement("input");
		if (f.setAttribute) f.setAttribute("type","text")
		if (elm.appendChild) elm.appendChild(f);
		f.style.width = "0px";
		f.style.height = "0px";
		if (f.focus) f.focus();
		if (elm.removeChild) elm.removeChild(f);
	}
}

/***********************************************************************************************/
// --> GET DE MENSAGENS
/***********************************************************************************************/
function chatMe(id, im){
    for(x=0;x<userid.length;x++){
        document.getElementById('lname'+userid[x]).className = 'text';
    }
    chating = id;
    document.getElementById('lname'+chating).className = 'roundborderselectedinv text';
    clearInterval(chatMeId);
    chatMeDone(id, im);
    chatMeId = setInterval("chatMeDone("+id+", "+im+")", 5000);
    document.getElementById('txt').focus();
}


function chatMeDone(id, im){
    if(chating >= 0){
        var url = "common/get_chat_message.php?id="+id;
        url = url + "&im=" + im;
        url = url + "&cache=" + new Date().getTime();
        aMsg.open("GET", url, true);
        aMsg.onreadystatechange = chatMe_reply;
        aMsg.send(null);
    }else{
        clearInterval(chatMeId);
    }
}

function chatMe_reply(){
if(aMsg.readyState == 4){
    var msg = aMsg.responseText;
    document.getElementById("mainchat").innerHTML = msg;
    scrollToBottom('mainchat');
    document.getElementById("chatstatus").innerHTML = "";
    scrollToBottom('mainchat');
}else{
 if(aMsg.readyState==1){
     document.getElementById("chatstatus").innerHTML = "Aguarde, atualizando mensagens...";
    }
 }
}

/***********************************************************************************************/
// --> ENVIO DE MENSAGENS
/***********************************************************************************************/
function sendMsg(id, im, msg){
    if(id >= 0 && im >= 0 && msg != ""){
        var url = "common/send_chat_message.php?id="+id;
        url = url + "&im=" + im;
        url = url + "&msg=" + msg;
        url = url + "&cache=" + new Date().getTime();
        sMsg.open("GET", url, true);
        sMsg.onreadystatechange = sendMsg_reply;
        sMsg.send(null);
        chatMeDone(id, im);
    }else{

    }
}

function sendMsg_reply(){
if(sMsg.readyState == 4){
    var msg = sMsg.responseText;
    if(msg == 1){
        document.getElementById("txt").value = "";
        document.getElementById("txt").focus();
    }else{
        alert("Erro no envio da mensagem!");
    }
    document.getElementById("chatstatus").innerHTML = "";
}else{
 if(sMsg.readyState==1){
     document.getElementById("chatstatus").innerHTML = "Aguarde, Enviando mensagem...";
    }
 }
}

/***********************************************************************************************/
// --> CHANGE STATUS - SHOW / HIDE CHAT
/***********************************************************************************************/
function changeChatStatus(id){
        var url = "common/change_chat_status.php?id="+id;
        url = url + "&cache=" + new Date().getTime();
        aCSt.open("GET", url, true);
        aCSt.onreadystatechange = changeChatStatus_reply;
        aCSt.send(null);
}

function changeChatStatus_reply(){
    var usl = document.getElementById("userlist");
    var cst = document.getElementById("chatstatus");
    if(aCSt.readyState == 4){
        var msg = aCSt.responseText;
        if(msg == 1){
            document.getElementById("chatmsg").style.display = "block";
            if (cst != null || cst != "undefined"){
                cst.innerHTML = "";
                //document.getElementById("chatstatus").innerHTML = "";
            }
        }else if(msg == 2){//escander chat
            if (cst != null || cst != "undefined"){
                cst.innerHTML = "";
            }
            document.getElementById("chatmsg").style.display = "none";
            // --------------------------------------------------------------------------------->
            //Desliga variáveis de checkagem (aumento de desempenho???)
            chating = null;//----------> SE NÃO DER ERRO =x
            clearInterval(chatMeId);
            document.getElementById("mainchat").innerHTML = "";
            // <---------------------------------------------------------------------------------
        }else{
            if (cst != null || cst != "undefined"){
                cst.innerHTML = "Houve um erro ao tentar finalizar o SCI. Por favor, entre em contato com o suporte!";
            }
        }
    }else{
        if(aCSt.readyState==1){
           document.getElementById("chatstatus").innerHTML = "Finalizando o SCI, por favor, aguarde!";
        }
    }
}
