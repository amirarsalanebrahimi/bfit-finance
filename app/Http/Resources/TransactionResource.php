<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Morilog\Jalali\Jalalian;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => $this->user,
            'title' => $this->title,
            'type' => $this->type,
            'amount' => number_format((int) $this->amount),
            'date' => Jalalian::fromCarbon($this->date)->format('Y/m/d'),
            'reference_number' => $this->reference_number,
            'payee_payer' => $this->payee_payer,
            'description' => $this->description,
            'payment_method' => $this->payment_method,
            'tags' => TagResource::collection($this->tags)
        ];
    }
}
