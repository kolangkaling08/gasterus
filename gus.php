<?php
// HEMAT MEMORI SANGAT AGRESIF - versi debugging + produksi
// Simpan sebagai oke.php dan jalankan lewat browser

// Nonaktifkan output buffering agar PHP nggak menimbun output di memori
while (ob_get_level() > 0) { ob_end_flush(); }
ob_implicit_flush(true);

// Tampilkan error supaya kelihatan detail
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Coba set memory limit (jika hosting izinkan)
// Jika tidak diizinkan, ini tidak akan mengubah apa pun.
@ini_set('memory_limit', '256M');

// Laporkan memory_limit supaya bisa dicek di log / output
$limit_now = ini_get('memory_limit');

// Config
$judulFile = "kw.txt";
$maxUrlsPerSitemap = 10000;
$protocol = 'https';

// Validasi file
if (!file_exists($judulFile) || !is_readable($judulFile)) {
    die("❌ File '$judulFile' tidak ditemukan atau tidak bisa dibaca.");
}

// Dapatkan base URL (aman di CLI juga)
function getCurrentUrlPath($protocol = 'https') {
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $requestUri = $_SERVER['REQUEST_URI'] ?? '/';
    $path = rtrim(dirname($requestUri), '/');
    return rtrim("$protocol://$host$path", '/') . '/';
}
$urlPath = getCurrentUrlPath($protocol);

// Fungsi buka/tutup sitemap
function openNewSitemapFile($num) {
    $fileName = "sitemap{$num}.xml";
    $f = fopen($fileName, "w");
    if (!$f) {
        die("❌ Tidak bisa membuat file $fileName - cek permission.");
    }
    fwrite($f, '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL);
    fwrite($f, '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL);
    return $f;
}
function closeSitemapFile($f) {
    if (is_resource($f)) {
        fwrite($f, '</urlset>' . PHP_EOL);
        fclose($f);
    }
}
function writeSitemapIndexEntry($indexFile, $urlPath, $num, $lastmod) {
    fwrite($indexFile, "  <sitemap>\n");
    fwrite($indexFile, "    <loc>" . htmlspecialchars($urlPath . "sitemap{$num}.xml") . "</loc>\n");
    fwrite($indexFile, "    <lastmod>{$lastmod}</lastmod>\n");
    fwrite($indexFile, "  </sitemap>\n");
}

// Buat index file (tulis langsung ke disk, jangan simpan di memori)
$sitemapIndexFile = fopen("sitemap_index.xml", "w");
if (!$sitemapIndexFile) die("❌ Gagal membuat sitemap_index.xml");
fwrite($sitemapIndexFile, '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL);
fwrite($sitemapIndexFile, '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL);

$currentSitemapNum = 1;
$currentSitemapUrls = 0;
$sitemapFile = openNewSitemapFile($currentSitemapNum);

// Untuk lastmod kita pakai waktu saat sitemap dibuka (hemat pemanggilan date())
$lastmodForCurrentSitemap = date('Y-m-d\TH:i:sP');

// Baca file secara streaming baris demi baris
$handle = fopen($judulFile, "r");
if (!$handle) die("❌ Tidak bisa membuka $judulFile");

// Counter untuk memicu GC secara berkala
$counter = 0;
$gcInterval = 1000; // panggil garbage collect tiap 1000 baris

while (($line = fgets($handle)) !== false) {
    $judul = trim($line);
    if ($judul === '') continue;

    // slugify sederhana (sangat ringan)
    $slug = strtolower($judul);
    $slug = str_replace(' ', '-', $slug);
    // hapus karakter non alnum dan '-'
    $slug = preg_replace('/[^a-z0-9\-]/', '', $slug);

    // Jika sudah mencapai batas URL per sitemap -> tutup & buka baru
    if ($currentSitemapUrls >= $maxUrlsPerSitemap) {
        // tutup file lama dan tulis entry ke index dengan lastmod yang disimpan
        closeSitemapFile($sitemapFile);
        writeSitemapIndexEntry($sitemapIndexFile, $urlPath, $currentSitemapNum, $lastmodForCurrentSitemap);

        // reset dan buka baru
        $currentSitemapNum++;
        $currentSitemapUrls = 0;
        $sitemapFile = openNewSitemapFile($currentSitemapNum);
        $lastmodForCurrentSitemap = date('Y-m-d\TH:i:sP');
    }

    // bangun url (tidak menyimpan ke array — langsung tulis)
    $htmlURL = $urlPath . $slug;

    fwrite($sitemapFile, "  <url>\n");
    fwrite($sitemapFile, "    <loc>" . htmlspecialchars($htmlURL) . "</loc>\n");
    fwrite($sitemapFile, "    <lastmod>" . $lastmodForCurrentSitemap . "</lastmod>\n");
    fwrite($sitemapFile, "    <changefreq>daily</changefreq>\n");
    fwrite($sitemapFile, "  </url>\n");

    // free small vars (biasanya PHP GC otomatis, tapi kita bantu)
    unset($slug, $htmlURL, $judul, $line);

    $currentSitemapUrls++;
    $counter++;

    // panggil garbage collector berkala
    if ($counter % $gcInterval === 0) {
        if (function_exists('gc_collect_cycles')) {
            gc_collect_cycles();
        }
        // juga log sedikit supaya kalau masih error kita tahu progress
        error_log("Progress: processed {$counter} lines. memory_get_usage=" . memory_get_usage(true));
    }
}
fclose($handle);

// tutup sitemap terakhir jika ada isinya
if ($currentSitemapUrls > 0) {
    closeSitemapFile($sitemapFile);
    writeSitemapIndexEntry($sitemapIndexFile, $urlPath, $currentSitemapNum, $lastmodForCurrentSitemap);
}

fwrite($sitemapIndexFile, '</sitemapindex>' . PHP_EOL);
fclose($sitemapIndexFile);

// Buat robots.txt (tulis langsung)
$robotsFile = fopen("robots.txt", "w");
if ($robotsFile) {
    fwrite($robotsFile, "User-agent: *\n");
    fwrite($robotsFile, "Allow: /\n\n");
    fwrite($robotsFile, "Sitemap: " . $urlPath . "sitemap_index.xml\n");
    for ($i = 1; $i <= $currentSitemapNum; $i++) {
        fwrite($robotsFile, "Sitemap: " . $urlPath . "sitemap{$i}.xml\n");
    }
    fclose($robotsFile);
}

// Output ringkasan (jika dijalankan via browser)
echo "✅ SITEMAP DIBUAT: {$currentSitemapNum} file(s).<br>";
echo "Memory limit saat runtime: {$limit_now}<br>";
echo "Memory usage (peak): " . (memory_get_peak_usage(true)) . " bytes<br>";
echo "Jika masih error, lihat error log server untuk detail (atau hubungi hosting).<br>";
?>
