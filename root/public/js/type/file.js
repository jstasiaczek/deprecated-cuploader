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
	this.getContent = function()
	{
		var val = $('#file-input-wrap').val();
		var content = $('#file-content').val();
		if(val != '0')
		{
			return "<"+val+">"+content+"</"+val+">";
		}
		return content;
	}
}
var typeFile = new CTypeFile();