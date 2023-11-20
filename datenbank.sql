create table fahrzeug (
    id int(11) not null auto_increment primary key,
    kennzeichen varchar(255) not null,
    marke varchar(255) not null,
    modell varchar(255) not null,
    kilometerstand int(11) not null
);