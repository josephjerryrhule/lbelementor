<?php

/**
 * Plugin Name: LB Elementor
 * Author: Figmenta
 * Author URI: https://figmenta.com
 * Description: LB Elementor Widget Addons
 * Version: 0.1.0
 * text-domain: lbelementor
 * 
 * @package lbelementor
 */

namespace LBELEMENTOR\ElementorWidgets;

use LBELEMENTOR\ElementorWidgets\Widgets\buy_button;
use LBELEMENTOR\ElementorWidgets\Widgets\imagetransform;
use LBELEMENTOR\ElementorWidgets\Widgets\product_slider;
use LBELEMENTOR\ElementorWidgets\Widgets\products;

if (!defined('ABSPATH')) {
  exit;
}


final class lbelementor
{

  private static $_instance = null;

  public static function get_instance()
  {
    if (is_null(self::$_instance)) {
      self::$_instance = new self();
    }
    return self::$_instance;
  }

  public function __construct()
  {
    add_action('elementor/init', [$this, 'init']);
  }

  public function init()
  {
    add_action('elementor/elements/categories_registered', [$this, 'create_new_category']);
    add_action('elementor/widgets/register', [$this, 'init_widgets']);
  }

  public function create_new_category($elements_manager)
  {
    $elements_manager->add_category(
      'lbelementor',
      [
        'title' => __('LB Elementor', 'lbelementor')
      ]
    );
  }

  public function init_widgets($widgets_manager)
  {
    //Require Widgets
    require_once __DIR__ . '/widgets/products.php';
    require_once __DIR__ . '/widgets/buy-button.php';
    require_once __DIR__ . '/widgets/product-slider.php';
    require_once __DIR__ . '/widgets/imagetransform.php';

    //Instantiate Widgets
    $widgets_manager->register(new products());
    $widgets_manager->register(new buy_button());
    $widgets_manager->register(new product_slider());
    $widgets_manager->register(new imagetransform());
  }
}

lbelementor::get_instance();
