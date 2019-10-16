<?PHP
    $sql = "SELECT n.cnae, n.grau_risco, n.grupo_cipa, c.* FROM cliente c, cnae n WHERE cliente_id = '{$_GET[cod_cliente]}' AND c.cnae_id = n.cnae_id";
    $res = pg_query($sql);
    $buffer = pg_fetch_array($res);

    echo "<script src=\"http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=ABQIAAAAZ75tu5S7EN6LpMkAYpXMVRTzRdCvc1kXsjCUYVLreYzP3M3eUxQ-rDNAO3Ur_2Qu8jbFZkJUhkP7wQ\" type=\"text/javascript\"></script>";
    echo '<script type="text/javascript">';
    echo 'var map;';
    echo 'var geocoder;';

    echo 'function load(){';
    echo '  map = new GMap2(document.getElementById("map"));';
    echo '  map.setCenter(new GLatLng(23, 48), 15);';
    echo '  map.setUIToDefault();';
    echo '  geocoder = new GClientGeocoder();';
	echo '  findLocation("'.$buffer[endereco].', '.$buffer[num_end].', '.$buffer[bairro].'");';
    echo '}';

    echo 'function addAddressToMap(response){';
    echo '    map.clearOverlays();';
    echo '    if (!response || response.Status.code != 200) {';
    echo '        alert("Desculpe, Não foi possível encontrar a localização informada!\n\nTente refazer a busca sem a informação do bairro, por exemplo.\n\nA consulta pode ser editada na caixa com o endereço abaixo.");';
    echo '    } else {';
    echo '        place = response.Placemark[0];';
    echo '        point = new GLatLng(place.Point.coordinates[1],';
    echo '                          place.Point.coordinates[0]);';
    echo '        marker = new GMarker(point);';
    echo '        map.addOverlay(marker);';
    echo '        marker.openInfoWindowHtml(';
    echo "        '<font color=black><center><b>$buffer[razao_social]</b></center><BR>'";
    echo "        + '<b>Localizado:</b> '";
    echo "        + place.address + '<br>'";
    echo "        + '<b>Busca por:</b> '";
    echo "        + document.forms[0].q.value";
    echo "        + '</font>'";
    echo "        );";
    echo "    }";
    echo "}";

    echo 'function showLocation() {';
    echo '  var address = document.forms[0].q.value;';
    echo '  geocoder.getLocations(address, addAddressToMap);';
    echo '}';

    echo 'function findLocation(address) {';
    echo '  document.forms[0].q.value = address;';
    echo '  showLocation();';
    echo '}';
    echo '</script>';
?>
