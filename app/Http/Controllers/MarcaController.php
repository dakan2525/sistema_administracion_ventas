<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Models\Caracteristica;
use Illuminate\Http\Request;
use App\Models\Marca;
use Exception;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\DB;

class MarcaController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:ver-marca|crear-marca|editar-marca|eliminar-marca', ['only' => ['index']]);
        $this->middleware('permission:crear-marca', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-marca', ['only' => ['edit', 'update']]);
        $this->middleware('permission:eliminar-marca', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $marcas = Marca::with('caracteristica')->latest()->get();
        return view('marca.index', compact('marcas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('marca.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoriaRequest $request)
    {
        try {
            DB::beginTransaction();
            $caracteristica = Caracteristica::create($request->Validated());
            $caracteristica->marca()->create(['caracteristica_id' => $caracteristica->id]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }

        return redirect()->route('marca.index')->with('success', 'Marca creada correctamente');
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
        $marca = Marca::find($id);
        return view('marca.edit', ['marca' => $marca]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoriaRequest $request, Marca $marca)
    {
        $id = $marca->caracteristica->id;

        $caracteristica = Caracteristica::find($id);
        $caracteristica->nombre = $request->nombre;
        $caracteristica->descripcion = $request->descripcion;
        $caracteristica->save();

        return redirect()->route('marca.index')->with('success', 'Marca actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $marca = Marca::find($id);
        Caracteristica::where('id', $marca->caracteristica->id)->update([
            'estado' => $marca->caracteristica->estado == 1 ? 0 : 1
        ]);
        return redirect()->route('marca.index')->with('success', $marca->caracteristica->estado == 1 ? 'marca eliminada correctamente' : 'marca restaurada correctamente');
    }
}
