<?php
	// Search term comes from the header search form (POST). Normalise once and
	// always escape it on output to avoid a reflected-XSS hole and the
	// "Undefined array key" warning when the page is opened without a query.
	$cerca = isset($_POST["cerca"]) ? trim($_POST["cerca"]) : "";
	$cercaSafe = htmlspecialchars($cerca, ENT_QUOTES, 'UTF-8');
?>
<!doctype html>
<html lang="ca">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Cerca: <?php echo $cercaSafe; ?> - UABmèdia</title>
		<meta name="theme-color" content="#141414">
		<meta name="robots" content="noindex">
		<?php
	include './head-import.php';
		?>
	</head>
	<body>
		<?php
		include './plantilla/header.php';
		?>
		<div class="container">
			<h1 class="titol-pagina">Resultats de cerca per: <?php echo $cercaSafe; ?></h1>
			<?php
	include 'config.php';
				$GET_VARS2 = array(
					"go"        => "clips",
					"do"        => "list"
				);

				$POST_VARS = array(
					"sortByFilter"          => "date",
					"search"      			=> $cerca,
					"statusFilter"			=> 1

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
			<style>
				.programa_box h6{
					width: 80%;
					overflow: hidden;
					display: -webkit-box;
					-webkit-line-clamp: 3;
					-webkit-box-orient: vertical;
				}
				.slide-item {
					margin-bottom: 40px;
					padding: 0!important;
				}
			</style>
			<h2 class="titol-seccio">Clips</h2>
			<div class="row">
				<?php for ($i = 0; $i < count($data->list); $i++) { ?>
				<div class="col-12 col-md-4">
					<div class="slide-item">
						<div class="block-images position-relative">
							<div class="img-box">
								<img src="<?php echo $data->list[$i]->img_social; ?>" class="img-fluid" alt="<?php echo $data->list[$i]->title; ?>">
							</div>
							<div class="block-description">
								<h3 class="titol h6">
									<a href="/clip/<?php echo $data->list[$i]->id; ?>/<?php echo $data->list[$i]->title_url; ?>"><?php echo $data->list[$i]->title; ?></a>
								</h3>
								<div class="capitol d-flex align-items-center my-2">
									<div class="badge badge-programa p-1 mr-2">
										<?php echo $data->list[$i]->user_alias; ?>
									</div>
									<span class="text-white">
										<?php echo substr($data->list[$i]->date_formatted, 0, -9); ?>
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
			<?php
			include 'config.php';
			$GET_VARS_news = array(
				"go"        => "news",
				"do"        => "list"
			);

			$POST_VARS_news = array(
				"sortByFilter"          => "date",
				"search"      			=> $cerca,
				"statusFilter"			=> 1
			);

			$REQUEST_URL_news = $API_URL."?".http_build_query($GET_VARS)."&".http_build_query($GET_VARS_news);

			$ch_news = curl_init();
			curl_setopt($ch_news, CURLOPT_URL, $REQUEST_URL_news);
			curl_setopt($ch_news, CURLOPT_POST, true);
			curl_setopt($ch_news, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch_news, CURLOPT_HEADER, false);
			curl_setopt($ch_news, CURLOPT_POSTFIELDS, $POST_VARS_news);

			$response_news = curl_exec($ch_news);

			$data_news = json_decode($response_news);
			?>
			<h2 class="titol-seccio">Notícies</h2>
			<div class="row">
				<?php for ($inews = 0; $inews < count($data_news->list); $inews++) { ?>
				<div class="col-12 col-md-4">
					<div class="slide-item">
						<div class="block-images position-relative">
							<div class="img-box">
								<img src="<?php echo $data_news->list[$inews]->img_social; ?>" class="img-fluid" alt="<?php echo $data_news->list[$inews]->title; ?>">
							</div>
							<div class="block-description">
								<h3 class="titol h6">
									<a href="/noticia/<?php echo $data_news->list[$inews]->id; ?>/<?php echo $data_news->list[$inews]->title_url; ?>"><?php echo $data_news->list[$inews]->title; ?></a>
								</h3>
								<div class="capitol d-flex align-items-center my-2">
									<span class="text-white">
										<?php echo substr($data_news->list[$inews]->date_formatted, 0, -9); ?>
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
			<?php
			include './plantilla/footer.php';
			?>
			<script src="/assets/js/search.js"></script>
		</div>
	</body>
</html>