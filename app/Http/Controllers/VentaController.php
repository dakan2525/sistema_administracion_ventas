<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVentaRequest;
use App\Models\Cliente;
use App\Models\Comprobante;
use App\Models\Producto;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Venta;

use function Laravel\Prompts\select;

class VentaController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-venta|crear-venta|mostrar-venta|eliminar-venta', ['only' => ['index']]);
        $this->middleware('permission:crear-venta', ['only' => ['create', 'store']]);
        $this->middleware('permission:mostrar-venta', ['only' => ['show']]);
        $this->middleware('permission:eliminar-venta', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ventas = Venta::with('comprobante', 'productos', 'cliente.persona', 'user')->where('estado', 1)->latest()->get();
        return view('venta.index', compact('ventas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $subquery = DB::table('compra_producto')
            ->select('producto_id', DB::raw('MAX(created_at) as max_created_at'))
            ->groupBy('producto_id');

        $productos = Producto::join('compra_producto as cpr', function ($join) use ($subquery) {
            $join->on('cpr.producto_id', '=', 'productos.id')
                ->whereIn('cpr.created_at', function ($query) use ($subquery) {
                    $query->select('max_created_at')
                        ->from($subquery, 'subquery') // Cambia "sunquery" a "subquery"
                        ->whereRaw('subquery.producto_id = cpr.producto_id'); // Usa "subquery" en lugar de "sunquery"
                });
        })->select('productos.nombre', 'productos.id', 'productos.stock', 'cpr.precio_venta')
            ->where('productos.estado', 1)
            ->where('productos.stock', '>', 0)
            ->get();



        $clientes = Cliente::whereHas('persona', function ($query) {
            $query->where('estado', 1);
        })->get();
        $comprobantes = Comprobante::all();
        return view('venta.create', compact('productos', 'clientes', 'comprobantes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVentaRequest $request)
    {
        try {
            DB::beginTransaction();

            //llenar mi tabla venta
            $venta = Venta::create($request->validated());

            //llenar mi tabla_producto
            //1. recuperar los arrays
            $arrayProducto_id = $request->get('arrayidproducto');
            $arrayCantidad = $request->get('arraycantidad');
            $arrayPrecioVenta = $request->get('arrayprecioventa');
            $arrayDescuento = $request->get('arraydescuento');

            //2. Realizar el llenado 
            $siseArray = count($arrayProducto_id);
            $contador = 0;

            for ($i = 0; $i < $siseArray; $i++) {
                $venta->productos()->syncWithoutDetaching([
                    $arrayProducto_id[$contador] => [
                        'cantidad' => $arrayCantidad[$contador],
                        'precio_venta' => $arrayPrecioVenta[$contador],
                        'descuento' => $arrayDescuento[$contador]
                    ]
                ]);

                //actualizar stock 
                $producto = Producto::find($arrayProducto_id[$contador]);
                $stockActual = $producto->stock;
                $cantidad = intval($arrayCantidad[$contador]);

                DB::table('productos')
                    ->where('id', $producto->id)
                    ->update([
                        'stock' => $stockActual - $cantidad
                    ]);
                $contador++;
            }


            DB::commit();
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
        }

        return redirect()->route('venta.index')->with('success', 'Venta exitosa');
    }
    /**
     * Display the specified resource.
     */
    public function show(Venta $ventum)
    {
        $venta = $ventum;
        return view('venta.show', compact('venta'));
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
    public function destroy(Venta $ventum)
    {
        $venta = $ventum;
        $arrayId = [];
        $arrayCantidad = [];
        $i = 0;

        foreach ($venta->productos as $item) {
            $arrayCantidad[$i] = $item->pivot->cantidad;
            $arrayId[$i] = $item->pivot->producto_id;
            $i++;
        }
        for ($i = 0; $i < count($arrayId); $i++) {
            $producto = Producto::find($arrayId[$i]);
            $stockActual = $producto->stock;
            $cantidadVendida = intval($arrayCantidad[$i]);

            DB::table('productos')
                ->where('id', $producto->id)
                ->update([
                    'stock' => $stockActual + $cantidadVendida
                ]);
        }
        Venta::where('id', $venta->id)->update([
            'estado' => 0
        ]);
        return redirect()->route('venta.index')->with('success', 'Venta eliminada correctamente');
    }
}
