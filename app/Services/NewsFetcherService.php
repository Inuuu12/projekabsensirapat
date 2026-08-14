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

            $html = $response->body();

            $meta = $this->parseHtmlMeta($html, $url);

            return $meta;
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

        // Fetch title
        $judul = $this->getXpathContent($xpath, '//meta[@property="og:title"]/@content')
            ?: $this->getXpathContent($xpath, '//meta[@name="twitter:title"]/@content')
            ?: $this->getNodeValue($doc, 'title')
            ?: 'Berita Tanpa Judul';

        // Fetch description/content summary
        $isiBerita = $this->getXpathContent($xpath, '//meta[@property="og:description"]/@content')
            ?: $this->getXpathContent($xpath, '//meta[@name="description"]/@content')
            ?: $this->getXpathContent($xpath, '//meta[@name="twitter:description"]/@content')
            ?: 'Ringkasan berita dari sumber luar.';

        // Fetch image
        $gambar = $this->getXpathContent($xpath, '//meta[@property="og:image"]/@content')
            ?: $this->getXpathContent($xpath, '//meta[@name="twitter:image"]/@content')
            ?: $this->getXpathContent($xpath, '//meta[@property="og:image:secure_url"]/@content')
            ?: '';

        // If image is relative URL, make absolute
        if ($gambar && ! filter_var($gambar, FILTER_VALIDATE_URL)) {
            $parsedUrl = parse_url($url);
            $scheme = $parsedUrl['scheme'] ?? 'https';
            $host = $parsedUrl['host'] ?? '';
            $gambar = $scheme . '://' . $host . '/' . ltrim($gambar, '/');
        }

        // Fetch site name / source
        $host = parse_url($url, PHP_URL_HOST) ?? 'Internet';
        $siteName = $this->getXpathContent($xpath, '//meta[@property="og:site_name"]/@content')
            ?: str_replace('www.', '', $host);

        // Fetch publish date if available
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
            'gambar' => $gambar ?: 'foto/Beritalogo.png',
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
     * Sync latest news from Portal Pemkab Bogor & Diskominfo.
     */
    public function syncPemkabBogorNews(): int
    {
        $sources = [
            [
                'name' => 'Pemkab Bogor',
                'url' => 'https://bogorkab.go.id/berita',
                'fallback_image' => 'https://bogorkab.go.id/assets/images/logo1.png',
            ],
            [
                'name' => 'Diskominfo Kab. Bogor',
                'url' => 'https://diskominfo.bogorkab.go.id',
                'fallback_image' => 'foto/Beritalogo.png',
            ],
        ];

        $addedCount = 0;

        foreach ($sources as $source) {
            try {
                $response = Http::withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                ])->timeout(10)->get($source['url']);

                if (!$response->successful()) {
                    continue;
                }

                $meta = $this->parseHtmlMeta($response->body(), $source['url']);
                
                // Check if already exists
                $exists = Berita::where('judul', $meta['judul'])->exists();
                if (!$exists && !empty($meta['judul'])) {
                    Berita::create([
                        'judul' => $meta['judul'],
                        'isi_berita' => $meta['isi_berita'],
                        'tanggal' => $meta['tanggal'],
                        'gambar' => $meta['gambar'] ?: $source['fallback_image'],
                        'sumber' => $source['name'],
                    ]);
                    $addedCount++;
                }
            } catch (\Exception $e) {
                Log::warning("Sinkronisasi berita dari {$source['name']} gagal: " . $e->getMessage());
            }
        }

        return $addedCount;
    }
}
