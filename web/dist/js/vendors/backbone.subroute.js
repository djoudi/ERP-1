// backbone-subroute.js v0.3.2
//
// Copyright (C) 2012 Dave Cadwallader, Model N, Inc.  
// Distributed under the MIT License
//
// Documentation and full license available at:
// https://github.com/ModelN/backbone.subroute

(function(e){typeof define=="function"&&define.amd?define(["underscore","backbone"],e):e(_,Backbone)})(function(e,t){t.SubRoute=t.Router.extend({constructor:function(n,r){var i={};this.prefix=n=n||"",this.separator=n.slice(-1)==="/"?"":"/";var s=r&&r.createTrailingSlashRoutes;e.each(this.routes,function(e,t){t?(t.substr(0)==="/"&&(t=t.substr(1,t.length)),i[n+this.separator+t]=e,s&&(i[n+this.separator+t+"/"]=e)):(i[n]=e,s&&(i[n+"/"]=e))},this),this.routes=i,t.Router.prototype.constructor.call(this,r);var o;t.history.fragment?o=t.history.getFragment():o=t.history.getHash(),o.indexOf(n)===0&&t.history.loadUrl(o),this.postInitialize&&this.postInitialize(r)},navigate:function(e,n){e.substr(0,1)!="/"&&e.indexOf(this.prefix.substr(0,this.prefix.length-1))!=0&&(e=this.prefix+(e?this.separator:"")+e),t.Router.prototype.navigate.call(this,e,n)}})});