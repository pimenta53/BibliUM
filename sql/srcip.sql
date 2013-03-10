/** TABELAS **/

CREATE TABLE area
(cod_area number(10) PRIMARY KEY,
area_name varchar(30) not null unique /* se criar tem de existir e tem de ser unica, não deverá ser chave primaria?*/,
deleted date
);

CREATE TABLE specific (
cod_specific number(10) PRIMARY KEY,
name_specific varchar(30) not null, /* não tem de ser unica pode haver especificaçoes comuns a areas diferentes, mas não pode ser nula*/
cod_area number(10),
foreign key (cod_area) references area(cod_area),
deleted date
);

CREATE TABLE doctype
(cod_type number(10) PRIMARY KEY,
name_doc varchar(30) not null unique,
deleted date
);

CREATE TABLE country
(cod_country number(10) PRIMARY KEY,
country_name varchar(20) not null unique
deleted date
);

CREATE TABLE author
(cod_author number(10) PRIMARY KEY ,
author_name varchar(50) not null unique,
birth_date date,
cod_country number(10) references country,
deleted date
);

CREATE TABLE univ
(cod_univ number(5) PRIMARY KEY,
univ_name varchar(50) not null unique,  /* será unique????? */
cod_country number(10) references country,
deleted date
);

CREATE TABLE usersB

(username varchar(10) PRIMARY KEY,
first_name varchar(25) not null,
last_name varchar(25) not null,
birth_date date not null,
phone_number varchar(20),
sex varchar(1) not null,
email varchar(30) not null unique,
user_password varchar(50) not null,
cod_country number(10) references country
);

CREATE TABLE docs
(cod_doc number(10) PRIMARY KEY,
doc_name varchar(25) not null,
description varchar(500),
upload_date date not null,
cod_area number(10) references area not null,
cod_specific number(10) references specific,
cod_univ number(5) references univ,
cod_author number(10) references author,
cod_type number(10) references docType not null,
username varchar(10) references usersB,
rating number(5,2),
nDownloads number(6) not null,
deleted date
totalVotes number(10) not null
);

CREATE TABLE logg
(cod_log number(20) PRIMARY KEY,
username varchar(10) references usersB not null,
log_date date not null,
tipo varchar(1) not null,   /* l-> login e d->download u->upload */
cod_doc number(10) references docs
);

create table ratingDoc (
cod_rating number(10) primary key,
rating number(10) not null,
cod_doc number(10) not null, 
username varchar(10) not null,
foreign key (cod_doc) references docs,
foreign key (username) references usersB);


CREATE TABLE comments
(cod_coment number(20) PRIMARY KEY,
username varchar(10) references usersB not null,
comment_user varchar(500) not null,
cod_doc number(10) references docs not null,
post_date date not null,
deleted date
);

/** VIEWS **/

select author_name,birth_date,country_name from author, country where country.cod_country= author.cod_country and author.deleted is null;

select  docs.cod_doc,docs.doc_name,docs.description,docs.rating,docs.ndownloads ,docs.upload_date,docs.deleted,username,usersb.first_name, usersb.last_name, doctype.name_doc,author_name,area_name,specific.name_specific
, univ.univ_name
from docs
join area using(cod_area)
join doctype using(cod_type)
join usersB using(username)
LEFT OUTER join specific using(cod_specific)
LEFT OUTER join author using(cod_author)
LEFT OUTER join univ using(cod_univ);

select username, count(*) as Downloads from logg where tipo = 'd' group by username order by Downloads desc

select d.doc_name, trunc(avg(ratd.rating)) as md from docs d, ratingDoc ratd where ratd.cod_doc = d.cod_doc group by d.doc_name order by md desc

select username, count(*) as ficheiros from docs group by username order by ficheiros desc

select doc_name, nDownloads from docs order by nDownloads desc

/** PROCEDURES **/

create or replace
procedure actualizaRateDup(doc number,usern varchar2, oldrate number, newrate number) as
begin
declare tot number;
rate number;
begin
 select totalvotes into tot from docs where cod_doc=doc;
 if (tot=1) then
   update docs set rating = newrate where cod_doc = doc;
 else
   update docs set rating = ((rating)*(totalvotes))-oldrate where cod_doc=doc;
   update docs set rating = (rating+newrate)/(totalvotes) where cod_doc=doc;
 end if;
end;
end actualizaRateDup;

/** FUNCTIONS **/

create or replace
function getMedia(cod_d in varchar, rate in number) return number as
begin
  declare media number;
  votes number;
  begin
    media := 0;
    select rating into media from docs where cod_d = cod_doc;
    select totalVotes into votes from docs where cod_d = cod_doc;
    return (media + rate) / votes;
  end;
end getmedia;

/** TRIGGERS **/

create or replace trigger activatespecific after 
update on specific referencing old as oldrow new as newrow for each row
begin
 if (:oldrow.deleted is not null and :newrow.deleted is null) then
   update area set deleted = null where cod_area = :newrow.cod_area;
 end if;
end;

create or replace trigger actNDownloads after
insert on logg referencing new as newrow for each row
begin
  if (:newrow.tipo='d') then
    update docs set ndownloads = ndownloads + 1 where cod_doc= :newrow.cod_doc;
  end if;
end actNDownloads;

create or replace trigger deletespecific after 
update on area referencing old as oldrow new as newrow for each row
begin
 if (:oldrow.deleted is null and :newrow.deleted is not null) then
   update specific set deleted = :newrow.deleted where cod_area = :newrow.cod_area;
 end if;
end;

create or replace trigger duplicatedVote before 
insert on ratingdoc referencing new as newrow for each row
declare existe number;
cod_rate number;
oldrate number;
media number;
begin
 
 select max(cod_rating) into cod_rate from ratingdoc 
 where :newrow.cod_doc=cod_doc and :newrow.username=username;
 
 if (cod_rate is not null) then
 
   select rating into oldrate from ratingdoc where cod_rating=cod_rate;
   actualizaRateDup(:newrow.cod_doc, :newrow.username, oldrate, :newrow.rating);
   
 else 

   update docs set totalVotes = totalvotes + 1 where cod_doc = :newrow.cod_doc; 
   media := getmedia(:newrow.cod_doc, :newrow.rating);
   update docs set rating = media where cod_doc = :newrow.cod_doc; 
   
 end if;
end duplicatedVote;

/** SEQUENCES **/

create sequence new_area start with 1 increment by 1 cache 10;
create sequence new_comments start with 1 increment by 1 cache 10;
create sequence new_author start with 1 increment by 1 cache 10;
create sequence new_country start with 1 increment by 1 cache 10;
create sequence new_docs start with 1 increment by 1 cache 10;
create sequence new_doctype start with 1 increment by 1 cache 10;
create sequence new_logg start with 1 increment by 1 cache 10;
create sequence new_specific start with 1 increment by 1 cache 10;
create sequence new_univ start with 1 increment by 1 cache 10;
create sequence new_rating start with 1 increment by 1 cache 10;

/** INSERTS **/

insert into doctype values (new_doctype.nextval,'Livros',null);
insert into doctype values (new_doctype.nextval,'Relatorios',null);
insert into doctype values (new_doctype.nextval,'Figuras',null);
insert into area values (new_area.nextval,'Informatica',null);
insert into area values (new_area.nextval,'Fisica',null);
insert into area values (new_area.nextval,'Quimica',null);
insert into area values (new_area.nextval ,'Biologia',null);
insert into area values (new_area.nextval ,'Geologia',null);
insert into area values (new_area.nextval ,'Matematica',null);
insert into country values(new_country.nextval,'Portugal');
insert into country values(new_country.nextval,'USA');
insert into country values(new_country.nextval,'Espanha');
insert into country values(new_country.nextval,'Inglaterra');
insert into country values(new_country.nextval,'Brasil');
insert into univ values(new_univ.nextval,'Universidade do Minho',1,null);
insert into univ values(new_univ.nextval,'Universidade da beira interior',1,null);
insert into univ values(new_univ.nextval,'Universidade do Porto',1,null);
insert into univ values(new_univ.nextval,'Universidade do UTAD',1,null);
insert into univ values(new_univ.nextval,'Universidade de Coimbra',1,null);
insert into specific values(new_specific.nextval,'Base de dados',1,null);
insert into specific values(new_specific.nextval,'Programação Imperativa',1,null);
insert into specific values(new_specific.nextval,'Criptografia',1,null);

/*
drop table comments;
drop table ratingdoc;
DROP TABLE logg;
DROP TABLE docs;
DROP TABLE usersB;
DROP TABLE doctype;
DROP TABLE area;
DROP TABLE specific;
DROP TABLE univ;
DROP TABLE author;
Drop TABLE country;*/
