;
function __(label,defaultText){
	"strict";
	if (!defaultText)
		return label;
	return defaultText;
}

function _n(label, defaultSingle, defaultPlural, number){
	"strict";
	if (number == 1)
		return defaultSingle;
	
	return defaultPlural;
}