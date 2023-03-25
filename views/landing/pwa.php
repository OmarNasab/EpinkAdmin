<div class="container py-5">
	<h1>Delivery</h1>
	<p>Delivery at your finger tip</p>
	<div class="card mb-3">
		<div class="card-body">
			<input type="text" style="width: 100%; border: none;" class="noborder" placeholder="Please set pick up address">
		</div>
	</div>
	<div class="card mb-5">
		<div class="card-body">
			<input type="text" style="width: 100%; border: none;" class="noborder" placeholder="Please set drop off address">
		</div>
	</div>
	<div class="d-grid gap-2">
		<button class="btn btn-primary">REQUEST</button>
	</div>
</div>
<input type="file" onchange="checkFile(this)" multiple>
<script>
function checkFile(element){
	var totalfile = element.files.length;
	for (var i = 0; i < totalfile; ++i) {
		var file1 = element.files[i];
		var reader = new FileReader();
		reader.onloadend = function() {
			console.log('Reading File '+i+' out of '+totalfile);
			console.log('File Number '+i+'= '+reader.result);
		}
		reader.readAsDataURL(file1);
	}
}
</script>