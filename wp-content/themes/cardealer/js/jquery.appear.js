/*
 * jQuery.appear
 * https://github.com/bas2k/jquery.appear/
 * http://code.google.com/p/jquery-appear/
 * http://bas2k.ru/
 *
 * Copyright (c) 2009 Michael Hixson
 * Copyright (c) 2012-2014 Alexander Brovikov
 * Licensed under the MIT license (http://www.opensource.org/licenses/mit-license.php)
 */

!function(e){e.fn.appear=function(a,r){var p=e.extend({data:void 0,one:!0,accX:0,accY:0},r);return this.each(function(){var r=e(this);if(r.appeared=!1,a){var t=e(window),n=function(){if(r.is(":visible")){var e=t.scrollLeft(),a=t.scrollTop(),n=r.offset(),c=n.left,i=n.top,o=p.accX,f=p.accY,s=r.height(),l=t.height(),h=r.width(),d=t.width();i+s+f>=a&&a+l+f>=i&&c+h+o>=e&&e+d+o>=c?r.appeared||r.trigger("appear",p.data):r.appeared=!1}else r.appeared=!1},c=function(){if(r.appeared=!0,p.one){t.unbind("scroll",n);var c=e.inArray(n,e.fn.appear.checks);c>=0&&e.fn.appear.checks.splice(c,1)}a.apply(this,arguments)};p.one?r.one("appear",p.data,c):r.bind("appear",p.data,c),t.scroll(n),e.fn.appear.checks.push(n),n()}else r.trigger("appear",p.data)})},e.extend(e.fn.appear,{checks:[],timeout:null,checkAll:function(){var a=e.fn.appear.checks.length;if(a>0)for(;a--;)try{e.fn.appear.checks[a]()}catch(e){}},run:function(){e.fn.appear.timeout&&clearTimeout(e.fn.appear.timeout),e.fn.appear.timeout=setTimeout(e.fn.appear.checkAll,20)}}),e.each(["append","prepend","after","before","attr","removeAttr","addClass","removeClass","toggleClass","remove","css","show","hide"],function(a,r){var p=e.fn[r];p&&(e.fn[r]=function(){var a=p.apply(this,arguments);return e.fn.appear.run(),a})})}(jQuery);