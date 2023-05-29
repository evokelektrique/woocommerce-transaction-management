# WooCoommerce Transaction Management
TODO

# Build essentials

## Install dependencies
```
composer install && npm install

```

## Seeders
```
php artisan db:seed
```
## Commands 
List of usable commands or scheduled jobs
```
# Generate orders from WooCommerce's REST API
php artisan order:create

# Generate order accounts
php artisan order:account

# Will send a SMS / Email to orders contain expired accounts
php artisan account:proccess-expired

# Fetch orders notes through WooCommerce's REST API 
php artisan order:notes
```
