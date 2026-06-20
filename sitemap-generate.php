<?php
/**
 * sitemap-generate.php — Generador automàtic del sitemap.xml de UABmèdia.
 *
 * Consulta l'API de Staff (staff.uab.media) per obtenir TOTS els clips, totes
 * les notícies i tots els programes i reescriu /sitemap.xml amb les URLs reals
 * del portal, incloent-hi la data de publicació (lastmod) quan està disponible.
 * D'aquesta manera el sitemap deixa de ser un fitxer estàtic obsolet i es manté
 * sincronitzat amb el contingut.
 *
 * COM S'EXECUTA
 *   - Per CLI (recomanat, via Tasca programada de Plesk → "Executar un script PHP"
 *     o "Executar una ordre"):
 *         php /var/www/vhosts/uab.media/httpdocs/sitemap-generate.php
 *   - Per HTTP (opcional, via Plesk → "Recuperar una URL"), cal el token:
 *         https://uab.media/sitemap-generate.php?token=...
 *
 * Programació suggerida a Plesk: un cop al dia (p. ex. cada nit a les 04:00).
 *
 * Afegit per a l'automatització del sitemap — 20 de juny de 2026.
 */

// ---------------------------------------------------------------------------
// Configuració
// ---------------------------------------------------------------------------

// Token per a l'execució via HTTP (mode "Recuperar una URL" de Plesk). En mode
// CLI / cron no es demana. Canvia'l si vols. No té cap efecte sobre el sitemap.
const SITEMAP_TOKEN = 'c429a889ebde934da9038f2b7f65dd34';

// Base pública del lloc i destí del fitxer (al costat d'aquest script).
const SITE_BASE   = 'https://uab.media';
const OUTPUT_FILE = __DIR__ . '/sitemap.xml';

// Timestamps anteriors a 2005-01-01 es consideren invàlids (alguns continguts
// antics tenen dates a prop de l'època 0); en aquest cas s'omet el <lastmod>.
const MIN_VALID_TS = 1104537600;

// ---------------------------------------------------------------------------
// Control d'accés: si s'invoca per HTTP cal el token; per CLI/cron, no.
// ---------------------------------------------------------------------------

$viaHttp = (PHP_SAPI !== 'cli') && !empty($_SERVER['REQUEST_METHOD']);
if ($viaHttp) {
    header('Content-Type: text/plain; charset=utf-8');
    $token = $_GET['token'] ?? '';
    if (!is_string($token) || !hash_equals(SITEMAP_TOKEN, $token)) {
        http_response_code(403);
        exit("Forbidden\n");
    }
}

// Carrega les credencials de l'API ($API_URL, $API_KEY_ID, $API_SHARED_SECRET).
require __DIR__ . '/config.php';

// ---------------------------------------------------------------------------
// Crida a l'API de Staff. Els filtres viatgen al cos POST; l'autenticació
// (signatura HMAC) es regenera a cada crida.
// ---------------------------------------------------------------------------

/**
 * @return array Llista d'objectes (camp ->list de la resposta).
 */
function staff_fetch_list(string $go, array $filters): array
{
    global $API_URL, $API_KEY_ID, $API_SHARED_SECRET;

    $salt      = md5(mt_rand());
    $timestamp = time();
    $signature = base64_encode(hash_hmac('sha256', $salt . $timestamp, $API_SHARED_SECRET, true));

    $query = http_build_query([
        'timestamp' => $timestamp,
        'salt'      => $salt,
        'key'       => $API_KEY_ID,
        'signature' => $signature,
        'go'        => $go,
        'do'        => 'list',
    ]);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $API_URL . '?' . $query);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $filters);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);

    $response = curl_exec($ch);
    if ($response === false) {
        throw new RuntimeException("Error cURL en obtenir '$go': " . curl_error($ch));
    }

    $data = json_decode($response);
    if (!isset($data->list) || !is_array($data->list)) {
        throw new RuntimeException("Resposta invàlida de l'API per a '$go'.");
    }
    return $data->list;
}

// ---------------------------------------------------------------------------
// Construcció de la llista d'URLs
// ---------------------------------------------------------------------------

/** Afegeix una entrada normalitzada a $urls. */
function add_url(array &$urls, string $loc, ?int $ts, string $priority): void
{
    $urls[] = [
        'loc'      => $loc,
        'lastmod'  => ($ts !== null && $ts > MIN_VALID_TS) ? date('c', $ts) : null,
        'priority' => $priority,
    ];
}

try {
    $urls = [];

    // 1) Pàgines estàtiques principals.
    $staticPages = [
        ['/',           '1.00'],
        ['/actualitat', '0.80'],
        ['/uabradio',   '0.80'],
        ['/uabplay',    '0.80'],
        ['/especials',  '0.70'],
        ['/qui-som',    '0.60'],
    ];
    foreach ($staticPages as [$path, $priority]) {
        add_url($urls, SITE_BASE . $path, null, $priority);
    }

    // Filtres comuns: només actius, ordenats per data, tot el catàleg d'un cop.
    $listFilters = [
        'statusFilter'         => 1,
        'sortByFilter'         => 'date',
        'resultsPerPageFilter' => 5000,
        'fields'               => 'id, title_url, date, status',
    ];

    // 2) Notícies → /noticia/{id}/{slug}
    foreach (staff_fetch_list('news', $listFilters) as $it) {
        if (empty($it->id) || empty($it->title_url) || ($it->status ?? '1') !== '1') {
            continue;
        }
        $loc = sprintf('%s/noticia/%s/%s', SITE_BASE, $it->id, rawurlencode($it->title_url));
        add_url($urls, $loc, isset($it->date) ? (int) $it->date : null, '0.70');
    }

    // 3) Clips → /clip/{id}/{slug}
    foreach (staff_fetch_list('clips', $listFilters) as $it) {
        if (empty($it->id) || empty($it->title_url) || ($it->status ?? '1') !== '1') {
            continue;
        }
        $loc = sprintf('%s/clip/%s/%s', SITE_BASE, $it->id, rawurlencode($it->title_url));
        add_url($urls, $loc, isset($it->date) ? (int) $it->date : null, '0.64');
    }

    // 4) Programes → /programa/{id}/{slug}
    // Els programes són les categories filles directes de UABplay (ID 16) i de
    // UABràdio (ID 1). Cal includeData=1 perquè el "list" retorni el title_url.
    // S'inclouen tant els actius (status=1) com els d'arxiu (status=0, temporades
    // anteriors que segueixen sent navegables públicament des de /uabplay), però
    // amb prioritat menor. Aquestes categories no tenen data, per això no porten
    // <lastmod>. S'exclou la pròpia categoria arrel, que l'API hi inclou.
    $programRoots = [16, 1];
    foreach ($programRoots as $root) {
        foreach ([['1', '0.70'], ['0', '0.50']] as [$status, $priority]) {
            $cats = staff_fetch_list('categories', [
                'parentFilter'         => $root,
                'statusFilter'         => $status,
                'includeData'          => 1,
                'sortByFilter'         => 'title',
                'resultsPerPageFilter' => 500,
            ]);
            foreach ($cats as $c) {
                if (empty($c->id) || empty($c->title_url) || (int) $c->id === $root) {
                    continue;
                }
                $loc = sprintf('%s/programa/%s/%s', SITE_BASE, $c->id, rawurlencode($c->title_url));
                add_url($urls, $loc, null, $priority);
            }
        }
    }

    // -----------------------------------------------------------------------
    // Generació de l'XML
    // -----------------------------------------------------------------------
    $xml  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    foreach ($urls as $u) {
        $xml .= "  <url>\n";
        $xml .= '    <loc>' . htmlspecialchars($u['loc'], ENT_QUOTES, 'UTF-8') . "</loc>\n";
        if ($u['lastmod'] !== null) {
            $xml .= '    <lastmod>' . $u['lastmod'] . "</lastmod>\n";
        }
        $xml .= '    <priority>' . $u['priority'] . "</priority>\n";
        $xml .= "  </url>\n";
    }
    $xml .= "</urlset>\n";

    // -----------------------------------------------------------------------
    // Escriptura atòmica: fitxer temporal + rename (evita un sitemap a mitges
    // si el crawler arriba durant la generació).
    // -----------------------------------------------------------------------
    $tmp = OUTPUT_FILE . '.tmp';
    if (file_put_contents($tmp, $xml, LOCK_EX) === false) {
        throw new RuntimeException('No s\'ha pogut escriure el fitxer temporal: ' . $tmp);
    }
    if (!rename($tmp, OUTPUT_FILE)) {
        @unlink($tmp);
        throw new RuntimeException('No s\'ha pogut reemplaçar ' . OUTPUT_FILE);
    }

    $msg = sprintf(
        "[%s] sitemap.xml generat correctament: %d URLs (%s).\n",
        date('Y-m-d H:i:s'),
        count($urls),
        number_format(strlen($xml) / 1024, 1) . ' KB'
    );
    fwrite($viaHttp ? fopen('php://output', 'w') : STDOUT, $msg);
    exit(0);

} catch (Throwable $e) {
    // Surt amb codi != 0 perquè Plesk detecti l'error i pugui notificar-lo.
    $err = '[' . date('Y-m-d H:i:s') . '] ERROR generant sitemap: ' . $e->getMessage() . "\n";
    if ($viaHttp) {
        http_response_code(500);
        echo $err;
    } else {
        fwrite(STDERR, $err);
    }
    exit(1);
}
