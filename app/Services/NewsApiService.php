<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NewsApiService
{
    private const CACHE_KEY = 'indonesia_news_api_feed_v1';
    private const CACHE_TTL_SECONDS = 600; // 10 menit
    private const TIMEZONE = 'Asia/Jakarta';

    /**
     * Daftar feed berita resmi Indonesia.
     */
    private array $sources = [
        [
            'name' => 'Antara News',
            'slug' => 'antara',
            'url' => 'https://www.antaranews.com/rss/terkini.xml',
            'category' => 'Nasional',
        ],
        [
            'name' => 'CNN Indonesia',
            'slug' => 'cnn',
            'url' => 'https://www.cnnindonesia.com/nasional/rss',
            'category' => 'Nasional',
        ],
        [
            'name' => 'Tempo',
            'slug' => 'tempo',
            'url' => 'https://rss.tempo.co/nasional',
            'category' => 'Nasional',
        ],
    ];

    /**
     * Mengambil seluruh daftar berita terkini dari API/Feed dengan Cache.
     *
     * @return Collection<int, object>
     */
    public function getNews(array $filters = []): Collection
    {
        $merged = Cache::remember(self::CACHE_KEY, self::CACHE_TTL_SECONDS, function () {
            return $this->fetchFromAllSources();
        });

        // Filter berdasarkan kata kunci pencarian
        if (! empty($filters['keyword'])) {
            $keyword = strtolower(trim($filters['keyword']));
            $merged = $merged->filter(function ($item) use ($keyword) {
                return str_contains(strtolower($item->judul), $keyword)
                    || str_contains(strtolower($item->isi_berita), $keyword)
                    || str_contains(strtolower($item->sumber), $keyword);
            });
        }

        // Filter berdasarkan portal sumber (slug atau nama)
        if (! empty($filters['sumber']) && $filters['sumber'] !== 'semua') {
            $sumber = strtolower(trim($filters['sumber']));
            $merged = $merged->filter(function ($item) use ($sumber) {
                return strtolower($item->sumber_slug ?? '') === $sumber
                    || str_contains(strtolower($item->sumber), $sumber);
            });
        }

        return $merged->values();
    }

    /**
     * Memaksa refresh cache feed berita API.
     */
    public function refreshCache(): int
    {
        Cache::forget(self::CACHE_KEY);
        $news = $this->fetchFromAllSources();
        Cache::put(self::CACHE_KEY, $news, self::CACHE_TTL_SECONDS);

        return $news->count();
    }

    /**
     * Mengambil berita terbaru untuk beranda atau sidebar.
     *
     * @return Collection<int, object>
     */
    public function getLatest(int $limit = 3): Collection
    {
        return $this->getNews()->take($limit);
    }

    /**
     * Mencari berita berdasarkan ID unik.
     */
    public function findNews(int|string|null $id): ?object
    {
        if (! $id) {
            return $this->getLatest(1)->first();
        }

        return $this->getNews()->first(fn ($item) => (string) $item->id_berita === (string) $id);
    }

    /**
     * Mengambil daftar portal sumber yang tersedia.
     */
    public function getAvailableSources(): array
    {
        return array_merge([
            ['name' => 'Semua Sumber', 'slug' => 'semua'],
        ], array_map(fn ($s) => ['name' => $s['name'], 'slug' => $s['slug']], $this->sources));
    }

    /**
     * Mengambil feed dari seluruh portal sumber.
     */
    protected function fetchFromAllSources(): Collection
    {
        $items = collect();

        foreach ($this->sources as $source) {
            try {
                $response = Http::withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                    'Accept' => 'application/rss+xml, application/xml, text/xml, */*',
                ])->timeout(6)->get($source['url']);

                if ($response->successful()) {
                    $parsed = $this->parseRssFeed($response->body(), $source);
                    $items = $items->concat($parsed);
                }
            } catch (\Throwable $e) {
                Log::warning("Gagal mengambil feed berita dari {$source['name']}: " . $e->getMessage());
            }
        }

        // Urutkan berdasarkan tanggal terbaru
        return $items->sortByDesc(function ($item) {
            return $item->tanggal ? $item->tanggal->timestamp : 0;
        })->values();
    }

    /**
     * Parsing isi XML / RSS feed.
     */
    protected function parseRssFeed(string $xmlContent, array $source): Collection
    {
        $items = collect();
        libxml_use_internal_errors(true);
        $xml = @simplexml_load_string($xmlContent, 'SimpleXMLElement', LIBXML_NOCDATA);

        if (! $xml || ! isset($xml->channel->item)) {
            return $items;
        }

        foreach ($xml->channel->item as $entry) {
            $link = trim((string) $entry->link);
            if (! $link) {
                continue;
            }

            $title = trim(strip_tags((string) $entry->title));
            $description = trim(strip_tags((string) $entry->description));

            // Ekstrak URL gambar
            $image = $this->extractImageFromItem($entry);

            // Parsing tanggal rilis
            $pubDate = (string) $entry->pubDate;
            try {
                $tanggal = $pubDate ? Carbon::parse($pubDate, self::TIMEZONE) : Carbon::now(self::TIMEZONE);
            } catch (\Throwable) {
                $tanggal = Carbon::now(self::TIMEZONE);
            }

            // Generate ID deterministik integer positif dari URL
            $id = abs(crc32($link));

            $items->push((object) [
                'id_berita' => $id,
                'judul' => $title,
                'isi_berita' => $description,
                'gambar' => $image ?: asset('assets/foto/Beritalogo.png'),
                'sumber' => $source['name'],
                'sumber_slug' => $source['slug'],
                'tanggal' => $tanggal,
                'url' => $link,
                'is_internal' => false,
            ]);
        }

        return $items;
    }

    /**
     * Ekstraksi gambar thumbnail dari item RSS.
     */
    protected function extractImageFromItem(\SimpleXMLElement $entry): ?string
    {
        // 1. Cek elemen enclosure
        if (isset($entry->enclosure) && (string) $entry->enclosure['url']) {
            $url = (string) $entry->enclosure['url'];
            if (filter_var($url, FILTER_VALIDATE_URL)) {
                return $url;
            }
        }

        // 2. Cek media:content atau media:thumbnail jika ada namespace
        $media = $entry->children('http://search.yahoo.com/mrss/');
        if ($media && isset($media->content)) {
            $url = (string) $media->content->attributes()->url;
            if (filter_var($url, FILTER_VALIDATE_URL)) {
                return $url;
            }
        }
        if ($media && isset($media->thumbnail)) {
            $url = (string) $media->thumbnail->attributes()->url;
            if (filter_var($url, FILTER_VALIDATE_URL)) {
                return $url;
            }
        }

        // 3. Cek tag <img> di dalam deskripsi HTML
        $description = (string) $entry->description;
        if (preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', $description, $matches)) {
            if (filter_var($matches[1], FILTER_VALIDATE_URL)) {
                return $matches[1];
            }
        }

        return null;
    }
}
