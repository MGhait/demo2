<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ICResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'ID' => $this->id,
            'IC_code' => $this->name,
            'IC_commercial_name' => $this->commName,
            'IC_vendor_name' => $this->manName,
            'Slug' => $this->slug,
            'IC_image' => $this->mainImage ? url('storage/images/' . $this->mainImage->url) : null,
            'IC_blogDiagram' => $this->blogDiagram ? url('storage/images/' . $this->blogDiagram->url) : null,
            'IC_truth_table' => $this->truthTables ? TruthTableResource::collection($this->truthTables) : null,
            'IC_store' => $this->store->name,
            'IC_views' => $this->views,
            'IC_likes' => $this->likes,
            'IC_video' => $this->videoUrl

        ];
    }
}
