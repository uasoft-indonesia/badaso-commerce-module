<p align="center">
  <a href="https://badaso-docs.uatech.co.id/">
    <img src="https://i.ibb.co/L5tMztM/badaso-commerce-logo.png" width="150px" alt="Badaso logo" />
  </a>
</p>
<h3 align="center">badaso/commerce-module</h3>
<p align="center">Official e-commerce module for <a href="https://github.com/uasoft-indonesia/badaso">badaso</a></p>
<p align="center"><a href="https://badaso-demo.uatech.co.id/commerce" target="_blank">Try live demo</a></p>
<br />

<p align="center">
<a href="https://github.styleci.io/repos/347838630"><img src="https://github.styleci.io/repos/347838630/shield" alt="Badaso StyleCI"></a>
<a href="https://packagist.org/packages/uasoft-indonesia/badaso"><img src="https://img.shields.io/packagist/dt/badaso/core" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/uasoft-indonesia/badaso"><img src="https://img.shields.io/packagist/v/badaso/core" alt="Latest Stable Version"></a>
</p>

<p align="center">
  <a href="https://badaso-docs.uatech.co.id/">
    <img src="https://i.ibb.co/mTdhq0T/Screen-Shot-2021-12-08-at-22-47-51.png" alt="screencapture-badaso-dashboard-uatech-co-id-dashboard-crud-2021-03-17-09-57-08-1" />
  </a>
</p>

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
  - `MIX_PAYMENT_MODULE=commerce-module` Register the payment module.

- Fill the payment config in `badaso-commerce.php`. For example:
  - `'payments' => ['Uasoft\Badaso\Module\Commerce\BadasoCommerceModule']`

- Install the [commerce theme](https://github.com/uasoft-indonesia/badaso-commerce-theme)
