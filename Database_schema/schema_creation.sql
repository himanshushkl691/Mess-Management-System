drop table if exists extras;
drop table if exists admin;
drop table if exists users;
drop table if exists suggestions;

create table users(
	roll_no char(9) primary key,
	password varchar(20),
	mess_name varchar(5),
	hostel varchar(5),
	room_no char(3),
	contact_no char(9)
);

create table admin(
	mess_name varchar(5) primary key,
	password varchar(20),
	name varchar(25),
	contact_no char(9)
);

create table extras(
	roll_no char(9),
	day date,
	extra varchar(15),
	quantity integer,
	price real,
	total_price real
);

create table suggestions(
	roll_no char(9),
	suggestion varchar(1000),
	mess_name varchar(5)
);

alter table extras add foreign key(roll_no) references users(roll_no);