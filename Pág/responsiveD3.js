!function(t){function e(n){if(r[n])return r[n].exports;var a=r[n]={i:n,l:!1,exports:{}};return t[n].call(a.exports,a,a.exports,e),a.l=!0,a.exports}var r={};e.m=t,e.c=r,e.d=function(t,r,n){e.o(t,r)||Object.defineProperty(t,r,{configurable:!1,enumerable:!0,get:n})},e.n=function(t){var r=t&&t.__esModule?function(){return t.default}:function(){return t};return e.d(r,"a",r),r},e.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},e.p="",e(e.s=10)}({10:function(t,e,r){"use strict";function n(){var t=d3.range(5).map(i);s.value(function(e,r){return t[r]}),f=f.data(s),f.transition().duration(750).attrTween("d",a)}function a(t){var e=d3.interpolate(this._current,t);return this._current=e(0),function(t){return l(e(t))}}function i(){return Math.floor(4*Math.random()+2)}function o(t){function e(){var e=parseInt(r.style("width"));t.attr("width",e),t.attr("height",Math.round(e/i))}var r=d3.select(t.node().parentNode),n=parseInt(t.style("width")),a=parseInt(t.style("height")),i=n/a;t.attr("viewBox","0 0 "+n+" "+a).attr("perserveAspectRatio","xMinYMid").call(e),d3.select(window).on("resize."+r.attr("id"),e)}var u=Math.min(660,340)/2,c=d3.scale.category20(),d=d3.range(5).map(i),s=d3.layout.pie().padAngle(.02).sort(null),l=d3.svg.arc().innerRadius(u-40).outerRadius(u).cornerRadius(20),p=d3.select("#viz-responsive-demo").append("svg").attr("width",660).attr("height",340).call(o).append("g").attr("transform","translate(330,170)"),f=p.datum(d).selectAll("path").data(s).enter().append("path").attr("fill",function(t,e){return c(e)}).attr("d",l).each(function(t){this._current=t});setInterval(function(){n()},2e3)}});