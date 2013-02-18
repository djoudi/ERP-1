define [
	'underscore'
	'backbone'
], (_,Backbone)->

	###
	#	Model do Telefone
	###
	class Telefone extends Backbone.Model
	Telefone.format =
		fromRaw: (rawData)->
			length = rawData.numero.length;
			numero = "";

			if length > 8
				numero += "("+rawData.numero.substr(0,length-8)+") ";


				if length > 7
					numero += rawData.numero.substr(length-8,4)+"-"+rawData.numero.substr(length-4);
				else			
					numero = rawData.numero;

			rawData.numero=numero

			rawData			

		toRaw: (formattedData)->
			if _.isString formattedData
				return formattedData.replace /[^0-9]*/g, ""

			formattedData.numero = formattedData.numero.replace /[^0-9]*/g, ""

			return formattedData

	Telefone::formatToRaw = ->
		Telefone.format.toRaw @toJSON()	

	Telefone::formatFromRaw = ->
		Telefone.format.fromRaw @toJSON()



	Telefone