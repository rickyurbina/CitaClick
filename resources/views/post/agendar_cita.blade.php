<div class="page-header">
    <div class="card-options" style="margin-right: 100px;">

        <a class="btn btn-cyan text-gray-dark btn-lg mb-1" href="index.php?page=inicio"><i class="zmdi zmdi-home" style="color:white" title="Volver a Inicio" data-toggle="tooltip"></i></a>&nbsp

        <a class="btn btn-cyan btn-lg mb-1" href="index.php?page=vPacienteAdd"><i class="fa fa-user-plus" data-toggle="tooltip" title="Agregar Nuevo Paciente" data-original-title="fa fa-user-plus"></i></a>&nbsp

        <a class="btn btn-cyan text-gray-dark btn-lg mb-1" href="index.php?page=vNuevaCita"><i class="fa fa-calendar-plus-o" style="color:white" title="Agendar Nueva Cita" data-toggle="tooltip"></i></a>

    </div>
</div>
<div class="row ">
    <div class="col-lg-8">
        <form class="card" method="POST" enctype="multipart/form-data">
            <div class="card-header">
                <h3 class="card-title">Nueva cita</h3>
                <div class="card-options">
                    <!-- <h3 id="labelCosto">$ </h3> -->
                    <input type="text" class="form-control" name="responsable" value="" hidden >
                </div>

            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <h4><br>Datos Personales <br> &nbsp;</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <h4><br> &nbsp;</h4>
                    </div>
                    <div class="col-sm-12 col-md-5">
                        <div class="form-group">
                            <label class="form-label">Nombres (sin caracteres especiales " , . - / ")</label>
                            <input type="text" class="form-control" name="nombres" placeholder="Juan" required>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label class="form-label">Apellidos (sin caracteres especiales ", . - / ")</label>
                            <input type="text" class="form-control" name="apellidos" placeholder="Perez García" required>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label class="form-label">Telefono</label>
                            <input type="text" class="form-control" name="telefono" placeholder="" required>
                        </div>
                    </div>
                </div>
        </form>
    </div>

</div>