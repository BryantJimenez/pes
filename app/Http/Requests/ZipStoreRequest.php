<?php

namespace App\Http\Requests;

use App\Zip;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class ZipStoreRequest extends FormRequest
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
        $trashed=Zip::where('slug', Str::slug($this->name))->withTrashed()->exists();
        $exist=Zip::where('slug', Str::slug($this->name))->exists();
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
            $zip=Zip::where('slug', Str::slug($this->name))->withTrashed()->first();
            $zip->restore();
        }
        return [

            'name' => 'required|digits:5|unique:zips,name'
        ];
    }
}
