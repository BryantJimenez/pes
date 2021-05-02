<?php

namespace App\Http\Controllers;

use App\Zip;
use App\Colony;
use App\Http\Requests\ColonyStoreRequest;
use App\Http\Requests\ColonyUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ColonyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $colonies=Colony::with(['zip'])->orderBy('id', 'DESC')->get();
        return view('admin.colonies.index', compact('colonies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $zips=Zip::where('state', '1')->get();
        return view('admin.colonies.create', compact('zips'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ColonyStoreRequest $request) {
        $count=Colony::where('name', request('name'))->withTrashed()->count();
        $slug=Str::slug(request('name'), '-');
        if ($count>0) {
            $slug=$slug."-".$count;
        }

        // Validación para que no se repita el slug
        $num=0;
        while (true) {
            $count2=Colony::where('slug', $slug)->withTrashed()->count();
            if ($count2>0) {
                $slug=Str::slug(request('name'), '-')."-".$num;
                $num++;
            } else {
                $zip=Zip::where('slug', request('zip_id'))->first();
                $data=array('name' => request('name'), 'slug' => $slug, 'zip_id' => $zip->id);
                break;
            }
        }

        $colony=Colony::create($data);

        if ($colony) {
            return redirect()->route('colonias.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Registro exitoso', 'msg' => 'La colonia ha sido registrada exitosamente.']);
        } else {
            return redirect()->route('colonias.create')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Registro fallido', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.'])->withInputs();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug) {
        $colony=Colony::where('slug', $slug)->firstOrFail();
        $zips=Zip::where('state', '1')->get();
        return view('admin.colonies.edit', compact("colony", "zips"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ColonyUpdateRequest $request, $slug) {
        $colony=Colony::where('slug', $slug)->firstOrFail();
        $zip=Zip::where('slug', request('zip_id'))->first();
        $data=array('name' => request('name'), 'zip_id' => $zip->id);
        $colony->fill($data)->save();

        if ($colony) {
            return redirect()->route('colonias.edit', ['slug' => $slug])->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'La colonia ha sido editada exitosamente.']);
        } else {
            return redirect()->route('colonias.edit', ['slug' => $slug])->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    public function destroy($slug)
    {
        $colony=Colony::where('slug', $slug)->firstOrFail();
        $colony->delete();

        if ($colony) {
            if ($colony->sections()->withTrashed()->count()==0) {
                $colony->forceDelete();
            }
            return redirect()->route('colonias.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Eliminación exitosa', 'msg' => 'La colonia ha sido eliminada exitosamente.']);
        } else {
            return redirect()->route('colonias.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Eliminación fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    public function deactivate(Request $request, $slug) {
        $colony=Colony::where('slug', $slug)->firstOrFail();
        $colony->fill(['state' => "0"])->save();

        if ($colony) {
            return redirect()->route('colonias.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'La colonia ha sido desactivada exitosamente.']);
        } else {
            return redirect()->route('colonias.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    public function activate(Request $request, $slug) {
        $colony=Colony::where('slug', $slug)->firstOrFail();
        $colony->fill(['state' => "1"])->save();

        if ($colony) {
            return redirect()->route('colonias.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'La colonia ha sido activada exitosamente.']);
        } else {
            return redirect()->route('colonias.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }
}
