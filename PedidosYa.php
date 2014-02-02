<?
class PedidosYa{

	public function login($user, $contrasena){
		if ($loggued_in_user_info = $this->DBC('SELECT * FROM cliente 
			WHERE user=\''.mysql_real_escape_string($user).'\' 
			AND contrasena=\''.mysql_real_escape_string($contrasena).'\'',0)) {
			return array('error'=>0, 'data'=>$loggued_in_user_info);
		}else{
			return array('error'=>2,'descriptionerror'=>'Combinación Email/Password incorrecta.');
		}
	}

	public function registro($user, $contrasena,$ruc,$name){
		if ($loggued_in_user_info = $this->DBC('SELECT * FROM cliente 
			WHERE user=\''.mysql_real_escape_string($user).'\'',0 )){
			return array('error'=>2,'descriptionerror'=>'Nombre de Usuario en uso.');
		}else{
			//esta función ya retorna el ID del usuario registrado.
			return $this->DBC('INSERT INTO cliente SET user=\''.mysql_real_escape_string($user).'\',
			 contasena=\''.mysql_real_escape_string($contrasena).'\', 
			 ci_ruc=\''.mysql_real_escape_string($ruc).'\',
			 nombre=\''.mysql_real_escape_string($name).'\'',1);
		}
	}

	public function delete($fecha, $userid){
		return $this->DBC('DELETE FROM pedido WHERE fecha='.$fecha.' AND id_cliente='.$userid,1);
	}
	/*NOMBRE: DBC
	  PARÁMETROS: $query -> String
	  DETALLES: Dado el String $query, que es una sentencia sql
	  Ejecuta dicha sentencia, si hay algun error, el servidor
	  devuelve al cliente ERROR=1 y DESCRIPTIONERROR=query: 
	  (El query ejecutado) - dberror: (El tipo de error que 
	  	mysql devuelve).
	  	Caso contrario la función devuelve un arreglo asociativo 
	  	como respuesta del query ejecutado. */
	private function DBC($query,$insert){
		$result = mysql_query($query)
		or die(
			print json_encode(array('error'=>1,'descriptionerror'=>'query: '.$query.' - dberror: '.mysql_error()))
		);
		if($insert==0){
			$rows = array();
			while ($row = mysql_fetch_assoc($result)) {
				$rows[]=$row;
			}
			mysql_free_result($result);
			return $rows;
		}
		return  array('id' => mysql_insert_id());//id de editar
	}
}
?>