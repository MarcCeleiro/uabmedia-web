<?php
include 'config.php';
$GET_VARS2 = array(
	"go"        => "categories",
	"do"        => "get"
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
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title> Programes ARU - UABmèdia</title>
		<meta name="description" content="Els programes de l'ARU, ara al nostre web">
		<meta name="theme-color" content="#141414">
		<meta name="twitter:card" content="summary">
		<meta name="twitter:site" content="@uabmedia">
		<meta name="twitter:title" content="Programes ARU - UABmèdia">
		<meta name="twitter:description" content="Els programes de l'ARU, ara al nostre web">
		<meta name="twitter:image:src" content="https://s3-eu-west-1.amazonaws.com/uabmedia/gallery_images/gallery_280_image_259_1718269037_large.jpg">
		<meta 
			  name="twitter:url" 
			  content="https://uab.media/aru"
		>
		<meta property="og:site_name" content="UABmèdia" />
		<meta property="og:url" content="https://uab.media/aru"/>
		<meta property="og:title" content="Programes ARU - UABmèdia" />
		<meta property="og:description" content="Els informatius i els programes de l'Associació de Ràdios Universitàries a UABmèdia" />
		<meta property="og:image" content="https://s3-eu-west-1.amazonaws.com/uabmedia/gallery_images/gallery_280_image_259_1718269037_large.jpg" />
		<link rel="canonical" href="https://uab.media/aru">
		<link 
			  rel="stylesheet" 
			  href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" 		  />
		
		<?php
		include './head-import.php';
		?>
		<!--Estilo -->
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
		<?php
			include 'config.php';
		
			$GET_VARS3 = array(
				"go"        => "clips",
				"do"        => "list"
			);

			$POST_VARS3 = array(
				"sortByFilter"      => "date",
				"categoriesFilter"  => $data->data->id ?? null,
				"statusFilter"		=> 1,
				"resultsPerPageFilter" => 100,
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
					
		<!--Primera fila --> 
		<div class="contingut">
			<div class="container">
				<br/>
				<br/>
				
				<button class="button-return" onclick="window.history.back();"><a href="/uabradio"><span class="material-symbols-outlined">reply</span></a></button>
				<!--Boton volver 
				<button class="button-return">
					<a href="/uabradio.php">
						<span class="material-symbols-outlined">reply</span>
					</a>
				</button>
				-->

				<br/>
				<!--Logo + Titulo + Icono i descripcion seo con el horario programa + info -->
				<div class="d-flex align-items-center">
					<img style="margin-right:20px;width:120px;border-radius: 50%;" 
						 src="https://s3-eu-west-1.amazonaws.com/uabmedia/gallery_images/gallery_280_image_259_1718269037_large.jpg" 
						 alt="Programes ARU"
					>
					<div>
						<h1 class="trending-text mt-0" style="font-size: 2rem">Programes ARU</h1>
						<a href="https://uab.media/uabradio" style="text-decoration: none;">
							<i class="fa fa-calendar" style="font-size: 2em;"></i> 
						</a>
						<span>Els informatius i els programes de l'Associació de Ràdios Universitàries a UABmèdia</span>
					</div>
				</div>
				<br/><br/>
				
				<h2 class="titol-seccio h3">Capítols</h2><br/>
				<!--viñetas con los clips de los programas -->
				<div class="continguts-pre">
					<div class="row">
                        <div class="col-12 col-md-4">
							<div class="slide-item">
								<div class="block-images position-relative">
									<div class="img-box">
										<a 
										   href="https://go.ivoox.com/rf/149910991">
											<img src="https://s3-eu-west-1.amazonaws.com/uabmedia/gallery_images/gallery_280_image_258_1718268352_large.png" class="img-fluid" alt="">
										</a>
									</div>
									<div class="block-description">
										<h3 class="titol h6">
											<a href="https://go.ivoox.com/rf/149910991"> 
                                            Informativo ARU 10x28- Alimentación, investigaciones y medioambiente</a>										
                                        </h3>
										<div class="capitol d-flex align-items-center my-2">
											<span class="text-white">11/6/2025</span>
										</div>
									</div>
								</div>
							</div>
						</div>
                        <div class="col-12 col-md-4">
							<div class="slide-item">
								<div class="block-images position-relative">
									<div class="img-box">
										<a 
										   href="https://go.ivoox.com/rf/149154501">
											<img src="https://s3-eu-west-1.amazonaws.com/uabmedia/gallery_images/gallery_280_image_258_1718268352_large.png" class="img-fluid" alt="">
										</a>
									</div>
									<div class="block-description">
										<h3 class="titol h6">
											<a href="https://go.ivoox.com/rf/149154501"> 
                                            Informativo ARU 10x27 - Investigación en medicina y jornadas culturales</a>										
                                        </h3>
										<div class="capitol d-flex align-items-center my-2">
											<span class="text-white">4/6/2025</span>
										</div>
									</div>
								</div>
							</div>
						</div>
                        <div class="col-12 col-md-4">
							<div class="slide-item">
								<div class="block-images position-relative">
									<div class="img-box">
										<a 
										   href="https://go.ivoox.com/rf/148723857">
											<img src="https://s3-eu-west-1.amazonaws.com/uabmedia/gallery_images/gallery_280_image_258_1718268352_large.png" class="img-fluid" alt="">
										</a>
									</div>
									<div class="block-description">
										<h3 class="titol h6">
											<a href="https://go.ivoox.com/rf/148723857"> 
                                            Informativo ARU 10x26 - Nuevas instalaciones para la ciencia</a>										
                                        </h3>
										<div class="capitol d-flex align-items-center my-2">
											<span class="text-white">29/5/2025</span>
										</div>
									</div>
								</div>
							</div>
						</div>
                        <div class="col-12 col-md-4">
							<div class="slide-item">
								<div class="block-images position-relative">
									<div class="img-box">
										<a 
										   href="https://go.ivoox.com/rf/147964943">
											<img src="https://s3-eu-west-1.amazonaws.com/uabmedia/gallery_images/gallery_280_image_258_1718268352_large.png" class="img-fluid" alt="">
										</a>
									</div>
									<div class="block-description">
										<h3 class="titol h6">
											<a href="https://go.ivoox.com/rf/147964943"> 
                                            Informativo ARU 10x25 - Gastronomía y comunicación en nuestras universidades</a>										
                                        </h3>
										<div class="capitol d-flex align-items-center my-2">
											<span class="text-white">21/5/2025</span>
										</div>
									</div>
								</div>
							</div>
						</div>
                        <div class="col-12 col-md-4">
							<div class="slide-item">
								<div class="block-images position-relative">
									<div class="img-box">
										<a 
										   href="https://go.ivoox.com/rf/146750339">
											<img src="https://s3-eu-west-1.amazonaws.com/uabmedia/gallery_images/gallery_280_image_258_1718268352_large.png" class="img-fluid" alt="">
										</a>
									</div>
									<div class="block-description">
										<h3 class="titol h6">
											<a href="https://go.ivoox.com/rf/146750339"> 
                                            Informativo ARU 10x24 - La radio, y los medios, en las universidades españolas</a>										
                                        </h3>
										<div class="capitol d-flex align-items-center my-2">
											<span class="text-white">15/5/2025</span>
										</div>
									</div>
								</div>
							</div>
						</div>
                        <div class="col-12 col-md-4">
							<div class="slide-item">
								<div class="block-images position-relative">
									<div class="img-box">
										<a 
										   href="https://go.ivoox.com/rf/146303708">
											<img src="https://s3-eu-west-1.amazonaws.com/uabmedia/gallery_images/gallery_280_image_258_1718268352_large.png" class="img-fluid" alt="">
										</a>
									</div>
									<div class="block-description">
										<h3 class="titol h6">
											<a href="https://go.ivoox.com/rf/146303708">
                                            Informativo ARU 10x23- Jornadas universitarias y estudios de investigación</a>										
                                        </h3>
										<div class="capitol d-flex align-items-center my-2">
											<span class="text-white">7/5/2025</span>
										</div>
									</div>
								</div>
							</div>
						</div>
                        <div class="col-12 col-md-4">
							<div class="slide-item">
								<div class="block-images position-relative">
									<div class="img-box">
										<a 
										   href="https://go.ivoox.com/rf/145922790">
											<img src="https://s3-eu-west-1.amazonaws.com/uabmedia/gallery_images/gallery_280_image_258_1718268352_large.png" class="img-fluid" alt="">
										</a>
									</div>
									<div class="block-description">
										<h3 class="titol h6">
											<a href="https://go.ivoox.com/rf/145922790">
                                            Informativo ARU 10x22 - Ciencia para mejorar el mundo</a>										
                                        </h3>
										<div class="capitol d-flex align-items-center my-2">
											<span class="text-white">30/4/2025</span>
										</div>
									</div>
								</div>
							</div>
						</div>
                        <div class="col-12 col-md-4">
							<div class="slide-item">
								<div class="block-images position-relative">
									<div class="img-box">
										<a 
										   href="https://go.ivoox.com/rf/144742791">
											<img src="https://s3-eu-west-1.amazonaws.com/uabmedia/gallery_images/gallery_280_image_258_1718268352_large.png" class="img-fluid" alt="">
										</a>
									</div>
									<div class="block-description">
										<h3 class="titol h6">
											<a href="https://go.ivoox.com/rf/144742791">
                                            Informativo ARU 10x21- Investigación científica en las universidades españolas</a>
										</h3>
										<div class="capitol d-flex align-items-center my-2">
											<span class="text-white">9/4/2025</span>
										</div>
									</div>
								</div>
							</div>
						</div>
                        <div class="col-12 col-md-4">
							<div class="slide-item">
								<div class="block-images position-relative">
									<div class="img-box">
										<a 
										   href="https://go.ivoox.com/rf/144316784">
											<img src="https://s3-eu-west-1.amazonaws.com/uabmedia/gallery_images/gallery_280_image_258_1718268352_large.png" class="img-fluid" alt="">
										</a>
									</div>
									<div class="block-description">
										<h3 class="titol h6">
											<a href="https://go.ivoox.com/rf/144316784">
                                            Informativo ARU 10x20 - Nuevos estudios, laboratorios y proyectos de investigación</a>										
                                        </h3>
										<div class="capitol d-flex align-items-center my-2">
											<span class="text-white">2/4/2025</span>
										</div>
									</div>
								</div>
							</div>
						</div>
                        <div class="col-12 col-md-4">
							<div class="slide-item">
								<div class="block-images position-relative">
									<div class="img-box">
										<a 
										   href="https://go.ivoox.com/rf/143953538">
											<img src="https://s3-eu-west-1.amazonaws.com/uabmedia/gallery_images/gallery_280_image_258_1718268352_large.png" class="img-fluid" alt="">
										</a>
									</div>
									<div class="block-description">
										<h3 class="titol h6">
											<a href="https://go.ivoox.com/rf/143953538">
                                            Informativo ARU 10x19- De rectorado a la IA pasando por la gastronomía</a>										
										</h3>
										<div class="capitol d-flex align-items-center my-2">
											<span class="text-white">27/3/2025</span>
										</div>
									</div>
								</div>
							</div>
						</div>
                        <div class="col-12 col-md-4">
							<div class="slide-item">
								<div class="block-images position-relative">
									<div class="img-box">
										<a 
										   href="https://go.ivoox.com/rf/143512640">
											<img src="https://s3-eu-west-1.amazonaws.com/uabmedia/gallery_images/gallery_280_image_258_1718268352_large.png" class="img-fluid" alt="">
										</a>
									</div>
									<div class="block-description">
										<h3 class="titol h6">
											<a href="https://go.ivoox.com/rf/143512640">
                                            Informativo ARU 10x18 - Promover la ciencia entre los jóvenes, desde la universidad</a>
										</h3>
										<div class="capitol d-flex align-items-center my-2">
											<span class="text-white">20/3/2025</span>
										</div>
									</div>
								</div>
							</div>
						</div>
                        <div class="col-12 col-md-4">
							<div class="slide-item">
								<div class="block-images position-relative">
									<div class="img-box">
										<a 
										   href="https://go.ivoox.com/rf/141581323">
											<img src="https://s3-eu-west-1.amazonaws.com/uabmedia/gallery_images/gallery_280_image_258_1718268352_large.png" class="img-fluid" alt="">
										</a>
									</div>
									<div class="block-description">
										<h3 class="titol h6">
											<a href="https://go.ivoox.com/rf/141581323">
                                            Informativo ARU 10x17 - Propuestas culturales e investigación en salud</a>
										</h3>
										<div class="capitol d-flex align-items-center my-2">
											<span class="text-white">13/3/2025</span>
										</div>
									</div>
								</div>
							</div>
						</div>
                        <div class="col-12 col-md-4">
							<div class="slide-item">
								<div class="block-images position-relative">
									<div class="img-box">
										<a 
										   href="https://go.ivoox.com/rf/141191352">
											<img src="https://s3-eu-west-1.amazonaws.com/uabmedia/gallery_images/gallery_280_image_258_1718268352_large.png" class="img-fluid" alt="">
										</a>
									</div>
									<div class="block-description">
										<h3 class="titol h6">
											<a href="https://go.ivoox.com/rf/141191352">
                                            Informativo ARU 10x16 - El día de la mujer en las universidades españolas</a>
										</h3>
										<div class="capitol d-flex align-items-center my-2">
											<span class="text-white">6/3/2025</span>
										</div>
									</div>
								</div>
							</div>
						</div>
                        <div class="col-12 col-md-4">
							<div class="slide-item">
								<div class="block-images position-relative">
									<div class="img-box">
										<a 
										   href="https://go.ivoox.com/rf/140615036">
											<img src="https://s3-eu-west-1.amazonaws.com/uabmedia/gallery_images/gallery_280_image_258_1718268352_large.png" class="img-fluid" alt="">
										</a>
									</div>
									<div class="block-description">
										<h3 class="titol h6">
											<a href="https://go.ivoox.com/rf/140615036">
                                            Informativo ARU 10x15 - Jornadas y proyectos en nuestras universidades</a>
										</h3>
										<div class="capitol d-flex align-items-center my-2">
											<span class="text-white">27/2/2025</span>
										</div>
									</div>
								</div>
							</div>
						</div>
                        <div class="col-12 col-md-4">
							<div class="slide-item">
								<div class="block-images position-relative">
									<div class="img-box">
										<a 
										   href="https://go.ivoox.com/rf/140183689">
											<img src="https://s3-eu-west-1.amazonaws.com/uabmedia/gallery_images/gallery_280_image_258_1718268352_large.png" class="img-fluid" alt="">
										</a>
									</div>
									<div class="block-description">
										<h3 class="titol h6">
											<a href="https://go.ivoox.com/rf/140183689">
                                            Informativo ARU 10x14 - El papel de la mujer y niña en la ciencia, desde ARU</a>
										</h3>
										<div class="capitol d-flex align-items-center my-2">
											<span class="text-white">19/2/2025</span>
										</div>
									</div>
								</div>
							</div>
						</div>
                        <div class="col-12 col-md-4">
							<div class="slide-item">
								<div class="block-images position-relative">
									<div class="img-box">
										<a 
										   href="https://www.rtve.es/play/audios/informativo-aru-en-radio-exterior-de-espana/informativo-aru-ree-dia-mundial-radio-emisoras-aru/16448543/">
											<img src="https://s3-eu-west-1.amazonaws.com/uabmedia/gallery_images/gallery_280_image_258_1718268352_large.png" class="img-fluid" alt="">
										</a>
									</div>
									<div class="block-description">
										<h3 class="titol h6">
											<a href="https://www.rtve.es/play/audios/informativo-aru-en-radio-exterior-de-espana/informativo-aru-ree-dia-mundial-radio-emisoras-aru/16448543/">
                                            Informativo ARU 10x13 - Día mundial de la radio en las emisoras de ARU</a>
										</h3>
										<div class="capitol d-flex align-items-center my-2">
											<span class="text-white">16/2/2025</span>
										</div>
									</div>
								</div>
							</div>
						</div>
                        <div class="col-12 col-md-4">
							<div class="slide-item">
								<div class="block-images position-relative">
									<div class="img-box">
										<a 
										   href="https://go.ivoox.com/rf/139425083">
											<img src="https://s3-eu-west-1.amazonaws.com/uabmedia/gallery_images/gallery_280_image_258_1718268352_large.png" class="img-fluid" alt="">
										</a>
									</div>
									<div class="block-description">
										<h3 class="titol h6">
											<a href="https://go.ivoox.com/rf/139425083">
                                            Informativo ARU 10x12 - Concursos, becas y premios de cultura e investigación</a>
										</h3>
										<div class="capitol d-flex align-items-center my-2">
											<span class="text-white">6/2/2025</span>
										</div>
									</div>
								</div>
							</div>
						</div>
                        <div class="col-12 col-md-4">
							<div class="slide-item">
								<div class="block-images position-relative">
									<div class="img-box">
										<a 
										   href="https://go.ivoox.com/rf/138982424">
											<img src="https://s3-eu-west-1.amazonaws.com/uabmedia/gallery_images/gallery_280_image_258_1718268352_large.png" class="img-fluid" alt="">
										</a>
									</div>
									<div class="block-description">
										<h3 class="titol h6">
											<a href="https://go.ivoox.com/rf/138982424">
                                            Informativo ARU 10x11 - Acuerdos, premios y proyectos de investigación</a>
										</h3>
										<div class="capitol d-flex align-items-center my-2">
											<span class="text-white">29/1/2025</span>
										</div>
									</div>
								</div>
							</div>
						</div>
                        <div class="col-12 col-md-4">
							<div class="slide-item">
								<div class="block-images position-relative">
									<div class="img-box">
										<a 
										   href="https://go.ivoox.com/rf/138024095">
											<img src="https://s3-eu-west-1.amazonaws.com/uabmedia/gallery_images/gallery_280_image_258_1718268352_large.png" class="img-fluid" alt="">
										</a>
									</div>
									<div class="block-description">
										<h3 class="titol h6">
											<a href="https://go.ivoox.com/rf/138024095">
                                            Informativo ARU 10x10 - Liderazgo juvenil, animación 3D y stop motion</a>
										</h3>
										<div class="capitol d-flex align-items-center my-2">
											<span class="text-white">22/1/2025</span>
										</div>
									</div>
								</div>
							</div>
						</div>
                        <div class="col-12 col-md-4">
							<div class="slide-item">
								<div class="block-images position-relative">
									<div class="img-box">
										<a 
										   href="https://go.ivoox.com/rf/137799200">
											<img src="https://s3-eu-west-1.amazonaws.com/uabmedia/gallery_images/gallery_280_image_258_1718268352_large.png" class="img-fluid" alt="">
										</a>
									</div>
									<div class="block-description">
										<h3 class="titol h6">
											<a href="https://go.ivoox.com/rf/137799200">
                                            Informativo ARU 10x09- Proyectos innovadores en torno al cáncer o la anatomía</a>
										</h3>
										<div class="capitol d-flex align-items-center my-2">
											<span class="text-white">17/1/2025</span>
										</div>
									</div>
								</div>
							</div>
						</div>
                        <div class="col-12 col-md-4">
							<div class="slide-item">
								<div class="block-images position-relative">
									<div class="img-box">
										<a 
										   href="https://go.ivoox.com/rf/136562720">
											<img src="https://s3-eu-west-1.amazonaws.com/uabmedia/gallery_images/gallery_280_image_258_1718268352_large.png" class="img-fluid" alt="">
										</a>
									</div>
									<div class="block-description">
										<h3 class="titol h6">
											<a href="https://go.ivoox.com/rf/136562720">
                                            Informativo ARU 10x05-Tortugas, transporte sostenible e igualdad - 6 de Diciembre</a>
										</h3>
										<div class="capitol d-flex align-items-center my-2">
											<span class="text-white">6/12/2024</span>
										</div>
									</div>
								</div>
							</div>
						</div>
                        <div class="col-12 col-md-4">
							<div class="slide-item">
								<div class="block-images position-relative">
									<div class="img-box">
										<a 
										   href="https://go.ivoox.com/rf/136104472">
											<img src="https://s3-eu-west-1.amazonaws.com/uabmedia/gallery_images/gallery_280_image_258_1718268352_large.png" class="img-fluid" alt="">
										</a>
									</div>
									<div class="block-description">
										<h3 class="titol h6">
											<a href="https://go.ivoox.com/rf/136104472">
                                            Informativo ARU 10x03- 22 Noviembre 24- Sostenibilidad, innovación, periodismo y más radio</a>
										</h3>
										<div class="capitol d-flex align-items-center my-2">
											<span class="text-white">22/11/2024</span>
										</div>
									</div>
								</div>
							</div>
						</div>
                        <div class="col-12 col-md-4">
							<div class="slide-item">
								<div class="block-images position-relative">
									<div class="img-box">
										<a 
										   href="https://go.ivoox.com/rf/135907853">
											<img src="https://s3-eu-west-1.amazonaws.com/uabmedia/gallery_images/gallery_280_image_258_1718268352_large.png" class="img-fluid" alt="">
										</a>
									</div>
									<div class="block-description">
										<h3 class="titol h6">
											<a href="https://go.ivoox.com/rf/135907853">
                                            Informativo ARU 10x02- 15 Noviembre 24: Encuentro ARU. Solidaridad con la Dana</a>
										</h3>
										<div class="capitol d-flex align-items-center my-2">
											<span class="text-white">15/11/2024</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-4">
							<div class="slide-item">
								<div class="block-images position-relative">
									<div class="img-box">
										<a 
										   href="https://go.ivoox.com/rf/130287962">
											<img src="https://s3-eu-west-1.amazonaws.com/uabmedia/gallery_images/gallery_280_image_258_1718268352_large.png" class="img-fluid" alt="">
										</a>
									</div>
									<div class="block-description">
										<h3 class="titol h6">
											<a href="https://go.ivoox.com/rf/130287962">
												Informativo ARU 9x14- 16 de Junio: Astrofísica, premios y agroturismo</a>
										</h3>
										<div class="capitol d-flex align-items-center my-2">
											<span class="text-white">13/06/2024</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-4">
							<div class="slide-item">
								<div class="block-images position-relative">
									<div class="img-box">
										<a 
										   href="https://go.ivoox.com/rf/129966129">
											<img src="https://s3-eu-west-1.amazonaws.com/uabmedia/gallery_images/gallery_280_image_258_1718268352_large.png" class="img-fluid" alt="">
										</a>
									</div>
									<div class="block-description">
										<h3 class="titol h6">
											<a href="https://go.ivoox.com/rf/129966129">
												Informativo ARU 9x13- 9 de Junio: EBAU, Cáncer y sostenibilidad</a>
										</h3>
										<div class="capitol d-flex align-items-center my-2">
											<span class="text-white">06/06/2024</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-4">
							<div class="slide-item">
								<div class="block-images position-relative">
									<div class="img-box">
										<a 
										   href="https://go.ivoox.com/rf/129634230">
											<img src="https://s3-eu-west-1.amazonaws.com/uabmedia/gallery_images/gallery_280_image_258_1718268352_large.png" class="img-fluid" alt="">
										</a>
									</div>
									<div class="block-description">
										<h3 class="titol h6">
											<a href="https://go.ivoox.com/rf/129634230">
												Informativo ARU 9x12- 2 de junio- EBAU, Obesidad, madres y educación</a>
										</h3>
										<div class="capitol d-flex align-items-center my-2">
											<span class="text-white">30/05/2024</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-4">
							<div class="slide-item">
								<div class="block-images position-relative">
									<div class="img-box">
										<a 
										   href="https://go.ivoox.com/rf/124115612">
											<img src="https://s3-eu-west-1.amazonaws.com/uabmedia/gallery_images/gallery_280_image_258_1718268352_large.png" class="img-fluid" alt="">
										</a>
									</div>
									<div class="block-description">
										<h3 class="titol h6">
											<a href="https://go.ivoox.com/rf/124115612">
												Informativo ARU 9x11- 26 de Mayo- Ciberseguridad, amor y África</a>
										</h3>
										<div class="capitol d-flex align-items-center my-2">
											<span class="text-white">23/05/2024</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-4">
							<div class="slide-item">
								<div class="block-images position-relative">
									<div class="img-box">
										<a 
										   href="https://go.ivoox.com/rf/124115612">
											<img src="https://s3-eu-west-1.amazonaws.com/uabmedia/gallery_images/gallery_280_image_258_1718268352_large.png" class="img-fluid" alt="">
										</a>
									</div>
									<div class="block-description">
										<h3 class="titol h6">
											<a href="https://go.ivoox.com/rf/124115612">
												Informativo ARU 9x10- 19 de Mayo- Sostenibilidad, agua y globalidad</a>
										</h3>
										<div class="capitol d-flex align-items-center my-2">
											<span class="text-white">16/05/2024</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-4">
							<div class="slide-item">
								<div class="block-images position-relative">
									<div class="img-box">
										<a 
										   href="https://go.ivoox.com/rf/124115612">
											<img src="https://s3-eu-west-1.amazonaws.com/uabmedia/gallery_images/gallery_280_image_258_1718268352_large.png" class="img-fluid" alt="">
										</a>
									</div>
									<div class="block-description">
										<h3 class="titol h6">
											<a href="https://go.ivoox.com/rf/124115612">
												Informativo ARU 9x09- 12 de Mayo- Dietas, dopaje y células</a>
										</h3>
										<div class="capitol d-flex align-items-center my-2">
											<span class="text-white">10/05/2024</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-4">
							<div class="slide-item">
								<div class="block-images position-relative">
									<div class="img-box">
										<a 
										   href="https://go.ivoox.com/rf/128393085">
											<img src="https://s3-eu-west-1.amazonaws.com/uabmedia/gallery_images/gallery_280_image_258_1718268352_large.png" class="img-fluid" alt="">
										</a>
									</div>
									<div class="block-description">
										<h3 class="titol h6">
											<a href="https://go.ivoox.com/rf/128393085">
												Informativo ARU 9x08- 5 de Mayo- Biodiversidad, voz y lucha
</a>
										</h3>
										<div class="capitol d-flex align-items-center my-2">
											<span class="text-white">03/05/2024</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-4">
							<div class="slide-item">
								<div class="block-images position-relative">
									<div class="img-box">
										<a 
										   href="https://go.ivoox.com/rf/128077250">
											<img src="https://s3-eu-west-1.amazonaws.com/uabmedia/gallery_images/gallery_280_image_258_1718268352_large.png" class="img-fluid" alt="">
										</a>
									</div>
									<div class="block-description">
										<h3 class="titol h6">
											<a href="https://go.ivoox.com/rf/128077250">
												Informativo ARU 9x07- 28 DE ABRIL- Marketing, igualdad y voluntariado</a>
										</h3>
										<div class="capitol d-flex align-items-center my-2">
											<span class="text-white">26/04/2024</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-4">
							<div class="slide-item">
								<div class="block-images position-relative">
									<div class="img-box">
										<a 
										   href="https://go.ivoox.com/rf/127728869">
											<img src="https://s3-eu-west-1.amazonaws.com/uabmedia/gallery_images/gallery_280_image_258_1718268352_large.png" class="img-fluid" alt="">
										</a>
									</div>
									<div class="block-description">
										<h3 class="titol h6">
											<a href="https://go.ivoox.com/rf/127728869">
												Informativo ARU 9x06- 21 DE ABRIL- Hospital de peluche y educación</a>
										</h3>
										<div class="capitol d-flex align-items-center my-2">
											<span class="text-white">18/04/2024</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-4">
							<div class="slide-item">
								<div class="block-images position-relative">
									<div class="img-box">
										<a 
										   href="https://go.ivoox.com/rf/127439705">
											<img src="https://s3-eu-west-1.amazonaws.com/uabmedia/gallery_images/gallery_280_image_258_1718268352_large.png" class="img-fluid" alt="">
										</a>
									</div>
									<div class="block-description">
										<h3 class="titol h6">
											<a href="https://go.ivoox.com/rf/127439705">
												Informativo ARU 9x05- IA, fisioterapia y PAZ</a>
										</h3>
										<div class="capitol d-flex align-items-center my-2">
											<span class="text-white">12/04/2024</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-4">
							<div class="slide-item">
								<div class="block-images position-relative">
									<div class="img-box">
										<a 
										   href="https://go.ivoox.com/rf/127062046">
											<img src="https://s3-eu-west-1.amazonaws.com/uabmedia/gallery_images/gallery_280_image_258_1718268352_large.png" class="img-fluid" alt="">
										</a>
									</div>
									<div class="block-description">
										<h3 class="titol h6">
											<a href="https://go.ivoox.com/rf/127062046">
												Informativo ARU 9x04- Boom digital</a>
										</h3>
										<div class="capitol d-flex align-items-center my-2">
											<span class="text-white">05/04/2024</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-4">
							<div class="slide-item">
								<div class="block-images position-relative">
									<div class="img-box">
										<a 
										   href="https://go.ivoox.com/rf/126315317">
											<img src="https://s3-eu-west-1.amazonaws.com/uabmedia/gallery_images/gallery_280_image_258_1718268352_large.png" class="img-fluid" alt="">
										</a>
									</div>
									<div class="block-description">
										<h3 class="titol h6">
											<a href="https://go.ivoox.com/rf/126315317">
												Informativo ARU 9x03- 24 de Marzo 2024</a>
										</h3>
										<div class="capitol d-flex align-items-center my-2">
											<span class="text-white">22/03/2024</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-4">
							<div class="slide-item">
								<div class="block-images position-relative">
									<div class="img-box">
										<a 
										   href="https://go.ivoox.com/rf/125930524">
											<img src="https://s3-eu-west-1.amazonaws.com/uabmedia/gallery_images/gallery_280_image_258_1718268352_large.png" class="img-fluid" alt="">
										</a>
									</div>
									<div class="block-description">
										<h3 class="titol h6">
											<a href="https://go.ivoox.com/rf/125930524">
												Informativo ARU 9x02- 17 de Marzo. Actualidad y divulgación universitaria</a>
										</h3>
										<div class="capitol d-flex align-items-center my-2">
											<span class="text-white">15/03/2024</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-4">
							<div class="slide-item">
								<div class="block-images position-relative">
									<div class="img-box">
										<a 
										   href="https://go.ivoox.com/rf/125540929">
											<img src="https://s3-eu-west-1.amazonaws.com/uabmedia/gallery_images/gallery_280_image_258_1718268352_large.png" class="img-fluid" alt="">
										</a>
									</div>
									<div class="block-description">
										<h3 class="titol h6">
											<a href="https://go.ivoox.com/rf/125540929">
												Informativo ARU 9x01- Especial 8M</a>
										</h3>
										<div class="capitol d-flex align-items-center my-2">
											<span class="text-white">08/03/2024</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-4">
							<div class="slide-item">
								<div class="block-images position-relative">
									<div class="img-box">
										<a 
										   href="https://go.ivoox.com/rf/124115612">
											<img src="https://s3-eu-west-1.amazonaws.com/uabmedia/gallery_images/gallery_280_image_258_1718268352_large.png" class="img-fluid" alt="">
										</a>
									</div>
									<div class="block-description">
										<h3 class="titol h6">
											<a href="https://go.ivoox.com/rf/124115612">
												Especial - Dia mundial de la ràdio</a>
										</h3>
										<div class="capitol d-flex align-items-center my-2">
											<span class="text-white">12/02/2024</span>
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
	</body>
</html>