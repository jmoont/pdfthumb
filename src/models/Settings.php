<?php
/**
 * PDFThumb plugin for Craft CMS 3.x
 *
 * PDF thumbnail generation for Craft CMS 3 
 *
 * @link      twitter.com/moonty
 * @copyright Copyright (c) 2018 Josh Moont
 */

namespace jmoont\pdfthumb\models;

use jmoont\pdfthumb\PDFThumb;

use Craft;
use craft\base\Model;

/**
 * @author    Josh Moont
 * @package   PDFThumb
 * @since     1.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $storage_path = '';

    /**
     * @var string
     */
    public $base_url = '';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['storage_path', 'string'],
            ['base_url', 'string'],
            [['base_url','storage_path'], 'required'],
        ];
    }
}
