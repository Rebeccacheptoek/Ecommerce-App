# Application Setup and Deployment Guide

## Local Development Setup

### Prerequisites
- PHP 8.2 or higher
- Composer
- PostgreSQL 15
- Redis
- Node.js and npm
- Git

### Setting Up Local Environment

1. **Clone the Repository**
```bash
git clone https://github.com/Rebeccacheptoek/Ecommerce.git
cd Ecommerce
```

2. **Install PHP Dependencies**
```bash
composer install
```

3. **Environment Configuration**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configure Database**
Edit `.env` file with your PostgreSQL credentials:
```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=ecommerce
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. **Configure Redis**
Ensure Redis settings in `.env`:
```
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

6. **Run Migrations and Seeders**
```bash
php artisan migrate
php artisan db:seed
```

7. **Install Frontend Dependencies**
```bash
npm install
```

8. **Start Development Servers**
```bash
# Start Laravel server
php artisan serve

# In a separate terminal, start Vite development server
npm run dev
```

The application should now be running at `http://localhost:8000`

### Running Tests
```bash
php artisan test
```

## CI/CD Deployment

### GitHub Actions Setup

1. **Required Secrets**
Set up these secrets in your GitHub repository:
- `DB_PASSWORD`: The password for your PostgreSQL database
- `DB_USERNAME`: The username for your PostgreSQL database
- `REDIS_PASSWORD`: The password for Redis (if applicable)
- `APP_ENV`: Set to `production`
- `APP_KEY`: Your application key

2. **Workflow Configuration**
The CI/CD pipeline is configured in `.github/workflows/laravel.yml`. This file includes steps to:
- Set up the PHP environment
- Install dependencies using Composer
- Set up the database
- Run Laravel tests
- Deploy to the production server

### Workflow Steps

1. **Push to Main Branch**
```bash
git add .
git commit -m "Your commit message"
git pull origin main
git push origin main
```

2. **CI Pipeline Stages**
The GitHub Actions workflow will automatically:
- Set up PHP 8.2
- Install dependencies
- Configure environment variables using secrets
- Run tests
- Deploy if tests pass

### Deployment Configuration

1. **Environment Variables**
Ensure these are configured in your deployment environment:
```
APP_ENV=production
APP_DEBUG=false
APP_KEY=your_application_key
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=ecommerce
DB_USERNAME=your_username
DB_PASSWORD=your_password
REDIS_HOST=127.0.0.1
REDIS_PORT=6379
```

2. **Server Configuration**
- Ensure the server is running PHP 8.2 or higher.
- Install and configure PostgreSQL 15.
- Install and start Redis.
- Ensure Node.js and npm are installed for building frontend assets.

3. **Post-Deployment Commands**
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force
```

4. **Setting Up a Web Server**
Configure your web server (e.g., Nginx or Apache) to point to the `public` directory of the Laravel application. For example, an Nginx configuration might look like this:
```nginx
server {
    listen 80;
    server_name your_domain.com;

    root /path/to/your/project/public;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }
}
```