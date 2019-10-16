<?php
session_start();
header("Content-Type: text/html; charset=ISO-8859-1",true);
include "../../sessao.php";
include "config/connect.php";

if(isset($_GET['d'])){
    $dia = $_GET['d'];
}else{
    $dia = date("d");
}

if(!isset($_SESSION[mi])){
    $_SESSION[mi] = date("m");
}
if(!isset($_SESSION[yi])){
    $_SESSION[yi] = date("Y");
}

if(isset($_GET['m'])){
    $mes = $_GET['m'];
    $_SESSION[mi] = $mes;
}else{
    if(isset($_SESSION[mi])){
        $mes = $_SESSION[mi];
    }else{
        $mes = date("m");
    }
}

if(isset($_GET['y'])){
    $ano = $_GET['y'];
    $_SESSION[yi] = $ano;
}else{
    if(isset($_SESSION[yi])){
        $ano = $_SESSION[yi];
    }else{
        $ano = date("Y");
    }
}

$meses = array("", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho",
"Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");
	$query_cli = "SELECT c.razao_social, fi.cod_cliente, fi.cod_filial FROM site_fatura_info fi, cliente c
    WHERE fi.cod_cliente = c.cliente_id
    AND
    fi.cod_filial = c.filial_id
    AND
    (
    (
    --EXTRACT(month FROM fi.data_vencimento) < {$mes}
    --AND
    EXTRACT(year FROM fi.data_vencimento) < {$ano}
    )OR(
    EXTRACT(day FROM fi.data_vencimento) < {$dia}
    AND
    EXTRACT(month FROM fi.data_vencimento) = {$mes}
    AND
    EXTRACT(year FROM fi.data_vencimento) = {$ano}
    )OR(
    EXTRACT(month FROM fi.data_vencimento) < {$mes}
    AND
    EXTRACT(year FROM fi.data_vencimento) = {$ano}
    )
    )
    AND
    fi.migrado = 0
    GROUP BY c.razao_social, fi.cod_cliente, fi.cod_filial
	ORDER BY count(fi.cod_cliente) DESC";
    $result_cli = pg_query($connect, $query_cli);
	
function dateDiff($sDataInicial, $sDataFinal)
{
 $sDataI = explode("-", $sDataInicial);
 $sDataF = explode("-", $sDataFinal);

 $nDataInicial = mktime(0, 0, 0, $sDataI[1], $sDataI[0], $sDataI[2]);
 $nDataFinal = mktime(0, 0, 0, $sDataF[1], $sDataF[0], $sDataF[2]);

 return ($nDataInicial > $nDataFinal) ?
    floor(($nDataFinal - $nDataInicial)/86400) : floor(($nDataFinal - $nDataInicial)/86400);
   //floor(($nDataInicial - $nDataFinal)/86400) : floor(($nDataFinal - $nDataInicial)/86400);
}
?>
<html>
<head>
<title>Inadimplência de Fatura de Serviço</title>
<link href="css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="res_fat.js"></script>
<script language="javascript" src="scripts.js"></script>
<script language="javascript" src="js.js"></script>
<script language="javascript" src="../../screen.js"></script>
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
.trans{
filter:alpha(opacity=95);
-moz-opacity:0.95;
-khtml-opacity: 0.95;
opacity: 0.95;
}
.relatorio {
position: absolute;
border: 3px solid black;
background: #097b42;
color: #FFFFFF;
width: 300px;
height: 400px;
}
</style>
</head>
<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">
<div id="test" class="relatorio trans" style="display:none;">
   <!-- ### DIV - TITULO DA JANELA -->
   <div id=titulo name=titulo style="background: #000000;">
      <table width=100%>
      <tr>
         <td class=fontebranca><b>Simulador de Juros</b></td>
         <td align=right width=40 valign=center>
         <img src="../../images/fechar.jpg" style="cursor:pointer;" onClick="document.getElementById('test').style.display='none';">
         </td>
      </tr>
      </table>
   </div>
   <p>
   <center><span id=mname name=mname></span></center>
   <p>
   <table width=100% bordrt=1 cellspacing=0 cellpadding=0>
   <tr>
      <td align=right><font size=1><b>Data de Pagamento:</b></font></td><td><input type=text id=dtv name=dtv length=10 maxlength=10></td>
   </tr>
      <tr>
      <td align=right><font size=1><b>Data de Vencimento:</b></font></td><td><input type=text id=dto name=dto length=10 maxlength=10 disabled></td>
   </tr>
   <tr>
      <td align=right><font size=1><b>Valor:</b></font></td><td><input type=text length=10 name=valb id=valb disabled></td>
   </tr>
   </table>
   <p>
   <center><input type='button' value='Calcular' onclick='SimJuros();'></center>
   <input type=hidden name=tmpd id=tmpd>
   <input type=hidden name=tmpv id=tmpv>
   <p>
   <div id='cmr'></div>
</div>

<script>
window.onscroll = function(){adjust()};
adjust();
function adjust(){
var scrOfX = 0, scrOfY = 0;
  if( typeof( window.pageYOffset ) == 'number' ) {
    //Netscape compliant
    scrOfY = window.pageYOffset;
    scrOfX = window.pageXOffset;
  } else if( document.body && ( document.body.scrollLeft || document.body.scrollTop ) ) {
    //DOM compliant
    scrOfY = document.body.scrollTop;
    scrOfX = document.body.scrollLeft;
  } else if( document.documentElement && ( document.documentElement.scrollLeft || document.documentElement.scrollTop ) ) {
    //IE6 standards compliant mode
    scrOfY = document.documentElement.scrollTop;
    scrOfX = document.documentElement.scrollLeft;
  }

   div = document.getElementById('test');
   //document.getElementById("conteudo").style.display = "block";
   //alert(window.pageXOffset);
   if(navigator.appName == 'Microsoft Internet Explorer')
   {
      div.style.left = ((getWidth()/2) - 150)+"px";
      div.style.top = scrOfY+"px";
   }else{
      div.style.left = ((getWidth()/2) - 150)+"px";
      div.style.top = scrOfY+"px";
      
   }
}

function number_format( number, decimals, dec_point, thousands_sep ) {
    // %     nota 1: Para 1000.55 retorna com precisão 1 no FF/Opera é 1,000.5, mas no IE é 1,000.6
    // *     exemplo 1: number_format(1234.56);
    // *     retorno 1: '1,235'
    // *     exemplo 2: number_format(1234.56, 2, ',', ' ');
    // *     retorno 2: '1 234,56'
    // *     exemplo 3: number_format(1234.5678, 2, '.', '');
    // *     retorno 3: '1234.57'
    // *     exemplo 4: number_format(67, 2, ',', '.');
    // *     retorno 4: '67,00'
    // *     exemplo 5: number_format(1000);
    // *     retorno 5: '1,000'
    // *     exemplo 6: number_format(67.311, 2);
    // *     retorno 6: '67.31'

    var n = number, prec = decimals;
    n = !isFinite(+n) ? 0 : +n;
    prec = !isFinite(+prec) ? 0 : Math.abs(prec);
    var sep = (typeof thousands_sep == "undefined") ? ',' : thousands_sep;
    var dec = (typeof dec_point == "undefined") ? '.' : dec_point;

    var s = (prec > 0) ? n.toFixed(prec) : Math.round(n).toFixed(prec); //fix for IE parseFloat(0.55).toFixed(0) = 0;

    var abs = Math.abs(n).toFixed(prec);
    var _, i;

    if (abs >= 1000) {
        _ = abs.split(/\D/);
        i = _[0].length % 3 || 3;

        _[0] = s.slice(0,i + (n < 0)) +
              _[0].slice(i).replace(/(\d{3})/g, sep+'$1');

        s = _.join(dec);
    } else {
        s = s.replace('.', dec);
    }

    return s;
}

function calcme(val, dt, name){
   //alert('ok');
   document.getElementById('dtv').value = '<?PHP echo date("d/m/Y");?>';
   document.getElementById('dto').value = dt;
   document.getElementById('valb').value = number_format(val, 2, ',', '.');
   document.getElementById('tmpd').value = dt;
   document.getElementById('tmpv').value = number_format(val, 2, ',', '.');
   document.getElementById('mname').innerHTML = "<b>"+name+"</b>";
   document.getElementById('cmr').innerHTML = "";
   document.getElementById('test').style.display = 'block';
   
}

function SimJuros(){
   var url = "sim_juros.php?valor="+document.getElementById('valb').value;
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
    //document.getElementById("loading").style.display = "none";
    //alert(msg);
    if(data[0] <0){
       document.getElementById('cmr').innerHTML = "<center>Data de vencimento inválida!</center>";
    }else{
       document.getElementById('cmr').innerHTML = "<b>&nbsp;Dias após o vencimento:</b> "+data[0]+"<p>&nbsp;<b>Valor Ajustado:</b> R$ "+data[1];
    }
}else{
 if (http.readyState==1){
       //waiting...
       //document.getElementById("loading").style.display = "block";
        document.getElementById('cmr').innerHTML = "<center>Atualizando...</center>";
    }
 }
}
</script>

<p>
<center><h2> SESMT - Segurança do Trabalho </h2></center>
<p>&nbsp;</p>
<table width="730" border="2" align="center" cellpadding="0" cellspacing="0">
    <tr>
    	<th colspan="7" class="linhatopodiresq" bgcolor="#009966"><br>INADIMPLÊNCIA DE FATURA DE SERVIÇO<br>&nbsp;</th>
    </tr>
    <tr>
		<tr>
			<th bgcolor="#009966" colspan="7">
			<br>&nbsp;
			<?PHP
			if($_GET[act] != 'detail'){
               echo "<input name=btn_sair type=button id=btn_sair onClick=\"location.href='../index.php#financeiro';\" value=Sair style=\"width:100;\">";
            }else{
               echo "<input name=btn_sair type=button id=btn_sair onClick=\"location.href='inadimplente_fatura.php';\" value=Voltar style=\"width:100;\">";
               echo "&nbsp;&nbsp;";
               echo "<input name=btn_sair type=button id=btn_sair onClick=\"location.href='../index.php#financeiro';\" value=Sair style=\"width:100;\">";
            }
            ?>
			<br>&nbsp;
			</th>
		</tr>
	</tr>
	<tr>
      <td height="26" colspan="7" class="linhatopodiresq">
	  <br>
     <!-- CONTEÚDO -->
     <table width="730" border="0" align="center">
        <tr>
          <td width="100%" align=right>
              <div id="lista_orcamentos">
              </div>
          </td>
        </tr>
     </table>
	 </td>
    </tr>
  <tr>
    <th colspan="7" class="linhatopodiresq" bgcolor="#009966">
      <h3>Inadimplentes</h3>
<?PHP
  if($mes >=12){
      $n_mes = 01;
      $n_ano = $ano+1;
  }elseif($mes <= 01){
     $p_mes = 12;
     $p_ano = $ano-1;
  }else{
      $n_mes = STR_PAD($mes+1, 2, "0", STR_PAD_LEFT);
      $n_ano = $ano;
      $p_mes = STR_PAD($mes-1, 2, "0", STR_PAD_LEFT);
      $p_ano = $ano;
  }
if($_GET[act] != 'detail'){
   //echo "<center><font size=2><a href=\"javascript:location.href='?m=$p_mes&y=$p_ano'\" class=fontebranca12><<</a>  <b>".$meses[ltrim($mes, "0")]."/{$ano}</b>  <a href=\"javascript:location.href='?m=$n_mes&y=$n_ano'\"  class=fontebranca12>>></a></font></center>";
}else{
   //echo "<center><font size=2><a href=\"javascript:location.href='?m=$p_mes&y=$p_ano'\" class=fontebranca12><<</a>  <b>".$meses[ltrim($mes, "0")]."/{$ano}</b>  <a href=\"javascript:location.href='?m=$n_mes&y=$n_ano'\"  class=fontebranca12>>></a></font></center>";
}
?>
<br>
    </th>
  </tr>
<tr><td colspan=6>
<?PHP
if($_GET[act] != 'detail'){
?>
<table width="730" border="1" align="center" cellspacing=1 cellpadding=5>
  <tr>
    <td width="10%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Nº
	</strong></div></td>

    <td width="55%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Razão Social
	</strong></div></td>

    <td width="35%" bgcolor="#009966" class="linhatopodiresq">
    <div align="center" class="fontebranca12"><strong>Faturas</strong></div></td>
    </tr>
<?php
  $i = 1;
  $u = 1;
  while($row=pg_fetch_array($result_cli)){
  if($row['cod_filial']){
     $sql = "SELECT * FROM cliente WHERE cliente_id = {$row['cod_cliente']} AND filial_id={$row['cod_filial']}";
  }else{
     $sql = "SELECT * FROM cliente WHERE cliente_id = {$row['cod_cliente']}";
  }
  $result = pg_query($sql);
  $cd = pg_fetch_array($result);

  $sql = "SELECT fi.cod_fatura, fi.cod_cliente, fi.cod_filial FROM site_fatura_info fi, cliente c
    WHERE
    c.cliente_id = '{$row[cod_cliente]}'
    AND
    fi.cod_cliente = c.cliente_id
    AND
    fi.cod_filial = c.filial_id
	AND
	c.status != 'inativo'
    AND
    (
    (
    EXTRACT(year FROM fi.data_vencimento) < {$ano}
    )OR(
    EXTRACT(day FROM fi.data_vencimento) < {$dia}
    AND
    EXTRACT(month FROM fi.data_vencimento) = {$mes}
    AND
    EXTRACT(year FROM fi.data_vencimento) = {$ano}
    )OR(
    EXTRACT(month FROM fi.data_vencimento) < {$mes}
    AND
    EXTRACT(year FROM fi.data_vencimento) = {$ano}
    )
    )
    AND
    fi.migrado = 0
    GROUP BY fi.cod_fatura, fi.cod_cliente, fi.cod_filial
	ORDER BY fi.cod_fatura ASC";
    $rfat = pg_query($sql);
    $fat = pg_fetch_all($rfat);

for($r=0;$r<pg_num_rows($rfat);$r++){
  $sql = "SELECT * FROM site_fatura_produto WHERE cod_fatura = '{$fat[$r]['cod_fatura']}'";
  $rin = pg_query($sql);
  $items = pg_fetch_all($rin);
  
  $total=0;

  for($x=0;$x<pg_num_rows($rin);$x++){
     $total = $total + ($items[$x]['quantidade']*$items[$x]['valor']);
  }
  
  $multa = ($total * 3)/100;
  $juros = ($total * 0.29)/100;
  if($row['data_pagamento']){
     $data_pag = date("d-m-Y", strtotime($row['data_pagamento']));
  }else{
     $data_pag = date("d-m-Y");
  }
  $dias_vencidos = dateDiff(date("d-m-Y", strtotime($row['data_vencimento'])), $data_pag);
  $sql = "SELECT * FROM site_fatura_info WHERE cod_cliente = {$row['cod_cliente']} AND
    migrado = 0 AND
    (
    /*
    (
    EXTRACT(month FROM data_vencimento) < {$mes}
    AND
    EXTRACT(year FROM data_vencimento) <= {$ano}
    )OR(
    EXTRACT(day FROM data_vencimento) < {$dia}
    AND
    EXTRACT(month FROM data_vencimento) = {$mes}
    AND
    EXTRACT(year FROM data_vencimento) <= {$ano}
    ) */

    (
    EXTRACT(year FROM data_vencimento) < {$ano}
    )OR(
    EXTRACT(day FROM data_vencimento) < {$dia}
    AND
    EXTRACT(month FROM data_vencimento) = {$mes}
    AND
    EXTRACT(year FROM data_vencimento) = {$ano}
    )OR(
    EXTRACT(month FROM data_vencimento) < {$mes}
    AND
    EXTRACT(year FROM data_vencimento) = {$ano}
    )
    
    
    )
   ";
   $rv = pg_query($sql);
   $vencidos = pg_fetch_all($rv);

   $vv  = 0; // valor vencido - todas as faturas
   $tdv = 0; // total de dias vencidos
   $tvj = 0; // valor total com somatorio de juros e dias
   $mv  = 0; // Multas de valores vencidos
   $jv  = 0; // Juros de valores vencidos
   $ad = array();
   $re=0;
   for($i=0;$i<pg_num_rows($rv);$i++){
      $tdv += dateDiff(date("d-m-Y", strtotime($vencidos[$i]['data_vencimento'])), date("d-m-Y"));
      $ad[] = $tdv;
      $sql = "SELECT * FROM site_fatura_produto WHERE cod_fatura = '{$vencidos[$i]['cod_fatura']}'";
      $pr = pg_query($sql);
      $pt = pg_fetch_all($pr);
      //TEST THE NUMBER OF PRODUCTS AND IF DON'T HAVE MORE THAN 3 VALUES INSIDE EACH
      if(pg_num_rows($pr)<=0 || (pg_num_rows($pr)==2 && in_array('4.00', $pt[0]) && in_array('6.50', $pt[1]))){
          //DO NOTHING
      }else{
	  		$re++;
          //soma valores de items na variavel $vv; obtem valor total da fatura.
          for($o=0;$o<pg_num_rows($pr);$o++){
             $vv += $pt[$o][valor] * $pt[$o][quantidade];
          }
          // valores de cada vencimento separados
          $mv   = ($vv * 3)/100;
          $jv   = ($vv * 0.29)/100;
          $mva  += $mv;
          $jva  += $jv;
          //soma valor da fatura + multa da fatura + juros da fatura * dias vencidos até a data atual
          $mesesvencidos = ceil($tdv/30);
          $tvj += $vv + ($mv*$mesesvencidos) + ($jv * $tdv);
      }
   }
}

  if($row['tagged'] == 1){
     $bcolor = '#D75757';
  }else{
     $bcolor = '#006633';
  }

if($tvj == 0){
   //echo "zero";
   //FATURA ZERADA = CLIENTE SEM FATURA VÁLIDA
}else{
?>
  <tr>
    <?PHP
      $fetch = "<center><b>".addslashes($cd['razao_social']);
      if($row[cod_cliente] == "147"){
          $fetch .=  " UPV";
       }elseif($row[cod_cliente] == "148"){
          $fetch .= " UQMI";
       }elseif($row[cod_cliente] == "149"){
          $fetch .= " UQMII";
       }
      $fetch .= "</b></center>";
      $fetch .= "<p>";
      $fetch .= "<b>Endereço:</b> ".$cd[endereco]." Nº".$cd[num_end];
      $fetch .= "<br>";
      $fetch .= "<b>Telefone:</b> ".$cd[telefone];
      $fetch .= "<br>";
      $fetch .= "<b>E-mail:</b> ".$cd[email];
      if($cd[nome_contato_dir]){
         $fetch .= "<br>";
         $fetch .= "<b>Pessoa de contato:</b> ".$cd[nome_contato_dir];
      }
      if($cd[cargo_contato_dir]){
         $fetch .= "<br>";
         $fetch .= "<b>Cargo do contato:</b> ".$cd[cargo_contato_dir];
      }
      if($cd[tel_contato_dir]){
         $fetch .= "<br>";
         $fetch .= "<b>Telefone do contato:</b> ".$cd[tel_contato_dir];
      }
      if($cd[email_contato_dir]){
         $fetch .= "<br>";
         $fetch .= "<b>E-mail do contato:</b> ".$cd[email_contato_dir];
      }
      if($cd[nextel_contato_dir]){
         $fetch .= "<br>";
         $fetch .= "<b>Nextel do contato:</b> ".$cd[nextel_contato_dir];
      }
      if($cd[nextel_id_contato_dir]){
         $fetch .= "<br>";
         $fetch .= "<b>Nextel id:</b> ".$cd[nextel_id_contato_dir];
      }

    ?>
    
    <td class="linhatopodiresq" id="col4<?php echo $row['cod_fatura'];?>" bgcolor='<?PHP echo $bcolor;?>'>
	  <div align="center" class="linksistema">
	   <a href="?act=detail&cod_cliente=<?php echo $row['cod_cliente']?>&cod_filial=<?php echo $row['cod_filial']?>&fatura=<?php echo $row['cod_fatura']?>">
       &nbsp;<?PHP echo STR_PAD($u, 2, "0", STR_PAD_LEFT);?>
	  </div>
	</td>
    
    <td class="linhatopodiresq" id="col3<?php echo $row['cod_fatura'];?>" bgcolor='<?PHP echo $bcolor;?>'>
	  <div align="left" class="linksistema">
	   <a href="?act=detail&cod_cliente=<?php echo $row['cod_cliente']?>&cod_filial=<?php echo $row['cod_filial']?>&fatura=<?php echo $row['cod_fatura']?>" onMouseOver="return overlib('<?PHP echo $fetch;?>');" onMouseOut="return nd();">
       &nbsp;<?php echo $cd['razao_social'];
       if($row[cod_cliente] == "147"){
          echo " UPV";
       }elseif($row[cod_cliente] == "148"){
          echo " UQMI";
       }elseif($row[cod_cliente] == "149"){
          echo " UQMII";
       }
       ?>
       </a>
	  </div>
	</td>

    <td class="linhatopodiresq" id="col4<?php echo $row['cod_fatura'];?>" bgcolor='<?PHP echo $bcolor;?>'>
	  <div align="center" class="linksistema">
	   <a href="?act=detail&cod_cliente=<?php echo $row['cod_cliente']?>&cod_filial=<?php echo $row['cod_filial']?>&fatura=<?php echo $row['cod_fatura']?>">
       &nbsp;<?php echo"<font size=1><b>"; if($re>1){ echo "".$re." faturas vencidas."; }elseif($re==1){echo "".$re." fatura vencida.";} echo "</b></font>";?>
	  </div>
	</td>
  </tr>
<?php
$i++;
$u++;
  }
  }//REMOVE FATURAS VAZIAS
  $fecha = pg_close($connect);
  echo "</table>";
  echo "<pre>



















  </pre>";
}else{//END DETAIL
/***************************************************************************************************/
// DETAIL OF A CLIENT
/***************************************************************************************************/
    $query_cli = "SELECT fi.*, c.razao_social FROM site_fatura_info fi, cliente c
    WHERE
    fi.cod_cliente = '{$_GET['cod_cliente']}'
    AND
    fi.cod_cliente = c.cliente_id
    AND
    fi.cod_filial = c.filial_id
    AND
    (
    (
    EXTRACT(year FROM data_vencimento) < {$ano}
    )OR(
    EXTRACT(day FROM data_vencimento) < {$dia}
    AND
    EXTRACT(month FROM data_vencimento) = {$mes}
    AND
    EXTRACT(year FROM data_vencimento) = {$ano}
    )OR(
    EXTRACT(month FROM data_vencimento) < {$mes}
    AND
    EXTRACT(year FROM data_vencimento) = {$ano}
    )
    )
    AND
    fi.migrado = 0
	ORDER BY fi.data_vencimento ASC";
    $result_cli = pg_query($connect, $query_cli);
    $buffer = pg_fetch_all($result_cli);
    
    if($_GET['cod_filial']){
        $sql = "SELECT * FROM cliente WHERE cliente_id = {$_GET['cod_cliente']} AND filial_id={$_GET['cod_filial']}";
    }else{
        $sql = "SELECT * FROM cliente WHERE cliente_id = {$_GET['cod_cliente']}";
    }
    $result = pg_query($sql);
    $cd = pg_fetch_array($result);

    $fetch = "<center><b>".addslashes($cd['razao_social']);
      if($row[cod_cliente] == "147"){
          $fetch .=  " UPV";
       }elseif($row[cod_cliente] == "148"){
          $fetch .= " UQMI";
       }elseif($row[cod_cliente] == "149"){
          $fetch .= " UQMII";
       }
      $fetch .= "</b></center>";
      $fetch .= "<p>";
      $fetch .= "<b>Endereço:</b> ".$cd[endereco]." Nº".$cd[num_end];
      $fetch .= "<br>";
      $fetch .= "<b>Telefone:</b> ".$cd[telefone];
      $fetch .= "<br>";
      $fetch .= "<b>E-mail:</b> ".$cd[email];
      if($cd[nome_contato_dir]){
         $fetch .= "<br>";
         $fetch .= "<b>Pessoa de contato:</b> ".$cd[nome_contato_dir];
      }
      if($cd[cargo_contato_dir]){
         $fetch .= "<br>";
         $fetch .= "<b>Cargo do contato:</b> ".$cd[cargo_contato_dir];
      }
      if($cd[tel_contato_dir]){
         $fetch .= "<br>";
         $fetch .= "<b>Telefone do contato:</b> ".$cd[tel_contato_dir];
      }
      if($cd[email_contato_dir]){
         $fetch .= "<br>";
         $fetch .= "<b>E-mail do contato:</b> ".$cd[email_contato_dir];
      }
      if($cd[nextel_contato_dir]){
         $fetch .= "<br>";
         $fetch .= "<b>Nextel do contato:</b> ".$cd[nextel_contato_dir];
      }
      if($cd[nextel_id_contato_dir]){
         $fetch .= "<br>";
         $fetch .= "<b>Nextel id:</b> ".$cd[nextel_id_contato_dir];
      }

    echo "<CENTER><div align=center onMouseOver=\"return overlib('{$fetch}');\" onMouseOut=\"return nd();\"><font color=white><b>{$buffer[0]['razao_social']}</b></font></div></CENTER>";
    
    echo "<P>";

  echo '<table width="730" border="1" align="center">';
  echo '<tr>';
  echo'<td width="50" bgcolor="#009966" align=center class="linhatopodiresq fontebranca12"><strong>Fatura</strong></td>';
  echo'<td width="50" bgcolor="#009966" align=center class="linhatopodiresq fontebranca12"><strong>Parcela</strong></td>';
  echo'<td width="100" bgcolor="#009966" align=center class="linhatopodiresq fontebranca12"><strong>Vencimento</strong></td>';
  echo'<td width="70" bgcolor="#009966" align=center  class="linhatopodiresq fontebranca12"><strong>Dias<br>Vencidos</strong></td>';
  echo'<td width="100" bgcolor="#009966" align=center  class="linhatopodiresq fontebranca12"><strong>Valor</strong></td>';
  echo'<td width="70" bgcolor="#009966" align=center  class="linhatopodiresq fontebranca12"><strong>3%<br>Multa</strong></td>';
  echo'<td width="70" bgcolor="#009966" align=center  class="linhatopodiresq fontebranca12"><strong>0,29%<br>Juros</strong></td>';
  echo'<td width="130" bgcolor="#009966" align=center  class="linhatopodiresq fontebranca12"><strong>Total</strong></td>';
  echo'<td width="90" bgcolor="#009966" align=center  class="linhatopodiresq fontebranca12"><strong>Simulador<br>de Juros</strong></td>';
  echo '</tr>';
  
  $t_diasvencidos = 0;
  $t_total        = 0;
  $t_multa        = 0;
  $t_juros        = 0;
  $t_corrigido    = 0;
  
  for($x=0;$x<pg_num_rows($result_cli);$x++){
     $sql = "SELECT * FROM site_fatura_produto WHERE cod_fatura = '{$buffer[$x]['cod_fatura']}'";
     $rin = pg_query($sql);
     $items = pg_fetch_all($rin);
     $total=0;
	 if(pg_num_rows($rin)<=0 || (pg_num_rows($rin)==2 && in_array('4.00', $items[0]) && in_array('6.50', $items[1]))){
          //DO NOTHING
     }else{
		 for($y=0;$y<pg_num_rows($rin);$y++){
			 $total = $total + ($items[$y]['quantidade']*$items[$y]['valor']);
		 }
     $multa = ($total * 3)/100;
     $juros = ($total * 0.29)/100;
     if($row['data_pagamento']){
        $data_pag = date("d-m-Y", strtotime($row['data_pagamento']));
     }else{
        $data_pag = date("d-m-Y");
     }
     $dias_vencidos = dateDiff(date("d-m-Y", strtotime($buffer[$x]['data_vencimento'])), $data_pag);
     //AJUSTA DIAS PARA CALCULO DE MULTA MENSAL DE ACORDO COM NÚMERO DE DIAS VENCIDOS!
     $mult_multa = ceil(($dias_vencidos/30));
                  //correção = total + (multa mensal * (dias/30)) + (juro diário * dias vencidos)
     $corrigido = ($total + ($multa*$mult_multa)) + ($juros * $dias_vencidos);

     //TOTAL'S UPDATE
     $t_diasvencidos += $dias_vencidos;
     $t_total += $total;
     $t_multa += $multa;
     $t_juros += $juros*$dias_vencidos;
     $t_corrigido += $corrigido;
	 echo '<tr>';
     echo'<td width="50" align=center class="linhatopodiresq fontebranca12">'.$buffer[$x]['cod_fatura'].'</td>';
     echo'<td width="50" align=center class="linhatopodiresq fontebranca12">'.$buffer[$x]['parcela'].'</td>';
     echo'<td width="100" align=center class="linhatopodiresq fontebranca12">'.date("d/m/Y", strtotime($buffer[$x]['data_vencimento'])).'</td>';
     echo'<td width="70" align=center class="linhatopodiresq fontebranca12">'.$dias_vencidos.'</td>';
     echo'<td width="100" align=right  class="linhatopodiresq fontebranca12">R$ '.number_format($total, 2, ',','.').'</td>';
     echo'<td width="70" align=right  class="linhatopodiresq fontebranca12">R$ '.number_format($multa, 2, ',','.').'</td>';
     echo'<td width="70" align=right  class="linhatopodiresq fontebranca12">R$ '.number_format($juros, 2, ',','.').'</td>';
     echo'<td width="130" align=right  class="linhatopodiresq fontebranca12">R$ '.number_format($corrigido, 2, ',','.').'</td>';
     echo'<td width="90" bgcolor="#009966" align=center  class="linhatopodiresq fontebranca12" '; echo " onclick=\"javascript:calcme('{$total}','".date("d/m/Y", strtotime($buffer[$x]['data_vencimento']))."','".$cd['razao_social']."<br>Fatura: ".$buffer[$x]['cod_fatura']."');\" style=\"cursor:pointer;\"><strong>Simular</strong></td>";
     echo '</tr>';
	}
     
  }
  echo '<tr>';
  echo'<td width="200" colspan=3 bgcolor="#009966" align=right class="linhatopodiresq fontebranca12"><strong>Totais</strong></td>';
  echo'<td width="100" bgcolor="#009966" align=center  class="linhatopodiresq fontebranca12">'.$t_diasvencidos.'</td>';
  echo'<td width="100" bgcolor="#009966" align=right  class="linhatopodiresq fontebranca12">R$ '.number_format($t_total, 2, ',','.').'</td>';
  echo'<td width="100" bgcolor="#009966" align=right  class="linhatopodiresq fontebranca12">R$ '.number_format($t_multa, 2, ',','.').'</td>';
  echo'<td width="100" bgcolor="#009966" align=right  class="linhatopodiresq fontebranca12">R$ '.number_format($t_juros, 2, ',','.').'</td>';
  echo'<td width="130" bgcolor="#009966" align=right  class="linhatopodiresq fontebranca12" '; echo " onclick=\"javascript:calcme('{$t_corrigido}','".date("d/m/Y")."','".$cd['razao_social']."');\"><strong>R$ ".number_format($t_corrigido, 2, ',','.')."</strong></td>";
  echo'<td width="90" bgcolor="#009966" align=center  class="linhatopodiresq fontebranca12" '; echo " onclick=\"javascript:calcme('{$t_corrigido}','".date("d/m/Y")."','".$cd['razao_social']."');\" style=\"cursor:pointer;\"><strong>Simular</strong></td>";
  echo '</tr>';
  //javascript:calcme('{$t_total}','".date("d/m/Y", strtotime($row['data_vencimento']))."','".$buffer[$x]['razao_social']."');
  echo '</table>';
  
  }
?>
  </td></tr>
  <tr>
    <td bgcolor="#009966" colspan=6 class="linhatopodiresqbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
  </tr>
</table>
<P>
<?PHP
if($_GET[act] != 'detail'){
   //echo "<center><font size=2><a href=\"javascript:location.href='?m=$p_mes&y=$p_ano'\" class=fontebranca12><<</a>  <b>".$meses[ltrim($mes, "0")]."/{$ano}</b>  <a href=\"javascript:location.href='?m=$n_mes&y=$n_ano'\"  class=fontebranca12>>></a></font></center>";
}
?>
<p>
<br>
<pre>
</pre>
</body>
</html>