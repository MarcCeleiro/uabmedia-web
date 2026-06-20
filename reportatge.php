<?php
    include 'config.php';
    $GET_VARS2 = array(
    	"go"        => "news",
    	"do"        => "get"
    );
    $REQUEST_URL = $API_URL."?".http_build_query($GET_VARS)."&".http_build_query($GET_VARS2);

    // "do=get" identifica l'element mitjançant la query string (iq); no cal cos POST.
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
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@uabmedia">
        <meta name="twitter:title" content="<?php echo $data->data->title; ?> - UABmèdia">
        <meta name="twitter:description" content="<?php echo $data->data->description_seo; ?>">
        <meta name="twitter:image:src" content="<?php echo $data->data->img_social; ?>">
        <meta name="twitter:url" content="https://uab.media/reportatge/<?php echo $data->data->id; ?>/<?php echo $data->data->title_url; ?>">
        <meta property="og:site_name" content="UABmèdia" />
        <meta property="og:url" content="https://uab.media/reportatge/<?php echo $data->data->id; ?>/<?php echo $data->data->title_url; ?>" />
        <meta property="og:title" content="<?php echo $data->data->title; ?> - UABmèdia" />
        <meta property="og:description" content="<?php echo $data->data->description_seo; ?>" />
        <meta property="og:image" content="<?php echo $data->data->img_social; ?>" />
		<script type="application/ld+json">
			{
				"@context": "http://schema.org/",
				"@type": "NewsArticle",
				"mainEntityOfPage": {
					"@type": "WebPage",
					"@id": "https://uab.media/reportatge/<?php echo $data->data->id; ?>/<?php echo $data->data->title_url; ?>"
				},
				"headline": "<?php echo $data->data->title; ?>",
				"image": [
					"<?php echo $data->data->img_social; ?>"
				]
			}
		</script><?php
		include 'head-import.php';
		?>
    </head>
    <body>
        <?php
		include './plantilla/header.php';
		?>
        <section id="portada">
            <div class="portada-reportatge" style="background-image:url(<?php echo $data->data->img_poster; ?>);"></div>
        </section>
        <main id="main" class="reportatge">
            <div class="container">
                <article>
					<center>
						<h1><?php echo $data->data->title; ?></h1>
						<h2 class="h5"><?php echo $data->data->description_seo; ?></h2>
						<br/>
						<?php echo substr($data->data->date_formatted,0,-3); ?> · Un reportatge de <strong><?php echo $data->data->user_alias; ?></strong>
					</center>
					<br/><br/>
					<div class="detall-noticia">
						<div class="blog-content">
							<?php echo $data->data->description; ?>
						</div>
					</div>
                </article>
            </div>
        </main>
        <?php
            include './plantilla/footer.php';
            ?>
		<script src="/assets/js/search.js"></script>

    </body>
</html>