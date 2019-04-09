use db_csc484demo;

create table Video
( catalogID     char(5) PRIMARY KEY,
  title         varchar(100),
  category      varchar(100) check (category IN 
                 ('Action', 'Adult', 'Children', 'Comedy', 'Drama', 'Sci-Fi')),
  cost          decimal(6,2)
);

create table VideoForRent
( videoNo      int PRIMARY KEY,
  catalogID    char(5) references Video(CatalogID),
  status       varchar(100) check (Status IN ('Available', 'Rented', 'Lost')),
  dailyRental  decimal(6,2)
);

create table Member
( memberID     int PRIMARY KEY,
  fName        varchar(100),
  lName	   varchar(100),
  address      varchar(100),
  dateJoined   datetime,
  phoneNo      varchar(100)
);

create table VideoRented
( RentalID     int auto_increment PRIMARY KEY,
  videoNo      int references VideoForRent(VideoNo),
  memberID     int references Member(MemberID),
  dateOut      datetime,
  dateIn   datetime
);


