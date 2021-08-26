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
     * Uppish: Extensions to MIMEs.
     *
     * @param string $extensions Comma-separated string of extensions.
     *
     * @return array String of comma-separated MIME Types.
     */
    public static function extensionsToMimes($extensions)
    {
        $uppish = new UppishController;

        return $uppish->extensionsToMimes($extensions);
    }

    /**
     * Uppish: Bytes to Megabytes.
     *
     * @param integer $bytes       Bytes.
     * @param boolean $round       Boolean Value
     * @param integer $roundTo     Bytes.
     * @param integer $roundMethod Round halves up.
     *
     * @return integer Megabytes.
     */
    public static function bytesToMb($bytes, $round = false, $roundTo = 2, $roundMethod = PHP_ROUND_HALF_UP)
    {
        $uppish = new UppishController;

        return $uppish->bytesToMb($bytes, $round, $roundTo, $roundMethod);
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
     * Uppish: Clear Temp.
     */
    public static function clearTemp()
    {
        $uppish = new UppishController;

        return $uppish->clearTemp();
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
