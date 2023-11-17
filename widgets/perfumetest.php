<?php

/**
 * Wear Your Perfume Ajax Widget
 * 
 * @package lbelementor
 */

namespace LBELEMENTOR\ElementorWidgets\Widgets;

use Elementor\Widget_Base;

class perfumetest extends Widget_Base
{

  public function get_name()
  {
    return 'lb-perfume-test';
  }

  public function get_title()
  {
    return __('LB Wear Your Perfume');
  }

  public function get_icon()
  {
    return 'eicon-elementor';
  }

  public function get_categories()
  {
    return ['lbelementor', 'basic'];
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

    return ['swiperlb-js'];
  }

  protected function render()
  {
?>
    <div class="w-full lb-wperfumetest-widget">
      <div class="w-full lbwebformprogress relative">
        <div class="w-full lbwebformprogress-bar"></div>
        <div class="lbabsolute"></div>
      </div>

      <!-- First Step -->
      <form id="step1Form">
        <div class="lb-wperfume-content-area">
          <h1 class="text-center">
            <?php echo __('Wear your perfume', 'lbelementor'); ?>
          </h1>
          <div class="lb-wperfume-description text-center">
            Tell us something more about you, and we'll help you to find your perfect fragrance!
          </div>
          <div class="lb-wperfume-form-radios w-full">
            <div class="lb-wperfume-radio-item">
              <input type="radio" id="mens-perfume" name="lbcategory" value="mens-perfume" class="visually-hidden" required="required">
              <label for="mens-perfume" class="lb-wperfumeradiolabel">
                For Him
              </label>
            </div>
            <div class="lb-wperfume-radio-item">
              <input type="radio" id="womens-perfume" name="lbcategory" value="womens-perfume" class="visually-hidden" required="required">
              <label for="womens-perfume" class="lb-wperfumeradiolabel">
                For Her
              </label>
            </div>
          </div>
          <button type="button" class="disabled" id="nextStep1">
            <?php echo __('Start Test', 'lbelementor'); ?>
          </button>
        </div>
      </form>
      <!-- End of First Step -->

      <!-- Step 2 -->
      <form id="step2Form" style="display: none;">
        <div class="lb-wperfume-content-area w-full">
          <h1 class="text-center">
            <?php echo __('Which notes do you prefer', 'lbelementor'); ?>
          </h1>
          <div class="swiper wperfumenote-swiper w-full">
            <div class="lb-wperfume-notes-area swiper-wrapper w-full">
              <?php
              $terms = get_terms([
                'taxonomy' => 'notes',
                'hide_empty' => false,
              ]);

              if (($terms)) :
                foreach ($terms as $index => $item) :
                  if (function_exists('z_taxonomy_image_url')) :
                    $image = z_taxonomy_image_url($item->term_id);
                  endif;
              ?>
                  <div class="lb-wperfumenotes-radio-item swiper-slide">
                    <input type="radio" id="<?php echo $item->slug; ?>" name="notes" value="<?php echo $item->slug; ?>" class="visually-hidden" required="required">
                    <label for="<?php echo $item->slug; ?>" class="lb-wperfumenoteslabel">
                      <img src="<?php echo esc_url($image); ?>" alt="<?php $item->name; ?>">
                      <?php echo $item->name; ?>
                    </label>
                  </div>
              <?php
                endforeach;
              endif;
              ?>
            </div>
          </div>
          <button type="button" class="disabled" id="nextStep2">
            <?php echo __('Continue', 'lbelementor'); ?>
          </button>
          <p id="stepback" class="text-center"><?php echo __('<< Back', 'lbelementor'); ?></p>
        </div>
      </form>
      <!-- End of Step 2 -->

      <!-- Step 3 -->
      <form id="step3Form" style="display: none;">
        <div class="lb-wperfume-content-area w-full">
          <h1 class="text-center">
            <?php echo __('Which moment of the day is your favorite?', 'lbelementor'); ?>
          </h1>
          <div class="swiper wperfumemoment-swiper w-full">
            <div class="lb-wperfume-notes-area swiper-wrapper w-full">
              <?php
              $terms_moment = get_terms([
                'taxonomy' => 'moment',
                'hide_empty' => false,
              ]);

              if (($terms_moment)) :
                foreach ($terms_moment as $index => $item_moment) :
                  if (function_exists('z_taxonomy_image_url')) :
                    $image = z_taxonomy_image_url($item_moment->term_id);
                  endif;

              ?>
                  <div class="lb-wperfumemoments-radio-item swiper-slide">
                    <input type="radio" id="<?php echo $item_moment->slug; ?>" name="moment" value="<?php echo $item_moment->slug; ?>" class="visually-hidden" required="required">
                    <label for="<?php echo $item_moment->slug; ?>" class="lb-wperfumenoteslabel">
                      <img src="<?php echo esc_url($image); ?>" alt="<?php $item_moment->name; ?>">
                      <span class="text-center"><?php echo $item_moment->name; ?></span>
                      <span class="text-center momentdesc"><?php echo $item_moment->description; ?></span>
                    </label>
                  </div>
              <?php
                endforeach;
              endif;
              ?>
            </div>
          </div>
          <button type="button" class="disabled" id="nextStep3">
            <?php echo __('Continue', 'lbelementor'); ?>
          </button>
          <p id="stepback" class="text-center"><?php echo __('<< Back', 'lbelementor'); ?></p>
        </div>
      </form>
      <!-- End of Step 3 -->

      <!-- Step 4 -->
      <form id="step4Form" style="display: none;">
        <div class="lb-wperfume-content-area">
          <h1 class="text-center">
            <?php echo __('you prefer a perfume that is...', 'lbelementor'); ?>
          </h1>
          <div class="lb-wperfumeintensitiy-area d-lbsm-none">
            <p class="min-label">Light and Discrete</p>
            <input type="range" id="intensity" name="intensity" min="1" max="100">
            <p class="max-label">Intense and Persistent</p>
          </div>
          <button type="button" id="nextStep4">
            <?php echo __('Continue', 'lbelementor'); ?>
          </button>
          <p id="stepback" class="text-center"><?php echo __('<< Back', 'lbelementor'); ?></p>
        </div>
      </form>
      <!-- End of Step 4 -->


      <!-- Results Page -->
      <div id="results" style="display: none;">
      </div>
      <!-- End of Results Page -->
    </div>
<?php
  }
}
