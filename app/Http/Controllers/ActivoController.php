<?php

namespace App\Http\Controllers;

use App\Models\Activo;
use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Departamento;
use App\Models\HistoricoActivos;
use App\Models\Mantenimiento_activo;
use App\Models\Marca;
use App\Models\Modelo;
use App\Models\Producto;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ActivoController extends Controller
{
    public function index(){
        try{
        $activos = Activo::with("producto.modelos.marca", "producto.modelos.categoria", "cliente", "departamento")->get();
        $now = Carbon::now();
        return view("activos.index",compact("activos", "now"));
        // return response()->json(["error"=> $activos],200); 
        }
        catch(\Throwable $th){
            return response()->json(["error"=> $th->getMessage()],500);               
        }
    }


    

    public function create(){
        try{
            $clientes = Cliente::where("estado",1)->get();
            $departamentos = Departamento::where("estado",1)->get();
            $productos = Producto::where("estadoProductos",1)->get();
            return view("activos.create", compact("clientes","departamentos","productos"));
        }
        catch(\Throwable $th){
            return response()->json(["error"=> $th->getMessage()],500);
    }
}
    public function store(Request $request){
        try{
            $request ->validate([
                'fechaCompra'=> 'required',
                'idContabilidad'=> 'required',
                'estadoActivo'=> 'required',
                'ciudad'=> 'required',
                'cliente_id'=> 'required',
                'departamento_id'=> 'required',
                'producto_id'=> 'required',
                'garantia'=> 'required',
            ]);
            $activo = new Activo();
            $activo -> fechaDeCompra = $request-> fechaCompra;
            $activo-> idContabilidad = $request-> idContabilidad;
            $activo-> estadoActivo = $request->estadoActivo;
            $activo-> estado = 1;
            $activo-> cliente_id = $request -> cliente_id;
            $activo-> departamento_id = $request -> departamento_id;
            $activo-> producto_id = $request -> producto_id;
            $activo-> ciudad = $request -> ciudad;
            $activo-> garantia = $request -> garantia;
            $activo-> fecha_inicio_garantia = $request -> fecha_inicio_garantia;
            $activo-> fecha_final_garantia = $request -> fecha_final_garantia;
            $activo-> save();
            // return response()->json(['message'=> 'creado correctamente'], 200);
        }catch(\Throwable $th){
            return response()->json(["error"=> $th->getMessage()],500);
        }
    }   
    public function edit($id){
        try{
            $clientes = Cliente::where("estado",1)->get();
            $departamentos = Departamento::where("estado",1)->get();
            $productos = Producto::where("estadoProductos",1)->get();
            $activo = Activo::find($id);
            return view("activos.edit",compact("clientes","departamentos","productos","activo"));
        }
        catch(\Throwable $th){
            return response()->json(["error"=>$th ->getMessage()],500);
        }
    }

    public function update(Request $request, $id){
        try{
            $request ->validate([
                'fechaCompra'=> 'required',
                'idContabilidad'=> 'required',
                'estadoActivo'=> 'required',
                'ciudad'=> 'required',
                'cliente_id'=> 'required',
                'departamento_id'=> 'required',
                'producto_id'=> 'required',
                'estado'=> 'required',
            ]);
            $activo = Activo::find($id);
            $activo -> fechaDeCompra = $request->fechaCompra;
            $activo -> idContabilidad = $request-> idContabilidad;
            $activo-> estadoActivo = $request->estadoActivo;
            $activo-> cliente_id = $request -> cliente_id;
            $activo-> estado = $request -> estado;
            $activo-> departamento_id = $request -> departamento_id;
            $activo-> producto_id = $request -> producto_id;
            $activo-> garantia = $request -> garantia;
            $activo-> fecha_inicio_garantia = $request -> fecha_inicio_garantia;
            $activo-> fecha_final_garantia = $request -> fecha_final_garantia;
            $activo -> save();
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

    public function indexMantenimiento($id)
    {
        try {

            // $historicos = HistoricoActivos::where('activo_id', $id)->get()->groupBy('activo_id');
            $activo = Activo::with('mantenimientos', 'cliente','producto.modelos.marca', 'producto.modelos.categoria')->find($id);

            return view("mantenimiento.index", compact("activo"));
            // return response()->json(["error"=> $activo],200); 

        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 500);
        }
    }
    public function createMantenimiento($id)
    {
        try {

            $activo = Activo::with('mantenimientos', 'cliente','producto.modelos')->find($id);
            return view("mantenimiento.create", compact("activo"));
            // return response()->json(["error"=> $activo],200); 

        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 500);
        }
    }
    public function storeMantenimiento($id, Request $request)
    {
        try {

            $mantenimiento = new Mantenimiento_activo();
            $mantenimiento-> fecha_registro = now();
            $mantenimiento-> descripcion  = $request -> descripcion;
            $mantenimiento-> estadoActivo  = $request -> estadoActivo;
            $mantenimiento-> activo_id  = $id;
            $mantenimiento-> save();

            $activo = Activo::find($id);
            $activo-> estadoActivo = $request -> estadoActivo;
            $activo -> save();


            // return response()->json(["error"=> $activo],200); 

        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()], 500);
        }
    }


}
