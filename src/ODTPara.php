<?php

namespace OpenDocumentGenerator;

class ODTPara extends ODElement {
  public $text = "";
  function __construct($text, $style_name = "Standard") {
    parent::__construct("text", "p", $style_name);
    $this->text = $text;
    $this->attributes = "text:style-name=\"$style_name\"";
  }
  public function get_content() {
    // yield "<text:span text:style-name=\"$this->style_name\">$this->text</text:span>";
    if(count($this->content) > 0) {
      yield from parent::get_content();
    } else {
      yield htmlspecialchars($this->text);
    }
  }
}

// class ODTSoftPageBreak extends ODElement {
//   function __construct() {
//     parent::__construct("text", "soft-page-break");
//     $this->self_closing = true;
//   }
// }

