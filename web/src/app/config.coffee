requirejs.config
	shim:
		jquery:
			exports: 'jQuery'

		sprintf:
			exports: 'sprintf'

		underscore:
			exports: '_'

		i18n:
			exports: '__'

		backbone:
			deps: ['jquery', 'underscore'],
			exports: 'Backbone'

		bootstrap:
			deps: ['jquery'],
			exports: 'Bootstrap'

		backgrid:
			deps: ['backbone'],
			exports: 'Backgrid'

		"backbone-forms":
			deps: ['backbone'],

		"backbone-forms-bootstrap":
			deps: ['backbone-forms']


	paths:
		# Base Libraries
		jquery: 			'../assets/js/libs/jquery'
		backbone: 			'../assets/js/libs/backbone'
		bootstrap: 			'../assets/js/libs/bootstrap'
		underscore: 		'../assets/js/libs/underscore'

		# Essentials Libraries
		text:				'../assets/js/libs/text'
		i18n:				'../assets/js/libs/i18n'
		sprintf: 			'../assets/js/libs/sprintf'
		subroute: 			'../assets/js/libs/backbone.subroute'
		pageable:			'../assets/js/libs/backbone-pageable.min'

		# User Interface 
		'backbone-forms':						'../assets/js/libs/backbone-forms.min'
		'backbone-forms-bootstrap':				'../assets/js/libs/backbone-forms-bootstrap'
		'backbone-forms-list':					'../assets/js/libs/backbone-forms-list.min'
		'backbone-forms-inline-nestedmodels':	'../assets/js/libs/inlinenestedmodels'

require [
	'routers/core'
	'subroute'
	'text'
	'bootstrap'
	'i18n'
],
(CoreController)->
	new CoreController()
