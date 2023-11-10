-- Create the 'test' database if it doesn't exist
CREATE DATABASE  test;

-- Use the 'test' database
USE test;

-- Create the 'EmailMessage' table
CREATE TABLE CreateEmailMessage (
    EmailMessageId INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    loginID VARCHAR(30) NOT NULL,
    password INT(10),
    threats VARCHAR(50),
    createdDateTime INT(10),
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- Create an index for the 'name' column in 'CreateEmailMessage' table
CREATE INDEX idx_name ON CreateEmailMessage(name);

-- Create the 'ReceiveEmailMessage' table
CREATE TABLE ReceiveEmailMessage (
    ReceiveEmailMessageId INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(30),
    description VARCHAR(50),
    CreatedDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- Create an index for the 'title' column in 'ReceiveEmailMessage' table
CREATE INDEX idx_title ON ReceiveEmailMessage(title);


-- Create the 'CreateEmailMessage_ReceiveEmailMessage' relationship table
CREATE TABLE  CreateEmailMessage_ReceiveEmailMessage (
    CreateReceiveEmailMessageId INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ReceiveEmailMessageId INT(11) UNSIGNED,
    CreateEmailMessageId INT(11) UNSIGNED,

    INDEX fk_ReceiveEmailMessage_idx (ReceiveEmailMessageId),
    INDEX fk_CreateEmailMessage_idx (CreateEmailMessageId),

    FOREIGN KEY (ReceiveEmailMessageId) REFERENCES ReceiveEmailMessage(ReceiveEmailMessageId),
    FOREIGN KEY (CreateEmailMessageId) REFERENCES CreateEmailMessage(EmailMessageId)
);




-- Add any other SQL statements, data inserts, or modifications as needed
