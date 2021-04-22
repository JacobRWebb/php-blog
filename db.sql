create table user (
  ID int NOT NULL AUTO_INCREMENT,
  username varchar(100) NOT NULL,
  password varchar(100) NOT NULL,
  createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  primary key (ID)
);

create table post (
  ID int NOT NULL AUTO_INCREMENT,
  parentID int,
  ownerID int,
  title varchar(50),
  content varchar(4500),
  createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  primary key (ID),
  foreign key (ownerID) references user (ID)
    on delete cascade,
  foreign key (parentID) references post (ID)
    on delete cascade
);