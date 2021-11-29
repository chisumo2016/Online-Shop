<?php

namespace Domains\Customer\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class WishListBuilder extends Builder
{
     public function  public():self
     {
         return $this->where('public', true);
     }
}
