<?php
namespace App\Http\Controllers;

use Aws\S3\S3Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Routing\Controller;

class S3UploadController extends Controller
{
    public function sign(Request $request)
    {
        // Validazione minima
        $request->validate([
            'filename' => 'required|string',
            'type' => 'required|string',
        ]);

        $secretPhrase = env("UPLOAD_SECRET_PHRASE");

        $s3Client = new S3Client([
            'version' => 'latest',
            'region' => config('filesystems.disks.s3.region'),
            'credentials' => [
                'key' => config('filesystems.disks.s3.key'),
                'secret' => config('filesystems.disks.s3.secret'),
            ],
        ]);

        // Costruiamo il percorso di destinazione
        $key = 'uploads/' . Str::uuid() . '/' . basename($request->filename);
        $bucket = config('filesystems.disks.s3.bucket');

        // Creiamo URL pre-firmata PUT (upload)
        $cmd = $s3Client->getCommand('PutObject', [
            'Bucket' => $bucket,
            'Key' => $key,
            'ContentType' => $request->type,
            "Metadata" => [
                "secret" => $secretPhrase,
            ],
        ]);

        $url = $s3Client->createPresignedRequest($cmd, '+5 minutes')->getUri();

        return response()->json([
            'url' => (string) $url,
            'key' => $key,
            'method' => 'PUT',
        ]);
    }
}
