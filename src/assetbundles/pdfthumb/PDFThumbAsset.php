<?php
/**
 * PDFThumb plugin for Craft CMS 3.x
 *
 * PDF thumbnail generation for Craft CMS 3 
 *
 * @link      twitter.com/moonty
 * @copyright Copyright (c) 2018 Josh Moont
 */

namespace jadepad\pdfthumb\assetbundles\PDFThumb;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    Josh Moont
 * @package   PDFThumb
 * @since     1.0.0
 */
class PDFThumbAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@jadepad/pdfthumb/assetbundles/pdfthumb/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/PDFThumb.js',
        ];

        $this->css = [
            'css/PDFThumb.css',
        ];

        parent::init();
    }
}
