

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
}

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
