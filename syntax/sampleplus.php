<?php
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

require_once(DOKU_PLUGIN.'formatplus/formatting.php');

class syntax_plugin_formatplus_sampleplus extends FormattingPlus_Syntax_Plugin {
 
  function _getName() {
    return 'Sample+';
  }
  function _getDesc() {
    return 'Wraps text in <SAMP> tags. Syntax: $$sample$$';
  }
  function _getConfig() {
    return 'sample';
  }
 
  function _getFormatting() {
    return array('open'=>'\x24\x24', 'close'=>'\x24\x24', 'tag'=>'samp');
  }

  function getSort() {
    return 102;
  }

}
