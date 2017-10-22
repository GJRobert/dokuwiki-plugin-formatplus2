<?php
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

require_once(DOKU_PLUGIN.'formatplus2/formatting.php');

class syntax_plugin_formatplus_keyboardplus extends FormattingPlus_Syntax_Plugin {
 
  function _getName() {
    return 'Keyboard+';
  }
  function _getDesc() {
    return 'Wraps text in <KBD> tags. Syntax: ``keyboard``';
  }
  function _getConfig() {
    return 'keyboard';
  }
 
  function _getFormatting() {
    return array('open'=>'``', 'close'=>'``', 'tag'=>'kbd');
  }
  function getSort() {
    return 101;
  }
 
}
