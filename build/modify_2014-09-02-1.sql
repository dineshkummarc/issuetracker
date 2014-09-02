create table issuetracking ( id int not null primary key auto_increment, parent int not null default 0, date timestamp, item text);
create index trackedissues on issuetracking(parent);

insert into status (id, status) values ("0", "not assigned");
insert into status (id, status) values ("1", "new");
insert into status (id, status) values ("2", "assigned");
insert into status (id, status) values ("3", "open");
insert into status (id, status) values ("4", "closed");
insert into status (id, status) values ("5", "in progress");
insert into status (id, status) values ("6", "on hold (internal)");
insert into status (id, status) values ("7", "on hold (external)");
insert into status (id, status) values ("8", "cancelled");
insert into status (id, status) values ("9", "general request");
insert into status (id, status) values ("10", "reopened");

