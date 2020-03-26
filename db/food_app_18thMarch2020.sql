-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 18, 2020 at 12:48 PM
-- Server version: 5.7.29-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.3

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
(70, 30, 'fIWU-c9XH3k:APA91bFqKmvP3_rCb0Z1Kvi7Bqam-Z7hGKnEAP6vUdQ83GmTsV6UF0yeEXFuxdj5vl4o4BPGntfPSwyWG7GYPs69bRMWMV1XyIGjM1c-9b7wRNq198GtdkzHbOZDaYj4mcuEeIfdbW9t', '1', '', '2020-03-16 11:00:15'),
(73, 33, '', '1', '', '2020-03-17 10:13:14'),
(78, 35, '', '1', '', '2020-03-18 09:04:38'),
(80, 32, 'cAHnMpndUSE:APA91bFURgpH-kwZERhOWdpsI5g59cTU5f8VKpSSbN2NimyzjW2isJUdpzsQfmfMhqO3eiRmon15YSBS9dHZEnh9KVw2m6LO0dV5LvlzkXdbrzd5AkaNM-xI5mY4nWcuhp-x7le02x_f', '1', NULL, '2020-03-18 12:33:57'),
(81, 36, '123456', '1', '', '2020-03-18 09:26:37'),
(82, 37, 'fYL0R5eyRi4:APA91bGnWKWpPm1b57Axs23331h05I9z0heBBs0C78JmjG_poKPsSCpofsWPVo_QhrcMgB-zoh9ZQv6-ImF36SLxmf5HA4WNYcc3rMyamJ4jMas0TG2M3nGEcGg1-m75zDDrRnqXkZDh', '1', '', '2020-03-18 11:39:44'),
(84, 34, '123456', '1', NULL, '2020-03-18 12:06:25');

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
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `id` bigint(20) NOT NULL,
  `restaurant_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `rating` float NOT NULL,
  `review_note` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `feedbacks`
--

INSERT INTO `feedbacks` (`id`, `restaurant_id`, `user_id`, `rating`, `review_note`, `created_at`, `updated_at`) VALUES
(6, 1, 34, 4, 'This is Good Restaurant location wise. Food is good quality.', '2020-03-18 06:36:26', '2020-03-18 06:36:26'),
(7, 3, 34, 3, 'This is Good Restaurant location wise. Food is good quality.', '2020-03-18 06:37:05', '2020-03-18 06:37:05'),
(8, 4, 34, 1, 'This is Good Restaurant location wise. Food is good quality.', '2020-03-18 06:37:11', '2020-03-18 06:37:11');

-- --------------------------------------------------------

--
-- Table structure for table `menu_categories`
--

CREATE TABLE `menu_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `restaurant_id` bigint(20) NOT NULL,
  `status` tinyint(6) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menu_categories`
--

INSERT INTO `menu_categories` (`id`, `name`, `description`, `restaurant_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'pizza', 'pizza', 1, 1, '2020-02-20 10:33:53', '2020-02-20 10:41:53'),
(2, 'Burger', ' Burger', 1, 1, '2020-02-20 10:35:38', '2020-02-20 10:42:39'),
(3, 'Fast food', 'fast food', 3, 1, '2020-02-20 10:48:03', '2020-02-20 10:48:03'),
(5, 'Salad', 'Salads', 3, 1, '2020-02-20 10:49:22', '2020-02-20 10:49:33'),
(6, 'veg', 'veg', 4, 1, '2020-02-20 12:30:57', '2020-02-20 12:30:57'),
(7, 'Soups', 'Soups', 4, 1, '2020-02-20 12:31:16', '2020-02-20 12:31:16');

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
-- Table structure for table `notification_list`
--

CREATE TABLE `notification_list` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `body` text,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notification_list`
--

INSERT INTO `notification_list` (`id`, `user_id`, `title`, `body`, `status`, `created_at`, `updated_at`) VALUES
(2, 32, 'First Notification', 'First Notification Body', 1, '2019-09-25 07:11:51', '2019-09-25 07:22:03'),
(3, 32, 'Second Notification', 'Second Notification Body', 1, '2019-09-25 07:11:51', '2019-09-25 07:22:03'),
(4, 32, 'Third Notification', 'Third Notification Body', 1, '2019-09-25 07:11:51', '2019-09-25 07:22:03');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `payment_type` enum('1','2') NOT NULL,
  `total_amount` float DEFAULT NULL,
  `delivery_charges` float NOT NULL,
  `other_charges` double NOT NULL,
  `user_address_id` bigint(20) NOT NULL,
  `status` tinyint(6) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `payment_type`, `total_amount`, `delivery_charges`, `other_charges`, `user_address_id`, `status`, `created_at`, `updated_at`) VALUES
(16, 32, '1', 369, 20, 30, 10, 5, '2020-03-16 12:05:55', '2020-03-17 14:40:06'),
(17, 32, '1', 369, 20, 30, 10, 2, '2020-03-16 12:06:00', '2020-03-17 14:40:14'),
(18, 32, '1', 369, 20, 30, 10, 2, '2020-03-16 12:06:02', '2020-03-17 14:40:20');

-- --------------------------------------------------------

--
-- Table structure for table `order_menus`
--

CREATE TABLE `order_menus` (
  `id` bigint(20) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `restaurant_id` bigint(20) NOT NULL,
  `menu_id` bigint(20) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` float NOT NULL,
  `menu_total` float NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_menus`
--

INSERT INTO `order_menus` (`id`, `order_id`, `restaurant_id`, `menu_id`, `quantity`, `price`, `menu_total`, `created_at`, `updated_at`) VALUES
(28, 16, 1, 1, 3, 23, 69, '2020-03-16 12:05:55', '2020-03-16 12:05:55'),
(29, 16, 1, 4, 2, 150, 300, '2020-03-16 12:05:55', '2020-03-16 12:05:55'),
(30, 17, 1, 1, 3, 23, 69, '2020-03-16 12:06:00', '2020-03-16 12:06:00'),
(31, 17, 1, 4, 2, 150, 300, '2020-03-16 12:06:00', '2020-03-16 12:06:00'),
(32, 18, 1, 1, 3, 23, 69, '2020-03-16 12:06:02', '2020-03-16 12:06:02'),
(33, 18, 1, 4, 2, 150, 300, '2020-03-16 12:06:02', '2020-03-16 12:06:02');

-- --------------------------------------------------------

--
-- Table structure for table `order_payment`
--

CREATE TABLE `order_payment` (
  `id` bigint(20) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_payment`
--

INSERT INTO `order_payment` (`id`, `order_id`, `transaction_id`, `created_at`, `updated_at`) VALUES
(13, 16, 'HYU899909098', '2020-03-16 12:05:55', '2020-03-16 12:05:55'),
(14, 17, 'HYU899909098', '2020-03-16 12:06:00', '2020-03-16 12:06:00'),
(15, 18, 'HYU899909098', '2020-03-16 12:06:02', '2020-03-16 12:06:02');

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
  `area` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `pincode` int(11) DEFAULT NULL,
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

--
-- Dumping data for table `restaurants`
--

INSERT INTO `restaurants` (`id`, `name`, `description`, `restaurant_type`, `area`, `city`, `address`, `pincode`, `lattitude`, `longitude`, `website`, `contact_no`, `photo`, `avg_cost_for_two`, `status`, `is_deleted`, `created_by`, `updated_by`, `created_at`, `updated_at`, `email`) VALUES
(1, 'The Patang Hotel', 'The Patang Hotel', '2,3,4,5,6,7', 'Ellisbridge', 'Ahemdabad', 'ahmedabad', 380054, 23.0262, 72.57, 'patanghotel.blogspot.com', 7926586300, 'ab1_5e05d9b7cfcb4.png', 1000, 1, '0', 1, 1, '2019-12-20 11:00:21', '2020-02-25 11:17:26', 'testingforproject0@gmail.com'),
(3, 'TGB', 'TGB', '2,3,4', 'Pakwan', 'Ahmedabad', 'ahmedabad', 380054, 23.0262, 72.57, 'tgb.blogspot.com', 7926586300, 't2_5e05d9c485ab1.jpg', 1000, 1, '0', 1, 1, '2019-12-20 11:00:21', '2020-02-25 11:17:33', 'testingforproject0@gmail.com'),
(4, 'Pakwan Restaurant', 'Pure Veg Gujarati Restaurant', '1,13', 'Bodakdev', 'ahmedabad', 'ahmedabad', 380054, 23.0381, 72.5124, 'www.pakwan.com', 7926873290, 'g4_5e05d9a184569.jpg', 1500, 1, '0', 1, 1, '2019-12-27 10:14:57', '2020-02-25 11:18:14', 'testingforproject0@gmail.com');

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

--
-- Dumping data for table `restaurant_gallery`
--

INSERT INTO `restaurant_gallery` (`id`, `restaurant_id`, `image_title`, `image_description`, `image_name`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(6, 1, 'test', 'test', 'gg2_5e4e953f86dde.jpg', 1, 1, 1, '2020-02-20 14:18:39', '2020-02-20 14:18:39'),
(7, 1, 'test2', 'test2', 'gg3_5e4e95fd1b888.jpg', 1, 1, 1, '2020-02-20 14:21:49', '2020-02-20 14:21:49');

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

--
-- Dumping data for table `restaurant_menu`
--

INSERT INTO `restaurant_menu` (`id`, `restaurant_id`, `name`, `description`, `menu_category_id`, `price`, `photo`, `created_by`, `updated_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'pizza1', 'pizza1', 1, 23, 'Sports_5e4e7877da933.png', 1, 1, 1, '2020-02-20 12:15:51', '2020-02-20 12:21:43'),
(2, 1, 'pizza2', 'pizza2', 1, 500, 'g3_5e4e7a0829349.jpg', 1, 1, 1, '2020-02-20 12:22:32', '2020-02-20 12:22:32'),
(3, 1, 'Cheesy Burger', 'Cheesy Burger', 2, 200, 's2_5e4e7a6acc8e8.jpg', 1, 1, 1, '2020-02-20 12:24:10', '2020-02-20 12:24:10'),
(4, 1, 'Cheesy Burger1', 'Cheesy Burger1', 2, 150, 'dd2_5e4e7a8d29528.jpg', 1, 1, 1, '2020-02-20 12:24:45', '2020-02-20 12:24:45'),
(5, 4, 'Veg Pulav', 'Veg Pulav', 6, 200, 'ab3_5e4e7c30e8329.jpg', 1, 1, 1, '2020-02-20 12:31:44', '2020-02-20 12:31:44'),
(6, 4, 'Hot & Sour Soup', 'Hot & Sour Soup', 7, 200, 'g1_5e4e7c5541f57.jpg', 1, 1, 1, '2020-02-20 12:32:21', '2020-02-20 12:32:33');

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
-- Table structure for table `special_offers`
--

CREATE TABLE `special_offers` (
  `id` bigint(20) NOT NULL,
  `restaurant_id` varchar(255) NOT NULL,
  `discount` int(11) NOT NULL,
  `coupan_code` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `special_offers`
--

INSERT INTO `special_offers` (`id`, `restaurant_id`, `discount`, `coupan_code`, `photo`, `from_date`, `to_date`, `created_at`, `updated_at`) VALUES
(1, '4,3,1', 50, 'HJK90', 'g1_5e4e89a7dce92.jpg', '2020-02-20', '2020-03-19', '2020-02-20 13:29:11', '2020-03-18 06:31:36'),
(2, '4,1', 40, 'HJK91', 'sap_5e4e8c5cde9fa.png', '2020-02-20', '2020-03-20', '2020-02-20 13:40:44', '2020-02-20 13:58:04'),
(3, '4,3,1', 70, 'YH89', 'Tools_5e71c06de2b4a.png', '2020-03-18', '2020-03-25', '2020-03-18 06:32:13', '2020-03-18 06:32:13'),
(4, '4,3,1', 80, 'JKIJ89', 'Tools_5e71c096b3006.png', '2020-03-18', '2020-03-20', '2020-03-18 06:32:54', '2020-03-18 06:32:54');

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
(30, 3, 'rutusha_joshi', 'rutusha.joshi@zenocraft.com', '7488e331b8b64e5794da3fa4eb10ad5d', 98765432106, NULL, '577f02419314a9c1a5cfb7e7b0535bd41811da0c9b4d9865a956e036884376fa', '0', NULL, '6edad9d4732f74a4c3c8368a8e9ffb15', NULL, 1, 1, '2020-03-06 06:19:02', '2020-03-06 06:19:02', NULL),
(32, 3, 'vyas dipak', 'vyasdipak991@gmail.com', '7488e331b8b64e5794da3fa4eb10ad5d', 9974711674, 'https://lh3.googleusercontent.com/a-/AOh14GjZ4BWXo7HwC-FBTPb0CqJWnV4CFP9EQI8-A3vKpQ=s96-c', '5cd37d93fd6e3c2cb4a0516e40b47f47932a72914471a04c916d027fe9403975', '1', '-_IIlwB6ylPMhq6fFgBP9kDBrY5sb0kM_1584343786', 'c0dba47e17d90e398d26c6e1985bc870', NULL, 3, 1, '2020-03-16 06:44:24', '2020-03-18 12:33:57', NULL),
(33, 3, 'rishi', 'rishi.vekaria@zenocraft.com', 'e10adc3949ba59abbe56e057f20f883e', 9033999975, NULL, 'e4e310f982fa04c9f1cae9d74bd1105edafcf06a6580c0a49d1c5b0baf2ddf0b', '0', NULL, '890724f220ca7f43cd7fecf716b31133', NULL, 1, 1, '2020-03-17 10:13:14', '2020-03-17 10:13:14', NULL),
(34, 3, 'Rishi V', 'rishi.vekariya@zenocraft.com', 'e10adc3949ba59abbe56e057f20f883e', 9033999976, NULL, 'a5f38c7be3c23294d20731686949cfafb07c2a327f1250cfc322d9611f3b015b', '1', NULL, '96f56867e373627646bbe6d5c7d3f1df', NULL, 1, 1, '2020-03-17 10:22:23', '2020-03-18 12:06:25', NULL),
(35, 3, 'Rishi y', 'rishi.vekariya1@zenocraft.com', 'e10adc3949ba59abbe56e057f20f883e', 9033999973, NULL, '284cb5f1ebfec138f7afe708fff153d7ce6fc73f2186f3a222c9f17b3c746c94', '0', NULL, '19bddf469a362aab8d58744643f3ec5d', NULL, 1, 1, '2020-03-18 09:04:38', '2020-03-18 09:04:38', NULL),
(36, 3, 'rocky', 'rocky@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1234567890, '16ada05214aa9a815c6159c4ab55799469600.jpeg', '2e92ea062208cf7b7c3c827a3b1d90bd8f93cd4b974001090223d5a25211a7e1', '0', NULL, 'ab1fad9d58003324648a69418e15bf70', NULL, 1, 1, '2020-03-18 09:26:37', '2020-03-18 09:26:37', NULL),
(37, 3, 'Monty', 'monty@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 123123123, '16ada05214aa9a815c6159c4ab55799417572.jpeg', 'ece4eb38998a2f5289a5c4a4a593ecab3bf21565f78b50e5efd24078d544e3b4', '1', NULL, 'f1a9aa32922fdab7c148f5aeac873d2d', NULL, 1, 1, '2020-03-18 09:28:32', '2020-03-18 11:39:44', NULL),
(38, 3, 'Mobil', 'monil@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 123456789, '16ada05214aa9a815c6159c4ab55799434066.jpeg', '11169599d6be22b990e5e8e9aa682a4a5410daae6c23de48599e4684f46f00fe', '0', NULL, '', NULL, 1, 1, '2020-03-18 09:34:51', '2020-03-18 09:36:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_address`
--

CREATE TABLE `user_address` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `address` text,
  `address_type` varchar(255) DEFAULT NULL,
  `is_default` enum('0','1') NOT NULL DEFAULT '0',
  `area` varchar(255) DEFAULT NULL,
  `lat` float DEFAULT NULL,
  `long` float DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_address`
--

INSERT INTO `user_address` (`id`, `user_id`, `address`, `address_type`, `is_default`, `area`, `lat`, `long`, `created_at`, `updated_at`) VALUES
(10, 32, 'zenosys services', 'Work', '1', 'Sola', 23.0607, 72.5188, '2020-03-16 12:04:53', '2020-03-16 12:04:53'),
(11, 37, 'tttt', 'Home', '1', 'Sola', 23.0607, 72.5188, '2020-03-18 11:43:26', '2020-03-18 11:43:26');

-- --------------------------------------------------------

--
-- Table structure for table `user_favourite_orders`
--

CREATE TABLE `user_favourite_orders` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_favourite_orders`
--

INSERT INTO `user_favourite_orders` (`id`, `user_id`, `order_id`, `created_at`, `updated_at`) VALUES
(7, 32, 17, '2020-03-16 13:51:22', '2020-03-16 13:51:22');

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
(8, 2, 'restaurant-typeController', 'index,create,update,view,delete', 'allow', 'Restaurant admin'),
(9, 1, 'special-offersController', 'index,create,update,view,delete', 'allow', 'Super admin'),
(10, 2, 'special-offersController', 'index,create,update,view,delete', 'allow', 'admin'),
(11, 2, 'menu-categoriesController', 'index,create,update,view,delete', 'allow', 'admin'),
(12, 1, 'menu-categoriesController', 'index,create,update,view,delete', 'allow', 'super_admin'),
(13, 1, 'restaurant-menuController', 'index,create,update,view,delete', 'allow', 'Super admin'),
(14, 2, 'restaurant-menuController', 'index,create,update,view,delete', 'allow', 'admin'),
(15, 2, 'restaurants-galleryController', 'index,create,update,view,delete', 'allow', 'admin'),
(16, 1, 'restaurants-galleryController', 'index,create,update,view,delete', 'allow', 'super_admin'),
(17, 1, 'ordersController', 'index,create,update,view,delete,accept-order', 'allow', 'super_admin'),
(18, 2, 'ordersController', 'index,create,update,view,delete,accept-order', 'allow', 'admin'),
(19, 1, 'order-menusController', 'index', 'allow', 'super_admin'),
(20, 2, 'order-menusController', 'index', 'allow', 'admin');

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
(8, 'admin', 0, 8, 'Manage Restaurants Types', 'icon-user', 'restaurant-type/index', 2, 1),
(9, 'admin', 0, 9, 'Manage Special Offers', 'icon-user', 'special-offers/index', 4, 1),
(10, 'admin', 0, 10, 'Manage Special Offers', 'icon-user', 'special-offers/index', 4, 1),
(11, 'admin', 0, 17, 'Manage Orders', 'icon-user', 'orders/index', 5, 1),
(12, 'admin', 0, 18, 'Manage Orders', 'icon-user', 'orders/index', 5, 1);

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
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `restaurant_id` (`restaurant_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `menu_categories`
--
ALTER TABLE `menu_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `restaurant_id` (`restaurant_id`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `notification_list`
--
ALTER TABLE `notification_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `user_address_id` (`user_address_id`);

--
-- Indexes for table `order_menus`
--
ALTER TABLE `order_menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `menu_id` (`menu_id`),
  ADD KEY `restaurant_id` (`restaurant_id`);

--
-- Indexes for table `order_payment`
--
ALTER TABLE `order_payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

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
-- Indexes for table `special_offers`
--
ALTER TABLE `special_offers`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `user_favourite_orders`
--
ALTER TABLE `user_favourite_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `order_id` (`order_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;
--
-- AUTO_INCREMENT for table `email_format`
--
ALTER TABLE `email_format`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `menu_categories`
--
ALTER TABLE `menu_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `notification_list`
--
ALTER TABLE `notification_list`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `order_menus`
--
ALTER TABLE `order_menus`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `order_payment`
--
ALTER TABLE `order_payment`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `restaurant_gallery`
--
ALTER TABLE `restaurant_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `restaurant_menu`
--
ALTER TABLE `restaurant_menu`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
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
-- AUTO_INCREMENT for table `special_offers`
--
ALTER TABLE `special_offers`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `user_address`
--
ALTER TABLE `user_address`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `user_favourite_orders`
--
ALTER TABLE `user_favourite_orders`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user_rules`
--
ALTER TABLE `user_rules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `user_rules_menu`
--
ALTER TABLE `user_rules_menu`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `device_details`
--
ALTER TABLE `device_details`
  ADD CONSTRAINT `fk_userid` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD CONSTRAINT `restaurant_id` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `menu_categories`
--
ALTER TABLE `menu_categories`
  ADD CONSTRAINT `rest_cat_fk` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notification_list`
--
ALTER TABLE `notification_list`
  ADD CONSTRAINT `user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `buyer_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_menus`
--
ALTER TABLE `order_menus`
  ADD CONSTRAINT `menu_fk` FOREIGN KEY (`menu_id`) REFERENCES `restaurant_menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_id_fk` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `restaurant_id_fk` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_payment`
--
ALTER TABLE `order_payment`
  ADD CONSTRAINT `order_fk` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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

--
-- Constraints for table `user_favourite_orders`
--
ALTER TABLE `user_favourite_orders`
  ADD CONSTRAINT `ordersss_fk` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
