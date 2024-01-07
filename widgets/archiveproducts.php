<?php

/**
 * Archive Products Widget Addon for LB Elementor
 * 
 * @package lbelementor
 */

namespace LBELEMENTOR\ElementorWidgets\Widgets;

use Elementor\Widget_Base;

class archiveproducts extends Widget_Base
{

  public function get_name()
  {
    return 'lb-products-archive';
  }

  public function get_title()
  {
    return __('LB Archive Products');
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
    wp_register_script('lbelementor-script', plugins_url('js/script.js', __FILE__));

    return ['swiperlb-js', 'lbelementor-script'];
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
      'numberpost',
      [
        'label' => __('Number of posts', 'lbelementor'),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'default' => 4,
        'step' => 1,
      ]
    );

    $options = [];
    $options_args = [
      'taxonomy' => 'lbproductcategory',
      'hide_empty' => false,
    ];
    $options_categories = get_categories($options_args);
    foreach ($options_categories as $category) {
      $options[$category->slug] = $category->name;
    }

    $this->add_control(
      'lbproduct-categories',
      [
        'label' => __('Categories', 'lbelementor'),
        'type' => \Elementor\Controls_Manager::SELECT2,
        'multiple' => true,
        'options' => $options,
      ]
    );

    $this->add_control(
      'source-order',
      [
        'label' => __('Order', 'lbelementor'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'options' => [
          'ASC' => __('ASC', 'lbelementor'),
          'DESC' => __('DESC', 'lbelementor')
        ],
        'default' => 'DESC'
      ]
    );

    $this->end_controls_section();
  }

  protected function render()
  {
    global $post;
    $settings = $this->get_settings_for_display();
    $limit = $settings['numberpost'];
    $categoryname = $settings['lbproduct-categories'];
    $order = $settings['source-order'];
    $args = [
      'post_type' => 'lbproducts',
      'posts_per_page' => $limit,
      'order' => $order
    ];

    $args['tax_query'] = [
      'relation' => 'AND',
      [
        'taxonomy' => 'lbproductcategory',
        'field' => 'slug',
        'terms' => $categoryname,
      ]
    ];

    $post_query = new \WP_Query($args);

    if ($post_query->have_posts()) :
?>
      
      <div class="lbgrid">
        <?php
        while ($post_query->have_posts()) :
          $post_query->the_post();
          $secimage = get_field('lbsecondfeatured');
          $lbbrands = get_field('lbbrands');
          $sort_terms = get_the_terms(get_the_ID(), 'sort');
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
        endwhile;
        ?>
      </div>
<?php
    endif;
  }
}
