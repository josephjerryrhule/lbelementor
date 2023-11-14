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

use LBELEMENTOR\ElementorWidgets\Widgets\archiveproducts;
use LBELEMENTOR\ElementorWidgets\Widgets\buy_button;
use LBELEMENTOR\ElementorWidgets\Widgets\imagetransform;
use LBELEMENTOR\ElementorWidgets\Widgets\perfumetest;
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
    add_action('wp_enqueue_scripts', [$this, 'enqueue_custom_scripts']);
    add_action('wp_ajax_get_results', [$this, 'get_results_callback']);
    add_action('wp_ajax_nopriv_get_results', [$this, 'get_results_callback']);
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
    require_once __DIR__ . '/widgets/archiveproducts.php';
    require_once __DIR__ . '/widgets/perfumetest.php';

    //Instantiate Widgets
    $widgets_manager->register(new products());
    $widgets_manager->register(new buy_button());
    $widgets_manager->register(new product_slider());
    $widgets_manager->register(new imagetransform());
    $widgets_manager->register(new archiveproducts());
    $widgets_manager->register(new perfumetest());
  }

  public function enqueue_custom_scripts()
  {
    wp_enqueue_script('lbelementormain-script', plugins_url('widgets/js/script.js', __FILE__), ['jquery'], '1.0', true);

    //Localize Script
    wp_localize_script('lbelementormain-script', 'custom_script_vars', array(
      'ajax_url' => admin_url('admin-ajax.php'),
    ));
  }

  // AJAX callback function to retrieve results
  public function get_results_callback()
  {
    $user_selections = $_POST['userSelections'];

    // Define default query arguments
    $args = array(
      'post_type' => 'lbproducts',
    );

    // Modify the query based on user selections
    if (!empty($user_selections['lbcategory']) || !empty($user_selections['notes']) || !empty($user_selections['moment'])) {
      $args['tax_query']['relation'] = 'OR'; // Use OR operator


      if (!empty($user_selections['lbcategory'])) {
        $args['tax_query'][] = array(
          'taxonomy' => 'lbcategory',  // Replace 'lbcategory' with your actual taxonomy name for category
          'field'    => 'slug',       // Adjust the field as needed
          'terms'    => $user_selections['lbcategory'],
        );
      }

      if (!empty($user_selections['notes'])) {
        $args['tax_query'][] = array(
          'taxonomy' => 'notes',  // Replace 'notes' with your actual taxonomy name
          'field'    => 'slug',   // Adjust the field as needed
          'terms'    => $user_selections['notes'],
        );
      }

      if (!empty($user_selections['moment'])) {
        $args['tax_query'][] = array(
          'taxonomy' => 'moment',  // Replace 'moment' with your actual taxonomy name
          'field'    => 'slug',    // Adjust the field as needed
          'terms'    => $user_selections['moment'],
        );
      }
    }

    if (!empty($user_selections['intensity'])) {
      $args['meta_query'][] = array(
        'key'     => 'intensity',  // Replace 'intensity' with your actual custom field name
        'value'   => $user_selections['intensity'],
        'compare' => '=',  // Adjust the comparison based on your needs
        'type'    => 'NUMERIC',  // Adjust the type based on your custom field type
      );
    }

    // Add more conditions based on other user selections

    global $post;
    // Perform the query
    $query = new \WP_Query($args);
?>
    <div class="w-full text-center wperfume-finalstage">
      <p><?php echo __('Test completed'); ?></p>
      <h1 class="text-center">
        <?php echo __('DISCOVER THE PERFECT FRAGRANCES FOR YOU', 'lbelementor'); ?>
      </h1>
    </div>
    <?php
    // Display the results
    if ($query->have_posts()) {
    ?>
      <div class="lbgrid">
        <?php
        while ($query->have_posts()) {
          $query->the_post();
          $secimage = get_field('lbsecondfeatured');
          $lbbrands = get_field('lbbrands');
          // Display the post content or any other relevant information
        ?>
          <div class="lbarchiveproduct">
            <a href="<?php echo esc_url(the_permalink()); ?>">
              <div class="lbelementor-products-image w-full">
                <?php the_post_thumbnail('full', ['class' => 'lbfirstimage']); ?>
                <img src="<?php echo esc_url($secimage); ?>" alt="Product Image" class="absolute" />
                <div class="mt-25">
                  <span class="lb-product-title">
                    <?= __($post->post_title, 'lbelementor'); ?>
                  </span>
                  <br />
                  <span>
                    <?= __($post->post_excerpt, 'lbelementor'); ?>
                  </span>
                </div>
              </div>
            </a>

            <div class="lb-elementor-buybutton">
              <button type="button" class="lbmodalbtn">
                <span><?php echo __('Buy', 'lbelementor'); ?></span>
                <span class="lbbtn-icon">
                  <svg width="498" height="625" viewBox="0 0 498 625" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15.6667 210C15.6667 173.181 45.5144 143.333 82.3334 143.333H415.667C452.487 143.333 482.333 173.181 482.333 210V510C482.333 565.23 437.563 610 382.333 610H115.667C60.4384 610 15.6667 565.23 15.6667 510V210Z" stroke="currentColor" stroke-width="30" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M349 243.333V110C349 54.7717 304.23 10 249 10C193.77 10 149 54.7717 149 110V243.333" stroke="currentColor" stroke-width="20" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                </span>
              </button>
            </div>

            <div class="lb-elementor-modal w-full modalfixed">
              <div class="lb-elementor-modaldialog">
                <div class="lb-modal-header">
                  <h5>
                    <?php echo __('PROSEGUENDO SARAI REINDIRIZZATO SUL SITO DI UNO DEI NOSTRI PARTNER DOVE POTRAI ACQUISTARE LE NOSTRE FRAGRANZE', 'lbelementor'); ?>
                  </h5>
                  <span class="lb-modal-close">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40">
                      <path d="M31.667 10.683l-2.35-2.35-9.317 9.317-9.317-9.317-2.35 2.35 9.317 9.317-9.317 9.317 2.35 2.35 9.317-9.317 9.317 9.317 2.35-2.35-9.317-9.317z"></path>
                    </svg>
                  </span>
                </div>
                <div class="lb-modal-body">
                  <div class="lb-retails">
                    <?php
                    if ($lbbrands) :
                      foreach ($lbbrands as $brand) {
                        $image = $brand['lbbrandimage'];
                        $link = $brand['lbbrandurl'];
                    ?>
                        <div class="lb_field__item">
                          <div class="lb_field_item">
                            <img src="<?php echo esc_url($image); ?>" alt="Retailer">
                            <a href="<?php echo esc_url($link); ?>" target="_blank">
                              <button type="button">
                                <?php echo __('Buy', 'lbelementor'); ?>
                              </button>
                            </a>
                          </div>
                        </div>
                    <?php
                      }
                    endif;
                    ?>
                  </div>
                </div>
              </div>
            </div>

          </div>
      <?php
        }
        wp_reset_postdata();
      } else {
        echo 'No products found.';
      }
      ?>
      </div>
      <div class="w-full flex-center">
        <a href="/wear-your-perfume">
          <button type="button" class="wperfume-finalbtn">
            <?php echo __('START AGAIN', 'lbelementor'); ?>
          </button>
        </a>
      </div>
  <?php
    wp_die(); // This is required to terminate immediately and return a proper response
  }
}

lbelementor::get_instance();
