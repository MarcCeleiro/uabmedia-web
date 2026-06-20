<?php
include 'config.php';

// Paràmetres per a les notícies
$paramsNoticies = array(
	"go" => "news",
	"do" => "list"
);

$filtreNoticies = array(
	"statusFilter" => 1,
	"resultsPerPageFilter" => 30,
	"categoriesFilter" => 21,
	"categoriesFilterStrict" => 1,
);

$urlNoticies = $API_URL . "?" . http_build_query($GET_VARS) . "&" . http_build_query($paramsNoticies);

$conNoticies = curl_init();
curl_setopt($conNoticies, CURLOPT_URL, $urlNoticies);
curl_setopt($conNoticies, CURLOPT_POST, true);
curl_setopt($conNoticies, CURLOPT_RETURNTRANSFER, true);
curl_setopt($conNoticies, CURLOPT_HEADER, false);
curl_setopt($conNoticies, CURLOPT_POSTFIELDS, $filtreNoticies);
$respostaNoticies = curl_exec($conNoticies);
$dadesNoticies = json_decode($respostaNoticies);

// Paràmetres per als Informatius
$paramsInformatius = array(
	"go" => "clips",
	"do" => "list"
);

$filtreInformatius = array(
	"sortByFilter"      => "date",
	"categoriesFilter"  => '2',
	"statusFilter"    => 1,
	"resultsPerPageFilter" => 4,
);

$urlInformatius = $API_URL . "?" . http_build_query($GET_VARS) . "&" . http_build_query($paramsInformatius);

$conInformatius = curl_init();
curl_setopt($conInformatius, CURLOPT_URL, $urlInformatius);
curl_setopt($conInformatius, CURLOPT_POST, true);
curl_setopt($conInformatius, CURLOPT_RETURNTRANSFER, true);
curl_setopt($conInformatius, CURLOPT_HEADER, false);
curl_setopt($conInformatius, CURLOPT_POSTFIELDS, $filtreInformatius);
$respostaInformatius = curl_exec($conInformatius);
$dadesInformatius = json_decode($respostaInformatius);

// Paràmetres per a Campus
$paramsCampus = array(
	"go" => "news",
	"do" => "list"
);

$filtreCampus = array(
	"statusFilter" => 1,
	"resultsPerPageFilter" => 30,
	"categoriesFilter" => 22,
	"categoriesFilterStrict" => 1
);

$urlCampus = $API_URL . "?" . http_build_query($GET_VARS) . "&" . http_build_query($paramsCampus);

$conCampus = curl_init();
curl_setopt($conCampus, CURLOPT_URL, $urlCampus);
curl_setopt($conCampus, CURLOPT_POST, true);
curl_setopt($conCampus, CURLOPT_RETURNTRANSFER, true);
curl_setopt($conCampus, CURLOPT_HEADER, false);
curl_setopt($conCampus, CURLOPT_POSTFIELDS, $filtreCampus);
$respostaCampus = curl_exec($conCampus);
$dadesCampus = json_decode($respostaCampus);

// Paràmetres per a Centenari

$paramsCentenari = array(
	"go" => "news",
	"do" => "list"
);

$filtreCentenari = array(
	"statusFilter" => 1,
	"resultsPerPageFilter" => 30,
	"categoriesFilter" => 92,
	"categoriesFilterStrict" => 1
);

$urlCentenari = $API_URL . "?" . http_build_query($GET_VARS) . "&" . http_build_query($paramsCentenari);

$conCentenari = curl_init();
curl_setopt($conCentenari, CURLOPT_URL, $urlCentenari);
curl_setopt($conCentenari, CURLOPT_POST, true);
curl_setopt($conCentenari, CURLOPT_RETURNTRANSFER, true);
curl_setopt($conCentenari, CURLOPT_HEADER, false);
curl_setopt($conCentenari, CURLOPT_POSTFIELDS, $filtreCentenari);
$respostaCentenari = curl_exec($conCentenari);
$dadesCentenari = json_decode($respostaCentenari);

// Paràmetres per a Cultura
$paramsCultura = array(
	"go" => "news",
	"do" => "list"
);

$filtreCultura = array(
	"statusFilter" => 1,
	"resultsPerPageFilter" => 30,
	"categoriesFilter" => 26,
	"categoriesFilterStrict" => 1
);

$urlCultura = $API_URL . "?" . http_build_query($GET_VARS) . "&" . http_build_query($paramsCultura);

$conCultura = curl_init();
curl_setopt($conCultura, CURLOPT_URL, $urlCultura);
curl_setopt($conCultura, CURLOPT_POST, true);
curl_setopt($conCultura, CURLOPT_RETURNTRANSFER, true);
curl_setopt($conCultura, CURLOPT_HEADER, false);
curl_setopt($conCultura, CURLOPT_POSTFIELDS, $filtreCultura);
$respostaCultura = curl_exec($conCultura);
$dadesCultura = json_decode($respostaCultura);

// Paràmetres per a Societat
$paramsSocietat = array(
	"go" => "news",
	"do" => "list"
);

$filtreSocietat = array(
	"statusFilter" => 1,
	"resultsPerPageFilter" => 30,
	"categoriesFilter" => 24,
	"categoriesFilterStrict" => 1
);

$urlSocietat = $API_URL . "?" . http_build_query($GET_VARS) . "&" . http_build_query($paramsSocietat);

$conSocietat = curl_init();
curl_setopt($conSocietat, CURLOPT_URL, $urlSocietat);
curl_setopt($conSocietat, CURLOPT_POST, true);
curl_setopt($conSocietat, CURLOPT_RETURNTRANSFER, true);
curl_setopt($conSocietat, CURLOPT_HEADER, false);
curl_setopt($conSocietat, CURLOPT_POSTFIELDS, $filtreSocietat);
$respostaSocietat = curl_exec($conSocietat);
$dadesSocietat = json_decode($respostaSocietat);

// Paràmetres per a Igualtat
$paramsIgualtat = array(
	"go" => "news",
	"do" => "list"
);

$filtreIgualtat = array(
	"statusFilter" => 1,
	"resultsPerPageFilter" => 30,
	"categoriesFilter" => 30,
	"categoriesFilterStrict" => 1
);

$urlIgualtat = $API_URL . "?" . http_build_query($GET_VARS) . "&" . http_build_query($paramsIgualtat);

$conIgualtat = curl_init();
curl_setopt($conIgualtat, CURLOPT_URL, $urlIgualtat);
curl_setopt($conIgualtat, CURLOPT_POST, true);
curl_setopt($conIgualtat, CURLOPT_RETURNTRANSFER, true);
curl_setopt($conIgualtat, CURLOPT_HEADER, false);
curl_setopt($conIgualtat, CURLOPT_POSTFIELDS, $filtreIgualtat);
$respostaIgualtat = curl_exec($conIgualtat);
$dadesIgualtat = json_decode($respostaIgualtat);

// Paràmetres per a Ciència
$paramsCiencia = array(
	"go" => "news",
	"do" => "list"
);

$filtreCiencia = array(
	"statusFilter" => 1,
	"resultsPerPageFilter" => 30,
	"categoriesFilter" => 66,
	"categoriesFilterStrict" => 1
);

$urlCiencia = $API_URL . "?" . http_build_query($GET_VARS) . "&" . http_build_query($paramsCiencia);

$conCiencia = curl_init();
curl_setopt($conCiencia, CURLOPT_URL, $urlCiencia);
curl_setopt($conCiencia, CURLOPT_POST, true);
curl_setopt($conCiencia, CURLOPT_RETURNTRANSFER, true);
curl_setopt($conCiencia, CURLOPT_HEADER, false);
curl_setopt($conCiencia, CURLOPT_POSTFIELDS, $filtreCiencia);
$respostaCiencia = curl_exec($conCiencia);
$dadesCiencia = json_decode($respostaCiencia);

// Paràmetres per a Medi Ambient

$paramsMediambient = array(
	"go" => "news",
	"do" => "list"
);

$filtreMediambient = array(
	"statusFilter" => 1,
	"resultsPerPageFilter" => 30,
	"categoriesFilter" => 94,
	"categoriesFilterStrict" => 1
);

$urlMediambient = $API_URL . "?" . http_build_query($GET_VARS) . "&" . http_build_query($paramsMediambient);

$conMediambient = curl_init();
curl_setopt($conMediambient, CURLOPT_URL, $urlMediambient);
curl_setopt($conMediambient, CURLOPT_POST, true);
curl_setopt($conMediambient, CURLOPT_RETURNTRANSFER, true);
curl_setopt($conMediambient, CURLOPT_HEADER, false);
curl_setopt($conMediambient, CURLOPT_POSTFIELDS, $filtreMediambient);
$respostaMediambient = curl_exec($conMediambient);
$dadesMediambient = json_decode($respostaMediambient);

// Paràmetres per a Tecnologia

$paramsTecnologia = array(
	"go" => "news",
	"do" => "list"
);

$filtreTecnologia = array(
	"statusFilter" => 1,
	"resultsPerPageFilter" => 30,
	"categoriesFilter" => 93,
	"categoriesFilterStrict" => 1
);

$urlTecnologia = $API_URL . "?" . http_build_query($GET_VARS) . "&" . http_build_query($paramsTecnologia);

$conTecnologia = curl_init();
curl_setopt($conTecnologia, CURLOPT_URL, $urlTecnologia);
curl_setopt($conTecnologia, CURLOPT_POST, true);
curl_setopt($conTecnologia, CURLOPT_RETURNTRANSFER, true);
curl_setopt($conTecnologia, CURLOPT_HEADER, false);
curl_setopt($conTecnologia, CURLOPT_POSTFIELDS, $filtreTecnologia);
$respostaTecnologia = curl_exec($conTecnologia);
$dadesTecnologia = json_decode($respostaTecnologia);


//// Paràmetres per a Cultura

// Paràmetres per a Més Actualitat
$paramsMesActualitat = array(
	"go" => "news",
	"do" => "list"
);

$filtreMesActualitat = array(
	"statusFilter" => 1,
	"resultsPerPageFilter" => 30,
	"categoriesFilter" => 84,
	"categoriesFilterStrict" => 1
);

$urlMesActualitat = $API_URL . "?" . http_build_query($GET_VARS) . "&" . http_build_query($paramsMesActualitat);

$conMesActualitat = curl_init();
curl_setopt($conMesActualitat, CURLOPT_URL, $urlMesActualitat);
curl_setopt($conMesActualitat, CURLOPT_POST, true);
curl_setopt($conMesActualitat, CURLOPT_RETURNTRANSFER, true);
curl_setopt($conMesActualitat, CURLOPT_HEADER, false);
curl_setopt($conMesActualitat, CURLOPT_POSTFIELDS, $filtreMesActualitat);
$respostaMesActualitat = curl_exec($conMesActualitat);
$dadesMesActualitat = json_decode($respostaMesActualitat);
?>

<!doctype html>
<html lang="ca">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Actualitat - UABmèdia</title>
		<meta name="theme-color" content="#141414">
		<meta name="description" content="Els mitjans audiovisuals de l'alumnat de la UAB.">
		<meta name="twitter:card" content="summary">
		<meta name="twitter:site" content="@uabmedia">
		<meta name="twitter:title" content="UABmèdia">
		<meta name="twitter:description" content="Els mitjans audiovisuals de l'alumnat de la UAB.">
		<meta name="twitter:image:src" content="./assets/images/uabmedia_twitter.jpeg">
		<meta name="twitter:url" content="https://uab.media/actualitat">
		<meta property="og:site_name" content="UABmèdia" />
		<meta property="og:url" content="https://uab.media/actualitat" />
		<meta property="og:title" content="UABmèdia" />
		<meta property="og:description" content="Els mitjans audiovisuals de l'alumnat de la UAB." />
		<meta property="og:image" content="./assets/images/uabmedia_twitter.jpeg" />

		<?php include 'head-import.php';?>
	</head>

	<body>
		<?php
		include 'plantilla/header.php';
		?>

		<div class="container">
			<h1 class="titol-pagina"><svg xmlns="http://www.w3.org/2000/svg" style="margin-right:20px;height:30px;padding-bottom:5px;fill:#fff" viewBox="0 0 24 24">
				<path d="M20 3H4C2.89 3 2 3.89 2 5V19C2 20.11 2.89 21 4 21H20C21.11 21 22 20.11 22 19V5C22 3.89 										21.11 3 20 3M5 7H10V13H5V7M19 17H5V15H19V17M19 13H12V11H19V13M19 9H12V7H19V9Z" />
				</svg>Actualitat</h1>

		<div class="row gx-3 primera-fila actualitat-row">
				<a class="col-sm-12 col-md-8 noticia-gran" href="/noticia/<?php echo $dadesNoticies->list['0']->id; ?>/<?php echo $dadesNoticies->list['0']->title_url; ?>">
					<img class="imatge-destacada" src="<?php echo $dadesNoticies->list['0']->img_social; ?>">
					<div class="contingut-noticia">
						<h2 class="titol"><?php echo $dadesNoticies->list['0']->title; ?></h2>
						<p class="subtitol"><?php echo $dadesNoticies->list['0']->description_seo; ?></p>
						<p class="data"><?php echo substr($dadesNoticies->list['0']->date_formatted, 0, -9); ?></p>
					</div>
				</a>

				<div class="col-sm-12 col-md-4">
					<?php $i = 1; while ($i > 0 and $i < 2) { ?>
					<a class="noticia-petita" href="/noticia/<?php echo $dadesNoticies->list[$i]->id; ?>/<?php echo $dadesNoticies->list[$i]->title_url; ?>">
						<img class="imatge-destacada" src="<?php echo $dadesNoticies->list[$i]->img_social; ?>">
						<div class="contingut-noticia">
							<div class="titol"><?php echo $dadesNoticies->list[$i]->title; ?></div>
							<p class="subtitol"><?php echo $dadesNoticies->list[$i]->description_seo; ?></p>
							<p class="data"><?php echo substr($dadesNoticies->list[$i]->date_formatted, 0, -9); ?></p>
						</div>
					</a>
					<?php $i++; } ?>
				</div>
			</div>

		<div class="row gx-3 fila-petites actualitat-row">
				<?php $i = 2; while ($i > 0 and $i < 6) { ?>
				<a class="col-12 col-md noticia-petita" href="/noticia/<?php echo $dadesNoticies->list[$i]->id; ?>/<?php echo $dadesNoticies->list[$i]->title_url; ?>">
					<img class="imatge-destacada" src="<?php echo $dadesNoticies->list[$i]->img_social; ?>">
					<div class="contingut-noticia">
						<div class="titol"><?php echo $dadesNoticies->list[$i]->title; ?></div>
						<p class="data"><?php echo substr($dadesNoticies->list[$i]->date_formatted, 0, -9); ?></p>
					</div>
				</a>
				<?php $i++; } ?>
			</div>
		</div>

        <section id="campus" class="seccio" style="background-color:#2c2c2c!important;color:#333;">
			<div class="container">
				<a href="https://uab.media/programa/2/informatius"><h3 class="titol-seccio">Informatius</h3></a>
				<div class="informatius-row-Index">
					<?php $i = 0;
					while ($i < 5) { ?>
					<div class="informatiuIndex">
						<div class="slide-item">
							<div class="block-images position-relative">
								<a href="/clip/<?php echo $dadesInformatius->list[$i]->id; ?>/<?php echo $dadesInformatius->list[$i]->title_url; ?>">
									<div class="img-box">
										<img 
											 loading="lazy" 
											 src="<?php echo $dadesInformatius->list[$i]->img_poster; ?>" 
											 class="img-fluid" alt="<?php echo $dadesInformatius->list[$i]->title; ?>">
									</div>
									<div class="block-description"></div>
								</a>
							</div>
						</div>
					</div>
					<?php $i++;} ?>
				</div>
			</div>
		</section>

		<section id="campus" class="seccio">
			<div class="container">
				<a href="https://uab.media/noticies/campus"><h3 class="titol-seccio">Campus</h3></a>
				<div class="row gx-3">
					<?php $i = 0; while ($i < 4) { ?>
					<a class="col-12 col-md noticia-petita" href="/noticia/<?php echo $dadesCampus->list[$i]->id; ?>/<?php echo $dadesCampus->list[$i]->title_url; ?>">
						<img class="imatge-destacada" src="<?php echo $dadesCampus->list[$i]->img_social; ?>">
						<div class="contingut-noticia">
							<div class="titol"><?php echo $dadesCampus->list[$i]->title; ?></div>
							<p class="data"><?php echo substr($dadesCampus->list[$i]->date_formatted, 0, -9); ?></p>
						</div>
					</a>
					<?php $i++; } ?>
				</div>
				<div class="row gx-3">
					<div class="col-12 d-flex justify-content-end">
						<a href="https://uab.media/noticies/campus" class="btn btn-sm btn-lila">
							<i class="fa fa-arrow gx-3-circle-right"></i> Més notícies
						</a>
					</div>
				</div>
			</div>
		</section>

        

        <section id="cultura-i-mitjans" class="seccio" style="background-color:#2c2c2c!important;color:#333;">
			<div class="container">
				<a href="https://uab.media/noticies/cultura-i-mitjans"><h3 class="titol-seccio">Cultura i Mitjans</h3></a>
				<div class="row gx-3">
					<?php $i = 0; while ($i < 4) { ?>
					<a class="col-12 col-md noticia-petita" href="/noticia/<?php echo $dadesCultura->list[$i]->id; ?>/<?php echo $dadesCultura->list[$i]->title_url; ?>">
						<img class="imatge-destacada" src="<?php echo $dadesCultura->list[$i]->img_social; ?>">
						<div class="contingut-noticia">
							<div class="titol"><?php echo $dadesCultura->list[$i]->title; ?></div>
							<p class="data"><?php echo substr($dadesCultura->list[$i]->date_formatted, 0, -9); ?></p>
						</div>
					</a>
					<?php $i++; } ?>
				</div>
				<div class="row gx-3">
					<div class="col-12 d-flex justify-content-end">
						<a href="https://uab.media/noticies/cultura-i-mitjans" class="btn btn-sm btn-lila">
							<i class="fa fa-arrow gx-3-circle-right"></i> Més notícies
						</a>
					</div>
				</div>
			</div>
		</section>

		<section id="societat" class="seccio">
			<div class="container">
				<a href="https://uab.media/noticies/societat"><h3 class="titol-seccio">Societat</h3></a>
				<div class="row gx-3">
					<?php $i = 0; while ($i < 4) { ?>
					<a class="col-12 col-md noticia-petita" href="/noticia/<?php echo $dadesSocietat->list[$i]->id; ?>/<?php echo $dadesSocietat->list[$i]->title_url; ?>">
						<img class="imatge-destacada" src="<?php echo $dadesSocietat->list[$i]->img_social; ?>">
						<div class="contingut-noticia">
							<div class="titol"><?php echo $dadesSocietat->list[$i]->title; ?></div>
							<p class="data"><?php echo substr($dadesSocietat->list[$i]->date_formatted, 0, -9); ?></p>
						</div>
					</a>
					<?php $i++; } ?>
				</div>
				<div class="row gx-3">
					<div class="col-12 d-flex justify-content-end">
						<a href="https://uab.media/noticies/societat" class="btn btn-sm btn-lila">
							<i class="fa fa-arrow gx-3-circle-right"></i> Més notícies
						</a>
					</div>
				</div>
			</div>
		</section>

		<section id="igualtat" class="seccio" style="background-color:#2c2c2c!important;color:#333;">
			<div class="container">
				<a href="https://uab.media/noticies/igualtat"><h3 class="titol-seccio">Igualtat</h3></a>
				<div class="row gx-3">
					<?php $i = 0; while ($i < 4) { ?>
					<a class="col-12 col-md noticia-petita" href="/noticia/<?php echo $dadesIgualtat->list[$i]->id; ?>/<?php echo $dadesIgualtat->list[$i]->title_url; ?>">
						<img class="imatge-destacada" src="<?php echo $dadesIgualtat->list[$i]->img_social; ?>">
						<div class="contingut-noticia">
							<div class="titol"><?php echo $dadesIgualtat->list[$i]->title; ?></div>
							<p class="data"><?php echo substr($dadesIgualtat->list[$i]->date_formatted, 0, -9); ?></p>
						</div>
					</a>
					<?php $i++; } ?>
				</div>
				<div class="row gx-3">
					<div class="col-12 d-flex justify-content-end">
						<a href="https://uab.media/noticies/igualtat" class="btn btn-sm btn-lila">
							<i class="fa fa-arrow gx-3-circle-right"></i> Més notícies
						</a>
					</div>
				</div>
			</div>
		</section>

		<section id="ciència-i-tecnologia" class="seccio" >
			<div class="container">
				<a href="https://uab.media/noticies/ciencia-i-salut"><h3 class="titol-seccio">Ciència i Salut</h3></a>
				<div class="row gx-3">
					<?php $i = 0; while ($i < 4) { ?>
					<a class="col-12 col-md noticia-petita" href="/noticia/<?php echo $dadesCiencia->list[$i]->id; ?>/<?php echo $dadesCiencia->list[$i]->title_url; ?>">
						<img class="imatge-destacada" src="<?php echo $dadesCiencia->list[$i]->img_social; ?>">
						<div class="contingut-noticia">
							<div class="titol"><?php echo $dadesCiencia->list[$i]->title; ?></div>
							<p class="data"><?php echo substr($dadesCiencia->list[$i]->date_formatted, 0, -9); ?></p>
						</div>
					</a>
					<?php $i++; } ?>
				</div>
				<div class="row gx-3">
					<div class="col-12 d-flex justify-content-end">
						<a href="https://uab.media/noticies/ciencia-i-salut" class="btn btn-sm btn-lila">
							<i class="fa fa-arrow gx-3-circle-right"></i> Més notícies
						</a>
					</div>
				</div>
			</div>
		</section>

        <section id="ciència-i-tecnologia" class="seccio" style="background-color:#2c2c2c!important;color:#333;">
			<div class="container">
				<a href="https://uab.media/noticies/medi-ambient"><h3 class="titol-seccio">Medi Ambient i Sostenibilitat</h3></a>
				<div class="row gx-3">
					<?php $i = 0; while ($i < 4) { ?>
					<a class="col-12 col-md noticia-petita" href="/noticia/<?php echo $dadesMediambient->list[$i]->id; ?>/<?php echo $dadesMediambient->list[$i]->title_url; ?>">
						<img class="imatge-destacada" src="<?php echo $dadesMediambient->list[$i]->img_social; ?>">
						<div class="contingut-noticia">
							<div class="titol"><?php echo $dadesMediambient->list[$i]->title; ?></div>
							<p class="data"><?php echo substr($dadesMediambient->list[$i]->date_formatted, 0, -9); ?></p>
						</div>
					</a>
					<?php $i++; } ?>
				</div>
				<div class="row gx-3">
					<div class="col-12 d-flex justify-content-end">
						<a href="https://uab.media/noticies/medi-ambient" class="btn btn-sm btn-lila">
							<i class="fa fa-arrow gx-3-circle-right"></i> Més notícies
						</a>
					</div>
				</div>
			</div>
		</section>

		<section id="ciència-i-tecnologia" class="seccio">
			<div class="container">
				<a href="https://uab.media/noticies/tecnologia-i-innovacio"><h3 class="titol-seccio">Tecnologia i Innovació</h3></a>
				<div class="row gx-3">
					<?php $i = 0; while ($i < 4) { ?>
					<a class="col-12 col-md noticia-petita" href="/noticia/<?php echo $dadesTecnologia->list[$i]->id; ?>/<?php echo $dadesTecnologia->list[$i]->title_url; ?>">
						<img class="imatge-destacada" src="<?php echo $dadesTecnologia->list[$i]->img_social; ?>">
						<div class="contingut-noticia">
							<div class="titol"><?php echo $dadesTecnologia->list[$i]->title; ?></div>
							<p class="data"><?php echo substr($dadesTecnologia->list[$i]->date_formatted, 0, -9); ?></p>
						</div>
					</a>
					<?php $i++; } ?>
				</div>
				<div class="row gx-3">
					<div class="col-12 d-flex justify-content-end">
						<a href="https://uab.media/noticies/tecnologia-i-innovacio" class="btn btn-sm btn-lila">
							<i class="fa fa-arrow gx-3-circle-right"></i> Més notícies
						</a>
					</div>
				</div>
			</div>
		</section>

        <section id="campus" class="seccio" style="background-color:#2c2c2c!important;color:#333;">
			<div class="container">
				<a href="https://uab.media/noticies/centenari"><h3 class="titol-seccio">Centenari de la Ràdio</h3></a>
				<div class="row gx-3">
					<?php $i = 0; while ($i < 4) { ?>
					<a class="col-12 col-md noticia-petita" href="/noticia/<?php echo $dadesCentenari->list[$i]->id; ?>/<?php echo $dadesCentenari->list[$i]->title_url; ?>">
						<img class="imatge-destacada" src="<?php echo $dadesCentenari->list[$i]->img_social; ?>">
						<div class="contingut-noticia">
							<div class="titol"><?php echo $dadesCentenari->list[$i]->title; ?></div>
							<p class="data"><?php echo substr($dadesCentenari->list[$i]->date_formatted, 0, -9); ?></p>
						</div>
					</a>
					<?php $i++; } ?>
				</div>
				<div class="row gx-3">
					<div class="col-12 d-flex justify-content-end">
						<a href="https://uab.media/noticies/centenari" class="btn btn-sm btn-lila">
							<i class="fa fa-arrow gx-3-circle-right"></i> Més notícies
						</a>
					</div>
				</div>
			</div>
		</section>

		<section id="mes-actualitat" class="seccio">
			<div class="container">
				<a href="https://uab.media/noticies/mes-actualitat"><h3 class="titol-seccio">+ Actualitat</h3></a>
				<div class="row gx-3">
					<?php $i = 0; while ($i < 2) { ?>
					<a class="col-12 col-md noticia-petita" href="/noticia/<?php echo $dadesMesActualitat->list[$i]->id; ?>/<?php echo $dadesMesActualitat->list[$i]->title_url; ?>">
						<img class="imatge-destacada" src="<?php echo $dadesMesActualitat->list[$i]->img_social; ?>">
						<div class="contingut-noticia">
							<div class="titol"><?php echo $dadesMesActualitat->list[$i]->title; ?></div>
							<p class="data"><?php echo substr($dadesMesActualitat->list[$i]->date_formatted, 0, -9); ?></p>
						</div>
					</a>
					<?php $i++; } ?>
				</div>
				<div class="row gx-3">
					<div class="col-12 d-flex justify-content-end">
						<a href="https://uab.media/noticies/mes-actualitat" class="btn btn-sm btn-lila">
							<i class="fa fa-arrow gx-3-circle-right"></i> Més notícies
						</a>
					</div>
				</div>
			</div>
		</section>

		<?php include('plantilla/footer.php'); ?>
		<script src="/assets/js/search.js"></script>
	</body>

</html>