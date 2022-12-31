--Put Tony Stark into the Client Table
INSERT INTO clients (clientFirstname, clientLastname, clientEmail, clientPassword, comment)
	VALUES ('Tony', 'Stark', 'tony@starkent.com', 'Iam1ronM@n', 'I am the real Ironman');

-- change Tony Stark to level 3
UPDATE clients SET clientLevel = '3' WHERE clientId = '3';

--modify GM Hummer
UPDATE inventory
SET invDescription = REPLACE('Do you have 6 kids and like to go offroading? 
The Hummer gives you the small interiors with an engine to get you out of 
any muddy or rocky situation.','small','spacious')
WHERE invId = '12';

--Inner Join
SELECT inventory.invModel, carclassification.classificationName 
FROM inventory 
INNER JOIN carclassification 
ON inventory.classificationId = carclassification.classificationId
WHERE carclassification.classificationName = 'SUV';

--Delete Jeep
DELETE FROM inventory WHERE invModel = 'wrangler';

--Update Concat
UPDATE inventory 
SET invImage = concat('/phpmotors', invImage);