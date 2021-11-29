<?php
declare(strict_types=1);
namespace Domains\Customer\ValueObjects;

class WishListValueObject
{
   public  function __construct(
       public string    $name,
       public bool      $public = false,
       public null|int  $user = null,
   ){}
}
