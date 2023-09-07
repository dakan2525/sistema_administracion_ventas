<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Models\Caracteristica;
use App\Models\Presentacione;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use FFI\Exception;
use Spatie\LaravelIgnition\Http\Requests\UpdateConfigRequest;

class PresentacioneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $presentaciones = Presentacione::with('caracteristica')->latest()->get();
        return view('presentacion.index', compact('presentaciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('presentacion.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoriaRequest $request)
    {
        try {
            DB::beginTransaction();
            $caracteristica = Caracteristica::create($request->Validated());
            $caracteristica->presentacione()->create(['caracteristica_id' => $caracteristica->id]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }

        return redirect()->route('presentacion.index')->with('success', 'Presentación creada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $presentacion = Presentacione::find($id);
        return view('presentacion.edit', ['presentacion' => $presentacion]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoriaRequest $request, Presentacione $presentacion)
    {
        $id = $presentacion->caracteristica->id;

        $caracteristica = Caracteristica::find($id);
        $caracteristica->nombre = $request->nombre;
        $caracteristica->descripcion = $request->descripcion;
        $caracteristica->save();

        return redirect()->route('presentacion.index')->with('success', 'Presentación actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $presentacion = Presentacione::find($id);
        Caracteristica::where('id', $presentacion->caracteristica->id)->update([
            'estado' => $presentacion->caracteristica->estado == 1 ? 0 : 1
        ]);
        return redirect()->route('presentacion.index')->with('success', $presentacion->caracteristica->estado == 1 ? 'Presentación eliminada correctamente' : 'Presentacion restaurada correctamente');
    }
}
