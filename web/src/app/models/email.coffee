define [
	'backbone',
], (Backbone)->

	class Email extends Backbone.Model
	Email.schema = Email::schema =
		identificacao:
			type: "Text"
			title: "Rótulo"

		email:
			type: "Text"
			title: "E-mail"

	Email