<?php

declare(strict_types=1);

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
        return [
            'id'    =>$this->id,
            'type'  =>'product',
            'attributes'=>[
                'key' => $this->key,
                'name'=> $this->name,
                'description'=>$this->description,
                'price'=> [
                    'cost'=>$this->cost,
                    'retail'=>$this->retail ,//product.attributes.price.retail
                ],
                'vat'=>$this->vat,
                'active'=>$this->active
            ],
            'relationships'=>[
                'category' =>new CategoryResource(
                    resource: $this->whenLoaded(
                        relationship: 'category',
                        //value:$this->category,
                    ),
                ),
                'range'=> new RangeResource(
                    resource: $this->whenLoaded(
                        relationship: 'range',
                        //value: $this->range
                    )
                ),
                'variants'=> new VariantResource(
                    resource: $this->whenLoaded(
                        relationship: 'variants',
                    //value: $this->range
                    )
                ),
            ],
            'links' =>[
                '_self'   => route('api:v1:products:show', $this->key),
                '_parent' => route('api:v1:products:index')
            ] ,
        ];
    }
}
