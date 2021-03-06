<?php

namespace App\Http\Controllers\empresa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Users;
use App\Models\UserType;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function getDatatable(){
        $empresa = \Session::get('_empresa');
        $users = Users::select('users.id', 'users.name', 'users.email', 'users.created_at', 'users.id_tipo_usuario as id_tipo', 'tipo_usuario.tipo as tipo_usuario')
            ->join('tipo_usuario', 'tipo_usuario.id', 'users.id_tipo_usuario')
            ->where('users.id_empresa', $empresa->id)
            ->orderBy('users.name')->get();

        return DataTables::of($users)->make(true);
    }

    public function listar_todos()
    {
        return $this->getDatatable();
    }

    public function index(Request $request){
        $empresa = \Session::get('_empresa');

        $dados = [
            'empresa' => $empresa,
            'user' => \Session::get('_user'),
        ];

        return view('empresa.usuarios.index', $dados);
    }

    public function getEdit(Request $request){
        $empresa = \Session::get('_empresa');
        $segments = $request->segments();
        $id_usr = isset($segments[3]) ? $segments[3] : 0;

        $usuario = Users::where('id', $id_usr)->where('id_empresa', $empresa->id)->first();

        $tipos = UserType::all();
        $dados = [
            'empresa' => $empresa,
            'user' => $request->session()->get('_user'),
            'action' => 'novo',
            'tipos' => $tipos,
            'usuario' => $usuario,
        ];

        return view('empresa.usuarios.edit', $dados);
    }

    public function postEdit(Request $request){
        $empresa = \Session::get('_empresa');
        $id_user = $request->input('_id');
        $nome = $request->input('txNome');
        $email = $request->input('txEmail');
        $senha = $request->input('psSenha');
        $tipo = $request->input('selTipo');
        $name_image = null;

        if($request->file('flUser') != null && $request->file('flUser')->isValid()){
            $file = $request->file('flUser');
            $ext = $file->getClientOriginalExtension();

            $name_image = md5(rand(0, 10000).$nome.time()).'.'.$ext;

            $file->move('image/users/'.$empresa->link.'/', $name_image);
        }

        $user = Users::findOrNew($id_user);
        $user->name = $nome;
        $user->email = $email;
        $user->password = $senha != '' ? md5($senha) : $user->password;
        $user->id_tipo_usuario = $tipo;
        $user->id_empresa = $empresa->id;
        $user->image = $name_image;

        $user->save();

        return $this->index($request);
    }

    public function ajaxView(Request $request){
        $empresa = \Session::get('_empresa');
        $id_usr = $request->input('id_usr');
        if($user = Users::select('users.name', 'users.email', 'users.image', 'tipo_usuario.tipo')
            ->join('tipo_usuario', 'tipo_usuario.id', 'users.id_tipo_usuario')
            ->where('users.id', $id_usr)
            ->where('id_empresa', $empresa->id)->first()){
            return json_encode($user);
        }else{
            return '';
        }
    }

}
