DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer` (
  `customer_id` integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  `name` varchar(100) NOT NULL,
  `type` tinyint DEFAULT NULL
);

DROP TABLE IF EXISTS `incount`;
CREATE TABLE `incount` (
  `incount_id` integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  `customer_id` integer NOT NULL,
  `money` double NOT NULL DEFAULT '0',
  `phone` varchar(50) DEFAULT '' ,
  `note` text ,
  `add_time` datetime DEFAULT NULL ,
  `user_id` integer DEFAULT NULL,
  CONSTRAINT "fk_incount_customer_id" FOREIGN KEY ("customer_id") REFERENCES "customer" ("customer_id"),
  CONSTRAINT "fk_incount_user_id" FOREIGN KEY ("user_id") REFERENCES "user" ("user_id")
) ;

DROP TABLE IF EXISTS `outcount`;
CREATE TABLE `outcount` (
  `outcount_id` integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  `customer_id` integer NOT NULL ,
  `money` double NOT NULL DEFAULT '0' ,
  `phone` varchar(50) DEFAULT '' ,
  `note` text ,
  `add_time` datetime DEFAULT NULL ,
  `user_id` integer DEFAULT NULL,
  CONSTRAINT "fk_outcount_customer_id" FOREIGN KEY ("customer_id") REFERENCES "customer" ("customer_id"),
  CONSTRAINT "fk_outcount_user_id" FOREIGN KEY ("user_id") REFERENCES "user" ("user_id")
) ;

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` integer NOT NULL PRIMARY key AUTOINCREMENT,
  `name` varchar(100) DEFAULT NULL ,
  `password` varchar(50) DEFAULT NULL ,
  `add_time` datetime DEFAULT NULL ,
  `last_login_time` datetime DEFAULT NULL
) ;