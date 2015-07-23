-- phpMyAdmin SQL Dump
-- version 2.11.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 23, 2015 at 05:08 AM
-- Server version: 5.1.57
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `a5995757_mhelper`
--

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `author_id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL DEFAULT 'demo name',
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(255) NOT NULL DEFAULT 'demo@demo.com',
  `story_id` int(255) unsigned NOT NULL,
  `website` text,
  PRIMARY KEY (`author_id`),
  KEY `FK_AUTHORS_STORIES_STORY_ID` (`story_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='This table contains the information of the authors of the st' AUTO_INCREMENT=4 ;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` VALUES(1, 'Software', 'Project', 'sp@oulu.fi', 35, 'www.oulu.fi');
INSERT INTO `authors` VALUES(2, 'Software', 'Project', '', 36, '');
INSERT INTO `authors` VALUES(3, 'Ivan', 'Sanchez', '', 37, '');

-- --------------------------------------------------------

--
-- Table structure for table `chapters`
--

CREATE TABLE `chapters` (
  `chapter_id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `number` int(255) unsigned NOT NULL DEFAULT '1',
  `title` varchar(50) NOT NULL DEFAULT 'demo title',
  `text` text NOT NULL,
  `image_url` text,
  `video_url` text,
  `audio_url` text,
  `interaction_id` int(255) unsigned DEFAULT NULL,
  `story_id` int(255) unsigned NOT NULL,
  PRIMARY KEY (`chapter_id`),
  KEY `FK_INTERACTION_CHAPTER_INTERACTION_ID` (`interaction_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='This table contains the informatio of the chapters of the st' AUTO_INCREMENT=11 ;

--
-- Dumping data for table `chapters`
--

INSERT INTO `chapters` VALUES(1, 1, 'First chapter', 'This is the demo chapter without interactions and media.', 'http://memoryhelper.netne.net/interactivestory/media/35/1/image/test_image.jpg', 'http://memoryhelper.netne.net/interactivestory/media/35/1/video/test_video.mp4', 'http://memoryhelper.netne.net/interactivestory/media/35/1/audio/Test audio for a chapter.wma', 0, 35);
INSERT INTO `chapters` VALUES(2, 2, 'Second chapter', 'This is the GPS chapter demo.', '', '', '', 1, 35);
INSERT INTO `chapters` VALUES(3, 3, 'Third chapter', 'This is the NFC interaction demo chapter.', '', '', '', 2, 35);
INSERT INTO `chapters` VALUES(4, 4, 'Fourth chapter', 'This is the QR code interaction chapter.', '', '', '', 3, 35);
INSERT INTO `chapters` VALUES(5, 5, 'Fifth chapter', 'Quiz interaction demo.', '', '', '', 4, 35);
INSERT INTO `chapters` VALUES(6, 6, 'Sixth chapter', 'Spell check interaction demo', '', '', '', 5, 35);
INSERT INTO `chapters` VALUES(7, 7, 'Final chapter', 'This is the final chapter.', '', '', '', 0, 35);
INSERT INTO `chapters` VALUES(8, 1, 'Media chapter', 'This chapter includes media to test and a quiz interaction to show sound feedback.', 'http://memoryhelper.netne.net/interactivestory/media/36/1/image/test_image.jpg', 'http://memoryhelper.netne.net/interactivestory/media/36/1/video/test_video.mp4', 'http://memoryhelper.netne.net/interactivestory/media/36/1/audio/Test audio for a chapter.mp3', 6, 36);
INSERT INTO `chapters` VALUES(9, 2, 'Nfc chapter', 'Nfc demo with audio feedback', '', '', '', 7, 36);
INSERT INTO `chapters` VALUES(10, 1, 'chapter 1', 'text here', 'http://memoryhelper.netne.net/interactivestory/media/37/1/image/test_image.jpg', '', '', 8, 37);

-- --------------------------------------------------------

--
-- Table structure for table `gps`
--

CREATE TABLE `gps` (
  `gps_id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `latitude` float(20,10) NOT NULL DEFAULT '0.0000000000',
  `longitude` float(20,10) NOT NULL DEFAULT '0.0000000000',
  PRIMARY KEY (`gps_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='This table contains the information of the gps interaction' AUTO_INCREMENT=2 ;

--
-- Dumping data for table `gps`
--

INSERT INTO `gps` VALUES(1, 25.4742317200, 0.0000000000);

-- --------------------------------------------------------

--
-- Table structure for table `interactions`
--

CREATE TABLE `interactions` (
  `interaction_id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `interaction_type` int(255) unsigned NOT NULL DEFAULT '0',
  `nfc_id` int(255) unsigned DEFAULT NULL,
  `qr_id` int(255) unsigned DEFAULT NULL,
  `gps_id` int(255) unsigned DEFAULT NULL,
  `spell_id` int(255) unsigned DEFAULT NULL,
  `quiz_id` int(255) unsigned DEFAULT NULL,
  `positive_feedback` text,
  `negative_feedback` text,
  `positive_audio_url` text,
  `negative_audio_url` text,
  `instructions` text,
  PRIMARY KEY (`interaction_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='This table contains the information of the interactions of t' AUTO_INCREMENT=9 ;

--
-- Dumping data for table `interactions`
--

INSERT INTO `interactions` VALUES(1, 1, 0, 0, 1, 0, 0, 'Great, that is the place.', 'Wrong place, try again.', NULL, NULL, 'Find the correct place');
INSERT INTO `interactions` VALUES(2, 2, 1, 0, 1, 0, 0, 'Correct tag', 'Wrong tag', 'http://memoryhelper.netne.net/interactivestory/media/35/3/positive/Positive NFC.wma', 'http://memoryhelper.netne.net/interactivestory/media/35/3/negative/Negative NFC.wma', 'Find the right tag');
INSERT INTO `interactions` VALUES(3, 3, 1, 1, 1, 0, 0, 'Right qr', 'Wrong qr', NULL, NULL, 'Find the correct QR code.');
INSERT INTO `interactions` VALUES(4, 4, 1, 1, 1, 0, 1, 'Correct city', 'Wrong city', 'http://memoryhelper.netne.net/interactivestory/media/35/5/positive/General positive.wma', 'http://memoryhelper.netne.net/interactivestory/media/35/5/negative/General Negative.wma', 'Answer the question');
INSERT INTO `interactions` VALUES(5, 5, 1, 1, 1, 1, 1, 'Spelled correctly', 'Wrongly spelled', NULL, NULL, 'Type the word again');
INSERT INTO `interactions` VALUES(6, 4, 0, 0, 0, 0, 2, 'Great, Finnish is the language.', 'That is not the correct language', 'http://memoryhelper.netne.net/interactivestory/media/36/1/positive/General positive.mp3', 'http://memoryhelper.netne.net/interactivestory/media/36/1/negative/General Negative.mp3', 'Answer the question');
INSERT INTO `interactions` VALUES(7, 2, 2, 0, 0, 0, 2, 'Correct tag', 'Wrong tag', 'http://memoryhelper.netne.net/interactivestory/media/36/2/positive/Positive NFC.mp3', 'http://memoryhelper.netne.net/interactivestory/media/36/2/negative/Negative NFC.mp3', 'Find the correct tag');
INSERT INTO `interactions` VALUES(8, 5, 0, 0, 0, 2, 0, 'yes', 'no', NULL, NULL, 'test');

-- --------------------------------------------------------

--
-- Table structure for table `nfc`
--

CREATE TABLE `nfc` (
  `nfc_id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `info` text NOT NULL,
  PRIMARY KEY (`nfc_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='This table contains the information for nfs tag interaction' AUTO_INCREMENT=3 ;

--
-- Dumping data for table `nfc`
--

INSERT INTO `nfc` VALUES(1, 'This is the correct tag.');
INSERT INTO `nfc` VALUES(2, 'This is the correct tag.');

-- --------------------------------------------------------

--
-- Table structure for table `qr`
--

CREATE TABLE `qr` (
  `qr_id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `info` text NOT NULL,
  PRIMARY KEY (`qr_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='This table contains the information of the quiz interaction' AUTO_INCREMENT=2 ;

--
-- Dumping data for table `qr`
--

INSERT INTO `qr` VALUES(1, 'Correct qr');

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `quiz_id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `question` text NOT NULL,
  `correct_answer` text NOT NULL,
  `answer_1` text NOT NULL,
  `answer_2` text NOT NULL,
  `answer_3` text NOT NULL,
  PRIMARY KEY (`quiz_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='This table contains the quiz interaction' AUTO_INCREMENT=3 ;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` VALUES(1, 'In which city are we?', 'Oulu', 'Heksinki', 'Tampere', 'Espoo');
INSERT INTO `quiz` VALUES(2, 'What is the native language of Finland?', 'Finnish', 'English', 'Spanish', 'Dutch');

-- --------------------------------------------------------

--
-- Table structure for table `spell`
--

CREATE TABLE `spell` (
  `spell_id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `phrase` text NOT NULL,
  PRIMARY KEY (`spell_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='This table contains the spell interaction' AUTO_INCREMENT=3 ;

--
-- Dumping data for table `spell`
--

INSERT INTO `spell` VALUES(1, 'Fantastic');
INSERT INTO `spell` VALUES(2, 'apple');

-- --------------------------------------------------------

--
-- Table structure for table `stories`
--

CREATE TABLE `stories` (
  `story_id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `story_title` varchar(50) NOT NULL DEFAULT 'demo title',
  `story_summary` text,
  PRIMARY KEY (`story_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='This table contains the stories for the editor part of the a' AUTO_INCREMENT=38 ;

--
-- Dumping data for table `stories`
--

INSERT INTO `stories` VALUES(1, 'test title', 'test summary');
INSERT INTO `stories` VALUES(2, 'test title', 'test summary');
INSERT INTO `stories` VALUES(3, 'test title', 'test summary');
INSERT INTO `stories` VALUES(4, 'test title', 'test summary');
INSERT INTO `stories` VALUES(5, 'test title', 'test summary');
INSERT INTO `stories` VALUES(6, 'test title', 'test summary');
INSERT INTO `stories` VALUES(7, 'test title', 'test summary');
INSERT INTO `stories` VALUES(8, 'test title', 'test summary');
INSERT INTO `stories` VALUES(9, 'test title', 'test summary');
INSERT INTO `stories` VALUES(10, 'test title', 'test summary');
INSERT INTO `stories` VALUES(11, 'test title', 'test summary');
INSERT INTO `stories` VALUES(12, 'test title', 'test summary');
INSERT INTO `stories` VALUES(13, 'test title', 'test summary');
INSERT INTO `stories` VALUES(14, 'test title', 'test summary');
INSERT INTO `stories` VALUES(15, 'test title', 'test summary');
INSERT INTO `stories` VALUES(16, 'test title', 'test summary');
INSERT INTO `stories` VALUES(17, 'test title', 'test summary');
INSERT INTO `stories` VALUES(18, 'test title', 'test summary');
INSERT INTO `stories` VALUES(19, 'test title', 'test summary');
INSERT INTO `stories` VALUES(20, 'test title', 'test summary');
INSERT INTO `stories` VALUES(21, 'test title', 'test summary');
INSERT INTO `stories` VALUES(22, 'test title', 'test summary');
INSERT INTO `stories` VALUES(23, 'test title', 'test summary');
INSERT INTO `stories` VALUES(24, 'test title', 'test summary');
INSERT INTO `stories` VALUES(25, 'test title', 'test summary');
INSERT INTO `stories` VALUES(26, 'test title', 'test summary');
INSERT INTO `stories` VALUES(27, 'test title', 'test summary');
INSERT INTO `stories` VALUES(28, 'test title', 'test summary');
INSERT INTO `stories` VALUES(29, 'test title', 'test summary');
INSERT INTO `stories` VALUES(30, 'test title', 'test summary');
INSERT INTO `stories` VALUES(31, 'test title', 'test summary');
INSERT INTO `stories` VALUES(32, 'test title', 'test summary');
INSERT INTO `stories` VALUES(33, 'test title', 'test summary');
INSERT INTO `stories` VALUES(34, 'test title', 'test summary');
INSERT INTO `stories` VALUES(35, 'Test Story', 'This is a demo story');
INSERT INTO `stories` VALUES(36, 'Second Test Story', 'Test story');
INSERT INTO `stories` VALUES(37, 'Test', 'test');