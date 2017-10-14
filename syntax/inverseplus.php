<?php
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

require_once(DOKU_PLUGIN.'formatplus/formatting.php');

class syntax_plugin_formatplus_inverseplus extends FormattingPlus_Syntax_Plugin {
 
  function _getName() {
    return 'Inverse+';
  }
  function _getDesc() {
    return 'Shows light-colored text on a dark background. (Or the other way around.)
            Syntax: /!inverse!/';
  }
  function _getConfig() {
    return 'inverse';
  }
 
  function _getFormatting() {
    return array('open'=>'/!', 'close'=>'!/', 'tag'=>'em', 'attrs'=>'class="inverse"');
  }

  function getSort() {
    return 109;
  }

}
