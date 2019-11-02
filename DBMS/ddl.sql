create database NITC_MESS;
drop table if exists extras;
drop table if exists admin;
drop table if exists users;
drop table if exists suggestions;

create table student(
	roll_no char(9) primary key,
	name varchar(80) not null,
	password varchar(30) not null,
	mess_name varchar(5),
	hostel char(5) not null,
	room_no char(3) not null,
	time_stamp datetime default CURRENT_TIMESTAMP
);

create table mess_admin(
	mess_name varchar(5) primary key,
	password varchar(20) not null,
	base real default 0
);

create table extras(
	roll_no char(9),
	mess_name varchar(5),
	item_name varchar(15),
	item_price real,
	item_qty integer,
	total real,
	time_stamp datetime default CURRENT_TIMESTAMP
);

create table feedback(
	roll_no char(9),
	suggestion varchar(1000),
	mess_name varchar(5)
);

alter table extras add foreign key(roll_no) references student(roll_no);
alter table extras add foreign key(mess_name) references mess_admin(mess_name);
alter table feedback add foreign key(roll_no) references student(roll_no);
alter table feedback add foreign key(mess_name) references mess_admin(mess_name);
alter table student add foreign key(mess_name) references mess_admin(mess_name);
