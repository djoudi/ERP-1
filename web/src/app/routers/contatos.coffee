define [
	'jquery'		
	'underscore'		
	'backbone'
	'views/appview'
	'collections/contatos'
	'views/contatos/index'
	'views/contatos/editor'
], ($,_,Backbone, AppView, Contatos, ContatosIndexView, ContatoEditorView)->

	newRoute = __('NEW_CONTACT_ROUTE', 'novo')

	routes = {}

	routes["#{newRoute}"]	= "new"

	routes[""]		= "index"
	routes["/"]		= "index"
	routes[":id"]	= "edit"


	class ContatosRouter extends Backbone.SubRoute
		routes: routes
		contatos: new Contatos()
		index: ->
			if AppView.view? && AppView.view.constructor.name is "ContatosIndexView"
				return

			AppView.setTitle 	"Contatos"
			AppView.setView 	(new ContatosIndexView(collection: @contatos))

		new: ->
			if !AppView.view || AppView.view? && AppView.view.constructor.name is not "ContatosIndexView"
				AppView.setView new ContatosIndexView(collection: @contatos)

			editor = (new ContatoEditorView())
			editor.$el.on "hidden", =>
				@navigate "#{@prefix}/"
			editor.render()

		edit: ->
