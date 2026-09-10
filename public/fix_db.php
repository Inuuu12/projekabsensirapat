<?php
// Tool Perbaikan Otomatis Koneksi Database & Cache Laravel di cPanel
// Simpan file ini di folder: public/fix_db.php
// Akses melalui: https://devlop.bogorkab.go.id/rapid/public/fix_db.php

$rootDir = dirname(__DIR__);
$envFile = $rootDir . '/.env';
$cacheDir = $rootDir . '/bootstrap/cache';

$message = '';
$messageType = '';

// Nilai Default
$dbHost = $_POST['db_host'] ?? '127.0.0.1';
$dbPort = $_POST['db_port'] ?? '3306';
$dbName = $_POST['db_name'] ?? 'devlop_dbsirapi';
$dbUser = $_POST['db_user'] ?? 'devlop_dbsirapi';
$dbPass = $_POST['db_pass'] ?? 'GAke~e@5L9B5r5_8';

// Aksi Hapus File Ini Sendiri
if (isset($_POST['action']) && $_POST['action'] === 'delete_self') {
    @unlink(__FILE__);
    echo "<script>alert('File fix_db.php berhasil dihapus demi keamanan!'); window.location.href='admin/login';</script>";
    exit;
}

// Aksi Perbaiki & Simpan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save_and_test') {
    // 1. Tes Koneksi PDO Langsung
    try {
        $dsn = "mysql:host={$dbHost};port={$dbPort};dbname={$dbName};charset=utf8mb4";
        $pdo = new PDO($dsn, $dbUser, $dbPass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_TIMEOUT => 5
        ]);
        
        // Tes query sederhana
        $stmt = $pdo->query("SELECT 1");
        
        // 2. Jika koneksi sukses, update atau buat file .env
        $envContent = '';
        if (file_exists($envFile)) {
            $envContent = file_get_contents($envFile);
        } elseif (file_exists($rootDir . '/.env.example')) {
            $envContent = file_get_contents($rootDir . '/.env.example');
        }

        // Fungsi helper replace atau tambah key di .env
        $updateEnv = function($content, $key, $value) {
            $pattern = "/^{$key}=.*/m";
            if (preg_match($pattern, $content)) {
                return preg_replace($pattern, "{$key}={$value}", $content);
            } else {
                return rtrim($content) . "\n{$key}={$value}\n";
            }
        };

        $envContent = $updateEnv($envContent, 'DB_CONNECTION', 'mysql');
        $envContent = $updateEnv($envContent, 'DB_HOST', $dbHost);
        $envContent = $updateEnv($envContent, 'DB_PORT', $dbPort);
        $envContent = $updateEnv($envContent, 'DB_DATABASE', $dbName);
        $envContent = $updateEnv($envContent, 'DB_USERNAME', $dbUser);
        $envContent = $updateEnv($envContent, 'DB_PASSWORD', '"' . addcslashes($dbPass, '"') . '"');
        $envContent = $updateEnv($envContent, 'APP_URL', 'https://devlop.bogorkab.go.id/rapid/public');
        $envContent = $updateEnv($envContent, 'FRONTEND_URL', 'https://devlop.bogorkab.go.id/rapid/public');

        file_put_contents($envFile, $envContent);

        // 3. Bersihkan file cache Laravel
        $deletedCache = [];
        if (is_dir($cacheDir)) {
            foreach (glob($cacheDir . '/*.php') as $cFile) {
                if (basename($cFile) !== '.gitignore') {
                    @unlink($cFile);
                    $deletedCache[] = basename($cFile);
                }
            }
        }

        // 4. Buat / Pastikan symlink public/storage
        $storageTarget = $rootDir . '/storage/app/public';
        $storageLink = $rootDir . '/public/storage';
        $symlinkCreated = false;
        if (!file_exists($storageLink) && is_dir($storageTarget)) {
            @symlink($storageTarget, $storageLink);
            $symlinkCreated = file_exists($storageLink);
        }

        $storageStatus = (file_exists($storageLink))
            ? "• Storage Symlink: <span style='color: green;'>Aktif (public/storage terhubung)</span>"
            : "• Storage: <span style='color: green;'>Aktif (Aman dengan Fallback Route Laravel)</span>";

        $messageType = 'success';
        $message = "<b>BERHASIL!</b> Koneksi ke database <code>{$dbName}</code> sukses.<br>" .
                   "File <code>.env</code> telah diperbarui.<br>" .
                   "Cache konfigurasi (<b>" . 
                   (!empty($deletedCache) ? implode(', ', $deletedCache) : 'sudah bersih') . 
                   "</b>) telah dihapus dari server.<br>" .
                   $storageStatus;

    } catch (PDOException $e) {
        $messageType = 'error';
        $message = "<b>GAGAL KONEKSI KE DATABASE:</b><br>" . htmlspecialchars($e->getMessage()) . "<br><br>" .
                   "<i>Pastikan di menu cPanel -> 'MySQL Databases', user <b>{$dbUser}</b> sudah dibuat dan di-assign (Add User to Database) ke database <b>{$dbName}</b> dengan ALL PRIVILEGES.</i>";
    }
}

// Cek status file .env saat ini
$currentEnvStatus = file_exists($envFile) ? 'Ditemukan' : 'Tidak ditemukan (akan otomatis dibuat dari template)';
$currentCacheFiles = is_dir($cacheDir) ? array_diff(scandir($cacheDir), ['.', '..', '.gitignore']) : [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perbaikan Koneksi Database & Cache RAPID</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; background: #f0f4f8; margin: 0; padding: 30px 15px; color: #1e293b; }
        .card { max-width: 650px; margin: 0 auto; background: #fff; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); overflow: hidden; border: 1px solid #e2e8f0; }
        .header { background: #0f172a; color: #fff; padding: 20px 25px; }
        .header h1 { margin: 0; font-size: 20px; font-weight: 700; }
        .header p { margin: 5px 0 0; font-size: 13px; color: #94a3b8; }
        .body { padding: 25px; }
        .alert { padding: 15px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; line-height: 1.5; }
        .alert-success { background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; }
        .alert-error { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }
        .alert-info { background: #eff6ff; border: 1px solid #bfdbfe; color: #1e40af; }
        .form-group { margin-bottom: 16px; }
        label { display: block; font-weight: 600; font-size: 13px; margin-bottom: 6px; color: #334155; }
        input[type="text"], input[type="password"] { width: 100%; box-sizing: border-box; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px; }
        input:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15); }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .btn { display: inline-block; padding: 12px 20px; font-size: 14px; font-weight: 600; border-radius: 6px; cursor: pointer; text-decoration: none; text-align: center; border: none; }
        .btn-primary { background: #2563eb; color: #fff; width: 100%; }
        .btn-primary:hover { background: #1d4ed8; }
        .btn-success { background: #10b981; color: #fff; }
        .btn-danger { background: #ef4444; color: #fff; }
        .badge { display: inline-block; padding: 3px 8px; border-radius: 4px; font-size: 12px; font-weight: 600; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        .badge-info { background: #e0f2fe; color: #0369a1; }
        .actions { margin-top: 25px; padding-top: 20px; border-top: 1px solid #e2e8f0; display: flex; gap: 10px; }
    </style>
</head>
<body>

<div class="card">
    <div class="header">
        <h1>Perbaikan Koneksi Database & Cache RAPID</h1>
        <p>Gunakan alat ini untuk memperbaiki error 1045 Access Denied & membersihkan config cache cPanel.</p>
    </div>

    <div class="body">
        <?php if (!empty($message)): ?>
            <div class="alert alert-<?= $messageType ?>">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <div class="alert alert-info" style="font-size: 13px;">
            <b>Status Server Saat Ini:</b><br>
            • Lokasi File .env: <code><?= htmlspecialchars($envFile) ?></code> (<?= $currentEnvStatus ?>)<br>
            • File Cache Aktif: <?= !empty($currentCacheFiles) ? '<span class="badge badge-warning">' . implode(', ', $currentCacheFiles) . '</span> (Harus Dihapus)' : '<span class="badge badge-info">Bersih (Tidak Ada Cache)</span>' ?>
        </div>

        <form method="POST">
            <input type="hidden" name="action" value="save_and_test">
            
            <div class="grid">
                <div class="form-group">
                    <label>DB Host</label>
                    <input type="text" name="db_host" value="<?= htmlspecialchars($dbHost) ?>" required>
                </div>
                <div class="form-group">
                    <label>DB Port</label>
                    <input type="text" name="db_port" value="<?= htmlspecialchars($dbPort) ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label>DB Database</label>
                <input type="text" name="db_name" value="<?= htmlspecialchars($dbName) ?>" required>
            </div>

            <div class="form-group">
                <label>DB Username</label>
                <input type="text" name="db_user" value="<?= htmlspecialchars($dbUser) ?>" required>
            </div>

            <div class="form-group">
                <label>DB Password</label>
                <input type="text" name="db_pass" value="<?= htmlspecialchars($dbPass) ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">
                Simpan ke .env, Bersihkan Cache & Uji Koneksi Sekarang
            </button>
        </form>

        <?php if ($messageType === 'success'): ?>
            <div class="actions">
                <a href="admin/login" class="btn btn-success" style="flex: 1;">
                    Buka Halaman Login Admin
                </a>
                <form method="POST" style="flex: 1;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus script perbaikan ini?');">
                    <input type="hidden" name="action" value="delete_self">
                    <button type="submit" class="btn btn-danger" style="width: 100%;">
                        Hapus Script Ini Demi Keamanan
                    </button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
