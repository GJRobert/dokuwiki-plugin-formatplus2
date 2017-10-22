<?php
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

require_once(DOKU_PLUGIN.'formatplus2/formatting.php');

class syntax_plugin_formatplus_superplus extends FormattingPlus_Syntax_Plugin {
   
  function _getName() {
    return 'SuperScript+';
  }
  function _getDesc() {
    return 'Wraps text in <SUP> tags. Syntax: /^insert^/';
  }
  function _getConfig() {
    return 'super_sub';
  }
 
  function _getFormatting() {
    return array('open'=>'/\x5E', 'close'=>'\x5E/', 'tag'=>'sup');
  }

  function getSort() {
    return 88;
  }
 
}
