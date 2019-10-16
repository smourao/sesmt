<?PHP
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

$meses = array("", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");

	$query_cli = "SELECT c.razao_social, fi.cod_cliente, fi.cod_filial FROM site_fatura_info fi, cliente c
    WHERE fi.cod_cliente = c.cliente_id
    AND fi.cod_filial = c.filial_id
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
    GROUP BY c.razao_social, fi.cod_cliente, fi.cod_filial
	ORDER BY count(fi.cod_cliente) DESC";
    $result_cli = pg_query($connect, $query_cli);

if($_GET['cod_cliente'] != ""){

echo "<center><div id='test' class='inadimplente_popup roundborderselected' >";
      echo "<table width=300 align=center cellspacing=2 cellpadding=2 class='roundborderselectedinv'>";
      echo "<tr>";
         echo "<td class='text' align=center><b>Simulador de Juros</b></td>";
      echo "</tr>";
      echo "</table>";
   echo "<p>";
   echo "<center><span id=mname name=mname></span></center>";
   echo "<p>";
   echo "<table width=300 align=center cellspacing=2 cellpadding=2 >";
   echo "<tr>";
      echo "<td align=right class='text'><b>Data de Pagamento:</b></td><td><input type=text id=dtv name=dtv length=10 maxlength=10></td>";
   echo "</tr>";
      echo "<tr>";
      echo "<td align=right class='text'><b>Data de Vencimento:</b></td><td><input type=text id=dto name=dto length=10 maxlength=10 disabled></td>";
   echo "</tr>";
   echo "<tr>";
      echo "<td align=right class='text'><b>Valor:</b></td><td><input type=text length=10 name=valb id=valb disabled></td>";
   echo "</tr>";
   echo "</table>";
   echo "<p>";
   echo "<center><input type='button' value='Calcular' onclick=\"SimJuros();\">&nbsp;&nbsp;";
   echo "<input type='button' value='Cancelar' onclick=\"document.getElementById('fadescreen').style.display = 'none';document.getElementById('test').style.display = 'none';\"></center>";//document.getElementById('fadescreen').style.display = 'block';
   echo "<input type=hidden name=tmpd id=tmpd>";
   echo "<input type=hidden name=tmpv id=tmpv>";
   echo "<p>";
   echo "<div id='cmr'></div>";
echo "</div></center>";

/***************************************************************************************************/
// --> VARIABLES
/***************************************************************************************************/
echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
/**************************************************************************************************/
// -->  LEFT SIDE
/**************************************************************************************************/
     echo "<td width=250 class='text roundborder' valign=top>";
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>&nbsp;</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class='text' height=30 align=left>";
                echo "</tr>";
                echo "</table>";
                echo "<P>";

                // --> TIPBOX
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class=text height=30 valign=top align=justify>";
                        echo "<div id='tipbox' class='roundborderselected text' style='display: none;'>&nbsp;</div>";
                    echo "</td>";
                echo "</tr>";
                echo "</table>";
        echo "</td>";

/**************************************************************************************************/
// -->  RIGHT SIDE!!!
/**************************************************************************************************/
    echo "<td class='text roundborder' valign=top>";
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td align=center class='text roundborderselected'><b>Detalhamento de Inadimplentes</b></td>";
        echo "</tr>";
        echo "</table>";
        
	/***************************************************************************************************/
	// DETAIL OF A CLIENT
	/***************************************************************************************************/
    $query_cli = "SELECT fi.*, c.* FROM site_fatura_info fi, cliente c
    WHERE fi.cod_cliente = '{$_GET['cod_cliente']}'
    AND fi.cod_cliente = c.cliente_id
    AND fi.cod_filial = c.filial_id
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
    
	
	echo "<table width=100% border=0 align=center>";
	echo "<tr>";
    echo "<td align=left class=text colspan=2><b>{$buffer[0]['razao_social']}";
	   if($buffer[0][cod_cliente] == "147"){
          echo " UPV";
       }elseif($buffer[0][cod_cliente] == "148"){
          echo " UQMI";
       }elseif($buffer[0][cod_cliente] == "149"){
          echo " UQMII";
       }
	echo "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td width=30 align=left class=text><b>Endereço: </b></td><td align=left class=text>{$buffer[0]['endereco']} <b>Nº </b>{$buffer[0]['num_end']}</td>";
   	echo "</tr>";
	echo "<tr>";
	echo "<td align=left class=text><b>Telefone: </b></td><td align=left class=text>{$buffer[0]['telefone']}</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td align=left class=text><b>E-mail: </b></td><td align=left class=text>{$buffer[0]['email']}</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td align=left class=text><b>Contato: </b></td><td align=left class=text>{$buffer[0]['nome_contato_dir']}</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td align=left class=text><b>Cargo: </b></td><td align=left class=text>{$buffer[0]['cargo_contato_dir']}</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td align=left class=text><b>Telefone: </b></td><td align=left class=text>{$buffer[0]['tel_contato_dir']}</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td align=left class=text><b>E-mail: </b></td><td align=left class=text>{$buffer[0]['email_contato_dir']}</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td align=left class=text><b>Nextel: </b></td><td align=left class=text>{$buffer[0]['nextel_contato_dir']}</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td align=left class=text><b>ID: </b></td><td align=left class=text>{$buffer[0]['nextel_id_contato_dir']}</td>";
	echo "</tr>";
	echo "</table>";
	
	echo "<br>";

  echo '<table width="100%" border="0" align="center">';
  echo '<tr>';
  echo'<td width="50" align=center class="text roundborderselected"><strong>Fatura</strong></td>';
  echo'<td width="50" align=center class="text roundborderselected"><strong>Parcela</strong></td>';
  echo'<td width="100" align=center class="text roundborderselected"><strong>Vencimento</strong></td>';
  echo'<td width="70" align=center class="text roundborderselected"><strong>Dias<br>Vencidos</strong></td>';
  echo'<td width="100" align=center class="text roundborderselected"><strong>Valor</strong></td>';
  echo'<td width="70" align=center class="text roundborderselected"><strong>3%<br>Multa</strong></td>';
  echo'<td width="70" align=center class="text roundborderselected"><strong>0,29%<br>Juros</strong></td>';
  echo'<td width="130" align=center class="text roundborderselected"><strong>Total</strong></td>';
  echo'<td width="90" align=center class="text roundborderselected"><strong>Simulador<br>de Juros</strong></td>';
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
     echo'<td width="50" align=center class="text roundborder">'.$buffer[$x]['cod_fatura'].'</td>';
     echo'<td width="50" align=center class="text roundborder">'.$buffer[$x]['parcela'].'</td>';
     echo'<td width="100" align=center class="text roundborder">'.date("d/m/Y", strtotime($buffer[$x]['data_vencimento'])).'</td>';
     echo'<td width="70" align=center class="text roundborder">'.$dias_vencidos.'</td>';
     echo'<td width="100" align=right class="text roundborder">R$ '.number_format($total, 2, ',','.').'</td>';
     echo'<td width="70" align=right class="text roundborder">R$ '.number_format($multa, 2, ',','.').'</td>';
     echo'<td width="70" align=right class="text roundborder">R$ '.number_format($juros, 2, ',','.').'</td>';
     echo'<td width="130" align=right class="text roundborder">R$ '.number_format($corrigido, 2, ',','.').'</td>';
     echo'<td width="90" align=center class="text roundborderselected" '; echo " onclick=\"javascript:calcme('{$total}','".date("d/m/Y", strtotime($buffer[$x]['data_vencimento']))."','".$cd['razao_social']."<br>Fatura: ".$buffer[$x]['cod_fatura']."');\" style=\"cursor:pointer;\"><strong>Simular</strong></td>";
     echo '</tr>';
	}
     
  }
  echo '<tr>';
  echo'<td width="200" colspan=3 align=right class="text roundborderselected"><strong>Totais</strong></td>';
  echo'<td width="100" align=center class="text roundborderselected">'.$t_diasvencidos.'</td>';
  echo'<td width="100" align=right class="text roundborderselected">R$ '.number_format($t_total, 2, ',','.').'</td>';
  echo'<td width="100" align=right class="text roundborderselected">R$ '.number_format($t_multa, 2, ',','.').'</td>';
  echo'<td width="100" align=right class="text roundborderselected">R$ '.number_format($t_juros, 2, ',','.').'</td>';
  echo'<td width="130" align=right class="text roundborderselected" '; echo " onclick=\"javascript:calcme('{$t_corrigido}','".date("d/m/Y")."','".$cd['razao_social']."');\"><strong>R$ ".number_format($t_corrigido, 2, ',','.')."</strong></td>";
  echo'<td width="90" align=center class="text roundborderselected" '; echo " onclick=\"javascript:calcme('{$t_corrigido}','".date("d/m/Y")."','".$cd['razao_social']."');\" style=\"cursor:pointer;\"><strong>Simular</strong></td>";
  echo '</tr>';
  echo '</table>';

/**************************************************************************************************/
// -->
/**************************************************************************************************/
    echo "</td>";
echo "</tr>";
echo "</table>";
}
?>