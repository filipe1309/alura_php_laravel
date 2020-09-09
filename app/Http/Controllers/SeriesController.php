<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function index(Request $request)
    {
        $series = Serie::all();
        
        return view('series.index', compact('series'));
    }

    public function create()
    {   
        return view('series.create');
    }

    public function store(Request $request)
    {
        $nome = $request->nome;
        $serie = Serie::create($request->all());
        return redirect('/series');
    }
}
