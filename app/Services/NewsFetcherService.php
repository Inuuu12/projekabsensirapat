<?php

namespace App\Services;

use App\Models\Berita;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NewsFetcherService
{
    /**
     * Fetch OpenGraph metadata from a given news URL.
     */
    public function fetchOpenGraph(string $url): array
    {
        $url = trim($url);
        if (! filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException('URL berita tidak valid.');
        }

        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            ])->timeout(10)->get($url);

            if (! $response->successful()) {
                throw new \RuntimeException('Gagal mengakses URL berita. Status HTTP: ' . $response->status());
            }

            return $this->parseHtmlMeta($response->body(), $url);
        } catch (\Exception $e) {
            Log::error("Gagal fetch meta dari URL {$url}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Parse OpenGraph and Meta tags from HTML body.
     */
    protected function parseHtmlMeta(string $html, string $url): array
    {
        libxml_use_internal_errors(true);
        $doc = new \DOMDocument();
        @$doc->loadHTML('<?xml encoding="UTF-8">' . $html);
        libxml_clear_errors();

        $xpath = new \DOMXPath($doc);

        $judul = $this->getXpathContent($xpath, '//meta[@property="og:title"]/@content')
            ?: $this->getXpathContent($xpath, '//meta[@name="twitter:title"]/@content')
            ?: $this->getNodeValue($doc, 'title')
            ?: 'Berita Tanpa Judul';

        $isiBerita = $this->getXpathContent($xpath, '//meta[@property="og:description"]/@content')
            ?: $this->getXpathContent($xpath, '//meta[@name="description"]/@content')
            ?: $this->getXpathContent($xpath, '//meta[@name="twitter:description"]/@content')
            ?: 'Ringkasan berita dari sumber luar.';

        $gambar = $this->getXpathContent($xpath, '//meta[@property="og:image"]/@content')
            ?: $this->getXpathContent($xpath, '//meta[@name="twitter:image"]/@content')
            ?: '';

        if ($gambar && ! filter_var($gambar, FILTER_VALIDATE_URL)) {
            $parsedUrl = parse_url($url);
            $scheme = $parsedUrl['scheme'] ?? 'https';
            $host = $parsedUrl['host'] ?? '';
            $gambar = $scheme . '://' . $host . '/' . ltrim($gambar, '/');
        }

        $host = parse_url($url, PHP_URL_HOST) ?? 'Internet';
        $siteName = $this->getXpathContent($xpath, '//meta[@property="og:site_name"]/@content')
            ?: str_replace('www.', '', $host);

        $publishedTime = $this->getXpathContent($xpath, '//meta[@property="article:published_time"]/@content')
            ?: $this->getXpathContent($xpath, '//meta[@name="pubdate"]/@content')
            ?: date('Y-m-d');

        try {
            $tanggal = date('Y-m-d', strtotime($publishedTime));
        } catch (\Exception $e) {
            $tanggal = date('Y-m-d');
        }

        return [
            'judul' => trim($judul),
            'isi_berita' => trim($isiBerita),
            'gambar' => $gambar ?: 'assets/foto/Beritalogo.png',
            'sumber' => trim($siteName),
            'tanggal' => $tanggal,
            'url' => $url,
        ];
    }

    protected function getXpathContent(\DOMXPath $xpath, string $expression): string
    {
        $nodes = $xpath->query($expression);
        if ($nodes && $nodes->length > 0) {
            return trim($nodes->item(0)->nodeValue);
        }
        return '';
    }

    protected function getNodeValue(\DOMDocument $doc, string $tagName): string
    {
        $nodes = $doc->getElementsByTagName($tagName);
        if ($nodes && $nodes->length > 0) {
            return trim($nodes->item(0)->nodeValue);
        }
        return '';
    }

    /**
     * Sync actual individual news articles from Diskominfo, Pemkab Bogor, and Tribunnews Bogor.
     */
    public function syncPemkabBogorNews(): int
    {
        // Clean up old homepage title fallback entries
        Berita::whereIn('judul', ['Portal Resmi Kabupaten Bogor', 'Dinas Komunikasi dan Informatika'])->delete();

        $diskominfoArticles = $this->scrapeDiskominfoArticles();

        // If live scraping returned empty, fallback to curated Diskominfo news list
        if (empty($diskominfoArticles)) {
            $diskominfoArticles = $this->getCuratedDiskominfoNews();
        }

        $tribunArticles = $this->scrapeTribunnewsBogorArticles(10);

        $articles = array_merge($diskominfoArticles, $tribunArticles);

        $addedCount = 0;

        foreach ($articles as $article) {
            $exists = Berita::where('judul', $article['judul'])->exists();
            if (! $exists && ! empty($article['judul'])) {
                Berita::create([
                    'judul' => $article['judul'],
                    'isi_berita' => $article['isi_berita'],
                    'tanggal' => $article['tanggal'],
                    'gambar' => $article['gambar'],
                    'sumber' => $article['sumber'],
                ]);
                $addedCount++;
            }
        }

        return $addedCount;
    }

    /**
     * Scrape live news articles from Tribunnews Bogor (bogor.tribunnews.com).
     */
    public function scrapeTribunnewsBogorArticles(int $limit = 15): array
    {
        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            ])->timeout(12)->get('https://bogor.tribunnews.com/');

            if (! $response->successful()) {
                return [];
            }

            $html = $response->body();
            libxml_use_internal_errors(true);
            $doc = new \DOMDocument();
            @$doc->loadHTML('<?xml encoding="UTF-8">' . $html);
            libxml_clear_errors();

            $xpath = new \DOMXPath($doc);
            $cards = $xpath->query('//div[contains(@class, "listicle")] | //div[contains(@class, "p1520")] | //li[contains(@class, "pos-rel")]');

            $results = [];
            foreach ($cards as $card) {
                if (count($results) >= $limit) {
                    break;
                }

                $titleNode = $xpath->query('.//h3/a | .//h2/a', $card)->item(0);
                if (! $titleNode) {
                    continue;
                }

                $title = trim($titleNode->nodeValue);
                $url = $titleNode->getAttribute('href');

                if (empty($title) || empty($url) || str_contains($url, '/tag/')) {
                    continue;
                }

                $imgNode = $xpath->query('.//img/@src | .//img/@data-src', $card)->item(0);
                $img = $imgNode ? trim($imgNode->nodeValue) : '';

                $snippetNode = $xpath->query('.//div[contains(@class, "txt-article")] | .//p', $card)->item(0);
                $snippet = $snippetNode ? trim(str_replace(["\n", "\r"], ' ', $snippetNode->nodeValue)) : '';

                $timeNode = $xpath->query('.//time/@title | .//time', $card)->item(0);
                $dateStr = $timeNode ? trim($timeNode->nodeValue) : '';

                $tanggal = date('Y-m-d');
                if ($dateStr && preg_match('/(\d{1,2})\s+([a-zA-Z]+)\s+(\d{4})/', $dateStr, $m)) {
                    $parsed = strtotime($dateStr);
                    if ($parsed !== false) {
                        $tanggal = date('Y-m-d', $parsed);
                    }
                }

                $results[] = [
                    'judul' => $title,
                    'isi_berita' => $snippet ?: "Berita terkini dari Tribunnews Bogor: {$title}",
                    'tanggal' => $tanggal,
                    'gambar' => $img ?: 'assets/foto/Beritalogo.png',
                    'sumber' => 'Tribunnews Bogor',
                ];
            }

            return $results;
        } catch (\Exception $e) {
            Log::warning('Scrape Tribunnews Bogor error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Scrape live news cards from Diskominfo portal.
     */
    public function scrapeDiskominfoArticles(): array
    {
        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            ])->timeout(10)->get('https://diskominfo.bogorkab.go.id');

            if (! $response->successful()) {
                return [];
            }

            $html = $response->body();
            libxml_use_internal_errors(true);
            $doc = new \DOMDocument();
            @$doc->loadHTML('<?xml encoding="UTF-8">' . $html);
            libxml_clear_errors();

            $xpath = new \DOMXPath($doc);
            $cards = $xpath->query('//div[contains(@class, "post-card")]');

            $results = [];
            foreach ($cards as $card) {
                $titleNode = $xpath->query('.//h3[contains(@class, "card-title")]', $card)->item(0);
                $title = $titleNode ? trim($titleNode->nodeValue) : '';

                if (empty($title)) continue;

                $imgNode = $xpath->query('.//img[contains(@class, "card-img-top")]/@src', $card)->item(0);
                $img = $imgNode ? trim($imgNode->nodeValue) : 'assets/foto/Beritalogo.png';

                $textNode = $xpath->query('.//p[contains(@class, "card-text")]', $card)->item(0);
                $text = $textNode ? trim(str_replace(['Selengkapnya', "\n", "\r"], ' ', $textNode->nodeValue)) : '';

                $dateNode = $xpath->query('.//div[contains(@class, "topic-date")]', $card)->item(0);
                $dateStr = $dateNode ? trim($dateNode->nodeValue) : '';
                
                $tanggal = date('Y-m-d');
                if (preg_match('/(\d{2}-\d{2}-\d{4})/', $dateStr, $matches)) {
                    $dParts = explode('-', $matches[1]);
                    if (count($dParts) === 3) {
                        $tanggal = "{$dParts[2]}-{$dParts[1]}-{$dParts[0]}";
                    }
                }

                $results[] = [
                    'judul' => $title,
                    'isi_berita' => $text ?: 'Berita seputar kegiatan Diskominfo dan Pemkab Kabupaten Bogor.',
                    'tanggal' => $tanggal,
                    'gambar' => $img,
                    'sumber' => 'Diskominfo Kab. Bogor',
                ];
            }

            return $results;
        } catch (\Exception $e) {
            Log::warning('Scrape live Diskominfo articles error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Curated real Diskominfo news list for instant fallback.
     */
    protected function getCuratedDiskominfoNews(): array
    {
        return [
            [
                'judul' => 'Evaluasi dan Pelatihan Pengelolaan Website Pemerintah Desa / Desa Digital',
                'isi_berita' => 'Dalam rangka meningkatkan kapasitas aparatur desa dalam pengelolaan layanan digital, Dinas Komunikasi dan Informatika menyelenggarakan kegiatan Evaluasi dan Pelatihan Pengelolaan Website Pemerintah Desa.',
                'tanggal' => '2026-07-28',
                'gambar' => 'https://diskominfo.bogorkab.go.id/uploads/topics/17853070528111.jpg',
                'sumber' => 'Diskominfo Kab. Bogor',
            ],
            [
                'judul' => 'Bimbingan Teknis Website Desa Kecamatan Tajurhalang dan Kecamatan Tamansari',
                'isi_berita' => 'Dalam upaya meningkatkan kualitas layanan digital di tingkat desa, Dinas Komunikasi dan Informatika melaksanakan kegiatan evaluasi dan pelatihan pengelolaan Website Pemerintah Desa di Kecamatan Tajurhalang dan Tamansari.',
                'tanggal' => '2026-07-23',
                'gambar' => 'https://diskominfo.bogorkab.go.id/uploads/topics/17848102567781.jpeg',
                'sumber' => 'Diskominfo Kab. Bogor',
            ],
            [
                'judul' => 'Kadiskominfo Kabupaten Bogor Nobar Final Piala Dunia 2026 Bersama Bupati di Alun-Alun Tegar Beriman',
                'isi_berita' => 'Kepala Dinas Komunikasi dan Informatika (Diskominfo) Kabupaten Bogor turut menghadiri kegiatan nonton bareng (nobar) Final Piala Dunia 2026 bersama jajaran Pemkab dan masyarakat di Alun-Alun Tegar Beriman Cibinong.',
                'tanggal' => '2026-07-20',
                'gambar' => 'assets/foto/Beritalogo.png',
                'sumber' => 'Diskominfo Kab. Bogor',
            ],
            [
                'judul' => 'Pemkab Bogor Perkuat Tata Kelola Digital Demi Tingkatkan Pelayanan Publik',
                'isi_berita' => 'CIBINONG – Atas arahan Bupati Bogor, Pemerintah Kabupaten Bogor berkomitmen untuk memperkuat infrastruktur dan tata kelola digital di seluruh Perangkat Daerah demi meningkatkan efisiensi dan kualitas pelayanan publik.',
                'tanggal' => '2026-07-14',
                'gambar' => 'assets/foto/Suratlogo.png',
                'sumber' => 'Pemkab Bogor',
            ],
        ];
    }
}
