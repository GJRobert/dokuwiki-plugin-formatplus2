<?php
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

require_once(DOKU_PLUGIN.'formatplus2/formatting.php');

class syntax_plugin_formatplus2_definitionplus extends FormattingPlus_Syntax_Plugin {
 
  function _getName() {
    return 'Definition+';
  }
  function _getDesc() {
    return 'Wraps text in <DFN> tags. Syntax: @@definition@@';
  }
  function _getConfig() {
    return 'defnition';
  }
 
  function _getFormatting() {
    return array('open'=>'@@', 'close'=>'@@', 'tag'=>'dfn');
  }

  function getSort() {
    return 104;
  }
 
}
