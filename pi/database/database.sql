create database contasdb;
    use contasdb;

create table contastb (id_contas int  auto_increment not null primary key,
    login varchar(100), 
    password varchar(100), 
    username varchar(100));

select * from contastb;


