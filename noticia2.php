<?php
include 'config.php';
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
									<?php echo $data->data->description; ?>
								</div>
							</div>

						</div>
						<br/>																	
					</div>

					<div class="col-lg-4 col-sm-12">
						<div class="widget-area" aria-label="Barra lateral">
							<div class="um-widget-menu darreres-noticies">
								<h5 class="titol-widget">Darreres notícies</h5>
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
		<script>
			//esconder PEUDIRECTE cuando le das al pause en una pagina que no es el index.php
			document.addEventListener("DOMContentLoaded", function() {
				// Obtener referencia al botón y al div
				var pause_btn = document.getElementById("pause_btn");
				var peudirecte = document.getElementById("peudirecte");

				// Manejar el clic en el botón
				pause_btn.addEventListener("click", function() {
					// Cambiar la visibilidad del div
					if (peudirecte.style.display === "none") {
						peudirecte.style.display = "block";
					} else {
						peudirecte.style.display = "none";
					}
				});
			}); </script>
		<script src="/assets/js/search.js"></script>
		<script src="/assets/js/popper.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

		<script>
			$(document).ready(function() {
				$('#carouselExampleIndicators').carousel();
			});
		</script>
	</body>
</html>
