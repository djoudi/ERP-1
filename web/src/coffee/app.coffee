requirejs.config
	enforceDefine: true
	shim:
		backbone:
			deps: ['underscore', 'jquery'],
			exports: 'Backbone'
	paths:
		backbone: 	'vendors/backbone'
		underscore: 'vendors/underscore'
		jquery: 	'vendors/jquery'


define [
	'jquery'		
	'underscore'		
	'backbone'
	''
], ($,_,Backbone)->

	app = new Backbone.Router(); 

	$.ajaxSetup statusCode:
	  401: ->    
	    # Redirec the to the login page.
	    app.navigate "login",
	    	trigger: true


	  403: ->
	    # 403 -- Access denied
	    app.navigate "denied",
	    	trigger: true

