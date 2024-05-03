<?php

namespace App\Http\Controllers\Api;

use App\Models\News;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function principal()
    {
        try {
            $news = News::with(['user','images'])->take(10)->orderBy('date','desc')->get();

            return response()->json([
                "status" => "success",
                'message' => 'Listado de noticias',
                'data' => $news,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: NewsController index',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function index()
    {
        try {
            $news = News::with(['user','images'])->get();

            return response()->json([
                "status" => "success",
                'message' => 'Listado de noticias',
                'data' => $news,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: NewsController index',
                'error' => $e->getMessage(),
            ], 500);
        }
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
        try {

            $news_id = $request->input('id');
            $data = $request->except(['id', 'files','images']);
            $images = $request->input('images');
            $news = News::updateOrCreate(['id' => $news_id],$data);
            
            if ($request->has('images')) {
                $imageIds = $request->input('images');
                if (is_array($imageIds)) {
                    foreach ($imageIds as $imageId) {
                        $image = Image::find($imageId);
                        $image->delete();
                        Storage::disk('public')->delete([$image->url]);
                    }
                }
            }
                

            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $url = Storage::disk('public')->put('images', $file);
                    $image = new Image();
                    $image->url = $url;
                    $image->news_id = $news->id;
                    $image->save();
                }
            }

            return response()->json([
                "status" => "success",
                'message' => 'Noticia creada correctamente',
                'data' => $news,
                'images' => $images,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: NewsController store',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show($news_id)
    {
        try {
            $news = News::with(['images'])->find($news_id);
            return response()->json([
                "status" => "success",
                'message' => 'Noticia',
                'data' => $news,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: NewsController show',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$news_id)
    {
        try {
            $news = News::with(['images'])->find($news_id);
            $news->update($request->except(['files']));
            if ($request->hasFile('files')) {
                foreach ($news->images as $image) {
                    Storage::disk('public')->delete($image->url);
                    $image->delete();
                }
                foreach ($request->file('files') as $file) {
                    $url = Storage::disk('public')->put('images', $file);
                    $image = new Image();
                    $image->url = $url;
                    $image->news_id = $news->id;
                    $image->save();
                }
            }
            $news->save();
            return response()->json([
                "status" => "success",
                'message' => 'Noticia actualizada correctamente',
                'data' => $news,
                'request' => $request->all(),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: NewsController update',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        try {
            $news->delete();
            return response()->json([
                "status" => "success",
                'message' => 'Noticia eliminada correctamente',
                'data' => $news,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: NewsController destroy',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
