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
# Generate order accounts
php artisan order:account

# Change the order's status through WooCommerce's REST API
php artisan account:proccess-expired

# Generate orders notes
php artisan order:notes
```
