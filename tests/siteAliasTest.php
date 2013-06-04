<?php

/*
 * @file
 *   Tests for sitealias.inc
 *
 * @group base
 */
class saCase extends Drush_CommandTestCase {

  /*
   * Assure that site lists work as expected.
   * @todo Use --backend for structured return data. Depends on http://drupal.org/node/1043922
   */
  public function testSAList() {
    $sites = $this->setUpDrupal(2);
    $subdirs = array_keys($sites);
    $eval = 'print "bon";';
    $options = array(
      'yes' => NULL,
      'verbose' => NULL,
      'root' => $this->webroot(),
    );
    foreach ($subdirs as $dir) {
      $dirs[] = "#$dir";
    }
    $this->drush('php-eval', array($eval), $options, implode(',', $dirs));
    $output = $this->getOutputAsList();
    $expected = "You are about to execute 'php-eval print \"bon\";' non-interactively (--yes forced) on all of the following targets:
  #dev
  #stage
Continue?  (y/n): y
#stage >> bon
#dev   >> bon";
    $this->assertEquals($expected, implode("\n", $output));
  }
}
