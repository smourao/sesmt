function float2moeda(num){
   x = 0;
   if(num<0) {
      num = Math.abs(num);
      x = 1;
   }
   if(isNaN(num)) num = "0";
      cents = Math.floor((num*100+0.5)%100);
   num = Math.floor((num*100+0.5)/100).toString();
   if(cents < 10) cents = "0" + cents;
      for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
         num = num.substring(0,num.length-(4*i+3))+'.'
               +num.substring(num.length-(4*i+3));
   ret = num + ',' + cents;
   if (x == 1) ret = '-' + ret;return ret;
}


var http = getHTTPObject();

function getHTTPObject(){
  http = null;
    if (window.XMLHttpRequest) {
        http = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        try {
            http = new ActiveXObject("Msxml2.XMLHTTP.4.0");
        } catch(e) {
            try {
                http = new ActiveXObject("Msxml2.XMLHTTP.3.0");
            } catch(e) {
                try {
                    http = new ActiveXObject("Msxml2.XMLHTTP");
                } catch(e) {
                    try {
                        http = new ActiveXObject("Microsoft.XMLHTTP");
                    } catch(e) {
                        http = false;
                    }
                }
            }
        }
  }
 return http;
}

/**********************************************************************************************/
// ATUALIZA ITEMS DE PLACAS DO PPRA
/**********************************************************************************************/
function update_ppra_placas(id, setor, id_ppra){
//alert("update - ano: " + ano);
var url = "update_ppra_placas.php?cliente_id="+id;
url = url + "&setor=" + setor;//para evitar problemas com o cache
url = url + "&id_ppra=" + id_ppra;
url = url + "&cache=" + new Date().getTime();//para evitar problemas com o cache
http.open("GET", url, true);
http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;");
http.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate");
http.setRequestHeader("Cache-Control", "post-check=0, pre-check=0");
http.setRequestHeader("Pragma", "no-cache");
http.onreadystatechange = update_ppra_placas_result;
http.send(null);
}

function update_ppra_placas_result(){
if(http.readyState == 4)
{
    var msg = http.responseText;
    msg = msg.replace(/\+/g," ");
    msg = unescape(msg);
    var data = msg.split("§");
    var saida = "";
    saida += "<table width=100% border=1>";
    saida += "<tr>";
    saida += "<td align=center width=10><b><font size=1>Cod. Prod</b></td><td align=left width=40%><b><font size=1>Descrição</b></td> <td align=left width=40%><b><font size=1>Legenda</b></td>";
    saida += "<td width=30><b><font size=1>Remover</td>";
    saida += "</tr>";
    for(var x=0;x<data.length;x++){
       var user = data[x].split("|");
       if(user[0] != ""){
          saida += "<tr>";
          saida += "<td align=center><font size=1>"+user[4]+"</td>";
          saida += "<td align=left  class=linksistema><font size=1>"+user[1]+"</td>";
          saida += "<td align=center><font size=1>"+user[2]+"</td>";
          saida += "<td align=center><a href=\"javascript:remove_ppra_placas("+user[0]+", "+user[5]+", "+user[6]+", "+user[7]+");\" class='linksistema fontebranca12'>Remover</td>";
          saida += "</tr>";
       }
    }
    saida += "</table>";
    document.getElementById("pcontent").innerHTML = saida;
}else{
 if (http.readyState==1){
    document.getElementById("pcontent").innerHTML = "<center><font size=1>Atualizando lista, aguarde...</font></center>";
    }
 }
}


/**********************************************************************************************/
// REMOVE ITEMS DE PLACAS DO PPRA
/**********************************************************************************************/
function remove_ppra_placas(id, cliente, setor, id_ppra){
    var url = "remove_ppra_placas.php?id="+id;
    url = url + "&setor=" + setor;
    url = url + "&cliente=" + cliente;
    url = url + "&id_ppra=" + id_ppra;
    url = url + "&cache=" + new Date().getTime();//para evitar problemas com o cache
    http.open("GET", url, true);
    http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;");
    http.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate");
    http.setRequestHeader("Cache-Control", "post-check=0, pre-check=0");
    http.setRequestHeader("Pragma", "no-cache");
    http.onreadystatechange = remove_ppra_placas_result;
    http.send(null);
}

function remove_ppra_placas_result(){
if(http.readyState == 4)
{
    var msg = http.responseText;
    msg = msg.replace(/\+/g," ");
    msg = unescape(msg);
    var data = msg.split("|");
    window.parent.update_ppra_placas(data[0], data[1], data[2]);
 }else{
 if (http.readyState==1){
    //document.getElementById("pcontent").innerHTML = "<center><font size=1>Atualizando lista, aguarde...</font></center>";
    }
 }
}


/**********************************************************************************************/
// ADICIONAR ITEMS DE PLACAS DO PPRA
/**********************************************************************************************/
/*
function add_ppra_placas(id, cliente, setor){
    var url = "add_ppra_placas.php?id="+id;
    url = url + "&setor=" + setor;
    url = url + "&cliente=" + cliente;
    url = url + "&cache=" + new Date().getTime();//para evitar problemas com o cache
    http.open("GET", url, true);
    http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;");
    http.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate");
    http.setRequestHeader("Cache-Control", "post-check=0, pre-check=0");
    http.setRequestHeader("Pragma", "no-cache");
    http.onreadystatechange = add_ppra_placas_result;
    http.send(null);
}

function add_ppra_placas_result(){
if(http.readyState == 4)
{
    var msg = http.responseText;
    msg = msg.replace(/\+/g," ");
    msg = unescape(msg);
    var data = msg.split("|");
    alert("add -> data[2]: " + data[2]);
    window.parent.update_ppra_placas(data[0], data[1], data[2]);
 }else{
 if (http.readyState==1){
    //document.getElementById("pcontent").innerHTML = "<center><font size=1>Atualizando lista, aguarde...</font></center>";
    }
 }
}
*/

/*SIMULADOR DE ORCAMENTOS - LEGENDAS DE PLACAS*/
function legendas_de_placas(){
var box = document.getElementById("categoria");
var url = "getlegendas.php?cat=" + escape(box.options[box.selectedIndex].text);
url = url + "&cache=" + new Date().getTime();//para evitar problemas com o cache
http.open("GET", url, true);
http.onreadystatechange = legendas_de_placas_reply;
http.send(null);
}

function legendas_de_placas_reply(){
if(http.readyState == 4)
{
    var msgz = http.responseText;
    msgz = msgz.replace(/\+/g," ");
    msgz = unescape(msgz);
    var data = msgz.split("|");
    var l = document.getElementById("leg");
    l.options.length = data.length;
    l.style.width='150px'
    for(var x=0;x< data.length-1;x++){
        l.options[x].text = data[x];
        l.options[x].value = data[x];
    }
    l.style.width='150px'
    //window.parent.update_orcamento();
}else{
 if (http.readyState==1){
         document.getElementById("leg").options.length = 0;
        //document.getElementById("cpf").style.backgroundColor = "#aca5a5";
    }
 }
}

/**********************************************************************************************/
// ADD ITEMS DE PLACAS DO PPRA
/**********************************************************************************************/

function add_ppra_placas(cod_prod, qnt, cod_cliente, cod_setor, id_ppra){
var box = document.getElementById("leg");
var url = "add_ppra_placas.php?cod_prod=" + cod_prod;
url = url + "&quantidade=" + qnt;
url = url + "&cod_cliente=" + cod_cliente;
url = url + "&cod_setor=" + cod_setor;
url = url + "&id_ppra=" + id_ppra;
url = url + "&legenda=" + escape(box.options[box.selectedIndex].value);
url = url + "&cache=" + new Date().getTime();//para evitar problemas com o cache
http.open("GET", url, true);
http.onreadystatechange = add_ppra_placas_reply;
http.send(null);
}

function add_ppra_placas_reply(){
if(http.readyState == 4){
    var msgz = http.responseText;
    msgz = msgz.replace(/\+/g," ");
    msgz = unescape(msgz);
    if(msgz != ""){
       var data = msgz.split("|");
        window.parent.update_ppra_placas(data[0], data[1], data[2]);
    }
}else{
 if (http.readyState==1){
         //document.getElementById("leg").options.length = 0;
        //document.getElementById("cpf").style.backgroundColor = "#aca5a5";
    }
 }
}



