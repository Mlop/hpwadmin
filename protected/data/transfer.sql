/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50169
 Source Host           : 127.0.0.1
 Source Database       : transfer

 Target Server Type    : MySQL
 Target Server Version : 50169
 File Encoding         : utf-8

 Date: 01/29/2015 21:50:18 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `customer`
-- ----------------------------
DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer` (
  `customer_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT '借款人或贷款人姓名',
  `type` bit(1) DEFAULT NULL COMMENT '0=借款人，1=贷款人',
  PRIMARY KEY (`customer_id`),
  KEY `customer_id` (`customer_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='借款人、贷款人姓名表';

-- ----------------------------
--  Table structure for `incount`
-- ----------------------------
DROP TABLE IF EXISTS `incount`;
CREATE TABLE `incount` (
  `incount_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) unsigned NOT NULL COMMENT '贷款人ID',
  `money` double NOT NULL DEFAULT '0' COMMENT '金额',
  `phone` varchar(50) DEFAULT '' COMMENT '联系电话',
  `note` text COMMENT '备注',
  `add_time` datetime DEFAULT NULL COMMENT '入账时间',
  `user_id` int(10) unsigned DEFAULT NULL COMMENT '所属用户ID',
  PRIMARY KEY (`incount_id`),
  KEY `customer_id` (`customer_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `fk_incount_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_incount_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='收到款数';

-- ----------------------------
--  Table structure for `outcount`
-- ----------------------------
DROP TABLE IF EXISTS `outcount`;
CREATE TABLE `outcount` (
  `outcount_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) unsigned NOT NULL COMMENT '借款人ID',
  `money` double NOT NULL DEFAULT '0' COMMENT '借出款数目',
  `phone` varchar(50) DEFAULT '' COMMENT '联系电话',
  `note` text COMMENT '备注',
  `add_time` datetime DEFAULT NULL COMMENT '借出时间',
  `user_id` int(10) unsigned DEFAULT NULL COMMENT '所属用户ID',
  PRIMARY KEY (`outcount_id`),
  KEY `customer_id` (`customer_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `fk_outcount_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_outcount_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='借出款数';

-- ----------------------------
--  Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL COMMENT '注册用户姓名',
  `password` varchar(50) DEFAULT NULL COMMENT '密码',
  `add_time` datetime DEFAULT NULL COMMENT '注册时间',
  `last_login_time` datetime DEFAULT NULL COMMENT '最后一次登录系统时间',
  PRIMARY KEY (`user_id`),
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS = 1;
