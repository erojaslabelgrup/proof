<?php

namespace App\Http\Requests\Api\Tasks;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'title' => 'required|string',
            'status' => 'required|string|in:' . implode(',', \App\Models\Task::STATUSES),
            'description' => 'nullable|string'
        ];
    }
}
