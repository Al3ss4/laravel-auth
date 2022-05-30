<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post = Post::all();
        return view('admin.posts.index' , compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // validazione dei dati
        $request->validate([
            'title'=> 'required|max:200',
            'content'=>'required'
        ]);

        // prendiamo i dati
        $postData = $request->all();

         // creiamo la nuova istanza con i dati ottenuti dalla request
        $newPost = new Post();
        $newPost-> fill($postData);
        $slug = Str::slug($newPost->title);
        $alternativeSlug = $slug;
        $postFound = Post::where('slug', $slug )-> first();
        $counter =1;

        // fin quando non c'è un duplicato il ciclo continua
        while($postFound){
            $alternativeSlug = $slug . '_' . $counter;
            $counter++;
            $postFound = Post::where('slug', $alternativeSlug)-> first();
        }
        $newPost->slug = $alternativeSlug;
        $newPost->save();
        return redirect()->route('admin.posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        // selezio il primo elemento
        $post = Post::where('slug', $slug)->first();

        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        // validazione dei dati
        $request->validate([
            'title' => 'required|max:200',
            'content' => 'required'
        ]);

        // prendiamo i dati
        $data = $request->all();

        // se il 'title' è stato modificato allora parte l if
        if($data['title'] != $post->title){

            $slug = Str::slug($data['title'], '-');

            $slug_standard = $slug;

            $slug_presente = Post::where('slug',  $slug)->first();

            $counter = 1;
            while($slug_presente){
                $slug = $slug_standard . '-' . $counter;
                $slug_presente = Post::where('slug',  $slug)->first();
                $counter++;
            }

            $data['slug'] = $slug;
        }

         // si attua la modifica
        $post->update($data);

        return redirect()->route('admin.posts.index');
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
