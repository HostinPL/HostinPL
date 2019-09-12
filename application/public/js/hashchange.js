 
(function($) {

function formatHash(hash) {
   if (!hash)
      hash = '#';
   else if (hash.charAt(0) != '#')
      hash = '#' + hash;

   return hash;
}
   
$.fn.extend({
   hashchange: function(callback) { return this.bind('hashchange', callback) },
   openOnClick: function(href) {
      if (href === undefined || href.length == 0)
         href = '#';
      return this.click(function(ev) {
         if (href && href.charAt(0) == '#') {
            // execute load in separate call stack
            window.setTimeout(function() { $.History.add(href) }, 0);
         }
         else {
            window.location(href);
         }
         ev.stopPropagation();
         return false;
      });
   }
});
   
function isHashchangeEventSupported() {
   var el = window;
   var eventName = 'onhashchange';
   var isSupported = (eventName in el);
   if (!isSupported) {
      try {
         el.setAttribute(eventName, 'return;');
         isSupported = typeof el[eventName] == 'function';
      } catch(e) {}
   }
   el = null;
   return isSupported;
}
$.support.hashchange = isHashchangeEventSupported();
   
// For browsers that support hashchange natively, we don't have to poll for hash changes
if ($.support.hashchange) {
   $.support.hashchange = true
   $.extend({
      History : {
         fireInitialChange: true,
         init: function() {
            if($.History.fireInitialChange)
               $.event.trigger('hashchange');
         },
         
         add: function(hash) {
            location.hash = formatHash(hash);
         },

         replace: function(hash) {
            var path = location.href.split('#')[0] + formatHash(hash);
            location.replace(path);
         }
      }
   });
   return;
}

var curHash;
// hidden iframe for IE (earlier than 8)
var iframe;

$.extend({
   History : {
      fireInitialChange: true,
      init: function() {
         curHash = location.hash;
         
         if ($.browser.msie) {
            // stop the callback firing twice during init if no hash present
            if (curHash == '')
               curHash = '#';
            // add hidden iframe for IE
            iframe = $('<iframe />').hide().get(0);
            $('body').prepend(iframe);
            updateIEFrame(location.hash);
            setInterval(checkHashIE, 100);
         }
         else if(!$.browser.rhino)
            setInterval(checkHash, 100); //id like this to wait for load
         
         if($.History.fireInitialChange)
            $.event.trigger('hashchange');
      },
      
      add: function(hash) {
         if (curHash === undefined)
            return;

         location.hash = formatHash(hash);
         
         //if (curHash == hash)  let it detect this itself because location.hash might not equal hash
         //   return;
         //curHash = hash;
         
         //if ($.browser.msie)
         //   updateIEFrame(hash);
         
         //$.event.trigger('hashchange');  Removed, 
      },

      replace: function(hash) {
         var path = location.href.split('#')[0] + formatHash(hash);
         location.replace(path);
      }
   }
});
/*
$(document).ready(function() {
   $.History.init();
});
*/
$(window).unload(function() { iframe = null });

function checkHash() {
   var hash = location.hash;
   if (hash != curHash) {
      curHash = hash;
      $.event.trigger('hashchange');
   }
}
/*   
function hasNamedAnchor(hash) {
   return ($(hash).length > 0 || $('a[name='+hash.slice(1)+']').length > 0);
}

if ($.browser.msie) {
    // Attach a live handler for any anchor links
//orig    $('a[href^=#]').live('click', function() {
    $("a[href*='#']").live('click', function() {
        var hash = $(this).attr('href');
        var poundIndex = hash.indexOf('#');
        if(poundIndex > 0)
           hash = hash.substring(poundIndex);
        // Don't intercept the click if there is an existing anchor on the page
        // that matches this hash
        if ( !hasNamedAnchor(hash) ) {
            $.History.add(hash);
            return false;
        }
    });
}
*/
function checkHashIE() {
   /* First, check for address bar change */
   var hash = location.hash;
   if (hash != curHash) {
      updateIEFrame(hash);
      curHash = hash;
      $.event.trigger('hashchange');
      return
   }
   
   // Now check for back/forward button
   // On IE, check for location.hash of iframe
   var idoc = iframe.contentDocument || iframe.contentWindow.document;
   var hash = idoc.location.hash;
   if (hash == '')
      hash = '#';

   if (hash != curHash) {
      if (location.hash != hash)
         location.hash = hash;
      curHash = hash;
      $.event.trigger('hashchange');
   }
}

function updateIEFrame(hash) {
   if (hash == '#')
      hash = '';
   var idoc = iframe.contentDocument || iframe.contentWindow.document;
   idoc.open();
   idoc.close();
   if (idoc.location.hash != hash)
      idoc.location.hash = hash;
}

})(jQuery);