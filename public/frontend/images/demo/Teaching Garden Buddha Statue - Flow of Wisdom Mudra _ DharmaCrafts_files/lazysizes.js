!function(e,t){var a=function(e,t,a){"use strict";var n,i;if(function(){i={lazyClass:"mmLazyload",loadedClass:"mmLazyloaded",loadingClass:"mmLazyloading",preloadClass:"mmLazypreload",errorClass:"mmLazyerror",autosizesClass:"mmLazyautosizes",fastLoadedClass:"mmLs-is-cached",iframeLoadMode:0,srcAttr:"data-src",srcsetAttr:"data-srcset",sizesAttr:"data-sizes",minSize:40,customMedia:{},init:!0,expFactor:1.5,hFac:.8,loadMode:2,loadHidden:!0,ricTimeout:0,throttleDelay:125}}(),!t||!t.getElementsByClassName)return{init:function(){},cfg:i,noSupport:!0};var o=t.documentElement,s=e.HTMLPictureElement,r="addEventListener",l="getAttribute",d=e[r].bind(e),c=e.setTimeout,u=e.requestAnimationFrame||c,f=e.requestIdleCallback,m=/^picture$/i,h=["load","error","lazyincluded","_lazyloaded"],y={},v=Array.prototype.forEach,z=function(e,t){return y[t]||(y[t]=new RegExp("(\\s|^)"+t+"(\\s|$)")),y[t].test(e[l]("class")||"")&&y[t]},g=function(e,t){z(e,t)||e.setAttribute("class",(e[l]("class")||"").trim()+" "+t)},p=function(e,t){var a;(a=z(e,t))&&e.setAttribute("class",(e[l]("class")||"").replace(a," "))},C=function(e,t,a){var n=a?r:"removeEventListener";a&&C(e,t),h.forEach((function(a){e[n](a,t)}))},b=function(e,a,i,o,s){var r=t.createEvent("Event");return i||(i={}),i.instance=n,r.initEvent(a,!o,!s),r.detail=i,e.dispatchEvent(r),r},A=function(t,a){var n;!s&&(n=e.picturefill||i.pf)?(a&&a.src&&!t[l]("srcset")&&t.setAttribute("srcset",a.src),n({reevaluate:!0,elements:[t]})):a&&a.src&&(t.src=a.src)},E=function(e,t){return(getComputedStyle(e,null)||{})[t]},_=function(e,t,a){for(a=a||e.offsetWidth;a<i.minSize&&t&&!e._lazysizesWidth;)a=t.offsetWidth,t=t.parentNode;return a},L=(ge=[],pe=[],Ce=ge,be=function(){var e=Ce;for(Ce=ge.length?pe:ge,ve=!0,ze=!1;e.length;)e.shift()();ve=!1},Ae=function(e,a){ve&&!a?e.apply(this,arguments):(Ce.push(e),ze||(ze=!0,(t.hidden?c:u)(be)))},Ae._lsFlush=be,Ae),w=function(e,t){return t?function(){L(e)}:function(){var t=this,a=arguments;L((function(){e.apply(t,a)}))}},M=function(e){var t,n=0,o=i.throttleDelay,s=i.ricTimeout,r=function(){t=!1,n=a.now(),e()},l=f&&s>49?function(){f(r,{timeout:s}),s!==i.ricTimeout&&(s=i.ricTimeout)}:w((function(){c(r)}),!0);return function(e){var i;(e=!0===e)&&(s=33),t||(t=!0,(i=o-(a.now()-n))<0&&(i=0),e||i<9?l():c(l,i))}},N=function(e){var t,n,i=99,o=function(){t=null,e()},s=function(){var e=a.now()-n;e<i?c(s,i-e):(f||o)(o)};return function(){n=a.now(),t||(t=c(s,i))}},x=(K=/^img$/i,Q=/^iframe$/i,V="onscroll"in e&&!/(gle|ing)bot/.test(navigator.userAgent),X=0,Y=0,Z=0,ee=-1,te=function(e){Z--,(!e||Z<0||!e.target)&&(Z=0)},ae=function(e){return null==J&&(J="hidden"==E(t.body,"visibility")),J||!("hidden"==E(e.parentNode,"visibility")&&"hidden"==E(e,"visibility"))},ne=function(e,a){var n,i=e,s=ae(e);for(I-=a,G+=a,U-=a,j+=a;s&&(i=i.offsetParent)&&i!=t.body&&i!=o;)(s=(E(i,"opacity")||1)>0)&&"visible"!=E(i,"overflow")&&(n=i.getBoundingClientRect(),s=j>n.left&&U<n.right&&G>n.top-1&&I<n.bottom+1);return s},ie=function(){var e,a,s,r,d,c,u,f,m,h,y,v,z=n.elements;if((O=i.loadMode)&&Z<8&&(e=z.length)){for(a=0,ee++;a<e;a++)if(z[a]&&!z[a]._lazyRace)if(!V||n.prematureUnveil&&n.prematureUnveil(z[a]))fe(z[a]);else if((f=z[a][l]("data-expand"))&&(c=1*f)||(c=Y),h||(h=!i.expand||i.expand<1?o.clientHeight>500&&o.clientWidth>500?500:370:i.expand,n._defEx=h,y=h*i.expFactor,v=i.hFac,J=null,Y<y&&Z<1&&ee>2&&O>2&&!t.hidden?(Y=y,ee=0):Y=O>1&&ee>1&&Z<6?h:X),m!==c&&($=innerWidth+c*v,q=innerHeight+c,u=-1*c,m=c),s=z[a].getBoundingClientRect(),(G=s.bottom)>=u&&(I=s.top)<=q&&(j=s.right)>=u*v&&(U=s.left)<=$&&(G||j||U||I)&&(i.loadHidden||ae(z[a]))&&(k&&Z<3&&!f&&(O<3||ee<4)||ne(z[a],c))){if(fe(z[a]),d=!0,Z>9)break}else!d&&k&&!r&&Z<4&&ee<4&&O>2&&(D[0]||i.preloadAfterLoad)&&(D[0]||!f&&(G||j||U||I||"auto"!=z[a][l](i.sizesAttr)))&&(r=D[0]||z[a]);r&&!d&&fe(r)}},oe=M(ie),se=function(e){var t=e.target;t._lazyCache?delete t._lazyCache:(te(e),g(t,i.loadedClass),p(t,i.loadingClass),C(t,le),b(t,"lazyloaded"))},re=w(se),le=function(e){re({target:e.target})},de=function(e,t){var a=e.getAttribute("data-load-mode")||i.iframeLoadMode;0==a?e.contentWindow.location.replace(t):1==a&&(e.src=t)},ce=function(e){var t,a=e[l](i.srcsetAttr);(t=i.customMedia[e[l]("data-media")||e[l]("media")])&&e.setAttribute("media",t),a&&e.setAttribute("srcset",a)},ue=w((function(e,t,a,n,o){var s,r,d,u,f,h;(f=b(e,"lazybeforeunveil",t)).defaultPrevented||(n&&(a?g(e,i.autosizesClass):e.setAttribute("sizes",n)),r=e[l](i.srcsetAttr),s=e[l](i.srcAttr),o&&(u=(d=e.parentNode)&&m.test(d.nodeName||"")),h=t.firesLoad||"src"in e&&(r||s||u),f={target:e},g(e,i.loadingClass),h&&(clearTimeout(H),H=c(te,2500),C(e,le,!0)),u&&v.call(d.getElementsByTagName("source"),ce),r?e.setAttribute("srcset",r):s&&!u&&(Q.test(e.nodeName)?de(e,s):e.src=s),o&&(r||u)&&A(e,{src:s})),e._lazyRace&&delete e._lazyRace,p(e,i.lazyClass),L((function(){var t=e.complete&&e.naturalWidth>1;h&&!t||(t&&g(e,i.fastLoadedClass),se(f),e._lazyCache=!0,c((function(){"_lazyCache"in e&&delete e._lazyCache}),9)),"lazy"==e.loading&&Z--}),!0)})),fe=function(e){if(!e._lazyRace){var t,a=K.test(e.nodeName),n=a&&(e[l](i.sizesAttr)||e[l]("sizes")),o="auto"==n;(!o&&k||!a||!e[l]("src")&&!e.srcset||e.complete||z(e,i.errorClass)||!z(e,i.lazyClass))&&(t=b(e,"lazyunveilread").detail,o&&W.updateElem(e,!0,e.offsetWidth),e._lazyRace=!0,Z++,ue(e,t,o,n,a))}},me=N((function(){i.loadMode=3,oe()})),he=function(){3==i.loadMode&&(i.loadMode=2),me()},ye=function(){k||(a.now()-P<999?c(ye,999):(k=!0,i.loadMode=3,oe(),d("scroll",he,!0)))},{_:function(){P=a.now(),n.elements=t.getElementsByClassName(i.lazyClass),D=t.getElementsByClassName(i.lazyClass+" "+i.preloadClass),d("scroll",oe,!0),d("resize",oe,!0),d("pageshow",(function(e){if(e.persisted){var a=t.querySelectorAll("."+i.loadingClass);a.length&&a.forEach&&u((function(){a.forEach((function(e){e.complete&&fe(e)}))}))}})),e.MutationObserver?new MutationObserver(oe).observe(o,{childList:!0,subtree:!0,attributes:!0}):(o[r]("DOMNodeInserted",oe,!0),o[r]("DOMAttrModified",oe,!0),setInterval(oe,999)),d("hashchange",oe,!0),["focus","mouseover","click","load","transitionend","animationend"].forEach((function(e){t[r](e,oe,!0)})),/d$|^c/.test(t.readyState)?ye():(d("load",ye),t[r]("DOMContentLoaded",oe),c(ye,2e4)),n.elements.length?(ie(),L._lsFlush()):oe()},checkElems:oe,unveil:fe,_aLSL:he}),W=(T=w((function(e,t,a,n){var i,o,s;if(e._lazysizesWidth=n,n+="px",e.setAttribute("sizes",n),m.test(t.nodeName||""))for(o=0,s=(i=t.getElementsByTagName("source")).length;o<s;o++)i[o].setAttribute("sizes",n);a.detail.dataAttr||A(e,a.detail)})),F=function(e,t,a){var n,i=e.parentNode;i&&(a=_(e,i,a),(n=b(e,"lazybeforesizes",{width:a,dataAttr:!!t})).defaultPrevented||(a=n.detail.width)&&a!==e._lazysizesWidth&&T(e,i,n,a))},R=N((function(){var e,t=S.length;if(t)for(e=0;e<t;e++)F(S[e])})),{_:function(){S=t.getElementsByClassName(i.autosizesClass),d("resize",R)},checkElems:R,updateElem:F}),B=function(){!B.i&&t.getElementsByClassName&&(B.i=!0,W._(),x._())};var S,T,F,R;var D,k,H,O,P,$,q,I,U,j,G,J,K,Q,V,X,Y,Z,ee,te,ae,ne,ie,oe,se,re,le,de,ce,ue,fe,me,he,ye;var ve,ze,ge,pe,Ce,be,Ae;return c((function(){i.init&&B()})),n={cfg:i,autoSizer:W,loader:x,init:B,uP:A,aC:g,rC:p,hC:z,fire:b,gW:_,rAF:L}}(e,e.document,Date);e.lazySizesBuddha=a,"object"==typeof module&&module.exports&&(module.exports=a)}("undefined"!=typeof window?window:{});
