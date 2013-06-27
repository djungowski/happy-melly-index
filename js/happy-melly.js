var updateFinalPrice = function() {
	var price,
		currency,
		origin,
		originIndex,
		originPrice,
		destination,
		destinationIndex,
		destinationPrice,
		originPriceError;

	originIndex = $('select[name="origin"] option:selected').val();
	destinationIndex = $('select[name="destination"] option:selected').val();
	origin = window.happyMellyIndex[originIndex];
	destination = window.happyMellyIndex[destinationIndex];
	originPriceError = $('#origin-price-error');

	originPrice =  parseInt($('#origin-price').val());
	// If something crappy was given: use 0
	if (isNaN(originPrice)) {
		originPrice = 0;
		originPriceError.show(100);
	} else {
		originPriceError.hide(100);
	}

	destinationPrice = Math.round(originPrice / origin['ratio'] * destination['ratio']);

	$('#final-currency').html(destination['currency']);
	$('#final-price').html(destinationPrice);
};

var bootstrapAbout = function() {
	var aboutLink,
		aboutParagraph;

	aboutLink = $('#happy-melly-navigation a[href="#about"]');
	aboutParagraph = $('#happy-melly-about');

	aboutLink.on('click', function() {
		aboutParagraph.slideToggle(400);
	});
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
	$('#happy-melly-index-form').on('submit', function(event) {
		event.preventDefault();
	});

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
	bootstrapAbout();
	updateFinalPrice();
};