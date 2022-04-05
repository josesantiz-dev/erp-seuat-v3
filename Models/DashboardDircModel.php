<?php
    class DashboardDircModel extends Mysql{
        public function __construct(){
            parent::__construct();
        }
        public function selectTotalPlanteles(string $nomConexion){
            $sqlPlanteles = "SELECT COUNT(*) AS total FROM t_db";
            $requestPlanteles = $this->select($sqlPlanteles,$nomConexion);
            return $requestPlanteles;
        }
        public function selectTotalesPlanEstudios(string $nomConexion){
            $sqlPlanEstudios = "SELECT COUNT(*) AS total FROM t_plan_estudios WHERE estatus = 1";
            $requestPlanEstudios = $this->select($sqlPlanEstudios,$nomConexion);
            return $requestPlanEstudios;
        }
        public function selectTotalesMaterias(string $nomConexion){
            $sqlMaterias = "SELECT COUNT(*) AS total FROM t_materias WHERE estatus = 1";
            $requestMaterias = $this->select($sqlMaterias, $nomConexion);
            return $requestMaterias;
        }
        public function selectTotalesRVOES($nomConexion){
            $sqlRVOES = "SELECT COUNT(*) AS total FROM t_plan_estudios WHERE DATEDIFF(fecha_actualizacion_rvoe,CURRENT_DATE) <= 365 AND estatus = 1";
            $requestRVOES = $this->select($sqlRVOES, $nomConexion);
            return $requestRVOES;
        }
/*         public function selectTotalesCard($nomConexion){
            if($nomConexion == "all"){
               $sqlPlanteles = "SELECT COUNT(*) AS total FROM t_db";
                $requestPlanteles = $this->select($sqlPlanteles,'bd_usr');
                $sqlPlanEstudios = "SELECT COUNT(*) AS total FROM t_plan_estudios WHERE estatus = 1";
                $requestPlanEstudios = $this->select($sqlPlanEstudios,$nom);
                $sqlMaterias = "SELECT COUNT(*) AS total FROM t_materias WHERE estatus = 1";
                $requestMaterias = $this->select($sqlMaterias);
                $sqlRVOES = "SELECT COUNT(*) AS total FROM t_plan_estudios WHERE DATEDIFF(fecha_actualizacion_rvoe,CURRENT_DATE) <= 365 AND estatus = 1";
                $requestRVOES = $this->select($sqlRVOES);
                $request['planteles'] = $requestPlanteles['total'];
                $request['plan_estudios'] = $requestPlanEstudios['total'];
                $request['materias'] = $requestMaterias['total'];
                $request['rvoes'] = $requestRVOES['total'];
                $request['tipo'] = "all";
            }else{
                $sqlPlanEstudios = "SELECT COUNT(*) AS total FROM t_plan_estudios WHERE estatus = 1 AND id_plantel = $plantel";
                $requestPlanEstudios = $this->select($sqlPlanEstudios);
                $sqlMaterias = "SELECT COUNT(*) AS total FROM t_materias AS mat 
                INNER JOIN t_plan_estudios AS pln ON mat.id_plan_estudios = pln.id WHERE mat.estatus = 1 AND pln.id_plantel = $plantel";
                $requestMaterias = $this->select($sqlMaterias);
                $sqlRVOES = "SELECT COUNT(*) AS total FROM t_plan_estudios WHERE DATEDIFF(fecha_actualizacion_rvoe,CURRENT_DATE) <= 365 AND id_plantel = $plantel AND estatus = 1";
                $requestRVOES = $this->select($sqlRVOES);
                $request['plan_estudios'] = $requestPlanEstudios['total'];
                $request['materias'] = $requestMaterias['total'];
                $request['rvoes'] = $requestRVOES['total'];
                $request['tipo'] = "";
            }
            return $requestPlanteles;
        }
 */


        public function selectRvoesExpirar($plantel){
            if($plantel == "all"){
                $sqlRVOES = "SELECT pl.id,pl.nombre_carrera,pl.nombre_carrera_corto,plnt.abreviacion_sistema,plnt.abreviacion_plantel,plnt.municipio,pl.rvoe,pl.fecha_actualizacion_rvoe FROM t_plan_estudios AS pl 
                INNER JOIN t_planteles AS plnt ON pl.id_plantel = plnt.id WHERE DATEDIFF(pl.fecha_actualizacion_rvoe,CURRENT_DATE) <= 365 AND pl.estatus = 1";
                $requestRVOES = $this->select_all($sqlRVOES,'hshsuhusuhsu');
            }else{
                $sqlRVOES = "SELECT pl.id,pl.nombre_carrera,pl.nombre_carrera_corto,plnt.abreviacion_sistema,plnt.abreviacion_plantel,plnt.municipio,pl.rvoe,pl.fecha_actualizacion_rvoe FROM t_plan_estudios AS pl INNER JOIN t_planteles AS plnt ON pl.id_plantel = plnt.id WHERE DATEDIFF(fecha_actualizacion_rvoe,CURRENT_DATE) <= 365 AND pl.id_plantel = $plantel AND pl.estatus = 1";
                $requestRVOES = $this->select_all($sqlRVOES);
            }
            return $requestRVOES;
        }
        public function selectPlanteles(string $nomConexion){
            $sql = "SELECT id,nombre_conexion,nombre_plantel FROM t_db";
            $request = $this->select_all($sql, $nomConexion);
            return $request;
        }
        public function selectPlanEstudiosbyPlantel(string $nombreConexion){
            $sql = "SELECT COUNT(*) AS total FROM t_plan_estudios";
            $request = $this->select($sql,$nombreConexion);
            return $request;
        }
        public function selectMateriasbyPlantel(string $nombreConexion){
            $sql = "SELECT COUNT(*) AS total FROM t_materias AS mat
            INNER JOIN t_plan_estudios AS ples ON mat.id_plan_estudios = ples.id
            INNER JOIN t_planteles AS pl ON ples.id_plantel = pl.id";
            $request = $this->select($sql,$nombreConexion);
            return $request;
        }
        public function selectRVOEproximoExpbyPlantel(string $nombreConexion){
            $sql = "SELECT COUNT(*) AS total FROM t_plan_estudios";
            $request = $this->select($sql,$nombreConexion);
            return $request;
        }
        public function selectDatosPlantel(string $nombreConexion){
            $sql = "SELECT *FROM t_planteles";
            return $nombreConexion;
        }
    }
?>    