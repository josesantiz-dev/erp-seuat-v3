<?php
    class PlanEstudios extends Controllers{
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

        public function planestudios(){
            $data['page_id'] = 10;
            $data['page_tag'] = "Planes de estudios";
            $data['page_title'] = "Planes de estudios";
            $data['page_content'] = "";
            $data['page_functions_js'] = "functions_plan_estudios.js";
            $data['planteles'] = $this->model->selectSuperPlanteles('bd_user');
			$data['nomConexion'] = $this->nomConexion;
			$data['claveRol'] = $this->rol;
            $this->views->getView($this,"planestudios",$data);
        }

        function getPlanEstudios(string $nomConexion){
            $arrRes = [];
            if($nomConexion == 'all'){
                foreach (conexiones as $key => $conexion) {
                    if($key != 'bd_user'){
                        $arrData = $this->model->selectPlanEstudios($key);
                        for($i = 0; $i<count($arrData);$i++){
                            $arrData[$i]['nom_conexion'] = $key;
                        }
                        array_push($arrRes,$arrData);
                    }
                }
                $newArray = array_merge([], ...$arrRes);
            }else{
                $newArray = $this->model->selectPlanEstudios($nomConexion);
                for($i = 0; $i<count($newArray);$i++){
                    $newArray[$i]['nom_conexion'] = $nomConexion;
                }
            }
            for ($i=0; $i < count($newArray); $i++){
                $newArray[$i]['numeracion'] = $i+1;
				$newArray[$i]['nombre_plantel'] = $newArray[$i]['nombre_plantel'].' ('.$newArray[$i]['municipio'].')';
                if($newArray[$i]['estatus'] == 1)
				{
					$newArray[$i]['estatus'] = '<span class="badge badge-dark">Activo</span>';
				}else{
					$newArray[$i]['estatus'] = '<span class="badge badge-secondary">Inactivo</span>';
				}
                $newArray[$i]['options'] = '<div class="text-center">
				<div class="btn-group">
					<button type="button" class="btn btn-outline-secondary btn-xs icono-color-principal dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fas fa-layer-group"></i> &nbsp; Acciones
					</button>
					<div class="dropdown-menu">
						<button class="dropdown-item btn btn-outline-secondary btn-sm btn-flat icono-color-principal btnVerPlanEstudios" con="'.$newArray[$i]['nom_conexion'].'" onClick="fntVerPlanEstudios(this,'.$newArray[$i]['id'].')" data-toggle="modal" data-target="#ModalFormVerPlanEstudios" title="Ver"> &nbsp;&nbsp; <i class="fas fa-eye icono-azul"></i> &nbsp; Ver</button>
						<button class="dropdown-item btn btn-outline-secondary btn-sm btn-flat icono-color-principal btnEditPlanEstudios" con="'.$newArray[$i]['nom_conexion'].'" onClick="fntEditPlanEstudios(this,'.$newArray[$i]['id'].')" data-toggle="modal" data-target="#ModalFormEditPlanEstudios" title="Editar"> &nbsp;&nbsp; <i class="fas fa-pencil-alt"></i> &nbsp; Editar</button>
						<div class="dropdown-divider"></div>
						<button class="dropdown-item btn btn-outline-secondary btn-sm btn-flat icono-color-principal btnDelPlanEstudios" con="'.$newArray[$i]['nom_conexion'].'" onClick="fntDelPlanEstudios(this,'.$newArray[$i]['id'].')" title="Eliminar"> &nbsp;&nbsp; <i class="far fa-trash-alt "></i> &nbsp; Eliminar</button>
						<!--<a class="dropdown-item" href="#">link</a>-->
					</div>
				</div>
				</div>';
            }
            echo json_encode($newArray, JSON_UNESCAPED_UNICODE);
            die();
        }
        //Funcion para guardar una Categoria
		public function setPlanEstudios(){
			$data = $_POST;
			$arreglo = json_decode(($_GET['valores']));
            $nomConexion = ($_GET['con']);
			$idPlanEstudiosEdit = 0;
			$idPlanEstudiosNuevo = 0;
			if(isset($_POST['idNuevo'])){
				$idPlanEstudiosNuevo = intval($_POST['idNuevo']);
			}
			if(isset($_POST['idEdit'])){
				$idPlanEstudiosEdit = intval($_POST['idEdit']);
			}
			
			if($idPlanEstudiosEdit != 0 ){
				$arrData = $this->model->updatePlanEstudios($idPlanEstudiosEdit,$data,$arreglo,$_POST['nomConexion_edit']);
				if($arrData){
					$arrResponse = array('estatus' => true, 'msg' => 'Datos actualizados correctamente.');
				}else{
					$arrResponse = array('estatus' => false, 'mgg' => 'No es posible actualizar los datos.');
				}
			}
			if($idPlanEstudiosNuevo == 1){
				$arrData = $this->model->insertPlanEstudios($data,$arreglo,$nomConexion);
			    if($arrData){
			        $arrResponse = array('estatus' => true, 'msg' => 'Datos guardados correctamente.');
			    }else{
			        $arrResponse = array('estatus' => false, 'mgg' => 'No es posible almacenar los datos'); 
                }
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}

        public function getPlanEstudio($params){
            $arrParams = explode(',',$params);
            $idPlanEstudio = $arrParams[0];
            $nomConexion = $arrParams[1];
            $arrData['plan_estudio'] = $this->model->selectPlanEstudio($idPlanEstudio,$nomConexion);
            $arrData['clasificaciones'] = $this->model->selectClasificacionPlanEstudio($idPlanEstudio,$nomConexion);
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			die();
        }
        public function getPlanEstudioEdit($params){
            $arrParams = explode(',',$params);
            $idPlanEstudio = $arrParams[0];
            $nomConexion = $arrParams[1];
			$arrData['plan_estudio'] = $this->model->selectPlanEstudioEdit($idPlanEstudio,$nomConexion);
            $arrData['clasificaciones'] = $this->model->selectClasificacionPlanEstudio($idPlanEstudio,$nomConexion);
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            die();
        }

		public function delPlanEstudio(string $nomConexion){
			if($_POST){
					$intIdPlanEstudio = intval($_POST['idPlanEstudio']);
					$requestTablaRef = $this->model->getTablasRef($nomConexion);
					if(count($requestTablaRef)>0){
						$requestStatus = 0;
						foreach ($requestTablaRef as $key => $tabla) {
							$nombreTabla = $tabla['tablas'];
							$existColumn = $this->model->selectColumn($nombreTabla,$nomConexion);
							if($existColumn){
								$requestEstatusRegistro = $this->model->estatusRegistroTabla($nombreTabla,$intIdPlanEstudio,$nomConexion);
								if($requestEstatusRegistro){
									$requestStatus += count($requestEstatusRegistro);
								}else{
									$requestStatus += 0;
								}	
							}
						}
						if($requestStatus == 0){
							$requestDelete = $this->model->deletePlanEdtudio($intIdPlanEstudio,$nomConexion);
							if($requestDelete == 'ok'){
								$arrResponse = array('estatus' => true, 'msg' => 'Se ha eliminado el plan de estudios.');
							}else if($requestDelete == 'exist'){
								$arrResponse = array('estatus' => false, 'msg' => 'No es posible eliminar el plan de estudios.');
							}else{
								$arrResponse = array('estatus' => false, 'msg' => 'Error al eliminar el plan de estudios.');
							}
						}else{
							$arrResponse = array('estatus' => false, 'msg' => 'No es posible eliminar porque hay materias activas relacionados a este plan de estudios.');
						}
					}else{
						$arrResponse = "eliminando";
						$requestDelete = $this->model->deletePlanEdtudio($intIdPlanEstudio,$nomConexion);
						if($requestDelete == 'ok'){
							$arrResponse = array('estatus' => true, 'msg' => 'Se ha eliminado el plan de estudios.');
						}else if($requestDelete == 'exist'){
							$arrResponse = array('estatus' => false, 'msg' => 'No es posible eliminar el plan de estudios.');
						}else{
							$arrResponse = array('estatus' => false, 'msg' => 'Error al eliminar el plan de estudios.');
						}
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

        public function getPlanteles(string $nomConexion){
            $arrData = $this->model->selectPlanteles($nomConexion);
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            die();
        }
        public function getNivelesEducativos(string $nomConexion){
            $arrData = $this->model->selectNivelEducativo($nomConexion);
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            die();
        }
        public function getCategorias(string $nomConexion){
            $arrData = $this->model->selectCategorias($nomConexion);
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            die();
        }
        public function getModalidades(string $nomConexion){
            $arrData = $this->model->selectModalidades($nomConexion);
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            die();
        }
        public function getPlanes(string $nomConexion){
            $arrData = $this->model->selectPlanes($nomConexion);
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            die();
        }
        public function getClacificaciones(string $nomConexion){
            $arrData = $this->model->selectClasificaciones($nomConexion);
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            die();
        }
       
    }
?>