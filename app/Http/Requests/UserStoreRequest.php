<?php

namespace App\Http\Requests;

use App\User;
use App\Colony;
use App\Section;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Auth;

class UserStoreRequest extends FormRequest
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
    $roles=Role::all()->pluck('name');
    $colony=Colony::where([['state', '1'], ['slug', $this->colony_id]])->first();
    $colonies=Colony::where('state', '1')->get()->pluck('slug');
    if (!is_null($colony)) {
      $sections=$colony->sections()->where('state', '1')->get()->pluck('slug');
    } else {
      $sections=Section::where('state', '1')->get()->pluck('slug');
    }

    $required="nullable";
    if (!Auth::user()->hasRole('Líder') && $this->type!="Promovido") {
      $required="required";
    }

    //Esta validacion hay que mejorarla
    if (!is_null($this->promoter) && !empty($this->promoter)) {
      if ($this->type=="Seccional") {
        $rol="Coordinador de Ruta";
      } elseif ($this->type=="Líder") {
        $rol="Seccional";
      } elseif ($this->type=="Promovido") {
        $rol="Líder";
      }
      $promoters=User::role($rol)->where('state', '1')->get()->pluck('slug');
    } else {
      $promoters=[];
    }

    if (Auth::user()->hasRole("Coordinador de Ruta")) {
      $rol="Seccional";
    } elseif (Auth::user()->hasRole("Seccional")) {
      $rol="Líder";
    } elseif (Auth::user()->hasRole("Líder")) {
      $rol="Promovido";
    } else {
      $rol=Auth::user()->roles->first()->name;
    }

    return [
      'photo' => 'nullable|file|mimetypes:image/*',
      'name' => 'required|string|min:2|max:191',
      'lastname' => 'required|string|min:2|max:191',
      'phone' => 'required|string|min:5|max:15',
      'type' => Rule::requiredIf(!Auth::user()->hasRole(['Coordinador de Ruta', 'Seccional', 'Líder'])).'|'.Rule::in($roles),
      'promoter' => Rule::requiredIf(!Auth::user()->hasRole('Líder') && $rol!=$this->type && $this->type!="Super Admin" && $this->type!="Administrador" && $this->type!="Analista" && $this->type!="Coordinador de Ruta").'|'.Rule::in($promoters),
      'colony_id' => Rule::requiredIf(!Auth::user()->hasRole(['Coordinador de Ruta', 'Seccional', 'Líder'])).'|'.Rule::in($colonies),
      'section_id' => Rule::requiredIf(!Auth::user()->hasRole(['Coordinador de Ruta', 'Seccional', 'Líder'])).'|'.Rule::in($sections),
      'email' => $required.'|string|email|max:191|unique:users,email',
      'password' => $required.'|string|min:8|confirmed'
    ];
  }
}
