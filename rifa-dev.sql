create table Clients (
	id serial PRIMARY KEY,
	datetime timestamp,
	name varchar(256) not null,
	email varchar(256) not null,
	tel varchar(13) not null,
	cpf int not null,
	units int not null,
	stripe_id varchar(320) default null,
	asaas_id varchar(320) not null,
	amount int not null,
	paid varchar(11) default null
);
create table Tickets (
	token int not null,
	clientid int not null,
	FOREIGN KEY (clientid) REFERENCES Clients(id)
);

