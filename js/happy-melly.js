var updateFinalPrice = function() {
	var price,
		currency,
		origin,
		originIndex,
		originPrice,
		destination,
		destinationIndex,
		destinationPrice;

	originIndex = $('select[name="origin"] option:selected').val();
	destinationIndex = $('select[name="destination"] option:selected').val();
	origin = window.happyMellyIndex[originIndex];
	destination = window.happyMellyIndex[destinationIndex];

	originPrice = $('#origin-price').val();

	destinationPrice = Math.round(originPrice / origin['ratio'] * destination['ratio']);

	$('#final-currency').html(destination['currency']);
	$('#final-price').html(destinationPrice);
};

var bootstrapMelly = function() {
	$('select[name="origin"]').on('change', function(event) {
		var index,
			country;

		index = $(event.target).find('option:selected').val();
		country = window.happyMellyIndex[index];
		$('#currency').html(country['currency']);
		updateFinalPrice();
	});
	$('select[name="destination"]').on('change', updateFinalPrice);
	$('#origin-price').on('keyup', updateFinalPrice);

	var selects,
		option,
		country;

	selects = $('select');
	for (var index in window.happyMellyIndex) {
		country = window.happyMellyIndex[index];
		if (index == 0) {
			$('#currency').html(country['currency']);
		}
		option = $('<option value="' + index + '">' + country['name'] + '</option>');
		selects.append(option);
	}
	updateFinalPrice();
};