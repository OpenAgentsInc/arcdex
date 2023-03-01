<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\AbstractHandler;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class DependencyUploadController extends UploadController
{
    /**
     * Handles the file upload
     *
     * @param FileReceiver $receiver
     *
     * @return JsonResponse
     *
     * @throws UploadMissingFileException
     *
     */
    public function uploadFile(FileReceiver $receiver, Request $request)
    {
        // dd($request);

        // grab the title param from the request

        // check if the upload is success, throw exception or return response you need
        if ($receiver->isUploaded() === false) {
            throw new UploadMissingFileException();
        }
        // receive the file
        $save = $receiver->receive();

        // check if the upload has finished (in chunk mode it will send smaller files)
        if ($save->isFinished()) {
            // save the file and return any response you need
            return $this->saveFileToS3($save->getFile(), $request);
        }

        // we are in chunk mode, lets send the current progress
        /** @var AbstractHandler $handler */
        $handler = $save->handler();
        return response()->json([
            "done" => $handler->getPercentageDone()
        ]);
    }
}
