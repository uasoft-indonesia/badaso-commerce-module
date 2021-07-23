<?php

namespace Uasoft\Badaso\Module\Commerce\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Discount extends Model
{
    use SoftDeletes;

    protected $table = null;

    /**
     * Constructor for setting the table name dynamically.
     */
    public function __construct(array $attributes = [])
    {
        $prefix = config('badaso.database.prefix');
        $this->table = $prefix.'discounts';
        parent::__construct($attributes);
    }

    protected $fillable = [
        'id',
        'name',
        'desc',
        'discount_type',
        'discount_percent',
        'discount_fixed',
        'active',
        'created_at', 
        'updated_at', 
        'deleted_at'
    ];

    /**
     * Get all of the productDetail for the Discount
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productDetail()
    {
        return $this->hasMany(ProductDetail::class);
    }
}
