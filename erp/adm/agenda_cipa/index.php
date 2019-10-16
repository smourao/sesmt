<?php
session_start();
header("Content-Type: text/html; charset=ISO-8859-1",true);
include "../../sessao.php";
include "../../config/connect.php";

if($_POST[nparticipantes]){
    if(is_numeric($_POST[nparticipantes])){
       $sql = "UPDATE agenda_cipa_config SET participantes = '{$_POST[nparticipantes]}'";
       pg_query($sql);
    }
}

$mes = date("n");
$ano = date("Y");
$tdias = date("t", mktime(0, 0, 0, $mes, 1, $ano));
$diah =  date("d");

function next_days($num_days){
   global $conn;
   $mes = date("n");
   $ano = date("Y");
   $tdias = date("t", mktime(0, 0, 0, $mes, 1, $ano));
   $diah =  date("d");
   $d = date("d");
   $dias = array();
   $sql = "SELECT participantes FROM agenda_cipa_config";
   $result = pg_query($sql);
   $config = pg_fetch_array($result);

       while(count($dias) < $num_days){
          if(date("w", mktime(0, 0, 0, $mes, $d, $ano)) == 1){
             $sql = "SELECT * FROM agenda_cipa_part WHERE data_realizacao = '".$ano."-".$mes."-".$d."'";
             $result = pg_query($sql);
             if(pg_num_rows($result)<$config[participantes]){
                $dias[] = $ano."/".$mes."/".$d;//date("d", mktime(0, 0, 0, $mes, $d, $ano));
             }
          }

          $d++;

          if($d > $tdias){
              //break;
              $d = 1;
              if($mes<=11){$mes++;}else{$mes=1;$ano++;}
              $tdias = date("t", mktime(0, 0, 0, $mes, 1, $ano));
          }
       }//end while
   return $dias;
}


if(!isset($_SESSION[m])){
    $_SESSION[m] = date("m");
}
if(!isset($_SESSION[y])){
    $_SESSION[y] = date("Y");
}

if(isset($_GET['m'])){
    $mes = $_GET['m'];
    $_SESSION[m] = $mes;
}else{
    if(isset($_SESSION[m])){
        $mes = $_SESSION[m];
    }else{
        $mes = date("m");
    }
}

if(isset($_GET['y'])){
    $ano = $_GET['y'];
    $_SESSION[y] = $ano;
}else{
    if(isset($_SESSION[y])){
        $ano = $_SESSION[y];
    }else{
        $ano = date("Y");
    }
}
$meses = array("", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho",
"Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");

   $sql = "SELECT participantes FROM agenda_cipa_config";
   $result = pg_query($sql);
   $config = pg_fetch_array($result);
?>
<html>
<head>
<title>Curso CIPA</title>
<link href="../../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../../scripts.js"></script>
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
    	<th colspan="7" class="linhatopodiresq" bgcolor="#009966"><br>ADMINISTRAÇÃO DE CURSO DE CIPA<br>&nbsp;</th>
    </tr>
    <tr>
		<tr>
			<th bgcolor="#009966" colspan="7">
			<br>&nbsp;
			<?PHP
			 if($_GET[id]){
			 echo "<input type=button value='Voltar'  style=\"width:100;\" onclick=\"location.href='index.php';\">";
			 }
			?>
                  <input name="btn_sair" type="button" id="btn_sair" onClick="location.href='../index.php#financeiro';" value="Sair" style="width:100;">
			<br>&nbsp;
			</th>
		</tr>
	</tr>

	<tr>
      <td colspan="7" class="linhatopodiresq">
      <!--
	  <br>
      <table width="500" border="0" align="center">
        <tr>
         <form action="javascript:select_cliente('<?php //echo $mes;?>','<?php //echo $ano;?>');">
          <td width="25%" align=right><strong>Razão Social:</strong></td>
          <td width="50%" align=center><input name="cliente" id="cliente" type="text" size="30" style="background:#FFFFCC"></td>
          <td width="25%" align=left><input type="button" onclick="select_cliente('<?php //echo $mes;?>','<?php //echo $ano;?>');" name="Submit" value="Pesquisar" class="inputButton" style="width:100;"></td>
          </form>
        </tr>
      </table>
      -->
      <br>
      <form method=post>
           Número Máximo de Participantes: <input type=text size=2 value="<?PHP echo $config[participantes];?>" name=nparticipantes> <input type=submit value='Alterar' style="width:100;">
      </form>
	 </td>
    </tr>

  <tr>
    <th colspan="7" class="linhatopodiresq" bgcolor="#009966">
<!--      <h3>Lista de Resumos de Fatura Geradas</h3>-->
<?PHP
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


   //echo "<center><font size=2><a href=\"javascript:location.href='?m=$p_mes&y=$p_ano'\" class=fontebranca12><<</a>  <b>".$meses[ltrim($mes, "0")]."/{$ano}</b>  <a href=\"javascript:location.href='?m=$n_mes&y=$n_ano'\"  class=fontebranca12>>></a></font>    </center>";
?>
   <br>
    </th>
  </tr>
  <tr>
    <td colspan=6 width="6%" bgcolor="#009966" class="linhatopodiresq">
    <?PHP
    if(!$_GET[id]){
        /*
        $dias = next_days(10);
        for($x=0;$x<count($dias);$x++){
           echo $dias[$x];
           echo "<BR>";
        }
        */
        $sql = "SELECT * FROM agenda_cipa_info";
        $result = pg_query($sql);
        $info = pg_fetch_all($result);

        echo "<table width=100% border=1>";
        echo "<tr>";
        echo "<td align=center width=50><b>Nº</b></td>";
        echo "<td align=center><b>Data Realização</b></td>";
        echo "<td align=center><b>Nº Participantes</b></td>";
        echo "<td align=center width=150><b>Detalhes</b></td>";
        echo "</tr>";

        
        for($x=0;$x<pg_num_rows($result);$x++){
            $sql = "SELECT * FROM agenda_cipa_part WHERE cod_cipa = '{$info[$x][id]}'";
            $res = pg_query($sql);
            echo "<tr>";
            echo "<td align=center>".($x+1)."</td>";
            echo "<td align=center>".date("d/m/Y", strtotime($info[$x][data_realizacao]))."</td>";
            echo "<td align=center>".pg_num_rows($res)."</td>";
            echo "<td align=center><a href='?id={$info[$x][id]}' style=\"color: #FFFFFF;\"><b>Visualizar</b></a></td>";
            echo "</tr>";
        }
        
         echo "</table>";
    }else{
        //echo "<center><input type=button value='Voltar'  style=\"width:100;\" onclick=\"location.href='index.php';\"></center>";
        //echo "<P>";
        $sql = "SELECT * FROM agenda_cipa_info WHERE id='{$_GET[id]}'";
        $result = pg_query($sql);
        $info = pg_fetch_all($result);

        echo "<table width=100% border=1>";
        echo "<tr>";
        echo "<td align=center width=40><b>Nº</b></td>";
        echo "<td align=center><b>Realização</b></td>";
        echo "<td align=center><b>Inscrição</b></td>";
        echo "<td align=center><b>Participante</b></td>";
        echo "<td align=center><b>Empresa</b></td>";
        echo "</tr>";

        $sql = "SELECT p.*, c.razao_social FROM agenda_cipa_part p, cliente c
        WHERE cod_cipa = '{$_GET[id]}'
        AND
        p.cod_cliente = c.cliente_id
        AND
        p.cod_filial = c.filial_id
        ORDER BY p.data_inscricao
        ";
        $res = pg_query($sql);
        $part = pg_fetch_all($res);
        for($x=0;$x<pg_num_rows($res);$x++){
            echo "<tr>";
            echo "<td class=fontebranca12 align=center><b>".($x+1)."</b></td>";
            echo "<td class=fontebranca12 align=center><b>".date("d/m/Y", strtotime($part[$x][data_realizacao]))."</b></td>";
            echo "<td class=fontebranca12 align=center><b>".date("d/m/Y", strtotime($part[$x][data_inscricao]))."</b></td>";
            echo "<td class=fontebranca12><b>".$part[$x][participante]."</b></td>";
            echo "<td class=fontebranca12><b>".$part[$x][razao_social]."</b></td>";
            echo "</tr>";
        }
         echo "</table>";
    }
    ?>
    </td>
  </tr>
  <tr>
    <td bgcolor="#009966" class="linhatopodiresqbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
  </tr>
</table>
<?PHP
   //echo "<center><font size=2><a href=\"javascript:location.href='?m=$p_mes&y=$p_ano'\" class=fontebranca12><<</a>  <b>".$meses[ltrim($mes, "0")]."/{$ano}</b>  <a href=\"javascript:location.href='?m=$n_mes&y=$n_ano'\"  class=fontebranca12>>></a></font></center>";
?>
<br>
</body>
</html>
