<?php
    headerAdmin($data);
    getModal("Inscripcion/modalNuevaInscripcion",$data);
    getModal("Inscripcion/modalDocumentacion",$data);
    getModal("Inscripcion/modalEditInscripcion",$data);
    getModal("Inscripcion/modalListaInscritos",$data);
;
?>
<div id="contentAjax"></div>
<div class="wrapper">
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-7">
                        <h1 class="m-0"><?= $data['page_title'] ?></h1>
                    </div>
                    <div class="col-lg-6 col-md-6">
                    <?php if($data['claveRol'] == 'admin' || $data['claveRol'] == 'superadmin'){ ?>
                        <label>Selecciona una base de datos para poder inscribir</label>
                        <select class="custom-select" id="listPlantelDatatable" onchange="fnPlantelSeleccionadoDatatable(value)">
                            <option value="all" selected="">Todos</option>
                            <?php foreach ($data['superplanteles'] as $key => $plantel) { ?>
                                <option value="<?php echo($plantel['nombre_conexion']) ?>"><?php echo($plantel['nombre_plantel']) ?></option>
                            <?php }?>
                        </select>
                        <?php } else { ?>
                        <select class="custom-select" id="listPlantelDatatable" onchange="fnPlantelSeleccionadoDatatable(value)" style="display: none;">
                            <?php foreach ($data['superplanteles'] as $key => $plantel) { if($plantel['nombre_conexion'] == $data['nomConexion']){?>
                            <option value="<?php echo($plantel['nombre_conexion']) ?>" selected><?php echo($plantel['nombre_plantel']) ?></option>
                            <?php } }?>
                        </select>
                        <?php }?>
                    </div>
                    <div class="col-sm-5 d-flex align-items-end">
                        <ol class="breadcrumb float-sm-right btn-block">
                            <button type="button" id="btnNuevaInscripcion" class="btn btn-inline btn-primary btn-sm btn-block" data-toggle="modal" data-target="#ModalFormNuevaInscripcion"><i class="fa fa-plus-circle fa-md"></i>Nuevo</button>
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
                                <h2 class="card-title" id="nombrePlantelDatatable"></h2>
                                <p class="card-text">
                                    <table id="tableInscripciones" class="table table-bordared table-hover table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nombre de la Carrera</th>
                                                <th>Nivel Educativo</th>
                                                <th>Grado</th> 
                                                <th>Plan</th>
                                                <th>Turno</th>
                                                <th>Grupo</th>
                                                <th>Total inscritos</th>
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
<?php
    footerAdmin($data);
?>