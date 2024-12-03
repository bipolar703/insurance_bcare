<?php

namespace App\Http\Controllers;

use App\Services\FileManagerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class FileManagerController extends Controller
{
    protected $fileManager;

    public function __construct(FileManagerService $fileManager)
    {
        $this->fileManager = $fileManager;
        $this->middleware(['auth', 'web']);
    }

    public function index(Request $request)
    {
        try {
            $directory = $request->get('directory', '');
            $files = $this->fileManager->listFiles($directory);
            $directories = $this->fileManager->listDirectories($directory);

            // Get additional file information
            $filesInfo = collect($files)->map(function ($file) {
                return [
                    'name' => basename($file),
                    'path' => $file,
                    'size' => $this->formatFileSize($this->fileManager->getFileSize($file)),
                    'last_modified' => $this->fileManager->getLastModified($file)
                ];
            });

            return view('file-manager.index', [
                'files' => $filesInfo,
                'directories' => $directories,
                'directory' => $directory,
                'breadcrumbs' => $this->generateBreadcrumbs($directory)
            ]);
        } catch (\Exception $e) {
            Log::error('Error in file manager index: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error loading file manager: ' . $e->getMessage());
        }
    }

    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|max:10240', // 10MB max
            'directory' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        try {
            $file = $request->file('file');
            $directory = $request->get('directory', '');

            // Check if file already exists
            $filename = $file->getClientOriginalName();
            $fullPath = trim($directory, '/') . '/' . $filename;

            if ($this->fileManager->getFileContents($fullPath) !== null) {
                return response()->json([
                    'error' => 'File already exists'
                ], 409);
            }

            $result = $this->fileManager->uploadFile($file, $directory);

            return response()->json([
                'success' => true,
                'message' => 'File uploaded successfully',
                'path' => $result
            ]);
        } catch (\Exception $e) {
            Log::error('Upload failed: ' . $e->getMessage());
            return response()->json([
                'error' => 'Upload failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'path' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        try {
            $path = $request->path;

            // Check if it's a directory
            if ($this->fileManager->listDirectories(dirname($path))) {
                $result = $this->fileManager->deleteDirectory($path);
            } else {
                $result = $this->fileManager->deleteFile($path);
            }

            return response()->json([
                'success' => $result,
                'message' => $result ? 'Item deleted successfully' : 'Item not found'
            ]);
        } catch (\Exception $e) {
            Log::error('Delete failed: ' . $e->getMessage());
            return response()->json([
                'error' => 'Delete failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function createDirectory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'path' => 'required|string|max:255|regex:/^[a-zA-Z0-9\/_-]+$/'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        try {
            $result = $this->fileManager->createDirectory($request->path);

            return response()->json([
                'success' => $result,
                'message' => 'Directory created successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to create directory: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to create directory: ' . $e->getMessage()
            ], 500);
        }
    }

    public function move(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'from' => 'required|string',
            'to' => 'required|string|different:from'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        try {
            if ($this->fileManager->getFileContents($request->to) !== null) {
                return response()->json([
                    'error' => 'Destination file already exists'
                ], 409);
            }

            $result = $this->fileManager->moveFile($request->from, $request->to);

            return response()->json([
                'success' => $result,
                'message' => 'File moved successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to move file: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to move file: ' . $e->getMessage()
            ], 500);
        }
    }

    protected function formatFileSize($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);

        return round($bytes, 2) . ' ' . $units[$pow];
    }

    protected function generateBreadcrumbs($path)
    {
        if (empty($path)) {
            return [['name' => 'Root', 'path' => '']];
        }

        $parts = explode('/', $path);
        $breadcrumbs = [['name' => 'Root', 'path' => '']];
        $currentPath = '';

        foreach ($parts as $part) {
            $currentPath .= ($currentPath ? '/' : '') . $part;
            $breadcrumbs[] = [
                'name' => $part,
                'path' => $currentPath
            ];
        }

        return $breadcrumbs;
    }
}
