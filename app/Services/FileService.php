<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\File;
use App\Models\FileType;

class FileService
{
    /**
     * Default file type.
     *
     * @const int DEFAULT_FILE_TYPE
     */
    public const DEFAULT_FILE_TYPE = 1;

    /**
     * Default order.
     *
     * @const int DEFAULT_ORDER
     */
    public const DEFAULT_ORDER = 1;

    /**
     * Upload files to storage.
     *
     * @param array $files
     * @param int $recordId
     * @return void
     */
    public function upload(array $files, int $recordId): void
    {
        foreach ($files as $path) {
            $ext = FileType::where(
                'extension',
                pathinfo(
                    $path,
                    PATHINFO_EXTENSION
                )
            )
                ->first()
                ->id ?? self::DEFAULT_FILE_TYPE;

            File::create([
                'title' => __('fileresponse.post.attachment'),
                'path' => $path, //TODO for get api Storage::url($path)
                'order' => self::DEFAULT_ORDER,
                'file_type_id' => $ext,
                'post_id' => $recordId,
            ]);
        }
    }
}
