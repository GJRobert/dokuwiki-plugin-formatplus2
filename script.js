/**
 *
 * @license   GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author    Tom N Harris <tnharris@whoopdedo.org>
 */
jQuery(function (){
  if(jQuery.browser.msie && 8 > parseFloat(jQuery.browser.version)){
    // Does MSIE support :before and :after ?
    function isParentNode(p, n){
      if(!p) return false;
      while(n){
        if(n == p) return true;
        n = n.parentNode;
      }
      return false;
    }
    var q_open = Array();
    var q_close = Array();
    var ssheet = document.styleSheets[0];
    for(var i=0; i<ssheet.rules.length; i++){
      var srule = ssheet.rules[i];
      if(srule.selectorText=='Q'){
        var quotes = srule.style.quotes.split(' ');
        for(var j=0; j<quotes.length; j+=2){
          var q = quotes[j];
          if(q.length < 3) continue;
          var q1 = q.substring(1,q.length-1);
          var q2 = q1;
          if(j+1 < quotes.length){
            q = quotes[j+1];
            if(q.length >= 3){
              q2 = q.substring(1,q.length-1);
            }
          }
          q_open.push(q1);
          q_close.push(q2);
        }
      }
    }
    if(q_open.length==0) q_open.push('“');
    if(q_close.length==0) q_close.push('”');
    var qstack = Array();
    var qprev = null;
    var qelems = document.getElementsByTagName('q');
    for(var i=0; i<qelems.length; i++){
      var q = qelems[i];
      if(isParentNode(qprev, q)){
        if(qprev)
          qstack.push(qprev);
      }else{
        while(qstack.length > 0){
          qprev = qstack.pop();
          if(isParentNode(qprev, q)){
            qstack.push(qprev);
            break;
          }
        }
      }
      var mark_before = document.createTextNode(q_open[qstack.length % q_open.length]);
      var mark_after = document.createTextNode(q_close[qstack.length % q_open.length]);
      q.insertBefore(mark_before, q.firstChild);
      q.insertBefore(mark_after);
      qprev = q;
    }
    var bqelems = document.getElementsByTagName('blockquote');
    for (var i=0; i<bqelems.length; i++){
      var bq = bqelems[i];
      var bq_cite = bq.getAttribute('title');
      if (bq.className == 'citation' && bq_cite) {
        var bq_after = document.createElement('div');
        bq_after.setAttribute('className', 'citation_after');
        bq_after.innerHTML = '—' + bq_cite;
        bq.appendChild(bq_after);
      }
    }
  }
});
