
<script id="add-photo-tpl" type="text/x-handlebars-template">
	<div id="add-photo-wrapper" class="box-style bash-form">
		<form id="add-photo-form" action="{{action}}" method="post" enctype="multipart/form-data">
			<input type="hidden" name="album_id" value="{{albumId}}">
			
			<h1>{{title}}</h1>
			<div class="form-group">
				<input placeholder="Enter Photo Caption" name="photo_caption" type="text" class="form-control" id="email" size="30" value="{{caption}}"/> 
				{{#if errors.photo_caption}}
					<span class="error">{{errors.photo_caption}}</span>
				{{/if}}
			</div>
			
			<div class="form-group">
				<input type="file" name="thumbnail" id="thumbnail"/>
				{{#if errors.thumbnail}}
					<span class="error">{{errors.thumbnail}}</span>
				{{/if}}				
			</div>
			<div class="form-group">
				<input name="submit" type="submit" id="{{submitId}}" value="UPLOAD" />
			</div>

		</form>		
	</div>
</script>