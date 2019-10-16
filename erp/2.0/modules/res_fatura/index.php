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
	AND c.status != 'inativo'
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
					echo "<td class='text' align=center>&nbsp;</td>";  echo "</td>";
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
        echo "<td align=center class='text roundborderselected'><b>Inadimplência de Fatura de Serviços</b></td>";
        echo "</tr>";
        echo "</table>";
        
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

	    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td align=left class='text' width=5><b>Nº:</b></td>";
		echo "<td align=left class='text' width=200><b>Razão Social:</b></td>";
        echo "<td align=left class='text' width=40><b>Faturas:</b></td>";
        echo "</tr>";
		
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
		WHERE c.cliente_id = '{$row[cod_cliente]}'
		AND fi.cod_cliente = c.cliente_id
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
		//FATURA ZERADA = CLIENTE SEM FATURA VÁLIDA
		}else{
		//echo "<tr>";
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

            echo "<tr class='text roundbordermix'>";
            echo "<td align=center class='text roundborder curhand' onclick=\"location.href='?dir=res_fatura&p=ina_fat&cod_cliente={$row['cod_cliente']}';\" alt='Clique para ver detalhado' title='Clique para ver detalhado'>". STR_PAD($u, 2, "0", STR_PAD_LEFT) ."</td>";
			echo "<td align=left class='text roundborder curhand' onclick=\"location.href='?dir=res_fatura&p=ina_fat&cod_cliente={$row['cod_cliente']}';\" alt='Clique para ver detalhado' title='Clique para ver detalhado'>{$cd['razao_social']}";
			if($row[cod_cliente] == "147"){
			  echo " UPV";
		    }elseif($row[cod_cliente] == "148"){
			  echo " UQMI";
		    }elseif($row[cod_cliente] == "149"){
			  echo " UQMII";
       		}
			echo "&nbsp;</td>";
            echo "<td align=left class='text roundborder curhand' onclick=\"location.href='?dir=res_fatura&p=ina_fat&cod_cliente={$row['cod_cliente']}';\" alt='Clique para ver detalhado' title='Clique para ver detalhado'>";
			if($re>1){ echo "".$re." faturas vencidas."; }elseif($re==1){echo "".$re." fatura vencida.";}
			echo "&nbsp;</td>";			
            echo "</tr>";
			$i++;
			$u++;
        }
		}
        echo "</table>";

/**************************************************************************************************/
// -->
/**************************************************************************************************/
    echo "</td>";
echo "</tr>";
echo "</table>";
?>