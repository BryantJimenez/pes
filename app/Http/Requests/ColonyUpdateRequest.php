<?php

namespace App\Http\Requests;

use App\Zip;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ColonyUpdateRequest extends FormRequest
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
        $zips=Zip::where('state', '1')->get()->pluck('slug');
        return [
            'name' => 'required|string|min:2|max:191|'.Rule::unique('colonies')->ignore($this->slug, 'slug'),
            'zip_id' => 'required|'.Rule::in($zips)
        ];
    }
}
