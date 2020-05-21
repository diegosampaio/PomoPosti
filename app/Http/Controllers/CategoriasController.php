<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Categoria;

class CategoriasController extends Controller
{
    private $categoria;

    public function __construct(Categoria $cat)
    {
        $this->middleware('auth');
        $this->categoria = $cat;
    }

    public function index()
    {
        $categorias = $this->categoria->where('users_id', auth()->user()->id)->get();
        return view('sistema.categorias.index', compact('categorias'));
    }

    public function store(Request $request)
    {
        $dadosForm = $request->all();
        $dadosForm['users_id'] = auth()->user()->id;

        $response = $this->categoria->create($dadosForm);
        if ($response) {
            return redirect()
                ->route('categorias')
                ->with('success', 'Categoria cadastrada com sucesso!');
        }else{
            return redirect()
                ->back()
                ->with('error', 'Erro ao cadastrar Categoria!');
        }
    }
}
