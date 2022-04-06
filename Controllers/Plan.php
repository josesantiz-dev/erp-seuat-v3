<?php
    class Plan extends Controllers{
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
        public function plan(){
            $data['page_id'] = 8;
            $data['page_tag'] = "Organización de planes";
            $data['page_title'] = "Organización del plan de programa";
			$data['planteles'] = $this->model->selectSuperPlanteles('bd_user');
            $data['page_functions_js'] = "functions_plan.js";
            $this->views->getView($this,"plan",$data);
        }
        public function getPlanes(string $nomConexion){
            $arrRes = [];
            if($nomConexion == 'all'){
                foreach (conexiones as $key => $conexion) {
                    if($key != 'bd_user'){
                        $arrData = $this->model->selectPlanes($key);
                        for($i = 0; $i<count($arrData); $i++){
                            $arrData[$i]['nom_conexion'] = $key;
                        }
                        array_push($arrRes,$arrData);
                    }
                }
                $newArray = array_merge([], ...$arrRes);
            }else{
                $newArray = $this->model->selectPlanes($nomConexion);
                for($i = 0; $i<count($newArray); $i++){
                    $newArray[$i]['nom_conexion'] = $nomConexion;
                }
            }
            for ($i=0; $i<count($newArray); $i++){
                $newArray[$i]['numeracion'] = $i+1;
                if($newArray[$i]['estatus'] == 1){
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
						<button class="dropdown-item btn btn-outline-secondary btn-sm btn-flat icono-color-principal btnEditPlan" con="'.$newArray[$i]['nom_conexion'].'" onClick="fntEditPlan(this,'.$newArray[$i]['id'].')" data-toggle="modal" data-target="#ModalFormEditPlan" title="Editar"> &nbsp;&nbsp; <i class="fas fa-pencil-alt"></i> &nbsp; Editar</button>
						<div class="dropdown-divider"></div>
						<button class="dropdown-item btn btn-outline-secondary btn-sm btn-flat icono-color-principal btnDelPlan" con="'.$newArray[$i]['nom_conexion'].'" onClick="fntDelPlan(this,'.$newArray[$i]['id'].')" title="Eliminar"> &nbsp;&nbsp; <i class="far fa-trash-alt "></i> &nbsp; Eliminar</button>
						<!--<a class="dropdown-item" href="#">link</a>-->
					</div>
				</div>
				</div>';
            }
            echo json_encode($newArray,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function setPlan(string $nomConexion){
            $data = $_POST;
            $intIdPlanNuevo = 0;
            $intIdPlanEdit = 0;
            if(isset($_POST['idNuevo'])){
                $intIdPlanNuevo = intval($_POST['idNuevo']);
            }
            if(isset($_POST['idEdit'])){
                $intIdPlanEdit = intval($_POST['idEdit']);
            }
            if($intIdPlanNuevo == 1){
                $arrData = $this->model->insertPlan($data,$nomConexion);
                if($arrData['estatus'] != TRUE){
                    $arrResponse = array('estatus' => true, 'msg' => 'Datos guardados correctamente');
                }else{
                    $arrResponse = array('estatus' => false, 'msg' => '¡Atención! El plan ya existe');
                }
            }
            if($intIdPlanEdit !=0){
                $arrData = $this->model->updatePlan($intIdPlanEdit,$data,$_POST['nomConexion_edit']);
                if($arrData['estatus'] != TRUE){
                    $arrResponse = array('estatus' => true, 'msg' => 'Datos actualizados correctamente');
                }else{
                    $arrResponse = array('estatus' => false, 'msg' => $arrData['msg']);
                }
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function getPlan($params){
            $arrParams = explode(',',$params);
            $idPlan = $arrParams[0];
            $nomConexion = $arrParams[1];
            $arrData = $this->model->selectPlan($idPlan,$nomConexion);
            if($arrData){
                echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
                die();
            }
        }

        //Funcion para Eliminar Plan
		public function delPlan(string $nomConexion){
			if($_POST){
				$intIdPlan = intval($_POST['idPlan']);
				$requestDelete = $this->model->deletePlan($intIdPlan,$nomConexion);
				if($requestDelete == 'ok'){
					$arrResponse = array('estatus' => true, 'msg' => 'Se ha eliminado el plan.');
				}else{
					$arrResponse = array('estatus' => false, 'msg' => 'Error al eliminar el plan.');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
    }
?>