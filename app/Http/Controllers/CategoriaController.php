<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Models\Caracteristica;
use Exception;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelIgnition\Http\Requests\UpdateConfigRequest;

class CategoriaController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:ver-categoria|crear-categoria|editar-categoria|eliminar-categoria', ['only' => ['index']]);
        $this->middleware('permission:crear-categoria', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-categoria', ['only' => ['edit', 'update']]);
        $this->middleware('permission:eliminar-categoria', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Recupera todas las categorías con sus características relacionadas
        $categorias = Categoria::with('caracteristica')->latest()->get();

        // Devuelve la vista 'categoria.index' con las categorías cargadas
        return view('categoria.index', compact('categorias'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categoria.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoriaRequest $request)
    {
        // dd($request);
        try {
            DB::beginTransaction();
            $caracteristica = Caracteristica::create($request->validated());
            $caracteristica->categoria()->create(['caracteristica_id' => $caracteristica->id]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }

        return redirect()->route('categoria.index')->with('success', 'Categoria creada correctamente');
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
        $categoria = Categoria::find($id);
        return view('categoria.edit', ['categoria' => $categoria]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoriaRequest $request, Categoria $categorium)
    {
        $id = $categorium->caracteristica->id;

        $caracteristica = Caracteristica::find($id);
        $caracteristica->nombre = $request->nombre;
        $caracteristica->descripcion = $request->descripcion;
        $caracteristica->save();


        return redirect()->route('categoria.index')->with('success', 'Categoria actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $categoria = Categoria::find($id);
        Caracteristica::where('id', $categoria->caracteristica->id)->update([
            'estado' => $categoria->caracteristica->estado == 1 ? 0 : 1
        ]);
        return redirect()->route('categoria.index')->with('success', $categoria->caracteristica->estado == 1 ? 'Categoria eliminada correctamente' : 'Categoria restaurada correctamente');
    }
}
