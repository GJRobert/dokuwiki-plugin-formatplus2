# dokuwiki-plugin-formatplus2
A fork of the [nice DokuWiki plugin "formatplus"](https://www.dokuwiki.org/plugin:formatplus) (orig. by [Tom N Harris](http://whoopdedo.org/doku/wiki/formatplus))

This fork only tries to fix the deprecated `jQuery.browser` type error (at the moment). I have e-mailed to Tom to report this error, and he encouraged me to fork to deal with the bug since his development has been ceased. (A million thanks to Tom!)

I found that `jQuery.browser` type is deprecated since jQuery 1.9, so I have inserted a snippet found [here](https://stackoverflow.com/questions/9645803/whats-the-replacement-for-browser#answer-15072522) into the `script.js` of this plugin, and the JavaScript error in browser console is gone.
