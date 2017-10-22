<?php
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

require_once(DOKU_PLUGIN.'formatplus2/formatting.php');

class syntax_plugin_formatplus_deleteplus extends FormattingPlus_Syntax_Plugin {
   
  function _getName() {
    return 'Delete+';
  }
  function _getDesc() {
    return 'Wraps text in <DEL> tags. Syntax: /-delete-/';
  }
  function _getConfig() {
    return 'ins_del';
  }
 
  function _getFormatting() {
    return array('open'=>'/-', 'close'=>'-/', 'tag'=>'del', 'attrs'=>'class="simple"');
  }

  function getSort() {
    return 84;
  }
 
}
