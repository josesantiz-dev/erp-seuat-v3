<?php
    class Modalidades extends Controllers{
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
        
         //Funcion para la Vista de Modalidades
        public function modalidades(){
            $data['page_id'] = 6;
            $data['page_tag'] = "Modalidades";
            $data['page_title'] = "Modalidades";
            $data['page_name'] = "modalidades";
			$data['planteles'] = $this->model->selectSuperPlanteles('bd_user');
            $data['page_functions_js'] = "functions_modalidades.js";
            $this->views->getView($this,"modalidades",$data);
        }
        public function getModalidades(string $nomConexion){
            $arrRes = [];
            if($nomConexion == 'all'){
                foreach (conexiones as $key => $conexion) {
                    if($key != 'bd_user'){
                        $arrData = $this->model->selectModalidades($key);
                        for($i =0; $i<count($arrData);$i++){
                            $arrData[$i]['nom_conexion'] = $key;
                        }
                        array_push($arrRes, $arrData);
                    }
                }
                $newArray = array_merge([], ...$arrRes);
            }else{
                $newArray = $this->model->selectModalidades($nomConexion);
                for($i =0; $i<count($newArray);$i++){
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
						<button class="dropdown-item btn btn-outline-secondary btn-sm btn-flat icono-color-principal btnEditModalidad" con="'.$newArray[$i]['nom_conexion'].'" onClick="fntEditModalidad(this,'.$newArray[$i]['id'].')" data-toggle="modal" data-target="#ModalFormEditModalidad" title="Editar"> &nbsp;&nbsp; <i class="fas fa-pencil-alt"></i> &nbsp; Editar</button>
						<div class="dropdown-divider"></div>
						<button class="dropdown-item btn btn-outline-secondary btn-sm btn-flat icono-color-principal btnDelModalidad" con="'.$newArray[$i]['nom_conexion'].'" onClick="fntDelModalidad(this,'.$newArray[$i]['id'].')" title="Eliminar"> &nbsp;&nbsp; <i class="far fa-trash-alt "></i> &nbsp; Eliminar</button>
						<!--<a class="dropdown-item" href="#">link</a>-->
					</div>
				</div>
				</div>';
            }
            echo json_encode($newArray,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function setModalidad(string $nomConexion){
            $data = $_POST;
            $intIdModalidadNueva = 0;
            $intIdModalidadEdit = 0;
            if(isset($_POST['idModalidadNueva'])){
                $intIdModalidadNueva = intval($_POST['idModalidadNueva']);
            }
            if(isset($_POST['idModalidadEdit'])){
                $intIdModalidadEdit = intval($_POST['idModalidadEdit']);
            }
            if($intIdModalidadNueva == 1){
                $arrData = $this->model->insertModalidad($data,$nomConexion);
                if($arrData['estatus'] != TRUE){
                    $arrResponse = array('estatus' => true, 'msg' => 'Datos guardados correctamente');
                }else{
                    $arrResponse = array('estatus' => false, 'msg' => '¡Atención! La modalidad ya existe');
                }
            }
            if($intIdModalidadEdit !=0){
                $arrData = $this->model->updateModalidad($intIdModalidadEdit,$data,$_POST['nomConexion_edit']);
                if($arrData['estatus'] != TRUE){
                    $arrResponse = array('estatus' => true, 'msg' => 'Datos actualizados correctamente');
                }else{
                    $arrResponse = array('estatus' => false, 'msg' => 'El nombre de la modalidad ya esiste');
                }
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function getModalidad($params){
            $arrParams = explode(',',$params);
            $idModalidad = $arrParams[0];
            $nomConexion = $arrParams[1];
            $arrData = $this->model->selectModalidad($idModalidad,$nomConexion);
            if($arrData){
                echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
                die();
            }
        }

        //Funcion para Eliminar Modalidad
		public function delModalidad(string $nomConexion){
			if($_POST){
				$intIdModalidad = intval($_POST['idModalidad']);
				$requestDelete = $this->model->deleteModalidad($intIdModalidad,$nomConexion);
				if($requestDelete == 'ok'){
					$arrResponse = array('estatus' => true, 'msg' => 'Se ha eliminado la modalidad.');
				}else{
					$arrResponse = array('estatus' => false, 'msg' => 'Error al eliminar la modalidad.');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
    }
?>