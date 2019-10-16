/*-----> VARIÁVEIS <-----*/
var fields = new Array(20);

for(var i=0;i<20;i++){
 fields[i]=new Array(20);
}

fields[0][0] = "atan";
fields[1][0] = "ord";
fields[2][0] = "anoi";
fields[3][0] = "anof";
fields[4][0] = "empresa";
fields[5][0] = "end";
fields[6][0] = "num";
fields[7][0] = "cidade";
fields[8][0] = "municipio";
fields[9][0] = "estado";
fields[10][0] = "dias";
fields[11][0] = "mes";
fields[12][0] = "ano";
fields[13][0] = "hora";
fields[14][0] = "min";
fields[15][0] = "sala";
fields[16][0] = "pres";
fields[17][0] = "vice";
fields[18][0] = "svp";
fields[19][0] = "sec";


var ntopicos = 0;


function insert_br(text){
    var normalized_Enters = text.replace(/\r|\n/g, "\r\n");
    var text_with_br = normalized_Enters.replace(/\r\n/g, "<br />");
    return text_with_br;
}

function remove_br(text){
    var normalized_Enters = text.replace(/<br>|<BR>/g, "<br><BR>");
    var text_with_br = normalized_Enters.replace(/<br><BR>/g, "\n");
    return text_with_br;
}

 function LTrim(str){
    var espaco = String.fromCharCode(32);
    var tamanho = str.length;
    var temp = "";
    if(tamanho < 0)
      return "";

    var temp2 = 0;

    while(temp2 < tamanho){
      if(str.charAt(temp2) == espaco){
        // não faz nada
      }
      else{
        temp = str.substring(temp2, tamanho);
        break;
      }
      temp2++;
    }
    return temp;
  }

function check(input, span){
var texto = LTrim(document.getElementById(input).value);
var entrada = document.getElementById(input);
 if(texto != ""){
    document.getElementById(span).innerHTML = insert_br(document.getElementById(input).value);
    //alert(document.getElementById(input));
//    document.getElementById('h').value = entrada.name;
//      document.getElementById(span).innerHTML += "<input type=hidden id="+entrada+" name="+entrada+" value="+entrada.value+">";

    if(input == "atan"){
       document.getElementById('n').innerHTML = document.getElementById(span).innerHTML;
    }else{
       //document.getElementById(span).innerHTML += "<input type=hidden id="+input+" name="+input+" value='"+document.getElementById(input).value+"'>";
    }
 }
}

function checkc(input, span, n){
 var texto = LTrim(document.getElementById(input).value);
 if(texto != ""){
    document.getElementById(span).innerHTML = insert_br(document.getElementById(input).value);
//    document.getElementById(span).innerHTML += "<a href=\"javascript:checkc('titulo"+n+"', 'span"+n+"');\"\">Ok</a>";
 }
}


function tTOs(input, span, size, n){
  if(document.getElementById(input)!=null){
     //alert(input);
  }else{
     //alert('sem');
    document.getElementById(span).innerHTML = "<input class=text type=text name=\""+input+"\" id=\""+input+"\" size="+size+" OnBlur=\"check('"+input+"', '"+span+"');\" value='"+document.getElementById(span).innerHTML+"'>";
    document.getElementById(input).focus();
  //  document.getElementById(span).innerHTML += "  [<a href=\"javascript:checkc('titulo"+n+"', 'span"+n+"', '"+n+"');\"\">Confirmar</a> | <a href=\"javascript:removeTopic("+n+");\"\">Excluir Tópico</a>]";
  }
}


function tTOc(input, span, size, n){
  if(document.getElementById(input)!=null){
     //alert(input);
  }else{
     //alert('sem');
    document.getElementById(span).innerHTML = "<select name=\""+input+"\" id=\""+input+"\" OnChange=\"check('"+input+"', '"+span+"');\"";
    document.getElementById(span).innerHTML+= "<option value=\"ordinária\" selected>ordinária</option>";
    document.getElementById(span).innerHTML+= "<option value=\"extraordinária\">extraordinária</option>";
    document.getElementById(span).innerHTML+= "</select>";
    document.getElementById(input).focus();
  //  document.getElementById(span).innerHTML += "  [<a href=\"javascript:checkc('titulo"+n+"', 'span"+n+"', '"+n+"');\"\">Confirmar</a> | <a href=\"javascript:removeTopic("+n+");\"\">Excluir Tópico</a>]";
  }
}

function tTOa(input, span, size){
  if(document.getElementById(input)!=null){
     //alert(input);
  }else{
     //alert('sem');
    document.getElementById(span).innerHTML = "<textarea name=\""+input+"\" id=\""+input+"\" cols='90%' rows="+size+" OnBlur=\"check('"+input+"', '"+span+"');\">"+remove_br(document.getElementById(span).innerHTML)+"</textarea>";
    document.getElementById(input).focus();

  }
}


function tTOi(input, span, size, n){
  if(document.getElementById(input)!=null){
     //alert(input);
  }else{
     //alert('sem');
    document.getElementById(span).innerHTML = "<input type=text name=\""+input+"\" id=\""+input+"\" size="+size+" OnBlur=\"check('"+input+"', '"+span+"');\" value='"+document.getElementById(span).innerHTML+"'>";
    document.getElementById(input).focus();
    document.getElementById(span).innerHTML += "  [<a href=\"javascript:checkc('titulo"+n+"', 'span"+n+"', '"+n+"');\"\">Confirmar</a> | <a href=\"javascript:removeTopic("+n+");\"\">Excluir Tópico</a>]";
  }
}


function addTopic(){
if( navigator.appName == "Microsoft Internet Explorer" ){
   var fieldname = prompt("Digite o Título do tópico:","");
   //cria o div
   var div = document.createElement("<div onClick=\"tTOi('titulo"+ntopicos+"', 'span"+ntopicos+"', 20, "+ntopicos+");\">");
   div.setAttribute('id','span'+ntopicos);
   div.setAttribute('align','center');
   div.setAttribute('style','font-weight:bold;');
}else{
   var fieldname = prompt("Digite o Título do tópico:","");
   //cria o div
   var div = document.createElement("div");
   div.setAttribute('id','span'+ntopicos);
   div.setAttribute('align','center');
   div.setAttribute('style','font-weight:bold;');
   div.setAttribute("onClick","tTOi('titulo"+ntopicos+"', 'span"+ntopicos+"', 20, "+ntopicos+");");
}
//div.innerHTML = "<center><input type=text name='titulo"+ntopicos+"' id='titulo"+ntopicos+"' size=20 OnChange=\"checkc('titulo"+ntopicos+"', 'span"+ntopicos+"');\" value='"+fieldname+"'><br>";<a href=\"alert(this)\">Excluir</a>
div.innerHTML = "<center><input class=text type=text name='titulo"+ntopicos+"' id='titulo"+ntopicos+"' size=20 value='"+fieldname+"'> [<a href=\"javascript:checkc('titulo"+ntopicos+"', 'span"+ntopicos+"', '"+ntopicos+"');\"\">Confirmar</a> | <a href=\"javascript:removeTopic("+ntopicos+");\"\">Excluir Tópico</a>]<br>";
var mydiv = document.getElementById("tdelements");
mydiv.appendChild(div);

var p = document.createElement("span");
p.setAttribute('id', 'p'+ntopicos);
p.innerHTML = "<br><p>";
mydiv.appendChild(p);


if( navigator.appName == "Microsoft Internet Explorer" ){
var div = document.createElement("<div onClick=\"tTOa('texto"+ntopicos+"', 'spancontent"+ntopicos+"', 10);\">");
div.setAttribute('id','spancontent'+ntopicos);
div.setAttribute("onClick","tTOa('texto"+ntopicos+"', 'spancontent"+ntopicos+"', 10);");
div.innerHTML = "<center><textarea name='texto"+ntopicos+"' id='texto"+ntopicos+"' cols=90% rows=10 OnChange=\"checkc('texto"+ntopicos+"', 'spancontent"+ntopicos+"', '"+ntopicos+"');\"></textarea>";
}else{
var div = document.createElement("div");
div.setAttribute('id','spancontent'+ntopicos);
div.setAttribute("onClick","tTOa('texto"+ntopicos+"', 'spancontent"+ntopicos+"', 10);");
div.innerHTML = "<center><textarea name='texto"+ntopicos+"' id='texto"+ntopicos+"' cols=90% rows=10 OnChange=\"checkc('texto"+ntopicos+"', 'spancontent"+ntopicos+"', '"+ntopicos+"');\"></textarea>";
}
//var mydiv = document.getElementById("tdelements");
mydiv.appendChild(div);
mydiv.appendChild(p);

//var t = document.getElementById("titulo0");


//checkc('titulo'+ntopicos, 'span'+ntopicos);
//alert(ntopicos);
ntopicos+=1;
//alert(ntopicos);
}



function removeTopic(n){
var mydiv = document.getElementById("tdelements");
var olddiv = document.getElementById("span"+n);
var olddivz = document.getElementById("spancontent"+n);
var p = document.getElementById("p"+n);
mydiv.removeChild(olddiv);
mydiv.removeChild(olddivz);
mydiv.removeChild(p);
}

function check_titles(){
   for(var z=0;z<=ntopicos;z++){
       if(document.getElementById("titulo"+z)){
          alert("Por favor, confirme o título: "+document.getElementById("titulo"+z).value);
          return false;
       }

       if(document.getElementById("texto"+z)){
          if(confirm("O campo para relatório com o título "+document.getElementById("span"+z).innerHTML+" está vázio, deseja excluir este tópico e finalizar a edição?")){
             removeTopic(z);
          }else{
             return false;
          }
       }
   }
   return true;
}

function Finish(){

//alert(document.form1.elements.length);
for(var x=0;x<document.form1.elements.length;x++){
   if(document.form1.elements[x].type == "text"){
      if(document.form1.elements[x].value ==""){
         alert('Preencha os campos para finalizar a ATA.');
         return false;
      }
       //alert(document.form1.elements[x].name);
      check(document.form1.elements[x].name, 'span'+document.form1.elements[x].name);
   }
}
//return false;

  if(check_titles()){
    for(var x=0;x<20;x++){
        if(document.getElementById(fields[x][0])){
            document.getElementById("d_"+fields[x][0]).value = document.getElementById(fields[x][0]).value;
        }else{
           if(document.getElementById("span"+fields[x][0])){
            document.getElementById("d_"+fields[x][0]).value = document.getElementById("span"+fields[x][0]).innerHTML;
            //alert(document.getElementById("span"+fields[x][0]).innerHTML);
           }
        }
    }

    for(var y=0;y<=ntopicos;y++){
       //if exist the DIV span+number (created dinamically to add topic title)
       if(document.getElementById("span"+y)){
           //iside we can have the input titulo+number
           if(document.getElementById("titulo"+y)){
              document.getElementById("d_titulos").value += document.getElementById("titulo"+y).value+"|";
           }else{
              document.getElementById("d_titulos").value += document.getElementById("span"+y).innerHTML+"|";
           }
       }

       if(document.getElementById("spancontent"+y)){
           if(document.getElementById("texto"+y)){
              document.getElementById("d_textos").value += document.getElementById("texto"+y).value+"|";
           }else{
              document.getElementById("d_textos").value += document.getElementById("spancontent"+y).innerHTML+"|";
           }
       }
    }
document.getElementById("finalizar").innerHTML = "";
document.getElementById("tosend").innerHTML = "<input class=button type=submit id=enviar name=enviar value='Salvar'>";
  }
}



function nextfield(){
//alert(document.form1.elements.length);
for(var x=0;x<document.form1.elements.length;x++){
   if(document.form1.elements[x].type == "text"){
      check(document.form1.elements[x].name, 'span'+document.form1.elements[x].name);
      //var to = document.form1.elements[x+1];
      var to = document.getElementById(document.form1.elements[x].name);
      //alert(document.form1.elements[x+1].name);
      to.focus();
      to.focus();
      return false;
   }
}
}





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

function select_cliente(){
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
       saida += "<td align=left  class=linksistema><font size=1><a href='ata_cipa_index.php?act=new&cod_cliente="+user[0]+"&cod_filial="+user[2]+"' class=linksistema>"+user[1]+"</a></td>";
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

