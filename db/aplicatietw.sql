-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2019 at 11:27 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aplicatietw`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `frequency` (`pass` VARCHAR(100)) RETURNS INT(10) UNSIGNED BEGIN
	DECLARE i INT;
    
    SELECT COUNT(*) INTO i FROM items WHERE AES_DECRYPT(password, UNHEX(SHA2(username, 512))) = pass;
    
    RETURN i;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `strength` (`pass` VARCHAR(100)) RETURNS INT(10) UNSIGNED BEGIN
	DECLARE SCORE INT;
    DECLARE LEN INT;
    DECLARE UPPERCASE INT;
    DECLARE UPPERCASE_ALPH VARCHAR(30);
    DECLARE LOWERCASE INT;
    DECLARE LOWERCASE_ALPH VARCHAR(30);
    DECLARE v_NUMBER INT;
    DECLARE NUMBER_ALPH VARCHAR(30);
    DECLARE SYMBOLS INT;
    SET UPPERCASE_ALPH := 'ABCDEFGHIJKLMNOPQRSTUWXYZ';
    SET LOWERCASE_ALPH := 'abcdefghijklmnopqrstuwxyz';
    SET NUMBER_ALPH := '1234567890';
    SET SCORE := 0;
    SELECT LENGTH(pass) INTO LEN FROM DUAL;
    #ADUNARI
    #NR CHAR - +(N*4)
    SET SCORE := SCORE + LEN * 4;
    #UPPERCASE - +((LEN-N)*2)
    SELECT LENGTH(REPLACE(pass, UPPERCASE_ALPH, '')) INTO UPPERCASE FROM DUAL;
    SET UPPERCASE := LEN - UPPERCASE;
    SET SCORE := SCORE + (LEN - UPPERCASE) * 2;
    #LOWERCASE - +((LEN-N)*2)
    SELECT LENGTH(REPLACE(pass, LOWERCASE_ALPH, '')) INTO LOWERCASE FROM DUAL;
    SET LOWERCASE := LEN - LOWERCASE;
    SET SCORE := SCORE + (LEN - LOWERCASE) * 2;
    #NUMBER - +(N*4)
    SELECT LENGTH(REPLACE(pass, NUMBER_ALPH, '')) INTO v_NUMBER FROM DUAL;
    SET v_NUMBER := LEN - v_NUMBER;
    SET SCORE := SCORE + v_NUMBER * 4;
    #SYMBOLS - +(N*6)
    SELECT LENGTH(REPLACE(pass, UPPERCASE_ALPH || LOWERCASE_ALPH || NUMBER_ALPH, '')) INTO SYMBOLS FROM DUAL;
    SET SCORE := SCORE + SYMBOLS * 6;
    RETURN SCORE;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `max_time` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `user_id`, `title`, `username`, `password`, `url`, `comment`, `max_time`) VALUES
(56, 17, 'Google account', 'admingoogle123', '¤ú)­õâ2¾»h×¥R\n$‚Ù	Y‘³‹!JhÙia°', 'www.google.com', '', '2019-05-29'),
(57, 17, 'Yahoo', 'MyMail', 'ÐÛVÃÛOE˜ù¿ão¾', 'www.mail.yahoo.com', 'my mail account', '2019-06-28'),
(58, 17, 'Facebook', 'popescudavid91', 'Rº6ý,‚K%´N5©RóÎ³*ÓYåRä$áÊ´ï3­[Ùgˆ‡xÏ?YÐç!¾¨ñ.Ð‡8‘r\rÕÿN—©Äô3ÆÃ‚;•áXù&:÷ÂåA', 'www.facebook.com', '', '0000-00-00'),
(59, 17, 'Twitter', 'popa_paull', 'Óà±„¢þ‘G…Á¿duÐVŸRSÿ—@¯Õ{@Œ\0Bç ‘Å&KüŒ83MóÖe', 'www.twitter.com', '', '2019-05-30'),
(66, 17, 'Instragram', 'cosmin_serbann', '½HøX#YÔêà4XXîÖ', 'www.instagram.com', 'My instagram account', '0000-00-00'),
(67, 17, 'Passer', 'admin', 'Kãbw^¯/3 ,OÝÂc3>', 'www.passer.ro', '', '0000-00-00'),
(68, 18, 'NewAccount', 'Alin', 'æ¯Åò`C¡1ÑEº…', 'www.mysite.ro', 'test', '0000-00-00'),
(69, 18, 'FII', 'alin.ciocoveanu', '‘\0F÷ë†±-j¼ïoáØ}\")¡jy·€:þŒŒYk•‘£—-n$“ÔX.šÚÈmÌ6Ùq„3ÄU¡ë|3ÚË*C¦`h·ž¶ûêSQÇÖ›—jÙÜ[ê…)íaµ–š', 'https://webmail-studs.info.uaic.ro/', '', '2019-05-29'),
(70, 17, 'Github', 'alinciocoveanu', 'ýÝ”õ‘ßDqaÓn—…£', 'www.github.com', 'my repositories', '2019-07-25'),
(71, 17, 'Gmail', 'alinc1998', 'îˆ\rOµ‰ÙÍGÇ2$%“¹M,üõtÖèY‡öàî”÷¸åNÅ“ë\n³|(', 'www.gmail.com', 'my gmail account', '0000-00-00'),
(72, 17, 'Facebook 2.0', 'andrei.petrescu', '$qÏ4H\rQ?Ù6ºüï³=', 'www.facebook.com', '', '0000-00-00'),
(73, 17, 'Discord', 'shredd', 'êm–•š3S:EQ+ºÕë…˜– ¿¨lLœæH8ÐJÍ', 'www.discord.com', '', '0000-00-00'),
(74, 17, 'Skype', 'test', 'ƒa\Z›«\0‘à\' µ„Ôhµ¸L»…0ƒ¬£¦eÌýR”Ó_ ´QdL3FÐp#ŒRt', 'www.skype.com', 'cine mai foloseste skype?', '0000-00-00'),
(75, 18, 'TestSite', 'TestUsername', 'eÆ\ZÖù²>	Ž®±V]Yëknécã”ºñéˆ›!', 'www.example.com', 'Test description', '0000-00-00'),
(76, 18, 'Passer', 'AlinC', 'DhþeÃÀ»A8ºï', 'www.passer.ro', '', '2019-05-31'),
(77, 20, 'HelloWorld', 'Test', 'J–5YGU3NgOÚ•LZ6QƒgO$¬öº¶-¨­[Ùí', 'www.example.com', '', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `passwords`
--

CREATE TABLE `passwords` (
  `user_id` int(11) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `passwords`
--

INSERT INTO `passwords` (`user_id`, `password`) VALUES
(17, 'UjUrNnJsSllLcWdPM3pCdXFnZ0REQT09OjrKQzleAhjqSkuxOfxUnFF9'),
(18, 'K09mZk10VVhvRjNud0NSYmE0VTlMQT09OjrEPx8qEFKNDaix1UX/udVG'),
(19, 'RmNLc25sbnNvME1MMTFmVElkUXlxUT09OjoPdX+gfiUDj16v1R1OLnvd'),
(20, 'RnFvbHVRQkVFWkZyeldnUGxMRGxxQT09OjoZti85IMOVvKugPWehZJDU');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`) VALUES
(17, 'admin', 'administrator@passer.ro'),
(18, 'AlinC', 'alinciocoveanu@gmail.com'),
(19, 'testuser', 'testmail@yahoo.com'),
(20, 'AndreiP', 'skillparkninja@yahoo.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `passwords`
--
ALTER TABLE `passwords`
  ADD KEY `fk_pass_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `passwords`
--
ALTER TABLE `passwords`
  ADD CONSTRAINT `fk_pass_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
