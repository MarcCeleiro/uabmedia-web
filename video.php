<?php
include 'config.php';
$GET_VARS2 = array(
	"go"        => "clips",
	"do"        => "get"
);
$REQUEST_URL = $API_URL . "?" . http_build_query($GET_VARS) . "&" . http_build_query($GET_VARS2);

// "do=get" identifies the clip via the query string (iq); no POST body needed.
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
	<link rel="stylesheet" href="https://uab.media/assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="https://uab.media/assets/css/typography.css">
	<link rel="stylesheet" href="https://uab.media/assets/css/style.css" />
	<link rel="stylesheet" href="https://uab.media/assets/css/responsive.css" />
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
	<div id="reproductor" class="video-container">
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
			<section class="movie-detail container-fluid">
				<div class="row">
					<div class="col-lg-12">
						<div class="trending-info g-border">
							<h1 class="trending-text big-title text-uppercase mt-0">
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

                                // "do=get" identifies the category via the query string (iq); no POST body needed.
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
                                <img style="margin-right:20px;width:40px;border-radius: 50%;" src="<?php echo $data_usuari->data->img_social; ?>" alt="<?php echo $data->categories['0']->title; ?>">
								<h6><strong><?php echo $data->categories['0']->title; ?></strong><br/><div style="color:#d1d0cf!important;font-size:10pt!important">Publicat el <?php echo substr($data->data->date_formatted,0,-9); ?></div></h6>
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

			// Prefer the secondary category for related content, but fall back to
			// the primary one when a clip only has a single category (avoids
			// "Undefined array key 1" / null property reads).
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
								<h4 class="main-title">Continguts relacionats</h4>
							</div>
							<div class="continguts-pre">
								<ul class="favorites-slider list-inline  row p-0 mb-0">
									<li class="slide-item">
										<div class="block-images position-relative">
											<div class="img-box">
												<img src="<?php echo $data3->list['0']->img_social; ?>" class="img-fluid">
											</div>
											<div class="block-description" onclick="location.href='./clip/<?php echo $data3->list['0']->id; ?>/<?php echo $data3->list['0']->title_url; ?>'">
												<h6 class="titol"><a href="/clip/<?php echo $data3->list['0']->id; ?>/<?php echo $data3->list['0']->title_url; ?>"><?php echo $data3->list['0']->title; ?></a></h6>
												<div class="capitol d-flex align-items-center my-2">
													<span class="text-white"><?php echo $data3->list['0']->date_formatted; ?></span>
												</div>
											</div>
										</div>
									</li>
									<li class="slide-item">
										<div class="block-images position-relative">
											<div class="img-box">
												<img src="<?php echo $data3->list['1']->img_social; ?>" class="img-fluid">
											</div>
											<div class=" block-description" onclick="location.href='./clip/<?php echo $data3->list['1']->id; ?>/<?php echo $data3->list['1']->title_url; ?>'">
												<h6 class="titol"><a href="/clip/<?php echo $data3->list['1']->id; ?>/<?php echo $data3->list['1']->title_url; ?>"><?php echo $data3->list['1']->title; ?></a></h6>
												<div class="capitol d-flex align-items-center my-2">
													<span class="text-white"><?php echo $data3->list['1']->date_formatted; ?></span>
												</div>
											</div>
										</div>
									</li>
									<li class="slide-item">
										<div class="block-images position-relative">
											<div class="img-box">
												<img src="<?php echo $data3->list['2']->img_social; ?>" class="img-fluid">
											</div>
											<div class="block-description" onclick="location.href='./clip/<?php echo $data3->list['2']->id; ?>/<?php echo $data3->list['2']->title_url; ?>'">
												<h6 class="titol"><a href="/clip/<?php echo $data3->list['2']->id; ?>/<?php echo $data3->list['2']->title_url; ?>"><?php echo $data3->list['2']->title; ?></a></h6>
												<div class="capitol d-flex align-items-center my-2">
													<span class="text-white"><?php echo $data3->list['2']->date_formatted; ?></span>
												</div>
											</div>
										</div>
									</li>
									<li class="slide-item">
										<div class="block-images position-relative">
											<div class="img-box">
												<img src="<?php echo $data3->list['3']->img_social; ?>" class="img-fluid">
											</div>
											<div class="block-description" onclick="location.href='./clip/<?php echo $data3->list['3']->id; ?>/<?php echo $data3->list['3']->title_url; ?>'">
												<h6 class="titol"><a href="/clip/<?php echo $data3->list['3']->id; ?>/<?php echo $data3->list['3']->title_url; ?>"><?php echo $data3->list['3']->title; ?></a></h6>
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
