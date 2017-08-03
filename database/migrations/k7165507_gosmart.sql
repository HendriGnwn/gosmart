-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: 03 Agu 2017 pada 05.54
-- Versi Server: 5.5.55-cll
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `k7165507_gosmart`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bank`
--

CREATE TABLE `bank` (
  `id` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `branch` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `behalf_of` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `bank`
--

INSERT INTO `bank` (`id`, `payment_id`, `name`, `image`, `description`, `branch`, `behalf_of`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'BCA', 'bca.jpg', 'Bank Central Asia', 'Sawah Besar, Jakarta Pusat', 'Hendri Gunawan', NULL, '2017-06-18 07:38:11', '2017-06-18 07:38:11'),
(2, 1, 'DANAMON', 'danamon.jpg', 'Bank Danamon', 'Sawah Besar, Jakarta Pusat', 'Hendri Gunawan', NULL, '2017-06-18 07:38:11', '2017-06-18 07:38:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `config`
--

CREATE TABLE `config` (
  `name` char(100) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `notes` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `config`
--

INSERT INTO `config` (`name`, `value`, `notes`) VALUES
('additional_cost', '30000', NULL),
('teacher_course_admin_fee', '5000', NULL),
('term_condition_teacher', 'Lorem ipsum dolor de', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `course`
--

CREATE TABLE `course` (
  `id` bigint(20) NOT NULL,
  `course_level_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `section` int(11) NOT NULL,
  `section_time` time NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1' COMMENT '1=Active;0=Inactive',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `course`
--

INSERT INTO `course` (`id`, `course_level_id`, `name`, `description`, `section`, `section_time`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'Matematika I', 'Matematika Sekolah Dasar Kelas 1', 3, '01:30:00', 1, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 1, 'Bahasa Indonesia I', 'Bahasa Indonesia Sekolah Dasar Kelas 1', 3, '01:30:00', 1, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 2, 'Matematika II', 'Matematika Sekolah Dasar Kelas 2', 4, '01:30:00', 1, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 2, 'Bahasa Indonesia II', 'Bahasa Indonesia Sekolah Dasar Kelas 2', 4, '01:30:00', 1, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 3, 'Matematika III', 'Matematika Sekolah Dasar Kelas 3', 3, '01:30:00', 1, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 3, 'Bahasa Indonesia III', 'Bahasa Indonesia Sekolah Dasar Kelas 3', 3, '01:30:00', 1, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 4, 'Matematika IV', 'Matematika Sekolah Dasar Kelas 4', 3, '01:30:00', 1, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 4, 'Bahasa Indonesia IV', 'Bahasa Indonesia Sekolah Dasar Kelas 4', 3, '01:30:00', 1, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 5, 'Matematika V', 'Matematika Sekolah Dasar Kelas 5', 3, '01:30:00', 1, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 5, 'Bahasa Indonesia V', 'Bahasa Indonesia Sekolah Dasar Kelas 5', 4, '01:30:00', 1, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 6, 'Matematika VI', 'Matematika Sekolah Dasar Kelas 6', 4, '01:30:00', 1, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 6, 'Bahasa Indonesia VI', 'Bahasa Indonesia Sekolah Dasar Kelas 6', 4, '01:30:00', 1, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 7, 'Matematika VII', 'Matematika Sekolah Menengah Pertama Kelas 7', 4, '01:30:00', 1, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 7, 'Bahasa Indonesia VII', 'Bahasa Indonesia Sekolah Menengah Pertama Kelas 7', 4, '01:30:00', 1, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 8, 'Matematika VIII', 'Matematika Sekolah Menengah Pertama Kelas 8', 2, '01:30:00', 1, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 8, 'Bahasa Indonesia VIII', 'Bahasa Indonesia Sekolah Menengah Pertama Kelas 8', 2, '01:30:00', 1, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, 9, 'Matematika IX', 'Matematika Sekolah Menengah Pertama Kelas 9', 2, '01:30:00', 1, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, 9, 'Bahasa Indonesia IX', 'Bahasa Indonesia Sekolah Menengah Pertama Kelas 9', 2, '01:30:00', 1, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, 10, 'Matematika X', 'Matematika Sekolah Menengah Atas Kelas 10', 5, '01:30:00', 1, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, 10, 'Bahasa Indonesia X', 'Bahasa Indonesia Sekolah Menengah Atas Kelas 10', 5, '01:30:00', 1, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, 11, 'Matematika XI', 'Matematika Sekolah Menengah Atas Kelas 11', 5, '01:30:00', 1, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, 11, 'Bahasa Indonesia XI', 'Bahasa Indonesia Sekolah Menengah Atas Kelas 11', 5, '01:30:00', 1, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, 12, 'Matematika XII', 'Matematika Sekolah Menengah Atas Kelas 12', 3, '01:30:00', 1, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(24, 12, 'Bahasa Indonesia XII', 'Bahasa Indonesia Sekolah Menengah Atas Kelas 12', 3, '01:30:00', 1, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `course_level`
--

CREATE TABLE `course_level` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL COMMENT '1=Active;0=Inactive;',
  `order` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `course_level`
--

INSERT INTO `course_level` (`id`, `name`, `status`, `order`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Sekolah Dasar I', 1, 0, NULL, '2017-06-20 11:57:55', '2017-06-20 11:57:55'),
(2, 'Sekolah Dasar II', 1, 1, NULL, '2017-06-20 12:00:06', '2017-06-20 12:00:06'),
(3, 'Sekolah Dasar III', 1, 2, NULL, '2017-06-20 12:00:06', '2017-06-20 12:00:06'),
(4, 'Sekolah Dasar IV', 1, 3, NULL, '2017-06-20 12:00:06', '2017-06-20 12:00:06'),
(5, 'Sekolah Dasar V', 1, 4, NULL, '2017-06-20 12:00:06', '2017-06-20 12:00:06'),
(6, 'Sekolah Dasar VI', 1, 5, NULL, '2017-06-20 12:00:06', '2017-06-20 12:00:06'),
(7, 'Sekolah Menengah Pertama VII', 1, 6, NULL, '2017-06-20 12:00:06', '2017-06-20 12:00:06'),
(8, 'Sekolah Menengah Pertama VIII', 1, 7, NULL, '2017-06-20 12:00:06', '2017-06-20 12:00:06'),
(9, 'Sekolah Menengah Pertama IX', 1, 8, NULL, '2017-06-20 12:00:06', '2017-06-20 12:00:06'),
(10, 'Sekolah Menengah Atas X', 1, 9, NULL, '2017-06-20 12:00:06', '2017-06-20 12:00:06'),
(11, 'Sekolah Menengah Atas XI', 1, 10, NULL, '2017-06-20 12:00:06', '2017-06-20 12:00:06'),
(12, 'Sekolah Menengah Atas XII', 1, 11, NULL, '2017-06-20 12:00:06', '2017-06-20 12:00:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `order`
--

CREATE TABLE `order` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL COMMENT 'as student',
  `teacher_id` bigint(20) NOT NULL COMMENT 'as teacher',
  `code` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `section` int(11) NOT NULL,
  `section_time` time NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `admin_fee` decimal(14,2) NOT NULL,
  `final_amount` decimal(14,2) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `status` smallint(6) NOT NULL COMMENT '0=Canceled;1=Waiting Payment;5=Confirmed;10=Paid;',
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `paid_by` bigint(20) DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `order`
--

INSERT INTO `order` (`id`, `user_id`, `teacher_id`, `code`, `section`, `section_time`, `start_date`, `end_date`, `admin_fee`, `final_amount`, `payment_id`, `status`, `confirmed_at`, `paid_by`, `paid_at`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'INV-201707-00001', 8, '12:00:00', '2017-07-05', '2017-07-08', '5000.00', '235000.00', 1, 10, '2017-07-02 04:20:14', 3, '2017-07-12 15:01:44', '2017-07-02 04:10:57', '2017-07-12 15:01:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_confirmation`
--

CREATE TABLE `order_confirmation` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `bank_id` int(11) NOT NULL,
  `bank_number` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `bank_behalf_of` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(14,2) NOT NULL,
  `upload_bukti` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `order_confirmation`
--

INSERT INTO `order_confirmation` (`id`, `user_id`, `order_id`, `bank_id`, `bank_number`, `bank_behalf_of`, `amount`, `upload_bukti`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2240026256', 'Rendi Gunawan', '235000.00', 'order-confirmation-inv-201707-00001.jpg', 'telahj di bayar', '2017-07-02 04:20:14', '2017-07-02 04:20:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_detail`
--

CREATE TABLE `order_detail` (
  `id` bigint(20) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `course_id` bigint(20) NOT NULL,
  `on_at` text COLLATE utf8_unicode_ci NOT NULL,
  `section` int(11) NOT NULL,
  `section_time` time NOT NULL,
  `amount` decimal(14,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `order_detail`
--

INSERT INTO `order_detail` (`id`, `order_id`, `course_id`, `on_at`, `section`, `section_time`, `amount`, `created_at`, `updated_at`) VALUES
(1, 1, 13, '2017-07-05 10:00:00,2017-07-06 10:00:00,2017-07-07 10:00:00,2017-07-08 10:00:00', 4, '01:30:00', '1150000.00', '2017-07-02 04:12:25', '2017-07-02 04:12:25'),
(2, 1, 14, '2017-07-05 11:30:00,2017-07-06 11:30:00,2017-07-07 11:30:00,2017-07-08 11:30:00', 4, '01:30:00', '1150000.00', '2017-07-02 04:12:51', '2017-07-02 04:12:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(1) NOT NULL DEFAULT '1' COMMENT '1=Active;0=Inactive',
  `order` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `payment`
--

INSERT INTO `payment` (`id`, `name`, `status`, `order`, `created_at`, `updated_at`) VALUES
(1, 'Transfer Bank', 1, 0, '2017-06-18 01:00:00', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `private`
--

CREATE TABLE `private` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `teacher_id` bigint(20) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `section` int(11) NOT NULL,
  `section_time` time NOT NULL,
  `code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1' COMMENT '1=Belum Mulai;5=On Going;10=Done;',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `private`
--

INSERT INTO `private` (`id`, `user_id`, `teacher_id`, `order_id`, `section`, `section_time`, `code`, `start_date`, `end_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 1, 8, '12:00:00', 'PRI-201707-0001', '2017-07-05', '2017-07-08', 1, '2017-07-12 15:01:35', '2017-07-12 15:01:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `private_detail`
--

CREATE TABLE `private_detail` (
  `id` bigint(20) NOT NULL,
  `private_id` bigint(20) NOT NULL,
  `course_id` bigint(20) NOT NULL,
  `on_at` text COLLATE utf8_unicode_ci,
  `section` int(11) DEFAULT NULL,
  `section_time` time DEFAULT NULL,
  `student_details` text COLLATE utf8_unicode_ci,
  `teacher_details` text COLLATE utf8_unicode_ci,
  `checklist` smallint(1) DEFAULT NULL COMMENT '1=True;0=False;',
  `checklist_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `private_detail`
--

INSERT INTO `private_detail` (`id`, `private_id`, `course_id`, `on_at`, `section`, `section_time`, `student_details`, `teacher_details`, `checklist`, `checklist_at`, `created_at`, `updated_at`) VALUES
(1, 1, 13, '2017-07-05 10:00:00,2017-07-06 10:00:00,2017-07-07 10:00:00,2017-07-08 10:00:00', 4, '01:30:00', '[{\"on_at\":\"2017-07-05 10:00:00\",\"check\":0,\"check_at\":\"\"},{\"on_at\":\"2017-07-06 10:00:00\",\"check\":0,\"check_at\":\"\"},{\"on_at\":\"2017-07-07 10:00:00\",\"check\":0,\"check_at\":\"\"},{\"on_at\":\"2017-07-08 10:00:00\",\"check\":0,\"check_at\":\"\"}]', '[{\"on_at\":\"2017-07-05 10:00:00\",\"check\":0,\"check_at\":\"\"},{\"on_at\":\"2017-07-06 10:00:00\",\"check\":0,\"check_at\":\"\"},{\"on_at\":\"2017-07-07 10:00:00\",\"check\":0,\"check_at\":\"\"},{\"on_at\":\"2017-07-08 10:00:00\",\"check\":0,\"check_at\":\"\"}]', 0, NULL, '2017-07-12 15:01:35', '2017-07-12 15:01:35'),
(2, 1, 14, '2017-07-05 11:30:00,2017-07-06 11:30:00,2017-07-07 11:30:00,2017-07-08 11:30:00', 4, '01:30:00', '[{\"on_at\":\"2017-07-05 11:30:00\",\"check\":0,\"check_at\":\"\"},{\"on_at\":\"2017-07-06 11:30:00\",\"check\":0,\"check_at\":\"\"},{\"on_at\":\"2017-07-07 11:30:00\",\"check\":0,\"check_at\":\"\"},{\"on_at\":\"2017-07-08 11:30:00\",\"check\":0,\"check_at\":\"\"}]', '[{\"on_at\":\"2017-07-05 11:30:00\",\"check\":0,\"check_at\":\"\"},{\"on_at\":\"2017-07-06 11:30:00\",\"check\":0,\"check_at\":\"\"},{\"on_at\":\"2017-07-07 11:30:00\",\"check\":0,\"check_at\":\"\"},{\"on_at\":\"2017-07-08 11:30:00\",\"check\":0,\"check_at\":\"\"}]', 0, NULL, '2017-07-12 15:01:35', '2017-07-12 15:01:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `review`
--

CREATE TABLE `review` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `teacher_id` bigint(20) NOT NULL,
  `private_id` bigint(20) NOT NULL,
  `rate` smallint(6) NOT NULL,
  `description` text NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `student_profile`
--

CREATE TABLE `student_profile` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `school` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `degree` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `department` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `school_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `formal_photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Master User Student';

--
-- Dumping data untuk tabel `student_profile`
--

INSERT INTO `student_profile` (`id`, `user_id`, `school`, `degree`, `department`, `school_address`, `photo`, `formal_photo`, `created_at`, `updated_at`) VALUES
(1, 1, 'SMP Negeri Ciampea - Bogor', '7', 'Gunawan', 'Jl Letnan Sukarna Ciampea Bogor', 'hendri.jpg', NULL, NULL, '2017-07-28 21:37:14'),
(2, 6, NULL, NULL, NULL, NULL, NULL, NULL, '2017-06-24 06:37:26', '2017-06-24 06:37:26'),
(3, 17, NULL, NULL, NULL, NULL, NULL, NULL, '2017-07-18 13:27:14', '2017-07-18 13:27:14'),
(4, 18, 'SMP Negeri Ciampea - Bogor', '7', NULL, 'Jl Letnan Sukarna Ciampea Bogor', NULL, NULL, '2017-07-18 13:45:39', '2017-07-18 14:10:56'),
(5, 20, NULL, NULL, NULL, NULL, NULL, NULL, '2017-07-21 17:45:26', '2017-07-21 17:45:26'),
(6, 21, NULL, NULL, NULL, NULL, NULL, NULL, '2017-07-21 17:51:22', '2017-07-21 17:51:22'),
(7, 22, NULL, NULL, NULL, NULL, NULL, NULL, '2017-07-21 17:53:37', '2017-07-21 17:53:37'),
(8, 23, NULL, NULL, NULL, NULL, NULL, NULL, '2017-07-21 17:56:10', '2017-07-21 17:56:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `teacher_bank`
--

CREATE TABLE `teacher_bank` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `number` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `branch` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `behalf_of` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `teacher_bank`
--

INSERT INTO `teacher_bank` (`id`, `user_id`, `name`, `number`, `branch`, `behalf_of`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 2, 'BCA', '2240026255', 'KCP Sawah Besar', 'Hendri Gunawan', NULL, '2017-07-16 10:22:12', '2017-07-29 13:10:09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `teacher_course`
--

CREATE TABLE `teacher_course` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `course_id` bigint(20) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `expected_cost` decimal(14,2) NOT NULL,
  `expected_cost_updated_at` timestamp NULL DEFAULT NULL,
  `additional_cost` decimal(14,2) NOT NULL DEFAULT '0.00',
  `admin_fee` decimal(14,2) NOT NULL DEFAULT '0.00',
  `final_cost` decimal(14,2) NOT NULL DEFAULT '0.00',
  `approved_by` bigint(20) DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `module` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='teacher bisa ngajar mapel apa aja';

--
-- Dumping data untuk tabel `teacher_course`
--

INSERT INTO `teacher_course` (`id`, `user_id`, `course_id`, `description`, `expected_cost`, `expected_cost_updated_at`, `additional_cost`, `admin_fee`, `final_cost`, `approved_by`, `approved_at`, `module`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '', '80000.00', '2017-06-24 07:33:51', '30000.00', '5000.00', '115000.00', 3, '2017-06-24 07:33:51', 'module-matematika.pdf', 1, '2017-06-24 07:33:51', '2017-06-24 14:33:51'),
(2, 2, 13, 'Matematika kelas 7', '80000.00', '2017-06-24 07:33:51', '30000.00', '5000.00', '115000.00', 3, '2017-06-24 07:33:51', 'module-matematika.pdf', 1, '2017-06-24 07:33:51', '2017-06-24 14:33:51'),
(3, 2, 14, 'Bahasa indonesia kelas 7', '80000.00', '2017-06-24 07:33:51', '30000.00', '5000.00', '115000.00', 3, '2017-06-24 07:33:51', 'module-bahasaindonesia.pdf', 1, '2017-06-24 07:33:51', '2017-06-24 14:33:51'),
(4, 2, 2, 'lorem ipsum dolor de', '80000.00', '2017-07-02 06:12:35', '30000.00', '5000.00', '115000.00', NULL, NULL, NULL, 0, '2017-07-02 06:12:35', '2017-07-02 13:12:35'),
(7, 2, 16, 'Saya ingin mengajar Bahasa Indonesia Viii', '160000.00', '2017-07-14 11:31:25', '30000.00', '5000.00', '195000.00', 3, '2017-07-14 11:31:25', '45161.pdf', 1, '2017-07-14 11:31:25', '2017-07-14 18:31:25'),
(9, 2, 3, 'lorem ipsum dolor de', '80000.00', '2017-07-18 14:34:41', '30000.00', '5000.00', '115000.00', NULL, NULL, NULL, 0, '2017-07-18 14:34:41', '2017-07-18 21:34:41');

-- --------------------------------------------------------

--
-- Struktur dari tabel `teacher_profile`
--

CREATE TABLE `teacher_profile` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `title` smallint(6) DEFAULT NULL COMMENT '1=S1;2=S2;3=S3',
  `izajah_number` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `graduated` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'College',
  `bio` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `upload_izajah` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `formal_photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total` decimal(14,2) NOT NULL DEFAULT '0.00',
  `total_updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Master User Teacher';

--
-- Dumping data untuk tabel `teacher_profile`
--

INSERT INTO `teacher_profile` (`id`, `user_id`, `title`, `izajah_number`, `graduated`, `bio`, `photo`, `upload_izajah`, `formal_photo`, `total`, `total_updated_at`, `created_at`, `updated_at`) VALUES
(1, 2, 4, 'NC821920192', 'Universitas Mercu Buana Jakarta', 'My name is Hendri', 'hendri-teacher.jpg', NULL, NULL, '0.00', NULL, NULL, '2017-07-28 19:42:48'),
(2, 12, 1, 'DC-0290-01292', 'Universitas Mercu Buana Jakarta', NULL, NULL, NULL, NULL, '0.00', NULL, '2017-06-24 06:45:40', '2017-06-30 06:24:23'),
(3, 16, 2, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', NULL, '2017-07-18 13:25:10', '2017-07-18 13:25:10'),
(4, 19, 2, 'DC-0290-01292', 'Universitas Mercu Buana Jakarta', 'I\'m Web Developer', 'gunawan-teacher-1500386440.png', 'gunawan-teacher-1500386527.png', NULL, '0.00', NULL, '2017-07-18 13:46:01', '2017-07-18 14:02:07'),
(5, 24, 1, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', NULL, '2017-07-21 18:32:53', '2017-07-21 18:32:53'),
(6, 25, 3, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', NULL, '2017-07-21 18:50:55', '2017-07-21 18:50:55'),
(7, 26, 2, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', NULL, '2017-07-24 20:45:40', '2017-07-24 20:45:40'),
(8, 27, 2, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', NULL, '2017-07-28 20:35:35', '2017-07-28 20:35:35'),
(9, 28, 2, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', NULL, '2017-07-28 20:35:59', '2017-07-28 20:35:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `teacher_total_history`
--

CREATE TABLE `teacher_total_history` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `private_id` bigint(20) NOT NULL,
  `operation` smallint(1) NOT NULL COMMENT '1=+;0=-',
  `total` decimal(14,2) NOT NULL,
  `evidence` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '5' COMMENT '0=Rejected;5=Waiting;1=Approved;10=Done',
  `approved_by` bigint(20) DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `done_by` bigint(20) DEFAULT NULL,
  `done_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Teacher History Total (Honor)';

--
-- Dumping data untuk tabel `teacher_total_history`
--

INSERT INTO `teacher_total_history` (`id`, `user_id`, `private_id`, `operation`, `total`, `evidence`, `status`, `approved_by`, `approved_at`, `done_by`, `done_at`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 1, '10000.00', '32777.jpg', 1, 3, '2017-07-16 11:56:11', 3, '2017-07-16 11:54:34', NULL, '2017-07-14 11:46:37', '2017-07-16 11:56:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` bigint(20) NOT NULL,
  `unique_number` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_number` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `photo` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(600) COLLATE utf8_unicode_ci DEFAULT NULL,
  `firebase_token` varchar(600) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(2) NOT NULL DEFAULT '0' COMMENT '1=Active;5=Blocked;0=Inactive(Tapi masih bisa login)',
  `role` smallint(6) NOT NULL COMMENT '1=User/Administrator; 2=Teacher;3=Student',
  `last_login_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Master User';

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `unique_number`, `first_name`, `last_name`, `phone_number`, `photo`, `latitude`, `longitude`, `address`, `email`, `password`, `remember_token`, `firebase_token`, `status`, `role`, `last_login_at`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'STU2017060001', 'Hendri', 'Student', '08561471500', 'hendri-student-1501236740.jpg', 10, 10, 'Jl Batu Ceper X No 2Y, Kebon Kelapa Gambir Jakarta Pusat', 'hendri.gnw@gmail.com', '$2y$10$ZHgHAL.sM4nogsZDVJNI0.i.ANfjRiEEFI0CCBICs9/ER88xSAlbq', 'JnDMEpUe4vbuvW7hXQNVdQeVUwXlJB3OE8Hm7iRHq6tuLL0N0aKLf1RMbgo4', 'test', 1, 3, '2017-08-02 02:08:03', NULL, '2017-06-20 12:37:16', '2017-08-02 02:08:03'),
(2, 'TEA2017060001', 'Hendri', 'Teacher', '085711202889', 'hendri-teacher-1501231363.jpg', 10, 10, 'Jl Lapangan Tembak 300 Ciaruteun Ilir Cibungbulang Bogor', 'hendrigunawan195@gmail.com', '$2y$10$iw/7PewIbwAEkRuUyRJ1O.Uru6ghgKZCMvNkVY9NiF436q8cYM2VW', NULL, 'test', 1, 2, '2017-07-29 13:08:44', NULL, '2017-06-24 07:12:21', '2017-07-29 13:08:44'),
(3, 'USR2017060001', 'Administrator', NULL, '08561471500', NULL, -6.920291, 106.9292812, 'Jl Batu Ceper X No 2Y Jakarta', 'administrator@gmail.com', '$2y$10$iw/7PewIbwAEkRuUyRJ1O.Uru6ghgKZCMvNkVY9NiF436q8cYM2VW', '730mvlFHRLViMhejVuoXVhprQWSXbsYoCSRePj0mWVhCVL5BSJs4bO7PLBW8', NULL, 1, 1, '2017-06-24 00:31:12', NULL, '2017-06-24 07:12:21', '2017-06-24 00:31:12'),
(6, 'STU2017060002', 'Wina', 'Marlina', '085711202889', NULL, NULL, NULL, 'PGRI Ciampea 2', 'winamarlina97@gmail.com', '$2y$10$Db1NEtx4r9wu.TgeowxuCe434LzeAwT8rium6Qz.ID/syr4wFXwMK', NULL, NULL, 0, 3, '2017-06-24 06:46:47', NULL, '2017-06-24 06:37:26', '2017-06-24 06:46:47'),
(12, 'TEA2017060002', 'Wina', 'Marlina', '085711202889', NULL, -6.55592, 106.9928, 'PGRI Ciampea 2', 'winamarlina977@gmail.com', '$2y$10$PeQ/lmOvrhLT4QIm5yrJW..jBt/d7zB0udhvzoIk9VO6muvs4xG7S', NULL, NULL, 0, 2, '2017-07-02 04:58:47', NULL, '2017-06-24 06:45:40', '2017-07-02 04:58:47'),
(16, 'TEA2017070001', 'Gunawan', 'Teacher', '085711202889', NULL, NULL, NULL, 'PGRI Ciampea 2 Bogor', 'gunawan.teacher@gmail.com', '$2y$10$gNaLYctRyPz.EWW1L4ZreuLU5jycsNXUQ128kg.Z.fhCwWfHXlBfu', NULL, NULL, 0, 2, '2017-07-18 13:25:10', NULL, '2017-07-18 13:25:10', '2017-07-18 13:25:10'),
(17, 'STU2017070001', 'Gunawan', 'Student', '085711202889', NULL, NULL, NULL, 'PGRI Ciampea 2 Jakarta', 'gunawan.student@gmail.com', '$2y$10$Tlc8qU9ylLn541j3r8vImu3V/DkV1I8T8Y3xEHPzy4nvuEdjIBCJC', NULL, NULL, 0, 3, '2017-07-18 13:27:14', NULL, '2017-07-18 13:27:14', '2017-07-18 13:38:51'),
(18, 'STU2017070002', 'Gunawan', 'Student', '085711202889', 'gunawan-student-1500387056.png', -6.55592, 106.9928, 'PGRI Ciampea 2 Jakarta', 'gunawan.students@gmail.com', '$2y$10$DXHg/pC4YSC24htDJP.H2uBee0zhOtDCrwXMtvSht.wuJRNc/oCBO', NULL, NULL, 1, 3, '2017-07-18 13:45:39', NULL, '2017-07-18 13:45:39', '2017-07-18 14:10:56'),
(19, 'TEA2017070002', 'Gunawan', 'Teacher', '085711202889', 'gunawan-teacher-1500386527.png', -6.55592, 106.9928, 'PGRI Ciampea 2 Bogor', 'gunawan.teachers@gmail.com', '$2y$10$8IzlTx9JlLve3ptfBg8Whe.2E2W/IsoWlzVLvDR499y29N3m3n81K', NULL, NULL, 0, 2, '2017-07-18 13:46:01', NULL, '2017-07-18 13:46:00', '2017-07-18 14:02:07'),
(20, 'STU2017070003', 'Hendri', NULL, '08561471500', NULL, NULL, NULL, 'jl batu ceper x no 2y jakarta', 'hemdri.gnw@gmail.com', '$2y$10$aQmjlut5YrxNlAo4zBmVgulaoLKPCUF.5qX12FEjxOjSdAuPV68Py', NULL, NULL, 0, 3, NULL, NULL, '2017-07-21 17:45:25', '2017-07-21 17:45:25'),
(21, 'STU2017070004', 'Gunawan', 'H', '08561771500', NULL, NULL, NULL, 'ysiabashs shsks', 'hendri.gnw1@gmail.com', '$2y$10$jJWjNz22dEB/5qRcAHzw4.JF3y.FuAGqfQ9NLChQ40tZSSNmS8HSi', NULL, NULL, 0, 3, NULL, NULL, '2017-07-21 17:51:22', '2017-07-21 17:51:22'),
(22, 'STU2017070005', 'Hendri', NULL, '085617751840', NULL, NULL, NULL, 'ysisns shl', 'hendri.gnw2@gmail.com', '$2y$10$dq9WkNY2IEJGPA1NV/00.u0eyiTOFUC6wPsQEhlqJ2xm4IveM9Woa', NULL, NULL, 0, 3, NULL, NULL, '2017-07-21 17:53:37', '2017-07-21 17:53:37'),
(23, 'STU2017070006', 'Hendri', NULL, '08561771500', NULL, NULL, NULL, 'ueisbs shsk', 'hemdri.gnw5@gmail.com', '$2y$10$4LUtvbnOkJ1AU0i68EdYmuNDNuGyofQeOn64efz1P5ygK/AvxDwAS', NULL, NULL, 0, 3, '2017-07-21 17:56:11', NULL, '2017-07-21 17:56:09', '2017-07-21 18:12:50'),
(24, 'TEA2017070003', 'Hendri', NULL, '08561771500', NULL, NULL, NULL, 'testing', 'hendri.gnw123@gmail.com', '$2y$10$Nl/ylsqJ.zTzZuPxxT7UKuIlt3fSRT.QwYJ.aXnZCXQggwCH3XfMS', NULL, NULL, 0, 2, '2017-07-21 18:43:32', NULL, '2017-07-21 18:32:52', '2017-07-21 18:50:06'),
(25, 'TEA2017070004', 'Hendri', 'Master', '0484516494', NULL, NULL, NULL, 'hendvdkdb', 'hendri.gnw927@gmail.com', '$2y$10$lhdyVeal3Pjv/qAZs1MMTO1svYS.saIkNI3XMwEY.TgLrhImXlIFi', NULL, NULL, 0, 2, '2017-07-21 18:50:56', NULL, '2017-07-21 18:50:54', '2017-07-24 14:18:17'),
(26, 'TEA2017070005', 'Sandi', 'Winata', '085693138131', NULL, NULL, NULL, 'Bogor', 'winatasandi05@gmail.com', '$2y$10$3pcOSP5FFKDDRUySPepStOnfX9dJhrAScla2NGE5Roj8imuvy4O16', NULL, NULL, 0, 2, '2017-07-24 20:45:43', NULL, '2017-07-24 20:45:39', '2017-07-24 20:53:38'),
(27, 'TEA2017070006', 'Gunawan', 'Hendri', '08561471500', NULL, NULL, NULL, 'Jl Batu Ceper', 'hendrigunawan@gmail.com', '$2y$10$xGpG8MQFrqqMwPnO8jMTguh0kzaI01vNTpK04m3PGc0mTocfaqxA.', NULL, NULL, 0, 2, '2017-07-28 20:35:46', NULL, '2017-07-28 20:35:35', '2017-07-28 20:35:46'),
(28, 'TEA2017070007', 'Gunawan', 'Hendri', '08561471500', NULL, NULL, NULL, 'Jl Batu Ceper', 'hendrigunawan123@gmail.com', '$2y$10$C203l6iIBvMa5F/8gEL3I.OnUvZ.SieIugNFChvJul8kIZ3XZm54q', NULL, NULL, 0, 2, '2017-07-28 20:37:37', NULL, '2017-07-28 20:35:58', '2017-07-28 20:42:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_level`
--
ALTER TABLE `course_level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `order_confirmation`
--
ALTER TABLE `order_confirmation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `private`
--
ALTER TABLE `private`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `private_detail`
--
ALTER TABLE `private_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_profile`
--
ALTER TABLE `student_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher_bank`
--
ALTER TABLE `teacher_bank`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher_course`
--
ALTER TABLE `teacher_course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher_profile`
--
ALTER TABLE `teacher_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher_total_history`
--
ALTER TABLE `teacher_total_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `unique_number` (`unique_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bank`
--
ALTER TABLE `bank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `course_level`
--
ALTER TABLE `course_level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `order_confirmation`
--
ALTER TABLE `order_confirmation`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `private`
--
ALTER TABLE `private`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `private_detail`
--
ALTER TABLE `private_detail`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `student_profile`
--
ALTER TABLE `student_profile`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `teacher_bank`
--
ALTER TABLE `teacher_bank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `teacher_course`
--
ALTER TABLE `teacher_course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `teacher_profile`
--
ALTER TABLE `teacher_profile`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `teacher_total_history`
--
ALTER TABLE `teacher_total_history`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
