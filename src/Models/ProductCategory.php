<?php

namespace Uasoft\Badaso\Module\Commerce\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ProductCategory extends Model
{
    use SoftDeletes;

    protected $table = null;

    /**
     * Constructor for setting the table name dynamically.
     */
    public function __construct(array $attributes = [])
    {
        $prefix = config('badaso.database.prefix');
        $this->table = $prefix.'product_categories';
        parent::__construct($attributes);
    }

    protected $fillable = [
        'id',
        'parent_id',
        'name',
        'slug',
        'desc',
        'SKU',
        'created_at',
        'updated_at',	
        'deleted_at'
    ];

    public function children()
    {
        return $this->hasMany(ProductCategory::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(ProductCategory::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'product_category_id', 'id');
    }
}
