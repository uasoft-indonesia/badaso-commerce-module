<?php

namespace Uasoft\Badaso\Module\Commerce\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Uasoft\Badaso\Models\User;

class Order extends Model
{
    protected $table = null;

    // protected $primaryKey = 'id';
    // protected $keyType = 'string';

    public $incrementing = false;

    /**
     * Constructor for setting the table name dynamically.
     */
    public function __construct(array $attributes = [])
    {
        $prefix = config('badaso.database.prefix');
        $this->table = $prefix.'orders';
        parent::__construct($attributes);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            try {
                $model->id = Str::uuid()->toString();
            } catch (Exception $e) {
                abort(500, $e->getMessage());
            }
        });
    }

    protected $guarded = [];

    /**
     * Get the user that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order associated with the OrderPayment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function orderPayment()
    {
        return $this->hasOne(OrderPayment::class);
    }

    /**
     * Get all of the orderDetails for the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }

    /**
     * Get the orderAddress associated with the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function orderAddress()
    {
        return $this->hasOne(OrderAddress::class);
    }
}
