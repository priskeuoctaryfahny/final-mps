<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('transaction-create') || auth()->user()->can('transaction-update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => 'required|in:in,out', // Ensure type is either 'in' or 'out'
            'gas_id' => 'required|exists:gases,id', // Ensure gas_id exists in the gases table
            'qty' => 'required|integer|min:1', // Quantity must be a positive integer
            'amount' => 'required|numeric|min:0', // Amount must be a non-negative number
            'optional_amount' => 'nullable|numeric|min:0', // Optional amount can be null or a non-negative number
            'description' => 'nullable|string|max:255', // Description can be null or a string with max length of 255
            'reference' => 'nullable|string|max:255', // Reference can be null or a string with max length of 255
            'transaction_date' => 'nullable|date', // Transaction date can be null or a valid date
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', // Attachment can be a file of specific types and size
            'status' => 'required|in:completed,pending,canceled', // Status must be one of the specified values
        ];
    }
}
