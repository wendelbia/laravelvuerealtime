<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//uso para fazer a substituição do arquivo de imagem
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function profile()
    {
        return view('users.profile');
    }

    public function profileUpdate(Request $request)
    {
    	//dd para ver se está chegnado 
        $user = auth()->user();
        //dd no request->all() preciso fazer algumas modificações
        $data = $request->all();
        //se informou o email 
        if ($request->email) unset($data['email']);
        //se informou a senha e ela recebe a mesma
        if ($request->password)
            $data['password'] = bcrypt($data['password']);
        //então será deletada
        else
            unset($data['password']);

        //verifico se foi escolhi a imagem se entrar em isValid é pq a imagem está apta
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
        	//se a imagem existe no storage então
            if ($user->image && Storage::exists("users/{$user->image}"))
            	//então deleto algo semelhando e informa o aruiqvo q será deletado
                Storage::delete("users/{$user->image}");
            //para cria o nome da imagem uso o kebab_case que é o nome combinado com o id do usu
            $name = kebab_case($request->name).uniqid($user->id);
            //extensão que é a imagem mais extensão usando o método extenion
            $extension = $request->image->extension();
            //uso o nome da imagem que está lá em cima mais a extensão
            $nameImage = "{$name}.$extension";
            //verificando se o nome está ok
            //dd($nameImage)
            //faço o upload da imagem
            $data['image'] = $nameImage;
            //upload recebe o storeAs que cria a pasta users q é o params com o nome da imagem que é o segundo parametro
            $upload = $request->image->storeAs('users', $nameImage);
            //se ñ foi feito o upload
            if (!$upload)
            	//então redireciona para 
                return redirect()
                            ->route('profile')
                            //posso o erro e tenho q ir no profile para exibir esse erro
                            ->with('error', 'Falha ao fazer o upload');

        }

        //não basta apenas fazer o upload tenho q atualizar no banco de dados 
        $user->update($data);

        return redirect()
                    ->route('profile')
                    ->with('success', 'Atualizado com Sucesso!');
    }
}
