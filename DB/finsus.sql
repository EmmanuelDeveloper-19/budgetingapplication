CREATE TABLE users (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    balance DECIMAL(10, 2) NOT NULL DEFAULT 0.00
);

CREATE TABLE authentication (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,

    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,

    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    last_login DATETIME NULL,

    idUser BIGINT NOT NULL,

    CONSTRAINT fk_authentication_user
        FOREIGN KEY (idUser)
        REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE credit_cards (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,

    payment_date DATE NOT NULL,
    statement_closing_date DATE NOT NULL,

    credit_limit DECIMAL(12, 2) NOT NULL DEFAULT 0.00,
    outstanding_balance DECIMAL(12, 2) NOT NULL DEFAULT 0.00,

    bank VARCHAR(100) NOT NULL,

    user_id BIGINT NOT NULL,

    CONSTRAINT fk_credit_card_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE debit_cards (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,

    balance DECIMAL(12, 2) NOT NULL DEFAULT 0.00,

    bank VARCHAR(100) NOT NULL,

    user_id BIGINT NOT NULL,

    CONSTRAINT fk_debit_card_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE transactions (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(150) NOT NULL,

    type VARCHAR(50) NOT NULL,

    amount DECIMAL(12, 2) NOT NULL,

    payment_method VARCHAR(50) NOT NULL,

    description VARCHAR(500),

    user_id BIGINT NOT NULL,

    CONSTRAINT fk_transaction_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE transaction_debit (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,

    transaction_id BIGINT NOT NULL,
    debit_card_id BIGINT NOT NULL,

    CONSTRAINT fk_transaction_debit_transaction
        FOREIGN KEY (transaction_id)
        REFERENCES transactions(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT fk_transaction_debit_card
        FOREIGN KEY (debit_card_id)
        REFERENCES debit_cards(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE transaction_credit_card (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,

    transaction_id BIGINT NOT NULL,
    credit_card_id BIGINT NOT NULL,

    installments INT NOT NULL DEFAULT 1,

    status VARCHAR(50) NOT NULL DEFAULT 'PENDING',

    transaction_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_transaction_credit_card_transaction
        FOREIGN KEY (transaction_id)
        REFERENCES transactions(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT fk_transaction_credit_card_card
        FOREIGN KEY (credit_card_id)
        REFERENCES credit_cards(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE wishlists (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(150) NOT NULL,

    amount DECIMAL(12, 2) NOT NULL,

    status VARCHAR(50) NOT NULL DEFAULT 'PENDING',

    user_id BIGINT NOT NULL,

    CONSTRAINT fk_wishlist_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE contacts (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(150) NOT NULL,

    user_id BIGINT NOT NULL,

    CONSTRAINT fk_contact_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE debts (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,

    amount DECIMAL(12, 2) NOT NULL,

    contact_id BIGINT NOT NULL,

    user_id BIGINT NOT NULL,

    status VARCHAR(50) NOT NULL DEFAULT 'PENDING',

    debt_date DATE NOT NULL DEFAULT (CURRENT_DATE),

    interest DECIMAL(5, 2) NULL,

    due_date DATE NULL,

    term INT NULL,

    CONSTRAINT fk_debt_contact
        FOREIGN KEY (contact_id)
        REFERENCES contacts(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT fk_debt_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);