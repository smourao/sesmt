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

function select_cliente(){
//alert("NeverDie");

var id = document.getElementById("cliente").value;
var url = "ajax_select_cliente.php?id="+id;
url = url + "&cache=" + new Date().getTime();//para evitar problemas com o cache

http.open("GET", url, true);
http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;");
http.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate");
http.setRequestHeader("Cache-Control", "post-check=0, pre-check=0");
http.setRequestHeader("Pragma", "no-cache");

http.onreadystatechange = select_cliente_result;
http.send(null);
}

function select_cliente_result(){
if(http.readyState == 4)
{
    var msg = http.responseText;
    msg = msg.replace(/\+/g," ");
    msg = unescape(msg);
    var data = msg.split("§");
    //alert(data.length);
    var saida = "";
    saida += "<table width=500 border=1>";
    saida += "<tr>";
    saida += "<td align=center><b><font size=1>ID</b></td> <td align=center><b><font size=1>RAZÃO SOCIAL</b></td> <td align=center><b><font size=1>FILIAL</b></td>";
    saida += "</tr>";
    for(var x=0;x<data.length-1;x++){
       var user = data[x].split("|");
       saida += "<tr>";
       saida += "<td align=center><font size=1>"+user[0]+"</td>";
       saida += "<td align=left  class=linksistema><font size=1><a href='cria_orcamento.php?act=new&cod_cliente="+user[0]+"&cod_filial="+user[2]+"' class=linksistema>"+user[1]+"</a></td>";
       saida += "<td align=center><font size=1>"+user[2]+"</td>";
       saida += "</tr>";
    }
    saida += "</table>";
    document.getElementById("lista_orcamentos").innerHTML = saida;
}else{
 if (http.readyState==1){
    document.getElementById("lista_orcamentos").innerHTML = "<center><font size=1>Atualizando lista, aguarde...</font></center>";
    }
 }
}



/*SIMULADOR DE ORCAMENTOS - MOSTA/ATUALIZA LISTA DE PRODUTOS*/
function update_orcamento(){
var url = "update_orcamento.php?orcamento="+document.getElementById("orca").value;
url = url + "&cod_cliente=" + document.getElementById("cod_cliente").value;
url = url + "&cod_filial=" + document.getElementById("cod_filial").value;
url = url + "&cache=" + new Date().getTime();//para evitar problemas com o cache
http.open("GET", url, true);
http.onreadystatechange = update_orcamento_reply;
http.send(null);
}

function update_orcamento_reply(){
if(http.readyState == 4)
{
    var fir = http.responseText;
    fir = fir.replace(/\+/g," ");
    fir = unescape(fir);
    var ex = fir.split("¢");
    var msgz = ex[1];
    var total = 0;
    var lista = msgz.split("£");
    var tmp = lista[0].split("|");

       var retorno = "<table border=1 width=100%>";
       retorno += "<tr>";
       retorno += "<td align=center width=10><font size=1><b>Excluir</b></font></td>";
       retorno += "<td align=center><font size=1><b>Descrição.</b></font></td>";
       retorno += "<td align=center width=10><font size=1><b>Quant.</b></font></td>";
       retorno += "<td align=center width=50><font size=1><b>Preço</b></font></td>";
       retorno += "<td align=center width=50><font size=1><b>Total</b></font></td>";
       retorno += "</tr>";

       for(var x=0;x<lista.length -1;x++){
          retorno += "<tr>";
          var data = lista[x].split("|");
          retorno += "<td align=center><center><font size=1><a href='javascript:remove_orcamento_produto("+data[0]+");' class=excluir><font size=1>Excluir</font></a></font></td>";
          retorno += "<td align=left><font size=2>"+data[4]+"</font></td>";
          retorno += "<td align=center><font size=2>"+data[2]+"</font></td>";
          retorno += "<td align=center><font size=2>"+float2moeda(data[3])+"</font></td>";
          retorno += "<td align=center><font size=2>"+float2moeda((data[3]*data[2]))+"</font></td>";
          retorno += "</tr>";

          total+=(data[3]*data[2]);
          }

          retorno += "<tr>";
          retorno += "<td colspan=2 align=right><font size=2><b>TOTAL</b></td>";
          retorno += "<td align=right>&nbsp;</td>";
          retorno += "<td colspan=2 align=right><font size=2><b>R$ </b><b>"+float2moeda(total)+"</b></td>";
          retorno += "</table>";

    document.getElementById("dados").innerHTML = retorno;
    document.getElementById("orc_loading").className='loading_done';
    //document.getElementById("dados").style.visibility='hidden';
    if(document.getElementById("dados").scrollHeight >220){
        parent.document.getElementById("find").height = document.getElementById("dados").scrollHeight; //40:
    }

}else{
 if (http.readyState<4){
        //document.getElementById("orc_loading").style.display='block';
        document.getElementById("orc_loading").className='loading';
    }
 }
}



/*SIMULADOR DE ORCAMENTOS - ADICIONA PRODUTOS*/
function add_orcamento_produto(qnt, pcode){
if(qnt > 0){
var url = "add_orcamento_prod.php?orcamento="+window.parent.document.getElementById("orca").value;
url = url + "&cod_cliente=" + window.parent.document.getElementById("cod_cliente").value;
url = url + "&cod_filial=" + window.parent.document.getElementById("cod_filial").value;
url = url + "&qnt=" + qnt;
if(document.getElementById("leg")){
//alert(document.getElementById("leg"));
   url = url + "&legenda=" + document.getElementById("leg").options[document.getElementById("leg").selectedIndex].value;
}
url = url + "&cod_produto=" + pcode;
url = url + "&cache=" + new Date().getTime();//para evitar problemas com o cache
//alert(url);
http.open("GET", url, true);
http.onreadystatechange = add_orcamento_prod_reply;
http.send(null);
}else{
    if(qnt == null){
    }else{
       if(typeof(qnt) == "undefined"){
       }else{
          alert('O valor informado para quantidade é inválido!');
       }
    }
}
}

function add_orcamento_prod_reply(){
if(http.readyState == 4)
{
    window.parent.update_orcamento();
    var msgz = http.responseText;
    msgz = msgz.replace(/\+/g," ");
    msgz = unescape(msgz);
}else{
 if (http.readyState==1){
        //document.getElementById("cpf").style.backgroundColor = "#aca5a5";
    }
 }
}





/*SIMULADOR DE ORCAMENTOS - REMOVE PRODUTOS*/
function remove_orcamento_produto(pcode){
if(pcode >= 0){
var url = "remove_orcamento_prod.php?orcamento="+document.getElementById("orca").value;
url = url + "&cod_cliente=" + document.getElementById("cod_cliente").value;
url = url + "&cod_filial=" + document.getElementById("cod_filial").value;
url = url + "&cod_produto=" + pcode;
url = url + "&cache=" + new Date().getTime();//para evitar problemas com o cache
http.open("GET", url, true);
http.onreadystatechange = remove_orcamento_prod_reply;
http.send(null);
}else{
    if(pcode == null){
    }else{
       if(typeof(pcode) == "undefined"){
       }else{
          alert('Erro ao remover o produto selecionado!');
       }
    }
}
}

function remove_orcamento_prod_reply(){
if(http.readyState == 4)
{
    var msgz = http.responseText;
    msgz = msgz.replace(/\+/g," ");
    msgz = unescape(msgz);
    window.parent.update_orcamento();
}else{
 if (http.readyState==1){
        //document.getElementById("cpf").style.backgroundColor = "#aca5a5";
    }
 }
}



/*SIMULADOR DE ORCAMENTOS - LEGENDAS DE PLACAS*/
function legendas_de_placas(){
var box = document.getElementById("categoria");
var url = "getlegendas.php?cat=" + box.options[box.selectedIndex].text;
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
    //alert(msgz);
    
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

