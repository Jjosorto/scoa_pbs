<?php

namespace App\Http\Controllers;

use App\Models\Activo;
use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Modelo;
use Illuminate\Http\Request;

class ActivoController extends Controller
{
    public function index(){
        try{
        $activos = Activo::with("producto.modelos.marca", "producto.modelos.categoria", "cliente", "departamento")->get();
        return view("activos.index",compact("activos"));
        // return response()->json(["error"=> $activos],200); 
        }
        catch(\Throwable $th){
            return response()->json(["error"=> $th->getMessage()],500);               
        }
    }

    public function activosByFecha(Request $request){
        try{
            $fechaInicio = $request->fechaInicio;
            $fechaFinal = $request->fechaFinal;

    
            $activos = Activo::with("producto.modelos.marca", "producto.modelos.categoria", "cliente", "departamento")
                        ->whereBetween('fechaDeCompra', [$fechaInicio, $fechaFinal])
                        ->get();
    
            // return view("activos.index",compact("activos"));
            return response()->json(["activos"=> $activos],200); 
        }
        catch(\Throwable $th){
            return response()->json(["error"=> $th->getMessage()],500);               
        }
    }
    

    public function create(){
        try{
            $categorias = Categoria::where("estadoCategoria",1)->get();
            $marcas = Marca::where("estadoMarca",1)->get();
            return view("modelos.create", compact("categorias","marcas"));
        }
        catch(\Throwable $th){
            return response()->json(["error"=> $th->getMessage()],500);
    }
}
    public function store(Request $request){
        try{
            $request ->validate([
                'nombreModelo'=> 'required',
                'id_marca'=> 'required',
                'id_categoria'=> 'required',
            ]);
            $modelos = new Modelo();
            $modelos -> nombreModelo = $request-> nombreModelo;
            $modelos-> estadoModelo = 1;
            $modelos-> marca_id = $request->id_marca;
            $modelos-> categoria_id = $request -> id_categoria;
            $modelos-> save();

        }catch(\Throwable $th){
            return response()->json(["error"=> $th->getMessage()],500);
        }
    }   
    public function edit($id){
        try{
            $modelo = Modelo::find($id);
            $categorias = Categoria::where("estadoCategoria",1)->get();
            $marcas = Marca::where("estadoMarca",1)->get();
            return view("modelos.edit",compact("modelo","categorias","marcas"));
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
            $modelo = Modelo::find($id);
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
            $modelo = Modelo ::find($id);
            $modelo -> estadoModelo = 0;
            $modelo -> save();
            return response()->json(['message'=> 'Desactivado correctamente'],200);
        }
        catch(\Throwable $th){
            return response()->json(["error"=>$th->getMessage()],500);
        }
    }
}
