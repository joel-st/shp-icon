!function(e){var t={};function n(o){if(t[o])return t[o].exports;var r=t[o]={i:o,l:!1,exports:{}};return e[o].call(r.exports,r,r.exports,n),r.l=!0,r.exports}n.m=e,n.c=t,n.d=function(e,t,o){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:o})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var o=Object.create(null);if(n.r(o),Object.defineProperty(o,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var r in e)n.d(o,r,function(t){return e[t]}.bind(null,r));return o},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=5)}({3:function(e,t){function n(e){return(n="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e})(e)}
/*! modernizr 3.6.0 (Custom Build) | MIT *
 * https://modernizr.com/download/?-svgforeignobject-setclasses !*/!function(e,t,o){function r(e,t){return n(e)===t}var i=[],s=[],a={_version:"3.6.0",_config:{classPrefix:"",enableClasses:!0,enableJSClass:!0,usePrefixes:!0},_q:[],on:function(e,t){var n=this;setTimeout((function(){t(n[e])}),0)},addTest:function(e,t,n){s.push({name:e,fn:t,options:n})},addAsyncTest:function(e){s.push({name:null,fn:e})}},l=function(){};l.prototype=a,l=new l;var u=t.documentElement,f="svg"===u.nodeName.toLowerCase(),c={}.toString;l.addTest("svgforeignobject",(function(){return!!t.createElementNS&&/SVGForeignObject/.test(c.call(t.createElementNS("http://www.w3.org/2000/svg","foreignObject")))})),function(){var e,t,n,o,a,u;for(var f in s)if(s.hasOwnProperty(f)){if(e=[],(t=s[f]).name&&(e.push(t.name.toLowerCase()),t.options&&t.options.aliases&&t.options.aliases.length))for(n=0;n<t.options.aliases.length;n++)e.push(t.options.aliases[n].toLowerCase());for(o=r(t.fn,"function")?t.fn():t.fn,a=0;a<e.length;a++)1===(u=e[a].split(".")).length?l[u[0]]=o:(!l[u[0]]||l[u[0]]instanceof Boolean||(l[u[0]]=new Boolean(l[u[0]])),l[u[0]][u[1]]=o),i.push((o?"":"no-")+u.join("-"))}}(),function(e){var t=u.className,n=l._config.classPrefix||"";if(f&&(t=t.baseVal),l._config.enableJSClass){var o=new RegExp("(^|\\s)"+n+"no-js(\\s|$)");t=t.replace(o,"$1"+n+"js$2")}l._config.enableClasses&&(t+=" "+n+e.join(" "+n),f?u.className.baseVal=t:u.className=t)}(i),delete a.addTest,delete a.addAsyncTest;for(var p=0;p<l._q.length;p++)l._q[p]();e.Modernizr=l}(window,document)},5:function(e,t,n){"use strict";n.r(t);n(3);!function(){if(!Modernizr.svgforeignobject){var e=document.querySelectorAll(".shp-icon--block");e.length&&Array.prototype.forEach.call(e,(function(e){var t=e.getElementsByTagName("svg");if(t){var n=!!(t=t[0]).getAttribute("viewBox")&&(4===t.getAttribute("viewBox").split(" ").length&&t.getAttribute("viewBox").split(" ").map(Number)),o=e.clientWidth,r=window.getComputedStyle(e,null).getPropertyValue("font-size");if(r=!!parseFloat(r)&&parseFloat(r),n&&o&&r){var i=n[2],s=o/r,a=o*n[3]/i/r;t.style.cssText=t.style.cssText+"width:"+s+"em;height:"+a+"em;"}}}))}}()}});