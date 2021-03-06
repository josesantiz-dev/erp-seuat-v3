<?php
    class Materias extends Controllers{
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

        public function materias(){
            $data['page_id'] = 9;
            $data['page_tag'] = "Materias";
            $data['page_title'] = "Materias";
            $data['superplanteles'] = $this->model->selectSuperPlanteles('bd_user');
            $data['page_functions_js'] = "functions_materias.js";
            $this->views->getView($this,"materias",$data);
        }
        public function getMaterias(string $nomConexion){
            $arrRes = [];
            if($nomConexion == 'all'){
                foreach (conexiones as $key => $conexion) {
                    if($key != 'bd_user'){
                        $arrData = $this->model->selectMaterias($key);
                        for($i = 0; $i<count($arrData); $i++){
                            $arrData[$i]['nom_conexion'] = $key;
                        }
                        array_push($arrRes, $arrData);
                    }
                }
                $newArray = array_merge([], ...$arrRes);
            }else{
                $newArray = $this->model->selectMaterias($nomConexion);
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
                        <button class="dropdown-item btn btn-outline-secondary btn-sm btn-flat icono-color-principal btnVerMateria" con="'.$newArray[$i]['nom_conexion'].'" onClick="fntVerMateria(this,'.$newArray[$i]['id'].')" data-toggle="modal" data-target="#ModalFormVerMateria" title="Ver"> &nbsp;&nbsp; <i class="fas fa-eye icono-azul"></i> &nbsp; Ver</button>
						<button class="dropdown-item btn btn-outline-secondary btn-sm btn-flat icono-color-principal btnEditMateria" con="'.$newArray[$i]['nom_conexion'].'" onClick="fntEditMateria(this,'.$newArray[$i]['id'].')" data-toggle="modal" data-target="#ModalFormEditMateria" title="Editar"> &nbsp;&nbsp; <i class="fas fa-pencil-alt"></i> &nbsp; Editar</button>
						<div class="dropdown-divider"></div>
						<button class="dropdown-item btn btn-outline-secondary btn-sm btn-flat icono-color-principal btnDelMateria" con="'.$newArray[$i]['nom_conexion'].'" onClick="fntDelMateria(this,'.$newArray[$i]['id'].')" title="Eliminar"> &nbsp;&nbsp; <i class="far fa-trash-alt "></i> &nbsp; Eliminar</button>
						<!--<a class="dropdown-item" href="#">link</a>-->
					</div>
				</div>
				</div>';
            }
            echo json_encode($newArray,JSON_UNESCAPED_UNICODE);
            die();
        }
        public function setMateria(string $nomConexion){
            $data = $_POST;
            $intIdMateriaNueva = 0;
            $intIdMateriaEdit = 0;
            if(isset($_POST['idNuevo'])){
                $intIdMateriaNueva = intval($_POST['idNuevo']);
            }
            if(isset($_POST['idEdit'])){
                $intIdMateriaEdit = intval($_POST['idEdit']);
            }
            if($intIdMateriaNueva == 1){
                $arrData = $this->model->insertMateria($data,$nomConexion);
                if($arrData['estatus'] != TRUE){
                    $arrResponse = array('estatus' => true, 'msg' => 'Datos guardados correctamente');
                }else{
                    $arrResponse = array('estatus' => false, 'msg' => '??Atenci??n! La materia ya existe');
                }
            }
            if($intIdMateriaEdit !=0){
                $arrData = $this->model->updateMateria($intIdMateriaEdit,$data,$_POST['nomConexion_edit']);
                if($arrData){
                    $arrResponse = array('estatus' => true, 'msg' => 'Datos actualizados correctamente');
                }else{
                    $arrResponse = array('estatus' => false, 'msg' => 'No es posible actualizar los datos');

                }
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function getMateria($params){
            $arrParams = explode(',',$params);
            $idMateria = $arrParams[0];
            $nomConexion = $arrParams[1];
            $arrData = $this->model->selectMateria($idMateria,$nomConexion);
            if($arrData){
                echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
                die();
            }
        }
        
        public function getPlanEstudiosNuevo(){
            $id = $_GET['id'];
            $nomConexion = $_GET['con'];
            $arrData = $this->model->selectPlanEstudiosNuevo($id,$nomConexion);
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            die();
        }
        public function getPlanEstudios(string $nomConexion){
            $arrData = $this->model->selectPlanEstudios($nomConexion);
            if($arrData){
                echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
                die();
            }
        }

        public function getGrados(string $nomConexion){
            /* $arrData = $this->model->selectGrados($nomConexion);
            if($arrData){
            } */
            echo json_encode($nomConexion,JSON_UNESCAPED_UNICODE);
            die();
        }
        public function getClasificaciones(string $nomConexion){
            $arrData = $this->model->selectClasificacion($nomConexion);
            if($arrData){
                echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
                die();
            }
        }
        public function getPlanteles(string $nomConexion){
            $arrData = $this->model->selectPlanteles($nomConexion);
            if($arrData){
                echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
                die();
            } 
        }

        //Funcion para Eliminar Materia
		public function delMateria(string $nomConexion){
			if($_POST){
				$intIdMateria = intval($_POST['idMateria']);
				$requestDelete = $this->model->deleteMateria($intIdMateria,$nomConexion);
				if($requestDelete == 'ok'){
					$arrResponse = array('estatus' => true, 'msg' => 'Se ha eliminado la materia.');
				}else{
					$arrResponse = array('estatus' => false, 'msg' => 'Error al eliminar la materia.');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
    }
?>    