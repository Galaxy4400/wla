<?php

namespace App\Http\Requests\Web\Mail;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
	 * @return array
	 */
	public function rules()
	{
		return [
			'email' => ['required', 'email'],
			'text' => ['required', 'min:5'],
		];
	}
}