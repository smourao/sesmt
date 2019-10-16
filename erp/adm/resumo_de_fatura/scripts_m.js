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
		window.alert('Dados Alterados com Sucesso!');
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
	//alert("");
	var box = document.getElementById("resultado");
	if(box.options[box.selectedIndex].index == 2){
		var txt = document.createElement("textarea");
		txt.setAttribute("id","restricao");
		txt.setAttribute("rows", "3");
		txt.setAttribute("cols", "90%");
		txt.value=document.getElementById("abc").value;
		
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
    var url = "add_epi.php?id="+document.getElementById("funcao").value;
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

    var url = "add_exa.php?id="+document.getElementById("funcao_exame").value;
    url = url + "&cod_exa=" +document.getElementById("cod_exa").value;
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






//--CURSOS--\\
function save_curso(){
    var url = "add_curso.php?id="+document.getElementById("funcao_curso").value;
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


function funcao_cod(ar){
	var lista = ar.split("|");
	var combo = document.getElementById("cod_funcao");
	document.getElementById("dinamica_funcao").value = ""
	
	alert(lista[combo.selectedIndex]);
	//return combo.selectedIndex;
	
}



function save_medi_n(){

    var url = "add_medi_n.php?id="+document.getElementById("funcao_medi").value;
    url = url + "&cod_medi=" +document.getElementById("cod_medi").value;
    url = url + "&cache=" + new Date().getTime();
    //alert('ok');
     //alert('');
    http.open("GET", url, true);
    http.onreadystatechange = save_medi_reply_n
}

function save_medi_reply_n(){
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
