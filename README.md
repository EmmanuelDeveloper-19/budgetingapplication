# BudgetingApp

A custom PHP MVC web application designed for personal budget tracking, financial control, and account management. The system features dynamic multi-environment configuration (Development / Production), flexible routing, dynamic host detection for mobile testing, and JWT-based security.

---

## 📌 About the Project

**BudgetingApp** is a lightweight, high-performance MVC application built from scratch in PHP without heavy frameworks. It provides a structured, modular approach to managing personal finances, tracking budgets, and analyzing income vs. expenses.

### Key Objectives
* Complete control over personal accounts, budgets, and financial records.
* Flexible deployment across local network devices (e.g., testing via mobile IP) and production servers.
* Custom-built lightweight PHP MVC core for maximum speed and zero bloated dependencies.
* Robust database abstraction layer with support for Prepared Statements and MySQLi transactions.

---

## ✨ Features

### 🔐 Security & Authentication
* **JWT Authentication:** Secure token-based session handling using custom JWT signatures (`JWT_SECRET`).
* **Prepared Statements:** Protection against SQL Injection across all database interactions.
* **Environment Isolation:** Clear separation between development (`dev_`) and production settings.

### 💰 Financial Management
* **Budget Tracking:** Record, update, and monitor income and expense flows.
* **Prepared SQL Layer:** Native transaction handling (`beginTransaction`, `commit`, `rollback`).
* **Dynamic Network Binding:** Accessible seamlessly via `localhost`, local IP (`192.168.x.x`), or WAN IP.

---

## 🛠️ Tech Stack & Prerequisites

* **Language:** PHP 8.x
* **Database:** MySQL / MariaDB (`finsus_db` / `u529637583_sigodb23`)
* **Web Server:** Apache (XAMPP / WAMP / Linux Apache)
* **Extensions:** `mysqli`, `pcre`, `json`
* **Containerization:** Docker & Docker Compose

---

## 🏗️ Project Architecture (MVC)

The application follows a clean **Model-View-Controller (MVC)** architectural pattern:

```text
budgetingapp/
├── Controllers/         # Application logic & HTTP handling
│   └── UserController.php
├── Models/              # Data models & business logic
│   └── UserModel.php
├── Views/               # UI components & templates
├── core/                # System core files
│   ├── app.php          # Application router & bootstrap
│   ├── controller.php   # Base Controller class
│   └── db.php           # MySQLi Database wrapper class
├── includes/            # Reusable UI fragments (headers, footers)
├── public/              # Document root (CSS, JS, index.php)
│   ├── css/
│   ├── js/
│   └── index.php
├── configuration.ini    # Environment & database credentials
├── Dockerfile           # Apache PHP Docker image definition
├── docker-compose.yml   # Multi-container orchestrator (PHP + MySQL)
└── index.php            # Main entry point & constant definitions
```

### Layer Responsibilities

| Component | Layer | Description |
| :--- | :--- | :--- |
| `Controllers/` | **Controller** | Handles user requests, processes input, and renders Views or JSON. |
| `Models/` | **Model** | Encapsulates data logic and interacts with the `Db` class. |
| `Views/` | **View** | Displays data to the user using clean PHP/HTML templates. |
| `core/db.php` | **Database Layer** | Wraps `mysqli`, auto-detects hosts, and provides prepared statements. |
| `configuration.ini` | **Config** | Stores environment variables and credentials securely outside public directory. |

---

## 🔄 Application Flow

```text
User Request (HTTP GET/POST)
       │
       ▼
   public/index.php (Bootstrap & Constants)
       │
       ▼
   core/app.php (Router)
       │
       ▼
   Controllers/ (Execute Business Logic)
       │
       ├──► Models/ ──► core/db.php ──► MySQL Database
       │
       ▼
   Views/ (Render Response / Return JSON)
```

## ⚙️ Environment Configuration (`.env`)

The application uses **`vlucas/phpdotenv`** to manage environment variables. Create a `.env` file in the project root with the following configuration:

```env
APP_ENV=development

DB_HOST=127.0.0.1
DB_PORT=3306
DB_NAME=your_database
DB_USER=your_username
DB_PASSWORD=
```

The environment variables are loaded during application startup and are used to configure the database connection.

> **Security Note:** Never commit your `.env` file to version control. Instead, include a `.env.example` file with placeholder values and add `.env` to your `.gitignore`.

> **Network Note:** MySQL database connections remain bound to the local loopback interface (`127.0.0.1`), while Apache can serve requests from other devices on the local network (e.g., `192.168.x.x`).

## 🚀 How to Run the Project

### Option A: Local Apache/XAMPP Setup

1. **Clone the repository:**
   ```bash
   git clone https://github.com/EmmanuelDeveloper-19/budgetingapp.git
   cd budgetingapp
   ```

2. **Configure Database:**
   Import your database schema into MySQL:
   ```sql
   CREATE DATABASE your_db CHARACTER SET utf8 COLLATE utf8_general_ci;
   ```

3. **Configure Environment Variables:**
   Copy `.env.example` to `.env` and update the database credentials and other required environment variables for your local development environment.

4. **Access the application:**
   Open your browser and navigate to:
   ```text
   http://localhost/budgetingapp/aplicacion/public/
   ```
   Or access from a mobile device on the same network:
   ```text
   http://192.168.1.XX/budgetingapp/aplicacion/public/
   ```

---

### Option B: Docker Deployment 🐳

You can run the entire environment (PHP 8.2 Apache + MySQL 8.0) using Docker and Docker Compose.

#### 1. `Dockerfile`
Create a `Dockerfile` in the root folder:

```dockerfile
FROM php:8.2-apache

# Install MySQLi extension
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Enable Apache Mod Rewrite
RUN a2enmod rewrite

# Copy application files
COPY . /var/www/html/budgetingapp

# Set permissions
RUN chown -R www-data:www-data /var/www/html/budgetingapp
```

#### 2. `docker-compose.yml`
Create a `docker-compose.yml` file:

```yaml
version: '3.8'

services:
  web:
    build: .
    container_name: budgetingapp_web
    ports:
      - "8080:80"
    volumes:
      - .:/var/www/html/budgetingapp
    depends_on:
      - db

  db:
    image: mysql:8.0
    container_name: budgetingapp_db
    restart: always
    environment:
      MYSQL_ROOT_PASSWORD: root_password
      MYSQL_DATABASE: db
    ports:
      - "3306:3306"
    volumes:
      - db_data:/var/lib/mysql

volumes:
  db_data:
```

#### 3. Run with Docker Compose

```bash
docker-compose up -d --build
```

Access the app via: `http://localhost:8080/budgetingapp/aplicacion/public/`

---

## 💡 Key Architectural Highlight: Dynamic Host Handling

The core database class dynamically inspects `$_SERVER['HTTP_HOST']` to seamlessly toggle between local development settings and production configurations without requiring manual code changes when switching environments:

```php
$host = $_SERVER['HTTP_HOST'] ?? '';
if ($host === 'localhost' || $host === '127.0.0.1' || strpos($host, '192.168.') === 0) {
    $prefix = "dev_";
}
```

---

## 📈 Future Roadmap

- [ ] Add interactive dashboard charts (Chart.js).
- [ ] Implement automated recurring transactions.
- [ ] Multi-currency support.
- [ ] Export transactions to CSV / PDF.
- [ ] REST API endpoints for native mobile app integration.

---

## 👤 Author

**Jose Emmanuel Reyes Hernandez**

* **GitHub:** [@EmmanuelDeveloper-19](https://github.com/EmmanuelDeveloper-19)
* **LinkedIn:** [Jose Emmanuel Reyes Hernández](https://www.linkedin.com/in/jose-emmanuel-reyes-hern%C3%A1ndez-589226305/)

---

## 📄 License

This project is open-source and available under the [MIT License](LICENSE).
