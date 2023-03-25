<?php
$servername = "localhost";
$username = "epink";
$password = "880208Limitless@";
$dbname = "admin_epink";
$productmargin = 35;
$itemurl = "https://epink.health/api/";
$db = new mysqli($servername, $username, $password, $dbname);
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
echo '<a href="'.$domain.'/genos/">-Back</a><br>';
if($_GET["action"] == "insert"){
if(isset($_GET["table"])){
	$backlink = $_GET["backlink"];
	$table = $_GET["table"];
	$result = $db->query("describe ".$dbname.".".$table."");
	if ($result->num_rows > 0) {
		
		$counter = 2;
		$totalrow = $result->num_rows;
		$rowlist = '';
		$inputlist = '';
		$datas = '';
		$filter = '';
		$formelement = '';
		
		while ($row = $result->fetch_assoc()) {
				if($row["Field"] != "id"){
					if($row["Field"] != "owner"){
						$datas .= '&nbsp &nbsp &nbsp &nbsp $'. $row["Field"] .' = cleanInput($_POST["'. $row["Field"] .'"]);<br>';
						$formelement .= '
&ltdiv class="form-group"&gt
	&ltlabel for="'.$row["Field"].'"&gt'.$row["Field"].'&lt/label&gt
	&ltinput class="form-control" type="text" id="'.$row["Field"].'" name="'.$row["Field"].'"&gt
&lt/div&gt<br>';
$jsformdata .= '&nbsp &nbsp &nbsp &nbspvar '.$row["Field"].' = document.getElementById("'.$row["Field"].'").value;<br>';
					}else{
						$datas .= '&nbsp &nbsp &nbsp &nbsp $'. $row["Field"] .' = $authUser["id"];<br>';

					}
					if($totalrow > $counter){

						$filter .= '$'.$row["Field"].' != "" &&  ';
						$rowlist .= ''. $row["Field"] .', ';  
						$inputlist .= '\'$'. $row["Field"] .'\', ';	
						if($row["Field"] != "owner"){
						$jspostdata .= '&'.$row["Field"].'="+'.$row["Field"].'+"';
						}
						$counter++;
					}else{
						$filter .= '$'.$row["Field"].' != ""';
						$rowlist .= ''. $row["Field"] .'';  
						$inputlist .= '\'$'. $row["Field"] .'\'';
						if($row["Field"] != "owner"){
						$jspostdata .= '&'.$row["Field"].'="+'.$row["Field"].''; 
						}
					}
				}
				
		}
		echo 'Insert to <br>';
		echo '
<b>BACKEND</b><br>
Materialize PHP

<pre>
&lt?php
if(isset($_POST["insertto'.$table.'"])){
	$ownerid = $authUser["id"];
'.$datas.'
	if('.$filter.'){
		$'.$table.'sql = "INSERT INTO '.$table.' ('.$rowlist.')
		VALUES ('.$inputlist.')";

		if ($db->query($'.$table.'sql) === TRUE) {
			$row["card"] = "green";
			$row["status"] = "Successful";
			$row["message"] =  "New record successfully created";
			$data = $row;
		} else {
			$row["card"] = "red";
			$row["status"] = "Fail";
			$row["message"] =  "Error: " . $sql . "&ltbr&gt" . $db->error;
			$data = $row;
		}
	}else{
		$row["card"] = "red";
		$row["status"] = "Fail";
		$row["message"] = "Please fill all the form";
		$data = $row;
	}
}

<b>Javascript</b><br>
<pre>
document.getElementById("insertto'.$table.'").addEventListener("submit", insertTo'.$table.');
function insertTo'.$table.'(){
    event.preventDefault(); 
    showLoading();
	'.$jsformdata.'
    var dataTopost = "api=1&auth_token=" + authUser.login_token + "&insertto'.$table.'=true'.$jspostdata.';
    var '.$table.' = new XMLHttpRequest();
    '.$table.'.open("POST", serverUrl, true);
    '.$table.'.setRequestHeader(\'Content-type\', \'application/x-www-form-urlencoded\');
    '.$table.'.onload = function() {
        if ('.$table.'.status == 200) {
            var json = '.$table.'.responseText;
            var response = JSON.parse(json);
            loadingResponse(response.message);
        } else if ('.$table.'.status == 404) {
            alert("Fail to connect to our server");
        } else {
            alert("Fail to connect to our server");
        }
    }
    '.$table.'.send(dataTopost);
}
</pre>

?&gt
&ltmain&gt
	&ltdiv class="navbar-fixed"&gt
		&ltnav&gt
			&ltdiv class="nav-wrapper white black-text"&gt
				&ltul class="left"&gt
					&ltli&gt&lta href="&lt?php echo $domain; ?&gt/'.$backlink.'/" class="black-text" onclick="showLoading()"&gt&lti class="material-icons  black-text"&gtarrow_back&lt/i&gt&lt/a&gt&lt/li&gt
					&ltli&gt&lta href="#!" class="black-text flow-text strong"&gtBack&lt/a&gt&lt/li&gt
				&lt/ul&gt
			&lt/div&gt
		&lt/nav&gt
	&lt/div&gt
	&ltdiv class="container bot-pad"&gt
			&lth1 class="strong flow-text"&gt Title &lt/h1&gt
			&ltp class="helper"&gt Helper &lt/p&gt
		&lt?php if(isset($data)){
			echo \'
			&ltdiv id="response"&gt
			
	&ltdiv id="action_response" class="card \'.$data["card"].\' darken-1" onclick="removeResponse()"&gt

		&ltdiv class="card-content white-text"&gt
			&ltspan class="card-title"&gt\'.$data["status"].\'&ltspan class="helper right"&gt&lti class="material-icons"&gtclose&lt/i&gt&lt/span&gt&lt/span&gt
			&ltp&gt\'.$data["message"].\'&lt/p&gt
		&lt/div&gt
		
	&lt/div&gt
	&ltbr&gt&ltbr&gt&ltbr&gt
	&lt/div&gt

	\';
		}
		?&gt

&ltform id="insertto'.$table.'" method="POST" action="&lt?php echo $page_url; ?&gt" &gt 
&ltinput type="text" id="csrf" name="csrf" value="&lt? echo $csrftoken; ?&gt" hidden&gt
'.$formelement.'
&ltbutton class="btn black white-text" name="submit'.$table.'" id="submit'.$table.'" type="submit" onclick="showLoading()" &gtSUBMIT&lt/button&gt 
&lt/form&gt




	&lt/div&gt
&lt/main&gt	


<pre>
if(isset($_POST["submit'.$table.'"]) && $_POST["csrf"] == $_SESSION["csrftoken"]){
'.$datas.'
	if('.$filter.'){
		$'.$table.'sql = "INSERT INTO '.$table.' ('.$rowlist.')
		VALUES ('.$inputlist.')";

		if ($db->query($'.$table.'sql) === TRUE) {
			$row["status"] = "successful";
			$row["message"] =  "New record successfully created";
			$data = $row;
		} else {
			$row["status"] = "fail";
			$row["message"] =  "Error: " . $sql . "&ltbr&gt" . $db->error;
			$data = $row;
		}
	}else{
		$row["status"] = "fail";
		$row["message"] = "Please fill all the form";
		$data = $row;
	}
}
<pre>

API<br>
<pre>
if(isset($_POST["submit'.$table.'"])){
'.$datas.'
	if('.$filter.'){
		$'.$table.'sql = "INSERT INTO '.$table.' ('.$rowlist.')
		VALUES ('.$inputlist.')";

		if ($db->query($'.$table.'sql) === TRUE) {
			$row["status"] = "successful";
			$row["message"] =  "New record successfully created";
			$data = $row;
		} else {
			$row["status"] = "fail";
			$row["message"] =  "Error: " . $sql . "&ltbr&gt" . $db->error;
			$data = $row;
		}
	}else{
		$row["status"] = "fail";
		$row["message"] = "Please fill all the form";
		$data = $row;
	}
}
<pre>
<b>FRONTEND</b><br>
<b>Form</b><br>
<pre>
&ltform id="insertto'.$table.'" method="POST" action="&lt?php echo $page_url; ?&gt" &gt 
&ltinput type="text" id="csrf" name="csrf" value="&lt? echo $csrftoken; ?&gt" hidden&gt
'.$formelement.'
&ltbutton class="btn black white-text" name="submit'.$table.'" id="submit'.$table.'" type="submit"&gtSUBMIT&lt/button&gt
&lt/form&gt
</pre>

<pre>
<b>JS FRONTEND</b><br>
<b>Form</b><br>
<pre>
&ltform id="insertto'.$table.'" method="POST" &gt 

'.$formelement.'
&ltbutton class="btn black white-text" name="submit'.$table.'" id="submit'.$table.'" type="submit"&gtSUBMIT&lt/button&gt
&lt/form&gt
</pre>


		';
	}else{
		echo 'Table not found';
	}
}else{
	echo 'What would you like to do?';
}

}elseif($_GET["action"] == "edit"){
	$backlink = $_GET["backlink"];
	if(isset($_GET["table"])){
		$table = $_GET["table"];
		$result = $db->query("describe ".$dbname.".".$table."");
		$counter = 2;
		$totalrow = $result->num_rows;
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				if($row["Field"] != "id"){
					if($totalrow > $counter){
						$datatoupdate .= "".$row["Field"]."='$".$row["Field"]."', ";
						$variablestoendter .= '$'.$row["Field"].' = cleanInput($_POST["edit'.$row["Field"].'"]);<br>';
						
												$formelement .= '
&ltdiv class="form-group"&gt
	&ltlabel for="edit'.$row["Field"].'"&gt'.$row["Field"].'&lt/label&gt
	&ltinput type="text" class="form-control" id="edit'.$row["Field"].'" name="edit'.$row["Field"].'"&gt
&lt/div&gt<br>';
												$formelementphp .= '
&ltdiv class="form-group"&gt
	&ltlabel for="edit'.$row["Field"].'"&gt'.$row["Field"].'&lt/label&gt
	&ltinput type="text" id="edit'.$row["Field"].'" class="form-control" name="edit'.$row["Field"].'" value="&lt?php echo $'.$table.'object["'.$row["Field"].'"]; ?&gt"&gt
&lt/div&gt<br>';

$jsvariable .= 'var '.$row["Field"].' = document.getElementById("edit'.$row["Field"].'").value;<br>';
$jspostdata .= '&edit'.$row["Field"].'="+'.$row["Field"].'+"';
						
					
						$counter++;
					}else{
						
						$datatoupdate .= "".$row["Field"]."='$".$row["Field"]."'";
						$variablestoendter .= '$'.$row["Field"].' = cleanInput($_POST["edit'.$row["Field"].'"]);';
												$formelement .= '
&ltdiv class="input-field"&gt
	&ltlabel for="edit'.$row["Field"].'"&gt'.$row["Field"].'&lt/label&gt
	&ltinput type="text" id="edit'.$row["Field"].'" name="edit'.$row["Field"].'"&gt
&lt/div&gt<br>';
												$formelementphp .= '
&ltdiv class="input-field"&gt
	&ltlabel for="edit'.$row["Field"].'"&gt'.$row["Field"].'&lt/label&gt
	&ltinput type="text" id="edit'.$row["Field"].'" name="edit'.$row["Field"].'" value="&lt?php echo $'.$table.'object["'.$row["Field"].'"]; ?&gt"&gt
&lt/div&gt<br>';
$jsvariable .= 'var '.$row["Field"].' = document.getElementById("edit'.$row["Field"].'").value;';
						$jspostdata .= '&edit'.$row["Field"].'="+'.$row["Field"].'';
						
					}
				}
			}
echo '
MATERIALIZE PHP

<pre>
&lt?php

if(isset($_POST["submitupdate'.$table.'"]) &&  $_POST["csrf"] == $_SESSION["csrftoken"]){
$id = cleanInput($_POST["editid"]);
$owner = $authUser["id"];
'.$variablestoendter.'
	$sql = "UPDATE '.$table.' SET '.$datatoupdate.' WHERE  id=\'$id\' ";

	if ($db-&gtquery($sql) === TRUE) {
		$row["card"] = "green";
		$row["status"] = "Successfull";
		$row["message"] = "The record has been updated successfully";
		$data = $row;
	} else {
		$row["card"] = "red";
		$row["status"] = "Fail";
		$row["message"] = "Error updating record: " . $db-&gterror;
		$data = $row;
	}
}

$id = cleanInput($page_identifier_action);
$'.$table.'sql = "SELECT * FROM '.$table.' WHERE id=\'$id\'";
$'.$table.'result = $db-&gtquery($'.$table.'sql);
if ($'.$table.'result-&gtnum_rows &gt 0){
	$row = $'.$table.'result-&gtfetch_assoc();
	$'.$table.'object = $row;
} else {
	$row["card"] = "red";
	$row["status"] = "Fail";
	$row["message"] = "The record you looking for does not exist &ltscript&gtwindow.location.href= \'\'.$domain.\'404\';  &lt/script&gt";
	$data = $row;
}

?&gt
 &lt!-- Content Wrapper. Contains page content --&gt
  &ltdiv class="content-wrapper"&gt
    &lt!-- Content Header (Page header) --&gt
    &ltsection class="content-header"&gt
      &ltdiv class="container-fluid"&gt
        &ltdiv class="row mb-2"&gt
          &ltdiv class="col-sm-6"&gt
            &lth1&gtEstablishement manager&lt/h1&gt
          &lt/div&gt
          &ltdiv class="col-sm-6"&gt
            &ltol class="breadcrumb float-sm-right"&gt
              &ltli class="breadcrumb-item active"&gtEstablishement manager&lt/li&gt
            &lt/ol&gt
          &lt/div&gt
        &lt/div&gt
      &lt/div&gt&lt!-- /.container-fluid --&gt
    &lt/section&gt
    &ltsection class="content"&gt
	&ltdiv class="container-fluid"&gt


		&lt?php if(isset($data)){
			echo \'
			&ltdiv id="response"&gt
			
	&ltdiv id="action_response" class="card \'.$data["card"].\' darken-1" onclick="removeResponse()"&gt

		&ltdiv class="card-content white-text"&gt
			&ltspan class="card-title"&gt\'.$data["status"].\'&ltspan class="helper right"&gt&lti class="material-icons"&gtclose&lt/i&gt&lt/span&gt&lt/span&gt
			&ltp&gt\'.$data["message"].\'&lt/p&gt
		&lt/div&gt
		
	&lt/div&gt
	&ltbr&gt&ltbr&gt&ltbr&gt
	&lt/div&gt

	\';
		}
		?&gt
&ltform id="edit'.$table.'" method="POST" action="&lt?php echo $page_url; ?&gt" &gt
&ltinput type="text" id="csrf" name="csrf" value="&lt? echo $csrftoken; ?&gt" hidden&gt
&ltinput type="text" id="editid" name="editid" value="&lt? echo $'.$table.'object["id"]; ?&gt" hidden&gt
	'.$formelementphp.'
&ltbutton class="btn blue white-text" name="submitupdate'.$table.'" id="submitupdate'.$table.'" type="submit"&gtSubmit&lt/button&gt
&lt/form&gt
	&lt/div&gt
&lt/section&gt	
&lt/div&gt

</pre>
Back End<br>
<pre>

</pre>
<pre>
if(isset($_POST["submitupdate'.$table.'"]) &&  $_POST["csrf"] == $_SESSION["csrftoken"]){
$id = cleanInput($_POST["editid"]);
$owner = $authUser["id"];
'.$variablestoendter.'
	$sql = "UPDATE '.$table.' SET '.$datatoupdate.' WHERE  id=\'$id\' ";

	if ($db->query($sql) === TRUE) {
		$row["card"] = "green";
		$row["status"] = "Successfull";
		$row["message"] = "The record has been updated successfully";
		$data = $row;
	} else {
		$row["card"] = "red";
		$row["status"] = "Fail";
		$row["message"] = "Error updating record: " . $db->error;
		$data = $row;
	}
}

$id = cleanInput($page_action_identifier);
$'.$table.'sql = "SELECT * FROM '.$table.' WHERE permalink=\'$id\'";
$'.$table.'result = $db->query($'.$table.'sql);
if ($'.$table.'result->num_rows > 0){
	$row = $'.$table.'result->fetch_assoc();
	$'.$table.'object = $row;
} else {
	$row["card"] = "red";
	$row["status"] = "Fail";
	$row["message"] = "The record you looking for does not exist&ltscript&gtwindow.location.href= \'\'.$domain.\'404\';&lt/script&gt";
	$data = $row;
}
</pre>
Materialize Front End
<pre>
&ltform id="edit'.$table.'" method="POST" action="&lt?php echo $page_url; ?&gt" &gt
	'.$formelement.'
&ltbutton class="btn black white-text" name="submitedit'.$table.'" id="submitupdate'.$table.'" type="submit"&gtSubmit&lt/button&gt
&lt/form&gt

</pre>
Materialize Front End use PHP
<pre>
&ltform id="edit'.$table.'" method="POST" action="&lt?php echo $page_url; ?&gt" &gt
&ltinput type="text" id="csrf" name="csrf" value="&lt? echo $csrftoken; ?&gt" hidden&gt
&ltinput type="text" id="editid" name="editid" value="&lt? echo $'.$table.'object["id"]; ?&gt" hidden&gt
	'.$formelementphp.'
&ltbutton class="btn black white-text" name="submitupdate'.$table.'" id="submitupdate'.$table.'" type="submit"&gtSubmit&lt/button&gt
&lt/form&gt

</pre>
Javascript
<pre>
document.getElementById("edit'.$table.'").addEventListener("submit", editTable'.$table.');
function editTable'.$table.'(id){
event.preventDefault();
var recordId = id;
'.$jsvariable.'
var dataTopost = "api=1&auth_token=" + authUser.login_token + "&edit'.$table.'="+recordId+"'.$jspostdata.';
    var '.$table.' = new XMLHttpRequest();
    '.$table.'.open("POST", serverUrl, true);
    '.$table.'.setRequestHeader(\'Content-type\', \'application/x-www-form-urlencoded\');
    '.$table.'.onload = function() {
        if ('.$table.'.status == 200) {
            var json = '.$table.'.responseText;
            var response = JSON.parse(json);
            loadingResponse(response.message);
        } else if ('.$table.'.status == 404) {
            alert("Fail to connect to our server");
        } else {
            alert("Fail to connect to our server");
        }
    }
    '.$table.'.send(dataTopost);
}
</pre>
';
		}else{
			echo 'Table not found';
		}
	}else{
		
	echo 'What would you like to do?';
	}
	
}elseif($_GET["action"] == "viewall"){
	if(isset($_GET["table"])){
		$table = $_GET["table"];
		$result = $db->query("describe ".$dbname.".".$table."");
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$tableview .= " &ltp&gt".$row["Field"]." : '+response[i].".$row["Field"]."+'&lt/p&gt";
				$th = ucfirst(str_replace("_", " ", $row["Field"]));
				$tableheader .= '
				&ltdiv class="col s2 strong"&gt
					'.$th.'
				&lt/div&gt
				';
				
				$tablecontent .= '
				&ltdiv class="col s2 strong"&gt
					\'.$'.$table.'object["'.$row["Field"].'"].\'
				&lt/div&gt
				';
			}
$backlink = $_GET["backlink"];
echo '
<b>MATERIALIZE PHP</b><br>
<pre>
&ltmain&gt
	&ltdiv class="container bot-pad"&gt
	
		&lth1 class="strong flow-text"&gt Title &lta href="create/" class="btn-small blue white-text right"&gtNew&lt/a&gt&lt/h1&gt
		&ltp class="helper"&gtThis is a helper for this page&lt/p&gt
		
		&ltdiv class="row"&gt
		'.$tableheader.'
		&ltdiv class="col s2 strong"&gt
			Action
		&lt/div&gt
		&lt/div&gt
&lt?php
$'.$table.'sql = "SELECT * FROM '.$table.'";
$'.$table.'result = $db-&gtquery($'.$table.'sql);

if ($'.$table.'result-&gtnum_rows &gt 0) {
 
    while($'.$table.'object = $'.$table.'result-&gtfetch_assoc()) {
		echo \'&ltdiv class="row"&gt\';
		echo \' 
		
		'.$tablecontent .'
		
		\';
		echo \'
		&ltdiv class="col s2 strong"&gt
			&lta href="\'.$domain.\'/'.$backlink.'/view/\'.$'.$table.'object["permalink"].\'/"&gtView&lt/a&gt
			&lta href="\'.$domain.\'/'.$backlink.'/update/\'.$'.$table.'object["permalink"].\'/"&gtUpdate&lt/a&gt
			&lta href="\'.$domain.\'/'.$backlink.'/delete/\'.$'.$table.'object["permalink"].\'/"&gtDelete&lt/a&gt
		&lt/div&gt
		\';
		echo \'&lt/div&gt\';
    }
	
} else {
    echo "0 results";
}
?&gt
	&lt/div&gt
&lt/main&gt
</pre>
';			
			
echo '
<b>Front end</b></br>
<pre>
&ltul id="viewall'.$table.'" class="collection"&gt
	
&lt/ul&gt
</pre>
<br>


<pre>
function retrive'.$table.'(){
    var dataTopost = "api=1&auth_token=" + authUser.login_token + "&viewall'.$table.'=true";
    var '.$table.' = new XMLHttpRequest();
    '.$table.'.open("POST", serverUrl, true);
    '.$table.'.setRequestHeader(\'Content-type\', \'application/x-www-form-urlencoded\');
    '.$table.'.onload = function() {
        if ('.$table.'.status == 200) {
            var json = '.$table.'.responseText;
            var response = JSON.parse(json);
			var i;
			document.getElementById("viewall'.$table.'").innerHTML ="";
				for (i = 0; i < response.length; i++) {
					document.getElementById("viewall'.$table.'").innerHTML += \'&ltli&gt'.$tableview.'&lt/li&gt\';
				}
            loadingResponse(response.message);
        } else if ('.$table.'.status == 404) {
            alert("Fail to connect to our server");
        } else {
            alert("Fail to connect to our server");
        }
    }
    '.$table.'.send(dataTopost);
}
</pre>

<b>Back end</b><br>
<pre>
if(isset($_POST["viewall'.$table.'"])){
	$sql = "SELECT * FROM '.$table.'";
	$result = $db->query($sql);

	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
	} else {
		$row["status"] = "fail";
		$row["message"] = "Database is empty";
		$data = $row;
	}
}
</pre>
';
		}else{
			echo 'Table not found';
		}
	}else{
		
	echo 'What would you like to do?';
	}
}elseif($_GET["action"] == "viewthis"){
	$backlink = $_GET["backlink"];
	if(isset($_GET["table"])){
		$table = $_GET["table"];
		$result = $db->query("describe ".$dbname.".".$table."");
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$tableview .= " &ltp&gt".$row["Field"]." : '+response[i].".$row["Field"]."+'&lt/p&gt";
				if($row["Field"] != "id" && $row["Field"] != "password"){
					$responsetable .= "&ltp&gt'+response.".$row["Field"]."+'&lt/p&gt";
					$curname = ucfirst($row["Field"]);
					$curname = str_replace('_', ' ', $curname);
					$phpviewrow .= '&ltp&gt'.$curname.':&lt?php echo $'.$table.'data["'.$row["Field"].'"]; ?&gt&lt/p&gt<br>';
					$tableviews .= '&lttr&gt
										&lttd&gt 
										'.$curname.'
										&lt/td&gt 
										&lttd&gt 
										&lt?php echo $'.$table.'data["'.$row["Field"].'"]; ?&gt
										&lt/td&gt 
									&lt/tr&gt';
					//addedithere
				}
			}
			echo '
Material <br>

<pre>
&lt?php
	$id = cleanInput($page_action_identifier);
	$'.$table.'sql = "SELECT * FROM '.$table.' WHERE id=\'$id\'";
	$'.$table.'result = $db-&gtquery($'.$table.'sql);
	if ($'.$table.'result-&gtnum_rows &gt 0){
		$row = $'.$table.'result-&gtfetch_assoc();
		$'.$table.'data = $row;
		
	} else {
		$row["card"] = "red";
		$row["status"] = "Fail";
		$row["message"] = "The record you looking for does not exist&ltscript&gtwindow.location.href= \'\'.$domain.\'/404\';&lt/script&gt";
		$data = $row;
	}
?&gt
&ltmain&gt
	&ltdiv class="navbar-fixed"&gt
		&ltnav&gt
			&ltdiv class="nav-wrapper white black-text"&gt
				
				&ltul class="left"&gt
					&ltli&gt&lta href="&lt?php echo $domain; ?&gt/'.$backlink.'/" class="black-text" onclick="showLoading()"&gt&lti class="material-icons  black-text"&gtarrow_back&lt/i&gt&lt/a&gt&lt/li&gt
					&ltli&gt&lta href="#!" class="black-text flow-text strong"&gtBack&lt/a&gt&lt/li&gt
				&lt/ul&gt

			&lt/div&gt
		&lt/nav&gt
	&lt/div&gt
	&ltdiv class="container bot-pad"&gt
			&lth1 class="strong flow-text"&gt Title &lt/h1&gt
			&ltp class="helper"&gt Helper  &ltspan class="right"&gt &lta href="&lt?php echo $domain ?&gt/'.$backlink.'/update/&lt?php echo $'.$table.'data["permalink"]; ?&gt" class="btn blue btn-small white-text"&gt Update &lt/a&gt  &lt/span&gt &lt/p&gt
		&lt?php if(isset($data)){
			echo \'
			&ltdiv id="response"&gt
			
	&ltdiv id="action_response" class="card \'.$data["card"].\' darken-1" onclick="removeResponse()"&gt

		&ltdiv class="card-content white-text"&gt
			&ltspan class="card-title"&gt\'.$data["status"].\'&ltspan class="helper right"&gt&lti class="material-icons"&gtclose&lt/i&gt&lt/span&gt&lt/span&gt
			&ltp&gt\'.$data["message"].\'&lt/p&gt
		&lt/div&gt
		
	&lt/div&gt
	&ltbr&gt&ltbr&gt&ltbr&gt
	&lt/div&gt

	\';
		}
		?&gt
	&lttable class="table-responsive" &gt
		&ltthead&gt
			&lttr&gt
				&ltth&gtField&lt/th&gt
				&ltth&gtContent&lt/th&gt
			&lt/tr&gt
		&lt/thead&gt

		&lttbody&gt
		   '.$tableviews.'
		&lt/tbody&gt
	&lt/table&gt
	&lt/div&gt
&lt/main&gt	
</pre>
Back end <br>
<pre>
if(isset($_POST["viewThis'.$table.'"])){
	$id = cleanInput($page_action_identifier);
	$'.$table.'sql = "SELECT * FROM '.$table.' WHERE permalink=\'$id\'";
	$'.$table.'result = $db->query($'.$table.'sql);
	if ($'.$table.'result->num_rows > 0){
		$row = $'.$table.'result->fetch_assoc();
		$'.$table.'data = $row;
		
	} else {
		$row["card"] = "red";
		$row["status"] = "Fail";
		$row["message"] = "The record you looking for does not exist&ltscript&gtwindow.location.href= \'\'.$domain.\'/404\';&lt/script&gt";
		$data = $row;
	}
}
Front end</br>
<pre>
'.$phpviewrow.'
<br>
<p>Table</p>
<br>
&lttable class="table-responsive" &gt
    &ltthead&gt
        &lttr&gt
            &ltth&gtField&lt/th&gt
            &ltth&gtContent&lt/th&gt
        &lt/tr&gt
    &lt/thead&gt

    &lttbody&gt
       '.$tableviews.'
    &lt/tbody&gt
&lt/table&gt

&ltbutton id="viewthis'.$table.'button" onclick="viewThis'.$table.'(rid)"&gt Get item &lt/button&gt
Data here
&ltdiv id="viewThis'.$table.'"&gt
&lt/div&gt

</pre>
Javascript</br>
function viewThis'.$table.'(id){
	
    var dataTopost = "api=1&auth_token=" + authUser.login_token + "&viewThis'.$table.'="+id;
    var '.$table.' = new XMLHttpRequest();
    '.$table.'.open("POST", serverUrl, true);
    '.$table.'.setRequestHeader(\'Content-type\', \'application/x-www-form-urlencoded\');
    '.$table.'.onload = function() {
        if ('.$table.'.status == 200) {
            var json = '.$table.'.responseText;
            var response = JSON.parse(json);
			console.log("'.$responsetable.'");
            loadingResponse(response.message);
        } else if ('.$table.'.status == 404) {
            alert("Fail to connect to our server");
        } else {
            alert("Fail to connect to our server");
        }
    }
    '.$table.'.send(dataTopost);
}
';
		}else{
			
		}
		
	}else{
		
	}
	
}elseif($_GET["action"] == "delete"){
	$backlink = $_GET["backlink"];
	if(isset($_GET["table"])){
		$table = $_GET["table"];
		$result = $db->query("describe ".$dbname.".".$table."");
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				if($row["Field"] != "id"){
					$responsetable .= "&ltp&gt'+response.".$row["Field"]."+'&lt/p&gt";
				}
			}
			echo '
<pre>
if(isset($_POST["delete'.$table.'"])){
	$owner = $authUser["id"];
	$id = cleanInput($page_action_identifier);
	$sql = "DELETE FROM '.$table.' WHERE id=\'$id\' AND owner=\'$owner\'";
	if ($db->query($sql) === TRUE) {
		$row["status"] = "success";
		$row["message"] = \'The record has been deleted successfully document.getElementById("deleteform").style.display = "none" &ltscript&gt\';
		$data = $row;
	} else {
		$row["status"] = "fail";
		$row["message"] = "Error deleting record: " . $db->error;
		$data = $row;
	}	
}

<br><b>MATERIALIZE PHP</p><br>
&lt?php
if(isset($_POST["delete'.$table.'"]) &&  $_POST["csrf"] == $_SESSION["csrftoken"]){
	$id = cleanInput($page_action_identifier);
	$sql = "DELETE FROM '.$table.' WHERE permalink=\'$id\'";
	if ($db-&gtquery($sql) === TRUE) {
		$row["card"] = "green";
		$row["status"] = "Success";
		$row["message"] = \'The record has been deleted successfully &ltscript&gtdocument.getElementById("deleteform").style.display = "none"; document.getElementById("pagetitle").style.display = "none"; document.getElementById("pageheader").style.display = "none"; &lt/script&gt\';
		$data = $row;
	} else {
		$row["card"] = "red";
		$row["status"] = "Fail";
		$row["message"] = "Error deleting record: " . $db-&gterror;
		$data = $row;
	}	
}
?&gt
&ltmain&gt
	&ltdiv class="navbar-fixed"&gt
		&ltnav&gt
			&ltdiv class="nav-wrapper white black-text"&gt
				
				&ltul class="left"&gt
					&ltli&gt&lta href="&lt?php echo $domain; ?&gt/'.$backlink.'/" class="black-text" onclick="showLoading()"&gt&lti class="material-icons  black-text"&gtarrow_back&lt/i&gt&lt/a&gt&lt/li&gt
					&ltli&gt&lta href="#!" class="black-text flow-text strong"&gtBack&lt/a&gt&lt/li&gt
				&lt/ul&gt

			&lt/div&gt
		&lt/nav&gt
	&lt/div&gt
	&ltdiv class="container bot-pad"&gt
			&lth1 id="pagehelper" class="strong flow-text"&gt Delete '.$table.' &lt/h1&gt
			&ltp id="pagetitle" class="helper"&gt Are you sure about deleting this &lt/p&gt
		&lt?php if(isset($data)){
			echo \'
			&ltdiv id="response"&gt
			
	&ltdiv id="action_response" class="card \'.$data["card"].\' darken-1" onclick="removeResponse()"&gt

		&ltdiv class="card-content white-text"&gt
			&ltspan class="card-title"&gt\'.$data["status"].\'&ltspan class="helper right"&gt&lti class="material-icons"&gtclose&lt/i&gt&lt/span&gt&lt/span&gt
			&ltp&gt\'.$data["message"].\'&lt/p&gt
		&lt/div&gt
		
	&lt/div&gt
	&ltbr&gt&ltbr&gt&ltbr&gt
	&lt/div&gt

	\';
		}
		?&gt
		&ltform id="deleteform" method="POST" action="&lt?php echo $page_url; ?&gt" &gt
&ltinput type="text" id="csrf" name="csrf" value="&lt? echo $csrftoken; ?&gt" hidden&gt
&ltinput type="text" id="deleteid" name="deleteid" value="&lt? echo cleanInput($page_action_identifier); ?&gt" hidden&gt
&ltbutton type="submit" id="delete'.$table.'" name="delete'.$table.'" class="btn white-text blue strong"&gtYes &lt/button&gt &lta href="&lt?php echo $domain; ?&gt/'.$backlink.'/" class="btn white-text blue strong" &gtNo&lt/a&gt
&ltform&gt
	&lt/div&gt
&lt/main&gt
	
</pre>
Front end<br>
<pre>
&ltbutton id="viewthis'.$table.'button" onclick="delete'.$table.'(1)"&gt Delete &lt/button&gt
</pre>
<pre>
Javascript</br>
function deleteFrom'.$table.'(id){
    var dataTopost = "api=1&auth_token=" + authUser.login_token + "&deleteFrom'.$table.'="+id;
    var '.$table.' = new XMLHttpRequest();
    '.$table.'.open("POST", serverUrl, true);
    '.$table.'.setRequestHeader(\'Content-type\', \'application/x-www-form-urlencoded\');
    '.$table.'.onload = function() {
        if ('.$table.'.status == 200) {
            var json = '.$table.'.responseText;
            var response = JSON.parse(json);
            loadingResponse(response.message);
        } else if ('.$table.'.status == 404) {
            alert("Fail to connect to our server");
        } else {
            alert("Fail to connect to our server");
        }
    }
    '.$table.'.send(dataTopost);
}
</pre>
	';
		}else{
			echo 'Table not found';
		}
	}else{
		echo 'What are you looking for';
	}	
}


?>