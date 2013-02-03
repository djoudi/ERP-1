define [
	'jquery'		
	'underscore'		
	'backbone'
	'subroute'
], ($, _, Backbone)->

	class AppRouter extends Backbone.Router
		initialize: ()->
			super()
			$.ajaxSetup statusCode:
			  401: =>    
				# Redireciona para página de login
				@navigate "login",
					trigger: true


		subRouters: {}
		routes:
			":module(/*path)": 'loadModuleRouter'

		loadModuleRouter: (module, subRoute) ->

			module = module.toLowerCase()


			if !@subRouters[module]? && module != "core"
				require ["modules/#{module}/router"], (SubRouter) =>
					console.log "Módulo #{module.substr(0,1).toUpperCase()+ module.substr(1).toLowerCase()} acionado"
					@subRouters[module] = new SubRouter(module)
				,(error)=>
					console.error "Módulo #{module.substr(0,1).toUpperCase()+ module.substr(1).toLowerCase()} não foi encontrado"
					@handleError error

		handleError: (error)=>
			console.log	error
				
