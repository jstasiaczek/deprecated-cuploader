function CUploaderPopup(){
	this.cuploaderUrl = '';
	this.language = 'en';
	this.type = 'list';
	
	this.init = function(url, lang, type){
		if(url != null)
			this.cuploaderUrl = url;
		if(lang != null)
			this.language = lang;
		if(type != null)
			this.type = type;
	};
	
	this.insertImage = function(id){
		if(window['cuploader_params_storage'] == null)
			window['cuploader_params_storage'] = {path:'', type:this.type};
		window.open(this.cuploaderUrl+'manage.php/?lang='+this.language+'&target=popup&target_id='+id+'&path='+window['cuploader_params_storage'].path+'&type='+window['cuploader_params_storage'].type, '_blank', 'width=850,height=600,location=0,menubar=0,toolbar=0')
	};
}

