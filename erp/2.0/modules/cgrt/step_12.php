<?PHP
    $sql = "SELECT * FROM cliente WHERE cliente_id = $_GET[cod_cliente]";
    $result = pg_query($sql);
    $cinfo = pg_fetch_array($result);
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td align=center class='text roundborderselected'>";
    echo "<b>$cinfo[razao_social]</b>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    
    //print_r($_SERVER);
    
/***************************************************************************************************/
// --> CONFIRMAR FINALIZAÇÃO DE CADASTO CGRT
/***************************************************************************************************/
if($_POST && $_POST[btnConfirmCGRT]){
    //print_r($_SESSION);
    $sql = "SELECT * FROM funcionario WHERE funcionario_id = ".(int)($_SESSION[usuario_id]);
    $rfa = @pg_query($sql);
    $fin = @pg_fetch_array($rfa);
    if(@pg_num_rows($rfa)>0 && ($fin[is_coord] || $fin[grupo_id] == 1)){
        $epcmso = 0;
        $eppra  = 0;
		$eapgre = 0;
        if($_POST[enable_pcmso])
            $epcmso = 1;
        if($_POST[enable_ppra])
            $eppra = 1;
		if($_POST[enable_apgre])
			$eapgre = 1;

        $sql = "UPDATE cgrt_info SET cgrt_finished = 1, pcmso_enabled = ".(int)($epcmso).", ppra_enabled = ".(int)($eppra).", apgre_enabled = ".(int)($eapgre)." WHERE cod_cgrt = ".(int)($_GET[cod_cgrt]);
        if(pg_query($sql)){
			
			
			$msg = "";
			$msg .= "<center><h1>".$cinfo['razao_social']."</h1></center>";
			$msg .= "<br>";
			$msg .= "<br>";
			
			//Pegar numero dos satores
			$pegarsetorsql = "SELECT s.cod_setor, s.nome_setor FROM cliente_setor c, setor s WHERE c.id_ppra = ".(int)($_GET[cod_cgrt])." AND s.cod_setor = c.cod_setor ORDER BY s.nome_setor";
			
			$pegarsetorquery = pg_query($pegarsetorsql);
			
			$pegarsetor = pg_fetch_all($pegarsetorquery);
			
			$pegarsetornum = pg_num_rows($pegarsetorquery);
			
			for($cont=0;$cont<$pegarsetornum;$cont++){
				
				$cod_setor = $pegarsetor[$cont]['cod_setor'];
				$nome_setor = $pegarsetor[$cont]['nome_setor'];
				
				$msg .= "<br>";
				$msg .= "<h2>";
				$msg .= "Setor: ".$nome_setor."";
				$msg .= "</h2>";
				$msg .= "<br>";
				$msg .= "<br>";
				
				
				//Pegar os programas de cada setor
			$programasetorsql = "SELECT id, descricao, 1 as t FROM funcao_programas WHERE cod_funcao IN (SELECT cod_funcao FROM cgrt_func_list WHERE cod_cgrt = ".(int)($_GET[cod_cgrt])." AND cod_setor = ".$cod_setor." GROUP BY cod_funcao ORDER BY cod_funcao)
UNION
SELECT id, descricao, 2 as t FROM setor_programas WHERE cod_setor = ".$cod_setor;

			$programasetorquery = pg_query($programasetorsql);
			
			$programasetorall = pg_fetch_all($programasetorquery);
			
			$programasetornum = pg_num_rows($programasetorquery);
				
				for($cont2=0;$cont2<$programasetornum;$cont2++){
					
					
					if($cont2==0){
						
						$msg .= "<h3>PROGRAMAS:</h3>";
						$msg .= "<br>";
						
					}
					
					$sqlsugepro = "SELECT plano_acao FROM sugestao WHERE id_ppra = ".(int)($_GET[cod_cgrt])." AND tipo_med_prev = 4 AND med_prev = ".$programasetorall[$cont2][id]."";
        $rsugepro = pg_query($sqlsugepro);
        $dmpsugepro = pg_fetch_array($rsugepro);
		
		if($dmpsugepro[plano_acao] == 0){
						
						$tipoplanopro = "<strong> Existente </strong>";
						
					}else{
						
						$tipoplanopro = "<strong> Sugerida </strong>";
						
					}
					
					
					
					
					$programasetor = $programasetorall[$cont2]['descricao'];
					
					$msg .= "- ".$programasetor."";
					$msg .= "[".$tipoplanopro."]";
					$msg .= "<br>";
					$msg .= "<br>";
					
					if($cont3 == ($programasetornum - 1)){
						
						$msg .= "<hr>";
						$msg .= "<br>";
						
					}
					
					
				}
				
				
				
				
				//Pegar EPI de cada setor
			
	/*		$episetorsql = "SELECT id, descricao, cod_produto, 1 as t FROM funcao_epi WHERE cod_epi IN (SELECT cod_funcao FROM cgrt_func_list WHERE cod_cgrt = ".(int)($_GET[cod_cgrt])." AND cod_setor = ".$cod_setor." GROUP BY cod_funcao ORDER BY cod_funcao)
UNION
SELECT id, descricao, cod_produto, 2 as t FROM setor_epi WHERE cod_setor = ".$cod_setor;
				
			$episetorquery = pg_query($episetorsql);
				
			$episetorall = pg_fetch_all($episetorquery);
			
			$episetornum = pg_num_rows($episetorquery);
			
			
			for($cont3=0;$cont3<$episetornum;$cont3++){
					
					if($cont3==0){
						
						$msg .= "<h3>";
						$msg .= "EPI:";
						$msg .= "</h3>";
						$msg .= "<br>";
						
					}
					
					
					
					 $sqlsuge = "SELECT plano_acao FROM sugestao WHERE id_ppra = ".(int)($_GET[cod_cgrt])." AND tipo_med_prev = 0 AND med_prev = ".$episetorall[$cont3][id]."";
        $rsuge = pg_query($sqlsuge);
        $dmpsuge = pg_fetch_array($rsuge);
					
					
					if($dmpsuge[plano_acao] == 0){
						
						$tipoplano = "<strong> Existente </strong>";
						
					}else{
						
						$tipoplano = "<strong> Sugerida </strong>";
						
					}
					
					
					
					
					$episetor = $episetorall[$cont3]['descricao'];
					
					$msg .= "- ".$episetor."";
					$msg .= "[".$tipoplano."]";
					$msg .= "<br>";
					$msg .= "<br>";
					
					if($cont3 == ($episetornum - 1)){
						
						$msg .= "<hr>";
						$msg .= "<br>";
						
					}
					
					
				}
				
				
				
				*/
			
							
			}
			
			
			
			//Pegar os Cursos da empresa
			
				$cursoempresasql =  "select distinct(p.desc_resumida_prod), p.cod_prod from site_orc_produto o, produto p
				where o.cod_cliente = $_GET[cod_cliente] and o.cod_produto = p.cod_prod
				and (o.cod_produto = 431 or o.cod_produto = 840 or o.cod_produto = 897 or o.cod_produto = 980 or o.cod_produto = 981
				or o.cod_produto = 429 or o.cod_produto = 430 or o.cod_produto = 70275 or o.cod_produto = 941 or o.cod_produto = 69832 or o.cod_produto = 425 or o.cod_produto = 426 or o.cod_produto = 982 or o.cod_produto = 70413)";
				
				$cursoempresaquery = pg_query($cursoempresasql);
			
				$cursoempresaall = pg_fetch_all($cursoempresaquery);
				
				$cursoempresanum = pg_num_rows($cursoempresaquery);
				
				$msg .="<br>";
				$msg .="<h3>CURSOS:</h3>";
				$msg .="<br>";
				
			
				for($cont4=0;$cont4<$cursoempresanum;$cont4++){
					
					
					$prodcurso = $cursoempresaall[$cont4][cod_prod];
					
					
					$sqlcur = "SELECT plano_acao FROM sugestao WHERE id_ppra = ".(int)($_GET[cod_cgrt])." and cod_produto = ".$prodcurso." and tipo_med_prev = 2";
			$rsucur = pg_query($sqlcur);
			$dmpcur = pg_fetch_array($rsucur);
			
			
			
			
			if($dmpcur[plano_acao] == 0){
						
						$tipocurso = "<strong> Existente </strong>";
						
					}else{
						
						$tipocurso = "<strong> Sugerida </strong>";
						
					}
			
			
			
			
			
			
					
			
					$cursoempresa = $cursoempresaall[$cont4]['desc_resumida_prod'];
					
					$msg .= "- ".$cursoempresa."";
					$msg .= "[".$tipocurso."]";
					$msg .= "<br>";
					$msg .= "<br>";
			
				}
				
			$titulo = "SESMT: Finalização do Programa ";
				
			$headers = "MIME-Version: 1.0\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\n";
			$headers .= 'From: SESMT - Seguranca do Trabalho e Higiene Ocupacional. <suporte@sesmt-rio.com> ' . "\n" .
    					'X-Mailer: PHP/' . phpversion();
			
			if(mail("comercial@sesmt-rio.com;financeiro@sesmt-rio.com;suporte@ti-seg.com", $titulo, $msg, $headers)){
				
				echo "ok";
			}
			
			
			
			
			
			
            makelog((int)($_SESSION[usuario_id]), "[CGRT] CGRT finalizado. cod_cgrt: $_GET[cod_cgrt]", 118, $sql);
            showMessage("CGRT alterado para finalizado.", 0, 1);
			
			
			
            //AVISAR CLIENTE????????????????
        }else{
            makelog((int)($_SESSION[usuario_id]), "[CGRT] Houve um erro ao tentar finalizar este relatório. cod_cgrt: $_GET[cod_cgrt]", 119, $sql);
            showMessage("Houve um problema ao tentar finalizar este cadastro. Por favor, entre em contato com o setor de suporte!");
        }
    }else{
        showmessage('Você não tem permissão para confirmar este cadastro.',1);
    }
}else{
    if($cgrt_info[cgrt_finished]){
        $sql = "SELECT * FROM cgrt_info WHERE cod_cgrt = ".(int)($_GET[cod_cgrt]);
        $info = pg_fetch_array(pg_query($sql));
    }
    
    echo "<form method='POST' name='frmEndCGRT'>";
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 height=200>";
    echo "<tr>";
    echo "<td align=left class='text roundborderselected'>";
    if($cgrt_info[cgrt_finished])
        echo "<center><b>ATENÇÃO ESTE RELATÓRIO JÁ FOI FINALIZADO</b></center>";
    else
        echo "<center><b>ATENÇÃO</b></center>";

    echo "<BR><P>";
    echo "Selecione abaixo os relatórios que serão exibidos para os clientes no site (relatórios que constam no contrato):";
    echo "<br>";
    echo "<table width=100% border=0>";
    echo "<tr>";
    echo "<td width=60 align=center><input type=checkbox name=enable_pcmso value=1 "; print $info[pcmso_enabled] ? "checked":""; echo "></td>";
    echo "<td>Habilitar exibição do PCMSO no site.</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td width=60 align=center><input type=checkbox name=enable_ppra value=1 "; print $info[ppra_enabled] ? "checked":""; echo "></td>";
    echo "<td>Habilitar exibição do PPRA no site.</td>";
    echo "</tr>";
	echo "<tr>";
    echo "<td width=60 align=center><input type=checkbox name=enable_apgre value=1 "; print $info[apgre_enabled] ? "checked":""; echo "></td>";
    echo "<td>Habilitar exibição do APGRE no site.</td>";
    echo "</tr>";
    echo "</table>";
    echo "<br><p>";
    echo "Após a confirmação, o cliente poderá visualizar no site os relatórios gerados e selecionados acima.";
    echo "<p>";
    if($cgrt_info[cgrt_finished])
        echo "Tem certeza que deseja <b>EXIBIR</b> os relatórios selecionados no site?<BR>";
    else
        echo "Tem certeza que deseja <b>FINALIZAR</b> este relatório?<BR>";

    echo "</td>";
    echo "</tr>";
    echo "</table>";

    echo "<p>";

    echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
    echo "<tr>";
    echo "<td align=left class='text'>";
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
            echo "<td align=center class='text roundbordermix'>";
                echo "<input type='submit' class='btn' name='btnConfirmCGRT' value='Confirmar' onmouseover=\"showtip('tipbox', '- Confirmar, Após a confirmação, o cliente poderá visualizar os relatórios gerados.');\" onmouseout=\"hidetip('tipbox');\">";
                echo "&nbsp;";
                echo "<input type='button' class='btn' name='btnCancelCGRT' value='Cancelar' onmouseover=\"showtip('tipbox', '- Cancelar, retorna à tela anterior.');\" onmouseout=\"hidetip('tipbox');\" onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&step=5&cod_cliente=$_GET[cod_cliente]&cod_cgrt=$_GET[cod_cgrt]&cod_setor=$_GET[cod_setor]';\">";
            echo "</td>";
        echo "</tr>";
        echo "</table>";
    echo "<td>";
    echo "</tr>";
    echo "</table>";

    echo "</form>";
}
?>
