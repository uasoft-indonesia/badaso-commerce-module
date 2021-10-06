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
}
