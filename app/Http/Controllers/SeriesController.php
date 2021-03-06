<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use App\Services\{ CriadorDeSerie, RemovedorDeSerie };
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SeriesFormRequest;

class SeriesController extends Controller
{
    /*public function __construct()
    {
        // Bloqueia todas as rotas (metodos) deste controller
        $this->middleware('auth');
    }*/

    public function index(Request $request)
    {
        // Bloqueia somente esta rota
        /*if (!Auth::check()) {
            echo "Nao autorizado!!";
        }*/

        $series = Serie::query()->orderBy('nome')->get();
        
        $mensagem = $request->session()->get('mensagem');

        return view('series.index', compact('series', 'mensagem'));
    }

    public function create()
    {   
        return view('series.create');
    }

    public function store(SeriesFormRequest $request, CriadorDeSerie $criadorDeSerie)
    {;
        $serie = $criadorDeSerie->criarSerie($request->nome, $request->qtd_temporadas, $request->ep_por_temporada);

        $request->session()->flash('mensagem', "Serie {$serie->id}, temporadas, e episodios criados com sucesso: {$serie->nome}");

        return redirect(route('listar_series'));
    }

    public function destroy(Request $request, RemovedorDeSerie $removedorDeSerie)
    {
        $nomeSerie = $removedorDeSerie->removerSerie($request->id);

        $request->session()->flash('mensagem', "Serie $nomeSerie removida com sucesso");
        
        return redirect(route('listar_series'));
    }

    public function editaNome(int $id, Request $request)
    {
        $novoNome = $request->nome;
        $serie = Serie::find($id); // OU $request->id
        $serie->nome = $novoNome;
        $serie->save();
    }
}
