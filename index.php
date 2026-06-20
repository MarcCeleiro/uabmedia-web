<?php
/**
Aquesta pàgina correspon a la portada principal de UABmèdia i actua com a punt d’entrada als continguts més recents i destacats del portal, combinant notícies, clips i contingut audiovisual en temps real.

En primer lloc, es fa una crida a l’API per obtenir les notícies d’actualitat (go=news, do=list), filtrant-les per la categoria Notícies (ID 21) amb filtre estricte de categoria (categoriesFilterStrict = 1) i mostrant únicament contingut actiu (status = 1). Aquest bloc alimenta tant la notícia destacada principal com el llistat de notícies secundàries de la secció “Actualitat”.

Paral·lelament, es fa una segona crida a l’API per obtenir clips associats a la categoria ID 44, que correspon a continguts audiovisuals destacats utilitzats també dins la secció d’actualitat. Aquests clips es comparen per data amb les notícies per decidir quin contingut (notícia o clip) ocupa la posició principal destacada.

A més, es fa una tercera crida a l’API per recuperar un llistat ampli de clips recents, sense filtre de categoria, ordenats per data de publicació. Aquest llistat s’utilitza per alimentar el carrusel principal de la portada, mostrant els continguts audiovisuals més recents del portal, independentment del seu origen.

La pàgina d’inici també integra contingut en directe (ràdio i televisió) mitjançant components externs i plantilles compartides, i no aplica exclusions manuals ni lògiques hardcoded sobre les categories: el contingut visible depèn exclusivament de l’estat (status), la categoria i la data definides a Staff.

Afegit per Marc Celeiro (marc.celeiro@uab.cat) el 18 de desembre de 2025
*/

include 'config.php';
$paramsNoticies = array(
	"go"        => "news",
	"do"        => "list"
);

$filtreNoticies = array(
	"statusFilter" => 1,
	"resultsPerPageFilter" => 30,
	"categoriesFilter" => 21,
	"categoriesFilterStrict" => 1,
	"fields" => "id, id_user, status, type, title, title_url, description, description_seo, img_poster, img_social, img_thumbnail, date",
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
?>
<?php
include 'config.php';
$paramsClips = array(
	"go"        => "clips",
	"do"        => "list"
);

$filtreClips = array(
	"statusFilter" => 1,
	"resultsPerPageFilter" => 30,
	"categoriesFilter" => 44,
	"categoriesFilterStrict" => 1,
	"fields" => "id, id_user, status, type, title, title_url, description, description_seo, img_poster, img_social, img_thumbnail, date",
);

$urlClips = $API_URL . "?" . http_build_query($GET_VARS) . "&" . http_build_query($paramsClips);

$conClips = curl_init();
curl_setopt($conClips, CURLOPT_URL, $urlClips);
curl_setopt($conClips, CURLOPT_POST, true);
curl_setopt($conClips, CURLOPT_RETURNTRANSFER, true);
curl_setopt($conClips, CURLOPT_HEADER, false);
curl_setopt($conClips, CURLOPT_POSTFIELDS, $filtreClips);

$respostaClips = curl_exec($conClips);

$dadesClips = json_decode($respostaClips);
?>

<?php
include 'config.php';
$paramsClipsRecents = array(
	"go"        => "clips",
	"do"        => "list"
);

$filtreClipsRecents = array(
	"sortByFilter"      => "date",
	"includeData"       => 1,
	"statusFilter"		=> 1,
	"resultsPerPageFilter" => 100,
);

$urlClipsRecents = $API_URL . "?" . http_build_query($GET_VARS) . "&" . http_build_query($paramsClipsRecents);

$conClipsRecents = curl_init();
curl_setopt($conClipsRecents, CURLOPT_URL, $urlClipsRecents);
curl_setopt($conClipsRecents, CURLOPT_POST, true);
curl_setopt($conClipsRecents, CURLOPT_RETURNTRANSFER, true);
curl_setopt($conClipsRecents, CURLOPT_HEADER, false);
curl_setopt($conClipsRecents, CURLOPT_POSTFIELDS, $filtreClipsRecents);

$respostaClipsRecents = curl_exec($conClipsRecents);
$dadesClipsRecents = json_decode($respostaClipsRecents);
?>

<!doctype html>
<html lang="ca">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>UABmèdia: Descobreix, comparteix, connecta</title>
		<meta name="theme-color" content="#141414">
		<meta name="description" content="Descobreix, comparteix, connecta.">
		<meta name="twitter:card" content="summary">
		<meta name="twitter:site" content="@uabmedia">
		<meta name="twitter:title" content="UABmèdia">
		<meta name="twitter:description" content="Descobreix, comparteix, connecta.">
		<meta name="twitter:image:src" content="./assets/images/uabmedia_twitter.jpeg">
		<meta name="twitter:url" content="https://uab.media/">
		<meta property="og:site_name" content="UABmèdia" />
		<meta property="og:url" content="https://uab.media/" />
		<meta property="og:title" content="UABmèdia" />
		<meta property="og:description" content="Descobreix, comparteix, connecta." />
		<meta property="og:image" content="./assets/images/uabmedia_twitter.jpeg" />

		<script type="application/ld+json">
        {
        "@context":"http://schema.org",
        "@type":"NewsMediaOrganization",
        "name":"UABmèdia",
        "url":"https://uab.media",
        "logo":"https://uab.media/assets/images/favicon.png",
        "sameAs":[
            "https://x.com/uabmedia",
            "https://www.instagram.com/uabmedia",
            "https://www.twitch.com/uabmedia"
        ],
        "parentOrganization":{
        "@type":"CollegeOrUniversity",
        "name":"Universitat Autònoma de Barcelona",
        "url":"https://www.uab.cat"
        },
        "address":{
            "@type":"PostalAddress",
            "streetAddress":"Carrer de la Vinya,s/n",
            "addressLocality":"Bellaterra",
            "addressRegion":"Cerdanyola del Vallès",
            "postalCode":"08193",
            "addressCountry":"ES"
        },
        "contactPoint":{
        "@type":"ContactPoint",
        "telephone":"+34935813288",
        "contactType":"customer service",
        "email":"uabmedia@uab.cat"
        }
    }
		</script>

		<?php include './head-import.php'; ?>
	</head>

	<body>
		<?php setlocale(LC_ALL, "ca_ES"); ?>
		<?php include './plantilla/header.php'; ?>

		<div class="container">
			<section id="portada">
				<div class="row gx-4 actualitat-row">
					<div class="col-sm-8 col-12 d-flex justify-content-center"> 
						<div id="carouseluabmedia" class="carousel slide carousel-fade" data-ride="carousel">
							<div class="carousel-inner m-auto">
								<div class="carousel-item active">
									<a href="/clip/<?php echo $dadesClipsRecents->list['0']->id; ?>/<?php echo $dadesClipsRecents->list['0']->title_url; ?>">
										<img class="d-block w-100" src="<?php echo $dadesClipsRecents->list['0']->img_social; ?>" alt="<?php echo $dadesClipsRecents->list['0']->title; ?>">
									</a>
									<div class="carousel-caption d-md-block">
										<h2 class="h5">
											<a href="/clip/<?php echo $dadesClipsRecents->list['0']->id; ?>/<?php echo $dadesClipsRecents->list['0']->title_url; ?>">
												<?php echo $dadesClipsRecents->list['0']->title; ?>
												<p> 
													<?php echo substr($dadesClipsRecents->list['0']->date_formatted, 0, -9); ?>
												</p>
											</a>
										</h2>
									</div>
								</div>
								<div class="carousel-item">
									<a href="/clip/<?php echo $dadesClipsRecents->list['1']->id; ?>/<?php echo $dadesClipsRecents->list['1']->title_url; ?>">
										<img class="d-block w-100" src="<?php echo $dadesClipsRecents->list['1']->img_social; ?>" alt="<?php echo $dadesClipsRecents->list['1']->title; ?>">
									</a>
									<div class="carousel-caption d-md-block">
										<h2 class="h5">
											<a href="/clip/<?php echo $dadesClipsRecents->list['1']->id; ?>/<?php echo $dadesClipsRecents->list['1']->title_url; ?>">
												<?php echo $dadesClipsRecents->list['1']->title; ?>
												<p>
													<?php echo substr($dadesClipsRecents->list['1']->date_formatted, 0, -9); ?>
												</p>
											</a>
										</h2>
									</div>
								</div>
								<div class="carousel-item">
									<a href="/clip/<?php echo $dadesClipsRecents->list['2']->id; ?>/<?php echo $dadesClipsRecents->list['2']->title_url; ?>">
										<img class="d-block w-100" src="<?php echo $dadesClipsRecents->list['2']->img_social; ?>" alt="<?php echo $dadesClipsRecents->list['2']->title; ?>">
									</a>
									<div class="carousel-caption d-md-block">
										<h2 class="h5">
											<a href="/clip/<?php echo $dadesClipsRecents->list['2']->id; ?>/<?php echo $dadesClipsRecents->list['2']->title_url; ?>"><?php echo $dadesClipsRecents->list['2']->title; ?>
												<p>
													<?php echo substr($dadesClipsRecents->list['2']->date_formatted, 0, -9); ?>
												</p>
											</a>
										</h2>
									</div>
								</div>
								<div class="carousel-item">
									<a href="/clip/<?php echo $dadesClipsRecents->list['3']->id; ?>/<?php echo $dadesClipsRecents->list['3']->title_url; ?>">
										<img class="d-block w-100" src="<?php echo $dadesClipsRecents->list['3']->img_social; ?>" alt="<?php echo $dadesClipsRecents->list['3']->title; ?>">
									</a>
									<div class="carousel-caption d-md-block">
										<h2 class="h5">
											<a href="/clip/<?php echo $dadesClipsRecents->list['3']->id; ?>/<?php echo $dadesClipsRecents->list['3']->title_url; ?>"><?php echo $dadesClipsRecents->list['3']->title; ?>
												<p>
													<?php echo substr($dadesClipsRecents->list['3']->date_formatted, 0, -9); ?>
												</p>
											</a>
										</h2>
									</div>
								</div>
								<div class="carousel-item">
									<a href="/clip/<?php echo $dadesClipsRecents->list['4']->id; ?>/<?php echo $dadesClipsRecents->list['4']->title_url; ?>">
										<img class="d-block w-100" src="<?php echo $dadesClipsRecents->list['4']->img_social; ?>" alt="<?php echo $dadesClipsRecents->list['4']->title; ?>">
									</a>
									<div class="carousel-caption d-md-block">
										<h2 class="h5">
											<a href="/clip/<?php echo $dadesClipsRecents->list['4']->id; ?>/<?php echo $dadesClipsRecents->list['4']->title_url; ?>"><?php echo $dadesClipsRecents->list['4']->title; ?>
												<p>
													<?php echo substr($dadesClipsRecents->list['4']->date_formatted, 0, -9); ?>
												</p>
											</a>
										</h2>
									</div>
								</div>
							</div>
							<a class="carousel-control-prev" href="#carouseluabmedia" role="button" data-slide="prev">
								<span class="carousel-control-prev-icon" aria-hidden="true"></span>
								<span class="sr-only">Anterior</span>
							</a>
							<a class="carousel-control-next" href="#carouseluabmedia" role="button" data-slide="next">
								<span class="carousel-control-next-icon" aria-hidden="true"></span>
								<span class="sr-only">Següent</span>
							</a>
						</div>
					</div>
					<div class="col-sm-4 col-12 justify-content-left amaga-mobil">
						<div class="bloc-inici">
							<img width="230" src="https://uab.media/assets/images/logo-uabmedia.png" alt="UABmèdia">
							<br/><br/>
							<h1 class="titol-benvinguda">Us donem la benvinguda<br/><strong>a UABmèdia</strong></h1>
							<br/>
							<p>UABmèdia és un espai de formació universitària centrat en la creació, producció i emissió de continguts innovadors i de qualitat ubicat en la facultat de Ciències de la Comunicació de la UAB.</p><p>Com a plataforma multimèdia articulem continguts sonors, audiovisuals, digitals i interactius que elabora l’alumnat, així com la resta de la comunitat universitària.</p>
						</div>
					</div>
				</div>
				<br/><br/>
				<?php include './plantilla/directe_radio.php';?>
			</section>

			<section id="actualitat" class="mb-40">
				<a href="https://uab.media/actualitat"><h2 class="titol-seccio h3">Actualitat</h2></a>
				<div class="row gx-4 actualitat-row">
					<?php
					// Compara el clip destacat més nou (categoria 44) amb la notícia
					// més nova per decidir quina encapçala la secció. Per defecte 0 perquè
					// una categoria buida no provoqui avisos de propietats nul·les.
					$a = $dadesClips->list[0]->date ?? 0;
					$b = $dadesNoticies->list[0]->date ?? 0;
					if ($b >= $a):
					?>
					<a class="col-12 col-md-8 noticia-gran d-flex flex-column flex-md-row" href="/noticia/<?php echo $dadesNoticies->list['0']->id; ?>/<?php echo $dadesNoticies->list['0']->title_url; ?>">
					<img class="imatge-destacada col-12 col-md-6 img-fluida"
						 src="<?php echo $dadesNoticies->list['0']->img_social; ?>"
						>
					<div class="contingut-noticia col-12 col-md-6">
						<h3 class="titol"><?php echo $dadesNoticies->list['0']->title; ?></h3>
						<p class="subtitol"><?php echo $dadesNoticies->list['0']->description_seo; ?></p>
						<p class="data"><?php echo substr($dadesNoticies->list['0']->date_formatted, 0, -9); ?></p>
					</div>
					</a>
					<?php else: ?>
					<a class="col-12 col-md noticia-gran noticia-gran-alta" href="/noticia/<?php echo $dadesClips->list['0']->id; ?>/<?php echo $dadesClips->list['0']->title_url; ?>">
						<img class="imatge-destacada" src="<?php echo $dadesClips->list['0']->img_social; ?>">
						<div class="contingut-noticia">
							<h3 class="titol"><?php echo $dadesClips->list['0']->title; ?></h3>
							<p class="subtitol"><?php echo $dadesClips->list['0']->description_seo; ?></p>
							<p class="data"><?php echo substr($dadesClips->list['0']->date_formatted, 0, -9); ?></p>
						</div>
					</a>
					<?php endif ?>
				</div>

				<div class="row gx-4">
					<?php $i = 1; while ($i > 0 and $i < 5) { ?>
					<a class="col-12 col-md noticia-petita" href="/noticia/<?php echo $dadesNoticies->list[$i]->id; ?>/<?php echo $dadesNoticies->list[$i]->title_url; ?>">
						<img class="imatge-destacada" src="<?php echo $dadesNoticies->list[$i]->img_poster; ?>">
						<div class="contingut-noticia">
							<div class="titol"><?php echo $dadesNoticies->list[$i]->title; ?></div>
							<p class="data"><?php echo substr($dadesNoticies->list[$i]->date_formatted, 0, -9); ?></p>
						</div>
					</a>
					<?php $i++;} ?>
				</div>
				<a href="https://uab.media/actualitat"><h2 class="titol-seccio h3">Més notícies</h2></a>
			</section>
		</div>

		<?php include './plantilla/footer.php'; ?>

		<script src="/assets/js/search.js"></script>
	</body>
</html>