create table Clients (
	id serial PRIMARY KEY,
	datetime timestamp,
	name varchar(256) not null,
	email varchar(256) not null,
	tel varchar(13) not null,
	units int not null,
	payment_id varchar(320) not null,
	amount int not null,
	stripe boolean default null
);
create table Tickets (
	token int not null,
	clientid int not null,
	FOREIGN KEY (clientid) REFERENCES Clients(id)
);

