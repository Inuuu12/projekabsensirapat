<?php
// Helper pembersih cache & pengecekan koneksi database di server cPanel
define('LARAVEL_START', microtime(true));

$bootstrapCacheDir = __DIR__ . '/../bootstrap/cache';
$cleared = [];

if (is_dir($bootstrapCacheDir)) {
    foreach (glob($bootstrapCacheDir . '/*.php') as $file) {
        if (basename($file) !== '.gitignore') {
            @unlink($file);
            $cleared[] = basename($file);
        }
    }
}

echo "<h2>1. Hasil Pembersihan Cache bootstrap/cache/</h2>";
if (!empty($cleared)) {
    echo "<p style='color: green; font-weight: bold;'>File cache berhasil dihapus: " . implode(', ', $cleared) . "</p>";
} else {
    echo "<p style='color: gray;'>Folder <code>bootstrap/cache/</code> sudah bersih (tidak ada file cache lama).</p>";
}

echo "<hr><h2>2. Konfigurasi yang Dibaca Laravel</h2>";

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

$dbConfig = config('database.connections.mysql');
$username = $dbConfig['username'] ?? '';
$database = $dbConfig['database'] ?? '';
$password = $dbConfig['password'] ?? '';

echo "<ul>";
echo "<li><b>DB_HOST:</b> " . htmlspecialchars($dbConfig['host'] ?? '') . "</li>";
echo "<li><b>DB_DATABASE:</b> " . htmlspecialchars($database) . "</li>";
echo "<li><b>DB_USERNAME:</b> " . htmlspecialchars($username) . "</li>";
echo "<li><b>DB_PASSWORD:</b> " . (!empty($password) ? '<span style="color:green;">Terisi (' . strlen($password) . ' karakter)</span>' : '<span style="color:red; font-weight:bold;">KOSONG (NO PASSWORD)</span>') . "</li>";
echo "</ul>";

echo "<hr><h2>3. Uji Koneksi Database MySQL</h2>";
try {
    \Illuminate\Support\Facades\DB::connection()->getPdo();
    $connectedDb = \Illuminate\Support\Facades\DB::connection()->getDatabaseName();
    echo "<h3 style='color: green;'>✅ SUKSES! Database berhasil terkoneksi ke: " . htmlspecialchars($connectedDb) . "</h3>";
    echo "<p>Sekarang Anda sudah bisa login kembali di <a href='admin/login'>Halaman Login Admin</a>.</p>";
} catch (\Exception $e) {
    echo "<h3 style='color: red;'>❌ GAGAL: " . htmlspecialchars($e->getMessage()) . "</h3>";
    echo "<p>Silakan periksa kembali file <code>.env</code> di root folder project Anda.</p>";
}

echo "<hr><p style='color: orange;'>⚠️ <i>Catatan: Setelah pengecekan berhasil, segera hapus file <code>clear_cache.php</code> ini dari folder <code>public/</code> demi keamanan server.</i></p>";
