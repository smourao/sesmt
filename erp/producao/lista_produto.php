<?php
include "../sessao.php";
include "../config/connect.php";

if(!$_GET[s])$_GET[s] = 0;
$s = $_GET[s];
$rpp = 100;



switch($grupo){ // "$grupo" é a variável global de sessão, criada no "auth.php"
	case "administrador":
		if($produto=='')// || $btn_voltar=='voltar')
		{
			$query_produto="select cod_prod, desc_detalhada_prod, desc_resumida_prod, preco_prod, cod_atividade from produto";
		}else
		{
			$query_produto="select cod_prod, desc_detalhada_prod, desc_resumida_prod, preco_prod, cod_atividade from produto 
							where lower(desc_detalhada_prod) like '%".strtolower(addslashes($produto))."%'
							or lower(desc_resumida_prod) like '%".strtolower(addslashes($produto))."%'";
		}
		$query_produto.=" order by cod_prod";
	break;
	case "cliente":
	    $query_produto.="where cliente_id=".$cliente_id."";
	break;
	case "funcionario":
		if($produto!=''){
			$query_produto="select cod_prod, desc_detalhada_prod,  preco_prod, desc_resumida_prod, cod_atividade from produto
							 where lower(desc_detalhada_prod) like '%".strtolower(addslashes($produto))."%'
		  					 or lower(desc_resumida_prod) like '%".strtolower(addslashes($produto))."%'";
		}
	break;
    case "vendedor":
		if($produto!=''){
			$query_produto="select cod_prod, desc_detalhada_prod, preco_prod, desc_resumida_prod, cod_atividade from produto
							 where lower(desc_detalhada_prod) like '%".strtolower(addslashes($produto))."%'
		  					 or lower(desc_resumida_prod) like '%".strtolower(addslashes($produto))."%'";
		}
	break;
	case "contador":
	     $query_produto.="where contador_id=".$contador_id."";
	break;
	default:
         //header("location: index.php");
	break;
}

$query_produto.=" LIMIT 100 OFFSET ".($s*$rpp);

?>
<html>
<head>
<title>Produto</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
</head>

<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">
<p>
<center><h2> SESMT - Segurança do Trabalho </h2></center>
<p>&nbsp;</p>
<table width="700" border="2" align="center" cellpadding="0" cellspacing="0">
    <tr>
    	<th colspan="5" class="linhatopodiresq" bgcolor="#009966"><br>TELA DE PRODUTOS<br>&nbsp;</th>
    </tr>
    <tr>
		<tr>
			<th bgcolor="#009966" colspan="5">
			<br>&nbsp;
			<?php 
				if($grupo=="administrador")
				{
			?>
				<input name="btn_novo" type="button" id="btn_novo" onClick="MM_goToURL('parent','cad_produto.php'); return document.MM_returnValue" value="Novo" style="width:100;">&nbsp;&nbsp;&nbsp;&nbsp;
			<?php 
				}
				else
				{
			?>
						&nbsp;
			<?php   } ?>
		
				<input name="btn_sair" type="button" id="btn_sair" onClick="MM_goToURL('parent','../tela_principal.php'); return document.MM_returnValue" value="Sair" style="width:100;">
			<br>&nbsp;
			</th>
		</tr>
	</tr>
	<tr>			
      <td height="26" colspan="5" class="linhatopodiresq">
	  <form action="lista_produto.php" method="post" enctype="multipart/form-data" name="form1">
	  <br>
      <table width="400" border="0" align="center">
        <tr>
          <td width="25%"><strong>Digite Sua Pesquisa:</strong></td>
		  <td width="50%">
		  <?php  
			if($grupo!="administrador")
			{ 
		  ?>
          <input name="produto" type="text" size="30" style="background:#FFFFCC">
		  <?php  
			}
			else
			{ 
			?>
			<input name="produto" type="text" size="30" style="background:#FFFFCC">
			<?php  
			}
 		  ?>
		  </td>
          <td width="25%"><input type="submit" name="Submit" value="Pesquisar" class="inputButton" style="width:100;"></td>
        </tr>
      </table>
      </form>
	 </td>
    </tr>
  <tr>
    <th colspan="5" class="linhatopodiresq" bgcolor="#009966">
      <h3>Registros no Sistema</h3>
    </th>
  </tr>
  <tr>
    <td width="5%" bgcolor="#009966" class="linhatopodiresq"><div align="center" class="fontebranca12"><strong>Cód. Produto
	</strong></div></td>
    <td width="39%" bgcolor="#009966" class="linhatopodiresq"><div align="center" class="fontebranca12"><strong>Desc. Detalhada
	</strong></div></td>
    <td width="34%" bgcolor="#009966" class="linhatopodiresq"><div align="center" class="fontebranca12"><strong>Desc. Resumida
	</strong></div></td>
    <td width="12%" bgcolor="#009966" class="linhatopodiresq"><div align="center" class="fontebranca12"><strong>Preço Unitário
	</strong></div></td>
    <td width="10%" bgcolor="#009966" class="linhatopodiresq"><div align="center" class="fontebranca12"><strong>Cód. da Atividade
	</strong></div></td>
  </tr>
<?php  
	if (!empty($query_produto))	{
	$result_produto=pg_query($query_produto);

    if(pg_num_rows($result_produto) > 0){
    $start = $_GET['s']*$rpp;
    if(pg_num_rows($result_produto) >= $start+$rpp){
       $end = ($start+$rpp);
    }else{
       $end = pg_num_rows($result_produto);
    }
    $row = pg_fetch_all($result_produto);
for($x=0;$x<pg_num_rows($result_produto);$x++){
?>
  <tr>
    <td class="linhatopodiresq">
	  <div align="center" class="linksistema">
	   <a href="cad_produto.php?id=<?php echo $row[$x][cod_prod]?>"><?php echo $row[$x][cod_prod]?></a>
	  </div>
	</td>
    <td class="linhatopodiresq">
	  <div align="left" class="linksistema">
	   &nbsp;<a href="cad_produto.php?id=<?php echo $row[$x][cod_prod]?>"><?php echo $row[$x][desc_detalhada_prod]?></a>
	  </div>
	</td>
    <td class="linhatopodiresq">
	  <div align="left" class="linksistema">
	   &nbsp;<a href="cad_produto.php?id=<?php echo $row[$x][cod_prod]?>"><?php echo $row[$x][desc_resumida_prod]?></a>
	  </div>
	</td>
    <td class="linhatopodiresq">
	  <div align="left" class="linksistema">
	   &nbsp;<a href="cad_produto.php?id=<?php echo $row[$x][cod_prod]?>">R$ <?php echo $row[$x][preco_prod]?></a>
	  </div>
	</td>
    <td class="linhatopodiresq">
	  <div align="center" class="linksistema">
	  <a href="cad_produto.php?id=<?php echo $row[$x][cod_prod]?>"><?php echo $row[$x][cod_atividade]?></a>
	  </div>
	</td>

  </tr>
<?php
 }
  }else{
	echo "<script>alert('Não foi encontrado o cógido digitado.');</script>";
  }
}
?>
  <tr>
    <td bgcolor="#009966" class="linhatopodiresqbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
  </tr>
</table>
<center>
<p>
<?PHP

if($result_produto){
$sql = "SELECT count(*) as n FROM produto";
$r = pg_query($sql);
$n = pg_fetch_array($r);
$n = $n[n];

if($n > $rpp){
   $pages = $n / $rpp;
}else{
   $pages = $n;
}

echo ' <div align="center" class="linksistema"><font size=1><b>Página:</b></font> ';
for($x=0;$x<$pages;$x++){
   if($_GET['s'] == ($x)){
      echo "<b>".($x+1)."</b> ";
   }else{
      echo "<a href='?s=".($x)."' class='linksistema fontbranca12'>".($x+1)."</a> ";
   }
}
}
echo "</div>";
?>
<p>
</center>
</body>
</html>
