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
			$data['superplanteles'] = $this->model->selectSuperplanteles('bd_user');
			$this->views->getView($this,"dashboarddirc",$data);
		}

		public function getTotalesCard($params){
			$arrParams = explode(',',$params);
			$nomConexion = $arrParams[0];
			$idPlatel = $arrParams[1];
			if($nomConexion == 'all' && $idPlatel == 'all'){
				$totalPlanteles = 0;
				$totalPlanEstudios = 0;
				$totalMaterias = 0;
				$totalRVOES = 0;
				foreach (conexiones as $key => $conexion) {
					if($key != 'bd_user'){
						$planteles = $this->model->selectTotalPlanteles($key);
						$totalPlanteles += $planteles['total'];
						$planEstudios = $this->model->selectTotalesPlanEstudios($key);
						$totalPlanEstudios += $planEstudios['total'];
						$materias = $this->model->selectTotalesMaterias($key);
						$totalMaterias += $materias['total'];
						$rvoes = $this->model->selectTotalesRVOES($key);
						$totalRVOES += $rvoes['total'];
					}
				}
				$arrData['planteles'] = $totalPlanteles;
                $arrData['plan_estudios'] = $totalPlanEstudios;
                $arrData['materias'] = $totalMaterias;
                $arrData['rvoes'] = $totalRVOES;
                $arrData['tipo'] = "all";
			}else if($nomConexion != 'all' && $idPlatel =='all'){
				$totalPlanteles = $this->model->selectTotalPlanteles($nomConexion);
				$totalPlanEstudios = $this->model->selectTotalesPlanEstudios($nomConexion);
				$totalMaterias = $this->model->selectTotalesMaterias($nomConexion);
				$totalRVOES = $this->model->selectTotalesRVOES($nomConexion);
				$arrData['planteles'] = $totalPlanteles['total'];
                $arrData['plan_estudios'] = $totalPlanEstudios['total'];
                $arrData['materias'] = $totalMaterias['total'];
                $arrData['rvoes'] = $totalRVOES['total'];
                $arrData['tipo'] = "all"; 
			}else if($nomConexion != 'all' && $idPlatel != 'all'){
				$totalPlanEstudios = $this->model->selectPlanEstudiosbyPlantel($nomConexion,$idPlatel);
				$totalMaterias = $this->model->selectMateriasbyPlantel($nomConexion,$idPlatel);
				$totalRVOES = $this->model->selectRVOEproximoExpbyPlantel($nomConexion,$idPlatel);
				$arrData['planteles'] = 1;
                $arrData['plan_estudios'] = $totalPlanEstudios['total'];
                $arrData['materias'] = $totalMaterias['total'];
                $arrData['rvoes'] = $totalRVOES['total'];
                $arrData['tipo'] = "all";
			} 
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            die();
		}
		public function getListaRvoesExpirar($params){
			$arrParams = explode(',',$params);
			$nomConexion = $arrParams[0];
			$idPlantel = $arrParams[1];
			$arrRes = [];
			if($nomConexion == 'all' && $idPlantel == 'all'){
				foreach (conexiones as $key => $conexion) {
					if($key != 'bd_user'){
						$arrData = $this->model->selectRvoesExpirar($key,'all');
						array_push($arrRes,$arrData);
					}
				}
				$newArray = array_merge([], ...$arrRes);
			}else if($nomConexion != 'all' && $idPlantel == 'all'){
				$newArray = $this->model->selectRvoesExpirar($nomConexion,'all');
			}else if($nomConexion != 'all' && $idPlantel != 'all'){
				$newArray = $this->model->selectRvoesExpirar($nomConexion,$idPlantel);
			}
			echo json_encode($newArray,JSON_UNESCAPED_UNICODE);
            die();
		}

		public function getPlanEstudiosMateriabyPlantel($params){
			$arrParams = explode(',',$params);
			$nomConexion = $arrParams[0];
			$idPlantel = $arrParams[1];
			if($nomConexion == "all" &&  $nomConexion == 'all'){
				$array = [];
				foreach (conexiones as $key => $conexion) {
                    if($key != 'bd_user'){
                        $arrPlanEstudios = $this->model->selectTotalesPlanEstudios($key);
                       	$arrMaterias = $this->model->selectTotalesMaterias($key);
                       	$rvoes = $this->model->selectTotalesRVOES($key);
                        /* $array[$key] = array('conexion'=>$key,'abreviacion_plantel'=>$value['abreviacion_plantel'],'municipio'=>$value['municipio'],'carreras' => $arrPlanEstudios['total'],'materias'=>$arrMaterias['total'],'rvoes'=>$rvoes);  */
                    }
				}
			}else{
				/*$array;
				$arrPlanEstudios = $this->model->selectPlanEstudiosbyPlantel($plantel);
				$arrMaterias = $this->model->selectMateriasbyPlantel($plantel);
				$rvoes = $this->model->selectRVOEproximoExpbyPlantel($plantel);
				$array[$plantel] = array('id_plantel'=>$plantel,'abreviacion_plantel'=>null,'carreras' => $arrPlanEstudios['total'],'materias'=>$arrMaterias['total'],'rvoes'=>$rvoes);*/
			}  
			echo json_encode($rvoes,JSON_UNESCAPED_UNICODE);
            die();
		}
		
		public function getPlanteles(string $nomConexion){
			$arrData = $this->model->selectDatosPlantel($nomConexion);
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            die();
		}
	}
?>