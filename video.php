<?php
include 'config.php';
$GET_VARS2 = array(
	"go"        => "clips",
	"do"        => "get"
);
$REQUEST_URL = $API_URL . "?" . http_build_query($GET_VARS) . "&" . http_build_query($GET_VARS2);

// "do=get" identifica el clip mitjançant la query string (iq); no cal cos POST.
$POST_VARS = array();

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $REQUEST_URL);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, $POST_VARS);

$response = curl_exec($ch);

$data = json_decode($response);
?>

<!doctype html>
<html lang="ca">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title><?php echo $data->data->title; ?> - UABmèdia</title>
	<meta name="description" content="<?php echo $data->data->description_seo; ?>">
	<meta name="theme-color" content="#141414">
	<meta name="twitter:card" content="player">
	<meta name="twitter:player" content="https://uab.media/embed/<?php echo $data->data->id; ?>/<?php echo $data->data->title_url; ?>">
	<meta name="twitter:player:height" content="360">
	<meta name="twitter:player:width" content="200">
	<meta name="twitter:site" content="@uabmedia">
	<meta name="twitter:title" content="<?php echo $data->data->title; ?> - UABmèdia">
	<meta name="twitter:description" content="<?php echo $data->data->description_seo; ?>">
	<meta name="twitter:image" content="<?php echo $data->data->img_social; ?>">
	<meta name="twitter:url" content="https://uab.media/clip/<?php echo $data->data->id; ?>/<?php echo $data->data->title_url; ?>">
	<meta property="og:site_name" content="UABmèdia" />
	<meta property="og:url" content="https://uab.media/clip/<?php echo $data->data->id; ?>/<?php echo $data->data->title_url; ?>" />
	<meta property="og:title" content="<?php echo $data->data->title; ?> - UABmèdia" />
	<meta property="og:description" content="<?php echo $data->data->description_seo; ?>" />
	<meta property="og:image" content="<?php echo $data->data->img_social; ?>" />
	<link rel="canonical" href="https://uab.media/clip/<?php echo $data->data->id; ?>/<?php echo $data->data->title_url; ?>">
	<link rel="shortcut icon" href="https://uab.media/assets/images/favicon.png" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" />
	<link rel="stylesheet" href="/assets/css/typography.css">
	<link rel="stylesheet" href="/assets/css/style.css" />
	<link rel="stylesheet" href="/assets/css/responsive.css" />
	<link rel="stylesheet" href="https://uab.media/assets/player/video.css" />
	<link rel="stylesheet" href="https://uab.media/assets/player/video-js.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://s3-eu-west-1.amazonaws.com">
    <script type="application/ld+json">
        {
        "@context":"http://schema.org/",
        "@type":"VideoObject",
        "name":"<?php echo $data->data->title; ?>",
        "description":"<?php echo $data->data->description_seo; ?>",
        "thumbnailUrl":"<?php echo $data->data->img_social; ?>",
        "@id":"https://uab.media/clip/<?php echo $data->data->id; ?>/<?php echo $data->data->title_url; ?>",
        "embedUrl":"https://uab.media/embed/<?php echo $data->data->id; ?>/<?php echo $data->data->title_url; ?>",
		"uploadDate":"<?php echo $data->data->date_formatted; ?>"
        }
    </script>
</head>

<body>
	<?php
	include './plantilla/header.php';
	?>
	<div id="reproductor" class="contenidor-video">
		<?php echo $data->media['0']->embed_html5; ?>
		<video class="video-js vjs-big-play-centered" controls preload="auto" height="500" poster="<?php echo $data->data->img_poster; ?>" data-setup='{"fluid": true}'>
			<source src="<?php echo $data->media['0']->vod_html5_h264; ?>" />
			<p class="vjs-no-js">
				Per a veure aquest capítol, cal activar JavaScript.
			</p>
		</video>
	</div>
	<div class="container">
		<div class="contingut movi">
			<section class="detall-video container-fluid">
				<div class="row">
					<div class="col-lg-12">
						<div class="info-destacat g-border">
							<h1 class="titol-destacat titol-gran text-uppercase mt-0">
								<?php echo $data->data->title; ?>
							</h1>
                            <?php
                                include 'config.php';
                                $GET_VARS_usuari = array(
                                    "go"        => "categories",
                                    "do"        => "get",
                                    "iq"        => $data->categories['0']->id
                                );
                                $REQUEST_URL_usuari = $API_URL."?".http_build_query($GET_VARS)."&".http_build_query($GET_VARS_usuari);

                                // "do=get" identifica la categoria mitjançant la query string (iq); no cal cos POST.
                                $POST_VARS_usuari = array();

                                $ch_usuari = curl_init();
                                curl_setopt($ch_usuari, CURLOPT_URL, $REQUEST_URL_usuari);
                                curl_setopt($ch_usuari, CURLOPT_POST, true);
                                curl_setopt($ch_usuari, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($ch_usuari, CURLOPT_HEADER, false);
                                curl_setopt($ch_usuari, CURLOPT_POSTFIELDS, $POST_VARS_usuari);
                                
                                $response_usuari = curl_exec($ch_usuari);
                                
                                $data_usuari = json_decode($response_usuari);
                            ?>
							<br/>
                            <div class="um-capcalera d-flex align-items-center">
                                <img class="avatar-autor" src="<?php echo $data_usuari->data->img_social; ?>" alt="<?php echo $data->categories['0']->title; ?>">
								<h2 class="h6"><strong><?php echo $data->categories['0']->title; ?></strong><br/><div class="meta-categoria">Publicat el <?php echo substr($data->data->date_formatted,0,-9); ?></div></h2>
                            </div>
							<p><?php echo $data->data->description; ?></p>
						</div>
					</div>
				</div>
			</section>

			<?php
			include 'config.php';
			$GET_VARS3 = array(
				"go"        => "clips",
				"do"        => "list"
			);

			// Prioritza la categoria secundària per al contingut relacionat, però recorre a
			// la primària quan un clip només té una categoria (evita
			// lectures de "Undefined array key 1" / propietats nul·les).
			$relatedCategory = $data->categories[1]->id ?? ($data->categories[0]->id ?? null);
			$POST_VARS3 = array(
				"sortByFilter"          => "date",
				"categoriesFilter"      => $relatedCategory
			);

			$REQUEST_URL3 = $API_URL . "?" . http_build_query($GET_VARS) . "&" . http_build_query($GET_VARS3);

			$ch3 = curl_init();
			curl_setopt($ch3, CURLOPT_URL, $REQUEST_URL3);
			curl_setopt($ch3, CURLOPT_POST, true);
			curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch3, CURLOPT_HEADER, false);
			curl_setopt($ch3, CURLOPT_POSTFIELDS, $POST_VARS3);

			$response3 = curl_exec($ch3);

			$data3 = json_decode($response3);
			?>
			<section id="llista-horitzontal">
				<div class="container-fluid">
					<div class="row">
						<div class="col-sm-12 overflow-hidden">
							<div class="um-capcalera d-flex">
								<h2 class="titol-principal h4">Continguts relacionats</h2>
							</div>
							<div class="continguts-pre">
								<ul class="favorites-slider list-inline  row p-0 mb-0">
									<li class="targeta">
										<div class="bloc-imatges position-relative">
											<div class="img-box">
												<img src="<?php echo $data3->list['0']->img_social; ?>" class="img-fluid">
											</div>
											<div class="bloc-descripcio" onclick="location.href='./clip/<?php echo $data3->list['0']->id; ?>/<?php echo $data3->list['0']->title_url; ?>'">
												<h3 class="titol h6"><a href="/clip/<?php echo $data3->list['0']->id; ?>/<?php echo $data3->list['0']->title_url; ?>"><?php echo $data3->list['0']->title; ?></a></h3>
												<div class="capitol d-flex align-items-center my-2">
													<span class="text-white"><?php echo $data3->list['0']->date_formatted; ?></span>
												</div>
											</div>
										</div>
									</li>
									<li class="targeta">
										<div class="bloc-imatges position-relative">
											<div class="img-box">
												<img src="<?php echo $data3->list['1']->img_social; ?>" class="img-fluid">
											</div>
											<div class=" bloc-descripcio" onclick="location.href='./clip/<?php echo $data3->list['1']->id; ?>/<?php echo $data3->list['1']->title_url; ?>'">
												<h3 class="titol h6"><a href="/clip/<?php echo $data3->list['1']->id; ?>/<?php echo $data3->list['1']->title_url; ?>"><?php echo $data3->list['1']->title; ?></a></h3>
												<div class="capitol d-flex align-items-center my-2">
													<span class="text-white"><?php echo $data3->list['1']->date_formatted; ?></span>
												</div>
											</div>
										</div>
									</li>
									<li class="targeta">
										<div class="bloc-imatges position-relative">
											<div class="img-box">
												<img src="<?php echo $data3->list['2']->img_social; ?>" class="img-fluid">
											</div>
											<div class="bloc-descripcio" onclick="location.href='./clip/<?php echo $data3->list['2']->id; ?>/<?php echo $data3->list['2']->title_url; ?>'">
												<h3 class="titol h6"><a href="/clip/<?php echo $data3->list['2']->id; ?>/<?php echo $data3->list['2']->title_url; ?>"><?php echo $data3->list['2']->title; ?></a></h3>
												<div class="capitol d-flex align-items-center my-2">
													<span class="text-white"><?php echo $data3->list['2']->date_formatted; ?></span>
												</div>
											</div>
										</div>
									</li>
									<li class="targeta">
										<div class="bloc-imatges position-relative">
											<div class="img-box">
												<img src="<?php echo $data3->list['3']->img_social; ?>" class="img-fluid">
											</div>
											<div class="bloc-descripcio" onclick="location.href='./clip/<?php echo $data3->list['3']->id; ?>/<?php echo $data3->list['3']->title_url; ?>'">
												<h3 class="titol h6"><a href="/clip/<?php echo $data3->list['3']->id; ?>/<?php echo $data3->list['3']->title_url; ?>"><?php echo $data3->list['3']->title; ?></a></h3>
												<div class="capitol d-flex align-items-center my-2">
													<span class="text-white"><?php echo $data3->list['3']->date_formatted; ?></span>
												</div>
											</div>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
	<br/><br/>
	<?php
	include './plantilla/footer.php';
	?>
	<script src="/assets/js/search.js"></script>
	
	</body>

</html>
