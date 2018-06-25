ALTER TABLE receiving
ADD reference_name VARCHAR(255);

ALTER TABLE receiving
ADD delivery_due_date DATE;

ALTER TABLE receiving
ADD from_outlet INT;

ALTER TABLE receiving
ADD to_outlet INT;

ALTER TABLE receiving
ADD trans_type VARCHAR(2);

ALTER TABLE receiving
ADD created_date DATETIME;

ALTER TABLE receiving
ADD modified_date DATETIME;