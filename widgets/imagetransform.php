<?php

/**
 * Image Transform Widget Addon for LB
 * 
 * @package lbelementor
 */

namespace LBELEMENTOR\ElementorWidgets\Widgets;

use Elementor\Widget_Base;

class imagetransform extends Widget_Base
{

  public function get_name()
  {
    return 'lb-image-transform';
  }

  public function get_title()
  {
    return __('LB Image Transform');
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
    wp_register_style('lb-style', plugins_url('scss/style.css', __FILE__));

    return ['lb-style'];
  }

  public function get_script_depends()
  {
    wp_register_script('lbelementor-script', plugins_url('js/script.js', __FILE__));

    return ['lbelementor-script'];
  }

  public function register_controls()
  {
    $this->start_controls_section(
      'content',
      [
        'label' => __('Content', 'lbelementor'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
      ]
    );

    $this->add_control(
      'gallery',
      [
        'label' => __('Gallery', 'lbelementor'),
        'type' => \Elementor\Controls_Manager::GALLERY,
        'show_label' => 'false',
        'default' => [],
      ]
    );

    $this->end_controls_section();
  }


  protected function render()
  {
    $settings = $this->get_settings_for_display();
    $gallery = $settings['gallery'];
    if ($gallery) :
?>
      <div class="lbproductdrag-area">
        <?php foreach ($gallery as $index => $image) :
        ?>
          <img src="<?php echo esc_url($image['url']); ?>" alt="Product Image" class="lb-gallery-image <?php echo $index === 0 ? 'active' : ''; ?>" id="lb-image-<?php echo $index; ?>">
        <?php
        endforeach; ?>
        <div class="lb-drag-mouse">
          <p>Drag to discover</p>
          <div class="lb-drag-image">
            <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
              <rect width="30" height="30" fill="url(#pattern0)" />
              <defs>
                <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
                  <use xlink:href="#image0_36_9" transform="scale(0.0166667)" />
                </pattern>
                <image id="image0_36_9" width="60" height="60" xlink:href="data:image/png;base64,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" />
              </defs>
            </svg>
          </div>
          <div id="lb-slider" class="lb-slider">
            <?php
            foreach ($gallery as $index => $image) :
            ?>
              <div class="lb-drag-circle" id="lb-image-<?php echo $index; ?>"></div>
            <?php
            endforeach;
            ?>
          </div>
        </div>
      </div>

<?php
    endif;
  }
}
