<?php
/**
Aquesta pàgina correspon a la fitxa individual d’un programa (categoria) i mostra tota la informació associada a aquest programa a partir de l’API de Staff, així com el llistat dels seus capítols (clips).

En primer lloc, es fa una crida a l’API per obtenir les dades de la categoria activa (go=categories, do=get), que identifica el programa actual a partir de la seva ID. D’aquesta crida s’obtenen les dades bàsiques del programa (títol, descripció SEO, imatges, slug, etc.), que s’utilitzen tant per construir el contingut visible de la pàgina com per generar les metadades SEO i socials (title, description, Open Graph, Twitter Cards i URL canònica).

A continuació, es fa una segona crida a l’API per obtenir el llistat de clips associats a aquest programa (go=clips, do=list), filtrant-los per la ID de la categoria del programa (categoriesFilter = ID del programa) i mostrant únicament els clips actius (status = 1), ordenats per data. Aquest llistat representa els capítols o episodis del programa i es mostra en format de graella.

La pàgina, per tant, actua com a single page de programa, on la categoria funciona com a contenidor del projecte editorial o audiovisual, i els clips en són les unitats de contingut publicades al llarg del temps. No s’apliquen filtres manuals ni exclusions hardcoded: el contingut que s’hi mostra depèn exclusivament de l’estat i les relacions definides a Staff.

Afegit per Marc Celeiro (marc.celeiro@uab.cat) el 18 de desembre de 2025
*/

include 'config.php';

//START mòdul agafar el programa i identificar-lo
$GET_VARS_PROG_id = array(
	"go" => "categories",
	"do" => "get"
);

$POST_VARS = array(
	"statusFilter" => 1,
	"resultsPerPageFilter" => 100,
);

$REQUEST_URL = $API_URL . "?" . http_build_query($GET_VARS) . "&" . http_build_query($GET_VARS_PROG_id );

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $REQUEST_URL);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, $POST_VARS);

$response = curl_exec($ch);
$data_PROG_id = json_decode($response);


//END mòdul agafar el programa

//START mòdul llista clips del programa
$GET_VARS_clips = array(
	"go" => "clips",
	"do" => "list"
);

$POST_VARS_clips = array(
	"sortByFilter" => "date",
	"categoriesFilter" => $data_PROG_id->data->id,
	"statusFilter" => 1,
	"resultsPerPageFilter" => 100,
);

$REQUEST_URL_clips = $API_URL . "?" . http_build_query($GET_VARS) . "&" . http_build_query($GET_VARS_clips);

$ch_clips = curl_init();
curl_setopt($ch_clips, CURLOPT_URL, $REQUEST_URL_clips);
curl_setopt($ch_clips, CURLOPT_POST, true);
curl_setopt($ch_clips, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch_clips, CURLOPT_HEADER, false);
curl_setopt($ch_clips, CURLOPT_POSTFIELDS, $POST_VARS_clips);

$response_clips = curl_exec($ch_clips);
$data_clips = json_decode($response_clips);

//END mòdul llista clips del programa
?>

<!doctype html>
<html lang="ca">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title><?php echo htmlspecialchars(trim($data_PROG_id->data->title)); ?> - UABmèdia</title>
		<meta name="description" content="<?php echo htmlspecialchars(trim($data_PROG_id->data->description_seo)); ?>">
		<meta name="theme-color" content="#141414">
		<meta name="twitter:card" content="summary">
		<meta name="twitter:site" content="@uabmedia">
		<meta name="twitter:title" content="<?php echo htmlspecialchars(trim($data_PROG_id->data->title)); ?> - UABmèdia">
		<meta name="twitter:description" content="<?php echo htmlspecialchars(trim($data_PROG_id->data->description_seo)); ?>">
		<meta name="twitter:image:src" content="<?php echo htmlspecialchars(trim($data_PROG_id->data->img_social)); ?>">
		<meta name="twitter:url" content="https://uab.media/programa/<?php echo trim($data_PROG_id->data->id); ?>/<?php echo htmlspecialchars(trim($data_PROG_id->data->title_url)); ?>">
		<meta property="og:site_name" content="UABmèdia" />
		<meta property="og:url" content="https://uab.media/programa/<?php echo trim($data_PROG_id->data->id); ?>/<?php echo htmlspecialchars(trim($data_PROG_id->data->title_url)); ?>" />
		<meta property="og:title" content="<?php echo htmlspecialchars(trim($data_PROG_id->data->title)); ?> - UABmèdia" />
		<meta property="og:description" content="<?php echo htmlspecialchars(trim($data_PROG_id->data->description_seo)); ?>" />
		<meta property="og:image" content="<?php echo htmlspecialchars(trim($data_PROG_id->data->img_social)); ?>" />
		<link rel="canonical" href="https://uab.media/programa/<?php echo trim($data_PROG_id->data->id); ?>/<?php echo htmlspecialchars(trim($data_PROG_id->data->title_url)); ?>">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

		<?php
		include './head-import.php';
		?>
		<!--Estil -->
		<style>
			.slide-item {
				padding: 0px 0px !important;
			}
			.material-symbols-outlined{
				color:white;
			}
			.button-return{
				background-color:#141414;
				border-radius: 25px;
				margin-bottom:20px!important;
				border-color:white;
			}
			.programa_box h6{
				width: 80%;
				overflow: hidden;
				display: -webkit-box;
				-webkit-line-clamp: 3;
				-webkit-box-orient: vertical;
			}
			.slide-item {
				margin-bottom: 40px;
			}
		</style>
	</head>

	<body>

		<?php
		include './plantilla/header.php';
		?>

		<!--Primera fila -->
		<div class="container">
			<button class="button-return" onclick="window.history.back();"><span class="material-symbols-outlined">reply</span></button>

			<!--Logo + Titulo + Icono i descripcion seo con el horario programa + info -->
			<div class="d-flex align-items-center">
				<img style="margin-right:20px;width:120px;border-radius: 50%;"
					 src="<?php echo htmlspecialchars(trim($data_PROG_id->data->img_social)); ?>"
					 alt="<?php echo htmlspecialchars(trim($data_PROG_id->data->title)); ?>"
					 >
				<div>
					<h1 class="trending-text mt-0" style="font-size: 2rem"><?php echo htmlspecialchars(trim($data_PROG_id->data->title)); ?></h1>
					<a href="https://uab.media/uabradio" style="text-decoration: none;">
						<i class="fa fa-calendar" style="font-size: 2em;"></i>
					</a>
					<span><?php echo htmlspecialchars(trim($data_PROG_id->data->description_seo)); ?></span>
				</div>
			</div>
			<br/><br/>

			<h2 class="titol-seccio">Capítols</h2>
			<!--viñetas con los clips de los programas -->
			<div class="continguts-pre">
				<div class="row">
					<?php
					for ($i = 0; $i < count($data_clips->list); $i++) {
					?>
					<div class="col-12 col-md-4">
						<div class="slide-item">
							<div class="block-images position-relative">
								<div class="img-box">
									<a
									   href="/clip/<?php echo htmlspecialchars(trim($data_clips->list[$i]->id));?>/<?php echo htmlspecialchars(trim($data_clips->list[$i]->title_url)); ?>">
										<img src="<?php echo htmlspecialchars(trim($data_clips->list[$i]->img_social)); ?>" class="img-fluid" alt="">
									</a>
								</div>
								<div class="block-description">
									<h3 class="titol h6">
										<a href="/clip/<?php echo htmlspecialchars(trim($data_clips->list[$i]->id));?>/<?php echo htmlspecialchars(trim($data_clips->list[$i]->title_url));?>"><?php echo htmlspecialchars(trim($data_clips->list[$i]->title)); ?>
										</a>
									</h3>
									<div class="capitol d-flex align-items-center my-2">
										<span class="text-white"><?php echo substr(htmlspecialchars(trim($data_clips->list[$i]->date_formatted)), 0, -9); ?></span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>

		<?php
		include './plantilla/footer.php';
		?>

		<script src="/assets/js/search.js"></script>
	</body>
</html>
