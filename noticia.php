<?php
include 'config.php';

// "do=get" requests identify the item via the query string (iq); no POST body
// is needed. Defined in global scope so replaceStaffEmbeddedVideos() can reuse it.
$POST_VARS = array();

// Funció per reemplaçar vídeos incrustats de staff.uab.media amb JW Player
function replaceStaffEmbeddedVideos($content) {
	// Patró per coincidir amb iframes incrustats de staff.uab.media
	$pattern = '/<iframe[^>]*src="https:\/\/staff\.uab\.media\/embed\.php\?id=(\d+)"[^>]*>.*?<\/iframe>/i';
	
	return preg_replace_callback($pattern, function($matches) {
		$videoId = $matches[1];
		
		// Obtenir dades del vídeo des de l'API
		global $API_URL, $GET_VARS, $POST_VARS;
		
		$GET_VARS_VIDEO = array(
			"go"        => "clips",
			"do"        => "get",
			"iq"        => $videoId
		);
		
		$REQUEST_URL_VIDEO = $API_URL . "?" . http_build_query($GET_VARS) . "&" . http_build_query($GET_VARS_VIDEO);
		
		$ch_video = curl_init();
		curl_setopt($ch_video, CURLOPT_URL, $REQUEST_URL_VIDEO);
		curl_setopt($ch_video, CURLOPT_POST, true);
		curl_setopt($ch_video, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch_video, CURLOPT_HEADER, false);
		curl_setopt($ch_video, CURLOPT_POSTFIELDS, $POST_VARS);
		
		$response_video = curl_exec($ch_video);
		
		$videoData = json_decode($response_video);
		
		// Si les dades del vídeo estan disponibles, crear JW Player
		if ($videoData && isset($videoData->data) && isset($videoData->media[0])) {
			$uniqueId = 'jwplayer_' . $videoId . '_' . uniqid();
			
			$jwPlayerHtml = '<div id="' . $uniqueId . '" style="width: 100%; height: 225px; margin: 20px 0;"></div>';
			$jwPlayerHtml .= '<script type="text/JavaScript">
				jwplayer("' . $uniqueId . '").setup({ 
					"width": "100%",
					"aspectratio": "16:9",
					"displaytitle": false,
					"displaydescription": false,
					"abouttext": "2024 UABmèdia. Universitat Autònoma de Barcelona",
					"generateSEOMetadata": true,
					"pipIcon": false,
					"playbackRateControls": true,
					"thumbnail_type": "static",
					"file": "' . htmlspecialchars($videoData->media[0]->vod_html5_h264, ENT_QUOTES, 'UTF-8') . '",
					"image": "' . htmlspecialchars($videoData->data->img_poster, ENT_QUOTES, 'UTF-8') . '",
					"title": "' . htmlspecialchars($videoData->data->title, ENT_QUOTES, 'UTF-8') . '",
					"description": "' . htmlspecialchars($videoData->data->description_seo, ENT_QUOTES, 'UTF-8') . '",
					"cast": {},
					"sharing": {
						sites: ["email","facebook","twitter"]
					},
					"ga": {
						"id": "G-ES1G92PJ17",
						"events": {
							"play": true,
							"pause": true,
							"complete": true,
							"seek": true,
							"buffer": true,
							"time": 10
						}
					},
					"controls": true,
					"stretching": "fill",
					"displayPlaybackLabel": true,
					"skin": {
						"name": "seven"
					}							
				});
			</script>';
			
			return $jwPlayerHtml;
		}
		
		// Si les dades del vídeo no estan disponibles, retornar l'iframe original
		return $matches[0];
	}, $content);
}

$GET_VARS2 = array(
	"go"        => "news",
	"do"        => "get"
);
$REQUEST_URL = $API_URL."?".http_build_query($GET_VARS)."&".http_build_query($GET_VARS2);

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
		<meta name="twitter:card" content="summary_large_image">
		<meta name="twitter:site" content="@uabmedia">
		<meta name="twitter:title" content="<?php echo $data->data->title; ?>">
		<meta name="twitter:description" content="<?php echo $data->data->description_seo; ?>">
		<meta name="twitter:image:src" content="<?php echo $data->data->img_social; ?>">
		<meta name="twitter:url" content="https://uab.media/noticia/<?php echo $data->data->id; ?>/<?php echo $data->data->title_url; ?>">
		<meta property="og:site_name" content="UABmèdia" />
		<meta property="og:url" content="https://uab.media/noticia/<?php echo $data->data->id; ?>/<?php echo $data->data->title_url; ?>" />
		<meta property="og:title" content="<?php echo $data->data->title; ?> - UABmèdia" />
		<meta property="og:description" content="<?php echo $data->data->description_seo; ?>" />
		<meta property="og:image" content="<?php echo $data->data->img_social; ?>" />
		<link rel="canonical" href="https://uab.media/noticia/<?php echo $data->data->id; ?>/<?php echo $data->data->title_url; ?>">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
		<?php
		include './head-import.php';
		?>
		<link rel="stylesheet" href="https://uab.media/assets/css/noticia.css" />
		<script type="application/ld+json">
			{
				"@context": "http://schema.org/",
				"@type": "NewsArticle",
				"mainEntityOfPage": {
					"@type": "WebPage",
					"@id": "https://uab.media/noticia/<?php echo $data->data->id; ?>/<?php echo $data->data->title_url; ?>"
				  },
				"headline": "<?php echo $data->data->title; ?>",
				"image": [
					"<?php echo $data->data->img_social; ?>"
				]
			}
		</script>
		<style>

			.button-return{
				border-radius: 25px;
				margin-bottom:20px!important;
				border-color:white;
			}
			.img-small {
				max-width: 50%; /* Ajusta el tamaño máximo de la imagen */
				height: auto; /* Mantiene la proporción de aspecto */
				filter: brightness(100%); /* Ajusta el valor para cambiar el brillo */
			}

		</style>
	</head>
	<body>
		<?php
		include './plantilla/header.php';
		?>
		<div class="contingut">
			<div class="container">
				<div class="row gx-5">
					<div class="col-lg-8 col-sm-12">
						<button class="button-return" onclick="window.history.back();"><span class="material-symbols-outlined">reply</span></button>
						<div class="um-blog-box">
							<h1 class="titol"><?php echo $data->data->title; ?></h1>
							<p class="subtitol"><?php echo $data->data->description_seo; ?></p>
							<br/>
							<?php echo substr($data->data->date_formatted,0,-3); ?> · Per <strong><?php echo $data->data->user_alias; ?></strong><br/><br/>
							<div class="um-blog-image">
								<img src="<?php echo $data->data->img_poster; ?>" >
								<span><?php echo $data->data->img_legend; ?></span>
							</div> 
							<br/><br/>

							<div class="detall-noticia">
								<div class="blog-content">
									<?php echo replaceStaffEmbeddedVideos($data->data->description); ?>
								</div>
							</div>

						</div>
						<br/>																	
					</div>

					<div class="col-lg-4 col-sm-12">
						<div class="widget-area" aria-label="Barra lateral">
							<div class="um-widget-menu darreres-noticies">
								<h2 class="titol-widget">Darreres notícies</h2>
								<?php
								include 'config.php';
								$GET_VARS3 = array(
									"go"        => "news",
									"do"        => "list"
								);

								$POST_VARS3 = array(
									"statusFilter"      => 1
								);

								$REQUEST_URL3 = $API_URL."?".http_build_query($GET_VARS)."&".http_build_query($GET_VARS3);

								$ch3 = curl_init();
								curl_setopt($ch3, CURLOPT_URL, $REQUEST_URL3);
								curl_setopt($ch3, CURLOPT_POST, true);
								curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
								curl_setopt($ch3, CURLOPT_HEADER, false);
								curl_setopt($ch3, CURLOPT_POSTFIELDS, $POST_VARS3);

								$response3 = curl_exec($ch3);

								$data3 = json_decode($response3);
								?>
								<div class="list-inline um-widget-menu">
									<ul class="um-post noticia">
										<li>
											<div class="post-img">
												<div class="post-img-holder">
													<a href="/noticia/<?php echo $data3->list['0']->id; ?>/<?php echo $data3->list['0']->title_url; ?>" style="background-image: url('<?php echo $data3->list['0']->img_poster; ?>');"></a>
												</div>
												<div class="post-blog">
													<div class="blog-box">
														<a href="https://uab.media/noticia/<?php echo $data3->list['0']->id; ?>/<?php echo $data3->list['0']->title_url; ?>">
															<p class="titol"><?php echo $data3->list['0']->title; ?></p>
														</a>
													</div>
												</div>
											</div>
										</li>
										<li>
											<div class="post-img">
												<div class="post-img-holder">
													<a href="https://uab.media/noticia/<?php echo $data3->list['1']->id; ?>/<?php echo $data3->list['1']->title_url; ?>" style="background-image: url('<?php echo $data3->list['1']->img_poster; ?>');"></a>
												</div>
												<div class="post-blog">
													<div class="blog-box">
														<a href="https://uab.media/noticia/<?php echo $data3->list['1']->id; ?>/<?php echo $data3->list['1']->title_url; ?>">

															<p class="titol"><?php echo $data3->list['1']->title; ?></p>
														</a>
													</div>
												</div>
											</div>
										</li>
										<li>
											<div class="post-img">
												<div class="post-img-holder">
													<a href="/noticia/<?php echo $data3->list['2']->id; ?>/<?php echo $data3->list['2']->title_url; ?>" style="background-image: url('<?php echo $data3->list['2']->img_poster; ?>');"></a>
												</div>
												<div class="post-blog">
													<div class="blog-box">
														<a href="/noticia/<?php echo $data3->list['2']->id; ?>/<?php echo $data3->list['2']->title_url; ?>">
															<p class="titol"><?php echo $data3->list['2']->title; ?></p>
														</a>
													</div>
												</div>
											</div>
										</li>
										<li>
											<div class="post-img">
												<div class="post-img-holder">
													<a href="/noticia/<?php echo $data3->list['3']->id; ?>/<?php echo $data3->list['3']->title_url; ?>" style="background-image: url('<?php echo $data3->list['3']->img_poster; ?>');"></a>
												</div>
												<div class="post-blog">
													<div class="blog-box">
														<a href="/noticia/<?php echo $data3->list['3']->id; ?>/<?php echo $data3->list['3']->title_url; ?>">
															<p class="titol"><?php echo $data3->list['3']->title; ?></p>
														</a>
													</div>
												</div>
											</div>
										</li>
										<li>
											<div class="post-img">
												<div class="post-img-holder">
													<a href="/noticia/<?php echo $data3->list['4']->id; ?>/<?php echo $data3->list['4']->title_url; ?>" style="background-image: url('<?php echo $data3->list['4']->img_poster; ?>');"></a>
												</div>
												<div class="post-blog">
													<div class="blog-box">
														<a href="/noticia/<?php echo $data3->list['4']->id; ?>/<?php echo $data3->list['4']->title_url; ?>">
															<p class="titol"><?php echo $data3->list['4']->title; ?></p>
														</a>
													</div>
												</div>
											</div>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
		include './plantilla/footer.php';
		?>
		<script src="/assets/js/search.js"></script>

		<script>
			$(document).ready(function() {
				$('#carouselExampleIndicators').carousel();
			});
		</script>
	</body>
</html>
