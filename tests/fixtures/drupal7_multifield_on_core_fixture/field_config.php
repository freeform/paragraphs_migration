<?php
// @codingStandardsIgnoreFile
/**
 * @file
 * A database agnostic dump for testing purposes.
 *
 * This file was generated by the Drupal 9.1.9 db-tools.php script.
 */

use Drupal\Core\Database\Database;

$connection = Database::getConnection();

// The field_link (ID 15) and field_text_sum_filtered (ID 33) field storages
// should have an "entity_translation_sync" settings with boolean FALSE value.
foreach ([15, 33] as $id) {
  $data_serialized = $connection->select('field_config', 'fc')
    ->fields('fc', ['data'])
    ->condition('fc.id', $id)
    ->execute()
    ->fetchCol()[0];

  $data = unserialize($data_serialized);
  assert(is_array($data));
  $data['settings']['entity_translation_sync'] = FALSE;

  $connection->update('field_config')
    ->condition('id', $id)
    ->fields(['data' => serialize($data)])
    ->execute();
}

$connection->insert('field_config')
->fields(array(
  'id',
  'field_name',
  'type',
  'module',
  'active',
  'storage_type',
  'storage_module',
  'storage_active',
  'locked',
  'data',
  'cardinality',
  'translatable',
  'deleted',
))
->values(array(
  'id' => '156',
  'field_name' => 'field_multifield_w_text_fields',
  'type' => 'multifield',
  'module' => 'multifield',
  'active' => '1',
  'storage_type' => 'field_sql_storage',
  'storage_module' => 'field_sql_storage',
  'storage_active' => '1',
  'locked' => '0',
  'data' => 'a:7:{s:12:"translatable";i:1;s:12:"entity_types";a:0:{}s:8:"settings";a:2:{s:16:"hide_blank_items";i:1;s:23:"entity_translation_sync";a:1:{i:0;s:2:"id";}}s:7:"storage";a:5:{s:4:"type";s:17:"field_sql_storage";s:8:"settings";a:0:{}s:6:"module";s:17:"field_sql_storage";s:6:"active";s:1:"1";s:7:"details";a:1:{s:3:"sql";a:2:{s:18:"FIELD_LOAD_CURRENT";a:1:{s:41:"field_data_field_multifield_w_text_fields";a:6:{s:22:"field_text_plain_value";s:53:"field_multifield_w_text_fields_field_text_plain_value";s:23:"field_text_plain_format";s:54:"field_multifield_w_text_fields_field_text_plain_format";s:29:"field_text_sum_filtered_value";s:60:"field_multifield_w_text_fields_field_text_sum_filtered_value";s:31:"field_text_sum_filtered_summary";s:62:"field_multifield_w_text_fields_field_text_sum_filtered_summary";s:30:"field_text_sum_filtered_format";s:61:"field_multifield_w_text_fields_field_text_sum_filtered_format";s:2:"id";s:33:"field_multifield_w_text_fields_id";}}s:19:"FIELD_LOAD_REVISION";a:1:{s:45:"field_revision_field_multifield_w_text_fields";a:6:{s:22:"field_text_plain_value";s:53:"field_multifield_w_text_fields_field_text_plain_value";s:23:"field_text_plain_format";s:54:"field_multifield_w_text_fields_field_text_plain_format";s:29:"field_text_sum_filtered_value";s:60:"field_multifield_w_text_fields_field_text_sum_filtered_value";s:31:"field_text_sum_filtered_summary";s:62:"field_multifield_w_text_fields_field_text_sum_filtered_summary";s:30:"field_text_sum_filtered_format";s:61:"field_multifield_w_text_fields_field_text_sum_filtered_format";s:2:"id";s:33:"field_multifield_w_text_fields_id";}}}}}s:12:"foreign keys";a:2:{s:23:"field_text_plain_format";a:2:{s:5:"table";s:13:"filter_format";s:7:"columns";a:1:{s:23:"field_text_plain_format";s:6:"format";}}s:30:"field_text_sum_filtered_format";a:2:{s:5:"table";s:13:"filter_format";s:7:"columns";a:1:{s:30:"field_text_sum_filtered_format";s:6:"format";}}}s:7:"indexes";a:3:{s:23:"field_text_plain_format";a:1:{i:0;s:23:"field_text_plain_format";}s:30:"field_text_sum_filtered_format";a:1:{i:0;s:30:"field_text_sum_filtered_format";}s:2:"id";a:1:{i:0;s:2:"id";}}s:2:"id";s:3:"156";}',
  'cardinality' => '-1',
  'translatable' => '1',
  'deleted' => '0',
))
->values(array(
  'id' => '157',
  'field_name' => 'field_multifield_complex_fields',
  'type' => 'multifield',
  'module' => 'multifield',
  'active' => '1',
  'storage_type' => 'field_sql_storage',
  'storage_module' => 'field_sql_storage',
  'storage_active' => '1',
  'locked' => '0',
  'data' => 'a:7:{s:12:"translatable";s:1:"0";s:12:"entity_types";a:0:{}s:8:"settings";a:2:{s:16:"hide_blank_items";i:1;s:23:"entity_translation_sync";a:1:{i:0;s:2:"id";}}s:7:"storage";a:5:{s:4:"type";s:17:"field_sql_storage";s:8:"settings";a:0:{}s:6:"module";s:17:"field_sql_storage";s:6:"active";s:1:"1";s:7:"details";a:0:{}}s:12:"foreign keys";a:1:{s:14:"field_tags_tid";a:2:{s:5:"table";s:18:"taxonomy_term_data";s:7:"columns";a:1:{s:14:"field_tags_tid";s:3:"tid";}}}s:7:"indexes";a:2:{s:14:"field_tags_tid";a:1:{i:0;s:14:"field_tags_tid";}s:2:"id";a:1:{i:0;s:2:"id";}}s:2:"id";s:3:"157";}',
  'cardinality' => '1',
  'translatable' => '0',
  'deleted' => '0',
))
->values(array(
  'id' => '158',
  'field_name' => 'field_deleted_multifield',
  'type' => 'multifield',
  'module' => 'multifield',
  'active' => '1',
  'storage_type' => 'field_sql_storage',
  'storage_module' => 'field_sql_storage',
  'storage_active' => '1',
  'locked' => '0',
  'data' => 'a:7:{s:12:"translatable";s:1:"0";s:12:"entity_types";a:0:{}s:8:"settings";a:2:{s:16:"hide_blank_items";i:1;s:23:"entity_translation_sync";a:1:{i:0;s:2:"id";}}s:7:"storage";a:5:{s:4:"type";s:17:"field_sql_storage";s:8:"settings";a:0:{}s:6:"module";s:17:"field_sql_storage";s:6:"active";s:1:"1";s:7:"details";a:0:{}}s:12:"foreign keys";a:1:{s:17:"field_text_format";a:2:{s:5:"table";s:13:"filter_format";s:7:"columns";a:1:{s:17:"field_text_format";s:6:"format";}}}s:7:"indexes";a:3:{s:17:"field_text_format";a:1:{i:0;s:17:"field_text_format";}s:37:"field_subfield_of_deleted_multi_value";a:1:{i:0;s:37:"field_subfield_of_deleted_multi_value";}s:2:"id";a:1:{i:0;s:2:"id";}}s:2:"id";s:3:"158";}',
  'cardinality' => '1',
  'translatable' => '0',
  'deleted' => '1',
))
->values(array(
  'id' => '159',
  'field_name' => 'field_subfield_of_deleted_multi',
  'type' => 'list_boolean',
  'module' => 'list',
  'active' => '1',
  'storage_type' => 'field_sql_storage',
  'storage_module' => 'field_sql_storage',
  'storage_active' => '1',
  'locked' => '0',
  'data' => 'a:7:{s:12:"translatable";i:0;s:12:"entity_types";a:0:{}s:8:"settings";a:3:{s:14:"allowed_values";a:2:{i:0;s:0:"";i:1;s:0:"";}s:23:"allowed_values_function";s:0:"";s:23:"entity_translation_sync";b:0;}s:7:"storage";a:5:{s:4:"type";s:17:"field_sql_storage";s:8:"settings";a:0:{}s:6:"module";s:17:"field_sql_storage";s:6:"active";s:1:"1";s:7:"details";a:1:{s:3:"sql";a:2:{s:18:"FIELD_LOAD_CURRENT";a:1:{s:42:"field_data_field_subfield_of_deleted_multi";a:1:{s:5:"value";s:37:"field_subfield_of_deleted_multi_value";}}s:19:"FIELD_LOAD_REVISION";a:1:{s:46:"field_revision_field_subfield_of_deleted_multi";a:1:{s:5:"value";s:37:"field_subfield_of_deleted_multi_value";}}}}}s:12:"foreign keys";a:0:{}s:7:"indexes";a:1:{s:5:"value";a:1:{i:0;s:5:"value";}}s:2:"id";s:3:"159";}',
  'cardinality' => '1',
  'translatable' => '0',
  'deleted' => '1',
))
->execute();