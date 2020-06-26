<?php
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();
if (!defined('DOKU_LF')) define('DOKU_LF',"\n");

/** Additional Formatting modes.

    This plugin adds more formatting options, covering most of the inline
    styles of XHTML. A simpler syntax is also available for some of the
    existing styles.

    Syntax:
      /+Insert+/
      /-Delete-/
      <ins desc =cite @date>
      <del desc =cite @date>
      /,Subscript,/
      /^Superscript^/
      ``Keyboard``
      ??Variable??
      @@Definition@@
      !!SmallCaps!!
      &&Cite&&
      ""=cite|Quotation""
      <quote cite>Blockquote</quote>
      /!Inverse!/

    License: GPL
    */
abstract class FormattingPlus_Syntax_Plugin extends DokuWiki_Syntax_Plugin {

  var $formatting = array();
  var $pattern = '';

  function _getName() {
    return "";
  }
  function _getDesc() {
    return "";
  }
  function _getConfig() {
    return "";
  }

  /**
   * Generic Formatting Description
   *
   * This method returns an array with formatting information.
   *
   * 'open' - Text that begins the formatting.
   * 'close' - Text that ends the formatting.
   * 'tag' - Name of the XHTML tag to render.
   * 'attrs' - Optional attribute string that will be added to the start tag.
   */
  function _getFormatting() {
    return array();
  }

  function _disabledSyntax($type) {
    static $disabled = null;
    if (is_null($disabled)) {
      $disabled = explode(',',$this->getConf('disable_syntax'));
      $disabled = array_map('trim',$disabled);
    }
    if (in_array('all', $disabled)) return true;
    return in_array($type, $disabled);
  }

  function getType() {
    return 'formatting';
  }

  function getAllowedTypes() {
    return array('formatting','substition','disabled');
  }

  function preConnect() {
    if (!empty($this->formatting)) return;

    if ($this->_disabledSyntax($this->_getConfig())) return;

    $this->formatting = $this->_getFormatting();
    if (!empty($this->formatting)) {
      $this->pattern = $this->formatting['open'] . '(?=.*' . $this->formatting['close'] . ')';
    }
  }

  function connectTo($mode) {
    if (!empty($this->pattern))
     $this->Lexer->addEntryPattern($this->pattern, $mode, 'plugin_formatplus2_'.$this->getPluginComponent());
  }

  function postConnect() {
    if (!empty($this->pattern))
      $this->Lexer->addExitPattern($this->formatting['close'], 'plugin_formatplus2_'.$this->getPluginComponent());
  }

  function handle($match, $state, $pos, Doku_Handler $handler){
    $formatting = $this->_getFormatting();
    if (empty($formatting)) return array(DOKU_LEXER_UNMATCHED,$match);
    if ($state != DOKU_LEXER_UNMATCHED) {
      $output = $formatting['tag'];
      if ($state == DOKU_LEXER_ENTER && isset($formatting['attrs']))
        $output .= ' '.$formatting['attrs'];
    }
    else
      $output = $match;
    return array($state,$output);
  }

  function render($format, Doku_Renderer $renderer, $data) {
    list($state,$output) = $data;
    if ($format == 'xhtml'){
      switch ($state) {
        case DOKU_LEXER_ENTER:
          $renderer->doc .= "<$output>";
          break;
        case DOKU_LEXER_EXIT:
          $renderer->doc .= "</$output>";
          break;
        case DOKU_LEXER_UNMATCHED:
          $renderer->doc .= $renderer->_xmlEntities($output);
          break;
      }
      return true;
    } elseif ($format == 'metadata') {
      if ($renderer->capture) {
        if ($state == DOKU_LEXER_UNMATCHED)
          $renderer->doc .= $output;
        if (strlen($renderer->doc) > 250)
          $renderer->capture = false;
      }
      return true;
    }
    return false;
  }
}
