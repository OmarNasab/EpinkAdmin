<?php
if(isset($_GET["id"])){
	
}

?>
<!doctype html>
<html lang='en'>
<head>
  <meta charset='utf-8'>
  <title>PDF GENERATOR</title>

  <script src='https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.40/pdfmake.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.40/vfs_fonts.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js'></script>
  <script src='https://cdn.jsdelivr.net/npm/pdfjs-dist@2.0.385/build/pdf.min.js'></script>


  <style>
  .container {
  padding: 0;
  margin: 0;
  list-style: none;
  
  display: -webkit-box;
  display: -moz-box;
  display: -ms-flexbox;
  display: -webkit-flex;
  display: flex;
  
  -webkit-flex-flow: row wrap;
  justify-content: space-around;
}

.item {
  padding: 5px;
  width: 48%;
  height: 100em;
  margin-top: 10px;
  
  font-weight: bold;
  text-align: center;
}

.vertical-line {
  position: absolute;
  background-color: black;
  width: 2px;
  top: 0px;
  bottom: 0px;
  left: 50%;
  height: 100em;
}
  </style>
</head>
<body>
<div class="container">
<p>Generating PDF</p>
<div id="base64" style="word-wrap: break-word;">
test
</div>
<a id="pdfurl" href="">View</a>
</div>


<script>
var canvasElement = document.getElementById("canvas");

function printPdf(action) {
    var docDefinition = {
			content: [
		'COVID-19 VACCINATION CONSENT FORM ',
		'\n',
		'The COVID-19 vaccine is provided to control the spread of COVID-19 in the country. As the number of those vaccinated increase, so too will the number of those that develop antibodies which will lessen the probability of a more severe illness from COVID-19. Indirectly, we can protect those at risk who are ineligible to receive vaccine injections.',
		'\n',
		'The Special Committee Meeting of the National Muzakarah Meeting Council on Islamic Religious Affairs Malaysia that was held on 3 December 2020 declared that COVID-19 vaccines were permissible and mandatory for those determined by the Government.',
		'\n',
		'The COVID-19 injection vaccines will be administered in either one (1) or two (2) doses according to the type of vaccine. The injection is generally administered into the shoulder muscle except in certain circumstances. The type of vaccine that would be provided is subject to the current vaccine supply.',
		'\n',
		'Receiving COVID-19 vaccines may result in mild side effects and other side effects that may be reported from time to time.',
		'\n',
		'I have read / it as been read to me the information regarding COVID-19 vaccine, its purpose and the method of administration of the vaccine as provided in the COVID-19 Information Sheet for vaccine recipients.',
		'\n',
		'I hereby understand that:',
		'\n',
		'\u200B\t	1. Receiving the COVID-19 vaccines may cause reactions and side effects as stated in the vaccine information;',
		'\u200B\t	2. I am responsible for any risk that may arise as a result of my decision / action in receiving the vaccine as the benefits of the vaccine outweighs its side effects;',
		'\u200B\t	3. The vaccine dose not fully guarantee that I will not be infected with COVID-19 in the future;',
		'\u200B\t	4. By signing this consent to receive the COVID-19 vaccine, I voluntarily agree to complete the number of vaccine doses as scheduled.',
		'\n',
		'\n',
		{ text: '[*]   By signing this consent to receive the COVID-19 vaccine, I voluntarily agree to complete the number of vaccine doses as scheduled.', style: 'header'},
		
		],
		styles: {
			header: {
			  bold: true
			},
			anotherStyle: {
			  italics: true,
			  alignment: 'right'
			}
		  }
    };
    
    if (action === 1) {
        pdfMake.createPdf(docDefinition).getDataUrl(function(dataURL) {
            renderPDF(dataURL, document.getElementById('canvas'));
        });
    }
    else if (action === 2) {
        var pdf = createPdf(docDefinition);
/* 		var pdffile = 'data:application/pdf;base64,'+data;
		document.getElementById("base64").innerHTML = pdffile;
		document.getElementById("pdfurl").href = pdffile; */
		/* createPdf(docDefinition).open({}, window); */
		
/* 		const pdfDocGenerator = createPdf(docDefinition);
		pdfDocGenerator.getDataUrl((dataUrl) => {
			const targetElement = document.querySelector('#iframeContainer');
			const iframe = document.createElement('iframe');
			iframe.src = dataUrl;
			targetElement.appendChild(iframe);
		}); */
		pdf.getBase64((data) => {
		var pdffile = 'data:application/pdf;base64,'+data;
		
	document.getElementById("base64").innerHTML = pdffile;
	document.getElementById("pdfurl").href = pdffile;
});
    }
}





// * this is not important for PDFMake, it's here just to render the result *
// It's a Mozilla lib called PDFjs that handles pdf rendering directly on the browser
function renderPDF(url, canvasContainer, options) {

    options = options || { scale: 1.4 };
        
    function renderPage(page) {
        var viewport = page.getViewport(options.scale);
        var wrapper = document.createElement("div");
        wrapper.className = "canvas-wrapper";
        var canvas = document.createElement('canvas');
        var ctx = canvas.getContext('2d');
        var renderContext = {
          canvasContext: ctx,
          viewport: viewport
        };
        
        canvas.height = viewport.height;
        canvas.width = viewport.width;
        wrapper.appendChild(canvas)
        canvasContainer.appendChild(wrapper);
        
        page.render(renderContext);
    }
    
    function renderPages(pdfDoc) {
        for(var num = 1; num <= pdfDoc.numPages; num++)
            pdfDoc.getPage(num).then(renderPage);
    }

    PDFJS.disableWorker = true;
    PDFJS.getDocument(url).then(renderPages);

}
printPdf(2);
</script>
</body>
</html>