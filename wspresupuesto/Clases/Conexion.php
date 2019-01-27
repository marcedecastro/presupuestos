<?php 
 class Conexion extends PDO { 
   private $tipo_de_base = 'mysql';
   private $host = 'localhost:3306';
   private $nombre_de_base = 'newinstalaciones';
   private $usuario = 'root';
   private $contrasena = ''; 
   private $status;

     
  private $options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING ); 

   
  
   public function getStatus() {
       return $this->status;
   }

   public function setStatus($status) {
       $this->status = $status;
   
       return $this;
   }
   public function __construct() {
      //Sobreescribo el método constructor de la clase PDO.
      try{
           parent::__construct($this->tipo_de_base.':host='.$this->host.';dbname='.$this->nombre_de_base, $this->usuario, $this->contrasena, $this->options); 
     
      }catch(PDOException $e){
         $this->status= 'Ha surgido un error y no se puede conectar a la base de datos. Detalle: ' . $e->getMessage();
         exit;
      }
   } 
     
  public function logGrabar($accion,$sentencia,$objeto,$resultado,$usuarioID){
       
    /*  print_r('<br>------------------------------------------------</br>');
        print_r($accion);
        print_r('</br>');
        print_r($sentencia);
        print_r('</br>');
        print_r($objeto);
        print_r('</br>');
        print_r($usuarioID);
        print_r('</br>');
        print_r($resultado);
        print_r('<br>-----------------------------------------------</br>');
      //$con = new Conexion();
     */
      $consulta =  $this->prepare(' CALL logInsert(:accion, :sentencia, :objeto,
      :resultado, :usuarioID)');

         $consulta->bindParam(':accion', $accion);         
         $consulta->bindParam(':sentencia', $sentencia);
         $consulta->bindParam(':objeto', $objeto);
         $consulta->bindParam(':resultado', $resultado);         
         $consulta->bindParam(':usuarioID', $usuarioID);
       $consulta->execute();
      
      /*  print_r('<br>------------------------------------------------</br>');
        print_r($consulta->queryString);
        print_r('</br>');

        print_r('<br>-----------------------------------------------</br>');*/
   }

 } 
?>