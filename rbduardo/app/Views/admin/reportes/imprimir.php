<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h3 class="mt-4">Imprimir reporte</h3>
            <div class="d-grid d-md-flex justify-content-md-end">
                <a href="<?php echo base_url(); ?>/admin/reporte" class="btn btn-outline-primary me-3"> Regresar </a>
            </div>
            <div class="mb-4"></div>
            <div class="container-fluid">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="panel">
                        <div class="embed-responsive embed-responsive-4by3" style="margin-top: 30px;">
                            <iframe class="embed-responsive-item border-ticket" style="width:100%; height:600px" src="<?php echo base_url() . '/admin/reporte/generarReporte/' . $dateStart . '/' . $dateEnd; ?>"></iframe>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>