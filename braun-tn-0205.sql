-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 02 mai 2025 à 16:25
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `braun`
--

-- --------------------------------------------------------

--
-- Structure de la table `attributs`
--

CREATE TABLE `attributs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `attributs`
--

INSERT INTO `attributs` (`id`, `nom`, `parent_id`, `value`, `created_at`, `updated_at`) VALUES
(1, 'color', NULL, '\"sdqfseq,rrezr,rezrez,rezrez,rezr,erezr,ezezeze68989\"', '2025-01-30 10:26:37', '2025-01-30 14:04:05'),
(2, 'rez', 1, 're', '2025-01-30 10:32:09', '2025-01-30 10:32:09'),
(3, 'Color 1', 2, '#2f9364', '2025-01-30 10:33:44', '2025-01-30 10:33:44'),
(4, 'rtre', NULL, 'ttret', '2025-01-30 11:39:02', '2025-01-30 11:39:02'),
(5, 'ty', 2, 'tyt', '2025-01-30 11:45:00', '2025-01-30 11:45:00'),
(6, 'erzr', 1, '\"84,t\"', '2025-01-30 11:45:56', '2025-01-30 13:05:10'),
(7, 'rez', NULL, NULL, '2025-01-30 12:11:15', '2025-01-30 12:11:15'),
(8, 'erzr', NULL, '\"87987,tretret,tretret,rtretre,rezr,rer\"', '2025-01-30 12:21:34', '2025-01-30 13:05:22');

-- --------------------------------------------------------

--
-- Structure de la table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `parent_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `image`, `parent_id`, `created_at`, `updated_at`) VALUES
(50, 'Silk·épil 3', 'silk-pil-3', NULL, NULL, '2025-04-25 07:23:50', '2025-04-25 07:23:50'),
(51, 'Face Spa', 'face-spa', NULL, NULL, '2025-04-25 07:24:16', '2025-04-25 07:24:16'),
(52, 'Silk·épil 5', 'silk-pil-5', NULL, NULL, '2025-04-25 07:24:29', '2025-04-25 07:24:29'),
(53, 'Silk·épil 9', 'silk-pil-9', NULL, NULL, '2025-04-25 07:24:40', '2025-04-25 07:24:40'),
(54, 'Silk·épil 9 Flex', 'silk-pil-9-flex', NULL, NULL, '2025-04-25 07:24:48', '2025-04-25 07:24:48'),
(59, 'ter', 'ter', NULL, '54', '2025-05-02 13:13:02', '2025-05-02 13:13:02');

-- --------------------------------------------------------

--
-- Structure de la table `checkout_data`
--

CREATE TABLE `checkout_data` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `birth_date` date NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `products` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`products`)),
  `payment_method` enum('card','cash_on_delivery') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `type` enum('fixed','percent') NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `cart_value` decimal(10,2) NOT NULL,
  `ceiling` decimal(10,2) DEFAULT NULL,
  `min_spend` decimal(10,2) NOT NULL,
  `usage_limit_per_order` int(11) DEFAULT NULL,
  `start_date` date NOT NULL DEFAULT curdate(),
  `end_date` date NOT NULL DEFAULT curdate(),
  `status` enum('active','inactive') DEFAULT 'active',
  `usage_limit_per_user` int(11) DEFAULT NULL,
  `expiry_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `type`, `value`, `cart_value`, `ceiling`, `min_spend`, `usage_limit_per_order`, `start_date`, `end_date`, `status`, `usage_limit_per_user`, `expiry_date`, `created_at`, `updated_at`) VALUES
(1, 'ezaer', 'fixed', 21858.00, 787.00, NULL, 0.00, NULL, '2025-02-03', '2025-02-03', 'active', NULL, '2024-12-20', '2024-12-29 22:43:45', '2024-12-29 22:43:45'),
(3, 'test', 'fixed', 20.00, 1000.00, NULL, 0.00, NULL, '2025-02-03', '2025-02-03', 'active', NULL, '2025-01-30', '2025-01-18 09:03:08', '2025-01-18 09:03:08');

-- --------------------------------------------------------

--
-- Structure de la table `demande_revendeur`
--

CREATE TABLE `demande_revendeur` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `sujet` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `demande_revendeur`
--

INSERT INTO `demande_revendeur` (`id`, `name`, `sujet`, `email`, `phone`, `message`, `created_at`, `updated_at`) VALUES
(1, 'Iskander', 'rzer', 'ahmed.adel@gei.tn', '8987978', 'tretret', '2025-01-14 09:17:50', '2025-01-14 09:17:50'),
(2, 'Iskander', 'test', 'ahmed.adel@gei.tn', '74125896', 'test', '2025-01-17 15:17:29', '2025-01-17 15:17:29'),
(3, 'Iskander', 'agence', 'ines.ayari@tunishop.com', '74125896', 'ezaezae', '2025-02-03 09:38:41', '2025-02-03 09:38:41'),
(4, 'Iskander Ounifi', 'question', 'ahmed.adel@gei.tn', '7412586', 'gf', '2025-04-28 14:23:20', '2025-04-28 14:23:20'),
(5, 'Iskander Ounifi', 'support', 'ahmed.adel@gei.tn', '8523694', 'xwxw<', '2025-04-28 14:24:08', '2025-04-28 14:24:08'),
(6, 'ezae', 'question', 'mezriguikhaoula@nabeul.r-iset.tn', '412398', 'The <article> HTML element represents a self-contained composition in a document, page, application, or site, which is intended to be independently distributable or reusable (e.g., in syndication). Examples include: a forum post, a magazine or newspaper article, or a blog entry, a product card, a user-submitted comment, an interactive widget or gadget, or any other independent item of content.\r\nThe <article> HTML element represents a self-contained composition in a document, page, application, or site, which is intended to be independently distributable or reusable (e.g., in syndication). Examples include: a forum post, a magazine or newspaper article, or a blog entry, a product card, a user-submitted comment, an interactive widget or gadget, or any other independent item of content.\r\nThe <article> HTML element represents a self-contained composition in a document, page, application, or site, which is intended to be independently distributable or reusable (e.g., in syndication). Examples include: a forum post, a magazine or newspaper article, or a blog entry, a product card, a user-submitted comment, an interactive widget or gadget, or any other independent item of content.\r\nThe <article> HTML element represents a self-contained composition in a document, page, application, or site, which is intended to be independently distributable or reusable (e.g., in syndication). Examples include: a forum post, a magazine or newspaper article, or a blog entry, a product card, a user-submitted comment, an interactive widget or gadget, or any other independent item of content.\r\nThe <article> HTML element represents a self-contained composition in a document, page, application, or site, which is intended to be independently distributable or reusable (e.g., in syndication). Examples include: a forum post, a magazine or newspaper article, or a blog entry, a product card, a user-submitted comment, an interactive widget or gadget, or any other independent item of content.\r\nThe <article> HTML element represents a self-contained composition in a document, page, application, or site, which is intended to be independently distributable or reusable (e.g., in syndication). Examples include: a forum post, a magazine or newspaper article, or a blog entry, a product card, a user-submitted comment, an interactive widget or gadget, or any other independent item of content.\r\nThe <article> HTML element represents a self-contained composition in a document, page, application, or site, which is intended to be independently distributable or reusable (e.g., in syndication). Examples include: a forum post, a magazine or newspaper article, or a blog entry, a product card, a user-submitted comment, an interactive widget or gadget, or any other independent item of content.\r\nThe <article> HTML element represents a self-contained composition in a document, page, application, or site, which is intended to be independently distributable or reusable (e.g., in syndication). Examples include: a forum post, a magazine or newspaper article, or a blog entry, a product card, a user-submitted comment, an interactive widget or gadget, or any other independent item of content.', '2025-04-28 14:57:50', '2025-04-28 14:57:50'),
(7, 'Iskander Ounifi', 'question', 'selim.idriss@gei.tn', '123456789', 'ererez', '2025-05-02 13:09:26', '2025-05-02 13:09:26');

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(29, '0001_01_01_000000_create_users_table', 1),
(30, '0001_01_01_000001_create_cache_table', 1),
(31, '0001_01_01_000002_create_jobs_table', 1),
(32, '2024_12_29_143957_create_brands_table', 1),
(33, '2024_12_29_144200_create_category_table', 1),
(34, '2024_12_29_193545_create_product_table', 1),
(35, '2024_12_29_233720_create_coupon_table', 1),
(36, '2025_01_13_075759_create_demande_revendeur_table', 1),
(37, '2025_01_13_090353_create_slides_table', 1),
(38, '2025_01_13_123122_create_orders_table', 1),
(39, '2025_01_14_091851_create_checkout_data_table', 2),
(40, '2025_01_16_080919_create_visitor_logs_table ', 1),
(41, '2025_01_16_080919_create_visitor_logs_table', 3),
(42, '2025_01_30_103559_create_attributs_table', 4);

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `red_order` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telephone` varchar(255) NOT NULL,
  `gouvernorat` varchar(255) NOT NULL,
  `adress` text NOT NULL,
  `sex` enum('male','female','other') DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `date_order` datetime NOT NULL,
  `status` enum('encours','traité','annulé') DEFAULT 'encours',
  `id_produit` bigint(20) UNSIGNED NOT NULL,
  `prix_produit` decimal(10,2) NOT NULL,
  `quantite_produit` int(11) NOT NULL,
  `mode_paiement` enum('espace','carte') NOT NULL,
  `date_shipping` datetime DEFAULT NULL,
  `code_compagnie` varchar(255) DEFAULT NULL,
  `source_commande` varchar(255) DEFAULT NULL,
  `ip_client` varchar(45) DEFAULT NULL,
  `device_client` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`id`, `red_order`, `nom`, `prenom`, `email`, `telephone`, `gouvernorat`, `adress`, `sex`, `date_naissance`, `date_order`, `status`, `id_produit`, `prix_produit`, `quantite_produit`, `mode_paiement`, `date_shipping`, `code_compagnie`, `source_commande`, `ip_client`, `device_client`, `created_at`, `updated_at`) VALUES
(164, 'ORD-681231072E219', 'Ounifi', 'Iskander', 'mezriguikhadfsdfoula@nabeul.r-iset.tn', '12365478', 'Sousse', '2083\r\nariana', 'male', '1990-04-23', '2025-04-30 14:17:43', 'encours', 10, 160.00, 1, 'espace', NULL, NULL, 'web', '127.0.0.1', 'Desktop', '2025-04-30 13:17:43', '2025-04-30 13:17:43'),
(178, 'ORD-681482350BAFC', 'Ounifi', 'Iskander', 'selim.idriss@gei.tn', '12365478', 'Kairouan', '2083\r\nariana', 'male', '2025-04-29', '2025-05-02 08:28:37', 'encours', 11, 250.00, 1, 'espace', NULL, NULL, 'web', '127.0.0.1', 'Desktop', '2025-05-02 07:28:37', '2025-05-02 07:28:37'),
(179, 'ORD-68148C0EE7585', 'Ounifi', 'Iskander', 'selim.idriss@gei.tn', '12365478', 'Médenine', '2083\r\nariana', 'male', '2025-04-30', '2025-05-02 09:10:38', 'encours', 11, 250.00, 10, 'espace', NULL, NULL, 'web', '127.0.0.1', 'Desktop', '2025-05-02 08:10:38', '2025-05-02 08:10:38'),
(180, 'ORD-68148C0EE7585', 'Ounifi', 'Iskander', 'selim.idriss@gei.tn', '12365478', 'Médenine', '2083\r\nariana', 'male', '2025-04-30', '2025-05-02 09:10:38', 'encours', 10, 160.00, 10, 'espace', NULL, NULL, 'web', '127.0.0.1', 'Desktop', '2025-05-02 08:10:38', '2025-05-02 08:10:38'),
(181, 'ORD-681499426896B', 'Ounifi', 'Iskander', 'selim.idriss@gei.tn', '12365478', 'Kébili', '2083\r\nariana', 'male', '2025-04-30', '2025-05-02 10:06:58', 'encours', 11, 250.00, 1, 'espace', NULL, NULL, 'web', '127.0.0.1', 'Desktop', '2025-05-02 09:06:58', '2025-05-02 09:06:58'),
(182, 'ORD-6814997A62A2F', 'Ounifi', 'Iskander', 'mezriguikhaoula@nabeul.r-iset.tn', '12365478', 'Médenine', '2083\r\nariana', 'male', '2025-04-30', '2025-05-02 10:07:54', 'encours', 10, 160.00, 1, 'espace', NULL, NULL, 'web', '127.0.0.1', 'Desktop', '2025-05-02 09:07:54', '2025-05-02 09:07:54'),
(199, 'ORD-6814C41DDE42D', 'test', 'test', 'aziz.menzli@gei.tn', '12365478', 'Monastir', '54 rue du mercure', 'male', '2025-04-27', '2025-05-02 13:09:50', 'encours', 10, 160.00, 6, 'espace', NULL, NULL, 'web', '192.168.1.26', 'Desktop', '2025-05-02 12:09:50', '2025-05-02 12:09:50'),
(200, 'ORD-6814D17C50689', 'Ounifi', 'Iskander', 'selim.idriss@gei.tn', '12365478', 'Médenine', '2083\r\nariana', 'male', '2025-04-30', '2025-05-02 14:06:52', 'encours', 11, 250.00, 6, 'espace', NULL, NULL, 'web', '192.168.1.58', 'Desktop', '2025-05-02 13:06:52', '2025-05-02 13:06:52');

-- --------------------------------------------------------

--
-- Structure de la table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('ahmed.adel5@gei.tn', '$2y$12$DlIxHIAMLQtw0TUiW4IkBOgPOp6NtHSx6Vl1h2/k9XeWxkP/kOr9i', '2025-01-18 08:31:39');

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `regular_price` decimal(10,2) NOT NULL,
  `sale_price` decimal(10,2) DEFAULT NULL,
  `SKU` varchar(100) DEFAULT NULL,
  `stock_status` enum('instock','outofstock') DEFAULT 'instock',
  `quantity` int(11) DEFAULT 0,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sous_categorie_id` bigint(20) UNSIGNED DEFAULT NULL,
  `specifications` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`specifications`)),
  `additional_links` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`additional_links`)),
  `status` enum('published','draft') DEFAULT 'published',
  `type` varchar(50) DEFAULT NULL,
  `order` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `description`, `regular_price`, `sale_price`, `SKU`, `stock_status`, `quantity`, `category_id`, `sous_categorie_id`, `specifications`, `additional_links`, `status`, `type`, `order`, `created_at`, `updated_at`) VALUES
(10, 'SE3170', 'se3170', 'Comprend 2 extras (tête de rasoir et capuchon de tondeuse)', 209.00, 160.00, 'SKU-A62KMBGH', 'instock', 991, 50, 11, '\"[{\\\"name\\\":\\\"20 Pincettes d\\\\u2019\\\\u00e9pilation\\\",\\\"icon\\\":\\\"specification-icons\\\\\\/juLjgJC71d0YUKh38y5KL7pGJxPSQGFxzY4SBnbR.png\\\"},{\\\"name\\\":\\\"Lumi\\\\u00e8re int\\\\u00e9gr\\\\u00e9e\\\",\\\"icon\\\":\\\"specification-icons\\\\\\/whOSFCby90fYugpt6KLCLAmmGRkS2k7CzWgAnmz0.png\\\"},{\\\"name\\\":\\\"Utilisation sur prise\\\",\\\"icon\\\":\\\"specification-icons\\\\\\/gaWHUl82xb40vkJ2znjwOSqK3xVSWfUNT5cqUybd.png\\\"}]\"', '\"[{\\\"url\\\":\\\"https:\\\\\\/\\\\\\/res.cloudinary.com\\\\\\/ddi29nbzl\\\\\\/image\\\\\\/upload\\\\\\/v1745570473\\\\\\/SE3-170-2_rfcafu.png\\\"},{\\\"url\\\":\\\"https:\\\\\\/\\\\\\/res.cloudinary.com\\\\\\/ddi29nbzl\\\\\\/image\\\\\\/upload\\\\\\/v1745570475\\\\\\/SE3-170-1_hc3raf.png\\\"},{\\\"url\\\":\\\"https:\\\\\\/\\\\\\/res.cloudinary.com\\\\\\/ddi29nbzl\\\\\\/image\\\\\\/upload\\\\\\/v1745570475\\\\\\/SE3-170-3_cyvujg.png\\\"}]\"', 'published', 'simple', 1, '2025-04-25 09:59:07', '2025-05-02 12:09:50'),
(11, 'SE3410', 'se3410', 'Épilateur Électrique Femme Rose Framboise, avec Fil Et 3 Accessoires incluant un rasoir et une tondeuse, les zones sensibles, des rouleaux de massage', 303.00, 250.00, 'SKU-EXIKJEX9', 'instock', 992, 50, 11, '\"[{\\\"name\\\":\\\"20 Pincettes d\\\\u2019\\\\u00e9pilation\\\",\\\"icon\\\":\\\"specification-icons\\\\\\/jNCXOAtoqSbJaffU4QUIagyMjJN4sZZRV6j38fsv.png\\\"},{\\\"name\\\":\\\" Lumi\\\\u00e8re int\\\\u00e9gr\\\\u00e9e\\\",\\\"icon\\\":\\\"specification-icons\\\\\\/5knvoPmyVi3u8lw9YNy6PQh45JEomi43jHYlJm22.png\\\"},{\\\"name\\\":\\\"Utilisation sur prise\\\",\\\"icon\\\":\\\"specification-icons\\\\\\/YSuVjyUtRO2fM5R3SidsyJ3qbuFqrZJ3VyNpenwq.png\\\"},{\\\"name\\\":\\\"T\\\\u00eate de rasoir\\\",\\\"icon\\\":\\\"specification-icons\\\\\\/KNFpmCWyqwSnwoA95LnvgbZ8WnrspB3HD1LgGB5L.png\\\"},{\\\"name\\\":\\\"Accessoire tondeuse\\\",\\\"icon\\\":\\\"specification-icons\\\\\\/F5S81pS2ZGZDvx9KubIYMkX8Z7Fosc6HSc4uS3ga.png\\\"}]\"', '\"[{\\\"url\\\":\\\"https:\\\\\\/\\\\\\/res.cloudinary.com\\\\\\/ddi29nbzl\\\\\\/image\\\\\\/upload\\\\\\/v1745652493\\\\\\/SE3-410-3-2048x2048_mryd4v.png\\\"},{\\\"url\\\":\\\"https:\\\\\\/\\\\\\/res.cloudinary.com\\\\\\/ddi29nbzl\\\\\\/image\\\\\\/upload\\\\\\/v1745652494\\\\\\/SE3-410-extra-1-2048x2048_z5rak6.png\\\"},{\\\"url\\\":\\\"https:\\\\\\/\\\\\\/res.cloudinary.com\\\\\\/ddi29nbzl\\\\\\/image\\\\\\/upload\\\\\\/v1745652495\\\\\\/SE3-410-extra-2-2048x2048_babyi2.png\\\"}]\"', 'published', 'simple', 2, '2025-04-26 06:33:18', '2025-05-02 13:06:52'),
(12, 'SES5500', 'ses5500', 'l\'épilateur Braun se 5-500 sensosmart, vous obtenez une peau parfaitement épilée, mais pas seulement. En effet, il peut également vous masser pour votre plus grand plaisir. Référence fabricant 5-500', 1396.00, 1100.00, 'SKU-BVSSXVZE', 'instock', 44, 52, 11, '\"[{\\\"name\\\":\\\"28 Pincettes d\\\\u2019\\\\u00e9pilation\\\",\\\"icon\\\":\\\"specification-icons\\\\\\/IDdTQ9un8GbFw3wMI2YFjI3zx1vuSaiUf4Y8YSGz.png\\\"},{\\\"name\\\":\\\"Lumi\\\\u00e8re int\\\\u00e9gr\\\\u00e9e\\\",\\\"icon\\\":\\\"specification-icons\\\\\\/0DKhqnYsyQqY4lBBjjeENfmQ8HFsiTwHxA8Fqs0w.png\\\"},{\\\"name\\\":\\\"Capteur de pression\\\",\\\"icon\\\":\\\"specification-icons\\\\\\/Hp1iwKJrbohBlZbhyl4Fen1RL2QAc6EDazE5SOks.png\\\"},{\\\"name\\\":\\\"Fonctionne sous l\\\\u2019eau\\\",\\\"icon\\\":\\\"specification-icons\\\\\\/9wdI9u5P18jGdi9IR5URYpNRSDnGVNHSBlkut5OG.png\\\"},{\\\"name\\\":\\\"30 min d\\\\u2019autonomie\\\",\\\"icon\\\":\\\"specification-icons\\\\\\/wFooWh7ZY7yXbvkqKareOaPkRSk0i3cFZjOjAyr4.png\\\"}]\"', '\"[{\\\"url\\\":\\\"https:\\\\\\/\\\\\\/res.cloudinary.com\\\\\\/ddi29nbzl\\\\\\/image\\\\\\/upload\\\\\\/v1745653094\\\\\\/41VSyNUQULL._AC_SL1000__ypnqsk.jpg\\\"},{\\\"url\\\":\\\"https:\\\\\\/\\\\\\/res.cloudinary.com\\\\\\/ddi29nbzl\\\\\\/image\\\\\\/upload\\\\\\/v1745653095\\\\\\/SES5-500_rixpdz.png\\\"},{\\\"url\\\":\\\"https:\\\\\\/\\\\\\/res.cloudinary.com\\\\\\/ddi29nbzl\\\\\\/image\\\\\\/upload\\\\\\/v1745653097\\\\\\/SE5-500-extra-2-2048x2048_l9svor.png\\\"},{\\\"url\\\":\\\"https:\\\\\\/\\\\\\/res.cloudinary.com\\\\\\/ddi29nbzl\\\\\\/image\\\\\\/upload\\\\\\/v1745653098\\\\\\/SE5-500-extra-1-1-2048x2048_lizgm1.png\\\"},{\\\"url\\\":\\\"\\\"}]\"', 'published', 'simple', 3, '2025-04-26 06:42:09', '2025-04-26 11:16:19'),
(13, 'ezez', 'ezez', 'ezae', 15.00, 284.00, NULL, 'instock', 1000, 51, 11, '\"[{\\\"name\\\":\\\"ezae\\\",\\\"icon\\\":\\\"specification-icons\\\\\\/FdLeON8nB9Yp789J2pU3zxOHAuHTLoSS1WJmsJC3.png\\\"}]\"', '\"[{\\\"url\\\":\\\"https:\\\\\\/\\\\\\/res.cloudinary.com\\\\\\/ddi29nbzl\\\\\\/image\\\\\\/upload\\\\\\/v1745420211\\\\\\/braun.tn\\\\\\/logo\\\\\\/vfqv40by0uco5dvofusj.png\\\"},{\\\"url\\\":\\\"https:\\\\\\/\\\\\\/res.cloudinary.com\\\\\\/ddi29nbzl\\\\\\/image\\\\\\/upload\\\\\\/v1745420211\\\\\\/braun.tn\\\\\\/logo\\\\\\/vfqv40by0uco5dvofusj.png\\\"}]\"', 'published', 'simple', 4, '2025-04-29 13:45:24', '2025-04-30 09:51:51'),
(15, 'CXWCXWCXWC', 'cxwcxwcxwc', 'CXWCXWCXW', 5.00, 4.00, NULL, 'instock', 1000, 51, 11, '\"[{\\\"name\\\":\\\"XCXWC\\\",\\\"icon\\\":\\\"specification-icons\\\\\\/Y2rMPHW2qVYxfleoF9GOqtOja0M4cL2JZ8hk6UX2.png\\\"}]\"', '\"[{\\\"url\\\":\\\"https:\\\\\\/\\\\\\/res.cloudinary.com\\\\\\/ddi29nbzl\\\\\\/image\\\\\\/upload\\\\\\/v1745420211\\\\\\/braun.tn\\\\\\/logo\\\\\\/vfqv40by0uco5dvofusj.png\\\"},{\\\"url\\\":\\\"https:\\\\\\/\\\\\\/res.cloudinary.com\\\\\\/ddi29nbzl\\\\\\/image\\\\\\/upload\\\\\\/v1745420211\\\\\\/braun.tn\\\\\\/logo\\\\\\/vfqv40by0uco5dvofusj.png\\\"}]\"', 'published', 'variable', 5, '2025-04-30 09:17:06', '2025-04-30 12:27:18');

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `ID` int(11) NOT NULL,
  `Type` varchar(255) DEFAULT NULL,
  `UGS` varchar(255) DEFAULT NULL,
  `GTIN_UPC_EAN_ISBN` varchar(255) DEFAULT NULL,
  `Nom` varchar(255) DEFAULT NULL,
  `Publie` tinyint(1) DEFAULT NULL,
  `Mis_en_avant` tinyint(1) DEFAULT NULL,
  `Visibilite_catalogue` varchar(255) DEFAULT NULL,
  `Description_courte` text DEFAULT NULL,
  `Description` longtext DEFAULT NULL,
  `Date_debut_promo` date DEFAULT NULL,
  `Date_fin_promo` date DEFAULT NULL,
  `Etat_TVA` varchar(255) DEFAULT NULL,
  `Classe_TVA` varchar(255) DEFAULT NULL,
  `En_stock` tinyint(1) DEFAULT NULL,
  `Stock` int(11) DEFAULT NULL,
  `Montant_stock_faible` int(11) DEFAULT NULL,
  `Autoriser_cmds_rupture` tinyint(1) DEFAULT NULL,
  `Vendre_individuellement` tinyint(1) DEFAULT NULL,
  `Poids_kg` decimal(10,2) DEFAULT NULL,
  `Longueur_cm` decimal(10,2) DEFAULT NULL,
  `Largeur_cm` decimal(10,2) DEFAULT NULL,
  `Hauteur_cm` decimal(10,2) DEFAULT NULL,
  `Autoriser_avis_clients` tinyint(1) DEFAULT NULL,
  `Note_commande` text DEFAULT NULL,
  `Tarif_promo` decimal(10,2) DEFAULT NULL,
  `Tarif_regulier` decimal(10,2) DEFAULT NULL,
  `Categories` varchar(255) DEFAULT NULL,
  `Etiquettes` varchar(255) DEFAULT NULL,
  `Classe_expedition` varchar(255) DEFAULT NULL,
  `Images` text DEFAULT NULL,
  `Limite_telechargement` int(11) DEFAULT NULL,
  `Jours_expiration_telechargement` int(11) DEFAULT NULL,
  `Parent` int(11) DEFAULT NULL,
  `Groupes_produits` varchar(255) DEFAULT NULL,
  `Produits_suggeres` varchar(255) DEFAULT NULL,
  `Ventes_croisees` varchar(255) DEFAULT NULL,
  `URL_externe` text DEFAULT NULL,
  `Libelle_bouton` varchar(255) DEFAULT NULL,
  `Position` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('57oZHKFtWwAFJKsRpjHsAKJck0b4Aj7TI3jKxo6X', 7, '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWEFzYnZYM0dSZzU3SERPV2VoWXM0dDBhV0FjUG5QSTVGdFR6YjY2aCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xOTIuMTY4LjEuNTg6ODAwMC9kYXNoYm9hcmQvaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjc7fQ==', 1746193466),
('9XPMp0X38OH0Vk7ODTxKpqU7WhAiSHKAzniWcIOE', 7, '192.168.1.58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiNk9uRlZMZnZkQXF4dm5ydFZLUGRZWkFUbFZ0UGc1SVhJWlJCa2NLcSI7czoyMjoiUEhQREVCVUdCQVJfU1RBQ0tfREFUQSI7YTowOnt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly8xOTIuMTY4LjEuNTg6ODAwMC9kYXNoYm9hcmQvY2F0ZWdvcmllcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjc7fQ==', 1746195188),
('Hhwb3qg9anKyeYMsSoj9TAQRefMpsrumGV0P2mAE', 7, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoic1ZQdVRnZ2pDNzZ1WGpobXoyR1lyZmxmR2ZFS2tUNDBLMWFEMFpONiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo3O3M6MjI6IlBIUERFQlVHQkFSX1NUQUNLX0RBVEEiO2E6MDp7fX0=', 1746189742),
('Nksfo0Sl87T66E7iiadn3rI4PlvMkxn1ebt5lS1u', 7, '192.168.1.5', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiSUwyQmxOSnlkZWJxdlA4NFFXaDY5a2IxV2JoR2dTM2h3UUV5Vmx1TiI7czoyMjoiUEhQREVCVUdCQVJfU1RBQ0tfREFUQSI7YTowOnt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xOTIuMTY4LjEuNTg6ODAwMC9kYXNoYm9hcmQvaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjc7fQ==', 1746192625),
('wrWNwE3nwY6sWV7I8SXhmubvI9WV5olXnDx0yEuE', 7, '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoibng0aTRrM3hLR2dNd2VpTmVOZzg4dFJ0bEV6c3RDOUF2c3BCSDJCZCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozOToiaHR0cDovLzE5Mi4xNjguMS41ODo4MDAwL2Rhc2hib2FyZC9ob21lIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly8xOTIuMTY4LjEuNTg6ODAwMC9kYXNoYm9hcmQvY2F0ZWdvcmllcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjc7fQ==', 1746194487);

-- --------------------------------------------------------

--
-- Structure de la table `slides`
--

CREATE TABLE `slides` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `line1` varchar(255) NOT NULL,
  `line2` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `slides`
--

INSERT INTO `slides` (`id`, `title`, `line1`, `line2`, `image_path`, `type`, `created_at`, `updated_at`) VALUES
(1, 'retrret', 'tretre', 'tretre', 'slides/cUhCBuOyuPZxEG4nCoarGEDxLhkms79Bdzn6vXAo.png', 'PC', '2025-01-17 13:54:42', '2025-01-17 13:54:42'),
(2, 'rtret', 'retre', 'tetre', 'slides/K39zL92y5XEKRB2d7nad6KGXBjgRRsa40rWBbGK1.png', NULL, '2025-01-17 13:54:52', '2025-01-17 13:54:52'),
(3, 'retre', 'tret', 'tret', 'slides/2W9r5TXkvdpUvQKIVW83KEkyByH5e911TN2HBuDR.png', NULL, '2025-01-17 13:55:15', '2025-01-17 13:55:15');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `utype` varchar(255) NOT NULL DEFAULT 'USR' COMMENT 'ADM for Admin and USR for User or Customer',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `utype`, `remember_token`, `created_at`, `updated_at`) VALUES
(7, 'selim idriss', 'selim.idriss@gei.tn', NULL, '$2y$12$dXxaMMFZrJ3igMs7ZgsHleLAZ.isx36.t7itm5u0w5k/BRNrqx8TC', 'USR', NULL, '2025-04-30 07:21:31', '2025-04-30 07:21:31');

-- --------------------------------------------------------

--
-- Structure de la table `visitor_logs`
--

CREATE TABLE `visitor_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `country` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `os` varchar(255) DEFAULT NULL,
  `browser` varchar(255) DEFAULT NULL,
  `device` varchar(255) DEFAULT NULL,
  `referer` varchar(255) DEFAULT NULL,
  `visited_page` varchar(255) DEFAULT NULL,
  `visit_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `visitor_logs`
--

INSERT INTO `visitor_logs` (`id`, `ip_address`, `country`, `city`, `latitude`, `longitude`, `os`, `browser`, `device`, `referer`, `visited_page`, `visit_time`, `updated_at`, `created_at`) VALUES
(587, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Firefox', '0', NULL, '/', '2025-04-26 10:37:12', '2025-04-26 10:37:12', '2025-04-26 10:37:12'),
(588, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Firefox', '0', NULL, '/', '2025-04-26 10:41:11', '2025-04-26 10:41:11', '2025-04-26 10:41:11'),
(589, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-26 10:42:01', '2025-04-26 10:42:01', '2025-04-26 10:42:01'),
(590, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Firefox', '0', NULL, '/', '2025-04-26 10:48:37', '2025-04-26 10:48:37', '2025-04-26 10:48:37'),
(591, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Firefox', '0', 'http://127.0.0.1:8000/checkout', '/', '2025-04-26 11:15:25', '2025-04-26 11:15:25', '2025-04-26 11:15:25'),
(592, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Firefox', '0', 'http://127.0.0.1:8000/confirmation/ORD-680CCE9311310', '/', '2025-04-26 11:23:10', '2025-04-26 11:23:10', '2025-04-26 11:23:10'),
(593, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Firefox', '0', 'http://127.0.0.1:8000/confirmation/ORD-680CD0554A27C', '/', '2025-04-26 11:24:03', '2025-04-26 11:24:03', '2025-04-26 11:24:03'),
(594, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Firefox', '0', 'http://127.0.0.1:8000/confirmation/ORD-680CD20D2F747', '/', '2025-04-26 11:31:37', '2025-04-26 11:31:37', '2025-04-26 11:31:37'),
(595, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 06:24:21', '2025-04-28 06:24:21', '2025-04-28 06:24:21'),
(596, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 06:24:29', '2025-04-28 06:24:29', '2025-04-28 06:24:29'),
(597, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/confirmation/ORD-680F2D606DC4A', '/', '2025-04-28 06:25:44', '2025-04-28 06:25:44', '2025-04-28 06:25:44'),
(598, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 08:53:01', '2025-04-28 08:53:01', '2025-04-28 08:53:01'),
(599, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 09:05:29', '2025-04-28 09:05:29', '2025-04-28 09:05:29'),
(600, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'iOS', 'Safari', 'iPhone', 'http://127.0.0.1:8000/', '/', '2025-04-28 09:05:40', '2025-04-28 09:05:40', '2025-04-28 09:05:40'),
(601, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 09:05:49', '2025-04-28 09:05:49', '2025-04-28 09:05:49'),
(602, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 09:06:11', '2025-04-28 09:06:11', '2025-04-28 09:06:11'),
(603, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 09:11:41', '2025-04-28 09:11:41', '2025-04-28 09:11:41'),
(604, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 09:12:03', '2025-04-28 09:12:03', '2025-04-28 09:12:03'),
(605, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 09:12:33', '2025-04-28 09:12:33', '2025-04-28 09:12:33'),
(606, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 09:13:27', '2025-04-28 09:13:27', '2025-04-28 09:13:27'),
(607, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 09:14:12', '2025-04-28 09:14:12', '2025-04-28 09:14:12'),
(608, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 09:15:05', '2025-04-28 09:15:05', '2025-04-28 09:15:05'),
(609, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 09:25:25', '2025-04-28 09:25:25', '2025-04-28 09:25:25'),
(610, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 09:29:34', '2025-04-28 09:29:34', '2025-04-28 09:29:34'),
(611, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 09:36:48', '2025-04-28 09:36:48', '2025-04-28 09:36:48'),
(612, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 09:39:18', '2025-04-28 09:39:18', '2025-04-28 09:39:18'),
(613, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 09:40:00', '2025-04-28 09:40:00', '2025-04-28 09:40:00'),
(614, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 09:42:09', '2025-04-28 09:42:09', '2025-04-28 09:42:09'),
(615, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 09:42:28', '2025-04-28 09:42:28', '2025-04-28 09:42:28'),
(616, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 09:43:55', '2025-04-28 09:43:55', '2025-04-28 09:43:55'),
(617, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 09:46:19', '2025-04-28 09:46:19', '2025-04-28 09:46:19'),
(618, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 09:48:12', '2025-04-28 09:48:12', '2025-04-28 09:48:12'),
(619, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 09:52:08', '2025-04-28 09:52:08', '2025-04-28 09:52:08'),
(620, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 09:53:47', '2025-04-28 09:53:47', '2025-04-28 09:53:47'),
(621, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 09:55:21', '2025-04-28 09:55:21', '2025-04-28 09:55:21'),
(622, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 09:57:13', '2025-04-28 09:57:13', '2025-04-28 09:57:13'),
(623, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'iOS', 'Safari', 'iPhone', 'http://127.0.0.1:8000/', '/', '2025-04-28 09:59:21', '2025-04-28 09:59:21', '2025-04-28 09:59:21'),
(624, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 10:02:06', '2025-04-28 10:02:06', '2025-04-28 10:02:06'),
(625, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 10:02:21', '2025-04-28 10:02:21', '2025-04-28 10:02:21'),
(626, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 10:05:08', '2025-04-28 10:05:08', '2025-04-28 10:05:08'),
(627, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 10:06:35', '2025-04-28 10:06:35', '2025-04-28 10:06:35'),
(628, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 10:08:41', '2025-04-28 10:08:41', '2025-04-28 10:08:41'),
(629, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 10:09:57', '2025-04-28 10:09:57', '2025-04-28 10:09:57'),
(630, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 10:14:18', '2025-04-28 10:14:18', '2025-04-28 10:14:18'),
(631, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 10:15:50', '2025-04-28 10:15:50', '2025-04-28 10:15:50'),
(632, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'iOS', 'Safari', 'iPhone', 'http://127.0.0.1:8000/', '/', '2025-04-28 10:15:54', '2025-04-28 10:15:54', '2025-04-28 10:15:54'),
(633, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 10:16:07', '2025-04-28 10:16:07', '2025-04-28 10:16:07'),
(634, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/categorie/50', '/', '2025-04-28 10:19:34', '2025-04-28 10:19:34', '2025-04-28 10:19:34'),
(635, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 10:22:21', '2025-04-28 10:22:21', '2025-04-28 10:22:21'),
(636, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 10:22:33', '2025-04-28 10:22:33', '2025-04-28 10:22:33'),
(637, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 10:22:48', '2025-04-28 10:22:48', '2025-04-28 10:22:48'),
(638, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 10:22:56', '2025-04-28 10:22:56', '2025-04-28 10:22:56'),
(639, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/checkout', '/', '2025-04-28 10:30:52', '2025-04-28 10:30:52', '2025-04-28 10:30:52'),
(640, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/categorie/51', '/', '2025-04-28 10:30:58', '2025-04-28 10:30:58', '2025-04-28 10:30:58'),
(641, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 10:31:38', '2025-04-28 10:31:38', '2025-04-28 10:31:38'),
(642, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/checkout', '/', '2025-04-28 10:32:33', '2025-04-28 10:32:33', '2025-04-28 10:32:33'),
(643, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 10:34:11', '2025-04-28 10:34:11', '2025-04-28 10:34:11'),
(644, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 12:08:53', '2025-04-28 12:08:53', '2025-04-28 12:08:53'),
(645, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 12:09:37', '2025-04-28 12:09:37', '2025-04-28 12:09:37'),
(646, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 12:10:14', '2025-04-28 12:10:14', '2025-04-28 12:10:14'),
(647, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 12:12:46', '2025-04-28 12:12:46', '2025-04-28 12:12:46'),
(648, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 12:13:03', '2025-04-28 12:13:03', '2025-04-28 12:13:03'),
(649, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 12:13:32', '2025-04-28 12:13:32', '2025-04-28 12:13:32'),
(650, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 12:13:40', '2025-04-28 12:13:40', '2025-04-28 12:13:40'),
(651, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 12:16:25', '2025-04-28 12:16:25', '2025-04-28 12:16:25'),
(652, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 12:16:39', '2025-04-28 12:16:39', '2025-04-28 12:16:39'),
(653, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 12:18:05', '2025-04-28 12:18:05', '2025-04-28 12:18:05'),
(654, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 12:20:56', '2025-04-28 12:20:56', '2025-04-28 12:20:56'),
(655, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 12:21:14', '2025-04-28 12:21:14', '2025-04-28 12:21:14'),
(656, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'iOS', 'Safari', 'iPhone', 'http://127.0.0.1:8000/', '/', '2025-04-28 12:22:10', '2025-04-28 12:22:10', '2025-04-28 12:22:10'),
(657, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 12:22:43', '2025-04-28 12:22:43', '2025-04-28 12:22:43'),
(658, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 12:24:19', '2025-04-28 12:24:19', '2025-04-28 12:24:19'),
(659, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/remboursement', '/', '2025-04-28 12:24:49', '2025-04-28 12:24:49', '2025-04-28 12:24:49'),
(660, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 12:25:27', '2025-04-28 12:25:27', '2025-04-28 12:25:27'),
(661, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'iOS', 'Safari', 'iPhone', 'http://127.0.0.1:8000/', '/', '2025-04-28 12:25:36', '2025-04-28 12:25:36', '2025-04-28 12:25:36'),
(662, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'AndroidOS', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', '/', '2025-04-28 12:25:46', '2025-04-28 12:25:46', '2025-04-28 12:25:46'),
(663, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 12:25:49', '2025-04-28 12:25:49', '2025-04-28 12:25:49'),
(664, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'iOS', 'Safari', 'iPhone', 'http://127.0.0.1:8000/', '/', '2025-04-28 12:25:56', '2025-04-28 12:25:56', '2025-04-28 12:25:56'),
(665, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'OS X', 'Safari', 'Macintosh', 'http://127.0.0.1:8000/', '/', '2025-04-28 12:25:59', '2025-04-28 12:25:59', '2025-04-28 12:25:59'),
(666, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'OS X', 'Safari', 'Macintosh', NULL, '/', '2025-04-28 12:26:38', '2025-04-28 12:26:38', '2025-04-28 12:26:38'),
(667, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'OS X', 'Safari', 'Macintosh', 'http://127.0.0.1:8000/', '/', '2025-04-28 12:26:41', '2025-04-28 12:26:41', '2025-04-28 12:26:41'),
(668, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'OS X', 'Safari', 'Macintosh', NULL, '/', '2025-04-28 12:26:52', '2025-04-28 12:26:52', '2025-04-28 12:26:52'),
(669, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'OS X', 'Safari', 'Macintosh', 'http://127.0.0.1:8000/', '/', '2025-04-28 12:26:54', '2025-04-28 12:26:54', '2025-04-28 12:26:54'),
(670, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'OS X', 'Safari', 'Macintosh', 'http://127.0.0.1:8000/checkout', '/', '2025-04-28 12:31:50', '2025-04-28 12:31:50', '2025-04-28 12:31:50'),
(671, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'OS X', 'Safari', 'Macintosh', 'http://127.0.0.1:8000/checkout', '/', '2025-04-28 12:31:53', '2025-04-28 12:31:53', '2025-04-28 12:31:53'),
(672, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'OS X', 'Safari', 'Macintosh', 'http://127.0.0.1:8000/contact', '/', '2025-04-28 12:32:38', '2025-04-28 12:32:38', '2025-04-28 12:32:38'),
(673, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/produit/12', '/', '2025-04-28 12:33:09', '2025-04-28 12:33:09', '2025-04-28 12:33:09'),
(674, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/checkout', '/', '2025-04-28 12:42:24', '2025-04-28 12:42:24', '2025-04-28 12:42:24'),
(675, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 12:42:40', '2025-04-28 12:42:40', '2025-04-28 12:42:40'),
(676, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 12:59:16', '2025-04-28 12:59:16', '2025-04-28 12:59:16'),
(677, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'iOS', 'Safari', 'iPhone', 'http://127.0.0.1:8000/', '/', '2025-04-28 12:59:19', '2025-04-28 12:59:19', '2025-04-28 12:59:19'),
(678, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/checkout', '/', '2025-04-28 13:13:52', '2025-04-28 13:13:52', '2025-04-28 13:13:52'),
(679, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 13:14:02', '2025-04-28 13:14:02', '2025-04-28 13:14:02'),
(680, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/checkout', '/', '2025-04-28 13:18:53', '2025-04-28 13:18:53', '2025-04-28 13:18:53'),
(681, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/categorie/51', '/', '2025-04-28 13:18:57', '2025-04-28 13:18:57', '2025-04-28 13:18:57'),
(682, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'OS X', 'Safari', 'Macintosh', 'http://127.0.0.1:8000/', '/', '2025-04-28 13:34:13', '2025-04-28 13:34:13', '2025-04-28 13:34:13'),
(683, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 13:35:27', '2025-04-28 13:35:27', '2025-04-28 13:35:27'),
(684, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'iOS', 'Safari', 'iPhone', 'http://127.0.0.1:8000/', '/', '2025-04-28 13:35:30', '2025-04-28 13:35:30', '2025-04-28 13:35:30'),
(685, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 13:35:32', '2025-04-28 13:35:32', '2025-04-28 13:35:32'),
(686, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/categorie/50', '/', '2025-04-28 13:43:16', '2025-04-28 13:43:16', '2025-04-28 13:43:16'),
(687, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'OS X', 'Safari', 'Macintosh', NULL, '/', '2025-04-28 13:50:33', '2025-04-28 13:50:33', '2025-04-28 13:50:33'),
(688, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'OS X', 'Safari', 'Macintosh', 'http://127.0.0.1:8000/', '/', '2025-04-28 13:50:36', '2025-04-28 13:50:36', '2025-04-28 13:50:36'),
(689, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-28 14:02:17', '2025-04-28 14:02:17', '2025-04-28 14:02:17'),
(690, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/categorie/50', '/', '2025-04-29 06:48:59', '2025-04-29 06:48:59', '2025-04-29 06:48:59'),
(691, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-29 10:01:17', '2025-04-29 10:01:17', '2025-04-29 10:01:17'),
(692, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'iOS', 'Safari', 'iPhone', 'http://127.0.0.1:8000/', '/', '2025-04-29 10:02:40', '2025-04-29 10:02:40', '2025-04-29 10:02:40'),
(693, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'iOS', 'Safari', 'iPad', 'http://127.0.0.1:8000/', '/', '2025-04-29 10:02:46', '2025-04-29 10:02:46', '2025-04-29 10:02:46'),
(694, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'iOS', 'Safari', 'iPad', 'http://127.0.0.1:8000/', '/', '2025-04-29 10:02:50', '2025-04-29 10:02:50', '2025-04-29 10:02:50'),
(695, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'iOS', 'Safari', 'iPad', 'http://127.0.0.1:8000/', '/', '2025-04-29 10:03:06', '2025-04-29 10:03:06', '2025-04-29 10:03:06'),
(696, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'AndroidOS', 'Chrome', 'SamsungTablet', 'http://127.0.0.1:8000/', '/', '2025-04-29 10:03:25', '2025-04-29 10:03:25', '2025-04-29 10:03:25'),
(697, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-29 10:03:29', '2025-04-29 10:03:29', '2025-04-29 10:03:29'),
(698, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/produit/11', '/', '2025-04-29 10:12:33', '2025-04-29 10:12:33', '2025-04-29 10:12:33'),
(699, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'iOS', 'Safari', 'iPhone', 'http://127.0.0.1:8000/', '/', '2025-04-29 10:12:46', '2025-04-29 10:12:46', '2025-04-29 10:12:46'),
(700, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'iOS', 'Safari', 'iPhone', NULL, '/', '2025-04-29 10:13:17', '2025-04-29 10:13:17', '2025-04-29 10:13:17'),
(701, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'iOS', 'Safari', 'iPhone', 'http://127.0.0.1:8000/', '/', '2025-04-29 10:13:19', '2025-04-29 10:13:19', '2025-04-29 10:13:19'),
(702, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'iOS', 'Safari', 'iPhone', NULL, '/', '2025-04-29 10:13:47', '2025-04-29 10:13:47', '2025-04-29 10:13:47'),
(703, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'iOS', 'Safari', 'iPhone', 'http://127.0.0.1:8000/', '/', '2025-04-29 10:13:49', '2025-04-29 10:13:49', '2025-04-29 10:13:49'),
(704, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-29 10:14:18', '2025-04-29 10:14:18', '2025-04-29 10:14:18'),
(705, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-29 10:15:41', '2025-04-29 10:15:41', '2025-04-29 10:15:41'),
(706, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-29 10:16:41', '2025-04-29 10:16:41', '2025-04-29 10:16:41'),
(707, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-29 10:17:14', '2025-04-29 10:17:14', '2025-04-29 10:17:14'),
(708, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-29 10:17:37', '2025-04-29 10:17:37', '2025-04-29 10:17:37'),
(709, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-29 10:20:17', '2025-04-29 10:20:17', '2025-04-29 10:20:17'),
(710, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/produit/11', '/', '2025-04-29 11:40:58', '2025-04-29 11:40:58', '2025-04-29 11:40:58'),
(711, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-29 11:41:00', '2025-04-29 11:41:00', '2025-04-29 11:41:00'),
(712, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/checkout', '/', '2025-04-29 11:46:24', '2025-04-29 11:46:24', '2025-04-29 11:46:24'),
(713, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/confirmation/ORD-6810CA36BFC64', '/', '2025-04-29 11:47:01', '2025-04-29 11:47:01', '2025-04-29 11:47:01'),
(714, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/confirmation/ORD-6810CA36BFC64', '/', '2025-04-29 11:47:31', '2025-04-29 11:47:31', '2025-04-29 11:47:31'),
(715, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-29 11:47:53', '2025-04-29 11:47:53', '2025-04-29 11:47:53'),
(716, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/remboursement', '/', '2025-04-29 12:33:20', '2025-04-29 12:33:20', '2025-04-29 12:33:20'),
(717, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-30 06:56:55', '2025-04-30 06:56:55', '2025-04-30 06:56:55'),
(718, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-30 07:07:44', '2025-04-30 07:07:44', '2025-04-30 07:07:44'),
(719, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-30 07:19:12', '2025-04-30 07:19:12', '2025-04-30 07:19:12'),
(720, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/contact', '/', '2025-04-30 09:37:30', '2025-04-30 09:37:31', '2025-04-30 09:37:31'),
(721, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-30 09:51:32', '2025-04-30 09:51:32', '2025-04-30 09:51:32'),
(722, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-30 10:24:52', '2025-04-30 10:24:52', '2025-04-30 10:24:52'),
(723, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'remboursement', '2025-04-30 10:24:54', '2025-04-30 10:24:54', '2025-04-30 10:24:54'),
(724, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/contact/', '/', '2025-04-30 10:26:05', '2025-04-30 10:26:05', '2025-04-30 10:26:05'),
(725, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/contact/', '/', '2025-04-30 10:27:00', '2025-04-30 10:27:00', '2025-04-30 10:27:00'),
(726, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'categorie/51', '2025-04-30 10:27:13', '2025-04-30 10:27:13', '2025-04-30 10:27:13'),
(727, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'produit/15', '2025-04-30 10:27:43', '2025-04-30 10:27:43', '2025-04-30 10:27:43'),
(728, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/dashboard/produits', 'produit/13', '2025-04-30 12:03:43', '2025-04-30 12:03:43', '2025-04-30 12:03:43'),
(729, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/dashboard/produits', 'produit/11', '2025-04-30 12:03:47', '2025-04-30 12:03:47', '2025-04-30 12:03:47'),
(730, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-30 12:09:24', '2025-04-30 12:09:24', '2025-04-30 12:09:24'),
(731, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/51', '2025-04-30 12:09:26', '2025-04-30 12:09:26', '2025-04-30 12:09:26'),
(732, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/dashboard/produits', 'produit/10', '2025-04-30 12:10:02', '2025-04-30 12:10:02', '2025-04-30 12:10:02'),
(733, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-30 12:19:39', '2025-04-30 12:19:39', '2025-04-30 12:19:39'),
(734, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-04-30 12:19:43', '2025-04-30 12:19:43', '2025-04-30 12:19:43'),
(735, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/checkout', '/', '2025-04-30 12:21:20', '2025-04-30 12:21:20', '2025-04-30 12:21:20'),
(736, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/confirmation/ORD-681223DEC387E', '/', '2025-04-30 12:23:07', '2025-04-30 12:23:07', '2025-04-30 12:23:07'),
(737, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-04-30 12:23:10', '2025-04-30 12:23:10', '2025-04-30 12:23:10'),
(738, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-30 12:24:28', '2025-04-30 12:24:28', '2025-04-30 12:24:28'),
(739, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-30 12:24:31', '2025-04-30 12:24:31', '2025-04-30 12:24:31'),
(740, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-30 12:25:20', '2025-04-30 12:25:20', '2025-04-30 12:25:20'),
(741, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-04-30 12:25:22', '2025-04-30 12:25:22', '2025-04-30 12:25:22'),
(742, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/confirmation/ORD-681224D2E4CAB', '/', '2025-04-30 12:26:58', '2025-04-30 12:26:58', '2025-04-30 12:26:58'),
(743, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/51', '2025-04-30 12:27:00', '2025-04-30 12:27:00', '2025-04-30 12:27:00'),
(744, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/confirmation/ORD-6812253664E4E', '/', '2025-04-30 12:28:23', '2025-04-30 12:28:23', '2025-04-30 12:28:23'),
(745, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/51', '2025-04-30 12:28:25', '2025-04-30 12:28:25', '2025-04-30 12:28:25'),
(746, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-30 12:29:17', '2025-04-30 12:29:17', '2025-04-30 12:29:17'),
(747, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-04-30 12:29:55', '2025-04-30 12:29:55', '2025-04-30 12:29:55'),
(748, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-04-30 12:29:57', '2025-04-30 12:29:57', '2025-04-30 12:29:57'),
(749, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/confirmation/ORD-681225EB7F31F', '/', '2025-04-30 12:31:53', '2025-04-30 12:31:53', '2025-04-30 12:31:53'),
(750, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/51', '2025-04-30 12:31:55', '2025-04-30 12:31:55', '2025-04-30 12:31:55'),
(751, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/categorie/51', '/', '2025-04-30 12:31:57', '2025-04-30 12:31:57', '2025-04-30 12:31:57'),
(752, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-04-30 12:31:58', '2025-04-30 12:31:58', '2025-04-30 12:31:58'),
(753, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/confirmation/ORD-6812266049B7E', '/', '2025-04-30 12:33:14', '2025-04-30 12:33:14', '2025-04-30 12:33:14'),
(754, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-04-30 12:33:18', '2025-04-30 12:33:18', '2025-04-30 12:33:18'),
(755, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/confirmation/ORD-681226AC0774C', '/', '2025-04-30 12:38:47', '2025-04-30 12:38:47', '2025-04-30 12:38:47'),
(756, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-04-30 12:38:49', '2025-04-30 12:38:49', '2025-04-30 12:38:49'),
(757, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/confirmation/ORD-681227F4E21FC', '/', '2025-04-30 12:48:07', '2025-04-30 12:48:07', '2025-04-30 12:48:07'),
(758, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-04-30 12:48:09', '2025-04-30 12:48:09', '2025-04-30 12:48:09'),
(759, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/confirmation/ORD-68122A25CDC5B', '/', '2025-04-30 12:49:28', '2025-04-30 12:49:28', '2025-04-30 12:49:28'),
(760, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-04-30 12:49:30', '2025-04-30 12:49:30', '2025-04-30 12:49:30'),
(761, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/confirmation/ORD-68122A846D7D5', '/', '2025-04-30 12:54:36', '2025-04-30 12:54:36', '2025-04-30 12:54:36'),
(762, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-04-30 12:54:38', '2025-04-30 12:54:38', '2025-04-30 12:54:38'),
(763, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/confirmation/ORD-68122BAF82388', '/', '2025-04-30 12:56:28', '2025-04-30 12:56:28', '2025-04-30 12:56:28'),
(764, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-04-30 12:56:29', '2025-04-30 12:56:29', '2025-04-30 12:56:29'),
(765, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/confirmation/ORD-68122C1A10864', '/', '2025-04-30 13:02:27', '2025-04-30 13:02:27', '2025-04-30 13:02:27'),
(766, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-04-30 13:02:58', '2025-04-30 13:02:58', '2025-04-30 13:02:58'),
(767, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/confirmation/ORD-68122DF2EBB35', '/', '2025-04-30 13:06:55', '2025-04-30 13:06:55', '2025-04-30 13:06:55'),
(768, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-04-30 13:06:57', '2025-04-30 13:06:57', '2025-04-30 13:06:57'),
(769, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/confirmation/ORD-68122E90AB9D9', '/', '2025-04-30 13:08:39', '2025-04-30 13:08:39', '2025-04-30 13:08:39'),
(770, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-04-30 13:08:40', '2025-04-30 13:08:40', '2025-04-30 13:08:40'),
(771, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/categorie/50', 'produit/10', '2025-04-30 13:08:41', '2025-04-30 13:08:41', '2025-04-30 13:08:41'),
(772, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'categorie/50', '2025-04-30 13:12:22', '2025-04-30 13:12:22', '2025-04-30 13:12:22'),
(773, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/categorie/50', 'produit/11', '2025-04-30 13:12:24', '2025-04-30 13:12:24', '2025-04-30 13:12:24'),
(774, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/confirmation/ORD-6812306A8B769', '/', '2025-04-30 13:15:54', '2025-04-30 13:15:54', '2025-04-30 13:15:54'),
(775, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-04-30 13:15:56', '2025-04-30 13:15:56', '2025-04-30 13:15:56'),
(776, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/confirmation/ORD-681230AA62145', '/', '2025-04-30 13:16:22', '2025-04-30 13:16:22', '2025-04-30 13:16:22'),
(777, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-04-30 13:16:24', '2025-04-30 13:16:24', '2025-04-30 13:16:24'),
(778, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/confirmation/ORD-681230C9DAFA9', '/', '2025-04-30 13:17:13', '2025-04-30 13:17:13', '2025-04-30 13:17:13'),
(779, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-04-30 13:17:15', '2025-04-30 13:17:15', '2025-04-30 13:17:15'),
(780, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/confirmation/ORD-681231072E219', '/', '2025-04-30 13:31:29', '2025-04-30 13:31:29', '2025-04-30 13:31:29'),
(781, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-04-30 13:31:31', '2025-04-30 13:31:31', '2025-04-30 13:31:31'),
(782, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/confirmation/ORD-68122FD7614E3', '/', '2025-04-30 13:32:13', '2025-04-30 13:32:13', '2025-04-30 13:32:13'),
(783, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-04-30 13:32:15', '2025-04-30 13:32:15', '2025-04-30 13:32:15'),
(784, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/confirmation/ORD-6812347E86190', '/', '2025-04-30 13:33:19', '2025-04-30 13:33:19', '2025-04-30 13:33:19'),
(785, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-04-30 13:33:20', '2025-04-30 13:33:20', '2025-04-30 13:33:20'),
(786, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/confirmation/ORD-681234C734779', '/', '2025-04-30 13:37:16', '2025-04-30 13:37:16', '2025-04-30 13:37:16'),
(787, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-04-30 13:37:18', '2025-04-30 13:37:18', '2025-04-30 13:37:18'),
(788, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/confirmation/ORD-681235B1E1E90', '/', '2025-04-30 13:42:06', '2025-04-30 13:42:06', '2025-04-30 13:42:06'),
(789, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-04-30 13:42:07', '2025-04-30 13:42:07', '2025-04-30 13:42:07'),
(790, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/confirmation/ORD-681236CB22AA1', '/', '2025-04-30 13:42:55', '2025-04-30 13:42:55', '2025-04-30 13:42:55'),
(791, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-04-30 13:42:57', '2025-04-30 13:42:57', '2025-04-30 13:42:57'),
(792, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/confirmation/ORD-681236FDD31EB', '/', '2025-04-30 13:44:01', '2025-04-30 13:44:01', '2025-04-30 13:44:01'),
(793, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-04-30 13:44:03', '2025-04-30 13:44:03', '2025-04-30 13:44:03'),
(794, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/confirmation/ORD-6812373F0731F', '/', '2025-04-30 13:45:43', '2025-04-30 13:45:43', '2025-04-30 13:45:43'),
(795, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-04-30 13:45:45', '2025-04-30 13:45:45', '2025-04-30 13:45:45'),
(796, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/confirmation/ORD-681237A764436', '/', '2025-04-30 13:46:48', '2025-04-30 13:46:48', '2025-04-30 13:46:48'),
(797, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-04-30 13:46:49', '2025-04-30 13:46:49', '2025-04-30 13:46:49'),
(798, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/confirmation/ORD-681237E9972C4', '/', '2025-04-30 13:48:08', '2025-04-30 13:48:08', '2025-04-30 13:48:08'),
(799, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-04-30 13:48:15', '2025-04-30 13:48:15', '2025-04-30 13:48:15'),
(800, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-05-02 07:28:14', '2025-05-02 07:28:14', '2025-05-02 07:28:14'),
(801, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/51', '2025-05-02 07:28:16', '2025-05-02 07:28:16', '2025-05-02 07:28:16'),
(802, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-05-02 07:28:22', '2025-05-02 07:28:22', '2025-05-02 07:28:22'),
(803, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/confirmation/ORD-681482350BAFC', '/', '2025-05-02 07:32:25', '2025-05-02 07:32:25', '2025-05-02 07:32:25'),
(804, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-05-02 07:32:27', '2025-05-02 07:32:27', '2025-05-02 07:32:27'),
(805, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'categorie/50', '2025-05-02 07:33:26', '2025-05-02 07:33:26', '2025-05-02 07:33:26'),
(806, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'categorie/50', '2025-05-02 07:33:43', '2025-05-02 07:33:43', '2025-05-02 07:33:43'),
(807, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'categorie/50', '2025-05-02 07:34:03', '2025-05-02 07:34:03', '2025-05-02 07:34:03'),
(808, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'categorie/50', '2025-05-02 07:35:20', '2025-05-02 07:35:20', '2025-05-02 07:35:20'),
(809, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'categorie/50', '2025-05-02 07:35:44', '2025-05-02 07:35:44', '2025-05-02 07:35:44'),
(810, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'categorie/50', '2025-05-02 07:37:52', '2025-05-02 07:37:52', '2025-05-02 07:37:52'),
(811, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'categorie/50', '2025-05-02 07:38:00', '2025-05-02 07:38:00', '2025-05-02 07:38:00'),
(812, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'categorie/50', '2025-05-02 07:38:41', '2025-05-02 07:38:41', '2025-05-02 07:38:41'),
(813, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'categorie/50', '2025-05-02 07:43:38', '2025-05-02 07:43:38', '2025-05-02 07:43:38'),
(814, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'categorie/50', '2025-05-02 07:50:24', '2025-05-02 07:50:24', '2025-05-02 07:50:24'),
(815, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'categorie/50', '2025-05-02 07:51:29', '2025-05-02 07:51:29', '2025-05-02 07:51:29'),
(816, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'categorie/50', '2025-05-02 07:52:21', '2025-05-02 07:52:21', '2025-05-02 07:52:21'),
(817, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'categorie/50', '2025-05-02 07:52:23', '2025-05-02 07:52:23', '2025-05-02 07:52:23'),
(818, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'categorie/50', '2025-05-02 07:56:30', '2025-05-02 07:56:30', '2025-05-02 07:56:30'),
(819, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'categorie/50', '2025-05-02 07:56:51', '2025-05-02 07:56:51', '2025-05-02 07:56:51'),
(820, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'categorie/50', '2025-05-02 07:57:07', '2025-05-02 07:57:07', '2025-05-02 07:57:07'),
(821, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'categorie/50', '2025-05-02 07:57:27', '2025-05-02 07:57:27', '2025-05-02 07:57:27'),
(822, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'AndroidOS', 'Chrome', 'Nexus', NULL, 'categorie/50', '2025-05-02 07:58:21', '2025-05-02 07:58:21', '2025-05-02 07:58:21'),
(823, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'categorie/50', '2025-05-02 08:07:23', '2025-05-02 08:07:23', '2025-05-02 08:07:23'),
(824, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'AndroidOS', 'Chrome', 'Nexus', NULL, 'categorie/50', '2025-05-02 08:08:21', '2025-05-02 08:08:21', '2025-05-02 08:08:21'),
(825, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'categorie/50', '2025-05-02 08:09:29', '2025-05-02 08:09:29', '2025-05-02 08:09:29'),
(826, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'categorie/50', '2025-05-02 08:10:48', '2025-05-02 08:10:48', '2025-05-02 08:10:48'),
(827, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'categorie/50', '2025-05-02 08:20:13', '2025-05-02 08:20:13', '2025-05-02 08:20:13'),
(828, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'categorie/50', '2025-05-02 08:20:16', '2025-05-02 08:20:16', '2025-05-02 08:20:16'),
(829, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/checkout', '/', '2025-05-02 08:24:02', '2025-05-02 08:24:02', '2025-05-02 08:24:02'),
(830, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/contact', 'remboursement', '2025-05-02 08:26:54', '2025-05-02 08:26:54', '2025-05-02 08:26:54'),
(831, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/remboursement', '/', '2025-05-02 08:27:13', '2025-05-02 08:27:13', '2025-05-02 08:27:13'),
(832, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/contact/', 'remboursement', '2025-05-02 08:27:20', '2025-05-02 08:27:20', '2025-05-02 08:27:20'),
(833, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'politique-de-remboursement', '2025-05-02 08:29:16', '2025-05-02 08:29:16', '2025-05-02 08:29:16'),
(834, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'politique-de-remboursement', '2025-05-02 08:30:13', '2025-05-02 08:30:13', '2025-05-02 08:30:13'),
(835, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'politique-de-remboursement', '2025-05-02 08:31:20', '2025-05-02 08:31:20', '2025-05-02 08:31:20'),
(836, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/politique-de-remboursement', 'politique-de-remboursement', '2025-05-02 08:31:22', '2025-05-02 08:31:22', '2025-05-02 08:31:22'),
(837, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/politique-de-remboursement', 'politique-de-remboursement', '2025-05-02 08:31:25', '2025-05-02 08:31:25', '2025-05-02 08:31:25'),
(838, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/politique-de-remboursement', 'politique-de-remboursement', '2025-05-02 08:31:27', '2025-05-02 08:31:27', '2025-05-02 08:31:27'),
(839, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/politique-de-remboursement', '/', '2025-05-02 08:31:28', '2025-05-02 08:31:28', '2025-05-02 08:31:28'),
(840, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'politique-de-remboursement', '2025-05-02 08:31:31', '2025-05-02 08:31:31', '2025-05-02 08:31:31'),
(841, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/politique-de-remboursement', 'politique-de-remboursement', '2025-05-02 08:31:32', '2025-05-02 08:31:32', '2025-05-02 08:31:32'),
(842, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'politique-de-remboursement', '2025-05-02 08:31:42', '2025-05-02 08:31:42', '2025-05-02 08:31:42');
INSERT INTO `visitor_logs` (`id`, `ip_address`, `country`, `city`, `latitude`, `longitude`, `os`, `browser`, `device`, `referer`, `visited_page`, `visit_time`, `updated_at`, `created_at`) VALUES
(843, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'politique-de-remboursement', '2025-05-02 08:31:49', '2025-05-02 08:31:49', '2025-05-02 08:31:49'),
(844, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'politique-de-remboursement', '2025-05-02 08:32:01', '2025-05-02 08:32:01', '2025-05-02 08:32:01'),
(845, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'politique-de-remboursement', '2025-05-02 08:32:07', '2025-05-02 08:32:07', '2025-05-02 08:32:07'),
(846, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/contact', 'politique-de-remboursement', '2025-05-02 08:32:13', '2025-05-02 08:32:13', '2025-05-02 08:32:13'),
(847, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/contact', 'politique-de-remboursement', '2025-05-02 08:32:18', '2025-05-02 08:32:18', '2025-05-02 08:32:18'),
(848, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/contact', 'politique-de-remboursement', '2025-05-02 08:32:28', '2025-05-02 08:32:28', '2025-05-02 08:32:28'),
(849, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'politique-de-remboursement', '2025-05-02 08:32:58', '2025-05-02 08:32:58', '2025-05-02 08:32:58'),
(850, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'politique-de-remboursement', '2025-05-02 08:33:21', '2025-05-02 08:33:21', '2025-05-02 08:33:21'),
(851, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/contact', 'politique-de-remboursement', '2025-05-02 08:33:29', '2025-05-02 08:33:29', '2025-05-02 08:33:29'),
(852, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/politique-de-remboursement', '/', '2025-05-02 08:33:45', '2025-05-02 08:33:45', '2025-05-02 08:33:45'),
(853, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-05-02 08:33:46', '2025-05-02 08:33:46', '2025-05-02 08:33:46'),
(854, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/checkout', '/', '2025-05-02 08:34:02', '2025-05-02 08:34:02', '2025-05-02 08:34:02'),
(855, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-05-02 08:34:04', '2025-05-02 08:34:04', '2025-05-02 08:34:04'),
(856, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/categorie/50', 'produit/11', '2025-05-02 08:34:05', '2025-05-02 08:34:05', '2025-05-02 08:34:05'),
(857, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'produit/11', '2025-05-02 08:34:32', '2025-05-02 08:34:32', '2025-05-02 08:34:32'),
(858, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'produit/11', '2025-05-02 08:34:34', '2025-05-02 08:34:34', '2025-05-02 08:34:34'),
(859, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'produit/11', '2025-05-02 08:34:36', '2025-05-02 08:34:36', '2025-05-02 08:34:36'),
(860, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'produit/11', '2025-05-02 08:35:30', '2025-05-02 08:35:30', '2025-05-02 08:35:30'),
(861, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'produit/11', '2025-05-02 08:36:00', '2025-05-02 08:36:00', '2025-05-02 08:36:00'),
(862, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'produit/11', '2025-05-02 08:40:18', '2025-05-02 08:40:18', '2025-05-02 08:40:18'),
(863, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'produit/11', '2025-05-02 08:44:59', '2025-05-02 08:44:59', '2025-05-02 08:44:59'),
(864, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'produit/11', '2025-05-02 08:48:55', '2025-05-02 08:48:55', '2025-05-02 08:48:55'),
(865, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'produit/11', '2025-05-02 08:53:29', '2025-05-02 08:53:29', '2025-05-02 08:53:29'),
(866, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'produit/11', '2025-05-02 08:54:44', '2025-05-02 08:54:44', '2025-05-02 08:54:44'),
(867, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'produit/11', '2025-05-02 08:55:08', '2025-05-02 08:55:08', '2025-05-02 08:55:08'),
(868, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'produit/11', '2025-05-02 08:55:41', '2025-05-02 08:55:41', '2025-05-02 08:55:41'),
(869, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'produit/11', '2025-05-02 08:55:54', '2025-05-02 08:55:54', '2025-05-02 08:55:54'),
(870, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'produit/11', '2025-05-02 08:56:16', '2025-05-02 08:56:16', '2025-05-02 08:56:16'),
(871, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'produit/11', '2025-05-02 08:57:28', '2025-05-02 08:57:28', '2025-05-02 08:57:28'),
(872, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'produit/11', '2025-05-02 08:57:49', '2025-05-02 08:57:49', '2025-05-02 08:57:49'),
(873, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'produit/11', '2025-05-02 08:59:04', '2025-05-02 08:59:04', '2025-05-02 08:59:04'),
(874, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'produit/11', '2025-05-02 08:59:30', '2025-05-02 08:59:30', '2025-05-02 08:59:30'),
(875, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'produit/11', '2025-05-02 08:59:58', '2025-05-02 08:59:58', '2025-05-02 08:59:58'),
(876, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'produit/11', '2025-05-02 09:00:33', '2025-05-02 09:00:33', '2025-05-02 09:00:33'),
(877, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'produit/11', '2025-05-02 09:01:42', '2025-05-02 09:01:42', '2025-05-02 09:01:42'),
(878, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/contact', 'politique-de-remboursement', '2025-05-02 09:02:23', '2025-05-02 09:02:23', '2025-05-02 09:02:23'),
(879, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/contact', 'politique-de-remboursement', '2025-05-02 09:02:32', '2025-05-02 09:02:32', '2025-05-02 09:02:32'),
(880, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/politique-de-remboursement', '/', '2025-05-02 09:02:43', '2025-05-02 09:02:43', '2025-05-02 09:02:43'),
(881, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-05-02 09:05:14', '2025-05-02 09:05:14', '2025-05-02 09:05:14'),
(882, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/checkout', '/', '2025-05-02 09:06:43', '2025-05-02 09:06:43', '2025-05-02 09:06:43'),
(883, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-05-02 09:06:45', '2025-05-02 09:06:45', '2025-05-02 09:06:45'),
(884, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/confirmation/ORD-68148C0EE7585', '/', '2025-05-02 09:07:40', '2025-05-02 09:07:40', '2025-05-02 09:07:40'),
(885, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-05-02 09:07:41', '2025-05-02 09:07:41', '2025-05-02 09:07:41'),
(886, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/categorie/50', '/', '2025-05-02 09:12:29', '2025-05-02 09:12:29', '2025-05-02 09:12:29'),
(887, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-05-02 09:12:31', '2025-05-02 09:12:31', '2025-05-02 09:12:31'),
(888, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/contact', '/', '2025-05-02 09:14:02', '2025-05-02 09:14:02', '2025-05-02 09:14:02'),
(889, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-05-02 09:14:03', '2025-05-02 09:14:03', '2025-05-02 09:14:03'),
(890, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/confirmation/ORD-68149AFA04F98', '/', '2025-05-02 09:17:44', '2025-05-02 09:17:44', '2025-05-02 09:17:44'),
(891, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-05-02 09:17:46', '2025-05-02 09:17:46', '2025-05-02 09:17:46'),
(892, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/confirmation/ORD-68149BD758725', '/', '2025-05-02 09:18:53', '2025-05-02 09:18:53', '2025-05-02 09:18:53'),
(893, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-05-02 09:18:55', '2025-05-02 09:18:55', '2025-05-02 09:18:55'),
(894, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/confirmation/ORD-68149C1CAA7B6', '/', '2025-05-02 09:21:54', '2025-05-02 09:21:54', '2025-05-02 09:21:54'),
(895, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-05-02 09:21:56', '2025-05-02 09:21:56', '2025-05-02 09:21:56'),
(896, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/confirmation/ORD-68149CD385CC2', '/', '2025-05-02 09:23:42', '2025-05-02 09:23:42', '2025-05-02 09:23:42'),
(897, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-05-02 09:23:44', '2025-05-02 09:23:44', '2025-05-02 09:23:44'),
(898, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/confirmation/ORD-68149D3D75FF8', '/', '2025-05-02 09:24:21', '2025-05-02 09:24:21', '2025-05-02 09:24:21'),
(899, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-05-02 09:24:23', '2025-05-02 09:24:23', '2025-05-02 09:24:23'),
(900, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/confirmation/ORD-68149D6895042', '/', '2025-05-02 09:26:00', '2025-05-02 09:26:00', '2025-05-02 09:26:00'),
(901, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-05-02 09:26:01', '2025-05-02 09:26:01', '2025-05-02 09:26:01'),
(902, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/confirmation/ORD-68149DCF3D8B0', '/', '2025-05-02 09:28:40', '2025-05-02 09:28:40', '2025-05-02 09:28:40'),
(903, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-05-02 09:28:42', '2025-05-02 09:28:42', '2025-05-02 09:28:42'),
(904, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/confirmation/ORD-68149E7D49C7E', '/', '2025-05-02 09:32:11', '2025-05-02 09:32:11', '2025-05-02 09:32:11'),
(905, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-05-02 09:32:12', '2025-05-02 09:32:12', '2025-05-02 09:32:12'),
(906, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/confirmation/ORD-68149FEC840DF', '/', '2025-05-02 09:36:52', '2025-05-02 09:36:52', '2025-05-02 09:36:52'),
(907, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-05-02 09:36:59', '2025-05-02 09:36:59', '2025-05-02 09:36:59'),
(908, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/confirmation/ORD-6814A06C56109', '/', '2025-05-02 09:37:44', '2025-05-02 09:37:44', '2025-05-02 09:37:44'),
(909, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/50', '2025-05-02 09:37:45', '2025-05-02 09:37:45', '2025-05-02 09:37:45'),
(910, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-05-02 09:58:09', '2025-05-02 09:58:09', '2025-05-02 09:58:09'),
(911, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'iOS', 'Safari', 'iPhone', 'http://127.0.0.1:8000/', '/', '2025-05-02 09:58:36', '2025-05-02 09:58:36', '2025-05-02 09:58:36'),
(912, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'iOS', 'Safari', 'iPhone', 'http://127.0.0.1:8000/', 'categorie/51', '2025-05-02 09:59:01', '2025-05-02 09:59:01', '2025-05-02 09:59:01'),
(913, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'iOS', 'Safari', 'iPhone', 'http://127.0.0.1:8000/', '/', '2025-05-02 09:59:05', '2025-05-02 09:59:05', '2025-05-02 09:59:05'),
(914, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'iOS', 'Safari', 'iPhone', 'http://127.0.0.1:8000/', 'categorie/50', '2025-05-02 09:59:07', '2025-05-02 09:59:07', '2025-05-02 09:59:07'),
(915, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'categorie/50', '2025-05-02 09:59:28', '2025-05-02 09:59:28', '2025-05-02 09:59:28'),
(916, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'iOS', 'Safari', 'iPhone', 'http://127.0.0.1:8000/categorie/50', 'categorie/50', '2025-05-02 10:13:45', '2025-05-02 10:13:45', '2025-05-02 10:13:45'),
(917, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'categorie/50', '2025-05-02 10:14:22', '2025-05-02 10:14:22', '2025-05-02 10:14:22'),
(918, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'categorie/50', '2025-05-02 10:14:53', '2025-05-02 10:14:53', '2025-05-02 10:14:53'),
(919, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'iOS', 'Safari', 'iPhone', 'http://127.0.0.1:8000/categorie/50', 'categorie/50', '2025-05-02 10:15:04', '2025-05-02 10:15:04', '2025-05-02 10:15:04'),
(920, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'categorie/50', '2025-05-02 10:15:15', '2025-05-02 10:15:15', '2025-05-02 10:15:15'),
(921, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, 'categorie/50', '2025-05-02 10:15:48', '2025-05-02 10:15:48', '2025-05-02 10:15:48'),
(922, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/categorie/50', '/', '2025-05-02 10:15:53', '2025-05-02 10:15:53', '2025-05-02 10:15:53'),
(923, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/51', '2025-05-02 10:15:54', '2025-05-02 10:15:54', '2025-05-02 10:15:54'),
(924, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/', 'categorie/52', '2025-05-02 10:15:59', '2025-05-02 10:15:59', '2025-05-02 10:15:59'),
(925, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://127.0.0.1:8000/categorie/52', '/', '2025-05-02 10:16:13', '2025-05-02 10:16:13', '2025-05-02 10:16:13'),
(926, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-05-02 10:17:50', '2025-05-02 10:17:50', '2025-05-02 10:17:50'),
(927, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'iOS', 'Safari', 'iPhone', 'http://127.0.0.1:8000/', '/', '2025-05-02 10:17:56', '2025-05-02 10:17:56', '2025-05-02 10:17:56'),
(928, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'iOS', 'Safari', 'iPhone', NULL, '/', '2025-05-02 10:18:02', '2025-05-02 10:18:02', '2025-05-02 10:18:02'),
(929, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'iOS', 'Safari', 'iPhone', 'http://127.0.0.1:8000/', '/', '2025-05-02 10:18:05', '2025-05-02 10:18:05', '2025-05-02 10:18:05'),
(930, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'iOS', 'Safari', 'iPhone', NULL, '/', '2025-05-02 10:19:02', '2025-05-02 10:19:02', '2025-05-02 10:19:02'),
(931, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'iOS', 'Safari', 'iPhone', 'http://127.0.0.1:8000/', '/', '2025-05-02 10:19:04', '2025-05-02 10:19:04', '2025-05-02 10:19:04'),
(932, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'iOS', 'Safari', 'iPhone', NULL, '/', '2025-05-02 10:19:15', '2025-05-02 10:19:15', '2025-05-02 10:19:15'),
(933, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'iOS', 'Safari', 'iPhone', 'http://127.0.0.1:8000/', '/', '2025-05-02 10:19:17', '2025-05-02 10:19:17', '2025-05-02 10:19:17'),
(934, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'iOS', 'Safari', 'iPhone', NULL, '/', '2025-05-02 10:19:23', '2025-05-02 10:19:23', '2025-05-02 10:19:23'),
(935, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'iOS', 'Safari', 'iPhone', 'http://127.0.0.1:8000/', '/', '2025-05-02 10:19:26', '2025-05-02 10:19:26', '2025-05-02 10:19:26'),
(936, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'iOS', 'Safari', 'iPhone', NULL, '/', '2025-05-02 10:19:46', '2025-05-02 10:19:46', '2025-05-02 10:19:46'),
(937, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'iOS', 'Safari', 'iPhone', 'http://127.0.0.1:8000/', '/', '2025-05-02 10:19:49', '2025-05-02 10:19:49', '2025-05-02 10:19:49'),
(938, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'OS X', 'Safari', 'Macintosh', 'http://127.0.0.1:8000/', '/', '2025-05-02 10:20:16', '2025-05-02 10:20:16', '2025-05-02 10:20:16'),
(939, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-05-02 10:20:19', '2025-05-02 10:20:19', '2025-05-02 10:20:19'),
(940, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-05-02 10:25:44', '2025-05-02 10:25:44', '2025-05-02 10:25:44'),
(941, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'iOS', 'Safari', 'iPhone', 'http://127.0.0.1:8000/', '/', '2025-05-02 10:25:49', '2025-05-02 10:25:49', '2025-05-02 10:25:49'),
(942, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'iOS', 'Safari', 'iPhone', NULL, '/', '2025-05-02 10:28:09', '2025-05-02 10:28:09', '2025-05-02 10:28:09'),
(943, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'iOS', 'Safari', 'iPhone', 'http://127.0.0.1:8000/', '/', '2025-05-02 10:28:11', '2025-05-02 10:28:11', '2025-05-02 10:28:11'),
(944, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'OS X', 'Safari', 'Macintosh', 'http://127.0.0.1:8000/', '/', '2025-05-02 10:28:38', '2025-05-02 10:28:38', '2025-05-02 10:28:38'),
(945, '127.0.0.1', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'OS X', 'Safari', 'Macintosh', 'http://127.0.0.1:8000/', 'categorie/50', '2025-05-02 10:28:56', '2025-05-02 10:28:56', '2025-05-02 10:28:56'),
(946, '192.168.1.58', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-05-02 11:43:30', '2025-05-02 11:43:30', '2025-05-02 11:43:30'),
(947, '192.168.1.5', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'AndroidOS', 'Chrome', 'WebKit', NULL, '/', '2025-05-02 11:44:03', '2025-05-02 11:44:03', '2025-05-02 11:44:03'),
(948, '192.168.1.58', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-05-02 11:46:06', '2025-05-02 11:46:06', '2025-05-02 11:46:06'),
(949, '192.168.1.58', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://192.168.1.58:8000/', '/', '2025-05-02 11:46:37', '2025-05-02 11:46:37', '2025-05-02 11:46:37'),
(950, '192.168.1.58', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://192.168.1.58:8000/contact', 'politique-de-remboursement', '2025-05-02 11:46:42', '2025-05-02 11:46:42', '2025-05-02 11:46:42'),
(951, '192.168.1.58', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://192.168.1.58:8000/politique-de-remboursement', '/', '2025-05-02 11:46:46', '2025-05-02 11:46:46', '2025-05-02 11:46:46'),
(952, '192.168.1.58', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://192.168.1.58:8000/', 'categorie/50', '2025-05-02 11:46:49', '2025-05-02 11:46:49', '2025-05-02 11:46:49'),
(953, '192.168.1.58', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-05-02 11:47:10', '2025-05-02 11:47:10', '2025-05-02 11:47:10'),
(954, '192.168.1.58', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-05-02 11:56:11', '2025-05-02 11:56:11', '2025-05-02 11:56:11'),
(955, '192.168.1.19', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-05-02 11:56:54', '2025-05-02 11:56:54', '2025-05-02 11:56:54'),
(956, '192.168.1.26', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-05-02 12:07:42', '2025-05-02 12:07:42', '2025-05-02 12:07:42'),
(957, '192.168.1.26', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'AndroidOS', 'Chrome', 'Nexus', 'http://192.168.1.58:8000/', 'politique-de-remboursement', '2025-05-02 12:08:01', '2025-05-02 12:08:01', '2025-05-02 12:08:01'),
(958, '192.168.1.26', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://192.168.1.58:8000/contact', '/', '2025-05-02 12:08:23', '2025-05-02 12:08:23', '2025-05-02 12:08:23'),
(959, '192.168.1.26', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://192.168.1.58:8000/', 'categorie/53', '2025-05-02 12:08:27', '2025-05-02 12:08:27', '2025-05-02 12:08:27'),
(960, '192.168.1.26', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://192.168.1.58:8000/', 'categorie/51', '2025-05-02 12:08:31', '2025-05-02 12:08:31', '2025-05-02 12:08:31'),
(961, '192.168.1.26', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://192.168.1.58:8000/', 'categorie/50', '2025-05-02 12:08:39', '2025-05-02 12:08:39', '2025-05-02 12:08:39'),
(962, '192.168.1.26', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://192.168.1.58:8000/categorie/50', 'categorie/50', '2025-05-02 12:09:07', '2025-05-02 12:09:07', '2025-05-02 12:09:07'),
(963, '192.168.1.26', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://192.168.1.58:8000/categorie/50', 'produit/10', '2025-05-02 12:09:10', '2025-05-02 12:09:10', '2025-05-02 12:09:10'),
(964, '192.168.1.26', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://192.168.1.58:8000/confirmation/ORD-6814C41DDE42D', '/', '2025-05-02 12:10:06', '2025-05-02 12:10:06', '2025-05-02 12:10:06'),
(965, '192.168.1.58', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://192.168.1.58:8000/', 'categorie/50', '2025-05-02 12:31:19', '2025-05-02 12:31:19', '2025-05-02 12:31:19'),
(966, '192.168.1.19', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-05-02 12:49:59', '2025-05-02 12:49:59', '2025-05-02 12:49:59'),
(967, '192.168.1.19', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://192.168.1.58:8000/dashboard/produits', 'produit/13', '2025-05-02 12:50:26', '2025-05-02 12:50:26', '2025-05-02 12:50:26'),
(968, '192.168.1.19', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://192.168.1.58:8000/dashboard/produits', 'produit/10', '2025-05-02 12:51:11', '2025-05-02 12:51:11', '2025-05-02 12:51:11'),
(969, '192.168.1.19', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://192.168.1.58:8000/contact', '/', '2025-05-02 12:53:18', '2025-05-02 12:53:18', '2025-05-02 12:53:18'),
(970, '192.168.1.19', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://192.168.1.58:8000/', 'politique-de-remboursement', '2025-05-02 12:53:19', '2025-05-02 12:53:19', '2025-05-02 12:53:19'),
(971, '192.168.1.19', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://192.168.1.58:8000/politique-de-remboursement', '/', '2025-05-02 12:53:22', '2025-05-02 12:53:22', '2025-05-02 12:53:22'),
(972, '192.168.1.19', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://192.168.1.58:8000/', 'categorie/51', '2025-05-02 12:53:46', '2025-05-02 12:53:46', '2025-05-02 12:53:46'),
(973, '192.168.1.19', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://192.168.1.58:8000/', 'categorie/50', '2025-05-02 12:53:52', '2025-05-02 12:53:52', '2025-05-02 12:53:52'),
(974, '192.168.1.19', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://192.168.1.58:8000/', 'categorie/50', '2025-05-02 12:53:57', '2025-05-02 12:53:57', '2025-05-02 12:53:57'),
(975, '192.168.1.19', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://192.168.1.58:8000/', 'categorie/52', '2025-05-02 12:54:05', '2025-05-02 12:54:05', '2025-05-02 12:54:05'),
(976, '192.168.1.19', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://192.168.1.58:8000/categorie/52', 'produit/12', '2025-05-02 12:54:08', '2025-05-02 12:54:08', '2025-05-02 12:54:08'),
(977, '192.168.1.19', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://192.168.1.58:8000/categorie/52', '/', '2025-05-02 12:54:23', '2025-05-02 12:54:23', '2025-05-02 12:54:23'),
(978, '192.168.1.19', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://192.168.1.58:8000/', 'categorie/50', '2025-05-02 12:54:24', '2025-05-02 12:54:24', '2025-05-02 12:54:24'),
(979, '192.168.1.19', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://192.168.1.58:8000/categorie/50', 'produit/11', '2025-05-02 12:54:27', '2025-05-02 12:54:27', '2025-05-02 12:54:27'),
(980, '192.168.1.19', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://192.168.1.58:8000/categorie/50', 'produit/10', '2025-05-02 12:54:31', '2025-05-02 12:54:31', '2025-05-02 12:54:31'),
(981, '192.168.1.19', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://192.168.1.58:8000/categorie/50', '/', '2025-05-02 12:55:39', '2025-05-02 12:55:39', '2025-05-02 12:55:39'),
(982, '192.168.1.19', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://192.168.1.58:8000/', 'categorie/50', '2025-05-02 12:55:48', '2025-05-02 12:55:48', '2025-05-02 12:55:48'),
(983, '192.168.1.19', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://192.168.1.58:8000/contact', '/', '2025-05-02 12:58:34', '2025-05-02 12:58:34', '2025-05-02 12:58:34'),
(984, '192.168.1.19', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://192.168.1.58:8000/', 'categorie/51', '2025-05-02 12:58:36', '2025-05-02 12:58:36', '2025-05-02 12:58:36'),
(985, '192.168.1.19', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://192.168.1.58:8000/categorie/51', '/', '2025-05-02 12:58:39', '2025-05-02 12:58:39', '2025-05-02 12:58:39'),
(986, '192.168.1.19', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://192.168.1.58:8000/', 'categorie/50', '2025-05-02 12:58:42', '2025-05-02 12:58:42', '2025-05-02 12:58:42'),
(987, '192.168.1.58', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-05-02 13:05:03', '2025-05-02 13:05:03', '2025-05-02 13:05:03'),
(988, '192.168.1.58', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://192.168.1.58:8000/', 'categorie/50', '2025-05-02 13:05:06', '2025-05-02 13:05:06', '2025-05-02 13:05:06'),
(989, '192.168.1.58', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://192.168.1.58:8000/categorie/50', 'produit/11', '2025-05-02 13:05:18', '2025-05-02 13:05:18', '2025-05-02 13:05:18'),
(990, '192.168.1.58', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://192.168.1.58:8000/confirmation/ORD-6814D17C50689', '/', '2025-05-02 13:07:20', '2025-05-02 13:07:20', '2025-05-02 13:07:20'),
(991, '192.168.1.58', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-05-02 13:08:27', '2025-05-02 13:08:27', '2025-05-02 13:08:27'),
(992, '192.168.1.58', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://192.168.1.58:8000/', 'categorie/50', '2025-05-02 13:08:34', '2025-05-02 13:08:34', '2025-05-02 13:08:34'),
(993, '192.168.1.58', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', NULL, '/', '2025-05-02 13:09:02', '2025-05-02 13:09:02', '2025-05-02 13:09:02'),
(994, '192.168.1.58', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://192.168.1.58:8000/contact', 'contact', '2025-05-02 13:09:26', '2025-05-02 13:09:26', '2025-05-02 13:09:26'),
(995, '192.168.1.58', 'Unknown', 'Unknown', 0.00000000, 0.00000000, 'Windows', 'Chrome', 'WebKit', 'http://192.168.1.58:8000/dashboard/produits', 'produit/10', '2025-05-02 13:12:29', '2025-05-02 13:12:29', '2025-05-02 13:12:29');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `attributs`
--
ALTER TABLE `attributs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attributs_parent_id_foreign` (`parent_id`);

--
-- Index pour la table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Index pour la table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Index pour la table `checkout_data`
--
ALTER TABLE `checkout_data`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupons_code_unique` (`code`);

--
-- Index pour la table `demande_revendeur`
--
ALTER TABLE `demande_revendeur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Index pour la table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_produit` (`id_produit`),
  ADD KEY `red_order` (`red_order`);

--
-- Index pour la table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Index pour la table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD UNIQUE KEY `SKU` (`SKU`),
  ADD KEY `fk_category` (`category_id`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Index pour la table `slides`
--
ALTER TABLE `slides`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Index pour la table `visitor_logs`
--
ALTER TABLE `visitor_logs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `attributs`
--
ALTER TABLE `attributs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT pour la table `checkout_data`
--
ALTER TABLE `checkout_data`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `demande_revendeur`
--
ALTER TABLE `demande_revendeur`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT pour la table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5855;

--
-- AUTO_INCREMENT pour la table `slides`
--
ALTER TABLE `slides`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `visitor_logs`
--
ALTER TABLE `visitor_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=996;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `attributs`
--
ALTER TABLE `attributs`
  ADD CONSTRAINT `attributs_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `attributs` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_id_produit_foreign` FOREIGN KEY (`id_produit`) REFERENCES `products` (`id`);

--
-- Contraintes pour la table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
