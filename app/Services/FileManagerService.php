<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class FileManagerService
{
    protected $disk;

    public function __construct(string $disk = 'ftp')
    {
        $this->disk = $disk;
    }

    public function listFiles($directory = '')
    {
        try {
            return Storage::disk($this->disk)->files($directory);
        } catch (\Exception $e) {
            Log::error('Error listing files: ' . $e->getMessage());
            return [];
        }
    }

    public function listDirectories($directory = '')
    {
        try {
            return Storage::disk($this->disk)->directories($directory);
        } catch (\Exception $e) {
            Log::error('Error listing directories: ' . $e->getMessage());
            return [];
        }
    }

    public function uploadFile(UploadedFile $file, $path = '')
    {
        try {
            $filename = $file->getClientOriginalName();
            $path = trim($path, '/');
            $fullPath = $path ? "{$path}/{$filename}" : $filename;

            $stream = fopen($file->getRealPath(), 'r+');
            $result = Storage::disk($this->disk)->putStream($fullPath, $stream);

            if (is_resource($stream)) {
                fclose($stream);
            }

            if (!$result) {
                throw new \Exception('Failed to upload file');
            }

            return $fullPath;
        } catch (\Exception $e) {
            Log::error('Error uploading file: ' . $e->getMessage());
            throw $e;
        }
    }

    public function deleteFile($path)
    {
        try {
            if (!Storage::disk($this->disk)->exists($path)) {
                return false;
            }
            return Storage::disk($this->disk)->delete($path);
        } catch (\Exception $e) {
            Log::error('Error deleting file: ' . $e->getMessage());
            throw $e;
        }
    }

    public function createDirectory($path)
    {
        try {
            if (Storage::disk($this->disk)->exists($path)) {
                return true;
            }
            return Storage::disk($this->disk)->makeDirectory($path);
        } catch (\Exception $e) {
            Log::error('Error creating directory: ' . $e->getMessage());
            throw $e;
        }
    }

    public function deleteDirectory($path)
    {
        try {
            if (!Storage::disk($this->disk)->exists($path)) {
                return false;
            }
            return Storage::disk($this->disk)->deleteDirectory($path);
        } catch (\Exception $e) {
            Log::error('Error deleting directory: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getFileContents($path)
    {
        try {
            if (!Storage::disk($this->disk)->exists($path)) {
                return null;
            }
            return Storage::disk($this->disk)->get($path);
        } catch (\Exception $e) {
            Log::error('Error getting file contents: ' . $e->getMessage());
            throw $e;
        }
    }

    public function moveFile($from, $to)
    {
        try {
            if (!Storage::disk($this->disk)->exists($from)) {
                return false;
            }
            return Storage::disk($this->disk)->move($from, $to);
        } catch (\Exception $e) {
            Log::error('Error moving file: ' . $e->getMessage());
            throw $e;
        }
    }

    public function copyFile($from, $to)
    {
        try {
            if (!Storage::disk($this->disk)->exists($from)) {
                return false;
            }
            return Storage::disk($this->disk)->copy($from, $to);
        } catch (\Exception $e) {
            Log::error('Error copying file: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getFileSize($path)
    {
        try {
            if (!Storage::disk($this->disk)->exists($path)) {
                return 0;
            }
            return Storage::disk($this->disk)->size($path);
        } catch (\Exception $e) {
            Log::error('Error getting file size: ' . $e->getMessage());
            return 0;
        }
    }

    public function getLastModified($path)
    {
        try {
            if (!Storage::disk($this->disk)->exists($path)) {
                return null;
            }
            return Storage::disk($this->disk)->lastModified($path);
        } catch (\Exception $e) {
            Log::error('Error getting last modified time: ' . $e->getMessage());
            return null;
        }
    }
}
