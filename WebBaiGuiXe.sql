USE webbaiguixe;
-- Payment	(giá trị của hóa đơn chỉ mang tính minh họa cho Front-end, nên không có độ chính xác logic)
-- 			(lý do, tính toán giữa các bảng tốn rất nhiều thời gian ("có thể" dùng Trigger để tính toán luôn), Front-end cứ dùng tạm dữ liệu phía dưới)
-- 			(hóa đơn do đăng ký thẻ tháng thì vehicleInOutID null, và ngược lại giữa 2 cột)

CREATE TABLE Card (
    cardID INT PRIMARY KEY,
    status BIT,
    vehicleType VARCHAR(30) CHECK (vehicleType IN ('Xe máy' , 'Ô tô')),
    type VARCHAR(30) CHECK (type IN ('Thường' , 'Tháng')),
    display BIT
);

CREATE TABLE MonthCard (
    monthCardID INT PRIMARY KEY,
    date DATE,
    customerName VARCHAR(30),
    customerIdentityCard VARCHAR(30),
    phoneNumber VARCHAR(11) CHECK (phoneNumber LIKE '0%'),
    licensePlate VARCHAR(12),
    CONSTRAINT KNMC FOREIGN KEY (monthCardID)
        REFERENCES Card (cardID),
    display BIT
);

CREATE TABLE Account (
    userName VARCHAR(20) PRIMARY KEY,
    password VARCHAR(100),
    name VARCHAR(30),
    position VARCHAR(30) CHECK (position IN ('Nhân viên' , 'Admin')),
    identityCard VARCHAR(30),
    birth DATE,
    sex BIT,
    display BIT
);

CREATE TABLE Feedback (
    feedbackID INT PRIMARY KEY,
    content VARCHAR(1000),
    userName VARCHAR(20),
    CONSTRAINT KNFB FOREIGN KEY (userName)
        REFERENCES Account (userName),
    display BIT
);

CREATE TABLE Area (
    areaName VARCHAR(5) PRIMARY KEY,
    vehicleType VARCHAR(30) CHECK (vehicleType IN ('Xe máy' , 'Ô tô')),
    maxSize INT,
    currentSize INT,
    display BIT
);

CREATE TABLE ParkItem (
    parkItemID INT PRIMARY KEY,
    location INT,
    areaName VARCHAR(5),
    CONSTRAINT KNPI1 FOREIGN KEY (areaName)
        REFERENCES Area (areaName),
    cardID INT,
    CONSTRAINT KNPI2 FOREIGN KEY (cardID)
        REFERENCES Card (cardID),
    status BIT,
    display BIT
);

CREATE TABLE VehicleInOut (
    vehicleInOutID INT PRIMARY KEY,
    type BIT,
    time DATETIME,
    licensePlate VARCHAR(15),
    vehicleType VARCHAR(30) CHECK (vehicleType IN ('Xe máy' , 'Ô tô')),
    cardID INT,
    CONSTRAINT KNVIO1 FOREIGN KEY (cardID)
        REFERENCES Card (cardID),
    userName VARCHAR(20),
    CONSTRAINT KNVIO2 FOREIGN KEY (userName)
        REFERENCES Account (userName),
    display BIT
);

CREATE TABLE PriceList (
    priceListID INT PRIMARY KEY,
    motor INT,
    car INT,
    motorMonth INT,
    carMonth INT,
    display BIT
);

CREATE TABLE Payment (
    paymentID INT PRIMARY KEY,
    money INT,
    time DATETIME,
    monthCardID INT,
    CONSTRAINT KNP1 FOREIGN KEY (monthCardID)
        REFERENCES Card (cardID),
    vehicleInOutID INT,
    CONSTRAINT KNP2 FOREIGN KEY (vehicleInOutID)
        REFERENCES VehicleInOut (vehicleInOutID),
    priceListID INT,
    CONSTRAINT KNP3 FOREIGN KEY (priceListID)
        REFERENCES PriceList (priceListID),
    display BIT
);

-- Nhập dữ liệu
-- Card
		-- 25 thẻ
		-- 10 thẻ thường, 15 thẻ tháng
		-- 12 xe máy, 13 ô tô, 
        -- 2 thẻ thường, xe máy;	10 thẻ tháng, xe máy
        -- 8 thẻ thường ô tô;		5 thẻ tháng, ô tô
INSERT INTO Card (cardID, status, vehicleType, type, display)
VALUES (1001, 1, 'Ô tô', 'Thường', 1);
INSERT INTO Card (cardID, status, vehicleType, type, display)
VALUES (1002, 1, 'Ô tô', 'Thường', 1);
INSERT INTO Card (cardID, status, vehicleType, type, display)
VALUES (1003, 1, 'Ô tô', 'Thường', 1);
INSERT INTO Card (cardID, status, vehicleType, type, display)
VALUES (1004, 1, 'Xe máy', 'Thường', 1);
INSERT INTO Card (cardID, status, vehicleType, type, display)
VALUES (1005, 1, 'Ô tô', 'Thường', 1);
INSERT INTO Card (cardID, status, vehicleType, type, display)
VALUES (1006, 1, 'Ô tô', 'Thường', 1);
INSERT INTO Card (cardID, status, vehicleType, type, display)
VALUES (1007, 1, 'Xe máy', 'Thường', 1);
INSERT INTO Card (cardID, status, vehicleType, type, display)
VALUES (1008, 1, 'Ô tô', 'Thường', 1);
INSERT INTO Card (cardID, status, vehicleType, type, display)
VALUES (1009, 1, 'Ô tô', 'Thường', 1);
INSERT INTO Card (cardID, status, vehicleType, type, display)
VALUES (1010, 1, 'Ô tô', 'Thường', 1);
INSERT INTO Card (cardID, status, vehicleType, type, display)
VALUES (1011, 1, 'Ô tô', 'Tháng', 1);
INSERT INTO Card (cardID, status, vehicleType, type, display)
VALUES (1012, 1, 'Xe máy', 'Tháng', 1);
INSERT INTO Card (cardID, status, vehicleType, type, display)
VALUES (1013, 1, 'Xe máy', 'Tháng', 1);
INSERT INTO Card (cardID, status, vehicleType, type, display)
VALUES (1014, 1, 'Xe máy', 'Tháng', 1);
INSERT INTO Card (cardID, status, vehicleType, type, display)
VALUES (1015, 1, 'Xe máy', 'Tháng', 1);
INSERT INTO Card (cardID, status, vehicleType, type, display)
VALUES (1016, 1, 'Xe máy', 'Tháng', 1);
INSERT INTO Card (cardID, status, vehicleType, type, display)
VALUES (1017, 1, 'Ô tô', 'Tháng', 1);
INSERT INTO Card (cardID, status, vehicleType, type, display)
VALUES (1018, 1, 'Ô tô', 'Tháng', 1);
INSERT INTO Card (cardID, status, vehicleType, type, display)
VALUES (1019, 1, 'Ô tô', 'Tháng', 1);
INSERT INTO Card (cardID, status, vehicleType, type, display)
VALUES (1020, 1, 'Xe máy', 'Tháng', 1);
INSERT INTO Card (cardID, status, vehicleType, type, display)
VALUES (1021, 1, 'Xe máy', 'Tháng', 1);
INSERT INTO Card (cardID, status, vehicleType, type, display)
VALUES (1022, 1, 'Xe máy', 'Tháng', 1);
INSERT INTO Card (cardID, status, vehicleType, type, display)
VALUES (1023, 1, 'Xe máy', 'Tháng', 1);
INSERT INTO Card (cardID, status, vehicleType, type, display)
VALUES (1024, 1, 'Xe máy', 'Tháng', 1);
INSERT INTO Card (cardID, status, vehicleType, type, display)
VALUES (1025, 1, 'Ô tô', 'Tháng', 1);

-- MonthCard
INSERT INTO MonthCard (monthCardID, date, customerName, customerIdentityCard, phoneNumber, licensePlate, display)
VALUES (1011, '2023-05-01', 'Lý Văn C', '123456789111', '0320000011', '92U-1 27015', 1);
INSERT INTO MonthCard (monthCardID, date, customerName, customerIdentityCard, phoneNumber, licensePlate, display)
VALUES (1012, '2023-05-01', 'Lê Văn A', '123456789112', '0320000012', '10M-2 72231', 1);
INSERT INTO MonthCard (monthCardID, date, customerName, customerIdentityCard, phoneNumber, licensePlate, display)
VALUES (1013, '2023-05-01', 'Lê Văn A', '123456789113', '0320000013', '57H-2 92308', 1);
INSERT INTO MonthCard (monthCardID, date, customerName, customerIdentityCard, phoneNumber, licensePlate, display)
VALUES (1014, '2023-05-01', 'Vũ Thị D', '123456789114', '0320000014', '90F-3 22339', 1);
INSERT INTO MonthCard (monthCardID, date, customerName, customerIdentityCard, phoneNumber, licensePlate, display)
VALUES (1015, '2023-05-01', 'Hồ Thị A', '123456789115', '0320000015', '10E-3 39394', 1);
INSERT INTO MonthCard (monthCardID, date, customerName, customerIdentityCard, phoneNumber, licensePlate, display)
VALUES (1016, '2023-05-01', 'Bùi Văn C', '123456789116', '0320000016', '49P-1 78340', 1);
INSERT INTO MonthCard (monthCardID, date, customerName, customerIdentityCard, phoneNumber, licensePlate, display)
VALUES (1017, '2023-05-01', 'Nguyễn Văn C', '123456789117', '0320000017', '62J-1 33249', 1);
INSERT INTO MonthCard (monthCardID, date, customerName, customerIdentityCard, phoneNumber, licensePlate, display)
VALUES (1018, '2023-05-01', 'Lý Văn B', '123456789118', '0320000018', '31R-1 68290', 1);
INSERT INTO MonthCard (monthCardID, date, customerName, customerIdentityCard, phoneNumber, licensePlate, display)
VALUES (1019, '2023-05-01', 'Hồ Văn C', '123456789119', '0320000019', '48V-2 88813', 1);
INSERT INTO MonthCard (monthCardID, date, customerName, customerIdentityCard, phoneNumber, licensePlate, display)
VALUES (1020, '2023-05-01', 'Vũ Văn A', '123456789120', '0320000020', '60X-3 77129', 1);
INSERT INTO MonthCard (monthCardID, date, customerName, customerIdentityCard, phoneNumber, licensePlate, display)
VALUES (1021, '2023-05-01', 'Đỗ Văn A', '123456789121', '0320000021', '13O-2 97901', 1);
INSERT INTO MonthCard (monthCardID, date, customerName, customerIdentityCard, phoneNumber, licensePlate, display)
VALUES (1022, '2023-05-01', 'Nguyễn Văn A', '123456789122', '0320000022', '42G-2 62357', 1);
INSERT INTO MonthCard (monthCardID, date, customerName, customerIdentityCard, phoneNumber, licensePlate, display)
VALUES (1023, '2023-05-01', 'Bùi Thị B', '123456789123', '0320000023', '51X-1 19838', 1);
INSERT INTO MonthCard (monthCardID, date, customerName, customerIdentityCard, phoneNumber, licensePlate, display)
VALUES (1024, '2023-05-01', 'Chu Thị D', '123456789124', '0320000024', '24S-3 27077', 1);
INSERT INTO MonthCard (monthCardID, date, customerName, customerIdentityCard, phoneNumber, licensePlate, display)
VALUES (1025, '2023-05-01', 'Hồ Thị A', '123456789125', '0320000025', '44L-3 59716', 1);

-- Account
INSERT INTO Account (userName, password, name, position, identityCard, birth, sex, display)
VALUES ('lovantam', 'vantam123', 'Lò Văn Tám', 'Nhân viên', '123456789101', '2000-01-01', 1, 1);
INSERT INTO Account (userName, password, name, position, identityCard, birth, sex, display)
VALUES ('nguyenanhtu', 'anhtu123', 'Nguyễn Anh Tú', 'Admin', '123456789102', '2000-02-02', 1, 1);
INSERT INTO Account (userName, password, name, position, identityCard, birth, sex, display)
VALUES ('nguyenthixuan', 'thixuan123', 'Nguyễn Thị Xuân', 'Nhân viên', '123456789103', '2000-03-03', 0, 1);
INSERT INTO Account (userName, password, name, position, identityCard, birth, sex, display)
VALUES ('trananhtu', 'anhtu123', 'Trần Anh Tú', 'Nhân viên', '123456789104', '2000-04-04', 1, 1);
INSERT INTO Account (userName, password, name, position, identityCard, birth, sex, display)
VALUES ('tranvana', 'vana123', 'Trần Văn A', 'Nhân viên', '123456789105', '2000-05-05', 1, 1);

-- Feedback
INSERT INTO Feedback (feedbackID, content, userName, display)
VALUES (1001, 'Truy xuất dữ liệu phần nhận/trả xe còn chậm', 'lovantam', 1);
INSERT INTO Feedback (feedbackID, content, userName, display)
VALUES (1002, 'Thống kê số lượng xe sai', 'lovantam', 1);
INSERT INTO Feedback (feedbackID, content, userName, display)
VALUES (1003, 'Bị treo khi đăng nhập', 'nguyenthixuan', 1);

-- Area
INSERT INTO Area (areaName, vehicleType, maxSize, currentSize, display)
VALUES ('B', 'Xe máy', 480, 11, 1);
INSERT INTO Area (areaName, vehicleType, maxSize, currentSize, display)
VALUES ('C', 'Ô tô', 160, 10, 1);

-- ParkItem
		-- 480 ô khu B, 160 ô khu C
        -- 11 xe máy đang gửi, 10 ô tô đang gửi
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1001, 1, 'B', 1021, 1, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1002, 2, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1003, 3, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1004, 4, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1005, 5, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1006, 6, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1007, 7, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1008, 8, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1009, 9, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1010, 10, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1011, 11, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1012, 12, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1013, 13, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1014, 14, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1015, 15, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1016, 16, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1017, 17, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1018, 18, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1019, 19, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1020, 20, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1021, 21, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1022, 22, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1023, 23, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1024, 24, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1025, 25, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1026, 26, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1027, 27, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1028, 28, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1029, 29, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1030, 30, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1031, 31, 'B', 1020, 1, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1032, 32, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1033, 33, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1034, 34, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1035, 35, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1036, 36, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1037, 37, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1038, 38, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1039, 39, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1040, 40, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1041, 41, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1042, 42, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1043, 43, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1044, 44, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1045, 45, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1046, 46, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1047, 47, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1048, 48, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1049, 49, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1050, 50, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1051, 51, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1052, 52, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1053, 53, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1054, 54, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1055, 55, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1056, 56, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1057, 57, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1058, 58, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1059, 59, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1060, 60, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1061, 61, 'B', 1013, 1, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1062, 62, 'B', 1014, 1, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1063, 63, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1064, 64, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1065, 65, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1066, 66, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1067, 67, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1068, 68, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1069, 69, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1070, 70, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1071, 71, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1072, 72, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1073, 73, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1074, 74, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1075, 75, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1076, 76, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1077, 77, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1078, 78, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1079, 79, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1080, 80, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1081, 81, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1082, 82, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1083, 83, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1084, 84, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1085, 85, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1086, 86, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1087, 87, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1088, 88, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1089, 89, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1090, 90, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1091, 91, 'B', 1007, 1, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1092, 92, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1093, 93, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1094, 94, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1095, 95, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1096, 96, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1097, 97, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1098, 98, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1099, 99, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1100, 100, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1101, 101, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1102, 102, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1103, 103, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1104, 104, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1105, 105, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1106, 106, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1107, 107, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1108, 108, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1109, 109, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1110, 110, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1111, 111, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1112, 112, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1113, 113, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1114, 114, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1115, 115, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1116, 116, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1117, 117, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1118, 118, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1119, 119, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1120, 120, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1121, 121, 'B', 1016, 1, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1122, 122, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1123, 123, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1124, 124, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1125, 125, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1126, 126, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1127, 127, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1128, 128, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1129, 129, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1130, 130, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1131, 131, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1132, 132, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1133, 133, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1134, 134, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1135, 135, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1136, 136, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1137, 137, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1138, 138, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1139, 139, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1140, 140, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1141, 141, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1142, 142, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1143, 143, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1144, 144, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1145, 145, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1146, 146, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1147, 147, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1148, 148, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1149, 149, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1150, 150, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1151, 151, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1152, 152, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1153, 153, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1154, 154, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1155, 155, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1156, 156, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1157, 157, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1158, 158, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1159, 159, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1160, 160, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1161, 161, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1162, 162, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1163, 163, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1164, 164, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1165, 165, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1166, 166, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1167, 167, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1168, 168, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1169, 169, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1170, 170, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1171, 171, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1172, 172, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1173, 173, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1174, 174, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1175, 175, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1176, 176, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1177, 177, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1178, 178, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1179, 179, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1180, 180, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1181, 181, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1182, 182, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1183, 183, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1184, 184, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1185, 185, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1186, 186, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1187, 187, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1188, 188, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1189, 189, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1190, 190, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1191, 191, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1192, 192, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1193, 193, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1194, 194, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1195, 195, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1196, 196, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1197, 197, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1198, 198, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1199, 199, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1200, 200, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1201, 201, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1202, 202, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1203, 203, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1204, 204, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1205, 205, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1206, 206, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1207, 207, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1208, 208, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1209, 209, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1210, 210, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1211, 211, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1212, 212, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1213, 213, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1214, 214, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1215, 215, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1216, 216, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1217, 217, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1218, 218, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1219, 219, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1220, 220, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1221, 221, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1222, 222, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1223, 223, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1224, 224, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1225, 225, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1226, 226, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1227, 227, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1228, 228, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1229, 229, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1230, 230, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1231, 231, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1232, 232, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1233, 233, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1234, 234, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1235, 235, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1236, 236, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1237, 237, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1238, 238, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1239, 239, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1240, 240, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1241, 241, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1242, 242, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1243, 243, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1244, 244, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1245, 245, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1246, 246, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1247, 247, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1248, 248, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1249, 249, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1250, 250, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1251, 251, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1252, 252, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1253, 253, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1254, 254, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1255, 255, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1256, 256, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1257, 257, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1258, 258, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1259, 259, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1260, 260, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1261, 261, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1262, 262, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1263, 263, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1264, 264, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1265, 265, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1266, 266, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1267, 267, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1268, 268, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1269, 269, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1270, 270, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1271, 271, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1272, 272, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1273, 273, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1274, 274, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1275, 275, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1276, 276, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1277, 277, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1278, 278, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1279, 279, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1280, 280, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1281, 281, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1282, 282, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1283, 283, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1284, 284, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1285, 285, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1286, 286, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1287, 287, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1288, 288, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1289, 289, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1290, 290, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1291, 291, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1292, 292, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1293, 293, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1294, 294, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1295, 295, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1296, 296, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1297, 297, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1298, 298, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1299, 299, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1300, 300, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1301, 301, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1302, 302, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1303, 303, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1304, 304, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1305, 305, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1306, 306, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1307, 307, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1308, 308, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1309, 309, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1310, 310, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1311, 311, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1312, 312, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1313, 313, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1314, 314, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1315, 315, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1316, 316, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1317, 317, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1318, 318, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1319, 319, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1320, 320, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1321, 321, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1322, 322, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1323, 323, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1324, 324, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1325, 325, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1326, 326, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1327, 327, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1328, 328, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1329, 329, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1330, 330, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1331, 331, 'B', 1015, 1, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1332, 332, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1333, 333, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1334, 334, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1335, 335, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1336, 336, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1337, 337, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1338, 338, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1339, 339, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1340, 340, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1341, 341, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1342, 342, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1343, 343, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1344, 344, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1345, 345, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1346, 346, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1347, 347, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1348, 348, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1349, 349, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1350, 350, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1351, 351, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1352, 352, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1353, 353, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1354, 354, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1355, 355, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1356, 356, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1357, 357, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1358, 358, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1359, 359, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1360, 360, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1361, 361, 'B', 1012, 1, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1362, 362, 'B', 1022, 1, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1363, 363, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1364, 364, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1365, 365, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1366, 366, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1367, 367, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1368, 368, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1369, 369, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1370, 370, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1371, 371, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1372, 372, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1373, 373, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1374, 374, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1375, 375, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1376, 376, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1377, 377, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1378, 378, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1379, 379, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1380, 380, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1381, 381, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1382, 382, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1383, 383, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1384, 384, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1385, 385, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1386, 386, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1387, 387, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1388, 388, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1389, 389, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1390, 390, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1391, 391, 'B', 1023, 1, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1392, 392, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1393, 393, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1394, 394, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1395, 395, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1396, 396, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1397, 397, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1398, 398, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1399, 399, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1400, 400, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1401, 401, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1402, 402, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1403, 403, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1404, 404, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1405, 405, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1406, 406, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1407, 407, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1408, 408, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1409, 409, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1410, 410, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1411, 411, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1412, 412, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1413, 413, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1414, 414, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1415, 415, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1416, 416, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1417, 417, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1418, 418, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1419, 419, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1420, 420, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1421, 421, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1422, 422, 'B', 1004, 1, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1423, 423, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1424, 424, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1425, 425, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1426, 426, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1427, 427, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1428, 428, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1429, 429, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1430, 430, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1431, 431, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1432, 432, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1433, 433, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1434, 434, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1435, 435, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1436, 436, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1437, 437, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1438, 438, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1439, 439, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1440, 440, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1441, 441, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1442, 442, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1443, 443, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1444, 444, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1445, 445, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1446, 446, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1447, 447, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1448, 448, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1449, 449, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1450, 450, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1451, 451, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1452, 452, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1453, 453, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1454, 454, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1455, 455, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1456, 456, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1457, 457, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1458, 458, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1459, 459, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1460, 460, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1461, 461, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1462, 462, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1463, 463, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1464, 464, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1465, 465, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1466, 466, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1467, 467, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1468, 468, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1469, 469, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1470, 470, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1471, 471, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1472, 472, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1473, 473, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1474, 474, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1475, 475, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1476, 476, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1477, 477, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1478, 478, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1479, 479, 'B', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1480, 480, 'B', NULL, 0, 1);


INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1481, 1, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1482, 2, 'C', 1019, 1, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1483, 3, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1484, 4, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1485, 5, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1486, 6, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1487, 7, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1488, 8, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1489, 9, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1490, 10, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1491, 11, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1492, 12, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1493, 13, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1494, 14, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1495, 15, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1496, 16, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1497, 17, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1498, 18, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1499, 19, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1500, 20, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1501, 21, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1502, 22, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1503, 23, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1504, 24, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1505, 25, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1506, 26, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1507, 27, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1508, 28, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1509, 29, 'C', 1006, 1, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1510, 30, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1511, 31, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1512, 32, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1513, 33, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1514, 34, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1515, 35, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1516, 36, 'C', 1011, 1, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1517, 37, 'C', 1008, 1, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1518, 38, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1519, 39, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1520, 40, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1521, 41, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1522, 42, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1523, 43, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1524, 44, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1525, 45, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1526, 46, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1527, 47, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1528, 48, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1529, 49, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1530, 50, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1531, 51, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1532, 52, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1533, 53, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1534, 54, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1535, 55, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1536, 56, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1537, 57, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1538, 58, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1539, 59, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1540, 60, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1541, 61, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1542, 62, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1543, 63, 'C', 1018, 1, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1544, 64, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1545, 65, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1546, 66, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1547, 67, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1548, 68, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1549, 69, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1550, 70, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1551, 71, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1552, 72, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1553, 73, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1554, 74, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1555, 75, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1556, 76, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1557, 77, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1558, 78, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1559, 79, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1560, 80, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1561, 81, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1562, 82, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1563, 83, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1564, 84, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1565, 85, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1566, 86, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1567, 87, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1568, 88, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1569, 89, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1570, 90, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1571, 91, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1572, 92, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1573, 93, 'C', 1017, 1, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1574, 94, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1575, 95, 'C', 1010, 1, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1576, 96, 'C', 1002, 1, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1577, 97, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1578, 98, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1579, 99, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1580, 100, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1581, 101, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1582, 102, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1583, 103, 'C', 1005, 1, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1584, 104, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1585, 105, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1586, 106, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1587, 107, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1588, 108, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1589, 109, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1590, 110, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1591, 111, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1592, 112, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1593, 113, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1594, 114, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1595, 115, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1596, 116, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1597, 117, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1598, 118, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1599, 119, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1600, 120, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1601, 121, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1602, 122, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1603, 123, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1604, 124, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1605, 125, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1606, 126, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1607, 127, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1608, 128, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1609, 129, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1610, 130, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1611, 131, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1612, 132, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1613, 133, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1614, 134, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1615, 135, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1616, 136, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1617, 137, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1618, 138, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1619, 139, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1620, 140, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1621, 141, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1622, 142, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1623, 143, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1624, 144, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1625, 145, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1626, 146, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1627, 147, 'C', 1025, 1, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1628, 148, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1629, 149, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1630, 150, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1631, 151, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1632, 152, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1633, 153, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1634, 154, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1635, 155, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1636, 156, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1637, 157, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1638, 158, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1639, 159, 'C', NULL, 0, 1);
INSERT INTO ParkItem (parkItemID, location, areaName, cardID, status, display)
VALUES (1640, 160, 'C', NULL, 0, 1);

-- VehicleInOut
		-- 41 lần nhận/trả
		-- 31 lần nhận, 10 lần trả
        -- 14 lần nhận xe máy, 17 lần nhận ô tô
        -- 3 lần trả xe máy, 7 lần trả ô tô
INSERT INTO VehicleInOut (vehicleInOutID, type, time, licensePlate, vehicleType, cardID, userName, display)
VALUES (1001, 1, '2023-06-14 06:14:21', '29A-2 10001', 'Ô tô', 1001, 'nguyenanhtu', 1);
INSERT INTO VehicleInOut (vehicleInOutID, type, time, licensePlate, vehicleType, cardID, userName, display)
VALUES (1002, 0, '2023-06-14 15:04:59', '29A-2 10001', 'Ô tô', 1001, 'nguyenanhtu', 1);
INSERT INTO VehicleInOut (vehicleInOutID, type, time, licensePlate, vehicleType, cardID, userName, display)
VALUES (1003, 1, '2023-06-15 03:25:40', '31R-1 68290', 'Ô tô', 1018, 'tranvana', 1);
INSERT INTO VehicleInOut (vehicleInOutID, type, time, licensePlate, vehicleType, cardID, userName, display)
VALUES (1004, 1, '2023-06-15 14:22:18', '29A-2 10001', 'Ô tô', 1001, 'trananhtu', 1);
INSERT INTO VehicleInOut (vehicleInOutID, type, time, licensePlate, vehicleType, cardID, userName, display)
VALUES (1005, 1, '2023-06-15 18:55:21', '29A-1 10009', 'Ô tô', 1009, 'nguyenanhtu', 1);
INSERT INTO VehicleInOut (vehicleInOutID, type, time, licensePlate, vehicleType, cardID, userName, display)
VALUES (1006, 0, '2023-06-15 20:18:31', '29A-1 10009', 'Ô tô', 1009, 'tranvana', 1);
INSERT INTO VehicleInOut (vehicleInOutID, type, time, licensePlate, vehicleType, cardID, userName, display)
VALUES (1007, 1, '2023-06-15 20:39:02', '29A-1 10004', 'Xe máy', 1004, 'lovantam', 1);
INSERT INTO VehicleInOut (vehicleInOutID, type, time, licensePlate, vehicleType, cardID, userName, display)
VALUES (1008, 1, '2023-06-15 22:16:25', '62J-1 33249', 'Ô tô', 1017, 'lovantam', 1);
INSERT INTO VehicleInOut (vehicleInOutID, type, time, licensePlate, vehicleType, cardID, userName, display)
VALUES (1009, 1, '2023-06-16 01:12:06', '29A-1 10006', 'Ô tô', 1006, 'nguyenanhtu', 1);
INSERT INTO VehicleInOut (vehicleInOutID, type, time, licensePlate, vehicleType, cardID, userName, display)
VALUES (1010, 1, '2023-06-16 10:27:28', '29A-1 10002', 'Ô tô', 1002, 'nguyenanhtu', 1);
INSERT INTO VehicleInOut (vehicleInOutID, type, time, licensePlate, vehicleType, cardID, userName, display)
VALUES (1011, 1, '2023-06-16 11:38:52', '49P-1 78340', 'Xe máy', 1016, 'nguyenthixuan', 1);
INSERT INTO VehicleInOut (vehicleInOutID, type, time, licensePlate, vehicleType, cardID, userName, display)
VALUES (1012, 0, '2023-06-16 18:21:59', '62J-1 33249', 'Ô tô', 1017, 'tranvana', 1);
INSERT INTO VehicleInOut (vehicleInOutID, type, time, licensePlate, vehicleType, cardID, userName, display)
VALUES (1013, 1, '2023-06-17 02:03:54', '10M-2 72231', 'Xe máy', 1012, 'nguyenanhtu', 1);
INSERT INTO VehicleInOut (vehicleInOutID, type, time, licensePlate, vehicleType, cardID, userName, display)
VALUES (1014, 1, '2023-06-17 08:09:13', '29A-1 10010', 'Ô tô', 1010, 'nguyenanhtu', 1);
INSERT INTO VehicleInOut (vehicleInOutID, type, time, licensePlate, vehicleType, cardID, userName, display)
VALUES (1015, 1, '2023-06-17 12:43:43', '51X-1 19838', 'Xe máy', 1023, 'lovantam', 1);
INSERT INTO VehicleInOut (vehicleInOutID, type, time, licensePlate, vehicleType, cardID, userName, display)
VALUES (1016, 0, '2023-06-18 01:24:24', '29A-2 10001', 'Ô tô', 1001, 'tranvana', 1);
INSERT INTO VehicleInOut (vehicleInOutID, type, time, licensePlate, vehicleType, cardID, userName, display)
VALUES (1017, 1, '2023-06-18 06:34:36', '48V-2 88813', 'Ô tô', 1019, 'trananhtu', 1);
INSERT INTO VehicleInOut (vehicleInOutID, type, time, licensePlate, vehicleType, cardID, userName, display)
VALUES (1018, 1, '2023-06-19 02:02:05', '29A-1 10009', 'Ô tô', 1009, 'lovantam', 1);
INSERT INTO VehicleInOut (vehicleInOutID, type, time, licensePlate, vehicleType, cardID, userName, display)
VALUES (1019, 1, '2023-06-20 09:10:48', '29A-1 10003', 'Ô tô', 1003, 'trananhtu', 1);
INSERT INTO VehicleInOut (vehicleInOutID, type, time, licensePlate, vehicleType, cardID, userName, display)
VALUES (1020, 0, '2023-06-21 17:00:06', '29A-1 10003', 'Ô tô', 1003, 'nguyenthixuan', 1);
INSERT INTO VehicleInOut (vehicleInOutID, type, time, licensePlate, vehicleType, cardID, userName, display)
VALUES (1021, 0, '2023-06-21 20:24:59', '10M-2 72231', 'Xe máy', 1012, 'nguyenanhtu', 1);
INSERT INTO VehicleInOut (vehicleInOutID, type, time, licensePlate, vehicleType, cardID, userName, display)
VALUES (1022, 1, '2023-06-22 01:35:39', '92U-1 27015', 'Ô tô', 1011, 'nguyenanhtu', 1);
INSERT INTO VehicleInOut (vehicleInOutID, type, time, licensePlate, vehicleType, cardID, userName, display)
VALUES (1023, 1, '2023-06-23 02:48:01', '10E-3 39394', 'Xe máy', 1015, 'tranvana', 1);
INSERT INTO VehicleInOut (vehicleInOutID, type, time, licensePlate, vehicleType, cardID, userName, display)
VALUES (1024, 1, '2023-06-25 06:12:23', '60X-3 77129', 'Xe máy', 1020, 'tranvana', 1);
INSERT INTO VehicleInOut (vehicleInOutID, type, time, licensePlate, vehicleType, cardID, userName, display)
VALUES (1025, 1, '2023-06-25 16:08:42', '29A-1 10007', 'Xe máy', 1007, 'lovantam', 1);
INSERT INTO VehicleInOut (vehicleInOutID, type, time, licensePlate, vehicleType, cardID, userName, display)
VALUES (1026, 1, '2023-06-25 22:23:59', '57H-2 92308', 'Xe máy', 1013, 'tranvana', 1);
INSERT INTO VehicleInOut (vehicleInOutID, type, time, licensePlate, vehicleType, cardID, userName, display)
VALUES (1027, 1, '2023-06-27 00:15:24', '10M-2 72231', 'Xe máy', 1012, 'nguyenthixuan', 1);
INSERT INTO VehicleInOut (vehicleInOutID, type, time, licensePlate, vehicleType, cardID, userName, display)
VALUES (1028, 1, '2023-06-27 02:29:22', '42G-2 62357', 'Xe máy', 1022, 'nguyenthixuan', 1);
INSERT INTO VehicleInOut (vehicleInOutID, type, time, licensePlate, vehicleType, cardID, userName, display)
VALUES (1029, 0, '2023-06-27 15:46:55', '10E-3 39394', 'Xe máy', 1015, 'nguyenthixuan', 1);
INSERT INTO VehicleInOut (vehicleInOutID, type, time, licensePlate, vehicleType, cardID, userName, display)
VALUES (1030, 1, '2023-06-27 18:30:27', '13O-2 97901', 'Xe máy', 1021, 'nguyenthixuan', 1);
INSERT INTO VehicleInOut (vehicleInOutID, type, time, licensePlate, vehicleType, cardID, userName, display)
VALUES (1031, 1, '2023-06-27 21:48:54', '90F-3 22339', 'Xe máy', 1014, 'tranvana', 1);
INSERT INTO VehicleInOut (vehicleInOutID, type, time, licensePlate, vehicleType, cardID, userName, display)
VALUES (1032, 1, '2023-06-28 12:40:12', '10E-3 39394', 'Xe máy', 1015, 'nguyenanhtu', 1);
INSERT INTO VehicleInOut (vehicleInOutID, type, time, licensePlate, vehicleType, cardID, userName, display)
VALUES (1033, 1, '2023-06-29 01:38:40', '44L-3 59716', 'Ô tô', 1025, 'nguyenanhtu', 1);
INSERT INTO VehicleInOut (vehicleInOutID, type, time, licensePlate, vehicleType, cardID, userName, display)
VALUES (1034, 0, '2023-06-29 16:44:09', '29A-1 10009', 'Ô tô', 1009, 'nguyenanhtu', 1);
INSERT INTO VehicleInOut (vehicleInOutID, type, time, licensePlate, vehicleType, cardID, userName, display)
VALUES (1035, 1, '2023-06-29 17:15:32', '29A-1 10008', 'Ô tô', 1008, 'trananhtu', 1);
INSERT INTO VehicleInOut (vehicleInOutID, type, time, licensePlate, vehicleType, cardID, userName, display)
VALUES (1036, 1, '2023-06-29 23:18:45', '24S-3 27077', 'Xe máy', 1024, 'nguyenthixuan', 1);
INSERT INTO VehicleInOut (vehicleInOutID, type, time, licensePlate, vehicleType, cardID, userName, display)
VALUES (1037, 1, '2023-06-30 08:38:04', '62J-1 33249', 'Ô tô', 1017, 'nguyenanhtu', 1);
INSERT INTO VehicleInOut (vehicleInOutID, type, time, licensePlate, vehicleType, cardID, userName, display)
VALUES (1038, 0, '2023-06-30 13:43:26', '29A-1 10008', 'Ô tô', 1008, 'nguyenthixuan', 1);
INSERT INTO VehicleInOut (vehicleInOutID, type, time, licensePlate, vehicleType, cardID, userName, display)
VALUES (1039, 0, '2023-06-30 14:37:49', '24S-3 27077', 'Xe máy', 1024, 'lovantam', 1);
INSERT INTO VehicleInOut (vehicleInOutID, type, time, licensePlate, vehicleType, cardID, userName, display)
VALUES (1040, 1, '2023-06-30 16:23:15', '29A-1 10008', 'Ô tô', 1008, 'tranvana', 1);
INSERT INTO VehicleInOut (vehicleInOutID, type, time, licensePlate, vehicleType, cardID, userName, display)
VALUES (1041, 1, '2023-06-30 23:56:30', '29A-1 10005', 'Ô tô', 1005, 'trananhtu', 1);


-- PriceList
INSERT INTO PriceList (priceListID, motor, car, motorMonth, carMonth, display)
VALUES (1001, 5000, 10000, 120000, 5000000, 1);

-- Payment	(giá trị của hóa đơn chỉ mang tính minh họa cho Front-end, nên không có độ chính xác logic)
-- 			(lý do, tính toán giữa các bảng tốn rất nhiều thời gian ("có thể" dùng Trigger để tính toán luôn), Front-end cứ dùng tạm dữ liệu phía dưới)
-- 			(hóa đơn do đăng ký thẻ tháng thì vehicleInOutID null, và ngược lại giữa 2 cột)
INSERT INTO Payment (paymentID, money, time, monthCardID, vehicleInOutID, priceListID, display)
VALUES (1001, 5000000, '2023-05-01 14:45:58', 1011, NULL, 1001, 1);
INSERT INTO Payment (paymentID, money, time, monthCardID, vehicleInOutID, priceListID, display)
VALUES (1002, 120000, '2023-05-01 14:46:00', 1012, NULL, 1001, 1);
INSERT INTO Payment (paymentID, money, time, monthCardID, vehicleInOutID, priceListID, display)
VALUES (1003, 120000, '2023-05-01 14:46:02', 1013, NULL, 1001, 1);
INSERT INTO Payment (paymentID, money, time, monthCardID, vehicleInOutID, priceListID, display)
VALUES (1004, 120000, '2023-05-01 14:46:04', 1014, NULL, 1001, 1);
INSERT INTO Payment (paymentID, money, time, monthCardID, vehicleInOutID, priceListID, display)
VALUES (1005, 120000, '2023-05-01 14:46:07', 1015, NULL, 1001, 1);
INSERT INTO Payment (paymentID, money, time, monthCardID, vehicleInOutID, priceListID, display)
VALUES (1006, 120000, '2023-05-01 14:46:14', 1016, NULL, 1001, 1);
INSERT INTO Payment (paymentID, money, time, monthCardID, vehicleInOutID, priceListID, display)
VALUES (1007, 5000000, '2023-05-01 14:46:18', 1017, NULL, 1001, 1);
INSERT INTO Payment (paymentID, money, time, monthCardID, vehicleInOutID, priceListID, display)
VALUES (1008, 5000000, '2023-05-01 14:46:22', 1018, NULL, 1001, 1);
INSERT INTO Payment (paymentID, money, time, monthCardID, vehicleInOutID, priceListID, display)
VALUES (1009, 5000000, '2023-05-01 14:46:26', 1019, NULL, 1001, 1);
INSERT INTO Payment (paymentID, money, time, monthCardID, vehicleInOutID, priceListID, display)
VALUES (1010, 120000, '2023-05-01 14:46:29', 1020, NULL, 1001, 1);
INSERT INTO Payment (paymentID, money, time, monthCardID, vehicleInOutID, priceListID, display)
VALUES (1011, 120000, '2023-05-01 14:46:38', 1021, NULL, 1001, 1);
INSERT INTO Payment (paymentID, money, time, monthCardID, vehicleInOutID, priceListID, display)
VALUES (1012, 120000, '2023-05-01 14:46:40', 1022, NULL, 1001, 1);
INSERT INTO Payment (paymentID, money, time, monthCardID, vehicleInOutID, priceListID, display)
VALUES (1013, 120000, '2023-05-01 14:46:53', 1023, NULL, 1001, 1);
INSERT INTO Payment (paymentID, money, time, monthCardID, vehicleInOutID, priceListID, display)
VALUES (1014, 120000, '2023-05-01 14:46:55', 1024, NULL, 1001, 1);
INSERT INTO Payment (paymentID, money, time, monthCardID, vehicleInOutID, priceListID, display)
VALUES (1015, 5000000, '2023-05-01 14:46:57', 1025, NULL, 1001, 1);
INSERT INTO Payment (paymentID, money, time, monthCardID, vehicleInOutID, priceListID, display)
VALUES (1016, 90000, '2023-06-14 15:04:59', NULL, 1002, 1001, 1);
INSERT INTO Payment (paymentID, money, time, monthCardID, vehicleInOutID, priceListID, display)
VALUES (1017, 20000, '2023-06-15 20:18:31', NULL, 1006, 1001, 1);
INSERT INTO Payment (paymentID, money, time, monthCardID, vehicleInOutID, priceListID, display)
VALUES (1018, 600000, '2023-06-18 01:24:24', NULL, 1016, 1001, 1);
INSERT INTO Payment (paymentID, money, time, monthCardID, vehicleInOutID, priceListID, display)
VALUES (1019, 320000, '2023-06-21 17:00:06', NULL, 1020, 1001, 1);
INSERT INTO Payment (paymentID, money, time, monthCardID, vehicleInOutID, priceListID, display)
VALUES (1020, 2550000, '2023-06-29 16:44:09', NULL, 1034, 1001, 1);
INSERT INTO Payment (paymentID, money, time, monthCardID, vehicleInOutID, priceListID, display)
VALUES (1021, 210000, '2023-06-30 13:43:26', NULL, 1038, 1001, 1);
