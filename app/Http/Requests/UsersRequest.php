<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UsersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    //
                    "fullname"=> "required",
                    "email"=> ["required", "email", "unique:users"],
                    "password" => "required"
                ];
                break;
            case 'PUT':
            case 'PATCH':
                return [
                    //
                    "fullname"=> "required",
                    "email"=> ["required", "email", Rule::unique('users')->ignore($this->id)],
                    "password" => "required"
                ];
                break;
            default:break;
        }

    }
}
