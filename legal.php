<?php
    include 'config.php';
    $GET_VARS2 = array(
    	"go"        => "channels",
    	"do"        => "get",
        "iq"        => 2
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
		<title>Qui som? – UABmèdia</title>
		<meta name="theme-color" content="#141414">
		<meta name="description" content="UABmèdia és una plataforma d’articulació de continguts interactius que elabora l’alumnat de forma homologable als que produeixen altres mitjans.">
		<meta name="twitter:card" content="summary">
		<meta name="twitter:site" content="@uabmedia">
		<meta name="twitter:title" content="Qui som? - UABmèdia">
		<meta name="twitter:description" content="UABmèdia és una plataforma d’articulació de continguts interactius que elabora l’alumnat de forma homologable als que produeixen altres mitjans.">
		<meta name="twitter:image:src" content="https://uab.media/assets/images/uabmedia_twitter.jpeg">
		<meta property="og:site_name" content="UABmèdia" />
		<meta property="og:title" content="Qui som? - UABmèdia" />
		<meta property="og:description" content="UABmèdia és una plataforma d’articulació de continguts interactius que elabora l’alumnat de forma homologable als que produeixen altres mitjans." />
		<meta property="og:image" content="https://uab.media/assets/images/uabmedia_twitter.jpeg" />
		<link rel="shortcut icon" href="https://uab.media/assets/images/favicon.png" />
		<link rel="stylesheet" href="https://uab.media/assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="https://uab.media/assets/css/typography.css">
		<link rel="stylesheet" href="https://uab.media/assets/css/style.css" />
		<link rel="stylesheet" href="https://uab.media/assets/css/responsive.css" />
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://s3-eu-west-1.amazonaws.com">
		<?php
		include './head-import.php';
		?>
	</head>

<body>
  <?php
   include './plantilla/header.php';
   ?>
    <div class="container" style="padding-top:100px">
        <h4>Avís Legal</h4><br/>
        <?php echo $data->data->description; ?>
    </div>
    <?php
   include './plantilla/footer.php';
   ?>
	<script src="/assets/js/search.js"></script>
	</body>
</html>