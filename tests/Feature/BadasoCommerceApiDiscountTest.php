<?php

namespace Uasoft\Badaso\Module\Commerce\Tests\Feature;

use Tests\TestCase;
use Uasoft\Badaso\Helpers\CallHelper;
use Uasoft\Badaso\Module\Commerce\Models\Discount;

class BadasoCommerceApiDiscountTest extends TestCase
{
    public function testInitStart()
    {
        CallHelper::handleUserAdminAuthorize($this);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testBrowseDiscount()
    {
        $ids = [];
        $discounts = [];
        for ($index = 0; $index < 3; $index++) {
            $discount = Discount::create([
                'name' => 'Diskon Kemerdekaan'.$index,
                'desc' => 'description diskon'.$index,
                'discount_type' => 'percent',
                'discount_percent' => 10,
                'discount_fixed' => null,
                'active' => 1,
            ]);
            $discounts[] = $discount;
            $ids[] = $discount->id;
        }

        $count_discount = Discount::all()->count();

        $response = CallHelper::withAuthorizeBearer($this)->json('GET', '/badaso-api/module/commerce/v1/discount', [
            'page' => 1,
            'limit' => $count_discount,
        ]);
        $response->assertSuccessful();
        foreach ($discounts as $key => $discount_key) {
            $discount_key->forceDelete();
        }
    }

    public function testBrowseBinDiscount()
    {
        $ids = [];
        $discounts = [];
        for ($index = 0; $index < 3; $index++) {
            $discount = Discount::create([
                'name' => 'Diskon Kemerdekaan'.$index,
                'desc' => 'description diskon'.$index,
                'discount_type' => 'percent',
                'discount_percent' => 10,
                'discount_fixed' => null,
                'active' => 1,
            ]);
            $discounts[] = $discount;
            $ids[] = $discount->id;
        }
        foreach ($discounts as $key => $discount_key) {
            $discount_key->delete();
        }
        $discount_trans_count = Discount::withTrashed()->count();
        $response = CallHelper::withAuthorizeBearer($this)->json('GET', '/badaso-api/module/commerce/v1/discount/bin', [
            'page' => 1,
            'limit' => $discount_trans_count,
        ]);

        $response->assertSuccessful();
        foreach ($discounts as $key => $discount_key) {
            $discount_key->forceDelete();
        }
    }

    public function testReadDiscount()
    {
        $discount = Discount::create([
            'name' => 'Diskon Kemerdekaan read',
            'desc' => 'description diskon read',
            'discount_type' => 'percent',
            'discount_percent' => 10,
            'discount_fixed' => null,
            'active' => 1,
        ]);
        $discount_id = $discount->id;
        $response = CallHelper::withAuthorizeBearer($this)->json('GET', '/badaso-api/module/commerce/v1/discount/read', [
            'id' => $discount_id,
        ]);
        $response->assertSuccessful();
        $discount->forceDelete();
    }

    public function testInsertDiscount()
    {
        $response = CallHelper::withAuthorizeBearer($this)->json('POST', '/badaso-api/module/commerce/v1/discount/add', [
            'name' => 'Diskon Kemerdekaan insert diskon',
            'desc' => 'description diskon insert diskon',
            'discount_type' => 'percent',
            'discount_percent' => 10,
            'discount_fixed' => 10000,
            'active' => 1,
        ]);

        $response->assertSuccessful();
        $get_response_discount = $response->json('data.id');
        $data = Discount::find($get_response_discount);
        $this->assertNotEmpty($data);
        $data->delete();
    }

    public function testEditDiscount()
    {
        $discount = Discount::create([
            'name' => 'Diskon Kemerdekaan read',
            'desc' => 'description diskon read',
            'discount_type' => 'percent',
            'discount_percent' => 10,
            'discount_fixed' => 10000,
            'active' => 1,
        ]);
        $discount_id = $discount->id;
        $request_discount = [
            'id' => $discount_id,
            'name' => 'Diskon Kemerdekaan edit',
            'desc' => 'description diskon edit',
            'discount_type' => 'percent',
            'discount_percent' => 10,
            'discount_fixed' => 10000,
            'active' => 1,
        ];
        $response = CallHelper::withAuthorizeBearer($this)->json('PUT', '/badaso-api/module/commerce/v1/discount/edit', $request_discount);
        $response->assertSuccessful();

        $data_discount = Discount::find($discount_id);
        $this->assertNotEmpty($data_discount);
        $this->assertTrue($request_discount['name'] == $data_discount->name);
        $this->assertTrue($request_discount['desc'] == $data_discount->desc);
        $this->assertTrue($request_discount['discount_type'] == $data_discount->discount_type);
        $this->assertTrue($request_discount['discount_percent'] == $data_discount->discount_percent);
        $this->assertTrue($request_discount['discount_fixed'] == $data_discount->discount_fixed);
        $this->assertTrue($request_discount['active'] == $data_discount->active);
        $data_discount->forceDelete();
    }

    public function testDeleteDiscount()
    {
        $discount = Discount::create([
            'name' => 'Diskon Kemerdekaan read',
            'desc' => 'description diskon read',
            'discount_type' => 'percent',
            'discount_percent' => 10,
            'discount_fixed' => null,
            'active' => 1,
        ]);
        $discount_id = $discount->id;
        $response = CallHelper::withAuthorizeBearer($this)->json('DELETE', '/badaso-api/module/commerce/v1/discount/delete', [
            'id' => $discount_id,
        ]);
        $response->assertSuccessful();
        $discount->forceDelete();
    }

    public function testForceDeleteDiscount()
    {
        $discount = Discount::create([
            'name' => 'Diskon Kemerdekaan read',
            'desc' => 'description diskon read',
            'discount_type' => 'percent',
            'discount_percent' => 10,
            'discount_fixed' => null,
            'active' => 1,
        ]);
        $discount_id = $discount->id;
        $discount->delete();
        $response = CallHelper::withAuthorizeBearer($this)->json('DELETE', '/badaso-api/module/commerce/v1/discount/force-delete', [
            'id' => $discount_id,
        ]);
        $response->assertSuccessful();
        $discount_trans = Discount::withTrashed()->find($discount_id);
        $this->assertEmpty($discount_trans);
        $discount->forceDelete();
    }

    public function testDeleteMultipleDiscount()
    {
        $ids = [];
        $discounts = [];
        for ($index = 0; $index < 3; $index++) {
            $discount = Discount::create([
                'name' => 'Diskon Kemerdekaan delete multiple'.$index,
                'desc' => 'description diskon delete multiple'.$index,
                'discount_type' => 'percent',
                'discount_percent' => 10,
                'discount_fixed' => null,
                'active' => 1,
            ]);
            $ids[] = $discount->id;
            $discounts[] = $discount;
        }

        $join_discount = join(',', $ids);
        $response = CallHelper::withAuthorizeBearer($this)->json('DELETE', '/badaso-api/module/commerce/v1/discount/delete-multiple', [
            'ids' => $join_discount,
        ]);
        $response->assertSuccessful();
        $discount->forceDelete();
    }

    public function testForceDeleteMultipleDiscount()
    {
        $ids = [];
        $discounts = [];
        for ($index = 0; $index < 3; $index++) {
            $discount = Discount::create([
                'name' => 'Diskon Kemerdekaan delete multiple'.$index,
                'desc' => 'description diskon delete multiple'.$index,
                'discount_type' => 'percent',
                'discount_percent' => 10,
                'discount_fixed' => null,
                'active' => 1,
            ]);
            $ids[] = $discount->id;
            $discounts[] = $discount;
        }

        $join_discount = join(',', $ids);
        foreach ($discounts as $key => $discount_key) {
            $discount_key->delete();
        }
        $response = CallHelper::withAuthorizeBearer($this)->json('DELETE', '/badaso-api/module/commerce/v1/discount/force-delete-multiple', [
            'ids' => $join_discount,
        ]);
        $response->assertSuccessful();
        $history = [];
        foreach ($discounts as $key => $discount) {
            $delete_discount_id = $discount->id;
            $discount_trans = Discount::withTrashed()->find($delete_discount_id);
            $this->assertEmpty($discount_trans);
            if (isset($product_trans)) {
                $history[] = $delete_discount_id;
            }
        }
    }

    public function testRestoreDeleteDiscount()
    {
        $discount = Discount::create([
            'name' => 'Diskon Kemerdekaan restore',
            'desc' => 'description diskon restore',
            'discount_type' => 'percent',
            'discount_percent' => 10,
            'discount_fixed' => null,
            'active' => 1,
        ]);
        $discount_id = $discount->id;
        $discount->delete();
        $discount_trashed = Discount::withTrashed()->find($discount_id);
        $discount_trashed_id = $discount_trashed->id;
        $response = CallHelper::withAuthorizeBearer($this)->json('POST', '/badaso-api/module/commerce/v1/discount/restore', [
            'id' => $discount_trashed_id,
        ]);
        $response->assertSuccessful();
        $discount_get = Discount::find($discount_id);
        $this->assertNotEmpty($discount_get);
        $this->assertEmpty($discount_get->deleted_at);
        $discount->forceDelete();
    }

    public function testRestoreMultipleDeleteDiscount()
    {
        $ids = [];
        $discounts = [];
        for ($index = 0; $index < 3; $index++) {
            $discount = Discount::create([
                'name' => 'Diskon Kemerdekaan restore multiple'.$index,
                'desc' => 'description diskon restore'.$index,
                'discount_type' => 'percent',
                'discount_percent' => 10,
                'discount_fixed' => null,
                'active' => 1,
            ]);
            $ids[] = $discount->id;
            $discounts[] = $discount;
        }
        $join_discount = explode(',', $discount->id);
        foreach ($discounts as $key => $discount_key) {
            $discount_key->delete();
        }
        foreach ($join_discount as $key => $id) {
            $discount_trashed = Discount::withTrashed()->findOrFail($id);
            $discount_trashed_id = $discount_trashed->id;
        }

        $response = CallHelper::withAuthorizeBearer($this)->json('POST', '/badaso-api/module/commerce/v1/discount/restore-multiple', [
            'ids' => $discount_trashed_id,
        ]);
        $response->assertSuccessful();
        foreach ($join_discount as $key => $id) {
            $discount_get = Discount::findOrFail($id);
            $this->assertNotEmpty($discount_get);
            $this->assertEmpty($discount_get->deleted_at);
        }

        foreach ($discounts as $key => $discount_key) {
            $discount_key->forceDelete();
        }
    }
}
