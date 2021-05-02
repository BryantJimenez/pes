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

class UserUpdateRequest extends FormRequest
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
        $user=User::where('slug', $this->slug)->first();
        $roles=Role::all()->pluck('name');
        $colonies=Colony::where('state', '1')->get()->pluck('slug');
        $colony=Colony::where([['state', '1'], ['slug', $this->colony_id]])->first();
        if (!is_null($colony)) {
            $sections=$colony->sections()->where('state', '1')->get()->pluck('slug');
        } else {
            $sections=Section::where('state', '1')->get()->pluck('slug');
        }

        if($user->roles[0]->name=="Promovido" || $user->roles[0]->name=="Líder" || $user->roles[0]->name=="Seccional") {
            if ($user->roles[0]->name=="Seccional") {
                $rol="Coordinador de Ruta";
            } elseif ($user->roles[0]->name=="Líder") {
                $rol="Seccional";
            } elseif ($user->roles[0]->name=="Promovido") {
                $rol="Líder";
            }
            $promoters=User::role($rol)->where([['slug', '!=', $this->slug], ['state', '1']])->get()->pluck('slug');
        } else {
            $promoters=[];
        }
        return [
            'photo' => 'nullable|file|mimetypes:image/*',
            'name' => 'required|string|min:2|max:191',
            'lastname' => 'required|string|min:2|max:191',
            'phone' => 'required|string|min:5|max:15',
            'type' => Rule::requiredIf(Auth::user()->hasRole(['Super Admin'])).'|'.Rule::in($roles),
            'promoter' => Rule::requiredIf(Auth::user()->hasRole(['Super Admin']) && ($user->roles[0]->name=="Promovido" || $user->roles[0]->name=="Líder" || $user->roles[0]->name=="Seccional")).'|'.Rule::in($promoters),
            'colony_id' => Rule::requiredIf(Auth::user()->hasRole(['Super Admin'])).'|'.Rule::in($colonies),
            'section_id' => Rule::requiredIf(Auth::user()->hasRole(['Super Admin'])).'|'.Rule::in($sections),
            'state' => 'required|'.Rule::in(['0', '1']),
            'email' => Rule::requiredIf(empty($user->email) && $user->roles[0]->name!="Promovido").'|string|email|max:191|unique:users,email',
            'password' => 'nullable|string|min:8|confirmed'
        ];
    }
}
