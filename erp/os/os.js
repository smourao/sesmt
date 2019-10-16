function nl2br(str)
{
   return str.replace(/\n/g, "<br>");
}

function br2nl(str)
{
   //return str.replace(/\n/g, "<br>");
   return str.replace(/<br>/g, '\n');
}



function edit_title(os, title){
    var url = "edit_title.php?os="+os;
    url = url + "&title=" +title;
    url = url + "&cache=" + new Date().getTime();
    if(title==""){
        alert('O assunto não pode estar em branco!');
        return false;
    }
    http.open("GET", url, true);
    http.onreadystatechange = edit_title_reply;
    http.send(null);
}

function edit_title_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
    if(msg > 0){
        alert('Assunto alterado!');
        location.href="?action=view&os="+msg;
    }else{
        alert('Erro ao alterar assunto desta O.S.');
    }
}else{
    if(http.readyState==1){

    }
}
}



function open_edit(os){
    var url = "open_edit.php?os="+os;
    url = url + "&cache=" + new Date().getTime();
    http.open("GET", url, true);
    http.onreadystatechange = open_title_reply;
    http.send(null);
}

function open_title_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
    if(msg){
        document.getElementById("edittxt").value = br2nl(msg);
        document.getElementById('editmsg').style.display='block';
    }else{
        alert('Erro ao iniciar consulta para edição de mensagem!');
    }
}else{
    if(http.readyState==1){

    }
}
}



function save_edit(os){
    var url = "save_edit.php?os="+os;
    url = url + "&mid=" + document.getElementById("msgid").value;
    url = url + "&txt=" + nl2br(document.getElementById("edittxt").value);
    url = url + "&cache=" + new Date().getTime();
    if(document.getElementById("edittxt").value == ""){
        alert('O campo Mensagem não pode estar vazio!');
        return false;
    }
    //alert(url);
    http.open("GET", url, true);
    http.onreadystatechange = save_edit_reply;
    http.send(null);
}

function save_edit_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
    if(msg>0){
        //document.getElementById("edittxt").value = msg;
        document.getElementById('editmsg').style.display='none';
        alert('Mensagem atualizada!');
        location.href='?action=view&os='+msg;
        //alert(msg);
    }else{
        alert('Erro ao iniciar consulta para edição de mensagem!');
    }
}else{
    if(http.readyState==1){

    }
}
}


