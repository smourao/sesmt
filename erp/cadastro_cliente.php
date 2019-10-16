<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i ") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
include "sessao.php";
include "./config/connect.php";
switch($grupo){ // "$grupo" é a variável global de sessão, criada no "auth.php"
	case "administrador":
		$leitura = "";
	break;
	case "funcionario":
		$leitura = "readonly=true";
	break;
}

if($id_func_digitado!="" && is_numeric($id_func_digitado)){
$query_funcionario="select * from funcionario where funcionario_id=".$id_func_digitado."";
$result_funcionario=pg_query($query_funcionario)or die("Erro na pesquisa de Funcionario $query_funcionario".pg_last_error($connect));
$qtd_funcionario=pg_num_rows($result_funcionario);

if($qtd_funcionario==1){
	$row_funcionario=pg_fetch_array($result_funcionario);
	$funcionario_id=$row_funcionario[funcionario_id];
	}else{
	$valor="";
	echo'<script>alert("Funcionário não cadastrado ou inválido");</script>';
	}

}else{
	$funcionario_id=18;
}

if($cnae_digitado!=""){
$query_cnae="select cnae_id from cnae where cnae='$cnae_digitado'";
$result_cnae=pg_query($query_cnae)or die("Erro na pesquisa de CNAE $query_cnae".pg_last_error($connect));
$qtd_cnae=pg_num_rows($result_cnae);

if($qtd_cnae==1){
	$row_cnae=pg_fetch_array($result_cnae);
	$cnae_id=$row_cnae[cnae_id];
	}else{
	$valor="";
	echo'<script>alert("CNAE não cadastrado ou inválido");</script>';
	}
}

function coloca_zeros($numero){
echo str_pad($numero, 4, "0", STR_PAD_LEFT);
}

function zeros($numero){
echo str_pad($numero, 3, "0", STR_PAD_LEFT);
}

if($valor=="gravar"){
	$sql = "select cnpj from cliente";
	$res = pg_query($connect, $sql);
	$buffer = pg_fetch_all($res);
	$cnpj_existente = 0;
	$remover = array("/", ".", "-");
		for($x=0;$x<count($buffer);$x++){
			if(str_replace($remover, "", $buffer[$x]['cnpj']) == str_replace($remover, "", $cnpj)){
				$cnpj_existente = 1;
			}
		}

	$query_cliente_cod="select cliente_id from cliente where cliente_id=".$cod_cliente." and filial_id = ".$filial_id."";
	$result_cliente_cod =pg_query($connect, $query_cliente_cod) or die ("Erro na query $query_cliente_cod".pg_last_error($connect));
	$row_cliente_cod=pg_fetch_array($result_cliente_cod);

	if (pg_num_rows($result_cliente_cod) < 1) {
	  if($cnpj_existente<=0){
		$query_cliente="insert into cliente
		(ano_contrato, cliente_id, filial_id, razao_social, nome_fantasia, endereco, bairro, cep, municipio, estado, telefone, fax, celular, email, cnpj, cnpj_contratante, insc_estadual, insc_municipal, cnae_id, descricao_atividade, numero_funcionarios, grau_de_risco, nome_contato_dir, cargo_contato_dir, tel_contato_dir, email_contato_dir, skype_contato_dir, msn_contato_dir, nextel_contato_dir, nextel_id_contato_dir, nome_cont_ind, cargo_cont_ind, email_cont_ind, skype_cont_ind, tel_cont_ind, escritorio_contador, tel_contador, msn_contador, skype_contador, nome_contador, email_contador, status, classe, vendedor_id, num_end, num_rep, membros_brigada) values
		('$ano_contrato', $cod_cliente, $filial_id, '".addslashes($razao_social)."', '$nome_fantasia', '$endereco', '$bairro', '$cep', '$municipio', '$estado', '$telefone', '$fax', '$celular', '$email', '$cnpj', '$cnpj_contratante', '$insc_estadual', '$insc_municipal', '".$cnae_id."', '$desc_atividade', '$numero_funcionarios', '$grau_de_risco', '$nome_contato_dir', '$cargo_contato_dir', '$tel_contato_dir', '$email_contato_dir', '$skype_contato_dir', '$msn_contato_dir', '$nextel_contato_dir', '$nextel_id_contato_dir', '$nome_cont_ind', '$cargo_cont_ind', '$email_cont_ind', '$skype_cont_ind', '$tel_cont_ind', '$escritorio_contador', '$tel_contador', '$msn_contador', '$skype_contador', '$nome_contador', '$email_contador', '$status', '$classe', ".$funcionario_id.", '$num_end', '$num_rep', '$membros_brigada')";
		$result_cliente=pg_query($query_cliente)or die("Erro na query: $query_cliente".pg_last_error($connect));

		echo '<script> alert("Cliente Cadastrado com Sucesso!");</script>';
		}else{//IF
            echo "<script>alert('CNPJ já cadatrado!')</script>";
        }
	}else {

		$query_cliente = "update cliente SET ano_contrato='$ano_contrato', cliente_id=".$cod_cliente.", filial_id=".$filial_id.", razao_social='".addslashes($razao_social)."', nome_fantasia='".$nome_fantasia."', endereco='$endereco', bairro='$bairro', cep='$cep', municipio='$municipio', estado='$estado', telefone='$telefone', fax='$fax', celular='$celular', email='$email', cnpj='$cnpj', cnpj_contratante='$cnpj_contratante', insc_estadual='$insc_estadual', insc_municipal='$insc_municipal', cnae_id='$cnae_id', descricao_atividade='$desc_atividade', numero_funcionarios='$numero_funcionarios', grau_de_risco='".$grau_de_risco."', nome_contato_dir='$nome_contato_dir', cargo_contato_dir='$cargo_contato_dir', tel_contato_dir='$tel_contato_dir', email_contato_dir='$email_contato_dir', skype_contato_dir='$skype_contato_dir', msn_contato_dir='$msn_contato_dir', nextel_contato_dir='$nextel_contato_dir', nextel_id_contato_dir='$nextel_id_contato_dir', nome_cont_ind='$nome_cont_ind', cargo_cont_ind='$cargo_cont_ind',
		email_cont_ind='$email_cont_ind', skype_cont_ind='$skype_cont_ind', tel_cont_ind='$tel_cont_ind', escritorio_contador='$escritorio_contador', tel_contador='$tel_contador', msn_contador='$msn_contador', skype_contador='$skype_contador', nome_contador='$nome_contador', email_contador='$email_contador', status='$status', classe='$classe', num_end='$num_end', num_rep='$num_rep', membros_brigada='$membros_brigada' where cliente_id=".$row_cliente_cod[cliente_id]."  and filial_id=".$filial_id."";
		$result_cliente=pg_query($query_cliente)or die("Erro na query: $query_cliente".pg_last_error($connect));

		echo '<script> alert("Cliente Alterado com Sucesso!");</script>';
	}
}

if($valor=="apagar"){

	$query_cliente_cod="select cliente_id from cliente where cliente_id=".$cod_cliente." and filial_id=".$filial_id."";
	$result_cliente_cod =pg_query($query_cliente_cod) or die ("Erro na query $query_cliente_cod".pg_last_error($connect));
	if ($teste_cliente_cod=pg_num_rows($result_cliente_cod) >= 1) {

		$query_cliente_del="delete from cliente where cliente_id=".$cod_cliente." and filial_id=".$filial_id."";
		pg_query($query_cliente_del)or die("Erro na query: $query_cliente_del".pg_last_error($connect));

		}
}

if($valor=="novo" || $novo=="new"){

	$query_cliente_cod="select cliente_id from cliente order by cliente_id DESC LIMIT 1";
	$result_cliente_cod =pg_query($query_cliente_cod) or die ("Erro na query $query_cliente_cod".pg_last_error($connect));
	$row_cliente_cod=pg_fetch_array($result_cliente_cod);

	$cliente_id_sel=$row_cliente_cod[cliente_id]+1;
	$filial_id_sel=1;

}else if ($valor=="novofl"){
		$query_cliente_cod="select filial_id from cliente where cliente_id=".$cod_cliente." order by filial_id DESC LIMIT 1";
		$result_cliente_cod =pg_query($query_cliente_cod) or die ("Erro na query $query_cliente_cod".pg_last_error($connect));
		$row_cliente_cod=pg_fetch_array($result_cliente_cod);

		$filial_id_sel=$row_cliente_cod[filial_id]+1;
		$cliente_id_sel=$cod_cliente;
	}else if($valor=="gravar" || $cod_cliente!="" || $cliente_id!=""){
			if($filial_id!=""){
				$filtro_filial='and filial_id='.$filial_id.'';
			}else{
				$filtro_filial='and filial_id=1';
			}
		$query="select * from cliente where cliente_id=".$cliente_id.$cod_cliente." $filtro_filial";
		$result=pg_query($query) or die ("Erro na query $query".pg_last_error($connect));
		$row=pg_fetch_array($result);

		}

function ddd($ddd, $numero){
$verifica=explode(" - ", $numero);
if ($verifica[0]!=""){
	if($ddd!=""){
		if($verifica[1]==""){
			$novo_numero=$ddd." -"." ".$numero;
			return $novo_numero;
		}else{
			$novo_numero=$ddd." -"." ".$verifica[1];
			return $novo_numero;
		}
	}else{
	$novo_numero=$numero;
	return $novo_numero;
	}
	}
}

if($row[classe]!=""){

$quantidade=$row[numero_funcionarios];

$query_clac="select * from brigadistas where classe = '$row[classe]'";
$result_calc=pg_query($query_clac) or die("Erro na query: $query_clac".pg_last_error($connect));
$row_calc=pg_fetch_array($result_calc);

 $menor=$row_calc[ate_10];
 $maior=$row_calc[mais_10];

	if($quantidade<=10){

	$calculo=$quantidade*($menor/100);

	}else{
 	$calculo=10*($menor/100)+($quantidade-10)*($maior/100);
	}

if($membros=round($calculo, 0) <= 0){
$membros="Não necessária";
}else{
$membros=round($calculo, 0);
}
}

?>
  <?php
	if($row[cnae_id]!=""){
	    $query_cnae="select * from cnae where cnae_id=".$row[cnae_id]."";
	    $result_cnae=pg_query($query_cnae)or die("Erro na query $query_cnae".pg_last_error($connect));
	    $row_cnae=pg_fetch_array($result_cnae);
	    //$novo_cnae=$row_cnae[cnae];
	}
	?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="cache-control"   content="no-cache" />
<meta http-equiv="pragma" content="no-cache" />
<meta http-equiv="expires" content = "-1" />

<title>::Sistema SESMT - Cadastro de Cliente::</title>
<link href="css_js/css.css" rel="stylesheet" type="text/css">
<style type="text/css">
td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}

.relatorio {
position: absolute;
border: 3px solid black;
background: #097b42;
color: #FFFFFF;
width: 300px;
height: 400px;
}

.fontebranca{
   color: #FFFFFF;
}

.textorelatorio{
   color: #FFFFFF;
   font-size: 12px;
}

.trans{
filter:alpha(opacity=95);
-moz-opacity:0.95;
-khtml-opacity: 0.95;
opacity: 0.95;
}
</style>

<script language="javascript" src="scripts.js"></script>
<script language="javascript" src="ajax.js"></script>
<script language="javascript" src="screen.js"></script>

</head>
<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" tracingsrc="img/Sistema sesmt 3  (2).png" tracingopacity="0">

<!-- ################################################################################## -->
<!-- #                            FLOWING WINDOW DEFINITIONS                          # -->
<!-- ################################################################################## -->
<script>
   window.onresize = function(){resize('test')};
   <?PHP
   if($_GET['relatorio']){
      echo "window.onload = function(){resize('test'); maximize();};";
   }else{
      echo "window.onload = function(){resize('test'); minimize();};";
   }
   ?>
   var save = 0;
</script>

<!-- DIV COM CONTEUDO DINAMICO -->
<div id="test" class="relatorio trans">
   <!-- ### DIV - TITULO DA JANELA -->
   <div id=titulo name=titulo style="background: #000000;">
      <table width=100%>
      <tr>
         <td class=fontebranca><b>Relatório de Atendimento</b></td>
         <td align=right width=40 valign=center>
         <img src="images/minimizar.jpg" style="cursor:pointer;" onClick="minimize();">
         </td>
      </tr>
      </table>
   </div>

   <div id=loading name=loading  style="position: absolute; display: none;" class="trans">
      <table width=570 height=380>
         <tr>
            <td align=center bgcolor=black><font color=white><b>Atualizando...</b></font></td>
         </tr>
      </table>
   </div>

   <div id=add style="display: none;">
      <table width=100%>
      <tr>
      <td width=30 class=textorelatorio><b>Título</b></td>
      <td><input type=text name=messagetitle id=messagetitle></td>
      </tr>
      <tr>
      <td width=30 class=textorelatorio><b>Comentário</b></td>
      <td><textarea name=comentario id=comentario style='width:100%;' rows='6'></textarea></td>
      </tr>
      </table>
      <br><center>
      <input type=button onclick='save_comment(<?PHP echo $_GET['cliente_id'];?>);' value='Adicionar'> &nbsp;
      <input type=button onclick='back_to_list(<?PHP echo $_GET['cliente_id'];?>);' value='Voltar'>
   </div>

   <div id=edit style="display: none;">
      <table width=100%>
      <tr>
      <td width=30 class=textorelatorio><b>Título</b></td>
      <td><input type=text name=messagetitleedit id=messagetitleedit></td>
      </tr>
      <tr>
      <td width=30 class=textorelatorio><b>Comentário</b></td>
      <td><textarea name=comentarioedit id=comentarioedit style='width:100%;' rows='6'></textarea></td>
      </tr>
      </table>
      <br><center>
      <input type=hidden name=editid id=editit value="">
      <input type=button onclick='save_comment_edit(<?PHP echo $_GET['cliente_id'];?>);' value='Salvar'> &nbsp;
      <input type=button onclick='back_to_list(<?PHP echo $_GET['cliente_id'];?>);' value='Voltar'>
   </div>

   <!-- ### DIV - CONTEÚDO DA JANELA -->
   <div id=conteudo name=conteudo class="textorelatorio" align=justify>
   <?PHP
   if($_GET['cliente_id']){
         echo "<p>";
         echo "<center><input type=button onclick=\"add_comment({$_GET[cliente_id]});\" value='Adicionar comentário'></center>";
         echo "<p>";
         $sql = "SELECT * FROM erp_cliente_message WHERE cliente_id = '{$_GET['cliente_id']}'";
         $result = pg_query($sql);
         $dados = pg_fetch_all($result);

         for($x=0;$x<pg_num_rows($result);$x++){
            echo date("d/m/Y", strtotime($dados[$x]['data_criacao']))." <input type=button onclick='delete_message({$dados[$x][id]});' value='Excluir'> - <b><span style='cursor:pointer;' onclick=\"edit_message({$dados[$x][id]});\">{$dados[$x][titulo]}</span></b>";
            echo "<br>";
         }
      }
   ?>
   </div>
  <!-- ### DIV - CONTEÚDO DA JANELA -->

</div>

<input type=hidden name=temptext id=temptext>

<!-- ################################################################################## -->
<script>

function add_comment(id){
   //document.getElementById("conteudo").innerHTML = "<table width=100%><tr><td width=30 class=textorelatorio><b>Título</b></td><td><input type=text name=titulo id=titulo></td></tr><tr><td width=30 class=textorelatorio><b>Comentário</b></td><td><textarea name=comentario id=comentario style='width:100%;' rows='6'></textarea></td></tr></table><br><center><input type=button onclick='save_comment("+id+");' value='Adicionar'> &nbsp;    <input type=button onclick='back_to_list("+id+");' value='Voltar'>";
   document.getElementById("add").style.display = "block";
   document.getElementById("conteudo").style.display = "none";
}

function visita(value){
  if(value == 1){
     document.getElementById("visitasim").style.display = "block";
  }else{
     document.getElementById("visitasim").style.display = "none";
  }
}

function reacao(obj){
   //alert(obj.options[obj.selectedIndex].value);
   var opt = obj.options[obj.selectedIndex].value;

   if(opt == "0"){
      document.getElementById("razao_social").style.display = "none";
   }else if(opt == 1){
      document.getElementById("razao_social").style.display = "block";
   }else if(opt == 2){
      document.getElementById("razao_social").style.display = "block";
      document.getElementById("visita1").checked = true;
      document.getElementById("visitasim").style.display = "block";
   }else if(opt == 3){
      document.getElementById("razao_social").style.display = "none";
      document.getElementById("visita1").checked = true;
      document.getElementById("visitasim").style.display = "block";
   }else if(opt == 4){
      document.getElementById("razao_social").style.display = "block";
      document.getElementById("visita1").checked = true;
      document.getElementById("visitasim").style.display = "block";
   }
}

function minimize(){
//alert(navigator.appName);
   div = document.getElementById('test');
   div.style.height = "20px";
   div.style.width = "210px";
   document.getElementById("titulo").innerHTML = "<table width=100%><tr><td  class=fontebranca><b><font size=1>Relatório de Atendimento</b></td><td align=right width=40 valign=center><img src='images/restaurar.jpg' style='cursor:pointer;' onclick=maximize(); alt='Maximizar' title='Maximizar'></td></tr></table>";
   document.getElementById("conteudo").style.display = "none";
   document.getElementById("edit").style.display = "none";
   document.getElementById("add").style.display = "none";
   if(navigator.appName =='Microsoft Internet Explorer')
   {
      div.style.left = (getWidth() - 215)+"px";
   }else{
      div.style.left = (getWidth() - 235)+"px";
   }
}

function maximize(){
   div = document.getElementById('test');
   div.style.height = "400px";
   div.style.width = "570px";
   document.getElementById("titulo").innerHTML = "<table width=100%><tr><td  class=fontebranca align=center><b>Relatório de Atendimento</b></td><td align=right width=40 valign=center><img src='images/minimizar.jpg'  style='cursor:pointer;' onclick=minimize(); alt='Minimizar' title='Minimizar'></td></tr></table>";
   document.getElementById("conteudo").style.display = "block";
   if(navigator.appName == 'Microsoft Internet Explorer')
   {
      div.style.left = (getWidth() - 575)+"px";
   }else{
      div.style.left = (getWidth() - 595)+"px";
   }
}

// ------------- AJAX --------------

function simulador_first_edit(cliente_id){
   var url = "cliente_first.php?id="+cliente_id;
   url = url + "&editar=1";
   url = url + "&cache=" + new Date().getTime();
   http.open("GET", url, true);
   http.onreadystatechange = simulador_first_reply;
   http.send(null);
}

function simulador_first(cliente_id){
   var brindes = "";
   for(var x=11; x > 0;x--){
      var it = document.getElementById('brinde['+x+']');
      //alert(it.checked);
      if(it.checked){
         brindes += it.value + "|";
      }
   }

   var apreciado = document.getElementById("apreciado");
   apreciado = apreciado.options[apreciado.selectedIndex].value;
   var reacao = document.getElementById("reacao");
   reacao = reacao.options[reacao.selectedIndex].value;
   var data_programa = document.getElementById("dia_u").value + "/" + document.getElementById("mes_u").value + "/" + document.getElementById("ano_u").value;

   var dia_visita = document.getElementById("dia").value + "/" + document.getElementById("mes").value + "/" + document.getElementById("ano").value;
   var horario_visita = document.getElementById("hora").value + ":" + document.getElementById("min").value;
   var pessoa_contato = document.getElementById("pessoa").value;
   var telefone = document.getElementById("telefone").value;

   if(document.getElementById("visita1").checked == false && document.getElementById("visita0").checked == false){
     alert('Selecione se visita foi ou não aceita!');
     return false;
   }else{
      if(document.getElementById("visita1").checked == false){
         var visita = document.getElementById("visita0").value;
         dia_visita = "00/00/0000";
         horario_visita = "00:00";
      }else{
         var visita = document.getElementById("visita1").value;
         if(document.getElementById("dia").value == "" || document.getElementById("mes").value == "" || document.getElementById("ano").value == ""){
            alert('Selecione a data de visita!');
            return false;
         }
         if(document.getElementById("hora").value == "" || document.getElementById("min").value == ""){
            alert('Selecione a hora da visita!');
            return false;
         }
         if(pessoa_contato == ""){
            alert('Informe o nome de contato para a visita!');
            return false;
         }
         if(telefone == ""){
            alert('Informe um telefone de contato para a visita!');
            return false;
         }
      }
   }

   var url = "cliente_first.php?id="+cliente_id;
   url = url + "&contato=" + document.getElementById("contato_direto").value;
   url = url + "&apreciado=" + apreciado;
   url = url + "&reacao=" + reacao;
   url = url + "&prestadora=" + document.getElementById("empresa").value;
   url = url + "&data_programa=" + data_programa;
   url = url + "&visita=" + visita;
   url = url + "&dia_visita=" + dia_visita;
   url = url + "&horario_visita=" + horario_visita;
   url = url + "&pessoa_contato=" + pessoa_contato;
   url = url + "&telefone=" + telefone;
   url = url + "&referencia=" + document.getElementById("referencia").value;
   url = url + "&brindes=" + brindes;

   url = url + "&cache=" + new Date().getTime();
   http.open("GET", url, true);
   http.onreadystatechange = simulador_first_reply;
   http.send(null);
}

function simulador_first_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
	var data = msg.split("|");
    //document.getElementById("conteudo").innerHTML = msg;
    //alert(msg);
    if(data[0] == "1"){
       alert('Dados atualizados!');
       save = 1;
    }else if(data[0] == "2"){
       document.getElementById("conteudo").innerHTML = data[1];
    }else{
       alert('Erro ao armazenar dados!');
    }
    document.getElementById("loading").style.display = "none";
}else{
 if (http.readyState==1){
       //waiting...
       document.getElementById("loading").style.display = "block";
    }
 }
}

function back_to_list(cliente_id){
   var url = "cliente_first_list.php?id="+cliente_id;
   url = url + "&cache=" + new Date().getTime();
   http.open("GET", url, true);
   http.onreadystatechange = simulador_list_reply;
   http.send(null);
}
function simulador_list_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
	var data = msg.split("|");
    document.getElementById("add").style.display = "none";
    document.getElementById("edit").style.display = "none";
    document.getElementById("conteudo").style.display = "block";
    document.getElementById("conteudo").innerHTML = data[0];
    document.getElementById("loading").style.display = "none";
}else{
 if (http.readyState==1){
       //waiting...
       document.getElementById("loading").style.display = "block";
    }
 }
}

function save_comment(cliente_id){
   var url = "save_cliente_comment.php?id="+cliente_id;
   url = url + "&titulo=" + document.getElementById("messagetitle").value;
   url = url + "&mensagem=" + document.getElementById("comentario").value;
   url = url + "&cache=" + new Date().getTime();
   http.open("GET", url, true);
   http.onreadystatechange = save_comment_reply;
   http.send(null);
}
function save_comment_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
	var data = msg.split("|");
    //document.getElementById("conteudo").innerHTML = data[0];
    if(data[1] == 1){
       alert('Comentário adicionado!');
       document.getElementById("add").style.display = "none";
       document.getElementById("conteudo").style.display = "block";
       document.getElementById("messagetitle").value = "";
       document.getElementById("comentario").value = "";
       back_to_list(data[0]);
    }else{
       alert('Erro ao adicionar comentário!');
    }
    document.getElementById("loading").style.display = "none";
}else{
 if (http.readyState==1){
       //waiting...
       document.getElementById("loading").style.display = "block";
    }
 }
}

function save_comment_edit(cliente_id){
   var url = "save_cliente_comment_edit.php?id="+cliente_id;
   url = url + "&titulo=" + document.getElementById("messagetitleedit").value;
   url = url + "&mensagem=" + document.getElementById("comentarioedit").value;
   url = url + "&mid=" + document.getElementById("editit").value;
   url = url + "&cache=" + new Date().getTime();
   http.open("GET", url, true);
   http.onreadystatechange = save_edit_reply;
   http.send(null);
}
function save_edit_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
	var data = msg.split("|");
    //document.getElementById("conteudo").innerHTML = data[0];
    if(data[1] == 1){
       alert('Comentário alterado!');
       document.getElementById("edit").style.display = "none";
       document.getElementById("conteudo").style.display = "block";
       document.getElementById("messagetitleedit").value = "";
       document.getElementById("comentarioedit").value = "";
       back_to_list(data[0]);
       document.getElementById("editit").value = 0;
    }else{
       alert('Erro ao alterar comentário!');
    }
    document.getElementById("loading").style.display = "none";
}else{
 if (http.readyState==1){
       //waiting...
       document.getElementById("loading").style.display = "block";
    }
 }
}



function edit_message(message_id){
   document.getElementById("editit").value = message_id;
   var url = "edit_cliente_message.php?id="+message_id;
   url = url + "&cache=" + new Date().getTime();
   http.open("GET", url, true);
   http.onreadystatechange = edit_message_reply;
   http.send(null);
}
function edit_message_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
	var data = msg.split("|");
       document.getElementById("edit").style.display = "block";
       document.getElementById("add").style.display = "none";
       document.getElementById("conteudo").style.display = "none";
       document.getElementById("messagetitleedit").value = data[0];
       document.getElementById("comentarioedit").value = data[1];
       document.getElementById("loading").style.display = "none";
}else{
 if (http.readyState==1){
       //waiting...
       document.getElementById("loading").style.display = "block";
    }
 }
}



function delete_message(message_id){
   document.getElementById("editit").value = message_id;
   var url = "delete_cliente_message.php?id="+message_id;
   url = url + "&cache=" + new Date().getTime();
   http.open("GET", url, true);
   http.onreadystatechange = delete_message_reply;
   http.send(null);
}
function delete_message_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
	var data = msg.split("|");
       document.getElementById("edit").style.display = "none";
       document.getElementById("add").style.display = "none";
       document.getElementById("conteudo").style.display = "block";
       //document.getElementById("messagetitleedit").value = data[0];
       //document.getElementById("comentarioedit").value = data[1];
       document.getElementById("loading").style.display = "none";
       back_to_list(data[0]);
}else{
 if (http.readyState==1){
       //waiting...
       document.getElementById("loading").style.display = "block";
    }
 }
}

function check_meall(){
   if(document.getElementById('cnae_digitado').value == ''){
      alert('Preencha o campo CNAE!');
      document.getElementById('cnae_digitado').focus();
      return false;
   }
   if(document.getElementById('numero_funcionarios').value == ''){
      alert('Preencha o campo Número de Funcionários!');
      document.getElementById('numero_funcionarios').focus();
      return false;
   }
   if(document.getElementById('cnpj').value == ''){
      alert('Preencha o campo CNPJ!');
      document.getElementById('cnpj').focus();
      return false;
   }
   return true;
}
<!-- ################################################################################## -->
</script>







<form action="cadastro_cliente.php" method="post" enctype="multipart/form-data" name="cadastro" target="_self" id="cadastro">
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td class="fontebranca22bold"><div align="center">Cadastro de Cliente </div></td>
    </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td class="fontebranca10">Ano-Contrato</td>
	  <td class="fontebranca10">Cod. Cliente </td>
      <td class="fontebranca10">Cod Filial </td>
      <td class="fontebranca10">Razão Social </td>
      <td class="fontebranca10">Status</td>
    </tr>
    <tr>
      <td class="fontebranca10"><input id="ano_contrato" name="ano_contrato" <?php echo($leitura)?> value="<?php if(!empty($ano_contrato)){ echo $ano_contrato;} else {echo $row[ano_contrato];}?>" type="text" size="8" maxlength="9" OnKeyPress="formatar(this, '####/###')"></td>
	  <td class="fontebranca10"><input name="cod_cliente" <?php echo($leitura)?> type="text" id="cod_cliente" size="5" value="<?php if($row[cliente_id]==""){coloca_zeros($cliente_id_sel);}else{coloca_zeros($row[cliente_id]);} ?>"></td>
      <td class="fontebranca10"><input name="filial_id" type="text" <?php echo($leitura)?> id="filial_id" size="5" value="<?php if($row[filial_id]==""){zeros($filial_id_sel);}else{zeros($row[filial_id]);}?>"></td>
      <td class="fontebranca10"><input name="razao_social" <?php echo($leitura)?> type="text" id="razao_social" value="<?php if(!empty($razao_social)){ echo $razao_social;} else {echo $row[razao_social];}?>" size="68"></td>
      <td ><select name="status" id="status">
        <option value="ativo" <?php if($row[status]=="ativo"){echo "selected";} ?>>ativo</option>
        <option value="inativo" <?php if($row[status]=="inativo"){echo "selected";} ?>>inativo</option>
        <option value="semi-ativo" <?php if($row[status]=="semi-ativo"){echo "selected";} ?>>semi-ativo</option>
      </select>      </td>
    </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td class="fontebranca10">Nome fantasia </td>
      <td class="fontebranca10">CEP</td>
      <td class="fontebranca10">Endereço</td>
      <td class="fontebranca10">Nº</td>
    </tr>
    <tr>
      <td class="fontebranca10"><input name="nome_fantasia" type="text" <?php echo($leitura)?> id="nome_fantasia" value="<?php if(!empty($nome_fantasia)){ echo $nome_fantasia;} else {echo $row[nome_fantasia];}?>" size="40"></td>
      <td class="fontebranca10"><input name="cep" type="text" id="cep" value="<?php if(!empty($cep)){ echo $cep;} else {echo $row[cep];}?>" size="10" onChange="showDataCliente();" <?php echo($leitura)?>></td>
      <td class="fontebranca10"><input name="endereco" type="text" id="endereco" value="<?php if(!empty($endereco)){ echo $endereco;} else {echo $row[endereco];}?>" <?php echo($leitura)?> size="50"></td>
      <td class="fontebranca10"><input name="num_end" type="text" id="num_end" value="<?php if(!empty($num_end)){ echo $num_end;} else {echo $row[num_end];}?>" <?php echo($leitura)?> size="2"></td>
    </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td class="fontebranca10">Bairro</td>
      <td class="fontebranca10">Município</td>
      <td class="fontebranca10">Estado</td>
      <td class="fontebranca10">Telefone</td>
    </tr>
    <tr>
      <td class="fontebranca10"><input name="bairro" type="text" id="bairro" value="<?php if(!empty($bairro)){ echo $bairro;} else {echo $row[bairro];}?>" <?php echo($leitura)?> size="20"></td>
      <td class="fontebranca10"><input name="municipio" <?php echo($leitura)?> type="text" id="municipio" value="<?php if(!empty($municipio)){ echo $municipio;} else {echo $row[municipio];}?>" size="20"></td>
      <td class="fontebranca10"><input name="estado" id="estado" type="text" <?php echo($leitura)?> value="<?php if(!empty($estado)){ echo $estado;} else {echo $row[estado];}?>" size="20"></td>
      <td class="fontebranca10"><input name="telefone" maxlength="14" type="text" id="telefone" <?php echo($leitura)?> value="<?php if(!empty($telefone)){ echo $telefone;} else {echo $row[telefone];}?>" size="12" onKeyUp="fone(this);"></td>
    </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td class="fontebranca10">FAX</td>
      <td class="fontebranca10">Celular</td>
      <td class="fontebranca10">Email</td>
      <td class="fontebranca10">CNPJ</td>
      <td class="fontebranca10">CNPJ Contratante</td>
    </tr>
    <tr>
      <td class="fontebranca10"><input name="fax" <?php echo($leitura)?> type="text" id="fax" value="<?php if(!empty($fax)){ echo $fax;} else {echo $row[fax];}?>" size="15" maxlength="14" onKeyUp="fone(this);"></td>
      <td class="fontebranca10"><input name="celular" type="text" id="celular" <?php echo($leitura)?> value="<?php if(!empty($celular)){ echo $celular;} else {echo $row[celular];}?>" size="15" maxlength="14" onKeyUp="fone(this);"></td>
      <td class="fontebranca10"><input name="email" ondblClick="parent.location='mailto:<?php echo $row[email]?>';" type="text" id="email" value="<?php if(!empty($email)){ echo $email;} else {echo $row[email];}?>" size="15" <?php echo($leitura)?>></td>
      <td class="fontebranca10"><input name="cnpj" type="text" id="cnpj" onBlur="check_cnpj_cliente(this);" value="<?php if(!empty($cnpj)){ echo $cnpj;} else {echo $row[cnpj];}?>" size="17" <?php echo($leitura)?> maxlength="18" OnKeyPress="formatar(this, '##.###.###/####-##');"></td>
      <td class="fontebranca10"><input name="cnpj_contratante" type="text" id="cnpj_contratante" value="<?php if(!empty($cnpj_contratante)){ echo $cnpj_contratante;} else {echo $row[cnpj_contratante];}?>" size="17" <?php echo($leitura)?> maxlength="18" OnKeyPress="formatar(this, '##.###.###/####-##');"></td>
    </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td class="fontebranca10">Insc. Estadual </td>
      <td class="fontebranca10">Insc. Municipal </td>
      <td class="fontebranca10">CNAE</td>
      <td class="fontebranca10">Grupo</td>
      <td class="fontebranca10">G. Risco </td>
      <td class="fontebranca10">Descrição Atividade </td>
    </tr>
    <tr>
      <td class="fontebranca10"><input name="insc_estadual" type="text" id="insc_estadual" value="<?php if(!empty($insc_estadual)){ echo $insc_estadual;} else {echo $row[insc_estadual];}?>" size="15" maxlength="10" OnKeyPress="formatar(this, '##.###.###');" <?php echo($leitura)?>></td>
      <td class="fontebranca10"><input name="insc_municipal" type="text" id="insc_municipal" value="<?php if(!empty($insc_municipal)){ echo $insc_municipal;} else {echo $row[insc_municipal];}?>" size="15" maxlength="10" OnKeyPress="formatar(this, '###.###-##');" <?php echo($leitura)?>></td>
      <td class="fontebranca10"><input type="text" value="<?php echo $row_cnae[cnae]?>" name="cnae_digitado" id="cnae_digitado" size="8" onChange="showData();" onBlur="check_cnae(this);" <?php echo($leitura)?>></td>
      <td class="fontebranca10">
	  <?php
		if ($row[cnae_id]!=""){
	  $query_grupo="select grupo_cipa, grau_risco, descricao from cnae where cnae_id=".$row[cnae_id]."";
	  $result_grupo=pg_query($query_grupo)or die("Erro na consulta de grupo".pg_last_error($connect));
	  $row_grupo=pg_fetch_array($result_grupo);
	  ?>
	  &nbsp;<input name="grupo_cipa" id="grupo_cipa" type="text" value="<?php echo $row_grupo[grupo_cipa]?>" size="4" <?php echo($leitura)?>>
		<?php
		}else{
		echo' <input type="text" value="" size="4">';
		 }
		?>
		</td>
      <td class="fontebranca10"><input name="grau_de_risco" type="text" id="grau_de_risco" value="<?php echo $row_grupo[grau_risco]?>" size="5" <?php echo($leitura)?>></td>
      <td class="fontebranca10"><input name="desc_atividade" type="text" id="desc_atividade" value="<?php echo $row_grupo[descricao]?>" size="30" <?php echo($leitura)?>></td>
    </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td class="fontebranca10">Classe - Brigada </td>
      <td class="fontebranca10">Membros Part. da Brigada</td>
      <td class="fontebranca10">Nº Func.</td>
      <td class="fontebranca10">Cipa (Func./Empresa)</td>
    </tr>
    <tr>
      <td class="fontebranca10"><select name="classe" id="classe">
  	  <?php
		  $query="select * from brigadistas order by classe";
		  $result=pg_query($query)or die("Erro na query".pg_last_error($connect));
          while($row_classe=pg_fetch_array($result)){
	  ?>
		<option value="<?php echo $row_classe[classe]?>" <?php if($row_classe[classe]==$row[classe]){echo "selected";}?>><?php echo $row_classe[classe]?></option>
		<?php
		}
		?>
        </select></td>
      <td class="fontebranca10"><input name="membros_brigada" type="text" id="membros_brigada" value="<?php echo $membros?>" size="30" <?php echo($leitura)?>></td>
      <td class="fontebranca10"><input name="numero_funcionarios" type="text" id="numero_funcionarios" onBlur="check_brigada(this);" value="<?php echo $row[numero_funcionarios]?>" size="5" <?php echo($leitura)?>/></td>
      <td class="fontebranca10">
        <?php
		if($row[cnae_id]!=""){

	 $query_cnae="select * from cnae where cnae_id='".$row[cnae_id]."'";
	 $result_cnae=pg_query($query_cnae)or die("Erro na query $query_cnae".pg_last_error($connect));
	 $row_cnae=pg_fetch_array($result_cnae);

	 $query_cont="select * from cipa where grupo='".$row_cnae[grupo_cipa]."'";
	 $result_cont=pg_query($query_cont)or die("Erro na consulta de contigente".pg_last_error($conect));
	while($row_cont=pg_fetch_array($result_cont)){

 		$numero=explode(" a ", $row_cont[numero_empregados]);
		if($row[numero_funcionarios]>$numero[0] && $numero[1]>$row[numero_funcionarios] || $row[numero_funcionarios]==$numero[0] || $row[numero_funcionarios]==$numero[1]){
			if($row_cont[numero_membros_cipa]>="19"){
		 		$menor=true;
				$efetivo_empregador=1;
				$suplente_empregador=0;
				$efetivo_empregado=0;
				$suplente_empregado=0;
			}else{
		 		$necessidade=$row_cont[numero_membros_cipa]+$row_cont[numero_representante_empregador]+$row_cont[suplente];
				$efetivo_empregador=$row_cont[numero_membros_cipa];
				$suplente_empregador=$row_cont[suplente];
				$efetivo_empregado=$row_cont[numero_membros_cipa];
				$suplente_empregado=$row_cont[suplente];
			}

		  }
 		}
}
$total1=$efetivo_empregador+$suplente_empregador;
$total2=$efetivo_empregado+$suplente_empregado;
?>
        <input name="num_rep" type="text" id="num_rep" value="<?php echo $total1." | ".$total2?>" size="15" style="text-align:center" <?php echo($leitura)?>></td>
    </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td class="fontebranca10">Tel Cont. Dir. </td>
      <td class="fontebranca10">Nome Cont. Dir.</td>
      <td class="fontebranca10">Cargo Cont. Dir </td>
      <td class="fontebranca10">Email Cont. Dir </td>
      <td class="fontebranca10">Skype Cont. Dir </td>
      <td class="fontebranca10">MSN Cont. Dir</td>
    </tr>
    <tr>
      <td class="fontebranca10"><input name="tel_contato_dir" type="text" id="tel_contato_dir" value="<?php if(!empty($tel_contato_dir)){ echo $tel_contato_dir;} else {echo $row[tel_contato_dir];}?>" size="10" maxlength="14" onKeyUp="fone(this);" <?php echo($leitura)?>></td>
      <td class="fontebranca10"><input name="nome_contato_dir" type="text" id="nome_contato_dir" value="<?php if($_GET[novo]){echo "Sr.(ª) ";};if(!empty($nome_contato_dir)){ echo $nome_contato_dir;} else {echo $row[nome_contato_dir];}?>" size="15" <?php echo($leitura)?>></td>
      <td class="fontebranca10"><input name="cargo_contato_dir" type="text" id="cargo_contato_dir" value="<?php if(!empty($cargo_contato_dir)){ echo $cargo_contato_dir;} else {echo $row[cargo_contato_dir];}?>" size="10" <?php echo($leitura)?>></td>
      <td class="fontebranca10"><input name="email_contato_dir" ondblClick="parent.location='mailto:<?php echo $row[email_contato_dir]?>';" type="text" id="email_contato_dir" value="<?php if(!empty($email_contato_dir)){ echo $email_contato_dir;} else {echo $row[email_contato_dir];}?>" size="10" <?php echo($leitura)?>></td>
      <td class="fontebranca10"><input name="skype_contato_dir" type="text" id="skype_contato_dir" value="<?php if(!empty($skype_contato_dir)){ echo $skype_contato_dir;} else {echo $row[skype_contato_dir];}?>" size="10" <?php echo($leitura)?>></td>
      <td class="fontebranca10"><input name="msn_contato_dir" type="text" id="msn_contato_dir" ondblClick="parent.location='mailto:<?php echo $row[msn_contato_dir]?>';" value="<?php if(!empty($msn_contato_dir)){ echo $msn_contato_dir;} else {echo $row[msn_contato_dir];}?>" size="10" <?php echo($leitura)?>></td>
    </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td class="fontebranca10">Nextel Cont. Dir</td>
      <td class="fontebranca10">ID. Nextel</td>
      <td class="fontebranca10">Escritório Cont. </td>
      <td class="fontebranca10">Tel Contador </td>
      <td class="fontebranca10">Email Contador </td>
      <td class="fontebranca10">Skype Contador </td>
      <td class="fontebranca10">Nome Contador </td>
    </tr>
    <tr>
      <td class="fontebranca10"><input name="nextel_contato_dir" type="text" id="nextel_contato_dir" value="<?php if(!empty($nextel_contato_dir)){ echo $nextel_contato_dir;} else {echo $row[nextel_contato_dir];}?>" size="10" maxlength="14" onKeyUp="fone(this);" <?php echo($leitura)?>></td>
      <td class="fontebranca10"><input name="nextel_id_contato_dir" type="text" id="id_contato_dir" value="<?php if(!empty($nextel_id_contato_dir)){ echo $nextel_id_contato_dir;} else {echo $row[nextel_id_contato_dir];}?>" size="5" <?php echo($leitura)?>></td>
      <td class="fontebranca10"><input name="escritorio_contador" type="text" id="escritorio_contador" value="<?php if(!empty($escritorio_contador)){ echo $escritorio_contador;} else {echo $row[escritorio_contador];}?>" size="10" <?php echo($leitura)?>></td>
      <td class="fontebranca10"><input name="tel_contador" type="text" id="tel_contador" value="<?php if(!empty($tel_contador)){ echo $tel_contador;} else {echo $row[tel_contador];}?>" size="10" maxlength="14" onKeyUp="fone(this);" <?php echo($leitura)?>></td>
      <td class="fontebranca10"><input name="email_contador" ondblClick="parent.location='mailto:<?php echo $row[email_contador]?>';" type="text" id="email_contador" value="<?php if(!empty($email_contador)){ echo $email_contador;} else {echo $row[email_contador];}?>" size="10" <?php echo($leitura)?>></td>
      <td class="fontebranca10"><input name="skype_contador" type="text" id="skype_contador" value="<?php if(!empty($skype_contador)){ echo $skype_contador;} else {echo $row[skype_contador];}?>" size="10" <?php echo($leitura)?>></td>
      <td class="fontebranca10"> <input name="nome_contador" type="text" id="nome_contador" value="<?php if($_GET[novo]){echo "Sr.(ª) ";};if(!empty($nome_contador)){ echo $nome_contador;} else {echo $row[nome_contador];}?>" <?php echo($leitura)?> size="8"></td>
    </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td class="fontebranca10">Nome Cont Ind. </td>
      <td class="fontebranca10">Email Cont. Ind. </td>
      <td class="fontebranca10">Cargo Cont. Ind </td>
      <td class="fontebranca10"> Tel Cont. Ind </td>
      <td class="fontebranca10">Skype Cont. Ind </td>
      <td class="fontebranca10">Vendedor </td>
	  <!--<td class="fontebranca10">Contratante</td>-->
    </tr>
    <tr>
      <td class="fontebranca10"><input name="nome_cont_ind" type="text" id="nome_cont_ind" value="<?php if($_GET[novo]){echo "Sr.(ª) ";};if(!empty($nome_cont_ind)){ echo $nome_cont_ind;} else {echo $row[nome_cont_ind];}?>" <?php echo($leitura)?> size="10">
      <input name="valor" type="hidden" id="valor"></td>
      <td class="fontebranca10"><input name="email_cont_ind" ondblClick="parent.location='mailto:<?php echo $row[email_cont_ind]?>';" type="text" id="email_cont_ind" value="<?php if(!empty($email_cont_ind)){ echo $email_cont_ind;} else {echo $row[email_cont_ind];}?>" size="10" <?php echo($leitura)?>></td>
      <td class="fontebranca10"><input name="cargo_cont_ind" type="text" id="cargo_cont_ind" value="<?php if(!empty($cargo_cont_ind)){ echo $cargo_cont_ind;} else {echo $row[cargo_cont_ind];}?>" size="10" <?php echo($leitura)?>></td>
      <td class="fontebranca10"><input name="tel_cont_ind" type="text" id="tel_cont_ind" value="<?php if(!empty($tel_cont_ind)){ echo $tel_cont_ind;} else {echo $row[tel_cont_ind];}?>" size="10" maxlength="14" onKeyUp="fone(this);" <?php echo($leitura)?>></td>
      <td class="fontebranca10"><input name="skype_cont_ind" type="text" id="skype_cont_ind" value="<?php if(!empty($skype_cont_ind)){ echo $skype_cont_ind;} else {echo $row[skype_cont_ind];}?>" size="10" <?php echo($leitura)?>></td>

<?PHP
if($row[vendedor_id]){
    $sql = "SELECT * FROM funcionario WHERE funcionario_id = {$row[vendedor_id]}";
    $rf = pg_query($sql);
    $ff = pg_fetch_array($rf);
}

//print_r($ff);
if($row[contratante] != ""){
$cont = "SELECT * FROM funcionario WHERE funcionario_id = {$row[contratante]}";
$re = pg_query($cont);
$ro = pg_fetch_array($re);
}else{

}
?>
      <td class="fontebranca10"><input name="id_func_digitado" type="text" id="id_func_digitado" value="<?PHP echo $ff[nome];?>" size="30" <?php echo($leitura)?>></td>
	  <!--
      <td class="fontebranca10"><input name="contratante" type="text" id="contratante" value="<?php //echo $ro[nome];?>" size="30" <?php //echo($leitura)?>></td>
      -->
    </tr>
</table>
<BR>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td class="fontebranca10" valign=top align=center><a href="listagem.php"><img src="img/cadastro_cliente_verde_r21_c18.gif" alt="" name="cadastro_cliente_verde_r21_c18" width="41" height="58"  border="0" id="cadastro_cliente_verde_r21_c18" /></a></td>

<?php if ($grupo=="administrador"){?>
     <td class="fontebranca10" valign=top align=center>
	  		<input name="novo" type="image" id="novo" src="img/cadastro_cliente_verde_r22_c3.gif" width="53" height="37" border="0" onClick="valore('novo');"/>
	  </td>
	 <td class="fontebranca10" valign=top align=center>
     <a href="http://www.receita.fazenda.gov.br/PessoaJuridica/CNPJ/cnpjreva/Cnpjreva_Solicitacao.asp" target="_blank"><img src="img/receitafederal.jpg" width="63" height="37" border="0"></a>
     </td>
	  		
      <!--
      <td class="fontebranca10" valign=top align=center><input name="novofl" type="image" id="novofl" src="img/icone_novafilial.gif" onClick="valore('novofl');">
	  </td>
      -->
      
      <td class="fontebranca10" valign=top align=center><input name="procura" type="image" id="procura" src="img/localizar.gif" onClick="window.open('find_client.php', 'procura', 'status , scrollbars=yes ,width=300, height=350');">
	  </td>


      <td class="fontebranca10" valign=top align=center><input type="image" name="apagar" src="img/cadastro_cliente_verde_r22_c5.gif" width="52" height="37" onClick="valore('apagar');" />
	  </td>
      <td class="fontebranca10" valign=top align=center><input name="gravar" type="image" id="gravar" value="gravar" src="img/icones_gravar.gif" width="52" height="37" onClick="valore('gravar');" hspace="1">
      </td>
<?php } else { echo "&nbsp;";}?>
      <td class="fontebranca10" valign=top align=center>
      <input type=button value='Funcionários' style="width:100px; height:30px;" onClick="javascript:location.href='relacao_de_funcionarios/?cod_cliente=<?PHP echo $_GET['cliente_id'];?>&cod_filial=<?PHP echo $_GET['filial_id'];?>';">
 	  </td>
 	  <td class="fontebranca10" valign=top align=center>
<?php
        if($_GET[cliente_id]){
            $sql = "SELECT * FROM site_gerar_contrato
            WHERE
            cod_cliente = $_GET[cliente_id]";
            $r = pg_query($sql);
            $buffer = pg_fetch_array($r);
        }
        
        if(@pg_num_rows($r)>0 && $_GET[cliente_id]){
            echo "<input type=button value='Resumo Contrato' style=\"width:100px; height:30px;\" onclick=\"javascript:location.href='adm_contratos/?action=propriedade_de_contrato&cod_cliente=".$_GET['cliente_id']."';\">";
        }else{
            echo "<input type=button value='Resumo Contrato' style=\"width:100px; height:30px;\" onclick=\"javascript:alert('Este cliente não possui contrato online!');\">";
        }
?>
 	  </td>
      <td class="fontebranca10" valign=top align=center>
      <input type=button value='Certificado' style="width:100px; height:30px;" onClick="javascript:location.href='treinamento/cert_empresa.php?cod_cliente=<?PHP echo $_GET['cliente_id'];?>';">
 	  </td>
    </tr>
  </table>
</form>
</body>
</html>
