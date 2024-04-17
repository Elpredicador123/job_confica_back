<?php

namespace App\Http\Controllers\Api;

use App\Models\Video;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $videos = Video::all();

            return response()->json([
                "status" => "success",
                'message' => 'Listado de videos',
                'data' => $videos,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: VideoController index',
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
            $video = Video::create($request->except(['file']));
            if ($request->hasFile('file')) {
                $url = Storage::disk('public')->put('videos', $request->file('file'));
                $video->url = $url;
            }
            $video->save();
            return response()->json([
                "status" => "success",
                'message' => 'Video creada',
                'data' => $video,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: VideoController store',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Video  $infographic
     * @return \Illuminate\Http\Response
     */
    public function show($infographic_id)
    {
        try {
            $infographic = Video::find($infographic_id);
            return response()->json([
                "status" => "success",
                'message' => 'Video',
                'data' => $infographic,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: VideoController show',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Video  $infographic
     * @return \Illuminate\Http\Response
     */
    public function edit(Video $video)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $video_id)
    {
        try {
            $video = Video::find($video_id);
            $video->update($request->except(['file']));
            if ($request->hasFile('file')) {
                if ($video->url && Storage::disk('public')->exists('videos', $video->url)) {
                    Storage::disk('public')->delete('videos', $video->url);
                }
                $url = Storage::disk('public')->put('videos', $request->file('file'));
                $video->url = $url;
            }
            $video->save();
            return response()->json([
                "status" => "success",
                'message' => 'Video actualizada',
                'data' => $video,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: VideoController update',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy(Video $video)
    {
        try {
            if ($video->url && Storage::disk('public')->exists($video->url)) {
                Storage::disk('public')->delete($video->url);
            }
            $video->delete();
            return response()->json([
                "status" => "success",
                'message' => 'Video eliminada',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                'message' => 'Error: VideoController destroy',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
