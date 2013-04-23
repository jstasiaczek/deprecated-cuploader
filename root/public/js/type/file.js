function CTypeFile(){
	this.getHtml = function(){
		var htmlTag = '<a href="';
		htmlTag += $('#file-input-url').val()+'"';
		if($('#file-input-window').is(':checked'))
			htmlTag += ' target="_blank" ';
		if($('#file-input-title').length > 0)
			htmlTag += ' title="'+$('#file-input-title').val()+'" ';
		htmlTag += ' >'+$('#file-input-text').val()+'</a>';
		return htmlTag;
	};
}
var typeFile = new CTypeFile();