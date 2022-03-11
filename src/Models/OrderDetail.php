<?php

namespace Uasoft\Badaso\Module\Commerce\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OrderDetail extends Model
{
    protected $table = null;

    /**
     * Constructor for setting the table name dynamically.
     */
    public function __construct(array $attributes = [])
    {
        $prefix = config('badaso.database.prefix');
        $this->table = $prefix.'order_details';
        parent::__construct($attributes);
    }

    protected $guarded = [];

    /**
     * Get the productDetail that owns the ProductDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productDetail()
    {
        return $this->belongsTo(ProductDetail::class);
    }

    /**
     * Get the order that owns the OrderDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the review associated with the OrderDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function review()
    {
        return $this->hasOne(ProductReview::class, 'order_detail_id');
    }
}
