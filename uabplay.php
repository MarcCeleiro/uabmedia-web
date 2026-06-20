<?php
/**
Aquesta pàgina mostra els continguts de UABplay (antigament anomenat UABtv) a partir de dos blocs principals, utilitzant com a categoria arrel UABplay (ID 16) i diferenciant entre programes actius i arxiu.

El bloc “Programes de UABplay” carrega totes les categories actives a Staff (status = 1) que són filles directes de la categoria UABplay (ID 16). Aquest llistat es genera dinàmicament a través de l’API, ordenant els resultats pel títol i mostrant únicament els programes que actualment estan marcats com a actius.

El bloc “Catàleg d’altres temporades de UABplay” mostra les categories inactives a Staff (status = 0) que també són filles directes de la categoria UABplay (ID 16). En aquest cas, s’exclou explícitament la pròpia categoria arrel (ID 16) mitjançant una condició al codi, ja que no representa un programa sinó un contenidor general. Aquest bloc agrupa programes de temporades anteriors o continguts que, per diferents motius (finalització del projecte, canvis editorials, drets, etc.), ja no es mostren com a actius al frontend.

A diferència de la pàgina de UABràdio, aquesta vista no utilitza graelles setmanals ni categories forçades manualment: tota la informació es basa exclusivament en l’estat (status) i la jerarquia de categories definides a Staff sota la categoria UABplay (ID 16).

Afegit per Marc Celeiro (marc.celeiro@uab.cat) el 18 de desembre de 2025
**/

include 'config.php';

//START mòdul clips de video actius
$GET_VARS_PROG = array(
	"go"        => "categories",
	"do"        => "list"
);

$POST_VARS_PROG = array(
	"sortByFilter"      => "title",
	"includeData"       => 1,
	"parentFilter"      => 16,
	"statusFilter"      => 1
);

$REQUEST_URL_PROG = $API_URL . "?" . http_build_query($GET_VARS) . "&" . http_build_query($GET_VARS_PROG);

$ch_PROG = curl_init();
curl_setopt($ch_PROG, CURLOPT_URL, $REQUEST_URL_PROG);
curl_setopt($ch_PROG, CURLOPT_POST, true);
curl_setopt($ch_PROG, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch_PROG, CURLOPT_HEADER, false);
curl_setopt($ch_PROG, CURLOPT_POSTFIELDS, $POST_VARS_PROG);

$response_PROG = curl_exec($ch_PROG);
$data_PROG = json_decode($response_PROG);
//END mòdul clips de videos actius 

//START mòdul clips cataleg					
$GET_VARS_ARXIU = array(
	"go"        => "categories",
	"do"        => "list"
);

$POST_VARS_ARXIU = array(
	"sortByFilter"          => "name",
	"includeData"           => 1,
	"parentFilter"          => 16,
	"statusFilter"          => 0,
	"resultsPerPageFilter"  => 50
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
//END mòdul clips no actius (statusfilter=0) pel catelg
?>
<!doctype html>
<html lang="ca">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>UABplay, la televisió de l'Autònoma - UABmèdia</title>
		<meta name="description" content="Descobreix, Comparteix, Connecta">
		<meta name="theme-color" content="#141414">
		<meta name="twitter:card" content="summary">
		<meta name="twitter:site" content="@uabmedia">
		<meta name="twitter:title" content="Descobreix, Comparteix, Connecta">
		<meta name="twitter:description" content="Descobreix, Comparteix, Connecta">
		<meta name="twitter:image:src" content="https://uab.media/assets/images/uabtv_twitter.jpeg">
		<meta name="twitter:url" content="https://uab.media/uabplay">
		<meta property="og:site_name" content="UABmèdia" />
		<meta property="og:url" content="https://uab.media/uabplay" />
		<meta property="og:title" content="Descobreix, Comparteix, Connecta" />
		<meta property="og:description" content="Descobreix, Comparteix, Connecta" />
		<meta property="og:image" content="https://uab.media/assets/images/uabtv_twitter.jpeg" />
		<link rel="canonical" href="https://uab.media/uabplay/">
		<?php
		include './head-import.php';
		?>
	</head>
	<body>
		<?php include './plantilla/header.php';?>
		<div class="container">
			<h1 class="titol-pagina"><img style="margin-right:20px;height:30px;padding-bottom:5px" src="https://uab.media/assets/images/uabtv-color.svg" alt="UABplay">UABplay</h1>
			<span>La televisió de la Facultat de Ciències de la Comunicació de la UAB</span>
			<section id="directetv" style="margin-top: 40px">
				<script src= "https://player.twitch.tv/js/embed/v1.js"></script>
				<div id="twitch-embed" 
					 style="height: 360px; width: 640px;">
				</div>
				<script type="text/javascript">
					var options = {
						width: 840, 
						height: 420,
						channel: "UABmedia",
					};
					var player = new Twitch.Player("twitch-embed", options);
					player.setVolume(0.7);
				</script>
			</section>
			<div class="container">

				<!--inici programes uabplay-->
				<section id="llista-programes">
					<h2 class="titol-seccio">Programes de UABplay</h2>
					<div class="row">
						<?php
						for ($i = 0; $i < count($data_PROG->list); $i++) {
						?>
						<div class="col-4 col-md-2">
							<div class="bloc-imatges position-relative">
								<a href="/programa/<?php echo $data_PROG->list[$i]->id; ?>/<?php echo $data_PROG->list[$i]->title_url; ?>">
									<div class="img-box icona-programa">
										<img 
											 src="<?php echo $data_PROG->list[$i]->img_poster; ?>" 
											 class="icona-programa" alt="<?php echo $data_PROG->list[$i]->title; ?>">
									</div>
									<center><?php echo $data_PROG->list[$i]->title; ?></center>
								</a><br/><br/>
							</div>
						</div>
						<?php } ?>
					</div>
				</section>
				<!--fi programes uabplay-->

				<!--catàleg altres temporades-->
				<section id="llista-programes">	
					<h2 class="titol-seccio">Catàleg d'altres temporades de UABplay</h2>
					<div class="row">
						<?php
						for ($i = 0; $i < count($data_ARXIU->list); $i++) {
							if ($data_ARXIU->list[$i]->id == 16) {
								continue;}            
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
				<!--fi catàleg altres temporades-->
			</div>
		</div>
		<?php
		include './plantilla/footer.php';
		?>
		<script src="/assets/js/search.js"></script>
	</body>
</html>