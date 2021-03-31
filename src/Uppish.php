<?php

/**
 * Initialize Uppish
 *
 * @package    Laravel
 * @subpackage TechnoVistaLimited/Uppish
 */

namespace Technovistalimited\Uppish;

use Technovistalimited\Uppish\Controllers\UppishController;

class Uppish
{
    /**
     * Uppish: Accepted MIME Types.
     *
     * @return array Array of MIMEs as mentioned in the configuration.
     */
    public static function acceptedMimes()
    {
        $uppish = new UppishController;

        return $uppish->getAcceptedMimes();
    }

    /**
     * Uppish: Bytes to Megabytes.
     *
     * @return integer Megabytes.
     */
    public static function bytesToMb($bytes)
    {
        $uppish = new UppishController;

        return $uppish->bytesToMb($bytes);
    }

    /**
     * Uppish: Upload.
     */
    public static function upload($file)
    {
        $uppish = new UppishController;

        return $uppish->upload($file);
    }

    /**
     * Uppish: Delete.
     */
    public static function delete($file)
    {
        $uppish = new UppishController;

        return $uppish->deleteFromPath($file);
    }

    /**
     * Uppish: getFileURL.
     */
    public static function getFileURL($file)
    {
        $uppish = new UppishController;

        return $uppish->getFileURL($file);
    }

    /**
     * Uppish: getImageURL.
     */
    public static function getImageURL($image, $size = '')
    {
        $uppish = new UppishController;

        return $uppish->getImageURL($image, $size);
    }
}
