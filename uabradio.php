<?php
/**
Aquesta pàgina mostra els continguts de UABràdio a partir de diferents blocs amb criteris específics. 

El carrusel superior carrega clips de la categoria ID 56 (PROGRAMES UABRÀDIO – slider inicial), forçada explícitament al codi mitjançant un filtre per categoria.

La graella setmanal de programació no depèn del llistat general de categories, sinó del fitxer graella.json, que defineix manualment els IDs dels programes a mostrar. Si visiteu graella.json, veureu que és un array amb les IDs dels programes, que són els identificadors que tenen a Staff (els podeu aconseguir a través de la seva pàgina, agafant el número de la URL després d'iq: https://staff.uab.media/index.php?go=adminCategories&do=edit&iq=11 té la ID 11).

El bloc “Programes de UABràdio” mostra totes les categories actives (status = 1) que són filles directes de la categoria arrel UABràdio (ID 1), obtingudes dinàmicament via l’API. 

El bloc “Catàleg d’altres temporades de UABràdio” mostra categories inactives a Staff (status = 0) també filles de la ID 1, excloent explícitament alguns IDs mitjançant un array escrit directament al codi (ara per ara: 1, 8, 45, 56, 57, 59), ja sigui perquè són categories generals i no programes, o fins i tot programes que per A o per B es mantenen a Staff, però en algun moment s'han decidit amagar públicament. Vigileu que hi ha diversos motius: Programes que han sigut problemàtics en el passat, que tenen temes de drets d'autor, etc.

Finalment, el programa ARU (ID 85) s’afegeix manualment al frontend i no forma part de cap llistat automàtic de l’API.

Afegit per Marc Celeiro (marc.celeiro@uab.cat) el 18 desembre de 2025
**/


include 'config.php';
//START Mòdul PHP carrousel
$GET_VARS_carrousel = array(
	"go"        => "clips",
	"do"        => "list"
);

$POST_VARS_carrousel = array(
	"sortByFilter"      => "date",
	"categoriesFilter"  => 56,
	"includeData"       => 1,
	"statusFilter"		=> 1,
	"resultsPerPageFilter" => 100,
);

$REQUEST_URL_carrousel = $API_URL . "?" . http_build_query($GET_VARS) . "&" . http_build_query($GET_VARS_carrousel);

$ch_carrousel = curl_init();
curl_setopt($ch_carrousel, CURLOPT_URL, $REQUEST_URL_carrousel);
curl_setopt($ch_carrousel, CURLOPT_POST, true);
curl_setopt($ch_carrousel, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch_carrousel, CURLOPT_HEADER, false);
curl_setopt($ch_carrousel, CURLOPT_POSTFIELDS, $POST_VARS_carrousel);
$response_carrousel = curl_exec($ch_carrousel);
$data_carrousel = json_decode($response_carrousel);
//END mòdul PHP carrousel

//START mòdul PHP graella.json. Per canviar la graella s'ha d'agafar l'arxiu graella.json i s'agafi els id dels programes/categories
$programacion_semanal = json_decode(file_get_contents('graella.json'), true);
$detalles_programas = null;

// Igual que a directe_radio.php: resoldre cada programa de la graella suposava
// ~35 crides síncrones a l'API per visita. Les cachem en disc 1 hora i les
// invalidem quan graella.json canvia.
$cacheDir  = 'cache';
$cacheFile = $cacheDir . '/uabradio_graella.json';
$cacheTtl  = 3600;

if (
	is_file($cacheFile)
	&& (time() - filemtime($cacheFile) < $cacheTtl)
	&& filemtime($cacheFile) >= filemtime('graella.json')
) {
	$cached = json_decode(file_get_contents($cacheFile), true);
	if (is_array($cached)) {
		$detalles_programas = $cached;
	}
}

if ($detalles_programas === null) {
	$detalles_programas = [];

	foreach ($programacion_semanal as $dia => $programas) {
		foreach ($programas as $programa) {
			$GET_VARS_PROG = array(
				"go" => "categories",
				"do" => "get",
				"iq" => $programa['id']
			);
			$REQUEST_URL_PROG = $API_URL . "?" . http_build_query($GET_VARS) . "&" . http_build_query($GET_VARS_PROG);
			$ch_PROG = curl_init();
			curl_setopt($ch_PROG, CURLOPT_URL, $REQUEST_URL_PROG);
			curl_setopt($ch_PROG, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch_PROG, CURLOPT_HEADER, false);

			$response_PROG = curl_exec($ch_PROG);
			$datos_programa = json_decode($response_PROG, true);

			if (isset($datos_programa['data'])) {
				$detalles_programas[$dia][] = [
					'id' => $programa['id'],
					'hora_inici' => $programa['hora_inici'],
					'titulo' => $datos_programa['data']['title'],
					'img_poster' => $datos_programa['data']['img_poster']
				];
			}
		}
	}

	if (!is_dir($cacheDir)) {
		@mkdir($cacheDir, 0775, true);
	}
	@file_put_contents($cacheFile, json_encode($detalles_programas), LOCK_EX);
}
//END mòdul PHP graella json

//START mòdul PHP categories/programes actius
$GET_VARS_programes_actius = array(
	"go"        => "categories",
	"do"        => "list"
);

$POST_VARS_programes_actius = array(
	"sortByFilter"          => "title",
	"includeData"           => 1,
	"parentFilter"          => 1,
	"statusFilter"          => 1,
	"resultsPerPageFilter"  => 60
);

$REQUEST_URL_programes_actius = $API_URL . "?" . http_build_query($GET_VARS) . "&" . http_build_query($GET_VARS_programes_actius);

$ch_programes_actius = curl_init();
curl_setopt($ch_programes_actius, CURLOPT_URL, $REQUEST_URL_programes_actius);
curl_setopt($ch_programes_actius, CURLOPT_POST, true);
curl_setopt($ch_programes_actius, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch_programes_actius, CURLOPT_HEADER, false);
curl_setopt($ch_programes_actius, CURLOPT_POSTFIELDS, $POST_VARS_programes_actius);

$response_programes_actius = curl_exec($ch_programes_actius);
$data_programes_actius = json_decode($response_programes_actius); 
//END mòdul PHP categories/programes actius

//START mòdul PHP categories/programes no actius, cataleg/arxiu. Status filter = 0
$GET_VARS_ARXIU = array(
	"go"        => "categories",
	"do"        => "list"
);

$POST_VARS_ARXIU = array(
	"sortByFilter"          => "name",
	"includeData"           => 1,
	"parentFilter"          => 1,
	"statusFilter"          => 0,
	"resultsPerPageFilter"  => 100
);

$REQUEST_URL_ARXIU = $API_URL . "?" . http_build_query($GET_VARS) . "&" . http_build_query($GET_VARS_ARXIU);

$ch_ARXIU = curl_init();
curl_setopt($ch_ARXIU, CURLOPT_URL, $REQUEST_URL_ARXIU);
curl_setopt($ch_ARXIU, CURLOPT_POST, true);
curl_setopt($ch_ARXIU, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch_ARXIU, CURLOPT_HEADER, false);
curl_setopt($ch_ARXIU, CURLOPT_POSTFIELDS, $POST_VARS_ARXIU);

$response_ARXIU = curl_exec($ch_ARXIU);

$data_ARXIU = json_decode($response_ARXIU);

?>

<!doctype html>
<html lang="ca">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>UABràdio, la ràdio de l'Autònoma - UABmèdia</title>
		<meta name="description" content="Descobreix, Comparteix, Connecta">
		<meta name="twitter:card" content="summary">
		<meta name="twitter:site" content="@uabmedia">
		<meta name="twitter:title" content="Descobreix, Comparteix, Connecta">
		<meta name="twitter:description" content="Descobreix, Comparteix, Connecta">
		<meta name="twitter:image:src" content="https://uab.media/assets/images/uabradio_twitter.jpeg">
		<meta name="twitter:url" content="https://uab.media/uabradio">
		<meta property="og:site_name" content="UABmèdia" />
		<meta property="og:url" content="https://uab.media/uabradio" />
		<meta property="og:title" content="Descobreix, Comparteix, Connecta" />
		<meta property="og:description" content="Descobreix, Comparteix, Connecta" />
		<meta property="og:image" content="https://uab.media/assets/images/uabradio_twitter.jpeg" />
		<link rel="canonical" href="https://uab.media/uabradio">
		<?php
		include './head-import.php';
		?>
	</head>
	<style>
		/* Media query for medium-sized screens */
		@media (max-width: 992px) {
			.carousel-caption {
				/* Adjust the styling for medium-sized screens */
				/* For example, you can reduce font size or truncate text */
				font-size: 14px; /* Adjust as needed */
				overflow: hidden;
				white-space: nowrap;
				text-overflow: ellipsis; /* Truncate text with ellipsis */
			}
		}
	</style>

	<body>
		<!-- Google Tag Manager (noscript) -->
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MZGPM9HV"
						  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<!-- End Google Tag Manager (noscript) -->
		<?php
		include './plantilla/header.php';
		?>
		<div class="container">
			<section>
				<h1 class="titol-pagina"><img style="margin-right:20px;height:30px;padding-bottom:5px" src="https://uab.media/assets/images/uabradio-color.svg" alt="UABplay">UABràdio</h1>
				<span>La ràdio de la Facultat de Ciències de la Comunicació de la UAB</span>
				<div class="row gx-5" style="margin-top: 40px;margin-bottom: 40px">
					<div class="col-sm-6 col-12 order-2 order-md-1">
						<!--llista de la setmana-->
						<ul class="nav nav-tabs flex-wrap flex-lg-nowrap" id="myTab" role="tablist">
							<?php foreach ($detalles_programas as $dia => $programas): ?>
							<li class="nav-item">
								<a 
								   class="nav-link" 
								   id="<?php echo $dia; ?>-tab" 
								   data-toggle="tab" 
								   href="#<?php echo $dia; ?>" 
								   role="tab" 
								   aria-controls="<?php echo $dia; ?>"
								   ><?php echo $dia; ?>
								</a>
							</li>
							<?php endforeach; ?>
						</ul>
						<!--fi llista de la setmana-->

						<style>
							.nav-tabs .nav-item a {
								border: none!important;
								border-bottom: 0!important;
								padding: 0!important;
								margin: 0 10px 10px 0;
								border-radius: 0!important;
							}
							.nav-tabs .nav-item:hover, .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
								background-color: transparent!important;
							}
						</style>

						<!--graella-->
						<div class="tab-content" id="myTabContent">
							<?php foreach ($detalles_programas as $dia => $programas): ?>
							<div 
								 class="tab-pane fade" 
								 id="<?php echo $dia; ?>" 
								 role="tabpanel" 
								 aria-labelledby="<?php echo $dia; ?>-tab">
								<?php foreach ($programas as $programa): ?>

								<div class="row">
									<div class="col-md-2 col-12">
										<img src="<?php echo $programa['img_poster']; ?>" class="graella-imatge">
									</div>
									<div class="col-md-6 col-12">
										<?php echo $programa['hora_inici']; ?>
										<a 
										   href="/programa/<?php echo $programa['id']; ?>/<?php echo str_replace(' ', '-', $programa['titulo']); ?>">
											<span class="h5" style="display:block;font-weight:700;color:#fff;"><?php echo $programa['titulo']; ?></span>
										</a>						
									</div>
								</div>
								<?php endforeach; ?>
							</div>
							<?php endforeach; ?>
						</div>
						<!--fi graella-->
					</div>
					<div class="col-sm-6 col-12 order-1 order-md-2"> 
						<div id="carouseluabmedia" class="carousel slide carousel-fade" data-ride="carousel">
							<div class="carousel-inner m-auto">

								<!--item 1 carrousel-->
								<div class="carousel-item active">
									<a href="/clip/<?php echo $data_carrousel->list['0']->id; ?>/<?php echo $data_carrousel->list['0']->title_url; ?>">
										<img 
											 class="d-block w-100" 
											 src="<?php echo $data_carrousel->list['0']->img_social; ?>" 
											 alt="<?php echo $data_carrousel->list['0']->title; ?>">
									</a>
									<div class="carousel-caption d-md-block">
										<h2 class="h5">
											<a href="/clip/<?php echo $data_carrousel->list['0']->id; ?>/<?php echo $data_carrousel->list['0']->title_url; ?>"><?php echo $data_carrousel->list['0']->title;?>
												<p> 
													<?php echo substr($data_carrousel->list['0']->date_formatted, 0, -9); ?>
												</p>
											</a>
										</h2>
									</div>
								</div>

								<!--item 2 carrousel-->
								<div class="carousel-item">
									<a href="/clip/<?php echo $data_carrousel->list['1']->id; ?>/<?php echo $data_carrousel->list['1']->title_url; ?>">
										<img 
											 class="d-block w-100" 
											 src="<?php echo $data_carrousel->list['1']->img_social; ?>" 
											 alt="<?php echo $data_carrousel->list['1']->title; ?>">
									</a>
									<div class="carousel-caption d-md-block">
										<h2 class="h5">
											<a href="/clip/<?php echo $data_carrousel->list['1']->id; ?>/<?php echo $data_carrousel->list['1']->title_url; ?>"><?php echo $data_carrousel->list['1']->title; ?>
												<p>
													<?php echo substr($data_carrousel->list['1']->date_formatted, 0, -9); ?>
												</p>
											</a>
										</h2>
									</div>
								</div>

								<!--item3 carrousel-->
								<div class="carousel-item">
									<a href="/clip/<?php echo $data_carrousel->list['2']->id; ?>/<?php echo $data_carrousel->list['2']->title_url; ?>">
										<img 
											 class="d-block w-100" 
											 src="<?php echo $data_carrousel->list['2']->img_social; ?>" 
											 alt="<?php echo $data_carrousel->list['2']->title; ?>">
									</a>
									<div class="carousel-caption d-md-block">
										<h2 class="h5">
											<a href="/clip/<?php echo $data_carrousel->list['2']->id; ?>/<?php echo $data_carrousel->list['2']->title_url; ?>"><?php echo $data_carrousel->list['2']->title; ?>
												<p>
													<?php echo substr($data_carrousel->list['2']->date_formatted, 0, -9); ?>
												</p>
											</a>
										</h2>
									</div>
								</div>

								<!--item4 carrousel-->
								<div class="carousel-item">
									<a href="/clip/<?php echo $data_carrousel->list['3']->id; ?>/<?php echo $data_carrousel->list['3']->title_url; ?>">
										<img 
											 class="d-block w-100" 
											 src="<?php echo $data_carrousel->list['3']->img_social; ?>" 
											 alt="<?php echo $data_carrousel->list['3']->title; ?>">
									</a>
									<div class="carousel-caption d-md-block">
										<h2 class="h5">
											<a href="/clip/<?php echo $data_carrousel->list['3']->id; ?>/<?php echo $data_carrousel->list['3']->title_url; ?>"><?php echo $data_carrousel->list['3']->title; ?>
												<p>
													<?php echo substr($data_carrousel->list['3']->date_formatted, 0, -9); ?>
												</p>
											</a>
										</h2>
									</div> 
								</div>
							</div>
							<!--flechas carrousel-->
							<a class="carousel-control-prev" href="#carouseluabmedia" role="button" data-slide="prev">
								<span class="carousel-control-prev-icon" aria-hidden="true"></span>
								<span class="sr-only">Previous</span>
							</a>
							<a class="carousel-control-next" href="#carouseluabmedia" role="button" data-slide="next">
								<span class="carousel-control-next-icon" aria-hidden="true"></span>
								<span class="sr-only">Next</span>
							</a>
						</div>
						<br/>
						<?php include './plantilla/directe_radio.php';?>
						<br/>
					</div>
				</div>
			</section>
			
			<!--programes uabràdio actius-->
			<section id="llista-programes">
				<h2 class="titol-seccio">Programes de UABràdio</h2>
				<div class="row">
					<!--programes que agafem staff-->
					<?php
					for ($i = 0; $i < count($data_programes_actius->list); $i++) {
					?>
					<div class="col-4 col-md-2">
						<div class="bloc-imatges position-relative">
							<a href="/programa/<?php echo $data_programes_actius->list[$i]->id; ?>/<?php echo $data_programes_actius->list[$i]->title_url; ?>">
								<div class="img-box icona-programa">
									<img 
										 src="<?php echo $data_programes_actius->list[$i]->img_poster; ?>" 
										 class="icona-programa" alt="<?php echo $data_programes_actius->list[$i]->title; ?>">
								</div>
								<center><?php echo $data_programes_actius->list[$i]->title; ?></center>
							</a>
							<br/><br/>
						</div>
					</div>
					<?php } ?>

					<!--programa ARU que es extern, enllaçem els episodis a una web externa (s'ha de fer manual)-->
					<div class="col-4 col-md-2">
						<div class="bloc-imatges position-relative">
							<a href="/aru">
								<div class="img-box icona-programa">
									<img 
										 src="assets/images/aru.png" 
										 class="icona-programa" alt="Programes ARU">
								</div>
								<center>Programes ARU</center>
							</a>
							<br/><br />
						</div>
					</div>
					<!--fi programa ARU-->
				</div>
			</section> 

			<!--cataleg de programes=categories no actives. es podria fer el php més senzill?-->
			<section id="llista-programes">
				<h2 class="titol-seccio">Catàleg d'altres temporades de UABràdio</h2>
				<div class="row">
					<?php
					for ($i = 0; $i < count($data_ARXIU->list); $i++) {
						if ($data_ARXIU->list[$i]->id == 1 || 
							$data_ARXIU->list[$i]->id == 8 || 
							$data_ARXIU->list[$i]->id == 45 || 
							$data_ARXIU->list[$i]->id == 56 || 
							$data_ARXIU->list[$i]->id == 57 ||
							$data_ARXIU->list[$i]->id == 59 ||
							$data_ARXIU->list[$i]->id == 86) {
							continue;
						}
					?>
					<div class="col-4 col-md-2">
						<div class="bloc-imatges position-relative">
							<a href="/programa/<?php echo $data_ARXIU->list[$i]->id; ?>/<?php echo $data_ARXIU->list[$i]->title_url; ?>">
								<div class="img-box icona-programa">
									<img 
										 src="<?php echo $data_ARXIU->list[$i]->img_poster; ?>" 
										 class="icona-programa" alt="<?php echo $data_ARXIU->list[$i]->title; ?>">
								</div>
								<center><?php echo $data_ARXIU->list[$i]->title; ?></center>
							</a>
						</div>
						<br/><br/>
					</div>
					<?php } ?>
				</div>
			</section>
			<!-- fi cataleg de programes=categories no actives-->
			<?php
			include './plantilla/footer.php';

			?>
		</div>

		<!--script de java per fer que la graella funcioni-->		
		<script>
			$(document).ready(function() {
				var diaActual = new Date().getDay();
				var tabId;

				if (diaActual === 0 || diaActual === 6) {
					tabId = "#Dilluns";
				} else {
					switch(diaActual) {
						case 1:
							tabId = "#Dilluns";
							break;
						case 2:
							tabId = "#Dimarts";
							break;
						case 3:
							tabId = "#Dimecres";
							break;
						case 4:
							tabId = "#Dijous";
							break;
						case 5:
							tabId = "#Divendres";
							break;
						case 6:
							tabId = "#Dissabte";
							break;
					}
				}

				$('#myTab a[href="' + tabId + '"]').tab('show');
			});
		</script>



		<script>
			// AOS is loaded with "defer" in the footer, so it isn't available yet
			// when this inline script runs. Initialise it once the DOM is ready
			// (deferred scripts have executed by then) and guard for safety.
			document.addEventListener('DOMContentLoaded', function () {
				if (window.AOS) {
					AOS.init({ duration: 500 });
				}
			});
		</script>
		<script src="/assets/js/search.js"></script>
	</body>
</html>