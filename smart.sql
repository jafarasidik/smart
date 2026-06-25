-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table db_smart.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_smart.failed_jobs: ~1 rows (approximately)

-- Dumping structure for table db_smart.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '7.jpg',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_smart.users: ~2 rows (approximately)
INSERT INTO `users` (`id`, `nama`, `email`, `email_verified_at`, `password`, `remember_token`, `foto`, `created_at`, `updated_at`) VALUES
	(1, 'Jafar', 'jafarasidik@ybth.org', NULL, '$2y$12$PrzZUjHZpbwVJtJcspRTpe.Lh5qnCCSP0R3rFRs5dpt6pFM3DnipW', NULL, 'QMvC7UgB4JhG1Gve4I2cG0netLZwOqnT2O0wx4Uz.jpg', '2026-05-05 15:32:55', '2026-06-06 03:46:45'),
	(2, 'Ihsan Mufaiz', 'ihsan@gmail.com', NULL, '$2y$12$INm65HfbH3ZTCVbRI6fSwu1mQPfPigc2CVlbbYbZRmqGyDoDx78.2', NULL, 'E0efxe6B17aCUmuYSmCbO0BIPZIqi4IwrNTyCQvo.png', '2026-06-06 04:11:32', '2026-06-06 04:55:01');

-- Dumping structure for table db_smart.ruangans
CREATE TABLE IF NOT EXISTS `ruangans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_smart.ruangans: ~1 rows (approximately)
INSERT INTO `ruangans` (`id`, `nama`, `lokasi`, `created_at`, `updated_at`) VALUES
	(1, 'R. Rapat', 'Yayasan', '2026-05-05 15:35:25', '2026-05-21 13:48:59');


-- Dumping structure for table db_smart.instansi_x_jabatans
CREATE TABLE IF NOT EXISTS `instansi_x_jabatans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_instansi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_jabatan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_smart.instansi_x_jabatans: ~3 rows (approximately)
INSERT INTO `instansi_x_jabatans` (`id`, `nama_instansi`, `nama_jabatan`, `created_at`, `updated_at`) VALUES
	(1, 'Sekretariat Yayasan', 'TIK', '2026-05-11 14:17:08', '2026-05-11 14:17:09'),
	(2, 'Sekretariat Yayasan', 'Ketua Yayasan', '2026-05-11 14:21:07', '2026-05-11 14:21:07'),
	(5, 'Sekretariat Yayasan', 'Keuangan', '2026-05-21 14:27:18', '2026-05-21 14:27:18');


-- Dumping structure for table db_smart.pesertas
CREATE TABLE IF NOT EXISTS `pesertas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_jabatan_instansi` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `pesertas_id_jabatan_instansi_foreign` (`id_jabatan_instansi`),
  CONSTRAINT `pesertas_id_jabatan_instansi_foreign` FOREIGN KEY (`id_jabatan_instansi`) REFERENCES `instansi_x_jabatans` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_smart.pesertas: ~3 rows (approximately)
INSERT INTO `pesertas` (`id`, `nama`, `email`, `id_jabatan_instansi`, `created_at`, `updated_at`) VALUES
	(1, 'ihsan', 'ihsanarif763@gmail.com', 1, '2026-05-05 15:33:25', '2026-06-17 12:13:40'),
	(21, 'jafar', 'jafarabdillahsidik@gmail.com', 5, '2026-06-06 07:42:35', '2026-06-17 12:09:06'),
	(22, 'bapak indra', 'indra.mulyanto11@gmail.com', 2, '2026-06-19 14:32:15', '2026-06-19 14:32:15');


-- Dumping structure for table db_smart.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_smart.jobs: ~0 rows (approximately)

-- Dumping structure for table db_smart.rapats
CREATE TABLE IF NOT EXISTS `rapats` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_selesai` time NOT NULL,
  `status` enum('Aktif','Tidak Aktif','Selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Selesai',
  `id_ruangan` bigint unsigned DEFAULT NULL,
  `id_user` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rapats_id_ruangan_foreign` (`id_ruangan`),
  KEY `rapats_id_user_foreign` (`id_user`),
  CONSTRAINT `rapats_id_ruangan_foreign` FOREIGN KEY (`id_ruangan`) REFERENCES `ruangans` (`id`) ON DELETE SET NULL,
  CONSTRAINT `rapats_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_smart.rapats: ~4 rows (approximately)
INSERT INTO `rapats` (`id`, `nama`, `tanggal`, `waktu_mulai`, `waktu_selesai`, `status`, `id_ruangan`, `id_user`, `created_at`, `updated_at`) VALUES
	(13, 'Rapat Organisasi Program MBG', '2026-06-04', '18:06:00', '20:06:00', 'Selesai', 1, 1, '2026-06-02 11:06:47', '2026-06-25 14:46:55'),
	(14, 'Rapatmbg', '2026-06-19', '19:30:00', '23:00:00', 'Selesai', 1, 2, '2026-06-06 12:26:00', '2026-06-25 15:10:55'),
	(19, 'Rapat Tester', '2026-06-24', '20:55:00', '23:56:00', 'Selesai', 1, 1, '2026-06-25 14:56:21', '2026-06-25 15:09:37'),
	(20, 'Rapat Organisasi Program MBG', '2026-06-24', '12:12:00', '17:12:00', 'Selesai', 1, 1, '2026-06-25 15:12:35', '2026-06-25 15:12:35');


-- Dumping structure for table db_smart.kehadirans
CREATE TABLE IF NOT EXISTS `kehadirans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_rapat` bigint unsigned DEFAULT NULL,
  `id_peserta` bigint unsigned DEFAULT NULL,
  `status` enum('Hadir','Tidak Hadir','Izin') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Tidak Hadir',
  `alasan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tandatangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kehadirans_id_rapat_foreign` (`id_rapat`),
  KEY `kehadirans_id_peserta_foreign` (`id_peserta`),
  CONSTRAINT `kehadirans_id_peserta_foreign` FOREIGN KEY (`id_peserta`) REFERENCES `pesertas` (`id`) ON DELETE SET NULL,
  CONSTRAINT `kehadirans_id_rapat_foreign` FOREIGN KEY (`id_rapat`) REFERENCES `rapats` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_smart.kehadirans: ~8 rows (approximately)
INSERT INTO `kehadirans` (`id`, `id_rapat`, `id_peserta`, `status`, `alasan`, `tandatangan`, `created_at`, `updated_at`) VALUES
	(1, 13, 1, 'Hadir', NULL, 'test.jpg', '2026-06-02 11:07:14', '2026-06-02 11:07:14'),
	(2, 13, 21, 'Hadir', NULL, 'public_ttd/ttd_13_21_1781873482.png', '2026-06-19 12:51:22', '2026-06-19 12:51:22'),
	(5, 14, 21, 'Hadir', NULL, 'public_ttd/ttd_14_21_1781878444.png', '2026-06-19 14:14:04', '2026-06-19 14:14:04'),
	(7, 14, 1, 'Hadir', NULL, 'public_ttd/ttd_14_1_1781879651.png', '2026-06-19 14:34:11', '2026-06-19 14:34:11'),
	(11, 19, 21, 'Tidak Hadir', 'Sistem: Otomatis Tidak Hadir karena rapat telah selesai', NULL, '2026-06-25 15:09:37', '2026-06-25 15:09:37'),
	(12, 20, 22, 'Tidak Hadir', 'Sistem: Otomatis Tidak Hadir karena rapat telah selesai', NULL, '2026-06-25 15:12:35', '2026-06-25 15:12:35'),
	(13, 20, 1, 'Tidak Hadir', 'Sistem: Otomatis Tidak Hadir karena rapat telah selesai', NULL, '2026-06-25 15:12:35', '2026-06-25 15:12:35'),
	(14, 20, 21, 'Tidak Hadir', 'Sistem: Otomatis Tidak Hadir karena rapat telah selesai', NULL, '2026-06-25 15:12:35', '2026-06-25 15:12:35');

-- Dumping structure for table db_smart.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_smart.migrations: ~13 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2026_05_05_201103_create_ruangans_table', 1),
	(6, '2026_05_05_201239_create_pesertas_table', 1),
	(7, '2026_05_05_201347_create_rapats_table', 1),
	(8, '2026_05_05_201442_create_notulensis_table', 1),
	(9, '2026_05_05_201459_create_kehadirans_table', 1),
	(10, '2026_05_05_220705_create_rapat_pesertas_table', 2),
	(11, '2026_05_11_203109_create_instansi_x_jabatans_table', 3),
	(12, '2026_05_11_203450_add_id_jabatan_instansi_to_pesertas_table', 3),
	(13, '2026_06_17_190517_create_jobs_table', 4);

-- Dumping structure for table db_smart.notulensis
CREATE TABLE IF NOT EXISTS `notulensis` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_rapat` bigint unsigned DEFAULT NULL,
  `isi_notulensi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `publish` tinyint(1) NOT NULL DEFAULT '0',
  `sampai` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notulensis_id_rapat_foreign` (`id_rapat`),
  CONSTRAINT `notulensis_id_rapat_foreign` FOREIGN KEY (`id_rapat`) REFERENCES `rapats` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_smart.notulensis: ~1 rows (approximately)
INSERT INTO `notulensis` (`id`, `id_rapat`, `isi_notulensi`, `file`, `created_at`, `updated_at`) VALUES
	(4, 13, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris sollicitudin, magna vitae mattis porttitor, arcu libero fermentum orci, luctus accumsan dolor nisi nec sem. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer metus tellus, vulputate sit amet erat at, tincidunt elementum libero. Aliquam erat mauris, rutrum a tempor et, tincidunt eget ligula. Suspendisse vulputate commodo turpis, posuere ultricies ipsum rhoncus a. Ut volutpat feugiat lorem, sed vestibulum lacus. Donec gravida urna nec euismod iaculis. Vivamus ultrices dictum pharetra. Integer dignissim et elit at aliquet. Maecenas ac dapibus metus. Vestibulum gravida nisi mauris, sed vestibulum purus placerat eget. Maecenas porta tincidunt nibh. Donec porttitor lobortis erat quis facilisis. Fusce sapien neque, laoreet sit amet nisl non, ultricies consequat purus. Nunc et sem non tortor volutpat congue sed ac dolor.\r\n\r\nInteger posuere, augue ut fermentum gravida, elit quam auctor orci, sit amet ultrices erat velit molestie felis. Cras vehicula feugiat est, et dictum massa pretium sit amet. Curabitur vitae mi a mauris dignissim dictum. Cras non ante eu ligula pulvinar scelerisque. Nullam vulputate sem vel sollicitudin varius. Cras quis hendrerit lectus, ac fringilla diam. Nunc posuere tempus porta. Aenean vehicula lectus nulla, ut placerat nulla efficitur ac. Integer pretium lacus in arcu fringilla lobortis.', 'rvtLrTixJQO9fx5IlRjG1WiIRtSUQIsRDDrUDoYM.pdf', '2026-06-02 14:36:59', '2026-06-06 06:51:39');

-- Dumping structure for table db_smart.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_smart.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table db_smart.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_smart.personal_access_tokens: ~0 rows (approximately)


-- Dumping structure for table db_smart.rapat_pesertas
CREATE TABLE IF NOT EXISTS `rapat_pesertas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_rapat` bigint unsigned DEFAULT NULL,
  `id_peserta` bigint unsigned DEFAULT NULL,
  `uuid` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rapat_pesertas_id_rapat_foreign` (`id_rapat`),
  KEY `rapat_pesertas_id_peserta_foreign` (`id_peserta`),
  CONSTRAINT `rapat_pesertas_id_peserta_foreign` FOREIGN KEY (`id_peserta`) REFERENCES `pesertas` (`id`) ON DELETE SET NULL,
  CONSTRAINT `rapat_pesertas_id_rapat_foreign` FOREIGN KEY (`id_rapat`) REFERENCES `rapats` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_smart.rapat_pesertas: ~9 rows (approximately)
INSERT INTO `rapat_pesertas` (`id`, `id_rapat`, `id_peserta`, `uuid`, `created_at`, `updated_at`) VALUES
	(23, 13, 1, '10dd4c00-bd85-40c7-8805-73392fe826ef', '2026-06-17 11:47:13', '2026-06-17 11:47:13'),
	(24, 13, 21, '41901a19-dc87-4d2a-9ce7-ab48647d2e47', '2026-06-17 11:47:13', '2026-06-17 11:47:13'),
	(26, 14, 21, '8c373cec-486f-4d33-ba2b-f718ab33aef3', '2026-06-17 11:47:56', '2026-06-25 15:10:55'),
	(30, 14, 22, 'cb2b316c-bd17-459f-a5e0-6c699a5a3733', '2026-06-19 14:32:55', '2026-06-25 15:10:55'),
	(31, 14, 1, 'e5cc4cdf-e340-483c-895a-019ce7a9ebba', '2026-06-19 14:32:55', '2026-06-25 15:10:55'),
	(44, 19, 21, 'd16a0af8-9564-4c6d-9a29-78c2f02a5341', '2026-06-25 14:56:21', '2026-06-25 15:09:20'),
	(45, 20, 22, 'ad9df0c4-39f4-43bf-84a0-aca3ac903cc0', '2026-06-25 15:12:35', '2026-06-25 15:12:35'),
	(46, 20, 1, '4ac27b52-dde7-4182-b3b7-ad081bbfb2ce', '2026-06-25 15:12:35', '2026-06-25 15:12:35'),
	(47, 20, 21, '6e89998c-256d-46ab-903c-daa647339cb8', '2026-06-25 15:12:35', '2026-06-25 15:12:35');


/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
