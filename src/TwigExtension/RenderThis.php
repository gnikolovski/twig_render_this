<?php

namespace Drupal\twig_render_this\TwigExtension;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * Twig Render This filter.
 */
class RenderThis extends AbstractExtension {

  /**
   * {@inheritdoc}
   */
  public function getName(): string {
    return 'twig_render_this.twig_extension';
  }

  /**
   * {@inheritdoc}
   */
  public function getFilters(): array {
    return [
      new TwigFilter('renderThis', $this->renderThisFilter(...)),
    ];
  }

  /**
   * Returns the rendered array for a single entity field.
   *
   * @param mixed $content
   *   Entity or Field object.
   * @param string $view_mode
   *   Name of the display mode.
   *
   * @return null|array|TranslatableMarkup
   *   A rendered array for the field or NULL if the value does not exist.
   */
  public static function renderThisFilter(mixed $content, string $view_mode = 'default'): array|TranslatableMarkup|null {
    if ($content instanceof EntityInterface) {
      $view_builder = \Drupal::entityTypeManager()
        ->getViewBuilder($content->getEntityTypeId());
      return $view_builder->view($content, $view_mode);
    }
    elseif ($content instanceof FieldItemInterface ||
      $content instanceof FieldItemListInterface ||
      method_exists($content, 'view')
    ) {
      return $content->view($view_mode);
    }
    else {
      return t('Twig Render This: Unsupported content.');
    }
  }

}
