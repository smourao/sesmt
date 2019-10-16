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
//Cadastro de Clinicas
function showData(){
var url = "findit.php?id="+document.getElementById("cep_clinica").value;
url = url + "&cache=" + new Date().getTime();
http.open("GET", url, true);
http.onreadystatechange = reply;
http.send(null);
}

function reply(){
if(http.readyState == 4)
{

    var msg = http.responseText;
	var data = msg.split("|");
		//alert(data[1]);
    document.getElementById("endereco_clinica").value = data[1].toString();
	document.getElementById("bairro_clinica").value = data[2].toString();
	document.getElementById("cidade").value = data[3].toString();
	document.getElementById("estado").value = data[4].toString();
}else{
 if (http.readyState==1){
        document.getElementById("endereco_clinica").value = 'atualizando...';
		document.getElementById("bairro_clinica").value = 'atualizando...';
		document.getElementById("cidade").value = 'atualizando...';
		document.getElementById("estado").value = 'atualizando...';
    }
 }

}
//Simulador
function showDataSimulador(){
var url = "findit.php?id="+document.getElementById("cep").value;
http.open("GET", url, true);
http.onreadystatechange = replySimulador;
http.send(null);
}

function replySimulador(){
if(http.readyState == 4)
{
    var msg = http.responseText;
	var data = msg.split("|");
	//alert(data[1]);
    document.getElementById("endereco").value = data[1];
	document.getElementById("bairro").value = data[2].toString();
	document.getElementById("municipio").value = data[3].toString();
	document.getElementById("estado").value = data[4].toString();
}else{
 if (http.readyState==1){
        document.getElementById("endereco").value = 'atualizando...';
		document.getElementById("bairro").value = 'atualizando...';
		document.getElementById("municipio").value = 'atualizando...';
		document.getElementById("estado").value = 'atualizando...';
    }
 }

}
//Cadastro de Fornecedores
function showDataFornecedor(){
var url = "findit.php?id="+document.getElementById("cep").value;
http.open("GET", url, true);
http.onreadystatechange = replyFornecedor;
http.send(null);
}

function replyFornecedor(){
if(http.readyState == 4)
{
    var msg = http.responseText;
	var data = msg.split("|");
	//alert(data[1]);
    document.getElementById("endereco").value = data[1];
	document.getElementById("bairro").value = data[2].toString();
	document.getElementById("cidade").value = data[3].toString();
	document.getElementById("estado").value = data[4].toString();
}else{
 if (http.readyState==1){
        document.getElementById("endereco").value = 'atualizando...';
		document.getElementById("bairro").value = 'atualizando...';
		document.getElementById("cidade").value = 'atualizando...';
		document.getElementById("estado").value = 'atualizando...';
    }
 }

}
//Cadastro de Clientes
function showDataCliente(){
var url = "findit.php?id="+document.getElementById("cep").value;
http.open("GET", url, true);
http.onreadystatechange = replyCliente;
http.send(null);
}

function replyCliente(){
if(http.readyState == 4)
{
    var msg = http.responseText;
	var data = msg.split("|");
	//alert(data[1]);
    document.getElementById("endereco").value = data[1];
	document.getElementById("bairro").value = data[2].toString();
	document.getElementById("municipio").value = data[3].toString();
	document.getElementById("estado").value = data[4].toString();
}else{
 if (http.readyState==1){
        document.getElementById("endereco").value = 'atualizando...';
		document.getElementById("bairro").value = 'atualizando...';
		document.getElementById("municipio").value = 'atualizando...';
		document.getElementById("estado").value = 'atualizando...';
    }
 }

}

//Cadastro de Funcionários
function showDataFunc(){
	//alert('');
var url = "findit.php?id="+document.getElementById("cep").value;
http.open("GET", url, true);
http.onreadystatechange = replyFunc;
http.send(null);
}

function replyFunc(){
if(http.readyState == 4)
{
    var msg = http.responseText;
	var data = msg.split("|");
	//alert(data[1]);
    document.getElementById("endereco_func").value = data[1];
	document.getElementById("bairro_func").value = data[2].toString();
	document.getElementById("cidade").value = data[3].toString();
	document.getElementById("estado").value = data[4].toString();
}else{
 if (http.readyState==1){
        document.getElementById("endereco_func").value = 'atualizando...';
		document.getElementById("bairro_func").value = 'atualizando...';
		document.getElementById("cidade").value = 'atualizando...';
		document.getElementById("estado").value = 'atualizando...';
    }
 }

}

function MM_formtCep(e,src,mask) {
    if(window.event) { _TXT = e.keyCode; }
    else if(e.which) { _TXT = e.which; }
    if(_TXT > 47 && _TXT < 58) {
 var i = src.value.length; var saida = mask.substring(0,1); var texto = mask.substring(i)
 if (texto.substring(0,1) != saida) { src.value += texto.substring(0,1); }
    return true; } else { if (_TXT != 8) { return false; }
 else { return true; }
    }
}


//***************************************************************************************
//     CHECAGEM DE CNAE
//***************************************************************************************
function check_cnae(obj){
   if(obj.value != ""){
      var url = "check_cnae.php?cnae="+obj.value;
      url = url + "&cache=" + new Date().getTime();
      http.open("GET", url, true);
      http.onreadystatechange = check_cnae_reply;
      http.send(null);
   }
}

function check_cnae_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
    if(msg != 0){
	   var data = msg.split("|");
       document.getElementById("grupo_cipa").value = data[0];
       document.getElementById("grau_de_risco").value = data[1];
       document.getElementById("desc_atividade").value = data[2];
       if(document.getElementById("numero_funcionarios").value != ""){
          window.parent.check_brigada(document.getElementById("numero_funcionarios"));
       }
	}else{
         alert('CNAE inválido!');
         document.getElementById("grupo_cipa").value = '';
         document.getElementById("grau_de_risco").value = '';
         document.getElementById("desc_atividade").value = '';
	}
}else{
 if (http.readyState==1){
         document.getElementById("grupo_cipa").value = '...';
         document.getElementById("grau_de_risco").value = '...';
         document.getElementById("desc_atividade").value = 'Atualizando, aguarde...';
    }
 }
}


//***************************************************************************************
//     CHECAGEM DE BRIGADA / CIPA
//***************************************************************************************
function check_brigada(obj){
   var box = document.getElementById("classe");
   //Só executar se funcionarios e cnae foram digitados
   //classe sempre esta marcado (mesmo que errado, ao alterar será re-executado)
   if(document.getElementById("numero_funcionarios").value != "" && document.getElementById("cnae_digitado").value != ""){
      var url = "check_brigada.php?classe=" + box.options[box.selectedIndex].value;
      url = url + "&nf=" + document.getElementById("numero_funcionarios").value;
      url = url + "&cnae=" + document.getElementById("cnae_digitado").value;
      url = url + "&cache=" + new Date().getTime();
      http.open("GET", url, true);
      http.onreadystatechange = check_brigada_reply;
      http.send(null);
   }
}

function check_brigada_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
    if(msg != 0){
//    alert(msg);
	   var data = msg.split("|");
       document.getElementById("membros_brigada").value = data[0];
       document.getElementById("num_rep").value = data[1]+"|"+data[2];
	}else{
       alert('Erro ao obter dados.'+msg);
       document.getElementById("membros_brigada").value = '';
       document.getElementById("num_rep").value = '';
	}
}else{
 if (http.readyState==1){
            document.getElementById("membros_brigada").value = 'Atualizando, aguarde...';
            document.getElementById("Atualizando, aguarde...").value = '...';
    }
 }
}


//***************************************************************************************
//     CHECAGEM DE CNPJ
//***************************************************************************************
function check_cnpj(obj){
//alert(obj.value);
   if(obj.value != ""){
      var url = "check_cnpj.php?cnpj=" + obj.value;
      url = url + "&cache=" + new Date().getTime();
      http.open("GET", url, true);
      http.onreadystatechange = check_cnpj_reply;
      http.send(null);
   }
}

function check_cnpj_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
    if(msg != 0){
       alert(msg);
	}else{
       //
	}
}else{
 if (http.readyState==1){
 
    }
 }
}

function check_cnpj_cliente(obj){
//alert(obj.value);
   if(obj.value != ""){
      var url = "check_cnpj_cliente.php?cnpj=" + obj.value;
      url = url + "&cache=" + new Date().getTime();
      http.open("GET", url, true);
      http.onreadystatechange = check_cnpj_cliente_reply;
      http.send(null);
   }
}

function check_cnpj_cliente_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
    if(msg != 0){
       alert(msg);
	}else{
       //
	}
}else{
 if (http.readyState==1){

    }
 }

}

//************INSERIR DATA NO CLIENTE SETOR*******************
function codventart(obj, data, hig, cod_cliente, cod_setor){
	//alert('3');
	if(obj != ""){
		var url = "check_ventilacao.php?dt_ventilacao=" + data;
		url = url + "&higiene="+hig;
		url = url + "&id="+obj;
		url = url + "&cliente="+cod_cliente;
		url = url + "&setor="+cod_setor;
		http.open("GET", url, true);
        http.onreadystatechange = vent_reply;
        http.send(null);
   }
}

function vent_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
	//alert(msg);
    if(msg != 0){
       //alert(msg);
	}else{
       //
	}
}else{
 if (http.readyState==1){
 
    }
 }

}



/***********************************************************************************************/
function show_in_website(id){
      var url = "ajax_show_in_website.php?id=" + id;
      url = url + "&cache=" + new Date().getTime();
      http.open("GET", url, true);
      http.onreadystatechange = show_in_website_reply;
      http.send(null);
}

function show_in_website_reply(){
    if(http.readyState == 4){
        var msg = http.responseText;
        var data = msg.split("|");
        var chk = document.getElementById("showsite"+data[2]);
        var dv = document.getElementById("dcont"+data[2]);

        if(data[1]==0){
            chk.checked = false;
        }else{
            chk.checked = true;
        }

        if(data[0] == 0){//falha
            dv.style.backgroundColor  = '#C33333';
            setTimeout("nordivcolor('"+data[2]+"');", 5000);
    	}else{
            dv.style.backgroundColor  = '#2B8A30';
            setTimeout("nordivcolor('"+data[2]+"');", 5000);
    	}
    }else{
        if (http.readyState==1){
            //
        }
    }
}

function nordivcolor(id){
    var dv = document.getElementById("dcont"+id);
    dv.style.backgroundColor = '#006633';
}
