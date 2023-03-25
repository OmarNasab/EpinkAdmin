<?php
if($page_action_identifier != ""){		
	$id = cleanInput($page_action_identifier);
	$c19consentsql = "SELECT * FROM c19consent WHERE icpassport='$id'";
	$c19consentresult = $db->query($c19consentsql);
	if ($c19consentresult->num_rows > 0){
		$row = $c19consentresult->fetch_assoc();
		if($row["medicalhistoryone"] == ""){
			$row["medicalhistoryone"] = '[  ]  Experienced severe side effects (such as seizures, fainting spells, and hospital admissions) after obtaining any previous vaccination(s)?';
		}else{
			$row["medicalhistoryone"] = '[ * ]  Experienced severe side effects (such as seizures, fainting spells, and hospital admissions) after obtaining any previous vaccination(s)?';
		}
		
		if($row["medicalhistorytwo"] == ""){
			$row["medicalhistorytwo"] = '[  ]  Ever had a history of severe allergy?';
		}else{
			$row["medicalhistorytwo"] = '[ * ] Ever had a history of severe allergy?';
		}
		
		if($row["medicalhistorythree"] == ""){
			$row["medicalhistorythree"] = '[  ] Pregnant or planing to conceive (for women)';
		}else{
			$row["medicalhistorythree"] = '[ * ] Pregnant or planing to conceive (for women)';
		}	

		if($row["medicalhistoryfour"] == ""){
			$row["medicalhistoryfour"] = '[  ] Currently breastfeeding? (for women)';
		}else{
			$row["medicalhistoryfour"] = '[ * ] Currently breastfeeding? (for women)';
		}	
		
		if($row["pdf"] == ""){
			echo 'PDF Not generated';
			
			//exit();
			
		}else{
			
			header("location: ".$row["pdf"]);
			
		}
		
	} else {
		echo 'Doest not exist';
		exit();
	}
}else{
	echo 'Doest not exist';
	exit();
}


?>
<!doctype html>
<html lang='en'>
<head>
  <meta charset='utf-8'>
  <title>Generating PDF</title>

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
</div>


<script>
var canvasElement = document.getElementById("canvas");
var serverUrl = 'https://epink.health/api/index.php';
var pid = '<?php echo $page_action_identifier; ?>';
var fullname = '<?php echo $row["name"]; ?>';
var mysejahteraid = '<?php echo $row["mysejahteraid"]; ?>';
var medicalhistoryone = '<?php echo $row["medicalhistoryone"]; ?>';
var medicalhistorytwo = '<?php echo $row["medicalhistorytwo"]; ?>';
var medicalhistorythree = '<?php echo $row["medicalhistorythree"]; ?>';
var medicalhistoryfour = '<?php echo $row["medicalhistoryfour"]; ?>';
var dates = '<?php echo $row["consentdate"]; ?>';
function printPdf(action) {
    var docDefinition = {
			content: [
		{ text: 'COVID-19 VACCINATION CONSENT FORM', style: 'header'},
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
		'Medical History (Please tick relevant fields)',
		''+medicalhistoryone+'',
		''+medicalhistorytwo+'',
		''+medicalhistorythree+'',
		''+medicalhistoryfour+'',
		'\n',
		'\n',
		{ text: '[*]   By signing this consent to receive the COVID-19 vaccine, I voluntarily agree to complete the number of vaccine doses as scheduled.', style: 'header'},
		'Name: '+fullname+'',
		'IC / Passport: '+pid+'',
		'MySejahtera ID: '+mysejahteraid+'',
		'Date: '+dates+'',
		
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
		//pdfMake.createPdf(docDefinition).open({}, window);
		pdf.getBase64((data) => {
			var pdffile = 'data:application/pdf;base64,'+data;
			
			savePdf(pdffile);
		});
    }
}


function savePdf(data){
    var dataTopost = "api=1&id="+pid+"&savePdf="+data;
    var c19consent = new XMLHttpRequest();
    c19consent.open("POST", serverUrl, true);
    c19consent.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    c19consent.onload = function() {
        if (c19consent.status == 200) {
            var json = c19consent.responseText;
            var response = JSON.parse(json);
			if(response.status == "successfull"){
				window.location.href = response.message;
			}
            //loadingResponse(response.message);
        } else if (c19consent.status == 404) {
            alert("Fail to connect to our server");
        } else {
            alert("Fail to connect to our server");
        }
    }
    c19consent.send(dataTopost);
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