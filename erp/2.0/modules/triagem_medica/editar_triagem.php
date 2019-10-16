<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">
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
   /* Executa a requisição quando o campo CNPJ perder o foco */
   $('#cnpj_cliente').blur(function(){
	   
	   		
	   
           /* Configura a requisição AJAX */
           $.ajax({
                url : 'modules/triagem_medica/consultar_cnpj_avulso.php', /* URL que será chamada */ 
                type : 'GET', /* Tipo da requisição */ 
                data: 'cnpj_cliente=' + $('#cnpj_cliente').val(), /* dado que será enviado via POST */
                dataType: 'json', /* Tipo de transmissão */
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
	

/***************************************************************************************************/


if($_POST[enviar]){
	

	$cod_aso = $_GET[editar];
	
	$cnae = $_POST['cnae'];
	
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
	$nome_funcao = $_POST['funcao'];
	$dinamica_funcao = $_POST['atv_lab'];
	
	
	
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
	
	
	
	$updatesetsql = "UPDATE aso_avulso SET razao_social_cliente = '{$razao_social}',endereco_cliente = '{$endereco}',cep_cliente = '{$cep}',cnae = '{$cnae}',grau_risco = '{$grau_risco}',tipo_exame = '{$tipo_exame}',nome_func = '{$nome_func}',num_ctps_func = '{$num_ctps_func}', serie_ctps_func = '{$serie_ctps_func}', cbo = '{$cbo}', nome_funcao = '{$nome_funcao}', dinamica_funcao = '{$dinamica_funcao}' WHERE cod_aso = {$cod_aso}";
	
	
	if(pg_query($updatesetsql)){
		
		echo "<script>window.location.href = '?dir=triagem_medica&p=index';</script>";
		
	}else{
		
		echo "<script>alert('Erro: Falar com Suporte');</script>";
		echo "<script>window.location.href = '?dir=triagem_medica&p=index';</script>";
		
	}
	
		
}

if(isset($_GET[editar])){
	
	$cod_aso = $_GET[editar];
	
	$sqleditar = "SELECT * FROM aso_avulso WHERE cod_aso = {$cod_aso}";
	
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
	$dinamica_funcao = $editar_aso['dinamica_funcao'];
	
	
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
	
					echo "<td width=50% align=center class='text'>";
	
					echo "<b>Razão Social</b>";
	
					echo "</td>";
	
					echo "<td width=50% align=center class='text'>";
	
					echo "<b>Endereço</b>";
	
					echo "</td>";
	 
				echo "</tr>";
				
				echo "<tr>";
				
					echo "<td align=center class='text roundbordermix curhand'>";
					
					?>
	
						<input type='text' name='razao_social_cliente' id='razao_social_cliente' value="<?php echo $razao_social; ?>" size='40' onkeyup="maiuscula('razao_social_cliente')" required>
                        
                    <?php
	
					echo "</td>";
	
					echo "<td align=center class='text roundbordermix curhand'>";
					
					?>
					
						<input type='text' name='endereco_cliente' id='endereco_cliente' value="<?php echo $endereco_cliente; ?>" size='40' onkeyup="maiuscula('endereco_cliente')" required>
						
					 <?php
	
					echo "</td>";
				
				echo "</tr>";
				
			 echo "</table>";
			 
			 echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
			 
				echo "<tr>";
	
					echo "<td width=45% align=center class='text'>";
	
						echo "<b>CEP</b>";
	
					echo "</td>";
	
					echo "<td width=55% align=center class='text'>";
	
						echo "<b>CNPJ</b>";
	
					echo "</td>";
	
				echo "</tr>";
				
				echo "<tr>";
				
					echo "<td align=center class='text roundbordermix curhand'>";
	
					   echo "<input type='text' name='cep_cliente' id='cep_cliente' value='{$cep_cliente}' size='8' maxlength='9' onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '#####-###');\" required>";
	
					echo "</td>";
	
					echo "<td align=center class='text roundbordermix curhand'>";
	
						echo "<input type='text' size=20 name='cnpj_cliente' id='cnpj_cliente' value='{$cnpj_cliente}' maxlength='18' onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '##.###.###/####-##');\">";
	
					echo "</td>";
					
				echo "</tr>";
				
			echo "</table>";
			
			echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
	
				echo "<tr>";
	
					echo "<td width=20% align=center class='text'>";
	
					echo "<b>CNAE</b>";
	
					echo "</td>";
					
					echo "<td width=40% align=center class='text'>";
	
					echo "<b>Tipo de Exame</b>";
	
					echo "</td>";
	
					echo "<td width=40% align=center class='text'>";
	
					echo "<b>Tipo do ASO</b>";
	
					echo "</td>";
					
				echo "</tr>";
				
				echo "<tr>";
				
					echo "<td align=center class='text roundbordermix curhand'>";
	
						echo "<input type='text' size=5 name='cnae' id='cnae' value='{$cnae}' maxlength='7' onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '##.##-#');\" onBlur=\"check_cnae(this);\" required>&nbsp;<span id='verify_cnae'></span><input type='button' value='Pesquisar' title='Click aqui para consultar com o CNPJ o número do CNAE' onClick='irReceita()'>";
	
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
	
					echo "<td width=60% align=center class='text'>";
	
					echo "<b>Nome do Funcionário</b>";
	
					echo "</td>";
	
					echo "<td width=20% align=center class='text'>";
	
					echo "<b>CTPS</b>";
	
					echo "</td>";
					
					echo "<td width=20% align=center class='text'>";
	
					echo "<b>Série</b>";
	
					echo "</td>";
	 
				echo "</tr>";
				
				echo "<tr>";
				
					echo "<td align=center class='text roundbordermix curhand'>";
	
					?>
	
						<input type='text' name='nome_func' id='nome_func'  value="<?php echo $nome_func; ?>" size='30' onkeyup="maiuscula('nome_func')" required>
                        
                    <?php 
	
					echo "</td>";
	
					echo "<td align=center class='text roundbordermix curhand'>";
					
						echo "<input type='text' name='ctps' value='{$num_ctps_func}' size='8' required>";
	
					echo "</td>";
					
					echo "<td align=center class='text roundbordermix curhand'>";
					
						echo "<input type='text' name='serie' value='{$serie_ctps_func}' size='5' required>";
	
					echo "</td>";
				
				echo "</tr>";
				
			 echo "</table>";
			 
			 echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
	
				echo "<tr>";
	
					echo "<td width=20% align=center class='text'>";
	
					echo "<b>CBO</b>";
	
					echo "</td>";
	
					echo "<td width=40% align=center class='text'>";
	
					echo "<b>Função</b>";
	
					echo "</td>";
					
					echo "<td width=40% align=center class='text'>";
	
					echo "<b>Atividade Laborativa</b>";
	
					echo "</td>";
	 
				echo "</tr>";
				
				echo "<tr>";
				
					echo "<td align=center class='text roundbordermix curhand'>";
	
						echo "<input type='text' name='cbo' value='{$cbo}' size='5' required>";
	
					echo "</td>";
	
					echo "<td align=center class='text roundbordermix curhand'>";
					
					?>
					
						<input type='text' name='funcao' id='funcao' size='20' value="<?php echo $nome_funcao; ?>" onkeyup="maiuscula('funcao')" required>
	
					</td>
					
					<td align=center class='text roundbordermix curhand'>
					
						<input type='text' name='atv_lab' id='atv_lab' size='30' value="<?php echo $dinamica_funcao; ?>" onkeyup="maiuscula('atv_lab')" required>
                        
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
			
				echo "<input type='submit' name='enviar'>";
			
			echo "</td>";
			
		echo "</tr>";
			
	echo "</table>";
			
echo "</form>";

echo "</table>";
		 

?>