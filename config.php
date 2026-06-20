<?php
	//Aquest fitxer conté les connexions via API amb l'Staff (staff.uab.media), les quals permeten carregar les notícies, els fitxers d'àudio i vídeo així com la resta de continguts dinàmics per alimentar la web. És extremadament important que aquest fitxer no sigui accessible públicament.

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
    $GET_VARS["go"] = $_REQUEST['go'];
    $GET_VARS["do"] = $_REQUEST['do'];
    $GET_VARS["iq"] = $_REQUEST['iq'];
?>
