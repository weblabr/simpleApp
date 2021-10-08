create schema public collate utf8_general_ci;

create table public.users
(
    id         int auto_increment
        primary key,
    name       varchar(255)                       not null,
    surname    varchar(255)                       null,
    phone      varchar(255)                       not null,
    email      varchar(255)                       null,
    created_at datetime default CURRENT_TIMESTAMP not null
);

