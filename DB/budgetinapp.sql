CREATE TABLE authentication (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE user_profiles (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    nombre VARCHAR(100),
    apellido VARCHAR(100),
    telefono VARCHAR(20),
    fecha_nacimiento DATE,
    balance DECIMAL(10,2) DEFAULT 0.00,
    CONSTRAINT fk_user_profile
        FOREIGN KEY (user_id)
        REFERENCES authentication(id)
        ON DELETE CASCADE
);

CREATE TABLE credit_cards (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    banco VARCHAR(100) NOT NULL,

    dia_corte TINYINT UNSIGNED NOT NULL,
    dia_pago  TINYINT UNSIGNED NOT NULL,

    balance_total DECIMAL(12,2) DEFAULT 0.00,
    deuda DECIMAL(12,2) DEFAULT 0.00,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_credit_user
        FOREIGN KEY (user_id)
        REFERENCES authentication(id)
        ON DELETE CASCADE,

    CONSTRAINT chk_dia_corte CHECK (dia_corte BETWEEN 1 AND 31),
    CONSTRAINT chk_dia_pago  CHECK (dia_pago BETWEEN 1 AND 31)
);


CREATE TABLE debit_cards (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    banco VARCHAR(100) NOT NULL,
    balance DECIMAL(12,2) DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_debit_user
        FOREIGN KEY(user_id)
        REFERENCES authentication(id)
        ON DELETE CASCADE
);

CREATE TABLE subscriptions (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    monto DECIMAL(10,2) NOT NULL,
    plazo ENUM('mensual', 'anual') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_subscription_user
        FOREIGN KEY (user_id)
        REFERENCES authentication(id)
        ON DELETE CASCADE
);

CREATE TABLE expenses (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    monto DECIMAL(10,2) NOT NULL,
    tipo VARCHAR(50) NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pendiente', 'pagado', 'cancelado') DEFAULT 'pendiente',
    metodo_pago VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_expense_user
        FOREIGN KEY (user_id)
        REFERENCES authentication(id)
        ON DELETE CASCADE
);

CREATE TABLE credit_card_subscription (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    credit_card_id INT UNSIGNED NOT NULL,
    subscription_id INT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_credit_user FOREIGN KEY (user_id) 
        REFERENCES authentication(id) ON DELETE CASCADE,
    CONSTRAINT fk_credit_card FOREIGN KEY (credit_card_id) 
        REFERENCES credit_cards(id) ON DELETE CASCADE,
    CONSTRAINT fk_credit_subscription FOREIGN KEY (subscription_id) 
        REFERENCES subscriptions(id) ON DELETE CASCADE,
    INDEX idx_credit_user (user_id),
    INDEX idx_credit_card (credit_card_id),
    INDEX idx_credit_subscription (subscription_id)
);

CREATE TABLE debit_card_subscription (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    debit_card_id INT UNSIGNED NOT NULL,
    subscription_id INT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_debit_user FOREIGN KEY (user_id) 
        REFERENCES authentication(id) ON DELETE CASCADE,
    CONSTRAINT fk_debit_card FOREIGN KEY (debit_card_id) 
        REFERENCES debit_cards(id) ON DELETE CASCADE,
    CONSTRAINT fk_debit_subscription FOREIGN KEY (subscription_id) 
        REFERENCES subscriptions(id) ON DELETE CASCADE,
    INDEX idx_debit_user (user_id),
    INDEX idx_debit_card (debit_card_id),
    INDEX idx_debit_subscription (subscription_id)
);
