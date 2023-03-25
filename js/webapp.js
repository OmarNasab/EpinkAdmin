					var serverUrl = "https://epink.health/api/guest.php";
					
					function setFilter(element){
						let value = element.innerHTML;
						document.getElementById("filterbutton").innerHTML = value;
						if(value == "Name"){
							document.getElementById("searchinput").placeholder  = "Search for service provider";
						}else if(value == "Category"){
							document.getElementById("searchinput").placeholder  = "Search for service provider";
						}
						
					}
					function initSearch(element){
					var typeofsearch = document.getElementById("filterbutton").innerHTML;
					var searchterm = element.value;
					var dataTopost = "searchterm="+searchterm+"&type="+typeofsearch;
					var ecare_services = new XMLHttpRequest();
					ecare_services.open("POST", serverUrl, true);
					ecare_services.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
					ecare_services.onload = function() {
						if (ecare_services.status == 200) {
							var json = ecare_services.responseText;
							var response = JSON.parse(json);
							document.getElementById("searchresult").innerHTML = '<div class="col-md-6 col-xl-4 mb-5">Searching for "'+searchterm+'"</div>';
							if(response.status == null){
								var i;
								document.getElementById("searchresult").innerHTML ='';
								searchedMed = response;
							
								for (i = 0; i < response.length; i++) {
									var productdetail = JSON.stringify(response[i]);
									document.getElementById("searchresult").innerHTML += ' <div class="col-md-6 col-xl-4 mb-5"> <div class="card card-team"> <div class="card-body"> <img class="card-team-img mb-3" src="'+response[i].profile_img+'" alt="'+response[i].fullname+' Profile Picture"> <div class="card-team-name">'+response[i].fullname+'</div> <div class="card-team-position mb-3">'+response[i].provider_type+'</div> <p class="small mb-0">'+response[i].organization_name+'</p> </div> <div class="card-footer text-center d-grid gap-2"> <a href="" class="btn epink-btn-primary btn-sm">View Profile</a> </div> </div> </div>';
								}
							}else{
								document.getElementById("searchresult").innerHTML ='<div class="col-md-6 col-xl-12 mb-5">Nothing found related to "'+searchterm+'"</div>';
							}
						} else if (ecare_services.status == 404) {
							alert("Fail to connect to our server");
						} else {
							alert("Fail to connect to our server");
						}
					}
					ecare_services.send(dataTopost);
				}
				
				function setWebappTarget(target, id){
					storage.setItem("webapptarget", target);
					storage.setItem("webapptargetid", id);
				}