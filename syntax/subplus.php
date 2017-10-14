<?php
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

require_once(DOKU_PLUGIN.'formatplus/formatting.php');

class syntax_plugin_formatplus_subplus extends FormattingPlus_Syntax_Plugin {
   
  function _getName() {
    return 'SubScript+';
  }
  function _getDesc() {
    return 'Wraps text in <SUB> tags. Syntax: /,insert,/';
  }
  function _getConfig() {
    return 'super_sub';
  }
 
  function _getFormatting() {
    return array('open'=>'/,', 'close'=>',/', 'tag'=>'sub');
  }

  function getSort() {
    return 87;
  }
 
}
