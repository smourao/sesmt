$(document).ready( function() {
   /* Executa a requisição quando o campo CNPJ perder o foco */
   $('#cnpj_cliente').blur(function(){
	   
	   		alert("oi");
	   
           /* Configura a requisição AJAX */
           $.ajax({
                url : 'consultar_cnpj_avulso.php', /* URL que será chamada */ 
                type : 'POST', /* Tipo da requisição */ 
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