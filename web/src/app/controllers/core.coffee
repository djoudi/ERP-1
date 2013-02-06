define [
	'jquery'		
	'underscore'		
	'backbone'
	'sprintf'
	'subroute'
], ($, _, Backbone)->

	

	class Core extends Backbone.SubRouter
		routes:
			":controller(/*path)": 'loadModuleRouter'
		subRouters: {}
		initialize: ()->
			super()
			@setResponseCachers()
			Backbone.history.start()

		loadModuleRouter: (controller) ->

			# regularizes controller name and its presentation
			controller = controller.toLowerCase()
			controllerName = controller.substr(0,1).toUpperCase()+ controller.substr(1).toLowerCase()

			# if it have been already added to Core, requires it
			if !@subRouters[controller]? && controller != "core"

				require ["controllers/#{controller}/router"], (Controller) =>
					# prints log 
					console.log sprintf  "Starting controller %$1s ...", controllerName

					# Instances the required Controller
					@subRouters[controller] = new Controller(controller)

				,(error)=>
					# prints log 
					console.error sprintf "%$1s controller required but not found", controllerName
					@handleError error

			else
				subRouters[controller]

		handleError: (error)=>
		
		setResponseCachers: ->
			$.ajaxSetup
				statusCode:
					401: =>    
						@navigate "login",
							trigger: true		