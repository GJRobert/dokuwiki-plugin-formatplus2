<?php
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

require_once(DOKU_PLUGIN.'formatplus/formatting.php');

class syntax_plugin_formatplus_smallcapsplus extends FormattingPlus_Syntax_Plugin {
 
  function _getName() {
    return 'SmallCaps+';
  }
  function _getDesc() {
    return 'Formats text using small-caps. Syntax: !!small-caps!!';
  }
  function _getConfig() {
    return 'smallcaps';
  }
 
  function _getFormatting() {
    return array('open'=>'!!', 'close'=>'!!', 'tag'=>'strong', 'attrs'=>'class="smallcaps"');
  }

  function getSort() {
    return 105;
  }

}
