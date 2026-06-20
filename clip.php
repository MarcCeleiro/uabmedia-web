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
		<title><?php echo htmlspecialchars($data->data->title, ENT_QUOTES, 'UTF-8'); ?> - UABmèdia</title>
		<meta name="description" content="<?php echo $data->data->description_seo; ?>">
		<meta name="theme-color" content="#141414">
		<meta name="twitter:card" content="player">
		<meta name="twitter:site" content="@uabmedia">
		<meta name="twitter:title" content="<?php echo htmlspecialchars($data->data->title, ENT_QUOTES, 'UTF-8'); ?> - UABmèdia">
		<meta name="twitter:description" content="<?php echo $data->data->description_seo; ?>">
		<meta name="twitter:image" content="<?php echo $data->data->img_social; ?>">
		<meta name="twitter:url" content="https://uab.media/clip/<?php echo $data->data->id; ?>/<?php echo $data->data->title_url; ?>">
		<meta property="og:site_name" content="UABmèdia" />
		<meta property="og:url" content="https://uab.media/clip/<?php echo $data->data->id; ?>/<?php echo $data->data->title_url; ?>" />
		<meta property="og:title" content="<?php echo htmlspecialchars($data->data->title, ENT_QUOTES, 'UTF-8'); ?> - UABmèdia" />
		<meta property="og:description" content="<?php echo $data->data->description_seo; ?>" />
		<meta property="og:image" content="<?php echo $data->data->img_social; ?>" />
		<link rel="canonical" href="https://uab.media/clip/<?php echo $data->data->id; ?>/<?php echo $data->data->title_url; ?>">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
		<?php
		include './head-import.php';
		?>
		<script type="application/ld+json">
        {
        "@context":"http://schema.org/",
        "@type":"VideoObject",
        "name":"<?php echo $data->data->title; ?>",
        "description":"<?php echo $data->data->description_seo; ?>",
        "thumbnailUrl":"<?php echo $data->data->img_social; ?>",
        "@id":"https://uab.media/clip/<?php echo $data->data->id; ?>/<?php echo $data->data->title_url; ?>",
		"uploadDate":"<?php echo $data->data->date_formatted; ?>"
        }
		</script>
		<style>
			@media(max-width:991px) {
				h3 {
					font-size: 1.600em;
				}
			}
			.targeta {
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
			.targeta {
				margin-bottom: 40px;
			}
		</style>
	</head>

	<body>
		<?php
		include './plantilla/header.php';
		?>

		<div class="container">
			<button class="button-return" onclick="window.history.back();"><span class="material-symbols-outlined">reply</span></button>
			<!--Fila amb 2 columnes amb reproductor i descripció-->
			<div class="row gx-5">
				<!--Columna Botó tornar + reproductor-->
				<div class="col-12 col-md-12 col-lg-8">				
					<!--Reproductor de vídeo -->
					<div id="reproductor"></div>
					<script type="text/JavaScript">
						jwplayer("reproductor").setup({ 
							"width": "100%",
							"aspectratio": "16:9",
							"displaytitle": false,
							"displaydescription": false,
							"abouttext": "2024 UABmèdia. Universitat Autònoma de Barcelona",
							"generateSEOMetadata": true,
							"pipIcon": false,
							"playbackRateControls": true,
							"thumbnail_type": "static",
							"file": "<?php echo $data->media['0']->vod_html5_h264; ?>",
							"image": "<?php echo $data->data->img_poster; ?>",
							"title": "<?php echo htmlspecialchars($data->data->title, ENT_QUOTES, 'UTF-8'); ?>",
							"description": "<?php echo $data->data->description_seo; ?>",
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
					</script>
					<br/>
				</div>
				<div class="col-12 col-md-12 col-lg-4">

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

					<h1 class="titol-destacat mt-0 titol-detall">
						<?php echo htmlspecialchars($data->data->title, ENT_QUOTES, 'UTF-8'); ?>
					</h1>
					<div class="d-flex align-items-center meta-clip">
						<img 
							 class="avatar-autor" 
							 src="<?php echo $data_usuari->data->img_social; ?>" 
							 alt="<?php echo $data->categories['0']->title; ?>"
							 >
						<h2 class="h6">
							<strong><?php echo $data->categories['0']->title; ?></strong>
							<br/>
							<div class="meta-categoria">
								Publicat el <?php echo substr($data->data->date_formatted,0,-9); ?>
							</div>
						</h2>
					</div>
					<p><?php echo $data->data->description; ?></p>
				</div>
			</div>
			<div class="row">
			</div>	
		</div>
		<?php
		include './plantilla/footer.php';
		?>
	</body>
</html>