-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 19, 2019 at 07:13 PM
-- Server version: 5.7.28-0ubuntu0.18.04.4
-- PHP Version: 7.2.24-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `food_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `device_details`
--

CREATE TABLE `device_details` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `device_tocken` varchar(6000) DEFAULT NULL,
  `type` enum('0','1') NOT NULL,
  `gcm_id` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `device_details`
--

INSERT INTO `device_details` (`id`, `user_id`, `device_tocken`, `type`, `gcm_id`, `created_at`) VALUES
(49, 9, '', '1', '', '2019-12-19 12:57:00');

-- --------------------------------------------------------

--
-- Table structure for table `email_format`
--

CREATE TABLE `email_format` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=Active, 0=In-Active',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `email_format`
--

INSERT INTO `email_format` (`id`, `title`, `subject`, `body`, `status`, `created_at`, `updated_at`) VALUES
(1, 'forgot_password', 'Forgot Password', '<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\">\n    <tbody>\n        <tr>\n            <td style=\"padding:20px 0 20px 0\" align=\"center\" valign=\"top\"><!-- [ header starts here] -->\n            <table style=\"border:1px solid #E0E0E0;\" cellpadding=\"10\" cellspacing=\"0\" bgcolor=\"FFFFFF\" border=\"0\" width=\"650\">\n                <tbody>\n                    <tr>\n                        <td style=\"background: #444444; \" bgcolor=\"#EAEAEA\" valign=\"top\"><p style=\"color:#fff;display: inline-flex;\">&nbsp;&nbsp;Food App</p><p></p><p></p></td>\n                    </tr>\n                    <!-- [ middle starts here] -->\n                    <tr>\n                        <td valign=\"top\">\n                        <p>Dear  {username},</p>\n                        <p>Your New Password is :<br></p><p><strong>E-mail:</strong> {email}<br>\n                         </p><p><strong>Password:</strong> {password}<br>\n\n                        </p><p>&nbsp;</p>\n                        </td>\n                    </tr>\n                   <tr>\n                        <td style=\"background: #444444; text-align:center;color: white;\" align=\"center\" bgcolor=\"#EAEAEA\"><center>\n                        <p style=\"font-size:12px; margin:0;\">Food App team</p>\n                        </center></td>\n                    </tr>\n                </tbody>\n            </table>\n            </td>\n        </tr>\n    </tbody>\n</table>\n', 1, '2019-12-12 00:00:00', NULL),
(2, 'user_registration', 'Food App -New Account', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">\n    <tbody>\n        <tr>\n            <td style=\"padding:20px 0 20px 0\" valign=\"top\" align=\"center\"><!-- [ header starts here] -->\n            <table style=\"border:1px solid #E0E0E0;\" cellpadding=\"10\" cellspacing=\"0\" width=\"650\" bgcolor=\"FFFFFF\" border=\"0\">\n                <tbody>\n                    <tr>\n                        <td style=\"background:#444444;color: white; \" valign=\"top\" bgcolor=\"#EAEAEA\"><p>Food App</p><p></p><p></p></td>\n                    </tr>\n                    <!-- [ middle starts here] -->\n                    <tr>\n                        <td valign=\"top\">\n                        <p>Dear  {username},</p>\n                        <p>Your account has been created.<br></p>\n                          <p><strong>E-mail:</strong> {email} <br></p>\n<p><strong>Password:</strong> {password} <br></p>\n<p>Please click on below link for verify your Email :</p>\n<p>{email_verify_link}</p>\n                        <p></p><p>&nbsp;</p>\n                        </td>\n                    </tr>\n                   <tr>\n                        <td style=\"background: #444444; text-align:center;color: white;\" align=\"center\" bgcolor=\"#EAEAEA\"><center>\n                        <p style=\"font-size:12px; margin:0;\">Food App Team</p>\n                        </center></td>\n                    </tr>\n                </tbody>\n            </table>\n            </td>\n        </tr>\n    </tbody>\n</table>\n', 1, '2019-12-12 00:00:00', NULL),
(3, 'reset_password', 'Reset Password', '<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\">\n    <tbody>\n        <tr>\n            <td style=\"padding:20px 0 20px 0\" align=\"center\" valign=\"top\"><!-- [ header starts here] -->\n            <table style=\"border:1px solid #E0E0E0;\" cellpadding=\"10\" cellspacing=\"0\" bgcolor=\"FFFFFF\" border=\"0\" width=\"650\">\n                <tbody>\n                   <tr>\n                        <td style=\"background: #444444; \" bgcolor=\"#EAEAEA\" valign=\"top\"><p style=\"color:#fff;display: inline-flex;\">&nbsp;&nbsp;Food App</p><p></p><p></p></td>\n                    </tr>\n                    <!-- [ middle starts here] -->\n                    <tr>\n                        <td valign=\"top\">\n                        <p>Dear  {username},</p>\n                        <p>Follow the link below to reset your password:</p>\n                        <p>{resetLink}</p>\n\n                        </p><p>&nbsp;</p>\n                        </td>\n                    </tr>\n                   <tr>\n                        <td style=\"background: #444444; text-align:center;color: white;\" align=\"center\" bgcolor=\"#EAEAEA\"><center>\n                        <p style=\"font-size:12px; margin:0;\">Food App</p>\n                        </center></td>\n                    </tr>\n                </tbody>\n            </table>\n            </td>\n        </tr>\n    </tbody>\n</table>\n', 1, '2019-12-12 00:00:00', NULL),
(4, 'contact_us', 'Food App Contact', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">\n    <tbody>\n        <tr>\n            <td style=\"padding:20px 0 20px 0\" valign=\"top\" align=\"center\"><!-- [ header starts here] -->\n            <table style=\"border:1px solid #E0E0E0;\" cellpadding=\"10\" cellspacing=\"0\" width=\"650\" bgcolor=\"FFFFFF\" border=\"0\">\n                <tbody>\n                     <tr>\n                        <td style=\"background: #444444; \" bgcolor=\"#EAEAEA\" valign=\"top\"><p style=\"color:#fff;display: inline-flex;\">&nbsp;&nbsp;Food App</p><p></p><p></p></td>\n                    </tr>\n                    <!-- [ middle starts here] -->\n                    <tr>\n                        <td valign=\"top\">\n                        <p>Hello  Food App Admin,\n                        <p>{message}<br></p>\n                        <p></p><p>&nbsp;</p>\n                        </td>\n                    </tr>\n                   <tr>\n                        <td style=\"background: #444444; text-align:center;color: white;\" align=\"center\" bgcolor=\"#EAEAEA\"><center>\n                        <p style=\"font-size:12px; margin:0;\">{name}</p>\n                        </center></td>\n                    </tr>\n                </tbody>\n            </table>\n            </td>\n        </tr>\n    </tbody>\n</table>\n', 1, '2019-12-12 00:00:00', NULL),
(5, 'backend_registration', 'Food App -New Account', '<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">\n    <tbody>\n        <tr>\n            <td style=\"padding:20px 0 20px 0\" valign=\"top\" align=\"center\"><!-- [ header starts here] -->\n            <table style=\"border:1px solid #E0E0E0;\" cellpadding=\"10\" cellspacing=\"0\" width=\"650\" bgcolor=\"FFFFFF\" border=\"0\">\n                <tbody>\n                    <tr>\n                        <td style=\"background:#444444;color: white; \" valign=\"top\" bgcolor=\"#EAEAEA\"><p>Food App</p><p></p><p></p></td>\n                    </tr>\n                    <!-- [ middle starts here] -->\n                    <tr>\n                        <td valign=\"top\">\n                        <p>Dear  {username},</p>\n                        <p>Your account has been created.<br></p>\n                          <p><strong>E-mail:</strong> {email} <br></p>\n                            <p><strong>Password:</strong> {password} <br></p>\n                            <p>Your role is {role}</p>\n                        <p></p><p>&nbsp;</p>\n                        </td>\n                    </tr>\n                   <tr>\n                        <td style=\"background: #444444; text-align:center;color: white;\" align=\"center\" bgcolor=\"#EAEAEA\"><center>\n                        <p style=\"font-size:12px; margin:0;\">Food App Team</p>\n                        </center></td>\n                    </tr>\n                </tbody>\n            </table>\n            </td>\n        </tr>\n    </tbody>\n</table>\n', 1, '2019-12-12 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menu_categories`
--

CREATE TABLE `menu_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` tinyint(6) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1576498339),
('m130524_201442_init', 1576498345),
('m190124_110200_add_verification_token_column_to_user_table', 1576498347),
('m191216_132958_users', 1576566801),
('m191217_071531_user_roles', 1576567743),
('m191217_075341_users_update', 1576569569);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `custom_url` varchar(255) NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `page_content` text NOT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_keyword` varchar(255) DEFAULT NULL,
  `meta_description` text,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `custom_url`, `page_title`, `page_content`, `meta_title`, `meta_keyword`, `meta_description`, `status`, `created_at`, `updated_at`) VALUES
(4, 'community-guidelines', 'Community Guidelines', '<p><em><strong>Community Guidelines1</strong></em></p>\r\n', 'Community Guidelines', 'Community Guidelines', '', 1, NULL, NULL),
(5, 'annoucements', 'Annoucements', '<p><em><strong>Annoucements</strong></em></p>\r\n', 'Annoucements', 'Annoucements', 'Annoucements', 1, NULL, NULL),
(6, 'terms-of-use', 'Terms of Use', '<p><em><strong>Terms of Use</strong></em></p>\r\n', 'Terms of Use', 'Terms of Use', 'Terms of Use', 1, NULL, NULL),
(7, 'about-bridge', 'About Bridge', '<p><strong>About Bridge</strong></p>\r\n\r\n<p>B4P.et &ndash; BRIDGE for participation &ndash; is a dedicated web-based application to bring individual parliamentarians and their constituents together as part of an inclusive, interactive online political community.</p>\r\n\r\n<p>The App will be accessible on tablets and smartphones, and its functionality will include creating and making visible parliamentarian profiles, and allowing parliamentarians and those they represent to post questions, comments and replies to one another.</p>\r\n\r\n<p>You can contact us through the below channels.</p>\r\n\r\n<p>Email: info@b4p.et<br />\r\nPhone: +251930294007</p>\r\n', 'About Bridge', 'About Bridge', 'About Bridge', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `restaurants`
--

CREATE TABLE `restaurants` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `restaurant_type` text NOT NULL,
  `address` varchar(255) NOT NULL,
  `lattitude` float NOT NULL,
  `longitude` float NOT NULL,
  `website` varchar(255) DEFAULT NULL,
  `contact_no` bigint(20) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `avg_cost_for_two` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `is_deleted` enum('1','0') NOT NULL DEFAULT '0',
  `created_by` bigint(20) NOT NULL,
  `updated_by` bigint(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_gallery`
--

CREATE TABLE `restaurant_gallery` (
  `id` int(11) NOT NULL,
  `restaurant_id` bigint(20) NOT NULL,
  `image_title` varchar(255) NOT NULL,
  `image_description` text,
  `image_name` varchar(255) NOT NULL,
  `status` tinyint(6) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `updated_by` bigint(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_menu`
--

CREATE TABLE `restaurant_menu` (
  `id` bigint(20) NOT NULL,
  `restaurant_id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `menu_category_id` int(11) NOT NULL,
  `price` float NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `status` tinyint(6) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_type`
--

CREATE TABLE `restaurant_type` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `restaurant_type`
--

INSERT INTO `restaurant_type` (`id`, `type`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Indian', 'Indian', '2019-12-19 12:49:55', '2019-12-19 12:56:31'),
(2, 'american', 'american', '2019-12-19 12:51:41', '2019-12-19 12:57:03'),
(3, 'asian', 'asian', '2019-12-19 12:57:12', '2019-12-19 12:57:12'),
(4, 'belgian', 'belgian', '2019-12-19 12:57:30', '2019-12-19 12:57:30'),
(5, 'chinese', 'chinese', '2019-12-19 12:58:12', '2019-12-19 12:58:12'),
(6, 'fast food', 'fast food', '2019-12-19 12:58:29', '2019-12-19 12:58:29'),
(7, 'french', 'french', '2019-12-19 12:58:42', '2019-12-19 12:58:42'),
(8, 'italian', 'italian', '2019-12-19 12:59:03', '2019-12-19 12:59:03'),
(9, 'mexican', 'mexican', '2019-12-19 12:59:13', '2019-12-19 12:59:13'),
(10, 'punjabi', 'punjabi', '2019-12-19 12:59:23', '2019-12-19 12:59:23'),
(11, 'north indian', 'north indian', '2019-12-19 12:59:39', '2019-12-19 12:59:39'),
(12, 'street food', 'street food', '2019-12-19 12:59:52', '2019-12-19 12:59:52'),
(13, 'vegetarian', 'vegetarian', '2019-12-19 13:00:10', '2019-12-19 13:00:10'),
(14, 'Non vegetarian', 'Non vegetarian', '2019-12-19 13:00:19', '2019-12-19 13:00:19'),
(15, 'west indian', 'west indian', '2019-12-19 13:00:37', '2019-12-19 13:00:37');

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_working_hours`
--

CREATE TABLE `restaurant_working_hours` (
  `id` bigint(20) NOT NULL,
  `restaurant_id` bigint(20) NOT NULL,
  `hours24` tinyint(2) DEFAULT NULL,
  `weekday` int(11) NOT NULL,
  `opening_time` time DEFAULT NULL,
  `closing_time` time DEFAULT NULL,
  `status` tinyint(6) NOT NULL COMMENT '''0''=Closed, ''1'' = Open',
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `verification_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `verification_token`) VALUES
(1, 'rutusha', '9RVFrCft1DVvnHvt7bdSuQOFGOV2oE0L', '$2y$13$ypJyQCuCKVvpIDKMCdJdyOZ.7/z6TDkqqf6OOLG0enIEm3EZx/iHy', NULL, 'rutusha1212joshi@gmail.com', 9, 1576498801, 1576498801, 'dW2jJIJJJCpqHsW-RdSVGE6iPStmG2Mq_1576498801');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` bigint(11) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `verification_code` varchar(255) DEFAULT NULL,
  `is_code_verified` enum('0','1') NOT NULL DEFAULT '0',
  `password_reset_token` text,
  `auth_token` varchar(255) DEFAULT NULL,
  `badge_count` int(11) DEFAULT NULL,
  `login_type` int(11) NOT NULL DEFAULT '1',
  `status` smallint(6) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `restaurant_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `user_name`, `email`, `password`, `phone`, `photo`, `verification_code`, `is_code_verified`, `password_reset_token`, `auth_token`, `badge_count`, `login_type`, `status`, `created_at`, `updated_at`, `restaurant_id`) VALUES
(1, 1, 'super_admin', 'rutusha1212joshi@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 44444444, '45ac63f556943e88ff3413af1def39f764654.png', '', '0', '', '', 0, 1, 1, '2019-12-17 00:00:00', '2019-12-17 00:00:00', 1),
(9, 3, '', '', 'd41d8cd98f00b204e9800998ecf8427e', NULL, NULL, '9568e445456de20632aa3c51341facb8351e571ab00f20f966a8defa64584b45', '0', NULL, 'af371575ff35477233492f60e2471c64', NULL, 1, 1, '2019-12-19 12:57:00', '2019-12-19 12:57:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_address`
--

CREATE TABLE `user_address` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `address` text NOT NULL,
  `lat` float NOT NULL,
  `longg` float NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(255) DEFAULT NULL,
  `role_description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id`, `role_name`, `role_description`) VALUES
(1, 'super_admin', 'Super Admin'),
(2, 'Restaurant Admin', 'admin'),
(3, 'customer', 'customer'),
(4, 'Delivery Boy', 'Delivery Boy');

-- --------------------------------------------------------

--
-- Table structure for table `user_rules`
--

CREATE TABLE `user_rules` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `privileges_controller` varchar(255) NOT NULL,
  `privileges_actions` text NOT NULL,
  `permission` enum('allow','deny') NOT NULL DEFAULT 'allow',
  `permission_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_rules`
--

INSERT INTO `user_rules` (`id`, `role_id`, `privileges_controller`, `privileges_actions`, `permission`, `permission_type`) VALUES
(1, 1, 'SiteController', 'index,logout,change-password,forgot-password', 'allow', 'super admin'),
(2, 2, 'SiteController', 'index,logout,change-password,forgot-password', 'allow', 'admin'),
(3, 1, 'UsersController', 'index,create,view,update,delete', 'allow', 'super admin'),
(4, 2, 'UsersController', 'index,create,view,update,delete', 'allow', 'admin'),
(5, 1, 'RestaurantsController', 'index,create,update,view,delete,update-workinghours', 'allow', 'super_admin'),
(6, 2, 'RestaurantsController', 'index,create,update,view,delete,update-workinghours', 'allow', 'Restaurant admin'),
(7, 1, 'restaurant-typeController', 'index,create,update,view,delete', 'allow', 'Super admin'),
(8, 2, 'restaurant-typeController', 'index,create,update,view,delete', 'allow', 'Restaurant admin');

-- --------------------------------------------------------

--
-- Table structure for table `user_rules_menu`
--

CREATE TABLE `user_rules_menu` (
  `id` int(10) NOT NULL,
  `category` enum('admin','front-top','front-bottom','front-middle') NOT NULL DEFAULT 'admin',
  `parent_id` int(10) NOT NULL DEFAULT '0',
  `user_rules_id` int(10) NOT NULL,
  `label` varchar(255) NOT NULL,
  `class` varchar(255) DEFAULT NULL,
  `url` varchar(255) NOT NULL,
  `position` int(10) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0 - inactive, 1 - active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_rules_menu`
--

INSERT INTO `user_rules_menu` (`id`, `category`, `parent_id`, `user_rules_id`, `label`, `class`, `url`, `position`, `status`) VALUES
(1, 'admin', 0, 1, 'Dashboard', 'icon-home', 'site/index', 1, 1),
(2, 'admin', 0, 2, 'Dashboard', 'icon-home', 'site/index', 1, 1),
(3, 'admin', 0, 3, 'Manage Users', 'icon-user', 'users/index', 2, 1),
(4, 'admin', 0, 4, 'Manage Users', 'icon-user', 'users/index', 2, 1),
(5, 'admin', 0, 5, 'Manage Restaurants', 'icon-user', 'restaurants/index', 3, 1),
(6, 'admin', 0, 6, 'Manage Restaurants', 'icon-user', 'restaurants/index', 3, 1),
(7, 'admin', 0, 7, 'Manage Restaurants Types', 'icon-user', 'restaurant-type/index', 2, 1),
(8, 'admin', 0, 8, 'Manage Restaurants Types', 'icon-user', 'restaurant-type/index', 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `device_details`
--
ALTER TABLE `device_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `email_format`
--
ALTER TABLE `email_format`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_categories`
--
ALTER TABLE `menu_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurant_gallery`
--
ALTER TABLE `restaurant_gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_restuarant_id` (`restaurant_id`);

--
-- Indexes for table `restaurant_menu`
--
ALTER TABLE `restaurant_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `restaurant_id` (`restaurant_id`),
  ADD KEY `menu_category_id` (`menu_category_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `restaurant_id_2` (`restaurant_id`),
  ADD KEY `menu_category_id_2` (`menu_category_id`),
  ADD KEY `created_by_2` (`created_by`),
  ADD KEY `updated_by_2` (`updated_by`);

--
-- Indexes for table `restaurant_type`
--
ALTER TABLE `restaurant_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurant_working_hours`
--
ALTER TABLE `restaurant_working_hours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `restaurant_id` (`restaurant_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-users-role_id` (`role_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `user_address`
--
ALTER TABLE `user_address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_rules`
--
ALTER TABLE `user_rules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `user_rules_menu`
--
ALTER TABLE `user_rules_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_rules_id` (`user_rules_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `device_details`
--
ALTER TABLE `device_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT for table `email_format`
--
ALTER TABLE `email_format`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `menu_categories`
--
ALTER TABLE `menu_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `restaurant_gallery`
--
ALTER TABLE `restaurant_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `restaurant_menu`
--
ALTER TABLE `restaurant_menu`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `restaurant_type`
--
ALTER TABLE `restaurant_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `restaurant_working_hours`
--
ALTER TABLE `restaurant_working_hours`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `user_address`
--
ALTER TABLE `user_address`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user_rules`
--
ALTER TABLE `user_rules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `user_rules_menu`
--
ALTER TABLE `user_rules_menu`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `device_details`
--
ALTER TABLE `device_details`
  ADD CONSTRAINT `fk_userid` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `restaurant_gallery`
--
ALTER TABLE `restaurant_gallery`
  ADD CONSTRAINT `fk_restaurant_id` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `restaurant_menu`
--
ALTER TABLE `restaurant_menu`
  ADD CONSTRAINT `created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `menu_category` FOREIGN KEY (`menu_category_id`) REFERENCES `menu_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `restaurant` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `restaurant_working_hours`
--
ALTER TABLE `restaurant_working_hours`
  ADD CONSTRAINT `fk_restaurant` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_role_id` FOREIGN KEY (`role_id`) REFERENCES `user_roles` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `user_address`
--
ALTER TABLE `user_address`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
