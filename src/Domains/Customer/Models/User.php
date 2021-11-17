<?php

 declare(strict_types=1);
namespace Domains\Customer\Models;

use Database\Factories\UserFactory;
use Domains\Shared\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasUuid;
    use HasFactory;
    use Notifiable;
    use HasApiTokens;

    protected $fillable = [
        'uuid',
        'first_name',
        'last_name',
        'email',
        'password',
        'billing_id',
        'shipping_id',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function addresses(): HasMany
    {
        return  $this->hasMany(
            related: Address::class,
            foreignKey: 'user_id',
        );
    }

    public function billing(): BelongsTo
    {
        return  $this->BelongsTo(
            related: Address::class,
            foreignKey: 'billing_id',
        );
    }
    public function shipping(): BelongsTo
    {
        return  $this->BelongsTo(
            related: Address::class,
            foreignKey: 'shipping_id',
        );
    }

    public function cart()
    {
        return $this->hasOne(
            related: Cart::class,
            foreignKey: 'user_id'
        );
    }

    public function orders(): HasMany
    {
        return $this->HasMany(
            related: Order::class,
            foreignKey: 'user_id'
        );
    }

    protected static function newFactory(): Factory
    {
        return  UserFactory::new();
        //return  new UserFactory();
    }
}
