<?php 
/*Parte que trata as sugestões que serão excluidas*/
if( !empty($_GET[exame]) )
{
	$exame = $_GET[exame];
	$query_excluir = $query_excluir . "DELETE FROM aso_exame WHERE cod_exame = $exame and cod_aso = $_GET[aso];";
	$result_excluir = pg_query($query_excluir);

	if ($result_excluir) {
		showMessage('O exame foi excluído com sucesso!');
	}
} 
/************ Fim da exclusão *************/
if(($_GET[funcionario] != "") and ($_GET[aso] != "") and ($_GET[cod_cliente] != "") and $_POST){
	if(isset($_POST["exame"])) // verifica se tem exames selecionados
	{
	$qua=0;
		foreach($_POST["exame"] as $exame) // recebe a lista de exames
		{
			$dt = explode("/", $_POST["data".$exame]);
			$data = $dt[2]."/".$dt[1]."/".$dt[0];

			$sql_verifica = "SELECT * FROM aso_exame WHERE cod_aso = $_GET[aso] and cod_exame = $exame";
			$result_verifica = pg_query($sql_verifica);

			if ( pg_num_rows($result_verifica)==0 ){
			// monta o insert no banco
			$query_aso_exame = $query_aso_exame . "INSERT INTO aso_exame(cod_aso, cod_exame, data)
												   VALUES 
												   ($_GET[aso], $exame, '$data');";
			}else{
				$sql_jatem = "SELECT especialidade FROM exame WHERE cod_exame = $exame";
				$result_jatem = pg_query($sql_jatem);
				$row_jatem = pg_fetch_array($result_jatem);
				showMessage('O exame $row_jatem[especialidade] já está cadastrada!');
			}
			$qua++;
		}
		$result_aso_exame = @pg_query($query_aso_exame);

		if ($result_aso_exame) { // se os inserts foram corretos
			showMessage('Os dados foram cadastradas com sucesso!');
		}
	}
}

echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
/**************************************************************************************************/
// -->  LEFT SIDE
/**************************************************************************************************/
     echo "<td width=250 class='text roundborder' valign=top>";
	 	echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
		echo "<td align=center class='text roundborderselected'>";
			echo "<b>opção</b>";
		echo "</td>";
		echo "</tr>";
		echo "</table>";
		
		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
		echo "<td align=center class='text roundborder'>";			
		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
		echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Relação Func.' onclick=\"location.href='?dir=cad_cliente&p=cadastro_func&cod_cliente=$_GET[cod_cliente]';\" onmouseover=\"showtip('tipbox', '- Volta para tela de relação de funcionários.');\" onmouseout=\"hidetip('tipbox');\"></td>";
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
        echo "<b>Exames Complementares</b>";
        echo "</td>";
        echo "</tr>";
        echo "</table>";

/************************************************************************************************/
/*                  ACTION: MAIN FORM!                                                          */
/************************************************************************************************/
		if ($_GET[funcionario] and $_GET[aso] and $_GET[cod_cliente] ) {
		$sql_tem_exame = "SELECT cod_exame, cod_aso FROM aso_exame WHERE cod_aso = $_GET[aso]";
		$result_tem_exame = pg_query($sql_tem_exame);
		if ( pg_num_rows($result_tem_exame)==0 ){ // se NÃO tiver nada cadastrado
			$query_exame = "SELECT cod_exame, especialidade FROM exame order by especialidade"; 
		}
		else{ // se tiver cadastrado
		
			while ( $exame_fora = pg_fetch_array($result_tem_exame) ){ // monta variável com valores que serão excluídos da consulta
				$row_fora = $row_fora . ", $exame_fora[cod_exame]";
			}
			$query_exame = "SELECT cod_exame, especialidade FROM exame where cod_exame not in (" . substr($row_fora,2,200) . ") order by especialidade"; /* como o primeiro caracter é vígula, pegar a partir do segundo para não dar erro na consulta*/
		}
		
		$result_exame = pg_query($query_exame);
		echo "<form name=form1 method=post>";
		echo "<table width=100% border=0 cellpadding=2 cellspacing=2>";
			while($row_exame=pg_fetch_array($result_exame)){ 
				echo "<tr class='text roundbordermix'>
				<td align=left class='roundborder text'>";
				echo "<input type='checkbox' name='exame[]' value='$row_exame[cod_exame]'>&nbsp;&nbsp;$row_exame[especialidade]";
				echo "</td><td width=20 align=left class='roundborder text'>";
				echo "<input type=text name=data".$row_exame[cod_exame]." value=''>";
				echo "</td>";
				echo "</tr>";
			}
		echo "</table>";
	}	
//BUSCA INFORMAÇÕES DA TABELA DE EXAMES
$sql_exame = "SELECT ae.cod_aso, ae.data, e.especialidade, ae.cod_exame
				 FROM aso_exame ae, exame e, aso a
				 where ae.cod_exame = e.cod_exame
				 and ae.cod_aso = a.cod_aso
				 and ae.cod_aso = $_GET[aso]
				 order by e.especialidade";

$result_exame = pg_query($sql_exame);

	if(pg_num_rows($result_exame)>0){
		echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
		echo "<tr>";
		echo "<td class='text' align=center colspan=3><h2>Exames já Cadastrados:</h2></td>";
		echo "</tr>";
		$total = 0;
		while($row_exame = pg_fetch_array($result_exame)){
			echo "<tr class='text roundbordermix'>";
			echo "<td width=10 align=center class='roundborder text'><a href=\"?dir=gerar_aso&p=complementar&aso=$aso&exame=$row_exame[cod_exame]&funcionario=$funcionario&setor=$setor&cod_cliente=$_GET[cod_cliente]\"><u>Excluir</u></a></td>";
			echo "<td align=left class='roundborder text' class='text'>&nbsp;$row_exame[especialidade] </td>";
			echo "<td width=20 align=left class='roundborder text' class='text'>".date("d/m/Y", strtotime($row_exame[data]))." </td>";
			echo "</tr>";
			$exame_fora = $exame_fora . ", $row_exame[cod_exame]";
	/***************************/
		}
		echo "</table>";
	}//echo "aqui" . $sql_exame;

	echo "<p>";

echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
    echo "<tr>";
    echo "<td align=left class='text'>";
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
            echo "<td align=center class='text roundbordermix'>";
            echo "<input type='submit' class='btn' name='btnSave' value='Gravar' onmouseover=\"showtip('tipbox', '- Gravar, armazenará todos os dados funcionário.');\" onmouseout=\"hidetip('tipbox');\" >";
			echo "</td>";
        echo "</tr>";
        echo "</table>";
    echo "</tr>";
echo "</table>";
echo "</form>";  

    echo "<p>";
/**************************************************************************************************/
// -->
/**************************************************************************************************/
    echo "</td>";
echo "</tr>";
echo "</table>";
?>
