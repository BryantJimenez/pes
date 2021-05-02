<?php

namespace App\Http\Requests;

use App\Colony;
use App\Section;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class SectionStoreRequest extends FormRequest
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

    protected function prepareForValidation()
    {
        $trashed=Section::where('slug', Str::slug($this->name))->withTrashed()->exists();
        $exist=Section::where('slug', Str::slug($this->name))->exists();
        ($trashed) ? $this->merge(['trashed' => true]) : $this->merge(['trashed' => false]);
        ($exist) ? $this->merge(['exist' => true]) : $this->merge(['exist' => false]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->trashed && $this->exist===false) {
            $section=Section::where('slug', Str::slug($this->name))->withTrashed()->first();
            $section->restore();
        }
        $colonies=Colony::where('state', '1')->get()->pluck('slug');
        return [
            'name' => 'required|digits:4|unique:sections,name',
            'colony_id'    => 'required|array|min:1',
            'colony_id.*'  => 'required|distinct|'.Rule::in($colonies)
        ];
    }
}
