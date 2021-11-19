<?php

use Illuminate\Support\Facades\Route;
use Uasoft\Badaso\Middleware\ApiRequest;
use Uasoft\Badaso\Middleware\BadasoAuthenticate;
use Uasoft\Badaso\Middleware\BadasoCheckPermissions;

$api_route_prefix = \config('badaso.api_route_prefix');

Route::group(['prefix' => $api_route_prefix, 'namespace' => 'Uasoft\Badaso\Module\Commerce\Controllers', 'as' => 'badaso.', 'middleware' => [ApiRequest::class]], function () {
    Route::group(['prefix' => 'module/commerce/v1'], function () {
        Route::group(['prefix' => 'product'], function () {
            Route::get('/', 'ProductController@browse')->middleware(BadasoCheckPermissions::class.':browse_products');
            Route::get('/bin', 'ProductController@browseBin')->middleware(BadasoCheckPermissions::class.':browse_products_bin');
            Route::get('/read', 'ProductController@read')->middleware(BadasoCheckPermissions::class.':read_products');
            Route::get('/read-slug', 'ProductController@readBySlug')->middleware(BadasoCheckPermissions::class.':read_products');
            Route::post('/restore', 'ProductController@restore')->middleware(BadasoCheckPermissions::class.':restore_products');
            Route::post('/restore-multiple', 'ProductController@restoreMultiple')->middleware(BadasoCheckPermissions::class.':restore_products');
            Route::post('/add', 'ProductController@add')->middleware(BadasoCheckPermissions::class.':add_products');
            Route::put('/edit', 'ProductController@edit')->middleware(BadasoCheckPermissions::class.':edit_products');
            Route::delete('/delete', 'ProductController@delete')->middleware(BadasoCheckPermissions::class.':delete_products');
            Route::delete('/delete-multiple', 'ProductController@deleteMultiple')->middleware(BadasoCheckPermissions::class.':delete_products');
            Route::delete('/force-delete', 'ProductController@forceDelete')->middleware(BadasoCheckPermissions::class.':delete_permanent_products');
            Route::delete('/force-delete-multiple', 'ProductController@forceDeleteMultiple')->middleware(BadasoCheckPermissions::class.':delete_permanent_products');
        });

        Route::group(['prefix' => 'product-detail'], function () {
            Route::post('/add', 'ProductDetailController@add')->middleware(BadasoCheckPermissions::class.':add_product_details');
            Route::put('/edit', 'ProductDetailController@edit')->middleware(BadasoCheckPermissions::class.':edit_product_details');
            Route::delete('/delete', 'ProductDetailController@delete')->middleware(BadasoCheckPermissions::class.':delete_product_details');
        });

        Route::group(['prefix' => 'product-category'], function () {
            Route::get('/', 'ProductCategoryController@browse')->middleware(BadasoCheckPermissions::class.':browse_product_categories');
            Route::get('/bin', 'ProductCategoryController@browseBin')->middleware(BadasoCheckPermissions::class.':browse_product_categories_bin');
            Route::get('/read', 'ProductCategoryController@read')->middleware(BadasoCheckPermissions::class.':read_product_categories');
            Route::get('/read-slug', 'ProductCategoryController@readBySlug')->middleware(BadasoCheckPermissions::class.':read_product_categories');
            Route::post('/restore', 'ProductCategoryController@restore')->middleware(BadasoCheckPermissions::class.':restore_product_categories');
            Route::post('/restore-multiple', 'ProductCategoryController@restoreMultiple')->middleware(BadasoCheckPermissions::class.':restore_product_categories');
            Route::post('/add', 'ProductCategoryController@add')->middleware(BadasoCheckPermissions::class.':add_product_categories');
            Route::put('/edit', 'ProductCategoryController@edit')->middleware(BadasoCheckPermissions::class.':edit_product_categories');
            Route::delete('/delete', 'ProductCategoryController@delete')->middleware(BadasoCheckPermissions::class.':delete_product_categories');
            Route::delete('/delete-multiple', 'ProductCategoryController@deleteMultiple')->middleware(BadasoCheckPermissions::class.':delete_product_categories');
            Route::delete('/force-delete', 'ProductCategoryController@forceDelete')->middleware(BadasoCheckPermissions::class.':delete_permanent_product_categories');
            Route::delete('/force-delete-multiple', 'ProductCategoryController@forceDeleteMultiple')->middleware(BadasoCheckPermissions::class.':delete_permanent_product_categories');
        });

        Route::group(['prefix' => 'discount'], function () {
            Route::get('/', 'DiscountController@browse')->middleware(BadasoCheckPermissions::class.':browse_discounts');
            Route::get('/bin', 'DiscountController@browseBin')->middleware(BadasoCheckPermissions::class.':browse_discounts_bin');
            Route::get('/read', 'DiscountController@read')->middleware(BadasoCheckPermissions::class.':read_discounts');
            Route::post('/restore', 'DiscountController@restore')->middleware(BadasoCheckPermissions::class.':restore_discounts');
            Route::post('/restore-multiple', 'DiscountController@restoreMultiple')->middleware(BadasoCheckPermissions::class.':restore_discounts');
            Route::post('/add', 'DiscountController@add')->middleware(BadasoCheckPermissions::class.':add_discounts');
            Route::put('/edit', 'DiscountController@edit')->middleware(BadasoCheckPermissions::class.':edit_discounts');
            Route::delete('/delete', 'DiscountController@delete')->middleware(BadasoCheckPermissions::class.':delete_discounts');
            Route::delete('/delete-multiple', 'DiscountController@deleteMultiple')->middleware(BadasoCheckPermissions::class.':delete_discounts');
            Route::delete('/force-delete', 'DiscountController@forceDelete')->middleware(BadasoCheckPermissions::class.':delete_permanent_discounts');
            Route::delete('/force-delete-multiple', 'DiscountController@forceDeleteMultiple')->middleware(BadasoCheckPermissions::class.':delete_permanent_discounts');
        });

        Route::group(['prefix' => 'payment'], function () {
            Route::get('/', 'PaymentController@browse')->middleware(BadasoCheckPermissions::class.':browse_payments');
            Route::get('/read', 'PaymentController@read')->middleware(BadasoCheckPermissions::class.':read_payments');
            Route::post('/add', 'PaymentController@add')->middleware(BadasoCheckPermissions::class.':add_payments');
            Route::put('/edit', 'PaymentController@edit')->middleware(BadasoCheckPermissions::class.':edit_payments');
            Route::delete('/delete', 'PaymentController@delete')->middleware(BadasoCheckPermissions::class.':delete_payments');
            Route::get('/option', 'PaymentController@browseOption')->middleware(BadasoCheckPermissions::class.':browse_payment_options');
            Route::post('/option/add', 'PaymentController@addOption')->middleware(BadasoCheckPermissions::class.':add_payment_options');
            Route::put('/option/edit', 'PaymentController@editOption')->middleware(BadasoCheckPermissions::class.':edit_payment_options');
            Route::delete('/option/delete', 'PaymentController@deleteOption')->middleware(BadasoCheckPermissions::class.':delete_payment_options');
            Route::put('/option/arrange', 'PaymentController@arrangeOption')->middleware(BadasoCheckPermissions::class.':edit_payment_options');

            Route::group(['prefix' => 'public'], function () {
                Route::get('/', 'PublicController\PaymentController@browse');
                Route::get('/read', 'PublicController\PaymentController@read');
            });
        });

        Route::group(['prefix' => 'order', 'middleware' => [BadasoAuthenticate::class]], function () {
            Route::get('/', 'OrderController@browse')->middleware(BadasoCheckPermissions::class.':browse_orders');
            Route::get('/read', 'OrderController@read')->middleware(BadasoCheckPermissions::class.':read_orders');
            Route::post('/confirm', 'OrderController@confirm')->middleware(BadasoCheckPermissions::class.':confirm_orders');
            Route::post('/reject', 'OrderController@reject')->middleware(BadasoCheckPermissions::class.':confirm_orders');
            Route::post('/ship', 'OrderController@ship')->middleware(BadasoCheckPermissions::class.':confirm_orders');
            Route::post('/done', 'OrderController@done')->middleware(BadasoCheckPermissions::class.':confirm_orders');
        });

        Route::group(['prefix' => 'cart'], function () {
            Route::get('/', 'CartController@browse')->middleware(BadasoCheckPermissions::class.':browse_carts');
            Route::get('/read', 'CartController@read')->middleware(BadasoCheckPermissions::class.':read_carts');
        });

        Route::group(['prefix' => 'user-address'], function () {
            Route::get('/', 'UserAddressController@browse')->middleware(BadasoCheckPermissions::class.':browse_user_addresses');
            Route::get('/read', 'UserAddressController@read')->middleware(BadasoCheckPermissions::class.':read_user_addresses');
        });

        Route::group(['prefix' => 'review', 'middleware' => [BadasoAuthenticate::class]], function () {
            Route::get('/', 'ReviewController@browse')->middleware(BadasoCheckPermissions::class.':browse_product_reviews');
            Route::get('/read', 'ReviewController@read')->middleware(BadasoCheckPermissions::class.':read_product_reviews');
            Route::delete('/delete', 'ReviewController@delete')->middleware(BadasoCheckPermissions::class.':delete_product_reviews');
        });

        Route::group(['prefix' => 'product/public'], function () {
            Route::get('/', 'PublicController\ProductController@browse');
            Route::get('/browse-category-slug', 'PublicController\ProductController@browseByCategorySlug');
            Route::get('/browse-similar', 'PublicController\ProductController@browseSimilar');
            Route::get('/read', 'PublicController\ProductController@read');
            Route::get('/read-by-cart', 'PublicController\ProductController@readSimple');
            Route::get('/search', 'PublicController\ProductController@search');
            Route::get('/best-selling', 'PublicController\ProductController@browseBestSellingProduct');
        });

        Route::group(['prefix' => 'product-category/public'], function () {
            Route::get('/', 'PublicController\ProductCategoryController@browse');
            Route::get('/read', 'PublicController\ProductCategoryController@read');
        });

        Route::group(['prefix' => 'cart/public', 'middleware' => [BadasoAuthenticate::class]], function () {
            Route::get('/', 'PublicController\CartController@browse');
            Route::post('/add', 'PublicController\CartController@add');
            Route::put('/edit', 'PublicController\CartController@edit');
            Route::put('/edit-cart', 'PublicController\CartController@editCart');
            Route::delete('/delete', 'PublicController\CartController@delete');
            Route::post('/validate', 'PublicController\CartController@validate');
        });

        Route::group(['prefix' => 'order/public', 'middleware' => [BadasoAuthenticate::class]], function () {
            Route::get('/', 'PublicController\OrderController@browse');
            Route::get('/read', 'PublicController\OrderController@read');
            Route::post('/pay', 'PublicController\OrderController@pay');
            Route::post('/finish', 'PublicController\OrderController@finish');
        });

        Route::group(['prefix' => 'review/public'], function () {
            Route::get('/', 'PublicController\ReviewController@browse');
            Route::post('/submit', 'PublicController\ReviewController@submit');
            Route::get('/read', 'PublicController\ReviewController@read');
        });

        Route::group(['prefix' => 'user-address/public', 'middleware' => [BadasoAuthenticate::class]], function () {
            Route::get('/', 'PublicController\UserAddressController@browse');
            Route::get('/read', 'PublicController\UserAddressController@read');
            Route::post('/add', 'PublicController\UserAddressController@add');
            Route::put('/edit', 'PublicController\UserAddressController@edit');
            Route::delete('/delete', 'PublicController\UserAddressController@delete');
            Route::post('/main', 'PublicController\UserAddressController@setMain');
        });

        Route::group(['prefix' => 'user/public', 'middleware' => [BadasoAuthenticate::class]], function () {
            Route::put('/edit', 'PublicController\UserController@edit');
            Route::post('/change', 'PublicController\UserController@changePassword');
        });

        Route::group(['prefix' => 'notification/public', 'middleware' => [BadasoAuthenticate::class]], function () {
            Route::get('/', 'PublicController\NotificationController@browse');
            Route::post('/read', 'PublicController\NotificationController@read');
            Route::post('/read-all', 'PublicController\NotificationController@readAll');
        });

        Route::group(['prefix' => 'configurations', 'middleware' => [BadasoAuthenticate::class]], function () {
            Route::put('/edit', 'ConfigurationController@edit')->middleware(BadasoCheckPermissions::class.':edit_configurations');
            Route::put('/edit-multiple', 'ConfigurationController@editMultiple')->middleware(BadasoCheckPermissions::class.':edit_configurations');
            Route::post('/add', 'ConfigurationController@add')->middleware(BadasoCheckPermissions::class.':add_configurations');
            Route::delete('/delete', 'ConfigurationController@delete')->middleware(BadasoCheckPermissions::class.':delete_configurations');
        });

        Route::group(['prefix' => 'configurations'], function () {
            Route::get('/', 'ConfigurationController@browse');
            Route::get('/read', 'ConfigurationController@read');
        });
    });
});
