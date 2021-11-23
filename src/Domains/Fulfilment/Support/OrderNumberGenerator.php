<?php

namespace Domains\Fulfilment\Support;

use Domains\Customer\Models\Cart;
use Illuminate\Support\Str;

class OrderNumberGenerator
{
    public  static  function  generate(): string
    {
       return  Str::uuid()->toString();
    }
}
