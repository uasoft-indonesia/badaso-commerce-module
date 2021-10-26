<?php

namespace Uasoft\Badaso\Module\Commerce\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Uasoft\Badaso\Models\User;
use Uasoft\Badaso\Module\Commerce\Factories\ProductDetailFactory;

class ProductReview extends Model
{
    use HasFactory;

    protected $table = null;

    protected $casts = [
        'media' => 'array',
    ];

    /**
     * Constructor for setting the table name dynamically.
     */
    public function __construct(array $attributes = [])
    {
        $prefix = config('badaso.database.prefix');
        $this->table = $prefix . 'product_reviews';
        parent::__construct($attributes);
    }

    protected $guarded = [];

    /**
     * Get the product that owns the ProductReview
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the user that owns the ProductReview
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the orderDetail that owns the ProductReview
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function orderDetail()
    {
        return $this->belongsTo(OrderDetail::class);
    }
}
