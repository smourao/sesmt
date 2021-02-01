<?PHP

$sql = "INSERT INTO pcmat_info(cod_cliente,
							   cod_obra,
							   cnpj_obra,
							   cep_obra,
							   end_obra,
							   bairro_obra,
							   cidade_obra,
							   estado_obra,
							   ------------->DATAINSTPREV<-------------,
							   ------------------>LO<-----------------,
							   n_func_inicial,
							   n_func_final,
							   nome_engenheiro_resp,
							   crea_engenheiro_resp,
							   nome_tec_seg_resp
							   registro_tec_seg_resp,
							   nome_rep_legal,
							   cargo_rep_legal,
							   garagem_obra,
							   inicio_obra,
							   fim_obra,
							   subsolo_obra,
							   tipo_edificacao,
							   metragem_terreno,
							   metragem_construcao,
							   cobertura_obra,

							   ";

$sql = "INSERT INTO pcmat_equip(cod_cliente,
								cod_obra,
							    equipamento,
							   							   
							    ";

$sql = "INSERT INTO pcmat_efetivo(cod_cliente,
								  cod_obra,
							 	  funcao,
								  funcionario,
								  empreiteiro,
								  
								  ";

$sql = "INSERT INTO pcmat_vivencia(cod_cliente,
								   cod_obra,
							 	   area,
								  
								  ";

$sql = "INSERT INTO pcmat_quimicos(cod_cliente,
							 	   cod_obra,
								   produto,
								  
								  ";

$sql = "INSERT INTO pcmat_maquinas(cod_cliente,
							 	   cod_obra,
								   maquina,
								  
								  ";
								  
$sql = "INSERT INTO pcmat_av_ambiental(cod_cliente,
							 		   cod_obra,
									   agente,
																	  
								 	   ";
						
$sql = "INSERT INTO pcmat_doc_complementares(cod_cliente,
								   			ppra,
							 	   			pcmso,
								   			aso,
								   			emdc,
								   			ppp,
								   			mapa,
											cipa,
											brigada,
											rota_fuga,
											av_ambiental,
											simula_escape,
								  
								  			";
											
$sql = "INSERT INTO pcmat_extintor(cod_cliente,
								   cod_obra,
							 	   tipo,
								   data,
								  
								  ";
?>