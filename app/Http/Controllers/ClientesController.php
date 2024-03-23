<?php
namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClientesController extends Controller
{
    public function index(){
        try{
           $clientes = Cliente::all();
        return view("clientes.index",compact("clientes"));
        }
        catch(\Throwable $th){
            return response()->json(["error"=> $th->getMessage()],500);               
        }
    }
    public function create(){
        try{
            return view("clientes.create");
        }
        catch(\Throwable $th){
            return response()->json(["error"=> $th->getMessage()],500);
    }
}
    public function store(Request $request){
        try{
            $request ->validate([
                'nombre'=> 'required',
                'telefono'=> 'required',
            ]);
            $cliente = new Cliente();
            $cliente-> nombre = $request-> nombre;
            $cliente -> telefono = $request-> telefono;
            $cliente -> direccion = $request-> direccion;
            $cliente -> correo = $request-> correo;
            $cliente -> estado = 1;
            $cliente -> save();
            return response()->json(['message'=> 'creado correctamente'], 200);
        }catch(\Throwable $th){
            return response()->json(["error"=> $th->getMessage()],500);
        }
    }   
    public function edit($id){
        try{
            $cliente = Cliente::find($id);
            return view("clientes.edit",compact("cliente"));
        }
        catch(\Throwable $th){
            return response()->json(["error"=>$th ->getMessage()],500);
        }
    }

    public function update(Request $request, $id){
        try{
            $request ->validate([
                'nombre'=> 'required',
                'telefono'=> 'required',
            ]);
            $cliente = Cliente::find($id);
            $cliente -> nombre = $request->nombre;
            $cliente -> telefono = $request->telefono;
            $cliente -> direccion = $request->direccion;
            $cliente -> correo = $request->correo;
            $cliente -> estado = $request-> estado;
            $cliente -> save();
            return response()->json(['message'=> 'Actualizado correctamente'], 200);

        }
        catch(\Throwable $th){
            return response()->json(["error"=>$th->getMessage()],500);
        }
    }
    public function desactive($id){
        try{
            $cliente = Cliente::find($id);
            $cliente -> estado = 0;
            $cliente -> save();
            return response()->json(['message'=> 'Desactivado correctamente'],200);
        }
        catch(\Throwable $th){
            return response()->json(["error"=>$th->getMessage()],500);
        }
    }


}
