"use strict";(self.webpackChunkdoc=self.webpackChunkdoc||[]).push([[142],{3905:function(e,r,t){t.d(r,{Zo:function(){return p},kt:function(){return m}});var n=t(7294);function o(e,r,t){return r in e?Object.defineProperty(e,r,{value:t,enumerable:!0,configurable:!0,writable:!0}):e[r]=t,e}function l(e,r){var t=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);r&&(n=n.filter((function(r){return Object.getOwnPropertyDescriptor(e,r).enumerable}))),t.push.apply(t,n)}return t}function i(e){for(var r=1;r<arguments.length;r++){var t=null!=arguments[r]?arguments[r]:{};r%2?l(Object(t),!0).forEach((function(r){o(e,r,t[r])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(t)):l(Object(t)).forEach((function(r){Object.defineProperty(e,r,Object.getOwnPropertyDescriptor(t,r))}))}return e}function a(e,r){if(null==e)return{};var t,n,o=function(e,r){if(null==e)return{};var t,n,o={},l=Object.keys(e);for(n=0;n<l.length;n++)t=l[n],r.indexOf(t)>=0||(o[t]=e[t]);return o}(e,r);if(Object.getOwnPropertySymbols){var l=Object.getOwnPropertySymbols(e);for(n=0;n<l.length;n++)t=l[n],r.indexOf(t)>=0||Object.prototype.propertyIsEnumerable.call(e,t)&&(o[t]=e[t])}return o}var c=n.createContext({}),u=function(e){var r=n.useContext(c),t=r;return e&&(t="function"==typeof e?e(r):i(i({},r),e)),t},p=function(e){var r=u(e.components);return n.createElement(c.Provider,{value:r},e.children)},s={inlineCode:"code",wrapper:function(e){var r=e.children;return n.createElement(n.Fragment,{},r)}},d=n.forwardRef((function(e,r){var t=e.components,o=e.mdxType,l=e.originalType,c=e.parentName,p=a(e,["components","mdxType","originalType","parentName"]),d=u(t),m=o,f=d["".concat(c,".").concat(m)]||d[m]||s[m]||l;return t?n.createElement(f,i(i({ref:r},p),{},{components:t})):n.createElement(f,i({ref:r},p))}));function m(e,r){var t=arguments,o=r&&r.mdxType;if("string"==typeof e||o){var l=t.length,i=new Array(l);i[0]=d;var a={};for(var c in r)hasOwnProperty.call(r,c)&&(a[c]=r[c]);a.originalType=e,a.mdxType="string"==typeof e?e:o,i[1]=a;for(var u=2;u<l;u++)i[u]=t[u];return n.createElement.apply(null,i)}return n.createElement.apply(null,t)}d.displayName="MDXCreateElement"},9112:function(e,r,t){t.r(r),t.d(r,{frontMatter:function(){return a},contentTitle:function(){return c},metadata:function(){return u},toc:function(){return p},default:function(){return d}});var n=t(7462),o=t(3366),l=(t(7294),t(3905)),i=["components"],a={sidebar_position:1},c="Override Controller",u={unversionedId:"customization/override-controller",id:"customization/override-controller",title:"Override Controller",description:"To override the controller, you can follow the following steps:",source:"@site/docs/customization/override-controller.md",sourceDirName:"customization",slug:"/customization/override-controller",permalink:"/id/customization/override-controller",editUrl:"https://github.com/uasoft-indonesia/badaso-commerce-module/edit/main/website/docs/customization/override-controller.md",tags:[],version:"current",sidebarPosition:1,frontMatter:{sidebar_position:1},sidebar:"tutorialSidebar",previous:{title:"Installation",permalink:"/id/getting-started/installation"}},p=[],s={toc:p};function d(e){var r=e.components,t=(0,o.Z)(e,i);return(0,l.kt)("wrapper",(0,n.Z)({},s,t,{components:r,mdxType:"MDXLayout"}),(0,l.kt)("h1",{id:"override-controller"},"Override Controller"),(0,l.kt)("p",null,"To override the controller, you can follow the following steps:"),(0,l.kt)("ul",null,(0,l.kt)("li",{parentName:"ul"},"Create a new controller by using below command.")),(0,l.kt)("p",null,(0,l.kt)("inlineCode",{parentName:"p"},"php artisan make:controller ExampleController")),(0,l.kt)("ul",null,(0,l.kt)("li",{parentName:"ul"},"After the new controller is created, you can override the controller by registering the controller in the ",(0,l.kt)("inlineCode",{parentName:"li"},"config/badaso-commerce.php")," file in ",(0,l.kt)("inlineCode",{parentName:"li"},"controllers")," section. For example:")),(0,l.kt)("pre",null,(0,l.kt)("code",{parentName:"pre",className:"language-php"},"return [\n    ...,\n\n    'controllers' => [\n        'PublicController\\ProductController@browse' => 'App\\Http\\Controllers\\ExampleController@browse',\n    ],\n];\n")),(0,l.kt)("ul",null,(0,l.kt)("li",{parentName:"ul"},"You can see the available keys of overrides in the ",(0,l.kt)("inlineCode",{parentName:"li"},"vendor/badaso/commerce-module/src/Routes/api.php")," file.")))}d.isMDXComponent=!0}}]);