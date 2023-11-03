<?php

/**
 * LB Elementor Product Slider Widget Addon
 * 
 * @package lbelementor
 */

namespace LBELEMENTOR\ElementorWidgets\Widgets;

use Elementor\Widget_Base;

class product_slider extends Widget_Base
{

  public function get_name()
  {
    return 'lb-product-slider';
  }

  public function get_title()
  {
    return __('LB Product Slider', 'lbelementor');
  }

  public function get_icon()
  {
    return 'eicon-elementor';
  }

  public function get_categories()
  {
    return ['lbelemenetor', 'basic'];
  }

  public function get_style_depends()
  {
    wp_register_style('swiper-style', plugins_url('scss/swiper.min.css', __FILE__));
    wp_register_style('lb-style', plugins_url('scss/style.css', __FILE__));

    return ['swiper-style', 'lb-style'];
  }

  public function get_script_depends()
  {
    wp_register_script('swiperlb-js', plugins_url('js/swiper.js', __FILE__));
    wp_register_script('lbelementor-script', plugins_url('js/script.js', __FILE__));

    return ['swiperlb-js', 'lbelementor-script'];
  }

  protected function render()
  {

    $product_id = get_the_ID();
    $featuredimageid = get_post_thumbnail_id($product_id);
    $featuredimageurl = wp_get_attachment_url($featuredimageid);
    $gallery = get_field('product_gallery', $product_id);
?>

    <div class="lb-product-slider w-full">
      <div class="swiper lbSwiper2">
        <div class="lbproduct-slider swiper-wrapper">
          <div class="swiper-slide">
            <img src="<?php echo esc_url($featuredimageurl); ?>" alt="<?php the_title(); ?>">
          </div>
          <?php
          if ($gallery) :
            foreach ($gallery as $image) :
          ?>
              <div class="swiper-slide">
                <img src="<?php echo esc_url($image); ?>" alt="<?php the_title(); ?>">
              </div>
          <?php
            endforeach;
          endif;
          ?>
        </div>
      </div>
      <div class="lbproduct-thumb swiper lbSwiper">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <img src="<?php echo esc_url($featuredimageurl); ?>" alt="<?php the_title(); ?>">
          </div>
          <?php
          if ($gallery) :
            foreach ($gallery as $image) :
          ?>
              <div class="swiper-slide">
                <img src="<?php echo esc_url($image); ?>" alt="<?php the_title(); ?>">
              </div>
          <?php
            endforeach;
          endif;
          ?>
        </div>
      </div>
    </div>

<?php
  }
}
