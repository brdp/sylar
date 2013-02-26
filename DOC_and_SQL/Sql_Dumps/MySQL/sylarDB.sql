-- phpMyAdmin SQL Dump
-- version 2.9.0-beta1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generato il: 25 Giu, 2008 at 06:13 PM
-- Versione MySQL: 5.0.24
-- Versione PHP: 5.1.5
-- 
-- Database: `sylarExampleDB`
-- 

-- --------------------------------------------------------

-- 
-- Struttura della tabella `SYLAR_DEV_error_code`
-- 

CREATE TABLE `SYLAR_DEV_error_code` (
  `code` int(11) NOT NULL auto_increment,
  `message` varchar(255) collate latin1_general_ci NOT NULL,
  `detail` text collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`code`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=10033 ;

-- 
-- Dump dei dati per la tabella `SYLAR_DEV_error_code`
-- 

INSERT INTO `SYLAR_DEV_error_code` (`code`, `message`, `detail`) VALUES 
(10001, 'Bad Locale Configuration. Language is null', ''),
(10002, 'Bad Locale Configuration. CharSet is null', ''),
(10003, 'Bad Locale Configuration. Time Zone Offset is null', ''),
(10004, 'The key of standard locale configuration does not exists. Key: ', ''),
(10005, 'The key of standard locale configuration is null', ''),
(10006, 'Dict file does not exists. File', ''),
(10007, 'Application Locale Root on Filesystem is not defined or not visible from the object Language', 'try calling the method previously setApplicationLocaleRootFs($sApplicationLocaleRootFs)'),
(10008, 'Language encode error. Replace array is not an array', ''),
(10009, 'No StandardSettingsKey provided. Configuration not modified', ''),
(10010, 'No data provided for login process.', 'when only password is provided'),
(10011, 'User Not found for Login', 'Sylar_SqlSession::Login'),
(10012, 'ERROR! More than one user with same username: ".$username." in the Storage!', 'Sylar_SqlSession::Login'),
(10013, 'Error! Cookie not set', ''),
(10014, 'Unknown Mail Type', 'e-mail type can be only:\r\ntxt\r\nhtml'),
(10015, 'Name or email address inconsistent... email:', ''),
(10016, 'Provided array of address list is inconsistent', ''),
(10017, 'Email address list is not OK!', ''),
(10018, 'Address list array is NULL', ''),
(10019, 'Address list array is not an array', ''),
(10020, 'It''s impossible to send e-mail to nobody!', ''),
(10021, 'It''s impossible to send e-mail without Sender address specified', ''),
(10022, 'Email address not valid! email', ''),
(10023, 'DataBase Error. Connection Failed!', ''),
(10024, 'Application static locale file does not exists', ''),
(10025, 'Application dictionary folder not defined.', ''),
(10026, 'Wrong Db Configuration. Check the application configuration file', ''),
(10027, 'DataBase Error. Disconnect failed!', ''),
(10028, 'DB Error. Error during query execution.', ''),
(10029, 'DB Error. Someting wrong during retrive the last insert id', ''),
(10030, 'DB Error. Error retrive affected row number.', ''),
(10031, 'Smart login is impossible without LastSessioId', ''),
(10032, 'Required param null. Password and lastSessId is all null', '');

-- --------------------------------------------------------

-- 
-- Struttura della tabella `SYLAR_active_sessions`
-- 

CREATE TABLE `SYLAR_active_sessions` (
  `sess_id` varchar(32) collate latin1_general_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip` varchar(50) collate latin1_general_ci NOT NULL,
  `logged` smallint(1) default '0',
  `ts_init` int(11) NOT NULL,
  `ts_last_act` int(11) NOT NULL,
  `num_actions` int(11) NOT NULL,
  `last_action` varchar(255) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`sess_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Dump dei dati per la tabella `SYLAR_active_sessions`
-- 


-- --------------------------------------------------------

-- 
-- Struttura della tabella `SYLAR_event_log`
-- 

CREATE TABLE `SYLAR_event_log` (
  `event_id` int(11) NOT NULL auto_increment,
  `user_id` int(11) default NULL,
  `level` int(11) default NULL,
  `level_desc` varchar(20) collate latin1_general_ci default NULL,
  `ip_address` varchar(15) collate latin1_general_ci default NULL,
  `istant` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `event_desc` varchar(255) collate latin1_general_ci default NULL,
  `web_page` varchar(255) collate latin1_general_ci default NULL,
  `extra_info` varchar(255) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`event_id`),
  KEY `level` (`level`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Dump dei dati per la tabella `SYLAR_event_log`
-- 


-- --------------------------------------------------------

-- 
-- Struttura della tabella `SYLAR_permissions`
-- 

CREATE TABLE `SYLAR_permissions` (
  `permission_id` int(11) unsigned NOT NULL auto_increment,
  `code` varchar(50) collate latin1_general_ci NOT NULL default '',
  `description` varchar(255) collate latin1_general_ci default NULL,
  `hidden` smallint(1) default '0',
  `system` smallint(1) default '0',
  `active` smallint(1) default '1',
  PRIMARY KEY  (`permission_id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=6 ;

-- 
-- Dump dei dati per la tabella `SYLAR_permissions`
-- 

INSERT INTO `SYLAR_permissions` (`permission_id`, `code`, `description`, `hidden`, `system`, `active`) VALUES 
(1, 'sylar_user_add', 'add a new user ', 0, 0, 1),
(2, 'sylar_user_remove', 'remove an existing user', 0, 0, 1),
(3, 'app_news_publish', 'Can publish a news in example application', 0, 0, 1),
(4, 'app_news_remove', 'Can delete a news from example application', 0, 0, 1),
(5, 'app_news_write', 'can write a news', 0, 0, 1);

-- --------------------------------------------------------

-- 
-- Struttura della tabella `SYLAR_preferences`
-- 

CREATE TABLE `SYLAR_preferences` (
  `pref_id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) collate latin1_general_ci NOT NULL,
  `value` varchar(255) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`pref_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Dump dei dati per la tabella `SYLAR_preferences`
-- 


-- --------------------------------------------------------

-- 
-- Struttura della tabella `SYLAR_rel_usergroup_permission`
-- 

CREATE TABLE `SYLAR_rel_usergroup_permission` (
  `group_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Dump dei dati per la tabella `SYLAR_rel_usergroup_permission`
-- 

INSERT INTO `SYLAR_rel_usergroup_permission` (`group_id`, `permission_id`) VALUES 
(1, 1),
(1, 2),
(2, 3),
(2, 4),
(2, 3),
(3, 3);

-- --------------------------------------------------------

-- 
-- Struttura della tabella `SYLAR_rel_users_usergroups`
-- 

CREATE TABLE `SYLAR_rel_users_usergroups` (
  `user_id` int(10) unsigned NOT NULL default '0',
  `group_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Dump dei dati per la tabella `SYLAR_rel_users_usergroups`
-- 

INSERT INTO `SYLAR_rel_users_usergroups` (`user_id`, `group_id`) VALUES 
(1, 1),
(1, 3),
(2, 2),
(2, 3);

-- --------------------------------------------------------

-- 
-- Struttura della tabella `SYLAR_usergroups`
-- 

CREATE TABLE `SYLAR_usergroups` (
  `group_id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(30) collate latin1_general_ci NOT NULL default '',
  `description` varchar(255) collate latin1_general_ci default NULL,
  `active` smallint(1) NOT NULL default '0',
  `system` char(1) collate latin1_general_ci default '0',
  `hidden` smallint(1) NOT NULL default '0',
  PRIMARY KEY  (`group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=4 ;

-- 
-- Dump dei dati per la tabella `SYLAR_usergroups`
-- 

INSERT INTO `SYLAR_usergroups` (`group_id`, `name`, `description`, `active`, `system`, `hidden`) VALUES 
(1, 'Administrators', 'Global Administrators -Reserved', 1, '1', 1),
(2, 'Publisher', 'An example application Group', 1, '0', 0),
(3, 'Writer', 'writer example user', 1, '0', 0);

-- --------------------------------------------------------

-- 
-- Struttura della tabella `SYLAR_users`
-- 

CREATE TABLE `SYLAR_users` (
  `user_id` int(10) unsigned NOT NULL auto_increment,
  `username` varchar(50) collate latin1_general_ci NOT NULL,
  `password` varchar(32) collate latin1_general_ci default NULL,
  `name` varchar(50) collate latin1_general_ci default NULL,
  `surname` varchar(50) collate latin1_general_ci default NULL,
  `email` varchar(50) collate latin1_general_ci default NULL,
  `session_id` varchar(64) collate latin1_general_ci NOT NULL,
  `last_update` timestamp NULL default NULL,
  `last_login` timestamp NULL default NULL,
  `last_action` timestamp NULL default NULL,
  `last_logout` timestamp NULL default NULL,
  `num_login` int(10) unsigned default NULL,
  `note` text collate latin1_general_ci,
  `active` smallint(1) unsigned default '1',
  `system` smallint(1) NOT NULL default '0',
  `hidden` smallint(1) NOT NULL default '0',
  `deleted` smallint(1) NOT NULL default '0',
  PRIMARY KEY  (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `active` (`active`),
  KEY `deleted` (`deleted`),
  KEY `system` (`system`),
  KEY `hidden` (`hidden`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=3 ;

-- 
-- Dump dei dati per la tabella `SYLAR_users`
-- 

INSERT INTO `SYLAR_users` (`user_id`, `username`, `password`, `name`, `surname`, `email`, `session_id`, `last_update`, `last_login`, `last_action`, `last_logout`, `num_login`, `note`, `active`, `system`, `hidden`, `deleted`) VALUES 
(1, 'brdp', '68cafd9048642157528f69f2b1a41c78', 'Gianluca', 'Giusti', 'brdp@sylar.sylar', 'qarglvt2h6grodau01lshbhr34', '2008-02-19 08:19:13', '2008-06-03 22:00:21', NULL, '2008-06-03 22:00:21', 262, 'Prova', 1, 0, 0, 0),
(2, 'Matt', '7c1f90bd9bdc70cc059640a7a6209389', 'Matt', 'Red', 'matt@yoursite.com', '', '2008-02-19 08:18:49', NULL, NULL, NULL, 0, 'test user', 1, 0, 0, 0);
