<?php
session_start();
include 'simple_html_dom.php';

// Create DOM from URL or file.
$html = file_get_html('https://www.dhn.mil.pe/cnat');
$tremors = [];
$tr = $html->find('tr');
foreach ($tr as $item) {
    $tremor = [];
    $tremor['place'] = $item->find('td', 0)->plaintext;
    // @TODO: Convert this to timestamp format.
    $tremor['dateTime'] = $item->find('td', 1)->plaintext;
    $tremor['magnitude'] = $item->find('td', 2)->plaintext;
    $tremor['evaluation'] = $item->find('td', 3)->plaintext;
    // @TODO: if report is "nacional" then display this on mobile.
    $tremor['report'] = $item->find('td', 4)->plaintext;
    $tremors[] = $tremor;
}
// We remove first row since it is columns descriptions.
if ($tremors[0]) {
    unset($tremors['']);
}


$html2 = file_get_html("http://ultimosismo.igp.gob.pe/");
$Datos['Fecha']= $html2->find("label[@class=descrip-info]", 0)->innertext;
$Datos['Hora'] = $html2->find("label[@class=descrip-info]", 1)->innertext;
$Datos['magnitud'] = $html2->find("label[@class=descrip-info]", 2)->innertext;
$Datos['Referencia Continental'] = $html2->find("label[@class=descrip-info]", 3)->innertext;
$Datos['Latitud'] = $html2->find("label[@class=descrip-info]", 4)->innertext;
$Datos['Longitud'] = $html2->find("label[@class=descrip-info]", 5)->innertext;
$Datos['profundidad'] = $html2->find("label[@class=descrip-info]", 6)->innertext;
$Datoss=$Datos;
$op=$_REQUEST['op'];
switch ($op) {
    case 1:{
        $estado['data'] = $tremors;
        print json_encode($estado);
        break;
    }case 2:{
        $data = $Datoss;
        echo json_encode($data);
        break;
}
}

?>