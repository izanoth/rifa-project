create table Clients (
	id serial PRIMARY KEY,
	datetime timestamp,
	name varchar(256) not null,
	email varchar(256),
	tel varchar(13) not null,
	units int not null,
	stripe varchar(320) default null
);

create table Tickets (
	token int not null,
	clientid int not null,
	done BOOLEAN default false
)
