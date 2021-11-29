<?php
declare(strict_types=1);

namespace Domains\Customer\Models;

use Database\Factories\WishlistFactory;
use Domains\Catalog\Models\Variant;
use Domains\Customer\Models\Builders\WishListBuilder;
use Domains\Shared\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wishlist extends Model
{
    use HasUuid;
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'name',
        'public',
        'user_id'
    ];

   protected $casts = [
       'public'=>'boolean',
   ];


    public function  owner(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return  $this->belongsTo(
            related:  User::class,
            foreignKey: 'user_id',
        );
    }

    public function  variants(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return  $this->belongsToMany(
            related:  Variant::class,
            table: 'variant_wishlist'
        );
    }
    protected static function newFactory() :Factory
    {
        return  WishlistFactory::new();

    }

    public function  newEloquentBuilder($query) :Builder
    {
        return new WishListBuilder(
            query: $query
        );
    }
}
