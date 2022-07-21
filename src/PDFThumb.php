<?php
/**
 * PDFThumb plugin for Craft CMS 3.x
 *
 * PDF thumbnail generation for Craft CMS 3
 *
 * @link      twitter.com/moonty
 * @copyright Copyright (c) 2018 Josh Moont
 */

namespace jmoont\pdfthumb;

use Craft;
use craft\base\Plugin;
use craft\web\twig\variables\CraftVariable;
use jmoont\pdfthumb\models\Settings;
use jmoont\pdfthumb\services\PDFThumbService as PDFThumbServiceService;
use jmoont\pdfthumb\variables\PDFThumbVariable;
use yii\base\Event;

/**
 * Class PDFThumb
 *
 * @author    Josh Moont
 * @package   PDFThumb
 * @since     1.0.0
 *
 * @property  PDFThumbServiceService $pDFThumbService
 */
class PDFThumb extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var PDFThumb
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('PDFThumb', PDFThumbVariable::class);
            }
        );

        Craft::info(
            Craft::t(
                'pdfthumb',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * @inheritdoc
     */
    protected function settingsHtml(): string
    {
        return Craft::$app->view->renderTemplate(
            'pdfthumb/settings',
            [
                'settings' => $this->getSettings()
            ]
        );
    }
}
