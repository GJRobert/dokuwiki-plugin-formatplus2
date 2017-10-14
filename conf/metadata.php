<?php
/**
 * Metadata for configuration manager plugin
 * Settings for Format+ plugin
 *
 * @author    Tom N Harris <tnharris@whoopdedo.org>
 */
$meta['disable_syntax']  = array('multicheckbox','_choices'=>array(
                                                 'sample',
                                                 'citation',
                                                 'definition',
                                                 'variable',
                                                 'smallcaps',
                                                 'keyboard',
                                                 'inverse',
                                                 'super_sub',
                                                 'quote',
                                                 'blockquote',
                                                 'ins_del',
                                                 'block_ins_del',
                                                 'classic_del'
                                                 )
                                 );
$meta['toplevel'] = array('onoff');
