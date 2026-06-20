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
	<title><?php echo $data->data->title; ?> - UABmèdia</title>
	<meta name="description" content="<?php echo $data->data->description_seo; ?>">
	<meta name="theme-color" content="#141414">
	<meta name="twitter:card" content="summary">
	<meta name="twitter:site" content="@uabmedia">
	<meta name="twitter:title" content="<?php echo $data->data->title; ?> - UABmèdia">
	<meta name="twitter:description" content="<?php echo $data->data->description_seo; ?>">
	<meta name="twitter:image:src" content="<?php echo $data->data->img_social; ?>">
	<meta name="twitter:url" content="https://uab.media/programa/<?php echo $data->data->id; ?>/<?php echo $data->data->title_url; ?>">
	<meta property="og:site_name" content="UABmèdia" />
	<meta property="og:url" content="https://uab.media/programa/<?php echo $data->data->id; ?>/<?php echo $data->data->title_url; ?>" />
	<meta property="og:title" content="<?php echo $data->data->title; ?> - UABmèdia" />
	<meta property="og:description" content="<?php echo $data->data->description_seo; ?>" />
	<meta property="og:image" content="<?php echo $data->data->img_social; ?>" />
	<link rel="canonical" href="https://uab.media/programa/<?php echo $data->data->id; ?>/<?php echo $data->data->title_url; ?>">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://s3-eu-west-1.amazonaws.com">
	<link rel="shortcut icon" href="https://uab.media/assets/images/favicon.png" />
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	<link rel="stylesheet" href="https://uab.media/assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="https://uab.media/assets/css/typography.css">
	<link rel="stylesheet" href="https://uab.media/assets/css/style.css" />
	<link rel="stylesheet" href="https://uab.media/assets/css/responsive.css" />
	<style>
		.slide-item {
			padding: 0px 0px !important;
		}
	</style>
</head>

<body>
	<?php
  include './plantilla/header.php';
  ?>
	
	<div class="contingut">
		<!--<section id="portada">
			<img width="100%" height="450" src="https://uab.media/assets/portades/<?php echo $data->data->id; ?>.png" alt="Portada del programa <?php echo $data->data->title; ?>">
		</section>-->
		<br />
		<div class="container">
			
			<section id="llista-horitzontal">
				<div class="container-fluid">
					<div class="row">
						<div class="col-sm-12 overflow-hidden">
							<!--<div class="um-capcalera d-flex align-items-center">
								<img style="margin-right:30px;width:80px;border-radius: 50%;" src="<?php echo $data->data->img_social; ?>" alt="<?php echo $data->data->title; ?>">
								<h1 style="font-size:2.2em!important;line-height: 0.9!important"><?php echo $data->data->title; ?><br><span style="font-size:14px!important;line-height: 0.9!important"><?php echo $data->data->description_seo; ?></span></h1>
							</div>-->
							<br />
							<!--<section id="noticies">
				<?php
				include 'config.php';
				$GET_VARS_NEWS = array(
					"go"        => "news",
					"do"        => "list"
				);

				$POST_VARS_NEWS = array(
					"statusFilter" => 1,
					"categoriesFilter" => $data->data->id,
					"resultsPerPageFilter" => 4
				);

				$REQUEST_URL_NEWS = $API_URL . "?" . http_build_query($GET_VARS) . "&" . http_build_query($GET_VARS_NEWS);

				$ch_NEWS = curl_init();
				curl_setopt($ch_NEWS, CURLOPT_URL, $REQUEST_URL_NEWS);
				curl_setopt($ch_NEWS, CURLOPT_POST, true);
				curl_setopt($ch_NEWS, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch_NEWS, CURLOPT_HEADER, false);
				curl_setopt($ch_NEWS, CURLOPT_POSTFIELDS, $POST_VARS_NEWS);

				$response_NEWS = curl_exec($ch_NEWS);

				$data_NEWS = json_decode($response_NEWS);
				?>
				<div class="um-capcalera d-flex align-items-center">
							<h4 class="main-title">Notícies</h4>
						</div>
				<div class="row">
					<?php
                    $j = 0;
                    while ($j < 4) {
                    ?>
					<div class="col-12 col-md">
						<div class="block-images position-relative">
							<div class="img-noticia noticia_flex" style="background-image:url(<?php echo $data_NEWS->list['0']->img_social; ?>)">
							</div>
						</div><br/>
						<h6 class="titol"><a href="/noticia/<?php echo $data_NEWS->list['0']->id; ?>/<?php echo $data_NEWS->list['0']->title_url; ?>"><?php echo $data_NEWS->list['0']->title; ?></a></h6>
						<div class="capitol d-flex align-items-center my-2">
							<span class="text-white"><?php echo substr($data_NEWS->list['0']->date_formatted, 0, -9); ?></span>
						</div>
						<br /><br />
					</div>
					<?php
                        $j++;
                    }
                    ?>
				</div>
			</section>-->
			<br/>
							<?php
							include 'config.php';
							$GET_VARS3 = array(
								"go"        => "clips",
								"do"        => "list"
							);

							$POST_VARS3 = array(
								"sortByFilter"      => "date",
								"categoriesFilter"  => $data->data->id,
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
								}
							</style>
							<div class="um-capcalera d-flex align-items-center">
							<h4 data-aos="fade-right" class="main-title">Informatius d'UABràdio</h4>
						</div>
                        
    <section id="noticies" style="background-color:#FF4C3E!important;padding-top:40px;padding-bottom:20px">
      <?php
      include 'config.php';
      $GET_VARS3 = array(
        "go"        => "clips",
        "do"        => "list"
      );

      $POST_VARS3 = array(
        "sortByFilter"      => "date",
        "categoriesFilter"  => '2',
        "statusFilter"    => 1,
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
      <div class="container-fluid" >
		  <h3 data-aos="fade-right">Informatius d'UABràdio</h3><br />
        <div data-aos="zoom-in" class="row">
		  
		  
		  <?php
		  
		  	for ($i = 0; $i < count($data3->list); $i++) {
		  ?>
		<div class="col-12 col-md-4">
		   <div class="informatiuIndex">
				<div class="slide-item">
					<div class="block-images position-relative">
						<a href="/clip/<?php echo $data3->list[$i]->id; ?>/<?php echo $data3->list[$i]->title_url; ?>">
							<div class="img-box">
								<img src="<?php echo $data3->list[$i]->img_social; ?>" class="img-fluid" alt="">
						</div>
						<div class="block-description">
							<h6 class="titol"><a href="/clip/<?php echo $data3->list[$i]->id; ?>/<?php echo $data3->list[$i]->title_url; ?>"><?php echo $data3->list[$i]->title; ?></a></h6>
							<div class="capitol d-flex align-items-center my-2">
								<span class="text-white"><?php echo substr($data3->list[$i]->date_formatted, 0, -9); ?></span>
							</div>
						</div></a>
					</div>
				</div>
			</div>
		</div>
		  <?php } ?>
		  
		  
		  
		  
       
      </div>
    


 






    
  
						
					
				</div>
			</section>
			<br /><br />
		</div>
	</div>
				</div>
			</section>
		</div>
	</div>
	<?php
	include './plantilla/footer.php';
	?>
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 500
        });
      </script>
</body>

</html>