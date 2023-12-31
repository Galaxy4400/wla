<?php

namespace App\Http\Requests\Admin\Page;

use App\Models\Page;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return auth('admin')->check();
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'name' => ['required', 'string', 'min:3'],
			// 'type' => ['required', 'integer'],
			'description' => ['nullable'],
			'content' => ['nullable'],
			// 'page' => ['required_if:type,'.Page::CONTENT_BY_PAGE, 'string'],
			// 'route' => ['required_if:type,'.Page::CONTENT_BY_ROUTE, 'string'],
			// 'link' => ['required_if:type,'.Page::CONTENT_BY_LINK, 'url'],
			'image' => ['nullable', 'image', 'max:2048'],
			'image_delete' => ['nullable', 'boolean'],
			'parent_id' => ['nullable', 'string'],
		];
	}
}
