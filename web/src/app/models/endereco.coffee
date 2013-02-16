define [
	'backbone',
], (Backbone)->

	class Endereco extends Backbone.Model
	Endereco.schema = Endereco::schema =
		identificacao:
			type: "Text"
			label: "Rótulo"

		endereco:
			type: "Text"
			label: "Endereço"

	Endereco