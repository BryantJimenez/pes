<?php

namespace App\Http\Controllers;

use App\Zip;
use App\Http\Requests\ZipStoreRequest;
use App\Http\Requests\ZipUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ZipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $zips=Zip::orderBy('id', 'DESC')->get();
        return view('admin.zips.index', compact('zips'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admin.zips.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ZipStoreRequest $request) {
        $count=Zip::where('name', request('name'))->withTrashed()->count();
        $slug=Str::slug(request('name'), '-');
        if ($count>0) {
            $slug=$slug."-".$count;
        }

        // Validación para que no se repita el slug
        $num=0;
        while (true) {
            $count2=Zip::where('slug', $slug)->withTrashed()->count();
            if ($count2>0) {
                $slug=Str::slug(request('name'), '-')."-".$num;
                $num++;
            } else {
                $data=array('name' => request('name'), 'slug' => $slug);
                break;
            }
        }

        $zip=Zip::create($data);

        if ($zip) {
            return redirect()->route('postales.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Registro exitoso', 'msg' => 'El código postal ha sido registrado exitosamente.']);
        } else {
            return redirect()->route('postales.create')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Registro fallido', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.'])->withInputs();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug) {
        $zip=Zip::where('slug', $slug)->firstOrFail();
        return view('admin.zips.edit', compact("zip"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ZipUpdateRequest $request, $slug) {
        $zip=Zip::where('slug', $slug)->firstOrFail();
        $data=array('name' => request('name'));
        $zip->fill($data)->save();

        if ($zip) {
            return redirect()->route('postales.edit', ['slug' => $slug])->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'El código postal ha sido editado exitosamente.']);
        } else {
            return redirect()->route('postales.edit', ['slug' => $slug])->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    public function destroy($slug)
    {
        $zip=Zip::where('slug', $slug)->firstOrFail();
        $zip->delete();

        if ($zip->colonies()->withTrashed()->count()==0) {
            $zip->forceDelete();
        }

        if ($zip) {
            return redirect()->route('postales.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Eliminación exitosa', 'msg' => 'El código postal ha sido eliminado exitosamente.']);
        } else {
            return redirect()->route('postales.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Eliminación fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    public function deactivate(Request $request, $slug) {
        $zip=Zip::where('slug', $slug)->firstOrFail();
        $zip->fill(['state' => "0"])->save();

        if ($zip) {
            return redirect()->route('postales.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'El código postal ha sido desactivado exitosamente.']);
        } else {
            return redirect()->route('postales.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    public function activate(Request $request, $slug) {
        $zip=Zip::where('slug', $slug)->firstOrFail();
        $zip->fill(['state' => "1"])->save();

        if ($zip) {
            return redirect()->route('postales.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'El código postal ha sido activado exitosamente.']);
        } else {
            return redirect()->route('postales.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }
}
