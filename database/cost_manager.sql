-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Gostitelj: 127.0.0.1
-- Čas nastanka: 10. avg 2015 ob 21.33
-- Različica strežnika: 5.6.17
-- Različica PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Zbirka podatkov: `cost_manager`
--

-- --------------------------------------------------------

--
-- Struktura tabele `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Odloži podatke za tabelo `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2015_06_24_210225_traffic_type', 1),
('2015_06_24_210226_traffic', 1);

-- --------------------------------------------------------

--
-- Struktura tabele `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabele `traffic`
--

CREATE TABLE IF NOT EXISTS `traffic` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `traffic_type_id` int(10) unsigned NOT NULL,
  `amount` decimal(5,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `traffic_traffic_type_id_foreign` (`traffic_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=28 ;

--
-- Odloži podatke za tabelo `traffic`
--

INSERT INTO `traffic` (`id`, `traffic_type_id`, `amount`, `created_at`, `updated_at`) VALUES
(2, 2, '20.00', '2015-06-27 09:32:52', '2015-06-27 09:32:52'),
(3, 2, '20.00', '2015-06-27 09:32:58', '2015-06-27 09:32:58'),
(4, 3, '30.00', '2015-06-27 09:37:16', '2015-06-27 09:37:16'),
(5, 4, '15.00', '2015-06-27 09:37:22', '2015-06-27 09:37:22'),
(6, 2, '50.00', '2015-06-27 09:44:13', '2015-06-27 09:44:13'),
(18, 2, '10.00', '2015-06-27 12:14:04', '2015-06-27 12:14:04'),
(19, 3, '20.00', '2015-06-27 12:14:10', '2015-06-27 12:14:10'),
(20, 3, '50.00', '2015-06-27 12:41:18', '2015-06-27 12:41:18'),
(21, 2, '154.00', '2015-06-28 20:31:14', '2015-06-28 20:31:14'),
(22, 5, '15.00', '2015-07-03 19:31:03', '2015-07-03 19:31:03'),
(23, 5, '15.00', '2015-07-03 19:31:07', '2015-07-03 19:31:07'),
(24, 2, '5.00', '2015-07-03 19:31:10', '2015-07-03 19:31:10'),
(25, 4, '100.00', '2015-07-03 19:31:13', '2015-07-03 19:31:13'),
(26, 5, '10.00', '2015-08-08 07:37:30', '2015-08-08 07:37:30'),
(27, 2, '10.20', '2015-08-10 16:49:26', '2015-08-10 16:49:26');

-- --------------------------------------------------------

--
-- Struktura tabele `traffic_type`
--

CREATE TABLE IF NOT EXISTS `traffic_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `desc` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_cost` tinyint(1) NOT NULL,
  `times_used` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Odloži podatke za tabelo `traffic_type`
--

INSERT INTO `traffic_type` (`id`, `name`, `desc`, `is_cost`, `times_used`, `created_at`, `updated_at`) VALUES
(2, 'Payment', 'No desc', 0, 8, '2015-06-27 09:32:52', '2015-08-10 16:49:26'),
(3, 'Sticker foil', 'No desc', 1, 3, '2015-06-27 09:37:16', '2015-06-27 12:41:18'),
(4, 'Gasoline', 'No desc', 1, 3, '2015-06-27 09:37:22', '2015-07-03 19:31:13'),
(5, 'Test', 'No desc', 0, 3, '2015-07-03 19:31:03', '2015-08-08 07:37:30');

-- --------------------------------------------------------

--
-- Struktura tabele `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Omejitve tabel za povzetek stanja
--

--
-- Omejitve za tabelo `traffic`
--
ALTER TABLE `traffic`
  ADD CONSTRAINT `traffic_traffic_type_id_foreign` FOREIGN KEY (`traffic_type_id`) REFERENCES `traffic_type` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
