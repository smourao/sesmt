<?PHP

$sql = "SELECT * FROM cliente WHERE cliente_id = '$_GET[cod_cliente]'";
$res = pg_query($sql);
$buffer = pg_fetch_array($res);
$buffer[ano_contrato] = date("Y")."/".($buffer[ano_contrato]+1);

$sql = "SELECT * FROM aso WHERE cod_func = '$_GET[cod_func]' ORDER BY cod_aso DESC";
$rss = @pg_query($sql);
$aso = @pg_fetch_all($rss);

/************************************************************************************************/
//DELETE//
if($_GET[sv] == "s"){
	$sql = "DELETE FROM antecedentes_familiares WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]'";
	$query = pg_query($sql);
	
	$sql = "DELETE FROM antecedentes_pessoais WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]'";
	$query = pg_query($sql);
}

/************************************************************************************************/
//INSERT//
$fam = $_POST[familiares];
if(is_array($fam)){
	foreach($fam as $fami){
		$s = "SELECT * FROM antecedentes_familiares WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = '$fami'";
		$q = @pg_query($s);
		if(@pg_num_rows($q) == 0){
			$sql = "INSERT INTO antecedentes_familiares(cod_func, cod_cliente, doenca) VALUES('$_GET[cod_func]', '$_GET[cod_cliente]', '$fami')";
			$query = @pg_query($sql);
		}
	}
}

$pes = $_POST[pessoais];
if(is_array($pes)){
	foreach($pes as $pess){
		$s = "SELECT * FROM antecedentes_pessoais WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = '$pess";
		$q = @pg_query($s);
		if(@pg_num_rows($q) == 0){
			$sql = "INSERT INTO antecedentes_pessoais(cod_func, cod_cliente, doenca) VALUES('$_GET[cod_func]', '$_GET[cod_cliente]', '$pess')";
			$query = @pg_query($sql);
		}
	}
}

$s = "SELECT * FROM exames_fisicos WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]'";
$q = @pg_query($s);
if(@pg_num_rows($q) == 0){
	$sql = "INSERT INTO exames_fisicos(altura, peso, pulso, fr, pa, biotipo, aspecto, cod_func, cod_cliente) VALUES('$_POST[altura_3]', '$_POST[peso_3]', '$_POST[pulso_3]', '$_POST[fr_3]', '$_POST[pa_3]', '$_POST[biotipo_3]', '$_POST[aspecto_3]', '$_GET[cod_func]', '$_GET[cod_cliente]')";
	$query = @pg_query($sql);
}elseif($_POST['altura_3'] || $_POST['peso_3'] || $_POST['pulso_3'] || $_POST['biotipo_3'] || $_POST['fr_3'] || $_POST['pa_3'] || $_POST['aspecto_3'] ){
	$sql = "UPDATE exames_fisicos SET altura = '$_POST[altura_3]', peso = '$_POST[peso_3]', pulso = '$_POST[pulso_3]', fr = '$_POST[fr_3]', pa = '$_POST[pa_3]', biotipo = '$_POST[biotipo_3]', aspecto = '$_POST[aspecto_3]' WHERE cod_cliente = '$_GET[cod_cliente]' AND cod_func = '$_GET[cod_func]'";
	$query = @pg_query($sql);
}

$data1 = $_POST[data_5];
$partes = explode('/',$data1);
$data5 = $partes[2].'-'.$partes[1].'-'.$partes[0];

$data1 = $_POST[data_f_5];
$partes = explode('/',$data1);
$data5_f = $partes[2].'-'.$partes[1].'-'.$partes[0];


$s = "SELECT * FROM avaliaca_periodica WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]'";
$q = @pg_query($s);
if(@pg_num_rows($q) == 0){
	$sql = "INSERT INTO avaliaca_periodica(resultado, tipo, data, altura, peso, fc, pa, cod_func, cod_cliente) VALUES('$_POST[res_5]', '$_POST[tipo_5]', '$data5', '$data5_f', '$_POST[altura_5]', '$_POST[peso_5]', '$_POST[fc_5]', '$_POST[pa_5]', '$_GET[cod_func]', '$_GET[cod_cliente]')";
	$query = @pg_query($sql);
}else{
	$sql = "UPDATE avaliaca_periodica SET resultado = '$_POST[res_5]', tipo = '$_POST[tipo_5]', altura = '$_POST[altura_5]', peso = '$_POST[peso_5]', fc = '$_POST[fc_5]', data = '$data5', data_f = '$data5_f', pa = '$_POST[pa_5]' WHERE cod_cliente = '$_GET[cod_cliente]' AND cod_func = '$_GET[cod_func]'";
	$query = @pg_query($sql);
}
/**************************************************************************************************/
if(is_numeric($_GET[cod_cliente])){
    $sql = "SELECT fi.cod_fatura, fi.cod_cliente, fi.cod_filial FROM site_fatura_info fi, cliente c
    WHERE
    c.cliente_id = '$_GET[cod_cliente]'
    AND
    fi.cod_cliente = c.cliente_id
    AND
    fi.cod_filial = c.filial_id
    AND
    (
    (
    EXTRACT(year FROM fi.data_vencimento) < '".date("Y")."'
    )OR(
    EXTRACT(day FROM fi.data_vencimento) < '".date("d")."'
    AND
    EXTRACT(month FROM fi.data_vencimento) = '".date("m")."'
    AND
    EXTRACT(year FROM fi.data_vencimento) = '".date("Y")."'
    )OR(
    EXTRACT(month FROM fi.data_vencimento) < '".date("m")."'
    AND
    EXTRACT(year FROM fi.data_vencimento) = '".date("Y")."'
    )
    )
    AND
    fi.migrado = 0
    GROUP BY fi.cod_fatura, fi.cod_cliente, fi.cod_filial
    ORDER BY fi.cod_fatura ASC";
    $rfat = pg_query($sql);
    $fat = pg_fetch_all($rfat);
}

echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
/**************************************************************************************************/
// -->  LEFT SIDE
/**************************************************************************************************/


     echo "<td width=250 class='text roundborder' valign=top>";
                // OP��ES DO CLIENTE
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>Op��es</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";
/*
<input type='button' class='btn' name='butVtr' value='Voltar' onclick=\"location.href='";
				if($_GET[step]==1){ 
					echo "?dir=cad_cliente&p=detalhe_cliente&cod_cliente={$_GET[cod_cliente]}";
				}else{
					echo "?dir=cad_cliente&p=list_funcao&cod_cliente=$_GET[cod_cliente]&step=1";
				}
					echo "';\" onmouseover=\"showtip('tipbox', '- Voltar, permite voltar para o cadastro de clientes.');\" onmouseout=\"hidetip('tipbox');\">


*/
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class='roundbordermix text' height=30 align=left>";
                        echo "<table width=100% border=0>";
						echo "<tr>";
						echo "<td class='text' align=center><input type='button' class='btn' name='button' value='...' onclick=\"location.href='?dir=relatorios_medicos&p=detalhe_cliente&cod_cliente=$_GET[cod_cliente]';\" ></td>";
                        echo "</tr>";
                        echo "</table>";
                    echo "</td>";
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
        echo "<td align=center class='text roundborderselected'>";
        echo "<b>{$buffer[razao_social]}</b>";
        echo "</td>";
        echo "</tr><tr><td class='text roundborder'>";
		//ANTECEDENTES FAMILIARES
		echo '<form method="POST" action="?dir=relatorios_medicos&p=ficha&cod_cliente='.$_GET[cod_cliente].'&cod_func='.$_GET[cod_func].'&sv=s"><table width="100%" border="0">
    <tr>
      <td colspan="6" align="center" class="text roundborderselected" ><b>1 - Antecedentes Familiares</b></td>
    </tr>
    <tr>
      <td width="5%"><label>
        <input type="checkbox" name="familiares[]" value="Tuberculose"';
		$s = "SELECT * FROM antecedentes_familiares WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'Tuberculose'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/>
      </label></td>
      <td class="text" width="28%">Tuberculose</td>
      <td class="text" width="5%"><label>
        <input type="checkbox" name="familiares[]" value="Asma"';
		$s = "SELECT * FROM antecedentes_familiares WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'Asma'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/>
      </label></td>
      <td class="text" width="28%">Asma</td>
      <td class="text" width="5%"><input type="checkbox" name="familiares[]" value="Press�o Alta" ';
		$s = "SELECT * FROM antecedentes_familiares WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'Press�o Alta'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/></td>
      <td class="text" width="28%">Press�o Alta</td>
    </tr>
    <tr>
      <td class="text"><label>
        <input type="checkbox" name="familiares[]" value="Diabete" ';
		$s = "SELECT * FROM antecedentes_familiares WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'Diabete'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/>
      </label></td>
      <td class="text">Diabete</td>
      <td class="text"><label>
        <input type="checkbox" name="familiares[]" value="Alergias" ';
		$s = "SELECT * FROM antecedentes_familiares WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'Alergias'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/>
      </label></td>
      <td class="text">Alergias</td>
      <td class="text"><input type="checkbox" name="familiares[]" value="Doen�a Nervosa" ';
		$s = "SELECT * FROM antecedentes_familiares WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'Doen�a Nervosa'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/></td>
      <td class="text">Doen�a Nervosa</td>
    </tr>
    <tr class="text">
      <td class="text"><label>
        <input type="checkbox" name="familiares[]" value="C�ncer" ';
		$s = "SELECT * FROM antecedentes_familiares WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'C�ncer'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/>
      </label></td>
      <td class="text">C�ncer</td>
      <td class="text"><label>
        <input type="checkbox" name="familiares[]" value="Urtic�ria" ';
		$s = "SELECT * FROM antecedentes_familiares WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'Urtic�ria'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/>
      </label></td>
      <td class="text">Urtic�ria</td>
      <td class="text"><input type="checkbox" name="familiares[]" value="Doen�a Mental" ';
		$s = "SELECT * FROM antecedentes_familiares WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'Doen�a Mental'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/></td>
      <td class="text">Doen�a Mental</td>
    </tr>
    <tr>
      <td class="text"><label>
        <input type="checkbox" name="familiares[]" value="Doen�a do Cora��o" ';
		$s = "SELECT * FROM antecedentes_familiares WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'Doen�a do Cora��o'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/>
      </label></td>
      <td class="text">Doen�a Cora��o</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>';
        echo "</tr><tr><td class='text roundborder'>";
		
		echo '<table width="100%" border="0">
    <tr>
      <td colspan="6" align="center" class="text roundborderselected" ><b>2 - Antecedentes Pessoais</b></td>
    </tr>
    <tr>
      <td width="5%" class="text">
        <input type="checkbox" name="pessoais[]" value="Doen�a no Cora��o" ';
		$s = "SELECT * FROM antecedentes_pessoais WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'Doen�a do Cora��o'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/>
      </td>
      <td class="text" width="28%">Doen�a no Cora��o</td>
      <td class="text" width="5%">
        <input type="checkbox" name="pessoais[]" value="Press�o Alta" ';
		$s = "SELECT * FROM antecedentes_pessoais WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'Press�o Alta'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/>
      </td>
      <td class="text" width="28%">Press�o Alta</td>
      <td width="5%">
        <input type="checkbox" name="pessoais[]" value="Dor no Peito" ';
		$s = "SELECT * FROM antecedentes_pessoais WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'Dor no Peito'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/>
      </td>
      <td class="text" width="28%">Dor no Peito</td>
    </tr>
    <tr>
      <td class="text">
        <input type="checkbox" name="pessoais[]" value="Palpita��o" ';
		$s = "SELECT * FROM antecedentes_pessoais WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'Palpita��o'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/>
      </td>
      <td class="text">Palpita��o</td>
      <td class="text">
        <input type="checkbox" name="pessoais[]" value="Bonquite" ';
		$s = "SELECT * FROM antecedentes_pessoais WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'Bonquite'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/>
      </td>
      <td class="text">Bonquite</td>
      <td class="text">
        <input type="checkbox" name="pessoais[]" value="Asma" ';
		$s = "SELECT * FROM antecedentes_pessoais WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'Asma'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/>
      </td>
      <td class="text">Asma</td>
    </tr>
    <tr>
      <td class="text">
        <input type="checkbox" name="pessoais[]" value="Rinite" ';
		$s = "SELECT * FROM antecedentes_pessoais WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'Rinite'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/>
      </td>
      <td class="text">Rinite</td>
      <td class="text">
        <input type="checkbox" name="pessoais[]" value="Dor na Coluna" ';
		$s = "SELECT * FROM antecedentes_pessoais WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'Dor na Coluna'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/>
      </td>
      <td class="text">Dor na Coluna</td>
      <td class="text">
        <input type="checkbox" name="pessoais[]" value="Dor nas Costas" ';
		$s = "SELECT * FROM antecedentes_pessoais WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'Dor nas Costas'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/>
      </td>
      <td class="text">Dor nas Costas</td>
    </tr>
    <tr>
      <td class="text">
        <input type="checkbox" name="pessoais[]" value="Doen�as Renais" ';
		$s = "SELECT * FROM antecedentes_pessoais WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'Doen�as Renais'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/>
      </td>
      <td class="text">Doen�as Renais</td>
      <td class="text">
        <input type="checkbox" name="pessoais[]" value="Doen�a no F�gado" ';
		$s = "SELECT * FROM antecedentes_pessoais WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'Doen�a no F�gado'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/>
      </td>
      <td class="text">Doen�a no F�gado</td>
      <td class="text">
        <input type="checkbox" name="pessoais[]" value="Diabetes" ';
		$s = "SELECT * FROM antecedentes_pessoais WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'Diabetes'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/>
      </td>
      <td class="text">Diabetes</td>
    </tr>
    <tr>
      <td class="text">
        <input type="checkbox" name="pessoais[]" value="�lcera" ';
		$s = "SELECT * FROM antecedentes_pessoais WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = '�lcera'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/>
      </td>
      <td class="text">�lcera</td>
      <td class="text">
        <input type="checkbox" name="pessoais[]" value="Gastrite" ';
		$s = "SELECT * FROM antecedentes_pessoais WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'Gastrite'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/>
      </td>
      <td class="text">Gastrite</td>
      <td class="text">
        <input type="checkbox" name="pessoais[]" value="Resfriado" ';
		$s = "SELECT * FROM antecedentes_pessoais WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'Resfriado'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/>
      </td>
      <td class="text">Resfriado</td>
    </tr>
    <tr>
      <td class="text">
        <input type="checkbox" name="pessoais[]" value="Tosse Cr�nica" ';
		$s = "SELECT * FROM antecedentes_pessoais WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'Tosse Cr�nica'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/>
      </td>
      <td class="text">Tosse Cr�nica</td>
      <td class="text">
        <input type="checkbox" name="pessoais[]" value="Sinusite" ';
		$s = "SELECT * FROM antecedentes_pessoais WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'Sinusite'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/>
      </td>
      <td class="text">Sinusite</td>
      <td class="text"><input type="checkbox" name="pessoais[]" value="Otite" ';
		$s = "SELECT * FROM antecedentes_pessoais WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'Otite'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/></td>
      <td class="text">Otite</td>
    </tr>
    <tr>
      <td class="text">
        <input type="checkbox" name="pessoais[]" value="J� esteve internado" ';
		$s = "SELECT * FROM antecedentes_pessoais WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'J� esteve internado'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/>
      </td>
      <td class="text">J� esteve internado</td>
      <td class="text"><input type="checkbox" name="pessoais[]" value="Zumbido" ';
		$s = "SELECT * FROM antecedentes_pessoais WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'Zumbido'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/></td>
      <td class="text">Zumbido</td>
      <td class="text">
        <input type="checkbox" name="pessoais[]" value="Doen�a Mentaltal" ';
		$s = "SELECT * FROM antecedentes_pessoais WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'Doen�a Mentaltal'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/>
      </td>
      <td class="text">Doen�a Mental</td>
    </tr>
    <tr>
      <td class="text">
        <input type="checkbox" name="pessoais[]" value="Doen�a Nervosa" ';
		$s = "SELECT * FROM antecedentes_pessoais WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'Doen�a Nervosa'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/>
      </td>
      <td class="text">Doen�a Nervosa</td>
      <td class="text">
        <input type="checkbox" name="pessoais[]" value="Dor de Cabe�a" ';
		$s = "SELECT * FROM antecedentes_pessoais WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'Dor de Cabe�a'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/>
      </td>
      <td class="text">Dor de Cabe�a</td>
      <td class="text">
        <input type="checkbox" name="pessoais[]" value="Tontura" ';
		$s = "SELECT * FROM antecedentes_pessoais WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'Tontura'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/>
      </td>
      <td class="text">Tontura</td>
    </tr>
    <tr>
      <td class="text">
        <input type="checkbox" name="pessoais[]" value="Convuls�es" ';
		$s = "SELECT * FROM antecedentes_pessoais WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'Convuls�es'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/>
      </td>
      <td class="text">Convuls�es</td>
      <td class="text">
        <input type="checkbox" name="pessoais[]" value="Alergia" ';
		$s = "SELECT * FROM antecedentes_pessoais WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'Alergia'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/>
      </td>
      <td class="text">Alergia</td>
      <td class="text">
        <input type="checkbox" name="pessoais[]" value="Doen�as de Pele" ';
		$s = "SELECT * FROM antecedentes_pessoais WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'Doen�as de Pele'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/>
      </td>
      <td class="text">Doen�as de Pele</td>
    </tr>
    <tr>
      <td class="text">
        <input type="checkbox" name="pessoais[]" value="Reumatismo" ';
		$s = "SELECT * FROM antecedentes_pessoais WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'Reumatismo'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/>
      </td>
      <td class="text">Reumatismo</td>
      <td class="text"><input type="checkbox" name="pessoais[]" value="Sofreu Cirurgia" ';
		$s = "SELECT * FROM antecedentes_pessoais WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'Sofreu Cirurgia'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/></td>
      <td class="text">Sofreu Cirurgia</td>
      <td class="text">
        <input type="checkbox" name="pessoais[]" value="Varizes" ';
		$s = "SELECT * FROM antecedentes_pessoais WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'Varizes'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/>
      </td>
      <td class="text">Varizes</td>
    </tr>
    <tr>
      <td class="text">
        <input type="checkbox" name="pessoais[]" value="Varicocele" ';
		$s = "SELECT * FROM antecedentes_pessoais WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'Varicocele'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/>
      </td class="text">
      <td class="text">Varicocele</td>
      <td class="text">
        <input type="checkbox" name="pessoais[]" value="H�rnias" ';
		$s = "SELECT * FROM antecedentes_pessoais WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'H�rnias'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/>
      </td>
      <td class="text">H�rnias</td>
      <td class="text">
        <input type="checkbox" name="pessoais[]" value="Hemorr�idas" ';
		$s = "SELECT * FROM antecedentes_pessoais WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'Hemorr�idas'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/>
      </td>
      <td class="text">Hemorr�idas</td>
    </tr>
    <tr>
      <td class="text">
        <input type="checkbox" name="pessoais[]" value="Diarr�ia Frequente" ';
		$s = "SELECT * FROM antecedentes_pessoais WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'Diarr�ia Frequente'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/>
      </td>
      <td class="text">Diarr�ia Frequente</td>
      <td class="text">
        <input type="checkbox" name="pessoais[]" value="Executar Tarefas Pesadas" ';
		$s = "SELECT * FROM antecedentes_pessoais WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'Executar Tarefas Pesadas'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/>
      </td>
      <td class="text">Executar Tarefas Pesadas</td>
      <td class="text">
        <input type="checkbox" name="pessoais[]" value="Tem defeito F�sico" ';
		$s = "SELECT * FROM antecedentes_pessoais WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'Tem defeito F�sico'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/>
      </td>
      <td class="text">Tem defeito F�sico</td>
    </tr>
    <tr class="text">
      <td class="text"><input type="checkbox" name="pessoais[]" value="Etilismo (Bebe)" ';
		$s = "SELECT * FROM antecedentes_pessoais WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'Etilismo (Bebe)'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/></td>
      <td class="text">Etilismo (Bebe)</td>
      <td class="text">
        <input type="checkbox" name="pessoais[]" value="Tabagismo (Fumo)" ';
		$s = "SELECT * FROM antecedentes_pessoais WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]' AND doenca = 'Tabagismo (Fumo)'";
		$q = pg_query($s);
		if(pg_num_rows($q) != 0){
			echo ' checked="checked" ';
		}
		echo'/>
      </td>
      <td class="text">Tabagismo (Fumo)</td>
      <td class="text">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>';
  
$s3 = "SELECT * FROM exames_fisicos WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]'";
$q3 = pg_query($s3);
$et3 = @pg_fetch_array($q3);

        echo "</tr><tr><td class='text roundborder'>";
		echo'<table width="100%" border="0">
    <tr>
      <td colspan="10" align="center" class="text roundborderselected" ><b>3 - Exames F�sicos</b></td>
    </tr>
	<tr>
    <td class="text" width="7%" align="right" >Altura:&nbsp;&nbsp;</td>
    <td class="text" width="13%"><label>
      <input type="text" onkeypress=\"return FormataReais(this, '.', ',', event);\" name="altura_3" value="'.$et3["altura"].'" size="7" />
    </label></td>
    <td class="text" width="7%" align="right" >Peso:</td>
    <td class="text" width="13%"><label>
      <input type="text" onkeypress=\"return FormataReais(this, '.', ',', event);\" name="peso_3" value="'.$et3["peso"].'" size="7" />
    </label></td>
    <td class="text" width="7%" align="right" >P.A:</td>
    <td class="text" width="13%"><label>
      <input type="text" onkeypress=\"return FormataReais(this, '.', ',', event);\" name="pa_3" value="'.$et3["pa"].'" size="7" />
    </label></td>
    <td class="text" width="7%" align="right" >Pulso:</td>
    <td class="text" width="13%"><label>
      <input type="text" onkeypress=\"FormataReais(this, '.', ',', event);\" name="pulso_3" value="'.$et3["pulso"].'" size="7" />
    </label></td>
    <td class="text" width="7%" align="right" >F.R:</td>
    <td class="text" width="13%"><label>
      <input type="text" onkeypress=\"return FormataReais(this, '.', ',', event);\" name="fr_3" value="'.$et3["fr"].'" size="7" />
    </label></td>
  </tr>
  <tr>
    <td class="text" colspan="4">BioTipo:
		<input type="text" name="biotipo_3" value="'.$et3[biotipo].'" size="30" />
	</td>
    <td class="text" colspan="6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Aspecto Geral:
		<input type="text" name="aspecto_3" value="'.$et3[aspecto].'" size="42" />
	</td>
    </tr>
</table>';

        echo "</tr><tr><td class='text roundborder'>";
		
		echo'<table width="100%" border="0">
    <tr>
      <td align="center" class="text roundborderselected" ><b>4 - Exames Complementares</b></td>
    </tr>';
	


if(@pg_num_rows($rss)){
		
for($y=0;$y<pg_num_rows($rss);$y++){
	$sql = "SELECT ae.*, ex.*, a.* FROM aso_exame ae, exame ex, aso a 
			WHERE ae.cod_aso = '{$aso[$y][cod_aso]}'
			AND ex.cod_exame = ae.cod_exame
			AND '{$aso[$y][cod_aso]}' = a.cod_aso";
	$rs = @pg_query($sql);
	$exames = @pg_fetch_all($rs);
	
$data1 = $exames[$y][aso_data];
$partes = explode('-',$data1);
$dt = $partes[2].'/'.$partes[1].'/'.$partes[0];
	
	echo '<tr><td class="text"><b>Aso n�: '.$exames[$y][cod_aso].' - '.$dt.'</b></td>
			</tr>';
	
	for($x=0;$x<@pg_num_rows($rs);$x++){
		echo '<tr>
				<td class="text">'.$exames[$x]['especialidade'];
		echo '	</td>
			  </tr>';
	}
}
}else{
		echo '<tr>
				<td class="text">Nenhum ASO encontrado para este funcion�rio!
				</td>
			  </tr>';
}

	echo '
</table>';

        echo "</tr><tr><td class='text roundborder'>";
$s5 = "SELECT * FROM avaliaca_periodica WHERE cod_func = '$_GET[cod_func]' AND cod_cliente = '$_GET[cod_cliente]'";
$q5 = pg_query($s5);
$et5 = @pg_fetch_array($q5);

$data1 = $et5["data"];
$partes = explode('-',$data1);
$data = $partes[2].'/'.$partes[1].'/'.$partes[0];

$data1 = $et5["data_f"];
$partes = explode('-',$data1);
$data_f = $partes[2].'/'.$partes[1].'/'.$partes[0];

echo'<table width="100%" border="0">
    <tr>
      <td colspan="10" align="center" class="text roundborderselected" ><b>5 - Avalia��o M�dica Peri�dica</b></td>
    </tr>
    <tr id="avalia��o">
      <td class="text" width="5%">Data:</td>
      <td class="text" width="15%"><input type="text" value="'.$data.'" name="data_5" size="10" onkeypress="formatar(this, \'##/##/####\');" maxlength="10"/></td>
      <td class="text" width="5%">P.A:</td>
      <td class="text" width="15%"><input type="text" value="'.$et5["pa"].'" name="pa_5" size="11" /></td>
      <td class="text" width="5%">F.C:</td>
      <td class="text" width="15%"><input type="text" value="'.$et5["fc"].'" name="fc_5" size="10" /></td>
      <td class="text" width="5%">Peso:</td>
      <td class="text" width="15%"><input type="text" value="'.$et5["peso"].'" name="peso_5" size="10" /></td>
      <td class="text" width="5%">Altura:</td>
      <td class="text" width="15%"><input type="text" value="'.$et5["altura"].'" name="altura_5" size="10" /></td>
    </tr>';
	
 echo '
    <tr><td colspan="4" class="text">';
	    echo 'Tipo dos exames:
      <select name="tipo_5" id="tipo_5">
	  <option value=""></option> 
	  <option value="Admissional" ';
          if($et5["tipo"] == "Admissional"){
              echo ' selected '; 
          }
        echo '>Admissional</option>';
		
    echo '
      	<option value="Peri�dico" ';
          if($et5["tipo"] == "Peri�dico"){
              echo ' selected '; 
          }
        echo '>Peri�dico</option>';
		
    echo '
      	<option value="Mudan�a de Fun��o" ';
          if($et5["tipo"] == "Mudan�a de Fun��o"){
              echo ' selected '; 
          }
        echo '>Mudan�a de Fun��o</option>';
		
    echo '
      	<option value="Demissional" ';
          if($et5["tipo"] == "Demissional"){
              echo ' selected '; 
          }
        echo '>Demissional</option>';
		
    echo '
      	<option value="P�s-Demissional" ';
          if($et5["tipo"] == "P�s-Demissional"){
              echo ' selected '; 
          }
        echo '>P�s-Demissional</option>';
		
    echo '
      	<option value="Cl�nico Preventivo" ';
          if($et5["tipo"] == "Cl�nico Preventivo"){
              echo ' selected '; 
          }
        echo '>Cl�nico Preventivo</option></select>';
echo '   </td>';


 echo '
    </tr></table>';
	
        echo "<tr><td class='text roundborder'>";
		
		
echo'<table width="100%" border="0">
    <tr>
      <td colspan="2" width="100%" align="center" class="text roundborderselected" ><b>6 - Conclus�o</b></td>
    </tr>';
	
 echo '
    <td class="text" width="39%">';
	    echo 'Resultado:
      <select name="res_5" id="res_5">
	  <option value=""></option> 
      	<option value="Apto" ';
          if($et5["resultado"] == "Apto"){
              echo ' selected '; 
          }
        echo '>Apto</option>';
		
    echo '
      	<option value="Apto a trabalhar em altura" ';
          if($et5["resultado"] == "Apto a trabalhar em altura"){
              echo ' selected '; 
          }
        echo '>Apto a trabalhar em altura</option>';

    echo '
      	<option value="Apto para trabalhar com alimentos" ';
          if($et5["resultado"] == "Apto para trabalhar com alimentos"){
              echo ' selected '; 
          }
        echo '>Apto para trabalhar com alimentos</option>';

    echo '
      	<option value="Apto a trabalhar em espa�o confinado" ';
          if($et5["resultado"] == "Apto a trabalhar em espa�o confinado"){
              echo ' selected '; 
          }
        echo '>Apto a trabalhar em espa�o confinado</option>';

    echo '
      	<option value="Apto com restri��o" ';
          if($et5["resultado"] == "Apto com restri��o"){
              echo ' selected '; 
          }
        echo '>Apto com restri��o</option>';
		
    echo '
      	<option value="Inapto" ';
          if($et5["resultado"] == "Inapto"){
              echo ' selected '; 
          }
        echo '>Inapto</option></select></td>
		
		<td class="text" >
			  &nbsp;Data do relat�rio: <input type="text" value="'.$data_f.'" name="data_f_5" size="10" onkeypress="formatar(this, \'##/##/####\');" maxlength="10"/></td>
</tr></table>';
		
echo'
	</tr>
	
</table>';

echo '<center><input name="enviar" type="submit" value="Salvar" class="btn" /></center>';

		echo "</td></tr>";
	
echo '</table>';


echo "</td></tr></table>";        


	echo "</td>";
echo "</tr>";
echo "</table>";

?>
