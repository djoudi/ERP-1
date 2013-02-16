define [
	'backbone'
	'pageable'
	'settings'		
	'models/contato'		
], (Backbone, PageableCollection, Settings, Contato)->


	class Contatos extends PageableCollection
		
		model: Contato
		url: Settings.api.url+"/contatos"
		parse: (response)->
			if (!response.metadata.errors)
				return response.data

		
