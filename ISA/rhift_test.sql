-- phpMyAdmin SQL Dump
-- version 2.11.9.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 19, 2010 at 11:38 PM
-- Server version: 5.0.77
-- PHP Version: 4.4.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `rhift_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL auto_increment,
  `first` varchar(30) NOT NULL default '',
  `last` varchar(30) NOT NULL default '',
  `user_id` varchar(30) NOT NULL default '',
  `password_hash` longtext NOT NULL,
  `email` varchar(60) NOT NULL default '',
  `balance` varchar(30) NOT NULL default '',
  `last_update` datetime default NULL,
  `question` varchar(100) NOT NULL default '',
  `answer` varchar(100) NOT NULL default '',
  `notice` mediumtext NOT NULL,
  `gm` longtext NOT NULL,
  `level` varchar(30) NOT NULL default '',
  `locked` varchar(4) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=62 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first`, `last`, `user_id`, `password_hash`, `email`, `balance`, `last_update`, `question`, `answer`, `notice`, `gm`, `level`, `locked`) VALUES
(1, 'Brad', 'Wilson', 'Brad', 'bf93d3475bd23b51c77c7ebed1b3a8a22bccb5fd', 'brad@rhift.com', 'GENIUS WOW!!', '2010-03-07 03:59:35', 'test', 'good', 'Testing and so forth. You are awsome! A over the top!\r\n', 'Account balances are now up to date.', 'treasurer', 'no'),
(2, 'Janell', 'Wilson', 'Janell', '66641ffc2df559942265cbbac9947f68695d79d1', 'Troop71Treasurer@comcast.net', 'Beautiful', '2006-08-29 20:30:54', 'What is my grad school?', 'Dominican', 'Hey. check your e-mail.', 'Account balances are now up to date.', 'treasurer', 'no'),
(23, 'Alan', 'Baar', 'Alan Baar', '91a131a7c5a2f26b6daf9d633fec4516442d47ae', 'Troop71Treasurer@comcast.net', '338.51', '2008-02-07 13:22:24', '', '', '', 'Account balances are now up to date.', 'user', 'no'),
(24, 'Craig', 'Basarich', 'Craig Basarich', 'dc4facaa7a01970f1b8712883791e3e5f3b08c83', 'Troop71Treasurer@comcast.net', '47.00', '2007-01-15 21:30:55', '', '', '', 'Account balances are now up to date.', 'user', 'no'),
(25, 'Joshua', 'Bixler', 'Joshua Bixler', '9312e4b3535bda7913cd76413163611521ab6a52', 'Troop71Treasurer@comcast.net', '58.30', '2008-02-07 13:29:28', '', '', '', 'Account balances are now up to date.', 'user', 'no'),
(26, 'Tom', 'Bixler', 'Tom Bixler', 'd7989be56490e96cbda7398d468ccd323195764a', 'Troop71Treasurer@comcast.net', '88.53', '2007-01-15 21:30:55', '', '', '', 'Account balances are now up to date.', 'user', 'no'),
(27, 'Alex', 'Blanchard', 'Alex Blanchard', '84700ce872a465dbe222369efa9761de3ad66927', 'Troop71Treasurer@comcast.net', '49.00', '2008-02-07 13:52:40', '', '', '', 'Account balances are now up to date.', 'user', 'yes'),
(28, 'Spencer', 'Carver', 'Spencer Carver', '6822f275fef591bd028d359c5e65588f81f56fd2', 'spencer.carver@gmail.com', '', '2009-03-01 20:06:56', 'Cat Name', 'bisque', 'Your Sea Base request of $270.31 has been deducted from your account.', 'Account balances are now up to date.', 'user', 'no'),
(29, 'Kevin', 'Doran', 'Kevin Doran', '584d16b5e9051a61c1c0b1a08a05a07363a74cb4', 'Troop71Treasurer@comcast.net', '175.56', '2009-03-01 20:38:54', '', '', 'Balance after Sea Base payment.', 'Account balances are now up to date.', 'user', 'no'),
(59, 'Russell', 'Plate', 'Russell Plate', 'e97b5fc8ddd45c315b9a25f03bde2f4704c2ec7c', 'Troop71Treasurer@comcast.net', '25.00', '2009-01-19 11:23:26', '', '', 'Welcome to your ISA! Remember to change the email address to your own, change the Password and add a security question with an answer so if you get locked you can get back in.', 'Account balances are now up to date.', 'user', 'no'),
(30, 'Mike', 'Edmonds', 'Mike Edmonds', 'fca997c4fc69aaa67f649226d6adca558a0ea376', 'tnkedmonds@aol.com', '', '2008-02-07 13:53:00', '', '', 'Mike, After reimbursing you for your Philmont expenses, your ISA is now depleted. ', 'Account balances are now up to date.', 'user', 'yes'),
(31, 'Frank', 'Elloian', 'Frank Elloian', '8e06e1be9626fd9c96c5f1170cf1d8af33170a91', 'Troop71Treasurer@comcast.net', '47.56', '2007-09-03 15:27:20', '', '', 'Welcome to your ISA Online Account.  You need to change the email address to your own and set up a password.', 'Account balances are now up to date.', 'user', 'no'),
(32, 'Cameron', 'Frossard', 'Cameron Frossard', '87dfed8d43fdc4525086709625ab686c65a69048', 'Troop71Treasurer@comcast.net', '118.04', '2007-01-15 21:30:55', '', '', '', 'Account balances are now up to date.', 'user', 'no'),
(33, 'William', 'Klauber', 'William Klauber', 'b2fb3106dc4396a842f3a2e4d905087137ec6e73', 'Troop71Treasurer@comcast.net', '30.43', '2009-01-19 11:10:47', '', '', '', 'Account balances are now up to date.', 'user', 'no'),
(34, 'Andrew', 'Klein', 'Andrew Klein', 'fc5648be8bd68a074044c50d56523ac2ac5cce16', 'Troop71Treasurer@comcast.net', '11.57', '2008-03-16 11:02:27', '', '', 'Your new balance after your initial deposit for Sea Base 2009.', 'Account balances are now up to date.', 'user', 'no'),
(35, 'Thomas', 'Klonowski', 'Thomas Klonowski', '100bdbc96ffd089b18d44bd014b31fc0bad9d08b', 'Troop71Treasurer@comcast.net', '47.00', '2007-07-29 15:56:58', '', '', '', 'Account balances are now up to date.', 'user', 'no'),
(36, 'Michael', 'Kohler', 'MDK', '5479f2fa49524adacff538d1cb23df73200d0ec6', 'kohler411@comcast.net', '4.04', '2007-09-03 14:38:08', 'Dogs Name', 'Samson', '', 'Account balances are now up to date.', 'user', 'no'),
(37, 'Daniel', 'McClory', 'Daniel McClory', '1cf070268419b1f35955d6d7950c7ae4e312f7a4', 'Troop71Treasurer@comcast.net', '76.80', '2007-01-15 21:30:55', '', '', '', 'Account balances are now up to date.', 'user', 'no'),
(38, 'Clint', 'McDonald', 'DeathDragon', '6211fdda4012d7339e0a84e8c045e553573340c5', 'wjclm@aol.com', '35.29', '2007-07-29 15:58:19', 'Mothers Maiden name', 'punches', '', 'Account balances are now up to date.', 'user', 'no'),
(39, 'Matthew', 'Message', 'Matthew Message', 'bf9542dd826e66b794eddca94a18b035ab8119f8', 'm.message@comcast.net', '417.58', '2009-03-11 20:51:17', 'ill', 'ini', 'Balance as of 3/1/09', 'Account balances are now up to date.', 'user', 'no'),
(40, 'Paul', 'Myles', 'Paul Myles', '6a87c09459170d72585c168169837af76c870cc4', 'rmyles8796@netzero.com', '198.55', '2008-09-20 13:46:54', '', '', '', 'Account balances are now up to date.', 'user', 'no'),
(41, 'James', 'Pierson', 'James Pierson', '90f9523e18f8b6798b8f21b7e27cd76200b54877', 'Troop71Treasurer@comcast.net', '69.16', '2008-02-07 13:38:55', '', '', '', 'Account balances are now up to date.', 'user', 'no'),
(42, 'Eric', 'Seiler', 'Eric Seiler', '0c95c4c3d882b314865fd4fb4da03794b56f2ee2', 'utamce@comcast.net', '244.54', '2009-03-03 20:36:23', '', '', 'The balance is current as of 3/03/09.', 'Account balances are now up to date.', 'user', 'no'),
(60, 'Mark', 'Thommes', 'Mark Thommes', '723a5248e08d2fa07090d058eeee0b3938b79e31', 'Troop71Treasurer@comcast.net', '85.00', '2009-01-19 11:37:13', '', '', 'Welcome to your ISA! Remember to change the email address above to your own, change the password and add a security question with an answer so that if you get locked out you can get back in.', 'Account balances are now up to date.', 'user', 'no'),
(43, 'Jordan', 'Sickle', 'Jordan Sickle', '6b5c54d51c95c3cd3688899e7d81fae1f5c7e287', 'Troop71Treasurer@comcast.net', '133.01', '2007-01-15 21:30:55', '', '', '', 'Account balances are now up to date.', 'user', 'no'),
(44, 'Sam', 'Stewart', 'Sam Stewart', 'dd0771c6b04610043de7646a2486762fd881db94', 'Troop71Treasurer@comcast.net', '214.36', '2007-07-29 16:01:10', '', '', '', 'Account balances are now up to date.', 'user', 'no'),
(45, 'Eric', 'Titus', 'Eric Titus', 'c04e2a21652ab72b2a8eeed5fc1b899c00e29f68', 'Troop71Treasurer@comcast.net', '', '2008-02-07 13:55:53', '', '', 'The balance represents  the use of all of your funds on Scout Related items. Scout a/c is closed (Scout has turned 18 years old).', 'Account balances are now up to date.', 'user', 'yes'),
(46, 'Adam', 'Tussing', 'Adam Tussing', '701ac07bd6d81dcea2050cadabe27f5ce219a99b', 'Troop71Treasurer@comcast.net', '255.32', '2008-02-07 13:44:58', '', '', '', 'Account balances are now up to date.', 'user', 'no'),
(47, 'Nick', 'Wilson', 'Nick Wilson', '95c4684fdaf3408f105effad55a3d26f71e4ac77', 'Troop71Treasurer@comcast.net', '215.12', '2008-02-07 13:56:47', '', '', '', 'Account balances are now up to date.', 'user', 'no'),
(48, 'Shadow', 'Cat', 'Shadow Cat', '7d5c2a2d6136fbf166211d5183bf66214a247f31', 'gwilson1@ku.edu', 'Kibbles', '2007-02-21 18:39:38', 'What color am I?', 'Black and White', 'Remember to safeguard your ISA information!', 'Account balances are now up to date.', 'user', 'yes'),
(52, 'Raymond', 'Wright', 'Raymond Wright', '0308ecdbdc06b301553d0256b5fbbbfd51ad5a2d', 'Troop71Treasurer@comcast.net', '71.00', '2008-06-16 16:15:22', '', '', 'Welcome to Troop 671 ISA! Remember to change the email address to your email address!', 'Account balances are now up to date.', 'user', 'no'),
(51, 'Justin', 'Elledge', 'Justin Elledge', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', 'Troop71Treasurer@comcast.net', '268.02', '2009-01-19 11:45:32', '', '', '', 'Account balances are now up to date.', 'user', 'no'),
(55, 'Sean', 'Korecky', 'Sean Korecky', '12be265493a61bbc14274a0a21f480d556487f15', 'Troop71Treasurer@comcast.net', '86.74', '2009-01-19 11:11:57', '', '', 'Welcome to your ISA! Remember to change the email address to your own, change the Password and add a security question with an answer so if you get locked you can get back in.', 'Account balances are now up to date.', 'user', 'no'),
(50, 'Blake', 'Young', 'b_young', '48a5c526f5bf77da2437e188691cafcbd931ad62', 'rhift@hotmail.com', '99999999932098743.00', '2007-02-21 18:44:53', '', '', 'I love you!', 'Account balances are now up to date.', 'user', 'yes'),
(49, 'Bob', 'Bland', 'bbland', 'efb61c7f9cd0668361362e3943aaaf8916cf7084', 'brad@rhift.com', '345.98', '2008-02-07 13:57:15', '', '', 'Keep up the good work!', 'Account balances are now up to date.', 'user', 'yes'),
(53, 'Nick', 'Jakolat', 'Nick Jakolat', '1ecd5e5dae420a459be6c05a44c9eeff7920d920', 'Troop71Treasurer@comcast.net', '114.17', '2008-02-07 13:34:16', '', '', 'Welcome to your ISA! Please remember to change your password AND your email address!', 'Account balances are now up to date.', 'user', 'no'),
(54, 'Nick', 'Pierson', 'Nick Pierson', '9c6d6d1710b570df50572c0404e439a929433df5', 'Troop71Treasurer@comcast.net', '8.50', '2008-02-07 13:42:09', '', '', 'Welcome to your online Troop account.  Remember to change your password and enter in your email account.', 'Account balances are now up to date.', 'user', 'no'),
(56, 'Zachery', 'Byerly', 'Zachery Byerly', '0e8ecb9f4c7c99faf927fe564719912d8cca109b', 'Troop71Treasurer@comcast.net', '161.85', '2009-01-19 11:43:48', '', '', 'Welcome to your ISA! Remember to change the email address to your own, change the Password and add a security question with an answer so if you get locked you can get back in.', 'Account balances are now up to date.', 'user', 'no'),
(57, 'Raymond', 'Richter', 'Raymond Richter', '0aef22912ea4000405c162b6f3e810ca825727d8', 'Troop71Treasurer@comcast.net', '61.27', '2009-01-19 11:25:01', '', '', 'Welcome to your ISA! Remember to change the email address to your own, change the Password and add a security question with an answer so if you get locked you can get back in.', 'Account balances are now up to date.', 'user', 'no'),
(58, 'David', 'Bergquist', 'David Bergquist', '98f1d89808921dbb4698d4cec8d3fcdebc62df3b', 'kmbergquist@comcast.net', '54.18', '2009-01-19 11:05:56', 'In what city was Keith born?', 'Pasadena', 'Welcome to your ISA! Remember to change the email address to your own, change the Password and add a security question with an answer so if you get locked you can get back in.', 'Account balances are now up to date.', 'user', 'no');
