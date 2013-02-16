define [
	'jquery'		
	'underscore'		
	'backbone'
	'sprintf'
	'views/appview'
	'subroute'
	# Modules will be listed from here on for better optimization
	'routers/contatos'
], ($, _, Backbone, sprintf, AppView)->
	
	class CoreRouter extends Backbone.Router
		routes:
			'' : 'index'
			':router(/*path)': 'loadModuleRouter'

		subRouters: { }

		index: ->
			@navigate "contatos/", trigger: true

		initialize: () ->
			super()
			@setResponseCatchers()
			Backbone.history.start()
			AppView.render().$el.appendTo("body")

		loadModuleRouter: (routerBase) ->

			# regularizes router name and its presentation
			routerBase = routerBase.toLowerCase()
			routerBaseName = routerBase.substr(0,1).toUpperCase()+ routerBase.substr(1).toLowerCase()

			# if it is not the core
			if routerBase != "core"
				require ["routers/#{routerBase}"], (Router) =>
					# prints log 
					console.log sprintf  "Starting router %1$s ...", routerBaseName
					(new Router routerBase).on "routeNotFound", @handleError ,@

		setResponseCatchers: ->
			$.ajaxSetup
				statusCode:
					401: =>    
						@navigate "login",
							trigger: true


