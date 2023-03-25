//Ref
//Modal Title ID "homepagemodaltitle"
//Modal Content ID "homepagemodalcontent"
/**********************/
	/*	Client carousel   */
	/**********************/
	$('.carousel-client').bxSlider({
		auto: true,
	    slideWidth: 234,
	    minSlides: 2,
	    maxSlides: 5,
	    controls: false
	});
console.log("Home loaded");
function prepareGo(page){
	localStorage.setItem("webapplink", page);
	console.log(page);
}

var slideIndex = 0;
showSlides();

function showSlides() {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}
  slides[slideIndex-1].style.display = "block";
  setTimeout(showSlides, 5000); // Change image every 2 seconds
}
var curslide = 1;
function setImage(){

		if(curslide == 1){
			document.getElementById("homepagebg").classList.remove('testbgimage1');
			document.getElementById("homepagebg").classList.add('testbgimage2');
			curslide++
		}else if(curslide == 2){
			document.getElementById("homepagebg").classList.remove('testbgimage2');
			document.getElementById("homepagebg").classList.add('testbgimage3');
			curslide++
		}else if(curslide == 3){
			document.getElementById("homepagebg").classList.remove('testbgimage3');
			document.getElementById("homepagebg").classList.add('testbgimage4');
			curslide++
		}else if(curslide == 4){
			document.getElementById("homepagebg").classList.remove('testbgimage4');
			document.getElementById("homepagebg").classList.add('testbgimage5');
			curslide++
		}else if(curslide == 5){
			document.getElementById("homepagebg").classList.remove('testbgimage5');
			document.getElementById("homepagebg").classList.add('testbgimage1');
			curslide = 1;
		}	
}
setInterval(function(){ setImage(); }, 5000);

