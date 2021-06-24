<?= $this->extend('cliente/layout/main'); ?>

<?= $this->section('title') ?>
Inicio
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container">
	<main>
		<header class="p-5 text-center bg-light">
			<h2 class="col-12 text-center tm-section-title">Bienvenido</h2>
			<h5 class="col-12 text-center">Tu mesa es la número <?php echo $mesa; ?></h5>
			<h5 class="col-12 text-center"><?php echo $mesero?> te atenderá. Disfruta tu estadía.</h5>	
		</header>
		<div class="tm-paging-links">
			<a href="<?php echo base_url('cliente/menu'); ?>" id="btn-home" class="tm-btn tm-btn-primary">Ver menú</a>
		</div>
		<div class="tm-section tm-container-inner">
			<div class="row">
				<div class="col-md-6">
					<figure class="tm-description-figure">
						<img src="<?php echo base_url('img/tacarnitas.jpg'); ?>" alt="Image" class="img-fluid" />
					</figure>
				</div>
				<div class="col-md-6">
					<!-- Agregar controlador para poder modificar el apartado del platillo del día -->
					<div class="tm-description-box">
						<h3 class="tm-title">Platillo del día</h3>
						<h4 class="tm-gallery-title">Tacos de carnitas</h4>
						<p class="tm-mb-45">Te invitamos a probar nuestros deliciosos tacos de carnitas al mero estilo de Michoacán. ¡En promoción por tiempo limitado!</p>
					</div>
				</div>
			</div>
		</div>
	</main>
</div>
<?= $this->endSection() ?>