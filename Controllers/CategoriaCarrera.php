<?php
	class CategoriaCarrera extends Controllers{
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
		//Funcion para la Vista de Carreras
		public function categoriacarrera()
		{
			$data['page_id'] = 5;
			$data['page_tag'] = "Categorías carreras";
			$data['page_title'] = "Categorías carreras";
			$data['page_name'] = "Categorías carreras";
			$data['planteles'] = $this->model->selectSuperPlanteles('bd_user');
			$data['page_functions_js'] = "functions_categoria_carreras.js";
			$this->views->getView($this,"categoriacarrera",$data);
		}
		//Funcion para lista de Categorias Carreras
		public function getCategoriasCarreras(string $nomConexion){
            $arrRes = [];
            if($nomConexion == 'all'){
                foreach (conexiones as $key => $conexion) {
                    if($key != 'bd_user'){
                        $arrData = $this->model->selectCategoriasCarreras($key);
                        for($i = 0; $i<count($arrData); $i++){
                            $arrData[$i]['nom_conexion'] = $key;
                        }
                        array_push($arrRes,$arrData);
                    }
                }
                $newArray = array_merge([], ...$arrRes);
            }else{
                $newArray = $this->model->selectCategoriasCarreras($nomConexion);
                for($i = 0; $i<count($newArray); $i++){
                    $newArray[$i]['nom_conexion'] = $nomConexion;
                }
            }
			//$arrData = $this->model->selectCategoriasCarreras();
			for ($i=0; $i < count($newArray); $i++) {
				$newArray[$i]['numeracion'] = $i+1;
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
						<button class="dropdown-item btn btn-outline-secondary btn-sm btn-flat icono-color-principal btnEditCategoriaCarrera" con="'.$newArray[$i]['nom_conexion'].'" onClick="fntEditCategoriaCarrera(this,'.$newArray[$i]['id'].')" data-toggle="modal" data-target="#ModalFormEditCategoriaCarrera" title="Editar"> &nbsp;&nbsp; <i class="fas fa-pencil-alt"></i> &nbsp; Editar</button>
						<div class="dropdown-divider"></div>
						<button class="dropdown-item btn btn-outline-secondary btn-sm btn-flat icono-color-principal btnDelCategoriaCarrera" con="'.$newArray[$i]['nom_conexion'].'" onClick="fntDelCategoriaCarrera(this,'.$newArray[$i]['id'].')" title="Eliminar"> &nbsp;&nbsp; <i class="far fa-trash-alt "></i> &nbsp; Eliminar</button>
						<!--<a class="dropdown-item" href="#">link</a>-->
					</div>
				</div>
				</div>';
			}
			echo json_encode($newArray,JSON_UNESCAPED_UNICODE);
			die();
		}
		//Funcion para guardar una Categoria
		public function setCategioriaCarrera(string $nomConexion){
			$data = $_POST;
			$idCategoriaCarreraEdit = 0;
			$idCategoriaCarreraNuevo = 0;
			if(isset($_POST['idCategoriaNueva'])){
				$idCategoriaCarreraNuevo = intval($_POST['idCategoriaNueva']);
			}
			if(isset($_POST['idCategoriaEdit'])){
				$idCategoriaCarreraEdit = intval($_POST['idCategoriaEdit']);
			}
			
			if($idCategoriaCarreraEdit != 0 ){
				$arrData = $this->model->updateCategoriaCarrera($idCategoriaCarreraEdit,$data,$_POST['nomConexion_edit']);
				if($arrData['estatus'] != TRUE){
                    $arrResponse = array('estatus' => true, 'msg' => 'Datos actualizados correctamente');
                }else{
                    $arrResponse = array('estatus' => false, 'msg' => 'El nombre de la categoría ya esiste');
                }
			}
			if($idCategoriaCarreraNuevo == 1){
				$arrData = $this->model->insertCategoriaCarrera($data,$nomConexion);
				if($arrData['estatus'] != TRUE){
                    $arrResponse = array('estatus' => true, 'msg' => 'Datos guardados correctamente');
                }else{
                    $arrResponse = array('estatus' => false, 'msg' => '¡Atención! La categoría ya existe');
                }
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}
		public function getCategoriaCarrera($params){
            $arrParams = explode(',',$params);
			$idCategoriaCarrera = $arrParams[0];
            $nomConexion = $arrParams[1];
			$arrData = $this->model->selectCategoriaCarrera($idCategoriaCarrera,$nomConexion);
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			die();
		}

		//Funcion para Eliminar categoría Carrera
		public function delCategoriaCarrera(string $nomConexion){
			if($_POST){
				$intIdCategoria = intval($_POST['idCategoriaCarrera']);
				$requestDelete = $this->model->deleteCategoriaCarrera($intIdCategoria,$nomConexion);
				if($requestDelete == 'ok'){
					$arrResponse = array('estatus' => true, 'msg' => 'Se ha eliminado la categoria.');
				}else{
					$arrResponse = array('estatus' => false, 'msg' => 'Error al eliminar la categoria.');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
	}
?>