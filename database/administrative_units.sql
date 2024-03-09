-- -------------------------------------------------------------
-- TablePlus 5.3.8(500)
--
-- https://tableplus.com/
--
-- Database: uudam_dev_local
-- Generation Time: 2024-03-09 10:32:46.7700
-- -------------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


DROP TABLE IF EXISTS `administrative_units`;
CREATE TABLE `administrative_units` (
  `id` int NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `full_name_en` varchar(255) DEFAULT NULL,
  `short_name` varchar(255) DEFAULT NULL,
  `short_name_en` varchar(255) DEFAULT NULL,
  `code_name` varchar(255) DEFAULT NULL,
  `code_name_en` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `administrative_units` (`id`, `full_name`, `full_name_en`, `short_name`, `short_name_en`, `code_name`, `code_name_en`) VALUES
(1, 'Thành phố trực thuộc trung ương', 'Municipality', 'Thành phố', 'City', 'thanh_pho_truc_thuoc_trung_uong', 'municipality'),
(2, 'Tỉnh', 'Province', 'Tỉnh', 'Province', 'tinh', 'province'),
(3, 'Thành phố thuộc thành phố trực thuộc trung ương', 'Municipal city', 'Thành phố', 'City', 'thanh_pho_thuoc_thanh_pho_truc_thuoc_trung_uong', 'municipal_city'),
(4, 'Thành phố thuộc tỉnh', 'Provincial city', 'Thành phố', 'City', 'thanh_pho_thuoc_tinh', 'provincial_city'),
(5, 'Quận', 'Urban district', 'Quận', 'District', 'quan', 'urban_district'),
(6, 'Thị xã', 'District-level town', 'Thị xã', 'Town', 'thi_xa', 'district_level_town'),
(7, 'Huyện', 'District', 'Huyện', 'District', 'huyen', 'district'),
(8, 'Phường', 'Ward', 'Phường', 'Ward', 'phuong', 'ward'),
(9, 'Thị trấn', 'Commune-level town', 'Thị trấn', 'Township', 'thi_tran', 'commune_level_town'),
(10, 'Xã', 'Commune', 'Xã', 'Commune', 'xa', 'commune');


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;