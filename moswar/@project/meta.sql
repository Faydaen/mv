CREATE TABLE `metaobject` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `code` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `versions` tinyint(3) unsigned NOT NULL default 0,
  `logs` tinyint(1) unsigned default 0,
  `extendsmetaobject_id` int(10) unsigned NOT NULL default 0,
  `extendstype` tinyint(3) unsigned NOT NULL default 0,
  PRIMARY KEY  (`id`),
  KEY `ix__metaobject__code` (`code`)
) ENGINE=InnoDb DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE `metaattribute` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `metaobject_id` int(10) unsigned NOT NULL,
  `code` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  `typeparam` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL default '',
  `role` tinyint(3) unsigned NOT NULL default 3,
  PRIMARY KEY  (`id`),
  KEY `ix__metaattribute__metaobject_id` (`metaobject_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE `metaview` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `metaobject_id` int(10) unsigned NOT NULL,
  `code` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL default '',
  `tree_metaobject_id` int(10) unsigned NOT NULL default 0,
  `template` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `templaterow` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `ix__metaview__metaobject_id` (`metaobject_id`),
  KEY `ix__metaview__code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE `metaviewfield` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `metaview_id` int(10) unsigned NOT NULL,
  `metaattribute_id` int(10) unsigned NOT NULL,
  `uie` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL default '',
  `uieparams` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL default '',
  `defaultvalue` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL default '',
  `required` tinyint(1) unsigned NOT NULL default 0,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL default '',
  `hint` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL default '',
  `unit` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL default '',
  `mask` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL default '',
  `group` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL default '',
  `pos` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `ix__metaviewfield__metaview_id` (`metaview_id`)
) ENGINE=InnoDb DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE `metaviewcondition` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `metaview_id` int(10) unsigned NOT NULL,
  `metaattribute_id` int(10) unsigned NOT NULL,
  `operation` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `value` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL default '',
  `sql` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `ix__metaviewcondition__metaview_id` (`metaview_id`)
) ENGINE=InnoDb DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE `metarelation` (
  `from` int(10) unsigned NOT NULL,
  `to` int(10) unsigned NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  KEY `ix__metarelation__from` (`from`),
  KEY `ix__metarelation__to` (`to`)
) ENGINE=InnoDb DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE `metalink` (
  `metaattribute_id` int(10) unsigned NOT NULL,
  `object_id` int(10) unsigned NOT NULL,
  `linkedobject_id` int(10) unsigned NOT NULL,
  KEY `ix__metalink__metaattribute_id` (`metaattribute_id`),
  KEY `ix__metalink__object_id` (`object_id`),
  KEY `ix__metalink__linkedobject_id` (`linkedobject_id`)
) ENGINE=InnoDb DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;