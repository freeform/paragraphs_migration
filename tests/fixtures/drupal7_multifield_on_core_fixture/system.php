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

$connection->insert('system')
->fields(array(
  'filename',
  'name',
  'type',
  'owner',
  'status',
  'bootstrap',
  'schema_version',
  'weight',
  'info',
))
->values(array(
  'filename' => 'sites/all/modules/multifield/multifield.module',
  'name' => 'multifield',
  'type' => 'module',
  'owner' => '',
  'status' => '1',
  'bootstrap' => '0',
  'schema_version' => '7101',
  'weight' => '0',
  'info' => 'a:16:{s:4:"name";s:10:"Multifield";s:11:"description";s:28:"Provides a combo field type.";s:7:"package";s:6:"Fields";s:4:"core";s:3:"7.x";s:12:"dependencies";a:2:{i:0;s:6:"ctools";i:1;s:5:"field";}s:9:"configure";s:26:"admin/structure/multifield";s:5:"files";a:10:{i:0;s:30:"MultifieldEntityController.php";i:1;s:43:"tests/MultifieldAdministrationTestCase.test";i:2;s:44:"tests/MultifieldCommerceIntegrationTest.test";i:3;s:42:"tests/MultifieldDevelGenerateTestCase.test";i:4;s:46:"tests/MultifieldEntityTranslationTestCase.test";i:5;s:38:"tests/MultifieldFileUsageTestCase.test";i:6;s:45:"tests/MultifieldNodeCloneIntegrationTest.test";i:7;s:45:"tests/MultifieldReplicateIntegrationTest.test";i:8;s:29:"tests/MultifieldTestBase.test";i:9;s:33:"tests/MultifieldUnitTestCase.test";}s:17:"test_dependencies";a:11:{i:0;s:12:"addressfield";i:1;s:5:"clone";i:2;s:8:"commerce";i:3;s:4:"date";i:4;s:5:"devel";i:5;s:5:"email";i:6;s:15:"entityreference";i:7;s:18:"entity_translation";i:8;s:16:"field_collection";i:9;s:9:"replicate";i:10;s:3:"url";}s:7:"version";s:14:"7.x-1.0-alpha4";s:7:"project";s:10:"multifield";s:9:"datestamp";s:10:"1466105019";s:5:"mtime";i:1466105019;s:3:"php";s:5:"5.2.4";s:9:"bootstrap";i:0;s:8:"required";b:1;s:11:"explanation";s:73:"Field type(s) in use - see <a href="/admin/reports/fields">Field list</a>";}',
))
->execute();
