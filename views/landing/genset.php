<?php
if(isset($_GET["table"])){
	$table = cleanInput($_GET["table"]);
	$result = $db->query("describe ".$dbname.".".$table."");
	if ($result->num_rows > 0) {
		$array = '';
		while ($row = $result->fetch_assoc()) {
			if($row["Field"] != "id"){
				$array .= "'".$row["Field"]."', ";
			}
		}
	}
}


?>
<section class="bg-white">
<div class="container bg-white">
<form id="" method="POST" onsubmit="insertToarray(event)" >

<p>Table Name</p>
<input type="text" class="form-control" id="tablename" value="<?php echo $_GET["table"]; ?>"><br>
<div id="availabletable">


</div>
<p>Table Row</p>
<div class="input-group mb-3">
	<input type="text" id="table" class="form-control" placeholder="" aria-label="" aria-describedby="button-addon1">
	<button class="btn btn-outline-secondary" type="submit" id="button-addon1">Button</button>
</div>

</form>
<div id="arraycontroller">


</div>
<p>Form </p>
<p>Php Update Code </p>
<textarea id="phpupdatecode" col="100" rows="10" width="100vw" style="width: 100%; max-width: 100%;">
</textarea>
<p>Form</p>
<textarea id="xde" col="100" rows="10" width="100vw" style="width: 100%; max-width: 100%;" value="">

</textarea>
<p>Data Base </p>
<textarea id="sqlcode" col="100" rows="10" width="100vw" style="width: 100%; max-width: 100%;">

</textarea>
<p>Php Select Code </p>
<textarea id="phpselectcode" col="100" rows="10" width="100vw" style="width: 100%; max-width: 100%;">

</textarea>
<p>Php Insert Code </p>
<textarea id="phpcode" col="100" rows="10" width="100vw" style="width: 100%; max-width: 100%;">

</textarea>
<script>
	var forms = [];
	var avail = [<?php echo $array; ?>];
	function insertToarray(event){
		event.preventDefault();
		var toAdd = document.getElementById("table").value;
		forms.push(toAdd);
		console.log(forms);
		if (!forms.includes(toAdd)) {
			forms.push(toAdd);
		}else{
		
		}
		renderArray();
	}
	function renderAvailable(){
		for (let i = 0; i < avail.length; i++){
		document.getElementById("availabletable").innerHTML += '<a class="badge badge-marketing bg-primary-soft rounded-pill text-primary mb-3" href="#!" onclick="insertAvailableToarray(\''+avail[i]+'\')">'+avail[i]+'</a> ';
		}
	}
	
	function insertAvailableToarray(toAdd){
		if(!forms.includes(toAdd)) {
				forms.push(toAdd);
		}else{
			alert("Already added");
		}
		renderArray();
	}
	function renderArray(){
		document.getElementById("arraycontroller").innerHTML = '';
		var tablename = document.getElementById("tablename").value;
		document.getElementById("xde").value = '<div class="container">\n    &lt?php \n    if(isset($response)){\n         echo $response; \n    } \n    ?&gt\n    <form method="POST">\n';
		document.getElementById("sqlcode").value = 'CREATE TABLE '+tablename+' (\n    id int NOT NULL AUTO_INCREMENT,\n';
		var totalArrat = forms.length;
		var currentArrat = 1;
		var variabletoInsert = '';
		var variablevalue = '';
		var variableCodevalue = '';
		var issetCode = '';
		var upCode = '';
		document.getElementById("phpcode").value = '';
		for (let i = 0; i < forms.length; i++){
			document.getElementById("arraycontroller").innerHTML += '<span class="badge badge-marketing bg-primary-soft rounded-pill text-primary mb-3">'+forms[i]+' <a href="#!" onclick="deleteArray('+i+')">x</a> </span> ';
			var codename = forms[i].replaceAll(' ', '_');
			var codename = forms[i].replaceAll('/', '_');
			var codename = codename.toLowerCase();
			document.getElementById("xde").value += '        <div class="form-group">\n            <label>'+forms[i]+'</label>\n            <input type="text" class="form-control" id="'+codename+'" name="'+codename+'">\n        </div>\n';
			document.getElementById("sqlcode").value += '    '+codename+' TEXT, \n';
			variabletoInsert += '        $'+codename+' = cleanInput($_POST["'+codename+'"]);\n';
			if(totalArrat >  currentArrat){
				variablevalue += ''+codename+', ';
				variableCodevalue += '\'$'+codename+'\', ';
				issetCode += '$'+codename+' != "" && ';
				upCode += ' '+codename+' = \'$'+codename+'\', ';
				currentArrat++;
			}else{
				variablevalue += ''+codename+'';
				variableCodevalue += '\'$'+codename+'\'';
				issetCode += '$'+codename+' != ""';
				upCode += ' '+codename+' = \'$'+codename+'\' ';
			}
		}
		document.getElementById("phpupdatecode").value  = '';
		document.getElementById("xde").value += '        <button type="submit" name="form-submit">Submit</button>\n    </form>\n</div>';
		document.getElementById("sqlcode").value += '    PRIMARY KEY (id) \n);';
		document.getElementById("phpcode").value += '&lt?php \n    if(isset($_POST["form-submit"])){\n';
		document.getElementById("phpcode").value += ''+variabletoInsert;
		document.getElementById("phpcode").value += '\n        $sql = "INSERT INTO '+tablename+' ';
		document.getElementById("phpcode").value += '('+variablevalue+')';
		document.getElementById("phpcode").value += ' VALUES ('+variableCodevalue+')";';
		document.getElementById("phpcode").value += '\n        \n        if ($db->query($sql) === TRUE) {\n            $response = "Your submission has been submitted successfully"; \n        }else{\n            $response = "Error: " . $sql . "<br>" . $db->error; \n    	}';
		document.getElementById("phpcode").value += '\n    } \n?&gt';
		
		var allcode = document.getElementById("phpcode").value;
		var allcodes = allcode.replaceAll('&lt', '<');
		var allcodes = allcodes.replaceAll('&gt', '>');
		document.getElementById("phpcode").value = allcodes;
		document.getElementById("phpselectcode").value = '';
		document.getElementById("phpselectcode").value  += 'if(isset($_POST["'+tablename+'"])){\n';
		document.getElementById("phpselectcode").value  += '    $sql = "SELECT * FROM '+tablename+'";\n';
		document.getElementById("phpselectcode").value  += '    if ($result->num_rows > 0) {';
		document.getElementById("phpselectcode").value  += '\n}';
		
		document.getElementById("phpupdatecode").value  += 'if(isset($_POST["'+tablename+'"])){\n';
		document.getElementById("phpupdatecode").value  += variabletoInsert;
		document.getElementById("phpupdatecode").value  += '\n        if('+issetCode+'){';
		document.getElementById("phpupdatecode").value  += '\n                $sql = "UPDATE '+tablename+' SET'+upCode+' WHERE id=\'$id\'";';
		document.getElementById("phpupdatecode").value  += '\n                if ($db->query($sql) === TRUE) {';
		document.getElementById("phpupdatecode").value  += '\n                        $response = \'Your submission has been submitted successfully\'; ';
		document.getElementById("phpupdatecode").value  += '\n                }else{';
		document.getElementById("phpupdatecode").value  += '\n                        $response = \'Error updating record\';';
		
		document.getElementById("phpupdatecode").value  += '\n                }';		
		
		document.getElementById("phpupdatecode").value  += '\n        }else{';
		document.getElementById("phpupdatecode").value  += '\n                $response=\'Please fill all the form\'; ';
		document.getElementById("phpupdatecode").value  += '\n        }';
		document.getElementById("phpupdatecode").value  += '\n}';
		
	}
	function deleteArray(id){
		forms.splice(id, 1);
		console.log(forms);
		renderArray();
	}
	renderAvailable();
</script>
</div>
</section>