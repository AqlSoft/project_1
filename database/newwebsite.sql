-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 20, 2023 at 02:40 PM
-- Server version: 8.0.21
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `newwebsite`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `userName` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `company_name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `userName`, `email`, `password`, `company`, `created_at`, `updated_at`, `company_name`) VALUES
(1, 'Atef Akl', 'admin', 'admin@gmail.com', '$2y$10$ytRz7P/Tw4w.vIGy625kTuCFQFkZmwslxfEVxPf4o4YsEHXp8VIwG', '1', '2022-09-23 12:24:42', '2022-09-23 12:26:03', 'AEICO-KSA');

-- --------------------------------------------------------

--
-- Table structure for table `business_brands`
--

DROP TABLE IF EXISTS `business_brands`;
CREATE TABLE IF NOT EXISTS `business_brands` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `name` char(100) NOT NULL,
  `brief` char(255) DEFAULT NULL,
  `created_by` bigint NOT NULL,
  `updated_by` bigint DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `business_brands`
--

INSERT INTO `business_brands` (`id`, `name`, `brief`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'AEICO', 'Brand Keda', 1, NULL, '2023-01-12 13:08:41', '2023-01-12 13:08:41'),
(2, 'AKLSOFT', 'Modifications', 1, NULL, '2023-01-13 06:19:21', '2023-01-13 06:19:21'),
(3, 'SYNDA', 'erurtiriurtiirut', 1, NULL, '2023-01-13 06:20:25', '2023-01-13 06:20:25'),
(4, 'gateval', 'nono frdk lo', 1, NULL, '2023-01-13 06:24:57', '2023-01-13 06:24:57'),
(10, 'Anderson Negele', 'Established in 1930, Anderson Negele A division of CNRG Energy India Pvt. Ltd. is the leading Manufacturer of Temperature Sensors, Level Sensors, Flow Sensors and much more. Immensely acclaimed in the industry owing to their preciseness.', 1, NULL, '2023-02-12 12:01:33', '2023-02-12 12:01:33');

-- --------------------------------------------------------

--
-- Table structure for table `business_categories`
--

DROP TABLE IF EXISTS `business_categories`;
CREATE TABLE IF NOT EXISTS `business_categories` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `name` char(100) NOT NULL,
  `type` bigint UNSIGNED NOT NULL,
  `parent` tinyint DEFAULT '0',
  `Brief` varchar(5000) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `created_by` bigint NOT NULL,
  `updated_by` bigint DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `business_categories`
--

INSERT INTO `business_categories` (`id`, `name`, `type`, `parent`, `Brief`, `link`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Pipes & Fittings', 1, 0, 'A fitting or adapter is used in pipe systems to connect straight sections of pipe or tube, adapt to different sizes or shapes, and for other purposes such as regulating (or measuring) fluid flow.[1] These fittings are used in plumbing to manipulate the conveyance of water, gas, or liquid waste in domestic or commercial environments, within a system of pipes or tubes.\r\n\r\nFittings (especially uncommon types) require money, time, materials, and tools to install and are an important part of piping and plumbing systems.[2] Valves are technically fittings, but are usually discussed separately. ', 'https://en.wikipedia.org/wiki/Stainless_steel', 1, NULL, '2023-01-16 06:22:07', '2023-01-16 06:22:07'),
(2, 'Valves & Flow Control', 1, 0, 'A valve is a type of fitting that allows for regulation, control, and direction of fluids passing through a pipe. Valves are commonly used to direct flow, shut off water access, prevent backflow, and adjust water pressure within a system. Valves allow homeowners to isolate sections of plumbing for repairs, or shut off a water line when a leak sprouts. They are also widely used throughout most commercial and industrial applications. Wastewater treatment centers, pharmaceutical manufacturers, chemical plants, and automobile production all rely on valves for control and direction of fluids and gasses.     \r\n\r\nThough valves are a type of fitting, they are usually discussed as their own separate, unique category. Each valve operates uniquely, and come in a wide range of styles designed to target specific plumbing needs. Valves are made out of a wide variety of materials, including plastic, lead-free brass, cast iron, stainless steel, and galvanized pipe. This guide is assembled to provide insight into how some of the most common valves work and their distinct advantages and disadvantages. ', 'https://en.wikipedia.org/wiki/Stainless_steel', 1, NULL, '2023-01-16 06:53:18', '2023-01-16 06:53:18'),
(3, 'Carbon Steel', 1, 1, 'Carbon steel is a steel with carbon content from about 0.05 up to 2.1 percent by weight. The definition of carbon steel from the American Iron and Steel Institute (AISI) states:\r\n\r\n    no minimum content is specified or required for chromium, cobalt, molybdenum, nickel, niobium, titanium, tungsten, vanadium, zirconium, or any other element to be added to obtain a desired alloying effect;\r\n    the specified minimum for copper does not exceed 0.40%;\r\n    or the maximum content specified for any of the following elements does not exceed the percentages noted: manganese 1.65%; silicon 0.60%; copper 0.60%.\r\n\r\nThe term carbon steel may also be used in reference to steel which is not stainless steel; in this use carbon steel may include alloy steels. High carbon steel has many different uses such as milling machines, cutting tools (such as chisels) and high strength wires. These applications require a much finer microstructure, which improves the toughness.\r\n\r\nCarbon steel is a popular metal choice for knife-making due to its high amount of carbon, giving the blade more edge retention. To make the most out of this type of steel it is very important to heat treat it properly. If not, the knife may end up being brittle, or too soft to hold an edge.\r\n\r\nAs the carbon percentage content rises, steel has the ability to become harder and stronger through heat treating; however, it becomes less ductile. Regardless of the heat treatment, a higher carbon content reduces weldability. In carbon steels, the higher carbon content lowers the melting point', 'https://en.wikipedia.org/wiki/Stainless_steel', 1, NULL, '2023-01-16 07:00:01', '2023-01-16 07:00:01'),
(4, 'Pumps & Motors', 1, 0, 'A pump is a device that moves fluids (liquids or gases), or sometimes slurries,[1] by mechanical action, typically converted from electrical energy into hydraulic energy.\r\n\r\nMechanical pumps serve in a wide range of applications such as pumping water from wells, aquarium filtering, pond filtering and aeration, in the car industry for water-cooling and fuel injection, in the energy industry for pumping oil and natural gas or for operating cooling towers and other components of heating, ventilation and air conditioning systems. In the medical industry, pumps are used for biochemical processes in developing and manufacturing medicine, and as artificial replacements for body parts, in particular the artificial heart and penile prosthesis.\r\n\r\nWhen a pump contains two or more pump mechanisms with fluid being directed to flow through them in series, it is called a multi-stage pump. Terms such as two-stage or double-stage may be used to specifically describe the number of stages. A pump that does not fit this description is simply a single-stage pump in contrast.\r\n\r\nIn biology, many different types of chemical and biomechanical pumps have evolved; biomimicry is sometimes used in developing new types of mechanical pumps. ', 'https://en.wikipedia.org/wiki/Stainless_steel', 1, NULL, '2023-01-16 10:13:37', '2023-01-16 10:13:37'),
(5, 'Metal Structure', 2, 0, 'The rolled steel \"profile\" or cross section of steel columns takes the shape of the letter \"I\". The two wide flanges of a column are thicker and wider than the flanges on a beam, to better withstand compressive stress in the structure. Square and round tubular sections of steel can also be used, often filled with concrete. Steel beams are connected to the columns with bolts and threaded fasteners, and historically connected by rivets. The central \"web\" of the steel I-beam is often wider than a column web to resist the higher bending moments that occur in beams.\r\n\r\nWide sheets of steel deck can be used to cover the top of the steel frame as a \"form\" or corrugated mold, below a thick layer of concrete and steel reinforcing bars. Another popular alternative is a floor of precast concrete flooring units with some form of concrete topping. Often in office buildings, the final floor surface is provided by some form of raised flooring system with the void between the walking surface and the structural floor being used for cables and air handling ducts.\r\n\r\nThe frame needs to be protected from fire because steel softens at high temperature and this can cause the building to partially collapse. In the case of the columns this is usually done by encasing it in some form of fire resistant structure such as masonry, concrete or plasterboard. The beams may be cased in concrete, plasterboard or sprayed with a coating to insulate it from the heat of the fire or it can be protected by a fire-resistant ceiling construction. Asbestos was a popular material for fireproofing steel structures up until the early 1970s, before the health risks of asbestos fibres were fully understood.\r\n\r\nThe exterior \"skin\" of the building is anchored to the frame using a variety of construction techniques and following a huge variety of architectural styles. Bricks, stone, reinforced concrete, architectural glass, sheet metal and simply paint have been used to cover the frame to protect the steel from the weather.', 'https://en.wikipedia.org/wiki/Steel_frame', 1, NULL, '2023-01-16 10:16:27', '2023-01-16 10:16:27'),
(6, 'Stainless steel', 1, 1, 'Stainless steel is an alloy of iron that is resistant to rusting and corrosion. It contains at least 11% chromium and may contain elements such as carbon, other nonmetals and metals to obtain other desired properties. Stainless steel\'s resistance to corrosion results from the chromium, which forms a passive film that can protect the material and self-heal in the presence of oxygen.[1]: 3 \r\n\r\nThe alloy\'s properties, such as luster and resistance to corrosion, are useful in many applications. Stainless steel can be rolled into sheets, plates, bars, wire, and tubing. These can be used in cookware, cutlery, surgical instruments, major appliances, vehicles, construction material in large buildings, industrial equipment (e.g., in paper mills, chemical plants, water treatment), and storage tanks and tankers for chemicals and food products.\r\n\r\nThe biological cleanability of stainless steel is superior to both aluminium and copper, and comparable to glass.[2] Its cleanability, strength, and corrosion resistance have prompted the use of stainless steel in pharmaceutical and food processing plants.[3]\r\n\r\nDifferent types of stainless steel are labeled with an AISI three-digit number,[4] The ISO 15510 standard lists the chemical compositions of stainless steels of the specifications in existing ISO, ASTM, EN, JIS, and GB standards in a useful interchange table.[5] ', 'https://en.wikipedia.org/wiki/Stainless_steel', 1, NULL, '2023-01-16 10:18:21', '2023-01-16 10:18:21'),
(7, 'Ductile Iron', 1, 1, 'Ductile iron, also known as ductile cast iron, nodular cast iron, spheroidal graphite iron, spheroidal graphite cast iron[1] and SG iron, is a type of graphite-rich cast iron discovered in 1943 by Keith Millis. While most varieties of cast iron are weak in tension and brittle, ductile iron has much more impact and fatigue resistance, due to its nodular graphite inclusions.\r\n\r\nOn October 25, 1949, Keith Dwight Millis, Albert Paul Gagnebin and Norman Boden Pilling received US patent 2,485,760 on a cast ferrous alloy for ductile iron production via magnesium treatment. Augustus F. Meehan was awarded a patent in January 1931 for inoculating iron with calcium silicide to produce ductile iron subsequently licensed as Meehanite, still produced as of 2017.', 'https://en.wikipedia.org/wiki/Ductile_iron', 1, NULL, '2023-01-16 10:25:16', '2023-01-16 10:25:16'),
(8, 'Reservoirs', 1, 0, 'Cylindrical fuel tanks are used to store various fuels including diesel and hydrotreated vegetable oil (HVO). Available in a choice of capacities, cylindrical tanks offer a reliable way to safely store larger quantities of fuel on site and are suitable for a range of commercial applications.', NULL, 1, NULL, '2023-01-16 10:46:12', '2023-02-13 15:13:16'),
(9, 'Instruments', 1, 0, 'Instrumentation a collective term for measuring instruments that are used for indicating, measuring and recording physical quantities. The term has its origins in the art and science of scientific instrument-making.\r\n\r\nInstrumentation can refer to devices as simple as direct-reading thermometers, or as complex as multi-sensor components of industrial control systems. Today, instruments can be found in laboratories, refineries, factories and vehicles, as well as in everyday household use (e.g., smoke detectors and thermostats)', NULL, 1, NULL, '2023-02-05 07:01:51', '2023-02-14 04:42:30'),
(10, 'Level Sensors', 1, 9, NULL, NULL, 1, NULL, '2023-02-05 07:02:18', '2023-02-05 07:02:18'),
(11, 'Filtration Systems', 1, 0, NULL, NULL, 1, NULL, '2023-02-09 12:23:34', '2023-02-09 12:23:34'),
(12, 'Electric Components', 1, 0, NULL, NULL, 1, NULL, '2023-02-09 12:37:25', '2023-02-09 12:37:25'),
(13, 'Transformers', 1, 12, NULL, NULL, 1, NULL, '2023-02-09 12:38:04', '2023-02-09 12:38:04'),
(14, 'Contracting', 3, 0, NULL, NULL, 1, NULL, '2023-02-09 13:00:38', '2023-02-09 13:00:38'),
(15, 'Third Party Services', 3, 0, NULL, NULL, 1, NULL, '2023-02-09 13:05:56', '2023-02-09 13:05:56'),
(16, 'Performance Test', 3, 15, NULL, NULL, 1, NULL, '2023-02-09 13:06:43', '2023-02-09 13:06:43'),
(17, 'Mechanical Works', 3, 0, NULL, NULL, 1, NULL, '2023-02-09 13:10:18', '2023-02-09 13:10:18');

-- --------------------------------------------------------

--
-- Table structure for table `business_items`
--

DROP TABLE IF EXISTS `business_items`;
CREATE TABLE IF NOT EXISTS `business_items` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` char(100) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `category` bigint DEFAULT '0',
  `parent` bigint UNSIGNED NOT NULL,
  `brief` varchar(2048) NOT NULL,
  `brand` bigint DEFAULT NULL,
  `tags` varchar(1024) DEFAULT NULL,
  `origin` bigint DEFAULT NULL,
  `company` bigint DEFAULT NULL,
  `model` char(30) DEFAULT NULL,
  `image` char(100) DEFAULT NULL,
  `dim` char(32) DEFAULT NULL,
  `packing_list` varchar(1024) DEFAULT NULL,
  `pack` char(120) DEFAULT NULL,
  `stock` char(30) DEFAULT '1',
  `max_delivery_time` char(50) DEFAULT NULL,
  `min_inquiry` int DEFAULT '1',
  `pos` char(60) DEFAULT NULL,
  `created_by` bigint NOT NULL,
  `updated_by` bigint DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category` (`category`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `business_items`
--

INSERT INTO `business_items` (`id`, `name`, `type`, `category`, `parent`, `brief`, `brand`, `tags`, `origin`, `company`, `model`, `image`, `dim`, `packing_list`, `pack`, `stock`, `max_delivery_time`, `min_inquiry`, `pos`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'C.S Seamless Pipes', 1, 3, 1, 'Structural and Tested Pipe is stocked at Industrial Tube & Steel Corporation in both seamless and welded with a variety of sizes to meet the structural and mechanical piping requirements |||||||||||| s in water, petroleum, oil & gas, construction and other industries. Carbon steel pipe can be structural in nature or used in fluid, gas, and oil transmission. We stock carbon steel piping in ASTM A500, A53, and A106 specifications. The grade indicates the testing methods required for a given application.', 1, 'eretrgr|yukiuytyuy|grtyyt', 257, 1, '12mm to 600mm', NULL, 'L: 40Ft, W: 5Ft, H: 5Ft', 'Containers', 'Metal Container', '1000', '3 months', 3, NULL, 1, 1, '2023-01-16 17:16:28', '2023-02-21 14:00:18'),
(2, 'Welded ERW Pipe', 1, 3, 1, 'Carbon Steel ERW Manufacturer, CS Pipes, Carbon Steel ERW Pipe Supplier, Exporter\r\n\r\nPermanent Steel Manufacturing Co.,Ltd is a well-known manufacturer of Carbon Steel ERW Pipes, which is known for Precision engineered, Light weight, Corrosion resistance, Structured appropriately, Intricate detailing, Economical, and more. We have set an example in terms of quality and performance by manufacturing and supplying CS ERW Pipes, which are primarily used in heavy manufacturing industries for their high strength and pressure bearing capacity. Our clients can avail from us a comprehensive range of these Carbon Steel Electric Resistance Welded Pipes that are manufactured in line with the prevailing industry standards. We are listed at the pinnacle for supplying and trading utmost quality CS Electric Resistance Welded Pipes, which is well-inspected for its finishing before it is delivered to the clients. Our Carbon Steel ERW Tubes is often used in industries like Automobile, Boilers & Pressure Vessels, Ship Building, Railways, Transmission Towers, Oil & Petro Chemicals, Coal & Mining, General & Heavy Engineering, and more. ', 3, 'dhfghjmfhgj|tdshjhdgj|utrujtuuiky', 257, 1, '100mm 1200mm', NULL, 'hreashdyjyufk', 'strjdtfykugy', NULL, '1', NULL, 1, NULL, 1, NULL, '2023-01-17 05:53:46', '2023-01-17 05:53:46'),
(4, 'Welded ERW Pipe', 1, 3, 1, 'Carbon Steel ERW Manufacturer, CS Pipes, Carbon Steel ERW Pipe Supplier, Exporter\r\n\r\nPermanent Steel Manufacturing Co.,Ltd is a well-known manufacturer of Carbon Steel ERW Pipes, which is known for Precision engineered, Light weight, Corrosion resistance, Structured appropriately, Intricate detailing, Economical, and more. We have set an example in terms of quality and performance by manufacturing and supplying CS ERW Pipes, which are primarily used in heavy manufacturing industries for their high strength and pressure bearing capacity. Our clients can avail from us a comprehensive range of these Carbon Steel Electric Resistance Welded Pipes that are manufactured in line with the prevailing industry standards. We are listed at the pinnacle for supplying and trading utmost quality CS Electric Resistance Welded Pipes, which is well-inspected for its finishing before it is delivered to the clients. Our Carbon Steel ERW Tubes is often used in industries like Automobile, Boilers & Pressure Vessels, Ship Building, Railways, Transmission Towers, Oil & Petro Chemicals, Coal & Mining, General & Heavy Engineering, and more. ', 2, 'dhfghjmfhgj|tdshjhdgj|utrujtuuiky', 257, 1, '100mm 1200mm', NULL, 'hreashdyjyufk', 'strjdtfykugy', NULL, '1', NULL, 1, NULL, 1, NULL, '2023-01-17 05:55:59', '2023-01-17 05:55:59'),
(5, 'Seamless Elbow 90Deg', 1, 3, 1, 'We export high quality Seamless Elbow 90 Degree 4″ Sch 120 SR BW ASTM A234 WPB to South Africa, they are all produced by ISO certified manufacturer.\r\n\r\nButt weld Elbow is essential fittings in pipe systems, it is used to change the direction of flow in different degrees. According to the manufacture method, it can be seamless or welded. What is the most common used type? Of course 90 degree long radius elbow , but short radius elbow is more suitable for small spaces application.', 1, 'bcvbv|ryhdrftujfghjkf.|hghfgjhg', 257, 1, '63mm 1200mm', NULL, 'fdsffnhgcf', 'mnhgvmbhj', NULL, '1', NULL, 1, NULL, 1, NULL, '2023-01-17 06:26:18', '2023-01-17 06:26:18'),
(8, 'L3 Pressure And Level Transmitter', 1, 10, 9, 'High precision process pressure measurement in pipes & hydrostatic level and volume measurement in vessels\r\n\r\nThe Anderson-Negele L3 Pressure and Level Transmitter has been designed to measure process pressure or hydrostatic level in hygienicprocess applications.\r\nThe state-of-the-art temperature compensation reduces errors associated with process temperature changes with improved zero stability reduces sensor interaction. The graphical user interface makes set-up and programming easy by directly aligning to the HARTTM DD menu structure. The field repairable and reconfigurable design allows the user to change the display orientation, add a remote cable, or replace a component in the field without impact to accuracy.', 10, 'sensors|instruments|level|indicator', 308, 2, '- - -', NULL, NULL, NULL, NULL, '1', NULL, 1, NULL, 1, 1, '2023-02-12 12:25:46', '2023-02-14 07:21:59'),
(9, 'Pump Performance Test', 3, 16, 15, 'Make sure that the suction strainer is clean and the suction valve is fully open. Ensure that discharge valve is fully closed. Open the discharge valve slightly till the flow rate reaches the first value indicated in pump performance curve provided by pump supplier.', 1, 'pump|test|performance|curves', 401, 4, 'MMCCO', NULL, NULL, NULL, NULL, '1', NULL, 1, NULL, 1, 1, '2023-02-12 12:46:25', '2023-02-12 12:53:46');

-- --------------------------------------------------------

--
-- Table structure for table `business_items_apps`
--

DROP TABLE IF EXISTS `business_items_apps`;
CREATE TABLE IF NOT EXISTS `business_items_apps` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `value` varchar(255) NOT NULL,
  `item` bigint UNSIGNED NOT NULL,
  `created_by` bigint NOT NULL,
  `updated_by` bigint DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item` (`item`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `business_items_apps`
--

INSERT INTO `business_items_apps` (`id`, `value`, `item`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Brakish Water Transfer', 2, 1, NULL, '2023-02-06 08:55:56', '2023-02-06 08:55:56'),
(4, 'The transfer of extremely hazardous materials such as chemical and waste.', 1, 1, NULL, '2023-02-12 14:17:48', '2023-02-12 14:17:48'),
(6, 'Pressure Measurement of Corrosive Media in Pipelines', 8, 1, NULL, '2023-02-14 08:06:33', '2023-02-14 08:06:33'),
(7, 'Process control', 8, 1, NULL, '2023-02-14 08:08:08', '2023-02-14 08:08:08'),
(8, 'Aerospace', 8, 1, NULL, '2023-02-14 08:08:17', '2023-02-14 08:08:17'),
(9, 'Chemical product and chemical industry', 8, 1, NULL, '2023-02-14 08:08:24', '2023-02-14 08:08:24'),
(10, 'Servo valve and transmission', 8, 1, NULL, '2023-02-14 08:08:32', '2023-02-14 08:08:32');

-- --------------------------------------------------------

--
-- Table structure for table `business_items_specs`
--

DROP TABLE IF EXISTS `business_items_specs`;
CREATE TABLE IF NOT EXISTS `business_items_specs` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `label` char(50) NOT NULL,
  `unit` char(50) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `item` bigint UNSIGNED NOT NULL,
  `created_by` bigint NOT NULL,
  `updated_by` bigint DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item` (`item`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `business_items_specs`
--

INSERT INTO `business_items_specs` (`id`, `label`, `unit`, `value`, `item`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Material', NULL, 'Stainless Steel', 2, 1, NULL, '2023-02-02 07:19:51', '2023-02-02 07:19:51'),
(2, 'Length', 'meter', '12', 2, 1, NULL, '2023-02-06 05:35:48', '2023-02-06 05:35:48'),
(3, 'Length', 'Meter', '12', 4, 1, NULL, '2023-02-12 13:26:05', '2023-02-12 13:26:05'),
(5, 'width', 'inch', '30', 4, 1, NULL, '2023-02-12 13:31:40', '2023-02-12 13:31:40'),
(6, 'height', 'M', '30', 4, 1, NULL, '2023-02-12 13:36:16', '2023-02-12 13:36:16'),
(7, 'coating', 'Blue', '3LPE 3mm', 4, 1, NULL, '2023-02-12 13:37:18', '2023-02-12 13:37:18'),
(9, 'width', 'Meter', '100', 1, 1, NULL, '2023-02-12 13:51:31', '2023-02-12 13:51:31'),
(11, 'Model Number', NULL, 'AEA16', 8, 1, NULL, '2023-02-14 07:43:22', '2023-02-14 07:43:22'),
(12, 'Application', NULL, 'Gauge Pressure, Liquid Level', 8, 1, NULL, '2023-02-14 07:44:34', '2023-02-14 07:44:34'),
(13, 'Connection Process', NULL, 'Thread', 8, 1, NULL, '2023-02-14 07:44:50', '2023-02-14 07:44:50'),
(14, 'Measuring Range', NULL, '0~40 Mpa', 8, 1, NULL, '2023-02-14 07:45:05', '2023-02-14 07:45:05'),
(16, 'Process Temperature', NULL, '-40℃ ~ 105℃', 8, 1, NULL, '2023-02-14 07:58:47', '2023-02-14 07:58:47'),
(17, 'Overload Presure Limit(OPL)', 'Mpa', 'Max 60', 8, 1, NULL, '2023-02-14 07:59:10', '2023-02-14 07:59:10'),
(18, 'Ambient Temperature', NULL, '-40℃ ~ 85℃ or -20℃ ~ 70℃(with LCD)', 8, 1, NULL, '2023-02-14 07:59:34', '2023-02-14 07:59:34'),
(19, 'Reference Measurement Accuracy', NULL, '±0.2%URL or ±0.1%URL or ±0.075%URL(Optional)', 8, 1, NULL, '2023-02-14 07:59:46', '2023-02-14 07:59:46'),
(20, 'Power Supply Voltage', 'VDC', '10~32', 8, 1, NULL, '2023-02-14 08:00:04', '2023-02-14 08:00:04'),
(21, 'Output', NULL, '4~20 mA or 4~20mA+HART or MODBUS RS485', 8, 1, NULL, '2023-02-14 08:00:18', '2023-02-14 08:00:18'),
(22, 'Certificate', NULL, 'CE, NEPSI', 8, 1, NULL, '2023-02-14 08:00:33', '2023-02-14 08:00:33'),
(23, 'Waterproof Grade', NULL, 'IP67', 8, 1, NULL, '2023-02-14 08:00:48', '2023-02-14 08:00:48'),
(24, 'Product Length Range', 'Meter', '6, 12, 24', 1, 1, NULL, '2023-02-20 14:40:01', '2023-02-20 14:40:01'),
(25, 'Diameter Range', 'mm', '12-2500', 1, 1, NULL, '2023-02-20 14:40:30', '2023-02-20 14:40:30'),
(26, 'Product Schedules Available', NULL, 'SCH10, SCH20, SCH30, STD, SCH40, SCH60, XS, SCH80, SCH100,	SCH120, SCH140, SCH160', 1, 1, NULL, '2023-02-20 14:44:19', '2023-02-20 14:44:19'),
(27, 'Ambient Temperature', 'F', '80', 1, 1, NULL, '2023-02-20 14:45:10', '2023-02-20 14:45:10');

-- --------------------------------------------------------

--
-- Table structure for table `business_items_standard`
--

DROP TABLE IF EXISTS `business_items_standard`;
CREATE TABLE IF NOT EXISTS `business_items_standard` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `label` char(50) NOT NULL,
  `value` varchar(255) NOT NULL,
  `item` bigint UNSIGNED NOT NULL,
  `created_by` bigint NOT NULL,
  `updated_by` bigint DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item` (`item`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `business_items_standard`
--

INSERT INTO `business_items_standard` (`id`, `label`, `value`, `item`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Manufactoring', 'BS EN 5255', 2, 1, NULL, '2023-02-06 12:47:43', '2023-02-06 12:47:43');

-- --------------------------------------------------------

--
-- Table structure for table `business_items_uploads`
--

DROP TABLE IF EXISTS `business_items_uploads`;
CREATE TABLE IF NOT EXISTS `business_items_uploads` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `role` char(20) NOT NULL,
  `file` char(100) NOT NULL,
  `type` tinyint NOT NULL,
  `item` bigint UNSIGNED DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `ext` varchar(20) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `parent_category` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint NOT NULL,
  `updated_by` bigint DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item` (`item`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `business_items_uploads`
--

INSERT INTO `business_items_uploads` (`id`, `name`, `role`, `file`, `type`, `item`, `title`, `ext`, `status`, `parent_category`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Item Logo', 'item file', 'Logo_230114_065932.png', 0, 1, NULL, 'png', 1, NULL, 1, 1, '2023-01-16 20:43:08', '2023-02-12 14:20:21'),
(2, 'Item logo', 'item file', 'Logo_230116_032847.png', 0, 4, NULL, 'png', 1, NULL, 1, NULL, '2023-01-17 05:55:59', '2023-01-17 05:55:59'),
(5, 'Item logo', 'item file', 'Logo_230117_061826.jpg', 0, 5, NULL, 'jpg', 1, NULL, 1, NULL, '2023-01-17 06:26:18', '2023-01-17 06:26:18'),
(20, 'default logo', 'Default Item Logo', 'nologo.png', 0, NULL, 'nologo.png', 'png', 0, 0, 1, 1, '2023-01-16 20:43:08', '2023-02-09 05:19:22'),
(32, 'Pipes & Fittings', 'Category Icon', 'Cover_20230212085846230212_084658.png', 1, 1, NULL, 'png', 0, 1, 1, 1, '2023-02-12 08:58:46', '2023-02-12 14:20:19'),
(33, 'Valves & Flow Control', 'Category Icon', 'Cover_20230212095239230212_093952.jpg', 1, 2, NULL, 'jpg', 1, 2, 1, NULL, '2023-02-12 09:52:39', '2023-02-12 09:52:39'),
(34, 'Pumps & Motors', 'Category Icon', 'Cover_20230212095327230212_092753.png', 1, 4, NULL, 'png', 1, 4, 1, NULL, '2023-02-12 09:53:27', '2023-02-12 09:53:27'),
(41, 'icon', 'Brand Icon', 'Icon_20230212120506230212_120605.jpg', 0, NULL, NULL, 'jpg', 1, 11, 1, NULL, '2023-02-12 12:05:06', '2023-02-12 12:05:06'),
(43, NULL, 'item file', 'Gallery_Image_20230212144106230212_020641.png', 3, 1, NULL, 'png', 1, 3, 1, 1, '2023-02-12 14:41:06', '2023-02-12 14:41:13'),
(44, 'Pipes & Fittings', 'Category Cover', 'Cover_20230213084435230213_083544.jpg', 1, 1, NULL, 'jpg', 1, 1, 1, NULL, '2023-02-13 08:44:35', '2023-02-13 08:44:35'),
(45, 'Default Cover', 'Default Cover', 'Cover_20230213084435230213_083545.jpg', 1, 1, NULL, 'jpg', 1, 1, 1, NULL, '2023-02-13 12:24:59', '2023-02-13 12:24:59'),
(46, 'Pipes & Fittings', 'Category Cover', 'Cover_20230213113344230213_114433.jpg', 1, 1, NULL, 'jpg', 1, 3, 1, NULL, '2023-02-13 11:33:44', '2023-02-13 11:33:44'),
(49, 'Stainless steel', 'Category Cover', 'Cover_20230213114936230213_113649.png', 1, NULL, NULL, 'png', 1, 6, 1, NULL, '2023-02-13 11:49:36', '2023-02-13 11:49:36'),
(50, 'Ductile Iron', 'Category Cover', 'Cover_20230213115309230213_110953.png', 1, NULL, NULL, 'png', 1, 7, 1, NULL, '2023-02-13 11:53:09', '2023-02-13 11:53:09'),
(51, 'Ductile Iron', 'Category Icon', 'Cover_20230213122318230213_121823.png', 1, NULL, NULL, 'png', 1, 7, 1, NULL, '2023-02-13 12:23:18', '2023-02-13 12:23:18'),
(52, 'Stainless steel', 'Category Icon', 'Cover_20230213123051230213_125130.jpg', 1, NULL, NULL, 'jpg', 1, 6, 1, NULL, '2023-02-13 12:30:51', '2023-02-13 12:30:51'),
(53, 'Carbon Steel', 'Category Icon', 'Cover_20230213123341230213_124133.jpg', 1, NULL, NULL, 'jpg', 1, 3, 1, NULL, '2023-02-13 12:33:41', '2023-02-13 12:33:41'),
(54, 'Item Cover', 'Item Cover', 'Item_Cover_20230213131014230213_011410.jpg', 16, 1, NULL, 'jpg', 1, 3, 1, 1, '2023-02-13 13:10:14', '2023-02-13 13:10:25'),
(55, 'Item Cover', 'item Cover', 'Item_Cover_20230213132040230213_014020.jpg', 16, 5, NULL, 'jpg', 1, 3, 1, 1, '2023-02-13 13:20:40', '2023-02-13 13:20:44'),
(56, NULL, 'Category Icon', 'Logo_20230213143752230213_025237.png', 0, NULL, NULL, 'png', 1, 8, 1, NULL, '2023-02-13 14:37:52', '2023-02-13 14:37:52'),
(58, NULL, 'Category Cover', 'Logo_20230213150458230213_035804.png', 0, NULL, NULL, 'png', 1, 8, 1, NULL, '2023-02-13 15:04:58', '2023-02-13 15:04:58'),
(59, NULL, 'Category Cover', 'Logo_20230214041455230214_045514.png', 0, NULL, NULL, 'png', 1, 9, 1, NULL, '2023-02-14 04:14:55', '2023-02-14 04:14:55'),
(60, '1', 'Item Gallery Image', 'Gallery_Image_20230214082723230214_082327.jpg', 2, 8, 'Front View', 'png', 1, 10, 1, NULL, '2023-02-14 08:27:23', '2023-02-14 08:27:23'),
(62, '2', 'Item Gallery Image', 'Gallery_Image_20230214082846230214_084628.jpg', 2, 8, 'Perspective View', 'png', 1, 10, 1, NULL, '2023-02-14 08:28:46', '2023-02-14 08:28:46'),
(63, '1', 'Item Gallery Image', 'Gallery_Image_20230220140146230220_024601.jpg', 2, 1, NULL, 'jpg', 1, 3, 1, NULL, '2023-02-20 14:01:46', '2023-02-20 14:01:46'),
(64, '2', 'Item Gallery Image', 'Gallery_Image_20230220140211230220_021102.jpg', 2, 1, NULL, 'jpg', 1, 3, 1, NULL, '2023-02-20 14:02:11', '2023-02-20 14:02:11'),
(65, '3', 'Item Gallery Image', 'Gallery_Image_20230220140234230220_023402.jpg', 2, 1, NULL, 'jpg', 1, 3, 1, NULL, '2023-02-20 14:02:34', '2023-02-20 14:02:34'),
(66, '4', 'Item Gallery Image', 'Gallery_Image_20230220140257230220_025702.jpg', 2, 1, 'Front View', 'jpg', 1, 3, 1, NULL, '2023-02-20 14:02:57', '2023-02-20 14:02:57'),
(67, '5', 'Item Gallery Image', 'Gallery_Image_20230220140333230220_023303.jpg', 2, 1, 'Perspective View', 'jpg', 1, 3, 1, NULL, '2023-02-20 14:03:33', '2023-02-20 14:03:33'),
(68, 'C.S SMLS Pipes', 'Item Datasheet', 'Data_Sheet_20230221060153230221_065301.pdf', 1, 1, NULL, 'pdf', 1, 3, 1, NULL, '2023-02-21 06:01:53', '2023-02-21 06:01:53');

-- --------------------------------------------------------

--
-- Table structure for table `business_item_uploads`
--

DROP TABLE IF EXISTS `business_item_uploads`;
CREATE TABLE IF NOT EXISTS `business_item_uploads` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `name` char(100) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `item` bigint UNSIGNED NOT NULL DEFAULT '0',
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `created_by` bigint NOT NULL,
  `updated_by` bigint DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `business_item_uploads`
--

INSERT INTO `business_item_uploads` (`id`, `name`, `type`, `item`, `title`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Logo_230114_065932.png', 0, 1, NULL, 1, NULL, '2023-01-16 20:43:08', NULL),
(2, 'Logo_230116_032847.png', 0, 4, NULL, 1, NULL, '2023-01-17 05:55:59', '2023-01-17 05:55:59'),
(3, 'Logo_230116_032446.png', 0, 3, NULL, 1, NULL, '2023-01-16 20:43:08', NULL),
(4, 'Logo_230114_061131.png', 0, 2, NULL, 1, NULL, '2023-01-16 20:43:08', NULL),
(5, 'item_logo_230117_061826.jpg', 0, 5, NULL, 1, NULL, '2023-01-17 06:26:18', '2023-01-17 06:26:18'),
(6, 'item_logo_230117_070036.jpg', 0, 7, NULL, 1, NULL, '2023-01-17 07:36:00', '2023-01-17 07:36:00'),
(7, 'item_logo_230117_075949.jpg', 0, 8, NULL, 1, NULL, '2023-01-17 07:49:59', '2023-01-17 07:49:59');

-- --------------------------------------------------------

--
-- Table structure for table `business_types`
--

DROP TABLE IF EXISTS `business_types`;
CREATE TABLE IF NOT EXISTS `business_types` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` char(100) NOT NULL,
  `items` varchar(255) DEFAULT NULL,
  `created_by` bigint NOT NULL,
  `updated_by` bigint DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `business_types`
--

INSERT INTO `business_types` (`id`, `name`, `items`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Supplies', NULL, 1, NULL, '2023-02-09 13:18:34', NULL),
(2, 'Manufacturing', NULL, 1, NULL, '2023-02-09 13:18:34', NULL),
(3, 'Services', NULL, 1, NULL, '2023-02-09 13:19:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `a_name` char(255) NOT NULL,
  `e_name` char(255) NOT NULL,
  `s_number` char(11) NOT NULL,
  `logo` char(72) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `phone` char(20) DEFAULT NULL,
  `fax` char(20) DEFAULT NULL,
  `mobile` char(20) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `vat` int DEFAULT NULL,
  `cr` int DEFAULT NULL,
  `files` varchar(1023) DEFAULT NULL,
  `company` bigint NOT NULL,
  `created_by` bigint NOT NULL,
  `updated_by` bigint DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` tinyint DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `a_name`, `e_name`, `s_number`, `logo`, `website`, `phone`, `fax`, `mobile`, `email`, `address`, `vat`, `cr`, `files`, `company`, `created_by`, `updated_by`, `created_at`, `updated_at`, `status`) VALUES
(1, 'الشركة العالمية للصيدليات', 'Global Pharmcies company', '1', NULL, 'www.farmaglob.com', 'a:4:{s:7:\"country\";s', NULL, NULL, NULL, 'a:4:{s:7:\"country\";i:401;s:5:\"state\";s:6:\"qassim\";s:4:\"city\";s:8:\"buraydah\";s:6:\"street\";s:22:\"13 alnoor dist. b: 230\";} ', NULL, NULL, NULL, 1, 1, NULL, '2022-11-04 20:17:15', '2022-11-04 20:17:15', 0);

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
CREATE TABLE IF NOT EXISTS `companies` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `shortName` char(100) NOT NULL,
  `logo` char(100) NOT NULL,
  `longName` char(255) DEFAULT NULL,
  `created_by` bigint NOT NULL,
  `updated_by` bigint DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `shortName`, `logo`, `longName`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'SYNDA', 'Logo_230116_032847.png', 'Synds Steel Pipes International Corporation', 1, NULL, '2023-01-16 15:47:28', '2023-01-16 15:47:28'),
(2, 'IndiaMART InterMESH Ltd', 'Logo_230212_125117.png', 'IndiaMART InterMESH Ltd', 1, NULL, '2023-02-12 12:17:51', '2023-02-12 12:17:51'),
(3, 'AEICO', 'Logo_230212_124440.png', 'AEICO', 1, NULL, '2023-02-12 12:40:44', '2023-02-12 12:40:44'),
(4, 'AEICO', 'Logo_230212_123253.png', 'Al Ghamas Factory Company for Advanced Electromechanical Industries', 1, NULL, '2023-02-12 12:53:32', '2023-02-12 12:53:32');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE IF NOT EXISTS `countries` (
  `id` int NOT NULL AUTO_INCREMENT,
  `a_name` varchar(50) DEFAULT NULL,
  `e_name` varchar(50) NOT NULL,
  `iso` varchar(10) DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=454 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `a_name`, `e_name`, `iso`, `code`) VALUES
(214, 'أفغانستان', 'Afghanista', 'AF', '93'),
(215, 'ألبانيا', 'Albania', 'AL', '355'),
(216, 'الجزائر', 'Algeria', 'DZ', '213'),
(217, 'ساموا الأمريكية', 'American S', 'AS', '1-684'),
(218, 'أندورا', 'Andorra', 'AD', '376'),
(219, 'أنجولا', 'Angola', 'AO', '244'),
(220, 'أنغيلا', 'Anguilla', 'AI', '1-264'),
(221, 'القارة القطبية الجنوبية', 'Antarctica', 'AQ', '672'),
(222, 'انتيغوا وبربودا', 'Antigua an', 'AG', '1-268'),
(223, 'الأرجنتين', 'Argentina', 'AR', '54'),
(224, 'أرمينيا', 'Armenia', 'AM', '374'),
(225, 'أروبا', 'Aruba', 'AW', '297'),
(226, 'أستراليا', 'Australia', 'AU', '61'),
(227, 'النمسا', 'Austria', 'AT', '43'),
(228, 'أذربيجان', 'Azerbaijan', 'AZ', '994'),
(229, 'جزر البهاما', 'Bahamas', 'BS', '1-242'),
(230, 'البحرين', 'Bahrain', 'BH', '973'),
(231, 'بنغلاديش', 'Bangladesh', 'BD', '880'),
(232, 'بربادوس', 'Barbados', 'BB', '1-246'),
(233, 'روسيا البيضاء', 'Belarus', 'BY', '375'),
(234, 'بلجيكا', 'Belgium', 'BE', '32'),
(235, 'بليز', 'Belize', 'BZ', '501'),
(236, 'بنين', 'Benin', 'BJ', '229'),
(237, 'برمودا', 'Bermuda', 'BM', '1-441'),
(238, 'بوتان', 'Bhutan', 'BT', '975'),
(239, 'بوليفيا', 'Bolivia', 'BO', '591'),
(240, 'البوسنة والهرسك', 'Bosnia and', 'BA', '387'),
(241, 'بوتسوانا', 'Botswana', 'BW', '267'),
(242, 'البرازيل', 'Brazil', 'BR', '55'),
(243, 'إقليم المحيط الهندي البريطاني', 'British In', 'IO', '246'),
(244, 'جزر فيرجن البريطانية', 'British Vi', 'VG', '1-284'),
(245, 'بروناي دار السلام', 'Brunei', 'BN', '673'),
(246, 'بلغاريا', 'Bulgaria', 'BG', '359'),
(247, 'بوركينا فاسو', 'Burkina Fa', 'BF', '226'),
(248, 'بوروندي', 'Burundi', 'BI', '257'),
(249, 'كمبوديا', 'Cambodia', 'KH', '855'),
(250, 'الكاميرون', 'Cameroon', 'CM', '237'),
(251, 'كندا', 'Canada', 'CA', '1'),
(252, 'الرأس الأخضر', 'Cape Verde', 'CV', '238'),
(253, 'جزر كايمان', 'Cayman Isl', 'KY', '1-345'),
(254, 'جمهورية أفريقيا الوسطى', 'Central Af', 'CF', '236'),
(255, 'تشاد', 'Chad', 'TD', '235'),
(256, 'تشيلي', 'Chile', 'CL', '56'),
(257, 'الصين', 'China', 'CN', '86'),
(258, 'جزيرة كريسماس', 'Christmas ', 'CX', '61'),
(259, 'جزر كوكوس (كيلينغ)', 'Cocos Isla', 'CC', '61'),
(260, 'كولومبيا', 'Colombia', 'CO', '57'),
(261, 'جزر القمر', 'Comoros', 'KM', '269'),
(262, 'جزر كوك', 'Cook Islan', 'CK', '682'),
(263, 'كوستاريكا', 'Costa Rica', 'CR', '506'),
(264, 'كرواتيا', 'Croatia', 'HR', '385'),
(265, 'كوبا', 'Cuba', 'CU', '53'),
(266, 'كوراكاو', 'Curacao', 'CW', '599'),
(267, 'قبرص', 'Cyprus', 'CY', '357'),
(268, 'الجمهورية التشيكية', 'Czech Repu', 'CZ', '420'),
(269, 'جمهورية الكونغو الديمقراطية', 'Democratic', 'CD', '243'),
(270, 'الدنمرك', 'Denmark', 'DK', '45'),
(271, 'جيبوتي', 'Djibouti', 'DJ', '253'),
(272, 'دومينيكا', 'Dominica', 'DM', '1-767'),
(273, 'جمهورية الدومينيكان', 'Dominican ', 'DO', '1-809,'),
(274, 'تيمور الشرقية', 'East Timor', 'TL', '670'),
(275, 'الإكوادور', 'Ecuador', 'EC', '593'),
(276, 'مصر', 'Egypt', 'EG', '20'),
(277, 'السلفادور', 'El Salvado', 'SV', '503'),
(278, 'غينيا الاستوائية', 'Equatorial', 'GQ', '240'),
(279, 'إريتريا', 'Eritrea', 'ER', '291'),
(280, 'استونيا', 'Estonia', 'EE', '372'),
(281, 'أثيوبيا', 'Ethiopia', 'ET', '251'),
(282, 'جزر فوكلاند (مالفيناس)', 'Falkland I', 'FK', '500'),
(283, 'جزر فارو', 'Faroe Isla', 'FO', '298'),
(284, 'فيجي', 'Fiji', 'FJ', '679'),
(285, 'فنلندا', 'Finland', 'FI', '358'),
(286, 'فرنسا', 'France', 'FR', '33'),
(287, 'بولينيزيا الفرنسية', 'French Pol', 'PF', '689'),
(288, 'الجابون', 'Gabon', 'GA', '241'),
(289, 'جامبيا', 'Gambia', 'GM', '220'),
(290, 'جورجيا', 'Georgia', 'GE', '995'),
(291, 'ألمانيا', 'Germany', 'DE', '49'),
(292, 'غانا', 'Ghana', 'GH', '233'),
(293, 'جبل طارق', 'Gibraltar', 'GI', '350'),
(294, 'اليونان', 'Greece', 'GR', '30'),
(295, 'جرينلند', 'Greenland', 'GL', '299'),
(296, 'جرينادا', 'Grenada', 'GD', '1-473'),
(297, 'جوام', 'Guam', 'GU', '1-671'),
(298, 'جواتيمالا', 'Guatemala', 'GT', '502'),
(299, 'جيرنسي', 'Guernsey', 'GG', '44-148'),
(300, 'غينيا', 'Guinea', 'GN', '224'),
(301, 'غينيا بيساو', 'Guinea-Bis', 'GW', '245'),
(302, 'غيانا', 'Guyana', 'GY', '592'),
(303, 'هايتي', 'Haiti', 'HT', '509'),
(304, 'هندوراس', 'Honduras', 'HN', '504'),
(305, 'هونج كونج', 'Hong Kong', 'HK', '852'),
(306, 'المجر', 'Hungary', 'HU', '36'),
(307, 'أيسلندا', 'Iceland', 'IS', '354'),
(308, 'الهند', 'India', 'IN', '91'),
(309, 'إندونيسيا', 'Indonesia', 'ID', '62'),
(310, 'إيران', 'Iran', 'IR', '98'),
(311, 'العراق', 'Iraq', 'IQ', '964'),
(312, 'ايرلندا', 'Ireland', 'IE', '353'),
(313, 'جزيرة آيل أوف مان', 'Isle of Ma', 'IM', '44-162'),
(314, 'غير مخصص', 'Israel', 'IL', '972'),
(315, 'إيطاليا', 'Italy', 'IT', '39'),
(316, 'كوت ديفوار', 'Ivory Coas', 'CI', '225'),
(317, 'جامايكا', 'Jamaica', 'JM', '1-876'),
(318, 'اليابان', 'Japan', 'JP', '81'),
(319, 'جيرسي', 'Jersey', 'JE', '44-153'),
(320, 'الأردن', 'Jordan', 'JO', '962'),
(321, 'كازاخستان', 'Kazakhstan', 'KZ', '7'),
(322, 'كينيا', 'Kenya', 'KE', '254'),
(323, 'كيريباتي', 'Kiribati', 'KI', '686'),
(324, 'كوسوفو', 'Kosovo', 'XK', '383'),
(325, 'الكويت', 'Kuwait', 'KW', '965'),
(326, 'قيرغيزستان', 'Kyrgyzstan', 'KG', '996'),
(327, 'لاوس', 'Laos', 'LA', '856'),
(328, 'لاتفيا', 'Latvia', 'LV', '371'),
(329, 'لبنان', 'Lebanon', 'LB', '961'),
(330, 'ليسوتو', 'Lesotho', 'LS', '266'),
(331, 'ليبيريا', 'Liberia', 'LR', '231'),
(332, 'ليبيا', 'Libya', 'LY', '218'),
(333, 'ليختنشتاين', 'Liechtenst', 'LI', '423'),
(334, 'ليتوانيا', 'Lithuania', 'LT', '370'),
(335, 'لوكسمبورغ', 'Luxembourg', 'LU', '352'),
(336, 'ماكاو', 'Macao', 'MO', '853'),
(337, 'مقدونيا', 'Macedonia', 'MK', '389'),
(338, 'مدغشقر', 'Madagascar', 'MG', '261'),
(339, 'مالاوي', 'Malawi', 'MW', '265'),
(340, 'ماليزيا', 'Malaysia', 'MY', '60'),
(341, 'جزر المالديف', 'Maldives', 'MV', '960'),
(342, 'مالي', 'Mali', 'ML', '223'),
(343, 'مالطا', 'Malta', 'MT', '356'),
(344, 'جزر مارشال', 'Marshall I', 'MH', '692'),
(345, 'موريتانيا', 'Mauritania', 'MR', '222'),
(346, 'موريشيوس', 'Mauritius', 'MU', '230'),
(347, 'جزيرة مايوت', 'Mayotte', 'YT', '262'),
(348, 'المكسيك', 'Mexico', 'MX', '52'),
(349, 'ولايات ميكرونيزيا الموحدة', 'Micronesia', 'FM', '691'),
(350, 'مولدوفيا', 'Moldova', 'MD', '373'),
(351, 'موناكو', 'Monaco', 'MC', '377'),
(352, 'منغوليا', 'Mongolia', 'MN', '976'),
(353, 'الجبل الأسود', 'Montenegro', 'ME', '382'),
(354, 'مونتسيرات', 'Montserrat', 'MS', '1-664'),
(355, 'مغربي', 'Morocco', 'MA', '212'),
(356, 'موزمبيق', 'Mozambique', 'MZ', '258'),
(357, 'بورما', 'Myanmar', 'MM', '95'),
(358, 'ناميبيا', 'Namibia', 'NA', '264'),
(359, 'ناورو', 'Nauru', 'NR', '674'),
(360, 'نيبال', 'Nepal', 'NP', '977'),
(361, 'هولندا', 'Netherland', 'NL', '31'),
(362, 'جزر الانتيل الهولندية', 'Netherland', 'AN', '599'),
(363, 'كاليدونيا الجديدة', 'New Caledo', 'NC', '687'),
(364, 'نيوزيلندا', 'New Zealan', 'NZ', '64'),
(365, 'نيكاراغوا', 'Nicaragua', 'NI', '505'),
(366, 'النيجر', 'Niger', 'NE', '227'),
(367, 'نيجيريا', 'Nigeria', 'NG', '234'),
(368, 'نيوي', 'Niue', 'NU', '683'),
(369, 'كوريا الشمالية', 'North Kore', 'KP', '850'),
(370, 'جزر ماريانا الشمالية', 'Northern M', 'MP', '1-670'),
(371, 'النرويج', 'Norway', 'NO', '47'),
(372, 'سلطنة عمان', 'Oman', 'OM', '968'),
(373, 'باكستان', 'Pakistan', 'PK', '92'),
(374, 'بالاو', 'Palau', 'PW', '680'),
(375, 'فلسطين', 'Palestine', 'PS', '970'),
(376, 'بنما', 'Panama', 'PA', '507'),
(377, 'بابوا غينيا الجديدة', 'Papua New ', 'PG', '675'),
(378, 'باراغواي', 'Paraguay', 'PY', '595'),
(379, 'بيرو', 'Peru', 'PE', '51'),
(380, 'الفلبين', 'Philippine', 'PH', '63'),
(381, 'جزر بيتكيرن', 'Pitcairn', 'PN', '64'),
(382, 'بولندا', 'Poland', 'PL', '48'),
(383, 'البرتغال', 'Portugal', 'PT', '351'),
(384, 'بويرتو ريكو', 'Puerto Ric', 'PR', '1-787,'),
(385, 'قطر', 'Qatar', 'QA', '974'),
(386, 'جمهورية الكونغو', 'Republic o', 'CG', '242'),
(387, 'رينيون', 'Reunion', 'RE', '262'),
(388, 'رومانيا', 'Romania', 'RO', '40'),
(389, 'الاتحاد الروسي', 'Russia', 'RU', '7'),
(390, 'رواندا', 'Rwanda', 'RW', '250'),
(391, 'سانت بارتيليمي', 'Saint Bart', 'BL', '590'),
(392, 'سانت هيلانة', 'Saint Hele', 'SH', '290'),
(393, 'سانت كيتس ونيفيس', 'Saint Kitt', 'KN', '1-869'),
(394, 'سانت لوسيا', 'Saint Luci', 'LC', '1-758'),
(395, 'سانت مارتن', 'Saint Mart', 'MF', '590'),
(396, 'سان بيار وميكلون', 'Saint Pier', 'PM', '508'),
(397, 'سانت فنسنت وغرينادين', 'Saint Vinc', 'VC', '1-784'),
(398, 'ساموا', 'Samoa', 'WS', '685'),
(399, 'سان مارينو', 'San Marino', 'SM', '378'),
(400, 'سانت تومي وبرينسبل', 'Sao Tome a', 'ST', '239'),
(401, 'المملكة العربية السعودية', 'Saudi Arab', 'SA', '966'),
(402, 'السنغال', 'Senegal', 'SN', '221'),
(403, 'صربيا', 'Serbia', 'RS', '381'),
(404, 'سيشيل', 'Seychelles', 'SC', '248'),
(405, 'سيراليون', 'Sierra Leo', 'SL', '232'),
(406, 'سنغافورة', 'Singapore', 'SG', '65'),
(407, 'سينت مارتن', 'Sint Maart', 'SX', '1-721'),
(408, 'سلوفاكيا', 'Slovakia', 'SK', '421'),
(409, 'سلوفينيا', 'Slovenia', 'SI', '386'),
(410, 'جزر سليمان', 'Solomon Is', 'SB', '677'),
(411, 'الصومال', 'Somalia', 'SO', '252'),
(412, 'جنوب أفريقيا', 'South Afri', 'ZA', '27'),
(413, 'كوريا الجنوبية', 'South Kore', 'KR', '82'),
(414, 'جنوب السودان', 'South Suda', 'SS', '211'),
(415, 'إسبانيا', 'Spain', 'ES', '34'),
(416, 'سريلانكا', 'Sri Lanka', 'LK', '94'),
(417, 'السودان', 'Sudan', 'SD', '249'),
(418, 'سورينام', 'Suriname', 'SR', '597'),
(419, 'سفالبارد', 'Svalbard a', 'SJ', '47'),
(420, 'سوازيلاند', 'Swaziland', 'SZ', '268'),
(421, 'السويد', 'Sweden', 'SE', '46'),
(422, 'سويسرا', 'Switzerlan', 'CH', '41'),
(423, 'سوريا', 'Syria', 'SY', '963'),
(424, 'تايوان', 'Taiwan', 'TW', '886'),
(425, 'طاجيكستان', 'Tajikistan', 'TJ', '992'),
(426, 'تنزانيا', 'Tanzania', 'TZ', '255'),
(427, 'تايلاند', 'Thailand', 'TH', '66'),
(428, 'توجو', 'Togo', 'TG', '228'),
(429, 'توكيلاو', 'Tokelau', 'TK', '690'),
(430, 'تونجا', 'Tonga', 'TO', '676'),
(431, 'ترينيداد وتوباجو', 'Trinidad a', 'TT', '1-868'),
(432, 'تونس', 'Tunisia', 'TN', '216'),
(433, 'تركيا', 'Turkey', 'TR', '90'),
(434, 'تركمانستان', 'Turkmenist', 'TM', '993'),
(435, 'جزر تركس وكايكوس', 'Turks and ', 'TC', '1-649'),
(436, 'توفالو', 'Tuvalu', 'TV', '688'),
(437, 'جزر فيرجن', 'U.S. Virgi', 'VI', '1-340'),
(438, 'أوغندا', 'Uganda', 'UG', '256'),
(439, 'أوكرانيا', 'Ukraine', 'UA', '380'),
(440, 'الإمارات العربية المتحدة', 'United Ara', 'AE', '971'),
(441, 'المملكة المتحدة', 'United Kin', 'GB', '44'),
(442, 'الولايات المتحدة', 'United Sta', 'US', '1'),
(443, 'أوروجواي', 'Uruguay', 'UY', '598'),
(444, 'أوزبكستان', 'Uzbekistan', 'UZ', '998'),
(445, 'فانواتو', 'Vanuatu', 'VU', '678'),
(446, 'الكرسي الرسولي (الفاتيكان)', 'Vatican', 'VA', '379'),
(447, 'فنزويلا', 'Venezuela', 'VE', '58'),
(448, 'فيتنام', 'Vietnam', 'VN', '84'),
(449, 'واليس وفوتونا', 'Wallis and', 'WF', '681'),
(450, 'الصحراء الغربية', 'Western Sa', 'EH', '212'),
(451, 'اليمن', 'Yemen', 'YE', '967'),
(452, 'زامبيا', 'Zambia', 'ZM', '260'),
(453, 'زيمبابوي', 'Zimbabwe', 'ZW', '263');

-- --------------------------------------------------------

--
-- Table structure for table `dashboard_settings`
--

DROP TABLE IF EXISTS `dashboard_settings`;
CREATE TABLE IF NOT EXISTS `dashboard_settings` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `general_alert` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint NOT NULL,
  `updated_by` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dashboard_settings`
--

INSERT INTO `dashboard_settings` (`id`, `name`, `icon`, `code`, `status`, `general_alert`, `address`, `phone`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'AEICO-KSA', 'uploads/logo/dashboard_logo_1_20221001_190501.png', '1', 1, 'none', 'Elqassim Buraydah', '0554545454', 1, 1, '2022-09-29 14:11:47', '2022-10-07 18:07:26');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
CREATE TABLE IF NOT EXISTS `invoices` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(120) DEFAULT NULL,
  `client` bigint UNSIGNED DEFAULT NULL,
  `type` bigint NOT NULL,
  `number` varchar(14) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `Updated_at` datetime DEFAULT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `company` int DEFAULT NULL,
  `status` tinyint DEFAULT '0',
  `discount` decimal(7,2) DEFAULT NULL,
  `VAT` decimal(5,2) DEFAULT NULL,
  `TAX` decimal(5,2) DEFAULT NULL,
  `claiming_at` datetime DEFAULT NULL,
  `account` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `invoices_ibfk_1` (`created_by`),
  KEY `invoices_ibfk_2` (`updated_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_09_23_145349_create_admins_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `money_pass_rules`
--

DROP TABLE IF EXISTS `money_pass_rules`;
CREATE TABLE IF NOT EXISTS `money_pass_rules` (
  `id` int NOT NULL AUTO_INCREMENT,
  `treasury_id` int NOT NULL,
  `push_to` int DEFAULT NULL,
  `pull_from` int DEFAULT NULL,
  `created_by` int NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `company` int NOT NULL,
  `status` tinyint DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `money_pass_rules`
--

INSERT INTO `money_pass_rules` (`id`, `treasury_id`, `push_to`, `pull_from`, `created_by`, `created_at`, `updated_at`, `updated_by`, `company`, `status`) VALUES
(1, 10, 11, NULL, 1, '2022-10-16 11:09:49', NULL, NULL, 1, 0),
(2, 11, 11, 11, 1, '2022-10-16 11:09:49', NULL, NULL, 1, 0),
(3, 12, 11, NULL, 1, '2022-10-16 11:09:49', NULL, NULL, 1, 0),
(4, 13, 11, NULL, 1, '2022-10-16 11:09:49', NULL, NULL, 1, 0),
(5, 14, 11, NULL, 1, '2022-10-16 11:09:49', NULL, NULL, 1, 0),
(6, 15, 11, NULL, 1, '2022-10-16 11:09:49', NULL, NULL, 1, 0),
(7, 16, 11, NULL, 1, '2022-10-16 11:09:49', NULL, NULL, 1, 0),
(8, 17, 11, NULL, 1, '2022-10-16 11:09:49', NULL, NULL, 1, 0),
(9, 19, 11, NULL, 1, '2022-10-22 09:00:45', NULL, NULL, 1, 0),
(10, 18, 14, NULL, 1, '2022-10-22 06:48:35', '2022-10-22 06:48:35', NULL, 1, 0),
(16, 14, 18, NULL, 1, '2022-10-22 11:24:16', '2022-10-22 11:24:16', NULL, 1, 0),
(17, 18, 11, NULL, 1, '2022-10-22 11:25:20', '2022-10-22 11:25:20', NULL, 1, 0),
(18, 10, 18, NULL, 1, '2022-10-22 11:31:04', '2022-10-22 11:31:04', NULL, 1, 0),
(19, 18, NULL, 10, 1, '2022-10-22 11:31:04', '2022-10-22 11:31:04', NULL, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_categories`
--

DROP TABLE IF EXISTS `sales_categories`;
CREATE TABLE IF NOT EXISTS `sales_categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `parent` bigint UNSIGNED DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` bigint NOT NULL,
  `updated_by` bigint DEFAULT NULL,
  `company` bigint NOT NULL,
  `status` tinyint DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `parent` (`parent`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sales_categories`
--

INSERT INTO `sales_categories` (`id`, `name`, `parent`, `created_at`, `updated_at`, `created_by`, `updated_by`, `company`, `status`) VALUES
(1, 'Root', NULL, '2022-10-28 12:55:23', '2022-10-28 12:55:23', 1, 1, 1, 1),
(2, 'Poly Ethiline -2', 1, '2022-10-28 13:00:15', '2022-10-29 09:53:16', 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `slides`
--

DROP TABLE IF EXISTS `slides`;
CREATE TABLE IF NOT EXISTS `slides` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `slideImage` char(50) NOT NULL,
  `slideTitle` varchar(255) NOT NULL,
  `slideParagraph` varchar(1024) NOT NULL,
  `slideUrl` varchar(1024) DEFAULT NULL,
  `page` bigint DEFAULT NULL,
  `created_by` bigint NOT NULL,
  `updated_by` bigint DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `slides`
--

INSERT INTO `slides` (`id`, `slideImage`, `slideTitle`, `slideParagraph`, `slideUrl`, `page`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'carousel_slide_230105_115820.jpg', 'Image Number 1', 'TuxCare Extended Lifecycle Support. An SLA Guarantee for Critical CVEs. Talk to an Expert! System Administrators Keep Infrastructure Always-on. Benefit from the Expertise of a Team. 24/7 Expert Support. Linux Kernel Live Patches. No annual commitment. No Server Reboots.', 'contact.view', NULL, 1, NULL, '2023-01-05 11:20:58', '2023-01-05 11:20:58'),
(2, 'carousel_slide_230108_063700.jpg', 'Slide Number 2', 'JavaScript animations are done by programming gradual changes in an element\'s style. The changes are called by a timer. When the timer interval is small, the ...', 'contactrus', NULL, 1, NULL, '2023-01-08 06:00:37', '2023-01-08 06:00:37'),
(3, 'carousel_slide_230108_062301.bmp', 'Slide No 3', 'JavaScript animations are done by programming gradual changes in an element\'s style. The changes are called by a timer. When the timer interval is small, the ...', 'About', NULL, 1, NULL, '2023-01-08 06:01:23', '2023-01-08 06:01:23');

-- --------------------------------------------------------

--
-- Table structure for table `treasuries`
--

DROP TABLE IF EXISTS `treasuries`;
CREATE TABLE IF NOT EXISTS `treasuries` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `type` tinyint(1) DEFAULT '0',
  `parent` bigint UNSIGNED NOT NULL,
  `last_money_out` decimal(10,2) DEFAULT '0.00',
  `last_money_in` decimal(10,2) DEFAULT '0.00',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` bigint NOT NULL,
  `updated_by` bigint DEFAULT NULL,
  `company` bigint NOT NULL,
  `cashier` int DEFAULT NULL,
  `status` tinyint DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `treasuries`
--

INSERT INTO `treasuries` (`id`, `name`, `type`, `parent`, `last_money_out`, `last_money_in`, `created_at`, `updated_at`, `created_by`, `updated_by`, `company`, `cashier`, `status`) VALUES
(10, 'El Qassim 2', 3, 11, '0.00', '0.00', '2022-10-08 19:48:25', '2022-10-22 11:31:04', 1, 1, 1, 1, 0),
(11, 'Mulidaa', 1, 0, '0.00', '0.00', '2022-10-08 20:02:27', '2022-10-14 04:33:59', 1, 1, 1, 1, 0),
(12, 'Riyadh Tr 1', 3, 11, '0.00', '0.00', '2022-10-14 05:16:37', '2022-10-14 05:16:37', 1, NULL, 1, 1, 0),
(13, 'Treasury No 138 - Qassim', 3, 12, '0.00', '0.00', '2022-10-14 05:55:22', '2022-10-16 05:44:37', 1, 1, 1, 1, 0),
(14, 'asdrft', 2, 12, '0.00', '0.00', '2022-10-15 19:24:20', '2022-10-22 11:24:16', 1, 1, 1, 1, 0),
(15, 'huytgk', 3, 12, '0.00', '0.00', '2022-10-15 19:25:12', '2022-10-16 05:36:51', 1, 1, 1, 1, 1),
(16, 'tyyrt', 3, 10, '0.00', '0.00', '2022-10-16 07:47:12', '2022-10-16 07:47:12', 1, NULL, 1, 1, 0),
(17, 'tyyrt2', 2, 10, '0.00', '0.00', '2022-10-16 07:52:07', '2022-10-28 04:38:55', 1, NULL, 1, 1, 1),
(18, 'Branche Treasury', 2, 12, '0.00', '0.00', '2022-10-22 04:59:21', '2022-10-28 04:38:54', 1, 1, 1, 1, 1),
(19, 'New Branche Treasury', 2, 12, '0.00', '0.00', '2022-10-22 04:59:21', '2022-10-28 04:38:51', 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `business_categories`
--
ALTER TABLE `business_categories`
  ADD CONSTRAINT `business_categories_ibfk_1` FOREIGN KEY (`type`) REFERENCES `business_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `business_items`
--
ALTER TABLE `business_items`
  ADD CONSTRAINT `business_items_ibfk_1` FOREIGN KEY (`category`) REFERENCES `business_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `business_items_apps`
--
ALTER TABLE `business_items_apps`
  ADD CONSTRAINT `business_items_apps_ibfk_1` FOREIGN KEY (`item`) REFERENCES `business_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `business_items_specs`
--
ALTER TABLE `business_items_specs`
  ADD CONSTRAINT `business_items_specs_ibfk_1` FOREIGN KEY (`item`) REFERENCES `business_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `business_items_standard`
--
ALTER TABLE `business_items_standard`
  ADD CONSTRAINT `business_items_standard_ibfk_1` FOREIGN KEY (`item`) REFERENCES `business_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `business_items_uploads`
--
ALTER TABLE `business_items_uploads`
  ADD CONSTRAINT `business_items_uploads_ibfk_1` FOREIGN KEY (`item`) REFERENCES `business_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `invoices_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sales_categories`
--
ALTER TABLE `sales_categories`
  ADD CONSTRAINT `sales_categories_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `sales_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
