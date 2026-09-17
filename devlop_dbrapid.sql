-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: devlop_dbsirapi
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('sirapi-cache-indonesia_news_api_feed_v1','O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}',1788334020);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2026_07_20_000001_create_sirapi_md_admin_table',1),(2,'2026_07_20_000002_create_sirapi_md_pegawai_table',1),(3,'2026_07_20_000003_create_sirapi_md_ruangrapat_table',1),(4,'2026_07_20_000004_create_sirapi_md_statusagenda_table',1),(5,'2026_07_20_000005_create_sirapi_md_peserta_table',1),(6,'2026_07_20_000006_create_sirapi_md_bidang_table',1),(7,'2026_07_20_000006_create_sirapi_md_jabatan_table',1),(8,'2026_07_20_000009_create_sirapi_md_galeri_table',1),(9,'2026_07_20_000010_create_sirapi_md_ulangtahun_table',1),(10,'2026_07_20_000012_create_sirapi_md_agenda_table',1),(11,'2026_07_20_000013_create_sirapi_md_kunjungan_table',1),(12,'2026_07_20_000016_create_sirapi_md_dataaduan_table',1),(13,'2026_07_20_000017_create_sirapi_md_tamu_table',1),(14,'2026_07_20_000018_create_sirapi_md_qrcode_table',1),(15,'2026_07_20_000020_create_sirapi_md_dokumen_notulen_table',1),(16,'2026_07_20_000021_create_sirapi_md_logbook_table',1),(17,'2026_07_20_000023_create_sirapi_md_kehadiran_table',1),(18,'2026_07_23_005851_create_sessions_table',1),(19,'2026_07_29_000001_create_sirapi_md_video_table',1),(20,'2026_08_06_151356_create_cache_table',1),(21,'2026_09_10_000001_create_sirapi_md_dinas_table',2),(22,'2026_09_10_000002_create_sirapi_md_kecamatan_table',2),(23,'2026_09_10_000003_add_role_and_instansi_to_sirapi_md_admin_table',2),(24,'2026_09_01_084114_add_status_verifikasi_to_sirapi_md_pegawai_table',3),(25,'2026_09_01_094400_add_foto_kehadiran_to_sirapi_md_kehadiran_table',3),(26,'2026_09_10_083749_create_sirapi_md_dinas_table',4),(27,'2026_09_10_083750_add_dinas_id_to_tables',4),(28,'2026_09_15_000001_add_id_kecamatan_to_agenda_ruang_pegawai_table',5),(29,'2026_09_15_000002_make_id_ruangrapat_nullable_in_agenda_table',5),(30,'2026_09_15_150000_add_gps_coords_to_sirapi_md_dinas_table',5),(31,'2026_09_17_000001_add_id_kecamatan_to_sirapi_md_kunjungan_table',6);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('MHhAnLEKQXaGgeQT5U48f4A3imthQXGaij5GEIAa',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiV1p0UUNUTnhKSlA4cUt2OFl0YnBMV21nUXdPMXR1YVNOeERoVmZpeiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wdWJsaWsvbWFzdWthbiI7czo1OiJyb3V0ZSI7czoxNDoicHVibGlrLm1hc3VrYW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1788333652);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sirapi_md_admin`
--

DROP TABLE IF EXISTS `sirapi_md_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sirapi_md_admin` (
  `id_admin` bigint unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'superadmin',
  `id_dinas` bigint unsigned DEFAULT NULL,
  `id_kecamatan` bigint unsigned DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_hp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_admin`),
  KEY `sirapi_md_admin_id_dinas_foreign` (`id_dinas`),
  KEY `sirapi_md_admin_id_kecamatan_foreign` (`id_kecamatan`),
  CONSTRAINT `sirapi_md_admin_id_dinas_foreign` FOREIGN KEY (`id_dinas`) REFERENCES `sirapi_md_dinas` (`id_dinas`) ON DELETE SET NULL,
  CONSTRAINT `sirapi_md_admin_id_kecamatan_foreign` FOREIGN KEY (`id_kecamatan`) REFERENCES `sirapi_md_kecamatan` (`id_kecamatan`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sirapi_md_admin`
--

LOCK TABLES `sirapi_md_admin` WRITE;
/*!40000 ALTER TABLE `sirapi_md_admin` DISABLE KEYS */;
INSERT INTO `sirapi_md_admin` VALUES (1,'admin','Administrator','$2y$12$5pvC32aTNzLgutkuatT1Zuww1VtCv7AWz2plOWyudQL8/.O4zF8tO','superadmin',NULL,NULL,NULL,NULL,'aktif','2026-09-15 04:09:56','2026-09-15 04:09:56'),(2,'dinas_diskominfo','Admin Diskominfo','$2y$12$5EGY0bdxP5JIiy55Rk3IsuVfod1edP0Hq3xAbmbaBk5ZPK1Yb7riu','dinas',1,NULL,'diskominfo@bogorkab.go.id','081234567890','aktif','2026-09-15 08:54:06','2026-09-15 08:54:06'),(3,'camat_cibinong','Admin Kecamatan Cibinong','$2y$12$CZmnD9J4nIQlaVDu2tnG9OD.czge38fDQcHC7g22dJCYuKBVWvIVa','kecamatan',NULL,1,'kecibinong@bogorkab.go.id','081298765432','aktif','2026-09-15 08:54:06','2026-09-15 08:54:06'),(4,'login','daffa','$2y$12$Yw/x3Zfep8xt9cvcjakLuOm5v.h11GS6LjdOm5/H6qlsCSnHJYgzi','dinas',7,NULL,'inuunuu09@gmail.com','0987890987','aktif','2026-09-10 03:20:18','2026-09-10 03:21:16'),(5,'adminkominfo','Admin Kominfo','$2y$12$M6aT.GCfkum7IID7Vhas.OOadkhcTuLvVJqbCJ4stl98CeQl/awG.','admin_dinas',10,NULL,NULL,NULL,'aktif','2026-09-10 04:09:32','2026-09-15 04:09:57'),(6,'adminpendidikan','Admin Pendidikan','$2y$12$haqEsWYLrKPOGuY2xxOO1uBcL3/QqVpJU89ebBJ1VItGi7VqT4jhq','admin_dinas',2,NULL,NULL,NULL,'aktif','2026-09-10 04:09:32','2026-09-15 04:09:57'),(7,'adminkesehatan','Admin Kesehatan','$2y$12$n7L8ODIzdlmFp6uVef/YjuXI.WizCFR0c30oVIdZWrl6G4Lunwj8u','admin_dinas',3,NULL,NULL,NULL,'aktif','2026-09-10 04:09:32','2026-09-15 04:09:58'),(8,'polpp','juna','$2y$12$vKgs/h0LhBuYH1vR0Nh3WuF0qVhZcI7oSnwx41WjnzRZ.2Zf5KDzS','dinas',8,NULL,'inuunuu09@gmail.com','0987890987','aktif','2026-09-10 04:19:52','2026-09-10 04:19:52');
/*!40000 ALTER TABLE `sirapi_md_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sirapi_md_agenda`
--

DROP TABLE IF EXISTS `sirapi_md_agenda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sirapi_md_agenda` (
  `id_agenda` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_agenda` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori_surat` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'internal',
  `asal_surat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ditugaskan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lampiran` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal` date NOT NULL,
  `waktu` time NOT NULL,
  `waktu_selesai` time DEFAULT NULL,
  `kuota` int DEFAULT NULL,
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_fr` tinyint(1) DEFAULT NULL,
  `status_qr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_ruangrapat` bigint unsigned DEFAULT NULL,
  `id_statusagenda` bigint unsigned NOT NULL,
  `id_dinas` bigint unsigned DEFAULT NULL,
  `id_kecamatan` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id_agenda`),
  KEY `sirapi_md_agenda_id_ruangrapat_foreign` (`id_ruangrapat`),
  KEY `sirapi_md_agenda_id_statusagenda_foreign` (`id_statusagenda`),
  KEY `sirapi_md_agenda_id_dinas_foreign` (`id_dinas`),
  KEY `sirapi_md_agenda_id_kecamatan_foreign` (`id_kecamatan`),
  CONSTRAINT `sirapi_md_agenda_id_dinas_foreign` FOREIGN KEY (`id_dinas`) REFERENCES `sirapi_md_dinas` (`id_dinas`) ON DELETE SET NULL,
  CONSTRAINT `sirapi_md_agenda_id_kecamatan_foreign` FOREIGN KEY (`id_kecamatan`) REFERENCES `sirapi_md_kecamatan` (`id_kecamatan`) ON DELETE SET NULL,
  CONSTRAINT `sirapi_md_agenda_id_ruangrapat_foreign` FOREIGN KEY (`id_ruangrapat`) REFERENCES `sirapi_md_ruangrapat` (`id_ruangrapat`) ON DELETE CASCADE,
  CONSTRAINT `sirapi_md_agenda_id_statusagenda_foreign` FOREIGN KEY (`id_statusagenda`) REFERENCES `sirapi_md_statusagenda` (`id_statusagenda`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sirapi_md_agenda`
--

LOCK TABLES `sirapi_md_agenda` WRITE;
/*!40000 ALTER TABLE `sirapi_md_agenda` DISABLE KEYS */;
INSERT INTO `sirapi_md_agenda` VALUES (10,'Rapat BPBD 2','internal','APTIKA',NULL,NULL,'2026-09-15','19:50:00','00:50:00',20,'Ruang rapat 1 (Dinas Komunikasi & Informatika)',0,'aktif','2026-09-15 12:51:18','2026-09-16 09:33:26',4,2,10,NULL),(11,'agenda 1','keluar','DISKOMINFO',NULL,'agenda-lampiran/kqZSmRHq8KJ6niWoN6KM4YQCxqi1IIo2ziJpWyfJ.jpg','2026-09-15','19:57:00','01:57:00',10,'Ruang rapat 1 (DISDIK)',0,'nonaktif','2026-09-15 12:58:22','2026-09-15 12:58:22',5,2,2,NULL),(12,'Agenda Penggunaan Aplikasi ke publik','internal','disdukcakpil',NULL,NULL,'2026-09-16','15:29:00','20:29:00',5,'Aula Serbaguna (Dinas Komunikasi & Informatika (Diskominfo))',0,'aktif','2026-09-16 08:30:16','2026-09-16 09:31:19',2,2,10,NULL),(13,'Agenda Penggunaan Aplikasi ke publik','keluar','APTIKA',NULL,NULL,'2026-09-16','16:31:00','20:32:00',3,'Ruang Rapat Bidang (Dinas Komunikasi & Informatika (Diskominfo))',0,'aktif','2026-09-16 09:32:14','2026-09-16 09:34:22',3,2,1,NULL);
/*!40000 ALTER TABLE `sirapi_md_agenda` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sirapi_md_bidang`
--

DROP TABLE IF EXISTS `sirapi_md_bidang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sirapi_md_bidang` (
  `id_bidang` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_bidang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_bidang`),
  UNIQUE KEY `sirapi_md_bidang_nama_bidang_unique` (`nama_bidang`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sirapi_md_bidang`
--

LOCK TABLES `sirapi_md_bidang` WRITE;
/*!40000 ALTER TABLE `sirapi_md_bidang` DISABLE KEYS */;
INSERT INTO `sirapi_md_bidang` VALUES (1,'Sekretariat','2026-09-15 04:09:56','2026-09-15 04:09:56'),(2,'Bidang Pengelolaan Informasi dan Komunikasi Publik','2026-09-15 04:09:56','2026-09-15 04:09:56'),(3,'Bidang Aplikasi Informatika','2026-09-15 04:09:56','2026-09-15 04:09:56'),(4,'Bidang Infrastruktur Teknologi','2026-09-15 04:09:56','2026-09-15 04:09:56'),(5,'Bidang Persandian dan Statistik','2026-09-15 04:09:56','2026-09-15 04:09:56'),(6,'UPT Radio dan Televisi','2026-09-15 04:09:56','2026-09-15 04:09:56');
/*!40000 ALTER TABLE `sirapi_md_bidang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sirapi_md_dataaduan`
--

DROP TABLE IF EXISTS `sirapi_md_dataaduan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sirapi_md_dataaduan` (
  `id_dataaduan` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_pengadu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_pengadu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isi_aduan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `balasan_admin` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_admin` bigint unsigned DEFAULT NULL,
  `id_dinas` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id_dataaduan`),
  KEY `sirapi_md_dataaduan_id_admin_foreign` (`id_admin`),
  KEY `sirapi_md_dataaduan_id_dinas_foreign` (`id_dinas`),
  CONSTRAINT `sirapi_md_dataaduan_id_admin_foreign` FOREIGN KEY (`id_admin`) REFERENCES `sirapi_md_admin` (`id_admin`) ON DELETE SET NULL,
  CONSTRAINT `sirapi_md_dataaduan_id_dinas_foreign` FOREIGN KEY (`id_dinas`) REFERENCES `sirapi_md_dinas` (`id_dinas`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sirapi_md_dataaduan`
--

LOCK TABLES `sirapi_md_dataaduan` WRITE;
/*!40000 ALTER TABLE `sirapi_md_dataaduan` DISABLE KEYS */;
INSERT INTO `sirapi_md_dataaduan` VALUES (1,'ejfk','09876543456','inuunuu09@gmail.com','aduan/5OeAMxaVHHy9ohRrRIpy6hckY1tRP5kE4eOaLjjE.jpg','kvnslk',NULL,'Pending','2026-09-02 07:18:53','2026-09-02 07:18:53',NULL,NULL),(2,'junjun','09876543456','inuunuu09@gmail.com','aduan/vhahyNSx7QTKVp0AxZopXRTlCetx774r3RyQLeUI.png','ajkcdbe',NULL,'Selesai','2026-09-02 07:20:52','2026-09-16 17:23:50',NULL,NULL),(3,'daffa','0987655678','inuunuu09@gmail.com','aduan/KxTR9TmOiAYd7unydcGVu17zWJwE8pTFvLYD9ceE.jpg','ll',NULL,'Menunggu','2026-09-16 17:33:19','2026-09-16 17:33:19',NULL,3);
/*!40000 ALTER TABLE `sirapi_md_dataaduan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sirapi_md_dinas`
--

DROP TABLE IF EXISTS `sirapi_md_dinas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sirapi_md_dinas` (
  `id_dinas` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode_dinas` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_dinas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `telepon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kepala_dinas` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gps_lat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gps_long` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_dinas`),
  UNIQUE KEY `sirapi_md_dinas_kode_dinas_unique` (`kode_dinas`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sirapi_md_dinas`
--

LOCK TABLES `sirapi_md_dinas` WRITE;
/*!40000 ALTER TABLE `sirapi_md_dinas` DISABLE KEYS */;
INSERT INTO `sirapi_md_dinas` VALUES (1,'DISKOMINFO','DISKOMINFO','Jl. Tegar Beriman No.1, Pakansari, Kec. Cibinong, Kabupaten Bogor, Jawa Barat 16914','(021) 8750001','diskominfo@bogorkab.go.id','Bambang Widodo, S.STP, M.Si','-6.485570355757940','106.83814060479300','2026-09-15 04:09:56','2026-09-15 08:54:06'),(2,'DISDIK','DISDIK','Jalan Nyaman No. 1 Kel. Tengah Kec. Cibinong','(021) 8753123','disdik@bogorkab.go.id','Bambang Supriyadi, M.Pd','-6.4757983373312600','106.82581208995600','2026-09-15 04:09:56','2026-09-15 08:54:06'),(3,'DINKES','DINKES','Jalan Tegar Beriman, Cibinong','(021) 8752456','dinkes@bogorkab.go.id','dr. Tri Wahyu, M.Kes','-6.482472407917920','106.8324634780720','2026-09-15 04:09:56','2026-09-15 08:54:06'),(4,'DISHUB','DISHUB','Jalan Raya Jakarta KM 50, Cimandala, Kecamatan Sukaraja, Kabupaten Bogor, Jawa Barat, 16710','(0251) 8241001','dishub@bogorkab.go.id','Agus Ridho, S.H, M.H','-6.529837133128540','106.82922642822900','2026-09-15 04:09:56','2026-09-15 08:54:06'),(5,'PUPR','Dinas Pekerjaan Umum dan Penataan Ruang','Jl. Tegar Beriman, Pakansari, Cibinong','(021) 8754890','pupr@bogorkab.go.id','Iwan Setiawan, S.T, M.T',NULL,NULL,'2026-09-15 04:09:56','2026-09-15 04:09:56'),(6,'BAPPEDALITBANG','Badan Perencanaan Pembangunan Penelitian dan Pengembangan Daerah','Jl. Tegar Beriman, Cibinong, Kab. Bogor','(021) 8752002','bappedalitbang@bogorkab.go.id','Ajat Rochmat Jatnika, S.T, M.Si',NULL,NULL,'2026-09-15 04:09:56','2026-09-15 04:09:56'),(7,'BAPPENDA','Bappenda','Jalan Raya Tegar Beriman No. 1, Pakansari, Cibinong, Pakansari, Cibinong, Bogor, Jawa Barat 16914, Indonesia','(021) 8753000','bappenda@bogorkab.go.id','Aris Nurjatmiko, S.STP','-6.484994815258150','106.83524222940500','2026-09-15 04:09:56','2026-09-15 08:54:06'),(8,'SATPOLPP','SATPOLPP','Jl. Aman No. 4 Kel. Tengah Kec. Cibinong Kab. Bogor Prov. Jawa Barat 16914','(021) 8751111','satpolpp@bogorkab.go.id','Cecep Imam Nagararasit, M.Si','-6.476394130819470','106.82439127949100','2026-09-15 04:09:56','2026-09-15 08:54:06'),(9,'pol','polisi','jhbwjkv','0987656788765','inuunuu09@gmail.com','rifqi',NULL,NULL,'2026-09-10 03:18:50','2026-09-10 03:18:50'),(10,NULL,'Dinas Komunikasi & Informatika',NULL,NULL,NULL,NULL,NULL,NULL,'2026-09-10 04:09:32','2026-09-10 04:09:32'),(11,'BAKESBANGPOL','Bakesbangpol','Jl. KSR Dadi Kusmayadi No.41, Tengah, Kec. Cibinong, Kabupaten Bogor, Jawa Barat 16914',NULL,NULL,NULL,'-6.475242896422230','106.82722662709700',NULL,'2026-09-15 08:54:06'),(12,'BAPPERIDA','Bapperida','Jl. Segar III Komplek Perkantoran Pemda Bogor No.Kav. 2, Tengah, Kec. Cibinong, Kabupaten Bogor, Jawa Barat 16914',NULL,NULL,NULL,'-6.476065267743370','106.8271264055190',NULL,'2026-09-15 08:54:06'),(13,'BKPSDM','BKPSDM','Jl. Bersih, Tengah, Kec. Cibinong, Kabupaten Bogor, Jawa Barat 16914',NULL,NULL,NULL,'-6.47565800550251','106.82406870792800',NULL,'2026-09-15 08:54:06'),(14,'BPBD','BPBD','Jalan Tegar Beriman, Cibinong',NULL,NULL,NULL,'-6.484659272975570','106.83839786344500',NULL,'2026-09-15 08:54:06'),(15,'BPKAD','BPKAD','Jalan Aman No 1, Kelurahan Tengah, Kecamatan Cibinong, Kabupaten Bogor',NULL,NULL,NULL,'-6.47546529425834','106.82449300807000',NULL,'2026-09-15 08:54:06'),(16,'DAMKAR','DAMKAR','Komplek, Jl. Raya Pemda Jl. Tegar Beriman No.1, Pakansari, Kec. Cibinong, Kabupaten Bogor, Jawa Barat 16914',NULL,NULL,NULL,'-6.485523543494310','106.83661950446600',NULL,'2026-09-15 08:54:06'),(17,'DAPD','DAPD','Jalan Bersih, Komplek Pemda, Kelurahan Tengah, Kecamatan Cibinong, Kabupaten Bogor',NULL,NULL,NULL,'-6.478133664773870','106.8230611055450',NULL,'2026-09-15 08:54:06'),(18,'DINSOS','DINSOS','Jalan Tegar Beriman, Cibinong',NULL,NULL,NULL,'-6.475137096626070','106.82420664932200',NULL,'2026-09-15 08:54:06'),(19,'DISBUD','DISBUD','Vivo Mall Lantai 1 Jl. Raya Jakarta - Bogor Km. 50, Cimandala, Kec. Sukaraja, Kabupaten Bogor, Jawa Barat 16710',NULL,NULL,NULL,'-6.523591440931880','106.83178626253800',NULL,'2026-09-15 08:54:06'),(20,'DISDAGIN','DISDAGIN','Jalan Aman Komplek Perkantoran Pemkab Bogor, Kelurahan Tengah Cibinong 16914',NULL,NULL,NULL,'-6.476992320470760','106.82440342443500',NULL,'2026-09-15 08:54:06'),(21,'DISDUKCAKPIL','DISDUKCAKPIL','Jalan Tegar Beriman, Kelurahan Pakansari, Kecamatan Cibinong',NULL,NULL,NULL,'-6.485572943494250','106.83712809652300',NULL,'2026-09-15 08:54:06'),(22,'DISKANAK','DISKANAK','Jl. Bersih, Tengah, Kec. Cibinong, Kabupaten Bogor, Jawa Barat 16914',NULL,NULL,NULL,'-6.476652724202460','106.82395219789300',NULL,'2026-09-15 08:54:06'),(23,'DISKOPUKM','DISKOPUKM','Jalan KSR Dadi Kusmayadi, Kelurahan Tengah Cibinong, Bogor, Jawa Barat 16941, Indonesia',NULL,NULL,NULL,'-6.4748951520537100','106.82522243664700',NULL,'2026-09-15 08:54:06'),(24,'DISNAKER','DISNAKER','Jalan Tegar Beriman, Cibinong',NULL,NULL,NULL,'-6.475480082839860','106.8238127228760',NULL,'2026-09-15 08:54:06'),(25,'DISPAREKRAF','DISPAREKRAF','Komplek Perkantoran Pemda, Jl. Segar III Kav. V, Kabupaten Bogor, 16914',NULL,NULL,NULL,'-6.476834582582200','106.82657727994700',NULL,'2026-09-15 08:54:06'),(26,'DISPORA','DISPORA','Jalan Tegar Beriman, Cibinong',NULL,NULL,NULL,'-6.495449158786360','106.83033790955600',NULL,'2026-09-15 08:54:06'),(27,'DISTANHORBUN','DISTANHORBUN','Jl. Segar III Komplek Perkantoran PEMDA Kelurahan Tengah Kecamatan Cibinong Kabupaten Bogor 16914',NULL,NULL,NULL,'-6.576529870490310','106.75978719354800',NULL,'2026-09-15 08:54:06'),(28,'DKP','DKP','JL. Raya Jasinga Km. 35, Kode Pos 16660, Telp. 0251 8682011, Email : Keccigudeg@bogorkab.go.id',NULL,NULL,NULL,'-6.475762583053950','106.82661416390100',NULL,'2026-09-15 08:54:06'),(29,'DLH','DLH','Komplek Kantor ke-PU-an, Jl. Tegar Beriman Cibinong 16914',NULL,NULL,NULL,'-6.481097247534780','106.83096921911000',NULL,'2026-09-15 08:54:06'),(30,'DP3AP2KB','DP3AP2KB','Jalan Bersih, Kelurahan Tengah - Cibinong 16914 - Kab. Bogor',NULL,NULL,NULL,'-6.476222755886020','106.82356754904200',NULL,'2026-09-15 08:54:06'),(31,'DPKP','DPKP','Jl. Tegar Beriman, Tengah, Kec. Cibinong, Kabupaten Bogor, Jawa Barat 16914',NULL,NULL,NULL,'-6.4815541448202300','106.83113578815300',NULL,'2026-09-15 08:54:06'),(32,'DPMD','DPMD','Jl. KSR Dadi Kusmayadi, Cibinong, Bogor, Jawa Barat 16914',NULL,NULL,NULL,'-6.47543803373732','106.82773629979300',NULL,'2026-09-15 08:54:06'),(33,'DPMPTSP','DPMPTSP','Jl. Tegar Beriman No.40, Tengah, Kec. Cibinong, Kabupaten Bogor, Jawa Barat 16914',NULL,NULL,NULL,'-6.481500598912050','106.82754823183800',NULL,'2026-09-15 08:54:06'),(34,'DPTR','DPTR','Jalan Tegar Beriman, Cibinong',NULL,NULL,NULL,'-6.484546930221800','106.83408594937200',NULL,'2026-09-15 08:54:06'),(35,'DPU','DPU','Pemkab Bogor Jalan Tegar Beriman Cibinong - Bogor 16914',NULL,NULL,NULL,'-6.481238839087380','106.83049073472400',NULL,'2026-09-15 08:54:06'),(36,'INSPEKTORAT','INSPEKTORAT','Jl. Indah No.1, Kelurahan Tengah, Kecamatan Cibinong',NULL,NULL,NULL,'-6.478405682581680','106.82363025675100',NULL,'2026-09-15 08:54:06'),(37,'RSUD CIAWI','RSUD CIAWI','Sirnagalih, Tamansari, Bogor 16610, Telp: (0251) 8487111',NULL,NULL,NULL,'-6.658947893584560','106.8525421494500',NULL,'2026-09-15 08:54:06'),(38,'RSUD CIBINONG','RSUD CIBINONG','Jl. KSR Dadi Kusmayadi No.27, Tengah, Cibinong, Bogor, Jawa Barat 16914',NULL,NULL,NULL,'-6.473036490256760','106.83132222057600',NULL,'2026-09-15 08:54:06'),(39,'RSUD CILEUNGSI','RSUD CILEUNGSI','Jl. Raya Cileungsi - Jonggol No.10, Cipeucang, Kec. Cileungsi, Kabupaten Bogor, Jawa Barat 16820, Indonesia',NULL,NULL,NULL,'-6.428146064344360','107.04771930898000',NULL,'2026-09-15 08:54:06'),(40,'RSUD LEUWILIANG','RSUD LEUWILIANG','Jl. Letkol Atang Senjaya Telp. ( 0251 ) 8624001 Bogor 16310, email : kecrancabungur@bogorkab.go.id',NULL,NULL,NULL,'-6.5674948669557900','106.62612602152800',NULL,'2026-09-15 08:54:06'),(41,'SETDA','SETDA','Jalan Tegar Beriman, Cibinong',NULL,NULL,NULL,'-6.478244628888420','106.82477429086600',NULL,'2026-09-15 08:54:06'),(42,'SETWAN','SETWAN','Jl. Segar, Tengah, Kec. Cibinong, Kabupaten Bogor, Jawa Barat 16914',NULL,NULL,NULL,'-6.479594016578280','106.82589094005200',NULL,'2026-09-15 08:54:06');
/*!40000 ALTER TABLE `sirapi_md_dinas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sirapi_md_dokumen_notulen`
--

DROP TABLE IF EXISTS `sirapi_md_dokumen_notulen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sirapi_md_dokumen_notulen` (
  `id_dokumen` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_agenda` bigint unsigned NOT NULL,
  `jenis_dokumen` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'notulen',
  `nama_file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_dokumen`),
  KEY `sirapi_md_dokumen_notulen_id_agenda_foreign` (`id_agenda`),
  CONSTRAINT `sirapi_md_dokumen_notulen_id_agenda_foreign` FOREIGN KEY (`id_agenda`) REFERENCES `sirapi_md_agenda` (`id_agenda`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sirapi_md_dokumen_notulen`
--

LOCK TABLES `sirapi_md_dokumen_notulen` WRITE;
/*!40000 ALTER TABLE `sirapi_md_dokumen_notulen` DISABLE KEYS */;
/*!40000 ALTER TABLE `sirapi_md_dokumen_notulen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sirapi_md_galeri`
--

DROP TABLE IF EXISTS `sirapi_md_galeri`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sirapi_md_galeri` (
  `id_galeri` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_galeri`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sirapi_md_galeri`
--

LOCK TABLES `sirapi_md_galeri` WRITE;
/*!40000 ALTER TABLE `sirapi_md_galeri` DISABLE KEYS */;
/*!40000 ALTER TABLE `sirapi_md_galeri` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sirapi_md_jabatan`
--

DROP TABLE IF EXISTS `sirapi_md_jabatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sirapi_md_jabatan` (
  `id_jabatan` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_jabatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_jabatan`),
  UNIQUE KEY `sirapi_md_jabatan_nama_jabatan_unique` (`nama_jabatan`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sirapi_md_jabatan`
--

LOCK TABLES `sirapi_md_jabatan` WRITE;
/*!40000 ALTER TABLE `sirapi_md_jabatan` DISABLE KEYS */;
INSERT INTO `sirapi_md_jabatan` VALUES (1,'Kepala Dinas','Struktural','2026-09-15 04:09:56','2026-09-15 04:09:56'),(2,'Sekretaris Dinas','Struktural','2026-09-15 04:09:56','2026-09-15 04:09:56'),(3,'Kepala Bidang','Struktural','2026-09-15 04:09:56','2026-09-15 04:09:56'),(4,'Kepala Subag/Seksi','Struktural','2026-09-15 04:09:56','2026-09-15 04:09:56'),(5,'Kepala UPT','Struktural','2026-09-15 04:09:56','2026-09-15 04:09:56'),(6,'Kepala TU UPT','Struktural','2026-09-15 04:09:56','2026-09-15 04:09:56'),(7,'Sub Koordinator','Jabatan Fungsional','2026-09-15 04:09:56','2026-09-15 04:09:56'),(8,'Pranata Komputer Ahli Muda','Jabatan Fungsional','2026-09-15 04:09:56','2026-09-15 04:09:56'),(9,'Pranata Komputer Pertama','Jabatan Fungsional','2026-09-15 04:09:56','2026-09-15 04:09:56'),(10,'Pelaksana','Jabatan Fungsional','2026-09-15 04:09:56','2026-09-15 04:09:56');
/*!40000 ALTER TABLE `sirapi_md_jabatan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sirapi_md_kecamatan`
--

DROP TABLE IF EXISTS `sirapi_md_kecamatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sirapi_md_kecamatan` (
  `id_kecamatan` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode_kecamatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_kecamatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat_kantor` text COLLATE utf8mb4_unicode_ci,
  `telepon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `camat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gps_lat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gps_long` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_kecamatan`),
  UNIQUE KEY `sirapi_md_kecamatan_kode_kecamatan_unique` (`kode_kecamatan`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sirapi_md_kecamatan`
--

LOCK TABLES `sirapi_md_kecamatan` WRITE;
/*!40000 ALTER TABLE `sirapi_md_kecamatan` DISABLE KEYS */;
INSERT INTO `sirapi_md_kecamatan` VALUES (1,'KEC-CIBINONG','Kecamatan Cibinong','Jl. Kayu Manis No.30 Kelurahan Cirimekar, Kecamatan Cibinong','(021) 8753879','kecibinong@bogorkab.go.id','Camat Cibinong','-6.473271','106.853688','2026-09-15 08:54:06','2026-09-15 08:54:06'),(2,'KEC-GUNUNGPUTRI','Kecamatan Gunung Putri','Jl. Barokah, Wanaherang, Gunung Putri, Bogor 16965','(021) 8672122','kecgunungputri@bogorkab.go.id','Camat Gunung Putri','-6.423838','106.940441','2026-09-15 08:54:06','2026-09-15 08:54:06'),(3,'KEC-CITEUREUP','Kecamatan Citeureup','Jln. Mayor Oking Jayaatmaja No 107 Citeureup, Bogor 16810','(021) 8752312','kecciteureup@bogorkab.go.id','Camat Citeureup','-6.486906','106.878721','2026-09-15 08:54:06','2026-09-15 08:54:06'),(4,'KEC-SUKARAJA','Kecamatan Sukaraja','JL Dharmais, Cimandala, Sukaraja, Bogor 16710','(0251) 8652476','kecsukaraja@bogorkab.go.id','Camat Sukaraja','-6.538937','106.822428','2026-09-15 08:54:06','2026-09-15 08:54:06'),(5,'KEC-BABAKANMADANG','Kecamatan Babakan Madang','Jl. Raya Babakan Madang No. 4','021-87951920','kecbabakanmadang@bogorkab.go.id','Camat Babakan Madang','-6.570999','106.865713','2026-09-15 08:54:06','2026-09-15 08:54:06'),(6,'KEC-JONGGOL','Kecamatan Jonggol','Jl. Raya Alun-Alun Utara No.7, Jonggol, Bogor 16830','(021) 89931171','kecjonggol@bogorkab.go.id','Camat Jonggol','-6.467843','107.066056','2026-09-15 08:54:06','2026-09-15 08:54:06'),(7,'KEC-CILEUNGSI','Kecamatan Cileungsi','Komplek Perumahan Metland Transyogi Jl. Gandaria Utara No. 1','(021) 8230085','keccileungsi@bogorkab.go.id','Camat Cileungsi','-6.394571','106.977392','2026-09-15 08:54:06','2026-09-15 08:54:06'),(8,'KEC-CARIU','Kecamatan Cariu','Jl. Brigjen Dharsono No.01 Cariu Kabupaten Bogor 16840','(021) 89960904','keccariu@bogorkab.go.id','Camat Cariu','-6.503854','107.133084','2026-09-15 08:54:06','2026-09-15 08:54:06'),(9,'KEC-SUKAMAKMUR','Kecamatan Sukamakmur','Jln. Raya Sukamakmur No. 1 Kec. Sukamakmur Kabupaten Bogor 16830','-','kecsukamakmur@bogorkab.go.id','Camat Sukamakmur','-6.565829','106.994981','2026-09-15 08:54:06','2026-09-15 08:54:06'),(10,'KEC-PARUNG','Kecamatan Parung','Jl. Raden Demang Arya, Desa Waru Jaya, Kecamatan Parung','0251-8611088','kecparung@bogorkab.go.id','Camat Parung','-6.420047','106.732847','2026-09-15 08:54:06','2026-09-15 08:54:06'),(11,'KEC-GUNUNGSINDUR','Kecamatan Gunung Sindur','Jl.Atma Asmawi NO. 58 Gunungsindur','021-7562152','kecamatangunungsindur@bogorkab.go.id','Camat Gunung Sindur','-6.385779','106.675057','2026-09-15 08:54:06','2026-09-15 08:54:06'),(12,'KEC-KEMANG','Kecamatan Kemang','Jl. Raya Kemang Kiara No. 57 - 16310','(0251) 7535154','keckemang@bogorkab.go.id','Camat Kemang','-6.513809','106.754521','2026-09-15 08:54:06','2026-09-15 08:54:06'),(13,'KEC-BOJONGGEDE','Kecamatan Bojong Gede','Jl. Raya Bojonggede No.316, Bojonggede 16320','(021) 8781078','kecbojonggede@bogorkab.go.id','Camat Bojong Gede','-6.483816','106.799348','2026-09-15 08:54:06','2026-09-15 08:54:06'),(14,'KEC-LEUWILIANG','Kecamatan Leuwiliang','Jl. Moh Noh Nur, Leuwiliang, Bogor 16640','-','kecleuwiliang@bogorkab.go.id','Camat Leuwiliang','-6.57677','106.635715','2026-09-15 08:54:06','2026-09-15 08:54:06'),(15,'KEC-CIAMPEA','Kecamatan Ciampea','Bojong Rangkas, Ciampea, Bogor 16620','-','kecciampea@bogorkab.go.id','Camat Ciampea','-6.554946','106.697082','2026-09-15 08:54:06','2026-09-15 08:54:06'),(16,'KEC-CIBUNGBULANG','Kecamatan Cibungbulang','Jalan KH Umar Cirangkong, Desa Cemplang Kec.Cibungbulang','-','keccibungbulang@bogorkab.go.id','Camat Cibungbulang','-6.57449','106.6669','2026-09-15 08:54:06','2026-09-15 08:54:06'),(17,'KEC-PAMIJAHAN','Kecamatan Pamijahan','Jl.Gunung Salak Endah no.2 Desa Gunung Sari','(0251) 8640509','kecpamijahan@bogorkab.go.id','Camat Pamijahan','-6.671667','106.663717','2026-09-15 08:54:06','2026-09-15 08:54:06'),(18,'KEC-RUMPIN','Kecamatan Rumpin','Jl. Prada Samlawi No.02, Rumpin, Bogor 16350','-','kecrumpin@bogorkab.go.id','Camat Rumpin','-6.442162','106.640901','2026-09-15 08:54:06','2026-09-15 08:54:06'),(19,'KEC-JASINGA','Kecamatan Jasinga','Jalan Raya Bogor - Cigelung No.01 Bogor 16670','(0251) 8688785','kecjasinga@bogorkab.go.id','Camat Jasinga','-6.48351','106.469633','2026-09-15 08:54:06','2026-09-15 08:54:06'),(20,'KEC-PARUNGPANJANG','Kecamatan Parung Panjang','Jl. Raya Moh Toha Nomor 1 Parungpanjang','(021) 5979148','kecparungpanjang@bogorkab.go.id','Camat Parung Panjang','-6.341668','106.571467','2026-09-15 08:54:06','2026-09-15 08:54:06'),(21,'KEC-NANGGUNG','Kecamatan Nanggung','Jl. Raya Ace Tabrani No.32, Parakan Muncang','-','kecnanggung@bogorkab.go.id','Camat Nanggung','-6.597729','106.539593','2026-09-15 08:54:06','2026-09-15 08:54:06'),(22,'KEC-CIGUDEG','Kecamatan Cigudeg','JL. Raya Jasinga Km. 35, Kode Pos 16660','0251 8682011','keccigudeg@bogorkab.go.id','Camat Cigudeg','-6.547643','106.532664','2026-09-15 08:54:06','2026-09-15 08:54:06'),(23,'KEC-TENJO','Kecamatan Tenjo','Jln.Raya Jasinga-Tenjo KM.18.55 Bogor 16370','021 59760015','kectenjo@bogorkab.go.id','Camat Tenjo','-6.339321','106.440804','2026-09-15 08:54:06','2026-09-15 08:54:06'),(24,'KEC-CIAWI','Kecamatan Ciawi','Jl. Raya K.H.R Moch. Toha No. 362 Ciawi-Bogor 16720','(0251) 8240234','kecciawi@bogorkab.go.id','Camat Ciawi','-6.662181','106.853163','2026-09-15 08:54:06','2026-09-15 08:54:06'),(25,'KEC-CISARUA','Kecamatan Cisarua','Jl. Raya Puncak - Cianjur No.520, Leuwimalang','0251 8254031','keccisarua@bogorkab.go.id','Camat Cisarua','-6.680613','106.934203','2026-09-15 08:54:06','2026-09-15 08:54:06'),(26,'KEC-MEGAMENDUNG','Kecamatan Megamendung','Jl. Lentan Suryanta No. 9 Sukamaju 16770','0251-7555536','kecmegamendung@bogorkab.go.id','Camat Megamendung','-6.674893','106.883359','2026-09-15 08:54:06','2026-09-15 08:54:06'),(27,'KEC-CARINGIN','Kecamatan Caringin','Jl. Mayjen HR. Edi Sukma KM. 17 Caringin','0251 8241392','keccaringin@bogorkab.go.id','Camat Caringin','-6.703843','106.824883','2026-09-15 08:54:06','2026-09-15 08:54:06'),(28,'KEC-CIJERUK','Kecamatan Cijeruk','Jalan KH. Halimi No. 04 Desa Cipelang','(0251) 8212375','keccijeruk@bogorkab.go.id','Camat Cijeruk','-6.697987','106.796579','2026-09-15 08:54:06','2026-09-15 08:54:06'),(29,'KEC-CIOMAS','Kecamatan Ciomas','Padusuka No.343, Pagelaran, Ciomas, Bogor 16610','-','kecciomas@bogorkab.go.id','Camat Ciomas','-6.602435','106.76531','2026-09-15 08:54:06','2026-09-15 08:54:06'),(30,'KEC-DRAMAGA','Kecamatan Dramaga','Jl.R.Soewandana No.74 Desa Dramaga','0251-8623002','kecdramaga@bogorkab.go.id','Camat Dramaga','-6.575719','106.737937','2026-09-15 08:54:06','2026-09-15 08:54:06'),(31,'KEC-TAMANSARI','Kecamatan Tamansari','Sirnagalih, Tamansari, Bogor 16610','(0251) 8487111','kectamansari@bogorkab.go.id','Camat Tamansari','-6.644802','106.765653','2026-09-15 08:54:06','2026-09-15 08:54:06'),(32,'KEC-KLAPANUNGGAL','Kecamatan Klapanunggal','Jl. Raya Narogong, Kembang Kuning, Klapa Nunggal','-','kecklapanunggal@bogorkab.go.id','Camat Klapanunggal','-6.449903','106.935872','2026-09-15 08:54:06','2026-09-15 08:54:06'),(33,'KEC-CISEENG','Kecamatan Ciseeng','Jl. Raya Ciseeng, Kabupaten Bogor','-','kecciseeng@bogorkab.go.id','Camat Ciseeng','-6.446257','106.685053','2026-09-15 08:54:06','2026-09-15 08:54:06'),(34,'KEC-RANCABUNGUR','Kecamatan Rancabungur','Jl. Letkol Atang Senjaya, Rancabungur','(0251) 8624001','kecrancabungur@bogorkab.go.id','Camat Rancabungur','-6.540684','106.709472','2026-09-15 08:54:06','2026-09-15 08:54:06'),(35,'KEC-SUKAJAYA','Kecamatan Sukajaya','Jl. Raya Sukajaya Km. 08','0251 8682917','kecsukajaya@bogorkab.go.id','Camat Sukajaya','-6.594062','106.477977','2026-09-15 08:54:06','2026-09-15 08:54:06'),(36,'KEC-TANJUNGSARI','Kecamatan Tanjungsari','Pasir Tanjung, Tanjungsari, Bogor 16840','-','kectanjungsari@bogorkab.go.id','Camat Tanjungsari','-6.605575','107.149038','2026-09-15 08:54:06','2026-09-15 08:54:06'),(37,'KEC-TAJURHALANG','Kecamatan Tajurhalang','Jl. Manunggal No. 1 Tajurhalang','(0251) 8552610','kectajurhalang@bogorkab.go.id','Camat Tajurhalang','-6.4745','106.757258','2026-09-15 08:54:06','2026-09-15 08:54:06'),(38,'KEC-CIGOMBONG','Kecamatan Cigombong','Cigombong, Bogor 16110','-','keccigombong@bogorkab.go.id','Camat Cigombong','-6.743253','106.803152','2026-09-15 08:54:06','2026-09-15 08:54:06'),(39,'KEC-LEUWISADENG','Kecamatan Leuwisadeng','Jalan Raya Bogor - Jasinga Km. 24','(0251) 8643608','kecleuwisadeng@bogorkab.go.id','Camat Leuwisadeng','-6.565256','106.614498','2026-09-15 08:54:06','2026-09-15 08:54:06'),(40,'KEC-TENJOLAYA','Kecamatan Tenjolaya','Jl. Raya Abdul Fatah, Tapos I, Tenjolaya','-','kectenjolaya@bogorkab.go.id','Camat Tenjolaya','-6.644707','106.693678','2026-09-15 08:54:06','2026-09-15 08:54:06');
/*!40000 ALTER TABLE `sirapi_md_kecamatan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sirapi_md_kehadiran`
--

DROP TABLE IF EXISTS `sirapi_md_kehadiran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sirapi_md_kehadiran` (
  `id_kehadiran` bigint unsigned NOT NULL AUTO_INCREMENT,
  `lokasi_presensi` text COLLATE utf8mb4_unicode_ci,
  `foto_kehadiran` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_peserta` bigint unsigned NOT NULL,
  `id_agenda` bigint unsigned NOT NULL,
  `id_log` bigint unsigned NOT NULL,
  PRIMARY KEY (`id_kehadiran`),
  KEY `sirapi_md_kehadiran_id_peserta_foreign` (`id_peserta`),
  KEY `sirapi_md_kehadiran_id_agenda_foreign` (`id_agenda`),
  KEY `sirapi_md_kehadiran_id_log_foreign` (`id_log`),
  CONSTRAINT `sirapi_md_kehadiran_id_agenda_foreign` FOREIGN KEY (`id_agenda`) REFERENCES `sirapi_md_agenda` (`id_agenda`) ON DELETE CASCADE,
  CONSTRAINT `sirapi_md_kehadiran_id_log_foreign` FOREIGN KEY (`id_log`) REFERENCES `sirapi_md_logbook` (`id_log`) ON DELETE CASCADE,
  CONSTRAINT `sirapi_md_kehadiran_id_peserta_foreign` FOREIGN KEY (`id_peserta`) REFERENCES `sirapi_md_peserta` (`id_peserta`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sirapi_md_kehadiran`
--

LOCK TABLES `sirapi_md_kehadiran` WRITE;
/*!40000 ALTER TABLE `sirapi_md_kehadiran` DISABLE KEYS */;
/*!40000 ALTER TABLE `sirapi_md_kehadiran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sirapi_md_kunjungan`
--

DROP TABLE IF EXISTS `sirapi_md_kunjungan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sirapi_md_kunjungan` (
  `id_kunjungan` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_pegawai` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_pejabat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_pengunjung` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `asal_instansi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomorhp_pengunjung` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_pengunjung` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keperluan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `waktu` time DEFAULT NULL,
  `tanggal_kunjungan` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_admin` bigint unsigned NOT NULL,
  `id_dinas` bigint unsigned DEFAULT NULL,
  `id_kecamatan` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id_kunjungan`),
  UNIQUE KEY `sirapi_md_kunjungan_email_pengunjung_unique` (`email_pengunjung`),
  KEY `sirapi_md_kunjungan_id_dinas_foreign` (`id_dinas`),
  KEY `sirapi_md_kunjungan_id_kecamatan_foreign` (`id_kecamatan`),
  CONSTRAINT `sirapi_md_kunjungan_id_dinas_foreign` FOREIGN KEY (`id_dinas`) REFERENCES `sirapi_md_dinas` (`id_dinas`) ON DELETE SET NULL,
  CONSTRAINT `sirapi_md_kunjungan_id_kecamatan_foreign` FOREIGN KEY (`id_kecamatan`) REFERENCES `sirapi_md_kecamatan` (`id_kecamatan`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sirapi_md_kunjungan`
--

LOCK TABLES `sirapi_md_kunjungan` WRITE;
/*!40000 ALTER TABLE `sirapi_md_kunjungan` DISABLE KEYS */;
/*!40000 ALTER TABLE `sirapi_md_kunjungan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sirapi_md_logbook`
--

DROP TABLE IF EXISTS `sirapi_md_logbook`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sirapi_md_logbook` (
  `id_log` bigint unsigned NOT NULL AUTO_INCREMENT,
  `catatan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `waktu_isi` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `Id_agenda` bigint unsigned NOT NULL,
  PRIMARY KEY (`id_log`),
  KEY `sirapi_md_logbook_id_agenda_foreign` (`Id_agenda`),
  CONSTRAINT `sirapi_md_logbook_id_agenda_foreign` FOREIGN KEY (`Id_agenda`) REFERENCES `sirapi_md_agenda` (`id_agenda`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sirapi_md_logbook`
--

LOCK TABLES `sirapi_md_logbook` WRITE;
/*!40000 ALTER TABLE `sirapi_md_logbook` DISABLE KEYS */;
/*!40000 ALTER TABLE `sirapi_md_logbook` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sirapi_md_pegawai`
--

DROP TABLE IF EXISTS `sirapi_md_pegawai`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sirapi_md_pegawai` (
  `id_pegawai` bigint unsigned NOT NULL AUTO_INCREMENT,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_wajah` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_pegawai` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bidang` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_hp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `face_descriptor` longtext COLLATE utf8mb4_unicode_ci,
  `status_verifikasi` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_dinas` bigint unsigned DEFAULT NULL,
  `id_kecamatan` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id_pegawai`),
  UNIQUE KEY `sirapi_md_pegawai_nip_unique` (`nip`),
  UNIQUE KEY `sirapi_md_pegawai_email_unique` (`email`),
  KEY `sirapi_md_pegawai_id_dinas_foreign` (`id_dinas`),
  KEY `sirapi_md_pegawai_id_kecamatan_foreign` (`id_kecamatan`),
  CONSTRAINT `sirapi_md_pegawai_id_dinas_foreign` FOREIGN KEY (`id_dinas`) REFERENCES `sirapi_md_dinas` (`id_dinas`) ON DELETE SET NULL,
  CONSTRAINT `sirapi_md_pegawai_id_kecamatan_foreign` FOREIGN KEY (`id_kecamatan`) REFERENCES `sirapi_md_kecamatan` (`id_kecamatan`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sirapi_md_pegawai`
--

LOCK TABLES `sirapi_md_pegawai` WRITE;
/*!40000 ALTER TABLE `sirapi_md_pegawai` DISABLE KEYS */;
INSERT INTO `sirapi_md_pegawai` VALUES (1,NULL,NULL,'Nuu Inuu','1234678','2026-09-08','Kepala Bidang','Bidang Aplikasi Informatika','09876678987','inuunuu09@gmail.com','$2y$12$egUDa6CgrHP9OvtH6LGBGugMFUPMu2Xr6zwk1ufXUJqMeKRNPvbKq',NULL,'aktif','2026-09-07 17:01:42','2026-09-07 17:16:08',NULL,NULL),(3,'pegawai/face_scan_3_1788804135.jpeg','pegawai/face_scan_3_1788804135.jpeg','Nuu Inuu','1234567876543456','2026-09-08','Pranata Komputer Pertama','Bidang Infrastruktur Teknologi','0987654567654','tugastugass10@gmail.com','$2y$12$9YwWxJOVTgf7tSYtluAzY.yWqFlujg9DUd4wnCGuneeYkagsULQYS','[-0.06225869059562683,0.15339533984661102,0.0889219269156456,-0.05809088796377182,-0.06524838507175446,-0.07745756208896637,-0.010244452394545078,-0.1473616510629654,0.12088657915592194,-0.09579112380743027,0.24771520495414734,-0.05104518309235573,-0.1718023419380188,-0.15190725028514862,0.017282268032431602,0.18735343217849731,-0.21717539429664612,-0.14498184621334076,-0.04815668985247612,-0.02925744280219078,0.037379004061222076,0.014288120903074741,0.011396507732570171,0.037032730877399445,-0.014532996341586113,-0.31144678592681885,-0.10881134867668152,-0.12961754202842712,0.14199227094650269,-0.024857575073838234,-0.04878456890583038,-0.011925882659852505,-0.18300321698188782,-0.05321606248617172,-0.02445673756301403,0.022645780816674232,-0.018936116248369217,0.008574998937547207,0.19137687981128693,-0.0246355552226305,-0.2104896605014801,0.0433102585375309,-0.027063734829425812,0.22645264863967896,0.23379690945148468,0.07903337478637695,0.030819019302725792,-0.12987621128559113,0.07154123485088348,-0.15750108659267426,0.05245401710271835,0.13683167099952698,0.13046368956565857,0.07440991699695587,-0.0654052123427391,-0.19112305343151093,-0.020406115800142288,0.061085496097803116,-0.14541077613830566,0.026652125641703606,0.0900692567229271,-0.09415266662836075,-0.014909831807017326,-0.03714870288968086,0.31974074244499207,0.011252318508923054,-0.14115013182163239,-0.13950549066066742,0.14550769329071045,-0.15173327922821045,-0.04153303802013397,0.07747302949428558,-0.14878907799720764,-0.09893420338630676,-0.28617990016937256,0.08028701692819595,0.44348931312561035,0.08027854561805725,-0.21322116255760193,0.003945925738662481,-0.1668146699666977,0.01798742637038231,0.0971553847193718,0.11620112508535385,-0.061423011124134064,-0.016177944839000702,-0.11630965024232864,-0.04003646597266197,0.16607213020324707,-0.12200921028852463,0.0016895057633519173,0.22495806217193604,-0.010471577756106853,0.1545000821352005,-0.03720270097255707,-0.02100607566535473,-0.026902366429567337,0.03639630228281021,-0.059037838131189346,-0.02983413077890873,0.010129122994840145,-0.04927203431725502,0.012612760066986084,0.13678985834121704,-0.15188246965408325,0.1696597933769226,0.021382411941885948,0.06578972190618515,0.0283524002879858,0.04916706308722496,-0.04765653237700462,-0.1324741244316101,0.17702069878578186,-0.18629124760627747,0.22821936011314392,0.22038425505161285,0.03560566529631615,0.12367761880159378,0.10431291162967682,0.15589815378189087,-0.0639767125248909,-0.03958582878112793,-0.2057216614484787,0.05008409172296524,0.12869422137737274,-0.05608851835131645,0.09037911146879196,0.043542761355638504]','aktif','2026-09-07 17:17:29','2026-09-07 18:02:15',NULL,NULL),(4,'pegawai/24eyZEajOkp0nURfb0u6PUwEvfxy8JKkyXra9KOT.jpg',NULL,'wisnu','732573275272363256','2026-09-08','Sekretaris Dinas','Bidang Aplikasi Informatika','09876545546','nutwisnut@gmail.com','$2y$12$U3gKpQlnAE3H3DHlX3K7eewoz9xF1vpsl2gBJ10wWfX7Zbp0u2wu2',NULL,'aktif','2026-09-07 17:40:59','2026-09-07 17:42:14',NULL,NULL);
/*!40000 ALTER TABLE `sirapi_md_pegawai` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sirapi_md_peserta`
--

DROP TABLE IF EXISTS `sirapi_md_peserta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sirapi_md_peserta` (
  `id_peserta` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `instansi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_peserta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_hp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_peserta`),
  UNIQUE KEY `sirapi_md_peserta_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sirapi_md_peserta`
--

LOCK TABLES `sirapi_md_peserta` WRITE;
/*!40000 ALTER TABLE `sirapi_md_peserta` DISABLE KEYS */;
INSERT INTO `sirapi_md_peserta` VALUES (1,'Nuu Inuu','Pranata Komputer Pertama','Bidang Infrastruktur Teknologi','pegawai','0987654567654','tugastugass10@gmail.com','2026-09-07 17:45:20','2026-09-07 18:02:33');
/*!40000 ALTER TABLE `sirapi_md_peserta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sirapi_md_qrcode`
--

DROP TABLE IF EXISTS `sirapi_md_qrcode`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sirapi_md_qrcode` (
  `id_qrcode` bigint unsigned NOT NULL AUTO_INCREMENT,
  `qr_codepath` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_agenda` bigint unsigned NOT NULL,
  PRIMARY KEY (`id_qrcode`),
  KEY `sirapi_md_qrcode_id_agenda_foreign` (`id_agenda`),
  CONSTRAINT `sirapi_md_qrcode_id_agenda_foreign` FOREIGN KEY (`id_agenda`) REFERENCES `sirapi_md_agenda` (`id_agenda`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sirapi_md_qrcode`
--

LOCK TABLES `sirapi_md_qrcode` WRITE;
/*!40000 ALTER TABLE `sirapi_md_qrcode` DISABLE KEYS */;
INSERT INTO `sirapi_md_qrcode` VALUES (3,'http://127.0.0.1:8000/publik/presensi-pegawai?agenda_id=12','2026-09-16 09:31:19','2026-09-16 09:31:19',12),(4,'http://127.0.0.1:8000/publik/presensi-pegawai?agenda_id=10','2026-09-16 09:33:26','2026-09-16 09:33:26',10),(5,'http://127.0.0.1:8000/publik/presensi-pegawai?agenda_id=13','2026-09-16 09:34:22','2026-09-16 09:34:22',13);
/*!40000 ALTER TABLE `sirapi_md_qrcode` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sirapi_md_ruangrapat`
--

DROP TABLE IF EXISTS `sirapi_md_ruangrapat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sirapi_md_ruangrapat` (
  `id_ruangrapat` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_ruang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kapasitas` int NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'tersedia',
  `keterangan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_dinas` bigint unsigned DEFAULT NULL,
  `id_kecamatan` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id_ruangrapat`),
  KEY `sirapi_md_ruangrapat_id_dinas_foreign` (`id_dinas`),
  KEY `sirapi_md_ruangrapat_id_kecamatan_foreign` (`id_kecamatan`),
  CONSTRAINT `sirapi_md_ruangrapat_id_dinas_foreign` FOREIGN KEY (`id_dinas`) REFERENCES `sirapi_md_dinas` (`id_dinas`) ON DELETE SET NULL,
  CONSTRAINT `sirapi_md_ruangrapat_id_kecamatan_foreign` FOREIGN KEY (`id_kecamatan`) REFERENCES `sirapi_md_kecamatan` (`id_kecamatan`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sirapi_md_ruangrapat`
--

LOCK TABLES `sirapi_md_ruangrapat` WRITE;
/*!40000 ALTER TABLE `sirapi_md_ruangrapat` DISABLE KEYS */;
INSERT INTO `sirapi_md_ruangrapat` VALUES (1,'Ruang Rapat Utama',40,'tersedia','Ruang rapat utama lantai 2.','2026-09-15 04:09:56','2026-09-15 04:09:56',1,NULL),(2,'Aula Serbaguna',120,'tersedia','Aula untuk rapat besar dan sosialisasi.','2026-09-15 04:09:56','2026-09-15 04:09:56',1,NULL),(3,'Ruang Rapat Bidang',20,'tersedia','Ruang rapat internal bidang.','2026-09-15 04:09:56','2026-09-15 04:09:56',1,NULL),(4,'Ruang rapat 1',20,'tersedia','Aula','2026-09-15 12:52:00','2026-09-15 12:52:00',10,NULL),(5,'Ruang rapat 1',15,'tersedia','Aula 1','2026-09-15 12:55:53','2026-09-15 12:55:53',2,NULL);
/*!40000 ALTER TABLE `sirapi_md_ruangrapat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sirapi_md_statusagenda`
--

DROP TABLE IF EXISTS `sirapi_md_statusagenda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sirapi_md_statusagenda` (
  `id_statusagenda` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_statusagenda`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sirapi_md_statusagenda`
--

LOCK TABLES `sirapi_md_statusagenda` WRITE;
/*!40000 ALTER TABLE `sirapi_md_statusagenda` DISABLE KEYS */;
INSERT INTO `sirapi_md_statusagenda` VALUES (1,'Mendatang','2026-09-15 04:09:56','2026-09-15 04:09:56'),(2,'Berlangsung','2026-09-15 04:09:56','2026-09-15 04:09:56'),(3,'Selesai','2026-09-15 04:09:56','2026-09-15 04:09:56');
/*!40000 ALTER TABLE `sirapi_md_statusagenda` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sirapi_md_tamu`
--

DROP TABLE IF EXISTS `sirapi_md_tamu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sirapi_md_tamu` (
  `id_tamu` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nik` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `asal_instansi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto_selfie` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lokasi_presensi` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_agenda` bigint unsigned NOT NULL,
  PRIMARY KEY (`id_tamu`),
  KEY `sirapi_md_tamu_id_agenda_foreign` (`id_agenda`),
  CONSTRAINT `sirapi_md_tamu_id_agenda_foreign` FOREIGN KEY (`id_agenda`) REFERENCES `sirapi_md_agenda` (`id_agenda`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sirapi_md_tamu`
--

LOCK TABLES `sirapi_md_tamu` WRITE;
/*!40000 ALTER TABLE `sirapi_md_tamu` DISABLE KEYS */;
/*!40000 ALTER TABLE `sirapi_md_tamu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sirapi_md_ulangtahun`
--

DROP TABLE IF EXISTS `sirapi_md_ulangtahun`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sirapi_md_ulangtahun` (
  `id_ulangtahun` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_ulangtahun`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sirapi_md_ulangtahun`
--

LOCK TABLES `sirapi_md_ulangtahun` WRITE;
/*!40000 ALTER TABLE `sirapi_md_ulangtahun` DISABLE KEYS */;
/*!40000 ALTER TABLE `sirapi_md_ulangtahun` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sirapi_md_video`
--

DROP TABLE IF EXISTS `sirapi_md_video`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sirapi_md_video` (
  `id_video` bigint unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `youtube_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `youtube_embed_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_video`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sirapi_md_video`
--

LOCK TABLES `sirapi_md_video` WRITE;
/*!40000 ALTER TABLE `sirapi_md_video` DISABLE KEYS */;
/*!40000 ALTER TABLE `sirapi_md_video` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-09-17  9:01:27
