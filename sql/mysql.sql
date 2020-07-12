CREATE TABLE `rmgs_categos` (
  `id_cat` int(11) NOT NULL auto_increment,
  `nombre` varchar(100) NOT NULL default '',
  `desc` varchar(255) NOT NULL default '',
  `fecha` varchar(40) NOT NULL default '',
  `parent` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id_cat`)
) TYPE=MyISAM;

CREATE TABLE `rmgs_favorites` (
  `id_user` int(11) NOT NULL default '0',
  `id_img` int(11) NOT NULL default '0',
  `fecha` int(11) NOT NULL default '0',
  KEY `id_user` (`id_user`,`id_img`)
) TYPE=MyISAM;

CREATE TABLE `rmgs_groups` (
  `id_cat` int(11) NOT NULL default '0',
  `id_grp` int(11) NOT NULL default '0'
) TYPE=MyISAM;

CREATE TABLE `rmgs_imglink` (
  `id_img` int(11) NOT NULL default '0',
  `id_cat` int(11) NOT NULL default '0'
) TYPE=MyISAM;

CREATE TABLE `rmgs_imgs` (
  `id_img` int(11) NOT NULL auto_increment,
  `titulo` varchar(100) NOT NULL default '',
  `file` varchar(255) NOT NULL default '',
  `idu` int(11) NOT NULL default '0',
  `fecha` varchar(40) NOT NULL default '',
  `update` int(11) NOT NULL default '0',
  `votos` int(11) NOT NULL default '0',
  `descargas` int(11) NOT NULL default '0',
  `rating` int(11) NOT NULL default '0',
  `home` tinyint(1) NOT NULL default '0',
  `reviews` int (11) NOT NULL default '0',
  PRIMARY KEY  (`id_img`)
) TYPE=MyISAM;

CREATE TABLE `rmgs_keylink` (
  `key` int(11) NOT NULL default '0',
  `img` int(11) NOT NULL default '0'
) TYPE=MyISAM;

CREATE TABLE `rmgs_keys` (
  `id_key` int(11) NOT NULL auto_increment,
  `key` varchar(100) NOT NULL default '',
  `points` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id_key`)
) TYPE=MyISAM;

CREATE TABLE `rmgs_postales` (
  `id_postal` int(11) NOT NULL auto_increment,
  `id_img` int(11) NOT NULL default '0',
  `codigo` varchar(40) NOT NULL default '',
  `titulo` varchar(100) NOT NULL default '',
  `texto` text NOT NULL,
  `idu` int(11) NOT NULL default '0',
  `email_sender` varchar(150) NOT NULL default '',
  `name_sender` varchar(150) NOT NULL default '',
  `email_dest` varchar(150) NOT NULL default '',
  `name_dest` varchar(150) NOT NULL default '',
  `plantilla` varchar(100) NOT NULL default '',
  `fecha` int(11) NOT NULL default '0',
  `redirect` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id_postal`)
) TYPE=MyISAM;

CREATE TABLE `rmgs_sizes` (
  `id_size` int(11) NOT NULL auto_increment,
  `titulo` varchar(255) NOT NULL default '',
  `id_img` int(11) NOT NULL default '0',
  `file` varchar(255) NOT NULL default '',
  `type` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id_size`)
) TYPE=MyISAM;

CREATE TABLE `rmgs_users` (
  `uid` int(11) NOT NULL default '0',
  `limit` int(11) NOT NULL default '0',
  `rating` int(11) NOT NULL default '0',
  `votos` int(11) NOT NULL default '0',
  `results` int(11) NOT NULL default '0'
) TYPE=MyISAM;

CREATE TABLE `rmgs_votes` (
  `id_img` int(11) NOT NULL default '0',
  `uid` int(11) NOT NULL default '0',
  `ip` varchar(20) NOT NULL default '',
  `fecha` int(11) NOT NULL default '0'
) TYPE=MyISAM;

CREATE TABLE `rmgs_writes` (
  `id_cat` int(11) NOT NULL default '0',
  `id_grp` int(11) NOT NULL default '0'
) TYPE=MyISAM;