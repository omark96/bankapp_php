CREATE DATABASE IF NOT EXISTS bankapp_olle;

DROP TABLE IF EXISTS Transactions;
DROP TABLE IF EXISTS Accounts;
DROP TABLE IF EXISTS Users;

CREATE TABLE Users
(
    id          INT PRIMARY KEY AUTO_INCREMENT,
    card_number VARCHAR(16)  NOT NULL UNIQUE,
    pin_hash    VARCHAR(255) NOT NULL,
    name        VARCHAR(255) NOT NULL,
    role        VARCHAR(50)  NOT NULL,
    deleted     BOOL         NOT NULL DEFAULT FALSE,
    created_at  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE Accounts
(
    id           INT PRIMARY KEY AUTO_INCREMENT,
    user_id      INT         NOT NULL,
    account_type VARCHAR(50) NOT NULL,
    created_at   TIMESTAMP   NOT NULL DEFAULT CURRENT_TIMESTAMP,
    deleted      BOOL        NOT NULL DEFAULT FALSE,

    FOREIGN KEY (user_id) REFERENCES Users (id)
);

CREATE TABLE Transactions
(
    id              INT PRIMARY KEY AUTO_INCREMENT,
    from_account_id INT         NULL,
    to_account_id   INT         NULL,
    type            VARCHAR(50) NOT NULL,
    amount          REAL        NOT NULL,
    created_at      TIMESTAMP   NOT NULL DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (from_account_id) REFERENCES Accounts (id),
    FOREIGN KEY (to_account_id) REFERENCES Accounts (id)
)

