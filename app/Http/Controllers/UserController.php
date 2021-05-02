<?php

namespace App\Http\Controllers;

use App\User;
use App\Zip;
use App\Colony;
use App\Section;
use App\Leader;
use Spatie\Permission\Models\Role;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;
use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        if (Auth::user()->hasRole(['Super Admin', 'Administrador', 'Analista'])) {
            $users=User::orderBy('id', 'DESC')->get();

        } elseif (Auth::user()->hasRole('Coordinador de Ruta')) {
            $user=User::with(['users.user.users.user.users.user'])->where('id', Auth::id())->firstOrFail();

            $num=0;
            $users=[];
            foreach ($user['users'] as $sectional) {
                if (!is_null($sectional['user'])) {
                    $users[$num]=$sectional['user'];
                    $num++;
                    foreach ($sectional['user']['users'] as $leader) {
                        if (!is_null($leader['user'])) {
                            $users[$num]=$leader['user'];
                            $num++;
                            foreach ($leader['user']['users'] as $promoted) {
                                if (!is_null($promoted['user'])) {
                                    $users[$num]=$promoted['user'];
                                    $num++;
                                }
                            }
                        }
                    }
                }
            }
            $users=collect($users)->sortByDesc('id')->values();

        } elseif (Auth::user()->hasRole('Seccional')) {
            $user=User::with(['users.user.users.user'])->where('id', Auth::id())->firstOrFail();

            $num=0;
            $users=[];
            foreach ($user['users'] as $leader) {
                if (!is_null($leader['user'])) {
                    $users[$num]=$leader['user'];
                    $num++;
                    foreach ($leader['user']['users'] as $promoted) {
                        if (!is_null($promoted['user'])) {
                            $users[$num]=$promoted['user'];
                            $num++;
                        }
                    }
                }
            }
            $users=collect($users)->sortByDesc('id')->values();

        } else {
            $user=User::with(['users.user'])->where('id', Auth::id())->firstOrFail();

            $num=0;
            $users=[];
            foreach ($user['users'] as $promoted) {
                if (!is_null($promoted['user'])) {
                    $users[$num]=$promoted['user'];
                    $num++;
                }
            }
            $users=collect($users)->sortByDesc('id')->values();
        }

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        if (Auth::user()->hasRole('Super Admin')) {
            $roles=Role::all()->pluck('name');
        } elseif (Auth::user()->hasRole('Administrador')) {
            $roles=Role::where('name', 'Administrador')->orWhere('name', 'Analista')->orWhere('name', 'Coordinador de Ruta')->orWhere('name', 'Seccional')->orWhere('name', 'Líder')->orWhere('name', 'Promovido')->get()->pluck('name');
        } elseif (Auth::user()->hasRole('Analista')) {
            $roles=Role::where('name', 'Coordinador de Ruta')->orWhere('name', 'Seccional')->orWhere('name', 'Líder')->orWhere('name', 'Promovido')->get()->pluck('name');
        } elseif (Auth::user()->hasRole('Coordinador de Ruta')) {
            $roles=Role::where('name', 'Seccional')->orWhere('name', 'Líder')->orWhere('name', 'Promovido')->get()->pluck('name');
        } elseif (Auth::user()->hasRole('Seccional')) {
            $roles=Role::where('name', 'Líder')->orWhere('name', 'Promovido')->get()->pluck('name');
        } elseif (Auth::user()->hasRole('Líder')) {
            $roles=Role::where('name', 'Promovido')->get()->pluck('name');
        } else {
            $roles=[];
        }
        $colonies=Colony::where('state', '1')->orderBy('name', 'ASC')->get();
        return view('admin.users.create', compact('roles', 'colonies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request) {
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
                if (!Auth::user()->hasRole(['Coordinador de Ruta', 'Seccional', 'Líder'])) {
                    $colony_id=Colony::where('slug', request('colony_id'))->first()->id;
                    $section_id=Section::where('slug', request('section_id'))->first()->id;
                } else {
                    $colony_id=Auth::user()->colony_id;
                    $section_id=Auth::user()->section_id;
                }
                $data=array('name' => request('name'), 'lastname' => request('lastname'), 'slug' => $slug, 'phone' => request('phone'), 'colony_id' => $colony_id, 'section_id' => $section_id, 'email' => request('email'), 'password' => Hash::make(request('password')));
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
            if (!Auth::user()->hasRole('Líder')) {
                $user->assignRole(request('type'));
                $rol=request('type');
            } else {
                $user->assignRole("Promovido");
                $rol="Promovido";
            }

            if (!is_null(request('promoter')) && !empty(request('promoter'))) {
                $promoter=User::where('slug', request('promoter'))->first();
                $promoter=$promoter->id;
            } else {
                $promoter=Auth::id();
            }

            if ($rol!="Super Admin" && $rol!="Administrador" && $rol!="Analista" && $rol!="Coordinador de Ruta" && !is_null(request('promoter')) && !empty(request('promoter'))) {
                $data=array('leader_id' => $promoter, 'user_id' => $user->id, 'rol' => $rol);
                Leader::create($data);
            }
            
            return redirect()->route('usuarios.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Registro exitoso', 'msg' => 'El usuario ha sido registrado exitosamente.']);
        } else {
            return redirect()->route('usuarios.create')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Registro fallido', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.'])->withInputs();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug) {
        $user=User::with(['user', 'user.leader', 'section', 'colony', 'colony.zip'])->where('slug', $slug)->firstOrFail();
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug) {
        $user=User::with(['section', 'colony'])->where('slug', $slug)->firstOrFail();
        if (Auth::user()->id==$user->id) {
            return redirect()->route('profile.edit');
        }
        $roles=Role::all()->pluck('name');
        $colonies=Colony::where('state', '1')->orderBy('name', 'ASC')->get();
        return view('admin.users.edit', compact("user", "roles", "colonies"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $slug) {
        $user=User::where('slug', $slug)->firstOrFail();
        $data=array('name' => request('name'), 'lastname' => request('lastname'), 'phone' => request('phone'), 'state' => request('state'));

        if (Auth::user()->hasRole(['Super Admin'])) {
            $colony_id=Colony::where('slug', request('colony_id'))->first()->id;
            $section_id=Section::where('slug', request('section_id'))->first()->id;

            $data['colony_id']=$colony_id;
            $data['section_id']=$section_id;
        }

        if (!is_null(request('email'))) {
            $data['email']=request('email');
        }

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
            if (!is_null(request('type')) && !empty(request('type'))) {
                $user->syncRoles(request('type'));
                $rol=request('type');

                Leader::where('user_id', $user->id)->delete();
                if(!is_null(request('promoter')) && !empty(request('promoter')) && $rol!="Super Admin" && $rol!="Administrador" && $rol!="Analista" && $rol!="Coordinador de Ruta") {
                    $promoter=User::where('slug', request('promoter'))->first();
                    $promoter=$promoter->id;

                    $data=array('leader_id' => $promoter, 'user_id' => $user->id, 'rol' => $rol);
                    Leader::create($data);
                }
            }

            return redirect()->route('usuarios.edit', ['slug' => $slug])->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'El usuario ha sido editado exitosamente.']);
        } else {
            return redirect()->route('usuarios.edit', ['slug' => $slug])->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $user=User::where('slug', $slug)->firstOrFail();
        $user->delete();

        if ($user) {
            Leader::where('user_id', $user->id)->delete();
            if ($user->users->count()==0) {
                $user->forceDelete();
            }
            return redirect()->route('usuarios.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Eliminación exitosa', 'msg' => 'El usuario ha sido eliminado exitosamente.']);
        } else {
            return redirect()->route('usuarios.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Eliminación fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    public function deactivate(Request $request, $slug) {
        $user=User::where('slug', $slug)->firstOrFail();
        $user->fill(['state' => "0"])->save();

        if ($user) {
            return redirect()->route('usuarios.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'El usuario ha sido desactivado exitosamente.']);
        } else {
            return redirect()->route('usuarios.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    public function activate(Request $request, $slug) {
        $user=User::where('slug', $slug)->firstOrFail();
        $user->fill(['state' => "1"])->save();

        if ($user) {
            return redirect()->route('usuarios.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'El usuario ha sido activado exitosamente.']);
        } else {
            return redirect()->route('usuarios.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }
}
