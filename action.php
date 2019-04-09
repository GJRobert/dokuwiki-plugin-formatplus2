<?php
/**
 *
 * @license   GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author    Tom N Harris <tnharris@whoopdedo.org>
 */

// must be run within DokuWiki
if(!defined('DOKU_INC')) die();

class action_plugin_formatplus2 extends DokuWiki_Action_Plugin {

  /**
   * register the eventhandlers
   */
  function register(Doku_Event_Handler $contr){
    $contr->register_hook('TOOLBAR_DEFINE', 'AFTER', $this, 'toolbar_event', array());
  }

  /**
   *
   * @author  Tom N Harris    <tnharris@whoopdedo.org>
   */
  function toolbar_event(Doku_Event $event, $param){
    $disabled = explode(',',$this->getConf('disable_syntax'));
    $disabled = array_map('trim',$disabled);
    $buttons = array();
    if (!in_array('smallcaps', $disabled))
      $buttons[] = array(
          'type'  => 'format',
          'title' => $this->getLang('smallcaps'),
          'icon'  => DOKU_BASE.'lib/plugins/formatplus2/images/caps.png',
          'open'  => '!!',
          'close' => '!!',
          'block' => false
          );
    if (!in_array('sample', $disabled))
      $buttons[] = array(
          'type'  => 'format',
          'title' => $this->getLang('sample'),
          'icon'  => DOKU_BASE.'lib/plugins/formatplus2/images/samp.png',
          'open'  => '$$',
          'close' => '$$',
          'block' => false
          );
    if (!in_array('variable', $disabled))
      $buttons[] = array(
          'type'  => 'format',
          'title' => $this->getLang('variable'),
          'icon'  => DOKU_BASE.'lib/plugins/formatplus2/images/var.png',
          'open'  => '??',
          'close' => '??',
          'block' => false
          );
    if (!in_array('keyboard', $disabled))
      $buttons[] = array(
          'type'  => 'format',
          'title' => $this->getLang('keyboard'),
          'icon'  => DOKU_BASE.'lib/plugins/formatplus2/images/kbd.png',
          'open'  => '``',
          'close' => '``',
          'block' => false
          );
    if (!in_array('definition', $disabled))
      $buttons[] = array(
          'type'  => 'format',
          'title' => $this->getLang('definition'),
          'icon'  => DOKU_BASE.'lib/plugins/formatplus2/images/dfn.png',
          'open'  => '@@',
          'close' => '@@',
          'block' => false
          );
    if (!in_array('citation', $disabled))
      $buttons[] = array(
          'type'  => 'format',
          'title' => $this->getLang('citation'),
          'icon'  => DOKU_BASE.'lib/plugins/formatplus2/images/cite.png',
          'open'  => '&&',
          'close' => '&&',
          'block' => false
          );
    if (!in_array('inverse', $disabled))
      $buttons[] = array(
          'type'  => 'format',
          'title' => $this->getLang('inverse'),
          'icon'  => DOKU_BASE.'lib/plugins/formatplus2/images/inv.png',
          'open'  => '/!',
          'close' => '!/',
          'block' => false
          );
    if (!in_array('quote', $disabled)) {
      $buttons[] = array(
          'type'  => 'format',
          'title' => $this->getLang('quote'),
          'icon'  => DOKU_BASE.'lib/plugins/formatplus2/images/q.png',
          'open'  => '""',
          'close' => '""',
          'block' => false
          );
    }
    $buttons2 = array();
    if (!in_array('blockquote', $disabled))
      $buttons2[] = array(
          'type'  => 'format',
          'title' => $this->getLang('blockquote'),
          'icon'  => DOKU_BASE.'lib/plugins/formatplus2/images/quote.png',
          'open'  => '<quote >',
          'close' => '</quote>',
          'block' => true
          );
    if (!in_array('ins_del', $disabled)) {
      $buttons2[] = array(
          'type'  => 'format',
          'title' => $this->getLang('insert'),
          'icon'  => DOKU_BASE.'lib/plugins/formatplus2/images/ins.png',
          'open'  => '/+',
          'close' => '+/',
          'block' => false
          );
      $buttons2[] = array(
          'type'  => 'format',
          'title' => $this->getLang('blockinsert'),
          'icon'  => DOKU_BASE.'lib/plugins/formatplus2/images/insert.png',
          'open'  => '<ins >',
          'close' => '</ins>',
          'block' => true
          );
      $buttons2[] = array(
          'type'  => 'format',
          'title' => $this->getLang('delete'),
          'icon'  => DOKU_BASE.'lib/plugins/formatplus2/images/del.png',
          'open'  => '/-',
          'close' => '-/',
          'block' => false
          );
      $buttons2[] = array(
          'type'  => 'format',
          'title' => $this->getLang('blockdelete'),
          'icon'  => DOKU_BASE.'lib/plugins/formatplus2/images/delete.png',
          'open'  => '<del >',
          'close' => '</del>',
          'block' => true
          );
    }
    if (!in_array('super_sub', $disabled)) {
      $buttons2[] = array(
          'type'  => 'format',
          'title' => $this->getLang('sub'),
          'icon'  => DOKU_BASE.'lib/plugins/formatplus2/images/sub.png',
          'open'  => '/,',
          'close' => ',/',
          'block' => false
          );
      $buttons2[] = array(
          'type'  => 'format',
          'title' => $this->getLang('super'),
          'icon'  => DOKU_BASE.'lib/plugins/formatplus2/images/super.png',
          'open'  => '/^',
          'close' => '^/',
          'block' => false
          );
    }
    $menu =& $event->data;
    if ($this->getConf('toplevel')) {
      $menu = array_merge($menu, $buttons);
      $menu[] = array(
          'type'  => 'picker',
          'title' => $this->getLang('title'),
          'icon'  => DOKU_BASE.'lib/plugins/formatplus2/images/formatplus.png',
          'list'  => $buttons2,
          'block' => true
          );
    } else {
      $menu[] = array(
          'type'  => 'picker',
          'title' => $this->getLang('title'),
          'icon'  => DOKU_BASE.'lib/plugins/formatplus2/images/formatplus.png',
          'list'  => array_merge($buttons, $buttons2),
          'block' => true
          );
    }
  }

}
