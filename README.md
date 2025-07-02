## 🐾 Amazing Pets

**Amazing Pets** is a Symfony-based web application designed to manage and process pet registrations efficiently.

## 📦 Getting Started

### ✅ Prerequisites

Make sure you have the following installed:

- [Docker](https://www.docker.com/)

### 🚀 Installation

Follow the steps below to set up the application locally:

1. **Clone the repository**
   ```bash
      git clone https://github.com/devmaster178/petsApp.git
   ```
2. **Navigate to the project directory**
    ```bash
       cd petsApp
    ```
3. **Configure environment variables**

   Open the .env file and update the database URL. Replace <?username> and <?password> with your MySQL credentials:   
   ```bash
      DATABASE_URL="mysql://<?username>:<?password>@db:3306/pets_app"
   ```
4. **Make the entrypoint script executable**
   ```bash
      chmod +x docker/php/entrypoint.sh
   ```
 
5. **Start the application using Docker** 
   ```bash
      docker compose up -d --build
   ```

6. **Seed the database**

   Load default data into the database. Select "yes" for all prompts:
   ```bash
      docker compose exec php bin/console doctrine:fixtures:load
   ```
7. **Access the application**  
   Open your browser and visit:  [http://localhost:8080/](http://localhost:8080/)
  

## 🧪 Running Tests
To execute the test suite, follow the steps below:
1. Ensure the Docker containers are running.
2. **Create the test database**
   ```bash
      docker compose exec php bin/console --env=test doctrine:database:create
   ```
3. **Create the test schema**   
   ```bash
      docker compose exec php bin/console --env=test doctrine:schema:create
   ```
4. **Run PHPUnit tests**
   ```bash
      docker compose exec php bin/phpunit
   ```
   
## 📂 Project Structure
```angular2html
    petsApp/
    ├── docker/             # Docker-related configurations
    ├── src/                # Symfony source files
    ├── tests/              # PHPUnit test files
    ├── .env                # Environment configuration
    └── ...
```

## 🛠️ Technologies Used
- PHP
- Symfony
- Docker
- MySQL
- PHPUnit

## 🙋‍♂️ Contributing
  Contributions are welcome! Please fork the repository and submit a pull request.

