<?php
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

require_once(DOKU_PLUGIN.'formatplus/formatting.php');

class syntax_plugin_formatplus_blockquoteplus extends FormattingPlus_Syntax_Plugin {

  var $disabled = false;

  function _getName() {
    return 'BlockQuote+';
  }
  function _getDesc() {
    return 'Create block quotes with optional citation.
            Syntax: <quote cite>Block quote</quote>';
  }
  function _getConfig() {
    return 'blockquote';
  }

  function _getFormatting() {
    return array();
  }

  function getSort() {
    return 107;
  }

  function getType() {
    return 'container';
  }

  function getAllowedTypes() {
    return array('container','paragraphs','formatting','substition','disabled','protected');
  }

  function getPType() {
    return 'stack';
  }

  function preConnect() {
    if ($this->_disabledSyntax($this->_getConfig()))
      $this->disabled = true;
  }

  function connectTo($mode) {
    if (!$this->disabled) {
      $this->Lexer->addEntryPattern('<quote>(?=.*</quote>)', $mode, 'plugin_formatplus_blockquoteplus');
      $this->Lexer->addEntryPattern('<quote [^>\r\n]+?>(?=.*</quote>)', $mode, 'plugin_formatplus_blockquoteplus');
    }
  }

  function postConnect() {
    if (!$this->disabled) {
      $this->Lexer->addExitPattern('</quote>', 'plugin_formatplus_blockquoteplus');
    }
  }

  function handle($match, $state, $pos, &$handler){
    switch ($state) {
      case DOKU_LEXER_ENTER:
        $output = trim(substr($match,6,-1));
      break;
      case DOKU_LEXER_EXIT:
        $output = '';
      break;
      case DOKU_LEXER_UNMATCHED:
        $output = $match;
      break;
    }
    return array($state,$output);
  }

  function render($format, &$renderer, $data) {
    list($state,$output) = $data;
    if (substr($format,0,5) == 'xhtml'){
      switch ($state) {
        case DOKU_LEXER_ENTER:
          if (!empty($output)) {
            $renderer->doc .= '<blockquote class="citation" title="'.$renderer->_xmlEntities($output).'">';
          } else {
            $renderer->doc .= '<blockquote class="citation">';
          }
        break;
        case DOKU_LEXER_EXIT:
          $renderer->doc .= '</blockquote>'.DOKU_LF;
        break;
        case DOKU_LEXER_UNMATCHED:
          $renderer->doc .= $renderer->_xmlEntities($output);
        break;
      }
      return true;
    } elseif ($format == 'metadata') {
      switch ($state) {
        case DOKU_LEXER_ENTER:
          if ($renderer->capture){
            $renderer->doc .= DOKU_LF;
            if(!empty($output)){
              $renderer->doc .= $output.':';
            }
          }
          break;
        case DOKU_LEXER_EXIT:
          if ($renderer->capture) {
            $renderer->doc .= DOKU_LF;
            if (strlen($renderer->doc) > 250) $renderer->capture = false;
          }
          break;
        case DOKU_LEXER_UNMATCHED:
          if ($renderer->capture) $renderer->doc .= $output;
          break;
      }
      return true;
    }
    return false;
  }
}
