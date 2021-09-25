<?php
declare(strict_types=1);

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class RangeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request) : array
    {
        return [
            'id'    => $this->id,
            'type'  =>'range',
            'attributes'    =>[
                'key'           => $this->key,
                'name'          => $this->name,
                'description'   => $this->description,
                'active'        => $this->active,
            ],

            //Return the relationship
            'relationships' => [
                'products'=>ProductResource::collection(
                    resource: $this->whenLoaded(
                        relationship: 'products'
                    ),
                ),
            ]
        ];
    }
}
