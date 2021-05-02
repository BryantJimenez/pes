<?php

namespace App\Http\Controllers;

use App\User;
use App\Section;
use App\Leader;
use App\Http\Requests\PromoterStoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Auth;

class WebController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        if (Auth::check()) {
            return redirect()->route('admin');
        }
        return redirect()->route('login');
    }

    public function promoter($slug) {
        $user=User::with(['section', 'colony', 'colony.zip'])->role(['Coordinador de Ruta', 'Seccional', 'Líder'])->where([['slug', $slug], ['state', '1']])->firstOrFail();
        return view('web.promoter', compact('user'));
    }

    public function promoterStore(PromoterStoreRequest $request, $slug) {
        $promoter=User::role(['Coordinador de Ruta', 'Seccional', 'Líder'])->where([['slug', $slug], ['state', '1']])->firstOrFail();
        $count=User::where('name', request('name'))->where('lastname', request('lastname'))->withTrashed()->count();
        $slug=Str::slug(request('name')." ".request('lastname'), '-');
        if ($count>0) {
            $slug=$slug."-".$count;
        }

        // Validación para que no se repita el slug
        $num=0;
        while (true) {
            $count2=User::where('slug', $slug)->withTrashed()->count();
            if ($count2>0) {
                $slug=Str::slug(request('name')." ".request('lastname'), '-')."-".$num;
                $num++;
            } else {
                $section=Section::where('id', $promoter->section_id)->firstOrFail();
                $data=array('name' => request('name'), 'lastname' => request('lastname'), 'slug' => $slug, 'phone' => request('phone'), 'section_id' => $section->id, 'email' => request('email'), 'password' => Hash::make(request('password')));
                break;
            }
        }

        // Mover imagen a carpeta users y extraer nombre
        if ($request->hasFile('photo')) {
            $file=$request->file('photo');
            $data['photo']=store_files($file, $slug, '/admins/img/users/');
        }

        $user=User::create($data);

        if ($user) {
            if($promoter->roles[0]->name=="Coordinador de Ruta") {
                $user->assignRole("Seccional");
                $rol="Seccional";
            } elseif($promoter->roles[0]->name=="Seccional") {
                $user->assignRole("Líder");
                $rol="Líder";
            } else {
                $user->assignRole("Promovido");
                $rol="Promovido";
            }

            $data=array('leader_id' => $promoter->id, 'user_id' => $user->id, 'rol' => $rol);
            Leader::create($data);
            
            return view('web.success');
        } else {
            return redirect()->route('web.promoter', ['slug' => $promoter->slug])->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Registro fallido', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.'])->withInputs();
        }
    }

    public function success() {
        return view('web.success');
    }
}