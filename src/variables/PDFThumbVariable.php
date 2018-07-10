<?php
/**
 * PDFThumb plugin for Craft CMS 3.x
 *
 * PDF thumbnail generation for Craft CMS 3 
 *
 * @link      twitter.com/moonty
 * @copyright Copyright (c) 2018 Josh Moont
 */

namespace jadepad\pdfthumb\variables;

use jadepad\pdfthumb\PDFThumb;
use jadepad\pdfthumb\services\PDFThumbService;

use Craft;

/**
 * @author    Josh Moont
 * @package   PDFThumb
 * @since     1.0.0
 */
class PDFThumbVariable
{
    // Public Methods
    // =========================================================================

    /**
     * @param null $optional
     * @return string
     */
    public function thumbnail($asset, $width = 250, $height = 250, $force_canvas_size = false, $filetype = "png")
    {
        $pdfservice = new PDFThumbService;
        $result = $pdfservice->thumbnail($asset, $width, $height, $force_canvas_size, $filetype);
        return $result;
    }
}
