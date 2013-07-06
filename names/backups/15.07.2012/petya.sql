-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 20, 2012 at 06:49 PM
-- Server version: 5.5.25
-- PHP Version: 5.3.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `petya`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `cid` int(10) NOT NULL AUTO_INCREMENT COMMENT 'category ID',
  `cname` varchar(255) NOT NULL DEFAULT 'input' COMMENT 'category NAME',
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cid`, `cname`) VALUES
(1, 'inbox'),
(4, 'site'),
(5, 'MIT'),
(10, 'Learning'),
(13, 'Everyday'),
(14, 'Ideas'),
(15, 'GRID WORK'),
(20, 'for TODAY'),
(21, 'films');

-- --------------------------------------------------------

--
-- Table structure for table `todos`
--

CREATE TABLE IF NOT EXISTS `todos` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'to do ID',
  `name` varchar(255) NOT NULL DEFAULT 'input' COMMENT 'to do Entry',
  `cid` int(10) NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=282 ;

--
-- Dumping data for table `todos`
--

INSERT INTO `todos` (`tid`, `name`, `cid`) VALUES
(220, 'Нужно добавить автоматическую высоту для поля редактирования записей, и, чтобы текст был на все поле', 4),
(227, 'Medical Form', 20),
(228, 'Account pay', 5),
(242, 'Найти лаборатории по искуственному интелекту в MIT', 5),
(243, 'Добавить между полем для ввода и кнопкой "+" выбор категории.', 4),
(246, '[Отложено] прочитать Гарвардскую/McKinsey книжку', 10),
(248, 'Управляемые сны - решать задачи во сне. найти в гарварде и MIT лаборатории, которые могут заниматься чем то похожим.', 14),
(249, 'Нужно найти статьи про разложение AC уравнений и попытаться связать линейный отклик через двойной ( для начала найти выражение для линейного отклика вообще )', 15),
(255, 'Посмотреть лекции Venture Lab', 10),
(256, 'Встать на учет', 13),
(257, 'Разобраться с влиянием трансформаторов', 15),
(261, 'Скачать книжки, которые Паша порекомендовал', 20),
(262, 'Спросить - можно ли участвовать в нескольких проектах одновременно', 20),
(263, 'Спросить про досрочное окончание магистратуры', 5),
(264, 'проверить сбербанковскую карточку, когда придут коробки', 13),
(266, 'Добавить возможность "избранного"', 4),
(267, 'Сделать задачи более тонкими, чтобы больше вмещалось на страницу', 4),
(268, 'Добавить папку "удаленные"', 20),
(269, 'Прочитать 2 главы книжки, которую Данилка порекомендовал', 20),
(270, 'вотчмену написать', 1),
(271, 'выбрать курсы', 5),
(272, 'Global Entrepreneurship Lab, Raising Early Stage Capital, New Enterprises, Entrepreneurial Finance и другие. посмотреть эти предпринимательские курсы', 5),
(273, 'Прочитать про бизнес в целом, про operations', 10),
(274, 'Найти курсы по operations, финансам и бухучету в MIT', 5),
(275, 'bloomberg business week', 20),
(276, 'прочитать главу книги, которую костя прислал', 20),
(277, 'Спросить у Паши чем он конкретно будет заниматься', 10),
(278, 'тайное окно', 21),
(279, 'жилец', 21),
(280, 'преследование', 21),
(281, 'Продумать хронометраж', 20);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
