<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h3 class="mt-4">Imprimir ticket</h3>
            <div class="d-grid d-md-flex justify-content-md-end">
                <a href="<?php echo base_url(); ?>/admin/ticket" class="btn btn-primary me-3"> Regresar </a>
            </div>
            <div class="mb-4"></div>
            <div class="container-fluid">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="panel">
                        <div class="embed-responsive embed-responsive-4by3" style="margin-top: 30px;">
                            <iframe class="embed-responsive-item border-ticket" style="width:100%; height:400px" src="<?php echo base_url() . '/admin/ticket/generarticket/' . $datos ?>"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>