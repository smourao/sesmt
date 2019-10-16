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

var NUM_DIGITOS_CPF  = 11;
var NUM_DIGITOS_CNPJ = 14;
var NUM_DGT_CNPJ_BASE = 8;

String.prototype.lpad = function(pSize, pCharPad)
{
	var str = this;
	var dif = pSize - str.length;
	var ch = String(pCharPad).charAt(0);
	for (; dif>0; dif--) str = ch + str;
	return (str);
} //String.lpad


/**
 * Adiciona método trim() à classe String.
 * Elimina brancos no início e fim da String.
 */
String.prototype.trim = function()
{
	return this.replace(/^\s*/, "").replace(/\s*$/, "");
} //String.trim


/**
 * Elimina caracteres de formatação e zeros à esquerda da string
 * de número fornecida.
 * @param String pNum
 *      String de número fornecida para ser desformatada.
 * @return String de número desformatada.
 */
function unformatNumber(pNum)
{
	return String(pNum).replace(/\D/g, "").replace(/^0+/, "");
} //unformatNumber


/**
 * Formata a string fornecida como CNPJ ou CPF, adicionando zeros
 * à esquerda se necessário e caracteres separadores, conforme solicitado.
 * @param String pCpfCnpj
 *      String fornecida para ser formatada.
 * @param boolean pUseSepar
 *      Indica se devem ser usados caracteres separadores (. - /).
 * @param boolean pIsCnpj
 *      Indica se a string fornecida é um CNPJ.
 *      Caso contrário, é CPF. Default = false (CPF).
 * @return String de CPF ou CNPJ devidamente formatada.
 */
function formatCpfCnpj(pCpfCnpj, pUseSepar, pIsCnpj)
{
	if (pIsCnpj==null) pIsCnpj = false;
	if (pUseSepar==null) pUseSepar = true;
	var maxDigitos = pIsCnpj? NUM_DIGITOS_CNPJ: NUM_DIGITOS_CPF;
	var numero = unformatNumber(pCpfCnpj);

	numero = numero.lpad(maxDigitos, '0');

	if (!pUseSepar) return numero;

	if (pIsCnpj)
	{
		reCnpj = /(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/;
		numero = numero.replace(reCnpj, "$1.$2.$3/$4-$5");
	}
	else
	{
		reCpf  = /(\d{3})(\d{3})(\d{3})(\d{2})$/;
		numero = numero.replace(reCpf, "$1.$2.$3-$4");
	}
	return numero;
} //formatCpfCnpj


/**
 * Calcula os 2 dígitos verificadores para o número-efetivo pEfetivo de
 * CNPJ (12 dígitos) ou CPF (9 dígitos) fornecido. pIsCnpj é booleano e
 * informa se o número-efetivo fornecido é CNPJ (default = false).
 * @param String pEfetivo
 *      String do número-efetivo (SEM dígitos verificadores) de CNPJ ou CPF.
 * @param boolean pIsCnpj
 *      Indica se a string fornecida é de um CNPJ.
 *      Caso contrário, é CPF. Default = false (CPF).
 * @return String com os dois dígitos verificadores.
 */
function dvCpfCnpj(pEfetivo, pIsCnpj)
{
	if (pIsCnpj==null) pIsCnpj = false;
	var i, j, k, soma, dv;
	var cicloPeso = pIsCnpj? NUM_DGT_CNPJ_BASE: NUM_DIGITOS_CPF;
	var maxDigitos = pIsCnpj? NUM_DIGITOS_CNPJ: NUM_DIGITOS_CPF;
	var calculado = formatCpfCnpj(pEfetivo + "00", false, pIsCnpj);
	calculado = calculado.substring(0, maxDigitos - 2);
	var result = "";

	for (j = 1; j <= 2; j++)
	{
		k = 2;
		soma = 0;
		for (i = calculado.length-1; i >= 0; i--)
		{
			soma += (calculado.charAt(i) - '0') * k;
			k = (k-1) % cicloPeso + 2;
		}
		dv = 11 - soma % 11;
		if (dv > 9) dv = 0;
		calculado += dv;
		result += dv
	}

	return result;
} //dvCpfCnpj


/**
 * Testa se a String pCpf fornecida é um CPF válido.
 * Qualquer formatação que não seja algarismos é desconsiderada.
 * @param String pCpf
 *      String fornecida para ser testada.
 * @return <code>true</code> se a String fornecida for um CPF válido.
 */
function isCpf(pCpf)
{
	var numero = formatCpfCnpj(pCpf, false, false);
	if (numero.length > NUM_DIGITOS_CPF) return false;

	var base = numero.substring(0, numero.length - 2);
	var digitos = dvCpfCnpj(base, false);
	var algUnico, i;

	// Valida dígitos verificadores
	if (numero != "" + base + digitos) return false;

	/* Não serão considerados válidos os seguintes CPF:
	 * 000.000.000-00, 111.111.111-11, 222.222.222-22, 333.333.333-33, 444.444.444-44,
	 * 555.555.555-55, 666.666.666-66, 777.777.777-77, 888.888.888-88, 999.999.999-99.
	 */
	algUnico = true;
	for (i=1; algUnico && i<NUM_DIGITOS_CPF; i++)
	{
		algUnico = (numero.charAt(i-1) == numero.charAt(i));
	}
	return (!algUnico);
} //isCpf


/**
 * Testa se a String pCnpj fornecida é um CNPJ válido.
 * Qualquer formatação que não seja algarismos é desconsiderada.
 * @param String pCnpj
 *      String fornecida para ser testada.
 * @return <code>true</code> se a String fornecida for um CNPJ válido.
 */
function isCnpj(pCnpj)
{
	var numero = formatCpfCnpj(pCnpj, false, true);
	if (numero.length > NUM_DIGITOS_CNPJ) return false;

	var base = numero.substring(0, NUM_DGT_CNPJ_BASE);
	var ordem = numero.substring(NUM_DGT_CNPJ_BASE, 12);
	var digitos = dvCpfCnpj(base + ordem, true);
	var algUnico;

	// Valida dígitos verificadores
	if (numero != "" + base + ordem + digitos) return false;

	/* Não serão considerados válidos os CNPJ com os seguintes números BÁSICOS:
	 * 11.111.111, 22.222.222, 33.333.333, 44.444.444, 55.555.555,
	 * 66.666.666, 77.777.777, 88.888.888, 99.999.999.
	 */
	algUnico = numero.charAt(0) != '0';
	for (i=1; algUnico && i<NUM_DGT_CNPJ_BASE; i++)
	{
		algUnico = (numero.charAt(i-1) == numero.charAt(i));
	}
	if (algUnico) return false;

	/* Não será considerado válido CNPJ com número de ORDEM igual a 0000.
	 * Não será considerado válido CNPJ com número de ORDEM maior do que 0300
	 * e com as três primeiras posições do número BÁSICO com 000 (zeros).
	 * Esta crítica não será feita quando o no BÁSICO do CNPJ for igual a 00.000.000.
	 */
	if (ordem == "0000") return false;
	return (base == "00000000"
		|| parseInt(ordem, 10) <= 300 || base.substring(0, 3) != "000");
} //isCnpj


/**
 * Testa se a String pCpfCnpj fornecida é um CPF ou CNPJ válido.
 * Se a String tiver uma quantidade de dígitos igual ou inferior
 * a 11, valida como CPF. Se for maior que 11, valida como CNPJ.
 * Qualquer formatação que não seja algarismos é desconsiderada.
 * @param String pCpfCnpj
 *      String fornecida para ser testada.
 * @return <code>true</code> se a String fornecida for um CPF ou CNPJ válido.
 */
function isCpfCnpj(pCpfCnpj)
{
	var numero = pCpfCnpj.replace(/\D/g, "");
	if (numero.length > NUM_DIGITOS_CPF)
		return isCnpj(pCpfCnpj)
	else
		return isCpf(pCpfCnpj);
} //isCpfCnpj


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

function cep(){
var cep = document.getElementById("cep1").value+document.getElementById("cep2").value;
var url = "include/cep.php?cep="+cep;
url = url + "&cache=" + new Date().getTime();//para evitar problemas com o cache
http.open("GET", url, true);
//http.setRequestHeader("Content-Type","text/html; charset=ISO-8859-1");
http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;");
http.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate");
http.setRequestHeader("Cache-Control", "post-check=0, pre-check=0");
http.setRequestHeader("Pragma", "no-cache");

http.onreadystatechange = cep_reply;
http.send(null);
}

function cep_reply(){
if(http.readyState == 4)
{

    var msg = http.responseText;
    //Response.Charset="ISO-8859-1";
    msg = msg.replace(/\+/g," ");
    msg = unescape(msg);
    var data = msg.split("|");
    document.getElementById("endereco").value = data[0]+" "+data[1];
    document.getElementById("bairro").value = data[2];
    document.getElementById("cidade").value = data[3];
    document.getElementById("estado").value = data[4];
}else{
 if (http.readyState==1){
    document.getElementById("endereco").value = "atualizando...";
    document.getElementById("bairro").value = "atualizando...";
    document.getElementById("cidade").value = "atualizando...";
    document.getElementById("estado").value = "atualizando...";
    }
 }
}

function mascara_cep(cep){
         if (cep.length == 5){
            document.getElementById("cep2").focus();
         }
}
function mascara_cep2(cep){
         if (cep.length == 3){
            document.getElementById("endereco_num").focus();
            cep();
         }
}

function mascara_tel1(tel){
         if (tel.length == 2){
               document.getElementById("fone1").focus();
         }
}

function mascara_tel2(tel){
         if (tel.length == 2){
            document.getElementById("fone2").focus();
         }
}

function mascara_tel3(tel){
         if (tel.length == 2){
            document.getElementById("fone3").focus();
         }
}


function mascara_tel(tel){
//alert(tel.value);
         if (tel.value.length == 4){
         var my_tel = tel.value +"-";
            document.getElementById(tel.name).value = my_tel;
         }
}

function cnpj_a(n){
//alert("ok");
         if (n.value.length == 2){
            document.getElementById("cmp2").focus();
         }
}
function cnpj2(n){
         if (n.value.length == 3){
            document.getElementById("cnpj3").focus();
         }
}

function cnpj_c(n){
         if (n.value.length == 3){
            document.getElementById("cnpj4").focus();
         }
}

function cnpj_d(n){
         if (n.value.length == 4){
            document.getElementById("cnpj5").focus();
         }
}

function faxddd(n){
         if (n.value.length == 2){
            document.getElementById("fone4").focus();
         }
}

function nextelddd(n){
         if (n.value.length == 2){
            document.getElementById("nextel").focus();
         }
}

/*function mascara_tel(tel){
//alert(tel.value);
         if (tel.value.length == 4){
         var my_tel = tel.value +"-";
            document.getElementById(tel.name).value = my_tel;
         }
}   */



function doNext(el)
{
if (el.value.length < el.getAttribute('maxlength')) return;
var nextEl = el.form.elements[el.tabIndex+1];
if (nextEl && nextEl.focus) nextEl.focus();
}

function is_email(email)
    {
      er = /^[a-zA-Z0-9][a-zA-Z0-9\._-]+@([a-zA-Z0-9\._-]+\.)[a-zA-Z-0-9]{2}/;

      if(er.exec(email))
        {
          return true;
        } else {
          return false;
        }
    }

function valida_registro(){
   f = document.cadastro;

   if(f.email.value ==""){alert("O campo E-Mail deve ser preenchido!"); return false;}
   if(is_email(f.email.value)==false){alert("O campo E-Mail não foi preenchido corretamente!"); return false;}
   if(f.senha.value ==""){alert("O campo Senha deve ser preenchido!"); return false;}
   if(f.senha2.value ==""){alert("O campo Confirmação deve ser preenchido!"); return false;}
   if(f.senha.value != f.senha2.value){alert("Senha e confirmação não conferem!"); return false;}
   if(f.pessoa[0].checked ==false && f.pessoa[1].checked ==false){alert("Selecione o tipo de pessoa!"); return false;}

   if(f.msn.value != ""){
      if(is_email(f.msn.value)==false){alert("O campo MSN não foi preenchido corretamente!"); return false;}
   }

   if(f.pessoa[0].checked == true){

      if(f.cpf.value !=""){
         if(!isCpf(f.cpf.value)){
            alert("CPF Inválido!");
            return false;
         }
      }
      if(f.nome.value ==""){alert("O campo Nome deve ser preenchido!"); return false;}
      if(f.sexo[0].checked == false & f.sexo[1].checked == false){alert("O campo Sexo deve ser selecionado!"); return false;}
      if(f.dia.value ==""){alert("O campo dia de Nascimento deve ser preenchido!"); return false;}
      if(f.dia.value > 31 || f.dia.value < 1){alert("O campo dia de Nascimento deve ser preenchido corretamente!"); return false;}
      if(f.mes.value ==""){alert("O campo mes de Nascimento deve ser preenchido!"); return false;}
      if(f.mes.value > 12 || f.mes.value < 1){alert("O campo mês de Nascimento deve ser preenchido corretamente!"); return false;}
      if(f.ano.value ==""){alert("O campo ano de Nascimento deve ser preenchido!"); return false;}
      if(f.ano.value < 1900){alert("O campo ano de Nascimento deve ser preenchido corretamente!"); return false;}
      if(f.cpf.value ==""){alert("O campo CPF deve ser preenchido!"); return false;}
      if(f.profissao[0].selected){alert("O campo Profissão deve ser preenchido!"); return false;}
      if(f.instituicao.value ==""){alert("O campo Instituição deve ser preenchido!"); return false;}
      if(f.ddd1.value =="" || f.fone1.value == ""){alert("O campo Telefone deve ser preenchido!"); return false;}
   }
   if(f.pessoa[1].checked == true){
      if(f.razao_social.value ==""){alert("O campo Razão Social deve ser preenchido!"); return false;}
      if(f.cnpj1.value ==""){alert("O campo CNPJ deve ser preenchido!"); return false;}
      if(f.cmp2.value ==""){alert("O campo CNPJ deve ser preenchido!"); return false;}
      if(f.cnpj3.value ==""){alert("O campo CNPJ deve ser preenchido!"); return false;}
      if(f.cnpj4.value ==""){alert("O campo CNPJ deve ser preenchido!"); return false;}
      if(f.cnpj5.value ==""){alert("O campo CNPJ deve ser preenchido!"); return false;}
      if(f.nome_fantasia.value ==""){alert("O campo Nome Fantasia deve ser preenchido!"); return false;}
      if(f.insc_estadual.value ==""){alert("O campo Inscrição Estadual deve ser preenchido!"); return false;}
      if(f.insc_municipal.value ==""){alert("O campo Inscrição Municipal deve ser preenchido!"); return false;}
      if(f.colaboradores.value ==""){alert("O campo Colaboradores deve ser preenchido!"); return false;}
      if(f.ddd2.value =="" || f.fone2.value == ""){alert("O campo Telefone Comercial deve ser preenchido!"); return false;}
   }

   if(f.cep1.value =="" || f.cep2.value==""){alert("O campo CEP deve ser preenchido!"); return false;}
   if(f.endereco.value ==""){alert("O campo Endereço deve ser preenchido!"); return false;}
   if(f.endereco_num.value ==""){alert("O campo Número deve ser preenchido!"); return false;}
   if(f.bairro.value ==""){alert("O campo Bairro deve ser preenchido!"); return false;}
   if(f.cidade.value ==""){alert("O campo Cidade deve ser preenchido!"); return false;}
   if(f.estado.value ==""){alert("O campo Estado deve ser preenchido!"); return false;}
   if(f.senha.value ==""){alert("O campo Senha deve ser preenchido!"); return false;}
return true;
}


function sWindow(url)
{
window.open(url,"SESMT","status=no,resizable=yes,scrollbars=yes,menubar=no,width=600,height=400,left=150,top=100");
}

function toCarrinho(){
   //BUSCA OS DADOS PRA ENVIAR O TEXTO DE DIMENSAO
   var combo = document.getElementById("medida");
   document.getElementById("dimensao").value = combo.options[combo.selectedIndex].text;

   //VALIDAÇÃO DE CAMPOS
   //####################
   if(document.getElementById("material").value == ""){
      document.getElementById("erro").innerHTML = "Selecione um Material!";
      return false;
   }
   if(document.getElementById("acabamento").value == ""){
      document.getElementById("erro").innerHTML = "Selecione um Acabamento!";
      return false;
   }
   if(document.getElementById("espessura").value == ""){
      document.getElementById("erro").innerHTML = "Selecione uma Espessura!";
      return false;
   }
   if(document.getElementById("medida").value == ""){
      document.getElementById("erro").innerHTML = "Selecione uma Medida!";
      return false;
   }
   if(document.getElementById("qnt").value == ""){
      document.getElementById("erro").innerHTML = "Selecione a Quantidade!";
      return false;
   }

   return true;
}

function RemoveFromCar(msg) {
   if (confirm(msg)) {
      //location.href="?page=prod_edit&act=del&id="+msg;
      return true;
   }
   return false;
}

//onKeyPress=”return(formataMoeda(this,’.',’,',event))”
/*
function formataMoeda(objTextBox,SeparadorMilesimo, SeparadorDecimal,e){
    var sep = 0;
    var key = ”;
    var i = j = 0;
    var len = len2 = 0;
    var strCheck = ‘0123456789?;
    var aux = aux2 = ”;
    var whichCode = (window.Event) ? e.which : e.keyCode;
    // 13=enter, 8=backspace as demais retornam 0(zero)
    // whichCode==0 faz com que seja possivel usar todas as teclas como del, setas, etc
    if ((whichCode == 13) || (whichCode == 0) || (whichCode == 8))
    return true;
    key = String.fromCharCode(whichCode); // Valor para o código da Chave     if (strCheck.indexOf(key) == -1)
   	return false; // Chave inválida
    len = objTextBox.value.length;
    for(i = 0; i < len; i++)
        if ((objTextBox.value.charAt(i) != ‘0?) && (objTextBox.value.charAt(i) != SeparadorDecimal))
       	break;
   aux = ”;
    for(; i  2) {
        aux2 = ”;
        for (j = 0, i = len - 3; i >= 0; i–) {
            if (j == 3) {
                aux2 += SeparadorMilesimo;
                j = 0;
            }
           aux2 += aux.charAt(i);
            j++;
        }
        objTextBox.value = ”;
        len2 = aux2.length;
        for (i = len2 - 1; i >= 0; i–)
        	objTextBox.value += aux2.charAt(i);
        objTextBox.value += SeparadorDecimal + aux.substr(len - 2, len);
    }
    return false;
}
        */

function uni_sum(){
//    var msg = http.responseText;
    var a = new Number();
    if(document.getElementById("qnt").value < 1){
      document.getElementById("erro").innerHTML = "Selecione a quantidade!";
      return false;
    }else{
       a = parseFloat(document.getElementById("unt").value * document.getElementById("qnt").value);
       document.getElementById("total").value = a.toFixed(2);
       document.getElementById("price").value = document.getElementById("unt").value;
       document.getElementById("erro").innerHTML = "";
    }

}


function f_fisica(){
   document.cadastro.nome.disabled = 0;
   document.cadastro.sexo[0].disabled = 0;
   document.cadastro.sexo[1].disabled = 0;
   document.cadastro.dia.disabled = 0;
   document.cadastro.mes.disabled = 0;
   document.cadastro.ano.disabled = 0;
   document.cadastro.cpf.disabled = 0;
   document.cadastro.profissao.disabled = 0;
   document.cadastro.instituicao.disabled = 0;
//-------------------------------------------------
   document.cadastro.razao_social.disabled = 1;
   document.cadastro.cnpj1.disabled = 1;
   document.cadastro.cnpj3.disabled = 1;
   document.cadastro.cnpj4.disabled = 1;
   document.cadastro.cnpj5.disabled = 1;
   document.cadastro.nome_fantasia.disabled = 1;
   document.cadastro.cmp2.disabled = 1;
   document.cadastro.insc_estadual.disabled = 1;
   document.cadastro.insc_municipal.disabled = 1;
   document.cadastro.colaboradores.disabled = 1;
   document.cadastro.cnae.disabled = 1;
   document.cadastro.responsavel.disabled = 1;
   document.cadastro.cargo.disabled = 1;
   document.cadastro.email_pessoal.disabled = 1;
   document.cadastro.sexo_responsavel[0].disabled = 1;
   document.cadastro.sexo_responsavel[1].disabled = 1;
   document.cadastro.dia_responsavel.disabled = 1;
   document.cadastro.mes_responsavel.disabled = 1;
   document.cadastro.ano_responsavel.disabled = 1;




}

function f_juridica(){
   document.cadastro.nome.disabled = 1;
   document.cadastro.sexo[0].disabled = 1;
   document.cadastro.sexo[1].disabled = 1;
   document.cadastro.dia.disabled = 1;
   document.cadastro.mes.disabled = 1;
   document.cadastro.ano.disabled = 1;
   document.cadastro.cpf.disabled = 1;
   document.cadastro.profissao.disabled = 1;
   document.cadastro.instituicao.disabled = 1;
//-------------------------------------------------
   document.cadastro.razao_social.disabled = 0;
   document.cadastro.cnpj1.disabled = 0;
   document.cadastro.cmp2.disabled = 0;
   document.cadastro.cnpj3.disabled = 0;
   document.cadastro.cnpj4.disabled = 0;
   document.cadastro.cnpj5.disabled = 0;
   document.cadastro.nome_fantasia.disabled = 0;
   document.cadastro.insc_estadual.disabled = 0;
   document.cadastro.insc_municipal.disabled = 0;
   document.cadastro.colaboradores.disabled = 0;
   document.cadastro.cnae.disabled = 0;
   document.cadastro.responsavel.disabled = 0;
   document.cadastro.cargo.disabled = 0;
   document.cadastro.email_pessoal.disabled = 0;
   document.cadastro.sexo_responsavel[0].disabled = 0;
   document.cadastro.sexo_responsavel[1].disabled = 0;
   document.cadastro.dia_responsavel.disabled = 0;
   document.cadastro.mes_responsavel.disabled = 0;
   document.cadastro.ano_responsavel.disabled = 0;

}



function verifycnpj(){

   var cnpj = document.getElementById("cnpj1").value+"."+document.getElementById("cmp2").value+"."+document.getElementById("cnpj3").value+"/"+document.getElementById("cnpj4").value+"-"+document.getElementById("cnpj5").value;
   var uid = 0;
  //alert(cnpj);
   var url = "pages/findbycnpj.php?cnpj="+cnpj;
   url = url + "&uid=" + uid;//para evitar problemas com o cache
   url = url + "&cache=" + new Date().getTime();//para evitar problemas com o cache

   if(cnpj.length >= 17){
      //alert(cnpj);
      http.open("GET", url, true);
      http.onreadystatechange = cnpj_reply;
      http.send(null);
   }
}


/*
function cep(){
var cep = document.getElementById("cep1").value+document.getElementById("cep2").value;
var url = "include/cep.php?cep="+cep;
http.open("GET", url, true);
http.onreadystatechange = cep_reply;
http.send(null);
}



function cep_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
    var data = msg.split("|");
    document.getElementById("endereco").value = data[0]+" "+data[1];
    document.getElementById("bairro").value = data[2];
    document.getElementById("cidade").value = data[3];
    document.getElementById("estado").value = data[4];
}else{
 if (http.readyState==1){
    document.getElementById("endereco").value = "atualizando...";
    document.getElementById("bairro").value = "atualizando...";
    document.getElementById("cidade").value = "atualizando...";
    document.getElementById("estado").value = "atualizando...";
    }
 }
} */

function cnpj_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
    var data = msg.split("|");

    //alert(msg);
    //alert(data[0]);
    var cep = data[5].replace(".","").replace("-","");
    //alert(cep);
    document.getElementById("razao_social").value = data[0];
    document.getElementById("nome_fantasia").value = data[1];
    document.getElementById("insc_estadual").value = data[2];
    document.getElementById("insc_municipal").value = data[3];
    document.getElementById("colaboradores").value = data[4];
    document.getElementById("cep1").value = cep.substring(0,5);
    document.getElementById("cep2").value = cep.substring(5,8);
    var cp = document.getElementById("cep2");
    cp.focus();
    var n = document.getElementById("endereco_num");
    n.focus();

    //document.getElementById("estado").value = data[4];
}else{
 if (http.readyState==1){
         document.getElementById("razao_social").value = "Verificando dados...";
         document.getElementById("nome_fantasia").value = "Verificando dados...";
         document.getElementById("insc_estadual").value = "Verificando dados...";
         document.getElementById("insc_municipal").value = "Verificando dados...";
         document.getElementById("colaboradores").value = "Verificando dados...";
    }
 }
}

function sugestao_localidade(login){
//alert(login);
if(document.getElementById("sugestao_bairro").value == ""){
   alert("O campo sugestão deve ser preenchido!");
   //return false;
}else{
var sug = document.getElementById("sugestao_bairro").value;
var url = "pages/abra_seu_negocio/sugestao_localidade.php?sugestao="+sug+"&login="+login;
http.open("GET", url, true);
http.onreadystatechange = sugestao_localidade_reply;
http.send(null);
}
}
function sugestao_localidade_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;

    document.getElementById("sugestao").innerHTML = "Sua sugestão foi recebida e será analisada. Em breve, você receberá um email de confirmação!<br>"+msg;
}else{
 if (http.readyState==1){
         document.getElementById("btnSugestao").value = "Enviando...";
         document.getElementById("btnSugestao").disabled = 1;
         document.getElementById("sugestao_bairro").disabled = 1;
    }
 }
}


/*VALIDA CPF DE FUNCIONÁRIO - RELAÇÃO DE FUNCIONÁRIOS*/
function cpf_funcionario(){
if(document.getElementById("cpf").value == ""){
    //alert("Preencha o campo CPF do colaborador!");
    return false;
}
var url = "pages/cliente/cpf_funcionario.php?cpf="+document.getElementById("cpf").value;
http.open("GET", url, true);
http.onreadystatechange = cpf_funcionario_reply;
http.send(null);
}
function cpf_funcionario_reply(){
if(http.readyState == 4)
{
    var msgz = http.responseText;
    msgz = msgz.replace(/\+/g," ");
    msgz = unescape(msgz);

    if(msgz != ""){
        alert(msgz);
        document.getElementById("cpf").style.backgroundColor = "#c05d5d";//fudeu
        //return false;
    }else{
        document.getElementById("cpf").style.backgroundColor = "#5dc062";//ok
        document.getElementById("tosend").value = 1;
        //return true;
    }
}else{
 if (http.readyState==1){
        document.getElementById("cpf").style.backgroundColor = "#aca5a5";
    }
 }
}



/*SIMULADOR DE ORCAMENTOS - MOSTA/ATUALIZA LISTA DE PRODUTOS*/
function update_orcamento(){
//alert('1');
var url = "pages/cliente/update_orcamento.php?orcamento="+document.getElementById("orca").value;
url = url + "&cod_cliente=" + document.getElementById("cod_cliente").value;
url = url + "&cod_filial=" + document.getElementById("cod_filial").value;
url = url + "&cache=" + new Date().getTime();//para evitar problemas com o cache
//alert(url);
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
    var msgz = ex[1];//http.responseText;

    //msgz = msgz.replace(/\+/g," ");
    //msgz = unescape(msgz);
    //alert('resposta');

    var total = 0;
    var lista = msgz.split("£");
    var tmp = lista[0].split("|");

    if(tmp[8] == 1 || tmp[9] == 4){
       var retorno = "<table border=1 width=100%>";
       retorno += "<tr>";
       retorno += "<td align=center width=10><font size=1><b>Excluir</b></font></td>";
       retorno += "<td align=center><font size=1><b>Descrição.</b></font></td>";
       retorno += "<td align=center width=10><font size=1><b>Quant.</b></font></td>";
       retorno += "<td align=center width=10><font size=1><b>Preço</b></font></td>";
       retorno += "<td align=center width=10><font size=1><b>Total</b></font></td>";
       retorno += "</tr>";
//       alert(msgz);
       for(var x=0;x<lista.length -1;x++){
          retorno += "<tr>";
          var data = lista[x].split("|");
          if(document.getElementById("aprovado").value != 1 && document.getElementById("aprovado").value != 2){
             retorno += "<td align=center><center><font size=1><a href='javascript:remove_orcamento_produto("+data[0]+");' class=excluir><font size=1>Excluir</font></a></font></td>";
          }else{
             retorno += "<td align=center>&nbsp;</td>";
          }
          if(data[10] != ""){
             retorno += "<td align=left onMouseOver=\"return overlib('<b>Legenda:</b> "+data[10]+"');\" onMouseOut=\"return nd();\"><font size=1>"+data[4]+"</font></td>";
          }else{
             retorno += "<td align=left><font size=1>"+data[4]+"</font></td>";
          }
          retorno += "<td align=center><font size=1>"+data[2]+"</font></td>";
          retorno += "<td align=center><font size=1>"+float2moeda(data[3])+"</font></td>";
          retorno += "<td align=center><font size=1>"+float2moeda((data[3]*data[2]))+"</font></td>";
          retorno += "</tr>";

          total+=(data[3]*data[2]);

          }
          retorno += "<tr>";
          retorno += "<td colspan=2 align=right><b>TOTAL</b></td>";
          retorno += "<td></td>";
          retorno += "<td colspan=2 align=right><b>"+float2moeda(total)+"</b></td>";
          retorno += "</table>";
    }else{
       var retorno = "<table border=1 width=100%>";
       retorno += "<tr>";
       retorno += "<td align=center width=10><font size=1><b>Excluir</b></font></td>";
       retorno += "<td align=center><font size=1><b>Descrição.</b></font></td>";
       retorno += "<td align=center width=10><font size=1><b>Quant.</b></font></td>";
       retorno += "</tr>";

       for(var x=0;x<lista.length -1;x++){
          retorno += "<tr>";
          var data = lista[x].split("|");
          if(document.getElementById("aprovado").value != 1 && document.getElementById("aprovado").value != 2){
             retorno += "<td align=center><center><font size=1><a href='javascript:remove_orcamento_produto("+data[0]+");' class=excluir><font size=1>Excluir</font></a></font></td>";
          }else{
             retorno += "<td align=center>&nbsp;</td>";
          }

          if(data[10] != ""){
             retorno += "<td align=left onMouseOver=\"return overlib('<b>Legenda:</b> "+data[10]+"');\" onMouseOut=\"return nd();\"><font size=1>"+data[4]+"</font></td>";
          }else{
             retorno += "<td align=left><font size=1>"+data[4]+"</font></td>";
          }
          //retorno += "<td align=left><font size=1>"+data[4]+"</font></td>";

          retorno += "<td align=center><font size=1>"+data[2]+"</font></td>";
          retorno += "</tr>";

          total+=(data[3]*data[2]);

          }
          retorno += "</table>";
    }
    

    
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
//alert(pcode);
//alert(escape(document.getElementById("leg").options[document.getElementById("leg").selectedIndex].value));
if(qnt > 0){
var url = "add_orcamento_prod.php?orcamento="+window.parent.document.getElementById("orca").value;
url = url + "&cod_cliente=" + window.parent.document.getElementById("cod_cliente").value;
url = url + "&cod_filial=" + window.parent.document.getElementById("cod_filial").value;
url = url + "&qnt=" + qnt;
url = url + "&cod_produto=" + pcode;
if(document.getElementById("leg")){
   url = url + "&legenda=" + escape(document.getElementById("leg").options[document.getElementById("leg").selectedIndex].value);
}
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
//    alert(msgz);
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
var url = "pages/cliente/remove_orcamento_prod.php?orcamento="+document.getElementById("orca").value;
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


function gerar_contrato_orcamento(){
if(document.getElementById("orc").value != ""){
   var url = "pages/cliente/gerar_contrato_orcamento.php?orcamento=" + document.getElementById("orc").value;
   url = url + "&cod_cliente=" + document.getElementById("cod_cli").value;
   url = url + "&cache=" + new Date().getTime();//para evitar problemas com o cache
   http.open("GET", url, true);
   http.onreadystatechange = gerar_contrato_orcamento_reply;
   http.send(null);
}else{
    document.getElementById("ce").disabled = true;
    document.getElementById("ca").disabled = true;
    document.getElementById("cf").disabled = true;
    document.getElementById("cm").disabled = true;
    document.getElementById("ce").checked = false;
    document.getElementById("ca").checked = false;
    document.getElementById("cf").checked = false;
    document.getElementById("cm").checked = false;
}
}

function gerar_contrato_orcamento_reply(){
if(http.readyState == 4)
{
    var msgz = http.responseText;
    msgz = msgz.replace(/\+/g," ");
    msgz = unescape(msgz);
    var data = msgz.split("|");
    //alert(msgz);
    // 0 - Número de orçamento inexistente
    // 1 - Contrato normal (aberto, fechado ou misto)
    // 2 - Específico
        document.getElementById("ce").checked = false;
        document.getElementById("ca").checked = false;
        document.getElementById("cf").checked = false;
        document.getElementById("cm").checked = false;
        document.getElementById("ce").disabled = true;
        document.getElementById("ca").disabled = true;
        document.getElementById("cf").disabled = true;
        document.getElementById("cm").disabled = true;

        var parcelas = document.getElementById("parcelas");
        if(data[1] <= 700){
           parcelas.options.length = 2;
           parcelas.options[0].text = 'À vista'; parcelas.options[0].value = "0";
           parcelas.options[1].text = '03x  s/ taxa 18%'; parcelas.options[0].value = "1";
        }else{
           //parcelas.options.length = 0;
           parcelas.options.length = 5;
           parcelas.options[0].text = 'À vista'; parcelas.options[0].value = "0";
           parcelas.options[1].text = '03x  s/ taxa 18%';parcelas.options[0].value = "1";
           parcelas.options[2].text = '06x  c/ taxa 18%';parcelas.options[0].value = "2";
           parcelas.options[3].text = '10x  c/ taxa 18%';parcelas.options[0].value = "3";
           parcelas.options[4].text = '12x  c/ taxa 18%';parcelas.options[0].value = "4";
        }

    if(data[0] == "0"){
        alert("Número de orçamento incorreto / inexistente!");
        document.getElementById("ce").disabled = true;
        document.getElementById("ca").disabled = true;
        document.getElementById("cf").disabled = true;
        document.getElementById("cm").disabled = true;
        document.getElementById("ce").checked = false;
        document.getElementById("ca").checked = false;
        document.getElementById("cf").checked = false;
        document.getElementById("cm").checked = false;
    }else if(data[0] == "1"){
        document.getElementById("ca").disabled = false;
        document.getElementById("cf").disabled = false;
        if(data[1] >= 45000){
            document.getElementById("cm").disabled = false;
        }
        document.getElementById("ce").disabled = true;

    }else if(data[0] == "2"){
        document.getElementById("ce").disabled = false;
        document.getElementById("ce").checked = true;
        document.getElementById("ca").disabled = true;
        document.getElementById("cf").disabled = true;
        document.getElementById("cm").disabled = true;
    }else{
        document.getElementById("ce").disabled = true;
        document.getElementById("ca").disabled = true;
        document.getElementById("cf").disabled = true;
        document.getElementById("cm").disabled = true;
        document.getElementById("ce").checked = false;
        document.getElementById("ca").checked = false;
        document.getElementById("cf").checked = false;
        document.getElementById("cm").checked = false;
    }
    document.getElementById("orc_loading").className='loading_done';
    document.getElementById("orc").disabled=false;
    document.getElementById("parcelas").disabled = false;
    document.getElementById("vencimento").disabled = false;
    document.getElementById("validade").disabled = false;
    document.getElementById("submit").disabled = false;
}else{
 if (http.readyState==1){
        document.getElementById("orc_loading").className='loading';
        document.getElementById("orc").disabled= true;
        document.getElementById("ce").disabled = true;
        document.getElementById("ca").disabled = true;
        document.getElementById("cf").disabled = true;
        document.getElementById("cm").disabled = true;
        document.getElementById("ce").checked = false;
        document.getElementById("ca").checked = false;
        document.getElementById("cf").checked = false;
        document.getElementById("cm").checked = false;

        document.getElementById("parcelas").disabled = true;
        document.getElementById("vencimento").disabled = true;
        document.getElementById("validade").disabled = true;
        document.getElementById("submit").disabled = true;
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

