define [
	'jquery'		
	'underscore'		
	'backbone'
	'subroute'
], ($, _, Backbone, App)->

	class AppRouter extends Backbone.Router
		subRouters: {}
		routes:
			":module(/*path)": 'loadModuleRouter'

		loadModuleRouter: (module, subRoute) ->
			if !@subRouters[module]?
				require ["modules/#{module}/router"], (SubRouter) =>
					@subRouters[module] = new SubRouter(module+"/")


	window.Router = new AppRouter()

	$.ajaxSetup statusCode:
	  401: ->    
		# Redirec the to the login page.
		Router.navigate "login",
			trigger: true

	  403: ->
		# 403 -- Access denied
		Router.navigate "denied",
			trigger: true

	Backbone.history.start();

