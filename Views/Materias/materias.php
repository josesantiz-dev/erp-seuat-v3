<?php
    headerAdmin($data);
    getModal("Materia/modalNuevaMateria",$data);
    getModal("Materia/modalVerMateria",$data);
    getModal("Materia/modalEditMateria",$data);
?>
<div id="contentAjax"></div>
<div class="wrapper">
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-7">
                        <h1 class="m-0"> <?= $data['page_title'] ?></h1>
                    </div>
                    <div class="col-lg-6 col-md-6">
                            <label>Selecciona una base de datos para agregar una nueva materia</label>
                            <select class="custom-select" id="listConexion_db_planteles" onchange="fnConexionDbSeleccionada(value)">
                                <option value="all" selected="">Todos</option>
                                <?php foreach ($data['superplanteles'] as $key => $plantel) { ?>
                                    <option value="<?php echo($plantel['nombre_conexion']) ?>"><?php echo($plantel['nombre_plantel']) ?></option>
                                <?php }?>
                            </select>
                    </div>
                    <div class="col-sm-5 d-flex align-items-end">
                        <ol class="breadcrumb float-sm-right btn-block">
                            <button type="button" id="btnNuevo_materias" onclick="fnNuevaMateria()" class="btn btn-inline btn-primary btn-sm btn-block" data-toggle="modal" data-target="#ModalFormNuevaMateria"><i class="fa fa-plus-circle fa-md"></i>Nuevo</button>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
<!--                                 <h3 class="card-title">Listado de Materias</h3>
 -->                                <p class="card-text">
                                    <table id="tableMaterias" class="table table-bordared table-striped table-hover 
                                    table-sm">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nombre</th>
                                                <th>Plan de Estudios</th>
                                                <th>Grado</th>
                                                <th>Tipo</th>
                                                <th>Clasificaci??n</th>
                                                <th>Estatus</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                </p>    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php footerAdmin($data); ?>