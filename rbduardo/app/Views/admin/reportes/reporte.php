<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h3 class="mt-4">Reporte </h3>
            <div class="mb-4"></div>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-clipboard"></i>
                    Reporte de tickets
                </div>
                <div class="card-body">
                    <div class="alert alert-secondary mb-5" role="alert">
                        Si quieres imprimir el reporte del dia de hoy, simplemente ingresa la misma fecha en los dos campos
                    </div>

                    <form action="<?php echo base_url() . '/admin/reporte/mostrarReporte'; ?>" method="POST">
                        <div class="form-group row mt-3">
                            <label for="example-date-input" class="col-1 col-form-label">Desde:</label>
                            <div class="col-4">
                                <input class="form-control" type="date" value="" id="fecha-inicio" name="fecha-inicio" required>
                            </div>

                            <label for="example-date-input" class="col-1 col-form-label">Hasta:</label>
                            <div class="col-4">
                                <input class="form-control" type="date" value="" id="fecha-fin" name="fecha-fin" required>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="d-grid d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primary mb-3">
                                    Generar reporte
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
