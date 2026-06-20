<?php
include 'config.php'; // Inclou la configuració, per exemple, la variable $API_URL

// Llegeix el fitxer JSON de la graella setmanal
$programacio_setmanal = json_decode(file_get_contents('graella.json'), true);
$detalls_programa = null;

/*
 * Els detalls de cada programa (títol i pòster) gairebé no canvien, però la
 * graella conté ~35 entrades setmanals. Resoldre-les a cada càrrega suposava
 * ~35 crides síncrones a l'API de Staff/WebTV per visita. Les cachem en disc
 * amb una validesa d'1 hora i invalidant-les si graella.json canvia, de manera
 * que l'API només rep aquestes peticions un cop per hora.
 */
$cacheDir  = 'cache';
$cacheFile = $cacheDir . '/graella_detalls.json';
$cacheTtl  = 3600; // segons

if (
	is_file($cacheFile)
	&& (time() - filemtime($cacheFile) < $cacheTtl)
	&& filemtime($cacheFile) >= filemtime('graella.json')
) {
	$cached = json_decode(file_get_contents($cacheFile), true);
	if (is_array($cached)) {
		$detalls_programa = $cached;
	}
}

if ($detalls_programa === null) {
	$detalls_programa = [];

	foreach ($programacio_setmanal as $dia => $programes) {
		foreach ($programes as $programa) {
			$GET_VARS_PROG = array(
				"go" => "categories",
				"do" => "get",
				"iq" => $programa['id']
			);

			// Construeix la URL de la sol·licitud a l'API per obtenir els detalls del programa
			$REQUEST_URL_PROG = $API_URL . "?" . http_build_query($GET_VARS) . "&" . http_build_query($GET_VARS_PROG);
			$ch_PROG = curl_init();
			curl_setopt($ch_PROG, CURLOPT_URL, $REQUEST_URL_PROG);
			curl_setopt($ch_PROG, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch_PROG, CURLOPT_HEADER, false);

			$response_PROG = curl_exec($ch_PROG);
			$dades_programa = json_decode($response_PROG, true);

			// Si l'API retorna informació vàlida, emmagatzema els detalls del programa
			if (isset($dades_programa['data'])) {
				$detalls_programa[$dia][] = [
					'id' => $programa['id'],
					'hora_inici' => $programa['hora_inici'],
					'titol' => $dades_programa['data']['title'],
					'img_poster' => $dades_programa['data']['img_poster']
				];
			}
		}
	}

	if (!is_dir($cacheDir)) {
		@mkdir($cacheDir, 0775, true);
	}
	@file_put_contents($cacheFile, json_encode($detalls_programa), LOCK_EX);
}

// Codifica en JSON els detalls dels programes per ser utilitzats en JavaScript
echo "<script>const detallsPrograma = " . json_encode($detalls_programa) . ";</script>";
?>

<!-- Afegir el script de Hls.js -->
<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>

<div id="live-player">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-10 d-flex align-items-center">
				<img id="program-image" src="https://uab.media/assets/images/gif-musica.gif" alt="UABràdio - Música">
				<div id="program-details">
					<div id="live-text">UABràdio en directe</div>
					<div id="program-info"></div>
				</div>
			</div>
			<div class="col-2 radio-buttons d-flex justify-content-end">
				<button id="play-btn" class="icon-button" aria-label="Play">&#9658;</button>
				<button id="pause-btn" class="icon-button" aria-label="Pause" style="display: none;">&#10074;&#10074;</button>
				<audio id="radio-player" controls style="display: none;"></audio>
			</div>
		</div>
	</div>
</div>

<script>
	document.addEventListener("DOMContentLoaded", function () {
		const radioPlayer = document.getElementById('radio-player');
		const playButton = document.getElementById('play-btn');
		const pauseButton = document.getElementById('pause-btn');
		const livePlayer = document.getElementById('live-player');
		const hlsSrc = "https://videosdigitals.uab.cat/live/uabradio/playlist.m3u8";
		let hls;
		let programaEnDirecte = null;

		// Inicialitza HLS si és compatible
		function initializeHls() {
			if (Hls.isSupported()) {
				hls = new Hls();
				hls.loadSource(hlsSrc);
				hls.attachMedia(radioPlayer);
				hls.on(Hls.Events.MANIFEST_PARSED, function () {
					console.log('HLS carregat i llest per reproduir');
				});
			} else if (radioPlayer.canPlayType('application/vnd.apple.mpegurl')) {
				// Safari natiu
				radioPlayer.src = hlsSrc;
				console.log('Reproductor carregat nativament per a Safari');
			} else {
				console.error('El teu navegador no suporta HLS.');
			}
		}

		// Inicia la configuració de HLS
		initializeHls();

		playButton.addEventListener('click', function () {
			// Per a Safari i iOS, cal que l'àudio es reprodueixi només després d'una acció de l'usuari.
			radioPlayer.play().then(() => {
				playButton.style.display = 'none';
				pauseButton.style.display = 'block';
				livePlayer.classList.add('active');
				updateMediaSession(programaEnDirecte);
			}).catch(error => {
				console.error('Error en la reproducció:', error);
			});
		});

		pauseButton.addEventListener('click', function () {
			radioPlayer.pause();
			playButton.style.display = 'block';
			pauseButton.style.display = 'none';
			livePlayer.classList.remove('active');

			if ('mediaSession' in navigator) {
				navigator.mediaSession.playbackState = 'paused';
			}
		});

		// Mostra el programa actual utilitzant les dades de detallsPrograma
		function displayCurrentProgram(detallsPrograma) {
			const diesSetmana = ["Diumenge", "Dilluns", "Dimarts", "Dimecres", "Dijous", "Divendres", "Dissabte"];
			const ara = new Date();
			const diaActual = diesSetmana[ara.getDay()];
			const horaActual = ara.getHours();
			const minutActual = ara.getMinutes();

			// Cerca el programa actual
			const programesAvui = detallsPrograma[diaActual];

			if (programesAvui) {
				programesAvui.forEach(programa => {
					const [horaInici, minutInici] = programa.hora_inici.split(':').map(Number);
					const horaFinal = horaInici + 1;

					if (
						(horaActual === horaInici && minutActual >= minutInici) ||
						(horaActual === horaFinal && minutActual < minutInici)
					) {
						programaEnDirecte = programa;
					}
				});
			}

			const infoDiv = document.getElementById("program-info");
			const imgDiv = document.getElementById("program-image");

			if (programaEnDirecte) {
				if (infoDiv) infoDiv.textContent = `${programaEnDirecte.titol}`;
				if (imgDiv) {
					imgDiv.src = `${programaEnDirecte.img_poster}`;
					imgDiv.alt = programaEnDirecte.titol;
				}
				updateMediaSession(programaEnDirecte);
			} else {
				if (infoDiv) infoDiv.textContent = "Sessions musicals";
				if (imgDiv) {
					imgDiv.src = "https://uab.media/assets/images/gif-musica.gif";
					imgDiv.alt = "Sessions musicals";
				}
				updateMediaSession(null);
			}
		}

		function updateMediaSession(programa) {
			if ('mediaSession' in navigator) {
				navigator.mediaSession.metadata = new MediaMetadata({
					title: programa ? programa.titol : "Sessions musicals",
					artist: "UABràdio en directe",
					album: "UABmèdia",
					artwork: [
						{ src: "https://uab.media/assets/images/icons/apple-touch-icon-180x180.png", sizes: "96x96", type: "image/png" },
						{ src: "https://uab.media/assets/images/icons/apple-touch-icon-180x180.png", sizes: "128x128", type: "image/png" },
						{ src: "https://uab.media/assets/images/icons/apple-touch-icon-180x180.png", sizes: "192x192", type: "image/png" },
						{ src: "https://uab.media/assets/images/icons/apple-touch-icon-180x180.png", sizes: "256x256", type: "image/png" },
						{ src: "https://uab.media/assets/images/icons/apple-touch-icon-180x180.png", sizes: "384x384", type: "image/png" },
						{ src: "https://uab.media/assets/images/icons/apple-touch-icon-180x180.png", sizes: "512x512", type: "image/png" }
					]
				});

				navigator.mediaSession.playbackState = 'playing';
			}
		}

		displayCurrentProgram(detallsPrograma);
	});
</script>