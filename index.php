<?php
include('PedidosYa.php');


if (isset($_REQUEST['data'])) {
	$modelo = new PedidosYa();

	$lnk = mysql_connect('localhost', 'root','root')or die (
		print json_encode( array('error'=>102,'descriptionerror'=>'dberror: NO Se pudo '.
			'conectar al servidor de DB-> '. mysql_error()))
	);

	mysql_select_db('pedidos', $lnk) or die (			
		print json_encode( array('error'=>103,'descriptionerror'=>'dberror: NO Se pudo '.
			'conectar-> '. mysql_error() ))
	);

	$json=json_decode($_REQUEST['data']);

	switch ($json->request) {
		case 'login':
			print json_encode($modelo->login($json->data->user,$json->data->contrasena));
			break;
		case 'registro':
			print json_encode($modelo->registro($json->data->user,$json->data->contrasena,$json->data->ruc,$json->data->name));
			break;
		case 'platos':
			print json_encode($modelo->platos());
			break;
		case 'pedido':
			print json_encode($modelo->save($json->data->userid,$json->data->platos));
			break;
		case 'eliminar':
			print json_encode($modelo->delete($json->data->fecha,$json->data->userid));
			break;
		default:
			print json_encode(array('error'=>104,'descriptionerror'=>'Requerimiento '.
				'no definido'));
	}
}
else
	print json_encode(array('error'=>100,'descriptionerror'=>'No existe \'data\' en el '.
		'requerimiento web'));
?>