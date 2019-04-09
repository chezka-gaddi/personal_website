use db_csc484demo;


insert into Video values('M0001', 'Life is Beatifull',  'Drama',   19.95);
insert into Video values('M0002', 'King Ralph',         'Comedy',  15.00);
insert into Video values('M0003', 'Crazy in Alabama',   'Action',  10.00);
insert into Video values('M0004', 'Dance with Me',      'Drama',   19.95);
insert into Video values('M0005', 'Sister Act',         'Comedy',  12.00);
insert into Video values('M0006', 'La Bamba',           'Drama',   10.00);
insert into Video values('M0007', 'As Good As It Gets', 'Drama',   15.00);
insert into Video values('M0008', 'Father of the Bride','Comedy',  17.50);
insert into Video values('M0009', 'Born Free',          'Children',10.00);
insert into Video values('M0010', 'Dangerous Minds',    'Drama',   14.50);
insert into Video values('M0011', 'Hercules',           'Action',  12.50);
insert into Video values('M0012', 'The Exterminator',   'Action',  19.95);

-- VideoForRent data
insert into VideoForRent values(1,  'M0001', 'Available',  1.00);
insert into VideoForRent values(2,  'M0001', 'Available',  1.00);
insert into VideoForRent values(3,  'M0001', 'Rented', 1.00);
insert into VideoForRent values(4,  'M0005', 'Available',  1.00);
insert into VideoForRent values(5,  'M0004', 'Available',  1.50);
insert into VideoForRent values(6,  'M0004', 'Available',  1.50);
insert into VideoForRent values(7,  'M0002', 'Available',  1.00);
insert into VideoForRent values(8,  'M0003', 'Available',  1.00);
insert into VideoForRent values(9,  'M0012', 'Available',  1.00);
insert into VideoForRent values(10, 'M0012', 'Rented', 1.00);
insert into VideoForRent values(11, 'M0009', 'Available',  1.00);
insert into VideoForRent values(12, 'M0011', 'Available',  1.00);
insert into VideoForRent values(13, 'M0011', 'Available',  1.00);
insert into VideoForRent values(14, 'M0010', 'Available',  1.00);
insert into VideoForRent values(15, 'M0010', 'Rented', 1.00);
insert into VideoForRent values(16, 'M0010', 'Available',  1.00);
insert into VideoForRent values(17, 'M0008', 'Available',  1.00);
insert into VideoForRent values(18, 'M0008', 'Rented', 1.00);
insert into VideoForRent values(19, 'M0008', 'Rented', 1.00);
insert into VideoForRent values(20, 'M0008', 'Available',  1.00);
insert into VideoForRent values(21, 'M0007', 'Rented', 1.50);
insert into VideoForRent values(22, 'M0007', 'Available',  1.50);
insert into VideoForRent values(23, 'M0006', 'Available',  1.00);

-- Member data
insert into Member 
  values(1, 'John', 'Thomas',  '2100 W. Main, Rapid City, SD 57702',    '20130220', '605-345-1212');
insert into Member 
  values(2, 'Peter', 'Flores', '412 Maple, Rapid City, SD 57701',       '20130221', '605-444-4455');
insert into Member 
  values(3, 'Ann',  'Jones',    '101 Century St., Rapid City, SD, 57703','20130221', '605-212-2320');
insert into Member 
  values(4, 'Juana', 'Plummer', '2456 Cloud St., Rapid City, SD 57701', '20130221', '605-453-2010');
insert into Member 
  values(5, 'Don', 'Flutes',   '410 Jones Dr., Rapid City, SD 57702',   '20130222', '605-484-0120');
insert into Member 
  values(6, 'Cory', 'Gomes',  '23201 Hw 44 W, Box Elder, SD 57705',    '20130222', '605-697-9838');
insert into Member 
  values(7, 'Tina', 'Turney',  '828 8th St, Rapid City, SD 57702',      '20130223', '605-355-6598');
insert into Member 
  values(8, 'Dana', 'Voller',  '2980 Rawhide Dr., Rapid City, SD 57702', '20130224', '605-444-3453');

-- VideoRented data
insert into VideoRented (  videoNo,  memberID,  dateOut,  dateIn) values(10, 2, '20130312', '20070313');
insert into VideoRented (  videoNo,  memberID,  dateOut,  dateIn) values(13, 1, '20130312', '20070314');
insert into VideoRented (  videoNo,  memberID,  dateOut,  dateIn) values(3, 1, '20130312', '20070314');
insert into VideoRented (  videoNo,  memberID,  dateOut,  dateIn) values(10, 5, '20130211', NULL);
insert into VideoRented (  videoNo,  memberID,  dateOut,  dateIn) values(19, 5, '20130211', NULL);
insert into VideoRented (  videoNo,  memberID,  dateOut,  dateIn) values(3, 2, '20130211', NULL);
insert into VideoRented (  videoNo,  memberID,  dateOut,  dateIn) values(15, 7, '20130211', NULL);
insert into VideoRented (  videoNo,  memberID,  dateOut,  dateIn) values(18, 7, '20130211', NULL);
insert into VideoRented (  videoNo,  memberID,  dateOut,  dateIn) values(21, 7, '20130211', NULL);