news-aggregator-be/
```
├── docker/
│   ├── nginx/
│   │   ├── nginx.conf
│   │   └── default.conf
│   └── php/
│       ├── Dockerfile
│       └── laravel-pool.conf
└── docker-compose.yml
```

## Configuration Files

- **PHP-FPM Dockerfile**
    - Base image: PHP 8.3-FPM
    - Installs system dependencies and PHP extensions
    - Configures PHP-FPM pool
    - Sets up Composer
    - Sets proper permissions

## Nginx Configuration

- **Main config (nginx.conf)**
    - Basic server settings
- **Site config (default.conf)**
    - Laravel-specific settings
    - PHP-FPM socket communication
    - Static file handling

## PHP-FPM Pool Configuration

- Process management settings
- Socket configuration
- Resource limits
- Security settings

## Deployment Instructions

### 1. Build Images
To build the Docker images for the application, run the following command in the root directory of your project:
```sh
docker compose build
```

### 2. Start Services
After building the images, start the services using:
```sh
docker compose up -d
```
This command will start all the services defined in the `docker-compose.yml` file in detached mode.

### 3. Initialize Laravel
Once the services are up and running, you need to initialize Laravel. Execute the following commands to set up the application:
```sh
# Enter the app container
docker compose exec app bash

# Run database migrations
php artisan migrate
```

### Accessing the Application
You can access the Laravel application in your web browser at:
```
http://localhost:8090
```
This URL points to the Nginx server which serves the Laravel application.

