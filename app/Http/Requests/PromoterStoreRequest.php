<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class PromoterStoreRequest extends FormRequest
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
    $promoter=User::role(['Coordinador de Ruta', 'Seccional', 'Líder'])->where([['slug', $this->slug], ['state', '1']])->first();
    $required="nullable";
    if ($promoter->roles[0]->name!='Líder') {
      $required="required";
    }

    return [
      'photo' => 'required|file|mimetypes:image/*',
      'name' => 'required|string|min:2|max:191',
      'lastname' => 'required|string|min:2|max:191',
      'phone' => 'required|string|min:5|max:15',
      'email' => $required.'|string|email|max:191|unique:users,email',
      'password' => $required.'|string|min:8|confirmed'
    ];
  }
}
