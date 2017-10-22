<?php
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

require_once(DOKU_PLUGIN.'formatplus2/formatting.php');

class syntax_plugin_formatplus2_insertplus extends FormattingPlus_Syntax_Plugin {
   
  function _getName() {
    return 'Insert+';
  }
  function _getDesc() {
    return 'Wraps text in <INS> tags. Syntax: /+insert+/';
  }
  function _getConfig() {
    return 'ins_del';
  }
 
  function _getFormatting() {
    return array('open'=>'/\x2B', 'close'=>'\x2B/', 'tag'=>'ins', 'attrs'=>'class="simple"');
  }

  function getSort() {
    return 83;
  }
 
}
