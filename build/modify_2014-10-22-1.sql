CREATE TABLE `residents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `name` tinytext,
  `email` tinytext,
  `phone` tinytext,
  `address1` tinytext,
  `address2` tinytext,
  `postcode` tinytext,
  `town` tinytext,
  `ss` tinytext,
  `information` text,
  `house` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8

 CREATE TABLE `resident_types` (
  `id` tinyint(4) DEFAULT NULL,
  `type` tinytext
) ENGINE=InnoDB DEFAULT CHARSET=utf8

insert into resident_types (id, type) values ("0", "tenant");
insert into resident_types (id, type) values ("1", "paying tenant");
insert into resident_types (id, type) values ("10", "owner");
insert into resident_types (id, type) values ("11", "paying owner");
insert into resident_types (id, type) values ("20", "boardmember");
insert into resident_types (id, type) values ("22", "secretary");
insert into resident_types (id, type) values ("30", "chairperson");

