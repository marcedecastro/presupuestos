<?php
session_name('demoUI');
session_start();


// array de salida
$appResponse = array(
	"respuesta" => false,
	"mensaje" => "Error en la aplicación",
	"contenido" => "",
    "datos" =>array()
);

$root = '';
 
if(isset($_POST) && !empty($_POST) && isset($_POST['accion'])){

	// incluimos el archivo de funciones y conexión a la base de datos
	include('mainFunctions.inc.php');
	include('../clases.php');
	//if($errorDbConexion == false){
	

		switch ($_POST['accion']) {
            case  'mapa':
              $x = listas::insertdir($_POST['orden'],$_POST['lat'],$_POST['long']);
              $appResponse['mensaje'] =$x;
          //    print_r($x);
            break;

		default:
			$appResponse['mensaje'] = "Opción no disponible";
		break;
		}

		
}
else{
	$appResponse['mensaje'] = "Variables no definidas";
}

// Retorno de JSON
echo json_encode($appResponse);

?>