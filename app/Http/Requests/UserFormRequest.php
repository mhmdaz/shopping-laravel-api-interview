<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UserFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return
            request()->user()->tokenCan('admin') ||
            (
                request()->user()->tokenCan('manager') &&
                $this->role !== 'admin' &&
                !User::where('id', $this->user?->id)->where('role', 'admin')->exists()
            );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->user?->id),
            ],
            'password' => ['required'],
            'role' =>  ['required'],
        ];
    }

    public function failedAuthorization()
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'This action is unauthorized.',
            ], 401)
        );
    }

    /**
    * Get the error messages for the defined validation rules.
    * 
    * @param Validator $validator
    */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 422)
        );
    }
}
