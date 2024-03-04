<?php

namespace OpenOfficeGenerator;

class ODTFile extends ZipArchive {
  private $files;
  protected $content;
  public $path;

  public function __construct($filename, $template_path = "/templates/%extension%/" ){
    $path_info = pathinfo($filename);
    $template_path = str_replace("%extension%", $path_info['extension'], $template_path);
    $this->path = dirname(__FILE__) . $template_path;
    if ($this->open($filename, ZIPARCHIVE::CREATE) !== TRUE) {
      die("Unable to open <$filename>\n");
    }
    $this->files = array(
      "META-INF/manifest.xml",
      "styles.xml",
      "mimetype"
    );

    foreach($this->files as $f) {
      $this->addFile($this->path.$f, $f);
    }
  }

  public function create_from_content($content) {
    $this->addFromString("content.xml", $content);
    $this->close();
  }
  public function create_from_file($filename) {
    $this->addFile($filename, "content.xml");
    $this->close();
  }
  public function create_from_document($document, $temp_path = "/../temp/") {
    $tmpfname = tempnam(dirname(__FILE__) . $temp_path, "doc_odt_");
    $handle = fopen($tmpfname, "w");
    foreach($document->create() as $doc_str) {
      fwrite($handle, $doc_str);
    }
    fclose($handle);

    $this->create_from_file($tmpfname);
    unlink($tmpfname);
  }
}
