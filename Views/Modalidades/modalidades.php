<?php
    headerAdmin($data);
    getModal("Modalidad/modalNuevaModalidad",$data);
    getModal("Modalidad/modalEditModalidad",$data);
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
                            <label>Selecciona una base de datos para agregar una nueva modalidad</label>
                            <select class="custom-select" id="listConexion_db_planteles" onchange="fnConexionDbSeleccionada(value)">
                                <option value="all" selected="">Todos</option>
                                <?php foreach ($data['planteles'] as $key => $plantel) { ?>
                                    <option value="<?php echo($plantel['nombre_conexion']) ?>"><?php echo($plantel['nombre_plantel']) ?></option>
                                <?php }?>
                            </select>
                    </div>
                    <div class="col-sm-5 d-flex align-items-end">
                        <ol class="breadcrumb float-sm-right btn-block">
                            <button type="button" id="btnNuevo_plantel" class="btn btn-inline btn-primary btn-sm btn-block" data-toggle="modal" data-target="#ModalFormNuevaModalidad"><i class="fa fa-plus-circle fa-md"></i>Nuevo</button>
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
<!--                                 <h3 class="card-title">Listado de Modalidades</h3>
 -->                                <p class="card-text">
                                    <table id="tableModalidad" class="table table-bordered table-striped table-hover table-sm">
                                        <thead>
                                            <tr>
                                                <th width="10%">#</th>
                                                <th>Nombre</th>
                                                <th>Plantel</th>
                                                <th width="20%">Estatus</th>
                                                <th width="20%">Acciones</th>
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