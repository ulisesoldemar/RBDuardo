<?= $this->extend('cliente/layout/main'); ?>

<?= $this->section('title') ?>
Acerca de
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container">
	<main>
		<header class="p-5 text-center bg-light">
			<h2 class="col-12 text-center tm-section-title">Acerca de RBDuardo</h2>
			<p class="col-12 text-center">RBDuardo es un software para la gestión y toma de pedidos de comensales. Tu puedes realizar los pedidos que quieras
				escaneando el codigo QR que se encuentra en una mesa en especifico. A continuación, se muestra nuestro equipo de desarrollo.</p>
		</header>
		<div class="tm-container-inner tm-persons">
			<div class="row">
				<article class="col-lg-6">
					<figure class="tm-person">
						<img src="<?php echo base_url('img/about-01.jpg') ?>" alt="Image" class="img-fluid tm-person-img" />
						<figcaption class="tm-person-description">
							<h4 class="tm-person-name">Ulises Ortega</h4>
							<p class="tm-person-title">Ingeniero en computación</p>
						</figcaption>
					</figure>
				</article>
				<article class="col-lg-6">
					<figure class="tm-person">
						<img src="<?php echo base_url('img/about-02.jpg') ?>" alt="Image" class="img-fluid tm-person-img" />
						<figcaption class="tm-person-description">
							<h4 class="tm-person-name">Eduardo Gutiérrez</h4>
							<p class="tm-person-title">Ingeniero en computación</p>
						</figcaption>
					</figure>
				</article>
				<article class="col-lg-6">
					<figure class="tm-person">
						<img src="<?php echo base_url('img/about-03.jpg') ?>" alt="Image" class="img-fluid tm-person-img" />
						<figcaption class="tm-person-description">
							<h4 class="tm-person-name">Luis Pacheco</h4>
							<p class="tm-person-title">Ingeniero en computación</p>
						</figcaption>
					</figure>
				</article>
				<article class="col-lg-6">
					<figure class="tm-person">
						<img src="<?php echo base_url('img/about-04.jpg') ?>" alt="Image" class="img-fluid tm-person-img" />
						<figcaption class="tm-person-description">
							<h4 class="tm-person-name">César González</h4>
							<p class="tm-person-title">Ingeniero en computación</p>
						</figcaption>
					</figure>
				</article>
				<article class="col-lg-6">
					<figure class="tm-person">
						<img src="<?php echo base_url('img/about-05.jpg') ?>" alt="Image" class="img-fluid tm-person-img" />
						<figcaption class="tm-person-description">
							<h4 class="tm-person-name">Oswaldo Mercado</h4>
							<p class="tm-person-title">Ingeniero en computación</p>
						</figcaption>
					</figure>
				</article>
				<article class="col-lg-6">
					<figure class="tm-person">
						<img src="<?php echo base_url('img/about-06.jpg') ?>" alt="Image" class="img-fluid tm-person-img" />
						<figcaption class="tm-person-description">
							<h4 class="tm-person-name">David Mondragon</h4>
							<p class="tm-person-title">Ingeniero en computación</p>
						</figcaption>
					</figure>
				</article>
			</div>
		</div>
		<div class="tm-container-inner tm-features">
			<div class="row">
				<div class="col-12">
					<div class="tm-feature">
						<i class="fas fa-4x fa-cocktail tm-feature-icon"></i>
						<p class="tm-feature-description">Comienza a realizar tus pedidos haciendo clic al siguiente botón</p>
						<a href="<?php echo base_url('cliente/menu')?>" class="tm-btn tm-btn-primary">Menú</a>
					</div>
				</div>
			</div>
		</div>
	</main>
</div>
<?= $this->endSection() ?>