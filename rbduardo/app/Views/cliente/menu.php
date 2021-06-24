<?= $this->extend('cliente/layout/main'); ?>

<?= $this->section('title') ?>
Menú
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container">
	<main>
		<header class="p-5 text-center bg-light mb-3">
			<h2 class="col-12 text-center tm-section-title">Menú</h2>
			<p class="col-12 text-center">Disfruta de la variedad de nuestros deliciosos platillos.</p>
		</header>
		<div class="tm-container-inner">
			<div class="row">
				<div class="col-sm-6 btn-menu">
					<div class="dropdown">
						<button class="dropbtn"><?php echo $entrada; ?></button>
						<div class="dropdown-content">
							<form action="" method="post">
								<button class="dropbtn" name="btnCat" type="submit" id="id" value=0>Todos los platillos</button>
								<?php foreach ($tipos as $tipo) : ?>
									<button class="dropbtn" name="btnCat" type="submit" value="<?php echo $tipo['idCategoria']; ?>">
										<?php echo $tipo['nombre']; ?></button>
								<?php endforeach ?>
							</form>
						</div>
					</div>
				</div>
				<!-- SEARCH -->
				<div class="col-sm-6 btn-menu">
					<form action="" method="post" autocomplete="off">
						<input type="text" name="buscar" id="buscar" placeholder="Buscar" required>
					</form>
				</div>
				<ul class="col-md-3 search-list">
					<li class="list-group" id="show-list">
						<!-- Lista de platillos autocompletados -->
					</li>
				</ul>
			</div>
		</div>

		<br>
		<!-- Gallery -->
		<ul class="row row-cols-1 row-cols-sm-3 row-cols-md-4 tm-gallery" id="listaPlatillos">
			<!-- Mostrar las entradas de cada etiqueta -->
			<?php $encrypter = \Config\Services::encrypter(); ?>
			<?php foreach ($platillos as $platillo) : ?>
				<li class="card col" id="platillo-menu" style="padding-bottom: 10px; padding-top: 10px;">
					<img class="card-img-top" title="<?php echo $platillo['nombre']; ?>" alt="Título" src="<?php echo base_url() . '/img/' . $platillo['imagen']; ?>" onerror="this.onerror=null; this.src='<?php echo base_url('img/default-food.png'); ?>'" width="256px" height="256px" data-bs-toggle="popover" data-bs-placement="right" data-bs-trigger="hover focus" data-bs-content="<?php echo $platillo['descripcion']; ?>">
					<div class="card-body">
						<h4 class="tm-gallery-title"><?php echo $platillo['nombre']; ?></h4>
						<p class="tm-gallery-price">$<?php echo number_format($platillo['precio'], 2); ?></p>
					</div>
					<form action="" method="post">
						<!-- Por seguridad, se encriptan los valores de las peticiones enviadas a post-->
						<input type="hidden" name="id" value="<?php echo base64_encode($encrypter->encrypt($platillo['idPlatillo'])); ?>">
						<input type="hidden" name="imagen" value="<?php echo base64_encode($encrypter->encrypt($platillo['imagen'])); ?>">
						<input type="hidden" name="nombre" value="<?php echo base64_encode($encrypter->encrypt($platillo['nombre'])); ?>">
						<input type="hidden" name="precio" value="<?php echo base64_encode($encrypter->encrypt($platillo['precio'])); ?>">
						<button class="tm-btn-primary" name="btnAction" type="submit" value="Agregar">Ordenar</button>
					</form>
				</li>
			<?php endforeach ?>
		</ul>
	</main>
</div>
<?= $this->endSection() ?>
<?= $this->section('js') ?>
<script>
	var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
	var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
		return new bootstrap.Popover(popoverTriggerEl)
	})
</script>

<script>
	$(document).ready(function() {
		// Send Search Text to the server
		$("#buscar").keyup(function() {
			let searchText = $(this).val();
			if (searchText != "") {
				$.ajax({
					url: "<?php echo base_url(); ?>/cliente/menu/autocompleteData",
					method: "post",
					data: {
						query: searchText,
					},
					success: function(response) {
						$("#show-list").html(response);
					},
				});
			} else {
				$("#show-list").html("");
			}
		});
		// Set searched text in input field on click of search button
		$(document).on("click", "a", function() {
			$("#buscar").val($(this).text());
			$("#show-list").html("");
		});
	});
</script>

<?= $this->endSection() ?>