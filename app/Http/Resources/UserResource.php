<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'dob' => $this->dob,
            'address' => $this->address,
            'occupation' => $this->occupation,
            'picture' => $this->picture,
            'created_at' => $this->created_at
        ];
        if ($this->token) {
            $data['token'] = $this->token;
            $data['expiry'] = Carbon::now()->addMinutes(config('sanctum.expiration') - 2);
        }
        return $data;
    }
}
