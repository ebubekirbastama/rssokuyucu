<?php

$rssNtvUrl = 'https://www.ntv.com.tr/rss';
$rssAhaberUrl = 'https://www.ahaber.com.tr/rss-bilgi';
$ntvxpath = "//li[@class='rss-item']//a";
$atvxpath = "//a[starts-with(@href, '/rss/')]";

function NtvRSS() {
    global $ntvxpath, $rssNtvUrl; // Global değişkenlere erişim
    // Sonuçları saklamak için bir dizi oluştur
    $links = [];

    // RSS kaynağını oku
    $rssContent = file_get_contents($rssNtvUrl);

    if ($rssContent === false) {
        die("RSS kaynağına erişilemedi.");
    }

    // DOMDocument nesnesini oluştur
    $dom = new DOMDocument();

    // Hataları gizleyerek yükleme
    libxml_use_internal_errors(true);
    $dom->loadHTML($rssContent);
    libxml_clear_errors();

    // DOMXPath oluştur
    $xpath = new DOMXPath($dom);

    // XPath ile öğeleri seç
    $elements = $xpath->query($ntvxpath);

    // Öğelerden linkleri al ve diziye ekle
    foreach ($elements as $element) {
        $href = $element->getAttribute('href');
        if (!empty($href)) {
            $links[] = "https://www.ntv.com.tr" . $href;
        }
    }

    return $links;
}

function AhaberRSS() {

    global $rssAhaberUrl, $atvxpath;
    // Sonuçları saklamak için bir dizi oluştur
    $links = [];

    // RSS kaynağını oku
    $rssContent = file_get_contents($rssAhaberUrl);

    if ($rssContent === false) {
        die("RSS kaynağına erişilemedi.");
    }

    // DOMDocument nesnesini oluştur
    $dom = new DOMDocument();

    // Hataları gizleyerek yükleme
    libxml_use_internal_errors(true);
    $dom->loadHTML($rssContent);
    libxml_clear_errors();

    // DOMXPath oluştur
    $xpath = new DOMXPath($dom);

    // XPath ile öğeleri seç
    $elements = $xpath->query($atvxpath);

    // Öğelerden linkleri al ve diziye ekle
    foreach ($elements as $element) {
        $href = $element->getAttribute('href');
        if (!empty($href)) {
            $links[] = "https://ahaber.com.tr/" . $href;
        }
    }

    return $links;
}

$links = AhaberRSS();

// Sonuçları ekrana yazdır
print_r($links);
