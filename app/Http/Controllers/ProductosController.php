<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductosController extends Controller
{
    public function index()
    {
        try {
            $productos = Producto::with("modelos.marca", "modelos.categoria")->get();
            return view("productos.index", compact("productos"));
            // return response()->json(["error"=> $productos],200); 
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 500);
        }
    }
    public function create()
    {
        try {
            $modelos = Modelo::where("estadoModelo", 1)
                ->with("marca", "categoria")
                ->get();
            return view("productos.create", compact("modelos"));
            // return response()->json(["error"=> $modelos],200); 
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 500);
        }
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombreProducto' => 'required',
                'serie' => 'required',
                'descripcion' => 'required',
                'id_modelo' => 'required',
            ]);
            $producto = new Producto();
            $producto->nombre = $request->nombreProducto;
            $producto->serie = $request->serie;
            $producto->ram = $request->ram;
            $producto->procesador = $request->procesador;
            $producto->estadoProductos = 1;
            $producto->descripcion = $request->descripcion;
            $producto->modelo_id = $request->id_modelo;
            $producto->tipoDisco = $request->tipoDisco;
            $producto->capacidadDisco = $request->capacidadDisco;
            
            if ($request->hasFile('imagen_producto')) {
                $imagenProducto = $request->file('imagen_producto');
                $nombreImagen = time() . '_' . $imagenProducto->getClientOriginalName();
                $rutaimagenProducto = $imagenProducto->storeAs('public/images/productos', $nombreImagen);
                $producto->nombreImagen = $nombreImagen;
            }
            
            
            $producto->save();
            return response()->json(['message'=> 'creado correctamente'], 200);
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 500);
        }
    }
    public function edit($id)
    {
        try {
            $producto = Producto::with("modelos.marca", "modelos.categoria")->find($id);
            $modelos = Modelo::where("estadoModelo", 1)->get();
            return view("productos.edit", compact("producto", "modelos"));
            // return response()->json(["error"=> $modelos],200); 
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nombreProducto' => 'required',
                'serie' => 'required',
                'descripcion' => 'required',
                'id_modelo' => 'required',
            ]);
            $producto = Producto::find($id);
            $producto->nombre = $request->nombreProducto;
            $producto->serie = $request->serie;
            $producto->ram = $request->ram;
            $producto->procesador = $request->procesador;
            $producto->estadoProductos = 1;
            $producto->descripcion = $request->descripcion;
            $producto->modelo_id = $request->id_modelo;
            $producto->capacidadDisco = $request->capacidadDisco;
            $producto->tipoDisco = $request->tipoDisco;
            $producto->estadoProductos = $request->estadoProductos;

            if ($request->hasFile('nueva_imagen')) {
                if (Storage::exists('public/images/productos/' . $producto->nombreImagen)) {
                    Storage::delete('public/images/productos/' . $producto->nombreImagen);
                }

                $imagenProduto = $request->file('nueva_imagen');
                $nombreImagenHistoria = time() . '_' . $imagenProduto->getClientOriginalName();
                $rutaImagenHistoria = $imagenProduto->storeAs('public/images/productos', $nombreImagenHistoria);
                $producto->nombreImagen = basename($rutaImagenHistoria);
            }

            $producto -> save();
            return response()->json(['message' => 'Actualizado correctamente'], 200);
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 500);
        }
    }
    public function desactive($id)
    {
        try {
            $producto = Producto::find($id);
            $producto->estadoProductos = 0;
            $producto->save();
            return response()->json(['message' => 'Desactivado correctamente'], 200);
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 500);
        }
    }
}
