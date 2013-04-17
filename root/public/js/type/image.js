function CTypeImage(){
	this.getHtml = function(url, width, height, attributes){
		var imgTag = '<img src="';
		imgTag += url+'"';
		if(width != null)
			imgTag += ' width="'+width+'" ';
		if(height != null)
			imgTag += ' height="'+height+'" ';
		if(attributes != null)
			imgTag += ' style="'+attributes+'" ';
		if($('#image-input-title').length > 0)
			imgTag += ' title="'+$('#image-input-title').val()+'" ';
		if($('#image-input-alt').length > 0)
			imgTag += ' alt="'+$('#image-input-alt').val()+'" ';
		imgTag += ' />';
		return imgTag;
	};

	this.createThumb = function(path_add, id, imageName)
	{
		$.ajax({
			url: uploader.urls.createThumb, 
			async: false,
			data: {'thumb_id': id, 'imageName':imageName, 'path_add': path_add}, 
			type: 'POST',
			success: function(data){
				var json = $.parseJSON(data);
				if(json.success)
				{
					targetObj.insert(this.getHtml(json.url, json.attributes[0],json.attributes[1], 'width: '+json.attributes[0]+'px; height: '+json.attributes[1]+'px;'));
				}
				else
					alert(json.error);
		}});
	};
}
var typeImage = new CTypeImage();