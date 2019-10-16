<?php
include "sessao.php";
include "config/connect.php";

$meses = array("", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho",
"Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");

// CONFIGURAÇÃO MESES E ANOS
if(!isset($_SESSION[morc])){
    $_SESSION[morc] = date("m");
}
if(!isset($_SESSION[yorc])){
    $_SESSION[yorc] = date("Y");
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
   
   
   if($_GET[status] >=0 && is_numeric($_GET[status])){
       if($_SESSION['grupo'] == "administrador"){
           if($_GET[status] == 0){
    	   $query_cli = "SELECT * FROM site_orc_info
    				  WHERE
                      vendedor_id <> 0
                      AND
                      aprovado <> 1
                      AND
                      aprovado <> 5
                      AND
                      EXTRACT(month FROM data_criacao) = '$mes'
                      AND
                      EXTRACT(year FROM data_criacao) = '$ano'
                      ORDER BY data_criacao DESC";
           }else{
           $query_cli = "SELECT * FROM site_orc_info
    				  WHERE vendedor_id <> 0 AND aprovado = ".(int)($_GET[status])."
                      AND
                      EXTRACT(month FROM data_criacao) = '$mes'
                      AND
                      EXTRACT(year FROM data_criacao) = '$ano'
                      ORDER BY data_criacao DESC";
           }
       }else{
           if($_GET[status] == 0){
           $query_cli = "SELECT * FROM site_orc_info
    				  WHERE vendedor_id <> 0  AND
                      vendedor_id = '{$_SESSION['usuario_id']}' AND aprovado <> 1 AND aprovado <> 5
                      AND
                      EXTRACT(month FROM data_criacao) = '$mes'
                      AND
                      EXTRACT(year FROM data_criacao) = '$ano'
                      ORDER BY data_criacao DESC";
          }else{
           $query_cli = "SELECT * FROM site_orc_info
    				  WHERE vendedor_id <> 0  AND
                      vendedor_id = '{$_SESSION['usuario_id']}' AND aprovado = ".(int)($_GET[status])."
                      AND
                      EXTRACT(month FROM data_criacao) = '$mes'
                      AND
                      EXTRACT(year FROM data_criacao) = '$ano'
                      ORDER BY data_criacao DESC";

          }
       }
   }else{
       if($_SESSION['grupo'] == "administrador"){
    	   $query_cli = "SELECT * FROM site_orc_info
    				  WHERE vendedor_id <> 0
                      AND
                      EXTRACT(month FROM data_criacao) = '$mes'
                      AND
                      EXTRACT(year FROM data_criacao) = '$ano'
                      ORDER BY data_criacao DESC";
       }else{
           $query_cli = "SELECT * FROM site_orc_info
    				  WHERE vendedor_id <> 0  AND
                      vendedor_id = '{$_SESSION['usuario_id']}'
                      AND
                      EXTRACT(month FROM data_criacao) = '$mes'
                      AND
                      EXTRACT(year FROM data_criacao) = '$ano'
                      ORDER BY data_criacao DESC";
       }
   }
   //echo $query_cli;
   $result_cli = pg_query($query_cli);
?>
<html>
<head>
<title>Orçamento</title>
<link href="css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="orc.js"></script>
<script language="javascript" src="scripts.js"></script>
<script language="javascript" src="ajax.js"></script>
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

<script language="javascript">
function set_aprovado(id, val){
    var url = "ajax_set_aprovado.php?id="+id;
    url = url + "&value=" + val;
    url = url + "&cache=" + new Date().getTime();
    http.open("GET", url, true);
    http.onreadystatechange = set_aprovado_reply;
    http.send(null);
}

function set_aprovado_reply(){
    if(http.readyState == 4)
    {
        var msg = http.responseText;
        alert(msg);
        if(msg == 1){
           alert('Situação alterada com sucesso!');
    	}else{
            alert('Erro ao alterar situação!');
    	}
    }else{
     if (http.readyState==1){

        }
    }
}
</script>

<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">
<p>
<center><h2> SESMT - Segurança do Trabalho </h2></center>
<p>&nbsp;</p>
<table width="700" border="2" align="center" cellpadding="0" cellspacing="0">
    <tr>
    	<th colspan="8" class="linhatopodiresq" bgcolor="#009966"><br>TELA DE CRIAÇÃO DE ORÇAMENTO<br>&nbsp;</th>
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
          <td width="25%" align=right><strong>Razão Social:</strong></td>
          <td width="50%" align=center><input name="cliente" id="cliente" type="text" size="30" style="background:#FFFFCC"></td>
          <td width="25%" align=left><input type="button" onclick="select_cliente();" name="Submit" value="Pesquisar" class="inputButton" style="width:100;"></td>
          </form>
        </tr>
      </table>
      
     <!-- CONTEÚDO -->
     <table width="500" border="0" align="center">
        <tr>
          <td width="100%" align=right>
              <div id="lista_orcamentos">
              </div>
          </td>
        </tr>
     </table>
     
     
     <br>
     <center><!--<a href='?action=list' class=fontebranca12><b>Todos</b></a> | --><a href='?status=0' class=fontebranca12><b>Aguardando</b></a> | <a href='?status=1' class=fontebranca12><b>Aprovados</b></a> | <a href='?status=5' class=fontebranca12><b>Cancelados</b></a></center>
     <br>
<?PHP
        echo "<BR>";
        echo "<center><font size=2><a href=\"javascript:location.href='?status=$_GET[status]&m=$p_mes&y=$p_ano'\" class=fontebranca12><<</a>  <b>".$meses[ltrim($mes, "0")]."/{$ano}</b>  <a href=\"javascript:location.href='?status=$_GET[status]&m=$n_mes&y=$n_ano'\"  class=fontebranca12>>></a></font>    </center>";
        echo "<br>";
?>

      
<!--      </form>-->
	 </td>
    </tr>
  <tr>
    <th colspan="8" class="linhatopodiresq" bgcolor="#009966">
      <h3>Lista de Orçamentos Gerados</h3>
    </th>
  </tr>
  <tr>

    <td width="12%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Nº Orçamento</strong></div></td>

    <td width="10%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Cód Cliente</strong></div></td>

    <td width="34%" bgcolor="#009966" class="linhatopodiresq"><div align="center" class="fontebranca12"><strong>Razão Social
	</strong></div></td>

    <td width="15%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Valor</strong></div></td>


    <td width="12%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Data Criação</strong></div></td>

    <!--
    <td width="20%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Vendedor</strong></div></td>
    -->
    <td width="20%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Status</strong></div></td>

    <td width="10%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Visualizar</strong></div></td>
    
    <td width="5%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Enviado</strong></div></td>

  </tr>
<?php
  while($row=pg_fetch_array($result_cli)){
  if($row['cod_filial']){
     $sql = "SELECT * FROM cliente WHERE cliente_id = {$row['cod_cliente']} AND filial_id={$row['cod_filial']}";
  }else{
     $sql = "SELECT * FROM cliente WHERE cliente_id = {$row['cod_cliente']}";
  }
  $result = pg_query($sql);
  $cd = pg_fetch_array($result);
  
  $sql = "SELECT * FROM funcionario WHERE funcionario_id = {$row['vendedor_id']}";
  $result = pg_query($sql);
  $fun = pg_fetch_array($result);
  
  $sql = "SELECT op.*, p.preco_prod, p.desc_detalhada_prod, p.desc_resumida_prod, p.cod_atividade
  FROM site_orc_produto op, produto p
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
	  <div align="center">
	   <a  class="fontebranca12" href="cria_orcamento.php?act=edit&cod_cliente=<?php echo $row['cod_cliente']?>&cod_filial=<?php echo $row['cod_filial']?>&orcamento=<?php echo $row['cod_orcamento']?>">
       &nbsp;<?php echo str_pad($row['cod_orcamento'], 3, "0", ST_PAD_LEFT)."/".substr($row['data_criacao'], 0, 4);?></a>
	  </div>
	</td>
	
   <td class="linhatopodiresq">
	  <div align="center">
    <a  class="fontebranca12" href="cria_orcamento.php?act=edit&cod_cliente=<?php echo $row['cod_cliente']?>&cod_filial=<?php echo $row['cod_filial']?>&orcamento=<?php echo $row['cod_orcamento']?>">
       &nbsp;<?php echo str_pad($cd['cliente_id'], 4, "0", ST_PAD_LEFT);?></a>
	  </div>
	</td>

    <td class="linhatopodiresq">
	  <div align="left" class="linksistema">
	   <a class="fontebranca12" href="cria_orcamento.php?act=edit&cod_cliente=<?php echo $row['cod_cliente']?>&cod_filial=<?php echo $row['cod_filial']?>&orcamento=<?php echo $row['cod_orcamento']?>">
       &nbsp;<?php echo $cd['razao_social']?></a>
	  </div>
	</td>
	
	    <td class="linhatopodiresq">
	  <div align="right">
	   <a class="fontebranca12" href="cria_orcamento.php?act=edit&cod_cliente=<?php echo $row['cod_cliente']?>&cod_filial=<?php echo $row['cod_filial']?>&orcamento=<?php echo $row['cod_orcamento']?>">
       <?php echo "R$ ".number_format($total,2,",",".");?></a>
	  </div>
	</td>

	
    <td class="linhatopodiresq">
	  <div align="center">
	  <a class="fontebranca12" href="cria_orcamento.php?act=edit&cod_cliente=<?php echo $row['cod_cliente']?>&cod_filial=<?php echo $row['cod_filial']?>&orcamento=<?php echo $row['cod_orcamento']?>">
       &nbsp;<?php echo date("d/m/Y", strtotime($row['data_criacao']));?></a>
	  </div>
	</td>
    <!--
    <td class="linhatopodiresq">
	  <div align="center">
	  <a class="fontebranca12" href="cria_orcamento.php?act=edit&cod_cliente=<?php echo $row['cod_cliente']?>&cod_filial=<?php echo $row['cod_filial']?>&orcamento=<?php echo $row['cod_orcamento']?>">
       &nbsp;<?php
        $nome = explode(" ", $fun['nome']);
        echo $nome[0]." ".$nome[1];
        ?></a>
	  </div>
	</td>
	-->
	<td class="linhatopodiresq">
	  <div align="center">
          <select id=status name=status onchange="set_aprovado(<?PHP echo $row[cod_orcamento];?>, this.value);">
              <option value='0' <?PHP if($row[aprovado]!=1 && $row[aprovado]!=5){ echo "selected ";}?>>Aguardando</option>
              <option value='1' <?PHP if($row[aprovado]==1){ echo "selected ";}?>>Aprovado</option>
              <option value='5' <?PHP if($row[aprovado]==5){ echo "selected ";}?>>Cancelado</option>
          </select>
	  </div>
	</td>

     <td class="linhatopodiresq">
	  <div align="center"  class="linksistema">
	  <a class="fontebranca12" href="cria_orcamento.php?act=preview&cod_cliente=<?php echo $row['cod_cliente']?>&cod_filial=<?php echo $row['cod_filial']?>&orcamento=<?php echo $row['cod_orcamento']?>">
       &nbsp;Visualizar</a> <a class="fontebranca12" href="orc_pdf.php?act=edit&cliente_id=<?php echo $row['cod_cliente']?>&cod_filial=<?php echo $row['cod_filial']?>&orcamento=<?php echo $row['cod_orcamento']?>"> PDF </a>
	  </div>
	</td>
	
	<td class="linhatopodiresq">
	  <div align="center">
	  <a class="fontebranca12" href="cria_orcamento.php?act=preview&cod_cliente=<?php echo $row['cod_cliente']?>&cod_filial=<?php echo $row['cod_filial']?>&orcamento=<?php echo $row['cod_orcamento']?>">
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
