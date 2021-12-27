---
sidebar_position: 1
---

# Installation

1. Install badaso first. After that, you can install the module with the following command.

```bash
composer require badaso/commerce-module
```

2. Run the following command to easily setup the module.

```bash
php artisan migrate
php artisan badaso-commerce:setup
composer dump-autoload
php artisan db:seed --class=BadasoCommerceModuleSeeder
```

3. Add the plugins to your `MIX_BADASO_MODULES` to `.env`. If you have another plugins installed, include them using delimiter comma (,).

```
MIX_BADASO_MODULES=commerce-module
```

4. Add the plugins menu to your `MIX_BADASO_MENU` to `.env`. If you have another menu, include them using delimiter comma (,).

```
MIX_BADASO_MENU=admin,commerce-module
```

5. Fill the other variables in .env file.
    - `COMMERCE_PRODUCTS_LIMIT_QUERY=10` Limit query browse on product, default is 10.
    - `MIX_PAYMENT_MODULE=commerce-module` Register the payment module.

6. Fill the payment config in `badaso-commerce.php`. For example:
    - `'payments' => ['Uasoft\Badaso\Module\Commerce\BadasoCommerceModule']`

7. Install the [commerce theme](https://github.com/uasoft-indonesia/badaso-commerce-theme)