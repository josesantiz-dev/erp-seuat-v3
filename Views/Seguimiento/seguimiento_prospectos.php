<?php
    headerAdmin($data);
?>
<div id="contentAjax"></div>
<div class="wrapper">
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1 class="m-0"> <?= $data['page_title'] ?></h1>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <label>Selecciona la base de datos para agregar un nuevo plantel:</label>
                        <select class="custom-select" id="listConexion_bd_planteles" onchange="fnConexionDbSeleccionada()">
                            <option value="all" selected="">Todos</option>
                            <?php foreach ($data['planteles'] as $key => $plantel) { ?>
                                <option value="<?php echo($plantel['nombre_conexion']) ?>"><?php echo($plantel['nombre_plantel'])?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-5 d-flex align-items-end">
                        <button type="button" id="btnNuevo_plantel" class="btn btn-inline btn-primary btn-sm btn-block"><i class="fa fa-plus-circle" aria-hidden="true"></i> Nuevo</button>
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
                                <p class="card-text">
                                    <table id="tableSeguimientoProspecto" class="table table-bordered table-striped table-hover table-sm">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nombre completo</th>
                                                <th>Alias</th>
                                                <th>Teléfono celular</th>
                                                <th>Plantel de interés</th>
                                                <th>Carrera de interés</th>
                                                <th>Medio de captación</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
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