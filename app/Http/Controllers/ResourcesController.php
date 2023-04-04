<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResourcesController extends Controller
{
    /**
     * Function Upload
     * This Function is Used to Proceed Upload Resource to DigitalOcean Object Storage
     * with POST Method
     * via API Routes : /resources
     * @param Request $request
     */
    public function uploadResource(Request $request) {
        $request->validate([
            'context' => 'required|string',
            'options' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $path = Storage::disk('do')->put($request->context,
                                                    $request->image,
                                                    $request->options);
            $path = Storage::disk('do')->url($path);
            return response()->json([
                    "result" => $path,
                    "message" => "Image Uploaded",
                    "error" => false,
                    "code" => 201
                ]
            );
        } catch (\Exception $e) {
            return response()->json([
                    "result" => "Failed to Upload Images",
                    "message" => $e->getMessage(),
                    "error" => true,
                    "code" => 500
                ]
            );
        }
    }

    /**
     * Function Get Resources
     * This Function is Used to Retrieve All Resources Data
     * with GET Method
     * via API Routes : /resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function getResources(Request $request) {
        try {
            return response()->json([
                    "result" => Storage::disk('do')->allFiles($request->query('context', 'test')),
                    "message" => "Data Retrieved",
                    "error" => false,
                    "code" => 200
                ]
            );
        } catch (\Exception $e) {
            return response()->json([
                    "result" => null,
                    "message" => $e->getMessage(),
                    "error" => true,
                    "code" => 500
                ]
            );
        }
    }
}
