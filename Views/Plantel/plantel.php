<?php
    headerAdmin($data);
    getModal('Plantel/modalNuevoPlantel',$data);
    getModal('Plantel/modalVerPlantel',$data);
    getModal('Plantel/modalEditPlantel',$data);
?>
<div id="contentAjax"></div>
<div class="wrapper">
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1 class="m-0">  <?= $data['page_title'] ?></h1>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <?php if($data['claveRol'] == 'admin' || $data['claveRol'] == 'superadmin'){ ?>
                            <label>Selecciona una base de datos para agregar un nuevo plantel</label>
                            <select class="custom-select" id="listConexion_db_planteles" onchange="fnConexionDbSeleccionada(value)">
                                <option value="all" selected="">Todos</option>
                                <?php foreach ($data['planteles'] as $key => $plantel) { ?>
                                    <option value="<?php echo($plantel['nombre_conexion']) ?>"><?php echo($plantel['nombre_plantel']) ?></option>
                                <?php }?>
                            </select>
                        <?php } else { ?>
                            <select class="custom-select" id="listConexion_db_planteles" onchange="fnConexionDbSeleccionada(value)" style="display: none;">
                                <?php foreach ($data['planteles'] as $key => $plantel) { if($plantel['nombre_conexion'] == $data['nomConexion']){?>
                                    <option value="<?php echo($plantel['nombre_conexion']) ?>" selected><?php echo($plantel['nombre_plantel']) ?></option>
                                <?php } }?>
                            </select>
                        <?php }?>
                    </div>
                    <div class="col-sm-5 d-flex align-items-end">
                            <button type="button" id="btnNuevo_plantel" class="btn btn-inline btn-primary btn-sm btn-block" data-toggle="modal"  onclick="btnNuevoPlantel()" data-target="#ModalFormNuevoPlantel"><i class="fa fa-plus-circle fa-md"></i> Nuevo</button>
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
<!--                                 <h3 class="card-title">Listado de planteles</h3>
 -->                                <p class="card-text">
                                    <table id="tablePlantel" class="table table-bordered table-striped table-hover table-sm">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Plantel</th>
                                                <th>Estado</th>
                                                <th>Municipio</th>
                                                <th>Localidad</th>
                                                <th>Regimen</th>
                                                <th>Servicio</th>
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


