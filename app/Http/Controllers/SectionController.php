<?php

namespace App\Http\Controllers;

use App\Colony;
use App\Section;
use App\ColonySection;
use App\Http\Requests\SectionStoreRequest;
use App\Http\Requests\SectionUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $sections=Section::with(['colonies', 'colonies.zip'])->orderBy('id', 'DESC')->get();
        return view('admin.sections.index', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $colonies=Colony::where('state', '1')->orderBy('name', 'ASC')->get();
        return view('admin.sections.create', compact('colonies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SectionStoreRequest $request) {
        $count=Section::where('name', request('name'))->withTrashed()->count();
        $slug=Str::slug(request('name'), '-');
        if ($count>0) {
            $slug=$slug."-".$count;
        }

        // Validación para que no se repita el slug
        $num=0;
        while (true) {
            $count2=Section::where('slug', $slug)->withTrashed()->count();
            if ($count2>0) {
                $slug=Str::slug(request('name'), '-')."-".$num;
                $num++;
            } else {
                $data=array('name' => request('name'), 'slug' => $slug);
                break;
            }
        }

        $section=Section::create($data);

        if ($section) {
            foreach (request('colony_id') as $slug_colony) {
                $colony=Colony::where('slug', $slug_colony)->first();
                if (!is_null($colony)) {
                    $data=array('colony_id' => $colony->id, 'section_id' => $section->id);
                    ColonySection::create($data)->save();
                }
            }

            return redirect()->route('secciones.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Registro exitoso', 'msg' => 'La sección ha sido registrada exitosamente.']);
        } else {
            return redirect()->route('secciones.create')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Registro fallido', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.'])->withInputs();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug) {
        $section=Section::with(['colonies'])->where('slug', $slug)->firstOrFail();
        $colonies=Colony::where('state', '1')->orderBy('name', 'ASC')->get();
        return view('admin.sections.edit', compact("section", "colonies"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SectionUpdateRequest $request, $slug) {
        $section=Section::where('slug', $slug)->firstOrFail();
        $data=array('name' => request('name'));
        $section->fill($data)->save();

        ColonySection::where('section_id', $section->id)->delete();
        foreach (request('colony_id') as $slug_colony) {
            $colony=Colony::where('slug', $slug_colony)->first();
            if (!is_null($colony)) {
                $data=array('colony_id' => $colony->id, 'section_id' => $section->id);
                ColonySection::create($data)->save();
            }
        }

        if ($section) {
            return redirect()->route('secciones.edit', ['slug' => $slug])->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'La sección ha sido editada exitosamente.']);
        } else {
            return redirect()->route('secciones.edit', ['slug' => $slug])->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    public function destroy($slug)
    {
        $section=Section::where('slug', $slug)->firstOrFail();
        $section->delete();

        if ($section->users()->withTrashed()->count()==0) {
            $section->forceDelete();
        }

        if ($section) {
            return redirect()->route('secciones.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Eliminación exitosa', 'msg' => 'La sección ha sido eliminada exitosamente.']);
        } else {
            return redirect()->route('secciones.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Eliminación fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    public function deactivate(Request $request, $slug) {
        $section=Section::where('slug', $slug)->firstOrFail();
        $section->fill(['state' => "0"])->save();

        if ($section) {
            return redirect()->route('secciones.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'La sección ha sido desactivada exitosamente.']);
        } else {
            return redirect()->route('secciones.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }

    public function activate(Request $request, $slug) {
        $section=Section::where('slug', $slug)->firstOrFail();
        $section->fill(['state' => "1"])->save();

        if ($section) {
            return redirect()->route('secciones.index')->with(['alert' => 'sweet', 'type' => 'success', 'title' => 'Edición exitosa', 'msg' => 'La sección ha sido activada exitosamente.']);
        } else {
            return redirect()->route('secciones.index')->with(['alert' => 'lobibox', 'type' => 'error', 'title' => 'Edición fallida', 'msg' => 'Ha ocurrido un error durante el proceso, intentelo nuevamente.']);
        }
    }
}
