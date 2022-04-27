<?php

namespace Drupal\paragraphs_migration\Plugin\migrate\source\d7;

use Drupal\migrate\Row;
use Drupal\paragraphs_migration\Plugin\migrate\source\DrupalSqlBase;

/**
 * Paragraphs Type source plugin.
 *
 * Available configuration keys:
 * - add_description: (bool) (optional) If enabled this will add a default
 *   description to the source data. default:FALSE.
 *
 * @MigrateSource(
 *   id = "d7_pm_paragraphs_type",
 *   source_module = "paragraphs"
 * )
 */
class ParagraphsType extends DrupalSqlBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'add_description' => FALSE,
    ] + parent::defaultConfiguration();
  }

  /**
   * {@inheritdoc}
   */
  public function query() {
    $bundles_query = $this->select('paragraphs_bundle', 'pt')
      ->fields('pt', ['bundle']);
    $missing_bundles_from_items_query = $this->select('paragraphs_item', 'pi')
      ->distinct()
      ->fields('pi', ['bundle']);
    $bundles_query->union($missing_bundles_from_items_query);

    $query = $this->select($bundles_query, 'ptpi')
      ->fields('ptpi', ['bundle'])
      ->fields('pb', ['name', 'locked']);
    $query->leftJoin('paragraphs_bundle', 'pb', 'pb.bundle = ptpi.bundle');

    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {

    // Paragraph bundles did not have descriptions in d7, optionally add one.
    if ($this->configuration['add_description']) {
      $name = $row->getSourceProperty('name') ?? preg_replace('/_+/', ' ', $row->getSourceProperty('bundle'));
      $row->setSourceProperty('description', 'Migrated from paragraph bundle ' . $name);
    }
    else {
      $row->setSourceProperty('description', '');
    }

    return parent::prepareRow($row);
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    return [
      'bundle' => $this->t('Paragraph type machine name'),
      'name' => $this->t('Paragraph type label'),
      'description' => $this->t('Paragraph type description'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getIds() {
    $ids['bundle']['type'] = 'string';
    $ids['bundle']['alias'] = 'ptpi';
    return $ids;
  }

  /**
   * {@inheritdoc}
   */
  public function setConfiguration(array $configuration) {
    // Configuration keys should be snake_case, not CamelCase. Adding a BC
    // layer for addDescription which should be deprecated.
    if (isset($configuration['addDescription'])) {
      @trigger_error("The addDescription configuration key is deprecated in paragraphs:8.x-1.0 and is removed from paragraphs:8.x-2.0. Use add_description instead. See https://www.drupal.org/project/paragraphs/issues/2911242", E_USER_DEPRECATED);
      if (!isset($configuration['add_description'])) {
        $configuration['add_description'] = $configuration['addDescription'];
      }
      unset($configuration['addDescription']);
    }

    parent::setConfiguration($configuration);
  }

}
