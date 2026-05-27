# Setup

Clone into `laragon\www\`.

Open `cmder` from Laragon and `cd` into `laragon\www\bankapp_php`.

Run `composer dump-autoload`.

Create the database you want to use for this application. Edit the `config.php` file found in `/src` with your
credentials and database connection.

`cd` into `bankapp_php\src` and run `php setup.php`. This will delete the database if it exists,
create a new database using the config from `config.php` and finally seed the database.

If you instead wish to manually create the database using the schema it can be found in `src/schema.sql`.
You can then run `php setup.php seed` to only seed the database.

### Option 1: Laragon with Apache

Right-click on the Laragon window and select `Apache->sites-enabled->auto.bankapp.test.conf` (If you can't see this
option try and reload apache).

In the config change the document root and directory from `laragon/www/bankapp_php/` to
`laragon/www/bankapp_php/src/public`.

If Apache is still running you should now be able to access the site through `www.bankapp_php.test`.

### Option 2: Laragon with PHP built-in server

Open `cmder` from Laragon and cd into `laragon\www\bankapp_php\` and run `php -S localhost:8000 -t public`.
The website should now be available on `localhost:8000`.

# Usage

### Users:

| ID | Name         | Role  | Card Number | PIN  |
|:---|:-------------|:------|:------------|:-----|
| 1  | John User    | user  | 1234        | 1234 |
| 2  | Joe Admin    | admin | 4321        | 4321 |
| 3  | John User Jr | user  | 1212        | 1212 |

### Admin functionality

The admin panel has 3 different tabs to display Users, Accounts and Transactions.
All tables are paginated and the transaction table allows for filtering by start date,
end date as well as transaction type.

From the user tab you can manage users. To create a new user press the "Skapa ny användare"-button
above the user table. To edit and delete existing users press the "Redigera"-button or the "Ta bort"-button.

# Schema

```mysql
CREATE TABLE Users
(
    id          INT PRIMARY KEY AUTO_INCREMENT,
    card_number VARCHAR(16)  NOT NULL UNIQUE,
    pin_hash    VARCHAR(255) NOT NULL,
    name        VARCHAR(255) NOT NULL,
    role        VARCHAR(50)  NOT NULL,
    created_at  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE Accounts
(
    id           INT PRIMARY KEY AUTO_INCREMENT,
    user_id      INT         NOT NULL,
    account_type VARCHAR(50) NOT NULL,
    created_at   TIMESTAMP   NOT NULL DEFAULT CURRENT_TIMESTAMP,

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
```