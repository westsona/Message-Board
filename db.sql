
 use gbook;

create table admin(
    username varchar(20) not null,
    userpass varchar(20) not null
);

create table message(
    id int(4) not null auto_increment primary key,
    author varchar(20) not null,
    addtime datetime not null,
    content varchar(1000) not null,
    reply varchar(1000) not null
);