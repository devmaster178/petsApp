## About The Project
Amazing Pets is a Symfony application to process Pets registration.

## Getting Started

Make sure that you have docker installed on your pc.
- From the terminal, clone the repository with the following command.
  ```sh
    git clone https://github.com/devmaster178/pets-app.git
  ```
- Change to the project directory
  ```sh
    cd pets-app
  ```

- Open the `.env` file, and set your mysql database url, replace the `<?username>` and `<?password>` with your database username and password.   
  ```sh
    DATABASE_URL="mysql://<?username>:<?password>@db:3306/pets_app"
  ```
  
- Run this command to allow the `entrypoint.sh` file to be executable.
  ```sh
    chmod +x docker/php/entrypoint.sh
  ```
 
- Start the application 
  ```sh
    docker compose up -d --build
  ```
  
- Once the project is up, seed the database with default data. (select yes for all questions)
  ```sh
    docker compose exec php bin/console doctrine:fixtures:load
  ```
  
- Visit [http://localhost:8080/](http://localhost:8080/) on your browser.
  

## Testing
- Make sure the project is up and running on docker.
- Create the test database with this command:
  ```sh
  docker compose exec php bin/console --env=test doctrine:database:create
  ```
- Create all schemas and tables for the test environment with this command
  ```sh
    docker compose exec php bin/console --env=test doctrine:schema:create 
    ```
- Run the test.
  ```sh
    docker compose exec php bin/phpunit
  ```


