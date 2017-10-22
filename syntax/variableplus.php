<?php
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

require_once(DOKU_PLUGIN.'formatplus2/formatting.php');

class syntax_plugin_formatplus2_variableplus extends FormattingPlus_Syntax_Plugin {
 
  function _getName() {
    return 'Variable+';
  }
  function _getDesc() {
    return 'Wraps text in <VAR> tags. Syntax: ??variable??';
  }
  function _getConfig() {
    return 'variable';
  }
 
  function _getFormatting() {
    return array('open'=>'\x3F\x3F', 'close'=>'\x3F\x3F', 'tag'=>'var');
  }

  function getSort() {
    return 103;
  }

}
