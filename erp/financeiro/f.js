function addslashes(str) {
str=str.replace(/\'/g,'\\\'');
str=str.replace(/\"/g,'\\"');
str=str.replace(/\\/g,'\\\\');
str=str.replace(/\0/g,'\\0');
return str;
}
function stripslashes(str) {
str=str.replace(/\\'/g,'\'');
str=str.replace(/\\"/g,'"');
str=str.replace(/\\\\/g,'\\');
str=str.replace(/\\0/g,'\0');
return str;
}

function getHTTPObject(){
   http = null;
   if (window.XMLHttpRequest){
        http = new XMLHttpRequest();
    }else if(window.ActiveXObject){
        try{
            http = new ActiveXObject("Msxml2.XMLHTTP.4.0");
        }catch(e){
            try{
                http = new ActiveXObject("Msxml2.XMLHTTP.3.0");
            }catch(e){
                try{
                    http = new ActiveXObject("Msxml2.XMLHTTP");
                }catch(e){
                    try{
                        http = new ActiveXObject("Microsoft.XMLHTTP");
                    }catch(e){
                        http = false;
                    }
                }
            }
        }
  }
 return http;
}

var http = getHTTPObject();

function j_parcelas(v){
//alert(document.getElementById("lancamento").value);
   if(v == 0){
      //v = 1;
   }
   if(v == 1){
      //var sel = document.getElementById("periodo");
      //sel.disabled = 1;
      //sel.selectedIndex = 0;
      document.getElementById("docn").style.display = "inline";
   }else{
      //var sel = document.getElementById("periodo");
      //sel.disabled = 0;
      if(document.frm.lancamento[0].checked == true){
         document.getElementById("docn").style.display = "inline";
      }else{
         document.getElementById("docn").style.display = "none";
      }
   }
}

function check_form(){
   if(isNaN(document.getElementById("parcelas").value)){
      alert('Número de parcelas inválido!');
   }else if(document.frm.lancamento[0].checked == false && document.frm.lancamento[1].checked == false){
      alert('Selecione um tipo de lançamento!');
      return false;
   }else{
      return true;
   }
}

function graph_m(ano){
   document.getElementById("grafico").innerHTML = "<img src='graph.php?ano="+ano+"&cache="+new Date().getTime()+"'>";
}

//*********************************************
//AJAX PAGAMENTO RECEITA
//*********************************************
function receita_paga(pcode){
//alert(pcode);
if(pcode >= 0){
var url = "paga_receita.php?cod="+pcode;
//url = url + "&cod_cliente=" + document.getElementById("cod_cliente").value;
//url = url + "&cod_filial=" + document.getElementById("cod_filial").value;
//url = url + "&cod_produto=" + pcode;
url = url + "&cache=" + new Date().getTime();//para evitar problemas com o cache
http.open("GET", url, true);
http.onreadystatechange = receita_paga_reply;
http.send(null);
}else{
    if(pcode == null){
    }else{
       if(typeof(pcode) == "undefined"){
       }else{
          alert('Erro ao marcar o produto como selecionado!');
       }
    }
}
}
function receita_paga_reply(){
if(http.readyState == 4)
{
    var msgz = http.responseText;
    msgz = msgz.replace(/\+/g," ");
    msgz = unescape(msgz);
    //alert(msgz);
    if(msgz > 0){
       document.getElementById("d"+msgz).innerHTML = "<font color=black><b>Pago!</b></font>";
       window.parent.receita_total();
    }
}else{
 if (http.readyState==1){
        //document.getElementById("cpf").style.backgroundColor = "#aca5a5";
    }
 }
}
//*********************************************
//AJAX RECEITA CALCULO
//*********************************************
function receita_total(){
var url = "receita_total.php?mes="+document.getElementById("hmes").value;
url = url + "&ano="+document.getElementById("hano").value;
url = url + "&cache=" + new Date().getTime();//para evitar problemas com o cache
http.open("GET", url, true);
http.onreadystatechange = receita_total_reply;
http.send(null);
}
function receita_total_reply(){
if(http.readyState == 4)
{
    var msgz = http.responseText;
    msgz = msgz.replace(/\+/g," ");
    msgz = unescape(msgz);
    //alert(msgz);
    if(msgz != ""){
       document.getElementById("soma_receita").innerHTML = "<b>R$ "+msgz+"</b>";
    }
}else{
 if (http.readyState==1){
        document.getElementById("soma_receita").innerHTML = "<i>Atualizando valor...</i>";
    }
 }
}





//*********************************************
//AJAX PAGAMENTO DESPESA
//*********************************************
function despesa_paga(pcode){
//alert(pcode);
if(pcode >= 0){
var url = "paga_despesa.php?cod="+pcode;
//url = url + "&cod_cliente=" + document.getElementById("cod_cliente").value;
//url = url + "&cod_filial=" + document.getElementById("cod_filial").value;
//url = url + "&cod_produto=" + pcode;
url = url + "&cache=" + new Date().getTime();//para evitar problemas com o cache
http.open("GET", url, true);
http.onreadystatechange = despesa_paga_reply;
http.send(null);
}else{
    if(pcode == null){
    }else{
       if(typeof(pcode) == "undefined"){
       }else{
          alert('Erro ao marcar o produto como selecionado!');
       }
    }
}
}
function despesa_paga_reply(){
if(http.readyState == 4)
{
    var msgz = http.responseText;
    msgz = msgz.replace(/\+/g," ");
    msgz = unescape(msgz);

    if(msgz > 0){
       //window.parent.despesa_total();
//       window.top.frames[0].despesa_total();
//document.getElementById("erp").Document.despesa_total();
//document.frames['erp'].fdp();
       document.getElementById("d"+msgz).innerHTML = "<font color=black><b>Pago!</b></font>";
    }
}else{
 if (http.readyState==1){
        //document.getElementById("cpf").style.backgroundColor = "#aca5a5";
    }
 }
}
//*********************************************
//AJAX DESPESA CALCULO
//*********************************************
function despesa_total(){
var url = "despesa_total.php?mes="+document.getElementById("hmes").value;
url = url + "&ano="+document.getElementById("hano").value;
url = url + "&cache=" + new Date().getTime();//para evitar problemas com o cache
http.open("GET", url, true);
http.onreadystatechange = despesa_total_reply;
http.send(null);
}
function despesa_total_reply(){
if(http.readyState == 4)
{
    var msgz = http.responseText;
    msgz = msgz.replace(/\+/g," ");
    msgz = unescape(msgz);
    //alert(msgz);
    if(msgz != ""){
       document.getElementById("soma_receita").innerHTML = "<b>R$ "+msgz+"</b>";
    }
}else{
 if (http.readyState==1){
        document.getElementById("soma_receita").innerHTML = "<i>Atualizando valor...</i>";
    }
 }
}



// construindo o calendário
function popdate(obj,div,tam,ddd, m, y)
{
    if (ddd)
    {
        day = ""
        mmonth = ""
        ano = ""
        c = 1
        char = ""
        for (s=0;s<parseInt(ddd.length);s++)
        {
            char = ddd.substr(s,1)
            if (char == "/")
            {
                c++;
                s++;
                char = ddd.substr(s,1);
            }
            if (c==1) day    += char
            if (c==2) mmonth += char
            if (c==3) ano    += char
        }
        
        if ( typeof m != 'undefined' && typeof y != 'undefined') {
           ddd = m + "/" + day + "/" + y
        }else{
           ddd = mmonth + "/" + day + "/" + ano
        }
    }

    if(!ddd) {today = new Date()} else {today = new Date(ddd)}
    date_Form = eval (obj)
    if (date_Form.value == "") { date_Form = new Date()} else {date_Form = new Date(date_Form.value)}

    ano = today.getFullYear();
    mmonth = today.getMonth ();
    day = today.toString ().substr (8,2)

    umonth = new Array ("Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro")
    days_Feb = (!(ano % 4) ? 29 : 28)
    days = new Array (31, days_Feb, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31)

    if ((mmonth < 0) || (mmonth > 11))  alert(mmonth)
    if ((mmonth - 1) == -1) {month_prior = 11; year_prior = ano - 1} else {month_prior = mmonth - 1; year_prior = ano}
    if ((mmonth + 1) == 12) {month_next  = 0;  year_next  = ano + 1} else {month_next  = mmonth + 1; year_next  = ano}
    txt  = "<table bgcolor='#efefff' style='border:solid #330099; border-width:2' cellspacing='0' cellpadding='3' border='0' width='"+tam+"' height='"+tam*1.1 +"'>"
    txt += "<tr bgcolor='#FFFFFF'><td colspan='7' align='center'><table border='0' cellpadding='0' width='100%' bgcolor='#FFFFFF'><tr>"
    txt += "<td width=20% align=center><a href=javascript:popdate('"+obj+"','"+div+"','"+tam+"','"+((mmonth+1).toString() +"/01/"+(ano-1).toString())+"') class='Cabecalho_Calendario' title='Ano Anterior'><<</a></td>"
    txt += "<td width=20% align=center><a href=javascript:popdate('"+obj+"','"+div+"','"+tam+"','"+( "01/" + (month_prior+1).toString() + "/" + year_prior.toString())+"') class='Cabecalho_Calendario' title='Mês Anterior'><</a></td>"
    txt += "<td width=20% align=center><a href=javascript:popdate('"+obj+"','"+div+"','"+tam+"','"+( "01/" + (month_next+1).toString()  + "/" + year_next.toString())+"') class='Cabecalho_Calendario' title='Próximo Mês'>></a></td>"
    txt += "<td width=20% align=center><a href=javascript:popdate('"+obj+"','"+div+"','"+tam+"','"+((mmonth+1).toString() +"/01/"+(ano+1).toString())+"') class='Cabecalho_Calendario' title='Próximo Ano'>>></a></td>"
    txt += "<td width=20% align=right><a href=javascript:force_close('"+div+"') class='Cabecalho_Calendario' title='Fechar Calendário'><b>x</b></a></td></tr></table></td></tr>"
/*
    txt += "<tr bgcolor='#FFFFFF'><td colspan='7' align='center'><table border='0' cellpadding='0' width='100%' bgcolor='#FFFFFF'><tr>"
    txt += "<td width=20% align=center><font size=1>"+(ano-1).toString()+"</font></td>"
    txt += "<td width=20% align=center><font size=1>"+umonth[mmonth-1].substr(0,3)+"</font></td>"
    txt += "<td width=20% align=center><font size=1>"+umonth[mmonth+1].substr(0,3)+"</font></td>"
    txt += "<td width=20% align=center><font size=1>"+(ano+1).toString()+"</font></td>"
    txt += "<td width=20% align=right><a href=javascript:force_close('"+div+"') class='Cabecalho_Calendario' title='Fechar Calendário'><b>X</b></a></td></tr></table></td></tr>"
*/
    txt += "<tr><td colspan='7' align='right' bgcolor='#ccccff' class='mes'><a href=javascript:pop_year('"+obj+"','"+div+"','"+tam+"','" + (mmonth+1) + "') class='mes'>" + ano.toString() + "</a>"
    txt += " <a href=javascript:pop_month('"+obj+"','"+div+"','"+tam+"','" + ano + "') class='mes'>" + umonth[mmonth] + "</a> <div id='popd' style='position:absolute'></div></td></tr>"
    txt += "<tr bgcolor='#330099'><td width='14%' class='dia' align=center><b>Dom</b></td><td width='14%' class='dia' align=center><b>Seg</b></td><td width='14%' class='dia' align=center><b>Ter</b></td><td width='14%' class='dia' align=center><b>Qua</b></td><td width='14%' class='dia' align=center><b>Qui</b></td><td width='14%' class='dia' align=center><b>Sex<b></td><td width='14%' class='dia' align=center><b>Sab</b></td></tr>"

    today1 = new Date((mmonth+1).toString() +"/01/"+ano.toString());
    diainicio = today1.getDay () + 1;
    week = d = 1
    start = false;

    for (n=1;n<= 42;n++)
    {
        if (week == 1)  txt += "<tr bgcolor='#efefff' align=center>"
        if (week==diainicio) {start = true}
        if (d > days[mmonth]) {start=false}
        if (start)
        {
            dat = new Date((mmonth+1).toString() + "/" + d + "/" + ano.toString())
            day_dat   = dat.toString().substr(0,10)
            day_today  = date_Form.toString().substr(0,10)
            year_dat  = dat.getFullYear ()
            year_today = date_Form.getFullYear ()
            colorcell = ((day_dat == day_today) && (year_dat == year_today) ? " bgcolor='#FFCC00' " : "" )
            txt += "<td"+colorcell+" align=center><a href=javascript:block('"+  d + "/" + (mmonth+1).toString() + "/" + ano.toString() +"','"+ obj +"','" + div +"') class='data'>"+ d.toString() + "</a></td>"
            d ++
        }
        else
        {
            txt += "<td class='data' align=center> </td>"
        }
        week ++
        if (week == 8)
        {
            week = 1; txt += "</tr>"}
        }
        txt += "</table>"
        div2 = eval (div)
        div2.innerHTML = txt
        //return false;
}

// função para exibir a janela com os meses
function pop_month(obj, div, tam, ano)
{
  txt  = "<table bgcolor='#CCCCFF' border='0' width=80>"
  for (n = 0; n < 12; n++) { txt += "<tr><td align=center><a href=javascript:popdate('"+obj+"','"+div+"','"+tam+"','"+("01/" + (n+1).toString() + "/" + ano.toString())+"') class=mes>" + umonth[n] +"</a></td></tr>" }
  txt += "</table>"
  popd.innerHTML = txt
}

// função para exibir a janela com os anos
function pop_year(obj, div, tam, umonth)
{
  txt  = "<table bgcolor='#CCCCFF' border='0' width=160>"
  l = 1
  for (n=1991; n<2012; n++)
  {  if (l == 1) txt += "<tr>"
     txt += "<td align=center class=mes><a href=javascript:popdate('"+obj+"','"+div+"','"+tam+"','"+(umonth.toString () +"/01/" + n) +"') class=mes>" + n + "</a></td>"
     l++
     if (l == 4)
        {txt += "</tr>"; l = 1 }
  }
  txt += "</tr></table>"
  popd.innerHTML = txt
}

// função para fechar o calendário
function force_close(div)
    { div2 = eval (div); div2.innerHTML = ''}

// função para fechar o calendário e setar a data no campo de data associado
function block(data, obj, div)
{
    force_close (div)
    obj2 = eval(obj)
    obj2.value = data
}


function change_es(obj){
//alert(obj.value);
if(obj.value == 0){
   document.getElementById("es").innerHTML = "Entrada";
   window.parent.update_lancamentos(0);
}else{
   document.getElementById("es").innerHTML = "Saída";
   window.parent.update_lancamentos(1);
}
}
// ---- FUNCTION CHECA CAMPOS ANTES DE INSERIR LANÇAMENTOS ----
function check_lan(){
if(document.getElementById("titulo").value == ""){
   alert('Insira um título para o lançamento!');
   return false;
}
if(document.getElementById("parcelas").value == "" || isNaN(document.getElementById("parcelas").value)){
   alert('Valor de parcela inválido!');
   return false;
}

if(document.getElementById("valor").value == ""){
   alert('Valor inválido para lançamento!');
   return false;
}

//vencimento
if(document.getElementById("data").value == ""){
   alert('Insira uma data para vencimento!');
   return false;
}

if(document.getElementById("entsai").value == ""){
   alert('Insira uma data para o lançamento!');
   return false;
}
/*
if(document.getElementById("tipo_pagamento").value == ""){
   alert('Selecione um tipo de lançamento!');
   return false;
}

if(document.getElementById("forma_pagamento").value == ""){
   alert('Selecione uma forma de pagamento!');
   return false;
}
*/
if(document.getElementById("historico").value == ""){
   alert('Insira um histórico para este lançamento!');
   return false;
}

return true;
}









//*********************************************
//AJAX TIPO DE LANÇAMENTO
//*********************************************
function update_lancamentos(pcode){
//alert(pcode);
if(pcode >= 0){
var url = "update_lancamentos.php?cod="+pcode;
url = url + "&cache=" + new Date().getTime();//para evitar problemas com o cache
http.open("GET", url, true);
http.onreadystatechange = update_lancamentos_reply;
http.send(null);
}else{
    if(pcode == null){
    }else{
       if(typeof(pcode) == "undefined"){
       }else{
          alert('Erro ao marcar o produto como selecionado!');
       }
    }
}
}
function update_lancamentos_reply(){
if(http.readyState == 4)
{
    var msgz = http.responseText;
    msgz = msgz.replace(/\+/g," ");
    msgz = unescape(msgz);
    //alert(msgz);
    
    if(msgz != 0){
    var box = document.getElementById("tipo_pagamento");
    var data = msgz.split("|");
    box.options.length = data.length;
    //alert(data.length);
    for(var x=0;x<data.length;x++){
       var it = data[x].split('§');
       box.options[x].value = it[0];
       box.options[x].text = it[1];
    }
    box.disabled = false;
       //document.getElementById("d"+msgz).innerHTML = "<b>Pago!</b>";
       //window.parent.despesa_total();
    }
}else{
 if (http.readyState==1){
         document.getElementById("tipo_pagamento").disabled = true;
         document.getElementById("tipo_pagamento").options.length = 0;
    }
 }
}





//*********************************************
//AJAX UPDATE PARCELA
//*********************************************
function update_parcela(pcode){
//alert(pcode);
if(pcode >= 0){
   document.getElementById("temp").value = pcode;
   var url = "update_parcela.php?cod="+pcode;
   url = url + "&titulo=" + document.getElementById("titulo"+pcode).value;
   url = url + "&data=" + document.getElementById("data"+pcode).value;
   url = url + "&valor=" + document.getElementById("valor"+pcode).value;
   url = url + "&cache=" + new Date().getTime();//para evitar problemas com o cache
   //alert(url);
   http.open("GET", url, true);
   http.onreadystatechange = update_parcela_reply;
   http.send(null);
}else{
    if(pcode == null){
    }else{
       if(typeof(pcode) == "undefined"){
       }else{
          alert('Erro ao alterar parcela! Código: '+pcode);
       }
    }
}
}
function update_parcela_reply(){
if(http.readyState == 4)
{
    var msgz = http.responseText;
    msgz = msgz.replace(/\+/g," ");
    msgz = unescape(msgz);
    var tmp = document.getElementById("temp").value;
    if(msgz != 0){
       var data = msgz.split("|");
       //alert(msgz);
         document.getElementById("titulo"+tmp).value=data[0];
         document.getElementById("data"+tmp).value=data[1];
         document.getElementById("valor"+tmp).value=data[2];
     }
     //alert(msgz);

         document.getElementById("titulo"+tmp).disabled=false;
         document.getElementById("data"+tmp).disabled=false;
         document.getElementById("valor"+tmp).disabled=false;
}else{
 if (http.readyState==1){
         var tmp = document.getElementById("temp").value;
         document.getElementById("titulo"+tmp).disabled=true;
         document.getElementById("data"+tmp).disabled=true;
         document.getElementById("valor"+tmp).disabled=true;
    }
 }
}

//*********************************************
//FODA QUE O PEDRO ARRUMA -.-
//*********************************************
function close_autocomplete(){
   var div = document.getElementById("autocomplete");
   div.style.display = "none";
}

function show_autocomplete(){
   var div = document.getElementById("autocomplete");
   div.style.display = "block";
}

function do_autocomplete(txt){
   document.getElementById("titulo").value = txt;
   window.parent.close_autocomplete();
}

function autocomplete(obj){
  if(obj.value != "" && obj.value != " "){
     var url = "ajax_autocomplete.php?search="+obj.value;
     url = url + "&cache=" + new Date().getTime();//para evitar problemas com o cache
     //alert(url);
     http.open("GET", url, true);
     http.onreadystatechange = autocomplete_reply;
     http.send(null);
  }else{
     window.parent.close_autocomplete();
  }
}

function autocomplete_reply(){
if(http.readyState == 4)
{
    var msgz = http.responseText;
    msgz = msgz.replace(/\+/g," ");
    msgz = unescape(msgz);
    
    if(msgz != 0){
       document.getElementById("autocomplete").innerHTML = msgz;
       window.parent.show_autocomplete();
    }else{
       document.getElementById("autocomplete").innerHTML = "";
       window.parent.close_autocomplete();
    }
 }else{
    if(http.readyState==1){
       document.getElementById("autocomplete").innerHTML = "<table width=100% border=0><tr><td align=center>Buscando dados...</td></tr></table>";
       window.parent.show_autocomplete();
    }
 }
}

function payment_method(box){
   if(box.options[box.selectedIndex].value == "Cheque" || box.options[box.selectedIndex].value == "Cheque pré-datado"){
      //show div
      document.getElementById("cheque_number").style.display = "inline";
   }else{
      //hide div
      document.getElementById("cheque_number").style.display = "none";
   }
}



function add_doc_number(id, value){
   if(id!=null && id!="" && value!=null && value!=""){
         //document.getElementById("temp").value = id;
         var url = "ajax_add_doc_number.php?id="+id;
         url = url + "&value="+value;
         url = url + "&cache=" + new Date().getTime();//para evitar problemas com o cache
         http.open("GET", url, true);
         http.onreadystatechange = add_doc_number_reply;
         http.send(null);
   }
}

function add_doc_number_reply(){
if(http.readyState == 4)
{
    var msgz = http.responseText;
    msgz = msgz.replace(/\+/g," ");
    msgz = unescape(msgz);
    
    //var tmp = document.getElementById("temp").value;
    
    if(msgz != ""){
         var data = msgz.split("|");
         document.getElementById("dcn"+data[1]).innerHTML = data[0];
    }
}else{
 if (http.readyState==1){
         //var tmp = document.getElementById("temp").value;
    }
 }
}




function tipo_de_debito(){
   
   if(document.frm.lancamento[0].checked == true){
         document.getElementById("esconde_tipo").style.display = "inline";
   }else{
         document.getElementById("esconde_tipo").style.display = "none";
      
   }
}