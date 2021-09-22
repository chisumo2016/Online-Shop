<?php
declare(strict_types=1);
namespace Database\Factories;

use Domains\Customer\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use JustSteveKing\LaravelPostcodes\Service\PostcodeService;


class LocationFactory extends Factory
{

    protected $model = Location::class;

    public function definition(): array
    {
        /**
         * @var PostcodeService
         */
        $service = resolve(PostcodeService::class);
        $location = $service->getRandomPostcode();
        $streetAddress = $this->faker->streetAddress;
        //dd(Str::of($streetAddress)->before(search:' '), Str::of($streetAddress)->after(search:' '));

        $house = Str::before(
            subject: '',
            search: $street = $this->faker->streetAddress,
        );
        //dd($this->faker->streetAddress());
        return [
             'house' =>Str::of($streetAddress)->before(search:' '),
            'street' => Str::of($streetAddress)->after(search:' '),
            'parish'=> data_get($location, key: 'parish'),
            'ward' => data_get($location, key:'admin_ward'),
            'district' => data_get($location, key:'admin_district'),
            'county' => data_get($location, key:'admin_county'),
            'postcode' => data_get($location, key:'postcode'),
            'country' => data_get($location, key:'country'),
        ];
    }
}
