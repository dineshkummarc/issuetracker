alter table users add column passhash tinytext;
alter table users add column email tinytext;
alter table users drop column password;

insert into table users (id, username, name, admin, superuser, user, active, passhash) values ("1", "admin", "admin", "1", "1", "1", "1", "$2y$10$LD7BWbFXXG5dMJIlH.x1.Od6vp9QccjlwT7c5xtWyVD2Pbn2.gb2C");

