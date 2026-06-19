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

-- Dumping data for table db_smart.failed_jobs: ~0 rows (approximately)
INSERT INTO `failed_jobs` (`id`, `uuid`, `connection`, `queue`, `payload`, `exception`, `failed_at`) VALUES
	(5, '721a151b-0b5a-4200-bc67-3ebf361fe1ce', 'database', 'default', '{"uuid":"721a151b-0b5a-4200-bc67-3ebf361fe1ce","displayName":"App\\\\Mail\\\\AgendaRapatMail","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\\\Mail\\\\SendQueuedMailable","command":"O:34:\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\":15:{s:8:\\"mailable\\";O:24:\\"App\\\\Mail\\\\AgendaRapatMail\\":5:{s:5:\\"rapat\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:16:\\"App\\\\Models\\\\Rapat\\";s:2:\\"id\\";i:14;s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"mysql\\";s:15:\\"collectionClass\\";N;}s:11:\\"namaPeserta\\";s:5:\\"jafar\\";s:9:\\"linkAbsen\\";s:67:\\"http:\\/\\/localhost\\/absensi\\/hadir\\/8c373cec-486f-4d33-ba2b-f718ab33aef3\\";s:2:\\"to\\";a:1:{i:0;a:2:{s:4:\\"name\\";N;s:7:\\"address\\";s:28:\\"jafarabdillahsidik@gmail.com\\";}}s:6:\\"mailer\\";s:4:\\"smtp\\";}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:13:\\"maxExceptions\\";N;s:17:\\"shouldBeEncrypted\\";b:0;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:19:\\"chainCatchCallbacks\\";N;s:5:\\"delay\\";N;s:11:\\"afterCommit\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}s:3:\\"job\\";N;}"}}', 'Symfony\\Component\\Mailer\\Exception\\TransportException: Connection to "ssl://mail.jafarasidik.my.id:465" has been closed unexpectedly. in C:\\Users\\HP\\Downloads\\smart\\vendor\\symfony\\mailer\\Transport\\Smtp\\Stream\\AbstractStream.php:87\nStack trace:\n#0 C:\\Users\\HP\\Downloads\\smart\\vendor\\symfony\\mailer\\Transport\\Smtp\\SmtpTransport.php(335): Symfony\\Component\\Mailer\\Transport\\Smtp\\Stream\\AbstractStream->readLine()\n#1 C:\\Users\\HP\\Downloads\\smart\\vendor\\symfony\\mailer\\Transport\\Smtp\\SmtpTransport.php(185): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->getFullResponse()\n#2 C:\\Users\\HP\\Downloads\\smart\\vendor\\symfony\\mailer\\Transport\\Smtp\\EsmtpTransport.php(118): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->executeCommand(\'MAIL FROM:<smar...\', Array)\n#3 C:\\Users\\HP\\Downloads\\smart\\vendor\\symfony\\mailer\\Transport\\Smtp\\SmtpTransport.php(248): Symfony\\Component\\Mailer\\Transport\\Smtp\\EsmtpTransport->executeCommand(\'MAIL FROM:<smar...\', Array)\n#4 C:\\Users\\HP\\Downloads\\smart\\vendor\\symfony\\mailer\\Transport\\Smtp\\SmtpTransport.php(203): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->doMailFromCommand(\'smart@jafarasid...\')\n#5 C:\\Users\\HP\\Downloads\\smart\\vendor\\symfony\\mailer\\Transport\\AbstractTransport.php(69): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->doSend(Object(Symfony\\Component\\Mailer\\SentMessage))\n#6 C:\\Users\\HP\\Downloads\\smart\\vendor\\symfony\\mailer\\Transport\\Smtp\\SmtpTransport.php(137): Symfony\\Component\\Mailer\\Transport\\AbstractTransport->send(Object(Symfony\\Component\\Mime\\Email), Object(Symfony\\Component\\Mailer\\DelayedEnvelope))\n#7 C:\\Users\\HP\\Downloads\\smart\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(573): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->send(Object(Symfony\\Component\\Mime\\Email), Object(Symfony\\Component\\Mailer\\DelayedEnvelope))\n#8 C:\\Users\\HP\\Downloads\\smart\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(335): Illuminate\\Mail\\Mailer->sendSymfonyMessage(Object(Symfony\\Component\\Mime\\Email))\n#9 C:\\Users\\HP\\Downloads\\smart\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(213): Illuminate\\Mail\\Mailer->send(\'email.agenda_ra...\', Array, Object(Closure))\n#10 C:\\Users\\HP\\Downloads\\smart\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\Traits\\Localizable.php(19): Illuminate\\Mail\\Mailable->Illuminate\\Mail\\{closure}()\n#11 C:\\Users\\HP\\Downloads\\smart\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailable.php(214): Illuminate\\Mail\\Mailable->withLocale(NULL, Object(Closure))\n#12 C:\\Users\\HP\\Downloads\\smart\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\SendQueuedMailable.php(83): Illuminate\\Mail\\Mailable->send(Object(Illuminate\\Mail\\MailManager))\n#13 C:\\Users\\HP\\Downloads\\smart\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Mail\\SendQueuedMailable->handle(Object(Illuminate\\Mail\\MailManager))\n#14 C:\\Users\\HP\\Downloads\\smart\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(41): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#15 C:\\Users\\HP\\Downloads\\smart\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#16 C:\\Users\\HP\\Downloads\\smart\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#17 C:\\Users\\HP\\Downloads\\smart\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(662): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#18 C:\\Users\\HP\\Downloads\\smart\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(128): Illuminate\\Container\\Container->call(Array)\n#19 C:\\Users\\HP\\Downloads\\smart\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#20 C:\\Users\\HP\\Downloads\\smart\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#21 C:\\Users\\HP\\Downloads\\smart\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#22 C:\\Users\\HP\\Downloads\\smart\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(124): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(Illuminate\\Mail\\SendQueuedMailable), false)\n#23 C:\\Users\\HP\\Downloads\\smart\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(144): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#24 C:\\Users\\HP\\Downloads\\smart\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(119): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Mail\\SendQueuedMailable))\n#25 C:\\Users\\HP\\Downloads\\smart\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(126): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#26 C:\\Users\\HP\\Downloads\\smart\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Mail\\SendQueuedMailable))\n#27 C:\\Users\\HP\\Downloads\\smart\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#28 C:\\Users\\HP\\Downloads\\smart\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(439): Illuminate\\Queue\\Jobs\\Job->fire()\n#29 C:\\Users\\HP\\Downloads\\smart\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(389): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#30 C:\\Users\\HP\\Downloads\\smart\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(176): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#31 C:\\Users\\HP\\Downloads\\smart\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(138): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#32 C:\\Users\\HP\\Downloads\\smart\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(121): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#33 C:\\Users\\HP\\Downloads\\smart\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#34 C:\\Users\\HP\\Downloads\\smart\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(41): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#35 C:\\Users\\HP\\Downloads\\smart\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#36 C:\\Users\\HP\\Downloads\\smart\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#37 C:\\Users\\HP\\Downloads\\smart\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(662): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#38 C:\\Users\\HP\\Downloads\\smart\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(211): Illuminate\\Container\\Container->call(Array)\n#39 C:\\Users\\HP\\Downloads\\smart\\vendor\\symfony\\console\\Command\\Command.php(326): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#40 C:\\Users\\HP\\Downloads\\smart\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(181): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#41 C:\\Users\\HP\\Downloads\\smart\\vendor\\symfony\\console\\Application.php(1121): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#42 C:\\Users\\HP\\Downloads\\smart\\vendor\\symfony\\console\\Application.php(324): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#43 C:\\Users\\HP\\Downloads\\smart\\vendor\\symfony\\console\\Application.php(175): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#44 C:\\Users\\HP\\Downloads\\smart\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(201): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#45 C:\\Users\\HP\\Downloads\\smart\\artisan(37): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#46 {main}', '2026-06-19 14:02:37');

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

-- Dumping data for table db_smart.users: ~1 rows (approximately)
INSERT INTO `users` (`id`, `nama`, `email`, `email_verified_at`, `password`, `remember_token`, `foto`, `created_at`, `updated_at`) VALUES
	(1, 'Jafar', 'jafarasidik@ybth.org', NULL, '$2y$12$PrzZUjHZpbwVJtJcspRTpe.Lh5qnCCSP0R3rFRs5dpt6pFM3DnipW', NULL, 'QMvC7UgB4JhG1Gve4I2cG0netLZwOqnT2O0wx4Uz.jpg', '2026-05-05 15:32:55', '2026-06-06 03:46:45'),
	(2, 'Ihsan Mufaiz', 'ihsan@gmail.com', NULL, '$2y$12$INm65HfbH3ZTCVbRI6fSwu1mQPfPigc2CVlbbYbZRmqGyDoDx78.2', NULL, 'E0efxe6B17aCUmuYSmCbO0BIPZIqi4IwrNTyCQvo.png', '2026-06-06 04:11:32', '2026-06-06 04:55:01');


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

-- Dumping structure for table db_smart.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_smart.jobs: ~0 rows (approximately)

-- Dumping structure for table db_smart.ruangans
CREATE TABLE IF NOT EXISTS `ruangans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_smart.ruangans: ~0 rows (approximately)
INSERT INTO `ruangans` (`id`, `nama`, `lokasi`, `created_at`, `updated_at`) VALUES
	(1, 'R. Rapat', 'Yayasan', '2026-05-05 15:35:25', '2026-05-21 13:48:59');


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

-- Dumping data for table db_smart.pesertas: ~2 rows (approximately)
INSERT INTO `pesertas` (`id`, `nama`, `email`, `id_jabatan_instansi`, `created_at`, `updated_at`) VALUES
	(1, 'ihsan', 'ihsanarif763@gmail.com', 1, '2026-05-05 15:33:25', '2026-06-17 12:13:40'),
	(21, 'jafar', 'jafarabdillahsidik@gmail.com', 5, '2026-06-06 07:42:35', '2026-06-17 12:09:06'),
	(22, 'bapak indra', 'indra.mulyanto11@gmail.com', 2, '2026-06-19 14:32:15', '2026-06-19 14:32:15');


-- Dumping structure for table db_smart.rapats
CREATE TABLE IF NOT EXISTS `rapats` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_selesai` time NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `id_ruangan` bigint unsigned DEFAULT NULL,
  `id_user` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rapats_id_ruangan_foreign` (`id_ruangan`),
  KEY `rapats_id_user_foreign` (`id_user`),
  CONSTRAINT `rapats_id_ruangan_foreign` FOREIGN KEY (`id_ruangan`) REFERENCES `ruangans` (`id`) ON DELETE SET NULL,
  CONSTRAINT `rapats_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_smart.rapats: ~0 rows (approximately)
INSERT INTO `rapats` (`id`, `nama`, `tanggal`, `waktu_mulai`, `waktu_selesai`, `status`, `id_ruangan`, `id_user`, `created_at`, `updated_at`) VALUES
	(13, 'Rapat Organisasi Program MBG', '2026-06-04', '18:06:00', '20:06:00', 1, 1, 1, '2026-06-02 11:06:47', '2026-06-17 11:47:13'),
	(14, 'Rapatmbg', '2026-06-19', '19:30:00', '23:00:00', 1, 1, 2, '2026-06-06 12:26:00', '2026-06-19 14:32:55');



-- Dumping structure for table db_smart.kehadirans
CREATE TABLE IF NOT EXISTS `kehadirans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_rapat` bigint unsigned DEFAULT NULL,
  `id_peserta` bigint unsigned DEFAULT NULL,
  `status` enum('Hadir','Tidak Hadir','Izin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Tidak Hadir',
  `alasan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tandatangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kehadirans_id_rapat_foreign` (`id_rapat`),
  KEY `kehadirans_id_peserta_foreign` (`id_peserta`),
  CONSTRAINT `kehadirans_id_peserta_foreign` FOREIGN KEY (`id_peserta`) REFERENCES `pesertas` (`id`) ON DELETE SET NULL,
  CONSTRAINT `kehadirans_id_rapat_foreign` FOREIGN KEY (`id_rapat`) REFERENCES `rapats` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_smart.kehadirans: ~5 rows (approximately)
INSERT INTO `kehadirans` (`id`, `id_rapat`, `id_peserta`, `status`, `alasan`, `tandatangan`, `created_at`, `updated_at`) VALUES
	(1, 13, 1, 'Hadir', NULL, 'test.jpg', '2026-06-02 11:07:14', '2026-06-02 11:07:14'),
	(2, 13, 21, 'Hadir', NULL, 'public_ttd/ttd_13_21_1781873482.png', '2026-06-19 12:51:22', '2026-06-19 12:51:22'),
	(5, 14, 21, 'Hadir', NULL, 'public_ttd/ttd_14_21_1781878444.png', '2026-06-19 14:14:04', '2026-06-19 14:14:04'),
	(7, 14, 1, 'Hadir', NULL, 'public_ttd/ttd_14_1_1781879651.png', '2026-06-19 14:34:11', '2026-06-19 14:34:11'),
	(10, 14, 22, 'Tidak Hadir', 'ustad cabul', NULL, '2026-06-19 14:39:14', '2026-06-19 14:39:14');

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

-- Dumping data for table db_smart.notulensis: ~0 rows (approximately)
INSERT INTO `notulensis` (`id`, `id_rapat`, `isi_notulensi`, `file`, `publish`, `sampai`, `created_at`, `updated_at`) VALUES
	(4, 13, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris sollicitudin, magna vitae mattis porttitor, arcu libero fermentum orci, luctus accumsan dolor nisi nec sem. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer metus tellus, vulputate sit amet erat at, tincidunt elementum libero. Aliquam erat mauris, rutrum a tempor et, tincidunt eget ligula. Suspendisse vulputate commodo turpis, posuere ultricies ipsum rhoncus a. Ut volutpat feugiat lorem, sed vestibulum lacus. Donec gravida urna nec euismod iaculis. Vivamus ultrices dictum pharetra. Integer dignissim et elit at aliquet. Maecenas ac dapibus metus. Vestibulum gravida nisi mauris, sed vestibulum purus placerat eget. Maecenas porta tincidunt nibh. Donec porttitor lobortis erat quis facilisis. Fusce sapien neque, laoreet sit amet nisl non, ultricies consequat purus. Nunc et sem non tortor volutpat congue sed ac dolor.\r\n\r\nInteger posuere, augue ut fermentum gravida, elit quam auctor orci, sit amet ultrices erat velit molestie felis. Cras vehicula feugiat est, et dictum massa pretium sit amet. Curabitur vitae mi a mauris dignissim dictum. Cras non ante eu ligula pulvinar scelerisque. Nullam vulputate sem vel sollicitudin varius. Cras quis hendrerit lectus, ac fringilla diam. Nunc posuere tempus porta. Aenean vehicula lectus nulla, ut placerat nulla efficitur ac. Integer pretium lacus in arcu fringilla lobortis.', 'rvtLrTixJQO9fx5IlRjG1WiIRtSUQIsRDDrUDoYM.pdf', 0, NULL, '2026-06-02 14:36:59', '2026-06-06 06:51:39');

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
  `uuid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rapat_pesertas_id_rapat_foreign` (`id_rapat`),
  KEY `rapat_pesertas_id_peserta_foreign` (`id_peserta`),
  CONSTRAINT `rapat_pesertas_id_peserta_foreign` FOREIGN KEY (`id_peserta`) REFERENCES `pesertas` (`id`) ON DELETE SET NULL,
  CONSTRAINT `rapat_pesertas_id_rapat_foreign` FOREIGN KEY (`id_rapat`) REFERENCES `rapats` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_smart.rapat_pesertas: ~4 rows (approximately)
INSERT INTO `rapat_pesertas` (`id`, `id_rapat`, `id_peserta`, `uuid`, `created_at`, `updated_at`) VALUES
	(23, 13, 1, '10dd4c00-bd85-40c7-8805-73392fe826ef', '2026-06-17 11:47:13', '2026-06-17 11:47:13'),
	(24, 13, 21, '41901a19-dc87-4d2a-9ce7-ab48647d2e47', '2026-06-17 11:47:13', '2026-06-17 11:47:13'),
	(26, 14, 21, '8c373cec-486f-4d33-ba2b-f718ab33aef3', '2026-06-17 11:47:56', '2026-06-19 14:32:55'),
	(30, 14, 22, 'cb2b316c-bd17-459f-a5e0-6c699a5a3733', '2026-06-19 14:32:55', '2026-06-19 14:32:55'),
	(31, 14, 1, 'e5cc4cdf-e340-483c-895a-019ce7a9ebba', '2026-06-19 14:32:55', '2026-06-19 14:32:55');


/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
