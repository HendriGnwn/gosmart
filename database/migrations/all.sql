-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `bank`;
CREATE TABLE `bank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `branch` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `behalf_of` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `bank` (`id`, `payment_id`, `name`, `image`, `description`, `branch`, `behalf_of`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1,	1,	'BCA',	'bca.jpg',	'Bank Central Asia',	'Sawah Besar, Jakarta Pusat',	'Hendri Gunawan',	NULL,	'2017-06-18 07:38:11',	'2017-06-18 07:38:11');

DROP TABLE IF EXISTS `course`;
CREATE TABLE `course` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `course_level_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `cost` decimal(14,2) NOT NULL,
  `face_to_face` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1' COMMENT '1=Active;0=Inactive',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `course` (`id`, `course_level_id`, `name`, `description`, `cost`, `face_to_face`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1,	1,	'Matematika I',	'Matematika Sekolah Dasar Kelas 1',	75000.00,	2,	1,	NULL,	'2017-06-20 12:01:47',	'2017-06-20 12:01:47'),
(2,	1,	'Bahasa Indonesia I',	'Bahasa Indonesia Sekolah Dasar Kelas 1',	75000.00,	2,	1,	NULL,	'2017-06-20 12:04:06',	'2017-06-20 12:04:06'),
(3,	2,	'Matematika II',	'Matematika Sekolah Dasar Kelas 2',	77000.00,	2,	1,	NULL,	'2017-06-20 12:04:06',	'2017-06-20 12:04:06'),
(4,	2,	'Bahasa Indonesia II',	'Bahasa Indonesia Sekolah Dasar Kelas 2',	77000.00,	2,	1,	NULL,	'2017-06-20 12:04:06',	'2017-06-20 12:04:06'),
(5,	3,	'Matematika III',	'Matematika Sekolah Dasar Kelas 3',	77000.00,	2,	1,	NULL,	'2017-06-20 12:04:06',	'2017-06-20 12:04:06'),
(6,	3,	'Bahasa Indonesia III',	'Bahasa Indonesia Sekolah Dasar Kelas 3',	77000.00,	2,	1,	NULL,	'2017-06-20 12:04:06',	'2017-06-20 12:04:06');

DROP TABLE IF EXISTS `course_level`;
CREATE TABLE `course_level` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL COMMENT '1=Active;0=Inactive;',
  `order` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `course_level` (`id`, `name`, `status`, `order`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1,	'Sekolah Dasar I',	1,	0,	NULL,	'2017-06-20 11:57:55',	'2017-06-20 11:57:55'),
(2,	'Sekolah Dasar II',	1,	1,	NULL,	'2017-06-20 12:00:06',	'2017-06-20 12:00:06'),
(3,	'Sekolah Dasar III',	1,	2,	NULL,	'2017-06-20 12:00:06',	'2017-06-20 12:00:06'),
(4,	'Sekolah Dasar IV',	1,	3,	NULL,	'2017-06-20 12:00:06',	'2017-06-20 12:00:06'),
(5,	'Sekolah Dasar V',	1,	4,	NULL,	'2017-06-20 12:00:06',	'2017-06-20 12:00:06'),
(6,	'Sekolah Dasar VI',	1,	5,	NULL,	'2017-06-20 12:00:06',	'2017-06-20 12:00:06'),
(7,	'Sekolah Menengah Pertama VII',	1,	6,	NULL,	'2017-06-20 12:00:06',	'2017-06-20 12:00:06'),
(8,	'Sekolah Menengah Pertama VIII',	1,	7,	NULL,	'2017-06-20 12:00:06',	'2017-06-20 12:00:06'),
(9,	'Sekolah Menengah Pertama IX',	1,	8,	NULL,	'2017-06-20 12:00:06',	'2017-06-20 12:00:06'),
(10,	'Sekolah Menengah Atas X',	1,	9,	NULL,	'2017-06-20 12:00:06',	'2017-06-20 12:00:06'),
(11,	'Sekolah Menengah Atas XI',	1,	10,	NULL,	'2017-06-20 12:00:06',	'2017-06-20 12:00:06'),
(12,	'Sekolah Menengah Atas XII',	1,	11,	NULL,	'2017-06-20 12:00:06',	'2017-06-20 12:00:06');

DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL COMMENT 'as student',
  `teacher_id` bigint(20) NOT NULL COMMENT 'as teacher',
  `code` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `face_to_face` int(11) NOT NULL,
  `admin_fee` decimal(14,2) NOT NULL,
  `final_amount` decimal(14,2) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `status` smallint(6) NOT NULL COMMENT '0=Canceled;1=Waiting Payment;5=Confirmed;10=Paid;',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `order_confirmation`;
CREATE TABLE `order_confirmation` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) NOT NULL,
  `bank_id` int(11) NOT NULL,
  `bank_behalf_of` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(14,2) NOT NULL,
  `upload_bukti` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `order_detail`;
CREATE TABLE `order_detail` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) NOT NULL,
  `course_id` bigint(20) NOT NULL,
  `section` int(11) NOT NULL,
  `section_time` time NOT NULL,
  `amount` decimal(14,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `payment`;
CREATE TABLE `payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(1) NOT NULL DEFAULT '1' COMMENT '1=Active;0=Inactive',
  `order` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `payment` (`id`, `name`, `status`, `order`, `created_at`) VALUES
(1,	'Transfer Bank',	1,	0,	'2017-06-18 01:00:00');

DROP TABLE IF EXISTS `private`;
CREATE TABLE `private` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `teacher_id` bigint(20) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `face_to_face` int(11) NOT NULL,
  `code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '5' COMMENT '5=On Going;10=Done;',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `private_detail`;
CREATE TABLE `private_detail` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `private_id` bigint(20) NOT NULL,
  `on_at` timestamp NULL DEFAULT NULL,
  `section` int(11) DEFAULT NULL,
  `section_time` time DEFAULT NULL,
  `student_check` smallint(1) DEFAULT '0' COMMENT '1=True;0=False;',
  `student_check_at` timestamp NULL DEFAULT NULL,
  `teacher_check` smallint(1) DEFAULT '0' COMMENT '1=True;0=False;',
  `teacher_check_at` timestamp NULL DEFAULT NULL,
  `checklist` smallint(1) DEFAULT '0' COMMENT '1=True;0=False;',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `student_profile`;
CREATE TABLE `student_profile` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `school` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `degree` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `department` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `school_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `formal_photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Master User Student';

INSERT INTO `student_profile` (`id`, `user_id`, `school`, `degree`, `department`, `school_address`, `photo`, `formal_photo`, `updated_at`) VALUES
(1,	1,	'SMP Negeri Ciampea - Bogor',	'7',	NULL,	'Jl Letnan Sukarna Ciampea Bogor',	NULL,	NULL,	'2017-06-20 12:38:10');

DROP TABLE IF EXISTS `teacher_course`;
CREATE TABLE `teacher_course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `course_id` bigint(20) NOT NULL,
  `expected_cost` decimal(14,2) NOT NULL,
  `expected_cost_updated_at` timestamp NULL DEFAULT NULL,
  `approved_expected_cost_by` bigint(20) DEFAULT NULL,
  `approved_expected_cost_at` timestamp NULL DEFAULT NULL,
  `module` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='teacher bisa ngajar mapel apa aja';


DROP TABLE IF EXISTS `teacher_profile`;
CREATE TABLE `teacher_profile` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `title` smallint(6) NOT NULL COMMENT '1=S1;2=S2;3=S3',
  `izajah_number` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `graduated` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'College',
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `upload_izajah` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `formal_photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total` decimal(14,2) DEFAULT NULL,
  `total_updated_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `izajah_number` (`izajah_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Master User Teacher';


DROP TABLE IF EXISTS `teacher_total_history`;
CREATE TABLE `teacher_total_history` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `private_id` bigint(20) NOT NULL,
  `operation` smallint(1) NOT NULL COMMENT '1=+;0=-',
  `total` decimal(14,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Teacher History Total (Honor)';


DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `unique_number` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_number` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(600) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(2) NOT NULL DEFAULT '0' COMMENT '1=Active;5=Blocked;0=Inactive(Tapi masih bisa login)',
  `role` smallint(6) NOT NULL COMMENT '1=User/Administrator; 2=Teacher;3=Student',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `unique_number` (`unique_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Master User';

INSERT INTO `user` (`id`, `unique_number`, `first_name`, `last_name`, `phone_number`, `latitude`, `longitude`, `address`, `email`, `password`, `remember_token`, `status`, `role`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1,	'STU2017060001',	'Hendri',	'Student',	'08561471500',	-6.55592,	106.9928,	'Jl Batu Ceper X No 2Y, Kebon Kelapa Gambir Jakarta Pusat',	'hendri.gnw@gmail.com',	'admin123',	NULL,	1,	3,	NULL,	'2017-06-20 12:37:16',	'2017-06-20 12:37:16');

-- 2017-06-23 19:08:04
