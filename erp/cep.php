<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);

function busca_cep($cep){
     $resultado = @file_get_contents('http://republicavirtual.com.br/web_cep.php?cep='.urlencode($cep).'&formato=query_string');
     if(!$resultado){
         $resultado = "&resultado=0&resultado_txt=erro+ao+buscar+cep";
     }
     parse_str($resultado, $retorno);
     return $retorno;
}



$resultado_busca = busca_cep($_GET['cep_clinica']);


 switch($resultado_busca['resultado']){
     case '2':
         /*$texto = "
     Cidade com logradouro ?nico
     <b>Cidade: </b> ".$resultado_busca['cidade']."
     <b>UF: </b> ".$resultado_busca['uf']."
         ";*/
         if($resultado_busca['tipo_logradouro'] == ""){$resultado_busca['tipo_logradouro']=" ";}
         if($resultado_busca['logradouro'] == ""){$resultado_busca['logradouro']=" ";}
         if($resultado_busca['bairro'] == ""){$resultado_busca['bairro']=" ";}
         $texto = $resultado_busca['tipo_logradouro']."|".$resultado_busca['logradouro']."|".$resultado_busca['bairro']."|".$resultado_busca['cidade']."|".$resultado_busca['uf'];
     break;

     case '1':
/*         $texto = "
     Cidade com logradouro completo
     <b>Tipo de Logradouro: </b> ".$resultado_busca['tipo_logradouro']."
     <b>Logradouro: </b> ".$resultado_busca['logradouro']."
     <b>Bairro: </b> ".$resultado_busca['bairro']."
     <b>Cidade: </b> ".$resultado_busca['cidade']."
     <b>UF: </b> ".$resultado_busca['uf']."
         ";*/
         if($resultado_busca['tipo_logradouro'] == ""){$resultado_busca['tipo_logradouro']=" ";}
         if($resultado_busca['logradouro'] == ""){$resultado_busca['logradouro']=" ";}
         if($resultado_busca['bairro'] == ""){$resultado_busca['bairro']=" ";}
         $texto = $resultado_busca['tipo_logradouro']."|".$resultado_busca['logradouro']."|".$resultado_busca['bairro']."|".$resultado_busca['cidade']."|".$resultado_busca['uf'];
     break;

     default:
        // $texto = "Fala ao buscar cep: ".$resultado_busca['resultado'];
         if($resultado_busca['tipo_logradouro'] == ""){$resultado_busca['tipo_logradouro']=" ";}
         if($resultado_busca['logradouro'] == ""){$resultado_busca['logradouro']=" ";}
         if($resultado_busca['bairro'] == ""){$resultado_busca['bairro']=" ";}

         $texto = "Cep n?o encontrado!".$resultado_busca['tipo_logradouro']."|".$resultado_busca['logradouro']."|".$resultado_busca['bairro']."|".$resultado_busca['cidade']."|".$resultado_busca['uf'];
     break;
 }

 echo $texto;


//echo $resultado_busca;

?>
