<div id="banner-images"> </div>
<script>

	function getRandomInt(min, max) {
		min = Math.ceil(min);
		max = Math.floor(max);
		return Math.floor(Math.random() * (max - min)) + min;
	}

	$('<img class="fade-in" src="image/' + getRandomInt(1, 12) + '.jpeg">').appendTo('#banner-images');
</script>