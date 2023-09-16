<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompraRequest;
use Illuminate\Http\Request;
use App\Models\Compra;
use App\Models\Comprobante;
use App\Models\Producto;
use App\Models\Proveedore;
use Exception;
use GrahamCampbell\ResultType\Success;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $compras = Compra::with('comprobante', 'productos', 'proveedore.persona')->latest()
            ->get();
        return view('compra.index', compact('compras'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $proveedores = Proveedore::whereHas('persona', function ($query) {
            $query->where('estado', 1);
        })->get();
        $comprobantes = Comprobante::all();
        $productos = Producto::where('estado', 1)->get();
        return view('compra.create', compact('proveedores', 'comprobantes', 'productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompraRequest $request)
    {
        try {
            DB::beginTransaction();

            $compra = Compra::create($request->validated());

            //llenar la tabla compra_productos
            //1. recuperar los array con los productos y cantidades 
            $arrayProducto_id = $request->get('arrayidproducto');
            $arrayCantidad = $request->get('arraycantidad');
            $arrayPrecioCompra = $request->get('arraypreciocompra');
            $arrayPrecioVenta = $request->get('arrayprecioventa');


            //2. realizar el llenado de la tabla
            $siseArray = count($arrayProducto_id);
            $cont = 0;
            while ($cont < $siseArray) {
                $compra->productos()->syncWithoutDetaching([
                    $arrayProducto_id[$cont] => [
                        'cantidad' => $arrayCantidad[$cont],
                        'precio_compra' => $arrayPrecioCompra[$cont],
                        'precio_venta' => $arrayPrecioVenta[$cont],
                    ]
                ]);


                //3. Actualizar el estock
                $producto = Producto::find($arrayProducto_id[$cont]);
                $stockActual = $producto->stock;
                $stockNuevo = intval($arrayCantidad[$cont]);

                DB::table('productos')
                    ->where('id', $producto->id)
                    ->update([
                        'stock' => $stockActual + $stockNuevo
                    ]);

                $cont++;
            }



            DB::commit();

            Log::info('Compra exitosa. Se agregaron ' . $siseArray . ' productos a la compra.');
        } catch (Exception $e) {
            Log::error('Error al guardar la compra: ' . $e->getMessage());
            DB::rollBack();
        }

        return redirect()->route('compra.index')->with('success', 'Compra exitosa');
    }

    /**
     * Display the specified resource.
     */
    public function show(Compra $compra)
    {
        // dd($compra->productos);
        return view('compra.show', compact('compra'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $compra = Compra::find($id);
        Compra::where('id', $compra->id)->update([
            'estado' => $compra->estado == 1 ? 0 : 1
        ]);
        return redirect()->route('compra.index')->with('success', $compra->estado == 1 ? 'Compra eliminada correctamente' : 'Compra restaurada correctamente');
    }
}
