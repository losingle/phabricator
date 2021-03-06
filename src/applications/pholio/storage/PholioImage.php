<?php

/**
 * @group pholio
 */
final class PholioImage extends PholioDAO
  implements PhabricatorMarkupInterface {

  const MARKUP_FIELD_DESCRIPTION  = 'markup:description';

  protected $mockID;
  protected $filePHID;
  protected $name = '';
  protected $description = '';
  protected $sequence;

  private $file;

/* -(  PhabricatorMarkupInterface  )----------------------------------------- */


  public function getMarkupFieldKey($field) {
    $hash = PhabricatorHash::digest($this->getMarkupText($field));
    return 'M:'.$hash;
  }

  public function newMarkupEngine($field) {
    return PhabricatorMarkupEngine::newMarkupEngine(array());
  }

  public function getMarkupText($field) {
    return $this->getDescription();
  }

  public function didMarkupText($field, $output, PhutilMarkupEngine $engine) {
    return $output;
  }

  public function shouldUseMarkupCache($field) {
    return (bool)$this->getID();
  }

  public function attachFile(PhabricatorFile $file) {
    $this->file = $file;
    return $this;
  }

  public function getFile() {
    if ($this->file === null) {
      throw new Exception("Call attachFile() before getFile()!");
    }
    return $this->file;
  }

}
