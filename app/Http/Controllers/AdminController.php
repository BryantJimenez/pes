<?php

namespace App\Http\Controllers;

use App\Zip;
use App\Colony;
use App\Section;
use App\User;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;

class AdminController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $zips=Zip::count();
        $colonies=Colony::count();
        $sections=Section::count();
        $users=User::count();
        return view('admin.home', compact('zips', 'colonies', 'sections', 'users'));
    }

    public function profile() {
        return view('admin.profile');
    }

    public function profileEdit() {
        return view('admin.edit');
    }

    public function profileUpdate(ProfileUpdateRequest $request) {
        $user=User::where('slug', Auth::user()->slug)->firstOrFail();
        $data=array('name' => request('name'), 'lastname' => request('lastname'), 'phone' => request('phone'));

        if (!is_null(request('password'))) {
            $data['password']=Hash::make(request('password'));
        }

        // Mover imagen a carpeta users y extraer nombre
        if ($request->hasFile('photo')) {
            $file=$request->file('photo');
            $data['photo']=store_files($file, $slug, '/admins/img/users/');
        }

        $user->fill($data)->save();

        if ($user) {
            if ($request->hasFile('photo')) {
                Auth::user()->photo=$data['photo'];
            }
            Auth::user()->name=request('name');
            Auth::user()->lastname=request('lastname');
            Auth::user()->phone=request('phone');
            if (!is_null(request('password'))) {
                Auth::user()->password=Hash::make(request('password'));
            }
            return redirect()->back()->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'El perfil ha sido editado exitosamente.']);
        } else {
            return redirect()->back()->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    public function emailVerifyAdmin(Request $request)
    {
        $count=User::where('email', request('email'))->count();
        if ($count>0) {
            return "false";
        } else {
            return "true";
        }
    }

    public function addColonies(Request $request) {
        $zip=Zip::where('slug', request('slug'))->first();
        if (!is_null($zip)) {
            $colonies=$zip->colonies()->select("slug", "name")->orderBy('name', 'DESC')->get();
            return response()->json(["state" => true, "data" => $colonies]);
        }

        return response()->json(["state" => false]);
    }

    public function addSections(Request $request) {
        $colony=Colony::where('slug', request('slug'))->first();
        if (!is_null($colony)) {
            $sections=$colony->sections()->select("slug", "name")->orderBy('name', 'DESC')->get();
            return response()->json(["state" => true, "data" => $sections]);
        }

        return response()->json(["state" => false]);
    }

    public function addPromoters(Request $request) {
        if (!Auth::user()->hasRole('Líder') && !empty(request('section'))) {
            $section=Section::where('slug', request('section'))->first();
        } else {
            $section=Section::where('id', Auth::user()->section_id)->first();
        }

        if (!is_null($section)) {
            if (request('rol')=="Seccional") {
                $rol="Coordinador de Ruta";
            } elseif (request('rol')=="Líder") {
                $rol="Seccional";
            } else {
                $rol="Líder";
            }
            $users=User::role($rol)->where('section_id', $section->id)->orderBy('name', 'DESC')->get();
            return response()->json(["state" => true, "data" => $users]);
        }

        return response()->json(["state" => false]);
    }
}
