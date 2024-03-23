<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

class MarcasController extends Controller
{
    public function index(){
        try{
           $marcas = Marca::all();
        return view("marcas.index",compact("marcas"));
        }
        catch(\Throwable $th){
            return response()->json(["error"=> $th->getMessage()],500);               
        }
    }
    public function create(){
        try{
            return view("marcas.create");
        }
        catch(\Throwable $th){
            return response()->json(["error"=> $th->getMessage()],500);
    }
}
    public function store(Request $request){
        try{
            $request ->validate([
                'nombreMarca'=> 'required',
            ]);
            $marcas = new Marca();
            $marcas -> nombreMarca = $request-> nombreMarca;
            $marcas-> estadoMarca = 1;
            $marcas-> save();
            return response()->json(['message'=> 'creado correctamente'], 200);
        }catch(\Throwable $th){
            return response()->json(["error"=> $th->getMessage()],500);
        }
    }   
    public function edit($id){
        try{
            $marca = Marca::find($id);
            return view("marcas.edit",compact("marca"));
        }
        catch(\Throwable $th){
            return response()->json(["error"=>$th ->getMessage()],500);
        }
    }

    public function update(Request $request, $id){
        try{
            $request ->validate([
                'nombreMarca'=> 'required',
            ]);
            $marca = Marca::find($id);
            $marca -> nombreMarca = $request->nombreMarca;
            $marca -> estadoMarca = $request-> estadoMarca;
            $marca -> save();
            return response()->json(['message'=> 'Actualizado correctamente'], 200);

        }
        catch(\Throwable $th){
            return response()->json(["error"=>$th->getMessage()],500);
        }
    }
    public function desactive($id){
        try{
            $marca = Marca::find($id);
            $marca -> estadoMarca = 0;
            $marca -> save();
            return response()->json(['message'=> 'Desactivado correctamente'],200);
        }
        catch(\Throwable $th){
            return response()->json(["error"=>$th->getMessage()],500);
        }
    }
}
