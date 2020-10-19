CREATE DATABASE `lost_found`;
CREATE TABLE `lost_found`.`user_details` (
  `id` int(20) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `id_no`int(20) NOT NULL UNIQUE,
  `name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL UNIQUE,
  `phone` varchar(15) NOT NULL UNIQUE,
  `password` varchar(60) NOT NULL,
  `created_at` DATETIME NOT NULL
);

CREATE TABLE `lost_found`.`lost_persons` (
  `id` int(20) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `user_id` int(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `place_lost` varchar(40) NOT NULL UNIQUE,
  `residence` varchar(100) NOT NULL,
  `email` varchar(45) NOT NULL,
  `phone` varchaR(14) NOT NULL,
  `status` varchar(1) DEFAULT 0, 
  `photo` varchar(255),
  `comments` varchar(255),
  `date_lost` varchar(20),
  `created_at` DATETIME NOT NULL,
  FOREIGN KEY (user_id) REFERENCES user_details(id)
);

CREATE TABLE `lost_found`.`privileges` (
  `id` int(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `created_at` DATETIME NOT NULL,
  FOREIGN KEY (user_id) REFERENCES user_details(id)
);

CREATE TABLE `lost_found`.`found_persons` (
  `id` int(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `place_found` varchar(60) NOT NULL,
  `contact_email` varchar(30) NOT NULL,
  `contact_phone` varchaR(14) NOT NULL,
  `status` varchar(1) DEFAULT 0,
  `photo` varchar(255),
  `comments` varchar(255),
  `date_found` varchar(20),
  `created_at` DATETIME NOT NULL,
  FOREIGN KEY (user_id) REFERENCES user_details(id)
);