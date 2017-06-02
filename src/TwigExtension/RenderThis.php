<?php

namespace Drupal\twig_render_this\TwigExtension;

/**
 * Twig render this filter.
 */
class RenderThis extends \Twig_Extension {

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return 'twig_render_this.twig_extension';
  }

  /**
   * {@inheritdoc}
   */
  public function getFilters() {
    return array(
      new \Twig_SimpleFilter('renderThis', [$this, 'renderThisFilter']),
    );
  }

  /**
   * Returns the rendered array for a single entity field.
   *
   * @param object $field
   *   Field object.
   * @param string $display_options
   *   Name of the display mode.
   *
   * @return NULL|array
   *   A rendered array for the field or NULL if the value does not exist.
   */
  public static function renderThisFilter($field, $display_options = 'default') {
    return method_exists($field, 'view') ?
      $field->view($display_options) : NULL;
  }

}
