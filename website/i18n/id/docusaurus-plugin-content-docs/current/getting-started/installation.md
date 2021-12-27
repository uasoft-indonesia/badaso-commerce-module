---
sidebar_position: 1
---

# Installation

1. Instal badaso dulu. Setelah itu, Anda dapat menginstal modul dengan perintah berikut.

```bash
composer require badaso/commerce-module
```

2. Jalankan perintah berikut untuk mengatur modul dengan mudah.

```bash
php artisan migrate
php artisan badaso-commerce:setup
composer dump-autoload
php artisan db:seed --class=BadasoCommerceModuleSeeder
```

3. Tambahkan plugin ke `MIX_BADASO_MODULES` Anda ke `.env`. Jika Anda memiliki plugin lain yang diinstal, sertakan mereka menggunakan koma pembatas (,).

```
MIX_BADASO_MODULES=commerce-module
```

4. Tambahkan menu plugin ke `MIX_BADASO_MENU` Anda ke `.env`. Jika Anda memiliki menu lain, sertakan menu tersebut menggunakan koma pembatas (,).

```
MIX_BADASO_MENU=admin,commerce-module
```

5. Isi variabel lain dalam file .env.
    - `COMMERCE_PRODUCTS_LIMIT_QUERY=10` Limit query browse on product, default is 10.
    - `MIX_PAYMENT_MODULE=commerce-module` Register the payment module.

6. Isi konfigurasi pembayaran di `badaso-commerce.php`. Sebagai contoh:
    - `'payments' => ['Uasoft\Badaso\Module\Commerce\BadasoCommerceModule']`

7. Instal [commerce theme](https://github.com/uasoft-indonesia/badaso-commerce-theme)