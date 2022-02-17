<?php

namespace Uasoft\Badaso\Module\Commerce\Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Str;
use Uasoft\Badaso\Models\User;
use Illuminate\Support\Facades\Hash;
use Uasoft\Badaso\Helpers\CallHelperTest;
use Illuminate\Foundation\Testing\WithFaker;
use Uasoft\Badaso\Module\Commerce\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Uasoft\Badaso\Module\Commerce\Models\Cart;
use Uasoft\Badaso\Module\Commerce\Models\Discount;
use Uasoft\Badaso\Module\Commerce\Models\OrderAddress;
use Uasoft\Badaso\Module\Commerce\Models\OrderPayment;
use Uasoft\Badaso\Module\Commerce\Models\PaymentOption;
use Uasoft\Badaso\Module\Commerce\Models\Product;
use Uasoft\Badaso\Module\Commerce\Models\ProductCategory;
use Uasoft\Badaso\Module\Commerce\Models\ProductDetail;
use Uasoft\Badaso\Module\Commerce\Models\UserAddress;

class BadasoCommerceApiOrderTest extends TestCase
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

    public function testBrowseOrder()
    {
        $ids = [];
        $orders = [];
        for ($index = 0; $index < 3; $index++) {

            $name = Str::uuid();
            $user = User::create([
                'name' => $name,
                'username' => $name,
                'email' => $name . "@mail.com",
                'password' => Hash::make("secret"),
                'avatar' => 'photos/shares/default-user.png',
                'additional_info' => null,
            ]);
            $user_id = $user->id;
            $order = Order::create([
                'user_id' => $user_id,
                'discounted' => 10,
                'total' => 100,
                'shipping_cost' => 0,
                'payed' => 10,
                'status' => 'process',
                'message' => 'yes' . $index,
                'expired_at' => Carbon::now()
            ]);
            $ids[] = $order->id;
            $orders[] = $order;
        }

        $count_order = Order::all()->count();
        $response = CallHelperTest::withAuthorizeBearer($this)->json('GET', '/badaso-api/module/commerce/v1/order', [
            'page' => 1,
            'limit' => $count_order
        ]);
        $response->assertSuccessful();
        foreach ($orders as $key => $order_key) {
            $order_key->delete();
        }
    }

    public function testReadOrder()
    {
        $name = Str::uuid();
        $user = User::create([
            'name' => $name,
            'username' => $name,
            'email' => $name . "@mail.com",
            'password' => Hash::make("secret"),
            'avatar' => 'photos/shares/default-user.png',
            'additional_info' => null,
        ]);
        $user_id = $user->id;
        $order = Order::create([
            'user_id' => $user_id,
            'discounted' => 10,
            'total' => 100,
            'shipping_cost' => 0,
            'payed' => 10,
            'status' => 'process',
            'message' => 'yes',
            'expired_at' => Carbon::now()
        ]);
        $order_id = $order->id;
        $response = CallHelperTest::withAuthorizeBearer($this)->json('GET', '/badaso-api/module/commerce/v1/order/read', [
            'id' => $order_id
        ]);
        $response->assertSuccessful();
        $order->forceDelete();
    }

    public function testConfirmOrder()
    {
        $name = Str::uuid();
        $user = User::create([
            'name' => $name,
            'username' => $name,
            'email' => $name . "@mail.com",
            'password' => Hash::make("secret"),
            'avatar' => 'photos/shares/default-user.png',
            'additional_info' => null,
        ]);
        $user_id = $user->id;
        $order = Order::create([
            'user_id' => $user_id,
            'discounted' => 10,
            'total' => 100,
            'shipping_cost' => 0,
            'payed' => 10,
            'status' => 'waitingSellerConfirmation',
            'message' => 'yes',
            'expired_at' => Carbon::tomorrow()
        ]);
        $order_id = $order->id;
        $response = CallHelperTest::withAuthorizeBearer($this)->json('POST', '/badaso-api/module/commerce/v1/order/confirm', [
            'id' => $order_id
        ]);
        $response->assertSuccessful();
        $order->forceDelete();
    }

    public function testRejectOrder()
    {
        $name = Str::uuid();
        $user = User::create([
            'name' => $name,
            'username' => $name,
            'email' => $name . "@mail.com",
            'password' => Hash::make("secret"),
            'avatar' => 'photos/shares/default-user.png',
            'additional_info' => null,
        ]);
        $user_id = $user->id;
        $order = Order::create([
            'user_id' => $user_id,
            'discounted' => 10,
            'total' => 100,
            'shipping_cost' => 0,
            'payed' => 10,
            'status' => 'waitingSellerConfirmation',
            'message' => 'yes',
            'cancel_message' => 'test',
            'expired_at' => Carbon::tomorrow()
        ]);
        $order_id = $order->id;
        $order_cancel_message = $order->cancel_message;

        $response = CallHelperTest::withAuthorizeBearer($this)->json('POST', '/badaso-api/module/commerce/v1/order/reject', [
            'id' => $order_id,
            'cancel_message' => $order_cancel_message
        ]);
        $response->assertSuccessful();
        $order->forceDelete();
    }

    public function testShipOrder()
    {
        $name = Str::uuid();
        $user = User::create([
            'name' => $name,
            'username' => $name,
            'email' => $name . "@mail.com",
            'password' => Hash::make("secret"),
            'avatar' => 'photos/shares/default-user.png',
            'additional_info' => null,
        ]);
        $user_id = $user->id;
        $order = Order::create([
            'user_id' => $user_id,
            'discounted' => 10,
            'total' => 100,
            'shipping_cost' => 0,
            'payed' => 10,
            'status' => 'process',
            'tracking_number' => '10003642868793',
            'message' => 'yes',
            'cancel_message' => 'test',
            'expired_at' => Carbon::tomorrow()
        ]);
        $order_id = $order->id;
        $tracking_order = $order->tracking_number;
        $response = CallHelperTest::withAuthorizeBearer($this)->json('POST', '/badaso-api/module/commerce/v1/order/ship', [
            'id' => $order_id,
            'tracking_number' => $tracking_order
        ]);
        $response->assertSuccessful();
    }

    public function testDoneOrder()
    {
        $name = Str::uuid();
        $user = User::create([
            'name' => $name,
            'username' => $name,
            'email' => $name . "@mail.com",
            'password' => Hash::make("secret"),
            'avatar' => 'photos/shares/default-user.png',
            'additional_info' => null,
        ]);
        $user_id = $user->id;
        $order = Order::create([
            'user_id' => $user_id,
            'discounted' => 10,
            'total' => 100,
            'shipping_cost' => 0,
            'payed' => 10,
            'status' => 'delivering',
            'tracking_number' => 'LOREM12312323',
            'message' => 'yes',
            'cancel_message' => 'test',
            'expired_at' => Carbon::tomorrow()
        ]);
        $order_id = $order->id;
        $response = CallHelperTest::withAuthorizeBearer($this)->json('POST', '/badaso-api/module/commerce/v1/order/done', [
            'id' => $order_id
        ]);
        $response->assertSuccessful();
        $order->forceDelete();
        $user->forceDelete();
    }

    public function testBrowseOrderPublic()
    {
        $ids = [];
        $orders = [];
        for ($index = 0; $index < 3; $index++) {
            $name = Str::uuid();
            $user = CallHelperTest::getUserAdminRole($this);
            $user_id = $user->id;
            $order = Order::create([
                'user_id' => $user_id,
                'discounted' => 10,
                'total' => 100,
                'shipping_cost' => 0,
                'payed' => 10,
                'status' => 'delivering',
                'tracking_number' => 'LOREM12312323',
                'message' => 'yes' . $index,
                'cancel_message' => 'test' . $index,
                'expired_at' => Carbon::tomorrow()
            ]);
            $ids[] = $order->id;
            $orders[] = $order;
        }
        $join_id = join(",", $ids);
        $response = CallHelperTest::withAuthorizeBearer($this)->json('GET', '/badaso-api/module/commerce/v1/order/public');
        $response->assertSuccessful();

        $response_get_order = $response->json('data.orders');
        foreach ($orders as $key => $value_order) {
            $get_id_order = $value_order->id;
            $data_order = Order::find($get_id_order);
            $this->assertNotEmpty($data_order);
            $data_order->forceDelete();
        }
    }



    public function testFinishPublicOrder()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function testPayOrderPublic()
    {
        $user = CallHelperTest::getUserAdminRole($this);
        $user_id = $user->id;

        $order = Order::create([
            'user_id' => $user_id,
            'discounted' => 10,
            'total' => 100,
            'shipping_cost' => 0,
            'payed' => 10,
            'status' => 'waitingBuyerPayment',
            'tracking_number' => 'LOREM12312323',
            'message' => 'yes',
            'cancel_message' => 'test',
            'expired_at' => Carbon::now()->addMonths(3)
        ]);
        $order_id = $order->id;
        $request_order = [
            'id' =>  $order_id,
            'name' => 'order_payments',
            'proof_of_transaction' => 'https://www.google.com/imgres?imgurl=https%3A%2F%2F1.bp.blogspot.com%2F-ODZquLEzq78%2FYHABUWWi8FI%2FAAAAAAAAVE0%2FE_kpYUmOUPUZ8g9a6Gg3j64TA4Ji1D4yQCLcBGAsYHQ%2Fs0%2FCara-Cetak-Rekening-Koran-Melalui-KlikBCA.jpg&imgrefurl=https%3A%2F%2Fbca.emingko.com%2F2021%2F04%2Fcara-cetak-rekening-koran-melalui-klikbca.html&tbnid=JbGqy6OH6ljHpM&vet=12ahUKEwjV8PvIkYP2AhU2_zgGHQ_RC3sQMygFegUIARC8AQ..i&docid=o3Q2nJTIlZqVuM&w=600&h=371&q=gambar%20bukti%20transaksi&ved=2ahUKEwjV8PvIkYP2AhU2_zgGHQ_RC3sQMygFegUIARC8AQ',
            'source_bank' => 'BCA',
            'destination_bank' => 'BCA',
            'account_number' => '201B23456800',
            'total_transfered' => 500000,
        ];
        $response = CallHelperTest::withAuthorizeBearer($this)->json('POST', '/badaso-api/module/commerce/v1/order/public/pay', $request_order);
        $response->assertSuccessful();
    }


    public function testEditOrderAddressPublic()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}
