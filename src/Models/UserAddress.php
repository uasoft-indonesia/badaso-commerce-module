<?php

namespace Uasoft\Badaso\Module\Commerce\Models;

use Illuminate\Database\Eloquent\Model;
use Uasoft\Badaso\Models\User;

class UserAddress extends Model
{
    protected $table = null;

    /**
     * Constructor for setting the table name dynamically.
     */
    public function __construct(array $attributes = [])
    {
        $prefix = config('badaso.database.prefix');
        $this->table = $prefix.'user_addresses';
        parent::__construct($attributes);
    }

    protected $fillable = [
        'id',
        'user_id',
        'recipient_name',
        'address_line1',
        'address_line2',
        'city',
        'postal_code',
        'country',
        'phone_number',
        'is_main',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the user that owns the UserAddress.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
