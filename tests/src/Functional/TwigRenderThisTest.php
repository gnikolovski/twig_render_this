<?php

namespace Drupal\Tests\twig_render_this\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Twig Render This tests.
 *
 * @group twig_render_this
 */
class TwigRenderThisTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = [
    'node',
    'twig_render_this',
    'twig_render_this_test',
  ];

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();

    $types = ['page', 'article'];

    foreach ($types as $type) {
      $type = $this->createContentType(['type' => $type]);
      $node_values = [
        'title' => 'This is Twig Render This',
        'type' => $type->id(),
      ];
      $this->createNode($node_values);
    }
  }

  /**
   * Tests with renderThis filter.
   */
  public function testWithFilter() {
    $this->drupalGet('node/1');
    $this->assertText('Hello world!');
    $this->assertText('This is Twig Render This');
  }

  /**
   * Tests without renderThis filter.
   */
  public function testWithoutFilter() {
    $this->drupalGet('node/2');
    $this->assertText('Object of type Drupal\Core\Field\FieldItemList cannot be printed');
  }

}
