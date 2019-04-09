<?php
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

require_once(DOKU_PLUGIN.'formatplus2/formatting.php');

class syntax_plugin_formatplus2_quoteplus extends FormattingPlus_Syntax_Plugin {
 
  var $disabled = false;

  function _getName() {
    return 'Quote+';
  }
  function _getDesc() {
    return 'Create inline quote with optional citation. '.
           'Syntax: ""Inline Quote"" ""=cite|With citation""';
  }
  function _getConfig() {
    return 'quote';
  }
 
  function _getFormatting() {
    return array();
  }

  function getSort() {
    return 107;
  }
 
  function getAllowedTypes() {
    return array('formatting','substition','disabled');
  }
    
  function preConnect() {
    if ($this->_disabledSyntax($this->_getConfig())) 
      $this->disabled = true;
  }

  function connectTo($mode) {
    if (!$this->disabled) {
      $this->Lexer->addEntryPattern('\x22\x22=[^\x22\r\n]+?\|(?=.*\x22\x22)', $mode, 'plugin_formatplus2_quoteplus');
      $this->Lexer->addEntryPattern('\x22\x22(?=.*\x22\x22)', $mode, 'plugin_formatplus2_quoteplus');
    }
  }
 
  function postConnect() {
    if (!$this->disabled) {
      $this->Lexer->addExitPattern('\x22\x22', 'plugin_formatplus2_quoteplus');
    }
  }
 
  function handle($match, $state, $pos, Doku_Handler $handler){
    switch ($state) {
      case DOKU_LEXER_ENTER:
        if (substr($match,2,1) == '=')
          $output = substr($match,3,-1);
        else
          $output = '';
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
 
  function render($format, Doku_Renderer $renderer, $data) {
    list($state,$output) = $data;
    if ($format == 'xhtml'){
      switch ($state) {
        case DOKU_LEXER_ENTER:
          if (!empty($output)) {
            $renderer->doc .= '<q cite="'.$renderer->_xmlEntities($output).'">';
          } else {
            $renderer->doc .= '<q>';
          }
        break;
        case DOKU_LEXER_EXIT:
          $renderer->doc .= '</q>';
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
