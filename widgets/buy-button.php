<?php

/**
 * Buy Button Elementor Widget Addon
 * 
 * @package lbelementor
 */

namespace LBELEMENTOR\ElementorWidgets\Widgets;

use Elementor\Widget_Base;

class buy_button extends Widget_Base
{

  public function get_name()
  {
    return 'lb-buy-button';
  }

  public function get_title()
  {
    return __('LB Buy Button', 'lbelementor');
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
      'title',
      [
        'label' => __('Button Title', 'lbelementor'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __('Buy', 'lbelementor'),
        'placeholder' => __('Add Button Title Here', 'lbelementor'),
      ]
    );


    $this->end_controls_section();
  }

  protected function render()
  {

    $settings = $this->get_settings_for_display();
    $title = $settings['title'];
    $product_id = get_the_ID();
    $lbbrands = get_field('lbbrands', $product_id);
?>
    <div class="lb-elementor-buybutton">
      <button type="button" class="lbmodalbtn">
        <span><?php echo __($title, 'lbelementor'); ?></span>
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
                        <?php echo __($title, 'lbelementor'); ?>
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
<?php
  }
}
