<?php
//Make the connection
$host = "localhost";
$username = "root";
$password = "";
$conn = new mysqli($host, $username, $password);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
    echo "<script>alert('The connection failed please try again')</script>";
} else {
    //the sql query to create the database, create the tables and insert the records.
    //it creates the database and the tables only if it doesnt exist.
    //inserts the initial records given by the company.
    $sqlCreate = "CREATE DATABASE IF NOT EXISTS w1714855_AudioVizzion;

CREATE TABLE IF NOT EXISTS w1714855_AudioVizzion.w1714855_Device(
w1714855_deviceCatalogID varchar(10),
w1714855_deviceCatalogName varchar(100) NOT NULL,
w1714855_deviceDescrip varchar(320) NOT NULL,
w1714855_deviceAvailabilityStatus ENUM ('in stock', 'currently being ordered') NOT NULL,

CONSTRAINT w1714855_device_devcid_pk PRIMARY KEY (w1714855_deviceCatalogID)
); 

CREATE TABLE IF NOT EXISTS w1714855_AudioVizzion.w1714855_Visual_Device(

w1714855_vdDeviceID varchar(10),
w1714855_vdFrFlag boolean NOT NULL,
w1714855_vdFrBrand varchar(40),
w1714855_vdFrModel varchar(40) ,
w1714855_vdLensFlag  boolean NOT NULL,
w1714855_vdLensSerialNo  varchar(15),
w1714855_vdLensVisionType varchar(320),
w1714855_vdLensTint varchar(15),
w1714855_vdLensThinnessLevel varchar(30),

CONSTRAINT w1714855_visual_device_vdid_pk  PRIMARY KEY (w1714855_vdDeviceID),
CONSTRAINT w1714855_visual_device_vdid_fk FOREIGN KEY (w1714855_vdDeviceID) 
REFERENCES w1714855_AudioVizzion.w1714855_device(w1714855_deviceCatalogID)ON UPDATE CASCADE ON DELETE CASCADE,
CONSTRAINT w1714855_visual_device_vdlserialno_ck UNIQUE (w1714855_vdLensSerialNo)

);

CREATE TABLE IF NOT EXISTS w1714855_AudioVizzion.w1714855_Hearing_Device(

w1714855_hdDeviceID varchar(10), 
w1714855_hdMake varchar(40) NOT NULL,
w1714855_hdModel varchar(40) NOT NULL,

 CONSTRAINT w1714855_hearing_device_hdid_pk  PRIMARY KEY (w1714855_hdDeviceID),
 CONSTRAINT w1714855_hearing_device_hdid_fk FOREIGN KEY (w1714855_hdDeviceID) 
 REFERENCES w1714855_AudioVizzion.w1714855_Device(w1714855_deviceCatalogID) ON UPDATE CASCADE ON DELETE CASCADE
);

INSERT INTO w1714855_audiovizzion.w1714855_Device(w1714855_deviceCatalogID,w1714855_deviceCatalogName,w1714855_deviceDescrip,w1714855_deviceAvailabilityStatus)
VALUES ('d0001','Emporio Armani Ultra-Light frame', 'Brand new grey and blue ultra-light frame, latest trend in 2019', 'in stock');

INSERT INTO w1714855_audiovizzion.w1714855_visual_device(w1714855_vdDeviceID, w1714855_vdFrFlag, w1714855_vdLensFlag,w1714855_vdFrBrand,w1714855_vdFrModel)
VALUES ((SELECT w1714855_deviceCatalogID FROM w1714855_AudioVizzion.w1714855_Device WHERE w1714855_deviceCatalogID='d0001'),true, false,'Emporio Armani','Empo324');

INSERT INTO w1714855_audiovizzion.w1714855_Device(w1714855_deviceCatalogID,w1714855_deviceCatalogName,w1714855_deviceDescrip,w1714855_deviceAvailabilityStatus)
VALUES ('d0002','Optimo Single Vision Lens', 'Optimal single vision lens, 2020 style, anti-scratch and anti-shock' , 'in stock' );

INSERT INTO w1714855_audiovizzion.w1714855_visual_device(w1714855_vdDeviceID, w1714855_vdFrFlag, w1714855_vdLensFlag, w1714855_vdLensSerialNo, w1714855_vdLensVisionType, w1714855_vdLensTint, w1714855_vdLensThinnessLevel)
VALUES ((SELECT w1714855_deviceCatalogID FROM w1714855_AudioVizzion.w1714855_Device WHERE w1714855_deviceCatalogID='d0002'),false, true,'opto456321987','Single vision for short-sightedness','clear','ultra-thin');
 
INSERT INTO w1714855_audiovizzion.w1714855_Device(w1714855_deviceCatalogID,w1714855_deviceCatalogName,w1714855_deviceDescrip,w1714855_deviceAvailabilityStatus)
VALUES ('d0003','Phono Titanium Digital Hearing Aid','Ultra-sensitive digital hearing aid, adjustable through an App', 'currently being ordered'); 

INSERT INTO w1714855_audiovizzion.w1714855_hearing_device (w1714855_hdDeviceID, w1714855_hdMake, w1714855_hdModel)
VALUES ((SELECT w1714855_deviceCatalogID FROM w1714855_AudioVizzion.w1714855_Device WHERE w1714855_deviceCatalogID='d0003'), 'Phono Titanium', 'phono2021');";

    //executing the sql queries.
    mysqli_multi_query($conn, $sqlCreate);
}

//closing the connection
mysqli_close($conn);
