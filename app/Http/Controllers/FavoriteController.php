<?php

namespace App\Http\Controllers;

use App\Favorite;
use Illuminate\Http\Request;
use Auth;

class FavoriteController extends Controller
{
    /**
     * FavoriteController constructor.
     */
     public function __construct()
     {
         $this->middleware('auth');
     }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $favorites = Auth::user()->favorites()->paginate(2);
//        $favorites = Auth::user()->favorites()->get()->toArray();
//        dd($favorites);

        return view('favorite',compact('favorites'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = $request->get('pic_id');

        $ids = Favorite::where('user_id',Auth::user()->id)->pluck('pic_id')->toArray();

        if (!in_array($id,$ids)){
            Auth::user()->favorites()->attach($id);
        }else{
            Auth::user()->favorites()->detach($id);
        }

//       Auth::user()->favorites()->toggle($id);
        /*
        Auth::user()->favorites()->toggle($id); // 作用相当于是会判断执行attach和detach
        Auth::user()->favorites()->attach($id);
        Auth::user()->favorites()->detach($id);*/

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
