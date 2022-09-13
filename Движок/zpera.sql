-- MySQL dump 10.13  Distrib 5.1.31, for debian-linux-gnu (i486)
--
-- Host: localhost    Database: era
-- ------------------------------------------------------
-- Server version	5.1.31-1ubuntu2-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `metaattribute`
--

DROP TABLE IF EXISTS `metaattribute`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `metaattribute` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `metaobject_id` int(10) unsigned NOT NULL,
  `code` varchar(255) NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  `typeparam` varchar(255) NOT NULL DEFAULT '',
  `role` tinyint(3) unsigned NOT NULL DEFAULT '3',
  PRIMARY KEY (`id`),
  KEY `ix__metaattribute__metaobject_id` (`metaobject_id`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `metaattribute`
--

LOCK TABLES `metaattribute` WRITE;
/*!40000 ALTER TABLE `metaattribute` DISABLE KEYS */;
INSERT INTO `metaattribute` VALUES (1,1,'metaobject_id',13,'metaobject',3),(2,1,'name',4,'',3),(3,1,'sortby',4,'',3),(4,1,'sortorder',4,'',3),(5,1,'groupby',4,'',3),(6,1,'groupstyle',4,'',3),(7,1,'action_list',10,'',3),(8,1,'action_view',10,'',3),(9,1,'action_create',10,'',3),(10,1,'action_edit',10,'',3),(11,1,'action_delete',10,'',3),(12,1,'export_metaattribute_id',13,'metaattribute',3),(13,1,'menupos',2,'',3),(14,2,'id',1,'',1),(15,2,'_id',13,'sysuser',3),(16,2,'email',4,'',3),(17,2,'pwd',17,'',3),(18,2,'enabled',10,'',3),(19,2,'name',4,'',3),(20,2,'cfghtmlarea',10,'',3),(21,3,'id',1,'',1),(22,3,'code',4,'',3),(23,3,'value',4,'',3),(24,4,'id',1,'',1),(25,4,'sysuser_id',13,'sysuser',3),(26,4,'metaobject_id',13,'metaobject',3),(27,4,'object_id',13,'*',3),(28,4,'metaview_id',13,'metaview',3),(29,4,'rights',2,'',3),(30,5,'id',1,'',1),(31,5,'code',4,'',3),(32,5,'name',4,'',3),(33,5,'menupos',2,'',3),(34,6,'id',1,'',1),(35,6,'file',7,'',3),(36,6,'path',4,'',3),(37,6,'name',4,'',3),(38,6,'size',2,'',3),(39,6,'type_id',13,'',3),(40,6,'dt',8,'',3),(41,6,'attached',10,'',3),(42,7,'id',1,'',1),(43,7,'image',7,'',3),(44,7,'preview',7,'',3),(45,7,'path',4,'',3),(46,7,'previewpath',4,'',3),(47,7,'name',4,'',3),(48,7,'size',2,'',3),(49,7,'width',2,'',3),(50,7,'height',2,'',3),(51,7,'type_id',13,'',3),(52,7,'dt',8,'',3),(53,7,'attached',10,'',3),(54,8,'id',1,'',1),(55,8,'ext',4,'',3),(56,8,'name',4,'',3),(57,8,'category',4,'',3),(58,9,'id',1,'',1),(59,9,'code',4,'',3),(60,9,'name',4,'',3),(61,10,'id',1,'',1),(62,10,'code',4,'',3),(63,10,'name',4,'',3),(64,11,'id',1,'',1),(65,11,'_id',13,'stdpage',2),(66,11,'url',4,'',2),(67,11,'stdtemplate_id',13,'stdtemplate',2),(68,11,'stdmodule_id',13,'stdmodule',3),(69,11,'name',4,'',3),(70,11,'windowname',4,'',3),(71,11,'content',5,'',3),(72,11,'pos',2,'',3),(73,11,'menuname',4,'',3),(74,11,'metakeywords',4,'',3),(75,11,'metadescription',4,'',3),(76,12,'id',1,'',1),(77,12,'name',4,'',3),(78,12,'dt',8,'',3),(79,12,'text',5,'',3),(80,13,'id',1,'',1),(81,13,'name',4,'',3),(82,13,'image',12,'servicecat',3),(83,13,'text',5,'',3),(84,14,'id',1,'',1),(85,14,'email',4,'',3),(86,15,'id',1,'',1),(87,15,'name',4,'',3),(88,15,'dt',9,'',3),(89,15,'type',15,'',3),(90,15,'file',11,'',3),(91,13,'pos',2,'',3),(94,11,'form_email',4,'',3),(95,11,'form_name',4,'',3),(96,11,'form_phone',4,'',3);
/*!40000 ALTER TABLE `metaattribute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `metalink`
--

DROP TABLE IF EXISTS `metalink`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `metalink` (
  `metaattribute_id` int(10) unsigned NOT NULL,
  `object_id` int(10) unsigned NOT NULL,
  `linkedobject_id` int(10) unsigned NOT NULL,
  KEY `ix__metalink__metaattribute_id` (`metaattribute_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `metalink`
--

LOCK TABLES `metalink` WRITE;
/*!40000 ALTER TABLE `metalink` DISABLE KEYS */;
/*!40000 ALTER TABLE `metalink` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `metaobject`
--

DROP TABLE IF EXISTS `metaobject`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `metaobject` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `versions` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `logs` tinyint(1) unsigned DEFAULT '0',
  `extendsmetaobject_id` int(10) unsigned NOT NULL DEFAULT '0',
  `extendstype` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `ix__metaobject__code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `metaobject`
--

LOCK TABLES `metaobject` WRITE;
/*!40000 ALTER TABLE `metaobject` DISABLE KEYS */;
INSERT INTO `metaobject` VALUES (1,'sysparams',0,0,0,0),(2,'sysuser',0,0,0,0),(3,'sysconfig',0,0,0,0),(4,'syssecurity',0,0,0,0),(5,'sysmodule',0,0,0,0),(6,'stdfile',0,0,0,0),(7,'stdimage',0,0,0,0),(8,'stdfiletype',0,0,0,0),(9,'stdmodule',0,0,0,0),(10,'stdtemplate',0,0,0,0),(11,'stdpage',0,0,0,0),(12,'news',0,0,0,0),(13,'project',0,0,0,0),(14,'subscribe',0,0,0,0),(15,'report',0,0,0,0);
/*!40000 ALTER TABLE `metaobject` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `metarelation`
--

DROP TABLE IF EXISTS `metarelation`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `metarelation` (
  `from` int(10) unsigned NOT NULL,
  `to` int(10) unsigned NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  KEY `ix__metarelation__from` (`from`),
  KEY `ix__metarelation__to` (`to`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `metarelation`
--

LOCK TABLES `metarelation` WRITE;
/*!40000 ALTER TABLE `metarelation` DISABLE KEYS */;
/*!40000 ALTER TABLE `metarelation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `metaview`
--

DROP TABLE IF EXISTS `metaview`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `metaview` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `metaobject_id` int(10) unsigned NOT NULL,
  `code` varchar(255) NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `tree_metaobject_id` int(10) unsigned NOT NULL DEFAULT '0',
  `template` text NOT NULL,
  `templaterow` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ix__metaview__metaobject_id` (`metaobject_id`),
  KEY `ix__metaview__code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `metaview`
--

LOCK TABLES `metaview` WRITE;
/*!40000 ALTER TABLE `metaview` DISABLE KEYS */;
INSERT INTO `metaview` VALUES (1,11,'stdpage_form',1,'Форма',0,'',''),(2,12,'news_list',2,'Новости',0,'',''),(3,12,'news_form',1,'Новость',0,'',''),(4,12,'news_card',3,'Новость',0,'',''),(5,13,'project_list',2,'Проекты',0,'',''),(6,13,'project_form',1,'Проект',0,'',''),(7,13,'project_card',3,'Проект',0,'',''),(8,14,'subscribe_list',2,'Подписчики',0,'',''),(9,14,'subscribe_form',1,'Подписчик',0,'',''),(10,14,'subscribe_card',3,'Подписчик',0,'',''),(11,15,'report_list',2,'Документы',0,'',''),(12,15,'report_form',1,'Документ',0,'',''),(13,15,'report_card',3,'Документ',0,'','');
/*!40000 ALTER TABLE `metaview` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `metaviewcondition`
--

DROP TABLE IF EXISTS `metaviewcondition`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `metaviewcondition` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `metaview_id` int(10) unsigned NOT NULL,
  `metaattribute_id` int(10) unsigned NOT NULL,
  `operation` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL DEFAULT '',
  `sql` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `ix__metaviewcondition__metaview_id` (`metaview_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `metaviewcondition`
--

LOCK TABLES `metaviewcondition` WRITE;
/*!40000 ALTER TABLE `metaviewcondition` DISABLE KEYS */;
/*!40000 ALTER TABLE `metaviewcondition` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `metaviewfield`
--

DROP TABLE IF EXISTS `metaviewfield`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `metaviewfield` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `metaview_id` int(10) unsigned NOT NULL,
  `metaattribute_id` int(10) unsigned NOT NULL,
  `uie` varchar(255) NOT NULL DEFAULT '',
  `uieparams` varchar(255) NOT NULL DEFAULT '',
  `defaultvalue` varchar(255) NOT NULL DEFAULT '',
  `required` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `hint` varchar(255) NOT NULL DEFAULT '',
  `unit` varchar(255) NOT NULL DEFAULT '',
  `mask` varchar(255) NOT NULL DEFAULT '',
  `group` varchar(255) NOT NULL DEFAULT '',
  `pos` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ix__metaviewfield__metaview_id` (`metaview_id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `metaviewfield`
--

LOCK TABLES `metaviewfield` WRITE;
/*!40000 ALTER TABLE `metaviewfield` DISABLE KEYS */;
INSERT INTO `metaviewfield` VALUES (1,1,69,'','','',1,'Заголовок','Заголовок страницы','','','',1),(2,1,73,'','','',1,'Заголовок в меню','Название пункта меню','','','',2),(3,1,70,'','','',1,'Заголовок окна','','','','',3),(4,1,71,'','','',1,'Контент','Основное содержание страницы','','','',4),(5,1,72,'','','',1,'Порядок','Порядок сортировки страниц в меню','','','',5),(6,1,74,'','','',0,'Meta keywords','','','','',6),(7,1,75,'','','',0,'Meta description','','','','',7),(8,2,77,'','','',0,'Заголовок','','','','',1),(9,2,78,'','','',0,'Дата','','','','',2),(10,3,77,'','','',0,'Заголовок','','','','',1),(11,3,78,'','','NOW',0,'Дата','','','','',2),(12,3,79,'','','',0,'Текст','','','','',3),(13,4,77,'','','',0,'Заголовок','','','','',1),(14,4,78,'','','',0,'Дата','','','','',2),(15,4,79,'','','',0,'Текст','','','','',3),(16,5,81,'','','',0,'Название','','','','',1),(17,6,81,'','','',0,'Название','','','','',1),(18,6,82,'','','',0,'Картинка','','','','',2),(19,6,83,'','','',0,'Текст','','','','',3),(20,7,81,'','','',0,'Название','','','','',1),(21,7,82,'','','',0,'Картинка','','','','',2),(22,7,83,'','','',0,'Текст','','','','',3),(23,8,85,'','','',0,'E-mail','','','','',1),(24,9,85,'','','',0,'E-mail','','','','',1),(25,10,85,'','','',0,'E-mail','','','','',1),(26,11,87,'','','',0,'Название','','','','',1),(27,11,88,'','','',0,'Дата','','','','',2),(28,11,89,'','','',0,'Тип','','','','',3),(29,11,90,'','','',0,'Файл','','','','',4),(30,12,87,'','','',0,'Название','','','','',1),(31,12,88,'','','NOW',0,'Дата','','','','',2),(32,12,89,'','','',0,'Тип','','','','',3),(33,12,90,'','','',0,'Файл','','','','',4),(34,13,87,'','','',0,'Название','','','','',1),(35,13,88,'','','',0,'Дата','','','','',2),(36,13,89,'','','',0,'Тип','','','','',3),(37,13,90,'','','',0,'Файл','','','','',4),(38,5,91,'','','',0,'Прядок','','','','',2),(39,6,91,'','','',0,'Прядок','','','','',4),(40,7,91,'','','',0,'Прядок','','','','',4),(43,1,94,'','','',0,'Форма сообщения (E-mail)','','','','',8),(44,1,95,'','','',0,'Форма сообщения (Имя)','','','','',9),(45,1,96,'','','',0,'Форма сообщения (Телефон)','','','','',10);
/*!40000 ALTER TABLE `metaviewfield` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `dt` datetime NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` VALUES (17,'','2009-11-24 14:22:00','<p><a href=\"/news/\">Открылся официальный сайт ОАО \"Зеленодольское&nbsp; предприятие \"ЭРА\"</a></p>');
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project`
--

DROP TABLE IF EXISTS `project`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `project` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `image` int(10) unsigned NOT NULL DEFAULT '0',
  `text` text NOT NULL,
  `pos` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `project`
--

LOCK TABLES `project` WRITE;
/*!40000 ALTER TABLE `project` DISABLE KEYS */;
INSERT INTO `project` VALUES (3,'Проект 15790Т танкер &quot;Андропов&quot;',5,'<p>Танкер \"Андропов\"&nbsp;проекта 15790Т&nbsp; предназначен для перевозки одного сорта груза: нефти и нефтепродуктов без ограничения по температуре вспышки паров, в том числе требующих подогрева;нефтеподобных веществ;растительных масел и др.</p>\r\n<p>\r\n<table style=\"width: 495px; height: 40px;\" border=\"0\">\r\n<tbody>\r\n<tr>\r\n<td>Завод-строитель</td>\r\n<td>Судостроительный завод \"Кама\" г. Пермь</td>\r\n</tr>\r\n<tr>\r\n<td>Водоизмещение, т</td>\r\n<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 6885</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</p>',12),(4,'ГПА-16 &quot;Волга&quot;',6,'<h2>Газоперекачивающий агрегат ГПА-16 \"Волга\"</h2>\r\n<p>Монтаж и сдача в эксплуатацию&nbsp;в 1998 году&nbsp;газоперекачивающего агрегата ГПА-16 &laquo;Волга&raquo; для компрессорной станции (КС) &laquo;Помарская&raquo;&nbsp; положило начало сотрудничеству&nbsp; с ОАО &laquo;Газпром&raquo;.</p>\r\n<p>Данный проект успешно эксплуатируется на КС&nbsp;&nbsp;\"Помарская\", \"Приполярная\", \"Ново-Арзамасская\", в настоящее время предприятие ведет работы для КС \"Ивановская\", \"Лукояновская\".&nbsp;</p>',17),(5,'ПБК &quot;Обский-1&quot;',7,'<p>Плавучий буровой комплекс (ПБК)&nbsp;\"Обский -1\" предназначен для бурения разведочных скважин. ПБК \"Обский-1\" состоит из двух частей: ППБУ и ПБКОБ. Плавучая погружная буровая установка (ППБУ) предназначена для бурения разведочных нефтяных и газовых скважин глубиной до 2500 м в межледовый период при глубинах воды от 4 до 10 м. Плавучая база комплексного обеспечения бурения (ПБКОБ) - &nbsp;несамоходное судно технического флота, с надстройками, оборудованием и системами, обеспечивающими функционирование ППБУ и проживания обслуживающего персонала. Данный буровой комплекс находится&nbsp;в акватории Обской губы.</p>\r\n<p>\r\n<table style=\"width: 572px; height: 40px;\" border=\"0\">\r\n<tbody>\r\n<tr>\r\n<td>Завод-строитель</td>\r\n<td>Тюменский судостроительный завод</td>\r\n</tr>\r\n<tr>\r\n<td>Водоизмещение порожнем, т</td>\r\n<td>3541</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</p>',15),(6,'Проект 342 &quot;Метеор&quot;',8,'<p>Теплоход проекта 342 \"Метеор\" предназначен для скоростных перевозок пассажиров&nbsp; по судоходным рекам и пресноводным водохранилищам и озерам.</p>\r\n<p>\r\n<table style=\"height: 20px;\" border=\"0\" width=\"648\">\r\n<tbody>\r\n<tr>\r\n<td>Завод-строитель</td>\r\n<td>Зеленодольский судостроительный завод им.А.М.Горького</td>\r\n</tr>\r\n<tr>\r\n<td>Пассажировместимость, чел</td>\r\n<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 116</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>',6),(7,'Проект 1141 &quot;Сокол&quot;',9,'<p>Малый противолодочный корабль на подводных крыльях проекта 1141 &laquo;Сокол&raquo; предназначен для дозорной службы и охраны небольших прибрежных конвоев.</p>\r\n<p>\r\n<table style=\"height: 20px;\" border=\"0\" width=\"520\">\r\n<tbody>\r\n<tr>\r\n<td>&nbsp;&nbsp;Завод-строитель</td>\r\n<td>&nbsp;&nbsp;&nbsp; Зеленодольский судостроительный завод им.А.М.Горького</td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;&nbsp;Водоизмещение, т</td>\r\n<td>&nbsp;&nbsp;&nbsp; 500</td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;&nbsp;Экипаж,чел</td>\r\n<td>&nbsp;&nbsp;&nbsp; 45</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</p>',3),(9,'Проект 1239 &quot;Сивуч&quot;',11,'<p>Ракетный корабль на воздушной подушке проекта 1239 &laquo;Сивуч&raquo;&nbsp;является крупнейшим в своем подклассе российского и мирового кораблестроения быстроходным боевым кораблем, использующим гидродинамическую платформу - катамаран с аэростатической воздушной разгрузкой. Ракетный корабль на воздушной подушке предназначен для борьбы с боевыми надводными кораблями, быстроходными катерами и транспортами противника.&nbsp;</p>\r\n<p>\r\n<table style=\"height: 40px;\" border=\"0\" width=\"535\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td>Завод-строитель</td>\r\n<td>\r\n<p>&nbsp;&nbsp;&nbsp; Зеленодольский судостроительный завод им. А.М.Горького</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>Водоизмещение,т</td>\r\n<td>&nbsp;&nbsp;&nbsp; ок. 1000</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</p>',14),(10,'Проект 18061 &quot;Звук&quot;',12,'<p style=\"padding-left: 30px;\">Судно контроля и измерения физических полей&nbsp;&nbsp;проекта&nbsp;18061 \"Звук\" предназначено для проведения измерений&nbsp;акустических, электромагнитных, магнитных, тепловых полей надводных кораблей и субмарин.</p>\r\n<p style=\"padding-left: 30px;\">\r\n<table style=\"width: 623px; height: 58px;\" border=\"0\">\r\n<tbody>\r\n<tr>\r\n<td>Завод-строитель</td>\r\n<td>Зеленодольский судостроительный завод им.А.М.Горького</td>\r\n</tr>\r\n<tr>\r\n<td>Водоизмещение, т</td>\r\n<td>1450</td>\r\n</tr>\r\n<tr>\r\n<td>Экипаж</td>\r\n<td>61</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</p>',5),(11,'Проект 204 &quot;МПК&quot;',13,'<p>Малый противолодочный корабль проекта 204 с газотурбинными установками предназначен для борьбы в прибрежных районах с подводными лодками, имеющими подводную скорость хода более 30 узлов.&nbsp;</p>\r\n<p>\r\n<table style=\"height: 20px;\" border=\"0\" width=\"496\">\r\n<tbody>\r\n<tr>\r\n<td>&nbsp;&nbsp;&nbsp;&nbsp;Завод-строитель</td>\r\n<td>\r\n<p>&nbsp;Зеленодольский судостроительный&nbsp;завод&nbsp;&nbsp;им.А.М.Горького</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;&nbsp;&nbsp;&nbsp;Водоизмещение, т</td>\r\n<td>&nbsp;555</td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;&nbsp;&nbsp;&nbsp;Экипаж,чел</td>\r\n<td>&nbsp;54</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</p>',1),(12,'Проект 1159Т &quot;Ягуар&quot;',14,'<p>Сторожевой корабль&nbsp;проекта 1159Т &laquo;Ягуар&raquo;&nbsp;предназначен для дозорной службы и охраны небольших прибрежных конвоев.&nbsp;</p>\r\n<p>\r\n<table style=\"height: 20px;\" border=\"0\" width=\"533\">\r\n<tbody>\r\n<tr>\r\n<td>Завод-строитель</td>\r\n<td>Зеленодольский судостроительный завод им.А.М.Горького</td>\r\n</tr>\r\n<tr>\r\n<td>Водоизмещение, т&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>\r\n<td>1670</td>\r\n</tr>\r\n<tr>\r\n<td>Экипаж,чел</td>\r\n<td>96</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</p>',2),(13,'Проект 11661 корабль &quot;Татарстан&quot;',15,'<p style=\"padding-left: 60px;\">&nbsp;Сторожевой корабль&nbsp;проекта 11661 &nbsp;предназначен для поиска и борьбы с подводным, надводным и воздушным противником&nbsp;в экономической&nbsp;морской зоне.</p>\r\n<p style=\"padding-left: 60px;\">С 2003г.&nbsp;корабль \"Татарстан\" является флагманом Каспийской флотилии.&nbsp;</p>\r\n<p style=\"padding-left: 30px;\">\r\n<table style=\"height: 20px;\" border=\"0\" width=\"626\" align=\"right\">\r\n<tbody>\r\n<tr>\r\n<td>Завод-строитель</td>\r\n<td>&nbsp; Зеленодольский судостроительный завод им. А.М.Горького&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td>Водоизмещение, т</td>\r\n<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ок. 2000</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</p>',16),(15,'Проект 18071',18,'<p>Крановое судно \"Газшельф\" проекта 18071 предназначено для обеспечения строительства и работы морских буровых платформ и портов.&nbsp;</p>\r\n<p>\r\n<table style=\"width: 637px; height: 60px;\" border=\"0\" width=\"637\">\r\n<tbody>\r\n<tr>\r\n<td>Завод-строитель</td>\r\n<td>Судостроительный завод&nbsp;\"Красные Баррикады\", Астраханская область</td>\r\n</tr>\r\n<tr>\r\n<td>Грузоподъемность крана, т</td>\r\n<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 40</td>\r\n</tr>\r\n<tr>\r\n<td>Грузоподъемность судна, т</td>\r\n<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 500</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</p>',9),(16,'Проект 1570 &quot;Нефтерудовоз&quot;',19,'<p>Танкер&nbsp; проекта 1570&nbsp;типа \"Нефтерудовоз\"- это сухогрузно-наливной гибридный теплоход с сухогрузным трюмом по центру корпуса и танками для перевозки нефти и нефтепродуктов вдоль бортов.&nbsp;</p>\r\n<p>\r\n<table style=\"height: 20px;\" border=\"0\" width=\"586\">\r\n<tbody>\r\n<tr>\r\n<td>Завод-строитель</td>\r\n<td>Судостроительный завод &nbsp;\"Кама\" г.Пермь</td>\r\n</tr>\r\n<tr>\r\n<td>Грузоподъемность, т</td>\r\n<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2700</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</p>',11),(18,'Проект 1540 СПБУ &quot;Баку&quot;',21,'<p>Самоподъемная&nbsp; плавучая буровая установка проекта 1540 предназначена для&nbsp;ведения разведочных и эксплуатационных работ&nbsp;на нефть и газ в пределах морского шельфа.&nbsp;</p>\r\n<p>\r\n<table style=\"height: 20px;\" border=\"0\" width=\"621\">\r\n<tbody>\r\n<tr>\r\n<td>Завод-строитель</td>\r\n<td>&nbsp;Судостроительный завод \"Красные баррикады\" Астраханская область</td>\r\n</tr>\r\n<tr>\r\n<td>Водоизмещение,т</td>\r\n<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;11200</td>\r\n</tr>\r\n<tr>\r\n<td>Глубина моря, м</td>\r\n<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 60</td>\r\n</tr>\r\n<tr>\r\n<td>Глубина бурения, м</td>\r\n<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 6000</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</p>',7),(19,'Проект 1205 &quot;Скат&quot;',22,'<p>Десантный штурмовой катер на воздушной подушке&nbsp; проекта 1205&nbsp;\"Скат\"&nbsp;предназначен для переброски и высадки десанта методом берег-берег или корабль-берег, когда большие десантные корабли&nbsp;вынуждены разгружаться на значительном расстоянии от берега.&nbsp;</p>\r\n<p>\r\n<table style=\"height: 20px;\" border=\"0\" width=\"639\">\r\n<tbody>\r\n<tr>\r\n<td>Завод-строитель&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>\r\n<td>Зеленодольский судостроительный завод им.А.М.Горького</td>\r\n</tr>\r\n<tr>\r\n<td>Водоизмещение, т&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;</td>\r\n<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 27</td>\r\n</tr>\r\n<tr>\r\n<td>Экипаж,чел&nbsp;&nbsp;&nbsp;&nbsp;</td>\r\n<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</p>',4),(20,'Проект 1527 ПЛЭС &quot;Северное сияние&quot;',23,'<p>Плавучая газотурбинная&nbsp; электростанция \"Северное сияние\" проекта 1527 предназначена для энергоснабжения промышленных северо-восточных районах России.</p>\r\n<p>\r\n<table style=\"width: 457px; height: 40px;\" border=\"0\">\r\n<tbody>\r\n<tr>\r\n<td>Завод-строитель</td>\r\n<td>Тюменский судостроительный завод</td>\r\n</tr>\r\n<tr>\r\n<td>Экипаж, чел</td>\r\n<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 26</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</p>',8),(21,'Проект 16710',24,'<p>Стационарная&nbsp;платформа проекта 16710 предназначена для бурения и эксплуатации в Каспийском море 20 скважин. Верхнее строение состоит из комплексов: эксплуатационного, бурового, энергетического, жилого и жизнеобеспечения.</p>\r\n<p>\r\n<table style=\"height: 85px;\" border=\"0\" width=\"627\">\r\n<tbody>\r\n<tr>\r\n<td>Заводы-строители верхнего строения</td>\r\n<td>\r\n<p>Судостроительный завод \"Лотос\", &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Морской судостроительный завод, г. Астрахань</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>Глубина моря, м</td>\r\n<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 200</td>\r\n</tr>\r\n<tr>\r\n<td>Глубина бурения,&nbsp;м&nbsp;&nbsp;&nbsp;</td>\r\n<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 6500</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</p>',10),(22,'Проект 00120 танкер-заправщик',25,'<p>Морской танкер-заправщик проекта 00120 предназначен для бункеровки буровых платформ и плавтехсредств на морских месторождениях арктического шельфа, доставки топлива и ГСМ на месторождения Северных регионов, а также вывоза нефтепродуктов.</p>\r\n<p>\r\n<table style=\"height: 58px;\" border=\"0\" width=\"549\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td>&nbsp;Завод-строитель</td>\r\n<td>Судостроительный завод&nbsp;\"Красные Баррикады\", Астраханская область</td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;Грузоподъемность, т</td>\r\n<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 500</td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;Экипаж, чел</td>\r\n<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 15</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</p>',13);
/*!40000 ALTER TABLE `project` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report`
--

DROP TABLE IF EXISTS `report`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `report` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `dt` date NOT NULL,
  `type` enum('','Ежеквартальный отчет','Список аффилированных лиц','Изменение в списке аффилированных лиц','Сообщение о существенных фактах','Годовой отчет','Учредительские документы','Cведения, которые могут оказать существенное влияние на стоимость ценных бумаг') NOT NULL DEFAULT '',
  `file` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `report`
--

LOCK TABLES `report` WRITE;
/*!40000 ALTER TABLE `report` DISABLE KEYS */;
INSERT INTO `report` VALUES (1,'Ежеквартальный отчет за 2 квартал 2009','2009-08-05','Ежеквартальный отчет',1),(2,'Устав','2009-11-24','Учредительские документы',2),(10,'Ежеквартальный отчет за 1 квартал 2004','2004-05-20','Ежеквартальный отчет',47),(12,'Ежеквартальный отчет за 2 квартал 2004','2004-08-12','Ежеквартальный отчет',49),(13,'Ежеквартальный отчет за 3 квартал 2004','2004-11-15','Ежеквартальный отчет',50),(14,'Ежеквартальный отчет за 4 квартал 2004','2005-01-19','Ежеквартальный отчет',51),(15,'Ежеквартальный отчет за 1 квартал 2005','2005-05-11','Ежеквартальный отчет',52),(16,'Ежеквартальный отчет за 2 квартал 2005','2005-08-12','Ежеквартальный отчет',53),(17,'Ежеквартальный отчет за 3 квартал 2005','2005-11-10','Ежеквартальный отчет',54),(18,'Ежеквартальный отчет за 4 квартал 2005','2006-01-11','Ежеквартальный отчет',55),(19,'Ежеквартальный отчет за 1 квартал 2006','2006-05-13','Ежеквартальный отчет',56),(20,'Ежеквартальный отчет за 2 квартал 2006','2006-08-07','Ежеквартальный отчет',57),(21,'Ежеквартальный отчет за 3 квартал 2006','2006-11-03','Ежеквартальный отчет',58),(22,'Ежеквартальный отчет за 4 квартал 2006','2007-02-12','Ежеквартальный отчет',59),(23,'Ежеквартальный отчет за 1 квартал 2007','2007-05-07','Ежеквартальный отчет',60),(24,'Ежеквартальный отчет за 2 квартал 2007','2007-08-09','Ежеквартальный отчет',61),(25,'Ежеквартальный отчет за 3 квартал 2007','2007-11-12','Ежеквартальный отчет',62),(26,'Ежеквартальный отчет за 4 квартал 2007','2008-01-15','Ежеквартальный отчет',63),(27,'Ежеквартальный отчет за 1 квартал 2008','2008-05-14','Ежеквартальный отчет',64),(28,'Ежеквартальный отчет за 2 квартал 2008','2008-08-05','Ежеквартальный отчет',65),(29,'Ежеквартальный отчет за 3 квартал 2008','2008-11-13','Ежеквартальный отчет',66),(30,'Ежеквартальный отчет за 4 квартал 2008','2009-02-12','Ежеквартальный отчет',67),(31,'Ежеквартальный отчет за 1 квартал 2009','2009-05-12','Ежеквартальный отчет',68),(32,'Ежеквартальный отчет за 3 квартал 2009','2009-11-12','Ежеквартальный отчет',116),(33,'Устав новая редакция','2009-11-24','Учредительские документы',70),(34,'Положение о Совете директоров','2009-11-24','Учредительские документы',71),(35,'Положение о собрании','2009-11-24','Учредительские документы',72),(36,'Положение о Генеральном директоре','2009-11-24','Учредительские документы',73),(37,'Положение о Правлении','2009-11-24','Учредительские документы',74),(38,'Положение о Ревизионной комиссии','2009-11-24','Учредительские документы',75),(39,'Положение о Счетной комисии','2009-11-24','Учредительские документы',76),(40,'Годовой отчет за 2004 год','2009-11-24','Годовой отчет',77),(41,'Годовой отчет за 2005 год','2009-11-24','Годовой отчет',78),(42,'Годовой отчет за 2006 год','2009-11-24','Годовой отчет',79),(43,'Годовой отчет за 2007 год','2009-11-24','Годовой отчет',80),(44,'Годовой отчет за 2008 год','2009-11-24','Годовой отчет',81),(45,'Список аффилированных лиц на 31.03.2009','2009-03-31','Список аффилированных лиц',82),(46,'Список аффилированных лиц на 30.06.2009','2009-07-01','Список аффилированных лиц',83),(47,'Список аффилированных лиц на 30.09.2009','2009-10-01','Список аффилированных лиц',84),(48,'Об изменении адреса в сети Интернет, используемой акционерным обществом для раскрытия информации','2009-11-26','Cведения, которые могут оказать существенное влияние на стоимость ценных бумаг',85),(49,'Информация о принятых Советом директоров решениях','2009-11-26','Cведения, которые могут оказать существенное влияние на стоимость ценных бумаг',86),(50,'Сведения о дате закрытия реестра акционеров эмитента','2009-11-26','Сообщение о существенных фактах',87),(52,'Список аффилированных лиц на 31.03.2006','2006-03-31','Список аффилированных лиц',88),(53,'Список аффилированных лиц на 30.06.2006','2006-06-30','Список аффилированных лиц',89),(54,'Список аффилированных лиц на 30.09.2006','2006-09-30','Список аффилированных лиц',90),(55,'Список аффилированных лиц на 31.12.2006','2006-12-31','Список аффилированных лиц',91),(56,'Список аффилированных лиц на 31.03.2007','2007-03-31','Список аффилированных лиц',92),(57,'Список аффилированных лиц на 30.06.2007','2007-06-30','Список аффилированных лиц',93),(58,'Список аффилированных лиц на 30.09.2007','2007-09-30','Список аффилированных лиц',94),(59,'Список аффилированных лиц на 31.12.2007','2007-12-31','Список аффилированных лиц',95),(60,'Список аффилированных лиц на 31.03.2008','2008-03-31','Список аффилированных лиц',96),(61,'Список аффилированных лиц на 30.06.2008','2008-06-30','Список аффилированных лиц',97),(62,'Список аффилированных лиц на 30.09.2008','2008-09-30','Список аффилированных лиц',98),(63,'Список аффилированных лиц на 31.12.2008','2008-12-31','Список аффилированных лиц',99),(64,'Сведения о решениях общих собраний','2009-06-02','Сообщение о существенных фактах',100),(65,'Сведения о дате закрытия реестра акционеров эмитента','2009-06-02','Сообщение о существенных фактах',101),(66,'Сведения о решениях общих собраний','2009-06-29','Сообщение о существенных фактах',102),(67,'Сведения о фактах, повлекших за собой разовое увеличение (уменьшение) чистой прибыли или чистых убытков эмитента более чем на 10 процентов','2009-07-30','Сообщение о существенных фактах',103),(68,'Сведения о фактах, повлекших за собой разовое увеличение или уменьшение стоимости активов эмитента более чем на 10 процентов','2009-07-30','Сообщение о существенных фактах',104),(69,'Сведения о фактах, повлекших за собой разовое увеличение (уменьшение) чистой прибыли или чистых убытков эмитента более чем на 10 процентов','2009-10-30','Сообщение о существенных фактах',105),(70,'Сведения о фактах, повлекших за собой разовое увеличение или уменьшение стоимости активов эмитента более чем на 10 процентов','2009-10-30','Сообщение о существенных фактах',106),(71,'Информация о принятых советом директоров акционерного общества решениях','2009-06-02','Cведения, которые могут оказать существенное влияние на стоимость ценных бумаг',107),(72,'О совершении акционерным обществом сделки, в совершении которой имеется заинтересованность, необходимость одобрения которой уполномоченным органом управления акционерного общества предусмотрена законодательством РФ, если цена такой сделки составляет  5 и ','2009-07-07','Cведения, которые могут оказать существенное влияние на стоимость ценных бумаг',108),(73,'О совершении акционерным обществом сделки, в совершении которой имеется заинтересованность, необходимость одобрения которой уполномоченным органом управления акционерного общества предусмотрена законодательством РФ, если цена такой сделки составляет  5 и ','2009-07-07','Cведения, которые могут оказать существенное влияние на стоимость ценных бумаг',109),(74,'Список аффилированных лиц на 31.12.2009','2010-01-11','Список аффилированных лиц',111),(76,'Сведения о решениях общих собраний','2010-01-27','Сообщение о существенных фактах',113),(77,'Изменения в списке аффилированных лиц','2010-01-27','Изменение в списке аффилированных лиц',114),(78,'Ежеквартальный отчет за 4 квартал 2009','2010-02-10','Ежеквартальный отчет',117),(79,'Сведения о фактах, повлекших за собой разовое увеличение или уменьшение стоимости активов эмитента более чем на 10 процентов','2010-03-31','Сообщение о существенных фактах',118),(80,'Сведения о фактах, повлекших за собой разовое увеличение (уменьшение) чистой прибыли или чистых убытков эмитента более чем на 10 процентов','2010-03-31','Сообщение о существенных фактах',119),(81,'Список аффилированных лиц на 31.03.2010','2010-04-01','Список аффилированных лиц',120),(82,'Сведения о фактах, повлекших за собой разовое увеличение (уменьшение) чистой прибыли или чистых убытков эмитента более чем на 10 процентов','2010-05-04','Сообщение о существенных фактах',124),(83,'Ежеквартальный отчет за I квартал 2010 года','2010-05-12','Ежеквартальный отчет',125),(85,'Информация о принятых советом директоров акционерного общества решениях','2010-05-21','Cведения, которые могут оказать существенное влияние на стоимость ценных бумаг',127),(86,'Сведения о дате закрытия реестра акционеров эмитента','2010-05-21','Сообщение о существенных фактах',128),(87,'Информация о принятых советом директоров акционерного общества решениях','2010-06-08','Cведения, которые могут оказать существенное влияние на стоимость ценных бумаг',129),(88,'Сведения о дате закрытия реестра акционеров эмитента','2010-06-08','Сообщение о существенных фактах',130);
/*!40000 ALTER TABLE `report` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stdfile`
--

DROP TABLE IF EXISTS `stdfile`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `stdfile` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `file` mediumblob NOT NULL,
  `path` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `size` int(11) NOT NULL DEFAULT '0',
  `type_id` int(10) unsigned NOT NULL DEFAULT '0',
  `dt` datetime NOT NULL,
  `attached` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `stdfile`
--

LOCK TABLES `stdfile` WRITE;
/*!40000 ALTER TABLE `stdfile` DISABLE KEYS */;
INSERT INTO `stdfile` VALUES (1,'','report/dwnl258.doc','dwnl258.doc',794624,1,'2009-09-17 14:48:57',1),(2,'','report/dwnl121.zip','dwnl121.zip',28564,1,'2009-09-17 15:07:43',1),(8,'','upload/blanck-zakaza-dlya-sydostroitelnoi-otrasli.doc','blanck zakaza dlya sydostroitelnoi otrasli.doc',44032,1,'2009-10-26 15:52:59',0),(9,'','upload/Sklad-kabelya-po-sostoyaniyu-na-19.10.09g..rar','Sklad kabelya po sostoyaniyu na 19.10.09г..rar',23235,1,'2009-10-29 08:58:11',0),(10,'','upload/Sklad-sudovoi-armaturi-na-27.10.-2009g..xls','Sklad sudovoi armaturi na 27.10. 2009г..xls',22528,1,'2009-10-29 08:58:35',0),(12,'','upload/Sklad-elektrooborudovaniya-skladskogo-hraneniya-na-19.10.09g..rar','Sklad elektrooborudovaniya skladskogo hraneniya na 19.10.09г..rar',16139,1,'2009-10-29 08:58:23',0),(13,'','upload/Sklad-elektrooborudovanya-na-19.10.09g..xls','Sklad elektrooborudovanya na 19.10.09г..xls',25088,1,'2009-10-29 08:58:47',0),(14,'','upload/Sklad-kabelya-po-sostoyaniyu-na19.10.09g..xls','Sklad kabelya po sostoyaniyu na19.10.09г..xls',60928,1,'2009-10-29 08:57:56',0),(15,'','upload/Sklad-electrooborudovaniya-na-19.10.09g..rar','Sklad electrooborudovaniya na 19.10.09г..rar',4690,1,'2009-10-29 08:57:41',0),(16,'','upload/Sklad-electrooborudovaniya-scladskogo-hraneniya-na-19.10.09g..xls','Sklad electrooborudovaniya scladskogo hraneniya na 19.10.09г..xls',76800,1,'2009-10-29 08:59:18',0),(24,'','upload/GRSCH-1.jpg','ГРЩ 1.jpg',723422,2,'2009-11-10 08:59:03',0),(25,'','upload/GRSCH-2.jpg','ГРЩ 2.jpg',579844,2,'2009-11-10 08:59:22',0),(26,'','upload/hit-vspom-meh-i-svasi.jpg','hit vspom meh i svasi.jpg',799193,2,'2009-11-10 08:59:51',0),(29,'','upload/hit-postoannogo-toka.JPG','hit postoannogo toka.JPG',1648587,2,'2009-11-10 09:01:37',0),(33,'','upload/hit-pitania-electronagrevatela-1..JPG','hit pitania electronagrevatela 1..JPG',444507,2,'2009-11-11 09:38:58',0),(34,'','upload/hit-pitania-sap-1..JPG','hit pitania sap 1..JPG',318132,2,'2009-11-11 09:39:45',0),(35,'','upload/hit-pitania-teplonagrevatela-1..JPG','hit pitania teplonagrevatela 1..JPG',396360,2,'2009-11-11 09:40:07',0),(37,'','upload/ust-vo-plavnogo-puska.jpg','ust-vo plavnogo puska.jpg',1016111,2,'2009-11-11 14:02:35',0),(39,'','upload/hit-s-kontaktorom-.jpg','hit s kontaktorom .jpg',210136,2,'2009-11-11 14:03:21',0),(40,'','upload/hit-signalisacii-1.jpg','hit signalisacii 1.jpg',659338,2,'2009-11-16 09:27:37',0),(41,'','upload/pult-sudovoditela--1.jpg','pult sudovoditela  1.jpg',356613,2,'2009-11-16 09:27:56',0),(42,'','upload/pult-upravlenia-lebedkami-1.jpg','pult upravlenia lebedkami 1.jpg',540339,2,'2009-11-16 09:28:24',0),(43,'','upload/pult-upravlenia-tehprocessom.jpg','pult upravlenia tehprocessom.jpg',1192445,2,'2009-11-16 09:50:55',0),(47,'','report/qreport-2004-1_1.doc','qreport 2004-1.doc',1269248,1,'2009-11-25 14:05:38',1),(49,'','report/qreport-2004-2.doc','qreport 2004-2.doc',827904,1,'2009-11-25 14:09:17',1),(50,'','report/qreport-2004-3.doc','qreport 2004-3.doc',857600,1,'2009-11-25 14:10:30',1),(51,'','report/qreport-2004-4.doc','qreport 2004-4.doc',571904,1,'2009-11-25 14:12:22',1),(52,'','report/qreport-2005-1.doc','qreport 2005-1.doc',1050624,1,'2009-11-25 14:47:39',1),(53,'','report/qreport-2005-2.doc','qreport 2005-2.doc',719872,1,'2009-11-25 14:53:13',1),(54,'','report/qreport-2005-3.doc','qreport 2005-3.doc',663040,1,'2009-11-25 14:54:12',1),(55,'','report/qreport-2005-4.doc','qreport 2005-4.doc',440832,1,'2009-11-25 14:55:01',1),(56,'','report/qreport-2006-1.doc','qreport 2006-1.doc',1193984,1,'2009-11-25 14:57:16',1),(57,'','report/qreport-2006-2.doc','qreport 2006-2.doc',733696,1,'2009-11-25 14:58:59',1),(58,'','report/qreport-2006-3.doc','qreport 2006-3.doc',727552,1,'2009-11-25 14:59:56',1),(59,'','report/qreport-2006-4.doc','qreport 2006-4.doc',536064,1,'2009-11-25 15:00:46',1),(60,'','report/qreport-2007-1.doc','qreport 2007-1.doc',1124864,1,'2009-11-25 15:01:46',1),(61,'','report/qreport-2007-2.doc','qreport 2007-2.doc',697344,1,'2009-11-25 15:02:42',1),(62,'','report/qreport-2007-3.doc','qreport 2007-3.doc',752640,1,'2009-11-25 15:03:55',1),(63,'','report/qreport-2007-4.doc','qreport 2007-4.doc',530944,1,'2009-11-25 15:18:01',1),(64,'','report/qreport-2008-1.doc','qreport 2008-1.doc',1168896,1,'2009-11-25 15:18:59',1),(65,'','report/qreport-2008-2.doc','qreport 2008-2.doc',704512,1,'2009-11-25 15:19:55',1),(66,'','report/qreport-2008-3.doc','qreport 2008-3.doc',698880,1,'2009-11-25 15:20:39',1),(67,'','report/qreport-2008-4.doc','qreport 2008-4.doc',529920,1,'2009-11-25 15:24:27',1),(68,'','report/qreport-2009-1.doc','qreport 2009-1.doc',1188352,1,'2009-11-25 15:29:41',1),(69,'','report/qreport-2009-3.doc','qr0309.doc',741376,1,'2010-02-10 10:29:41',1),(70,'','report/ustavNew.doc','ustavNew.doc',160256,1,'2009-11-25 15:43:51',1),(71,'','report/SD.doc','SD.doc',115200,1,'2009-11-25 15:44:40',1),(72,'','report/Sobr.doc','Sobr.doc',162304,1,'2009-11-25 15:45:17',1),(73,'','report/GenDir.doc','GenDir.doc',44544,1,'2009-11-25 15:45:59',1),(74,'','report/Pravlenie.doc','Pravlenie.doc',64512,1,'2009-11-25 15:46:36',1),(75,'','report/Rev.doc','Rev.doc',58880,1,'2009-11-25 15:47:42',1),(76,'','report/Schet.doc','Schet.doc',98816,1,'2009-11-25 15:48:22',1),(77,'','report/GO-2004.doc','GO-2004.doc',76800,1,'2009-11-25 16:01:45',1),(78,'','report/GO-2005.doc','GO-2005.doc',97280,1,'2009-11-25 16:02:23',1),(79,'','report/GO-2006.doc','GO-2006.doc',87552,1,'2009-11-25 16:03:10',1),(80,'','report/GO-2007.doc','GO-2007.doc',80896,1,'2009-11-25 16:03:53',1),(81,'','report/GO-2008.doc','GO-2008.doc',85504,1,'2009-11-25 16:04:16',1),(82,'','report/alist-2009-1.doc','alist 2009-1.doc',147968,1,'2009-11-25 16:09:57',1),(83,'','report/alist-2009-2.doc','alist 2009-2.doc',195584,1,'2009-11-25 16:11:11',1),(84,'','report/alist-2009-3.doc','alist 2009-3.doc',110080,1,'2009-11-25 16:12:48',1),(85,'','report/sved-2009-5.doc','sved 2009-5.doc',49152,1,'2009-11-26 08:44:54',1),(86,'','report/sved-2009-6.doc','sved 2009-6.doc',61440,1,'2009-11-26 08:46:06',1),(87,'','report/event-2009-12.doc','event 2009-12.doc',35840,1,'2009-11-26 08:47:50',1),(88,'','report/alist-2006-1.doc','alist 2006-1.doc',85504,1,'2009-11-26 09:52:30',1),(89,'','report/alist-2006-2.doc','alist 2006-2.doc',123904,1,'2009-11-26 09:53:19',1),(90,'','report/alist-2006-3.doc','alist 2006-3.doc',117760,1,'2009-11-26 09:53:58',1),(91,'','report/alist-2006-4.doc','alist 2006-4.doc',99840,1,'2009-11-26 09:55:19',1),(92,'','report/alist-2007-1.doc','alist 2007-1.doc',88576,1,'2009-11-26 09:55:41',1),(93,'','report/alist-2007-2.doc','alist 2007-2.doc',88576,1,'2009-11-26 09:56:09',1),(94,'','report/alist-2007-3.doc','alist 2007-3.doc',120832,1,'2009-11-26 09:56:35',1),(95,'','report/alist-2007-4.doc','alist 2007-4.doc',93184,1,'2009-11-26 09:56:56',1),(96,'','report/alist-2008-1.doc','alist 2008-1.doc',104448,1,'2009-11-26 09:57:17',1),(97,'','report/alist-2008-2.doc','alist 2008-2.doc',121856,1,'2009-11-26 09:57:38',1),(98,'','report/alist-2008-3.doc','alist 2008-3.doc',98304,1,'2009-11-26 09:57:59',1),(99,'','report/alist-2008-4.doc','alist 2008-4.doc',84992,1,'2009-11-26 09:58:34',1),(100,'','report/event-2009-5.doc','event 2009-5.doc',55808,1,'2009-11-26 10:26:09',1),(101,'','report/event-2009-6.doc','event 2009-6.doc',35328,1,'2009-11-26 10:26:51',1),(102,'','report/event-2009-7.doc','event 2009-7.doc',45568,1,'2009-11-26 10:27:40',1),(103,'','report/event-2009-8.doc','event 2009-8.doc',36864,1,'2009-11-26 10:28:31',1),(104,'','report/event-2009-9.doc','event 2009-9.doc',36864,1,'2009-11-26 10:37:20',1),(105,'','report/event-2009-10.doc','event 2009-10.doc',36864,1,'2009-11-26 10:40:19',1),(106,'','report/event-2009-11.doc','event 2009-11.doc',36864,1,'2009-11-26 10:40:53',1),(107,'','report/sved-2009-2.doc','sved 2009-2.doc',80896,1,'2009-11-26 10:43:01',1),(108,'','report/sved-2009-3.doc','sved 2009-3.doc',59392,1,'2009-11-26 10:43:57',1),(109,'','report/sved-2009-4.doc','sved 2009-4.doc',59392,1,'2009-11-26 10:44:36',1),(110,'','report/spisok-aff--lic-na-31.12.09.doc','список афф  лиц на 31.12.09.doc',84480,1,'2010-01-26 14:39:24',1),(111,'','report/spisok-aff--lic-na-31.12.09_1.doc','список афф  лиц на 31.12.09.doc',84480,1,'2010-01-26 14:39:49',1),(113,'','report/event2010-1-ERA.doc','event2010-1 ЭРА.doc',55808,1,'2010-01-27 09:52:59',1),(114,'','report/izm.spiska-aff--lic-na-26.01.10_1.doc','изм.списка афф  лиц на 26.01.10.doc',129536,1,'2010-02-10 09:24:25',1),(115,'','report/qr0309.doc','qr0309.doc',741376,1,'2010-02-10 10:30:14',1),(116,'','report/qr0309_1.doc','qr0309.doc',741376,1,'2010-02-10 10:30:18',1),(117,'','report/qr0409.doc','qr0409.doc',468480,1,'2010-02-10 11:05:06',1),(118,'','report/event2010-2-ERA.doc','event2010-2 ЭРА.doc',37888,1,'2010-03-31 16:15:39',1),(119,'','report/event2010-3-ERA.doc','event2010-3 ЭРА.doc',36864,1,'2010-03-31 16:17:34',1),(120,'','report/spisok-aff--lic-na-31.03.10.doc','список афф  лиц на 31.03.10.doc',171520,1,'2010-04-01 13:39:20',1),(123,'','upload/yandex_4e89a13b89af15aa.txt.txt','yandex_4e89a13b89af15aa.txt.txt',0,1,'2010-04-16 14:32:59',0),(124,'','report/event2010-4-ERA.doc','event2010-4 ЭРА.doc',36864,1,'2010-05-04 12:22:50',1),(125,'','report/qr0110.doc','qr0110.doc',1368576,1,'2010-05-12 16:08:31',1),(127,'','report/sved-2010-1.doc','sved 2010-1.doc',64512,1,'2010-05-21 12:26:37',1),(128,'','report/event-2010-5.doc','event 2010-5.doc',35840,1,'2010-05-21 12:28:44',1),(129,'','report/sved-2010-2.doc','sved 2010-2.doc',73728,1,'2010-06-08 10:33:03',1),(130,'','report/event-2010-6.doc','event 2010-6.doc',35840,1,'2010-06-08 10:33:56',1);
/*!40000 ALTER TABLE `stdfile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stdfiletype`
--

DROP TABLE IF EXISTS `stdfiletype`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `stdfiletype` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ext` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `category` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `stdfiletype`
--

LOCK TABLES `stdfiletype` WRITE;
/*!40000 ALTER TABLE `stdfiletype` DISABLE KEYS */;
INSERT INTO `stdfiletype` VALUES (1,'','Неизвестный файл',''),(2,'jpg','Изображение JPEG','image'),(3,'mp3','Музыкальный файл MP3','audio');
/*!40000 ALTER TABLE `stdfiletype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stdimage`
--

DROP TABLE IF EXISTS `stdimage`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `stdimage` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `image` mediumblob NOT NULL,
  `preview` mediumblob NOT NULL,
  `path` varchar(255) NOT NULL DEFAULT '',
  `previewpath` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `size` int(11) NOT NULL DEFAULT '0',
  `width` int(11) NOT NULL DEFAULT '0',
  `height` int(11) NOT NULL DEFAULT '0',
  `type_id` int(10) unsigned NOT NULL DEFAULT '0',
  `dt` datetime NOT NULL,
  `attached` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `stdimage`
--

LOCK TABLES `stdimage` WRITE;
/*!40000 ALTER TABLE `stdimage` DISABLE KEYS */;
INSERT INTO `stdimage` VALUES (1,'','','upload/18061-Subbotin--foto-1-104437-v1.JPG','upload/@18061-Subbotin--foto-1-104437-v1.JPG','18061 Субботин  фото 1 (104437 v1).JPG',677891,1531,1087,2,'2009-10-27 14:23:59',0),(2,'','','upload/2-2.jpg','upload/@2-2.jpg','2-2.jpg',10203,200,150,2,'2009-10-20 16:14:58',0),(5,'','','project/Andropov.jpg','project/@Andropov.jpg','Андропов(2).jpg',26927,200,150,2,'2009-09-21 17:17:51',1),(6,'','','project/GPA-Novo-Arzamasskaya.jpg','project/@GPA-Novo-Arzamasskaya.jpg','ГПА Ново-Арзамасская.jpg',23764,200,150,2,'2009-09-21 15:38:34',1),(7,'','','project/Kamennomysskaya---more-14.jpg','project/@Kamennomysskaya---more-14.jpg','Каменномысская - море 14.jpg',31700,200,150,2,'2009-09-21 15:49:43',1),(8,'','','project/meteor2.jpg','project/@meteor2.jpg','метеор2.jpg',25373,200,150,2,'2009-10-19 10:32:18',1),(9,'','','project/pr.1141-Sokol.jpg','project/@pr.1141-Sokol.jpg','pr.1141-Sokol.jpg',21868,200,150,2,'2010-02-03 20:10:37',1),(11,'','','project/pr.1239-Sivuch.jpg','project/@pr.1239-Sivuch.jpg','пр.1239 Сивуч.jpg',24696,200,150,2,'2009-10-19 10:47:47',1),(12,'','','project/pr.18061-Subbotin-.jpg','project/@pr.18061-Subbotin-.jpg','18061 Субботин  фото 1 (104437 v1).jpg',23262,200,150,2,'2009-10-19 10:20:38',1),(13,'','','project/pr.-204-MPK.jpg','project/@pr.-204-MPK.jpg','204 ч_б фотография (104199 v1).jpg',27663,200,150,2,'2009-10-19 10:17:22',1),(14,'','','project/pr.1159-YAguar.jpg','project/@pr.1159-YAguar.jpg','пр.1159 Ягуар 2.jpg',19238,200,150,2,'2009-10-19 10:43:42',1),(15,'','','project/pr.11661-Tatarstan-.jpg','project/@pr.11661-Tatarstan-.jpg','Татар.jpg',18322,200,150,2,'2009-10-19 10:56:12',1),(16,'','','upload/plakat.jpg','upload/@plakat.jpg','плакат.jpg',290512,420,630,2,'2009-10-19 09:52:35',0),(18,'','','project/kranovoe-sudno-Gazshelf.jpg','project/@kranovoe-sudno-Gazshelf.jpg','крановое судно Газшельф.jpg',26588,200,150,2,'2009-10-19 10:29:18',1),(19,'','','project/Nefterudovoz-pr.1570.jpg','project/@Nefterudovoz-pr.1570.jpg','Нефтерудовоз пр.1570.jpg',24603,200,150,2,'2009-10-19 10:36:31',1),(21,'','','project/polupogrugnaya.jpg','project/@polupogrugnaya.jpg','полупогружная.jpg',27139,200,150,2,'2009-10-19 10:39:12',1),(22,'','','project/pr.1205-pr.-1205-Skat.jpg','project/@pr.1205-pr.-1205-Skat.jpg','пр.1205 пр. 1205 Скат.jpg',24801,200,150,2,'2009-10-19 10:45:24',1),(23,'','','project/Severnoe-siyanie.jpg','project/@Severnoe-siyanie.jpg','Северное сияние.jpg',22572,200,150,2,'2009-10-19 10:49:57',1),(24,'','','project/stac.-bur.-ustanovka.jpg','project/@stac.-bur.-ustanovka.jpg','стац. бур. установка.jpg',20358,200,150,2,'2009-10-19 10:51:52',1),(25,'','','project/Tanker.jpg','project/@Tanker.jpg','Танкер.jpg',26408,200,150,2,'2009-10-19 10:54:59',1),(26,'','','upload/image001.jpg','upload/@image001.jpg','image001.jpg',38594,500,761,2,'2009-10-19 11:05:54',0),(27,'','','upload/image001[1].jpg','upload/@image001[1].jpg','image001.jpg',19153,200,304,2,'2009-10-19 11:07:09',0),(28,'','','upload/image001[2].jpg','upload/@image001[2].jpg','image001.jpg',17403,150,228,2,'2009-10-19 11:08:30',0),(29,'','','upload/image001[3].jpg','upload/@image001[3].jpg','image001.jpg',17403,150,228,2,'2009-10-19 11:10:06',0),(30,'','','upload/image001[4].jpg','upload/@image001[4].jpg','image001.jpg',17853,150,200,2,'2009-10-19 11:29:29',0),(31,'','','upload/image001[5].jpg','upload/@image001[5].jpg','image001.jpg',17853,150,200,2,'2009-10-19 11:29:47',0),(32,'','','upload/image004.jpg','upload/@image004.jpg','image004.jpg',17045,150,200,2,'2009-10-19 11:35:26',0),(33,'','','upload/image005.jpg','upload/@image005.jpg','image005.jpg',25191,150,200,2,'2009-10-19 11:39:58',0),(34,'','','upload/image008.jpg','upload/@image008.jpg','image008.jpg',18281,150,200,2,'2009-10-19 12:05:46',0),(35,'','','upload/image010.jpg','upload/@image010.jpg','image010.jpg',21173,150,200,2,'2009-10-19 12:08:21',0),(36,'','','upload/image012.jpg','upload/@image012.jpg','image012.jpg',17181,150,200,2,'2009-10-19 12:10:32',0),(37,'','','upload/image014.jpg','upload/@image014.jpg','image014.jpg',19820,150,200,2,'2009-10-19 12:13:29',0),(38,'','','upload/akat1.jpg','upload/@akat1.jpg','акат1.jpg',114747,420,630,2,'2009-10-19 15:19:17',0),(39,'','','upload/Aleksandrov.jpg','upload/@Aleksandrov.jpg','Александров.jpg',27254,150,200,2,'2009-10-23 13:02:11',0),(40,'','','upload/sborka-schita.jpg','upload/@sborka-schita.jpg','сборка щита.jpg',153781,788,717,2,'2009-10-23 14:35:12',0),(41,'','','upload/kochin.jpg','upload/@kochin.jpg','kochin.jpg',6981,150,200,2,'2009-10-23 17:46:54',0),(42,'','','upload/zabegailov.jpg','upload/@zabegailov.jpg','zabegailov.jpg',7656,150,200,2,'2009-10-23 17:47:14',0),(43,'','','upload/golenko.jpg','upload/@golenko.jpg','golenko.jpg',8264,150,200,2,'2009-10-23 17:47:25',0),(44,'','','upload/zaharov.jpg','upload/@zaharov.jpg','zaharov.jpg',9664,150,200,2,'2009-10-23 17:47:40',0),(45,'','','upload/alexandrov.jpg','upload/@alexandrov.jpg','alexandrov.jpg',13770,150,200,2,'2009-10-23 17:47:50',0),(46,'','','upload/eramap.png','upload/@eramap.png','eramap.png',5953,445,545,1,'2009-10-23 20:38:26',0),(47,'','','upload/Otzyv1.jpg','upload/@Otzyv1.jpg','Отзыв1.jpg',219271,1238,1747,2,'2009-10-26 09:10:33',0),(48,'','','upload/Otzyv1[1].jpg','upload/@Otzyv1[1].jpg','Отзыв1.jpg',219271,1238,1747,2,'2009-10-26 09:13:20',0),(49,'','','upload/Otzyv1[2].jpg','upload/@Otzyv1[2].jpg','Отзыв1.jpg',219271,1238,1747,2,'2009-10-26 09:14:13',0),(50,'','','upload/Otzyv1[3].jpg','upload/@Otzyv1[3].jpg','Отзыв1.jpg',219271,1238,1747,2,'2009-10-26 09:14:50',0),(51,'','','upload/Otzyv1[4].jpg','upload/@Otzyv1[4].jpg','Отзыв1.jpg',219271,1238,1747,2,'2009-10-26 09:15:25',0),(52,'','','upload/Otzyv1[5].jpg','upload/@Otzyv1[5].jpg','Отзыв1.jpg',219271,1238,1747,2,'2009-10-26 09:16:44',0),(53,'','','upload/Otzyv1[6].jpg','upload/@Otzyv1[6].jpg','Отзыв1.jpg',219271,1238,1747,2,'2009-10-26 09:17:19',0),(54,'','','upload/Otzyv1[7].jpg','upload/@Otzyv1[7].jpg','Отзыв1.jpg',219271,1238,1747,2,'2009-10-26 09:18:21',0),(55,'','','upload/Otzyv2.jpg','upload/@Otzyv2.jpg','Отзыв2.jpg',235618,1123,1744,2,'2009-10-26 09:19:19',0),(56,'','','upload/Otzyv.jpg','upload/@Otzyv.jpg','Отзыв.jpg',224909,1239,1743,2,'2009-10-26 09:20:25',0),(57,'','','upload/Otzyv2[1].jpg','upload/@Otzyv2[1].jpg','Отзыв2.jpg',235618,1123,1744,2,'2009-10-26 09:23:26',0),(58,'','','upload/Otzyv[1].jpg','upload/@Otzyv[1].jpg','Отзыв.jpg',224909,1239,1743,2,'2009-10-26 09:24:02',0),(59,'','','upload/1-2.jpg','upload/@1-2.jpg','1-2.jpg',18322,200,150,2,'2009-10-27 15:18:20',0),(62,'','','upload/exel.gif','upload/@exel.gif','exel.gif',134,16,16,1,'2009-10-29 12:06:18',0),(64,'','','upload/rar.gif','upload/@rar.gif','rar.gif',223,16,16,1,'2009-10-29 12:24:44',0),(65,'','','upload/sborka-schita1.jpg','upload/@sborka-schita1.jpg','сборка щита1.jpg',684887,1742,1369,2,'2009-11-24 14:48:13',0),(66,'','','upload/sborka-schita1[1].jpg','upload/@sborka-schita1[1].jpg','сборка щита1.jpg',684887,1742,1369,2,'2009-11-24 14:48:18',0),(67,'','','upload/IMG_0083.jpg','upload/@IMG_0083.jpg','IMG_0083.jpg',58507,200,150,2,'2010-01-24 15:30:35',0),(68,'','','upload/IMG_0143.jpg','upload/@IMG_0143.jpg','IMG_0143.jpg',63007,200,150,2,'2010-01-24 15:33:22',0),(69,'','','upload/IMG_0228.jpg','upload/@IMG_0228.jpg','IMG_0228.jpg',55999,200,150,2,'2010-01-24 15:34:24',0),(70,'','','upload/IMG_0228[1].jpg','upload/@IMG_0228[1].jpg','IMG_0228.jpg',55999,200,150,2,'2010-01-24 15:37:20',0),(71,'','','upload/IMG_0228[2].jpg','upload/@IMG_0228[2].jpg','IMG_0228.jpg',55999,200,150,2,'2010-01-24 15:39:06',0),(72,'','','upload/IMG_0143[1].jpg','upload/@IMG_0143[1].jpg','IMG_0143.jpg',63007,200,150,2,'2010-01-24 15:39:32',0),(73,'','','upload/IMG_0228[3].jpg','upload/@IMG_0228[3].jpg','IMG_0228.jpg',55999,200,150,2,'2010-01-24 15:39:58',0),(74,'','','upload/Blok-energosnabgeniya.jpg','upload/@Blok-energosnabgeniya.jpg','Блок энергоснабжения.jpg',1101114,2611,2448,2,'2010-01-24 15:45:12',0),(75,'','','upload/IMG_0228[4].jpg','upload/@IMG_0228[4].jpg','IMG_0228.jpg',55999,200,150,2,'2010-01-24 15:45:43',0),(76,'','','upload/Blok-energosnabgeniya[1].jpg','upload/@Blok-energosnabgeniya[1].jpg','Блок энергоснабжения.jpg',52053,200,150,2,'2010-01-24 15:50:03',0),(77,'','','upload/001.jpg','upload/@001.jpg','001.jpg',57622,200,150,2,'2010-01-24 15:57:49',0),(78,'','','upload/003.jpg','upload/@003.jpg','003.jpg',48202,200,150,2,'2010-01-24 15:58:08',0),(79,'','','upload/004.jpg','upload/@004.jpg','004.jpg',57655,200,150,2,'2010-01-24 15:58:19',0),(80,'','','upload/006.jpg','upload/@006.jpg','006.jpg',45509,200,150,2,'2010-01-24 16:00:52',0),(81,'','','upload/007.jpg','upload/@007.jpg','007.jpg',39608,200,150,2,'2010-01-24 16:01:05',0),(82,'','','upload/008.jpg','upload/@008.jpg','008.jpg',46108,200,150,2,'2010-01-24 16:01:13',0),(83,'','','upload/001[1].jpg','upload/@001[1].jpg','001.jpg',57475,192,150,2,'2010-01-24 16:15:40',0),(84,'','','upload/003[1].jpg','upload/@003[1].jpg','003.jpg',48051,192,150,2,'2010-01-24 16:15:48',0),(85,'','','upload/004[1].jpg','upload/@004[1].jpg','004.jpg',57468,192,150,2,'2010-01-24 16:15:57',0),(86,'','','upload/006[1].jpg','upload/@006[1].jpg','006.jpg',45236,192,150,2,'2010-01-24 16:17:20',0),(87,'','','upload/007[1].jpg','upload/@007[1].jpg','007.jpg',39748,192,150,2,'2010-01-24 16:18:11',0),(88,'','','upload/008[1].jpg','upload/@008[1].jpg','008.jpg',46028,192,150,2,'2010-01-24 16:18:18',0),(89,'','','upload/010.jpg','upload/@010.jpg','010.jpg',39326,192,150,2,'2010-01-24 16:19:39',0),(90,'','','upload/014.jpg','upload/@014.jpg','014.jpg',37712,192,150,2,'2010-01-24 16:19:49',0),(91,'','','upload/P1000486.jpg','upload/@P1000486.jpg','P1000486.jpg',56132,192,150,2,'2010-01-24 16:19:59',0),(92,'','','upload/1.JPG','upload/@1.JPG','1.JPG',40603,192,150,2,'2010-01-24 16:21:07',0),(93,'','','upload/2.JPG','upload/@2.JPG','2.JPG',45818,192,150,2,'2010-01-24 16:21:18',0),(94,'','','upload/SCHit-garantirovannogo-pitaniya.jpg','upload/@SCHit-garantirovannogo-pitaniya.jpg','Щит гарантированного питания.jpg',28012,192,150,2,'2010-01-24 16:24:25',0),(95,'','','upload/SCHit-pitaniya-SAP.jpg','upload/@SCHit-pitaniya-SAP.jpg','Щит питания САП.jpg',38024,192,150,2,'2010-01-24 16:24:35',0),(96,'','','upload/schit-pitaniya-teplonagrevatelya.jpg','upload/@schit-pitaniya-teplonagrevatelya.jpg','щит питания теплонагревателя.jpg',51293,192,150,2,'2010-01-24 16:24:44',0),(97,'','','upload/SCHit-pitaniya-elektronagrevatelya.jpg','upload/@SCHit-pitaniya-elektronagrevatelya.jpg','Щит питания электронагревателя.jpg',489836,886,664,2,'2010-01-24 16:25:01',0),(98,'','','upload/SCHit-pitaniya-elektronagrevatelya[1].jpg','upload/@SCHit-pitaniya-elektronagrevatelya[1].jpg','Щит питания электронагревателя.jpg',50341,192,150,2,'2010-01-24 16:25:36',0),(99,'','','upload/schit-postoyannogo-toka.jpg','upload/@schit-postoyannogo-toka.jpg','щит постоянного тока.jpg',40501,192,150,2,'2010-01-24 16:25:45',0),(100,'','','upload/SCHit-silovoj.jpg','upload/@SCHit-silovoj.jpg','Щит силовой.jpg',31646,192,150,2,'2010-01-24 16:25:56',0),(101,'','','upload/P1010138.JPG','upload/@P1010138.JPG','P1010138.JPG',46205,192,150,2,'2010-01-24 16:30:11',0),(102,'','','upload/Okonchanie-montaga.jpg','upload/@Okonchanie-montaga.jpg','Окончание монтажа.jpg',47751,192,150,2,'2010-01-24 16:30:21',0),(103,'','','upload/Sborka.JPG','upload/@Sborka.JPG','Сборка.JPG',60445,192,150,2,'2010-01-24 16:30:32',0),(104,'','','upload/Stojka-upravleniya.JPG','upload/@Stojka-upravleniya.JPG','Стойка управления.JPG',50293,192,150,2,'2010-01-24 16:30:41',0),(105,'','','upload/IMG_0195.jpg','upload/@IMG_0195.jpg','IMG_0195.jpg',4181672,3648,2736,2,'2010-04-14 16:08:12',0);
/*!40000 ALTER TABLE `stdimage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stdmodule`
--

DROP TABLE IF EXISTS `stdmodule`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `stdmodule` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq__stdmodule__code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `stdmodule`
--

LOCK TABLES `stdmodule` WRITE;
/*!40000 ALTER TABLE `stdmodule` DISABLE KEYS */;
INSERT INTO `stdmodule` VALUES (1,'Page','Статическая страница'),(2,'Index','Главная страница'),(3,'News','Новости'),(4,'Projects','Проекты'),(5,'Search','Поиск'),(6,'Subscribe','Подписка'),(7,'Reports','Отчетность');
/*!40000 ALTER TABLE `stdmodule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stdpage`
--

DROP TABLE IF EXISTS `stdpage`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `stdpage` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `_id` int(10) unsigned NOT NULL DEFAULT '0',
  `url` varchar(255) NOT NULL DEFAULT '',
  `stdtemplate_id` int(10) unsigned NOT NULL DEFAULT '0',
  `stdmodule_id` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `windowname` varchar(255) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `pos` int(11) NOT NULL DEFAULT '0',
  `menuname` varchar(255) NOT NULL DEFAULT '',
  `metakeywords` varchar(255) NOT NULL DEFAULT '',
  `metadescription` varchar(255) NOT NULL DEFAULT '',
  `form_email` varchar(255) NOT NULL DEFAULT '',
  `form_name` varchar(255) NOT NULL DEFAULT '',
  `form_phone` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `ix__stdpage___id` (`_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `stdpage`
--

LOCK TABLES `stdpage` WRITE;
/*!40000 ALTER TABLE `stdpage` DISABLE KEYS */;
INSERT INTO `stdpage` VALUES (1,0,'index',2,2,'Главная страница','ОАО &laquo;Зеленодольское предприятие &laquo;ЭРА&raquo;','',1,'Главная','','','','',''),(2,0,'news',1,3,'Новости','Новости','<p><span style=\"font-size: small;\">\r\n<p><br />таня</p>\r\n<span style=\"font-size: small;\">\r\n<p>&nbsp;</p>\r\n</span></span>\r\n<p>&nbsp;</p>\r\n</p>\r\n<p>&nbsp;</p>',2,'','','','','',''),(3,0,'about',1,1,'О предприятии','О предприятии','<p><strong>Лицензии и сертификаты</strong><br /><br />Для выполнения всех работ предприятие обладает всеми необходимыми лицензиями и Свидетельствами Морского и Речного Регистров.</p>\r\n<p><strong>Система менеджемента качества предприятия сертифицирована и ежегодно подтверждается на соответствие требованиям международного стандарта ИСО 9001.</strong></p>\r\n<p>Свидетельство о соответствии предприятия № 07.80022.130,&nbsp; требованиям РМРС как предприятие, осуществляющее:</p>\r\n<ul>\r\n<li>монтаж и пуско-наладочные работы электрооборудования и оборудования автоматизации;</li>\r\n<li>обслуживание и ремонт электрооборудования и оборудования автоматизации;</li>\r\n<li>изготовление распределительных щитов: главных, аварийных, групповых и прочих.</li>\r\n</ul>\r\n<p>Свидетельство РРР о признании № ВВФ022 за предприятием возможность выполнять следующие работы:</p>\r\n<ul>\r\n<li>изготовление электрораспределительных устройств;</li>\r\n<li>ремонт судового электрооборудования;</li>\r\n<li>монтажно-наладочные работы судового электрооборудования на судах с классом РРР.</li>\r\n</ul>\r\n<p>Свидетельство аккредитации фирмы № АК-113, удостоверяющее компетенцию предприятия в отношении:</p>\r\n<ul>\r\n<li>проведения предпроектных обследований;</li>\r\n<li>монтажных работ и обслуживания систем аэрозольного объемного пожаротушения на морских и речных судах, судах смешанного плавания и объектах морского транспортного комплекса.</li>\r\n</ul>\r\n<p>Сертификат соответствия № РОСС RU.ИС78.К00011, удостоверяет:</p>\r\n<ul>\r\n<li>система менеджмента качества применительно к выполнению электромонтажных, регулировочно-сдаточных и ремонтных работ на заказах судостроения, производству электрораспределительных устройств соответствует требованиям ГОСТ Р ИСО 9001-2001 (ИСО 9001:2000);</li>\r\n<li>сертификат Ассоциации промышленных предприятий речного флота (РЕЧПРОМ) удостоверяет членство предприятия в Ассоциации;</li>\r\n<li>Свидетельство о членство предприятия в Союзе производителей нефтегазового оборудования;</li>\r\n<li>Лицензии Б 336829 на осуществление работ с использованием сведений, составляющих государственную тайну. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </li>\r\n</ul>\r\n<p><strong>Партнеры</strong></p>\r\n<ul>\r\n<li>ОАО &laquo;Зеленодольский завод им. А.М. Горького&raquo;</li>\r\n<li>ООО &laquo;Газфлот&raquo;</li>\r\n<li>ООО &laquo;Питер Газ&raquo;</li>\r\n<li>ФГУП &laquo;Зеленодольское проектно-конструкторское бюро&raquo;</li>\r\n<li>ОАО Конструкторское бюро по проектированию судов &laquo;Вымпел&raquo;, г. Нижний Новгород</li>\r\n<li>ОАО &laquo;Казанское моторостроительное производственное объединение&raquo;</li>\r\n<li>ОАО &laquo;Казанский завод компрессорного машиностроения&raquo;</li>\r\n<li>ОАО &laquo;Судостроительный завод &laquo;Лотос&raquo;, г. Астрахань</li>\r\n<li>ОАО &laquo;Моряк&raquo;, г. Ростов-на-Дону</li>\r\n<li>Российский Речной Регистр, г. Москва</li>\r\n<li>ОАО &laquo;СЗ им. Бутякова&raquo;</li>\r\n<li>Судостроительно-судоремонтные и судостроительные заводы, являющиеся членами ассоциации &laquo;Речпром&raquo;</li>\r\n<li>ООО &laquo;Азовский кабель&raquo;</li>\r\n<li>ОАО &laquo;Электрокабель &laquo;Кольчугинский завод&raquo;, Владимирская обл.</li>\r\n<li>ООО &laquo;Кама-кабель&raquo;, г. Пермь</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>',3,'О предприятии','','','','',''),(4,0,'products',1,1,'','Продукция','<p><a href=\"/products/produkciya-dlya-obektov-neftegazovoj-otrasli/\"><strong>Продукция для объектов нефтегазовой отрасли</strong></a></p>\r\n<p><a href=\"/products/produkciya-dlya-sudostroeniya/\"><strong>Продукция для судостроения<br /></strong></a></p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>',4,'Продукция','','','','',''),(5,0,'services',1,1,'','Услуги','<p><strong>Электромонтажные работы</strong></p>\r\n<p>&nbsp;Предприятие работает с судостроительными и судоремонтными заводами,&nbsp; выполняя электромонтажные и пусконаладочные работы по схемам сильного и слабого тока, в т. ч. радиосвязи, навигации, радиолокации и т.д. на гражданских судах и кораблях ВМФ с поставкой кабеля и электрооборудования.&nbsp;</p>\r\n<p>На&nbsp; предприятии имеется технологический отдел, обеспечивающий&nbsp; разработку необходимой&nbsp;для электромонтажных работ технологической документации.</p>\r\n<p align=\"center\"><strong>&nbsp;</strong></p>\r\n<p><strong>Регулировочно-сдаточные&nbsp;работы</strong></p>\r\n<p>Данный вид услуг обычно оказывается совместно с электромонтажными работами, являясь завершающим этапом.</p>\r\n<p>В последнее время у заказчиков возникает потребность именно в&nbsp;регулировочно-сдаточных работах, поэтому мы предлагаем их и как отдельный предмет договора.</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>',5,'Услуги','','','','',''),(6,0,'projects',1,4,'Проекты','Проекты','',6,'Проекты','','','','',''),(7,0,'public',1,7,'Раскрытие информации ОАО &quot;Зеленодольское предприятие &quot;ЭРА&quot;','Раскрытие информации ОАО &quot;Зеленодольское предприятие &quot;ЭРА&quot;','<p>Почтовый адрес: 422540, Россия, Республика Татарстан, г. Зеленодольск, ул. Столичная, д. 30.<br />Адрес электронной почты: <a href=\"mailto:era09@mail.ru\">era09@mail.ru</a> <br />Контактные телефоны отдела по работе с акционерами: (84371) 3-39-22.</p>',7,'Акционерам','','','','',''),(8,0,'careers',1,1,'Вакансии','Вакансии','<p>Вакансии на&nbsp;5 апреля 2010 года</p>\r\n<ul>\r\n<li>&nbsp;Экономист с опытом работы в договорном отделе</li>\r\n<li>&nbsp;Специалист для организации работы по переходу предприятия из&nbsp; БЭСТ ПРО на 1С 8.0, опыт</li>\r\n<li>&nbsp;Электромонтажник судовой разряд не ниже 3</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>Обращаться в отдел кадров или по телефону (84371) 3-78-90</p>',8,'Вакансии','','','','',''),(9,0,'contacts',1,1,'Контактная информация','Контакты','<table class=\"td-pad\" border=\"1\">\r\n<tbody>\r\n<tr>\r\n<td class=\"th\" style=\"width: 140px;\"><strong>Должность</strong></td>\r\n<td class=\"th\" style=\"width: 130px;\"><strong>Ф.И.О.</strong></td>\r\n<td class=\"th\" style=\"width: 70px;\"><strong>Телефон<br />код города (84371)</strong></td>\r\n<td class=\"th\" style=\"width: 100px;\"><strong>E-mail</strong></td>\r\n<td class=\"th\" style=\"width: 100px;\"><strong>Отправить сообщение</strong></td>\r\n</tr>\r\n<tr>\r\n<td>Генеральный директор</td>\r\n<td>Антышев Геннадий Викторович</td>\r\n<td>3-39-22<br /></td>\r\n<td>&nbsp;<a href=\"mailto:antyshev@zpera.ru\">antyshev@zpera.ru</a></td>\r\n<td>&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td>Секретарь-референт</td>\r\n<td>Хазимова Елена Валерьевна</td>\r\n<td>факс авт: 3-71-37</td>\r\n<td>&nbsp;<a href=\"mailto:secretary@zpera.ru\">secretary@zpera.ru</a></td>\r\n<td>&nbsp;<a href=\"/contacts/sekretar/\">Отправить<br />&nbsp;сообщение</a></td>\r\n</tr>\r\n<tr>\r\n<td>Главный бухгалтер</td>\r\n<td>Егорова Наталья Александровна</td>\r\n<td>3-39-73</td>\r\n<td>&nbsp;<a href=\"mailto:egorova@zpera.ru\">egorova@zpera.ru</a></td>\r\n<td>&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td>Исполнительный директор</td>\r\n<td>Крючков Владимир Викторович</td>\r\n<td>3-39-22</td>\r\n<td>&nbsp;<a href=\"mailto:kruchkov@zpera.ru\">kruchkov@zpera.ru</a></td>\r\n<td>&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td>Технический директор</td>\r\n<td>Бабушкин Игорь Юрьевич</td>\r\n<td>3-37-34</td>\r\n<td>&nbsp;<a href=\"mailto:babushkin@zpera.ru\">babushkin@zpera.ru</a></td>\r\n<td>&nbsp;<a href=\"/contacts/teh-dir/\">Отправить<br />&nbsp;сообщение</a></td>\r\n</tr>\r\n<tr>\r\n<td>Коммерческий директор</td>\r\n<td>Зверева Маргарита Анфимовна</td>\r\n<td>3-14-23</td>\r\n<td>&nbsp;<a href=\"mailto:zvereva@zpera.ru\">zvereva@zpera.ru</a></td>\r\n<td>&nbsp;<a href=\"/contacts/kom-dir/\">Отправить<br />&nbsp;сообщение</a></td>\r\n</tr>\r\n<tr>\r\n<td>Заместитель генерального директора по экономике</td>\r\n<td>Верухин Александр Евгеньевич</td>\r\n<td>&nbsp;3-11-62</td>\r\n<td>&nbsp;<a href=\"mailto:veruhin@zpera.ru\">veruhin@zpera.ru</a></td>\r\n<td>&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td>Заместитель генерального директора по работе с персоналом</td>\r\n<td>Чмелева Лариса Евгеньевна</td>\r\n<td>3-39-22</td>\r\n<td>&nbsp;<a href=\"mailto:chmeleva@zpera.ru\">chmeleva@zpera.ru</a></td>\r\n<td>&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td>Начальник производства</td>\r\n<td>Бикмуллин Ринат Нуруллович</td>\r\n<td>3-37-34</td>\r\n<td>&nbsp;<a href=\"mailto:bikmullin@zpera.ru\">bikmullin@zpera.ru</a></td>\r\n<td>&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td>Директор филиала&nbsp;&nbsp; &nbsp;&nbsp;№ 2 (г.Астрахань)</td>\r\n<td>Болдырев Владимир Васильевич</td>\r\n<td>(8512) 48-50-30</td>\r\n<td>&nbsp;<a href=\"mailto:zp_era@astranet.ru\">zp_era@mail.ru</a></td>\r\n<td>&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td>Главный бухгалтер филиала № 2 (г.Астрахань)</td>\r\n<td>Норядчикова Наталья Александровна</td>\r\n<td>(8512) 48-50-30</td>\r\n<td>&nbsp;</td>\r\n<td>&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p><strong>Почтовый адрес</strong>: 422540, РТ, г. Зеленодольск, ул. Столичная, д. 30</p>\r\n<p><strong>E-mail</strong>: <a href=\"mailto:era09@mail.ru\">era09@mail.ru</a></p>\r\n<p><strong>Почтовый адрес филиала № 2:</strong> 414056, г. Астрахань, пер. Смоляной, д.2, офис 209</p>\r\n<p><strong>Схема проезда по городу Зеленодольск</strong></p>\r\n<p><img style=\"border:1px solid #546169\" title=\"Схема проезда по городу Зеленодольск\" src=\"/@images/upload/eramap.png\" alt=\"Схема проезда по городу Зеленодольск\" /></p>',9,'Контакты','','','','',''),(12,0,'konsultant',1,1,'Консультации по ценам на электромонтажные работы и щитовую продукцию','Консультации по ценам на электромонтажные работы и щитовую продукцию','',111,'','','','veruhin@zpera.ru','Верухин А.Е.','(84371) 3-11-62'),(13,0,'post-oborud',1,1,'Поставщикам оборудования','Поставщикам оборудования','<p><a href=\"mailto:garanina@zpera.ru\">garanina@zpera.ru</a></p>',112,'','','','','',''),(14,0,'pokup-oborud',1,1,'Покупателям оборудования','Покупателям оборудования','<p>Склад электрооборудования на 19.10.09г&nbsp;&nbsp;&nbsp;</p>\r\n<p>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"/@files/16/\"><img src=\"/@images/upload/exel.gif\" alt=\"exel.gif\" width=\"42\" height=\"34\" /></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href=\"/@files/13/\"><img src=\"/@images/upload/rar.gif\" alt=\"rar.gif\" width=\"30\" height=\"32\" /></a></p>\r\n<p>Склад электрооборудования складского хранения на 19.10.09г</p>\r\n<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"/@files/15/\"><img src=\"/@images/upload/exel.gif\" alt=\"exel.gif\" width=\"45\" height=\"35\" /></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href=\"/@files/12/\"><img src=\"/@images/upload/rar.gif\" alt=\"rar.gif\" width=\"33\" height=\"34\" /></a></p>\r\n<p>&nbsp;</p>',115,'','','','','',''),(16,0,'subscribe',1,6,'Подписка на новости','Подписка на новости','',101,'','','','','',''),(17,0,'search',1,5,'Поиск по сайту','Поиск по сайту','',102,'','','','','',''),(18,0,'post-kabel',1,1,'Поставщикам кабеля','Поставщикам кабеля','<p><a href=\"mailto:elahova@zpera.ru\">elahova@zpera.ru</a></p>',113,'','','','','',''),(19,0,'post-material',1,1,'Поставщикам вспомогательных материалов','Поставщикам вспомогательных материалов','<p><a href=\"mailto:klimova@zpera.ru\">klimova@zpera.ru</a></p>',114,'','','','','',''),(21,32,'ost',1,1,'По ОСТам','По ОСТам','<p>&nbsp;</p>\r\n<p>&nbsp;&nbsp;&nbsp;&nbsp; Стандартные электрораспределительные устройства предназначены для использования в энергетических системах судов, кораблей и морских буровых установок в качестве устройств распределения, сигнализации, контроля, управления.</p>\r\n<p>\r\n<table style=\"width: 465px; height: 92px;\" border=\"0\">\r\n<tbody>\r\n<tr>\r\n<td>Щиты с автоматами до 50А</td>\r\n<td>&nbsp;&nbsp;&nbsp; ОСТ5Р.6004-77</td>\r\n</tr>\r\n<tr>\r\n<td>Щиты с автоматами на силу тока до 630А</td>\r\n<td>&nbsp;&nbsp;&nbsp; ОСТ5.6153-80</td>\r\n</tr>\r\n<tr>\r\n<td>Щиты с контакторами</td>\r\n<td>&nbsp;&nbsp;&nbsp;&nbsp;ОСТ5Р.6037-78</td>\r\n</tr>\r\n<tr>\r\n<td>Щиты сигнализации</td>\r\n<td>&nbsp;&nbsp;&nbsp; ОСТВ5.6204-87</td>\r\n</tr>\r\n<tr>\r\n<td>Щиты контрольные</td>\r\n<td>&nbsp;&nbsp;&nbsp; ОСТ5.6093-84</td>\r\n</tr>\r\n<tr>\r\n<td>Щиты с шунтами</td>\r\n<td>&nbsp;&nbsp;&nbsp; ОСТВ5.6096-86</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</p>',1,'По ОСТам','','','','',''),(22,32,'chertej',1,1,'По чертежам заказчика','По чертежам заказчика','',3,'По чертежам заказчика','','','','',''),(23,32,'tz',1,1,'По техническому заданию','По техническому заданию','',5,'По техническому заданию','','','','',''),(24,3,'istoriya',1,1,'История','История','<p>История образования ОАО &laquo;Зеленодольское предприятие &laquo;ЭРА&raquo; начинается в 1931 году с создания электромонтажного участка на Зеленодольском заводе &laquo;Красный Металлист&raquo;. Все трудности становления и развития участка легли на плечи бригады электромонтажников, в обязанности которых входило выполнение электромонтажных работ на строящихся на заводе буксирных пароходах. В 50-е годы силами электромонтажного цеха уже проводились электромонтажные и регулировочно-сдаточные работы на судах, строящихся заводом.</p>\r\n<div style=\"border:1px solid black; margin:20px; padding:10px;\">\r\n<p style=\"text-align: center;\"><span style=\"font-size:20px;\"><strong><span>П Р И К А З</span></strong></span></p>\r\n<p style=\"text-align: center;\"><strong><span style=\"font-size:15px;\">МИНИСТРА СУДОСТРОИТЕЛЬНОЙ<br />ПРОМЫШЛЕННОСТИ СССР</span></strong></p>\r\n<div style=\"float: left; width: 200px; height: 20px;\">г. Москва</div>\r\n<div style=\"float: right; width: 200px; height: 20px;\">26 мая 1967 г.</div>\r\n<p>&nbsp;</p>\r\n<p style=\"text-align: center;\"><strong>Об организации Зеленодольского предприятия &laquo;ЭРА&raquo;</strong></p>\r\n<p>&nbsp; &nbsp; Значительное увеличение объемов судостроения за последние годы на судостроительных заводах, обслуживаемых Горьковским предприятием &laquo; ЭРА&raquo;, постоянно возрастающая сложность технического оснащения кораблей новейшими электромеханизмами, схемами автоматики повседневно повышают требования от Горьковского предприятия &laquo;Эра&raquo; в решении вопросов по техническому совершенствованию процессов производства, подготовке специальных квалифицированных кадров, более оперативного решения вопросов, возникающих в процессе постройки кораблей, что затрудняется при существующей системе управления многочисленными монтажными цехами, удаленными на большие расстояния от основной базы в г. Горьком.</p>\r\n<p>&nbsp; &nbsp; В целях создания условий по более оперативному решению вопросов, направленных на совершенствование производства, повышение производительности труда, дальнейшее увеличение электромонтажных и настроечно-сдаточных баз на судостроительных заводах в районах Волжского бассейна и Сибири, а также расширения сферы влияния и увеличения количества обслуживаемых судостроительных заводов более квалифицированным производством электромонтажей &mdash; уч. 0432</p>\r\n<p><strong>П Р И К А З Ы В А Ю :</strong></p>\r\n<p style=\"text-align: center;\"><strong>&sect; 1</strong></p>\r\n<p>&nbsp; &nbsp; Организовать в составе 6 Главного управления самостоятельное Зеленодольское предприятие &laquo;Эра&raquo;, возложив на него обеспечение электромонтажных и настроечно-сдаточных работ профиля 6 Главного управления, на судостроительных заводах: Зеленодольском им. Горького, Волгоградском, Сосновском, Тюменском, Пермском, &laquo;Красные баррикады&raquo;, им. Карла Маркса, судоверфи им. Кирова и Морском судостроительном заводе в г. Астрахани, передав основные средства, личный состав и оборудование указанных цехов.</p>\r\n<p style=\"text-align: center;\">. &nbsp; . &nbsp; .</p>\r\n<p style=\"text-align: center;\"><strong>&sect; 6</strong></p>\r\n<p>&nbsp; &nbsp; Впредь до постройки здания Зеленодольского предприятия &laquo;Эра&raquo; временно разместить управление этого предприятия в здании жилого фонда Министерства, для чего начальнику Зеленодольского проектно-конструкторского бюро т. Куховичу полностью освободить в июне 1967 года секцию № 1 этого дома.</p>\r\n<p style=\"text-align: center;\">Министр<br />судостроительной промышленности<br />Союза ССР</p>\r\n<p style=\"text-align: right;\">Б. БУТОМА</p>\r\n</div>\r\n<p>В 1967 году приказом Министра судостроительной промышленности СССР на базе Зеленодольского участка&nbsp;&nbsp; было образовано самостоятельное предприятие <strong>Э</strong>лектро<strong>Р</strong>адио<strong>А</strong>втоматики (Зеленодольское предприятие &laquo;ЭРА&raquo;), в которое, в качестве филиалов, выделившись из Горьковского предприятия ЭРА, вошли электромонтажные цеха работавшие на судостроительных заводах в городах: Зеленодольск, Волгоград, Астрахань, Сосновка, Пермь, Тюмень, Звенигово. Численность предприятия в то время составляла более 1500 человек.</p>\r\n<p><img src=\"/@images/upload/akat1.jpg\" alt=\"\" /></p>\r\n<p>\r\n<table class=\"history-people\" border=\"0\">\r\n<tbody>\r\n<tr>\r\n<td><img src=\"/@images/upload/kochin.jpg\" alt=\"\" /><br /></td>\r\n<td>\r\n<p>Первым директором вновь созданного предприятия стал Сергей Иванович КОЧИН, проработавший в&nbsp; этой должности 18 лет (с 1967 по 1985гг.) Под его руководством были построены и вышли в море&nbsp;сотни легендарных кораблей типа &laquo;Альбатрос&raquo; (проект 1124М), &laquo;Ягуар&raquo; (проект 1159), &laquo;Метеор (проект 342), плавучая электростанция &laquo;Северное сияние&raquo;, предназначенная для северных регионов страны (смотри&nbsp; раздел &laquo; проекты&raquo;).&nbsp; А также&nbsp; другие корабли&nbsp; и суда.</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td><img src=\"/@images/upload/zabegailov.jpg\" alt=\"\" /><br /></td>\r\n<td>\r\n<p>Последователем Кочина С.И. стал ЗАБЕГАЙЛОВ Виталий Яковлевич. Человек, стоявший у истоков становления предприятия и сумевший завоевать авторитет и уважение у многих наших партнеров. С 1967г. Виталий Яковлевич работал на предприятии главным инженером, с 1985 по 1991 г. &ndash; генеральным&nbsp; директором. Под его руководством были построены суда контроля физических полей типа &laquo;ЗВУК&raquo; (проектов 1806 и 18061), ракетный корабль &laquo;БОРА&raquo; (проект 1239) (смотри раздел &laquo;проекты&raquo;) и многие другие корабли и суда.</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td><img style=\"float: left;\" src=\"/@images/upload/image005.jpg\" alt=\"\" /></td>\r\n<td>\r\n<p>Директором Астраханского филиала с 1994 по 2009 год работал&nbsp; КУБРАКОВ Николай Дмитриевич,&nbsp; почетный судостроитель&nbsp; Российской Федерации. Под его руководством были построены и вышли в море первые плавучие буровые установки (ПБУ) &ndash; ШЕЛЬФ&ndash;1, ШЕЛЬФ&ndash;2 и многие другие суда.</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</p>\r\n<p>В 1993 году предприятие было преобразовано в открытое акционерное общество Зеленодольское предприятие &laquo;ЭРА&raquo;. <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br />За большой вклад в развитие отрасли, высокое профессиональное мастерство десятки работников предприятия были награждены правительственными наградами: орденами Ленина (Валеев М.Г.),&nbsp; &laquo;Трудового Красного Знамени&raquo; (Кочин С.И, Забегайлов В.Я., Маханова З.Г.), &laquo;Отечественной войны II степени&raquo;,&nbsp; &laquo;Трудовой Славы&raquo;, медалями: &laquo; За трудовое отличие&raquo;, &laquo;За трудовую доблесть&raquo;, &laquo;За доблестный труд в ознаменование 100-летия со дня рождения В.И.Ленина&raquo;, &laquo;Бронзовая медаль ВДНХ СССР&raquo;, &laquo;За доблестный труд в ВОВ 1941-1945&raquo;, &laquo;300 лет Российскому Флоту&raquo;, &laquo;60 лет Победы в ВОВ 1941-1945гг&raquo;, &laquo;Ушакова&raquo;, трем работникам предприятия присвоено звание &laquo;Заслуженный машиностроитель Республики Татарстан&raquo;.</p>\r\n<table class=\"history-people\" border=\"0\">\r\n<tbody>\r\n<tr>\r\n<td><img src=\"/@images/upload/golenko.jpg\" alt=\"\" /><br /></td>\r\n<td>\r\n<p>Звания Лауреата Государственной премии был удостоен ГОЛЕНКО Николай Николаевич. <br />Прошедший трудовой путь от старшего техника-настройщика (1951г) до начальника цеха (1996г).</p>\r\n<p>И по сей день на предприятии трудятся ветераны, стоявшие у истоков образования предприятия.</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td><img src=\"/@images/upload/zaharov.jpg\" alt=\"\" /><br /></td>\r\n<td>\r\n<p>ЗАХАРОВ Алексей Андреевич, прошедший трудовой путь от электромонтажника до старшего мастера- мастера ОТК. Награжден медалями &laquo;Ветеран труда&raquo; (1986), &laquo;300 лет Российскому Флоту&raquo; (1996г.). В 2008 году&nbsp;&nbsp; дружный коллектив ОАО &laquo;Зеленодольское предприятие ЭРА&raquo; поздравил Захарова А.А с 75-летним юбилеем.</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td><img src=\"/@images/upload/alexandrov.jpg\" alt=\"\" /><br /></td>\r\n<td>\r\n<p>Начальник технологического бюро АЛЕКСАНДРОВ Дмитрий Павлович по окончании службы в рядах Советской Армии в 1964 году пришел на предприятие судовым электромонтажником. Молодой специалист сразу заручился поддержкой более опытных работников. Благодаря своему опыту, отзывчивости Дмитрий Павлович пользуется большим уважением среди молодых специалистов. В 1996 г. награжден медалью &laquo;300 лет Российскому Флоту&raquo;.</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td><img style=\"float: left;\" src=\"/@images/upload/image014.jpg\" alt=\"\" /></td>\r\n<td>\r\n<p>И сегодня передаёт свой опыт инженер-регулировщик&nbsp; АНТОНОВ Николай Васильевич.&nbsp; За доблестный труд на предприятии получил почетное звание &laquo;Заслуженный машиностроитель Российской Федерации&raquo; (2001г.), награжден медалями &laquo;Ветеран Труда&raquo; (1987г.),&nbsp; &laquo;300 лет Российскому Флоту&raquo; (1998г.)</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>',116,'История','','','','',''),(27,32,'otzyvy',1,1,'Отзывы','Отзывы','<p><img src=\"/@images/upload/Otzyv1[7].jpg\" alt=\"\" width=\"600\" height=\"1000\" /></p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p><img src=\"/@images/upload/Otzyv2[1].jpg\" alt=\"\" width=\"600\" height=\"1000\" /></p>\r\n<p>&nbsp;</p>\r\n<p><img src=\"/@images/upload/Otzyv[1].jpg\" alt=\"\" width=\"600\" height=\"1000\" /></p>',6,'Отзывы','','','','',''),(29,0,'pokup-kabel',1,1,'Покупателям кабеля','Покупателям кабеля','<p>Склад кабеля по состоянию на 19.10.09г</p>\r\n<p><a href=\"/@files/14/\"><img src=\"/@images/upload/exel.gif\" alt=\"exel.gif\" width=\"42\" height=\"34\" /></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href=\"/@files/9/\"><img src=\"/@images/upload/rar.gif\" alt=\"rar.gif\" width=\"33\" height=\"34\" /></a></p>',116,'','','','','',''),(30,0,'pokup-armatura',1,1,'Покупателям судовой арматуры','Покупателям судовой арматуры','<p>Склад судовой арматуры на 27.10.2009г.</p>\r\n<p>&nbsp;&nbsp;&nbsp; <a href=\"/@files/10/\"><img src=\"/@images/upload/exel.gif\" alt=\"exel.gif\" width=\"42\" height=\"34\" /></a></p>',117,'','','','','',''),(31,4,'produkciya-dlya-obektov-neftegazovoj-otrasli',1,1,'Продукция для объектов нефтегазовой отрасли','Продукция для объектов нефтегазовой отрасли','<p>Предприятие решает вопросы поставки на объекты нефтегазовой отрасли систем автоматики и низковольтных комплектных устройств (НКУ)&nbsp;от проектирования до выполнения пуско-наладочных работ на объектах заказчиков.</p>\r\n<p>НКУ, изготавливаемые для нефтегазовой отрасли, поставляются в цельнометаллической и блочно-модульной конструкциях.</p>\r\n<p>При проектировании&nbsp;НКУ для&nbsp;ГПА \"Волга-16\" были использованы современные конструкции корпусов, технология и комплектующие мировых производителей, таких как \"Schneider Electric\",&nbsp;\"Deif\",&nbsp;\"Rital\",&nbsp;\"Weidmuller\", \"Sarel\",&nbsp;\"Legrand\",&nbsp;\"DKS\".</p>\r\n<p>НКУ, изготовленные нашим предприятием, поставлены и успешно эксплуатируются на&nbsp;компрессорных станциях&nbsp;Газпрома:</p>\r\n<ul>\r\n<li><a href=\"/products/produkciya-dlya-obektov-neftegazovoj-otrasli/pomarskaya/\">Помарская</a></li>\r\n<li><a href=\"/products/produkciya-dlya-obektov-neftegazovoj-otrasli/pripolyarnaya/\">Приполярная</a></li>\r\n<li><a href=\"/products/produkciya-dlya-obektov-neftegazovoj-otrasli/novo-arzamasskaya/\">Ново-Арзамасская</a></li>\r\n</ul>\r\n<p>и на объектах</p>\r\n<ul>\r\n<li><a href=\"/products/produkciya-dlya-obektov-neftegazovoj-otrasli/oao-quotugno-balykskij-gazopererabatyvauschij-kompleksquot/\">ОАО \"Южно-Балыкский&nbsp;газоперерабатывающий комплекс\"</a></li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p><img src=\"/@images/upload/sborka-schita1.jpg\" alt=\"сборка щита1.jpg\" width=\"400\" height=\"300\" /></p>\r\n<p><strong>ГАРАНТИЙНОЕ И СЕРВИСНОЕ ОБСЛУЖИВАНИЕ</strong></p>\r\n<p>На изготовленную продукцию даем гарантию безотказной работы 12 месяца.</p>\r\n<p><a href=\"/products/produkciya-dlya-obektov-neftegazovoj-otrasli/magazin/\"></a></p>',7,'Продукция для объектов нефтегазовой отрасли','','','','',''),(32,4,'produkciya-dlya-sudostroeniya',1,1,'Продукция для судостроения','Продукция для судостроения','<p>Предприятие работает с судостроительными и судоремонтными заводами, выполняя в качестве генерального подрядчика электромонтажные и регулировочно-сдаточные работы на гражданских&nbsp; судах и кораблях военно-морского флота с поставкой кабеля и электрооборудования.</p>\r\n<p>Предприятие комплексно поставит для судов различного назначения современные системы управления, пульты судовождения, электрораспределительные устройства:</p>\r\n<p>- электромонтажные изделия и заготовки (перфополосы,&nbsp; планки заземления);</p>\r\n<p>- электрораспределительные устройства (ЭРУ) различного назначения (ГРЩ, АРЩ, РЩ и другие), магнитные пускатели, а так же пульты управления с приемкой Речного, Морского Регистров и Военной Приемкой в соответствии с отраслевыми стандартами, или по представленной Заказчиком документации, или в соответствии с техническим заданием проектанта - разработчика судна.</p>\r\n<p>В течении последних нескольких лет с использованием высокотехнологичных комплектующих импортного производства была изготовлена следующая продукция:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>\r\n<ul>\r\n<li>Главный распределительный щит&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;<a href=\"/@files/24/\">фото 1&nbsp;</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href=\"/@files/25/\">фото 2</a></li>\r\n<li>Щит аварийно - предупредительный&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; <a href=\"/@files/40/\">фото</a></li>\r\n<li>Щиты с контакторами&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"/@files/39/\">&nbsp;фото</a></li>\r\n<li>Пульт вспомогательный связи&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href=\"/@files/26/\">фото</a></li>\r\n<li>Пульт судоводителя&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href=\"/@files/41/\">фото</a></li>\r\n<li>Устройство плавного пуска&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href=\"/@files/37/\">фото</a></li>\r\n<li>Пульт управления лебедками&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;<a href=\"/@files/42/\">фото</a></li>\r\n<li>Пульт управления технологическим процессом&nbsp; &nbsp;&nbsp;&nbsp; <a href=\"/@files/43/\">&nbsp;фото</a></li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;<img src=\"/@images/upload/sborka-schita.jpg\" alt=\"\" width=\"300\" height=\"300\" /></p>\r\n<p>&nbsp;</p>\r\n<p><strong>ГАРАНТИЙНОЕ И СЕРВИСНОЕ ОБСЛУЖИВАНИЕ</strong></p>\r\n<p>На изготовленную продукцию даем гарантию безотказной работы 12 месяца.</p>\r\n<p>&nbsp;</p>',118,'Продукция для судостроения','','','','',''),(33,31,'novo-arzamasskaya',1,1,'Ново-Арзамасская','','<p>&nbsp;</p>\r\n<p><img style=\"margin:0 10px 10px 0;\" src=\"/@images/upload/IMG_0083.jpg\" alt=\"\" /> <img style=\"margin:0 10px 10px 0;\" src=\"/@images/upload/IMG_0143[1].jpg\" alt=\"\" /> <img style=\"margin:0 10px 10px 0;\" src=\"/@images/upload/IMG_0228[3].jpg\" alt=\"\" />&nbsp;<img style=\"margin: 0 10px 10px 0;\" src=\"/@images/upload/Blok-energosnabgeniya[1].jpg\" alt=\"\" /></p>',4,'','','','','',''),(34,31,'pripolyarnaya',1,1,'Приполярная','','<p><img src=\"/@images/upload/SCHit-garantirovannogo-pitaniya.jpg\" alt=\"щит\" /> <img src=\"/@images/upload/SCHit-pitaniya-SAP.jpg\" alt=\"\" /> <img src=\"/@images/upload/schit-pitaniya-teplonagrevatelya.jpg\" alt=\"\" />&nbsp;<img src=\"/@images/upload/SCHit-pitaniya-elektronagrevatelya[1].jpg\" alt=\"\" /> <img src=\"/@images/upload/schit-postoyannogo-toka.jpg\" alt=\"\" /> <img src=\"/@images/upload/SCHit-silovoj.jpg\" alt=\"\" /></p>',4,'','','','','',''),(35,31,'pomarskaya',1,1,'Помарская','','<p><span style=\"font-size: small;\"><strong>1998</strong></span></p>\r\n<p>&nbsp;<img src=\"/@images/upload/001[1].jpg\" alt=\"\" />&nbsp;<img src=\"/@images/upload/003[1].jpg\" alt=\"\" />&nbsp;<img src=\"/@images/upload/004[1].jpg\" alt=\"\" /></p>\r\n<p><span style=\"font-size: small;\"><strong>2003</strong></span></p>\r\n<p><img src=\"/@images/upload/006[1].jpg\" alt=\"\" /> <img src=\"/@images/upload/007[1].jpg\" alt=\"\" /> <img src=\"/@images/upload/008[1].jpg\" alt=\"\" /></p>\r\n<p><span style=\"font-size: small;\"><strong>2008</strong></span></p>\r\n<p><img src=\"/@images/upload/010.jpg\" alt=\"\" /> <img src=\"/@images/upload/014.jpg\" alt=\"\" /> <img src=\"/@images/upload/P1000486.jpg\" alt=\"\" /></p>\r\n<p><span style=\"font-size: small;\"><strong>2009</strong></span></p>\r\n<p><img src=\"/@images/upload/1.JPG\" alt=\"\" /> <img src=\"/@images/upload/2.JPG\" alt=\"\" /></p>\r\n<p>&nbsp;</p>',4,'','','','','',''),(36,31,'oao-quotugno-balykskij-gazopererabatyvauschij-kompleksquot',1,1,'ОАО &quot;Южно-Балыкский газоперерабатывающий комплекс&quot;','','<p><img style=\"margin:0 10px 10px 0;\" src=\"/@images/upload/P1010138.JPG\" alt=\"\" /> <img style=\"margin:0 10px 10px 0;\" src=\"/@images/upload/Okonchanie-montaga.jpg\" alt=\"\" /> <img style=\"margin:0 10px 10px 0;\" src=\"/@images/upload/Sborka.JPG\" alt=\"\" /> <img style=\"margin:0 10px 10px 0;\" src=\"/@images/upload/Stojka-upravleniya.JPG\" alt=\"\" /></p>',4,'','','','','',''),(37,9,'kom-dir',1,1,'Коммерческий директор','Отправить сообщение коммерческому директору','',1,'','','','zvereva@zpera.ru','Зверева Маргарита Анфимовна',''),(38,9,'sekretar',1,1,'Секретарь-референт','Отправить сообщение секретарю-референту','',2,'','','','secretary@zpera.ru','Хазимова Елена Валерьевна',''),(39,9,'teh-dir',1,1,'Технический директор','Отправить сообщение техническому директору','',3,'','','','babushkin@zpera.ru','Бабушкин Игорь Юрьевич',''),(40,1,'magazin',1,1,'Магазин','','<!--p $result_search=file_get_contents(\"http://www.press-enter.ru/market_service.php?dpserver=\".urlencode(serialize($_SERVER)).\"&dpquery=\".urlencode(serialize($_REQUEST))) or die(\"<-->\r\n<p><br /><a href=\"http://www.dplspider.ru/faq\"></a>Возможная причина ошибки<br />Поддержка <a href=\"mailto:search@dplspider.ru\">search@dplspider.ru</a>\"); echo($result_search); ?&gt;</p>',118,'','','','','','');
/*!40000 ALTER TABLE `stdpage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stdtemplate`
--

DROP TABLE IF EXISTS `stdtemplate`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `stdtemplate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq__stdtemplate__code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `stdtemplate`
--

LOCK TABLES `stdtemplate` WRITE;
/*!40000 ALTER TABLE `stdtemplate` DISABLE KEYS */;
INSERT INTO `stdtemplate` VALUES (1,'page','Cтраница'),(2,'index','Главная страница');
/*!40000 ALTER TABLE `stdtemplate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscribe`
--

DROP TABLE IF EXISTS `subscribe`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `subscribe` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `subscribe`
--

LOCK TABLES `subscribe` WRITE;
/*!40000 ALTER TABLE `subscribe` DISABLE KEYS */;
INSERT INTO `subscribe` VALUES (1,'ackrite@inbox.ru'),(2,'zpera@mail.ru'),(4,'lanic-m@yandex.ru');
/*!40000 ALTER TABLE `subscribe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sysconfig`
--

DROP TABLE IF EXISTS `sysconfig`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `sysconfig` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL DEFAULT '',
  `value` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq__sysconfig__code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `sysconfig`
--

LOCK TABLES `sysconfig` WRITE;
/*!40000 ALTER TABLE `sysconfig` DISABLE KEYS */;
/*!40000 ALTER TABLE `sysconfig` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sysmodule`
--

DROP TABLE IF EXISTS `sysmodule`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `sysmodule` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `menupos` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq__sysmodule__code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `sysmodule`
--

LOCK TABLES `sysmodule` WRITE;
/*!40000 ALTER TABLE `sysmodule` DISABLE KEYS */;
INSERT INTO `sysmodule` VALUES (1,'Index','Обзор',1),(2,'Pages','Страницы',2),(3,'Users','Пользователи',3),(4,'Account','Профиль пользователя',0),(5,'Files','Файлы и картинки',4);
/*!40000 ALTER TABLE `sysmodule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sysparams`
--

DROP TABLE IF EXISTS `sysparams`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `sysparams` (
  `metaobject_id` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `sortby` varchar(255) NOT NULL DEFAULT '',
  `sortorder` varchar(255) NOT NULL DEFAULT '',
  `groupby` varchar(255) NOT NULL DEFAULT '',
  `groupstyle` varchar(255) NOT NULL DEFAULT '',
  `action_list` tinyint(1) NOT NULL DEFAULT '0',
  `action_view` tinyint(1) NOT NULL DEFAULT '0',
  `action_create` tinyint(1) NOT NULL DEFAULT '0',
  `action_edit` tinyint(1) NOT NULL DEFAULT '0',
  `action_delete` tinyint(1) NOT NULL DEFAULT '0',
  `export_metaattribute_id` int(10) unsigned NOT NULL DEFAULT '0',
  `menupos` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `uq__sysparams__metaobject_id` (`metaobject_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `sysparams`
--

LOCK TABLES `sysparams` WRITE;
/*!40000 ALTER TABLE `sysparams` DISABLE KEYS */;
INSERT INTO `sysparams` VALUES (2,'Пользователи','name','asc','name','',0,0,0,0,0,19,0),(11,'Страницы','name','asc','name','',0,0,0,0,0,69,0),(12,'Новости','dt','desc','dt','',1,1,1,1,1,77,1),(13,'Проекты','pos','asc','name','',1,1,1,1,1,81,9),(14,'Подписчики','email','asc','email','',1,1,1,1,1,85,9),(15,'Отчетность АО','dt','desc','dt','',1,1,1,1,1,87,1);
/*!40000 ALTER TABLE `sysparams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `syssecurity`
--

DROP TABLE IF EXISTS `syssecurity`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `syssecurity` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sysuser_id` int(10) unsigned NOT NULL DEFAULT '0',
  `metaobject_id` int(10) unsigned NOT NULL DEFAULT '0',
  `object_id` int(10) unsigned NOT NULL DEFAULT '0',
  `metaview_id` int(10) unsigned NOT NULL DEFAULT '0',
  `rights` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `syssecurity`
--

LOCK TABLES `syssecurity` WRITE;
/*!40000 ALTER TABLE `syssecurity` DISABLE KEYS */;
INSERT INTO `syssecurity` VALUES (1,1,5,1,0,1),(2,1,5,3,0,1),(3,1,5,4,0,1),(24,1,5,1,0,1),(25,1,5,2,0,1),(26,1,5,3,0,1),(27,1,5,4,0,1),(28,1,5,5,0,1),(29,1,2,0,0,11),(30,1,11,0,0,11),(31,1,11,0,1,1),(32,1,12,0,0,11),(33,1,12,0,2,1),(34,1,12,0,3,1),(35,1,12,0,4,1),(36,1,15,0,0,11),(37,1,15,0,11,1),(38,1,15,0,12,1),(39,1,15,0,13,1),(40,1,13,0,0,11),(41,1,13,0,5,1),(42,1,13,0,6,1),(43,1,13,0,7,1),(44,1,14,0,0,11),(45,1,14,0,8,1),(46,1,14,0,9,1),(47,1,14,0,10,1);
/*!40000 ALTER TABLE `syssecurity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sysuser`
--

DROP TABLE IF EXISTS `sysuser`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `sysuser` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `_id` int(10) unsigned NOT NULL DEFAULT '0',
  `email` varchar(255) NOT NULL DEFAULT '',
  `pwd` char(40) NOT NULL DEFAULT '',
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `cfghtmlarea` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `ix__sysuser___id` (`_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `sysuser`
--

LOCK TABLES `sysuser` WRITE;
/*!40000 ALTER TABLE `sysuser` DISABLE KEYS */;
INSERT INTO `sysuser` VALUES (1,0,'','',1,'Администраторы',0),(2,1,'admin','40dc6c3b5c6595384395164908da32c18ae9dfc9',1,'Администратор',1);
/*!40000 ALTER TABLE `sysuser` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2010-11-11 17:38:01
