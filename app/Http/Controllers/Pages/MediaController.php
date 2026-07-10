<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class MediaController extends Controller
{
    public function index()
    {
        $mediaFiles = Media::orderBy('created_at', 'desc')->get();
        return view('pages.media.index', compact('mediaFiles'));
    }

    public function list()
    {
        $mediaFiles = Media::orderBy('created_at', 'desc')->get();
        return response()->json(['media' => $mediaFiles]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            
            $file->move(public_path('uploads/media'), $fileName);
            $filePath = '/uploads/media/' . $fileName;

            $media = Media::create([
                'file_name' => $fileName,
                'file_path' => $filePath,
                'mime_type' => $file->getClientMimeType(),
                'size' => $file->getSize()
            ]);

            return response()->json(['success' => true, 'media' => $media]);
        }
        return response()->json(['success' => false, 'message' => 'Dosya bulunamadı']);
    }

    public function delete(Request $request)
    {
        $media = Media::find($request->id);
        if ($media) {
            $filePath = public_path($media->file_path);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
            $media->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }
}
