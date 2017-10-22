<?php
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

require_once(DOKU_PLUGIN.'formatplus2/formatting.php');

class syntax_plugin_formatplus2_blockdeleteplus extends FormattingPlus_Syntax_Plugin {
 
  var $disabled = false;
  var $no_classic = false;

  function _getName() {
    return 'BlockDelete+';
  }
  function _getDesc() {
    return 'Wraps text in <DEL> tags with optional meta-data. 
            Syntax: <del desc @date>...</del>';
  }
  function _getConfig() {
    return 'block_ins_del';
  }
 
  function _getFormatting() {
    return array();
  }

  function getSort() {
    return 86;
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
    if ($this->_disabledSyntax('classic_del'))
      $this->no_classic = true;
  }

  function connectTo($mode) {
    if (!$this->disabled) {
      if (!$this->no_classic) {
        $this->Lexer->addEntryPattern('<del>(?=.*</del>)', $mode, 'plugin_formatplus2_blockdeleteplus');
      }
      $this->Lexer->addEntryPattern('<del [^>\r\n]+? @[^>\r\n]+?>(?=.*</del>)', $mode, 'plugin_formatplus2_blockdeleteplus');
      $this->Lexer->addEntryPattern('<del [^>\r\n]+?>(?=.*</del>)', $mode, 'plugin_formatplus2_blockdeleteplus');
    }
  }

  function postConnect() {
    if (!$this->disabled) {
      $this->Lexer->addExitPattern('</del>', 'plugin_formatplus2_blockdeleteplus');
    }
  }

  function handle($match, $state, $pos, &$handler){
    switch ($state) {
      case DOKU_LEXER_ENTER:
        $match = substr($match,4,-1);
        if(!empty($match)){
          if(preg_match("/^(.*) =(.*?) @(.*?)$/", $match, $matches)){
            $output = array(trim($matches[1]),trim($matches[2]),trim($matches[3]));
          }elseif(preg_match("/^(.*) @(.*?) =(.*?)$/", $match, $matches)){
            $output = array(trim($matches[1]),trim($matches[3]),trim($matches[2]));
          }elseif(preg_match("/^(.*) =(.*?)$/", $match, $matches)){
            $output = array(trim($matches[1]),trim($matches[2]),'');
          }elseif(preg_match("/^(.*) @(.*?)$/", $match, $matches)){
            $output = array(trim($matches[1]),'',trim($matches[2]));
          }else{
            $output = array(trim($match),'','');
          }
        }else{
          $output = array('','','');
        }
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
          $renderer->doc .= '<del class="block"';
          if(!empty($output[0])){
            $renderer->doc .= ' title="'.$renderer->_xmlEntities($output[0]).'"';
          }
          if(!empty($output[1])){
            $renderer->doc .= ' cite="'.$renderer->_xmlEntities($output[1]).'"';
          }
          if(!empty($output[2])){
            $renderer->doc .= ' datetime="'.$renderer->_xmlEntities($output[2]).'"';
          }
          $renderer->doc .= '><div class="deleted">'.DOKU_LF;
          break;
        case DOKU_LEXER_EXIT:
          $renderer->doc .= DOKU_LF.'</div></del>'.DOKU_LF;
          break;
        case DOKU_LEXER_UNMATCHED:
          $renderer->doc .= $renderer->_xmlEntities($output);
          break;
      }
      return true;
    } elseif ($format == 'metadata') {
      switch ($state) {
        case DOKU_LEXER_ENTER:
          $sp = '';
          $line = '';
          if(!empty($output[0])){
            $line .= '['.$output[0].']';
            $sp = ' ';
          }
          if(!empty($output[1])){
            $line .= $sp.$output[1];
            $sp = ' ';
          }
          if(!empty($output[2])){
            $line .= $sp.$output[2];
          }
          if ($renderer->capture)
            $renderer->doc .= $line;
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
