<?php

namespace App\Http\Controllers;

use App\Models\Festivo;
use Illuminate\Http\Request;

/**
 * Class FestivoController
 * @package App\Http\Controllers
 */
class FestivoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $festivos = Festivo::paginate();

        return view('festivo.index', compact('festivos'))
            ->with('i', (request()->input('page', 1) - 1) * $festivos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $festivo = new Festivo();
        return view('festivo.create', compact('festivo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Festivo::$rules);

        $festivo = Festivo::create($request->all());

        return redirect()->route('festivos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $festivo = Festivo::find($id);

        return view('festivo.show', compact('festivo','id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $festivo = Festivo::findorfail($id);

        return view('festivo.edit', compact('festivo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Festivo $festivo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Festivo $festivo)
    {
        request()->validate(Festivo::$rules);

        $festivo->update($request->all());

        return redirect()->route('festivos.index');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $festivo = Festivo::find($id)->delete();

        return redirect()->route('festivos.index');
    }
}
