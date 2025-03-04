```shell
php artisan serve
```

```shell
php artisan make:filament-resource TaskTag --generate
```

```cron

* * * * * cd /var/www/laravel/ && php8.2 artisan schedule:run --env=production >> /dev/null 2>&1

```

```
pm2 start ecosystem.prod.config.cjs
```
