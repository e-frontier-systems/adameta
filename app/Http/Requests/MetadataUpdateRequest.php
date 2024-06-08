<?php

namespace App\Http\Requests;

use App\Models\Ticker;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MetadataUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'json' => ['required', 'string', 'max:2000'],
            'ticker_id' => ['required', 'integer', Rule::exists('metadatas', 'ticker_id')->where('ticker_id', [$this->request->get('ticker_id')])],
        ];
    }
}
