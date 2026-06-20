<?php
include(dirname(__DIR__).'/config.php');
$GET_VARS2 = array(
	"go"        => "categories",
	"do"        => "get",
	"iq"        => 92
);

$POST_VARS = array(
	"statusFilter" => 1,
	"resultsPerPageFilter" => 100,
);

$REQUEST_URL = $API_URL . "?" . http_build_query($GET_VARS) . "&" . http_build_query($GET_VARS2);

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
		<!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
															  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
				j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
					'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
									})(window,document,'script','dataLayer','GTM-5MVV29M');</script>
		<!-- End Google Tag Manager -->
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Notícies de Centenari de la Ràdio - Actualitat - UABmèdia</title>
		<meta name="description" content="<?php echo $data->data->description_seo; ?>">
		<meta name="theme-color" content="#141414">
		<meta name="twitter:card" content="summary">
		<meta name="twitter:site" content="@uabmedia">
		<meta name="twitter:title" content="<?php echo $data->data->title; ?> - UABmèdia">
		<meta name="twitter:description" content="<?php echo $data->data->description_seo; ?>">
		<meta name="twitter:image:src" content="<?php echo $data->data->img_social; ?>">
		<meta name="twitter:url" content="https://uab.media/noticies/ciencia">
		<meta property="og:site_name" content="UABmèdia" />
		<meta property="og:url" content="https://uab.media/noticies/ciencia" />
		<meta property="og:title" content="<?php echo $data->data->title; ?> - UABmèdia" />
		<meta property="og:description" content="<?php echo $data->data->description_seo; ?>" />
		<meta property="og:image" content="<?php echo $data->data->img_social; ?>" />
		<link rel="canonical" href="https://uab.media/noticies/ciencia">
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://s3-eu-west-1.amazonaws.com">
		<link rel="shortcut icon" href="https://uab.media/assets/images/favicon.png" />
		<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.min.css" rel="stylesheet">
		<link rel="stylesheet" href="https://uab.media/assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="https://uab.media/assets/css/typography.css">
		<link rel="stylesheet" href="https://uab.media/assets/css/style.css" />
		<link rel="stylesheet" href="https://uab.media/assets/css/responsive.css" />
		<style>
			.targeta {
				padding: 0px 0px !important;
			}
		</style>
		<?php
		include '../head-import.php';
		?>
	</head>

	<body>
		<!-- Google Tag Manager (noscript) -->
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5MVV29M"
						  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<!-- End Google Tag Manager (noscript) -->
		<?php
		//include(dirname(__DIR__).'/plantilla/header.php');
		//include(`../plantilla/header.php');
		include('../plantilla/header.php');
		?>

		<div class="contingut">
			<div class="container">
				<section id="header">
					<div class="row">
						<div class="col-12 overflow-hidden amaga-mobil">
							<div class="um-capcalera d-flex align-items-center">
								<h1 class="titol-principal titol-capcelera" style="font-size: 2.369em;line-height: 0.8!important">Notícies de Centenari de la Ràdio</h1>
							</div>
						</div>
						<section> 
							<div class="container">
								<div class="row">
									<div class="col-0"></div>
									<div class="col-4 amaga-mobil" style="margin-bottom: 2%;padding-left:0!important;" >
										<nav class="navbar navbar-expand-lg text-light">
											<!--<a class="navbar-brand" href="#">Navbar</a>-->
											<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
												<span class="navbar-toggler-icon"></span>
											</button>
											<div class="collapse navbar-collapse text-light" id="navbarNavDropdown">
												<ul class="navbar-nav">
													<li class="nav-item" style="margin-right: 20px">
														<a class="nav-link text-light" href="https://uab.media/programa/2/informatius">Informatius</a>
													</li>
													<li class="nav-item dropdown" style="margin-right: 20px">
														<a class="nav-link dropdown-toggle text-light" class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
															Notícies
														</a>
														<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
															<a class="dropdown-item" href="https://uab.media/noticies/campus">Campus</a>
                                                            <a class="dropdown-item" href="https://uab.media/noticies/centenari">Centenari de la Ràdio</a>
															<a class="dropdown-item" href="https://uab.media/noticies/cultura-i-mitjans">Cultura i Mitjans</a>
                                                            <a class="dropdown-item" href="https://uab.media/noticies/societat">Societat</a>
															<a class="dropdown-item" href="https://uab.media/noticies/igualtat">Igualtat</a>
                                                            <a class="dropdown-item" href="https://uab.media/noticies/ciencia-i-salut">Ciència i Salut</a>
															<a class="dropdown-item" href="https://uab.media/noticies/medi-ambient">Medi Ambient i Sostenibilitat</a>
															<a class="dropdown-item" href="https://uab.media/noticies/tecnologia-i-innovacio">Tecnologia i Innovació</a>
															<a class="dropdown-item" href="https://uab.media/noticies/mes-actualitat">+ Actualitat</a>
														</div>
													</li>
													<li class="nav-item" style="margin-right: 20px">
														<a class="nav-link text-light" href="https://uab.media/noticies/opinio">Opinió</a>
													</li>
												</ul>
											</div>
										</nav>
									</div>
								</div>
							</div>
						</section>
					</div>
				</section>
				<style>
					.programa_box h6{
						width: 80%;
						overflow: hidden;
						display: -webkit-box;
						display:-webkit-line-clamp: 3;
						display:-webkit-box-orient: vertical;
					}
					.targeta {
						margin-bottom: 40px;
					}
				</style>
				<div class="um-capcalera d-flex align-items-center">
				</div>
				<section>
					<?php
					include(dirname(__DIR__).'/config.php');

					$GET_VARS_centenari = array(
						"go" => "news",
						"do" => "list"
					);

					$POST_VARS_centenari = array(
						"statusFilter" => 1,
						"resultsPerPageFilter" => 30,
						"categoriesFilter" => 92,
						"categoriesFilterStrict" => 1
					);

					$REQUEST_URL_centenari = $API_URL . "?" . http_build_query($GET_VARS) . "&" . http_build_query($GET_VARS_centenari);

					$ch_centenari = curl_init();
					curl_setopt($ch_centenari, CURLOPT_URL, $REQUEST_URL_centenari);
					curl_setopt($ch_centenari, CURLOPT_POST, true);
					curl_setopt($ch_centenari, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch_centenari, CURLOPT_HEADER, false);
					curl_setopt($ch_centenari, CURLOPT_POSTFIELDS, $POST_VARS_centenari);

					$response_centenari = curl_exec($ch_centenari);

					$data_centenari = json_decode($response_centenari);
					?>
					<div>
<br />


						<div data-aos="zoom-in" class="row">


							<?php

							for ($i = 0; $i < count($data_centenari->list); $i++) {
							?>
							<a class="col-12 col-md-4 noticia-petita" href="/noticia/<?php echo $data_centenari->list[$i]->id; ?>/<?php echo $data_centenari->list[$i]->title_url; ?>">
								<img class="imatge-destacada" src="<?php echo $data_centenari->list[$i]->img_poster; ?>" alt="<?php echo $data_centenari->list[$i]->title; ?>">
								<div class="contingut-noticia">
									<h2 class="titol"><?php echo $data_centenari->list[$i]->title; ?></h2>
									<p class="data"><?php echo substr($data_centenari->list[$i]->date_formatted, 0, -9); ?></p>
								</div>
							</a>
							<?php } ?>
						</div>		
					</div>
				</section>
				<br/><br />
			</div>
		</div>
		<!--</div>
	</section>
</div>
</div>-->
	<?php
	//include(dirname(__DIR__).'/plantilla/footer.php');
	include ('../plantilla/footer.php');
	?>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.min.js"></script>
<script>
	AOS.init({
		duration: 500
	});
</script>
</body>

</html>