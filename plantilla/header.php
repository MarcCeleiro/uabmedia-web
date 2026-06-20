<header id="capcalera">
	<div class="container">
		<!--Fila 1-->
		<div class="row">
			<div class="col-sm-6 col-12">
				<nav class="navbar navbar-expand-lg navbar-light p-0">
					<div class="menu-main-menu-container">
						<ul id="top-menu" class="navbar-nav ml-auto">
							<li class="menu-item">
								<a href="https://uab.media/" class="uabmedia-title" id="/index.php">
									<img class="logo" src="/assets/images/uabmedia-color.svg" alt="Logotip d'UABmèdia" />UABmèdia
								</a>
							</li>

							<li class="menu-item amaga-mobil">
								<a href="https://uab.media/actualitat"
								   <?php 
								   if ( $_SERVER['PHP_SELF'] == '/index.php' ) {
									   echo 'style="filter:grayscale(0)"';
								   }else{
									   echo 'style="filter:grayscale(100)"';
								   }?>
								   >
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
										<title>newspaper-variant</title>
										<path d="M20 3H4C2.89 3 2 3.89 2 5V19C2 20.11 2.89 21 4 21H20C21.11 21 22 20.11 22 19V5C22 3.89 										21.11 3 20 3M5 7H10V13H5V7M19 17H5V15H19V17M19 13H12V11H19V13M19 9H12V7H19V9Z" />
									</svg>actualitat
								</a>
							</li>

							<li class="menu-item amaga-mobil">
								<a href="https://uab.media/uabradio" id="/uabradio.php"
								   <?php 
								   if ( $_SERVER['PHP_SELF'] == '/uabradio.php' ) {
									   echo 'style="filter:grayscale(0)"';
								   }else{
									   echo 'style="filter:grayscale(100)"';
								   }?>
								   >
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
										<title>radio</title>
										<path d="M20,6A2,2 0 0,1 22,8V20A2,2 0 0,1 20,22H4A2,2 0 0,1 2,20V8C2,7.15 2.53,6.42 													3.28,6.13L15.71,1L16.47,2.83L8.83,6H20M20,8H4V12H16V10H18V12H20V8M7,14A3,3 0 0,0 4,17A3,3 0 0,0 										7,20A3,3 0 0,0 10,17A3,3 0 0,0 7,14Z" />
									</svg>ràdio
								</a>
							</li>

							<li class="menu-item amaga-mobil">
								<a href="https://uab.media/uabplay" id="/uabplay.php"  
								   <?php 
								   if ( $_SERVER['PHP_SELF'] == '/uabplay.php' ) {
									   echo 'style="filter:grayscale(0)"';
								   }else{
									   echo 'style="filter:grayscale(100)"';
								   }?>
								   >
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
										<title>play-circle</title>
										<path d="M10,16.5V7.5L16,12M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 											12,2Z" />
									</svg>play
								</a>
							</li>

							<li class="menu-item amaga-mobil">
								<a href="https://uab.media/especials" id="/especials.php"
								   <?php
								   if ( $_SERVER['PHP_SELF'] == '/especials.php' ) {
									   echo 'style="filter:grayscale(0)"';
								   }else{
									   echo 'style="filter:grayscale(100)"';
								   }?>

								   >
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
										<title>cursor-default-click</title>
										<path d="M10.76,8.69A0.76,0.76 0 0,0 10,9.45V20.9C10,21.32 10.34,21.66 10.76,21.66C10.95,21.66 11.11,21.6 11.24,21.5L13.15,19.95L14.81,23.57C14.94,23.84 15.21,24 15.5,24C15.61,24 15.72,24 15.83,23.92L18.59,22.64C18.97,22.46 19.15,22 18.95,21.63L17.28,18L19.69,17.55C19.85,17.5 20,17.43 20.12,17.29C20.39,16.97 20.35,16.5 20,16.21L11.26,8.86L11.25,8.87C11.12,8.76 10.95,8.69 10.76,8.69M15,10V8H20V10H15M13.83,4.76L16.66,1.93L18.07,3.34L15.24,6.17L13.83,4.76M10,0H12V5H10V0M3.93,14.66L6.76,11.83L8.17,13.24L5.34,16.07L3.93,14.66M3.93,3.34L5.34,1.93L8.17,4.76L6.76,6.17L3.93,3.34M7,10H2V8H7V10" />
									</svg>especials
								</a>
							</li>

						</ul>
					</div>
				</nav>
				<div class="nav-overlay"></div>
			</div>

							
			<div class="col-sm-6 amaga-mobil" style="text-align:end;">
				<div class="d-flex align-items-center list-inline m-0 icones-socials">
					<div class="nav-item nav-icon">
						<a href="/qui-som.php"
						   <?php
						   if ($_SERVER['PHP_SELF'] == '/qui-som.php') {
							   echo 'style="filter:grayscale(0)"';
						   } else {
							   echo 'style="filter:grayscale(100)"';
						   }
						   ?>>
							Qui som?
						</a>
					</div>
					
					<div class="nav-item nav-icon">
						<a href="https://www.twitch.com/uabmedia" target="_blank" rel="noreferrer" aria-label="Twitch">
							<i class="fa fa-twitch" aria-hidden="true"></i>

						</a>
					</div>
					<div class="nav-item nav-icon">
						<a href="https://www.instagram.com/uabmedia" target="_blank" rel="noreferrer" aria-label="Instagram">
							<i class="fa fa-instagram" aria-hidden="true"></i>
						</a>
					</div>
					
					<div class="nav-item nav-icon">
						<a href="https://linkedin.com/in/redaccio-uabmedia" target="_blank" rel="noreferrer" aria-label="LinkedIn">
							<i class="fa fa-linkedin-square" aria-hidden="true"></i>
						</a>
					</div>
					<div id="ctn-icon-search" class="nav-item nav-icon">
						<i class="search-link fa fa-search" id="icon-search"></i>
					</div>
					
					<div id="box-search" class="d-search">
						<form action="https://uab.media/cerca" method="post" class="searchbox">
							<div id="ctn-bars-search" class="form-group position-relative">
								<input id="inputSearch" type="text" name="cerca" class="text search-input font-size-12" placeholder="Cercar un programa, capítol o notícia">
								<button id="send_search"type="submit"><i class="search-link fa fa-search"></i></button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>