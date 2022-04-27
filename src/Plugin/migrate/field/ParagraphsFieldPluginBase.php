<?php

namespace Drupal\paragraphs_migration\Plugin\migrate\field;

use Drupal\migrate\Plugin\migrate\destination\DestinationBase;
use Drupal\migrate\Plugin\MigrateDestinationInterface;
use Drupal\migrate\Plugin\MigrationInterface;
use Drupal\migrate_drupal\Plugin\migrate\field\FieldPluginBase;
use Drupal\paragraphs_migration\ParagraphsMigration;

/**
 * Base class for plugins wishing to support metadata inspection.
 */
abstract class ParagraphsFieldPluginBase extends FieldPluginBase {

  /**
   * The base ID of the default revision's migration.
   *
   * @var string
   */
  protected $migrationDependencyBaseId;

  /**
   * The base ID of the non-default revision's migration.
   *
   * @var string
   */
  protected $revisionMigrationDependencyBaseId;

  /**
   * Returns the migration dependencies for an entity migration.
   *
   * @param \Drupal\migrate\Plugin\MigrationInterface $migration
   *   The migration to parse.
   * @param string $field_name
   *   The name of the paragraphs or the field_collection field.
   *
   * @return string[]
   *   Array of the required migrations.
   */
  protected function getParentBasedMigrationDependencies(MigrationInterface $migration, string $field_name) {
    // Add the respective paragraphs or field collection migration dependency.
    $required_migrations = [];
    $destination_plugin = $migration->getDestinationPlugin();
    assert($destination_plugin instanceof DestinationBase);
    $destination_plugin_id = $destination_plugin->getPluginId();
    $destination_config = $destination_plugin->configuration;
    $is_revision_migration = $this->destinationIsEntityRevision($destination_plugin);

    $source_entity_type_id = !empty($migration->getSourceConfiguration()['legacy_entity_type_id'])
      ? $migration->getSourceConfiguration()['legacy_entity_type_id']
      : NULL;
    $destination_entity_type_id = strpos($destination_plugin_id, 'entity:') === 0 || $is_revision_migration
      ? explode(':', $destination_plugin_id)[1]
      : NULL;

    if (!$source_entity_type_id && !$destination_entity_type_id) {
      throw new \LogicException(sprintf('%s cannot determine the entity_type_id for migrating the values of field "%s" in the migration with plugin ID "%s"', get_class($this), $field_name, $migration->id()));
    }

    $source_entity_bundle_id = !empty($migration->getSourceConfiguration()['legacy_entity_bundle_id'])
      ? $migration->getSourceConfiguration()['legacy_entity_bundle_id']
      : NULL;
    $destination_entity_bundle_id = $destination_entity_type_id && !empty($destination_config['default_bundle'])
      ? $destination_config['default_bundle']
      : NULL;

    // In case of paragraphs or field collections, the destination entity type
    // ID is not the same as the source entity type ID. Since the paragraph
    // migration derivative IDs are based on the source entity type ID and
    // bundle, we have to use those for specifying the migration dependencies
    // for the parent entity migration of this field.
    $required_migration_suffix = implode(':', [
      'parent_entity_type_id' => $source_entity_type_id ?? $destination_entity_type_id,
      // For entity types without a bundle, we use the entity type ID as bundle.
      'parent_entity_bundle_id' => $source_entity_bundle_id ?? $destination_entity_bundle_id ?? $source_entity_type_id ?? $destination_entity_type_id,
      'host_field' => $field_name,
    ]);
    $required_migrations[] = implode(':', [
      $this->migrationDependencyBaseId,
      $required_migration_suffix,
    ]);

    if ($is_revision_migration) {
      $required_migrations[] = implode(':', [
        $this->revisionMigrationDependencyBaseId,
        $required_migration_suffix,
      ]);
    }

    if ($this->migrationDependencyBaseId === 'd7_pm_paragraphs') {
      $source = $migration->getSourceConfiguration();
      $preexisting_raw_dependencies = $source[ParagraphsMigration::PARAGRAPHS_RAW_DEPENDENCIES] ?? [];
      $source[ParagraphsMigration::PARAGRAPHS_RAW_DEPENDENCIES] = array_unique(array_merge($preexisting_raw_dependencies, $required_migrations));
      $migration->set('source', $source);
    }

    return $required_migrations;
  }

  /**
   * Checks whether a migration's destination is an entity revision.
   *
   * @param \Drupal\migrate\Plugin\MigrateDestinationInterface $destination
   *   The migration destination to check.
   *
   * @return bool
   *   TRUE if the destination base ID is on of:
   *   - entity_revision
   *   - entity_complete
   *   - entity_reference_revisions with 'new_revisions' set to TRUE.
   *   FALSE in every other case.
   */
  protected function destinationIsEntityRevision(MigrateDestinationInterface $destination) {
    $destination_plugin_id = $destination->getPluginId();
    $destination_config = (array) $destination->configuration;

    return strpos($destination_plugin_id, 'entity_revision:') === 0
      || strpos($destination_plugin_id, 'entity_complete:') === 0
      || (strpos($destination_plugin_id, 'entity_reference_revisions:') === 0 && !empty($destination_config['new_revisions']));
  }

}