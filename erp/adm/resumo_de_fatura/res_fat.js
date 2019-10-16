String.PAD_LEFT  = 0;
String.PAD_RIGHT = 1;
String.PAD_BOTH  = 2;

String.prototype.pad = function(size, pad, side) {
  var str = this, append = "", size = (size - str.length);
  var pad = ((pad != null) ? pad : " ");
  if ((typeof size != "number") || ((typeof pad != "string") || (pad == ""))) {
    throw new Error("Wrong parameters for String.pad() method.");
  }
  if (side == String.PAD_BOTH) {
    str = str.pad((Math.floor(size / 2) + str.length), pad, String.PAD_LEFT);
    return str.pad((Math.ceil(size / 2) + str.length), pad, String.PAD_RIGHT);
  }
  while ((size -= pad.length) > 0) {
    append += pad;
  }
  append += pad.substr(0, (size + pad.length));
  return ((side == String.PAD_LEFT) ? append.concat(str) : str.concat(append));
}


var STR_PAD_LEFT = 1;
var STR_PAD_RIGHT = 2;
var STR_PAD_BOTH = 3;

function pad(str, len, pad, dir) {

	if (typeof(len) == "undefined") { var len = 0; }
	if (typeof(pad) == "undefined") { var pad = ' '; }
	if (typeof(dir) == "undefined") { var dir = STR_PAD_RIGHT; }

	if (len + 1 >= str.length) {

		switch (dir){

			case STR_PAD_LEFT:
				str = Array(len + 1 - str.length).join(pad) + str;
			break;

			case STR_PAD_BOTH:
				var right = Math.ceil((padlen = len - str.length) / 2);
				var left = padlen - right;
				str = Array(left+1).join(pad) + str + Array(right+1).join(pad);
			break;

			default:
				str = str + Array(len + 1 - str.length).join(pad);
			break;

		} // switch

	}

	return str;

}


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

function select_cliente(mes, ano){
var id = document.getElementById("cliente").value;
var url = "ajax_select_cliente.php?id="+id;
url = url + "&mes=" + mes;
url = url + "&ano=" + ano;
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
       if(user[6]>0){ //Se for Parceria comercial user[6] == 0
           if(user[3]>0){
              saida += "<tr>";
              saida += "<td align=center><font size=1>"+user[0]+"</td>";
              saida += "<td align=left class=linksistema onclick=\"if(confirm('Já existe fatura para este cliente este mês. Deseja continuar?')){var num = prompt('Selecione o número de parcelas','1/12');if(num != '' && num != null){location.href='cria_resumo_de_fatura.php?act=new&cod_cliente="+user[0]+"&cod_filial="+user[2]+"&mes="+user[4]+"&ano="+user[5]+"&pc="+user[6]+"&parcelas='+num+'';}}else{return false;};return false;\"><font size=1><a href='#' class=linksistema>[PC] "+user[1]+"</a></td>";//cria_resumo_de_fatura.php?act=new&cod_cliente="+user[0]+"&cod_filial="+user[2]+"
              saida += "<td align=center><font size=1>"+user[2]+"</td>";
              saida += "</tr>";
           }else{
              saida += "<tr>";
              saida += "<td align=center><font size=1>"+user[0]+"</td>";
              saida += "<td align=left class=linksistema onclick=\"var num = prompt('Selecione o número de parcelas','1/12');if(num != '' && num != null){location.href='cria_resumo_de_fatura.php?act=new&cod_cliente="+user[0]+"&cod_filial="+user[2]+"&mes="+user[4]+"&ano="+user[5]+"&pc="+user[6]+"&parcelas='+num+''};return false;\"><font size=1><a href='#' class=linksistema>[PC] "+user[1]+"</a></td>";//cria_resumo_de_fatura.php?act=new&cod_cliente="+user[0]+"&cod_filial="+user[2]+"
              saida += "<td align=center><font size=1>"+user[2]+"</td>";
              saida += "</tr>";
           }
       }else{
           if(user[3]>0){
              saida += "<tr>";
              saida += "<td align=center><font size=1>"+user[0]+"</td>";
              saida += "<td align=left class=linksistema onclick=\"if(confirm('Já existe fatura para este cliente este mês. Deseja continuar?')){var num = prompt('Selecione o número de parcelas','1/12');if(num != '' && num != null){location.href='cria_resumo_de_fatura.php?act=new&cod_cliente="+user[0]+"&cod_filial="+user[2]+"&mes="+user[4]+"&ano="+user[5]+"&pc="+user[6]+"&parcelas='+num+'';}}else{return false;};return false;\"><font size=1><a href='#' class=linksistema>"+user[1]+"</a></td>";//cria_resumo_de_fatura.php?act=new&cod_cliente="+user[0]+"&cod_filial="+user[2]+"
              saida += "<td align=center><font size=1>"+user[2]+"</td>";
              saida += "</tr>";
           }else{
              saida += "<tr>";
              saida += "<td align=center><font size=1>"+user[0]+"</td>";
              saida += "<td align=left class=linksistema onclick=\"var num = prompt('Selecione o número de parcelas','1/12');if(num != '' && num != null){location.href='cria_resumo_de_fatura.php?act=new&cod_cliente="+user[0]+"&cod_filial="+user[2]+"&mes="+user[4]+"&ano="+user[5]+"&pc="+user[6]+"&parcelas='+num+''};return false;\"><font size=1><a href='#' class=linksistema>"+user[1]+"</a></td>";//cria_resumo_de_fatura.php?act=new&cod_cliente="+user[0]+"&cod_filial="+user[2]+"
              saida += "<td align=center><font size=1>"+user[2]+"</td>";
              saida += "</tr>";
           }
       }
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
function update_fatura(){
var url = "update_fatura.php?fatura="+document.getElementById("fatid").value;
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
          retorno += "<td align=center><center><font size=1><a href='javascript:remove_fatura_produto("+data[0]+");' class=excluir><font size=1>Excluir</font></a><p><a href='edita_fatura_produto.php?id="+data[0]+"&cod_cliente="+data[2]+"&cod_filial="+data[3]+"&pc="+data[10]+"&fatura="+data[1]+"' class=fontebranca12><font size=1><b>Editar</b></font></a></font></td>";
          retorno += "<td align=left><font size=2>"+data[4]+"</font></td>";
          retorno += "<td align=center><font size=2>"+data[5]+"</font></td>";
          retorno += "<td align=center><font size=2>"+float2moeda(data[7])+"</font></td>";
          retorno += "<td align=center><font size=2>"+float2moeda((data[7]*data[5]))+"</font></td>";
          retorno += "</tr>";

          total+=(data[7]*data[5]);
          }

          retorno += "<tr>";
          retorno += "<td colspan=2 align=right><font size=2><b>TOTAL</b></td>";
          retorno += "<td align=right>&nbsp;</td>";
          retorno += "<td colspan=2 align=right><font size=2><b>R$ </b><b>"+float2moeda(total)+"</b></td>";
          retorno += "</table>";
    document.getElementById("dados").innerHTML = retorno;
    document.getElementById("orc_loading").className='loading_done';
    //document.getElementById("dados").style.visibility='hidden';
/*
    if(document.getElementById("dados").scrollHeight >220){
        parent.document.getElementById("find").height = document.getElementById("dados").scrollHeight; //40:
    }
  */
}else{
 if (http.readyState<4){
        //document.getElementById("orc_loading").style.display='block';
        document.getElementById("orc_loading").className='loading';
    }
 }
}



/*SIMULADOR DE ORCAMENTOS - ADICIONA PRODUTOS*/
function add_fatura_produto(id){
var url = "add_fatura_prod.php?fatura="+id;
url = url + "&cod_cliente=" + document.getElementById("cod_cliente").value;
url = url + "&cod_filial=" + document.getElementById("cod_filial").value;
url = url + "&qnt=" + document.getElementById("quantidade").value;
url = url + "&desc=" + document.getElementById("desc_preview").value;
if(document.getElementById('desconto').checked){
   url = url + "&valor=" + "-" + document.getElementById("valor").value;
}else{
   url = url + "&valor=" + document.getElementById("valor").value;
}

url = url + "&parcelas=" + document.getElementById("parcelas").value;
url = url + "&cache=" + new Date().getTime();//para evitar problemas com o cache
http.open("GET", url, true);
http.onreadystatechange = add_fatura_produto_reply;
http.send(null);
}

function add_fatura_produto_reply(){
if(http.readyState == 4)
{
//    window.parent.update_orcamento();
    var msgz = http.responseText;
    msgz = msgz.replace(/\+/g," ");
    msgz = unescape(msgz);
    if(msgz != ""){
          update_fatura();
          document.getElementById("desc_preview").value = "";
          document.getElementById("valor").value = "";
    }
}else{
 if (http.readyState==1){
        //document.getElementById("cpf").style.backgroundColor = "#aca5a5";
    }
 }
}





/*SIMULADOR DE ORCAMENTOS - REMOVE PRODUTOS*/
function remove_fatura_produto(pcode){
if(pcode >= 0){
var url = "remove_fatura_prod.php?fatura="+document.getElementById("fatid").value;
url = url + "&cod_cliente=" + document.getElementById("cod_cliente").value;
url = url + "&cod_filial=" + document.getElementById("cod_filial").value;
url = url + "&cod_produto=" + pcode;
url = url + "&cache=" + new Date().getTime();//para evitar problemas com o cache
http.open("GET", url, true);
http.onreadystatechange = remove_fatura_prod_reply;
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

function remove_fatura_prod_reply(){
if(http.readyState == 4)
{
    var msgz = http.responseText;
    msgz = msgz.replace(/\+/g," ");
    msgz = unescape(msgz);
    //window.parent.update_fatura();
    update_fatura();
}else{
 if (http.readyState==1){
        //document.getElementById("cpf").style.backgroundColor = "#aca5a5";
    }
 }
}

String.prototype.trim = function() {
 // skip leading and trailing whitespace
 // and return everything in between
	return this.replace(/^\s*(\b.*\b|)\s*$/, "$1");
}



// create the prototype on the String object
String.prototype.trimLeadingZeros = function(todos) { //true, false
    if (""+todos=="undefined") todos=false;

    //tirando os zeros do começo
    var i=0;
    while ((i < this.length- (todos?0:1) ) && (this.substring(i,i+1)=='0')) i++;
    valor = this.substring(i);
	return valor;
}

function stripCharsNotInBag(bag, campo) { //campo só deve ser passado se for para alterar seu valor
	//bag = "0123456789";

	var temp="";
	if (campo==null) temp=this;
	if (campo!=null) temp=campo.value;

	var result = "";
	for (i=0; i<temp.length; i++){
		character = temp.charAt(i);
		if (bag.indexOf(character) != -1)
			result += character;
	}
	if (campo!=null && campo.value!=result) {
		campo.value=result;
	}
	return result;
}

// create the prototype on the String object
String.prototype.stripCharsNotInBag = stripCharsNotInBag;

function stripNotNumber(num) {
	return num.stripCharsNotInBag("0123456789");
}


var BASE_DATE = new Date("1997","09","07")  // 1999-out-07
var MAX_DATE = new Date("2025","01","21")   // 2025-fev-21

function ValidaData (data) {
	dt = data.value;

	if (dt.length<10) {
		alert("Tamnho inválido, digitar no formato dd/mm/aaaa.");
		data.select();
		return false;
	}

	dia = dt.substring(0,2);
	mes = dt.substring(3,5);
	ano = dt.substring(6,10);

	// month argument must be in the range 1 - 12
	// javascript month range : 0- 11
	var tempDate = new Date(ano,mes-1,dia);

	if ( (ano == tempDate.getFullYear()) &&
	     (mes == (tempDate.getMonth()+1)) &&
	     (dia == tempDate.getDate()) ) {
		var tmp = new Date();
		var todayDate = new Date(tmp.getFullYear(), tmp.getMonth(), tmp.getDate());

	     	//return (tempDate >= BASE_DATE && tempDate<=MAX_DATE && tempDate>=todayDate)
	     	return (tempDate >= BASE_DATE && tempDate<=MAX_DATE)
	} else {
		alert("Data inválida, digitar no formato dd/mm/aaaa.");
		data.select();
		return false;
	}
}


function formataDataDigitada(campo) {
    // retira tudo que nao eh numerico
    var temp=campo.value;
    var valor="";

    valor=stripNotNumber(temp);

    if (valor.length>8) { valor=valor.substring(0,8); }

    var j=0;
    temp="";
    for (var tam=0;tam<valor.length;tam++) {
        if (j==0) {
            temp+=valor.substring(tam,tam+1);
            if ( (tam==1) && (valor.length>2) ) { j++; temp+="/"; }
        } else if (j==1) {
            temp+=valor.substring(tam,tam+1);
            if ( (tam==3) && (valor.length>4) ) { j++; temp+="/"; }
        } else if (j==2) {
            temp+=valor.substring(tam,tam+1);
        }
    }

    if (campo.value!=temp) {
        campo.value=temp;
    }
}



//onkeypress="return FormataReais(this, '.', ',', event);"
function FormataReais(fld, milSep, decSep, e) {
var sep = 0;
var key = '';
var i = j = 0;
var len = len2 = 0;
var strCheck = '0123456789';
var aux = aux2 = '';
var whichCode = (window.Event) ? e.which : e.keyCode;
 if ((whichCode == 13) || (whichCode == 0) || (whichCode == 8))
return true;
key = String.fromCharCode(whichCode);  // Valor para o código da Chave
if (strCheck.indexOf(key) == -1) return false;  // Chave inválida
len = fld.value.length;
for(i = 0; i < len; i++)
if ((fld.value.charAt(i) != '0') && (fld.value.charAt(i) != decSep)) break;
aux = '';
for(; i < len; i++)
if (strCheck.indexOf(fld.value.charAt(i))!=-1) aux += fld.value.charAt(i);
aux += key;
len = aux.length;
if (len == 0) fld.value = '';
if (len == 1) fld.value = '0'+ decSep + '0' + aux;
if (len == 2) fld.value = '0'+ decSep + aux;
if (len > 2) {
aux2 = '';
for (j = 0, i = len - 3; i >= 0; i--) {
if (j == 3) {
aux2 += milSep;
j = 0;
}
aux2 += aux.charAt(i);
j++;
}
fld.value = '';
len2 = aux2.length;
for (i = len2 - 1; i >= 0; i--)
fld.value += aux2.charAt(i);
fld.value += decSep + aux.substr(len - 2, len);
}
return false;
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
            colorcell = ((day_dat == day_today) && (year_dat == year_today) ? " bgcolor='#FFCC00' " : "" ) //(mmonth+1).toString()
            txt += "<td"+colorcell+" align=center><a href=javascript:block('"+  pad(d.toString(), 2, "0", STR_PAD_LEFT) + "/" + pad((mmonth+1).toString(), 2, "0", STR_PAD_LEFT) + "/" + ano.toString() +"','"+ obj +"','" + div +"') class='data'>"+ d.toString() + "</a></td>"
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

function update_data(fatura_id){
   var url = "ajax_update_data.php?fatura="+fatura_id;
   url = url + "&contrato=" + document.getElementById("contrato").value;
   url = url + "&emissao=" + document.getElementById("emissao").value;
   url = url + "&vencimento=" + document.getElementById("vencimento").value;
   alert(document.getElementById("forma_pagamento").value);
   url = url + "&forma_pagamento=" + document.getElementById("forma_pagamento").value;
   url = url + "&cache=" + new Date().getTime();//para evitar problemas com o cache
   http.open("GET", url, true);
   http.onreadystatechange = update_reply;
   http.send(null);
}

function update_reply(){
if(http.readyState == 4)
{
    var msgz = http.responseText;
    msgz = msgz.replace(/\+/g," ");
    msgz = unescape(msgz);
    document.getElementById("periodo_de_cobranca").innerHTML = msgz;
    window.parent.update_fatura();
}else{
 if (http.readyState==1){
        //document.getElementById("cpf").style.backgroundColor = "#aca5a5";
    }
 }
}



function check_planilha(fatura_id){
   //alert(fatura_id);
   var url = "ajax_check_planilha.php?fatura="+fatura_id;
   url = url + "&cache=" + new Date().getTime();//para evitar problemas com o cache
   http.open("GET", url, true);
   http.onreadystatechange = check_planilha_reply;
   http.send(null);
}

function check_planilha_reply(){
if(http.readyState == 4)
{
    var msgz = http.responseText;
    msgz = msgz.replace(/\+/g," ");
    msgz = unescape(msgz);
    if(msgz != ""){
       if(msgz == 1){
          alert('Planilha marcada como enviada!');
       }else{
          alert('Planilha marcada como não enviada!')
       }
    }else{
       alert('Erro ao marcar planilha!');
    }
}else{
 if (http.readyState==1){
        //document.getElementById("cpf").style.backgroundColor = "#aca5a5";
    }
 }
}


function migrar_planilha(fatura_id, dias){
   //alert(fatura_id);
   var url = "ajax_migrar_planilha.php?fatura="+fatura_id;
   url = url + "&dias=" + dias;
   url = url + "&cache=" + new Date().getTime();//para evitar problemas com o cache
   http.open("GET", url, true);
   http.onreadystatechange = migrar_planilha_reply;
   http.send(null);
}

function migrar_planilha_reply(){
if(http.readyState == 4)
{
    var msgz = http.responseText;
    msgz = msgz.replace(/\+/g," ");
    msgz = unescape(msgz);
    var data = msgz.split("|");
    if(msgz != ""){
       alert(data[0]);
       document.getElementById("migrar"+data[1]).innerHTML = "<center><font size=1 color=white><b>Migrado!</b></font></center>";
    }else{
       alert('Erro ao migrar planilha!');
    }
}else{
 if (http.readyState==1){
        //document.getElementById("migrar"+data[1]).style.backgroundColor = "#aca5a5";
    }
 }
}

function colorir(id){
   //alert(document.getElementById("col"+id).bgcolor);
   var cor = '';
   var act = 0;
   if(document.getElementById("col11"+id).value == 1){
      cor = '#006633';
      document.getElementById("col11"+id).value = 0;
      act = 0;
   }else{
      cor = '#D75757';
      document.getElementById("col11"+id).value = 1;
      act = 1;
   }
   for(var x=1;x<10;x++){
      document.getElementById("col"+x+id).bgColor = cor;
   }
   
   var url = "ajax_tag_planilha.php?fatura="+id;
   url = url + "&act=" + act;
   url = url + "&cache=" + new Date().getTime();//para evitar problemas com o cache
   http.open("GET", url, true);
   http.onreadystatechange = tag_reply;
   http.send(null);
}

function tag_reply(){
if(http.readyState == 4)
{
    var msgz = http.responseText;
    msgz = msgz.replace(/\+/g," ");
    msgz = unescape(msgz);
    //var data = msgz.split("|");
    //alert(msgz);
    if(msgz != ""){
       //alert(data[0]);
       //document.getElementById("migrar"+data[1]).innerHTML = "<center><font size=1 color=white><b>Migrado!</b></font></center>";
    }else{
       alert('Erro ao marcar planilha na database!(Não será armazenada a marcação)');
    }
}else{
 if (http.readyState==1){
        //document.getElementById("migrar"+data[1]).style.backgroundColor = "#aca5a5";
    }
 }
}








function notificar_protesto(fatura_id){
   //alert(fatura_id);
   var url = "ajax_notificar_protesto.php?fatura="+fatura_id;
   url = url + "&cache=" + new Date().getTime();//para evitar problemas com o cache
   http.open("GET", url, true);
   http.onreadystatechange = notificar_protesto_reply;
   http.send(null);
}

function notificar_protesto_reply(){
if(http.readyState == 4){
    var msgz = http.responseText;
    msgz = msgz.replace(/\+/g," ");
    msgz = unescape(msgz);
    var data = msgz.split("|");
    if(msgz != ""){
       alert(data[0]);
       document.getElementById("notificar"+data[1]).innerHTML = "<center><font size=1 color=white><i><b>[Notificado]</b></i></font></center>";
    }else{
       alert('Erro ao notificar cliente!');
    }
}else{
 if (http.readyState==1){
        //document.getElementById("migrar"+data[1]).style.backgroundColor = "#aca5a5";
    }
 }
}
