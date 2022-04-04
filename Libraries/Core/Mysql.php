<?php

	class Mysql extends Conexion
	{
		public $conexion_bd_usr;
		public $conexion_bd_tap;
		public $conexion_bd_tgz;
		public $conexion_bd_camp;
		public $conexion_bd_tapi;
		public $conexion_bd_refo;
		public $conexion_bd_yaj;
		public $conexion_bd_oaxa;
		public $conexion_bd_pale;
		public $conexion_bd_comi;
		public $conexion_bd_chet;
		private $strquery;
		private $arrValues;
	    function __construct()
		{
            //CONEXIONES
			$this->conexion_bd_usr = new Conexion();
			$this->conexion_bd_usr = $this->conexion_bd_usr->conect('bd_usr'); 

			$this->conexion_bd_tgz = new Conexion();
			$this->conexion_bd_tgz = $this->conexion_bd_tgz->conect('bd_tgz');

            $this->conexion_bd_camp = new Conexion();
			$this->conexion_bd_camp = $this->conexion_bd_camp->conect('bd_camp');

            $this->conexion_bd_tap = new Conexion();
			$this->conexion_bd_tap = $this->conexion_bd_tap->conect('bd_tap'); 

			$this->conexion_bd_refo = new Conexion();
			$this->conexion_bd_refo = $this->conexion_bd_refo->conect('bd_refo'); 

			$this->conexion_bd_tapi = new Conexion();
			$this->conexion_bd_tapi = $this->conexion_bd_tapi->conect('bd_tapi'); 

			$this->conexion_bd_yaj = new Conexion();
			$this->conexion_bd_yaj = $this->conexion_bd_yaj->conect('bd_yaj'); 

			$this->conexion_bd_oaxa = new Conexion();
			$this->conexion_bd_oaxa = $this->conexion_bd_oaxa->conect('bd_oaxa'); 

			$this->conexion_bd_pale = new Conexion();
			$this->conexion_bd_pale = $this->conexion_bd_pale->conect('bd_pale'); 

			$this->conexion_bd_comi = new Conexion();
			$this->conexion_bd_comi = $this->conexion_bd_comi->conect('bd_comi'); 

			$this->conexion_bd_chet = new Conexion();
			$this->conexion_bd_chet = $this->conexion_bd_chet->conect('bd_chet'); 
		}

		//Insertar un registro
		public function insert(string $query,string $bd, array $arrValues)
		{
			$this->strquery = $query;
			$basedatos = "conexion_".$bd;
			$this->arrValues = $arrValues;
			$insert = $this->$basedatos->prepare($this->strquery);
			$resInsert = $insert->execute($this->arrValues);
			if ($resInsert)
			{
				$lastInsert = $this->$basedatos->lastInsertId();
			}else{
				$lastInsert = 0;
			}
			return $lastInsert;
		}

		//Buscar un registro
		public function select(string $query, string $bd)
		{
			$this->strquery = $query;
			$basedatos = "conexion_".$bd;
			$result = $this->$basedatos->prepare($this->strquery);
			$result->execute();
			$data = $result->fetch(PDO::FETCH_ASSOC);
			return $data;
		}

		//Devuelve todos los registros
		public function select_all(string $query, string $bd)
		{
			//$bd = "conexion".$base_datos;
			$this->strquery = $query;
			$basedatos = "conexion_".$bd;
			$result = $this->$basedatos->prepare($this->strquery);
			$result->execute();
			$data = $result->fetchall(PDO::FETCH_ASSOC);
			return $data;
		}

		//Actualizar registros
		public function update(string $query, string $bd, array $arrValues)
		{
			$this->strquery = $query;
			$this->arrValues = $arrValues;
			$basedatos = "conexion_".$bd;
			$update = $this->$basedatos->prepare($this->strquery);
			$resExecute = $update->execute($this->arrValues);
			return $resExecute;
		}

		//Eliminar un registro
		public function delete(string $query,string $bd)
		{
			$this->strquery = $query;
			$basedatos = "conexion_".$bd;
			$result = $this->$basedatos->prepare($this->strquery);
			$del = $result->execute();
			return $del;
		}
	}

?>