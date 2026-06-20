<?php
	//Aquest fitxer conté les connexions via API amb l'Staff (staff.uab.media), les quals permeten carregar les notícies, els fitxers d'àudio i vídeo així com la resta de continguts dinàmics per alimentar la web. És extremadament important que aquest fitxer no sigui accessible públicament.

	// El contingut és dinàmic: demana al navegador que revalidi l'HTML a cada
	// visita en lloc de servir-lo de la memòria cau (el servidor php -S no envia
	// capçaleres de cau pròpies). Així els canvis de CSS (versionats amb ?v=) i
	// de contingut es veuen sense haver de fer un refresc forçat.
	if (!headers_sent()) {
		header('Cache-Control: no-cache, must-revalidate');
	}

    $API_URL = "https://staff.uab.media/api.php";
    $API_KEY_ID = "4f6eb2eed1f11108103f317e5cb97c74";
    $API_KEY_SECRET = "NGY2ZWIyZWVkMWYxMTEwODEwM2YzMTdlNWNiOTdjNzQyMWRlN2M3ZWZmYTM5MjMz";
    $API_SHARED_SECRET = "NGY2ZWIyZWVkMWYxMTEwODEwM2YzMTdlNWNiOTdjNzQyMWRlN2M3ZWZmYTM5MjMz";

    $salt = md5(mt_rand());
    $timestamp = time();
    $signature = base64_encode(hash_hmac('sha256', $salt.$timestamp, $API_SHARED_SECRET, true));

    $GET_VARS["timestamp"] = $timestamp;
    $GET_VARS["salt"] = $salt;
    $GET_VARS["key"] = $API_KEY_ID;
    $GET_VARS["signature"] = $signature;
    // Fem servir la coalescència nul·la perquè un paràmetre absent simplement s'ometi de la
    // consulta a l'API (http_build_query omet els valors nuls) en lloc de provocar un
    // avís "Undefined array key". El comportament enviat a l'API no canvia.
    $GET_VARS["go"] = $_REQUEST['go'] ?? null;
    $GET_VARS["do"] = $_REQUEST['do'] ?? null;
    $GET_VARS["iq"] = $_REQUEST['iq'] ?? null;
?>
