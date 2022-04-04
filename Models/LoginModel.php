<?php

class LoginModel extends Mysql
{
	private $intIdUsuario;
	private $strUsuario;
	private $strPassword;
	private $nomConexion;
	private $strToken;

	public function __construct()
	{
		parent::__construct();
	}

	public function loginUSer(string $usuario, string $password, string $nomConexion)
	{
		$this->strUsuario = $usuario;
		$this->strPassword = $password;
		$this->nomConexion = $nomConexion;
		$sql = "SELECT us.id,us.estatus,us.id_persona,us.id_rol,r.nombre_rol,r.cve_rol,db.nombre_conexion FROM t_usuarios AS us
		INNER JOIN t_roles AS r ON us.id_rol = r.id  
		INNER JOIN t_db AS db ON us.id_db = db.id
		WHERE us.nickname = '$this->strUsuario' AND us.password = '$this->strPassword' AND db.nombre_conexion = '$this->nomConexion' AND us.estatus != 0";
		$request = $this->select($sql, 'bd_usr');
		return $request;
	}
	public function selectDateUser(int $idPersona,string $nomConexion){
		$sql = "SELECT *FROM t_personas WHERE id = $idPersona";
		$request = $this->select($sql, $nomConexion);
		return $request;
	}
    public function selectPlanteles(string $nomConexion){
        $sql = "SELECT *FROM t_db";
        $request = $this->select_all($sql, $nomConexion);
        return $request;
    }
}
?>