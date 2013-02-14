define [
	'jquery'		
	'underscore'		
	'backbone'
	'sprintf'
	'views/appview'
	'subroute'
], ($, _, Backbone, sprintf, AppView)->
	
	class CoreController extends Backbone.Router
		routes:		{":controller(/*path)": 'loadModuleRouter'}
		subRouters: { }
		initialize: () ->
			super()
			@setResponseCatchers()
			Backbone.history.start()

			AppView.render().$el.appendTo("body")

		loadModuleRouter: (controller) ->

			# regularizes controller name and its presentation
			controller = controller.toLowerCase()
			controllerName = controller.substr(0,1).toUpperCase()+ controller.substr(1).toLowerCase()

			# if it hasnt been already added to Core, requires it
			if !@subRouters[controller]? && controller != "core"
				require ["controllers/#{controller}"], (Controller) =>
					# prints log 
					console.log sprintf  "Starting controller %1$s ...", controllerName

					if !@subRouters[controller]? && controller != "core"
						# Instances the required Controller
						@subRouters[controller] = new Controller controller


		handleError: (error)=>
		setResponseCatchers: ->
			$.ajaxSetup
				statusCode:
					401: =>    
						@navigate "login",
							trigger: true


