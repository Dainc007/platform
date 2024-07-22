<?php

namespace App\Http\Requests\Message;

use App\Models\Message;
use Illuminate\Foundation\Http\FormRequest;

class StoreMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Message::class);
    }
    public function rules(): array
    {
        return [
            'content' => ['required', 'string']
        ];
    }
}
