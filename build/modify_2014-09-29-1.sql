truncate table status;
alter table status modify column id int not null auto_increment;
alter table status add unique (id);

insert into status (status) values ("unassigned");
insert into status (status) values ("assigned");
insert into status (status) values ("new");
insert into status (status) values ("open");
insert into status (status) values ("closed");
insert into status (status) values ("reopened");
insert into status (status) values ("in progress");
insert into status (status) values ("on hold (internal)");
insert into status (status) values ("on hold (external)");
insert into status (status) values ("general request");

alter table issues set status=1 where status=0;
