<?php
  headerAdmin($data);
  getModal('SalonesCompuestos/modalNuevoSalonesCompuestos',$data); 
  getModal('SalonesCompuestos/modalEditSalonesCompuestos',$data); 
?>

<div id="contentAjax"></div>
<div class="wrapper">


  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-7">
            <h1 class="m-0">  <?= $data['page_title'] ?>
              
            </h1>
          </div>
          <div class="col-sm-5">
            <ol class="breadcrumb float-sm-right btn-block">
            <button type="button" name="botonModal" id="botonModal" onclick="openModal();" class="btn btn-inline btn-primary btn-sm btn-block"><i class="fa fa-plus-circle fa-md"></i> Nuevo</button>
            <!--<button type="button" onclick="openModal();" class="btn btn-inline btn-primary btn-sm btn-block" data-toggle="modal" data-target="#ModalFormRol"><i class="fa fa-plus-circle fa-md"></i> Nuevo</button>-->
              <!--<li class="breadcrumb-item"><i class="fa fa-home fa-md"></i><a href="#">Home</a></li>
              <li class="breadcrumb-item active"><a href="<?= base_url(); ?>/roles"><?= $data['page_title'] ?></a></li>-->
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
                <!-- <div class="form-group">
                  <label for="listIdPlanteles">Planteles</label>
                  <select class="form-control" id="listIdPlanteles" name="listIdPlanteles" onchange="" required >
                        
                  </select>
                </div> -->

                <label for="listIdPlanteles">Planteles</label>
                <div class="input-group mb-3">
                  <select class="form-control custom-select" id="selectPlantel" name="selectPlantel" required onchange="fnSelectPlantel(value)" ;>
                      <option value="" selected>--Selecciona un plantel--</option>
                      <?php foreach ($data['planteles'] as $key => $value) { ?>
                          <option value="<?php echo($value['nombre_conexion'])?>"><?php echo($value['nombre_plantel']) ?></option>
                      <?php } ?>
                  </select>
                </div>


                <h3 class="card-title">Listado de salones compuestos</h3>
                <p class="card-text">
                <table id="tableSalonesCompuestos" class="table table-bordered table-striped table-hover table-sm">
                  <thead>
                  <tr>
                    <th width="7%">ID</th>
                    <th>Nombre S. C.</th>
                    <th width="10%">Periodos</th>
                    <th width="10%">Grados</th>
                    <th width="10%">Grupos</th>
                    <th width="17%">Planteles</th>
                    <th width="12%">Horarios</th>
                    <th width="10%">Salones</th>
                    <th width="8%">Estatus</th>
                    <th width="17%">Acciones</th>
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