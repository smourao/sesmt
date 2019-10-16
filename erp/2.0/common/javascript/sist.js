/*************************************************************************************************/
// --> FUNCTION TO SHOW TIP IN THE PAGE
/*************************************************************************************************/
function showtip(obj, text){
    var objId = document.getElementById(""+obj+"");
    objId.style.display = "block";
    objId.innerHTML = ""+text+"";
}

function hidetip(obj){
    var objId = document.getElementById(""+obj+"");
    objId.style.display = "none";
    objId.innerHTML = "&nbsp;";
}
/*************************************************************************************************/
function URLDecode(url){
    var HEXCHARS = "0123456789ABCDEFabcdef";
    var encoded = url;
    var plaintext = "";
    var i = 0;
    while (i < encoded.length){
        var ch = encoded.charAt(i);
        if (ch == "+"){
            plaintext += " ";
            i++;
        }else if(ch == "%"){
            if (i < (encoded.length-2) && HEXCHARS.indexOf(encoded.charAt(i+1)) != -1 && HEXCHARS.indexOf(encoded.charAt(i+2)) != -1 ){
                plaintext += unescape( encoded.substr(i,3) );
                i += 3;
            }else{
                alert( 'Bad escape combination near ...' + encoded.substr(i) );
                plaintext += "%[ERROR]";
                i++;
            }
        }else{
            plaintext += ch;
            i++;
        }
    } // while
    return plaintext;
}

function func_cod(ar, combo, dinamica){
	ar = URLDecode(ar);
	var lista = ar.split("|");
	document.getElementById(""+dinamica+"").value = lista[combo.selectedIndex];
}

// create the prototype on the String object
String.prototype.trim = function() {
 // skip leading and trailing whitespace
 // and return everything in between
	return this.replace(/^\s*(\b.*\b|)\s*$/, "$1");
}



// create the prototype on the String object
String.prototype.trimLeadingZeros = function(todos) { //true, false
    if (""+todos=="undefined") todos=false;
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
	if (campo!=null && campo.value!=result){
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

function formataHoraDigitada(campo) {
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
            if ( (tam==1) && (valor.length>2) ) { j++; temp+=":"; }
        } else if (j==1) {
            temp+=valor.substring(tam,tam+1);
            if ( (tam==3) && (valor.length>4) ) { j++; temp+=":"; }
        } else if (j==2) {
            temp+=valor.substring(tam,tam+1);
        }
    }
    if (campo.value!=temp) {
        campo.value=temp;
    }
}
/*************************************************************************************************/
// --> FUNCTIONS - VALIDAR DATA
/*************************************************************************************************/
function validate_data(pObj) {
  var expReg = /^((0[1-9]|[12]\d)\/(0[1-9]|1[0-2])|30\/(0[13-9]|1[0-2])|31\/(0[13578]|1[02]))\/(19|20)?\d{2}$/;
  var aRet = true;
  if ((pObj) && (pObj.value.match(expReg)) && (pObj.value != '')) {
        var dia = pObj.value.substring(0,2);
        var mes = pObj.value.substring(3,5);
        var ano = pObj.value.substring(6,10);
        if ((mes == 4 || mes == 6 || mes == 9 || mes == 11 ) && dia > 30)
          aRet = false;
        else
          if ((ano % 4) != 0 && mes == 2 && dia > 28)
                aRet = false;
          else
                if ((ano%4) == 0 && mes == 2 && dia > 29)
                  aRet = false;
  }  else
        aRet = false;
  return aRet;
}

/*************************************************************************************************/
// --> FUNCTIONS - CGRT
/*************************************************************************************************/
function checkfuncfields(){
   if(document.getElementById('nome').value == ''){
       showAlert('O campo <b>Nome</b> deve ser preenchido!');
       document.getElementById('nome').focus();
       return false;
   }
   if(document.getElementById('admissao').value == ''){
       showAlert('O campo <b>Admissão</b> deve ser preenchido!');
       document.getElementById('admissao').focus();
       return false;
   }
   var setor = document.getElementById('setorbase');
   var funcao = document.getElementById('cod_funcao');
   if(funcao.options[funcao.selectedIndex].value == ''){
       showAlert('O campo <b>Função</b> deve ser selecionado!');
       return false;
   }
   if(setor.options[setor.selectedIndex].value == ''){
       showAlert('O campo <b>Setor Base</b> deve ser selecionado!');
       return false;
   }
   return true;
}

//Verifica se algum setor foi marcado como externo e altera a posição da existência do setor
//externo no ppra.
function checkSetorConfig(){
    //document.write(document.getElementById("posto_trabalho[]").value);
    var lis = document.form2.elements;
    var isActive = false;
    for(var x=0;x<lis.length;x++){
        if(lis[x].name == "posto_trabalho[]" && lis[x].value == 1){
            isActive = true;
        }
    }

    if(isActive){
        document.getElementById("pt_existente").options.selectedIndex = 1;
    }else{
        document.getElementById("pt_existente").options.selectedIndex = 0;
    }

}

/*************************************************************************************************/


/*************************************************************************************************/
// --> FUNCTIONS - SHOW / HIDE MESSAGE [ AFTER POST ]
/*************************************************************************************************/
function showMSG(obj, msg, delay){
    //alert('Ok');
   //document.getElementById(""+obj+"").className = 'showsysmsg';
   document.getElementById(""+obj+"").innerHTML = ''+msg+'';
   document.getElementById(""+obj+"").style.display = 'block';
   setTimeout("hideMsg('"+obj+"')", delay);
   document.getElementById("fadescreen").style.display = 'block';
}

function hideMsg(obj){
    document.getElementById(""+obj+"").innerHTML = '&nbsp;';
    document.getElementById(""+obj+"").style.display = 'none';
    document.getElementById("fadescreen").style.display = 'none';
}
/*************************************************************************************************/


/*************************************************************************************************/
// --> FUNCTIONS - SHOW / HIDE MESSAGE [ AFTER POST ]
/*************************************************************************************************/
function showAlert(msg){
   document.getElementById("centeredwindow").innerHTML = "<table width=100% height=100% border=0 align=center><tr><td class=msgh align=left><table width=100%><tr><td width=25 height=25 align=center><img src='images/alert-tip.png' border=0 align=baseline></td><td class=text><font color=white>Alerta do sistema</font></td><td width=60><a href=\"javascript:hideAlert();\"><img src=\"images/imclose-tip.png\" border=0></a></td></tr></table></td></tr><tr><td align=left class=btext>"+msg+"</td></tr><tr><td valign=bottom align=center><input type=button class='btn' value=Ok name=btnsmok onclick=\"javascript:hideAlert();\"></td></tr></table>";//''+msg+'';
   //document.getElementById("centeredwindow").innerHTML = "<table width=100% height=100% border=0 align=center><tr><td class=msgh align=left><table width=100%><tr><td width=25 height=25 align=center><img src='images/alert-tip.png' border=0 align=baseline></td><td>Alerta do sistema</td><td width=60><a href=\"javascript:hideAlert();\"><img src=\"images/imclose-tip.png\" border=0></a></td></tr></table></td></tr><tr><td align=left class=btext><div style=\"width:100%;heigth:100%;overflow: auto;\">"+msg+"</div></td></tr><tr><td valign=bottom align=center><input type=button class='btn' value=Ok name=btnsmok onclick=\"javascript:hideAlert();\"></td></tr></table>";//''+msg+'';
   document.getElementById("centeredwindow").style.display = 'block';
   //setTimeout("hideAlert('centeredwindow')", delay);
   document.getElementById("fadescreen").style.display = 'block';
   return false;
}

function hideAlert(){
    document.getElementById("centeredwindow").innerHTML = '&nbsp;';
    document.getElementById("centeredwindow").style.display = 'none';
    document.getElementById("fadescreen").style.display = 'none';
}
/*************************************************************************************************/


/*************************************************************************************************/
// --> FUNCTIONS - PAINEL DE ADMINISTAÇÃO [admin_panel]
/*************************************************************************************************/
function admin_panel_option(val){
    window.location.href = '?dir=admin_panel&p=index&sp='+val;
    /*
    switch(val){
        case '1':
            window.location.href = '?dir=admin_panel&p=index&sp=mod_admin';
        break;
    }
    */
}

/*************************************************************************************************/
// --> FUNCTIONS - Scripts para mascara do sistema (exemplo universal)
//maxlength="18" OnKeyPress="formatar(this, '##.###.###/####-##'); --> para mascarar o cnpj
/*************************************************************************************************/
function formatar(src, mask){
    var i = src.value.length;
    var saida = mask.substring(0,1);
    var texto = mask.substring(i)
    if(texto.substring(0,1) != saida){
            src.value += texto.substring(0,1);
    }
}
/*************************************************************************************************/
// --> FUNCTIONS - Formata telefone
/*************************************************************************************************/
function fone(obj){
	if(obj.value.length == 2){
		obj.value = "" + obj.value + " - ";
	}
	if(obj.value.length == 9){
		obj.value = obj.value + " ";
	}
}
/*************************************************************************************************/

/*************************************************************************************************/
// --> FUNCTIONS - onkeydown=\"return only_number(event);\"
/*************************************************************************************************/
function only_number(evt){
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    //alert(charCode);
    if ((charCode >= 48 && charCode <= 57) || (charCode >= 96 && charCode <= 105) || (charCode == 8) || (charCode == 9) || (charCode == 46) || (charCode >= 37 && charCode <= 40)){
        return true;
    }else{
        return false;
    }
}
/*************************************************************************************************/

/*************************************************************************************************/
// --> FUNCTIONS - VERIFICA SE TODOS OS CAMPOS FORAM PREENCHIDOS CORRETAMENTE
/*************************************************************************************************/
function cad_cliente_check_fields(frm){
	if(frm.razao_social.value == ""){
		showAlert('O campo <b>Razão Social</b> deve ser preenchido!');
		frm.razao_social.focus();
		return false;
    }else if(frm.cnpj.value == ""){
		showAlert('O campo <b>CNPJ</b> deve ser preenchido!');
		frm.cnpj.focus();
		return false;
	}else if(frm.cnae.value == ""){
		showAlert('O campo <b>CNAE</b> deve ser preenchido!');
		frm.cnae.focus();
		return false;
    }else if(frm.grupo_cipa.value == ""){
		showAlert('O campo <b>GRUPO</b> deve ser preenchido!');
		frm.grupo_cipa.focus();
		return false;
	}else if(frm.grau_risco.value == ""){
		showAlert('O campo <b>Grau de Risco</b> deve ser preenchido!');
		frm.grau_risco.focus();
		return false;
	}else if(frm.descricao_atividade.value == ""){
		showAlert('O campo <b>Atividade</b> deve ser preenchido!');
		frm.descricao_atividade.focus();
		return false;
	}else if(frm.numero_funcionarios.value == ""){
		showAlert('O campo <b>Nº Funcionários</b> deve ser preenchido!');
		frm.numero_funcionarios.focus();
		return false;
	}else if(frm.membros_brigada.value == ""){
		showAlert('O campo <b>Memb. Brigada</b> deve ser preenchido!');
		frm.membros_brigada.focus();
		return false;
    }else if(frm.membros_cipa.value == ""){
		showAlert('O campo <b>CIPA</b> deve ser preenchido!');
		frm.membros_cipa.focus();
		return false;
    }else if(frm.cep.value == ""){
		showAlert('O campo <b>CEP</b> deve ser preenchido!');
		frm.cep.focus();
		return false;
    }else if(frm.estado.value == ""){
		showAlert('O campo <b>Estado</b> deve ser preenchido!');
		frm.estado.focus();
		return false;
	}else if(frm.endereco.value == ""){
		showAlert('O campo <b>Endereço</b> deve ser preenchido!');
		frm.endereco.focus();
		return false;
	}else if(frm.num_end.value == ""){
		showAlert('O campo <b>Número</b> deve ser preenchido!');
		frm.num_end.focus();
		return false;
	}else if(frm.bairro.value == ""){
		showAlert('O campo <b>Bairro</b> deve ser preenchido!');
		frm.bairro.focus();
		return false;
	}else if(frm.municipio.value == ""){
		showAlert('O campo <b>Municipio</b> deve ser preenchido!');
		frm.municipio.focus();
		return false;
	}else if(frm.telefone.value == ""){
		showAlert('O campo <b>Telefone</b> deve ser preenchido!');
		frm.telefone.focus();
		return false;
	}else if(frm.email.value == ""){
		showAlert('O campo <b>E-Mail</b> deve ser preenchido!');
		frm.email.focus();
		return false;
		
	}else if(frm.nome_contato_dir.value == ""){
		showAlert('O campo <b>Contato Direto</b> deve ser preenchido!');
		frm.nome_contato_dir.focus();
		return false;
	}else if(frm.cargo_contato_dir.value == ""){
		showAlert('O campo <b>Cargo</b> do contato direto deve ser preenchido!');
		frm.cargo_contato_dir.focus();
		return false;
	}else if(frm.tel_contato_dir.value == ""){
		showAlert('O campo <b>Telefone</b> do contato direto deve ser preenchido!');
		frm.tel_contato_dir.focus();
		return false;
		
	}else if(frm.nome_contador.value == ""){
		showAlert('O campo <b>Contador</b> deve ser preenchido!');
		frm.nome_contador.focus();
		return false;
	}else if(frm.tel_contador.value == ""){
		showAlert('O campo <b>Telefone</b> do contador/escritório deve ser preenchido!');
		frm.tel_contador.focus();
		return false;
		
		
	}else{
        return true;
	}
}
/*************************************************************************************************/

/*************************************************************************************************/
// --> FUNCTIONS - FORMATA VALOR DIGITADO EM CAMPO MONETÁRIO
//     Ex.: OnKeyPress = "return FormataReais(this, '.',',', event);"
/*************************************************************************************************/
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

/***********************************************************************************************/
//-> FUNCTION PARA COLOCAR CAMPOS OBRIGATÓRIOS DOS COLABORADORES SESMT
/***********************************************************************************************/
function fuc(){
	var asso = document.getElementById('associada_id');
	var grup = document.getElementById('grupo_id');
	var carg = document.getElementById('cargo_id');
	
	if(document.getElementById('nome').value == ''){ 
		showAlert('O preenchimento do campo <b>Nome</b> é obrigatório!');
		return false;
	} else if(document.getElementById('cpf').value == ''){ 
		showAlert('O preenchimento do campo <b>CPF</b> é obrigatório!');
		return false;
	}else if(document.getElementById('telefone').value == ''){ 
		showAlert('O preenchimento do campo <b>Telefone</b> é obrigatório!');
		return false;
	}else if(asso.options[asso.selectedIndex].value == ''){ 
		showAlert('A escolha do campo <b>Associada</b> é obrigatório!');
		return false;
	}else if(grup.options[grup.selectedIndex].value == ''){ 
		showAlert('A escolha do campo <b>Grupo</b> é obrigatório!');
		return false;
	}else if(carg.options[carg.selectedIndex].value == ''){ 
		showAlert('A escolha do campo <b>Cargo</b> é obrigatório!');
		return false;
	}else if(document.getElementById('login').value == ''){ 
		showAlert('O preenchimento do campo <b>Login</b> é obrigatório!');
		return false;
	}else if(document.getElementById('senha').value == ''){ 
		showAlert('O preenchimento do campo <b>Senha</b> é obrigatório!');
		return false;
	}else{
		return true;	
	}
}
/***********************************************************************************************/
//-> FUNCTION PARA ABRIR UMA NOVA JANELA 600x400
/***********************************************************************************************/
function sWindow(url){
	window.open(url,"SESMT","status=no,resizable=yes,scrollbars=yes,menubar=no,width=600,height=400,left=150,top=100");
}

function newWindow(url){
	window.open(url,"SESMT","status=yes,resizable=yes,scrollbars=yes,menubar=yes,width=750,height=550,left=0,top=0");
}
/***********************************************************************************************/
/***********************************************************************************************/
//-> FUNCTION [FADE IN E OUT PARA ELEMENTOS]
/***********************************************************************************************/
function fadeOut(id, time) {
	target = document.getElementById(id);
	alpha = 100;
	timer = (time*1000)/50;
	var i = setInterval(
			function() {
				if (alpha <= 0)
					clearInterval(i);
				setAlpha(target, alpha);
				alpha -= 2;
			}, timer);
}

function fadeIn(id, time) {
	target = document.getElementById(id);
	alpha = 0;
	timer = (time*1000)/50;
	var i = setInterval(
			function() {
				if (alpha >= 100)
					clearInterval(i);
				setAlpha(target, alpha);
				alpha += 2;
			}, timer);
}

function setAlpha(target, alpha) {
	target.style.filter = "alpha(opacity="+ alpha +")";
	target.style.opacity = alpha/100;
}
/***********************************************************************************************/
/***********************************************************************************************/
//-> FUNCTION [COUNT DOWN]
/***********************************************************************************************/
function CountDown(sec){
    sec--;
    var timetoshow = sec;
    if(timetoshow.length < 2)
        timetoshow = "0" + timetoshow;
    document.getElementById("countdown").innerHTML = timetoshow;
    if(sec > 0 )
        setTimeout("CountDown("+sec+")", 1000);
}
/***********************************************************************************************/

/***********************************************************************************************/
//-> FUNCTION PARA COLOCAR CAMPOS OBRIGATÓRIOS DO CADASTRO DE CLÍNICAS
/***********************************************************************************************/
function fuc_fdp(){
	if(document.getElementById('razao_social_clinica').value == ''){ 
		showAlert('O preenchimento do campo <b>Razão Social</b> é obrigatório!');
		return false;
	} else if(document.getElementById('nome_fantasia_clinica').value == ''){ 
		showAlert('O preenchimento do campo <b>Nome Fantasia</b> é obrigatório!');
		return false;
	} else if(document.getElementById('cep').value == ''){ 
		showAlert('O preenchimento do campo <b>CEP</b> é obrigatório!');
		return false;
	} else if(document.getElementById('endereco').value == ''){ 
		showAlert('O preenchimento do campo <b>Endereço</b> é obrigatório!');
		return false;
	} else if(document.getElementById('tel_clinica').value == ''){ 
		showAlert('O preenchimento do campo <b>Telefone</b> é obrigatório!');
		return false;
	} else if(document.getElementById('email_clinica').value == ''){ 
		showAlert('O preenchimento do campo <b>E-mail Corporativo</b> é obrigatório!');
		return false;
	} else if(document.getElementById('cnpj_clinica').value == ''){ 
		showAlert('O preenchimento do campo <b>CNPJ</b> é obrigatório!');
		return false;
	} else if(document.getElementById('referencia_clinica').value == ''){ 
		showAlert('O preenchimento do campo <b>Ponto de Referência</b> é obrigatório!');
		return false;
	} else if(document.getElementById('contato_clinica').value == ''){ 
		showAlert('O preenchimento do campo <b>Responsável</b> é obrigatório!');
		return false;
	} else if(document.getElementById('cargo_responsavel').value == ''){ 
		showAlert('O preenchimento do campo <b>Cargo</b> é obrigatório!');
		return false;
	} else if(document.getElementById('tel_contato').value == ''){ 
		showAlert('O preenchimento do campo <b>Telefone Responsável</b> é obrigatório!');
		return false;
	} else{
		return true;	
	}
}


/*************************************************************************************************/
// --> FUNCTIONS - VERIFICA SE TODOS OS CAMPOS FORAM PREENCHIDOS PARA GERAR NOVA ATA DA CIPA
/*************************************************************************************************/
function new_ata_check_fields(frm){
	if(frm.gestao.value == ""){
		showAlert('O campo <b>Gestão</b> deve ser preenchido!');
		frm.gestao.focus();
		return false;
    }else if(frm.local.value == ""){
		showAlert('O campo <b>Local</b> deve ser preenchido!');
		frm.local.focus();
		return false;
	}else if(frm.n_ata.value == ""){
		showAlert('O campo <b>Nº Ata</b> deve ser preenchido!');
		frm.n_ata.focus();
		return false;
    }else if(frm.data.value == ""){
		showAlert('O campo <b>Data</b> deve ser preenchido!');
		frm.data.focus();
		return false;
	}else if(frm.hora.value == ""){
		showAlert('O campo <b>Hora</b> deve ser preenchido!');
		frm.hora.focus();
		return false;
	}else if(frm.presidente_cipa.value == ""){
		showAlert('O campo <b>Presidente da CIPA</b> deve ser preenchido!');
		frm.presidente_cipa.focus();
		return false;
	}else if(frm.suplente_cipa.value == ""){
		showAlert('O campo <b>Suplente da CIPA</b> deve ser preenchido!');
		frm.suplente_cipa.focus();
		return false;
	}else if(frm.vice_presidente.value == ""){
		showAlert('O campo <b>Vice Presidente</b> deve ser preenchido!');
		frm.vice_presidente.focus();
		return false;
    }else if(frm.suplente_vice.value == ""){
		showAlert('O campo <b>Suplente Vice Presidente</b> deve ser preenchido!');
		frm.suplente_vice.focus();
		return false;
    }else if(frm.secretaria.value == ""){
		showAlert('O campo <b>Secretária da CIPA</b> deve ser preenchido!');
		frm.secretaria.focus();
		return false;
    }else{
        return true;
	}
}
/*************************************************************************************************/

/*************************************************************************************************/
// --> FUNCTIONS -   onkeypress=\"return lastdot(this, event);\",
// Retorna o valor com 1 casa decimal separada por ponto - só números
/*************************************************************************************************/
function lastdot(field, e){
    var nv = '';
    var strCheck = '0123456789';
    var key = '';
    var whichCode = (window.Event) ? e.which : e.keyCode;
    if ((whichCode == 13) || (whichCode == 0) || (whichCode == 8))
        return true;
    //Recebe o valor digitado convertido do charcode
    key = String.fromCharCode(whichCode);
    //se o valor digitado não estiver na var strCheck, retorna falso.
    if (strCheck.indexOf(key) == -1)
        return false;
    
    if(field.value.length <= 2){
        field.value = '0.' + key;
    }else{
        for(x=0;x<=field.value.length-1;x++){
            if(field.value.charAt(x) != '.'){
                if(x==0 && field.value.charAt(x) == '0'){
                
                }else{
                    nv += field.value.charAt(x);
                }
            }
        }
        field.value = nv + '.' + key;
    }
        
    return false;
}

/***********************************************************************************************/
// --> FUNCTIONS - VERIFICA SE TODOS OS CAMPOS FORAM PREENCHIDOS - CGRT - EDIFICAÇÃO
/***********************************************************************************************/
function cgrt_edif_cf(frm){
	if(frm.tipo_edificacao.value == ""){
		showAlert('O campo <b>Tipo de edificação</b> deve ser selecionado!');
		return false;
    }else if(frm.tipo_cobertura.value == ""){
		showAlert('O campo <b>Tipo de cobertura</b> deve ser selecionado!');
		return false;
   }else if(frm.tipo_parede.value == ""){
		showAlert('O campo <b>Tipo de parede</b> deve ser selecionado!');
		return false;
	}else if(frm.tipo_piso.value == ""){
		showAlert('O campo <b>Tipo de piso</b> deve ser selecionado!');
		return false;
    }else if(frm.vent_natural.value == ""){
		showAlert('O campo <b>Ventilação natural</b> deve ser selecionado!');
		return false;
	}else if(frm.vent_artificial.value == ""){
		showAlert('O campo <b>Ventilação artificial</b> deve ser selecionado!');
		return false;
	}else if(frm.luz_natural.value == ""){
		showAlert('O campo <b>Iluminação natural</b> deve ser selecionado!');
		return false;
    }else if(frm.luz_artificial.value == ""){
		showAlert('O campo <b>Iluminação artificial</b> deve ser selecionado!');
		return false;
	}else if(frm.ruido_fundo.value == ""){
		showAlert('O campo <b>Ruído de fundo</b> deve ser preenchido!');
		return false;
	}else if(frm.ruido_operacao.value == ""){
		showAlert('O campo <b>Ruído de operação</b> deve ser preenchido!');
		return false;
	}else if(frm.aparelho_ruido.value == ""){
		showAlert('O campo <b>Aparelho de medição de ruído</b> deve ser selecionado!');
		return false;
	}else if(frm.calor.value == ""){
		showAlert('O campo <b>Calor</b> deve ser preenchido!');
		return false;
	}else if(frm.umidade.value == ""){
		showAlert('O campo <b>Umidade</b> deve ser preenchido!');
		return false;
	}else if(frm.aparelho_temperatura.value == ""){
		showAlert('O campo <b>Aparelho de medição de temperatura</b> deve ser selecionado!');
		return false;
    }else{
        return true;
	}
}
/*************************************************************************************************/


/***********************************************************************************************/
// --> FUNCTIONS - VERIFICA SE TODOS OS CAMPOS FORAM PREENCHIDOS - CGRT - DADOS COMPLEMENTARES
/***********************************************************************************************/
function cgrt_dadoscompl_cf(frm){
	if(frm.pe_direito.value == ""){
		showAlert('O campo <b>Pé direito</b> deve ser preenchido!');
		return false;
    }else if(frm.frente.value == ""){
		showAlert('O campo <b>Frente</b> deve ser preenchido!');
		return false;
   }else if(frm.comprimento.value == ""){
		showAlert('O campo <b>Comprimento</b> deve ser preenchido!');
		return false;
	}else if(frm.aparelho_medicao.value == ""){
		showAlert('O campo <b>Aparelho de medição</b> deve ser selecionado!');
		return false;
	}else if(frm.n_pavimentos.value == ""){
		showAlert('O campo <b>Número de pavimentos</b> deve ser preenchido!');
		return false;
	}else if(!isNaN(frm.n_pavimentos.value) && frm.n_pavimentos.value < 1){
		showAlert('O campo <b>Número de pavimentos</b> deve ser maior do que zero!');
		return false;
    }else if(frm.data_avaliacao.value == ""){
		showAlert('O campo <b>Data de avaliação</b> deve ser preenchido!');
		return false;
   }else if(validate_data(frm.data_avaliacao) == false){
        showAlert('O campo <b>Data de avaliação</b> não tem uma data válida!');
        return false;
	}else if(frm.hora_avaliacao.value == ""){
		showAlert('O campo <b>Hora de avaliação</b> deve ser preenchido!');
		return false;
	}else{
        return true;
	}
}
/*************************************************************************************************/



/***********************************************************************************************/
// --> FUNCTIONS - VERIFICA SE TODOS OS CAMPOS FORAM PREENCHIDOS - CGRT - POSTO DE TRABALHO
/***********************************************************************************************/
function cgrt_pt_cf(frm){
	if(frm.razao_social.value == ""){
		showAlert('O campo <b>Razão Social</b> deve ser preenchido!');
		return false;
   }else if(frm.cep.value == ""){
		showAlert('O campo <b>CEP</b> deve ser preenchido!');
		return false;
	}else if(frm.estado.value == ""){
		showAlert('O campo <b>Estado</b> deve ser selecionado!');
		return false;
	}else if(frm.endereco.value == ""){
		showAlert('O campo <b>Endereço</b> deve ser preenchido!');
		return false;
    }else if(frm.num_end.value == ""){
		showAlert('O campo <b>Número</b> deve ser maior do que zero!');
		return false;
    }else if(frm.bairro.value == ""){
		showAlert('O campo <b>Bairro</b> deve ser preenchido!');
		return false;
 	}else if(frm.municipio.value == ""){
		showAlert('O campo <b>Municipio</b> deve ser preenchido!');
		return false;
	}else if(frm.telefone.value == ""){
		showAlert('O campo <b>Telefone</b> deve ser preenchido!');
		return false;
	}else{
        return true;
	}
}
/*************************************************************************************************/

/***********************************************************************************************/
// --> FUNCTIONS - VERIFICA SE TODOS OS CAMPOS FORAM PREENCHIDOS - CGRT - REL. INFO
/***********************************************************************************************/
function cgrt_relinfo_cf(frm){
	if(frm.jornada.value == ""){
		showAlert('O campo <b>Jornada de trabalho</b> deve ser preenchido!');
		return false;
    }else if(frm.ano.value == ""){
		showAlert('O campo <b>Ano de referência</b> deve ser preenchido!');
		return false;
	}else{
        return true;
	}
}
/*************************************************************************************************/

/***********************************************************************************************/
// --> FUNCTIONS - display div - CGRT EDIFICAÇÃO VENT ARTIFICIAL
/***********************************************************************************************/
function cgrt_edif_vent_art(box){
    if(box.options[box.selectedIndex].value == 5 || box.options[box.selectedIndex].value == 6){
        document.getElementById('fadescreen').style.display='block';
        document.getElementById('ar').style.display='block';
        document.getElementById('ar').style.left = (getWidth() / 2)-250;
	    document.getElementById('ar').style.top = (getHeight() / 2)-150;
	    //document.getElementById('fadescreen').style.zIndex = 200;
	    //document.getElementById('ar').style.zIndex = 300;//parseInt(document.getElementById('fadescreen').style.zIndex);
	    //document.getElementById('darcomp').style.display='block';
	    //document.getElementById('dtestar').style.display='block';
    }else if(box.options[box.selectedIndex].value == 4 ){
        document.getElementById('fadescreen').style.display='block';
		document.getElementById('port').style.display='block';
		document.getElementById('port').style.left = (getWidth() / 2)-250;
		document.getElementById('port').style.top = (getHeight() / 2)-150;
    }else{
        hide_cgrt_edif_vent_art();
    }
}

function hide_cgrt_edif_vent_art(){
    document.getElementById('fadescreen').style.display = 'none';
    document.getElementById('ar').style.display         = 'none';
    document.getElementById('port').style.display       = 'none';
}



/***********************************************************************************************/
// --> FUNCTIONS - MEDIDAS PREVENTIVAS - CGRT
/***********************************************************************************************/
function cgrt_mp_sugestao(obj, target){
    var trg = document.getElementById(target);
    if(obj.value != ''){
        trg.selectedIndex = 2;//sugerido
        trg.className = 'inputTextobr';
        obj.className = 'inputTextobr';
    }else{
        trg.selectedIndex = 1;//existente
        trg.className = 'inputTexto';
        obj.className = 'inputTexto';
    }
}

function cgrt_mp_chg_t(obj, target){
    var tar = document.getElementById(target);
    if(obj.selectedIndex == 2){//sugerido
        tar.className = 'inputTextobr';
        obj.className = 'inputTextobr';
    }else{
        tar.className = 'inputTexto';
        tar.value = '';
        obj.className = 'inputTexto';
    }
}

function cgrt_mp_check_all(frm){
    for(x=0;x<frm.elements.length;x++){
        var field = frm.elements[x];
        if(field.className == 'inputTextobr' && field.value == ''){
            showAlert('Por favor, preencha todos os campos obrigatórios.');
            return false;
        }
        
        if(field.className == 'inputTextobr' && field.type == 'text'){
            var dt = field.value.split("/");
            if(dt[0] > 12 || dt[0] < 01){
                showAlert('Por favor, preencha todos os campos corretamente. O campo para a data sugerida tem um formato inválido.');
                return false;
            }
            
            if(dt[1] < 1900 || dt[1] > 2100){
                showAlert('Por favor, preencha todos os campos corretamente. O campo para a data sugerida tem um formato inválido.');
                return false;
            }
            
            if(field.value.length < 7){
                showAlert('Por favor, preencha todos os campos corretamente. O campo para a data sugerida deve ter o formato mm/aaaa (dois dígitos para mês e quatro para o ano).');
                return false;
            }
        }
    }
    return true;
}

/***********************************************************************************************/
// --> FUNCTIONS - Retorna largura e altura da área de visualização do browser do usuário
/***********************************************************************************************/
function getWidth() {
   return window.innerWidth && window.innerWidth > 0 ? window.innerWidth : /* Non IE */
   document.documentElement.clientWidth && document.documentElement.clientWidth > 0 ? document.documentElement.clientWidth : /* IE 6+ */
   document.body.clientWidth && document.body.clientWidth > 0 ? document.body.clientWidth : -1; /* IE 4 */
}
function getHeight() {
   return window.innerHeight && window.innerHeight > 0 ? window.innerHeight : /* Non IE */
   document.documentElement.clientHeight && document.documentElement.clientHeight > 0 ? document.documentElement.clientHeight : /* IE 6+ */
   document.body.clientHeight && document.body.clientHeight > 0 ? document.body.clientHeight : -1; /* IE 4 */
}


/***********************************************************************************************/
// --> FUNCTIONS - DIV - CHANGE STATUS / SHOW / HIDE
// - obj: div
// - method: 1 - block, 2 - inline
/***********************************************************************************************/
function changeDivVis(obj, method){
    if(obj.style.display == 'none'){
        if(typeof method == 'undefined' || method == 1){
            obj.style.display = 'block';
        }else{
            obj.style.display = 'inline';
        }
    }else{
        obj.style.display = 'none';
    }
}

/***********************************************************************************************/
// --> FUNCTIONS - CALCULO DE INADIMPLENTES
/***********************************************************************************************/
function number_format( number, decimals, dec_point, thousands_sep ) {
    // %     nota 1: Para 1000.55 retorna com precisão 1 no FF/Opera é 1,000.5, mas no IE é 1,000.6
    // *     exemplo 1: number_format(1234.56);
    // *     retorno 1: '1,235'
    // *     exemplo 2: number_format(1234.56, 2, ',', ' ');
    // *     retorno 2: '1 234,56'
    // *     exemplo 3: number_format(1234.5678, 2, '.', '');
    // *     retorno 3: '1234.57'
    // *     exemplo 4: number_format(67, 2, ',', '.');
    // *     retorno 4: '67,00'
    // *     exemplo 5: number_format(1000);
    // *     retorno 5: '1,000'
    // *     exemplo 6: number_format(67.311, 2);
    // *     retorno 6: '67.31'

    var n = number, prec = decimals;
    n = !isFinite(+n) ? 0 : +n;
    prec = !isFinite(+prec) ? 0 : Math.abs(prec);
    var sep = (typeof thousands_sep == "undefined") ? ',' : thousands_sep;
    var dec = (typeof dec_point == "undefined") ? '.' : dec_point;

    var s = (prec > 0) ? n.toFixed(prec) : Math.round(n).toFixed(prec); //fix for IE parseFloat(0.55).toFixed(0) = 0;

    var abs = Math.abs(n).toFixed(prec);
    var _, i;

    if (abs >= 1000) {
        _ = abs.split(/\D/);
        i = _[0].length % 3 || 3;

        _[0] = s.slice(0,i + (n < 0)) +
              _[0].slice(i).replace(/(\d{3})/g, sep+'$1');

        s = _.join(dec);
    } else {
        s = s.replace('.', dec);
    }

    return s;
}

function calcme(val, dt, name){
   document.getElementById('dtv').value = + new Date().getDate() + '/' + (new Date().getMonth()+1) + '/' + new Date().getFullYear();
   document.getElementById('dto').value = dt;
   document.getElementById('valb').value = number_format(val, 2, ',', '.');
   document.getElementById('tmpd').value = dt;
   document.getElementById('tmpv').value = number_format(val, 2, ',', '.');
   document.getElementById('mname').innerHTML = "<b>"+name+"</b>";
   document.getElementById('cmr').innerHTML = "";
   document.getElementById('test').style.display = 'block';
   document.getElementById('fadescreen').style.display = 'block';
   
}

/********************************************************************************************************/
// - >ALTERAR NÍVEL DO CADASTRO DE RISCOS DO CGRT (AGENTES NOCIVOS)
/********************************************************************************************************/
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

/**************************************************************************************/
// - > ATRIBUI DATA NO CADASTRO DE EXTINTOR - CGRT
/**************************************************************************************/
function dataRecarga(){
	var msg = document.getElementById("data_recarga");
	var data = msg.value.split("/");
	document.getElementById("proxima_carga").value = data[0]+"/"+data[1]+"/"+(parseInt(data[2])+1);
}

/**************************************************************************************/
// - > DESABILITAR CAMPOS DO CADASTRO DE EXTINTOR - CGRT
/**************************************************************************************/
function sugerir(obj){
	if(obj.options[obj.selectedIndex].value == "existente"){
   document.frmExtintor.extintor.disabled = 0;
   document.frmExtintor.cod_produto.disabled = 0;
   document.frmExtintor.qtd_extintor.disabled = 0;
   document.frmExtintor.data_recarga.disabled = 0;
   document.frmExtintor.numero_cilindro.disabled = 0;
   document.frmExtintor.vencimento_abnt.disabled = 0;
   document.frmExtintor.proxima_carga.disabled = 0;
   document.frmExtintor.placa_sinalizacao_id.disabled = 0;
   document.frmExtintor.demarcacao_solo_id.disabled = 0;
   document.frmExtintor.tipo_instalacao_id.disabled = 0;
   document.frmExtintor.f_inspecao.disabled = 0;
   document.frmExtintor.empresa_prestadora.disabled = 0;
	}else{
   document.frmExtintor.extintor.disabled = 0;
   document.frmExtintor.cod_produto.disabled = 0;
   document.frmExtintor.qtd_extintor.disabled = 0;
   document.frmExtintor.data_recarga.disabled = 1;
   document.frmExtintor.numero_cilindro.disabled = 1;
   document.frmExtintor.vencimento_abnt.disabled = 1;
   document.frmExtintor.proxima_carga.disabled = 1;
   document.frmExtintor.placa_sinalizacao_id.disabled = 1;
   document.frmExtintor.demarcacao_solo_id.disabled = 1;
   document.frmExtintor.tipo_instalacao_id.disabled = 1;
   document.frmExtintor.f_inspecao.disabled = 1;
   document.frmExtintor.empresa_prestadora.disabled = 1;
	}
}

/**************************************************************************************/
//DESABILITAR CAMPOS DO CADASTRO DE MANGUEIRAS - CGRT
/**************************************************************************************/
function narin(tipo_hidrante_id){
	if(tipo_hidrante_id.options[tipo_hidrante_id.selectedIndex].value != "1"){
   document.frmMangueira.tipo_hidrante_id.disabled = 0;
   document.frmMangueira.estado_abrigo.disabled = 0;
   document.frmMangueira.diametro_mangueira_id.disabled = 0;
   document.frmMangueira.registro.disabled = 0;
   document.frmMangueira.quantidade_mangueira.disabled = 0;
   document.frmMangueira.repor.disabled = 0;
   document.frmMangueira.mang_reposta.disabled = 0;
   document.frmMangueira.vistoria.disabled = 0;
   document.frmMangueira.estado_mang.disabled = 0;
   document.frmMangueira.esquicho.disabled = 0;
   document.frmMangueira.qtd_esquicho.disabled = 0;
   document.frmMangueira.chave_stors.disabled = 0;
   document.frmMangueira.pl_ident.disabled = 0;
   document.frmMangueira.demarcacao.disabled = 0;
   document.frmMangueira.porta_cont_fogo.disabled = 0;
   document.frmMangueira.qtd_porta.disabled = 0;
   document.frmMangueira.tipo_para_raio_id.disabled = 0;
   document.frmMangueira.qtd_raio.disabled = 0;
   document.frmMangueira.tipo_sistema_fixo_contra_incendio_id.disabled = 0;
   document.frmMangueira.alarme_contra_incendio_id.disabled = 0;
   document.frmMangueira.sprinkler.disabled = 0;
   document.frmMangueira.bulbos.disabled = 0;
}else{
   document.frmMangueira.tipo_hidrante_id.disabled = 0;
   document.frmMangueira.estado_abrigo.disabled = 1;
   document.frmMangueira.diametro_mangueira_id.disabled = 1;
   document.frmMangueira.registro.disabled = 1;
   document.frmMangueira.quantidade_mangueira.disabled = 1;
   document.frmMangueira.repor.disabled = 1;
   document.frmMangueira.mang_reposta.disabled = 1;
   document.frmMangueira.vistoria.disabled = 1;
   document.frmMangueira.estado_mang.disabled = 1;
   document.frmMangueira.esquicho.disabled = 1;
   document.frmMangueira.qtd_esquicho.disabled = 1;
   document.frmMangueira.chave_stors.disabled = 1;
   document.frmMangueira.pl_ident.disabled = 1;
   document.frmMangueira.demarcacao.disabled = 1;
   document.frmMangueira.porta_cont_fogo.disabled = 1;
   document.frmMangueira.qtd_porta.disabled = 1;
   document.frmMangueira.tipo_para_raio_id.disabled = 1;
   document.frmMangueira.qtd_raio.disabled = 1;
   document.frmMangueira.tipo_sistema_fixo_contra_incendio_id.disabled = 1;
   document.frmMangueira.alarme_contra_incendio_id.disabled = 1;
   document.frmMangueira.sprinkler.disabled = 1;
   document.frmMangueira.bulbos.disabled = 1;
	}
}

/**************************************************************************************/
//CADASTRO DE MANGUEIRAS
/**************************************************************************************/
function hidrante(){
	if(document.getElementById("tipo_hidrante_id").value == 2 || document.getElementById("tipo_hidrante_id").value == 3 || document.getElementById("tipo_hidrante_id").value == 7 && document.getElementById("quantidade_mangueira").value < 2){
		var ms = document.getElementById("tipo_hidrante_id");
		var m = document.getElementById("quantidade_mangueira");
		var msg = document.getElementById("mang_reposta");
		var mg = document.getElementById("repor");
		
		if(document.getElementById("quantidade_mangueira").value == 2){
			document.getElementById("repor").value = 'nenhum';
			document.getElementById("mang_reposta").value = '0';
		}else if(document.getElementById("quantidade_mangueira").value < 2){
			document.getElementById("repor").value = 'aquis';
			document.getElementById("mang_reposta").value = 2-document.getElementById("quantidade_mangueira").value;
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

/**************************************************************************************/
// - > DESABILITAR CAMPOS DO CADASTRO DE AGENTES NOCIVOS - CGRT
/**************************************************************************************/
function avl(obj){
	if(obj.options[obj.selectedIndex].value == "sim"){
   document.frmagentes_nocivos.analito.disabled = 0;
   document.frmagentes_nocivos.coletor.disabled = 0;
   document.frmagentes_nocivos.vazao_m.disabled = 0;
   document.frmagentes_nocivos.volume.disabled = 0;
   document.frmagentes_nocivos.equip.disabled = 0;
   document.frmagentes_nocivos.dtc.disabled = 0;
   document.frmagentes_nocivos.dtc2.disabled = 0;
   document.frmagentes_nocivos.dtc3.disabled = 0;
   document.frmagentes_nocivos.conclusao.disabled = 0;
   
	}else{
   document.frmagentes_nocivos.analito.disabled = 1;
   document.frmagentes_nocivos.coletor.disabled = 1;
   document.frmagentes_nocivos.vazao_m.disabled = 1;
   document.frmagentes_nocivos.volume.disabled = 1;
   document.frmagentes_nocivos.equip.disabled = 1;
   document.frmagentes_nocivos.dtc.disabled = 1;
   document.frmagentes_nocivos.dtc2.disabled = 1;
   document.frmagentes_nocivos.dtc3.disabled = 1;
   document.frmagentes_nocivos.conclusao.disabled = 1;
   
	}
}

/***********************************************************************************************/
// --> FUNCTIONS - VERIFICA SE TODOS OS CAMPOS FORAM PREENCHIDOS - CGRT - ILUMINÂNCIA
/***********************************************************************************************/
function ilumi(frm){
	if(frm.luz_atual.value == ""){
		showAlert('O campo <b>Luz Atual</b> deve ser preenchido!');
		return false;
	}else if(frm.recomendado.value == ""){
		showAlert('O campo <b>Luz Recomendado</b> deve ser selecionado!');
		return false;
	}else if(frm.exposicao.value == ""){
		showAlert('O campo <b>Tempo de Exposição</b> deve ser preenchido!');
		return false;
    }else if(frm.movel.value == ""){
		showAlert('A escolha de um <b>Móvel</b> é obrigatório!');
		return false;
 	}else if(frm.numero.value == ""){
		showAlert('O campo <b>Número</b> deve ser preenchido!');
		return false;
	}else if(frm.aparelho_luz.value == ""){
		showAlert('A escolha de um <b>Aparelho de Medição</b> é obrigatório!');
		return false;
	}else{
        return true;
	}
}
/*************************************************************************************************/

/***********************************************************************************************/
// --> FUNCTIONS - VERIFICA SE TODOS OS CAMPOS FORAM PREENCHIDOS - CGRT - AGENTES NOCIVOS
/***********************************************************************************************/
function agen_noci(frm){
	if(frm.cod_agente_risco.value == ""){
		showAlert('A escolha de um <b>Agente de Risco</b> é obrigatório!');
		return false;
	}else{
        return true;
	}
}
/*************************************************************************************************/

/***********************************************************************************************/
// --> FUNCTIONS - VERIFICA SE TODOS OS CAMPOS FORAM PREENCHIDOS - CGRT - AVALIAÇÃO AMBIENTAL
/***********************************************************************************************/
function ava_amb(frm){
	if(frm.avaliacao.value == ""){
		showAlert('Escolha se <b>Houve Avaliação</b>!');
		return false;
	}else{
        return true;
	}
}
/*************************************************************************************************/

/***********************************************************************************************/
// --> FUNCTIONS - VERIFICA SE TODOS OS CAMPOS FORAM PREENCHIDOS - CGRT - EXTINTORES
/***********************************************************************************************/
function extin(frm){
	if(frm.extintor.value == ""){
		showAlert('A escolha de um <b>Extintor</b> é obrigatório!');
		return false;
	}else if(frm.cod_produto.value == ""){
		showAlert('A escolha de um <b>Tipo de Extintor</b> é obrigatório!');
		return false;
	}else if(frm.qtd_extintor.value == ""){
		showAlert('O campo <b>Quantidade</b> deve ser preenchido!');
		return false;
	}else{
        return true;
	}
}
/*************************************************************************************************/

/***********************************************************************************************/
// --> FUNCTIONS - VERIFICA SE TODOS OS CAMPOS FORAM PREENCHIDOS - CGRT - MANGUEIRA
/***********************************************************************************************/
function mangue(frm){
	if(frm.tipo_hidrante_id.value == ""){
		showAlert('A escolha de um <b>Hidrante</b> é obrigatório!');
		return false;
	}else{
        return true;
	}
}
/*************************************************************************************************/

/***********************************************************************************************/
// --> FUNCTIONS - ATUALIZA DINÂMICA DA FUNÇÃO AO ESCOLHER UMA FUNÇÃO - CADASTRO CLIENTE
/***********************************************************************************************/
function funcao(ar){
	ar = URLDecode(ar);
	var lista = ar.split("|");
	var combo = document.getElementById("cod_funcao");
	document.getElementById("dinamica_funcao").value = lista[combo.selectedIndex];
	//alert(lista[combo.selectedIndex]);
	//return combo.selectedIndex;
}

/***********************************************************************************************/
// --> FUNCTIONS - MOSTRA DIV SE APTO COM RESTRIÇÃO - CADASTRO CLIENTE
/***********************************************************************************************/
function apto(val){
	var poiu = document.getElementById("ds");
	if(val == 'Inapto' || val == 'Apto com Restrição'){		
		poiu.style.display='block';
	}else{
		poiu.style.display='none';	
	}	
}

/***********************************************************************************************/
// --> FUNCTIONS  - CADASTRO CLIENTE
/***********************************************************************************************/
function change_pessoa_pc(obj){
    if(obj.value==0){
        is_juridica();
    }else{
        is_fisica();
    }
}

function is_fisica(){
    document.getElementById("txtRazao").innerHTML = "Nome";
    document.getElementById("nome_fantasia").disabled = true;
    document.getElementById("txtCnpj").innerHTML = "CPF";
    document.getElementById("insc_estadual").disabled = true;
    document.getElementById("insc_municipal").disabled = true;
    document.getElementById("cnae").disabled = true;
    document.getElementById("grupo_cipa").disabled = true;
    document.getElementById("grau_risco").disabled = true;
    document.getElementById("descricao_atividade").disabled = true;
    document.getElementById("classe").disabled = true;
    document.getElementById("membros_brigada").disabled = true;
    document.getElementById("membros_cipa").disabled = true;
    document.getElementById("cnpj").onkeypress = function(){
        formatar(document.getElementById("cnpj"), '###.###.###-##');
    }
}

function is_juridica(){
    document.getElementById("txtRazao").innerHTML = "Razão Social";
    document.getElementById("nome_fantasia").disabled = false;
    document.getElementById("txtCnpj").innerHTML = "CNPJ";
    document.getElementById("insc_estadual").disabled = false;
    document.getElementById("insc_municipal").disabled = false;
    document.getElementById("cnae").disabled = false;
    document.getElementById("grupo_cipa").disabled = false;
    document.getElementById("grau_risco").disabled = false;
    document.getElementById("descricao_atividade").disabled = false;
    document.getElementById("classe").disabled = false;
    document.getElementById("membros_brigada").disabled = false;
    document.getElementById("membros_cipa").disabled = false;
    document.getElementById("cnpj").onkeypress = function(){
        formatar(document.getElementById("cnpj"), '##.###.###/####-##');
    }
}
