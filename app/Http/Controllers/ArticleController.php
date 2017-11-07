<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;
use App\Article;


class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::paginate(9);
//        dd($articles);

        return view('article',compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags =Tag::all();
        return view('article_create',compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->all());
        $data = [
            'title' => $request->get('title'),
            'content' => $request->get('content'),
        ];

//        dd($request->get('tags'));
        $article =  Article::create($data);

        $article->tags()->attach($request->get('tags'));

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
        $article = Article::with('tags')->find($id);
//        dd($article->tags);
        return view('article_show',compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = Article::with('tags')->find($id);

        $tags = Tag::all();

//        dd($article->tags()->get()->pluck('id')->toArray());
        $seltags = $article->tags()->get()->pluck('id')->toArray();

        return view('article_edit',compact('article','tags','seltags'));
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
        $data = [
            'title' => $request->get('title'),
            'content' => $request->get('content'),
        ];

        $article = Article::find($id);

        $article->update($data);

        $tags = $request->get('tags');

//        dd($tags);

        $article->tags()->sync($tags);

//        $question->topics()->sync($topics);

        return redirect('article/'.$id);

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
