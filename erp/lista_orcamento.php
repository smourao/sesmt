<?php
include "sessao.php";
include "./config/connect.php";
include "./config/config.php";
include "./config/funcoes.php";

$meses = array("", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho",
"Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");

// CONFIGURAÇÃO MESES E ANOS
if(!isset($_SESSION[morc])){
    $_SESSION[morc] = date("m");
}
if(!isset($_SESSION[yos])){
    $_SESSION[yos] = date("Y");
}
if(isset($_GET['m'])){
    $mes = $_GET['m'];
    $_SESSION[morc] = $mes;
}else{
    if(isset($_SESSION[morc])){
        $mes = $_SESSION[morc];
    }else{
        $mes = date("m");
    }
}
if(isset($_GET['y'])){
    $ano = $_GET['y'];
    $_SESSION[yorc] = $ano;
}else{
    if(isset($_SESSION[yorc])){
        $ano = $_SESSION[yorc];
    }else{
        $ano = date("Y");
    }
}

   if($mes >= 12){
      $n_mes = 01;
      $n_ano = $ano+1;
      $p_mes = $mes-1;
      $p_ano = $ano;
   }elseif($mes <= 01){
     $n_mes = $mes+1;
     $n_ano = $ano;
     $p_mes = 12;
     $p_ano = $ano-1;
   }else{
      $n_mes = STR_PAD($mes+1, 2, "0", STR_PAD_LEFT);
      $n_ano = $ano;
      $p_mes = STR_PAD($mes-1, 2, "0", STR_PAD_LEFT);
      $p_ano = $ano;
   }

   $p_ano = STR_PAD($p_ano, 2, "0", STR_PAD_LEFT);
   $p_mes = STR_PAD($p_mes, 2, "0", STR_PAD_LEFT);
   $n_ano = STR_PAD($n_ano, 2, "0", STR_PAD_LEFT);
   $n_mes = STR_PAD($n_mes, 2, "0", STR_PAD_LEFT);
   

function convertwords($text){
$siglas = array("ppp", "ppra", "pcmso", "aso", "cipa", "apgre", "ltcat", "epi", "me", "av", "rj", //Siglas normais
				"ppp,", "ppra,", "pcmso,", "aso,", "cipa,", "apgre,", "ltcat,", "epi,", "me,", "av,", //Siglas com vírgula
				"(ppp)", "(ppra)", "(pcmso)", "(aso)", "(cipa)", "(apgre)", "(ltcat)", "(epi)", "(me)", "(av)", //Siglas entre parênteses
				"nr", "nr.", "mr", "mr.", "in", "in.", "nbr", "nbr.", "me.", "av.", "a0", "a3", "a4", "(a4)"); //Siglas diversas
$at = explode(" ", $text);
$temp = "";
for($x=0;$x<count($at);$x++){
   $at[$x] = strtolower($at[$x]);
   $at[$x] = strtr(strtolower($at[$x]),"ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß","àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ");

  if(in_array($at[$x], $siglas)){
     $at[$x] = strtoupper($at[$x]);
  }elseif(strlen($at[$x])>2){
        $at[$x] = ucwords($at[$x]);
    }
	$temp .= $at[$x]." ";
}

return $temp;
}

switch($grupo){ // "$grupo" é a variável global de sessão, criada no "auth.php"

	case "administrador":
		if($cliente==''){
			$query_cli = "SELECT cc.*, cod_orcamento, cliente_id, razao_social
						  FROM cliente_comercial cc, orcamento o
						  WHERE cc.cliente_id=o.cod_cliente
						  and razao_social=razao_social
                          AND
                          EXTRACT(month FROM o.data) = '$mes'
                          AND
                          EXTRACT(year FROM o.data) = '$ano'
                          order by cliente_id, cod_orcamento";
		}
		else
		{
			$query_cli = "SELECT cc.*, cod_orcamento, cliente_id, razao_social
						  FROM cliente_comercial cc, orcamento o
						  WHERE cc.cliente_id=o.cod_cliente
						  and lower(razao_social) like '%".strtolower(addslashes($cliente))."%'";
		}
	break;

	case "cliente":
	$query_cli.="where cliente_id=".$cliente."";
	break;

	case "funcionario":
		if($razao!=''){
			$query_cli = "SELECT cc.*, cod_orcamento, cliente_id, razao_social
						  FROM cliente_comercial cc, orcamento o
						  WHERE cc.cliente_id=o.cod_cliente
						  and lower(razao_social) like '%".strtolower(addslashes($cliente))."%'";
		}
	break;

	case "vendedor":
	if ($razao==''){
		$query_cli = "SELECT cc.*, cod_orcamento, cliente_id, razao_social
					  FROM cliente_comercial cc, orcamento o, funcionario f
					  WHERE cc.cliente_id=o.cod_cliente
					  AND f.funcionario_id = cc.funcionario_id
					  AND f.funcionario_id = '{$_SESSION['usuario_id']}'
					  and razao_social=razao_social
       AND
                          EXTRACT(month FROM o.data) = '$mes'
                          AND
                          EXTRACT(year FROM o.data) = '$ano'
                      order by cliente_id, cod_orcamento";
		}
	else
		{
		$query_cli = "SELECT cc.*, cod_orcamento, cliente_id, razao_social
					  FROM cliente_comercial cc, orcamento o, funcionario f
					  WHERE cc.cliente_id=o.cod_cliente
					  AND f.funcionario_id = cc.funcionario_id
					  AND f.funcionario_id = '{$_SESSION['usuario_id']}'
					  and lower(razao_social) like '%".strtolower(addslashes($cliente))."%'";

		}
	break;
	
		case "autonomo":
	if ($razao==''){
		$query_cli = "SELECT cc.*, cod_orcamento, cliente_id, razao_social
					  FROM cliente_comercial cc, orcamento o, funcionario f
					  WHERE cc.cliente_id=o.cod_cliente
					  AND f.funcionario_id = cc.funcionario_id
					  AND f.funcionario_id = '{$_SESSION['usuario_id']}'
					  and razao_social=razao_social
                      AND
                          EXTRACT(month FROM o.data) = '$mes'
                          AND
                          EXTRACT(year FROM o.data) = '$ano'
                      order by cliente_id, cod_orcamento";
		}
	else
		{
		$query_cli = "SELECT cc.*, cod_orcamento, cliente_id, razao_social
					  FROM cliente_comercial cc, orcamento o, funcionario f
					  WHERE cc.cliente_id=o.cod_cliente
					  AND f.funcionario_id = cc.funcionario_id
					  AND f.funcionario_id = '{$_SESSION['usuario_id']}'
					  and lower(razao_social) like '%".strtolower(addslashes($cliente))."%'";

		}
	break;

	default:
	//header("location: index.php");
	break;
}

?>
<html>
<head>
<title>Orçamento</title>
<link href="css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="scripts.js"></script>
<script language="javascript" src="js.js"></script>
<script language="javascript" src="screen.js"></script>

</head>

<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">
<p>
<center><h2> SESMT - Segurança do Trabalho </h2></center>
<p>&nbsp;</p>
<table width="70%" border="2" align="center" cellpadding="0" cellspacing="0">
    <tr>
    	<th colspan="5" class="linhatopodiresq" bgcolor="#009966"><br>TELA DE ORÇAMENTO<br>&nbsp;</th>
    </tr>
    <tr>
		<tr>
			<th bgcolor="#009966" colspan="5">
			<br>&nbsp;
				<input name="btn_sair" type="button" id="btn_sair" onClick="MM_goToURL('parent','./tela_principal.php'); return document.MM_returnValue" value="Sair" style="width:100;">
			<br>&nbsp;
			</th>
		</tr>
	</tr>
	<tr>
      <td height="26" colspan="5" class="linhatopodiresq">
	  <form action="lista_orcamento.php" method="post" enctype="multipart/form-data" name="form1">
	  <br>
      <table width="400" border="0" align="center">
        <tr>
          <td width="25%"><strong>Digite Sua Pesquisa:</strong></td>
          <td width="50%"><input name="cliente" type="text" size="30" style="background:#FFFFCC"></td>
          <td width="25%"><input type="submit" name="Submit" value="Pesquisar" class="inputButton" style="width:100;"></td>
        </tr>
      </table>
<?PHP
        echo "<BR>";
        echo "<center><font size=2><a href=\"javascript:location.href='?m=$p_mes&y=$p_ano'\" class=fontebranca12><<</a>  <b>".$meses[ltrim($mes, "0")]."/{$ano}</b>  <a href=\"javascript:location.href='?m=$n_mes&y=$n_ano'\"  class=fontebranca12>>></a></font>    </center>";
        echo "<br>";
?>
      </form>
	 </td>
    </tr>
  <tr>
    <th colspan="5" class="linhatopodiresq" bgcolor="#009966">
      <h3>Registros no Sistema</h3>
    </th>
  </tr>
  <tr>
    <td width="12%" bgcolor="#009966" class="linhatopodiresq"><div align="center" class="fontebranca12"><strong>Cód. Cliente
	</strong></div></td>
	<td width="10%" bgcolor="#009966" class="linhatopodiresq"><div align="center" class="fontebranca12"><strong>Orçamento
	</strong></div></td>
    <td bgcolor="#009966" class="linhatopodiresq"><div align="center" class="fontebranca12"><strong>Razão Social
	</strong></div></td>
	<td width="170" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Ações
	</strong></div></td>
  </tr>
<?php
$result_cli = pg_query($query_cli) or die
		("erro na query! ==> $query_cli" .pg_last_error($connect));

  while($row=pg_fetch_array($result_cli)){
  $fet = "<b>Responsável:</b> $row[nome_contato_dir]<BR>";
  $fet.= "<b>Endereço: </b> $row[endereco], $row[num_end]<BR>";
  $fet.= "<b>Bairro:</b> $row[bairro]<BR>";
  $fet.= "<b>Telefone:</b> $row[telefone]<BR>";
  if($row[nextel_contato_dir])
      $fet.= "<b>Nextel:</b> $row[nextel_contato_dir]<BR>";
  if($row[nextel_id_contato_dir])
      $fet.= "<b>Id:</b> $row[nextel_id_contato_dir]<BR>";

?>
  <tr>
    <td class="linhatopodiresq">
	  <div align="left" class="linksistema">
	   &nbsp;<a href="orcamento_simulador/cria_orcamento_simulador.php?act=preview&orcamento=<?php echo $row[cod_orcamento]?>&cod_cliente=<?php echo $row[cliente_id]?>&cod_filial=">&nbsp;<?php echo $row[cliente_id]?></a>
	   &nbsp;<a href="orcamento_pdf.php?cod_orcamento=<?php echo $row[cod_orcamento]?>&cliente_id=<?php echo $row[cliente_id]?>">[PDF]</a>
	  </div>
	</td>
	
	<td class="linhatopodiresq">
	  <div align="left" class="linksistema">
	   &nbsp;&nbsp;<a href="orcamento_simulador/cria_orcamento_simulador.php?act=preview&orcamento=<?php echo $row[cod_orcamento]?>&cod_cliente=<?php echo $row[cliente_id]?>&cod_filial=">&nbsp;<?php echo str_pad($row[cod_orcamento], 4, "0", 0);?></a>
	  </div>
	</td>
	
    <td class="linhatopodiresq">
	  <div align="left" class="linksistema">
	   &nbsp;&nbsp;<a href="orcamento_simulador/cria_orcamento_simulador.php?act=preview&orcamento=<?php echo $row[cod_orcamento]?>&cod_cliente=<?php echo $row[cliente_id]?>&cod_filial="  onMouseOver="return overlib('<?PHP echo $fet;?>');" onMouseOut="return nd();">&nbsp;<?php echo convertwords($row[razao_social]);?></a>
	  </div>
	</td>
	<td class="linhatopodiresq">
	  <div align="center" class="linksistema">
	  <input type=button value="Editar" onclick="location.href='orcamento_simulador/cria_orcamento_simulador.php?act=edit&orcamento=<?php echo $row[cod_orcamento]?>&cod_cliente=<?php echo $row[cliente_id]?>';">&nbsp;<input type=button value="Novo Orçamento" onclick="if(confirm('Tem certeza que deseja criar um novo orçamento?','')){location.href='orcamento_simulador/cria_orcamento_simulador.php?act=new&cod_filial=<?php echo $row[filial_id]?>&cod_cliente=<?php echo $row[cliente_id]?>';}">
	  </div>
	</td>
  </tr>
<?php
  }
  $fecha = pg_close($connect);
?>
  <tr>
    <td bgcolor="#009966" class="linhatopodiresqbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
  </tr>
</table>
<pre>






</pre>
</body>
</html>
