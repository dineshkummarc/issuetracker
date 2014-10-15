alter table issuetypes modify column id int not null auto_increment;

alter table users add column passhash tinytext;
alter table users add column email tinytext;
alter table users drop column password;

