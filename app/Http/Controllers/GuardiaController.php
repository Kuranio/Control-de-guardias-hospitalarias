<?php

namespace App\Http\Controllers;

use App\Models\Guardia;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use PDF;

/**
 * Class GuardiaController
 * @package App\Http\Controllers
 */



class GuardiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return string
     */

    public function pdf(){
        $guardias = Guardia::paginate();
        $pdf = PDF::loadView('guardia.pdf',['guardias'=>$guardias]);
        return $pdf->stream();
        //return view('guardia.pdf', compact('guardias'));
    }

    public function UserPDF(){
        $guardias = Guardia::paginate();
        $pdf = PDF::loadView('guardia.UserPDF',['guardias'=>$guardias]);
        return $pdf->stream();
        //return view('guardia.pdf', compact('guardias'));
    }



    public function index(Request $request)
    {

        $guardias = Guardia::where([
            ['id', '!=', null],
            [function ($query) use ($request){
                if(($term = $request->term)) {
                    $query->Where('fecha', 'LIKE', '%' . $term . '%')->get();
                }
                if(($term1 = $request->term1)) {
                    $query->Where('dni', 'LIKE', $term1)->get();
                    $query->orWhere('donde', 'LIKE', $term1 )->get();
                }
            }]
        ])
            ->orderBy('id','asc')
            ->paginate(5000);

        Paginator::useBootstrap();

        return view('guardia.index', compact('guardias'))
            ->with('i', (request()->input('page', 1) - 1) * $guardias->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $guardia = new Guardia();
        return view('guardia.create', compact('guardia'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Guardia::$rules);

        $guardia = Guardia::create($request->all());

        return redirect()->route('guardias.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $guardia = Guardia::find($id);

        return view('guardia.show', compact('guardia'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $guardia = Guardia::find($id);

        return view('guardia.edit', compact('guardia'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Guardia $guardia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Guardia $guardia)
    {
        request()->validate(Guardia::$rules);

        $guardia->update($request->all());

        return redirect()->route('guardias.index');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $guardia = Guardia::find($id)->delete();

        return redirect()->route('guardias.index');
    }

    public function truncate()
    {
        Guardia::truncate();

        return redirect()->route('guardias.index');
    }
}
