define [
	'jquery'		
	'underscore'		
	'backbone'
	'bootstrap'
	'modules/core/router'
], ($, _, Backbone, Bootstrap, Router)->

	class Core extends Backbone.Model

		initialize: ()->
			@router = new Router();
			Backbone.history.start();
			Backbone.Events.on "load_view", (PageView)=>
				@setPageView PageView

		#setPageView: 