<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Support</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Support Request</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
		
			<div id="listing" class="col s6">
				<ul class="list-group">
				  <li class="list-group-item">
					<span class="font-weight-bolder">Support Request</span>
					<span  class="float-right"><a href="#!" class="btn btn-small btn-danger"> Closed</a> <a href="#!" onclick="closeChat()" class="btn btn-small btn-primary"> New</a></a></span>
				  </li>
				  <div id="listrequesthere">
				
				  </div>
				</ul>			
			</div>
			<div id="chat" class="col s6" style="height: 100%; width: 100%; display: none; ">
				<div class="card" style="height: 100%">
				  <div class="card-header" ><span id="clientnamehere">Support Window</span> <span  class="float-right"><a href="#!" onclick="markComplete()"> <i class="far fa-check-circle"></i> Mark Complete</a><a href="#!" onclick="closeChat()"> <i class="far fa-times-circle"></i> Close</a></a></span></div>
				  <div id="chatcontenthere" class="card-body" style="overflow: auto;
max-height: 80vh; height: 100vh;">Select a support request.</div>
				  <div class="card-footer">
				  <form method="POST" onsubmit="replyTocustomer(event)" autocomplete="off">
					<div class="form-group">
						<input id="supportreplyhere" type="text" class="form-control">
					</div>
					<button class="btn btn-primary" type="submit" name="replyss">Reply</button>
				  </div>
				  </form>
				</div>
			</div>
	

	</section>
</div>
<script>
	function listSupport(sts){
		document.getElementById("listrequesthere").innerHTML = '<li class="list-group-item">Loading</li>';
		var dataTopost = 'api=1&auth_token='+authUser.login_token+"&supportlistadmin="+sts;
		var xhr = new XMLHttpRequest();
		xhr.open("POST", serverUrl, true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.onload = function() {
			if (xhr.status == 200) {
				var json = xhr.responseText;
				var response = JSON.parse(json);
				if(response.status == null){
					document.getElementById("listrequesthere").innerHTML = '';
					var i;
					for (i = 0; i < response.length; i++) {
					  document.getElementById("listrequesthere").innerHTML += ' <li class="list-group-item" onclick="openrequestThread('+response[i].id+', '+response[i].owner+', \''+response[i].fullname+'\')"><a href="#!">'+response[i].fullname+' <span class="float-right">'+response[i].ticket_date+'</span></a></li>'; 
					}
				}else{
					 document.getElementById("listrequesthere").innerHTML = ' <li class="list-group-item">No support request</li>'; 
				}
				
			} else if (xhr.status == 404) {
				alert("Fail to connect to our server");
			} else {
				alert("Fail to connect to our server");
			}
		}
		xhr.send(dataTopost);
	}
	var currentchatowner = 0;
	var currentchatid = 0;
	var currentclientname = '';
	function openrequestThread(id, curch, clientname){
		document.getElementById("listing").style.display = "none";
		document.getElementById("chat").style.display = "block";
		currentchatowner = curch;
		currentclientname = clientname;
		currentchatid = id;
		document.getElementById("clientnamehere").innerHTML = clientname+'User id: '+currentchatowner;
		var dataTopost = 'api=1&auth_token='+authUser.login_token+"&opensupport="+id;
		var xhr = new XMLHttpRequest();
		xhr.open("POST", serverUrl, true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.onload = function() {
			if (xhr.status == 200) {
				var json = xhr.responseText;
				var response = JSON.parse(json);
				if(response.status == null){
					document.getElementById("chatcontenthere").innerHTML = '';
					var i;
					for (i = 0; i < response.length; i++){
						if(currentchatowner == response[i].owner){
							
							 document.getElementById("chatcontenthere").innerHTML += '<br><div class="row"><div class="col-6" style="background-color: green; color: white; padding: 10px">'+response[i].message+'</div><div class="col-6"></div></div>'; 
							 
						}else{
							
							 document.getElementById("chatcontenthere").innerHTML += '<br><div class="row"><div class="col-6"></div><div class="col-6" style="background-color: blue; color: white; padding: 10px">'+response[i].message+'</div></div>'; 
							 
						}
					 
					}
				}
				setTimeout(function(){ var curopen = document.getElementById("chat").style.display; if(curopen == "block"){openrequestThread(currentchatid, currentchatowner, currentclientname);} }, 10000);
				
			} else if (xhr.status == 404) {
				alert("Fail to connect to our server");
			} else {
				alert("Fail to connect to our server");
			}
		}
		xhr.send(dataTopost);
	}
	function closeChat(){
		document.getElementById("listing").style.display = "block";
		document.getElementById("chat").style.display = "none";
		listSupport('New');
	}
	
	function markComplete(){
		var dataTopost = 'api=1&auth_token='+authUser.login_token+"&markcomplete="+currentchatid;
		var xhr = new XMLHttpRequest();
		xhr.open("POST", serverUrl, true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.onload = function() {
			if (xhr.status == 200) {
				var json = xhr.responseText;
				var response = JSON.parse(json);
				if(response.status == "Successfull"){
					closeChat();
				}
				
			} else if (xhr.status == 404) {
				alert("Fail to connect to our server");
			} else {
				alert("Fail to connect to our server");
			}
		}
		xhr.send(dataTopost);
	}
	function replyTocustomer(event){
		
		event.preventDefault();
		var replymessage = document.getElementById("supportreplyhere").value;
	
		 var dataTopost = "api=1&auth_token=" + authUser.login_token + "&inserttosupport_content=true&message="+replymessage+"&thread="+currentchatid;
		var xhr = new XMLHttpRequest();
		xhr.open("POST", serverUrl, true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.onload = function() {
			if (xhr.status == 200) {
				var json = xhr.responseText;
				var response = JSON.parse(json);
				if(response.status == "successful"){
					openrequestThread(currentchatid, currentchatowner, currentclientname);
						
						replymessage = '';
				}
				
			} else if (xhr.status == 404) {
				alert("Fail to connect to our server");
			} else {
				alert("Fail to connect to our server");
			}
		}
		xhr.send(dataTopost);
	}
	listSupport('New');
</script>