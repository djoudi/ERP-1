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

			AppView.setView "Contatos", (new ContatosIndexView(collection: @contatos))
			AppView.view.on "edit", (contato)=>
				@navigate "#{@prefix}/#{contato.id}", trigger: true

			AppView.view.on "remove", (contato)=>
				@contatos.remove(contato)
				contato.destroy()

		new: ->

			if !AppView.view || AppView.view? && AppView.view.constructor.name is not "ContatosIndexView"
				@index()
				
			editor = (new ContatoEditorView( model: new @contatos.model() ))

			editor.$el.on "hidden", =>
				@navigate "#{@prefix}/"

			editor.render()

		edit: (contato)->

			if !_.isObject(contato)
				contato = new @contatos.model( id: contato )

			if !AppView.view || AppView.view? && AppView.view.constructor.name is not "ContatosIndexView"
				@index()


			contato.fetch 
				success: =>
					editor = (new ContatoEditorView( model: contato ))

					editor.$el.on "hidden", =>
						@navigate "#{@prefix}/"

					editor.render()


