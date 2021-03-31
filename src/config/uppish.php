<?php

/**
 * ---------------------------------------------------------------------
 * Configurations for Uppish
 * ---------------------------------------------------------------------
 */

return [
    /**
     * Upload Path
     *
     * Path where to upload files.
     *
     * Accepts: string
     *
     * Default: (string) 'uploads/' - relative to /storage/app/public/
     */
    'upload_path' => 'uploads/',

    /**
     * Maximum Upload Size.
     *
     * Maximum size of upload per file.
     *
     * Accepts: integer
     *
     * Default: (integer) 10485760 - 10mb in binary bytes
     */
    'upload_max_size' => 10485760, // 10mb in binary bytes

    /**
     * Maximum Number of Files.
     *
     * Maximum number of files allowed when using bulk uploader.
     *
     * Accepts: integer
     *
     * Default: (integer) 20 (files)
     */
    'maximum_files' => 20, // files.

    /**
     * Default File Extensions.
     *
     * Default accepted file extensions are mentioned here.
     * Will be applicable when per file extensions
     * are not available.
     *
     * Accepts: string
     *
     * Default: (string) '.jpg, .jpeg, .gif, .png, .pdf, .doc, .docx, .xls, .xlsx, .mp4, .mp3, .ogg, .wav, .wma, .webm, .mpeg'
     */
    'accepted_extensions' => '.jpg, .jpeg, .gif, .png, .pdf, .doc, .docx, .xls, .xlsx, .mp4, .mp3, .ogg, .wav, .wma, .webm, .mpeg',

    /**
     * Image Sizes.
     *
     * The default sizes of images to be resized. Beside the
     * sizes mentioned the original files will automatically
     * be saved by default.
     *
     * NOTE: ON THE ARRAY KEY '3 CHARACTERS' IS MANDATORY
     *
     * With this six character key the files will be prefixed
     * to distinguish from one another and to call them
     * while necessary with due size.
     *
     * ============================================
     * WARNING
     * ============================================
     * Please DON'T change the '3CR' size prefix
     * interim a project. Doing this, interim
     * will BREAK fetching older uploads.
     * --------------------------------------------
     *
     * Accepts: array
     */
    'sizes' => array(
        // '3CR' => array()
        'tmb' => array(
            'width'  => '150',
            'height' => '150',
            'crop'   => 'strict', // Hard crop.
        ),
        'med' => array(
            'width'  => '300',
            'height' => '200',
            'crop'   => 'loose',
        ),
    ),

    /**
     * Compress Original?
     *
     * Define whether to compress the original file while
     * storing them into the server. If it's set to zero
     * the original file will not be compressed.
     *
     * Accepts: integer
     * Default: 0 percent (no compression)
     */
    'original_compression' => 0, // Percent.

    /**
     * Original Image Resize.
     *
     * Resolution of resizing the original images. Default
     * is not to resize the original image, but if defined
     * the original image will be resized.
     *
     * SKIPPED if, 'original_compression' is zero (0).
     *
     * Accepts: array
     *
     * Default: Array with null values (no resize - keep original).
     */
    'original_resolution' => array(
        'width'  => null,
        'height' => null,
    ),

    /**
     * Read Metadata (EXIF)?
     *
     * Define whether to extract the EXIF data (metadata)
     * from the uploaded file or not. If defined true,
     * the EXIF data will be returned with the file.
     *
     * Accepts: boolean
     * Default: false (don't read EXIF data)
     */
    'read_exif_data' => false, // True to read, false otherwise.
];
