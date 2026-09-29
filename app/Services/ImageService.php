<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use InvalidArgumentException;
use RuntimeException;

class ImageService
{
    protected ImageManager $manager;

    /**
     * Create Image Service.
     */
    public function __construct()
    {
        /*
         * Intervention Image v4
         *
         * Using GD driver.
         */
        $this->manager = ImageManager::usingDriver(Driver::class);
    }

    /**
     * Store an image.
     *
     * Supports:
     * - UploadedFile
     * - Base64 Data URI
     * - Raw Base64
     *
     * All images are converted to WebP.
     *
     * @param UploadedFile|string $image
     * @param string $directory
     * @param string $disk
     * @param int $quality
     *
     * @return string
     */
    public function store(
        UploadedFile|string $image,
        string $directory = 'images',
        string $disk = 'public',
        int $quality = 80
    ): string {
        /*
         * Keep quality between 0 and 100.
         */
        $quality = max(0, min(100, $quality));

        /*
         * Uploaded file.
         */
        if ($image instanceof UploadedFile) {
            return $this->storeUploadedFile(
                $image,
                $directory,
                $disk,
                $quality
            );
        }

        /*
         * Base64 image.
         */
        if (is_string($image) && $this->isBase64Image($image)) {
            return $this->storeBase64(
                $image,
                $directory,
                $disk,
                $quality
            );
        }

        throw new InvalidArgumentException(
            'Invalid image. Expected UploadedFile or Base64 image.'
        );
    }

    /**
     * Store UploadedFile as WebP.
     */
    protected function storeUploadedFile(
        UploadedFile $file,
        string $directory,
        string $disk,
        int $quality
    ): string {
        /*
         * Validate upload.
         */
        if (!$file->isValid()) {
            throw new InvalidArgumentException(
                'Uploaded image is invalid.'
            );
        }

        /*
         * Make sure the uploaded file is actually an image.
         */
        $imageInfo = @getimagesize($file->getRealPath());

        if ($imageInfo === false) {
            throw new InvalidArgumentException(
                'Uploaded file is not a valid image.'
            );
        }

        try {
            /*
             * Intervention Image v4:
             *
             * UploadedFile extends SplFileInfo, so it can be decoded
             * directly using decodeSplFileInfo().
             */
            $image = $this->manager->decodeSplFileInfo($file);

            /*
             * v4 can automatically handle EXIF orientation through
             * manager configuration. Since we are using the default
             * manager here, the image remains ready for processing.
             */

            /*
             * Generate unique filename.
             */
            $filename = Str::uuid()->toString() . '.webp';

            /*
             * Normalize directory.
             */
            $directory = trim($directory, '/');

            $path = $directory . '/' . $filename;

            /*
             * Encode image as WebP.
             *
             * Intervention Image v4:
             * encodeUsingFileExtension()
             */
            $encoded = $image->encodeUsingFileExtension(
                'webp',
                quality: $quality
            );

            /*
             * Store through Laravel filesystem.
             */
            $stored = Storage::disk($disk)->put(
                $path,
                $encoded->toString()
            );

            if (!$stored) {
                throw new RuntimeException(
                    'Failed to store image.'
                );
            }

            return $path;
        } catch (\Throwable $e) {
            throw new RuntimeException(
                'Failed to process uploaded image: ' . $e->getMessage(),
                previous: $e
            );
        }
    }

    /**
     * Store Base64 image as WebP.
     */
    protected function storeBase64(
        string $base64,
        string $directory,
        string $disk,
        int $quality
    ): string {
        try {
            /*
             * Determine whether this is a Data URI.
             *
             * Example:
             *
             * data:image/png;base64,iVBORw0KGgo...
             */
            if ($this->isDataUri($base64)) {
                /*
                 * Intervention Image v4 supports Data URI decoding.
                 */
                $image = $this->manager->decodeDataUri($base64);
            } else {
                /*
                 * Raw Base64.
                 */
                $base64 = preg_replace('/\s+/', '', $base64);

                if (!$base64) {
                    throw new InvalidArgumentException(
                        'Base64 image data is empty.'
                    );
                }

                /*
                 * Validate Base64 before passing it to Intervention.
                 */
                $decoded = base64_decode($base64, true);

                if ($decoded === false) {
                    throw new InvalidArgumentException(
                        'Invalid Base64 image.'
                    );
                }

                /*
                 * Decode raw Base64 using Intervention Image v4.
                 */
                $image = $this->manager->decodeBase64($base64);
            }

            /*
             * Generate unique filename.
             */
            $filename = Str::uuid()->toString() . '.webp';

            /*
             * Normalize directory.
             */
            $directory = trim($directory, '/');

            $path = $directory . '/' . $filename;

            /*
             * Convert to WebP.
             */
            $encoded = $image->encodeUsingFileExtension(
                'webp',
                quality: $quality
            );

            /*
             * Store image.
             */
            $stored = Storage::disk($disk)->put(
                $path,
                $encoded->toString()
            );

            if (!$stored) {
                throw new RuntimeException(
                    'Failed to store image.'
                );
            }

            return $path;
        } catch (\Throwable $e) {
            /*
             * Don't wrap our own InvalidArgumentException again.
             */
            if ($e instanceof InvalidArgumentException) {
                throw $e;
            }

            throw new RuntimeException(
                'Failed to process Base64 image: ' . $e->getMessage(),
                previous: $e
            );
        }
    }

    /**
     * Check whether the given string is a Base64 image.
     */
    protected function isBase64Image(string $value): bool
    {
        /*
         * Data URI.
         */
        if ($this->isDataUri($value)) {
            return true;
        }

        /*
         * Remove whitespace from raw Base64.
         */
        $cleanValue = preg_replace('/\s+/', '', $value);

        if (!$cleanValue) {
            return false;
        }

        /*
         * Validate Base64.
         */
        $decoded = base64_decode($cleanValue, true);

        if ($decoded === false || $decoded === '') {
            return false;
        }

        /*
         * Make sure decoded data is actually an image.
         */
        return @getimagesizefromstring($decoded) !== false;
    }

    /**
     * Determine whether the value is a Data URI image.
     */
    protected function isDataUri(string $value): bool
    {
        return preg_match(
            '/^data:image\/[a-zA-Z0-9.+-]+;base64,/i',
            $value
        ) === 1;
    }

    /**
     * Delete an image.
     */
    public function delete(
        ?string $path,
        string $disk = 'public'
    ): bool {
        if (!$path) {
            return false;
        }

        $storage = Storage::disk($disk);

        if (!$storage->exists($path)) {
            return false;
        }

        return $storage->delete($path);
    }

    /**
     * Get public URL for an image.
     */
    public function url(
        ?string $path,
        string $disk = 'public'
    ): ?string {
        if (!$path) {
            return null;
        }

        return Storage::disk($disk)->url($path);
    }

    /**
     * Check whether an image exists.
     */
    public function exists(
        ?string $path,
        string $disk = 'public'
    ): bool {
        if (!$path) {
            return false;
        }

        return Storage::disk($disk)->exists($path);
    }

    /**
     * Replace an existing image.
     *
     * Stores the new image and deletes the old one only after
     * successful storage.
     */
    public function replace(
        UploadedFile|string $image,
        ?string $oldPath,
        string $directory = 'images',
        string $disk = 'public',
        int $quality = 80
    ): string {
        /*
         * Store new image first.
         */
        $newPath = $this->store(
            $image,
            $directory,
            $disk,
            $quality
        );

        /*
         * Delete old image after successful upload.
         */
        if ($oldPath) {
            $this->delete($oldPath, $disk);
        }

        return $newPath;
    }
}
