<?php

	class Plantel extends Controllers{
		private $idUser;
		private $nomConexion;
		private $rol;
		public function __construct()
		{
			parent::__construct();
			session_start();
		    if(empty($_SESSION['login']))
		    {
			    header('Location: '.base_url().'/login');
			    die();
		    }
			$this->idUser = $_SESSION['idUser'];
			$this->nomConexion = $_SESSION['nomConexion'];
			$this->rol = $_SESSION['claveRol'];
		}

		//Funcion para la Vista de Planteles
		public function Plantel()
		{
			$data['page_id'] = 4;
			$data['page_tag'] = "Planteles";
			$data['page_title'] = "Planteles";
			$data['page_name'] = "plantel";
			$data['page_content'] = "";
			$data['page_functions_js'] = "functions_planteles.js";
			$data['planteles'] = $this->model->selectSuperPlanteles('bd_user');
			$data['lista_categorias'] = $this->model->selectCategorias($this->nomConexion); //Traer lista de Categorias
			$data['lista_estados'] = $this->model->selectEstados($this->nomConexion); //Traer lista de Estados
			$this->views->getView($this,"plantel",$data);
		}

		//Funcion para traer Lista de Planteles
		public function getPlanteles(string $nomConexion){
			$arrRes = [];
			if($nomConexion == 'all'){
				foreach (conexiones as $key => $conexion) {
					if($key != 'bd_user'){
						$arrData = $this->model->selectPlanteles($key);
						if(count($arrData) > 0 ){
							for($i = 0; $i<count($arrData); $i++){
								$arrData[$i]['nom_conexion'] = $key;
							}
							array_push($arrRes, $arrData);
						}
					}
				}
				$newArray = array_merge([], ...$arrRes);
			}else{
				$newArray = $this->model->selectPlanteles($nomConexion);
				for($i = 0; $i<count($newArray); $i++){
					$newArray[$i]['nom_conexion'] = $nomConexion;
				}
			}
			for ($i=0; $i < count($newArray); $i++) {
				$newArray[$i]['numeracion'] = $i+1;
				$newArray[$i]['options'] = '<div class="text-center">
				<div class="btn-group">
					<button type="button" class="btn btn-outline-secondary btn-xs icono-color-principal dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fas fa-layer-group"></i> &nbsp; Acciones
					</button>
					<div class="dropdown-menu">
						<button class="dropdown-item btn btn-outline-secondary btn-sm btn-flat icono-color-principal btnVerPlantel" con="'.$newArray[$i]['nom_conexion'].'" onClick="fntVerPlantel(this,'.$newArray[$i]['id'].')" data-toggle="modal" data-target="#ModalVerPlantel" title="Ver"> &nbsp;&nbsp; <i class="fas fa-eye icono-azul"></i> &nbsp; Ver</button>
						<button class="dropdown-item btn btn-outline-secondary btn-sm btn-flat icono-color-principal btnEditPlantel" con="'.$newArray[$i]['nom_conexion'].'" onClick="fntEditPlantel(this,'.$newArray[$i]['id'].')" data-toggle="modal" data-target="#ModalFormEditPlantel" title="Editar"> &nbsp;&nbsp; <i class="fas fa-pencil-alt"></i> &nbsp; Editar</button>
						<div class="dropdown-divider"></div>
						<button class="dropdown-item btn btn-outline-secondary btn-sm btn-flat icono-color-principal btnDelPlantel" con="'.$newArray[$i]['nom_conexion'].'" onClick="fntDelPlantel(this,'.$newArray[$i]['id'].')" title="Eliminar"> &nbsp;&nbsp; <i class="far fa-trash-alt "></i> &nbsp; Eliminar</button>
						<!--<a class="dropdown-item" href="#">link</a>-->
					</div>
				</div>
				</div>';
			}
			echo json_encode($newArray,JSON_UNESCAPED_UNICODE);
			die();
		}
		
		//Funcion para obtener Datos de un Plantel
		public function getPlantel($params){
			$arrParams = explode(',',$params);
			$idPlantel = $arrParams[0];
			$nomConexion = $arrParams[1];
			$arrData = $this->model->selectPlantel($idPlantel,$nomConexion);;
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			die();
		}
		//Funcion para traer Lista de Municipios
		public function getMunicipios(){
			$idEstado = $_GET['idestado'];
			$arrData = $this->model->selectMunicipios($idEstado,$this->nomConexion);
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			die();
		}
		//Funcion para traer Lista de Localidades
		public function getLocalidades(){
			$idMunicipio = $_GET['idmunicipio'];
			$arrData = $this->model->selectLocalidades($idMunicipio, $this->nomConexion);
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			die();
		}
		//Funcion para Guardar un Nuevo Plantel
		public function setPlantel($nomConexion){
			$data = $_POST;
            $files = $_FILES;
			$idPlantelEdit = 0;
			$idPlantelNuevo = 0;
			if(isset($_POST['idPlantelNuevo'])){
				$idPlantelNuevo = intval($_POST['idPlantelNuevo']);
			}
			if(isset($_POST['idPlantelEdit'])){
				$idPlantelEdit = intval($_POST['idPlantelEdit']);
			}
			
			if($idPlantelEdit != 0 ){
				$arrData = $this->model->updatePlantel($idPlantelEdit,$data,$files,$_POST['nombreConexionEdit']);
			    if($arrData['estatus'] != TRUE){
					$arrResponse = array('estatus' => true, 'msg' => 'Datos actualizados correctamente.');
				}else{
					$arrResponse = array('estatus' => false, 'msg' => 'La Clave del centro de trabajo ya existe');
				}
			}
			if($idPlantelNuevo == 1){
				$arrData = $this->model->insertPlantel($data,$files,$nomConexion);
			    if($arrData['estatus'] != TRUE){
			        $arrResponse = array('estatus' => true, 'msg' => 'Datos guardados correctamente.');
			    }else{
			    $arrResponse = array('estatus' => false, 'msg' => '??Atenci??n! La Clave del centro de trabajo ya existe'); 
                }
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}

		//Funcion para Elimniar un Plantel
		public function delPlantel($nomConexion){
			if($_POST){
					$intIdPlantel = intval($_POST['idPlantel']);
					$requestTablaRef = $this->model->getTablasRef($nomConexion);
					if(count($requestTablaRef)>0){
						$requestStatus = 0;
						foreach ($requestTablaRef as $key => $tabla) {
							$nombreTabla = $tabla['tablas'];
							$existColumn = $this->model->selectColumn($nombreTabla, $nomConexion);
							if($existColumn){
								$requestEstatusRegistro = $this->model->estatusRegistroTabla($nombreTabla,$intIdPlantel, $nomConexion);
								if($requestEstatusRegistro){
									$requestStatus += count($requestEstatusRegistro);
								}else{
									$requestStatus += 0;
								}
							}
						}
						if($requestStatus == 0){
							$requestDelete = $this->model->deletePlantel($intIdPlantel, $nomConexion);
							if($requestDelete == 'ok'){
								$arrResponse = array('estatus' => true, 'msg' => 'Se ha eliminado el Plantel.');
							}else if($requestDelete == 'exist'){
								$arrResponse = array('estatus' => false, 'msg' => 'No es posible eliminar el plantel.');
							}else{
								$arrResponse = array('estatus' => false, 'msg' => 'Error al eliminar el plantel.');
							}
						}else{
							$arrResponse = array('estatus' => false, 'msg' => 'No es posible eliminar porque hay plan de estudios activos relacionados a este plantel.');
						}
					}else{
						$requestDelete = $this->model->deletePlantel($intIdPlantel,$nomConexion);
						if($requestDelete == 'ok'){
							$arrResponse = array('estatus' => true, 'msg' => 'Se ha eliminado el Plantel.');
						}else if($requestDelete == 'exist'){
							$arrResponse = array('estatus' => false, 'msg' => 'No es posible eliminar el plantel.');
						}else{
							$arrResponse = array('estatus' => false, 'msg' => 'Error al eliminar el plantel.');
						}
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getListEstados(){
			$arrResponse = $this->model->selectEstados($this->nomConexion);
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}

	}
?>