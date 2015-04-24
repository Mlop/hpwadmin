/*
Navicat MySQL Data Transfer

Source Server         : localhost_vagrant
Source Server Version : 50169
Source Host           : 127.0.0.1:3306
Source Database       : hpw

Target Server Type    : MYSQL
Target Server Version : 50169
File Encoding         : 65001

Date: 2015-04-24 17:38:21
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `auth_user`
-- ----------------------------
DROP TABLE IF EXISTS `auth_user`;
CREATE TABLE `auth_user` (
  `auth_user_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员ID',
  `auth_user_name` varchar(100) NOT NULL COMMENT '管理员名称',
  PRIMARY KEY (`auth_user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='向外提供API的用户（授权使用API的用户）';

-- ----------------------------
-- Records of auth_user
-- ----------------------------
INSERT INTO `auth_user` VALUES ('1', 'qfkong');

-- ----------------------------
-- Table structure for `customer`
-- ----------------------------
DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer` (
  `customer_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT '借款人或贷款人姓名',
  `phone` varchar(50) NOT NULL,
  `type` enum('borrower','lender') DEFAULT 'borrower' COMMENT 'borrower=借款人，lender=贷款人',
  `avatar` varchar(255) DEFAULT NULL COMMENT '用户头像',
  PRIMARY KEY (`customer_id`),
  KEY `customer_id` (`customer_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='借款人、贷款人姓名表';

-- ----------------------------
-- Records of customer
-- ----------------------------
INSERT INTO `customer` VALUES ('1', '张三', '', 'borrower', null);
INSERT INTO `customer` VALUES ('2', '李四', '', 'lender', null);

-- ----------------------------
-- Table structure for `incount`
-- ----------------------------
DROP TABLE IF EXISTS `incount`;
CREATE TABLE `incount` (
  `incount_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) unsigned NOT NULL COMMENT '贷款人ID',
  `money` double NOT NULL DEFAULT '0' COMMENT '金额',
  `phone` varchar(50) DEFAULT '' COMMENT '联系电话',
  `note` text COMMENT '备注',
  `add_time` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '入账时间',
  `confer_repayment_date` date DEFAULT '0000-00-00' COMMENT '约定的还款时间',
  `is_repayment` enum('no','yes') DEFAULT 'no' COMMENT '是否已偿还',
  `real_repayment_date` date DEFAULT '0000-00-00' COMMENT '实际的还款时间',
  `user_id` int(10) unsigned NOT NULL COMMENT '所属用户ID',
  PRIMARY KEY (`incount_id`),
  KEY `customer_id` (`customer_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `fk_incount_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_incount_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='收到款数';

-- ----------------------------
-- Records of incount
-- ----------------------------
INSERT INTO `incount` VALUES ('1', '1', '100', '123456', 'test', '2015-02-26 07:32:49', '2015-04-20', 'no', '0000-00-00', '5');
INSERT INTO `incount` VALUES ('2', '1', '300', '123456', 'test2', '2015-02-26 07:34:18', '2015-06-24', 'yes', '0000-00-00', '5');
INSERT INTO `incount` VALUES ('3', '1', '122', '', '', null, '0000-00-00', 'no', '0000-00-00', '5');

-- ----------------------------
-- Table structure for `outcount`
-- ----------------------------
DROP TABLE IF EXISTS `outcount`;
CREATE TABLE `outcount` (
  `outcount_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) unsigned NOT NULL COMMENT '借款人ID',
  `money` double NOT NULL DEFAULT '0' COMMENT '借出款数目',
  `phone` varchar(50) DEFAULT '' COMMENT '联系电话',
  `note` text COMMENT '备注',
  `add_time` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '借出时间',
  `confer_repayment_date` date DEFAULT '0000-00-00' COMMENT '约定的还款时间',
  `is_repayment` enum('no','yes') DEFAULT 'no' COMMENT '是否已偿还',
  `real_repayment_date` date DEFAULT '0000-00-00' COMMENT '实际的还款时间',
  `user_id` int(10) unsigned NOT NULL COMMENT '所属用户ID',
  PRIMARY KEY (`outcount_id`),
  KEY `customer_id` (`customer_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `fk_outcount_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_outcount_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='借出款数';

-- ----------------------------
-- Records of outcount
-- ----------------------------
INSERT INTO `outcount` VALUES ('1', '2', '500', '789456', null, '2015-04-24 03:21:42', '0000-00-00', null, '0000-00-00', '5');
INSERT INTO `outcount` VALUES ('2', '2', '20000', '', 'ccddeeffffff', '0000-00-00 00:00:00', '2015-10-06', 'no', '0000-00-00', '5');

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL COMMENT '注册用户姓名',
  `phone` varchar(50) NOT NULL COMMENT '注册用户手机号',
  `password` varchar(50) NOT NULL COMMENT '密码',
  `add_time` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '注册时间',
  `last_login_time` timestamp NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后一次登录系统时间',
  PRIMARY KEY (`user_id`),
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='注册用户表';

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('3', 'admin', '1111', '5f1213bb1978b1b5243954e6239c7c19FL', '2015-02-10 09:34:13', '2015-02-10 09:34:13');
INSERT INTO `user` VALUES ('4', 'vera', '22333', '5b4ba16d73434b7a0f918b6cd5d43a47q3', '2015-03-04 07:01:17', '2015-03-04 07:01:17');
INSERT INTO `user` VALUES ('5', 'qfkong', '123456', '0d7ce25016c4ebb90f53ac619060477djA', '2015-04-22 08:13:02', '2015-04-24 10:20:18');
