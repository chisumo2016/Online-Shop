<?php

namespace Domains\Customer\States\Statuses;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self pending()
 * @method static self complete()
 * @method static self refunded()
 * @method static self cancelled()
 */
final class OrderStatus extends Enum
{
}
