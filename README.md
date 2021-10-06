# badaso/commerce-module
e-commerce system for badaso.

## Installation
- Install badaso first. After that, you can install the module with the following command.

```bash
composer require badaso/commerce-module
```

- Run the following command to easily setup the module.

```bash
php artisan migrate
php artisan badaso-commerce:setup
composer dump-autoload
php artisan db:seed --class=BadasoCommerceModuleSeeder
```

- Add the plugins to your `MIX_BADASO_MODULES` to `.env`. If you have another plugins installed, include them using delimiter comma (,).

```
MIX_BADASO_MODULES=commerce-module
```

- Add the plugins menu to your `MIX_BADASO_MENU` to `.env`. If you have another menu, include them using delimiter comma (,).

```
MIX_BADASO_MENU=admin,commerce-module
```

- Fill the other variables in .env file.
  - `COMMERCE_PRODUCTS_LIMIT_QUERY=10` Limit query browse on product, default is 10.

