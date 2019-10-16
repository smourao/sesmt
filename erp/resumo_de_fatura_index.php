<?php
session_start();
header("Content-Type: text/html; charset=ISO-8859-1",true);
include "../../sessao.php";
include "config/connect.php";
//SALVAR CONFIGURAÇÕES
if($_POST[saveconf]){
    $sql = "UPDATE site_config SET value = '$_POST[wovencimento]' WHERE key='erp_wovencimento'";
    pg_query($sql);
    $sql = "UPDATE site_config SET value = '$_POST[woemptyfatura]' WHERE key='erp_woemptyfatura'";
    pg_query($sql);
}
$sql = "SELECT value FROM site_config WHERE key = 'erp_wovencimento'";
$result = pg_query($sql);
$erp_wovencimento = pg_fetch_array($result);

$sql = "SELECT value FROM site_config WHERE key = 'erp_woemptyfatura'";
$result = pg_query($sql);
$erp_woemptyfatura = pg_fetch_array($result);

$meumes = date("m");

if($meumes<=1){
    $meumes = 12;
}else{
    $meumes -= 1;
}

if(!isset($_SESSION[mrf])){
    $_SESSION[mrf] = $meumes;//date("m", strtotime(mktime(0,0,0,date("m")-1, date("d"), date("Y"))));
}
if(!isset($_SESSION[yrf])){
    $_SESSION[yrf] = date("Y");
}

if(isset($_GET['m'])){
    $mes = $_GET['m'];
    $_SESSION[mrf] = $mes;
}else{
    if(isset($_SESSION[mrf])){
        $mes = $_SESSION[mrf];
    }else{
        $mes = $meumes;//date("m", strtotime(mktime(0,0,0,date("m")-1, date("d"), date("Y"))));
    }
}
if(isset($_GET['y'])){
    $ano = $_GET['y'];
    $_SESSION[yrf] = $ano;
}else{
    if(isset($_SESSION[yrf])){
        $ano = $_SESSION[yrf];
    }else{
        $ano = date("Y");
    }
}

$meses = array("", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho",
"Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");

if(!$_GET[order]){
	$sql = "SELECT * FROM site_fatura_info
                  WHERE
                  (
                  EXTRACT(month FROM data_criacao) = {$mes}
                  AND
                  EXTRACT(year FROM data_criacao) = {$ano}
                  AND
                  data_emissao is null";
                      if($erp_wovencimento[value]){
                          $sql .= " AND data_vencimento is not null ";
                      }
                  $sql .= "
                  )OR(
                  EXTRACT(month FROM data_emissao) = {$mes}
                  AND
                  EXTRACT(year FROM data_emissao) = {$ano}";
                      if($erp_wovencimento[value]){
                          $sql .= " AND data_vencimento is not null ";
                      }
                  $sql .= ")";

	$sql .= " ORDER BY data_vencimento ASC, cod_fatura ASC, data_criacao ASC";
    $result_cli = pg_query($sql);
}elseif($_GET[order]=='cod_cliente'){
	$sql = "SELECT * FROM site_fatura_info
                  WHERE
                  (
                  EXTRACT(month FROM data_criacao) = {$mes}
                  AND
                  EXTRACT(year FROM data_criacao) = {$ano}
                  AND
                  data_emissao is null";
                      if($erp_wovencimento[value]){
                          $sql .= " AND data_vencimento is not null ";
                      }
                  $sql .= "
                  )OR(
                  EXTRACT(month FROM data_emissao) = {$mes}
                  AND
                  EXTRACT(year FROM data_emissao) = {$ano}";
                      if($erp_wovencimento[value]){
                          $sql .= " AND data_vencimento is not null ";
                      }
                  $sql .= ")";
	$sql .= "ORDER BY cod_cliente ASC, data_vencimento ASC, data_criacao ASC";
    $result_cli = pg_query($sql);
}
?>
<html>
<head>
<title>Resumo de Fatura</title>
<link href="css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="res_fat.js"></script>
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
<center><h2> SESMT - Segurança do Trabalho </h2></center>
<p>&nbsp;</p>
<table width="700" border="2" align="center" cellpadding="0" cellspacing="0">
    <tr>
    	<th colspan="7" class="linhatopodiresq" bgcolor="#009966"><br>TELA DE CRIAÇÃO DE RESUMO DE FATURA<br>&nbsp;</th>
    </tr>
    <tr>
		<tr>
			<th bgcolor="#009966" colspan="7">
			<br>&nbsp;
               <input name="btn_sair" type="button" id="btn_sair" onClick="location.href='../index.php#financeiro';" value="Sair" style="width:100;">
               <input name="btnReg" type="button" id="btnReg" onClick="location.href='cadastro_propaganda_fatura.php';" value="Cadastro de Propaganda">
			<br>&nbsp;
			</th>
		</tr>
	</tr>
	<tr>
      <td height="26" colspan="7" class="linhatopodiresq">
<!--	  <form action="lista_orcamento.php" method="post" enctype="multipart/form-data" name="form1">-->
	  <br>
      <table width="500" border="0" align="center">
        <tr>
         <form action="javascript:select_cliente('<?php echo $mes;?>','<?php echo $ano;?>');">
          <td width="25%" align=right><strong>Razão Social:</strong></td>
          <td width="50%" align=center><input name="cliente" id="cliente" type="text" size="30" style="background:#FFFFCC"></td>
          <td width="25%" align=left><input type="button" onclick="select_cliente('<?php echo $mes;?>','<?php echo $ano;?>');" name="Submit" value="Pesquisar" class="inputButton" style="width:100;"></td>
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
      
<!--      </form>-->
	 </td>
    </tr>
  <tr>
    <th colspan="7" class="linhatopodiresq" bgcolor="#009966">
      <h3>Lista de Resumos de Fatura Geradas</h3>
<?PHP
      echo "<table width=250 border=1 cellspacing=0 cellpadding=0 align=center>";
      echo "<tr>";
      echo "<td colspan=2 class=fontebranca12 align=center style=\"cursor: pointer;\" onclick=\"if(document.getElementById('conf').style.display == 'none'){document.getElementById('conf').style.display = 'block';}else{document.getElementById('conf').style.display = 'none';}\"><b>Configurações</b></td>";
      echo "</tr>";
      echo "</table>";
      echo "<div align=center id=conf style=\"display: none;\">";
      echo "<form method=post>";
      echo "<table width=250 border=1 cellspacing=0 cellpadding=0 align=center>";
      echo "<tr>";
      echo "<td class=fontebranca12>Ocultar faturas sem vencimento: </td><td><input type=checkbox name=wovencimento id=wovencimento "; if($erp_wovencimento[value]){echo " checked ";}else{}  echo " ></td>";
      echo "</tr>";
      /*
      echo "<tr>";
      echo "<td class=fontebranca12>Ocultar faturas sem produto: </td><td><input type=checkbox name=woemptyfatura id=woemptyfatura "; if($erp_woemptyfatura[value]){echo " checked ";}else{}  echo " ></td>";
      echo "</tr>";
      */
      echo "<tr>";
      echo "<td class=fontebranca12 colspan=2 align=center><input type=submit value='Salvar' name='saveconf'></td>";
      echo "</tr>";
      echo "</table>";
      echo "</form>";
      echo "</div>";
      echo "<BR>";

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


   echo "<center><font size=2><a href=\"javascript:location.href='?m=$p_mes&y=$p_ano'\" class=fontebranca12><<</a>  <b>".$meses[ltrim($mes, "0")]."/{$ano}</b>  <a href=\"javascript:location.href='?m=$n_mes&y=$n_ano'\"  class=fontebranca12>>></a></font>    </center>";
?>
   <br>
    </th>
  </tr>
  <tr>
    <td width="5%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong><a href='?order' class="fontebranca12"><b>Nº Fatura</b></a></strong></div></td>

    <td width="5%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong><a href='?order=cod_cliente' class="fontebranca12"><b>Cód Cliente</b></a></strong></div></td>

    <td width="34%" colspan=2 bgcolor="#009966" class="linhatopodiresq"><div align="center" class="fontebranca12"><strong>Razão Social
	</strong></div></td>

    <td width="12%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Vencimento</strong></div></td>
    
    <!--
    <td width="12%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Data Criação</strong></div></td>
    -->
    <td width="5%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Visualizar</strong></div></td>
    
    <td width="5%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Enviado</strong></div></td>
  </tr>
<?php
  while($row=pg_fetch_array($result_cli)){
  if($row[pc]){
      if($row['cod_filial']){
         $sql = "SELECT * FROM cliente_pc WHERE cliente_id = {$row['cod_cliente']} AND filial_id={$row['cod_filial']}";
      }else{
         $sql = "SELECT * FROM cliente_pc WHERE cliente_id = {$row['cod_cliente']}";
      }
  }else{
      if($row['cod_filial']){
         $sql = "SELECT * FROM cliente WHERE cliente_id = {$row['cod_cliente']} AND filial_id={$row['cod_filial']}";
      }else{
         $sql = "SELECT * FROM cliente WHERE cliente_id = {$row['cod_cliente']}";
      }
  }
  $result = pg_query($sql);
  $cd = pg_fetch_array($result);

  $sql = "SELECT valor FROM site_fatura_produto WHERE cod_fatura = '{$row[cod_fatura]}' ORDER BY valor";
  $rprod = pg_query($sql);
  $items = pg_fetch_all($rprod);


  if(/*$erp_woemptyfatura[value] &&*/ (pg_num_rows($rprod)<=0 || (pg_num_rows($rprod)==2 && in_array('4.00', $items[0]) && in_array('6.50', $items[1])))){
      //break;
  }else{
?>
  <tr>
    <td class="linhatopodiresq">
	  <div align="center" class="linksistema">
	   <a href="cria_resumo_de_fatura.php?act=edit&cod_cliente=<?php echo $row['cod_cliente']?>&cod_filial=<?php echo $row['cod_filial']?>&fatura=<?php echo $row['cod_fatura']?>&pc=<?php echo $row['pc']?>">
       &nbsp;<?php echo str_pad($row['cod_fatura'], 3, "0", ST_PAD_LEFT)."/".substr($row['data_criacao'], 0, 4);?></a>
	  </div>
	</td>
	
   <td class="linhatopodiresq">
	  <div align="center" class="linksistema">
	   <a href="cria_resumo_de_fatura.php?act=edit&cod_cliente=<?php echo $row['cod_cliente']?>&cod_filial=<?php echo $row['cod_filial']?>&fatura=<?php echo $row['cod_fatura']?>&pc=<?php echo $row['pc']?>">
       &nbsp;<?php echo str_pad($cd['cliente_id'], 4, "0", ST_PAD_LEFT);?></a>
	  </div>
	</td>

<?PHP
    //Verificar parcela, exibir notificação caso seja última e não haja parcelas a frente
    $pv = explode("/", $row['parcela']);
    if($pv[0] == $pv[1] && $pv[0] != 1){
        $sql = "SELECT * FROM site_fatura_info
        WHERE cod_cliente = $row[cod_cliente]
        AND
        cod_filial = $row[cod_filial]
        AND
        cod_fatura > $row[cod_fatura]";
        $rpv = pg_query($sql);
        if(pg_num_rows($rpv)>0){
            $bgcolor = "";
            $nicon = "";
        }else{
            $bgcolor = " bgcolor='#d75757' ";
            if($pv[0]==12){
                $nicon = " - <a href='#' onclick=\"if(confirm('Esta ação criará as próximas 12 faturas para este cliente, iniciando no mês subsequente à está fatura. Confirmar ação?','')){alert('Executar ação se confirmado!!!');}\"><img src='../../images/red_plus.gif' border=0 title='Gerar as próximas 12 faturas para este cliente.' alt='Gerar as próximas 12 faturas para este cliente.' ></a>";
            }
        }
    }else{
            $bgcolor = "";
            $nicon = "";
    }
?>
    <td colspan=2 class="linhatopodiresq" <?PHP echo $bgcolor;?>
	  <div align="left" class="linksistema">
	   <a href="cria_resumo_de_fatura.php?act=edit&cod_cliente=<?php echo $row['cod_cliente']?>&cod_filial=<?php echo $row['cod_filial']?>&fatura=<?php echo $row['cod_fatura']?>&pc=<?php echo $row['pc']?>" style="color: #FFFFFF;font-size: 12px;">
       <b>&nbsp;<?php if($row[pc]){ echo "[PC] "; } echo $cd['razao_social'];
       if($row[cod_cliente] == "147"){
          echo " UPV";
       }elseif($row[cod_cliente] == "148"){
          echo " UQMI";
       }elseif($row[cod_cliente] == "149"){
          echo " UQMII";
       }
       echo " - ".$row['parcela'].$nicon;?></b></a>
	  </div>
	</td>

    <td class="linhatopodiresq">
	  <div align="center" class="linksistema">
	   <a href="cria_resumo_de_fatura.php?act=edit&cod_cliente=<?php echo $row['cod_cliente']?>&cod_filial=<?php echo $row['cod_filial']?>&fatura=<?php echo $row['cod_fatura']?>&pc=<?php echo $row['pc']?>">
       <?php
       if($row['data_vencimento']){
           echo date("d/m/Y", strtotime($row['data_vencimento']));
       }else{
           echo "<font size=1 color=white>*Pendente data de vencimento</font>";
       }

       ?><br>
       <?php //if(!$row['data_emissao']){echo "<font size=1 color=white>*Pendente data de emissão</font>";}?></a>
	  </div>
	</td>
    <!--
    <td class="linhatopodiresq">
	  <div align="center" class="linksistema">
	   <a href="cria_resumo_de_fatura.php?act=edit&cod_cliente=<?php echo $row['cod_cliente']?>&cod_filial=<?php echo $row['cod_filial']?>&fatura=<?php echo $row['cod_fatura']?>&pc=<?php echo $row['pc']?>">
       <?php echo date("d/m/Y", strtotime($row['data_criacao']));?><br>
       <?php if(!$row['data_emissao']){echo "<font size=1 color=white>*Pendente data de emissão</font>";}?></a>
	  </div>
	</td>
	-->

     <td class="linhatopodiresq">
	  <div align="center" class="linksistema">
	   <a href="cria_resumo_de_fatura.php?act=preview&cod_cliente=<?php echo $row['cod_cliente']?>&cod_filial=<?php echo $row['cod_filial']?>&fatura=<?php echo $row['cod_fatura']?>&pc=<?php echo $row['pc']?>">
       &nbsp;Visualizar</a>
	  </div>
	</td>
	
     <td class="linhatopodiresq">
	  <div align="center" class="linksistema">
        <font size=2><?PHP if($row['email_enviado']){echo date("d/m/Y", strtotime($row['data_envio_email']));}else{echo "&nbsp;";}?></font>
	  </div>
	</td>
  </tr>
<?php
 }
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
  </tr>
</table>
<?PHP
   echo "<center><font size=2><a href=\"javascript:location.href='?m=$p_mes&y=$p_ano'\" class=fontebranca12><<</a>  <b>".$meses[ltrim($mes, "0")]."/{$ano}</b>  <a href=\"javascript:location.href='?m=$n_mes&y=$n_ano'\"  class=fontebranca12>>></a></font></center>";
?>
<br>
</body>
</html>
