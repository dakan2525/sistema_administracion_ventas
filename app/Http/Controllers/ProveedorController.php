<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedore;
use App\Models\Documento;
use Illuminate\Support\Facades\DB;
use App\Models\Persona;
use Exception;
use App\Http\Requests\StorePersonaRequest;
use App\Http\Requests\UpdateProveedorRequest;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proveedores = Proveedore::with('persona.documento')->get();
        return view('proveedor.index', compact('proveedores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $documentos = Documento::all();
        return view('proveedor.create', compact('documentos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePersonaRequest $request)
    {
        try {
            DB::beginTransaction();
            $persona = Persona::create($request->validated());
            $persona->proveedore()->create([
                'persona_id' => $persona->id
            ]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }

        return redirect()->route('proveedor.index')->with('success', 'Proveedor registrado exitosamente');
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
    public function edit(Proveedore $proveedor)
    {
        $documentos = Documento::all();
        return view('proveedor.edit', compact('proveedor', 'documentos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProveedorRequest $request,  Proveedore $proveedor)
    {
        try {
            DB::beginTransaction();
            Persona::where('id', $proveedor->persona->id)->update($request->validated());

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }

        return redirect()->route('proveedor.index')->with('success', $proveedor->persona->estado == 1 ? 'proveedores eliminado correctamente' : 'proveedores restaurado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proveedore $proveedor)
    {
        Persona::where('id', $proveedor->persona->id)->update([
            'estado' => $proveedor->persona->estado == 1 ? 0 : 1
        ]);
        return redirect()->route('proveedor.index')->with('success', $proveedor->persona->estado == 1 ? 'proveedor eliminado correctamente' : 'proveedor restaurado correctamente');
    }
}
