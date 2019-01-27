<?php

require_once "Conexion.php";

Class empresa{
	var $empresaId;
	var $razonsocial;
	var $estado;
	var $status; 


	function __construct($empresaId,$razonsocial=null) {


		$this->empresaId = $empresaId ;
		$this->razonsocial = $razonsocial ;
		$this->estado = 1;
	}
    
	public function delete($usuarioID){
		$conexion = new Conexion();
		$consulta = $conexion->prepare(' CALL empresasDelete( :empresaId)' );
		$consulta->bindParam(':empresaId', $this->empresaId);

		$consulta->execute();
		if ($consulta->errorInfo()[2])
			$this->status = $consulta->errorInfo()[2];

		$conexion->logGrabar('tarea Delete', $consulta->queryString,
												json_encode($this), $this->status, $usuarioID);
	}

   public function update($usuarioID){
      $conexion = new Conexion();
      $consulta = $conexion->prepare(' CALL empresasUpdate( :empresaId,:razonsocial)');
      $consulta->bindParam(':empresaId', $this->empresaId);        
      $consulta->bindParam(':razonsocial', $this->razonsocial);
      $consulta->execute();
      if ($consulta->errorInfo()[2])
          $this->status = $consulta->errorInfo()[2];

      $conexion->logGrabar('empresa Update', $consulta->queryString, json_encode($this), 
                            $this->status, $usuarioID);
  	}
	
   public function insert($usuarioID){
      $conexion = new Conexion();
      $consulta = $conexion->prepare(' CALL empresasInsert(:empresaId,:razonsocial)');
      
      $consulta->bindParam(':empresaId', $this->empresaId);
      $consulta->bindParam(':razonsocial', $this->razonsocial);

      $consulta->execute();

      if ($consulta->errorInfo()[2])
         $this->status = $consulta->errorInfo();
       

       $objeto = json_encode($this);
       $status= json_encode($this->status);
       $conexion->logGrabar('empresa insert', $consulta->queryString, $objeto, 
                            $status, $usuarioID);  

  }
    
  public static function buscar(){
    $conexion = new Conexion();
    $consulta = $conexion->prepare('call tareaBuscar()');
    $consulta->execute();
   
    $registro = $consulta->fetch(PDO::FETCH_ASSOC);
    if($registro){

       return new self($registro['empresaId'], 
                      $registro['razonsocial']
                      );
    }else{
       return false;
    }//return false;
  }


  public static function Listar(){

    $result= array();
    $conexion = new Conexion();

    $consulta =  $conexion->prepare( 'Call empresasLista()');

    $consulta->execute();
    $respuesta = $consulta->fetchAll(PDO::FETCH_ASSOC);
     
    return $respuesta;
  }


}

?>