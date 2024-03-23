<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriasController extends Controller
{
    public function index(){
        try{
           $categorias= Categoria::all();
        return view("categorias.index",compact("categorias"));
        }
        catch(\Throwable $th){
            return response()->json(["error"=> $th->getMessage()],500);               
        }
    }
    public function create(){
        try{
            return view("categorias.create");
        }
        catch(\Throwable $th){
            return response()->json(["error"=> $th->getMessage()],500);
    }
}
    public function store(Request $request){
        try{
            $request ->validate([
                'nombreCategoria'=> 'required',
            ]);
            $categoria = new Categoria();
            $categoria -> nombreCategoria = $request-> nombreCategoria;
            $categoria-> estadoCategoria = 1;
            $categoria-> save();
            return response()->json(['message'=> 'creado correctamente'], 200);
        }catch(\Throwable $th){
            return response()->json(["error"=> $th->getMessage()],500);
        }
    }   
    public function edit($id){
        try{
            $categoria = Categoria::find($id);
            return view("categorias.edit",compact("categoria"));
        }
        catch(\Throwable $th){
            return response()->json(["error"=>$th ->getMessage()],500);
        }
    }

    public function update(Request $request, $id){
        try{
            $request ->validate([
                'nombreCategoria'=> 'required',
            ]);
            $categoria = Categoria::find($id);
            $categoria -> nombreCategoria = $request->nombreCategoria;
            $categoria -> estadoCategoria = $request-> estadoCategoria;
            $categoria -> save();
            return response()->json(['message'=> 'Actualizado correctamente'], 200);

        }
        catch(\Throwable $th){
            return response()->json(["error"=>$th->getMessage()],500);
        }
    }
    public function desactive($id){
        try{
            $categoria = Categoria::find($id);
            $categoria -> estadoCategoria = 0;
            $categoria -> save();
            return response()->json(['message'=> 'Desactivado correctamente'],200);
        }
        catch(\Throwable $th){
            return response()->json(["error"=>$th->getMessage()],500);
        }
    }
}
