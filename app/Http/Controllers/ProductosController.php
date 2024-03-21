<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
  public function index(){
        try{
        $productos = Producto::with("modelos.marca", "modelos.categoria")->get();
        return view("productos.index",compact("productos"));
        // return response()->json(["error"=> $productos],200); 
    }
    catch(\Throwable $th){
        return response()->json(["error"=> $th->getMessage()],500);               
    }
}
public function create(){
    try{
        $modelos = Modelo::where("estadoModelo",1)
        ->with("marca","categoria")
        ->get();
        return view("productos.create", compact("modelos"));
        // return response()->json(["error"=> $modelos],200); 
        }
        catch(\Throwable $th){
            return response()->json(["error"=> $th->getMessage()],500);
    }
}
    public function store(Request $request){
        try{
            $request ->validate([
                'nombreProducto'=> 'required',
                'serie'=> 'required',
                'ram'=> 'required',
                'procesador'=> 'required',
                'tipoDisco'=> 'required',
                'capacidadDisco'=> 'required',
                'descripcion'=> 'required',
                'id_modelo'=> 'required',
            ]);
            $productos = new Producto();
            $productos -> nombre = $request-> nombreProducto;
            $productos -> serie = $request-> serie;
            $productos -> ram = $request-> ram;
            $productos -> procesador = $request-> procesador;
            $productos-> estadoProductos = 1;
            $productos-> descripcion = $request->descripcion;
            $productos-> modelo_id = $request->id_modelo;
            $productos-> save();

        }catch(\Throwable $th){
            return response()->json(["error"=> $th->getMessage()],500);
        }
    }   
    public function edit($id){
        try{
            $producto = Producto::find($id);
            $modelo = Modelo::where("estadoModelo",1)->get();
            return view("productos.edit",compact("producto","modelo"));
        }
        catch(\Throwable $th){
            return response()->json(["error"=>$th ->getMessage()],500);
        }
    }

    public function update(Request $request, $id){
        try{
            $request ->validate([
                'nombreModelo'=> 'required',
                'id_marca'=> 'required',
                'id_categoria'=> 'required',
            ]);
            $modelo = Producto::find($id);
            $modelo -> nombreModelo = $request->nombreModelo;
            $modelo -> estadoModelo = $request-> estadoModelo;
            $modelo-> marca_id = $request->id_marca;
            $modelo-> categoria_id = $request -> id_categoria;
            $modelo -> save();
            return response()->json(['message'=> 'Actualizado correctamente'], 200);

        }
        catch(\Throwable $th){
            return response()->json(["error"=>$th->getMessage()],500);
        }
    }
    public function desactive($id){
        try{
            $modelo = Producto ::find($id);
            $modelo -> estadoModelo = 0;
            $modelo -> save();
            return response()->json(['message'=> 'Desactivado correctamente'],200);
        }
        catch(\Throwable $th){
            return response()->json(["error"=>$th->getMessage()],500);
        }
    }
}
