<?php
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

require_once(DOKU_PLUGIN.'formatplus/formatting.php');

class syntax_plugin_formatplus_citationplus extends FormattingPlus_Syntax_Plugin {

  function _getName() {
    return 'Citation+';
  }
  function _getDesc() {
    return 'Wraps text in <CITE> tags. Syntax: &&cite&&';
  }
  function _getConfig() {
    return 'citation';
  }

  function _getFormatting() {
    return array('open'=>'&&', 'close'=>'&&', 'tag'=>'cite');
  }

  function getSort() {
    return 106;
  }

}
