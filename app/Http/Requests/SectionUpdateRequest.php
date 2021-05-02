<?php

namespace App\Http\Requests;

use App\Colony;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SectionUpdateRequest extends FormRequest
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
        $colonies=Colony::where('state', '1')->get()->pluck('slug');
        return [
            'name' => 'required|digits:4|'.Rule::unique('sections')->ignore($this->slug, 'slug'),
            'colony_id'    => 'required|array|min:1',
            'colony_id.*'  => 'required|distinct|'.Rule::in($colonies)
        ];
    }
}
