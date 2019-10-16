<script type='text/javascript' src='http://files.rafaelwendel.com/jquery.js'></script>
<script type="application/javascript">

function maiuscula(id) {
            //palavras para ser ignoradas
	var wordsToIgnore = ["DOS", "DAS", "de", "do", "dos", "das"],
	minLength = 2;
	var str = $('#'+id).val();
	var getWords = function(str) {
		return str.match(/\S+\s*/g);
	}
	$('#'+id).each(function () {
		var words = getWords(this.value);
		$.each(words, function (i, word) {
		// somente continua se a palavra nao estiver na lista de ignorados
		if (wordsToIgnore.indexOf($.trim(word)) == -1 && $.trim(word).length > minLength) {
			words[i] = words[i].charAt(0).toUpperCase() + words[i].slice(1).toLowerCase();
		} else{
			words[i] = words[i].toLowerCase();}
		});
		this.value = words.join("");
	});
};


$(document).ready( function() {
   /* Executa a requisi??o quando o campo CNPJ perder o foco */
   $('#cnpj_cliente').blur(function(){



           /* Configura a requisi??o AJAX */
           $.ajax({
                url : 'modules/triagem_medica/consultar_cnpj_avulso.php', /* URL que ser? chamada */
                type : 'GET', /* Tipo da requisi??o */
                data: 'cnpj_cliente=' + $('#cnpj_cliente').val(), /* dado que ser? enviado via POST */
                dataType: 'json', /* Tipo de transmiss?o */
                success: function(data){
                    if(data.sucesso == 1){
                        $('#razao_social_cliente').val(data.razao_social_cliente);
                        $('#endereco_cliente').val(data.endereco_cliente);
                        $('#cep_cliente').val(data.cep_cliente);
                        $('#cnae').val(data.cnae);
						$('#grau_risco').val(data.grau_risco);

                        $('#nome_func').focus();
                    }
                }
           });
   return false;
   })
});




function irReceita(){


	window.open("https://www.receita.fazenda.gov.br/PessoaJuridica/CNPJ/cnpjreva/cnpjreva_solicitacao2.asp");


}



</script>


<?PHP

/***************************************************************************************************/
// --> VARIABLES
/***************************************************************************************************/
?>

<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>
<tr>
<td width=250 class='text roundborder' valign=top>




				<table width=250 border=0 cellspacing=3 cellpadding=2>
                <tr>
                <td align=center class='text roundborderselected'>
                    <b>Triagem Médica</b>
                </td>
                </tr>
                </table>
                
                
                
                
                <table width=250 border=0 cellspacing=3 cellpadding=2>
                <tr>
                    <td class="roundbordermix text" height=30 align=center onmouseover=\"showtip('tipbox', '- Informe o ano de referência ao Relatório em Busca para visualizar os gerados.');\" onmouseout=\"hidetip('tipbox');\">
                       <table border=0 width=100% align=center>
                        <tr>
                        <td class="text"><b><input type="submit" class="btn" value="Novo" onclick="location.href='<?php echo "?dir=$_GET[dir]&p=$_GET[p]&novo=true" ?>'"></b></td>
                        
						<td rowspan=2 align=center class="text">
                        <input type="submit" class="btn" value="Lista" onClick="location.href='<?php echo "?dir=$_GET[dir]&p=$_GET[p]&lista=true" ?>'">
                        </td>
						
                        </tr>
						
						

                        </table>
						
						
                        
                    </td>
                </tr>
                </table>
				
				<br />
				
				<table width=250 border=0 cellspacing=3 cellpadding=2>
                <tr>
                <td align=center class='text roundborderselected'>
                    <b>Filtrar por Semana</b>
                </td>
                </tr>
                </table>
				<table width=250 border=0 cellspacing=3 cellpadding=2>
				<?php 
				if($_GET['semana']){
					$semana = $_GET['semana'];
				}else{
					$consultasql = "SELECT * FROM financeiro_relatorio WHERE ano = ".date('Y')." ORDER BY id DESC LIMIT 1";
					$consultaquery = pg_query($consultasql);
					$consulta = pg_fetch_array($consultaquery);
					$semana = $consulta['semana'];
				}
					for($x=1;$x<54;$x++){ 
						$consultasql = "SELECT * FROM financeiro_relatorio WHERE semana = $x AND ano = ".date('Y')." ORDER BY id DESC LIMIT 1";
						$consultaquery = pg_query($consultasql);
						$consulta = pg_fetch_all($consultaquery);
						$consultanum = pg_num_rows($consultaquery);
						echo $consulta[ano];
						if($consultanum != 0){
							

				?>
				
                <tr>
				
                    <td class="text <?php if($semana == $x) echo "roundborderselected"; else echo "roundbordermix";  ?> curhand" align="center" onClick="location.href='<?php echo "?dir=triagem_medica&p=index&semana=".$x ?>'">
						<?php echo 'Semana '.$x; ?>
                    </td>
						<?php }} ?>
                </tr>
		
                </table>
                
                <P>
                
                <?php
                // --> TIPBOX
				?>
                <table width=250 border=0 cellspacing=3 cellpadding=2>
                <tr>
                    <td class=text height=30 valign=top align=justify>
                        <div id="tipbox" class="roundborderselected text" style="display: none;">&nbsp;</div>
                    </td>
                </tr>
                </table>
		</td>
				
				
		 <td class="text roundborder" valign=top>
        <table width=100% border=0 cellspacing=2 cellpadding=2>
        <tr>
        <td align=center class="text roundborderselected">
            <b>Triagem Médica</b>
            
        </td>
        </tr>
        <tr>
        <td>
        <?php
		if($_GET[novo]){
			?>
            <?PHP

/***************************************************************************************************/


/***************************************************************************************************/


if($_POST[enviar]){

	if($_POST['cnae'] != "00.00-0"){
		$cnae = $_POST['cnae'];

		$pegarmaxsql = "SELECT max(cod_aso) as maximo FROM aso_avulso";
		$pegarmaxquery = pg_query($pegarmaxsql);
		$pegarmax = pg_fetch_array($pegarmaxquery);
		$cod_aso = $pegarmax[maximo] +1;

		$query_cnae="SELECT grau_risco FROM cnae WHERE cnae='".$cnae."' LIMIT 1";
		$result_cnae=pg_query($query_cnae);
		$row_cnae=pg_fetch_array($result_cnae);
		$cnaenum = pg_num_rows($result_cnae);

		if($cnaenum >= 1)
		$grau_risco = $row_cnae['grau_risco'];
		else
		$grau_risco = '0';

		$razao_social = $_POST['razao_social_cliente'];
		$endereco = $_POST['endereco_cliente'];
		$cep = $_POST['cep_cliente'];
		$cnpj_cliente = $_POST['cnpj_cliente'];

		$aso_data_lancamento = $_POST['aso_data_lancamento'];
		$aso_valor = $_POST['aso_valor'];
		$aso_semana = $_POST['aso_semana'];
	
		$tipo_exame = $_POST['tipo_exame'];
		$nome_func = $_POST['nome_func'];
		$num_ctps_func = $_POST['ctps'];
		$serie_ctps_func = $_POST['serie'];
		$cbo = $_POST['cbo'];
		$rg = $_POST['rg'];
		$nome_funcao = $_POST['funcao'];
		$dinamica_funcao = $_POST['atv_lab'];
		$data = date("d")."/".date("m")."/".date("Y");
		$datafatura = date("Y-m-d");
		$dia = date("d");
		$mes = date("m");
		$ano = date("Y");
		$semana = idate('W');
		$anointeiro = idate('Y');


		$tipo_aso = $_POST['tipo_aso'];


		if($tipo_aso == 2){
			$descricao_aso = 'Pagamento aso retroativo do mesmo ano';
			$preco_aso = 50.00;
			$preco_aso2 = 50;


		}
		else if($tipo_aso == 3){
			$descricao_aso = 'Pagamento aso retroativo de 1 ano';
			$preco_aso = 120.00;
			$preco_aso2 = 120;

		}
		else if($tipo_aso == 4){
			$descricao_aso = 'Pagamento aso retroativo de 2 ano';
			$preco_aso = 150.00;
			$preco_aso2 = 150;

		}
		else if($tipo_aso == 5){
			$descricao_aso = 'Pagamento aso retroativo de 3 ano';
			$preco_aso = 190.00;
			$preco_aso2 = 190;

		}
		else if($tipo_aso == 6){
			$descricao_aso = 'Pagamento aso retroativo de 4 ano';
			$preco_aso = 260.00;
			$preco_aso2 = 260;

		}
		else if($tipo_aso == 7){
			$descricao_aso = 'Pagamento aso retroativo de 5 ano';
			$preco_aso = 300.00;
			$preco_aso2 = 300;

		}
		else{
			$descricao_aso = 'Pagamento aso avulso';
			$preco_aso = 35.00;
			$preco_aso2 = 35;

			$precoespecifico_sql = "SELECT preco_aso FROM preco_aso_cnpj WHERE cnpj_cliente = '{$cnpj_cliente}' AND status = 0";
			$precoespecifico_query = pg_query($precoespecifico_sql);
			$precoespecifico = pg_fetch_array($precoespecifico_query);
			$precoespecificonum = pg_num_rows($precoespecifico_query);

			if($precoespecificonum >= 1){

				$preco_aso = $precoespecifico[preco_aso];
				$preco_aso2 = $precoespecifico[preco_aso];

			}
		}
		
		if($_POST['descricao_aso']){
			$descricao_aso = $_POST['descricao_aso'];
		}


		$insertindosql = "INSERT INTO aso_avulso (cod_aso, razao_social_cliente, endereco_cliente, cep_cliente, cnpj_cliente, cnae, grau_risco, tipo_exame, nome_func, num_ctps_func, serie_ctps_func, cbo, nome_funcao, dinamica_funcao, data, rg)
	VALUES ($cod_aso,'$razao_social','$endereco','$cep','$cnpj_cliente','$cnae',$grau_risco,'$tipo_exame','$nome_func','$num_ctps_func','$serie_ctps_func','$cbo','$nome_funcao','$dinamica_funcao','$data', '$rg')";

		if(pg_query($insertindosql)){



			//$query_fatura_max = "SELECT max(id) as cod_fatura FROM financeiro_info";
			//$result_fatura_max = pg_query($query_fatura_max);
			//$row_fatura_max = pg_fetch_array($result_fatura_max);

			//$query_fatura2_max = "SELECT max(id) as cod_fatura FROM financeiro_fatura";
			//$result_fatura2_max = pg_query($query_fatura2_max);
			//$row_fatura2_max = pg_fetch_array($result_fatura2_max);

			$query_relatorio_max = "SELECT max(id) as cod_relatorio FROM financeiro_relatorio";
			$result_relatorio_max = pg_query($query_relatorio_max);
			$row_relatorio_max = pg_fetch_array($result_relatorio_max);
			
			$cod_fatura = $row_fatura_max[cod_fatura] + 1;
			$cod_fatura2 = $row_fatura2_max[cod_fatura] + 1;
			$cod_relatorio = $row_relatorio_max[cod_relatorio] + 1;



			//Inserindo na Tabela financeiro_info

		//$receita1sql = "INSERT INTO financeiro_info (titulo, cod_aso, valor_total, n_parcelas, forma_pagamento, status, data, dia, mes ,ano, data_lancamento, data_entrada_saida, tipo_lancamento, historico, funcionario_id, pc) VALUES ('$razao_social', '$cod_aso', $preco_aso, 1, 'Dinheiro', 0, '$datafatura', '$dia', '$mes', '$ano', '$datafatura', '$datafatura', 24, '$descricao_aso', 0, 0)";

		//$receita1query = pg_query($receita1sql);



		//Inserindo na Tabela financeiro_fatura

		//$receita2sql = "INSERT INTO financeiro_fatura (cod_fatura, cod_aso, titulo, valor, parcela_atual, vencimento, status, pago, data_lancamento, numero_doc, numero_cheque) VALUES ($cod_fatura, '$cod_aso', '$razao_social', $preco_aso2, 1, '$datafatura', 0, 0, '$datafatura', '', '')";

		//$receita2query = pg_query($receita2sql);



		//Inserindo na Tabela financeiro_relatorio

		$relatoriosql = "INSERT INTO financeiro_relatorio (cod_fatura, cod_aso, titulo, valor, status, pago, historico, data_lancamento, semana, ano) VALUES ($cod_fatura, '$cod_aso', '$razao_social', $aso_valor, 0, 0, '$descricao_aso', '$aso_data_lancamento', $aso_semana, $anointeiro)";

		$fatura_relatorio = pg_query($relatoriosql);





			$headers = "MIME-Version: 1.0\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\n";
			$headers .= "From: SESMT - Segurança do Trabalho e Higiene Ocupacional. <suporte@sesmt-rio.com> \n";
			$maill = "financeiro@sesmt-rio.com";

			$msgg = "
	<!DOCTYPE HTML PUBLIC -//W3C//DTD HTML 4.0 Transitional//EN>
				   <HTML>
				   <HEAD>
					  <TITLE>Comunicado sobre o vencimento da Fatura</TITLE>
				<META http-equiv=Content-Type content=\"text/html; charset=iso-8859-1\">
				<META content=\"MSHTML 6.00.2900.3157\" name=GENERATOR>
				<style type=\"text/css\">
				td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}
				.style2 {font-family: Verdana, Arial, Helvetica, sans-serif}
				.style13 {font-size: 14px}
				.style15 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10; }
				.style16 {font-size: 9px}
				.style17 {font-family: Arial, Helvetica, sans-serif}
				.style18 {font-size: 12px}
				</style>
				   </HEAD>
				   <BODY>
				   
				   
				   <table width=100% border=0>
			<tr>
			<td align='left'>
				<p><strong>
				<font size='7' face='Verdana, Arial, Helvetica, sans-serif'>SESMT<sup><font size=3>®</font></sup></font>&nbsp;&nbsp;
				<font size='1' face='Verdana, Arial, Helvetica, sans-serif'>SERVIÇOS ESPECIALIZADOS DE SEGURANÇA<br> E MONITORAMENTO DE ATIVIDADES NO TRABALHO<br>
				CNPJ&nbsp; 04.722.248/0001-17 &nbsp;&nbsp;INSC. MUN.&nbsp; 311.213-6</font></strong>
				</td>
				 <td width=40% align='right'>
				<font face='Verdana, Arial, Helvetica, sans-serif' size='4'>
				<b>&nbsp;</b>
				</td>
		   
			</tr>
			</table>
			<br>
			<br>
			<br>
			<br>
			<br>";

			$msgg .= "Foi feito um ASO avulso, os dados abaixo:<br>";
			$msgg .= "Nome: ".$nome_func."<br>";
			$msgg .= "Empresa: ".$razao_social."<br>";
			$msgg .= "CNPJ: ".$cnpj_cliente."<br>";
			$msgg .= "CNAE: ".$cnae."<br>";
			$msgg .= "Grau de Risco: ".$grau_risco."<br>";
			$msgg .= "Endereço: ".$endereco."<br>";
			$msgg .= "Tipo exame: ".$tipo_exame."<br>";
			$msgg .= "Data: ".$data."<br>";

			$msgg .= "
			<br>
			<br>
			<br>
			<br>
			<br>


			<table width=100% border=0>
			<tr>
			<td align=left width=88%><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >Telefone: +55 (21) 3014 4304   Fax: Ramal 7</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >Nextel: +55 (21) 9700 31385 - Id 55*23*31641</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=3 >faleprimeirocomagente@sesmt-rio.com / medicotrab@sesmt-rio.com</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >www.sesmt-rio.com</font></td><td width=12%><font face=\"Verdana, Arial, Helvetica, sans-serif\"><b>
		 Pensando em<br>renovar seus<br>programas?<br>Fale primeiro<br>com a gente!</b>
		 </td>
		   </tr>
			</table>





				   </body></html>";


			mail($maill, "Aso Avulso (".$nome_func.") - ".$razao_social, $msgg, $headers);

			echo "<script>alert('Código do ASO: ".$cod_aso."');</script>";
			echo "<script>window.location.href = '?dir=triagem_medica&p=index';</script>";

		}else{

			echo "<script>alert('Erro: Falar com Suporte');</script>";
			echo "<script>window.location.href = '?dir=triagem_medica&p=index';</script>";

		}
	}else{
		echo "<script>alert('CNAE inválido!');window.history.back();</script>";
	}

}








echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";

	echo "<tr>";

    	echo "<td align=center class='text roundborderselected'>";

        	echo "<b>Cadastro da Triagem</b> ";

		echo "</td>";

    echo "</tr>";

echo "</table>";

    

echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";

	echo "<tr>";

    	echo "<td align=left class='text'>";
						
		
		?>
				<form action="" id="frm" method="post">
		<?php
		
			
		
			echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
	
				echo "<tr>";
	
					echo "<td width=33% align=center class='text'>";
	
					echo "<b>CNPJ</b>";
	
					echo "</td>";
	
					echo "<td width=67% align=center class='text'>";
	
					echo "<b>Razão Social</b>";
	
					echo "</td>";
	 
				echo "</tr>";
				
				echo "<tr>";
				
					echo "<td align=center class='text roundbordermix curhand'>";
					
					
                    echo "<input type='text' size=20 name='cnpj_cliente' id='cnpj_cliente' maxlength='18' onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '##.###.###/####-##');\">";
	
						
                        
                   
	
					echo "</td>";
	
					echo "<td align=center class='text roundbordermix curhand'>";
					
					?>
					<input type='text' name='razao_social_cliente' id='razao_social_cliente' size='55' onkeyup="maiuscula('razao_social_cliente')" required>
						
						
					 <?php
	
					echo "</td>";
				
				echo "</tr>";
				
			 echo "</table>";
			 
			 echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
			 
				echo "<tr>";
	
					echo "<td width=33% align=center class='text'>";
	
						echo "<b>CEP</b>";
	
					echo "</td>";
	
					echo "<td width=67% align=center class='text'>";
	
						echo "<b>Endereço</b>";
	
					echo "</td>";
	
				echo "</tr>";
				
				echo "<tr>";
				
					echo "<td align=center class='text roundbordermix curhand'>";
	
					   echo "<input type='text' name='cep_cliente' id='cep_cliente' size='20' maxlength='9' onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '#####-###');\" required>";
	
					echo "</td>";
	
					echo "<td align=center class='text roundbordermix curhand'>";
	
						
						?>
    <input type='text' name='endereco_cliente' id='endereco_cliente' size='55' onkeyup="maiuscula('endereco_cliente')" required>
    <?php
	
					echo "</td>";
					
				echo "</tr>";
				
			echo "</table>";
			
			echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
	
				echo "<tr>";
	
					echo "<td width=33% align=center class='text'>";
	
					echo "<b>CNAE</b>";
	
					echo "</td>";
					
					echo "<td width=34% align=center class='text'>";
	
					echo "<b>Tipo de Exame</b>";
	
					echo "</td>";
	
					echo "<td width=33% align=center class='text'>";
	
					echo "<b>Tipo do ASO</b>";
	
					echo "</td>";
					
				echo "</tr>";
				
				echo "<tr>";
				
					echo "<td align=center class='text roundbordermix curhand'>";
	
						echo "<input type='text' size=6 name='cnae' id='cnae' maxlength='7' onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '##.##-#');\" onBlur=\"check_cnae(this);\" required>&nbsp;<span id='verify_cnae'></span><input type='button' value='Pesquisar' class='btn title='Click aqui para consultar com o CNPJ o número do CNAE' onClick='irReceita()'>";
	
					echo "</td>";
	
					
					echo "<td align=center class='text roundbordermix curhand'>";
					
						echo "<select name='tipo_exame' required>";
							
							echo "<option></option>";
							echo "<option value='Admissional'>Admissional</option>";
							echo "<option value='Periódico'>Periódico</option>";
							echo "<option value='Demissional'>Demissional</option>";
							echo "<option value='Retorno ao Trabalho'>Retorno ao Trabalho</option>";
							echo "<option value='Mudança de Função'>Mudança de Função</option>";
						
						echo "</select>";
	
					echo "</td>";
					
					
					echo "<td align=center class='text roundbordermix curhand'>";
					
						echo '<select name="tipo_aso" required>
								<option value="1">Comercial</option>
								<option value="2">Retroativo mesmo ano</option>
								<option value="3">Retroativo 1 ano</option>
								<option value="4">Retroativo 2 ano</option>
								<option value="5">Retroativo 3 ano</option>
								<option value="6">Retroativo 4 ano</option>
								<option value="7">Retroativo 5 ano</option>
							</select>';
	
					echo "</td>";
					
					
				
				echo "</tr>";
				
			 echo "</table>";
			 
			 echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
	
				echo "<tr>";
	
					echo "<td width=67% align=center class='text'>";
	
					echo "<b>Nome do Funcionário</b>";
	
					echo "</td>";
	
					echo "<td width=16,5% align=center class='text'>";
	
					echo "<b>CTPS</b>";
	
					echo "</td>";
					
					echo "<td width=16,5% align=center class='text'>";
	
					echo "<b>Série</b>";
	
					echo "</td>";
	 
				echo "</tr>";
				
				echo "<tr>";
				
					echo "<td align=center class='text roundbordermix curhand'>";
	
					?>
	
						<input type='text' name='nome_func' id='nome_func' size='57' onkeyup="maiuscula('nome_func')" required>
                        
                    <?php 
	
					echo "</td>";
	
					echo "<td align=center class='text roundbordermix curhand'>";
					
						echo "<input type='text' name='ctps' size='8'>";
	
					echo "</td>";
					
					echo "<td align=center class='text roundbordermix curhand'>";
					
						echo "<input type='text' name='serie' size='5'>";
	
					echo "</td>";
				
				echo "</tr>";
				
			 echo "</table>";
			 
			 echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
	
				echo "<tr>";
	
					echo "<td width=33% align=center class='text'>";
	
					echo "<b>RG</b>";
	
					echo "</td>";
	
					echo "<td width=34% align=center class='text'>";
	
					echo "<b>CBO</b>";
	
					echo "</td>";
					
					echo "<td width=33% align=center class='text'>";
	
					echo "<b>Função</b>";
	
					echo "</td>";
	 
				echo "</tr>";
				
				echo "<tr>";
				
					echo "<td align=center class='text roundbordermix curhand'>";
	
						echo "<input maxlength='18' type='text' name='rg' size='20' required OnKeyPress=\"formatar(this, '##.###.###-# #####');\">";
	
					echo "</td>";
					
					echo "<td align=center class='text roundbordermix curhand'>";
	
						echo "<input maxlength='7' type='text' name='cbo' size='20' required onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '####.##');\">";
	
					echo "</td>";
	
					echo "<td align=center class='text roundbordermix curhand'>";
					
					?>
					
						<input type='text' name='funcao' id='funcao' size='20' onkeyup="maiuscula('funcao')" required>
	
					</td>
					
			
                       <?php
	
					
				echo "</tr>";
				
			 echo "</table>";
			 
			 
			 echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
	
				echo "<tr>";
	
					echo "<td width=100% align=center class='text'>";
	
					echo "<b>Atividade Laborativa</b>";
	
					echo "</td>";
	 
				echo "</tr>";
				
				echo "<tr>";
				
					?>
					
					<td align=center class='text roundbordermix curhand'>
					
						<input type='text' name='atv_lab' id='atv_lab' size='94' onkeyup="maiuscula('atv_lab')" required>
                        
                       <?php
	
					echo "</td>";
				
				echo "</tr>";
				
			 echo "</table>";

			 
			 echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
	
				echo "<tr>";
	
					echo "<td width=33% align=center class='text'>";
	
					echo "<b>Valor</b>";
	
					echo "</td>";
	
					echo "<td width=34% align=center class='text'>";
	
					echo "<b>Data Lançamento</b>";
	
					echo "</td>";
					
					echo "<td width=33% align=center class='text'>";
	
					echo "<b>Semana</b>";
	
					echo "</td>";
	 
				echo "</tr>";
				
				echo "<tr>";
				
					echo "<td align=center class='text roundbordermix curhand'>";
	
						echo "<input type='number' name='aso_valor' value='35' size='20' required>";
					
	
					echo "</td>";
					
					echo "<td align=center class='text roundbordermix curhand'>";
	
						echo "<input type='date' name='aso_data_lancamento' value='".date("Y-m-d")."' size='20' required>";
	
					echo "</td>";
	
					echo "<td align=center class='text roundbordermix curhand'>";
					
					?>
					
						<input type='number' name='aso_semana' id='aso_semana' size='20' value="<?php echo $semana; ?>" required>
	
					</td>
					
					
                        
                       <?php
	
				
				
				echo "</tr>";
				
				
		
				
			 echo "</table>";
			 
			 
			 echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
	
				echo "<tr>";
	
					echo "<td width=100% align=center class='text'>";
	
					echo "<b>Descrição do Serviço</b>";
	
					echo "</td>";
	 
				echo "</tr>";
				
				echo "<tr>";
				
					?>
					
					<td align=center class='text roundbordermix curhand'>
					
						<input type='text' name='descricao_aso' id='descricao_aso' size='94'>
                        
                       <?php
	
					echo "</td>";
				
				echo "</tr>";
				
			 echo "</table>";

			
		echo "</td>";
					
	echo "</tr>";
			
echo "</table>";
			
	echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
			
		echo "<tr>";
			
			echo "<td align=center class='text roundbordermix curhand'>";
			
				echo "<input class='btn' type='submit' name='enviar'>";
			
			echo "</td>";
			
		echo "</tr>";
			
	echo "</table>";
			
echo "</form>";

echo "</table>";
		 

?>
            <?php
			
		}elseif($_GET[lista]){
			require_once("lista_triagem.php");
			
		}elseif($_GET[editar]){
			?>
            <?PHP

/***************************************************************************************************/
	

/***************************************************************************************************/


if($_POST[enviarr]){
	
	if($_POST['cnae'] != "00.00-0"){

		$cod_aso = $_GET[editar];
		
		$cnae = $_POST['cnae'];
		$semana = $_GET['semana'];
		
		$query_cnae="SELECT grau_risco FROM cnae WHERE cnae='".$cnae."'";
		$result_cnae=pg_query($query_cnae);
		$row_cnae=pg_fetch_array($result_cnae);
		$cnaenum = pg_num_rows($result_cnae);
		
		if($cnaenum >= 1)
		$grau_risco = $row_cnae[grau_risco];
		else
		$grau_risco = '0';
		
		$razao_social = $_POST['razao_social_cliente'];
		$endereco = $_POST['endereco_cliente'];
		$cep = $_POST['cep_cliente'];
		$cnpj_cliente = $_POST['cnpj_cliente'];
		$tipo_exame = $_POST['tipo_exame'];
		$nome_func = $_POST['nome_func'];
		$num_ctps_func = $_POST['ctps'];
		$serie_ctps_func = $_POST['serie'];
		$cbo = $_POST['cbo'];
		$rg = $_POST['rg'];
		$nome_funcao = $_POST['funcao'];
		$dinamica_funcao = $_POST['atv_lab'];
		$aso_semana = $_POST['aso_semana'];
		$aso_valor = $_POST['aso_valor'];
		$aso_data_lancamento = $_POST['aso_data_lancamento'];
		$fr_id = $_POST['fr_id'];
		
		
		
		$tipo_aso = $_POST['tipo_aso'];
		
		
		if($tipo_aso == 2){
			$descricao_aso = 'Pagamento aso retroativo do mesmo ano';
			$preco_aso = 50.00;
			$preco_aso2 = 50;
		}
		else if($tipo_aso == 3){
			$descricao_aso = 'Pagamento aso retroativo de 1 ano';
			$preco_aso = 120.00;
			$preco_aso2 = 120;
			
		}
		else if($tipo_aso == 4){
			$descricao_aso = 'Pagamento aso retroativo de 2 ano';
			$preco_aso = 150.00;
			$preco_aso2 = 150;
			
		}
		else if($tipo_aso == 5){
			$descricao_aso = 'Pagamento aso retroativo de 3 ano';
			$preco_aso = 190.00;
			$preco_aso2 = 190;
			
		}
		else if($tipo_aso == 6){
			$descricao_aso = 'Pagamento aso retroativo de 4 ano';
			$preco_aso = 260.00;
			$preco_aso2 = 260;
			
		}
		else if($tipo_aso == 7){
			$descricao_aso = 'Pagamento aso retroativo de 5 ano';
			$preco_aso = 300.00;
			$preco_aso2 = 300;
			
		}
		else{
			$descricao_aso = 'Pagamento aso avulso';
			$preco_aso = 35.00;
			$preco_aso2 = 35;
			
		}
		
		if($_POST['descricao_aso']){
			$descricao_aso = $_POST['descricao_aso'];
		}
		
		
		
		$updatesetsql = "UPDATE aso_avulso SET razao_social_cliente = '{$razao_social}',endereco_cliente = '{$endereco}',cep_cliente = '{$cep}',cnae = '{$cnae}',grau_risco = '{$grau_risco}',tipo_exame = '{$tipo_exame}',nome_func = '{$nome_func}',num_ctps_func = '{$num_ctps_func}', serie_ctps_func = '{$serie_ctps_func}', cbo = '{$cbo}', rg = '{$rg}', nome_funcao = '{$nome_funcao}', dinamica_funcao = '{$dinamica_funcao}' WHERE cod_aso = {$cod_aso}";
		$updatesetsql2 = "UPDATE financeiro_relatorio SET semana = '{$aso_semana}',data_lancamento = '{$aso_data_lancamento}',valor = '{$aso_valor}' ,historico = '{$descricao_aso}' WHERE id = {$fr_id}";
		
		
		if(pg_query($updatesetsql) && pg_query($updatesetsql2)){
			
			echo "<script>alert('Atualizado!');</script>";
			echo "<script>window.location.href = '?dir=triagem_medica&p=index&editar={$cod_aso}&semana={$semana}';</script>";
			
		}else{
			
			echo "<script>alert('Erro: Falar com Suporte');</script>";
			echo "<script>window.location.href = '?dir=triagem_medica&p=index&editar={$cod_aso}&semana={$semana}';</script>";
			
		}
	}
		
}

if(isset($_GET[editar])){
	
	$cod_aso = $_GET[editar];
	
	$sqleditar = "SELECT aso_avulso.*, financeiro_relatorio.cod_aso, financeiro_relatorio.historico, financeiro_relatorio.valor, financeiro_relatorio.data_lancamento, financeiro_relatorio.semana, financeiro_relatorio.id as fr_id FROM aso_avulso JOIN financeiro_relatorio ON aso_avulso.cod_aso = financeiro_relatorio.cod_aso WHERE aso_avulso.cod_aso = {$cod_aso}";
	
	$queryeditar = pg_query($sqleditar);
	
	$editar_aso = pg_fetch_array($queryeditar);
	
	
	$razao_social = $editar_aso['razao_social_cliente'];
	$endereco_cliente = $editar_aso['endereco_cliente'];
	$cnpj_cliente = $editar_aso['cnpj_cliente'];
	$cep_cliente = $editar_aso['cep_cliente'];
	$cnae = $editar_aso['cnae'];
	$grau_risco = $editar_aso['grau_risco'];
	$tipo_exame = $editar_aso['tipo_exame'];
	$nome_func = $editar_aso['nome_func'];
	$num_ctps_func = $editar_aso['num_ctps_func'];
	$serie_ctps_func = $editar_aso['serie_ctps_func'];
	$nome_funcao = $editar_aso['nome_funcao'];
	$cbo = $editar_aso['cbo'];
	$rg = $editar_aso['rg'];
	$dinamica_funcao = $editar_aso['dinamica_funcao'];
	$aso_valor = $editar_aso['valor'];
	$aso_semana = $editar_aso['semana'];
	$aso_data_lancamento = $editar_aso['data_lancamento'];
	$fr_id = $editar_aso['fr_id'];
	$descricao_aso = $editar_aso['historico'];
	
	
}





	
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";

	echo "<tr>";

    	echo "<td align=center class='text roundborderselected'>";

        	echo "<b>Edição da Triagem</b> ";

		echo "</td>";

    echo "</tr>";

echo "</table>";

    

echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";

	echo "<tr>";

    	echo "<td align=left class='text'>";
						
		
		?>
				<form action="" id="frm" method="post">
		<?php
		
			
		
			echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
	
				echo "<tr>";
	
					echo "<td width=33% align=center class='text'>";
	
					echo "<b>CNPJ</b>";
	
					echo "</td>";
	
					echo "<td width=67% align=center class='text'>";
	
					echo "<b>Razão Social</b>";
	
					echo "</td>";
	 
				echo "</tr>";
				
				echo "<tr>";
				
					echo "<td align=center class='text roundbordermix curhand'>";
					
					echo "<input type='text' size=20 name='cnpj_cliente' id='cnpj_cliente' value='{$cnpj_cliente}' maxlength='18' onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '##.###.###/####-##');\">";
					
				
	
					echo "</td>";
	
					echo "<td align=center class='text roundbordermix curhand'>";
					
					?>
	
						<input type='text' name='razao_social_cliente' id='razao_social_cliente' value="<?php echo $razao_social; ?>" size='55' onkeyup="maiuscula('razao_social_cliente')" required>
                        
                    <?php
					
					
	
					echo "</td>";
				
				echo "</tr>";
				
			 echo "</table>";
			 
			 echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
			 
				echo "<tr>";
	
					echo "<td width=33% align=center class='text'>";
	
						echo "<b>CEP</b>";
	
					echo "</td>";
	
					echo "<td width=67% align=center class='text'>";
	
						echo "<b>Endereço</b>";
	
					echo "</td>";
	
				echo "</tr>";
				
				echo "<tr>";
				
					echo "<td align=center class='text roundbordermix curhand'>";
	
					   echo "<input type='text' name='cep_cliente' id='cep_cliente' value='{$cep_cliente}' size='20' maxlength='9' onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '#####-###');\" required>";
	
					echo "</td>";
	
					echo "<td align=center class='text roundbordermix curhand'>";
	
						?>
					
						<input type='text' name='endereco_cliente' id='endereco_cliente' value="<?php echo $endereco_cliente; ?>" size='55' onkeyup="maiuscula('endereco_cliente')" required>
						
					 <?php
	
					echo "</td>";
					
				echo "</tr>";
				
			echo "</table>";
			
			echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
	
				echo "<tr>";
	
					echo "<td width=33% align=center class='text'>";
	
					echo "<b>CNAE</b>";
	
					echo "</td>";
					
					echo "<td width=34% align=center class='text'>";
	
					echo "<b>Tipo de Exame</b>";
	
					echo "</td>";
	
					echo "<td width=33% align=center class='text'>";
	
					echo "<b>Tipo do ASO</b>";
	
					echo "</td>";
					
				echo "</tr>";
				
				echo "<tr>";
				
					echo "<td align=center class='text roundbordermix curhand'>";
	
						echo "<input type='text' size=6 name='cnae' id='cnae' value='{$cnae}' maxlength='7' onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '##.##-#');\" onBlur=\"check_cnae(this);\" required>&nbsp;<span id='verify_cnae'></span><input type='button' class='btn' value='Pesquisar' title='Click aqui para consultar com o CNPJ o número do CNAE' onClick='irReceita()'>";
	
					echo "</td>";
	
					
					echo "<td align=center class='text roundbordermix curhand'>";
					
						echo "<select name='tipo_exame' required>";
							
							echo "<option></option>";
							?>
							<option value='Admissional' <?php if($tipo_exame == 'Admissional') echo 'selected';?>>Admissional</option>
							<option value='Periódico' <?php if($tipo_exame == 'Periódico') echo 'selected';?>>Peri&oacute;dico</option>
							<option value='Demissional' <?php if($tipo_exame == 'Demissional') echo 'selected';?>>Demissional</option>
							<option value='Retorno ao Trabalho' <?php if($tipo_exame == 'Retorno ao Trabalho') echo 'selected';?>>Retorno ao Trabalho</option>
							<option value='Mudança de Função' <?php if($tipo_exame == 'Mudança de Função') echo 'selected';?>>Mudan&ccedil;a de Fun&ccedil;&atilde;o</option>
                            <?php
						
						echo "</select>";
	
					echo "</td>";
					
					
					echo "<td align=center class='text roundbordermix curhand'>";
					
						echo '<select name="tipo_aso" required>
								<option value="1">Comercial</option>
								<option value="2">Retroativo mesmo ano</option>
								<option value="3">Retroativo 1 ano</option>
								<option value="4">Retroativo 2 ano</option>
								<option value="5">Retroativo 3 ano</option>
								<option value="6">Retroativo 4 ano</option>
								<option value="7">Retroativo 5 ano</option>
							</select>';
	
					echo "</td>";
					
					
				
				echo "</tr>";
				
			 echo "</table>";
			 
			 echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
	
				echo "<tr>";
	
					echo "<td width=67% align=center class='text'>";
	
					echo "<b>Nome do Funcionário</b>";
	
					echo "</td>";
	
					echo "<td width=16,5% align=center class='text'>";
	
					echo "<b>CTPS</b>";
	
					echo "</td>";
					
					echo "<td width=16,5% align=center class='text'>";
	
					echo "<b>Série</b>";
	
					echo "</td>";
	 
				echo "</tr>";
				
				echo "<tr>";
				
					echo "<td align=center class='text roundbordermix curhand'>";
	
					?>
	
						<input type='text' name='nome_func' id='nome_func'  value="<?php echo $nome_func; ?>" size='57' onkeyup="maiuscula('nome_func')" required>
                        
                    <?php 
	
					echo "</td>";
	
					echo "<td align=center class='text roundbordermix curhand'>";
					
						echo "<input type='text' name='ctps' value='{$num_ctps_func}' size='8'>";
	
					echo "</td>";
					
					echo "<td align=center class='text roundbordermix curhand'>";
					
						echo "<input type='text' name='serie' value='{$serie_ctps_func}' size='5'>";
	
					echo "</td>";
				
				echo "</tr>";
				
			 echo "</table>";
			 
			 echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
	
				echo "<tr>";
	
					echo "<td width=33% align=center class='text'>";
	
					echo "<b>RG</b>";
	
					echo "</td>";
	
					echo "<td width=34% align=center class='text'>";
	
					echo "<b>CBO</b>";
	
					echo "</td>";
					
					echo "<td width=33% align=center class='text'>";
	
					echo "<b>Função</b>";
	
					echo "</td>";
	 
				echo "</tr>";
				
				echo "<tr>";
				
					echo "<td align=center class='text roundbordermix curhand'>";
	
						echo "<input maxlength='18' type='text' name='rg' value='{$rg}' size='20' OnKeyPress=\"formatar(this, '##.###.###-# ######');\">";
	
					echo "</td>";
					
					echo "<td align=center class='text roundbordermix curhand'>";
	
						echo "<input maxlength='7' type='text' name='cbo' value='{$cbo}' size='20' required onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '####.##');\">";
	
					echo "</td>";
	
					echo "<td align=center class='text roundbordermix curhand'>";
					
					?>
					
						<input type='text' name='funcao' id='funcao' size='20' value="<?php echo $nome_funcao; ?>" onkeyup="maiuscula('funcao')" required>
	
					</td>
					
					
                        
                       <?php
	
				
				
				echo "</tr>";
				
				
		
				
			 echo "</table>";
			 
			 echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
	
				echo "<tr>";
					
					echo "<td width=100% align=center class='text'>";
	
					echo "<b>Atividade Laborativa</b>";
	
					echo "</td>";
	 
				echo "</tr>";
				
				echo "<tr>";
				
					
					
					?>

					
					<td align=center class='text roundbordermix curhand'>
					
						<input type='text' name='atv_lab' id='atv_lab' size='94' value="<?php echo $dinamica_funcao; ?>" onkeyup="maiuscula('atv_lab')" required>
                        
                       <?php
	
					echo "</td>";
				
				echo "</tr>";
				
			 echo "</table>";
			 
			 echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
	
				echo "<tr>";
	
					echo "<td width=33% align=center class='text'>";
	
					echo "<b>Valor</b>";
	
					echo "</td>";
	
					echo "<td width=34% align=center class='text'>";
	
					echo "<b>Data Lançamento</b>";
	
					echo "</td>";
					
					echo "<td width=33% align=center class='text'>";
	
					echo "<b>Semana</b>";
	
					echo "</td>";
	 
				echo "</tr>";
				
				echo "<tr>";
				
					echo "<td align=center class='text roundbordermix curhand'>";
	
						echo "<input type='number' name='aso_valor' value='{$aso_valor}' size='20' required>";
						echo "<input type='hidden' name='fr_id' value='{$fr_id}' size='20' required>";
	
					echo "</td>";
					
					echo "<td align=center class='text roundbordermix curhand'>";
	
						echo "<input type='date' name='aso_data_lancamento' value='{$aso_data_lancamento}' size='20' required>";
	
					echo "</td>";
	
					echo "<td align=center class='text roundbordermix curhand'>";
					
					?>
					
						<input type='number' name='aso_semana' id='aso_semana' size='20' value="<?php echo $aso_semana; ?>" required>
	
					</td>
					
					
                        
                       <?php
	
				
				
				echo "</tr>";
				
				
		
				
			 echo "</table>";
			 
			 echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
	
				echo "<tr>";
	
					echo "<td width=100% align=center class='text'>";
	
					echo "<b>Descrição do Serviço</b>";
	
					echo "</td>";
	 
				echo "</tr>";
				
				echo "<tr>";
				
					?>
					
					<td align=center class='text roundbordermix curhand'>
					
						<input type='text' name='descricao_aso' value='<?php echo $descricao_aso; ?>' id='descricao_aso' size='94'>
                        
                       <?php
	
					echo "</td>";
				
				echo "</tr>";
				
			 echo "</table>";
			
		echo "</td>";
					
	echo "</tr>";
			
echo "</table>";
			
	echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
			
		echo "<tr>";
			
			echo "<td align=center class='text roundbordermix curhand'>";
			
				echo "<input type='submit' class='btn' name='enviarr'>";
			
			echo "</td>";
			
		echo "</tr>";
			
	echo "</table>";
			
echo "</form>";

echo "</table>";
		 

?>
            <?php
			
		}else{
			require_once("lista_triagem.php");
			
		}
		?>
        </table>
				
				
</tr>
</table>