var http = oAjax();
var sweb = oAjax();
var acnae = oAjax();
var acep = oAjax();
var chst = oAjax();
var ibar = oAjax();
var cgrt = oAjax();
var afuncionario = oAjax();  //nome dos funcionários -> check_func
var sinagm = oAjax();//GET MATERIAL
var sinage = oAjax();//GET ESPESSURA
var sinagr = oAjax();//GET RESULT
var sinaap = oAjax();//ADD PPRA PLACAS
var sinaup = oAjax();//UPDATE PPRA PLACAS
var ccon = oAjax();//condição de pagamento
var ccha = oAjax();//prazo de entrega


//CGRT -> SINALIZAÇÃO
var singm = oAjax();//GET MATERIAL
var singe = oAjax();//GET ESPESSURA
//var singa = oAjax();//GET ACABAMENTO
//var singt = oAjax();//GET TAMANHO
//var singl = oAjax();//GET LEGENDA
var singr = oAjax();//GET RESULT
var sinap = oAjax();//ADD PPRA PLACAS
var sinup = oAjax();//UPDATE PPRA PLACAS
var amos = oAjax();//AGENTES NOCIVOS
var tragem = oAjax();//AGENTES NOCIVOS

function oAjax(){
  var temp = null;
  //ajax = null;
    if (window.XMLHttpRequest) {
        temp = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        try {
            temp = new ActiveXObject("Msxml2.XMLHTTP.4.0");
        } catch(e) {
            try {
                temp = new ActiveXObject("Msxml2.XMLHTTP.3.0");
            } catch(e) {
                try {
                    temp = new ActiveXObject("Msxml2.XMLHTTP");
                } catch(e) {
                    try {
                        temp = new ActiveXObject("Microsoft.XMLHTTP");
                    } catch(e) {
                        temp = false;
                    }
                }
            }
        }
  }
 return temp;
}

function check_cep(cep){
    if(cep.value != "" && cep.value.length == 9){
        var url = "common/ajax_check_cep.php?id="+cep.value;
        acep.open("GET", url, true);
        acep.onreadystatechange = check_cep_reply;
        acep.send(null);
    }
}

function check_cep_reply(){
    var dv = document.getElementById("verify_cep");
    if(acep.readyState == 4){
        var msg = acep.responseText;
        if(msg != 0){
    	    var data = msg.split("|");
            document.getElementById("endereco").value = data[1];
        	document.getElementById("bairro").value = data[2].toString();
        	document.getElementById("municipio").value = data[3].toString();
            document.getElementById("estado").value = data[4].toString();
            document.getElementById("endereco").disabled = false;
    		document.getElementById("bairro").disabled = false;
    		document.getElementById("municipio").disabled = false;
    		document.getElementById("estado").disabled = false;
            dv.setAttribute("class", "text");
            dv.innerHTML = "";
        }else{
            dv.setAttribute("class", "text roundborderselectedred");
            dv.setAttribute("className", "text roundborderselectedred");
            dv.innerHTML = "CEP não encontrado";
            document.getElementById("endereco").value = '';
        	document.getElementById("bairro").value = '';
        	document.getElementById("municipio").value = '';
            document.getElementById("estado").value = '';
            document.getElementById("endereco").disabled = false;
    		document.getElementById("bairro").disabled = false;
    		document.getElementById("municipio").disabled = false;
    		document.getElementById("estado").disabled = false;
        }
    }else{
        if(acep.readyState==1){
            document.getElementById("endereco").disabled = true;
    		document.getElementById("bairro").disabled = true;
    		document.getElementById("municipio").disabled = true;
    		document.getElementById("estado").disabled = true;
    		dv.setAttribute("class", "text roundborderselected");
    		dv.setAttribute("className", "text roundborderselected");
            dv.innerHTML = "Verificando...";
        }
    }
}

/***********************************************************************************************/
function show_in_website(id){
      var url = "common/ajax_show_in_website.php?id=" + id;
      url = url + "&cache=" + new Date().getTime();
      sweb.open("GET", url, true);
      sweb.onreadystatechange = show_in_website_reply;
      sweb.send(null);
}

function show_in_website_reply(){
    if(sweb.readyState == 4){
        var msg = sweb.responseText;
        var data = msg.split("|");
        var chk = document.getElementById("showsite"+data[2]);
        var dv = document.getElementById("dcont"+data[2]);

        if(data[1]==0){
            chk.checked = false;
        }else{
            chk.checked = true;
        }

        if(data[0] == 0){//falha
            //dv.style.className = 'roundborderselected';
            dv.setAttribute("class", "text roundborderselectedred");
            dv.setAttribute("className", "text roundborderselectedred");
            setTimeout("nordivcolor('"+data[2]+"');", 5000);
    	}else{
            //dv.style.className = 'text roundborderselected';
            dv.setAttribute("class", "text roundborderselected");
            dv.setAttribute("className", "text roundborderselected");
            setTimeout("nordivcolor('"+data[2]+"');", 5000);
    	}
    }else{
        if (sweb.readyState==1){
            //
            //if (window.parseStylesheets) window.parseStylesheets();
        }
    }
}

function nordivcolor(id){
    var dv = document.getElementById("dcont"+id);
    dv.setAttribute("class", "text roundbordermix");//style.className = 'roundbordermix';
    dv.setAttribute("className", "text roundbordermix");
    //dv.style.className = 'text roundbordermix';
}

/***********************************************************************************************/
// --> FUNCTION - [ CHECK IF CNPJ IS ALREADY REGISTERED IN THE DATABASE ]
/***********************************************************************************************/
function check_cnpj_cliente(obj){
   if(obj.value != ""){
      if(obj.value.length>=18){
          var url = "common/ajax_check_cnpj_cliente.php?cnpj=" + obj.value;
          url = url + "&cache=" + new Date().getTime();
          http.open("GET", url, true);
          http.onreadystatechange = check_cnpj_cliente_reply;
          http.send(null);
      }else{
          var dv = document.getElementById("verify_cnpj");
          dv.setAttribute("class", "text");
          dv.setAttribute("className", "text");
          dv.innerHTML = "";
      }
   }
}
function check_cnpj_cliente_reply(){
    var dv = document.getElementById("verify_cnpj");
    if(http.readyState == 4){
        var msg = http.responseText;
        if(msg != 0){
           dv.setAttribute("class", "text roundborderselectedred");
           dv.setAttribute("className", "text roundborderselectedred");
           dv.innerHTML = "Duplicado";
           //showAlert(msg.replace(/\n/g, "<br />"));
           showAlert(msg);
    	}else{
           dv.setAttribute("class", "text roundborderselected");
           dv.setAttribute("className", "text roundborderselected");
           dv.innerHTML = "Válido";
    	}
    }else{
        if (http.readyState==1){
           dv.setAttribute("class", "text roundborderselected");
           dv.setAttribute("className", "text roundborderselected");
           dv.innerHTML = "Verificando...";
        }
    }
}
/***********************************************************************************************/


//***************************************************************************************
// --> FUNCTION - [ CHECK AND RETURN CNAE INFO ]
//***************************************************************************************
function check_cnae(obj){
   if(obj.value != ""){
      var url = "common/ajax_check_cnae.php?cnae="+obj.value;
      url = url + "&cache=" + new Date().getTime();
      acnae.open("GET", url, true);
      acnae.onreadystatechange = check_cnae_reply;
      acnae.send(null);
   }
}
function check_cnae_reply(){
    var dv = document.getElementById("verify_cnae");
    if(acnae.readyState == 4){
        var msg = acnae.responseText;
        if(msg != 0){
    	    var data = msg.split("|");
            document.getElementById("grupo_cipa").value = data[0];
            document.getElementById("grau_risco").value = data[1];
            document.getElementById("descricao_atividade").value = data[2];
            document.getElementById("grupo_cipa").disabled = false;
            document.getElementById("grau_risco").disabled = false;
            document.getElementById("descricao_atividade").disabled = false;
            dv.setAttribute("class", "text");
            dv.setAttribute("className", "text");
            dv.innerHTML = "";
            if(document.getElementById("numero_funcionarios").value != ""){
                window.parent.check_brigada(document.getElementById("numero_funcionarios"));
            }
    	}else{
             document.getElementById("grupo_cipa").value = '';
             document.getElementById("grau_risco").value = '';
             document.getElementById("descricao_atividade").value = '';
             document.getElementById("grupo_cipa").disabled = false;
             document.getElementById("grau_risco").disabled = false;
             document.getElementById("descricao_atividade").disabled = false;
             dv.setAttribute("class", "text roundborderselectedred");
             dv.setAttribute("className", "text roundborderselectedred");
             dv.innerHTML = "CNAE inválido";
    	}
    }else{
        if(acnae.readyState==1){
            document.getElementById("grupo_cipa").disabled = true;
            document.getElementById("grau_risco").disabled = true;
            document.getElementById("descricao_atividade").disabled = true;
            dv.setAttribute("class", "text roundborderselected");
            dv.setAttribute("className", "text roundborderselected");
            dv.innerHTML = "Verificando...";
        }
    }
}
//***************************************************************************************

//***************************************************************************************
// --> FUNCTION - [ CHECK AND RETURN BRIGADA/CNAE INFO ]
//***************************************************************************************
function check_brigada(obj){
   var box = document.getElementById("classe");
   //Só executar se funcionarios e cnae foram digitados
   //classe sempre esta marcado (mesmo que errado, ao alterar será re-executado)
   if(document.getElementById("numero_funcionarios").value != "" && document.getElementById("cnae").value != ""){
       var url = "common/ajax_check_brigada.php?classe=" + box.options[box.selectedIndex].value;
       url = url + "&nf=" + document.getElementById("numero_funcionarios").value;
       url = url + "&cnae=" + document.getElementById("cnae").value;
       url = url + "&cache=" + new Date().getTime();
       sweb.open("GET", url, true);
       sweb.onreadystatechange = check_brigada_reply;
       sweb.send(null);
   }
}
function check_brigada_reply(){
    var dv = document.getElementById("verify_brigada");
    if(sweb.readyState == 4){
        var msg = sweb.responseText;
        if(msg != 0){
    	    var data = msg.split("|");
            document.getElementById("membros_brigada").value = data[0];
            document.getElementById("membros_cipa").value = data[1]+"|"+data[2];
            document.getElementById("membros_brigada").disabled = false;
            document.getElementById("membros_cipa").disabled = false;
            dv.setAttribute("class", "text");
            dv.setAttribute("className", "text");
            dv.innerHTML = "";
    	}else{
            document.getElementById("membros_brigada").value = '';
            document.getElementById("membros_cipa").value = '';
            document.getElementById("membros_brigada").disabled = false;
            document.getElementById("membros_cipa").disabled = false;
            dv.setAttribute("class", "text roundborderselectedred");
            dv.setAttribute("className", "text roundborderselectedred");
            dv.innerHTML = "Dados/CNAE inválidos.";
    	}
    }else{
        if(sweb.readyState==1){
            document.getElementById("membros_brigada").disabled = true;
            document.getElementById("membros_cipa").disabled = true;
            dv.setAttribute("class", "text roundborderselected");
            dv.setAttribute("className", "text roundborderselected");
            dv.innerHTML = "Verificando...";
        }
    }
}
/***********************************************************************************************/


/***********************************************************************************************/
// --> FUNCTION - [ CAD_CLIENTE - CHANGE STATUS ATIVO/INATIVO ]
/***********************************************************************************************/
function cad_cliente_change_status(cod_cliente){
    var value = document.getElementById("chstatus").options[document.getElementById("chstatus").selectedIndex].value;
    if(cod_cliente != "" && value != ""){
        var url = "common/cad_cliente_change_status.php?cod_cliente=" + cod_cliente;
        url = url + "&value=" + value;
        url = url + "&cache=" + new Date().getTime();
        chst.open("GET", url, true);
        chst.onreadystatechange = cad_cliente_change_status_reply;
        chst.send(null);
    }else{

    }
}
function cad_cliente_change_status_reply(){
    var box = document.getElementById("chstatus");
    if(chst.readyState == 4){
        var msg = chst.responseText;
        if(msg == 2){
           showAlert('Status alterado com sucesso!');
           document.getElementById("chstatus").disabled = false;
    	}else{
           showAlert('Não foi possível alterar o status deste cliente. Por favor, tente novamente!<BR>Caso o problema persista, entre em contato com o setor de suporte!');
           document.getElementById("chstatus").disabled = false;
           box.selectedIndex = msg;
    	}
    }else{
        if (chst.readyState==1){
            document.getElementById("chstatus").disabled = true;
        }
    }
}
/***********************************************************************************************/

/***********************************************************************************************/
// --> FUNCTION - [ INFO BAR CHECK MSG's ]
/***********************************************************************************************/
function check_infobar(user_id, div){
   if(user_id != ""){
      var url = "common/ajax_check_infobar.php?user_id="+user_id;
      url += "&div=" + div.id;
      url = url + "&cache=" + new Date().getTime();
      ibar.open("GET", url, true);
      ibar.onreadystatechange = check_infobar_reply;
      ibar.send(null);
   }
}

function check_infobar_reply(){
    if(ibar.readyState == 4){
        var msg = ibar.responseText;
        var data = msg.split("|");
        var div = document.getElementById("infobar");
        if(data[1] != 0){
            var rnd = 0;//Math.floor(Math.random()*(data.length-1));
            myTable = "";
            myTable += "<table border=0 width=100%>";
            myTable += "<tr>";
            myTable += "<td class=text><marquee>";
            myTable += data[rnd+1];
            myTable += "</marquee></td>";
            myTable += "<td width=1 align=center class='text roundborderselected'><span id='countdown'></span></td>";
            myTable += "</tr>";
            myTable += "</table>";
            div.innerHTML = myTable;
            div.style.display = "block";

            CountDown(60);
            setTimeout(function(){
                div.style.display = "none";
            }, 60000);
            setTimeout("check_infobar("+data[0]+", document.getElementById('infobar'))", 65000);
    	}else{
             div.style.display = "none";
             //if not, wait 2minutes to do again.
             setTimeout("check_infobar("+data[0]+", document.getElementById('infobar'))", 180000);
    	}
    }else{
        if(ibar.readyState==1){

        }
    }
}
/***********************************************************************************************/

/***********************************************************************************************/
// --> FUNCTION - [ MODULES/CGRT ]
/***********************************************************************************************/
function save_cgrt_vent_art(cod_cgrt, cod_setor){
      var url = "common/ajax_save_cgrt_vent_art.php?";
      
      if(document.getElementById('n_aparelhos').value == ''){
          document.getElementById('notif_n_aparelhos').style.display = "inline";
          return false;
      }
      if(document.getElementById('marca_aparelho').value == ''){
          document.getElementById('notif_marca_aparelho').style.display = "inline";
          return false;
      }
      if(document.getElementById('modelo_aparelho').value == ''){
          document.getElementById('notif_modelo_aparelho').style.display = "inline";
          return false;
      }
      if(document.getElementById('capacidade_aparelho').value == ''){
          document.getElementById('notif_capacidade_aparelho').style.display = "inline";
          return false;
      }
      if(document.getElementById('ult_limpeza_filtros').value.length <10){
          document.getElementById('notif_ult_limpeza_filtros').style.display = "inline";
          return false;
      }
      if(document.getElementById('ult_limpeza_dutos').value.length <10){
          document.getElementById('notif_ult_limpeza_dutos').style.display = "inline";
          return false;
      }
      if(document.getElementById('prox_limpeza_filtros').value.length <10){
          document.getElementById('notif_prox_limpeza_filtros').style.display = "inline";
          return false;
      }
      if(document.getElementById('prox_limpeza_dutos').value.length <10){
          document.getElementById('notif_prox_limpeza_dutos').style.display = "inline";
          return false;
      }
      url += "cod_cgrt=" + cod_cgrt;
      url += "&cod_setor=" + cod_setor;
      url += "&n_aparelhos=" + document.getElementById('n_aparelhos').value;
      url += "&marca_aparelho=" + document.getElementById('marca_aparelho').value;
      url += "&modelo_aparelho=" + document.getElementById('modelo_aparelho').value;
      url += "&capacidade_aparelho=" + document.getElementById('capacidade_aparelho').value;
      url += "&ult_limpeza_filtros=" + document.getElementById('ult_limpeza_filtros').value;
      url += "&ult_limpeza_dutos=" + document.getElementById('ult_limpeza_dutos').value;
      url += "&prox_limpeza_filtros=" + document.getElementById('prox_limpeza_filtros').value;
      url += "&prox_limpeza_dutos=" + document.getElementById('prox_limpeza_dutos').value;
      url += "&empresa_prestadora_servico=" + document.getElementById('empresa_prestadora_servico').value;

      
      url = url + "&cache=" + new Date().getTime();
      cgrt.open("GET", url, true);
      cgrt.onreadystatechange = save_cgrt_vent_reply;
      cgrt.send(null);
}

function save_cgrt_vent_port(cod_cgrt, cod_setor){
      var url = "common/ajax_save_cgrt_vent_port.php?";

      if(document.getElementById('ult_higienizacao_mec').value.length <10){
          document.getElementById('notif_ult_higienizacao_mec').style.display = "inline";
          return false;
      }
      if(document.getElementById('ult_limpeza_filtros_portatil').value.length <10){
          document.getElementById('notif_ult_limpeza_filtros_portatil').style.display = "inline";
          return false;
      }
      url += "cod_cgrt=" + cod_cgrt;
      url += "&cod_setor=" + cod_setor;
      url += "&ult_higienizacao_mec=" + document.getElementById('ult_higienizacao_mec').value;
      url += "&ult_limpeza_filtros_portatil=" + document.getElementById('ult_limpeza_filtros_portatil').value;
      url += "&area_circulacao=" + document.getElementById('area_circulacao').value;

      url = url + "&cache=" + new Date().getTime();
      cgrt.open("GET", url, true);
      cgrt.onreadystatechange = save_cgrt_vent_reply;
      cgrt.send(null);
}

function save_cgrt_vent_reply(){
    if(cgrt.readyState == 4){
        var msg = cgrt.responseText;
        var data = msg.split("|");
        if(msg > 0){
            hide_cgrt_edif_vent_art();
            showAlert('Informações sobre qualidade do ar armazenadas com sucesso!');
    	}else{
    	    hide_cgrt_edif_vent_art();
            showAlert('Não foi possível armazenar os dados sobre <b>Informações adicionais sobre a qualidade do ar</b>!<BR>Verifique atentamente os campos preenchidos, em caso de dúvidas, entre em contato com o setor de suporte.');
    	}
    }else{
        if(cgrt.readyState==1){
            //waiting...
        }
    }
}
/***********************************************************************************************/

/***********************************************************************************************/
// --> FUNCTION - [ MODULES/INADIMPLENTES ]
/***********************************************************************************************/
function dateDiff($sDataInicial, $sDataFinal)
{
 $sDataI = explode("-", $sDataInicial);
 $sDataF = explode("-", $sDataFinal);

 $nDataInicial = mktime(0, 0, 0, $sDataI[1], $sDataI[0], $sDataI[2]);
 $nDataFinal = mktime(0, 0, 0, $sDataF[1], $sDataF[0], $sDataF[2]);

 return ($nDataInicial > $nDataFinal) ?
    floor(($nDataFinal - $nDataInicial)/86400) : floor(($nDataFinal - $nDataInicial)/86400);
}
/***********************************************************************************************/

/***********************************************************************************************/
// --> FUNCTION - [ MODULES/INADIMPLENTES ]
/***********************************************************************************************/
function SimJuros(){
   var url = "common/sim_juros.php?valor="+document.getElementById('valb').value;
   url = url + "&data="+document.getElementById('dtv').value;
   url = url + "&data_o="+document.getElementById('tmpd').value;
   url = url + "&valor_o="+document.getElementById('tmpv').value;
   url = url + "&cache=" + new Date().getTime();
   http.open("GET", url, true);
   http.onreadystatechange = SimJuros_reply;
   http.send(null);
}

function SimJuros_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
	var data = msg.split("|");
    if(data[0] <0){
       document.getElementById('cmr').innerHTML = "<center>Data de vencimento inválida!</center>";
    }else{
       document.getElementById('cmr').innerHTML = "<b>&nbsp;Dias após o vencimento:</b> "+data[0]+"<p>&nbsp;<b>Valor Ajustado:</b> R$ "+data[1];
    }
}else{
 if (http.readyState==1){
        document.getElementById('cmr').innerHTML = "<center>Atualizando...</center>";
    }
 }
}



/***********************************************************************************************/
// --> FUNCTION - [ MODULES/CGRT ] - SINALIZAÇÃO - STEP6
/***********************************************************************************************/
function cgrt_sin_get_material(val){
   //alert(val);
   var url = "common/ajax_cgrt_sim_get_material.php?";
   url = url + "cat=" + val;
   url = url + "&cache=" + new Date().getTime();
   singm.open("GET", url, true);
   singm.onreadystatechange = cgrt_sin_get_material_reply;
   singm.send(null);
}
function cgrt_sin_get_material_reply(){
    if(singm.readyState == 4){
        var msg = singm.responseText;
        var buffer = msg.split("£");
        
    	var data = buffer[0].split("|");

        var mat = document.getElementById('material');
        mat.disabled = false;
    	var esp = document.getElementById('espessura');
    	esp.length = 0;
    	esp.disabled = true;
    	var aca = document.getElementById('acabamento');
        aca.length = 0;
    	aca.disabled = true;
    	var tam = document.getElementById('tamanho');
    	tam.disabled = false;
    	var leg = document.getElementById('legenda');
    	leg.disabled = false;
    	
    	mat.length = data.length;
    	mat.selectedIndex = 0;
    	for(x=1;x<data.length;x++){
            mat.options[x].value = data[x-1];
            mat.options[x].text  = data[x-1];
    	}
    	
    	var dtz = buffer[1].split("|");
    	tam.length = dtz.length;
    	for(y=1;y<dtz.length;y++){
            tam.options[y].value = dtz[y-1];
            tam.options[y].text  = dtz[y-1];
    	}
    	
    	var ddt = buffer[2].split("|");
    	leg.length = ddt.length;
    	for(z=1;z<ddt.length;z++){
            leg.options[z].value = ddt[z-1];
            leg.options[z].text  = ddt[z-1];
            /*
            var tmpleg = ddt[z-1].split("§");
            leg.options[z].value = tmpleg[1];//ddt[z-1];
            leg.options[z].text  = tmpleg[0];//ddt[z-1];
            */
    	}
    	
    	//IMAGEM - TEST
    	var img = buffer[3].split("|");
        var sim = "";
    	for(i=0;i<img.length-1;i++){
            sim += "<img src='http://shoppingsesmt.com/images/upload/"+img[i]+"' border=0 width=50 height=50>";
    	}
    	
    	//document.getElementById('imgex').innerHTML = sim;
    	
    	document.getElementById('loadmat').style.display = 'none';
    	document.getElementById('loadtam').style.display = 'none';
        document.getElementById('loadleg').style.display = 'none';
    }else{
        if(singm.readyState==1){
            document.getElementById('loadmat').style.display = 'inline';
            document.getElementById('loadtam').style.display = 'inline';
            document.getElementById('loadleg').style.display = 'none';
        }
    }
}
/***********************************************************************************************/
function cgrt_sin_get_espessura(val){
   var url = "common/ajax_cgrt_sim_get_espessura.php?";
   url = url + "mat=" + val;
   url = url + "&cache=" + new Date().getTime();
   singe.open("GET", url, true);
   singe.onreadystatechange = cgrt_sin_get_espessura_reply;
   singe.send(null);
}
function cgrt_sin_get_espessura_reply(){
    if(singe.readyState == 4){
        var msg = singe.responseText;
        var buf = msg.split("£");
    	var data = buf[0].split("|");

    	var esp = document.getElementById('espessura');
    	esp.disabled = false;
    	var aca = document.getElementById('acabamento');
    	aca.disabled = false;
    	var leg = document.getElementById('legenda');
    	esp.length = data.length;
    	for(x=1;x<data.length;x++){
            esp.options[x].value = data[x-1];
            esp.options[x].text  = data[x-1];
    	}
    	
    	var data = buf[1].split("|");
    	aca.length = data.length;
    	for(x=1;x<data.length;x++){
            aca.options[x].value = data[x-1];
            aca.options[x].text  = data[x-1];
    	}
    	document.getElementById('loadesp').style.display = 'none';
        document.getElementById('loadaca').style.display = 'none';
    }else{
        if(singe.readyState==1){
            document.getElementById('loadesp').style.display = 'inline';
            document.getElementById('loadaca').style.display = 'inline';
        }
    }
}
/***********************************************************************************************/
/*
function cgrt_sin_get_acabamento(val){
   var url = "common/ajax_cgrt_sim_get_acabamento.php?";
   url = url + "acabamento=" + val;
   url = url + "&cache=" + new Date().getTime();
   singa.open("GET", url, true);
   singa.onreadystatechange = cgrt_sin_get_acabamento_reply;
   singa.send(null);
}
function cgrt_sin_get_acabamento_reply(){
    if(singa.readyState == 4){
        var msg = singa.responseText;
    	var data = msg.split("|");

    	var aca = document.getElementById('acabamento');
    	aca.disabled = false;
    	var tam = document.getElementById('tamanho');
    	tam.length = 0;
    	tam.disabled = true;
    	var leg = document.getElementById('legenda');
    	leg.length = 0;
    	leg.disabled = true;

    	aca.length = data.length;
    	for(x=1;x<data.length;x++){
            aca.options[x].value = data[x-1];
            aca.options[x].text  = data[x-1];
    	}
    }else{
        if(singa.readyState==1){
            //document.getElementById('cmr').innerHTML = "<center>Atualizando...</center>";
        }
    }
}
*/
/***********************************************************************************************/
/*
function cgrt_sin_get_tamanho(val){
   var url = "common/ajax_cgrt_sim_get_tamanho.php?";
   url = url + "tam=" + val;
   url = url + "&cache=" + new Date().getTime();
   singt.open("GET", url, true);
   singt.onreadystatechange = cgrt_sin_get_tamanho_reply;
   singt.send(null);
}
function cgrt_sin_get_tamanho_reply(){
    if(singt.readyState == 4){
        var msg = singt.responseText;
    	var data = msg.split("|");

    	var tam = document.getElementById('tamanho');
    	tam.disabled = false;
    	var leg = document.getElementById('legenda');
    	leg.length = 0;
    	leg.disabled = true;

    	tam.length = data.length;
    	for(x=1;x<data.length;x++){
            tam.options[x].value = data[x-1];
            tam.options[x].text  = data[x-1];
    	}
    }else{
        if(singt.readyState==1){
            //document.getElementById('cmr').innerHTML = "<center>Atualizando...</center>";
        }
    }
}
*/

/***********************************************************************************************/

function cgrt_sin_get_result(){
   if(document.getElementById('categoria').value != ""){
       var url = "common/ajax_cgrt_sin_result.php?";
       url = url + "cat=" + document.getElementById('categoria').value;
       url = url + "&mat=" + document.getElementById('material').value;
       url = url + "&esp=" + document.getElementById('espessura').value;
       url = url + "&aca=" + document.getElementById('acabamento').value;
       url = url + "&tam=" + document.getElementById('tamanho').value;
       url = url + "&leg=" + document.getElementById('legenda').value;
       url = url + "&cache=" + new Date().getTime();
       singr.open("GET", url, true);
       singr.onreadystatechange = cgrt_sin_get_result_reply;
       singr.send(null);
   }else{
       showAlert('Selecione uma categoria para realizar a pesquisa!');
   }
}
function cgrt_sin_get_result_reply(){
    var content = document.getElementById('sincontent');
    if(singr.readyState == 4){
        var msg = singr.responseText;
    	var data = msg.split("§");
    	var text = "";
    	if(data[0] > 0){//items found
    	    var buffer = data[1].split("£");
    	    text += "<table width=100% border=0>";
    	    text += "<tr>";
    	    text += "<td class='text' width=45 align=center><b>Cód</b></td>";
    	    text += "<td class='text'><i>"+data[0]+" Item(s) encontrado(s)</i></td>";
    	    text += "</tr>";
        	for(x=0;x<buffer.length-1;x++){
        	    var item = buffer[x].split("|");
        	    text += "<tr class='roundbordermix'>";
                text += "<td class='text roundborder curhand' width=45 align=center onclick=\"if(confirm('Tem certeza que deseja adicionar este item?','')){cgrt_sin_add_placas("+item[0]+",prompt('Informe a quantidade de items:','1'));}\">"+ item[0] +"</td>";
    	        text += "<td class='text roundborder curhelp' alt='"+item[2]+"' title='"+item[2]+"'>"+ item[4].substring(0, 33) +"...</td>";
    	        text += "</tr>";
        	}
        	text += "</table>";
        	content.innerHTML = text;
    	}else{//nothing found
    	    content.innerHTML = "<center>Nenhum resultado encontrado.</center>";
    	}
    }else{
        if(singr.readyState==1){
            content.innerHTML = "<table height=280 border=0 align=center><tr><td valign=center align=center style=\"height: 260px;\"><img src='images/load.gif' border=0></td></tr></table>";
        }
    }
}

/***********************************************************************************************/
function cgrt_sin_add_placas(cod_prod, qnt){
   if(cod_prod > 0 && qnt > 0){
       var url = "common/ajax_cgrt_sin_add_placas.php?";
       url = url + "cod_prod=" + cod_prod;
       url = url + "&qnt=" + qnt;
       url = url + "&cod_cliente=" + document.getElementById('cod_cliente').value;
       url = url + "&cod_setor=" + document.getElementById('cod_setor').value;
       url = url + "&cod_cgrt=" + document.getElementById('cod_cgrt').value;
       url = url + "&legenda=" + document.getElementById('legenda').value;
       url = url + "&cache=" + new Date().getTime();
       sinap.open("GET", url, true);
       sinap.onreadystatechange = cgrt_sin_add_placas_reply;
       sinap.send(null);
   }
}

function cgrt_sin_add_placas_reply(){
    //var content = document.getElementById('sincontent');
    if(sinap.readyState == 4){
        var msg = sinap.responseText;
    	var data = msg.split("|");
        if(data[2] > 0){
            //update list
            ajax_cgrt_sin_update_placas();
        }else{
            showAlert('Houve um erro ao adicionar este item no banco de dados. Por favor, entre em contato com o setor de suporte!');
        }
    }else{
        if(sinap.readyState==1){
            //content.innerHTML = "<table height=280 border=0 align=center><tr><td valign=center align=center style=\"height: 260px;\"><img src='images/load.gif' border=0></td></tr></table>";
        }
    }
}

/***********************************************************************************************/
function ajax_cgrt_sin_update_placas(){
   var url = "common/ajax_cgrt_sin_update_placas.php?";
   url = url + "cod_setor=" + document.getElementById('cod_setor').value;;
   url = url + "&cod_cgrt=" + document.getElementById('cod_cgrt').value;;
   url = url + "&cache=" + new Date().getTime();
   sinup.open("GET", url, true);
   sinup.onreadystatechange = ajax_cgrt_sin_update_placas_reply;
   sinup.send(null);
}

function ajax_cgrt_sin_update_placas_reply(){
    var content = document.getElementById('addeditems');
    if(sinup.readyState == 4){
        var msg = sinup.responseText;
    	var data = msg.split("£");
    	var table = "";
    	table += "<table width=100% border=0>";
    	table += "<tr>";
    	table += "<td width=45 class='text' align=center><b>Cód.</b></td>";
    	table += "<td class='text'><b>Items cadastrados</b></td>";
    	table += "<td width=30 class='text' align=center alt='Quantidade' title='Quantidade'><b>Qnt</b></td>";
    	table += "<td width=30 class='text' align=center><b></b></td>";
    	table += "</tr>";
        if(data.length > 1){
            for(var x=0;x<data.length-1;x++){
                var buffer = data[x].split("|");
                table += "<tr class='text roundbordermix'>";
                table += "<td class='roundborder text' align=center>" + buffer[1] + "</td>";
                table += "<td class='roundborder text curhelp' alt='Legenda: "+buffer[4]+"' title='Legenda: "+buffer[4]+"'>" + buffer[3] /*.substring(0, 40)*/ + "</td>";
                table += "<td class='roundborder text' align=center>" + buffer[2] + "</td>";
                table += "<td class='roundborderselectedred text curhand' align=center alt='Excluir' title='Excluir' onclick=\"if(confirm('Tem certeza que deseja excluir este item?','')){cgrt_sin_del_placas("+buffer[0]+");}\"><b>X</b></td>";
                table += "</tr>";
            }
            table += "</table>";
            content.innerHTML = table;
        }else{
            //nada cadastrado ainda
            content.innerHTML = "";
        }
    }else{
        if(sinup.readyState==1){
            content.innerHTML = "<table border=0 align=center><tr><td valign=center align=center><img src='images/load.gif' border=0></td></tr></table>";
        }
    }
}

/***********************************************************************************************/
function cgrt_sin_del_placas(id_prod){
   if(id_prod > 0){
       var url = "common/ajax_cgrt_sin_del_placas.php?";
       url = url + "id_prod=" + id_prod;
       url = url + "&cod_cgrt=" + document.getElementById('cod_cgrt').value;
       url = url + "&cache=" + new Date().getTime();
       sinap.open("GET", url, true);
       sinap.onreadystatechange = cgrt_sin_del_placas_reply;
       sinap.send(null);
   }
}

function cgrt_sin_del_placas_reply(){
    //var content = document.getElementById('sincontent');
    if(sinap.readyState == 4){
        var msg = sinap.responseText;
        if(msg > 0){
            //update list
            ajax_cgrt_sin_update_placas();
        }else{
            showAlert('Houve um erro ao remover este item no banco de dados. Por favor, entre em contato com o setor de suporte!');
        }
    }else{
        if(sinap.readyState==1){
            //content.innerHTML = "<table height=280 border=0 align=center><tr><td valign=center align=center style=\"height: 260px;\"><img src='images/load.gif' border=0></td></tr></table>";
        }
    }
}

/***********************************************************************************************/

/***********************************************************************************************/
function noci(valor){
   if(valor != ''){
       var url = "common/ajax_nocivo.php?";
       url = url + "valor=" + valor;
       url = url + "&cache=" + new Date().getTime();
       amos.open("GET", url, true);
       amos.onreadystatechange = noci_reply;
       amos.send(null);
   }
}

function noci_reply(){
    //var content = document.getElementById('sincontent');
    if(amos.readyState == 4){
        var msg = amos.responseText;	
		//alert(msg);
		var tr = msg.split('&');
		var combo = document.getElementById('coletor');
		combo.length = tr.length;
		for(var x=1;x<tr.length;x++){
			var fg = tr[x-1].split('|');
			combo.options[x].value = fg[0];
			combo.options[x].text = fg[1];
		}
		
    }else{
        if(amos.readyState==1){
            //content.innerHTML = "<table height=280 border=0 align=center><tr><td valign=center align=center style=\"height: 260px;\"><img src='images/load.gif' border=0></td></tr></table>";
        }
    }
}

/***********************************************************************************************/

/***********************************************************************************************/
function clt(valor){
   if(valor != ''){
       var url = "common/ajax_vazao.php?";
       url = url + "valor=" + valor;
       url = url + "&cache=" + new Date().getTime();
       tragem.open("GET", url, true);
       tragem.onreadystatechange = clt_reply;
       tragem.send(null);
   }
}

function clt_reply(){
    //var content = document.getElementById('sincontent');
    if(tragem.readyState == 4){
        var msg = tragem.responseText;	
		//alert(msg);
		var tr = msg.split('|');
		var combo = document.getElementById('vazao_m');
		combo.length = 3;		
		combo.options[1].value = tr[1];
		combo.options[1].text = tr[1];
		combo.options[2].value = tr[2];
		combo.options[2].text = tr[2];
		
		var combo = document.getElementById('volume');
		combo.length = 3;		
		combo.options[1].value = tr[3];
		combo.options[1].text = tr[3];
		combo.options[2].value = tr[4];
		combo.options[2].text = tr[4];
    }else{
        if(tragem.readyState==1){
            //content.innerHTML = "<table height=280 border=0 align=center><tr><td valign=center align=center style=\"height: 260px;\"><img src='images/load.gif' border=0></td></tr></table>";
        }
    }
}

/*****************************************************************************************************************/
// --> CHECK_FUNCIONÁRIO
/*****************************************************************************************************************/
function check_funcionario(nome_func){
    if(nome_func != ""){
        var url = "common/ajax_check_funcionario.php?funcionario="+nome_func;
        url = url + "&cache=" + new Date().getTime();
        afuncionario.open("GET", url, true);
        afuncionario.onreadystatechange = check_funcionario_reply;
        afuncionario.send(null);
    }
}

function check_funcionario_reply(){
   var dv = document.getElementById('load');
    if(afuncionario.readyState == 4){
        var msg = afuncionario.responseText;
        if(msg != 0){
			var ff = msg.split("|");
            document.getElementById("funcionario").className = "required";
        	document.getElementById("nome_funcao").value = ff[1];
			document.getElementById("ctps").value = ff[2];
			document.getElementById("serie").value = ff[3];
			document.getElementById("nome_funcao").disabled = false;
			document.getElementById("ctps").disabled = false;
			document.getElementById("serie").disabled = false;
            dv.innerHTML = "";
        }else{
            document.getElementById("funcionario").className = "required_wrong";
            document.getElementById("nome_funcao").value = '';
			document.getElementById("ctps").value = '';
			document.getElementById("serie").value = '';
			document.getElementById("nome_funcao").disabled = false;
			document.getElementById("ctps").disabled = false;
			document.getElementById("serie").disabled = false;
            dv.innerHTML = "";
        }
    }else{
        if(afuncionario.readyState==1){
			document.getElementById("nome_funcao").disabled = true;
			document.getElementById("ctps").disabled = true;
			document.getElementById("serie").disabled = true;
            dv.innerHTML = "<img src='images/arrow_loading.gif' border=0 alt='Carregando, aguarde...' title='Carregando, aguarde...'>";
        }
    }
}

/***********************************************************************************************/
// --> FUNCTION - [ MODULES/CGRT ] - SINALIZAÇÃO - STEP6
/***********************************************************************************************/
function cgrt_sina_get_material(val){
   //alert(val);
   var url = "common/ajax_orc_sim_get_material.php?";
   url = url + "cate=" + val;
   url = url + "&cache=" + new Date().getTime();
   sinagm.open("GET", url, true);
   sinagm.onreadystatechange = cgrt_sina_get_material_reply;
   sinagm.send(null);
}
function cgrt_sina_get_material_reply(){
    if(sinagm.readyState == 4){
        var msg = sinagm.responseText;
        var buffer = msg.split("£");
        
    	var data = buffer[0].split("|");

        var mat = document.getElementById('material');
        mat.disabled = false;
    	var esp = document.getElementById('espessura');
    	esp.length = 0;
    	esp.disabled = true;
    	var aca = document.getElementById('acabamento');
        aca.length = 0;
    	aca.disabled = true;
    	var tam = document.getElementById('tamanho');
    	tam.disabled = false;
    	var leg = document.getElementById('legenda');
    	leg.disabled = false;
    	
    	mat.length = data.length;
    	mat.selectedIndex = 0;
    	for(x=1;x<data.length;x++){
            mat.options[x].value = data[x-1];
            mat.options[x].text  = data[x-1];
    	}
    	
    	var dtz = buffer[1].split("|");
    	tam.length = dtz.length;
    	for(y=1;y<dtz.length;y++){
            tam.options[y].value = dtz[y-1];
            tam.options[y].text  = dtz[y-1];
    	}
    	
    	var ddt = buffer[2].split("|");
    	leg.length = ddt.length;
    	for(z=1;z<ddt.length;z++){
            leg.options[z].value = ddt[z-1];
            leg.options[z].text  = ddt[z-1];
    	}
    	
    	//IMAGEM - TEST
    	var img = buffer[3].split("|");
        var sim = "";
    	for(i=0;i<img.length-1;i++){
            sim += "<img src='http://shoppingsesmt.com/images/upload/"+img[i]+"' border=0 width=50 height=50>";
    	}
    	
    	//document.getElementById('imgex').innerHTML = sim;
    	
    	document.getElementById('loadmat').style.display = 'none';
    	document.getElementById('loadtam').style.display = 'none';
        document.getElementById('loadleg').style.display = 'none';
    }else{
        if(sinagm.readyState==1){
            document.getElementById('loadmat').style.display = 'inline';
            document.getElementById('loadtam').style.display = 'inline';
            document.getElementById('loadleg').style.display = 'none';
        }
    }
}
/***********************************************************************************************/
function cgrt_sina_get_espessura(val){
   var url = "common/ajax_orc_sim_get_espessura.php?";
   url = url + "mate=" + val;
   url = url + "&cache=" + new Date().getTime();
   sinage.open("GET", url, true);
   sinage.onreadystatechange = cgrt_sina_get_espessura_reply;
   sinage.send(null);
}
function cgrt_sina_get_espessura_reply(){
    if(sinage.readyState == 4){
        var msg = sinage.responseText;
        var buf = msg.split("£");
    	var data = buf[0].split("|");

    	var esp = document.getElementById('espessura');
    	esp.disabled = false;
    	var aca = document.getElementById('acabamento');
    	aca.disabled = false;
    	var leg = document.getElementById('legenda');
    	esp.length = data.length;
    	for(x=1;x<data.length;x++){
            esp.options[x].value = data[x-1];
            esp.options[x].text  = data[x-1];
    	}
    	
    	var data = buf[1].split("|");
    	aca.length = data.length;
    	for(x=1;x<data.length;x++){
            aca.options[x].value = data[x-1];
            aca.options[x].text  = data[x-1];
    	}
    	document.getElementById('loadesp').style.display = 'none';
        document.getElementById('loadaca').style.display = 'none';
    }else{
        if(sinage.readyState==1){
            document.getElementById('loadesp').style.display = 'inline';
            document.getElementById('loadaca').style.display = 'inline';
        }
    }
}

/**************************************************************************************/
function cgrt_sina_get_result(){
   if(document.getElementById('categoria').value != ""){
       var url = "common/ajax_orc_sin_result.php?";
       url = url + "cate=" + document.getElementById('categoria').value;
       url = url + "&mate=" + document.getElementById('material').value;
       url = url + "&espe=" + document.getElementById('espessura').value;
       url = url + "&acab=" + document.getElementById('acabamento').value;
       url = url + "&tama=" + document.getElementById('tamanho').value;
       url = url + "&lege=" + document.getElementById('legenda').value;
       url = url + "&cache=" + new Date().getTime();
       sinagr.open("GET", url, true);
       sinagr.onreadystatechange = cgrt_sina_get_result_reply;
       sinagr.send(null);
   }else{
       showAlert('Selecione uma categoria para realizar a pesquisa!');
   }
}

function cgrt_sina_get_result_reply(){
    var conten = document.getElementById('sinconten');
    if(sinagr.readyState == 4){
        var msg = sinagr.responseText;
    	var data = msg.split("§");
    	var text = "";
    	if(data[0] > 0){//items found
    	    var buffer = data[1].split("£");
    	    text += "<table width=100% border=0>";
    	    text += "<tr>";
    	    text += "<td class='text' width=45 align=center><b>Cód</b></td>";
    	    text += "<td class='text'><i>"+data[0]+" Item(s) encontrado(s)</i></td>";
    	    text += "</tr>";
        	for(x=0;x<buffer.length-1;x++){
        	    var item = buffer[x].split("|");
        	    text += "<tr class='roundbordermix'>";
                text += "<td class='text roundborder curhand' width=45 align=center onclick=\"if(confirm('Tem certeza que deseja adicionar este item?','')){cgrt_sina_add_placas("+item[0]+",prompt('Informe a quantidade de items:','1'));}\">"+ item[0] +"</td>";
    	        text += "<td class='text roundborder curhelp' alt='"+item[2]+"' title='"+item[2]+"'>"+ item[4].substring(0, 33) +"...</td>";
    	        text += "</tr>";
        	}
        	text += "</table>";
        	conten.innerHTML = text;
    	}else{//nothing found
    	    conten.innerHTML = "<center>Nenhum resultado encontrado.</center>";
    	}
    }else{
        if(sinagr.readyState==1){
            conten.innerHTML = "<table height=280 border=0 align=center><tr><td valign=center align=center style=\"height: 260px;\"><img src='images/load.gif' border=0></td></tr></table>";
        }
    }
}

/***********************************************************************************************/
function cgrt_sina_add_placas(cod_produto, qnt){
  //alert(cod_produto);	
   if(cod_produto > 0 && qnt > 0){
       var url = "common/ajax_orc_sin_add_placas.php?";
       url = url + "cod_produto=" + cod_produto;
       url = url + "&qnt=" + qnt;
       url = url + "&cod_cliente=" + document.getElementById('cod_cliente').value;
       url = url + "&cod_orcamento=" + document.getElementById('cod_orcamento').value;
       //url = url + "&preco_produto=" + document.getElementById('preco_produto').value;
       url = url + "&legenda=" + document.getElementById('legenda').value;
       url = url + "&cache=" + new Date().getTime();
       sinaap.open("GET", url, true);
       sinaap.onreadystatechange = cgrt_sina_add_placas_reply;
       sinaap.send(null);
   }
}

function cgrt_sina_add_placas_reply(){
    //var content = document.getElementById('sincontent');
    if(sinaap.readyState == 4){
        var msg = sinaap.responseText;
    	var data = msg.split("|");
        if(data[2] > 0){
            //update list
            ajax_orc_sin_update_placas();
			//showAlert('Produto adicionado ao orçamento!');
        }else{
            showAlert('Houve um erro ao adicionar este item no banco de dados. Por favor, entre em contato com o setor de suporte!');
        }
    }else{
        if(sinaap.readyState==1){
            //content.innerHTML = "<table height=280 border=0 align=center><tr><td valign=center align=center style=\"height: 260px;\"><img src='images/load.gif' border=0></td></tr></table>";
        }
    }
}

/***********************************************************************************************/
function ajax_orc_sin_update_placas(){
   var url = "common/ajax_orc_sin_update_placas.php?";
   url = url + "cod_cliente=" + document.getElementById('cod_cliente').value;;
   url = url + "&cod_orcamento=" + document.getElementById('cod_orcamento').value;;
   url = url + "&cache=" + new Date().getTime();
   sinaup.open("GET", url, true);
   sinaup.onreadystatechange = ajax_orc_sin_update_placas_reply;
   sinaup.send(null);
}

function ajax_orc_sin_update_placas_reply(){
    var conten = document.getElementById('addeditens');
    if(sinaup.readyState == 4){
        var msg = sinaup.responseText;
    	var data = msg.split("£");
    	var table = "";
    	table += "<table width=100% border=0>";
    	table += "<tr>";
    	table += "<td width=45 class='text' align=center><b>Cód.</b></td>";
    	table += "<td class='text'><b>Items cadastrados</b></td>";
    	table += "<td width=30 class='text' align=center alt='Quantidade' title='Quantidade'><b>Qnt</b></td>";
    	table += "<td width=30 class='text' align=center><b></b></td>";
    	table += "</tr>";
        if(data.length > 1){
            for(var x=0;x<data.length-1;x++){
                var buffer = data[x].split("|");
                table += "<tr class='text roundbordermix'>";
                table += "<td class='roundborder text' align=center>" + buffer[1] + "</td>";
                table += "<td class='roundborder text curhelp' alt='Legenda: "+buffer[4]+"' title='Legenda: "+buffer[4]+"'>" + buffer[2] /*.substring(0, 40)*/ + "</td>";
                table += "<td class='roundborder text' align=center>" + buffer[3] + "</td>";
                table += "<td class='roundborderselectedred text curhand' align=center alt='Excluir' title='Excluir' onclick=\"if(confirm('Tem certeza que deseja excluir este item?','')){cgrt_sina_del_placas("+buffer[0]+");}\"><b>X</b></td>";
                table += "</tr>";
            }
            table += "</table>";
            conten.innerHTML = table;
			//showAlert('Produto adicionado ao orçamento!');
        }else{
            //nada cadastrado ainda
            conten.innerHTML = "";
        }
    }else{
        if(sinaup.readyState==1){
			showAlert('Produto adicionado ao orçamento!');
            //conten.innerHTML = "<table border=0 align=center><tr><td valign=center align=center><img src='images/load.gif' border=0></td></tr></table>";
        }
    }
}

/***********************************************************************************************/
function cgrt_sina_del_placas(id){
   if(id > 0){
       var url = "common/ajax_orc_sin_del_placas.php?";
       url = url + "id=" + id;
       url = url + "&cod_orcamento=" + document.getElementById('cod_orcamento').value;
       url = url + "&cache=" + new Date().getTime();
       sinaap.open("GET", url, true);
       sinaap.onreadystatechange = cgrt_sina_del_placas_reply;
       sinaap.send(null);
   }
}

function cgrt_sina_del_placas_reply(){
    //var content = document.getElementById('sincontent');
    if(sinaap.readyState == 4){
        var msg = sinaap.responseText;
        if(msg > 0){
            //update list
            ajax_orc_sin_update_placas();
        }else{
            showAlert('Houve um erro ao remover este item no banco de dados. Por favor, entre em contato com o setor de suporte!');
        }
    }else{
        if(sinaap.readyState==1){
            //content.innerHTML = "<table height=280 border=0 align=center><tr><td valign=center align=center style=\"height: 260px;\"><img src='images/load.gif' border=0></td></tr></table>";
        }
    }
}

/***********************************************************************************************/

function change_condicao(id, valor){
if(id != "" && valor != ""){
   var url = "common/ajax_change_condicao.php?id=" + id;
   url = url + "&valor=" + valor;
   url = url + "&cache=" + new Date().getTime();//para evitar problemas com o cache
   ccon.open("GET", url, true);
   ccon.onreadystatechange = condicao_reply;
   ccon.send(null);
}
}

function condicao_reply(){
if(ccon.readyState == 4)
{
    var msgz = ccon.responseText;
    msgz = msgz.replace(/\+/g," ");
    msgz = unescape(msgz);
    var data = msgz.split("|");
    if(msgz != ""){
       alert(data[0]);
    }else{
       alert("Erro ao alterar condição de pagamento!");
    }
}else{
 if (ccon.readyState==1){

    }
 }
}



function change_delivery_time(orc, valor){
    if(orc != "" && valor != ""){
       var url = "common/ajax_change_delivery_time.php?orc=" + orc;
       url = url + "&valor=" + valor;
       url = url + "&cache=" + new Date().getTime();//para evitar problemas com o cache
       ccha.open("GET", url, true);
       ccha.onreadystatechange = change_delivery_time_reply;
       ccha.send(null);
    }
}

function change_delivery_time_reply(){
if(ccha.readyState == 4)
{
    var msgz = ccha.responseText;
    msgz = msgz.replace(/\+/g," ");
    msgz = unescape(msgz);
    var data = msgz.split("|");
    if(msgz != ""){
       alert(data[0]);
    }else{
       alert("Erro ao alterar prazo de entrega!");
    }
}else{
 if (ccha.readyState==1){

    }
 }
}
