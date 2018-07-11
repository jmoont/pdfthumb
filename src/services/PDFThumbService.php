<?php
/**
 * PDFThumb plugin for Craft CMS 3.x
 *
 * PDF thumbnail generation for Craft CMS 3 
 *
 * @link      twitter.com/moonty
 * @copyright Copyright (c) 2018 Josh Moont
 */

namespace jmoont\pdfthumb\services;

use jmoont\pdfthumb\PDFThumb;

use Craft;
use craft\base\Component;

/**
 * @author    Josh Moont
 * @package   PDFThumb
 * @since     1.0.0
 */
class PDFThumbService extends Component
{

    public $asset, $width, $height, $force_canvas_size, $filetype;
    private $cache_folder = 'previews/';
    private $settings;

    // Public Methods
    // =========================================================================

    
    public function __construct() {

        $this->settings = PDFThumb::$plugin->getSettings();
        $this->setup_cache_folder();
    }

    private function setup_cache_folder() {
        if( !is_dir($this->cache_storage_path()) )
          exec("mkdir " . $this->cache_storage_path());
        if( !is_writable($this->cache_storage_path()) )
          exec("chmod 755 " . $this->cache_storage_path());
    }

    public function thumbnail($asset, $width, $height, $force_canvas_size, $filetype)
    {
        $this->asset = $asset;
        $this->width = (int)$width;
        $this->height = (int)$height;
        $this->force_canvas_size = $force_canvas_size;
        $this->filetype = $filetype;

        if (!empty($this->settings->base_url) && !empty($this->settings->storage_path)) {
            $result = $this->generate_thumbnail()->url();
        } else {
            $result = "Missing settings";
        }

        return $result;
    }

    private function generate_thumbnail() {
        $error_log = $this->storage_path() . 'log.txt';
        if( !file_exists($this->thumbnail_path()) ){
          $segments = array("convert", $this->options(), $this->pdf() . "[0]", $this->thumbnail_path(), "> $error_log 2>&1");
          exec(join($segments, ' '));
        }
        return $this;
      }
      private function options() {
        $options = array(
          'density' => 144,
          'colorspace' => 'RGB',
          'resize' => $this->dimensions(),
          'gravity' => 'center',
          'background' => $this->background()
        );
        if($this->force_canvas_size)
          $options['extent'] = $this->dimensions();
        return $this->array_to_flags($options);
      }
      private function array_to_flags($array, $output = '') {
        foreach($array as $key => $value) {
          $output .= "-$key $value ";
        }
        return $output;
      }
      private function background() {
        return $this->filetype == 'png' ? 'transparent' : 'white';
      }
      private function dimensions() {
        return $this->width . "x" . $this->height;
      }
      private function thumbnail_path() {
        return $this->cache_storage_path() . $this->thumbnail_filename();
      }
      private function url() {
        $base_url = $this->settings->base_url;
        return $base_url . $this->cache_folder . $this->thumbnail_filename();
      }
      private function thumbnail_filename() {
        return $this->cache_key() . '.' . $this->filetype;
      }
      private function storage_path() {
        $storage_path = Craft::getAlias($this->settings->storage_path);
        return $this->slashify($storage_path);
      }
      private function cache_storage_path() {
        return $this->storage_path() . $this->cache_folder;
      }
      private function pdf() {
        return $this->storage_path() . $this->asset->filename;
      }
      private function cache_key() {
        $parts = array(
          $this->asset->size, $this->asset->id, $this->asset->dateModified->format('Y-m-d H:i:s'),
          $this->dimensions(), $this->filetype, $this->force_canvas_size
        );
        return md5(join($parts,'-'));
      }
      private function slashify($string) {
        $string = trim($string, '/');
        return "/$string/";
      }
}