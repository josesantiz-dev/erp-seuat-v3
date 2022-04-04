<?php
class Conexion{
	private $conect;

	public function __construct(){
		//$connectionString = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET;
		$connectionStringUsers = "mysql:host=".conexiones['bd_usr']['DB_HOST'].";dbname=".conexiones['bd_usr']['DB_NAME'].";charset=".conexiones['bd_usr']['DB_CHARSET'];
		$connectionStringTgz = "mysql:host=".conexiones['bd_tgz']['DB_HOST'].";dbname=".conexiones['bd_tgz']['DB_NAME'].";charset=".conexiones['bd_tgz']['DB_CHARSET'];
		$connectionStringTap = "mysql:host=".conexiones['bd_tap']['DB_HOST'].";dbname=".conexiones['bd_tap']['DB_NAME'].";charset=".conexiones['bd_tap']['DB_CHARSET'];
		$connectionStringCamp = "mysql:host=".conexiones['bd_camp']['DB_HOST'].";dbname=".conexiones['bd_camp']['DB_NAME'].";charset=".conexiones['bd_camp']['DB_CHARSET'];
		$connectionStringTapi = "mysql:host=".conexiones['bd_tapi']['DB_HOST'].";dbname=".conexiones['bd_tapi']['DB_NAME'].";charset=".conexiones['bd_tapi']['DB_CHARSET'];
		$connectionStringRefo = "mysql:host=".conexiones['bd_refo']['DB_HOST'].";dbname=".conexiones['bd_refo']['DB_NAME'].";charset=".conexiones['bd_refo']['DB_CHARSET'];
		$connectionStringYaj = "mysql:host=".conexiones['bd_yaj']['DB_HOST'].";dbname=".conexiones['bd_yaj']['DB_NAME'].";charset=".conexiones['bd_yaj']['DB_CHARSET'];
		$connectionStringOaxa = "mysql:host=".conexiones['bd_oaxa']['DB_HOST'].";dbname=".conexiones['bd_oaxa']['DB_NAME'].";charset=".conexiones['bd_oaxa']['DB_CHARSET'];
		$connectionStringPale = "mysql:host=".conexiones['bd_pale']['DB_HOST'].";dbname=".conexiones['bd_pale']['DB_NAME'].";charset=".conexiones['bd_pale']['DB_CHARSET'];
		$connectionStringComi = "mysql:host=".conexiones['bd_comi']['DB_HOST'].";dbname=".conexiones['bd_comi']['DB_NAME'].";charset=".conexiones['bd_comi']['DB_CHARSET'];
		$connectionStringChet = "mysql:host=".conexiones['bd_chet']['DB_HOST'].";dbname=".conexiones['bd_chet']['DB_NAME'].";charset=".conexiones['bd_chet']['DB_CHARSET'];
		try{
			$this->conect['bd_usr'] = new PDO($connectionStringUsers, conexiones['bd_usr']['DB_USER'], conexiones['bd_usr']['DB_PASSWORD']);
			$this->conect['bd_tgz'] = new PDO($connectionStringTgz, conexiones['bd_tgz']['DB_USER'], conexiones['bd_tgz']['DB_PASSWORD']);
			$this->conect['bd_tap'] = new PDO($connectionStringTap, conexiones['bd_tap']['DB_USER'], conexiones['bd_tap']['DB_PASSWORD']);
			$this->conect['bd_camp'] = new PDO($connectionStringCamp, conexiones['bd_camp']['DB_USER'], conexiones['bd_camp']['DB_PASSWORD']);
			$this->conect['bd_tapi'] = new PDO($connectionStringTapi, conexiones['bd_tapi']['DB_USER'], conexiones['bd_tapi']['DB_PASSWORD']);
			$this->conect['bd_refo'] = new PDO($connectionStringRefo, conexiones['bd_refo']['DB_USER'], conexiones['bd_refo']['DB_PASSWORD']);
			$this->conect['bd_yaj'] = new PDO($connectionStringYaj, conexiones['bd_yaj']['DB_USER'], conexiones['bd_yaj']['DB_PASSWORD']);
			$this->conect['bd_oaxa'] = new PDO($connectionStringOaxa, conexiones['bd_oaxa']['DB_USER'], conexiones['bd_oaxa']['DB_PASSWORD']);
			$this->conect['bd_pale'] = new PDO($connectionStringPale, conexiones['bd_pale']['DB_USER'], conexiones['bd_pale']['DB_PASSWORD']);
			$this->conect['bd_comi'] = new PDO($connectionStringComi, conexiones['bd_comi']['DB_USER'], conexiones['bd_comi']['DB_PASSWORD']);
			$this->conect['bd_chet'] = new PDO($connectionStringChet, conexiones['bd_chet']['DB_USER'], conexiones['bd_chet']['DB_PASSWORD']);
			$this->conect['bd_usr']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->conect['bd_tgz']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->conect['bd_tap']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->conect['bd_camp']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->conect['bd_tapi']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->conect['bd_refo']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->conect['bd_yaj']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->conect['bd_oaxa']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->conect['bd_pale']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->conect['bd_comi']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->conect['bd_chet']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}catch(PDOException $e){
			$this->conect['bd_usr'] = 'Error de conexión';
			$this->conect['bd_tgz'] = 'Error de conexión';
			$this->conect['bd_tap'] = 'Error de conexión';
			$this->conect['bd_camp'] = 'Error de conexión';
			$this->conect['bd_tapi'] = 'Error de conexión';
			$this->conect['bd_refo'] = 'Error de conexión';
			$this->conect['bd_yaj'] = 'Error de conexión';
			$this->conect['bd_oaxa'] = 'Error de conexión';
			$this->conect['bd_pale'] = 'Error de conexión';
			$this->conect['bd_comi'] = 'Error de conexión';
			$this->conect['bd_chet'] = 'Error de conexión';
		    echo "ERROR: " . $e->getMessage();
		}
	}

	public function conect($bd){
		return $this->conect[$bd];
	}
}

?>