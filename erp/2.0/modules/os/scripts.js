 function moeda(campo, e)
 {
    var SeparadorDecimal = ","
    var SeparadorMilesimo = "."
    var sep = 0;
    var key = '';
    var i = j = 0;
    var len = len2 = 0;
    var strCheck = '0123456789';
    var aux = aux2 = '';
    var whichCode = (window.Event) ? e.which : e.keyCode;

    if (whichCode == 13) return true;
    key = String.fromCharCode(whichCode); // Valor para o código da Chave

    if (strCheck.indexOf(key) == -1) return true; // Chave inválida
    len = campo.value.length;
    for(i = 0; i < len; i++)
        if ((campo.value.charAt(i) != '0') && (campo.value.charAt(i) != SeparadorDecimal)) break;

    aux = '';
    for(; i < len; i++)
        if (strCheck.indexOf(campo.value.charAt(i))!=-1) aux += campo.value.charAt(i);
        
    aux += key;
    len = aux.length;

    if (len == 0) campo.value = '';
    if (len == 1) campo.value = '0'+ SeparadorDecimal + '0' + aux;
    if (len == 2) campo.value = '0'+ SeparadorDecimal + aux;
    if (len > 2) {
        aux2 = '';
        for (j = 0, i = len - 3; i >= 0; i--) {
            if (j == 3) {
                aux2 += SeparadorMilesimo;
                j = 0;
            }
            aux2 += aux.charAt(i);
            j++;
        }
        campo.value = '';
        len2 = aux2.length;
        for (i = len2 - 1; i >= 0; i--)
        campo.value += aux2.charAt(i);
        campo.value += SeparadorDecimal + aux.substr(len - 2, len);
    }
    return false;
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

// JavaScript Document
function MM_goToURL() { //v3.0
	  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
	  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}

// Scripts para mascara do sistema
function formatar(src, mask)
{
  var i = src.value.length;
  var saida = mask.substring(0,1);
  var texto = mask.substring(i)
if (texto.substring(0,1) != saida)
  {
        src.value += texto.substring(0,1);
  }
}

// Confirmação do excluir e alterar do cadastro das clínicas
function aviso_cli(cod_clinica){
	if (window.confirm (' Deseja Realmente Excluir Essa Clínica? '))
	{
	  window.alert(' Arquivo Excluido com Sucesso! ');
	  location.href='lista_clinicas.php?cod_clinica='+$cod_clinica;
	}
}
function aviso_clin(cod_clinica){
	if (window.confirm ('Deseja Realmente Alterar a Clínica?'))
	{
		window.alert('Dados Alterados com Sucesso!');
		location.href='cadastro_clinicas_alt.php?cod_clinica'+$cod_clinica;
	}
}

// Tela Principal
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_showHideLayers() { //v6.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}

// Botões com Imagem
var botoes;
function valore(botoes){
	document.cadastro.valor.value=botoes;
}

// Campos Obrigatórios
 function valida()
 {
	 if(document.cadastro.cnae_digitado.value == "")
	{
	   alert("Campo ''CNAE'' vazio! Preencha o campo.");
	   document.cadastro.cnae_digitado.focus();
	   return false;
	}
	else
    	if (document.cadastro.numero_funcionarios.value == "")
	{
	   alert('Campo "FUNCIONÁRIO" vazio! Preencha o campo.');
	   document.cadastro.numero_funcionarios.focus();
	   return false;
	}
	else
    	if (document.cadastro.cod_cliente.value == "")
	{
	   alert('Campo "CLIENTE" vazio! Preencha o campo.');
	   document.cadastro.cod_cliente.focus();
	   return false;
	}
	else
    	if (document.cadastro.filial_id.value == "")
	{
	   alert('Campo "FILIAL" vazio! Preencha o campo.');
	   document.cadastro.filial_id.focus();
	   return false;
	}
	else {
		valore('gravar');
	}
 }

 // Confirmação do excluir e alterar do cadastro de Franquias
function aviso_fra(associada_id){
	if (window.confirm (' Deseja Realmente Excluir Esse Arquivo? '))
	{
	  window.alert(' Arquivo Excluido com Sucesso! ');
	  location.href='associada_adm.php?associada_id='+$associada_id;
	}
}
function aviso_fran(associada_id){
	if (window.confirm ('Deseja Realmente Alterar Essa Franquia?'))
	{
		window.alert('Dados Alterados com Sucesso!');
		location.href='associada_adm.php?associada_id'+$associada_id;
	}
}

 // Confirmação do excluir e alterar do cadastro de Aparelhos
function aviso_apa(cod_aparelho){
	if (window.confirm (' Deseja Realmente Excluir Esse Arquivo? '))
	{
	  window.alert(' Arquivo Excluido com Sucesso! ');
	  location.href='aparelho_adm.php?cod_aparelho='+$cod_aparelho;
	}
}
function aviso_apar(cod_aparelho){
	if (window.confirm ('Deseja Realmente Alterar Esse Arquivo?'))
	{
		//window.alert('Dados Alterados com Sucesso!');
		location.href='aparelho_adm.php?cod_aparelho'+$cod_aparelho;
	}
}

function tExame(){
     if(document.getElementById("exame[]").options[document.getElementById("exame[]").length-1].selected){
       if(document.getElementById("outro")){
       }else{
           document.getElementById("auxi").innerHTML = "Outros: <input name='outro' id='outro' type='text'>";
       }
     }else{
        document.getElementById("auxi").innerHTML = "";

     }
}

function fdp(){
	//alert("ok");
	var box = document.getElementById("resultado");
	if(box.options[box.selectedIndex].index == 7){
		var txt = document.createElement("textarea");
		txt.setAttribute("id","restricao");
		txt.setAttribute("rows", "5");
		txt.setAttribute("cols", "90%");
		txt.value=document.getElementById("abc").value;
		txt.style.width = '100%';

		var target = document.getElementById("zxc");
		target.appendChild(txt);

	}
}

function Check(){
document.getElementById("txt").value = document.getElementById("restricao").value;
//alert(document.getElementById("txt").value);
return true;
}

function savedata(){
if(!document.getElementById("cod_prod").value){
    if(confirm('Este produto não está no cadastro de produto, deseja adicioná-lo?','')){
       //return true;
    }else{
       return false;
    }
}
    //alert('indo');
    var url = "add_epi.php?id="+document.getElementById("funcao").value;
    url = url + "&cod_prod=" +document.getElementById("cod_prod").value;
    url = url + "&cod_epi=" +document.getElementById("cod_epi").value;
    url = url + "&cache=" + new Date().getTime();
    //alert('ok');
    http.open("GET", url, true);
    http.onreadystatechange = save_reply;
    http.send(null);
}

function save_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
	var data = msg.split("|");
    var r = "<table border=0 cellpadding=\"1\" cellspacing=\"1\" valign=top>";

    r += "<tr><td width=5% align=center bgcolor=\"#009966\"><b>ID</b></td><td align=center bgcolor=\"#009966\"><b>Descrição</b></td><td width=5% align=center bgcolor=\"#009966\"><b>Excluir</b></td>        </tr>";

	for(var x=0;x<data.length-1;x++){
          //r += "<tr><td>"+(x+1) + "</td><td>" + data[x] + "</td><td align=center><a href='javascript:remove_epi(".$r[$x]['id']});'>X</a></td></tr>";
         r+=data[x];
	}
   r+="</table>";
	document.getElementById("cadastrados").innerHTML = r;
	document.getElementById("funcao").value = "";
}else{
    if(http.readyState==1){
       document.getElementById("cadastrados").innerHTML = "<center>Atualizando...</center>";
    }
}
}

function save_setor_epi(){
if(!document.getElementById("cod_prod").value){
    if(confirm('Este produto não está no cadastro de produto, deseja adicioná-lo?','')){
       //return true;
    }else{
       return false;
    }
}
    var txt = escape(document.getElementById("funcao").value);
    var url = "add_epi_setor.php?id="+ txt;
    url = url + "&cod_epi=" +document.getElementById("cod_epi").value;
    url = url + "&cod_prod=" +document.getElementById("cod_prod").value;
    url = url + "&cache=" + new Date().getTime();
    http.open("GET", url, true);
    http.onreadystatechange = save_setor_epi_reply;
    http.send(null);
}

function save_setor_epi_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
	var data = msg.split("|");
    var r = "<table border=0 cellpadding=\"1\" cellspacing=\"1\" valign=top>";

    r += "<tr><td width=5% align=center bgcolor=\"#009966\"><b>ID</b></td><td align=center bgcolor=\"#009966\"><b>Descrição</b></td><td width=5% align=center bgcolor=\"#009966\"><b>Excluir</b></td>        </tr>";

	for(var x=0;x<data.length-1;x++){
          //r += "<tr><td>"+(x+1) + "</td><td>" + data[x] + "</td><td align=center><a href='javascript:remove_epi(".$r[$x]['id']});'>X</a></td></tr>";
         r+=data[x];
	}
   r+="</table>";
	document.getElementById("cadastrados").innerHTML = r;
	document.getElementById("funcao").value = "";
}else{
    if(http.readyState==1){
       document.getElementById("cadastrados").innerHTML = "<center>Atualizando...</center>";
    }
}
}


function remove_setor_epi(x){
    var url = "remove_setor_epi.php?id=" + x;
    url = url + "&cod_epi=" +document.getElementById("cod_epi").value;
    url = url + "&cache=" + new Date().getTime();
    http.open("GET", url, true);
    http.onreadystatechange = remove_setor_epi_reply;
    http.send(null);
}

function remove_setor_epi_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
	var data = msg.split("|");
    var r = "<table border=0 cellpadding=\"1\" cellspacing=\"1\" valign=top>";

    r += "<tr><td width=5% align=center bgcolor=\"#009966\"><b>ID</b></td><td align=center bgcolor=\"#009966\"><b>Descrição</b></td><td width=5% align=center bgcolor=\"#009966\"><b>Excluir</b></td>        </tr>";

	for(var x=0;x<data.length-1;x++){
         r+=data[x];
	}
   r+="</table>";
	document.getElementById("cadastrados").innerHTML = r;
	document.getElementById("funcao").value = "";
}else{
    if(http.readyState==1){
       document.getElementById("cadastrados").innerHTML = "<center>Atualizando...</center>";
    }
}
}



function remove_epi(x){
    var url = "remove_epi.php?id=" + x;
    url = url + "&cod_epi=" +document.getElementById("cod_epi").value;
    url = url + "&cache=" + new Date().getTime();

    http.open("GET", url, true);
    http.onreadystatechange = remove_epi_reply;
    http.send(null);
}

function remove_epi_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
	var data = msg.split("|");
    var r = "<table border=0 cellpadding=\"1\" cellspacing=\"1\" valign=top>";

    r += "<tr><td width=5% align=center bgcolor=\"#009966\"><b>ID</b></td><td align=center bgcolor=\"#009966\"><b>Descrição</b></td><td width=5% align=center bgcolor=\"#009966\"><b>Excluir</b></td>        </tr>";

	for(var x=0;x<data.length-1;x++){
          //r += "<tr><td>"+(x+1) + "</td><td>" + data[x] + "</td><td align=center><a href='javascript:remove_epi(".$r[$x]['id']});'>X</a></td></tr>";
         r+=data[x];
	}
   r+="</table>";
	document.getElementById("cadastrados").innerHTML = r;
	document.getElementById("funcao").value = "";
}else{
    if(http.readyState==1){
       document.getElementById("cadastrados").innerHTML = "<center>Atualizando...</center>";
    }
}
}





function save_setor_medi(){
    var url = "add_setor_medi.php?id="+document.getElementById("funcao_medi").value;
    url = url + "&cod_medi=" +document.getElementById("cod_medi").value;
    //url = url + "&cod_prod=" +document.getElementById("cod_prod").value;
    url = url + "&cache=" + new Date().getTime();
    http.open("GET", url, true);
    http.onreadystatechange = save_setor_medi_reply;
    http.send(null);
}

function save_setor_medi_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
	var data = msg.split("|");
    var r = "<table border=0 cellpadding=\"1\" cellspacing=\"1\" valign=top>";
    r += "<tr><td width=5% align=center bgcolor=\"#009966\"><b>ID</b></td><td align=center bgcolor=\"#009966\"><b>Descrição</b></td><td width=5% align=center bgcolor=\"#009966\"><b>Excluir</b></td>        </tr>";
	for(var x=0;x<data.length-1;x++){
         r+=data[x];
	}
   r+="</table>";
	document.getElementById("cadastrados").innerHTML = r;
	document.getElementById("funcao_medi").value = "";
}else{
    if(http.readyState==1){
       document.getElementById("cadastrados").innerHTML = "<center>Atualizando...</center>";
    }
}
}


function remove_setor_medi(x){
    var url = "remove_setor_medi.php?id=" + x;
    url = url + "&cod_medi=" +document.getElementById("cod_medi").value;
    url = url + "&cache=" + new Date().getTime();
    http.open("GET", url, true);
    http.onreadystatechange = remove_setor_medi_reply;
    http.send(null);
}


function remove_setor_medi_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
	var data = msg.split("|");
    var r = "<table border=0 cellpadding=\"1\" cellspacing=\"1\" valign=top>";
    r += "<tr><td width=5% align=center bgcolor=\"#009966\"><b>ID</b></td><td align=center bgcolor=\"#009966\"><b>Descrição</b></td><td width=5% align=center bgcolor=\"#009966\"><b>Excluir</b></td>        </tr>";
	for(var x=0;x<data.length-1;x++){
         r+=data[x];
	}
   r+="</table>";
	document.getElementById("cadastrados").innerHTML = r;
}else{
    if(http.readyState==1){
       document.getElementById("cadastrados").innerHTML = "<center>Atualizando...</center>";
    }
}
}



function save_medi(){

    var url = "add_medi.php?id="+document.getElementById("funcao_medi").value;
    url = url + "&cod_medi=" +document.getElementById("cod_medi").value;
    url = url + "&cache=" + new Date().getTime();
    //alert('ok');
     //alert('');
    http.open("GET", url, true);
    http.onreadystatechange = save_medi_reply;
    http.send(null);
}

function save_medi_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
	var data = msg.split("|");
    var r = "<table border=0 cellpadding=\"1\" cellspacing=\"1\" valign=top>";

    r += "<tr><td width=5% align=center bgcolor=\"#009966\"><b>ID</b></td><td align=center bgcolor=\"#009966\"><b>Descrição</b></td><td width=5% align=center bgcolor=\"#009966\"><b>Excluir</b></td>        </tr>";

	for(var x=0;x<data.length-1;x++){
          //r += "<tr><td>"+(x+1) + "</td><td>" + data[x] + "</td><td align=center><a href='javascript:remove_epi(".$r[$x]['id']});'>X</a></td></tr>";
         r+=data[x];
	}
   r+="</table>";
	document.getElementById("cadastrados").innerHTML = r;
	document.getElementById("funcao_medi").value = "";
}else{
    if(http.readyState==1){
       document.getElementById("cadastrados").innerHTML = "<center>Atualizando...</center>";
    }
}
}


function remove_medi(x){
    var url = "remove_medi.php?id=" + x;
    url = url + "&cod_medi=" +document.getElementById("cod_medi").value;
    url = url + "&cache=" + new Date().getTime();

    http.open("GET", url, true);
    http.onreadystatechange = remove_medi_reply;
    http.send(null);
}

function remove_medi_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
	var data = msg.split("|");
    var r = "<table border=0 cellpadding=\"1\" cellspacing=\"1\" valign=top>";

    r += "<tr><td width=5% align=center bgcolor=\"#009966\"><b>ID</b></td><td align=center bgcolor=\"#009966\"><b>Descrição</b></td><td width=5% align=center bgcolor=\"#009966\"><b>Excluir</b></td>        </tr>";

	for(var x=0;x<data.length-1;x++){
          //r += "<tr><td>"+(x+1) + "</td><td>" + data[x] + "</td><td align=center><a href='javascript:remove_epi(".$r[$x]['id']});'>X</a></td></tr>";
         r+=data[x];
	}
   r+="</table>";
	document.getElementById("cadastrados").innerHTML = r;
	//document.getElementById("funcao_medi").value = "";
}else{
    if(http.readyState==1){
       document.getElementById("cadastrados").innerHTML = "<center>Atualizando...</center>";
    }
}
}


//--EXAMES--\\
function save_exa(){
    var combo = document.getElementById("funcao_exame");
    var url = "add_exa.php?id="+document.getElementById("funcao_exame").value;
    url = url + "&cod_exa=" +document.getElementById("cod_exa").value;
    url = url + "&desc=" + combo.options[combo.selectedIndex].text;//document.getElementById("funcao_exame").text;
    url = url + "&cache=" + new Date().getTime();

    //alert('ok');
     //alert('');
    http.open("GET", url, true);
    http.onreadystatechange = save_exa_reply;
    http.send(null);
}

function save_exa_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
	var data = msg.split("|");
    var r = "<table border=0 cellpadding=\"1\" cellspacing=\"1\" valign=top>";

    r += "<tr><td width=5% align=center bgcolor=\"#009966\"><b>ID</b></td><td align=center bgcolor=\"#009966\"><b>Descrição</b></td><td width=5% align=center bgcolor=\"#009966\"><b>Excluir</b></td>        </tr>";

	for(var x=0;x<data.length-1;x++){
          //r += "<tr><td>"+(x+1) + "</td><td>" + data[x] + "</td><td align=center><a href='javascript:remove_epi(".$r[$x]['id']});'>X</a></td></tr>";
         r+=data[x];
	}
   r+="</table>";
	document.getElementById("cadastrados").innerHTML = r;
	document.getElementById("funcao_exame").value = "";
}else{
    if(http.readyState==1){
       document.getElementById("cadastrados").innerHTML = "<center>Atualizando...</center>";
    }
}
}

function save_setor_exa(){
    var combo = document.getElementById("funcao_exame");
    var url = "add_setor_exa.php?id="+document.getElementById("funcao_exame").value;
    url = url + "&cod_exa=" +document.getElementById("cod_exa").value;
    url = url + "&desc=" + combo.options[combo.selectedIndex].text;//document.getElementById("funcao_exame").text;
    url = url + "&cache=" + new Date().getTime();
    http.open("GET", url, true);
    http.onreadystatechange = save_setor_exa_reply;
    http.send(null);
}

function save_setor_exa_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
	var data = msg.split("|");
    var r = "<table border=0 cellpadding=\"1\" cellspacing=\"1\" valign=top>";
    r += "<tr><td width=5% align=center bgcolor=\"#009966\"><b>ID</b></td><td align=center bgcolor=\"#009966\"><b>Descrição</b></td><td width=5% align=center bgcolor=\"#009966\"><b>Excluir</b></td>        </tr>";
	for(var x=0;x<data.length-1;x++){
         r+=data[x];
	}
   r+="</table>";
	document.getElementById("cadastrados").innerHTML = r;
	document.getElementById("funcao_exame").value = "";
}else{
    if(http.readyState==1){
       document.getElementById("cadastrados").innerHTML = "<center>Atualizando...</center>";
    }
}
}



function remove_exa(x){
    var url = "remove_exa.php?id=" + x;
    url = url + "&cod_exa=" +document.getElementById("cod_exa").value;
    url = url + "&cache=" + new Date().getTime();
    http.open("GET", url, true);
    http.onreadystatechange = remove_exa_reply;
    http.send(null);
}

function remove_exa_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
	var data = msg.split("|");
    var r = "<table border=0 cellpadding=\"1\" cellspacing=\"1\" valign=top>";
    r += "<tr><td width=5% align=center bgcolor=\"#009966\"><b>ID</b></td><td align=center bgcolor=\"#009966\"><b>Descrição</b></td><td width=5% align=center bgcolor=\"#009966\"><b>Excluir</b></td>        </tr>";
	for(var x=0;x<data.length-1;x++){
          //r += "<tr><td>"+(x+1) + "</td><td>" + data[x] + "</td><td align=center><a href='javascript:remove_epi(".$r[$x]['id']});'>X</a></td></tr>";
         r+=data[x];
	}
   r+="</table>";
	document.getElementById("cadastrados").innerHTML = r;
}else{
    if(http.readyState==1){
       document.getElementById("cadastrados").innerHTML = "<center>Atualizando...</center>";
    }
}
}



function remove_setor_exa(x){
    var url = "remove_setor_exa.php?id=" + x;
    url = url + "&cod_exa=" +document.getElementById("cod_exa").value;
    url = url + "&cache=" + new Date().getTime();
    http.open("GET", url, true);
    http.onreadystatechange = remove_setor_exa_reply;
    http.send(null);
}

function remove_setor_exa_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
	var data = msg.split("|");
    var r = "<table border=0 cellpadding=\"1\" cellspacing=\"1\" valign=top>";
    r += "<tr><td width=5% align=center bgcolor=\"#009966\"><b>ID</b></td><td align=center bgcolor=\"#009966\"><b>Descrição</b></td><td width=5% align=center bgcolor=\"#009966\"><b>Excluir</b></td>        </tr>";
	for(var x=0;x<data.length-1;x++){
         r+=data[x];
	}
   r+="</table>";
	document.getElementById("cadastrados").innerHTML = r;
}else{
    if(http.readyState==1){
       document.getElementById("cadastrados").innerHTML = "<center>Atualizando...</center>";
    }
}
}





//--CURSOS--\\
function save_curso(){
if(!document.getElementById("cod_prod").value){
    if(confirm('Este produto não está no cadastro de produto, deseja adicioná-lo?','')){
       //return true;
    }else{
       return false;
    }
}
    var url = "add_curso.php?id="+document.getElementById("funcao_curso").value;
    url = url + "&cod_prod=" +document.getElementById("cod_prod").value;
    url = url + "&cod_curso=" +document.getElementById("cod_curso").value;
    url = url + "&cache=" + new Date().getTime();
    http.open("GET", url, true);
    http.onreadystatechange = save_curso_reply;
    http.send(null);
}

function save_curso_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
	var data = msg.split("|");
    var r = "<table border=0 cellpadding=\"1\" cellspacing=\"1\" valign=top>";

    r += "<tr><td width=5% align=center bgcolor=\"#009966\"><b>ID</b></td><td align=center bgcolor=\"#009966\"><b>Descrição</b></td><td width=5% align=center bgcolor=\"#009966\"><b>Excluir</b></td>        </tr>";

	for(var x=0;x<data.length-1;x++){
          //r += "<tr><td>"+(x+1) + "</td><td>" + data[x] + "</td><td align=center><a href='javascript:remove_epi(".$r[$x]['id']});'>X</a></td></tr>";
         r+=data[x];
	}
   r+="</table>";
	document.getElementById("cadastrados").innerHTML = r;
	document.getElementById("funcao_curso").value = "";
}else{
    if(http.readyState==1){
       document.getElementById("cadastrados").innerHTML = "<center>Atualizando...</center>";
    }
}
}



function remove_curso(x){
    var url = "remove_curso.php?id=" + x;
    url = url + "&cod_curso=" +document.getElementById("cod_curso").value;
    url = url + "&cache=" + new Date().getTime();
    http.open("GET", url, true);
    http.onreadystatechange = remove_curso_reply;
    http.send(null);
}

function remove_curso_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
	var data = msg.split("|");
    var r = "<table border=0 cellpadding=\"1\" cellspacing=\"1\" valign=top>";
    r += "<tr><td width=5% align=center bgcolor=\"#009966\"><b>ID</b></td><td align=center bgcolor=\"#009966\"><b>Descrição</b></td><td width=5% align=center bgcolor=\"#009966\"><b>Excluir</b></td>        </tr>";
	for(var x=0;x<data.length-1;x++){
          //r += "<tr><td>"+(x+1) + "</td><td>" + data[x] + "</td><td align=center><a href='javascript:remove_epi(".$r[$x]['id']});'>X</a></td></tr>";
         r+=data[x];
	}
   r+="</table>";
	document.getElementById("cadastrados").innerHTML = r;
}else{
    if(http.readyState==1){
       document.getElementById("cadastrados").innerHTML = "<center>Atualizando...</center>";
    }
}
}

function URLDecode(url) //function decode URL
{
// Replace + with ' '
// Replace %xx with equivalent character
// Put [ERROR] in output if %xx is invalid.
var HEXCHARS = "0123456789ABCDEFabcdef";
var encoded = url;
var plaintext = "";
var i = 0;
while (i < encoded.length) {
var ch = encoded.charAt(i);
if (ch == "+") {
plaintext += " ";
i++;
} else if (ch == "%") {
if (i < (encoded.length-2)
&& HEXCHARS.indexOf(encoded.charAt(i+1)) != -1
&& HEXCHARS.indexOf(encoded.charAt(i+2)) != -1 ) {
plaintext += unescape( encoded.substr(i,3) );
i += 3;
} else {
alert( 'Bad escape combination near ...' + encoded.substr(i) );
plaintext += "%[ERROR]";
i++;
}
} else {
plaintext += ch;
i++;
}
} // while

return plaintext;
} 


function func_cod(ar){
	//alert('ok');
	ar = URLDecode(ar);
	var lista = ar.split("|");
	var combo = document.getElementById("cod_funcao");
	document.getElementById("dinamica_funcao").value = lista[combo.selectedIndex];
	//alert(lista[combo.selectedIndex]);
	//return combo.selectedIndex;
}

function dataRecarga(){
	//var msg = document.getElementById("vencimento_abnt");
	var msg = document.getElementById("data_recarga");
	var data = msg.value.split("/");
	
	//document.getElementById("vencimento_abnt").value = data[1]+"/"+(parseInt(data[2])+5);
	document.getElementById("proxima_carga").value = data[0]+"/"+data[1]+"/"+(parseInt(data[2])+1);
}

function save_ambiente(){
if(!document.getElementById("cod_prod").value){
    if(confirm('Este produto não está no cadastro de produto, deseja adicioná-lo?','')){
       //return true;
    }else{
       return false;
    }
}
    var url = "add_ambiente.php?id="+document.getElementById("funcao_ambiental").value;
    url = url + "&cod_prod=" +document.getElementById("cod_prod").value;
    url = url + "&cod_funcao=" +document.getElementById("cod_funcao").value;
    url = url + "&cache=" + new Date().getTime();
    http.open("GET", url, true);
    http.onreadystatechange = save_ambiente_reply;
    http.send(null);
}

function save_ambiente_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
	var data = msg.split("|");
    var r = "<table border=0 cellpadding=\"1\" cellspacing=\"1\" valign=top>";

    r += "<tr><td width=5% align=center bgcolor=\"#009966\"><b>ID</b></td><td align=center bgcolor=\"#009966\"><b>Descrição</b></td><td width=5% align=center bgcolor=\"#009966\"><b>Excluir</b></td>        </tr>";

	for(var x=0;x<data.length-1;x++){
          //r += "<tr><td>"+(x+1) + "</td><td>" + data[x] + "</td><td align=center><a href='javascript:remove_epi(".$r[$x]['id']});'>X</a></td></tr>";
         r+=data[x];
	}
   r+="</table>";
	document.getElementById("cadastrados").innerHTML = r;
	document.getElementById("funcao_ambiental").value = "";
}else{
    if(http.readyState==1){
       document.getElementById("cadastrados").innerHTML = "<center>Atualizando...</center>";
    }
}
}

function remove_ambiente(x){
    var url = "remove_ambiente.php?id=" + x;
    url = url + "&cod_funcao=" +document.getElementById("cod_funcao").value;
    url = url + "&cache=" + new Date().getTime();
    http.open("GET", url, true);
    http.onreadystatechange = remove_ambiente_reply;
    http.send(null);
}

function remove_ambiente_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
	var data = msg.split("|");
    var r = "<table border=0 cellpadding=\"1\" cellspacing=\"1\" valign=top>";
    r += "<tr><td width=5% align=center bgcolor=\"#009966\"><b>ID</b></td><td align=center bgcolor=\"#009966\"><b>Descrição</b></td><td width=5% align=center bgcolor=\"#009966\"><b>Excluir</b></td>        </tr>";
	for(var x=0;x<data.length-1;x++){
          //r += "<tr><td>"+(x+1) + "</td><td>" + data[x] + "</td><td align=center><a href='javascript:remove_epi(".$r[$x]['id']});'>X</a></td></tr>";
         r+=data[x];
	}
   r+="</table>";
	document.getElementById("cadastrados").innerHTML = r;
}else{
    if(http.readyState==1){
       document.getElementById("cadastrados").innerHTML = "<center>Atualizando...</center>";
    }
}
}


function save_setor_ambiente(){
if(!document.getElementById("cod_prod").value){
    if(confirm('Este produto não está no cadastro de produto, deseja adicioná-lo?','')){
       //return true;
    }else{
       return false;
    }
}
    var url = "add_setor_ambiente.php?id="+document.getElementById("funcao_ambiental").value;
    url = url + "&cod_funcao=" +document.getElementById("cod_funcao").value;
    url = url + "&cod_prod=" +document.getElementById("cod_prod").value;
    url = url + "&cache=" + new Date().getTime();
    http.open("GET", url, true);
    http.onreadystatechange = save_setor_ambiente_reply;
    http.send(null);
}

function save_setor_ambiente_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
	var data = msg.split("|");
    var r = "<table border=0 cellpadding=\"1\" cellspacing=\"1\" valign=top>";

    r += "<tr><td width=5% align=center bgcolor=\"#009966\"><b>ID</b></td><td align=center bgcolor=\"#009966\"><b>Descrição</b></td><td width=5% align=center bgcolor=\"#009966\"><b>Excluir</b></td>        </tr>";

	for(var x=0;x<data.length-1;x++){
          //r += "<tr><td>"+(x+1) + "</td><td>" + data[x] + "</td><td align=center><a href='javascript:remove_epi(".$r[$x]['id']});'>X</a></td></tr>";
         r+=data[x];
	}
   r+="</table>";
	document.getElementById("cadastrados").innerHTML = r;
	document.getElementById("funcao_ambiental").value = "";
}else{
    if(http.readyState==1){
       document.getElementById("cadastrados").innerHTML = "<center>Atualizando...</center>";
    }
}
}



function remove_setor_ambiente(x){
    var url = "remove_setor_ambiente.php?id=" + x;
    url = url + "&cod_funcao=" +document.getElementById("cod_funcao").value;
    url = url + "&cache=" + new Date().getTime();
    http.open("GET", url, true);
    http.onreadystatechange = remove_setor_ambiente_reply;
    http.send(null);
}

function remove_setor_ambiente_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
	var data = msg.split("|");
    var r = "<table border=0 cellpadding=\"1\" cellspacing=\"1\" valign=top>";
    r += "<tr><td width=5% align=center bgcolor=\"#009966\"><b>ID</b></td><td align=center bgcolor=\"#009966\"><b>Descrição</b></td><td width=5% align=center bgcolor=\"#009966\"><b>Excluir</b></td>        </tr>";
	for(var x=0;x<data.length-1;x++){
         r+=data[x];
	}
   r+="</table>";
	document.getElementById("cadastrados").innerHTML = r;
}else{
    if(http.readyState==1){
       document.getElementById("cadastrados").innerHTML = "<center>Atualizando...</center>";
    }
}
}


function save_programas(){
if(!document.getElementById("cod_prod").value){
    if(confirm('Este produto não está no cadastro de produto, deseja adicioná-lo?','')){
       //return true;
    }else{
       return false;
    }
}
    var url = "add_programas.php?id="+document.getElementById("funcao_programas").value;
    url = url + "&cod_prod=" +document.getElementById("cod_prod").value;
    url = url + "&cod_funcao=" +document.getElementById("cod_funcao").value;
    url = url + "&cache=" + new Date().getTime();
    http.open("GET", url, true);
    http.onreadystatechange = save_programas_reply;
    http.send(null);
}

function save_programas_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
	var data = msg.split("|");
    var r = "<table border=0 cellpadding=\"1\" cellspacing=\"1\" valign=top>";

    r += "<tr><td width=5% align=center bgcolor=\"#009966\"><b>ID</b></td><td align=center bgcolor=\"#009966\"><b>Descrição</b></td><td width=5% align=center bgcolor=\"#009966\"><b>Excluir</b></td>        </tr>";

	for(var x=0;x<data.length-1;x++){
          //r += "<tr><td>"+(x+1) + "</td><td>" + data[x] + "</td><td align=center><a href='javascript:remove_epi(".$r[$x]['id']});'>X</a></td></tr>";
         r+=data[x];
	}
   r+="</table>";
	document.getElementById("cadastrados").innerHTML = r;
	document.getElementById("funcao_programas").value = "";
}else{
    if(http.readyState==1){
       document.getElementById("cadastrados").innerHTML = "<center>Atualizando...</center>";
    }
}
}



function save_setor_programas(){
if(!document.getElementById("cod_prod").value){
    if(confirm('Este produto não está no cadastro de produto, deseja adicioná-lo?','')){
       //return true;
    }else{
       return false;
    }
}
    var url = "add_setor_programas.php?id="+document.getElementById("funcao_programas").value;
    url = url + "&cod_funcao=" +document.getElementById("cod_funcao").value;
    url = url + "&cod_prod=" +document.getElementById("cod_prod").value;
    url = url + "&cache=" + new Date().getTime();
    http.open("GET", url, true);
    http.onreadystatechange = save_setor_programas_reply;
    http.send(null);
}

function save_setor_programas_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
	var data = msg.split("|");
    var r = "<table border=0 cellpadding=\"1\" cellspacing=\"1\" valign=top>";
    r += "<tr><td width=5% align=center bgcolor=\"#009966\"><b>ID</b></td><td align=center bgcolor=\"#009966\"><b>Descrição</b></td><td width=5% align=center bgcolor=\"#009966\"><b>Excluir</b></td>        </tr>";
	for(var x=0;x<data.length-1;x++){
         r+=data[x];
	}
   r+="</table>";
	document.getElementById("cadastrados").innerHTML = r;
	document.getElementById("funcao_programas").value = "";
}else{
    if(http.readyState==1){
       document.getElementById("cadastrados").innerHTML = "<center>Atualizando...</center>";
    }
}
}

function remove_setor_programas(x){
    var url = "remove_setor_programas.php?id=" + x;
    url = url + "&cod_funcao=" +document.getElementById("cod_funcao").value;
    url = url + "&cache=" + new Date().getTime();
    http.open("GET", url, true);
    http.onreadystatechange = remove_programas_reply;
    http.send(null);
}

function remove_setor_programas_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
	var data = msg.split("|");
    var r = "<table border=0 cellpadding=\"1\" cellspacing=\"1\" valign=top>";
    r += "<tr><td width=5% align=center bgcolor=\"#009966\"><b>ID</b></td><td align=center bgcolor=\"#009966\"><b>Descrição</b></td><td width=5% align=center bgcolor=\"#009966\"><b>Excluir</b></td>        </tr>";
	for(var x=0;x<data.length-1;x++){
         r+=data[x];
	}
   r+="</table>";
	document.getElementById("cadastrados").innerHTML = r;
}else{
    if(http.readyState==1){
       document.getElementById("cadastrados").innerHTML = "<center>Atualizando...</center>";
    }
}
}

function remove_programas(x){
    var url = "remove_programas.php?id=" + x;
    url = url + "&cod_funcao=" +document.getElementById("cod_funcao").value;
    url = url + "&cache=" + new Date().getTime();
    http.open("GET", url, true);
    http.onreadystatechange = remove_programas_reply;
    http.send(null);
}

function remove_programas_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
	var data = msg.split("|");
    var r = "<table border=0 cellpadding=\"1\" cellspacing=\"1\" valign=top>";
    r += "<tr><td width=5% align=center bgcolor=\"#009966\"><b>ID</b></td><td align=center bgcolor=\"#009966\"><b>Descrição</b></td><td width=5% align=center bgcolor=\"#009966\"><b>Excluir</b></td>        </tr>";
	for(var x=0;x<data.length-1;x++){
          //r += "<tr><td>"+(x+1) + "</td><td>" + data[x] + "</td><td align=center><a href='javascript:remove_epi(".$r[$x]['id']});'>X</a></td></tr>";
         r+=data[x];
	}
   r+="</table>";
	document.getElementById("cadastrados").innerHTML = r;
}else{
    if(http.readyState==1){
       document.getElementById("cadastrados").innerHTML = "<center>Atualizando...</center>";
    }
}
}

//DESABILITAR CAMPOS DO CADASTRO DE EXTINTOR
function sugerir(obj){
	if(obj.options[obj.selectedIndex].value == "existente"){
	//alert('ok');
   document.frm_medida_produto.extintor.disabled = 0;
   document.frm_medida_produto.cod_produto.disabled = 0;
   document.frm_medida_produto.qtd_extintor.disabled = 0;
   document.frm_medida_produto.data_recarga.disabled = 0;
   document.frm_medida_produto.numero_cilindro.disabled = 0;
   document.frm_medida_produto.vencimento_abnt.disabled = 0;
   document.frm_medida_produto.proxima_carga.disabled = 0;
   document.frm_medida_produto.placa_sinalizacao_id.disabled = 0;
   document.frm_medida_produto.demarcacao_solo_id.disabled = 0;
   document.frm_medida_produto.tipo_instalacao_id.disabled = 0;
   document.frm_medida_produto.f_inspecao.disabled = 0;
   document.frm_medida_produto.empresa_prestadora.disabled = 0;
	}else{
	//alert('okai');
   document.frm_medida_produto.extintor.disabled = 0;
   document.frm_medida_produto.cod_produto.disabled = 0;
   document.frm_medida_produto.qtd_extintor.disabled = 0;
   document.frm_medida_produto.data_recarga.disabled = 1;
   document.frm_medida_produto.numero_cilindro.disabled = 1;
   document.frm_medida_produto.vencimento_abnt.disabled = 1;
   document.frm_medida_produto.proxima_carga.disabled = 1;
   document.frm_medida_produto.placa_sinalizacao_id.disabled = 1;
   document.frm_medida_produto.demarcacao_solo_id.disabled = 1;
   document.frm_medida_produto.tipo_instalacao_id.disabled = 1;
   document.frm_medida_produto.f_inspecao.disabled = 1;
   document.frm_medida_produto.empresa_prestadora.disabled = 1;
	}
}

function fone(obj){
	if(obj.value.length == 2){
		obj.value = "" + obj.value + " - ";
	}
	if(obj.value.length == 9){
		obj.value = obj.value + " ";
	}
}

//DESABILITAR CAMPOS DO CADASTRO DE MANGUEIRAS
function narin(tipo_hidrante_id){
	if(tipo_hidrante_id.options[tipo_hidrante_id.selectedIndex].value != "1"){
   document.frm_medida_mang.tipo_hidrante_id.disabled = 0;
   document.frm_medida_mang.estado_abrigo.disabled = 0;
   document.frm_medida_mang.diametro_mangueira_id.disabled = 0;
   document.frm_medida_mang.registro.disabled = 0;
   document.frm_medida_mang.quantidade_mangueira.disabled = 0;
   document.frm_medida_mang.repor.disabled = 0;
   document.frm_medida_mang.mang_reposta.disabled = 0;
   document.frm_medida_mang.vistoria.disabled = 0;
   document.frm_medida_mang.estado_mang.disabled = 0;
   document.frm_medida_mang.esquicho.disabled = 0;
   document.frm_medida_mang.qtd_esquicho.disabled = 0;
   document.frm_medida_mang.chave_stors.disabled = 0;
   document.frm_medida_mang.pl_ident.disabled = 0;
   document.frm_medida_mang.demarcacao.disabled = 0;
   document.frm_medida_mang.porta_cont_fogo.disabled = 0;
   document.frm_medida_mang.qtd_porta.disabled = 0;
   document.frm_medida_mang.tipo_para_raio_id.disabled = 0;
   document.frm_medida_mang.qtd_raio.disabled = 0;
   document.frm_medida_mang.tipo_sistema_fixo_contra_incendio_id.disabled = 0;
   document.frm_medida_mang.alarme_contra_incendio_id.disabled = 0;
   document.frm_medida_mang.sprinkler.disabled = 0;
   document.frm_medida_mang.bulbos.disabled = 0;
}else{
   document.frm_medida_mang.tipo_hidrante_id.disabled = 0;
   document.frm_medida_mang.estado_abrigo.disabled = 1;
   document.frm_medida_mang.diametro_mangueira_id.disabled = 1;
   document.frm_medida_mang.registro.disabled = 1;
   document.frm_medida_mang.quantidade_mangueira.disabled = 1;
   document.frm_medida_mang.repor.disabled = 1;
   document.frm_medida_mang.mang_reposta.disabled = 1;
   document.frm_medida_mang.vistoria.disabled = 1;
   document.frm_medida_mang.estado_mang.disabled = 1;
   document.frm_medida_mang.esquicho.disabled = 1;
   document.frm_medida_mang.qtd_esquicho.disabled = 1;
   document.frm_medida_mang.chave_stors.disabled = 1;
   document.frm_medida_mang.pl_ident.disabled = 1;
   document.frm_medida_mang.demarcacao.disabled = 1;
   document.frm_medida_mang.porta_cont_fogo.disabled = 1;
   document.frm_medida_mang.qtd_porta.disabled = 1;
   document.frm_medida_mang.tipo_para_raio_id.disabled = 1;
   document.frm_medida_mang.qtd_raio.disabled = 1;
   document.frm_medida_mang.tipo_sistema_fixo_contra_incendio_id.disabled = 1;
   document.frm_medida_mang.alarme_contra_incendio_id.disabled = 1;
   document.frm_medida_mang.sprinkler.disabled = 1;
   document.frm_medida_mang.bulbos.disabled = 1;
	}
}

//CADASTRO DE MANGUEIRAS
function hidrante(){
	if(document.getElementById("tipo_hidrante_id").value == 2 || document.getElementById("tipo_hidrante_id").value == 3 || document.getElementById("tipo_hidrante_id").value == 7 && document.getElementById("quantidade_mangueira").value < 2){
		var ms = document.getElementById("tipo_hidrante_id");
		var m = document.getElementById("quantidade_mangueira");
		var msg = document.getElementById("mang_reposta");
		var mg = document.getElementById("repor");
		
		if(document.getElementById("quantidade_mangueira").value == 2){
			document.getElementById("repor").value = 'nenhum';
			document.getElementById("mang_reposta").value = '0';
		}else if(document.getElementById("quantidade_mangueira").value == 1){
			document.getElementById("repor").value = 'aquis';
			document.getElementById("mang_reposta").value = '1';
		}else if(document.getElementById("quantidade_mangueira").value > 2){
			document.getElementById("repor").value = 'redimensionar';
			document.getElementById("mang_reposta").value = document.getElementById("quantidade_mangueira").value-2;	
		}
	}else if(document.getElementById("tipo_hidrante_id").value == 5 || document.getElementById("tipo_hidrante_id").value == 6 || document.getElementById("tipo_hidrante_id").value == 8 && document.getElementById("quantidade_mangueira").value < 4){
		
		if(document.getElementById("quantidade_mangueira").value == 4){
			document.getElementById("repor").value = 'nenhum';
			document.getElementById("mang_reposta").value = '0';
		}else if(document.getElementById("quantidade_mangueira").value < 4){
			document.getElementById("repor").value = 'aquis';
			document.getElementById("mang_reposta").value = 4-document.getElementById("quantidade_mangueira").value;
		}else if(document.getElementById("quantidade_mangueira").value > 4){
			document.getElementById("repor").value = 'redimensionar';
			document.getElementById("mang_reposta").value = document.getElementById("quantidade_mangueira").value-4;	
		}
	}	
}

//ALTERAR NÍVEL DO CADASTRO DE RISCOS
function nivelRisco(sel){
	if(sel.value == '0'){		
		var inte = document.getElementById("itensidade"); inte.options.selectedIndex = 2;
		var dano = document.getElementById("danos_saude"); dano.options.selectedIndex = 0;
		var esca = document.getElementById("escala_acao"); esca.options.selectedIndex = 0;
	}else if(sel.value == 'I'){
		var inte = document.getElementById("itensidade"); inte.options.selectedIndex = 2;
		var dano = document.getElementById("danos_saude"); dano.options.selectedIndex = 0;
		var esca = document.getElementById("escala_acao"); esca.options.selectedIndex = 1;
	}else if(sel.value == 'II'){
		var inte = document.getElementById("itensidade"); inte.options.selectedIndex = 1;
		var dano = document.getElementById("danos_saude"); dano.options.selectedIndex = 1;
		var esca = document.getElementById("escala_acao"); esca.options.selectedIndex = 2;
	}else if(sel.value == 'III'){
		var inte = document.getElementById("itensidade"); inte.options.selectedIndex = 0;
		var dano = document.getElementById("danos_saude"); dano.options.selectedIndex = 2;
		var esca = document.getElementById("escala_acao"); esca.options.selectedIndex = 3;
	}
}

function apto(val){
	//alert(val);
	var poiu = document.getElementById("ds");
	if(val == 'Inapto' || val == 'Apto com Restrição'){		
		poiu.style.display='block';
	}else{
		poiu.style.display='none';	
	}	
}
