<?php

namespace Uasoft\Badaso\Module\Commerce\Tests\Feature;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;
use Uasoft\Badaso\Helpers\CallHelperTest;
use Uasoft\Badaso\Models\User;
use Uasoft\Badaso\Module\Commerce\Models\Cart;
use Uasoft\Badaso\Module\Commerce\Models\Discount;
use Uasoft\Badaso\Module\Commerce\Models\Product;
use Uasoft\Badaso\Module\Commerce\Models\ProductCategory;
use Uasoft\Badaso\Module\Commerce\Models\ProductDetail;

class BadasoCommerceApiCartTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testInitStart()
    {
        CallHelperTest::handleUserAdminAuthorize($this);
    }

    public function testBrowseCart()
    {
        $product_category = ProductCategory::create([
            'name' => 'coba 1',
            'slug' => Str::uuid(),
            'desc' => 'decription 1',
            'SKU'  => Str::uuid(),
        ]);
        $product_category_id = $product_category->id;
        $product = Product::create([
            'product_category_id' => $product_category_id,
            'name' => 'product 1',
            'slug' => Str::uuid(),
            'product_image' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.pexels.com%2Fsearch%2Fvideos%2Faesthetic%2520background%2F&psig=AOvVaw3LzeH9UjT1mVGsd0J9-XTu&ust=1644482935889000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCKC0grye8vUCFQAAAAAdAAAAABAP',
            'desc' => 'description tes product',
        ]);
        $product_id = $product->id;
        $discounts = Discount::create([
            'name' => 'New Year Discount',
            'desc' => '',
            'discount_type' => 'fixed',
            'discount_percent' => 0,
            'discount_fixed' => 10000,
            'active' => 1,
        ]);
        $discount_id = $discounts->id;
        $product_detail = ProductDetail::create([
            'product_id' => $product_id,
            'discount_id'=> $discount_id,
            'name' => 'name test 2',
            'quantity'  => 13,
            'price' => '1000001',
            'SKU' => Str::uuid(),
            'product_image' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.pexels.com%2Fsearch%2Fvideos%2Faesthetic%2520background%2F&psig=AOvVaw3LzeH9UjT1mVGsd0J9-XTu&ust=1644482935889000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCKC0grye8vUCFQAAAAAdAAAAABAP',

        ]);
        $product_detail_id = $product_detail->id;
        $name = Str::uuid();
        $user = User::create([
            'name' => $name,
            'username' => $name,
            'email' => $name.'@mail.com',
            'password' => Hash::make('secret'),
            'avatar' => 'photos/shares/default-user.png',
            'additional_info' => null,
        ]);
        $user_id = $user->id;
        $cart = Cart::create([
            'user_id' => $user_id,
            'product_detail_id' => $product_detail_id,
            'quantity' => 3,
        ]);
        $cart_count = Cart::all()->count();
        $response = CallHelperTest::withAuthorizeBearer($this)->json('GET', '/badaso-api/module/commerce/v1/cart', [
            'page' => 1,
            'limit' => $cart_count,
        ]);
        $response->assertSuccessful();
        $cart->delete($response->assertSuccessful());
    }

    public function testReadCart()
    {
        $product_category = ProductCategory::create([
            'name' => 'coba 1',
            'slug' => Str::uuid(),
            'desc' => 'decription 1',
            'SKU'  => Str::uuid(),
        ]);
        $product_category_id = $product_category->id;
        $product = Product::create([
            'product_category_id' => $product_category_id,
            'name' => 'product 1',
            'slug' => Str::uuid(),
            'product_image' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.pexels.com%2Fsearch%2Fvideos%2Faesthetic%2520background%2F&psig=AOvVaw3LzeH9UjT1mVGsd0J9-XTu&ust=1644482935889000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCKC0grye8vUCFQAAAAAdAAAAABAP',
            'desc' => 'description tes product',
        ]);
        $product_id = $product->id;
        $discounts = Discount::create([
            'name' => 'New Year Discount',
            'desc' => '',
            'discount_type' => 'fixed',
            'discount_percent' => 0,
            'discount_fixed' => 10000,
            'active' => 1,
        ]);
        $discount_id = $discounts->id;
        $product_detail = ProductDetail::create([
            'product_id' => $product_id,
            'discount_id'=> $discount_id,
            'name' => 'name test 2',
            'quantity'  => 13,
            'price' => '1000001',
            'SKU' => Str::uuid(),
            'product_image' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.pexels.com%2Fsearch%2Fvideos%2Faesthetic%2520background%2F&psig=AOvVaw3LzeH9UjT1mVGsd0J9-XTu&ust=1644482935889000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCKC0grye8vUCFQAAAAAdAAAAABAP',

        ]);
        $product_detail_id = $product_detail->id;
        $name = Str::uuid();
        $user = User::create([
            'name' => $name,
            'username' => $name,
            'email' => $name.'@mail.com',
            'password' => Hash::make('secret'),
            'avatar' => 'photos/shares/default-user.png',
            'additional_info' => null,
        ]);
        $user_id = $user->id;
        $cart = Cart::create([
            'user_id' => $user_id,
            'product_detail_id' => $product_detail_id,
            'quantity' => 3,
        ]);
        $cart_id = $cart->id;
        $response = CallHelperTest::withAuthorizeBearer($this)->json('GET', '/badaso-api/module/commerce/v1/cart/read', [
            'id' => $cart_id,
        ]);
        $response->assertSuccessful();
        $cart->forceDelete();
        $user->forceDelete();
        $product_detail->forceDelete();
        $discounts->forceDelete();
        $product->forceDelete();
        $product_category->forceDelete();
    }

    public function testBrowseCartPublic()
    {
        $product_category = ProductCategory::create([
            'name' => 'coba 1',
            'slug' => Str::uuid(),
            'desc' => 'decription 1',
            'SKU'  => Str::uuid(),
        ]);
        $product_category_id = $product_category->id;
        $product = Product::create([
            'product_category_id' => $product_category_id,
            'name' => 'product 1',
            'slug' => Str::uuid(),
            'product_image' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.pexels.com%2Fsearch%2Fvideos%2Faesthetic%2520background%2F&psig=AOvVaw3LzeH9UjT1mVGsd0J9-XTu&ust=1644482935889000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCKC0grye8vUCFQAAAAAdAAAAABAP',
            'desc' => 'description tes product',
        ]);
        $product_id = $product->id;
        $discounts = Discount::create([
            'name' => 'New Year Discount',
            'desc' => '',
            'discount_type' => 'fixed',
            'discount_percent' => 0,
            'discount_fixed' => 10000,
            'active' => 1,
        ]);
        $discount_id = $discounts->id;
        $product_detail = ProductDetail::create([
            'product_id' => $product_id,
            'discount_id'=> $discount_id,
            'name' => 'name test 2',
            'quantity'  => 13,
            'price' => '1000001',
            'SKU' => Str::uuid(),
            'product_image' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.pexels.com%2Fsearch%2Fvideos%2Faesthetic%2520background%2F&psig=AOvVaw3LzeH9UjT1mVGsd0J9-XTu&ust=1644482935889000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCKC0grye8vUCFQAAAAAdAAAAABAP',

        ]);
        $product_detail_id = $product_detail->id;
        $user = CallHelperTest::getUserAdminRole($this);
        $user_id = $user->id;
        $cart = Cart::create([
            'user_id' => $user_id,
            'product_detail_id' => $product_detail_id,
            'quantity' => 3,
        ]);
        $cart_id = $cart->id;

        $response = CallHelperTest::withAuthorizeBearer($this)->json('GET', '/badaso-api/module/commerce/v1/cart/public');
        $response->assertSuccessful();
        $data_cart = Cart::find($cart_id);
        $this->assertNotEmpty($data_cart);
        $cart->forceDelete();
        $product_detail->forceDelete();
        $discounts->forceDelete();
        $product->forceDelete();
        $product_category->forceDelete();
    }

    public function testInsertCartPublic()
    {
        $user = CallHelperTest::getUserAdminRole($this);
        $user_id = $user->id;
        $product_category = ProductCategory::create([
            'name' => 'coba 1',
            'slug' => Str::uuid(),
            'desc' => 'decription 1',
            'SKU'  => Str::uuid(),
        ]);
        $product_category_id = $product_category->id;
        $product = Product::create([
            'product_category_id' => $product_category_id,
            'name' => 'product 1',
            'slug' => Str::uuid(),
            'product_image' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.pexels.com%2Fsearch%2Fvideos%2Faesthetic%2520background%2F&psig=AOvVaw3LzeH9UjT1mVGsd0J9-XTu&ust=1644482935889000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCKC0grye8vUCFQAAAAAdAAAAABAP',
            'desc' => 'description tes product',
        ]);
        $product_id = $product->id;
        $discounts = Discount::create([
            'name' => 'New Year Discount',
            'desc' => '',
            'discount_type' => 'fixed',
            'discount_percent' => 0,
            'discount_fixed' => 10000,
            'active' => 1,
        ]);
        $discount_id = $discounts->id;
        $product_detail = ProductDetail::create([
            'product_id' => $product_id,
            'discount_id'=> $discount_id,
            'name' => 'name test 2',
            'quantity'  => 13,
            'price' => '1000001',
            'SKU' => Str::uuid(),
            'product_image' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.pexels.com%2Fsearch%2Fvideos%2Faesthetic%2520background%2F&psig=AOvVaw3LzeH9UjT1mVGsd0J9-XTu&ust=1644482935889000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCKC0grye8vUCFQAAAAAdAAAAABAP',

        ]);
        $product_detail_id = $product_detail->id;

        $response = CallHelperTest::withAuthorizeBearer($this)->json('POST', '/badaso-api/module/commerce/v1/cart/public/add', [
            'id' => $product_detail_id,
            'quantity' => $product_detail->quantity,
        ]);
        $response->assertSuccessful();
        $product_detail->forceDelete();
        $discounts->forceDelete();
        $product->forceDelete();
        $product_category->forceDelete();
    }

    public function testEditCartPublic()
    {
        $user = CallHelperTest::getUserAdminRole($this);
        $user_id = $user->id;
        $product_category = ProductCategory::create([
            'name' => 'coba 1',
            'slug' => Str::uuid(),
            'desc' => 'decription 1',
            'SKU'  => Str::uuid(),
        ]);
        $product_category_id = $product_category->id;
        $product = Product::create([
            'product_category_id' => $product_category_id,
            'name' => 'product 1',
            'slug' => Str::uuid(),
            'product_image' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.pexels.com%2Fsearch%2Fvideos%2Faesthetic%2520background%2F&psig=AOvVaw3LzeH9UjT1mVGsd0J9-XTu&ust=1644482935889000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCKC0grye8vUCFQAAAAAdAAAAABAP',
            'desc' => 'description tes product',
        ]);
        $product_id = $product->id;
        $discounts = Discount::create([
            'name' => 'New Year Discount',
            'desc' => '',
            'discount_type' => 'fixed',
            'discount_percent' => 0,
            'discount_fixed' => 10000,
            'active' => 1,
        ]);
        $discount_id = $discounts->id;
        $product_detail = ProductDetail::create([
            'product_id' => $product_id,
            'discount_id'=> $discount_id,
            'name' => 'name test 2',
            'quantity'  => 13,
            'price' => '1000001',
            'SKU' => Str::uuid(),
            'product_image' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.pexels.com%2Fsearch%2Fvideos%2Faesthetic%2520background%2F&psig=AOvVaw3LzeH9UjT1mVGsd0J9-XTu&ust=1644482935889000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCKC0grye8vUCFQAAAAAdAAAAABAP',
        ]);
        $product_detail_id = $product_detail->id;
        $cart = Cart::create([
            'user_id' => $user_id,
            'product_detail_id' => $product_detail_id,
            'quantity' => 3,
        ]);
        $cart_id = $cart->id;
        $request_cart = [
            'id' => $cart_id,
            'quantity' => 4,
        ];
        $response = CallHelperTest::withAuthorizeBearer($this)->json('PUT', '/badaso-api/module/commerce/v1/cart/public/edit', $request_cart);
        $response->assertSuccessful();
        $data_cart = Cart::find($cart_id);
        $this->assertNotEmpty($data_cart);
        $this->assertTrue($request_cart['quantity'] == $data_cart->quantity);
        $cart->forceDelete();
        $product_detail->forceDelete();
        $discounts->forceDelete();
        $product->forceDelete();
        $product_category->forceDelete();
    }

    public function testDeleteCartPublic()
    {
        $user = CallHelperTest::getUserAdminRole($this);
        $user_id = $user->id;
        $product_category = ProductCategory::create([
            'name' => 'coba 1',
            'slug' => Str::uuid(),
            'desc' => 'decription 1',
            'SKU'  => Str::uuid(),
        ]);
        $product_category_id = $product_category->id;
        $product = Product::create([
            'product_category_id' => $product_category_id,
            'name' => 'product 1',
            'slug' => Str::uuid(),
            'product_image' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.pexels.com%2Fsearch%2Fvideos%2Faesthetic%2520background%2F&psig=AOvVaw3LzeH9UjT1mVGsd0J9-XTu&ust=1644482935889000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCKC0grye8vUCFQAAAAAdAAAAABAP',
            'desc' => 'description tes product',
        ]);
        $product_id = $product->id;
        $discounts = Discount::create([
            'name' => 'New Year Discount',
            'desc' => '',
            'discount_type' => 'fixed',
            'discount_percent' => 0,
            'discount_fixed' => 10000,
            'active' => 1,
        ]);
        $discount_id = $discounts->id;
        $product_detail = ProductDetail::create([
            'product_id' => $product_id,
            'discount_id'=> $discount_id,
            'name' => 'name test 2',
            'quantity'  => 13,
            'price' => '1000001',
            'SKU' => Str::uuid(),
            'product_image' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.pexels.com%2Fsearch%2Fvideos%2Faesthetic%2520background%2F&psig=AOvVaw3LzeH9UjT1mVGsd0J9-XTu&ust=1644482935889000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCKC0grye8vUCFQAAAAAdAAAAABAP',
        ]);
        $product_detail_id = $product_detail->id;
        $cart = Cart::create([
            'user_id' => $user_id,
            'product_detail_id' => $product_detail_id,
            'quantity' => 3,
        ]);
        $cart_id = $cart->id;
        $response = CallHelperTest::withAuthorizeBearer($this)->json('DELETE', '/badaso-api/module/commerce/v1/cart/public/delete', [
            'id' => $cart_id,
        ]);
        $response->assertSuccessful();
        $product_detail->forceDelete();
        $discounts->forceDelete();
        $product->forceDelete();
        $product_category->forceDelete();
    }
}
