<?php
include "sessao.php";
//include "../sessao.php";
//include "../config/connect.php";
//include "../config/config.php";
//include "../config/funcoes.php";

include "config/connect.php";

   if($_SESSION['grupo'] == "administrador"){
	$query_cli = "SELECT * FROM site_orc_pc_info
				  WHERE vendedor_id <> 0 ORDER BY data_criacao DESC";
   }else{
   $query_cli = "SELECT * FROM site_orc_pc_info
				  WHERE vendedor_id <> 0  AND
                  vendedor_id = '{$_SESSION['usuario_id']}' ORDER BY data_criacao DESC";
   }

    $result_cli = pg_query($connect, $query_cli)
	or die ("Erro na cunsulta!==>$query_cli" .pg_last_error($connect));

?>
<html>
<head>
<title>Or�amento</title>
<link href="css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="orc_pc.js"></script>
<script language="javascript" src="scripts.js"></script>
</head>
<style>
#loading{
display: block;
position: relative;
left: 0px;
top: 60px;
width:0px;
height:0px;
color: #888000;
z-index:1;
}

#loading_done{
position: relative;
display: none;
}
</style>

<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">
<p>
<center><h2> SESMT - Seguran�a do Trabalho </h2></center>
<p>&nbsp;</p>
<table width="700" border="2" align="center" cellpadding="0" cellspacing="0">
    <tr>
    	<th colspan="8" class="linhatopodiresq" bgcolor="#009966"><br>TELA DE CRIA��O DE OR�AMENTO<br>&nbsp;</th>
    </tr>
    <tr>
		<tr>
			<th bgcolor="#009966" colspan="8">
			<br>&nbsp;
				<input name="btn_sair" type="button" id="btn_sair" onClick="MM_goToURL('parent','./tela_principal.php'); return document.MM_returnValue" value="Sair" style="width:100;">
			<br>&nbsp;
			</th>
		</tr>
	</tr>
	<tr>
      <td height="26" colspan="8" class="linhatopodiresq">
<!--	  <form action="lista_orcamento.php" method="post" enctype="multipart/form-data" name="form1">-->
	  <br>
      <table width="500" border="0" align="center">
        <tr>
         <form action="javascript:select_cliente();">
          <td width="25%" align=right><strong>Raz�o Social:</strong></td>
          <td width="50%" align=center><input name="cliente" id="cliente" type="text" size="30" style="background:#FFFFCC"></td>
          <td width="25%" align=left><input type="button" onclick="select_cliente();" name="Submit" value="Pesquisar" class="inputButton" style="width:100;"></td>
          </form>
        </tr>
      </table>
      
     <!-- CONTE�DO -->
     <table width="500" border="0" align="center">
        <tr>
          <td width="100%" align=right>
              <div id="lista_orcamentos">
              </div>
          </td>
        </tr>
     </table>
      
<!--      </form>-->
	 </td>
    </tr>
  <tr>
    <th colspan="8" class="linhatopodiresq" bgcolor="#009966">
      <h3>Lista de Or�amentos Gerados</h3>
    </th>
  </tr>
  <tr>

    <td width="12%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>N� Or�amento</strong></div></td>

    <td width="10%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>C�d Cliente</strong></div></td>

    <td width="34%" bgcolor="#009966" class="linhatopodiresq"><div align="center" class="fontebranca12"><strong>Raz�o Social
	</strong></div></td>

    <td width="12%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Valor</strong></div></td>


    <td width="12%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Data Cria��o</strong></div></td>

    <td width="20%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Vendedor</strong></div></td>

    <td width="10%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Visualizar</strong></div></td>
    
    <td width="5%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Enviado</strong></div></td>

  </tr>
<?php
  while($row=pg_fetch_array($result_cli)){
  if($row['cod_filial']){
     $sql = "SELECT * FROM cliente_pc WHERE cliente_id = {$row['cod_cliente']} AND filial_id={$row['cod_filial']}";
  }else{
     $sql = "SELECT * FROM cliente_pc WHERE cliente_id = {$row['cod_cliente']}";
  }
  $result = pg_query($sql);
  $cd = pg_fetch_array($result);
  
  $sql = "SELECT * FROM funcionario WHERE funcionario_id = {$row['vendedor_id']}";
  $result = pg_query($sql);
  $fun = pg_fetch_array($result);
  
//  $sql = "SELECT * FROM site_orc_produto WHERE cod_orcamento={$row['cod_orcamento']}";
  $sql = "SELECT op.*, p.preco_prod, p.desc_detalhada_prod, p.desc_resumida_prod, p.cod_atividade
FROM site_orc_pc_produto op, produto p
WHERE op.cod_orcamento={$row['cod_orcamento']} AND (p.cod_prod = op.cod_produto)";

  $r = pg_query($sql);
  $items = pg_fetch_all($r);
  $in = pg_num_rows($r);
  $total=0;

  for($x=0;$x<$in;$x++){
     if(!empty($items[$x][preco_aprovado])){
         $items[$x]['preco_prod'] = $items[$x][preco_aprovado];
     }
     $total = $total + ($items[$x]['quantidade']*$items[$x]['preco_prod']);
  }
?>
  <tr>
    <td class="linhatopodiresq">
	  <div align="center" class="linksistema">
	   <a href="cria_orcamento_pc.php?act=edit&cod_cliente=<?php echo $row['cod_cliente']?>&cod_filial=<?php echo $row['cod_filial']?>&orcamento=<?php echo $row['cod_orcamento']?>">
       &nbsp;<?php echo str_pad($row['cod_orcamento'], 3, "0", ST_PAD_LEFT)."/".substr($row['data_criacao'], 0, 4);?></a>
	  </div>
	</td>
	
   <td class="linhatopodiresq">
	  <div align="center" class="linksistema">
    <a href="cria_orcamento_pc.php?act=edit&cod_cliente=<?php echo $row['cod_cliente']?>&cod_filial=<?php echo $row['cod_filial']?>&orcamento=<?php echo $row['cod_orcamento']?>">
       &nbsp;<?php echo str_pad($cd['cliente_id'], 4, "0", ST_PAD_LEFT);?></a>
	  </div>
	</td>

    <td class="linhatopodiresq">
	  <div align="left" class="linksistema">
	   &nbsp;&nbsp;<a href="cria_orcamento_pc.php?act=edit&cod_cliente=<?php echo $row['cod_cliente']?>&cod_filial=<?php echo $row['cod_filial']?>&orcamento=<?php echo $row['cod_orcamento']?>">
       &nbsp;<?php echo $cd['razao_social']?></a>
	  </div>
	</td>
	
	    <td class="linhatopodiresq">
	  <div align="right" class="linksistema">
	   <a href="cria_orcamento_pc.php?act=edit&cod_cliente=<?php echo $row['cod_cliente']?>&cod_filial=<?php echo $row['cod_filial']?>&orcamento=<?php echo $row['cod_orcamento']?>">
       <?php echo "R$ ".number_format($total,2,",",".");?></a>
	  </div>
	</td>

	
    <td class="linhatopodiresq">
	  <div align="center" class="linksistema">
	  <a href="cria_orcamento_pc.php?act=edit&cod_cliente=<?php echo $row['cod_cliente']?>&cod_filial=<?php echo $row['cod_filial']?>&orcamento=<?php echo $row['cod_orcamento']?>">
       &nbsp;<?php echo date("d/m/Y", strtotime($row['data_criacao']));?></a>
	  </div>
	</td>

    <td class="linhatopodiresq">
	  <div align="center" class="linksistema">
	  <a href="cria_orcamento_pc.php?act=edit&cod_cliente=<?php echo $row['cod_cliente']?>&cod_filial=<?php echo $row['cod_filial']?>&orcamento=<?php echo $row['cod_orcamento']?>">
       &nbsp;<?php
        $nome = explode(" ", $fun['nome']);
        echo $nome[0]." ".$nome[1];

        ?></a>
	  </div>
	</td>

     <td class="linhatopodiresq">
	  <div align="center" class="linksistema">
	  <a href="cria_orcamento_pc.php?act=preview&cod_cliente=<?php echo $row['cod_cliente']?>&cod_filial=<?php echo $row['cod_filial']?>&orcamento=<?php echo $row['cod_orcamento']?>">
       &nbsp;Visualizar</a> <a href="orc_pdf.php?act=edit&cliente_id=<?php echo $row['cod_cliente']?>&cod_filial=<?php echo $row['cod_filial']?>&orcamento=<?php echo $row['cod_orcamento']?>"> PDF </a>
	  </div>
	</td>
	
	<td class="linhatopodiresq">
	  <div align="center" class="linksistema">
	  <a href="cria_orcamento_pc.php?act=preview&cod_cliente=<?php echo $row['cod_cliente']?>&cod_filial=<?php echo $row['cod_filial']?>&orcamento=<?php echo $row['cod_orcamento']?>">
      <?PHP print $row['orc_request_time_sended'] == 1 ? "Enviado" : "&nbsp;";?>
      </a>
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
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
  </tr>
</table>
</body>
</html>
