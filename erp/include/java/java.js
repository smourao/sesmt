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
document.getElementById("tosend").innerHTML = "<input class=button type=submit id=enviar name=enviar value='Versão para Impressão'>";
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


/* CAMPO LOGIN*/
function verify_login(){
  alert('Para sua segurança, utilize nosso teclado virtual!');
  document.getElementById('senha').value = '';
  return false;
}

function select_pesquisa(){
  var pes = document.getElementById("pesquisa");
  //alert(pes.options.selectedIndex);
  if(pes.options.selectedIndex > 0){
     switch(pes.options.selectedIndex){
        case 1:
           self.location.href='site.php?page=usuario&p=registro_cipa';
        break;
        case 2:
           self.location.href='site.php?page=usuario&p=contigcipa';
        break;
        case 3:
           self.location.href='site.php?page=usuario&p=contigbrigada';
        break;
        case 4:
           self.location.href='site.php?page=usuario&p=calendcipa';
        break;
        case 5:
           self.location.href='site.php?page=usuario&p=cons_risco';
        break;
        case 6:
           self.location.href='site.php?page=usuario&p=ataip';
        break;
        case 7:
           self.location.href='site.php?page=usuario&p=prot_entrega_ppp';
        break;
		case 8:
			self.location.href='site.php?page=usuario&p=ambulatorio';
		break;
/*        default:
        break;*/
     }
  }
}

/*
function getMouseXY(e) {
  if (IE) { // grab the x-y pos.s if browser is IE
    tempX = event.clientX + document.body.scrollLeft;
    tempY = event.clientY + document.body.scrollTop;
  } else {  // grab the x-y pos.s if browser is NS
    tempX = e.pageX;
    tempY = e.pageY;
  }
  // catch possible negative values in NS4
  if (tempX < 0){tempX = 0;}
  if (tempY < 0){tempY = 0;}
  // show the position values in the form named Show
  // in the text fields named MouseX and MouseY
  document.Show.MouseX.value = tempX;
  document.Show.MouseY.value = tempY;
  return true;
}    */


function scrollit(item){
      if( navigator.appName == "Microsoft Internet Explorer" ){
          var Y = document.body.scrollTop;
          Y+=140;
          document.getElementById(item).style.top = Y;//event.clientY + document.body.scrollTop;
      }else{
          document.captureEvents(Event.MOUSEMOVE);
          var Y = self.pageYOffset;//item.pageY;
          Y+=140;
          if(Y < 0){Y = 0;}
          document.getElementById(item).style.top = Y;
      }
      //alert(item);
}

function showdiv(item) {
/*// Detect if the browser is IE or not.
// If it is not IE, we assume that the browser is NS.
var IE = document.all?true:false;
// If NS -- that is, !IE -- then set up for mouse capture
if (!IE) document.captureEvents(Event.MOUSEMOVE);
// Set-up to use getMouseXY function onMouseMove
//document.onmousemove = getMouseXY;
// Temporary variables to hold mouse x-y pos.s
var tempX = 0;
var tempY = 0;

  if (IE) { // grab the x-y pos.s if browser is IE
    tempX = event.clientX + document.body.scrollLeft;
    tempY = event.clientY + document.body.scrollTop;
  } else {  // grab the x-y pos.s if browser is NS
    tempX = e.pageX;
    tempY = e.pageY;
  }
  // catch possible negative values in NS4
  if (tempX < 0){tempX = 0;}
  if (tempY < 0){tempY = 0;}
  // show the position values in the form named Show
  // in the text fields named MouseX and MouseY
  //document.Show.MouseX.value = tempX;
  //document.Show.MouseY.value = tempY;
                        */

   document.getElementById('ppra').style.display="none";
   document.getElementById('pcmat').style.display="none";
   document.getElementById('lie').style.display="none";
   document.getElementById('mr').style.display="none";
   document.getElementById('ppp').style.display="none";
   document.getElementById('ltcat').style.display="none";
   document.getElementById('sipat').style.display="none";
   document.getElementById('cipa').style.display="none";
   document.getElementById('inst').style.display="none";
   document.getElementById('pscip').style.display="none";
   document.getElementById('proa').style.display="none";
   document.getElementById('le').style.display="none";
   document.getElementById('pscv').style.display="none";
   document.getElementById('epi').style.display="none";
   document.getElementById('rip').style.display="none";
   document.getElementById('rpe').style.display="none";
   document.getElementById('pa').style.display="none";
   document.getElementById('lpm').style.display="none";
   document.getElementById('lqa').style.display="none";
   document.getElementById('rcsc').style.display="none";
   document.getElementById('rts').style.display="none";

   if (document.getElementById(item).style.display=="none") {
      document.getElementById(item).style.display="block";
       /*
      window.onload = function() {
         document.body.onscroll= function() {
          //document.getElementById("result").innerHTML = "Scroll Event !!";

        }
      }   */
      setInterval("scrollit('"+item+"')",100);
      //window.attachEvent("onscroll",alert);
      /*
      if (navigator.appName.indexOf("Microsoft")!=-1) {
      toppos = document.body.clientHeight / 2 - 100;
      leftpos = document.body.clientWidth / 2 - 100;
      }else{
      toppos = window.innerHeight / 2 - 100;
      leftpos = window.innerWidth / 2 - 100;
      }*/
      
   }else{
      document.getElementById(item).style.display="none";
   }
}

function closediv(item) {
      opener.document.getElementById(item).style.display="none";
      alert('');
}

function last_url(){
// Este Script mostra na tela a ultima pagina apartir do historico
if (document.referrer)
{
//document.write("<B>Você estava em:</B>");
return document.referrer;
}
}
// End


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

function Imprimir(){
//alert(document.form1.elements.length);
for(var x=0;x<document.form1.elements.length;x++){
   if(document.form1.elements[x].type == "text"){
      if(document.form1.elements[x].value ==""){
         alert('Preencha os campos para finalizar a O.S.');
         return false;
     }else{
		return true;
	 }
   }
   }
}

function Print(){
//alert(document.form1.elements.length);
for(var x=0;x<document.form1.elements.length;x++){
   if(document.form1.elements[x].type == "text"){
      if(document.form1.elements[x].value ==""){
         alert('Preencha os campos para finalizar a ATA.');
         return false;
     }else{
		return true;
	 }
   }
   }
}

function Write(){
//alert(document.form1.elements.length);
for(var x=0;x<document.form1.elements.length;x++){
   if(document.form1.elements[x].type == "text"){
      if(document.form1.elements[x].value ==""){
         alert('Preencha os campos para finalizar o Dimensionamento.');
         return false;
     }else{
		return true;
	 }
   }
   }
}

/* alert(document.form1.elements[x].name);
      check(document.form1.elements[x].name, 'span'+document.form1.elements[x].name);
   }
}*/

function produto_revenda(){
    if(document.getElementById("ps").selectedIndex == 2){
       document.getElementById("dvi").style.display = "block";
    }else{
       document.getElementById("dvi").style.display = "none";
    }
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

/* CAMPO PESQUISA AMBULATORIAL*/
function pesq(){
  if(document.getElementById('risco').value > 4 ||   document.getElementById('risco').value < 1 ||   document.getElementById('risco').value == ''){
	 alert('Grau de risco inválido! \nInforme um valor entre 1 e 4.');
	 return false;
  }else if(document.getElementById('f').value == ""){
	 alert('Digite a Quantidade de Colaboradores.');	  
	 return false;
  }else{
	return true;  
  }
  
}
