<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileUploadRequest;
use App\Models\File;
use App\Traits\ApiResponse;

class FileUploadController extends Controller
{
    use ApiResponse;

    public function upload(FileUploadRequest $request)
    {
        $uploadedFiles = [];

        foreach ($request->file('files') as $file) {
            $originalName = $file->getClientOriginalName();
            $storedPath = $file->store('uploads', 'public');

            $fileRecord = File::create([
                'filename' => $originalName,
                'path' => $storedPath,
                'task_id' => $request->task_id,
            ]);

            $uploadedFiles[] = $fileRecord;
        }

        return $this->apiResponse(true, 'Файлы успешно загружены', $uploadedFiles);
    }
}

