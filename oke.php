<?php
ini_set('memory_limit', '20G');

// Function to get the current URL path with customizable protocol
function getCurrentUrlPath($protocol = 'https') {
    $host = $_SERVER['HTTP_HOST'];
    $path = rtrim(dirname($_SERVER['REQUEST_URI']), '/'); // Ensure no trailing slash
    return "$protocol://$host$path/";
}

// Set protocol (http or https)
$protocol = 'http'; // Change to 'http' if needed

$judulFile = "kw.txt";
$maxUrlsPerSitemap = 10000;

// Check if the file exists and is readable
if (!file_exists($judulFile) || !is_readable($judulFile)) {
    die("File not found or not readable.");
}

// Read all lines from the file
$fileLines = file($judulFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$totalKeywords = count($fileLines);

// Get the base URL path with the selected protocol
$urlPath = getCurrentUrlPath($protocol);

// Create a sitemap index file
$sitemapIndexFile = fopen("sitemap_index.xml", "w");
if (!$sitemapIndexFile) {
    die("Unable to open sitemap_index.xml for writing.");
}

// Write the XML header for the sitemap index
fwrite($sitemapIndexFile, '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL);
fwrite($sitemapIndexFile, '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL);

$currentSitemapNum = 1;
$currentSitemapUrls = 0;
$sitemapFile = null;

function openNewSitemapFile($num) {
    $sitemapFileName = "sitemap{$num}.xml";
    $file = fopen($sitemapFileName, "w");
    if (!$file) {
        die("Unable to open $sitemapFileName for writing.");
    }
    fwrite($file, '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL);
    fwrite($file, '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL);
    return $file;
}

function closeSitemapFile($file) {
    fwrite($file, '</urlset>' . PHP_EOL);
    fclose($file);
}

function writeSitemapIndexEntry($indexFile, $urlPath, $num) {
    fwrite($indexFile, '  <sitemap>' . PHP_EOL);
    fwrite($indexFile, '    <loc>' . htmlspecialchars($urlPath . "sitemap{$num}.xml") . '</loc>' . PHP_EOL);
    fwrite($indexFile, '    <lastmod>' . date('Y-m-d\TH:i:sP') . '</lastmod>' . PHP_EOL);
    fwrite($indexFile, '  </sitemap>' . PHP_EOL);
}

$sitemapFile = openNewSitemapFile($currentSitemapNum);

// Prepare all URLs from the keywords
$allUrls = [];
foreach ($fileLines as $judul) {
    $baseTargetString = strtolower(str_replace(' ', '-', $judul));
    $baseTargetString = preg_replace('/[^a-z0-9\-]/', '', $baseTargetString); // Ensure only valid characters
    $allUrls[] = [
        'keyword' => $baseTargetString,
        'url' => $baseTargetString
    ];
}

// Shuffle the URLs to mix the keywords (optional)
shuffle($allUrls);

// Write the URLs to the sitemap files
foreach ($allUrls as $urlData) {
    if ($currentSitemapUrls >= $maxUrlsPerSitemap) {
        closeSitemapFile($sitemapFile);
        writeSitemapIndexEntry($sitemapIndexFile, $urlPath, $currentSitemapNum);
        $currentSitemapNum++;
        $sitemapFile = openNewSitemapFile($currentSitemapNum);
        $currentSitemapUrls = 0;
    }

    // Format the URL with "index.php?daftar=" parameter
    $htmlURL = $urlPath . "?daftar=" . $urlData['keyword'];

    fwrite($sitemapFile, '  <url>' . PHP_EOL);
    fwrite($sitemapFile, '    <loc>' . htmlspecialchars($htmlURL) . '</loc>' . PHP_EOL);
    fwrite($sitemapFile, '    <lastmod>' . date('Y-m-d\TH:i:sP') . '</lastmod>' . PHP_EOL);
    fwrite($sitemapFile, '    <changefreq>daily</changefreq>' . PHP_EOL);
    fwrite($sitemapFile, '  </url>' . PHP_EOL);

    $currentSitemapUrls++;
}


if ($currentSitemapUrls > 0) {
    closeSitemapFile($sitemapFile);
    writeSitemapIndexEntry($sitemapIndexFile, $urlPath, $currentSitemapNum);
}

fwrite($sitemapIndexFile, '</sitemapindex>' . PHP_EOL);
fclose($sitemapIndexFile);

// Create robots.txt file
$robotsFile = fopen("robots.txt", "w");
if (!$robotsFile) {
    die("Unable to open robots.txt for writing.");
}

// Write basic robots.txt content
fwrite($robotsFile, "User-agent: *\n");
fwrite($robotsFile, "Allow: /\n\n");

// Add sitemap index
fwrite($robotsFile, "Sitemap: " . $urlPath . "sitemap_index.xml\n");

// Add all individual sitemaps
for ($i = 1; $i <= $currentSitemapNum; $i++) {
    fwrite($robotsFile, "Sitemap: " . $urlPath . "sitemap{$i}.xml\n");
}

fclose($robotsFile);

echo "SITEMAPS, SITEMAP INDEX, AND ROBOTS.TXT CREATED SUCCESSFULLY!";
?>
