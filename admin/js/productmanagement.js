function updateSalePrice(elements) {
    var initialPrice = parseFloat(elements.value);
	var initialPrice = initialPrice.toFixed(2);
	var initialPrice = parseFloat(initialPrice);
	var margin = 8 * initialPrice / 100;
	margin = parseFloat(margin);
	var totalprice = initialPrice + margin;
	if(isNaN(totalprice)== false){
		 document.getElementById("totalpricetosell").innerHTML = totalprice.toFixed(2);
		 document.getElementById("vappymarkup").innerHTML = margin.toFixed(2);
		 document.getElementById("totalclientprice").innerHTML = initialPrice.toFixed(2);
	}
}