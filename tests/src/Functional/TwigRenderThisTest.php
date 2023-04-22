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
  protected static $modules = [
    'menu_ui',
    'node',
    'user',
    'twig_render_this',
    'twig_render_this_test',
    'views',
  ];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * {@inheritdoc}
   */
  public function setUp(): void {
    parent::setUp();

    $types = ['article', 'page', 'product'];

    foreach ($types as $type) {
      $type = $this->createContentType(['type' => $type]);
      $node_values = [
        'title' => 'This is Twig Render This',
        'type' => $type->id(),
      ];
      $this->createNode($node_values);
    }

    $nodes = [
      'Start Trek TNG' => 'Star Trek: The Next Generation (TNG) is an American science fiction television series created by Gene Roddenberry.',
      'Start Trek DS9' => 'Star Trek: Deep Space Nine (DS9) is an American science fiction television series created by Rick Berman and Michael Piller.',
      'Start Trek Voyager' => 'Star Trek: Voyager is an American science fiction television series created by Rick Berman, Michael Piller, and Jeri Taylor.',
    ];

    foreach ($nodes as $title => $description) {
      $this->createNode([
        'type' => 'news',
        'title' => $title,
        'field_description' => $description,
      ]);
    }
  }

  /**
   * Tests rendering entities.
   */
  public function testEntities() {
    $this->drupalGet('news');
    $this->assertSession()->pageTextContains('Using Twig Render This to render entities');
    $this->assertSession()->pageTextContains('Start Trek TNG');
    $this->assertSession()->pageTextContains('Star Trek: The Next Generation (TNG) is an American science fiction television series created by Gene Roddenberry.');
    $this->assertSession()->pageTextContains('Start Trek DS9');
    $this->assertSession()->pageTextNotContains('Star Trek: Deep Space Nine (DS9) is an American science fiction television series created by Rick Berman and Michael Piller.');
    $this->assertSession()->pageTextContains('Start Trek Voyager');
    $this->assertSession()->pageTextNotContains('Star Trek: Voyager is an American science fiction television series created by Rick Berman, Michael Piller, and Jeri Taylor.');
  }

  /**
   * Tests rendering a field with renderThis filter.
   */
  public function testFieldWithFilter() {
    $this->drupalGet('node/1');
    $this->assertSession()->pageTextContains('Hello world!');
    $this->assertSession()->pageTextContains('This is Twig Render This');
  }

  /**
   * Tests rendering a field without renderThis filter.
   */
  public function testFieldWithoutFilter() {
    $this->drupalGet('node/2');
    $this->assertSession()->pageTextContains('Object of type Drupal\Core\Field\FieldItemList cannot be printed');
  }

  /**
   * Tests unsupported content.
   */
  public function testUnsupportedContent() {
    $this->drupalGet('node/3');
    $this->assertSession()->pageTextContains('Twig Render This: Unsupported content.');
  }

}
