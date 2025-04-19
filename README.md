# Titan Inspeksi Unit

## Table of Contents

-   [Installation](#installation)

## Installation

To get started with Titan Inspeksi Unit, follow these steps:

1. Clone the repository:
    ```bash
    git clone git@github.com:rheznendra/titan-inspeksi-unit.git inspeksi-unit
    ```
2. Navigate to the project directory:
    ```bash
    cd inspeksi-unit
    ```
3. Install composer requirement
    ```bash
    composer install
    ```
4. Copy .env && generate APP_KEY
    ```bash
    cp .env.copy .env
    ```
    ```bash
    php artisan key:generate
    ```
5. Install the dependencies:
    ```bash
    npm install
    ```
6. Build the dependencies\

    on Local

    ```bash
    npm run dev
    ```

    or Production

    ```bash
    npm run build
    ```

7. Setup Database on ENV
    ```bash
    DB_CONNECTION=mysql
    DB_HOST=DB_HOST
    DB_PORT=DB_PORT
    DB_DATABASE=DB_NAME
    DB_USERNAME=DB_USER
    DB_PASSWORD=DB_PASSWORD
    ```
8. Migrate database & default data for table `question`
    ```bash
    php artisan migrate --seed
    ```
9. Done, all setup!
