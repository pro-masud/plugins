(()=>{"use strict";var e={790:e=>{e.exports=window.ReactJSXRuntime},715:e=>{e.exports=window.wp.blockEditor},997:e=>{e.exports=window.wp.blocks},723:e=>{e.exports=window.wp.i18n}},o={};function r(t){var s=o[t];if(void 0!==s)return s.exports;var i=o[t]={exports:{}};return e[t](i,i.exports,r),i.exports}var t=r(997),s=r(723),i=r(715),c=r(790);const n=JSON.parse('{"apiVersion":2,"name":"card-block/new-block","title":"New Block","category":"CardBlock","icon":"smiley","description":"A new custom block for your plugin.","keywords":["new","custom"],"supports":{"align":["left","right","center"],"anchor":true,"customClassName":false},"version":"1.0.0","textdomain":"card-block","editorScript":"file:./index.js","style":"file:./style.css"}');(0,t.registerBlockType)(n.name,{...n,edit:function(){return(0,c.jsx)("div",{...(0,i.useBlockProps)(),children:(0,c.jsx)("p",{children:(0,s.__)("Hello from the New Block!","card-block")})})},save:function(){return(0,c.jsx)("div",{...i.useBlockProps.save(),children:(0,c.jsx)("p",{children:"Hello from the New Block!"})})}})})();