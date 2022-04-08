<?php
    class NivelEducativo extends Controllers{
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
        //Funccion para la Vista de NivelEducativos
        public function niveleducativo(){
            $data['page_id'] = 7;
            $data['page_tag'] = "Niveles educativo";
            $data['page_title'] = "Niveles educativos";
			$data['planteles'] = $this->model->selectSuperPlanteles('bd_user');
            $data['page_functions_js'] = "functions_nivel_educativo.js";
            $this->views->getView($this,"niveleducativo",$data);
        }
        public function getNivelesEducativos(string $nomConexion){
            $arrRes = [];
            if($nomConexion == 'all'){
                foreach (conexiones as $key => $conexion) {
                    if($key != 'bd_user'){
                        $arrData = $this->model->selectNivelesEducativos($key);
                        for($i = 0; $i<count($arrData); $i++){
                            $arrData[$i]['nom_conexion'] = $key;
                            $arrData[$i]['nom_plantel'] = $this->model->selectConexion($key);
                        }
                        array_push($arrRes,$arrData);
                    }
                }
                $newArray = array_merge([], ...$arrRes);
            }else{
                $newArray = $this->model->selectNivelesEducativos($nomConexion);
                for($i = 0; $i<count($newArray); $i++){
                    $newArray[$i]['nom_conexion'] = $nomConexion;
                    $newArray[$i]['nom_plantel'] = $this->model->selectConexion($nomConexion);
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
						<button class="dropdown-item btn btn-outline-secondary btn-sm btn-flat icono-color-principal btnEditNivelEducativo" con="'.$newArray[$i]['nom_conexion'].'" onClick="fntEditNivelEducativo(this,'.$newArray[$i]['id'].')" data-toggle="modal" data-target="#ModalFormEditNivelEducativo" title="Editar"> &nbsp;&nbsp; <i class="fas fa-pencil-alt"></i> &nbsp; Editar</button>
						<div class="dropdown-divider"></div>
						<button class="dropdown-item btn btn-outline-secondary btn-sm btn-flat icono-color-principal btnDelNivelEducativo" con="'.$newArray[$i]['nom_conexion'].'" onClick="fntDelNivelEducativo(this,'.$newArray[$i]['id'].')" title="Eliminar"> &nbsp;&nbsp; <i class="far fa-trash-alt "></i> &nbsp; Eliminar</button>
						<!--<a class="dropdown-item" href="#">link</a>-->
					</div>
				</div>
				</div>';
            }
            echo json_encode($newArray,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function setNivelEducativo(string $nomConexion){
            $data = $_POST;
            $intIdNivelEducativoNuevo = 0;
            $intIdNivelEducativoEdit = 0;
            if(isset($_POST['idNuevo'])){
                $intIdNivelEducativoNuevo = intval($_POST['idNuevo']);
            }
            if(isset($_POST['idEdit'])){
                $intIdNivelEducativoEdit = intval($_POST['idEdit']);
            }
            if($intIdNivelEducativoNuevo == 1){
                $arrData = $this->model->insertNivelEducativo($data,$nomConexion);
                if($arrData['estatus'] != TRUE){
                    $arrResponse = array('estatus' => true, 'msg' => 'Datos guardados correctamente');
                }else{
                    $arrResponse = array('estatus' => false, 'msg' => '¡Atención! El nivel educativo ya existe');
                }
            }
            if($intIdNivelEducativoEdit !=0){
                $arrData = $this->model->updateNivelEducativo($intIdNivelEducativoEdit,$data,$_POST['nomConexion_edit']);
                if($arrData['estatus'] != TRUE){
                    $arrResponse = array('estatus' => true, 'msg' => 'Datos actualizados correctamente');
                }else{
                    $arrResponse = array('estatus' => false, 'msg' => $arrData['msg']);
                }
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function getNivelEducativo($params){
            $arrParams = explode(',',$params);
            $idNivelEducativo = $arrParams[0];
            $nomConexion = $arrParams[1];
            $arrData = $this->model->selectNivelEducativo($idNivelEducativo,$nomConexion);
            if($arrData){
                echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
                die();
            }
        }

        //Funcion para Eliminar Nivel Educativo
		public function delNivelEducativo(string $nomConexion){
			if($_POST){
				$intIdNivelEductaivo = intval($_POST['idNivelEducativo']);
				$requestDelete = $this->model->deleteNivelEducativo($intIdNivelEductaivo,$nomConexion);
				if($requestDelete == 'ok'){
					$arrResponse = array('estatus' => true, 'msg' => 'Se ha eliminado el nivel educativo.');
				}else{
					$arrResponse = array('estatus' => false, 'msg' => 'Error al eliminar el nivel educativo.');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
    }
?>