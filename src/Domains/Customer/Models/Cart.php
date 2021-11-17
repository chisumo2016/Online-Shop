<?php
declare(strict_types=1);

namespace Domains\Customer\Models;

use Database\Factories\CartFactory;
use Domains\Customer\States\Statuses\CartStatus;
use Domains\Shared\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use JustSteveKing\KeyFactory\Models\Concerns\HasKey;

class Cart extends Model
{
    //use HasKey;
    use HasUuid;
    use Prunable;
    use HasFactory;

    protected $fillable = [
         //'key',
        'uuid',
        'status',
        'coupon',
        'total',
        'reduction',
        'user_id',
    ];

    protected $casts = [
        'status' => CartStatus::class . ':nullable',
    ];

   public  function  user() : BelongsTo
   {
       return $this->belongsTo(
           related: User::class,
           foreignKey: 'user_id'
       );
   }

   public  function items() : HasMany
   {
       return $this->hasMany(
           related: CartItem::class,
           foreignKey: 'cart_id'
       );
   }

    protected static function newFactory() :Factory
    {
        return  CartFactory::new();

    }

    /**
     * Get the prunable model query.
     *
     * @return Builder
     */
    public function prunable(): Builder
    {
        return static::query()->where('created_at', '<=', now()->subMonth());
    }
}
