drop database beesmapDB;
create database beesmapDB;
use beesmapDB;

CREATE TABLE teams (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    number_members int
);

CREATE TABLE areas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    description VARCHAR(255),
    weathered boolean,
    locate VARCHAR(255),
    team_id INT,
    FOREIGN KEY (team_id) REFERENCES teams (id)
);

CREATE TABLE boxes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    identifier VARCHAR(255),
    collect_status boolean,
    area_id INT,
    FOREIGN KEY (area_id) REFERENCES areas (id)
);

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    email VARCHAR(255),
    password VARCHAR(255),
    image VARCHAR(255),
    team_leader BOOLEAN,
    team_id INT ,
    FOREIGN KEY (team_id) REFERENCES teams (id)
);

create table produtions(
    id int primary key auto_increment,
    date date,
    amount double,
    area_id int,
    foreign key (area_id) references areas(id),
    team_id int,
    foreign key (team_id) references teams(id)
);

create table sales(
    id int primary key auto_increment,
    date date,
    amount double,
    profit double,
    buyer varchar(255),
    produtions_id int,
    foreign key (produtions_id) references produtions(id),
    team_id int,
    foreign key (team_id) references teams(id)
);

create table vehicles(
	id int primary key auto_increment,
    model varchar(255),
    availability boolean,
    team_id int,
    foreign key (team_id) references teams(id)
);

create table faqs(
    id int primary key auto_increment,
    ask varchar(255),  
    answer varchar(255)
);


SELECT name, image from users;