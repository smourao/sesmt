function nl2br(str)
{
   return str.replace(/\n/g, "<br>");
}

function br2nl(str)
{
   //return str.replace(/\n/g, "<br>");
   return str.replace(/<br>/g, '\n');
}


function get_book_info(os){
    var url = "book_info.php?curso="+os;
    url = url + "&cache=" + new Date().getTime();
    if(os==""){
        //alert('O assunto não pode estar em branco!');
        return false;
    }
    http.open("GET", url, true);
    http.onreadystatechange = edit_book_reply;
    http.send(null);
}

function edit_book_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
    var data = msg.split("|");
    if(msg != ""){
        document.getElementById('folha').value = data[0];
        document.getElementById('livro').value = data[1];//document.getElementById('curso').options[document.getElementById('curso').selectedIndex].value;
        document.getElementById('certificado').value = data[2];
        //document.getElementById('folha').disabled = false;
        //document.getElementById('livro').disabled = false;
        //document.getElementById('certificado').disabled = false;
    }else{
        //document.getElementById('folha').disabled = false;
        //document.getElementById('livro').disabled = false;
        //document.getElementById('certificado').disabled = false;
    }
}else{
    if(http.readyState==1){
        //document.getElementById('folha').disabled = true;
        //document.getElementById('livro').disabled = true;
        //document.getElementById('certificado').disabled = true;
    }
}
}






function get_instrutor_info(os){
    var url = "instrutor_info.php?instrutor="+os;
    url = url + "&cache=" + new Date().getTime();
    if(os==""){
        return false;
    }
    http.open("GET", url, true);
    http.onreadystatechange = get_instrutor_info_reply;
    http.send(null);
}

function get_instrutor_info_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
    var data = msg.split("|");
    if(msg != ""){
        document.getElementById('prof_instrutor').value = data[0];
        document.getElementById('registromtb').value = data[1];//document.getElementById('curso').options[document.getElementById('curso').selectedIndex].value;
        //document.getElementById('certificado').value = data[2];
    }else{
        //error!
    }
}else{
    if(http.readyState==1){
        //loading info...
    }
}
}

