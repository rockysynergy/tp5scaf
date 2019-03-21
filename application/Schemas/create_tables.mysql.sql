use yacommerce;
create table if not exists shop (
    id int auto_increment primary key,
    name varchar(255) not null
) ENGINE=InnoDB;

create table if not exists product (
    id int auto_increment primary key,
    name varchar(255) not null,
    price decimal(10,2) not null,
    specifications text null,
    description text null
) ENGINE=InnoDB;
alter table product add column shop_id int not null default 0;
alter table product add constraint fk_shop_id (shop_id) references shop(id);

create table if not exists media (
    id int auto_increment primary key,
    uri varchar(255) not null,
    type enum('pic', 'video', 'audio'),
    title varchar(255) null,
    name varchar(50) null,
    description varchar(350) null
) ENGINE=InnoDB;

create table if not exists product_media (
    product_id int,
    media_id int,
    sort_order tinyint not null,
    primary key (product_id, media_id),
    foreign key fk_prod(product_id) references product(id),
    foreign key fk_media(media_id) references media(id)
) ENGINE=InnoDB;


create table if not exists acount (
    id int auto_increment primary key,
    identifier varchar(50) not null unique,
    password varchar(255) not null unique,
    create_time int not null,
    last_login int not null default 0
 ) engine=InnoDB;
 
-- insert default timestamp upon insersion
create trigger befor_insert_account
    before insert on account
    for each row
    set new.create_time = unix_timestamp();
    
create table be_user (
    id int auto_increment primary key,
    name varchar(20) not null default ' ' comment "User's realname",
    roles varchar(20) null comment 'Comma seperated role ids',
    profile_pic int null
) engine=InnoDB;

alter table be_user add constraint fk_media_id foreign key (profile_pic) references media(id);

create table beuser_account (
    account_id int not null,
    user_id int not null,
    constraint pr_all primary key (account_id, user_id)
);

create table shop_user (
    user_id int not null,
    shop_id int not null,
    constraint pr_all primary key (user_id, shop_id)
);
    

 
 