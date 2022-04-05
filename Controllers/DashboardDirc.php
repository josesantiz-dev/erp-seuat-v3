<?php
	class DashboardDirc extends Controllers{
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
		public function DashboardDirc(){
			$data['page_id'] = 2;
			$data['page_tag'] = "Dashboard DIRC";
			$data['page_title'] = "Página Dashboard";
			$data['page_name'] = "Página Dashboard";
			$data['page_functions_js'] = "functions_dashboard_dirc.js";
			$data['planteles'] = $this->model->selectPlanteles('bd_usr');
			$this->views->getView($this,"dashboarddirc",$data);
		}

		public function getTotalesCard($nomonexion){
			$conexionConsultar = $nomonexion;
			if($conexionConsultar == 'all'){
				$totalPlanteles = $this->model->selectTotalPlanteles('bd_usr');
				$totalPlanEstudios = 0;
				$totalMaterias = 0;
				$totalRVOES = 0;
				foreach (conexiones as $key => $conexion) {
					if($key != 'bd_usr'){
						$planEstudios = $this->model->selectTotalesPlanEstudios($key);
						$totalPlanEstudios += $planEstudios['total'];
						$materias = $this->model->selectTotalesMaterias($key);
						$totalMaterias += $materias['total'];
						$rvoes = $this->model->selectTotalesRVOES($key);
						$totalRVOES += $rvoes['total'];
					}
				}
				$arrData['planteles'] = $totalPlanteles['total'];
                $arrData['plan_estudios'] = $totalPlanEstudios;
                $arrData['materias'] = $totalMaterias;
                $arrData['rvoes'] = $totalRVOES;
                $arrData['tipo'] = "all";
			}else{
				$arrData['plan_estudios'] = $this->model->selectTotalesPlanEstudios($conexionConsultar);
                $arrData['materias'] = $this->model->selectTotalesMaterias($conexionConsultar);
                $arrData['rvoes'] = $this->model->selectTotalesRVOES($conexionConsultar);
                $arrData['tipo'] = "";

			}
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            die();
		}
		public function getListaRvoesExpirar($plantel){
			$plantelConsultar = $plantel;
			$arrData = $this->model->selectRvoesExpirar($plantelConsultar);
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            die();
		}
		public function getPlanEstudiosMateriabyPlantel($nomConexion){
			if($nomConexion == "all"){
				$arrData = $this->model->selectPlanteles('bd_usr');
				$array = [];
				foreach ($arrData as $key => $value) {
					$arrPlanEstudios = $this->model->selectPlanEstudiosbyPlantel($value['nombre_conexion']);
					$arrMaterias = $this->model->selectMateriasbyPlantel($value['nombre_conexion']);
					/*$rvoes = $this->model->selectRVOEproximoExpbyPlantel($value['id']);
					$array[$value['id']] = array('id_plantel'=>$value['id'],'abreviacion_plantel'=>$value['abreviacion_plantel'],'municipio'=>$value['municipio'],'carreras' => $arrPlanEstudios['total'],'materias'=>$arrMaterias['total'],'rvoes'=>$rvoes); */
				}
			}else{
				$array;
				$arrPlanEstudios = $this->model->selectPlanEstudiosbyPlantel($plantel);
				$arrMaterias = $this->model->selectMateriasbyPlantel($plantel);
				$rvoes = $this->model->selectRVOEproximoExpbyPlantel($plantel);
				$array[$plantel] = array('id_plantel'=>$plantel,'abreviacion_plantel'=>null,'carreras' => $arrPlanEstudios['total'],'materias'=>$arrMaterias['total'],'rvoes'=>$rvoes);
			}
			echo json_encode($arrPlanEstudios,JSON_UNESCAPED_UNICODE);
            die();
		}
	}
?>