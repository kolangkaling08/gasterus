<?php
// =======================
// FIXED & OPTIMIZED SCRIPT
// =======================

// Tampilkan error supaya gampang debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Batas memori aman untuk hosting biasa
ini_set('memory_limit', '512M');

// Nama file keyword
$judulFile = "kw.txt";

// Maksimum URL per sitemap (aturan Google: max 50.000, tapi kita pakai 10.000 biar ringan)
$maxUrlsPerSitemap = 10000;

// Pilih protokol situs kamu
$protocol = 'https'; // ubah ke 'http' kalau situsmu belum pakai SSL

// Cek apakah file kw.txt ada dan bisa dibaca
if (!file_exists($judulFile) || !is_readable($judulFile)) {
    die("❌ File '$judulFile' tidak ditemukan atau tidak bisa dibaca.");
}

// Dapatkan URL dasar
function getCurrentUrlPath($protocol = 'https') {
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $requestUri = $_SERVER['REQUEST_URI'] ?? '/';
    $path = rtrim(dirname($requestUri), '/');
    return "$protocol://$host$path/";
}

$urlPath = getCurrentUrlPath($protocol);

// Fungsi buka sitemap baru
function openNewSitemapFile($num) {
    $fileName = "sitemap{$num}.xml";
    $file = fopen($fileName, "w");
    if (!$file) {
        die("❌ Tidak bisa membuat file: $fileName");
    }
    fwrite($file, '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL);
    fwrite($file, '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL);
    return $file;
}

// Tutup sitemap
function closeSitemapFile($file) {
    fwrite($file, '</urlset>' . PHP_EOL);
    fclose($file);
}

// Tulis entry ke sitemap index
function writeSitemapIndexEntry($indexFile, $urlPath, $num) {
    fwrite($indexFile, "  <sitemap>\n");
    fwrite($indexFile, "    <loc>" . htmlspecialchars($urlPath . "sitemap{$num}.xml") . "</loc>\n");
    fwrite($indexFile, "    <lastmod>" . date('Y-m-d\TH:i:sP') . "</lastmod>\n");
    fwrite($indexFile, "  </sitemap>\n");
}

// Buat sitemap index
$sitemapIndexFile = fopen("sitemap_index.xml", "w");
if (!$sitemapIndexFile) {
    die("❌ Tidak bisa membuat sitemap_index.xml");
}
fwrite($sitemapIndexFile, '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL);
fwrite($sitemapIndexFile, '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL);

// Persiapan awal
$currentSitemapNum = 1;
$currentSitemapUrls = 0;
$sitemapFile = openNewSitemapFile($currentSitemapNum);

// Baca file besar baris per baris (hemat RAM)
$handle = fopen($judulFile, "r");
if (!$handle) {
    die("❌ Tidak bisa membuka $judulFile");
}

while (($judul = fgets($handle)) !== false) {
    $judul = trim($judul);
    if ($judul === '') continue; // skip baris kosong

    // Bersihkan keyword -> slug URL friendly
    $slug = strtolower($judul);
    $slug = str_replace(' ', '-', $slug);
    $slug = preg_replace('/[^a-z0-9\-]/', '', $slug);

    $htmlURL = $urlPath . $slug;

    // Jika sudah mencapai batas, tutup sitemap dan buka baru
    if ($currentSitemapUrls >= $maxUrlsPerSitemap) {
        closeSitemapFile($sitemapFile);
        writeSitemapIndexEntry($sitemapIndexFile, $urlPath, $currentSitemapNum);
        $currentSitemapNum++;
        $sitemapFile = openNewSitemapFile($currentSitemapNum);
        $currentSitemapUrls = 0;
    }

    // Tulis URL ke sitemap
    fwrite($sitemapFile, "  <url>\n");
    fwrite($sitemapFile, "    <loc>" . htmlspecialchars($htmlURL) . "</loc>\n");
    fwrite($sitemapFile, "    <lastmod>" . date('Y-m-d\TH:i:sP') . "</lastmod>\n");
    fwrite($sitemapFile, "    <changefreq>daily</changefreq>\n");
    fwrite($sitemapFile, "  </url>\n");

    $currentSitemapUrls++;
}
fclose($handle);

// Tutup sitemap terakhir
if ($currentSitemapUrls > 0) {
    closeSitemapFile($sitemapFile);
    writeSitemapIndexEntry($sitemapIndexFile, $urlPath, $currentSitemapNum);
}

fwrite($sitemapIndexFile, '</sitemapindex>' . PHP_EOL);
fclose($sitemapIndexFile);

// Buat robots.txt
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

echo "✅ SITEMAPS, SITEMAP INDEX, DAN ROBOTS.TXT BERHASIL DIBUAT!";
?>
