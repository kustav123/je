
CREATE TABLE `je`.`scentity` (
  `id` varchar(20) PRIMARY KEY,
  `merchant_name` varchar(30),
  `mobile` varchar(15),
  `email` varchar(50),
  `address` varchar(40),
  `created at` timestamp,
  `status` int,
  `due_ammount` float,
  `gst` varchar(255),
  `created_by` varchar(10)
);

CREATE TABLE `je`.`sdentity` (
  `id` varchar(20) PRIMARY KEY,
  `merchant_name` varchar(30),
  `mobile` varchar(15),
  `email` varchar(50),
  `address` varchar(40),
  `created at` timestamp,
  `status` int,
  `due_ammount` float,
  `gst` varchar(17),
  `created_by` varchar(10)
);

CREATE TABLE `je`.`raw_product` (
  `id` varchar(20) PRIMARY KEY,
  `name` varchar(50),
  `created at` timestamp,
  `unit` varchar(255),
  `current_stock` float,
  `status` int
);

CREATE TABLE `je`.`finish_product` (
  `id` varchar(20) PRIMARY KEY,
  `name` varchar(50),
  `created at` timestamp,
  `unit` varchar(255),
  `HSN` varchar(8),
  `cgst` varchar(255),
  `sgst` varchar(255),
  `current_stock` float,
  `status` int
);

CREATE TABLE `je`.`product_entry_main` (
  `id` varchar(20) PRIMARY KEY,
  `chalan_no` varchar(255),
  `from` varchar(20),
  `recived_date` date,
  `delivary_mode` varchar(10),
  `created at` timestamp,
  `total_amount` float,
  `remarks` varchar(100),
  `created_by` varchar(10)
);

CREATE TABLE `je`.`product_entry_history` (
  `id` int,
  `entry_id` varchar(20),
  `created at` timestamp,
  `product` varchar(20),
  `qty` float,
  `amount` float,
  `remarks` varchar(100),
  PRIMARY KEY (`id`, `entry_id`)
);

CREATE TABLE `je`.`product_st_out_int` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `chalan_no` varchar(50),
  `to` varchar(20),
  `handover_time` timestamp,
  `handover_by` varchar(10),
  `product` varchar(20),
  `remarks` varchar(100)
);

CREATE TABLE `je`.`product_st_out_ext` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `chalan_no` varchar(50),
  `to` varchar(20),
  `handover_time` timestamp,
  `handover_by` varchar(10),
  `product` varchar(20),
  `remarks` varchar(100)
);

CREATE TABLE `je`.`product_st_in_int` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `chalan_no` varchar(50),
  `from` varchar(20),
  `handover_time` timestamp,
  `handover_by` varchar(10),
  `product` varchar(20),
  `remarks` varchar(100)
);

CREATE TABLE `je`.`product_st_in_ext` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `chalan_no` varchar(50),
  `from` varchar(20),
  `handover_time` timestamp DEFAULT (now()),
  `handover_by` varchar(10),
  `product` varchar(20),
  `remarks` varchar(100)
);

CREATE TABLE `je`.`product_delivary_main` (
  `id` varchar(20) PRIMARY KEY,
  `chalan_no` varchar(50),
  `to` varchar(20),
  `delivary_date` date,
  `delivary_mode` varchar(10),
  `created_at` timestamp DEFAULT (now()),
  `total_amount` float,
  `remarks` varchar(100),
  `created_by` varchar(10)
);

CREATE TABLE `je`.`product_delivery_history` (
  `id` int,
  `entry_id` varchar(20),
  `created_at` timestamp DEFAULT (now()),
  `product` varchar(20),
  `qty` float,
  `amount` float,
  `remarks` varchar(100),
  PRIMARY KEY (`id`, `entry_id`)
);

CREATE TABLE `je`.`sc_payment_entry` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `scid` varchar(20),
  `created_at` timestamp DEFAULT (now()),
  `amount` float,
  `mode` varchar(10),
  `hisamount` float,
  `curamount` float,
  `remarks` varchar(100),
  `created_by` varchar(10)
);

CREATE TABLE `je`.`sd_payment_entry` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `sdid` varchar(20),
  `created_at` timestamp DEFAULT (now()),
  `amount` float,
  `mode` varchar(10),
  `hisamount` float,
  `curamount` float,
  `remarks` varchar(100),
  `created_by` varchar(10)
);

CREATE TABLE `je`.`invoice_gst_main` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `invoice_no` varchar(30),
  `to` varchar(20),
  `gst` varchar(20),
  `inovice_date` date,
  `gross_amount` float,
  `cgst_amount` float,
  `ssgst_amount` float,
  `total_amount` float,
  `remarks` varchar(100),
  `created_at` timestamp DEFAULT (now()),
  `created_by` varchar(10),
  `paid` bool
);

CREATE TABLE `je`.`invoice_gst_history` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `entry_id` int,
  `created at` timestamp,
  `product` varchar(20),
  `qty` float,
  `HSN` varchar(8),
  `cgst` varchar(10),
  `sgst` varchar(10),
  `gross_amount` float,
  `total_ammount` float,
  `remarks` varchar(100)
);

CREATE TABLE `je`.`leadger_sc` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `scid` varchar(20),
  `date` date,
  `type` varchar(20),
  `current_amomount` float,
  `truns_ammount` float,
  `mode` varchar(10),
  `remarks` varchar(50),
  `refno` varchar(50),
  `created at` timestamp
);

CREATE TABLE `je`.`leadger_sd` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `sdid` varchar(20),
  `date` date,
  `type` varchar(20),
  `current_amomount` float,
  `truns_ammount` float,
  `mode` varchar(10),
  `remarks` varchar(50),
  `refno` varchar(50),
  `created at` timestamp
);

CREATE TABLE `je`.`asso_int` (
  `id` varchar(20) PRIMARY KEY,
  `name` varchar(50),
  `mobile` varchar(15),
  `email` varchar(50),
  `status` varchar(1),
  `stock` varchar(20)
);

CREATE TABLE `je`.`asso_ext` (
  `id` varchar(20) PRIMARY KEY,
  `name` varchar(50),
  `mobile` varchar(15),
  `email` varchar(50),
  `status` varchar(1),
  `stock` varchar(20)
);

CREATE TABLE `je`.`secuence` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `type` varchar(20),
  `head` varchar(20),
  `sno` varchar(20),
  `remarks` varchar(40),
  `status` bool,
  `created at` timestamp
);

CREATE TABLE `je`.`appinfo` (
  `id` int,
  `name` varchar(50),
  `logo` varchar(100),
  `address` varchar(100),
  `gstno` varchar(17)
);

CREATE TABLE `je`.`appuser` (
  `id` varchar(20) PRIMARY KEY,
  `name` varchar(50),
  `mobile` varchar(15),
  `email` varchar(50),
  `password` varchar(255),
  `role` varchar(2),
  `sign` varchar(100),
  `status` varchar(1),
  `is_logedin` varchar(1),
  `lastlogin_time` timestamp,
  `lastlogin_from` varchar(30)
);


ALTER TABLE `je`.`scentity` ADD FOREIGN KEY (`created_by`) REFERENCES `je`.`appuser` (`id`);

ALTER TABLE `je`.`sdentity` ADD FOREIGN KEY (`created_by`) REFERENCES `je`.`appuser` (`id`);

ALTER TABLE `je`.`product_entry_main` ADD FOREIGN KEY (`created_by`) REFERENCES `je`.`appuser` (`id`);

ALTER TABLE `je`.`product_delivary_main` ADD FOREIGN KEY (`created_by`) REFERENCES `je`.`appuser` (`id`);

ALTER TABLE `je`.`sc_payment_entry` ADD FOREIGN KEY (`created_by`) REFERENCES `je`.`appuser` (`id`);

ALTER TABLE `je`.`sd_payment_entry` ADD FOREIGN KEY (`created_by`) REFERENCES `je`.`appuser` (`id`);

ALTER TABLE `je`.`invoice_gst_main` ADD FOREIGN KEY (`created_by`) REFERENCES `je`.`appuser` (`id`);

ALTER TABLE `je`.`product_st_out_int` ADD FOREIGN KEY (`handover_by`) REFERENCES `je`.`appuser` (`id`);

ALTER TABLE `je`.`product_st_out_ext` ADD FOREIGN KEY (`handover_by`) REFERENCES `je`.`appuser` (`id`);

ALTER TABLE `je`.`product_st_in_int` ADD FOREIGN KEY (`handover_by`) REFERENCES `je`.`appuser` (`id`);

ALTER TABLE `je`.`product_st_in_ext` ADD FOREIGN KEY (`handover_by`) REFERENCES `je`.`appuser` (`id`);

ALTER TABLE `je`.`product_entry_history` ADD FOREIGN KEY (`entry_id`) REFERENCES `je`.`product_entry_main` (`id`);

ALTER TABLE `je`.`product_delivery_history` ADD FOREIGN KEY (`entry_id`) REFERENCES `je`.`product_delivary_main` (`id`);

ALTER TABLE `je`.`product_delivery_history` ADD FOREIGN KEY (`product`) REFERENCES `je`.`finish_product` (`id`);

ALTER TABLE `je`.`invoice_gst_history` ADD FOREIGN KEY (`product`) REFERENCES `je`.`finish_product` (`id`);

ALTER TABLE `je`.`invoice_gst_history` ADD FOREIGN KEY (`entry_id`) REFERENCES `je`.`invoice_gst_main` (`id`);

ALTER TABLE `je`.`sd_payment_entry` ADD FOREIGN KEY (`sdid`) REFERENCES `je`.`sdentity` (`id`);

ALTER TABLE `je`.`sc_payment_entry` ADD FOREIGN KEY (`scid`) REFERENCES `je`.`scentity` (`id`);

ALTER TABLE `je`.`leadger_sc` ADD FOREIGN KEY (`scid`) REFERENCES `je`.`scentity` (`id`);

ALTER TABLE `je`.`product_delivary_main` ADD FOREIGN KEY (`to`) REFERENCES `je`.`sdentity` (`id`);

ALTER TABLE `je`.`product_entry_history` ADD FOREIGN KEY (`product`) REFERENCES `je`.`raw_product` (`id`);

ALTER TABLE `je`.`product_entry_main` ADD FOREIGN KEY (`from`) REFERENCES `je`.`scentity` (`id`);

ALTER TABLE `je`.`leadger_sd` ADD FOREIGN KEY (`sdid`) REFERENCES `je`.`sdentity` (`id`);

ALTER TABLE `je`.`product_st_out_ext` ADD FOREIGN KEY (`to`) REFERENCES `je`.`asso_ext` (`id`);

ALTER TABLE `je`.`product_st_in_int` ADD FOREIGN KEY (`from`) REFERENCES `je`.`asso_ext` (`id`);

ALTER TABLE `je`.`product_st_in_ext` ADD FOREIGN KEY (`from`) REFERENCES `je`.`asso_int` (`id`);

ALTER TABLE `je`.`product_st_out_int` ADD FOREIGN KEY (`to`) REFERENCES `je`.`asso_int` (`id`);

ALTER TABLE `je`.`invoice_gst_main` ADD FOREIGN KEY (`to`) REFERENCES `je`.`sdentity` (`id`);

ALTER TABLE `je`.`product_st_in_int` ADD FOREIGN KEY (`product`) REFERENCES `je`.`finish_product` (`id`);

ALTER TABLE `je`.`product_st_out_ext` ADD FOREIGN KEY (`product`) REFERENCES `je`.`raw_product` (`id`);

ALTER TABLE `je`.`product_st_out_int` ADD FOREIGN KEY (`product`) REFERENCES `je`.`raw_product` (`id`);

ALTER TABLE `je`.`product_st_in_ext` ADD FOREIGN KEY (`product`) REFERENCES `je`.`finish_product` (`id`);
