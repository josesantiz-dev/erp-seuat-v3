<?php

	//define("BASE_URL", "http://localhost/erp-seuat-v1/");
	const BASE_URL = "http://192.168.23.174/erp-seuat-v3";

	//Zona horaria
	date_default_timezone_set('America/Mexico_City');
	//const LIBS = "Libraries/";
	//const VIEWS = "Views/";
    //const basedatos = "Cam";
	const conexiones = array(
		'bd_user' => array( //base datos Usuarios
			'DB_HOST'=>'192.168.5.169',
			'DB_NAME' => 'erpseuat_users',
			'DB_USER' => 'usr_seuat',
			'DB_PASSWORD' => 'seuat21',
			'DB_CHARSET' => 'utf8'
		),
		'bd_tgz' => array( //base datos Tuxtla
			'DB_HOST'=>'192.168.5.169',
			'DB_NAME' => 'erpseuat_tuxtla',
			'DB_USER' => 'usr_seuat',
			'DB_PASSWORD' => 'seuat21',
			'DB_CHARSET' => 'utf8'
		),
		'bd_tap' => array( //base datos Tapachula
			'DB_HOST'=>'192.168.5.169',
			'DB_NAME' => 'erpseuat_tapachula',
			'DB_USER' => 'usr_seuat',
			'DB_PASSWORD' => 'seuat21',
			'DB_CHARSET' => 'utf8'
		),
		'bd_camp' => array( //base datos Campeche	
			'DB_HOST'=>'192.168.5.169',
			'DB_NAME' => 'erpseuat_campeche',
			'DB_USER' => 'usr_seuat',
			'DB_PASSWORD' => 'seuat21',
			'DB_CHARSET' => 'utf8'
        ),
        'bd_tapi' => array( //base datos Tapilula	
			'DB_HOST'=>'192.168.5.169',
			'DB_NAME' => 'erpseuat_tapilula',
			'DB_USER' => 'usr_seuat',
			'DB_PASSWORD' => 'seuat21',
			'DB_CHARSET' => 'utf8'
		),
        'bd_refo' => array( //base datos Reforma	
			'DB_HOST'=>'192.168.5.169',
			'DB_NAME' => 'erpseuat_reforma',
			'DB_USER' => 'usr_seuat',
			'DB_PASSWORD' => 'seuat21',
			'DB_CHARSET' => 'utf8'
		),
        'bd_yaj' => array( //base datos Yajalon	
			'DB_HOST'=>'192.168.5.169',
			'DB_NAME' => 'erpseuat_yajalon',
			'DB_USER' => 'usr_seuat',
			'DB_PASSWORD' => 'seuat21',
			'DB_CHARSET' => 'utf8'
		),
        'bd_oaxa' => array( //base datos Oaxaca	
			'DB_HOST'=>'192.168.5.169',
			'DB_NAME' => 'erpseuat_oaxaca',
			'DB_USER' => 'usr_seuat',
			'DB_PASSWORD' => 'seuat21',
			'DB_CHARSET' => 'utf8'
		),
        'bd_pale' => array( //base datos Palenque	
			'DB_HOST'=>'192.168.5.169',
			'DB_NAME' => 'erpseuat_palenque',
			'DB_USER' => 'usr_seuat',
			'DB_PASSWORD' => 'seuat21',
			'DB_CHARSET' => 'utf8'
		),
        'bd_comi' => array( //base datos Comitan	
			'DB_HOST'=>'192.168.5.169',
			'DB_NAME' => 'erpseuat_comitan',
			'DB_USER' => 'usr_seuat',
			'DB_PASSWORD' => 'seuat21',
			'DB_CHARSET' => 'utf8'
		),
        'bd_chet' => array( //base datos Chetumal	
			'DB_HOST'=>'192.168.5.169',
			'DB_NAME' => 'erpseuat_chetumal',
			'DB_USER' => 'usr_seuat',
			'DB_PASSWORD' => 'seuat21',
			'DB_CHARSET' => 'utf8'
		)
        
	);
	//Delimitadores decimal y millar Ej. 27,1985.00
	const SPD = "."; //Separador de decimales
	const SPM = ","; //Separador de millares

	//Simbolo de moneda
	const SMONEDA = "$";

?>