<?php
include('PedidosYa.php');


if (isset($_REQUEST['request'])) {
	$modelo = new PedidosYa();

	$lnk = mysql_connect('localhost', 'root','root')or die (
		print json_encode( array('error'=>102,'descriptionerror'=>'dberror: NO Se pudo '.
			'conectar al servidor de DB-> '. mysql_error()))
	);

	mysql_select_db('pedidos', $lnk) or die (			
		print json_encode( array('error'=>103,'descriptionerror'=>'dberror: NO Se pudo '.
			'conectar-> '. mysql_error() ))
	);
	switch ($_REQUEST['request']) {
		case 'login':
			print json_encode($modelo->login($_REQUEST['user'],$_REQUEST['contrasena']));
			break;
		case 'registro':
			print json_encode($modelo->registro($_REQUEST['user'],$_REQUEST['contrasena'],
				$_REQUEST['ruc'],$_REQUEST['name']));
			break;
		// case 'pedido':
		// 	print json_encode($modelo->save($_REQUEST['userid'],$_REQUEST));
		// 	break;
		case 'eliminar':
			print json_encode($modelo->delete($_REQUEST['fecha'],$_REQUEST['userid']));
			break;
		default:
			print json_encode(array('error'=>104,'descriptionerror'=>'Requerimiento '.
				'no definido'));
	}
}
else
	print json_encode(array('error'=>100,'descriptionerror'=>'No existe \'request\' en el '.
		'requerimiento web'));
?>