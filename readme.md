# Installation

1. Clone this repository.
2. Duplicate and rename the ".env.examples" to ".env" located 
   inside the cloned repository.
3. Open the .env file, then add the these fields
   "MS_DB_HOST", "MS_DB_PORT", "MS_DB_DATABASE",
   "MS_DB_USERNAME", and "MS_DB_PASSWORD", then
   configure the following fields "APP_NAME", "APP_DEBUG",
   "DB_HOST", "DB_PORT", "DB_DATABASE", "DB_USERNAME", 
   "DB_PASSWORD", "MS_DB_HOST", "MS_DB_PORT", "MS_DB_DATABASE",
   "MS_DB_USERNAME", and "MS_DB_PASSWORD"
   
   example:
   
   ```
   APP_NAME=Laravel
   APP_DEBUG=false

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=dostdtr
   DB_USERNAME=dostdtr
   DB_PASSWORD=dostdtr
   
   MS_DB_HOST=127.0.0.1
   MS_DB_PORT=1433
   MS_DB_DATABASE=biometrics
   MS_DB_USERNAME=dostdtr
   MS_DB_PASSWORD=dostdtr
   ```
   
 4. Run the following commands:
    
    ```
    composer install
    php artisan key:generate
    php artisan migrate:fresh --seed
    ```
    
5. Access the system and register the employees
6. Run this command "php artisan biometrics:sync all"
