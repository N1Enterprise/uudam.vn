-- -------------------------------------------------------------
-- TablePlus 5.1.0(469)
--
-- https://tableplus.com/
--
-- Database: mr_terragon_flagship
-- Generation Time: 2022-11-10 14:17:56.5310
-- -------------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


INSERT INTO `currencies` (`id`, `type`, `name`, `code`, `symbol`, `decimals`, `status`, `used_countries`, `created_at`, `updated_at`) VALUES
(1, 1, 'Antarctican dollar', 'AAD', '$', 2, 1, '[\"AQ\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(2, 1, 'United Arab Emirates dirham', 'AED', 'إ.د', 2, 1, '[\"AE\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(3, 1, 'Afghan afghani', 'AFN', '؋', 2, 1, '[\"AF\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(4, 1, 'Albanian lek', 'ALL', 'Lek', 2, 1, '[\"AL\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(5, 1, 'Armenian dram', 'AMD', '֏', 2, 1, '[\"AM\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(6, 1, 'Netherlands Antillean guilder', 'ANG', 'ƒ', 2, 1, '[\"CW\", \"SX\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(7, 1, 'Angolan kwanza', 'AOA', 'Kz', 2, 1, '[\"AO\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(8, 1, 'Argentine peso', 'ARS', '$', 2, 1, '[\"AR\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(9, 1, 'Australian dollar', 'AUD', '$', 2, 1, '[\"AU\", \"CX\", \"CC\", \"HM\", \"KI\", \"NR\", \"NF\", \"TV\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(10, 1, 'Aruban florin', 'AWG', 'ƒ', 2, 1, '[\"AW\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(11, 1, 'Azerbaijani manat', 'AZN', 'm', 2, 1, '[\"AZ\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(12, 1, 'Bosnia and Herzegovina convertible mark', 'BAM', 'KM', 2, 1, '[\"BA\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(13, 1, 'Barbadian dollar', 'BBD', 'Bds$', 2, 1, '[\"BB\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(14, 1, 'Bangladeshi taka', 'BDT', '৳', 2, 1, '[\"BD\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(15, 1, 'Bulgarian lev', 'BGN', 'Лв.', 2, 1, '[\"BG\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(16, 1, 'Bahraini dinar', 'BHD', '.د.ب', 3, 1, '[\"BH\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(17, 1, 'Burundian franc', 'BIF', 'FBu', 2, 1, '[\"BI\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(18, 1, 'Bermudian dollar', 'BMD', '$', 2, 1, '[\"BM\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(19, 1, 'Brunei dollar', 'BND', 'B$', 2, 1, '[\"BN\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(20, 1, 'Bolivian boliviano', 'BOB', 'Bs.', 2, 1, '[\"BO\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(21, 1, 'Brazilian real', 'BRL', 'R$', 2, 1, '[\"BR\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(22, 1, 'Bahamian dollar', 'BSD', 'B$', 2, 1, '[\"BS\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(23, 1, 'Bhutanese ngultrum', 'BTN', 'Nu.', 2, 1, '[\"BT\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(24, 1, 'Botswana pula', 'BWP', 'P', 2, 1, '[\"BW\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(25, 1, 'Belarusian ruble', 'BYN', 'Br', 2, 1, '[\"BY\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(26, 1, 'Belize dollar', 'BZD', '$', 2, 1, '[\"BZ\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(27, 1, 'Canadian dollar', 'CAD', '$', 2, 1, '[\"CA\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(28, 1, 'Congolese Franc', 'CDF', 'FC', 2, 1, '[\"CD\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(29, 1, 'Swiss franc', 'CHF', 'CHf', 2, 1, '[\"LI\", \"CH\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(30, 1, 'Chilean peso', 'CLP', '$', 2, 1, '[\"CL\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(31, 1, 'Chinese yuan', 'CNY', '¥', 2, 1, '[\"CN\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(32, 1, 'Colombian peso', 'COP', '$', 2, 1, '[\"CO\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(33, 1, 'Costa Rican colón', 'CRC', '₡', 2, 1, '[\"CR\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(34, 1, 'Cuban peso', 'CUP', '$', 2, 1, '[\"CU\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(35, 1, 'Cape Verdean escudo', 'CVE', '$', 0, 1, '[\"CV\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(36, 1, 'Czech koruna', 'CZK', 'Kč', 2, 1, '[\"CZ\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(37, 1, 'Djiboutian franc', 'DJF', 'Fdj', 0, 1, '[\"DJ\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(38, 1, 'Danish krone', 'DKK', 'Kr.', 2, 1, '[\"DK\", \"FO\", \"GL\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(39, 1, 'Dominican peso', 'DOP', '$', 2, 1, '[\"DO\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(40, 1, 'Algerian dinar', 'DZD', 'دج', 2, 1, '[\"DZ\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(41, 1, 'Egyptian pound', 'EGP', 'ج.م', 2, 1, '[\"EG\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(42, 1, 'Eritrean nakfa', 'ERN', 'Nfk', 2, 1, '[\"ER\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(43, 1, 'Ethiopian birr', 'ETB', 'Nkf', 2, 1, '[\"ET\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(44, 1, 'Euro', 'EUR', '€', 2, 1, '[\"AX\", \"AD\", \"AT\", \"BE\", \"CY\", \"EE\", \"FI\", \"FR\", \"GF\", \"TF\", \"DE\", \"GR\", \"GP\", \"IE\", \"IT\", \"LV\", \"LT\", \"LU\", \"MT\", \"MQ\", \"YT\", \"MC\", \"ME\", \"NL\", \"PT\", \"RE\", \"PM\", \"BL\", \"MF\", \"SM\", \"SK\", \"SI\", \"ES\", \"VA\", \"XK\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(45, 1, 'Fijian dollar', 'FJD', 'FJ$', 2, 1, '[\"FJ\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(46, 1, 'Falkland Islands pound', 'FKP', '£', 2, 1, '[\"FK\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(47, 1, 'British pound', 'GBP', '£', 2, 1, '[\"GG\", \"JE\", \"IM\", \"GS\", \"GB\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(48, 1, 'Georgian lari', 'GEL', 'ლ', 2, 1, '[\"GE\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(49, 1, 'Ghanaian cedi', 'GHS', 'GH₵', 2, 1, '[\"GH\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(50, 1, 'Gibraltar pound', 'GIP', '£', 2, 1, '[\"GI\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(51, 1, 'Gambian dalasi', 'GMD', 'D', 2, 1, '[\"GM\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(52, 1, 'Guinean franc', 'GNF', 'FG', 0, 1, '[\"GN\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(53, 1, 'Guatemalan quetzal', 'GTQ', 'Q', 2, 1, '[\"GT\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(54, 1, 'Guyanese dollar', 'GYD', '$', 2, 1, '[\"GY\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(55, 1, 'Hong Kong dollar', 'HKD', '$', 2, 1, '[\"HK\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(56, 1, 'Honduran lempira', 'HNL', 'L', 2, 1, '[\"HN\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(57, 1, 'Croatian kuna', 'HRK', 'kn', 2, 1, '[\"HR\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(58, 1, 'Haitian gourde', 'HTG', 'G', 2, 1, '[\"HT\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(59, 1, 'Hungarian forint', 'HUF', 'Ft', 2, 1, '[\"HU\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(60, 1, 'Indonesian rupiah', 'IDR', 'Rp', 0, 1, '[\"ID\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(61, 1, 'Israeli new shekel', 'ILS', '₪', 2, 1, '[\"IL\", \"PS\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(62, 1, 'Indian rupee', 'INR', '₹', 2, 1, '[\"IN\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(63, 1, 'Iraqi dinar', 'IQD', 'د.ع', 3, 1, '[\"IQ\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(64, 1, 'Iranian rial', 'IRR', '﷼', 2, 1, '[\"IR\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(65, 1, 'Icelandic króna', 'ISK', 'kr', 0, 1, '[\"IS\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(66, 1, 'Jamaican dollar', 'JMD', 'J$', 2, 1, '[\"JM\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(67, 1, 'Jordanian dinar', 'JOD', 'ا.د', 3, 1, '[\"JO\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(68, 1, 'Japanese yen', 'JPY', '¥', 0, 1, '[\"JP\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(69, 1, 'Kenyan shilling', 'KES', 'KSh', 2, 1, '[\"KE\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(70, 1, 'Kyrgyzstani som', 'KGS', 'лв', 2, 1, '[\"KG\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(71, 1, 'Cambodian riel', 'KHR', 'KHR', 2, 1, '[\"KH\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(72, 1, 'Comorian franc', 'KMF', 'CF', 0, 1, '[\"KM\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(73, 1, 'North Korean Won', 'KPW', '₩', 2, 1, '[\"KP\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(74, 1, 'Won', 'KRW', '₩', 0, 1, '[\"KR\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(75, 1, 'Kuwaiti dinar', 'KWD', 'ك.د', 3, 1, '[\"KW\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(76, 1, 'Cayman Islands dollar', 'KYD', '$', 2, 1, '[\"KY\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(77, 1, 'Kazakhstani tenge', 'KZT', 'лв', 2, 1, '[\"KZ\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(78, 1, 'Lao kip', 'LAK', '₭', 2, 1, '[\"LA\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(79, 1, 'Lebanese pound', 'LBP', '£', 2, 1, '[\"LB\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(80, 1, 'Sri Lankan rupee', 'LKR', 'Rs', 2, 1, '[\"LK\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(81, 1, 'Liberian dollar', 'LRD', '$', 2, 1, '[\"LR\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(82, 1, 'Lesotho loti', 'LSL', 'L', 2, 1, '[\"LS\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(83, 1, 'Libyan dinar', 'LYD', 'د.ل', 3, 1, '[\"LY\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(84, 1, 'Moroccan dirham', 'MAD', 'DH', 2, 1, '[\"MA\", \"EH\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(85, 1, 'Moldovan leu', 'MDL', 'L', 2, 1, '[\"MD\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(86, 1, 'Malagasy ariary', 'MGA', 'Ar', 2, 1, '[\"MG\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(87, 1, 'Denar', 'MKD', 'ден', 2, 1, '[\"MK\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(88, 1, 'Burmese kyat', 'MMK', 'K', 2, 1, '[\"MM\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(89, 1, 'Mongolian tögrög', 'MNT', '₮', 2, 1, '[\"MN\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(90, 1, 'Macanese pataca', 'MOP', '$', 2, 1, '[\"MO\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(91, 1, 'Mauritanian ouguiya', 'MRO', 'MRU', 2, 1, '[\"MR\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(92, 1, 'Mauritian rupee', 'MUR', '₨', 2, 1, '[\"MU\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(93, 1, 'Maldivian rufiyaa', 'MVR', 'Rf', 2, 1, '[\"MV\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(94, 1, 'Malawian kwacha', 'MWK', 'MK', 2, 1, '[\"MW\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(95, 1, 'Mexican peso', 'MXN', '$', 2, 1, '[\"MX\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(96, 1, 'Malaysian ringgit', 'MYR', 'RM', 2, 1, '[\"MY\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(97, 1, 'Mozambican metical', 'MZN', 'MT', 2, 1, '[\"MZ\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(98, 1, 'Namibian dollar', 'NAD', '$', 2, 1, '[\"NA\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(99, 1, 'Nigerian naira', 'NGN', '₦', 2, 1, '[\"NG\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(100, 1, 'Nicaraguan córdoba', 'NIO', 'C$', 2, 1, '[\"NI\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(101, 1, 'Norwegian Krone', 'NOK', 'kr', 2, 1, '[\"BV\", \"NO\", \"SJ\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(102, 1, 'Nepalese rupee', 'NPR', '₨', 2, 1, '[\"NP\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(103, 1, 'Cook Islands dollar', 'NZD', '$', 2, 1, '[\"CK\", \"NZ\", \"NU\", \"PN\", \"TK\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(104, 1, 'Omani rial', 'OMR', '.ع.ر', 3, 1, '[\"OM\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(105, 1, 'Panamanian balboa', 'PAB', 'B/.', 2, 1, '[\"PA\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(106, 1, 'Peruvian sol', 'PEN', 'S/.', 2, 1, '[\"PE\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(107, 1, 'Papua New Guinean kina', 'PGK', 'K', 2, 1, '[\"PG\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(108, 1, 'Philippine peso', 'PHP', '₱', 2, 1, '[\"PH\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(109, 1, 'Pakistani rupee', 'PKR', '₨', 2, 1, '[\"PK\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(110, 1, 'Polish złoty', 'PLN', 'zł', 2, 1, '[\"PL\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(111, 1, 'Paraguayan guarani', 'PYG', '₲', 0, 1, '[\"PY\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(112, 1, 'Qatari riyal', 'QAR', 'ق.ر', 2, 1, '[\"QA\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(113, 1, 'Romanian leu', 'RON', 'lei', 2, 1, '[\"RO\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(114, 1, 'Serbian dinar', 'RSD', 'din', 2, 1, '[\"RS\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(115, 1, 'Russian ruble', 'RUB', '₽', 2, 1, '[\"RU\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(116, 1, 'Rwandan franc', 'RWF', 'FRw', 0, 1, '[\"RW\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(117, 1, 'Saudi riyal', 'SAR', '﷼', 2, 1, '[\"SA\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(118, 1, 'Solomon Islands dollar', 'SBD', 'Si$', 2, 1, '[\"SB\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(119, 1, 'Seychellois rupee', 'SCR', 'SRe', 2, 1, '[\"SC\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(120, 1, 'Sudanese pound', 'SDG', '.س.ج', 2, 1, '[\"SD\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(121, 1, 'Swedish krona', 'SEK', 'kr', 2, 1, '[\"SE\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(122, 1, 'Singapore dollar', 'SGD', '$', 2, 1, '[\"SG\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(123, 1, 'Saint Helena pound', 'SHP', '£', 2, 1, '[\"SH\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(124, 1, 'Sierra Leonean leone', 'SLL', 'Le', 2, 1, '[\"SL\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(125, 1, 'Somali shilling', 'SOS', 'Sh.so.', 2, 1, '[\"SO\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(126, 1, 'Surinamese dollar', 'SRD', '$', 2, 1, '[\"SR\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(127, 1, 'South Sudanese pound', 'SSP', '£', 2, 1, '[\"SS\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(128, 1, 'Dobra', 'STD', 'Db', 2, 1, '[\"ST\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(129, 1, 'Syrian pound', 'SYP', 'LS', 2, 1, '[\"SY\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(130, 1, 'Lilangeni', 'SZL', 'E', 2, 1, '[\"SZ\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(131, 1, 'Thai baht', 'THB', '฿', 2, 1, '[\"TH\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(132, 1, 'Tajikistani somoni', 'TJS', 'SM', 2, 1, '[\"TJ\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(133, 1, 'Turkmenistan manat', 'TMT', 'T', 2, 1, '[\"TM\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(134, 1, 'Tunisian dinar', 'TND', 'ت.د', 3, 1, '[\"TN\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(135, 1, 'Tongan paʻanga', 'TOP', '$', 2, 1, '[\"TO\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(136, 1, 'Turkish lira', 'TRY', '₺', 2, 1, '[\"TR\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(137, 1, 'Trinidad and Tobago dollar', 'TTD', '$', 2, 1, '[\"TT\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(138, 1, 'New Taiwan dollar', 'TWD', '$', 2, 1, '[\"TW\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(139, 1, 'Tanzanian shilling', 'TZS', 'TSh', 2, 1, '[\"TZ\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(140, 1, 'Ukrainian hryvnia', 'UAH', '₴', 2, 1, '[\"UA\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(141, 1, 'Ugandan shilling', 'UGX', 'USh', 0, 1, '[\"UG\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(142, 1, 'US Dollar', 'USD', '$', 2, 1, '[\"AS\", \"IO\", \"TL\", \"EC\", \"SV\", \"GU\", \"MH\", \"FM\", \"BQ\", \"MP\", \"PW\", \"PR\", \"TC\", \"US\", \"UM\", \"VG\", \"VI\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(143, 1, 'Uruguayan peso', 'UYU', '$', 2, 1, '[\"UY\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(144, 1, 'Uzbekistani soʻm', 'UZS', 'лв', 2, 1, '[\"UZ\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(145, 1, 'Bolívar', 'VEF', 'Bs', 2, 1, '[\"VE\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(146, 1, 'Vietnamese đồng', 'VND', '₫', 0, 1, '[\"VN\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(147, 1, 'Vanuatu vatu', 'VUV', 'VT', 0, 1, '[\"VU\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(148, 1, 'Samoan tālā', 'WST', 'SAT', 2, 1, '[\"WS\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(149, 1, 'Central African CFA franc', 'XAF', 'FCFA', 0, 1, '[\"CM\", \"CF\", \"TD\", \"CG\", \"GQ\", \"GA\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(150, 1, 'East Caribbean dollar', 'XCD', '$', 2, 1, '[\"AI\", \"AG\", \"DM\", \"GD\", \"MS\", \"KN\", \"LC\", \"VC\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(151, 1, 'West African CFA franc', 'XOF', 'CFA', 0, 1, '[\"BJ\", \"BF\", \"CI\", \"GW\", \"ML\", \"NE\", \"SN\", \"TG\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(152, 1, 'CFP franc', 'XPF', '₣', 0, 1, '[\"PF\", \"NC\", \"WF\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(153, 1, 'Yemeni rial', 'YER', '﷼', 2, 1, '[\"YE\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(154, 1, 'South African rand', 'ZAR', 'R', 2, 1, '[\"ZA\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(155, 1, 'Zambian kwacha', 'ZMW', 'ZK', 2, 1, '[\"ZM\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54'),
(156, 1, 'Zimbabwe Dollar', 'ZWL', '$', 2, 1, '[\"ZW\"]', '2022-11-10 07:14:54', '2022-11-10 07:14:54');


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
