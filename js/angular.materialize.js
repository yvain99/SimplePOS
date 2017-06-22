(function(e){var i;e.module("ui.materialize",["ui.materialize.ngModel","ui.materialize.collapsible","ui.materialize.toast","ui.materialize.sidenav","ui.materialize.material_select","ui.materialize.dropdown","ui.materialize.inputfield","ui.materialize.input_date","ui.materialize.tabs","ui.materialize.pagination","ui.materialize.pushpin","ui.materialize.scrollspy","ui.materialize.parallax","ui.materialize.modal","ui.materialize.tooltipped","ui.materialize.slider","ui.materialize.materialboxed","ui.materialize.scrollFire","ui.materialize.nouislider","ui.materialize.input_clock","ui.materialize.carousel"]);e.module("ui.materialize.scrollFire",[]).directive("scrollFire",["$compile","$timeout",function(i,n){return{restrict:"A",scope:{offset:"@",scrollFire:"&"},link:function(i,n,a){var o=i.offset;if(!e.isDefined(i.offset)){o=0}o=Number(o)||0;var r=false;var l=t(function(){if(r){return}var e=window.pageYOffset+window.innerHeight;var t=n[0].getBoundingClientRect().top+window.pageYOffset;if(e>t+o){r=true;i.scrollFire({});s()}},100);function s(){$(window).off("scroll resize blur focus",l)}$(window).on("scroll resize blur focus",l);l();i.$on("$destroy",s)}}}]);function t(e,i){var t,n,a,o;var r=0;var l=function(){r=+new Date;t=null;o=e.apply(n,a);if(!t)n=a=null};var s=function(){var s=+new Date;var u=i-(s-r);n=this;a=arguments;if(u<=0||u>i){if(t){clearTimeout(t);t=null}r=s;o=e.apply(n,a);if(!t)n=a=null}else if(!t){t=setTimeout(l,u)}return o};s.cancel=function(){clearTimeout(t);r=0;t=n=a=null};return s}e.module("ui.materialize.ngModel",[]).directive("ngModel",["$timeout",function(e){return{restrict:"A",priority:-1,link:function(t,n,a){t.$watch(a.ngModel,function(t,a){e(function(){if(t instanceof Array&&a instanceof Array){if(t.length==a.length){return}}if(n.is("select")){return}if(t){n.trigger("change")}else if(n.attr("placeholder")===i){if(!n.is(":focus"))n.trigger("blur")}})})}}}]);e.module("ui.materialize.slider",[]).directive("slider",["$timeout",function(i){return{restrict:"A",scope:{height:"=",transition:"=",interval:"=",indicators:"="},link:function(t,n,a){n.addClass("slider");i(function(){n.slider({height:e.isDefined(t.height)?t.height:400,transition:e.isDefined(t.transition)?t.transition:500,interval:e.isDefined(t.interval)?t.interval:6e3,indicators:e.isDefined(t.indicators)?t.indicators:true})})}}}]);e.module("ui.materialize.carousel",[]).directive("carousel",["$timeout",function(i){return{restrict:"A",scope:{timeConstant:"@",dist:"@",shift:"@",padding:"@",fullWidth:"@",indicators:"@",noWrap:"@"},link:function(t,n,a){n.addClass("carousel");i(function(){n.carousel({time_constant:e.isDefined(t.timeConstant)?t.timeConstant:200,dist:e.isDefined(t.dist)?t.dist:-100,shift:e.isDefined(t.shift)?t.shift:0,padding:e.isDefined(t.padding)?t.padding:0,full_width:e.isDefined(t.fullWidth)?t.fullWidth:false,indicators:e.isDefined(t.indicators)?t.indicators:false,no_wrap:e.isDefined(t.noWrap)?t.noWrap:false})})}}}]);e.module("ui.materialize.collapsible",[]).directive("collapsible",["$timeout",function(e){return{link:function(i,t,n){e(function(){t.collapsible()});if("watch"in n){i.$watch(function(){return t[0].innerHTML},function(i,n){if(i!==n){e(function(){t.collapsible()})}})}}}}]);e.module("ui.materialize.parallax",[]).directive("parallax",["$timeout",function(e){return{link:function(i,t,n){e(function(){t.parallax()})}}}]);e.module("ui.materialize.toast",[]).constant("toastConfig",{duration:3e3}).directive("toast",["toastConfig",function(i){return{scope:{message:"@",duration:"@",callback:"&"},link:function(t,n,a){n.bind(a.toast,function(){var n=e.isDefined(t.message)?t.message:"";var o=e.isDefined(a.toastclass)?a.toastclass:"";Materialize.toast(n,t.duration?t.duration:i.duration,o,t.callback)})}}}]);e.module("ui.materialize.pushpin",[]).directive("pushpin",[function(){return{restrict:"AE",require:["?pushpinTop","?pushpinOffset","?pushpinBottom"],link:function(e,i,t){var n=t.pushpinTop||0;var a=t.pushpinOffset||0;var o=t.pushpinBottom||Infinity;setTimeout(function(){i.pushpin({top:n,offset:a,bottom:o})},0)}}}]);e.module("ui.materialize.scrollspy",[]).directive("scrollspy",["$timeout",function(e){return{restrict:"A",link:function(i,t,n){t.addClass("scrollspy");e(function(){t.scrollSpy()})}}}]);e.module("ui.materialize.tabs",[]).directive("tabs",["$timeout",function(e){return{scope:{reload:"="},link:function(i,t,n){t.addClass("tabs");e(function(){t.tabs()});i.$watch("reload",function(e){if(e===true){t.tabs();i.reload=false}})}}}]);e.module("ui.materialize.sidenav",[]).directive("sidenav",[function(){return{scope:{menuwidth:"@",closeonclick:"@"},link:function(t,n,a){n.sideNav({menuWidth:e.isDefined(t.menuwidth)?parseInt(t.menuwidth,10):i,edge:a.sidenav?a.sidenav:"left",closeOnClick:e.isDefined(t.closeonclick)?t.closeonclick=="true":i})}}}]);e.module("ui.materialize.material_select",[]).directive("materialSelect",["$compile","$timeout",function(t,n){return{link:function(t,a,o){if(a.is("select")){function r(e,n){if(o.multiple){if(n!==i&&e!==i){if(n.length===e.length){return}}var r=a.siblings("ul.active");if(e!==i&&r.length){var l=r.children("li.active").length;if(l==e.length){return}}}a.siblings(".caret").remove();function s(){if(!o.multiple){var e=a.val();var i=a.siblings("ul");i.find("li").each(function(){var i=$(this);if(i.text()===e){i.addClass("active")}})}}t.$evalAsync(function(){a.material_select(function(){if(!o.multiple){a.siblings("input.select-dropdown").trigger("close")}s()});var e=function(e){if(e.clientX>=e.target.clientWidth||e.clientY>=e.target.clientHeight){e.preventDefault()}};a.siblings("input.select-dropdown").off("mousedown.material_select_fix").on("mousedown.material_select_fix",e);s();a.siblings("input.select-dropdown").off("click.material_select_fix").on("click.material_select_fix",function(){$("input.select-dropdown").not(a.siblings("input.select-dropdown")).trigger("close")})})}n(r);if(o.ngModel){if(o.ngModel&&!e.isDefined(t.$eval(o.ngModel))){var l=false;t.$watch(o.ngModel,function(i,n){if(!l&&e.isDefined(t.$eval(o.ngModel))){l=true;r()}else{r(i,n)}})}else{t.$watch(o.ngModel,r)}}if("watch"in o){t.$watch(function(){return a[0].innerHTML},function(e,i){if(e!==i){n(r)}})}if(o.ngDisabled){t.$watch(o.ngDisabled,r)}}}}}]);e.module("ui.materialize.dropdown",[]).directive("dropdown",["$timeout",function(t){return{scope:{inDuration:"@",outDuration:"@",constrainWidth:"@",hover:"@",alignment:"@",gutter:"@",belowOrigin:"@"},link:function(n,a,o){t(function(){a.dropdown({inDuration:e.isDefined(n.inDuration)?n.inDuration:i,outDuration:e.isDefined(n.outDuration)?n.outDuration:i,constrain_width:e.isDefined(n.constrainWidth)?n.constrainWidth:i,hover:e.isDefined(n.hover)?n.hover:i,alignment:e.isDefined(n.alignment)?n.alignment:i,gutter:e.isDefined(n.gutter)?n.gutter:i,belowOrigin:e.isDefined(n.belowOrigin)?n.belowOrigin:i})})}}}]);e.module("ui.materialize.inputfield",[]).directive("inputField",["$timeout",function(i){var t=0;return{transclude:true,scope:{},link:function(n,a){i(function(){var o=a.find("> > input, > > textarea");var r=a.find("> > label");if(o.length==1&&r.length==1&&!o.attr("id")&&!r.attr("for")){var l="angularMaterializeID"+t++;o.attr("id",l);r.attr("for",l)}Materialize.updateTextFields();a.find("> > .materialize-textarea").each(function(){var e=$(this);e.addClass("materialize-textarea");e.trigger("autoresize");var t=e.attr("ng-model");if(t){n.$parent.$watch(t,function(t,n){if(t!==n){i(function(){e.trigger("autoresize")})}})}});a.find("> > .materialize-textarea, > > input").each(function(i,t){t=e.element(t);if(!t.siblings('span[class="character-counter"]').length){t.characterCounter()}})})},template:'<div ng-transclude class="input-field"></div>'}}]);e.module("ui.materialize.input_date",[]).directive("inputDate",["$compile","$timeout",function(t,n){var a=$("<style>#inputCreated_root {outline: none;}</style>");$("html > head").append(a);var o=function(){var e=/d{1,4}|m{1,4}|yy(?:yy)?|([HhMsTt])\1?|[LloSZ]|"[^"]*"|'[^']*'/g,t=/\b(?:[PMCEA][SDP]T|(?:Pacific|Mountain|Central|Eastern|Atlantic) (?:Standard|Daylight|Prevailing) Time|(?:GMT|UTC)(?:[-+]\d{4})?)\b/g,n=/[^-+\dA-Z]/g,a=function(e,i){e=String(e);i=i||2;while(e.length<i){e="0"+e}return e};return function(r,l,s){var u=o;if(arguments.length===1&&Object.prototype.toString.call(r)=="[object String]"&&!/\d/.test(r)){l=r;r=i}r=r?new Date(r):new Date;if(isNaN(r))throw SyntaxError("invalid date");l=String(u.masks[l]||l||u.masks["default"]);if(l.slice(0,4)=="UTC:"){l=l.slice(4);s=true}var c=s?"getUTC":"get",d=r[c+"Date"](),f=r[c+"Day"](),m=r[c+"Month"](),p=r[c+"FullYear"](),g=r[c+"Hours"](),v=r[c+"Minutes"](),h=r[c+"Seconds"](),y=r[c+"Milliseconds"](),D=s?0:r.getTimezoneOffset(),b={d:d,dd:a(d),ddd:u.i18n.dayNames[f],dddd:u.i18n.dayNames[f+7],m:m+1,mm:a(m+1),mmm:u.i18n.monthNames[m],mmmm:u.i18n.monthNames[m+12],yy:String(p).slice(2),yyyy:p,h:g%12||12,hh:a(g%12||12),H:g,HH:a(g),M:v,MM:a(v),s:h,ss:a(h),l:a(y,3),L:a(y>99?Math.round(y/10):y),t:g<12?"a":"p",tt:g<12?"am":"pm",T:g<12?"A":"P",TT:g<12?"AM":"PM",Z:s?"UTC":(String(r).match(t)||[""]).pop().replace(n,""),o:(D>0?"-":"+")+a(Math.floor(Math.abs(D)/60)*100+Math.abs(D)%60,4),S:["th","st","nd","rd"][d%10>3?0:(d%100-d%10!=10)*d%10]};return l.replace(e,function(e){return e in b?b[e]:e.slice(1,e.length-1)})}}();o.masks={"default":"ddd mmm dd yyyy HH:MM:ss",shortDate:"m/d/yy",mediumDate:"mmm d, yyyy",longDate:"mmmm d, yyyy",fullDate:"dddd, mmmm d, yyyy",shortTime:"h:MM TT",mediumTime:"h:MM:ss TT",longTime:"h:MM:ss TT Z",isoDate:"yyyy-mm-dd",isoTime:"HH:MM:ss",isoDateTime:"yyyy-mm-dd'T'HH:MM:ss",isoUtcDateTime:"UTC:yyyy-mm-dd'T'HH:MM:ss'Z'"};o.i18n={dayNames:["Sun","Mon","Tue","Wed","Thu","Fri","Sat","Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],monthNames:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec","January","February","March","April","May","June","July","August","September","October","November","December"]};Date.prototype.format=function(e,i){return o(this,e,i)};var r=function(e){if(Object.prototype.toString.call(e)==="[object Date]"){return!isNaN(e.getTime())}return false};return{require:"ngModel",scope:{container:"@",format:"@",formatSubmit:"@",monthsFull:"@",monthsShort:"@",weekdaysFull:"@",weekdaysShort:"@",weekdaysLetter:"@",firstDay:"=",disable:"=",today:"=",clear:"=",close:"=",selectYears:"=",selectMonths:"=",onStart:"&",onRender:"&",onOpen:"&",onClose:"&",onSet:"&",onStop:"&",ngReadonly:"=?",max:"@",min:"@"},link:function(a,o,l,s){s.$formatters.unshift(function(i){if(i){var t=new Date(i);return e.isDefined(a.format)?t.format(a.format):t.format("d mmmm, yyyy")}return null});var u=e.isDefined(a.monthsFull)?a.$eval(a.monthsFull):i,c=e.isDefined(a.monthsShort)?a.$eval(a.monthsShort):i,d=e.isDefined(a.weekdaysFull)?a.$eval(a.weekdaysFull):i,f=e.isDefined(a.weekdaysShort)?a.$eval(a.weekdaysShort):i,m=e.isDefined(a.weekdaysLetter)?a.$eval(a.weekdaysLetter):i;t(o.contents())(a);if(!a.ngReadonly){n(function(){var t={container:a.container,format:e.isDefined(a.format)?a.format:i,formatSubmit:e.isDefined(a.formatSubmit)?a.formatSubmit:i,monthsFull:e.isDefined(u)?u:i,monthsShort:e.isDefined(c)?c:i,weekdaysFull:e.isDefined(d)?d:i,weekdaysShort:e.isDefined(f)?f:i,weekdaysLetter:e.isDefined(m)?m:i,firstDay:e.isDefined(a.firstDay)?a.firstDay:0,disable:e.isDefined(a.disable)?a.disable:i,today:e.isDefined(a.today)?a.today:i,clear:e.isDefined(a.clear)?a.clear:i,close:e.isDefined(a.close)?a.close:i,selectYears:e.isDefined(a.selectYears)?a.selectYears:i,selectMonths:e.isDefined(a.selectMonths)?a.selectMonths:i,onStart:e.isDefined(a.onStart)?function(){a.onStart()}:i,onRender:e.isDefined(a.onRender)?function(){a.onRender()}:i,onOpen:e.isDefined(a.onOpen)?function(){a.onOpen()}:i,onClose:e.isDefined(a.onClose)?function(){a.onClose()}:i,onSet:e.isDefined(a.onSet)?function(){a.onSet()}:i,onStop:e.isDefined(a.onStop)?function(){a.onStop()}:i};if(!a.container){delete t.container}var n=o.pickadate(t);var l=n.pickadate("picker");a.$watch("max",function(e){if(l){var i=new Date(e);l.set({max:r(i)?i:false})}});a.$watch("min",function(e){if(l){var i=new Date(e);l.set({min:r(i)?i:false})}});a.$watch("disable",function(i){if(l){var t=e.isDefined(i)&&e.isArray(i)?i:false;l.set({disable:t})}})})}}}}]);e.module("ui.materialize.input_clock",[]).directive("inputClock",[function(){return{restrict:"A",scope:{"default":"@",fromnow:"=?",donetext:"@",autoclose:"=?",ampmclickable:"=?",darktheme:"=?",twelvehour:"=?",vibrate:"=?"},link:function(i,t){$(t).addClass("timepicker");if(!i.ngReadonly){t.pickatime({"default":e.isDefined(i.default)?i.default:"",fromnow:e.isDefined(i.fromnow)?i.fromnow:0,donetext:e.isDefined(i.donetext)?i.donetext:"Done",autoclose:e.isDefined(i.autoclose)?i.autoclose:false,ampmclickable:e.isDefined(i.ampmclickable)?i.ampmclickable:false,darktheme:e.isDefined(i.darktheme)?i.darktheme:false,twelvehour:e.isDefined(i.twelvehour)?i.twelvehour:true,vibrate:e.isDefined(i.vibrate)?i.vibrate:true})}}}}]);e.module("ui.materialize.pagination",[]).directive("pagination",["$sce",function(e){function i(e,i){e.List=[];e.Hide=false;e.page=parseInt(e.page)||1;e.total=parseInt(e.total)||0;e.dots=e.dots||"...";e.ulClass=e.ulClass||i.ulClass||"pagination";e.adjacent=parseInt(e.adjacent)||2;e.activeClass="active";e.disabledClass="disabled";e.scrollTop=e.$eval(i.scrollTop);e.hideIfEmpty=e.$eval(i.hideIfEmpty);e.showPrevNext=e.$eval(i.showPrevNext);e.useSimplePrevNext=e.$eval(i.useSimplePrevNext)}function t(e,i){if(e.page>i){e.page=i}if(e.page<=0){e.page=1}if(e.adjacent<=0){e.adjacent=2}if(i<=1){e.Hide=e.hideIfEmpty}}function n(e,i){i=i.valueOf();if(e.page==i){return}e.page=i;e.paginationAction({page:i});if(e.scrollTop){scrollTo(0,0)}}function a(i,t,a){var o=0;for(o=i;o<=t;o++){var r={value:e.trustAsHtml(o.toString()),liClass:a.page==o?a.activeClass:"waves-effect",action:function(){n(a,this.value)}};a.List.push(r)}}function o(i){i.List.push({value:e.trustAsHtml(i.dots)})}function r(e,i){a(1,2,e);if(i!=3){o(e)}}function l(i,t,a){if(!i.showPrevNext||t<1){return}var o,r,l;if(a==="prev"){o=i.page-1<=0;var s=i.page-1<=0?1:i.page-1;if(i.useSimplePrevNext){r={value:"<<",title:"First Page",page:1};l={value:"<",title:"Previous Page",page:s}}else{r={value:'<i class="material-icons">first_page</i>',title:"First Page",page:1};l={value:'<i class="material-icons">chevron_left</i>',title:"Previous Page",page:s}}}else{o=i.page+1>t;var u=i.page+1>=t?t:i.page+1;if(i.useSimplePrevNext){r={value:">",title:"Next Page",page:u};l={value:">>",title:"Last Page",page:t}}else{r={value:'<i class="material-icons">chevron_right</i>',title:"Next Page",page:u};l={value:'<i class="material-icons">last_page</i>',title:"Last Page",page:t}}}var c=function(t,a){i.List.push({value:e.trustAsHtml(t.value),title:t.title,liClass:a?i.disabledClass:"",action:function(){if(!a){n(i,t.page)}}})};c(r,o);c(l,o)}function s(e,i,t){if(t!=e-2){o(i)}a(e-1,e,i)}function u(e,n){if(!e.pageSize||e.pageSize<0){return}i(e,n);var o,u=e.adjacent*2,c=Math.ceil(e.total/e.pageSize);t(e,c);l(e,c,"prev");if(c<5+u){o=1;a(o,c,e)}else{var d;if(e.page<=1+u){o=1;d=2+u+(e.adjacent-1);a(o,d,e);s(c,e,d)}else if(c-u>e.page&&e.page>u){o=e.page-e.adjacent;d=e.page+e.adjacent;r(e,o);a(o,d,e);s(c,e,d)}else{o=c-(1+u+(e.adjacent-1));d=c;r(e,o);a(o,d,e)}}l(e,c,"next")}return{restrict:"EA",scope:{page:"=",pageSize:"=",total:"=",dots:"@",hideIfEmpty:"@",adjacent:"@",scrollTop:"@",showPrevNext:"@",useSimplePrevNext:"@",paginationAction:"&",ulClass:"=?"},template:'<ul ng-hide="Hide" ng-class="ulClass"> '+"<li "+'ng-class="Item.liClass" '+'ng-click="Item.action()" '+'ng-repeat="Item in List"> '+"<a href> "+'<span ng-bind-html="Item.value"></span> '+"</a>"+"</ul>",link:function(e,i,t){e.$watchCollection("[page, total, pageSize]",function(){u(e,t)})}}}]);e.module("ui.materialize.modal",[]).directive("modal",["$compile","$timeout",function(t,n){return{scope:{dismissible:"=",opacity:"@",inDuration:"@",outDuration:"@",ready:"&?",complete:"&?",open:"=?",enableTabs:"@?"},link:function(a,o,r){n(function(){var n=$(r.href?r.href:"#"+r.target);t(o.contents())(a);var l=function(){e.isFunction(a.complete)&&a.$apply(a.complete);a.open=false;a.$apply()};var s=function(){e.isFunction(a.ready)&&a.$apply(a.ready);a.open=true;a.$apply();if(a.enableTabs){n.find("ul.tabs").tabs()}};var u={dismissible:e.isDefined(a.dismissible)?a.dismissible:i,opacity:e.isDefined(a.opacity)?a.opacity:i,in_duration:e.isDefined(a.inDuration)?a.inDuration:i,out_duration:e.isDefined(a.outDuration)?a.outDuration:i,ready:s,complete:l};n.modal(u);o.modal(u);if(e.isDefined(r.open)&&n.length>0){a.$watch("open",function(i,t){if(!e.isDefined(i)){return}i===true?n.modal("open"):n.modal("close")})}})}}}]);e.module("ui.materialize.tooltipped",[]).directive("tooltipped",["$compile","$timeout",function(e,i){return{restrict:"A",link:function(t,n,a){var o=Function.prototype;function r(){n.addClass("tooltipped");e(n.contents())(t);i(function(){if(n.attr("data-tooltip-id")){n.tooltip("remove")}n.tooltip()});o=t.$on("$destroy",function(){n.tooltip("remove")})}a.$observe("tooltipped",function(e){if(e==="false"&&o!==Function.prototype){n.tooltip("remove");o();o=Function.prototype}else if(e!=="false"&&o===Function.prototype){r()}});if(a.tooltipped!=="false"){r()}n.on("$destroy",function(){n.tooltip("remove")})}}}]);e.module("ui.materialize.materialboxed",[]).directive("materialboxed",["$timeout",function(e){return{restrict:"A",link:function(i,t,n){e(function(){t.materialbox()})}}}]);e.module("ui.materialize.nouislider",[]).directive("nouislider",["$timeout",function(t){return{restrict:"A",scope:{ngModel:"=",min:"@",max:"@",step:"@?",connect:"@?",tooltips:"@?",behaviour:"@?"},link:function(n,a,o){var r=false;var l=n.$watch("ngModel",function(e){if(e!==i){s();l()}});a[0].noUiSlider.on("update",function(e,i){t(function(){n.ngModel=r?e:e[0]})});function s(){if(e.isArray(n.ngModel)){r=true}noUiSlider.create(a[0],{start:n.ngModel||0,step:parseFloat(n.step||1),tooltips:e.isDefined(n.tooltips)?n.tooltips:i,connect:e.isDefined(n.connect)?n.connect:[false,false],behaviour:e.isDefined(n.behaviour)?n.behaviour:i,range:{min:parseFloat(n.min||0),max:parseFloat(n.max||100)},format:{to:function(e){return Math.round(e*100)/100},from:function(e){return Number(e)}}});function t(e){e.toLowerCase();if("true"===e||"false"===e){return JSON.parse(e)}return e}}}}}])})(angular);