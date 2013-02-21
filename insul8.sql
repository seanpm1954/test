/*
 Navicat MySQL Data Transfer

 Source Server         : local
 Source Server Version : 50528
 Source Host           : localhost
 Source Database       : insul8

 Target Server Version : 50528
 File Encoding         : utf-8

 Date: 02/21/2013 15:41:20 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `bidLog`
-- ----------------------------
DROP TABLE IF EXISTS `bidLog`;
CREATE TABLE `bidLog` (
  `bidID` int(11) NOT NULL AUTO_INCREMENT,
  `customerID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `bidDate` date NOT NULL,
  `projectName` varchar(200) NOT NULL,
  `projectType` varchar(20) DEFAULT NULL,
  `bidAmount` double DEFAULT NULL,
  `status` int(1) DEFAULT '1',
  `startDate` date DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL,
  `comments` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`bidID`),
  KEY `customerID` (`customerID`),
  KEY `userID` (`userID`),
  KEY `status` (`status`),
  CONSTRAINT `fk3` FOREIGN KEY (`status`) REFERENCES `status` (`statusID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk1` FOREIGN KEY (`customerID`) REFERENCES `customers` (`CustomerID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk2` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `bidLog`
-- ----------------------------
BEGIN;
INSERT INTO `bidLog` VALUES ('2', '2', '1', '2013-02-05', 'test 222', 'type 2', '2000', '1', '2013-02-12', 'La Porte', 'comments for test 2'), ('4', '8', '1', '2013-02-05', 'project 1 new', '1', '3500', '1', '2013-02-05', 'Seabrook', 'newly added');
COMMIT;

-- ----------------------------
--  Table structure for `customers`
-- ----------------------------
DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `CustomerID` int(11) NOT NULL AUTO_INCREMENT,
  `CustName` varchar(50) NOT NULL,
  `ContactFName1` varchar(15) DEFAULT NULL,
  `ContactLName1` varchar(15) DEFAULT NULL,
  `ContactPhone1` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`CustomerID`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `customers`
-- ----------------------------
BEGIN;
INSERT INTO `customers` VALUES ('1', 'Natco', null, null, null), ('2', 'Linde Gas', null, null, null), ('3', 'Jett Weld', null, null, null), ('4', 'Formosa', null, null, null), ('5', 'IDC', null, null, null), ('6', 'Bay. Ltd.', null, null, null), ('7', 'Ashland Hercules', null, null, null), ('8', 'DCP', null, null, null), ('9', 'FHR', null, null, null), ('10', 'LCRA', null, null, null), ('11', 'BASF', null, null, null), ('12', 'One OK', null, null, null), ('13', 'Performance Contractors', null, null, null), ('14', 'TDC', null, null, null), ('15', 'Crosstex', null, null, null), ('16', 'OG&E', null, null, null), ('17', 'DCP Midstream', null, null, null), ('18', 'Entergy', null, null, null), ('19', 'Air Liquide', null, null, null), ('20', 'Performance Contractors', null, null, null), ('21', 'Navajo Refining', null, null, null), ('22', 'CB&I', null, null, null), ('23', 'Shaw Contractors', null, null, null), ('24', 'JV Industrial', null, null, null);
COMMIT;

-- ----------------------------
--  Table structure for `status`
-- ----------------------------
DROP TABLE IF EXISTS `status`;
CREATE TABLE `status` (
  `statusID` int(11) NOT NULL AUTO_INCREMENT,
  `statusName` varchar(10) NOT NULL DEFAULT 'Pending',
  PRIMARY KEY (`statusID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `status`
-- ----------------------------
BEGIN;
INSERT INTO `status` VALUES ('1', 'Pending'), ('2', 'Active'), ('3', 'Accepted'), ('4', 'Completed'), ('5', 'Re-Bid'), ('6', 'Closed'), ('7', 'Denied');
COMMIT;

-- ----------------------------
--  Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(10) NOT NULL,
  `password` varchar(10) NOT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `users`
-- ----------------------------
BEGIN;
INSERT INTO `users` VALUES ('1', 'jnichols', 'msinsul8'), ('2', 'smartin', 'msinsul8');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
