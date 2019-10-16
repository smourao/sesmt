<?PHP

$sql = "SELECT * FROM clinicas ORDER BY cod_clinica";
$res = pg_query($sql);
$buffer = pg_fetch_all($res);
	   
echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
/**************************************************************************************************/
// -->  LEFT SIDE
/**************************************************************************************************/
echo "<td width=250 class='text roundborder' valign=top>";
		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
		echo "<td height=13 align=center class='text roundborderselected'>Clínica conveniada";
		echo "</td>";
	   for($x=0;$x<pg_num_rows($res);$x++){
		  echo "<tr class='text roundbordermix'>";
		  echo "<td align=left class='text roundborder curhand' onclick=\"location.href='?dir=repasse&p=index&act=detail&id={$buffer[$x][cod_clinica]}';\" alt='Clique' title='Clique aqui para visualizar os exames cadastrados'>{$buffer[$x]['razao_social_clinica']}&nbsp;</td>";
		  echo "</tr>";
	   }
		echo "</table>";
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
	
if($_GET['act']=='detail'){

	   $sql = "SELECT * FROM clinicas WHERE cod_clinica = '{$_GET['id']}'";
	   $res = pg_query($sql);
	   $buffer = pg_fetch_array($res);
	   echo '<center><b><font color=white>'.$buffer[razao_social_clinica].'</font></b><br>
			 <font color=white size=1><b>CNPJ: ';
	   print $buffer[cnpj_clinica] != "" ? $buffer[cnpj_clinica] : "N/D";
	   echo '</b></font></center>';
	   echo '<p>';
	   echo '<table width=100% border=0 cellpadding=2 cellspacing=2>';
	   echo '<tr>';
	   echo '    <td class="text roundborder " width=30%><b>Endereço</b></td><td class="text roundborder " >'.$buffer[endereco_clinica].' Nº'.$buffer[num_end].'&nbsp;</td>';
	   echo '</tr>';
	   echo '<tr>';
	   echo '    <td class="text roundborder "><b>Bairro</b></td><td class="text roundborder ">'.$buffer[bairro_clinica].'&nbsp;</td>';
	   echo '</tr>';
	   echo '<tr>';
	   echo '    <td class="text roundborder "><b>Cidade/Estado</b></td><td class="text roundborder ">'.$buffer[cidade].'/'.$buffer[estado].'&nbsp;</td>';
	   echo '</tr>';
	   echo '<tr>';
	   echo '    <td class="text roundborder "><b>CEP</b></td><td class="text roundborder ">'.$buffer[cep_clinica].'&nbsp;</td>';
	   echo '</tr>';
	if(!empty($buffer[referencia_clinica])){
	   echo '<tr>';
	   echo '    <td class="text roundborder "><b>Ponto de Referência</b></td><td class="text roundborder ">'.$buffer[referencia_clinica].'&nbsp;</td>';
	   echo '</tr>';
	}
	if(!empty($buffer[tel_clinica])){
	   echo '<tr>';
	   echo '    <td class="text roundborder "><b>Telefone</b></td><td class="text roundborder ">'.$buffer[tel_clinica].'&nbsp;</td>';
	   echo '</tr>';
	}
	if(!empty($buffer[fax_clinica])){
	   echo '<tr>';
	   echo '    <td class="text roundborder "><b>Fax</b></td><td class="text roundborder ">'.$buffer[fax_clinica].'&nbsp;</td>';
	   echo '</tr>';
	}
	   echo '<tr>';
	   echo '    <td class="text roundborder "><b>E-Mail</b></td><td class="text roundborder ">'.$buffer[email_clinica].'&nbsp;</td>';
	   echo '</tr>';
	if(!empty($buffer[contato_clinica])){
	   echo '<tr>';
	   echo '    <td class="text roundborder "><b>Pessoa de Contato</b></td><td class="text roundborder ">'.$buffer[contato_clinica].'&nbsp;</td>';
	   echo '</tr>';
	}
	if(!empty($buffer[cargo_responsavel])){
	   echo '<tr>';
	   echo '    <td class="text roundborder "><b>Cargo Contato</b></td><td class="text roundborder ">'.$buffer[cargo_responsavel].'&nbsp;</td>';
	   echo '</tr>';
	}
	if(!empty($buffer[tel_contato])){
	   echo '<tr>';
	   echo '    <td class="text roundborder "><b>Tel Contato</b></td><td class="text roundborder ">'.$buffer[tel_contato].'&nbsp;</td>';
	   echo '</tr>';
	}
	if(!empty($buffer[nextel_contato]) || !empty($buffer[id_nextel_contato])){
	   echo '<tr>';
	   echo '    <td class="text roundborder "><b>Nextel</b></td><td class="text roundborder ">'.$buffer[nextel_contato].' - id '.$buffer[id_nextel_contato].'&nbsp;</td>';
	   echo '</tr>';
	}
	if(!empty($buffer[email_contato])){
	   echo '<tr>';
	   echo '    <td class="text roundborder "><b>E-Mail Contato</b></td><td class="text roundborder ">'.$buffer[email_contato].'&nbsp;</td>';
	   echo '</tr>';
	}
	   echo '<tr>';
	   echo '    <td class="text roundborder "><b>Status</b></td><td class="text roundborder ">'; print $buffer[ativo] == 0 ? "<font color=red><b>Inativo</b></font>" : "<font color=green><b>Ativo</b></font>"; echo '&nbsp;</td>';
	   echo '</tr>';
	   echo '</table>';
	   
/**************************************************************************************************/
// --> PARTE QUE TRATA DOS DETALHES DOS REPASSES
/**************************************************************************************************/				
		   echo '<p><center><b><font color=white>Exames Realizados</font></b></center>';
		   echo '<p>';
		   echo '<table width=100% border=0 cellpadding=2 cellspacing=2>';
		   echo '<tr>';
		   echo '    <td class="text roundborder" width=20%><b><center>Período de apuração</b></td>';
		   echo '    <td class="text roundborder" width=20% ><b><center>Nº de exames</b></td>';
		   echo '    <td class="text roundborder" width=20%><b><center>Valor total</b></td>';
		   echo '    <td class="text roundborder" width=20%><b><center>Relatório</center></b></td>';
		   echo '</tr>';
		   
//2012 ****************************************************
for($a=2012;$a<=2012;$a++){
	for($y=1;$y<=12;$y++){
		$mes1 = $y;
		
		if($mes1 == 1 || $mes1 == 3 || $mes1 == 5 || $mes1 == 7 || $mes1 == 8 || $mes1 == 10 || $mes1 == 12){
			
			$dia1 = 31;
			
			
		}elseif($mes1 == 2){
			
			$bisexto = 2012;
			if ((($bisexto % 4) == 0 and ($bisexto % 100)!=0) or ($bisexto % 400)==0){
				
				$dia1 = 29;
				
			}else{
			
				$dia1 = 28;
				
			}
		}else{
		
			$dia1 = 30;	
			
		}
		if($mes1<10){
			$mes1='0'.$mes1;
		}
		$mes2 = $y+1;
		if($mes2<10){
			$mes2='0'.$mes2;
		}
		$consulta = "SELECT *
					FROM repasse  
					WHERE (confirma_data BETWEEN '".$a."-".$mes1."-01' AND '".$a."-".$mes1."-20') 
					AND cod_clinica = $_GET[id] 
					ORDER BY cod_aso";
					
		$dados = @pg_query($consulta);
		$buffer = @pg_fetch_all($dados);
		if(@pg_num_rows($dados) <> 0){
			for($x=0;$x<pg_num_rows($dados);$x++){
			$total[$y] += $buffer[$x][valor];
			}
			
			if($total[$y]){
				echo "<tr>
						  <td class='text roundborder' align=center> 01-".$mes1."-".$a." a ".$dia1."-".$mes1."-".$a."</td>
						  <td class='text roundborder' align=center>".pg_num_rows($dados)."</td>
						  <td class='text roundborder' align=center>".number_format($total[$y], 2, ',','.')."</td>
						  <td class='text roundborder' align=center><input name=ver type=button value='Visualizar' class='btn' onmouseover=\"showtip('tipbox', '- Visualizar o relatório do período selecionado.');\" onmouseout=\"hidetip('tipbox');\" onclick=\"newWindow('".current_module_path."relatorio/?id=".$_GET['id']."&mes=".$mes1."&ano=".$a."');\"></td>
					  </tr>";
			}
		}
	}
}
//2013	*************************************************
		/* $consulta = "SELECT *
					FROM repasse  
					WHERE (confirma_data BETWEEN '2012-12-01' AND '2013-01-20') 
					AND cod_clinica = $_GET[id] 
					ORDER BY cod_aso";
					
		$dados = @pg_query($consulta);
		$buffer = @pg_fetch_all($dados);
		if(@pg_num_rows($dados) <> 0){
			for($x=0;$x<pg_num_rows($dados);$x++){
			$total2 += $buffer[$x][valor];
			}
			
			if($total){
				echo "<tr>
						  <td class='text roundborder' align=center> 01-12-2012 a 20-01-2013</td>
						  <td class='text roundborder' align=center>".pg_num_rows($dados)."</td>
						  <td class='text roundborder' align=center>".number_format($total2, 2, ',','.')."</td>
						  <td class='text roundborder' align=center><input name=ver type=button value='Visualizar' class='btn' onmouseover=\"showtip('tipbox', '- Visualizar o relatório do período selecionado.');\" onmouseout=\"hidetip('tipbox');\" onclick=\"newWindow('".current_module_path."relatorio/?id=".$_GET['id']."&mes=12');\"></td>
					  </tr>";
			}
		} */
$total[1] = 0;
$total[2] = 0;
$total[3] = 0;
$total[4] = 0;
$total[5] = 0;
$total[6] = 0;
$total[7] = 0;
$total[8] = 0;
$total[9] = 0;
$total[10] = 0;
$total[11] = 0;
$total[12] = 0;

//2013 ****************************************************
for($a=2013;$a<=2013;$a++){
	for($y=1;$y<=12;$y++){
		$mes1 = $y;
		
		if($mes1 == 1 || $mes1 == 3 || $mes1 == 5 || $mes1 == 7 || $mes1 == 8 || $mes1 == 10 || $mes1 == 12){
			
			$dia1 = 31;
			
			
		}elseif($mes1 == 2){
			
			$bisexto = 2013;
			if ((($bisexto % 4) == 0 and ($bisexto % 100)!=0) or ($bisexto % 400)==0){
				
				$dia1 = 29;
				
			}else{
			
				$dia1 = 28;
				
			}
		}else{
		
			$dia1 = 30;	
			
		}
		if($mes1<10){
			$mes1='0'.$mes1;
		}
		$mes2 = $y+1;
		if($mes2<10){
			$mes2='0'.$mes2;
		}
		$consulta = "SELECT *
					FROM repasse  
					WHERE (confirma_data BETWEEN '".$a."-".$mes1."-01' AND '".$a."-".$mes1."-20') 
					AND cod_clinica = $_GET[id] 
					ORDER BY cod_aso";
					
		$dados = @pg_query($consulta);
		$buffer = @pg_fetch_all($dados);
		if(@pg_num_rows($dados) <> 0){
			for($x=0;$x<pg_num_rows($dados);$x++){
			$total[$y] += $buffer[$x][valor];
			}
			
			if($total[$y]){
				echo "<tr>
						  <td class='text roundborder' align=center> 01-".$mes1."-".$a." a ".$dia1."-".$mes1."-".$a."</td>
						  <td class='text roundborder' align=center>".pg_num_rows($dados)."</td>
						  <td class='text roundborder' align=center>".number_format($total[$y], 2, ',','.')."</td>
						  <td class='text roundborder' align=center><input name=ver type=button value='Visualizar' class='btn' onmouseover=\"showtip('tipbox', '- Visualizar o relatório do período selecionado.');\" onmouseout=\"hidetip('tipbox');\" onclick=\"newWindow('".current_module_path."relatorio/?id=".$_GET['id']."&mes=".$mes1."&ano=".$a."');\"></td>
					  </tr>";
			}
		}
	}
}
		
//*************************************************
	
	
//2014	*************************************************
	/*	$consulta = "SELECT *
					FROM repasse  
					WHERE (confirma_data BETWEEN '2013-12-01' AND '2014-01-20') 
					AND cod_clinica = $_GET[id] 
					ORDER BY cod_aso";
					
		$dados = @pg_query($consulta);
		$buffer = @pg_fetch_all($dados);
		if(@pg_num_rows($dados) <> 0){
			for($xx=0;$xx<pg_num_rows($dados);$xx++){
			$total2 += $buffer[$xx][valor];
			}
			
			if($total){
				echo "<tr>
						  <td class='text roundborder' align=center> 01-12-2013 a 20-01-2014</td>
						  <td class='text roundborder' align=center>".pg_num_rows($dados)."</td>
						  <td class='text roundborder' align=center>".number_format($total2, 2, ',','.')."</td>
						  <td class='text roundborder' align=center><input name=ver type=button value='Visualizar' class='btn' onmouseover=\"showtip('tipbox', '- Visualizar o relatório do período selecionado.');\" onmouseout=\"hidetip('tipbox');\" onclick=\"newWindow('".current_module_path."relatorio/?id=".$_GET['id']."&mes=12');\"></td>
					  </tr>";
			}
		} */
$total[1] = 0;
$total[2] = 0;
$total[3] = 0;
$total[4] = 0;
$total[5] = 0;
$total[6] = 0;
$total[7] = 0;
$total[8] = 0;
$total[9] = 0;
$total[10] = 0;
$total[11] = 0;
$total[12] = 0;

	
//2014 ****************************************************
for($a=2014;$a<=2014;$a++){
	for($yy=1;$yy<=12;$yy++){
		$mes1 = $yy;
		
		if($mes1 == 1 || $mes1 == 3 || $mes1 == 5 || $mes1 == 7 || $mes1 == 8 || $mes1 == 10 || $mes1 == 12){
			
			$dia1 = 31;
			
			
		}elseif($mes1 == 2){
			
			$bisexto = 2014;
			if ((($bisexto % 4) == 0 and ($bisexto % 100)!=0) or ($bisexto % 400)==0){
				
				$dia1 = 29;
				
			}else{
			
				$dia1 = 28;
				
			}
		}else{
		
			$dia1 = 30;	
			
		}
		if($mes1<10){
			$mes1='0'.$mes1;
		}
		$mes2 = $yy+1;
		if($mes2<10){
			$mes2='0'.$mes2;
		}
		$consulta = "SELECT *
					FROM repasse  
					WHERE (confirma_data BETWEEN '".$a."-".$mes1."-01' AND '".$a."-".$mes1."-".$dia1."') 
					AND cod_clinica = $_GET[id] 
					ORDER BY cod_aso";
					
		$dados = @pg_query($consulta);
		$buffer = @pg_fetch_all($dados);
		if(@pg_num_rows($dados) <> 0){
			for($xx=0;$xx<pg_num_rows($dados);$xx++){
			$total[$yy] += $buffer[$xx][valor];
			}
			
			if($total[$yy]){
				echo "<tr>
						  <td class='text roundborder' align=center> 01-".$mes1."-".$a." a ".$dia1."-".$mes1."-".$a."</td>
						  <td class='text roundborder' align=center>".pg_num_rows($dados)."</td>
						  <td class='text roundborder' align=center>".number_format($total[$yy], 2, ',','.')."</td>
						  <td class='text roundborder' align=center><input name=ver type=button value='Visualizar' class='btn' onmouseover=\"showtip('tipbox', '- Visualizar o relatório do período selecionado.');\" onmouseout=\"hidetip('tipbox');\" onclick=\"newWindow('".current_module_path."relatorio/?id=".$_GET['id']."&mes=".$mes1."&ano=".$a."');\"></td>
					  </tr>";
			}
		}
	}
}
		
//*************************************************
	
	
//2015	*************************************************
		/*$consulta = "SELECT *
					FROM repasse  
					WHERE (confirma_data BETWEEN '2014-12-01' AND '2015-01-20') 
					AND cod_clinica = $_GET[id] 
					ORDER BY valor";
					
		$dados = @pg_query($consulta);
		$buffer = @pg_fetch_all($dados);
		
		if(@pg_num_rows($dados) <> 0){
			$total2 = 0;
			for($xx=0;$xx<pg_num_rows($dados);$xx++){
			$total2 += $buffer[$xx][valor];
			}
			
			if($total){
				echo "<tr>
						  <td class='text roundborder' align=center> 01-12-2015 a 31-01-2015</td>
						  <td class='text roundborder' align=center>".pg_num_rows($dados)."</td>
						  <td class='text roundborder' align=center>".number_format($total2, 2, ',','.')."</td>
						  <td class='text roundborder' align=center><input name=ver type=button value='Visualizar' class='btn' onmouseover=\"showtip('tipbox', '- Visualizar o relatório do período selecionado.');\" onmouseout=\"hidetip('tipbox');\" onclick=\"newWindow('".current_module_path."relatorio/?id=".$_GET['id']."&mes=12');\"></td>
					  </tr>";
			}
		}
		
		*/
$total[1] = 0;
$total[2] = 0;
$total[3] = 0;
$total[4] = 0;
$total[5] = 0;
$total[6] = 0;
$total[7] = 0;
$total[8] = 0;
$total[9] = 0;
$total[10] = 0;
$total[11] = 0;
$total[12] = 0;

	
//2015 ****************************************************
for($a=2015;$a<=2015;$a++){
	for($yy=1;$yy<=12;$yy++){
		$mes1 = $yy;
		
		if($mes1 == 1 || $mes1 == 3 || $mes1 == 5 || $mes1 == 7 || $mes1 == 8 || $mes1 == 10 || $mes1 == 12){
			
			$dia1 = 31;
			
			
		}elseif($mes1 == 2){
			
			$bisexto = 2015;
			if ((($bisexto % 4) == 0 and ($bisexto % 100)!=0) or ($bisexto % 400)==0){
				
				$dia1 = 29;
				
			}else{
			
				$dia1 = 28;
				
			}
		}else{
		
			$dia1 = 30;	
			
		}
		if($mes1<10){
			$mes1='0'.$mes1;
		}
		$mes2 = $yy+1;
		if($mes2<10){
			$mes2='0'.$mes2;
		}
		$consulta = "SELECT *
					FROM repasse  
					WHERE (confirma_data BETWEEN '".$a."-".$mes1."-01' AND '".$a."-".$mes1."-".$dia1."') 
					AND cod_clinica = $_GET[id] 
					ORDER BY valor";
					
		$dados = @pg_query($consulta);
		$buffer = @pg_fetch_all($dados);
		if(@pg_num_rows($dados) <> 0){
			for($xx=0;$xx<pg_num_rows($dados);$xx++){
			$total[$yy] += $buffer[$xx][valor];
			}
			
			if($total[$yy]){
				echo "<tr>
						  <td class='text roundborder' align=center> 01-".$mes1."-".$a." a ".$dia1."-".$mes1."-".$a."</td>
						  <td class='text roundborder' align=center>".pg_num_rows($dados)."</td>
						  <td class='text roundborder' align=center>".number_format($total[$yy], 2, ',','.')."</td>
						  <td class='text roundborder' align=center><input name=ver type=button value='Visualizar' class='btn' onmouseover=\"showtip('tipbox', '- Visualizar o relatório do período selecionado.');\" onmouseout=\"hidetip('tipbox');\" onclick=\"newWindow('".current_module_path."relatorio/?id=".$_GET['id']."&mes=".$mes1."&ano=".$a."');\"></td>
					  </tr>";
			}
		}
	}
}
		
//*************************************************



//*************************************************
	
	
//2016	*************************************************
	/*	$consulta = "SELECT *
					FROM repasse  
					WHERE (confirma_data BETWEEN '2015-12-01' AND '2016-01-20') 
					AND cod_clinica = $_GET[id] 
					ORDER BY valor";
					
		$dados = @pg_query($consulta);
		$buffer = @pg_fetch_all($dados);
		
		if(@pg_num_rows($dados) <> 0){
			$total2 = 0;
			for($xx=0;$xx<pg_num_rows($dados);$xx++){
			$total2 += $buffer[$xx][valor];
			}
			
			if($total){
				echo "<tr>
						  <td class='text roundborder' align=center> 01-12-2016 a 31-01-2016</td>
						  <td class='text roundborder' align=center>".pg_num_rows($dados)."</td>
						  <td class='text roundborder' align=center>".number_format($total2, 2, ',','.')."</td>
						  <td class='text roundborder' align=center><input name=ver type=button value='Visualizar' class='btn' onmouseover=\"showtip('tipbox', '- Visualizar o relatório do período selecionado.');\" onmouseout=\"hidetip('tipbox');\" onclick=\"newWindow('".current_module_path."relatorio/?id=".$_GET['id']."&mes=12');\"></td>
					  </tr>";
			}
		} */
$total[1] = 0;
$total[2] = 0;
$total[3] = 0;
$total[4] = 0;
$total[5] = 0;
$total[6] = 0;
$total[7] = 0;
$total[8] = 0;
$total[9] = 0;
$total[10] = 0;
$total[11] = 0;
$total[12] = 0;

	
//2016 ****************************************************
for($a=2016;$a<=2016;$a++){
	for($yy=1;$yy<=12;$yy++){
		$mes1 = $yy;
		
		if($mes1 == 1 || $mes1 == 3 || $mes1 == 5 || $mes1 == 7 || $mes1 == 8 || $mes1 == 10 || $mes1 == 12){
			
			$dia1 = 31;
			
			
		}elseif($mes1 == 2){
			
			$bisexto = 2016;
			if ((($bisexto % 4) == 0 and ($bisexto % 100)!=0) or ($bisexto % 400)==0){
				
				$dia1 = 29;
				
			}else{
			
				$dia1 = 28;
				
			}
		}else{
		
			$dia1 = 30;	
			
		}
		if($mes1<10){
			$mes1='0'.$mes1;
		}
		$mes2 = $yy+1;
		if($mes2<10){
			$mes2='0'.$mes2;
		}
		$consulta = "SELECT *
					FROM repasse  
					WHERE (confirma_data BETWEEN '".$a."-".$mes1."-01' AND '".$a."-".$mes1."-".$dia1."') 
					AND cod_clinica = $_GET[id] 
					ORDER BY valor";
					
		$dados = @pg_query($consulta);
		$buffer = @pg_fetch_all($dados);
		if(@pg_num_rows($dados) <> 0){
			for($xx=0;$xx<pg_num_rows($dados);$xx++){
			$total[$yy] += $buffer[$xx][valor];
			}
			
			if($total[$yy]){
				echo "<tr>
						  <td class='text roundborder' align=center> 01-".$mes1."-".$a." a ".$dia1."-".$mes1."-".$a."</td>
						  <td class='text roundborder' align=center>".pg_num_rows($dados)."</td>
						  <td class='text roundborder' align=center>".number_format($total[$yy], 2, ',','.')."</td>
						  <td class='text roundborder' align=center><input name=ver type=button value='Visualizar' class='btn' onmouseover=\"showtip('tipbox', '- Visualizar o relatório do período selecionado.');\" onmouseout=\"hidetip('tipbox');\" onclick=\"newWindow('".current_module_path."relatorio/?id=".$_GET['id']."&mes=".$mes1."&ano=".$a."');\"></td>
					  </tr>";
			}
		}
	}
}
		
//*************************************************
//2017	*************************************************
	/*	$consulta = "SELECT *
					FROM repasse  
					WHERE (confirma_data BETWEEN '2016-12-01' AND '2017-01-20') 
					AND cod_clinica = $_GET[id] 
					ORDER BY valor";
					
		$dados = @pg_query($consulta);
		$buffer = @pg_fetch_all($dados);
		
		if(@pg_num_rows($dados) <> 0){
			$total2 = 0;
			for($xx=0;$xx<pg_num_rows($dados);$xx++){
			$total2 += $buffer[$xx][valor];
			}
			
			if($total){
				echo "<tr>
						  <td class='text roundborder' align=center> 01-12-2017 a 31-01-2017</td>
						  <td class='text roundborder' align=center>".pg_num_rows($dados)."</td>
						  <td class='text roundborder' align=center>".number_format($total2, 2, ',','.')."</td>
						  <td class='text roundborder' align=center><input name=ver type=button value='Visualizar' class='btn' onmouseover=\"showtip('tipbox', '- Visualizar o relatório do período selecionado.');\" onmouseout=\"hidetip('tipbox');\" onclick=\"newWindow('".current_module_path."relatorio/?id=".$_GET['id']."&mes=12');\"></td>
					  </tr>";
			}
		} */
$total[1] = 0;
$total[2] = 0;
$total[3] = 0;
$total[4] = 0;
$total[5] = 0;
$total[6] = 0;
$total[7] = 0;
$total[8] = 0;
$total[9] = 0;
$total[10] = 0;
$total[11] = 0;
$total[12] = 0;

	
//2017 ****************************************************
for($a=2017;$a<=2017;$a++){
	for($yy=1;$yy<=12;$yy++){
		$mes1 = $yy;
		
		if($mes1 == 1 || $mes1 == 3 || $mes1 == 5 || $mes1 == 7 || $mes1 == 8 || $mes1 == 10 || $mes1 == 12){
			
			$dia1 = 31;
			
			
		}elseif($mes1 == 2){
			
			$bisexto = 2017;
			if ((($bisexto % 4) == 0 and ($bisexto % 100)!=0) or ($bisexto % 400)==0){
				
				$dia1 = 29;
				
			}else{
			
				$dia1 = 28;
				
			}
		}else{
		
			$dia1 = 30;	
			
		}
		if($mes1<10){
			$mes1='0'.$mes1;
		}
		$mes2 = $yy+1;
		if($mes2<10){
			$mes2='0'.$mes2;
		}
		$consulta = "SELECT *
					FROM repasse  
					WHERE (confirma_data BETWEEN '".$a."-".$mes1."-01' AND '".$a."-".$mes1."-".$dia1."') 
					AND cod_clinica = $_GET[id] 
					ORDER BY valor";
					
		$dados = @pg_query($consulta);
		$buffer = @pg_fetch_all($dados);
		if(@pg_num_rows($dados) <> 0){
			for($xx=0;$xx<pg_num_rows($dados);$xx++){
			$total[$yy] += $buffer[$xx][valor];
			}
			
			if($total[$yy]){
				echo "<tr>
						  <td class='text roundborder' align=center> 01-".$mes1."-".$a." a ".$dia1."-".$mes1."-".$a."</td>
						  <td class='text roundborder' align=center>".pg_num_rows($dados)."</td>
						  <td class='text roundborder' align=center>".number_format($total[$yy], 2, ',','.')."</td>
						  <td class='text roundborder' align=center><input name=ver type=button value='Visualizar' class='btn' onmouseover=\"showtip('tipbox', '- Visualizar o relatório do período selecionado.');\" onmouseout=\"hidetip('tipbox');\" onclick=\"newWindow('".current_module_path."relatorio/?id=".$_GET['id']."&mes=".$mes1."&ano=".$a."');\"></td>
					  </tr>";
			}
		}
	}
}
		
//*************************************************



$total[1] = 0;
$total[2] = 0;
$total[3] = 0;
$total[4] = 0;
$total[5] = 0;
$total[6] = 0;
$total[7] = 0;
$total[8] = 0;
$total[9] = 0;
$total[10] = 0;
$total[11] = 0;
$total[12] = 0;


//2018 ****************************************************
for($a=2018;$a<=2018;$a++){
	for($yy=1;$yy<=12;$yy++){
		$mes1 = $yy;
		
		if($mes1 == 1 || $mes1 == 3 || $mes1 == 5 || $mes1 == 7 || $mes1 == 8 || $mes1 == 10 || $mes1 == 12){
			
			$dia1 = 31;
			
			
		}elseif($mes1 == 2){
			
			$bisexto = 2018;
			if ((($bisexto % 4) == 0 and ($bisexto % 100)!=0) or ($bisexto % 400)==0){
				
				$dia1 = 29;
				
			}else{
			
				$dia1 = 28;
				
			}
		}else{
		
			$dia1 = 30;	
			
		}
		if($mes1<10){
			$mes1='0'.$mes1;
		}
		$mes2 = $yy+1;
		if($mes2<10){
			$mes2='0'.$mes2;
		}
		$consulta = "SELECT *
					FROM repasse  
					WHERE (confirma_data BETWEEN '".$a."-".$mes1."-01' AND '".$a."-".$mes1."-".$dia1."') 
					AND cod_clinica = $_GET[id] 
					ORDER BY valor";
					
		$dados = @pg_query($consulta);
		$buffer = @pg_fetch_all($dados);
		if(@pg_num_rows($dados) <> 0){
			for($xx=0;$xx<pg_num_rows($dados);$xx++){
			$total[$yy] += $buffer[$xx][valor];
			}
			
			if($total[$yy]){
				echo "<tr>
						  <td class='text roundborder' align=center> 01-".$mes1."-".$a." a ".$dia1."-".$mes1."-".$a."</td>
						  <td class='text roundborder' align=center>".pg_num_rows($dados)."</td>
						  <td class='text roundborder' align=center>".number_format($total[$yy], 2, ',','.')."</td>
						  <td class='text roundborder' align=center><input name=ver type=button value='Visualizar' class='btn' onmouseover=\"showtip('tipbox', '- Visualizar o relatório do período selecionado.');\" onmouseout=\"hidetip('tipbox');\" onclick=\"newWindow('".current_module_path."relatorio/?id=".$_GET['id']."&mes=".$mes1."&ano=".$a."');\"></td>
					  </tr>";
			}
		}
	}
}
		
//*************************************************


	
	
	echo "</table>";
}
	
echo "</td>";
echo "</tr>";
echo "</table>";

/*
$id = $_GET[id];

		$consulta = "SELECT ae.*, 
					a.cod_aso, a.aso_data, a.cod_cliente, a.cod_func, 
					e.*, 
					c.cliente_id, c.razao_social, 
					f.cod_func, f.nome_func, f.cod_cliente, 
					ce.*, 
					cl.cod_clinica, cl.por_exames  
					FROM aso_exame ae, aso a, exame e, cliente c, funcionarios f, clinica_exame ce, clinicas cl  
					WHERE ae.confirma = 1
					AND a.cod_aso = ae.cod_aso
					AND ae.cod_exame = e.cod_exame 
					AND a.cod_cliente = c.cliente_id
					AND a.cod_func = f.cod_func
					AND f.cod_cliente = a.cod_cliente
					AND ce.cod_exame = ae.cod_exame
					AND ce.cod_exame = e.cod_exame
					AND ce.cod_clinica = a.cod_clinica
					AND ce.cod_clinica = cl.cod_clinica
					AND cl.cod_clinica = a.cod_clinica
					AND (ae.data BETWEEN '2012-11-21' AND '2012-12-20')
					ORDER BY a.cod_aso ";
		$dados = pg_query($consulta);
		$buffer = pg_fetch_all($dados);
		
	for($x=0;$x<pg_num_rows($dados);$x++){
		
		$cod_clinica = $buffer[$x][cod_clinica];
		$cod_exame = $buffer[$x][cod_exame];
		$cod_cliente = $buffer[$x][cod_cliente];
		$cod_func = $buffer[$x][cod_func];
		$cod_aso = $buffer[$x][cod_aso];
		$valor = $buffer[$x][por_exames]*$buffer[$x][preco_exame]/100;
		$nome_func = $buffer[$x][nome_func];
		$nome_exame = $buffer[$x][especialidade];
		$nome_cliente = $buffer[$x][razao_social];
		$confirma_data = $buffer[$x][data];
		
		$sql = "INSERT INTO repasse(cod_clinica, cod_exame, cod_cliente, cod_func, cod_aso, valor, nome_func, nome_exame, nome_cliente, confirma_data) 
				VALUES('$cod_clinica', '$cod_exame', '$cod_cliente', '$cod_func', '$cod_aso', '$valor', '$nome_func', '$nome_exame', '$nome_cliente', '$confirma_data')";
		$inserir = pg_query($sql);		
		}
*/		
?>