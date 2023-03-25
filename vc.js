let globalsession;
var session;
var tocall; 
var gs;
var stream;
function initApp(){
	var CREDENTIALS = {
	  appId: 86124,
	  authKey: 'GGJYCyau4MFz49u',
	  authSecret: 'MX9tDPyBpWHPkJX',
	  accountKey: 'FqLTFn_ernioDcYWJQhE',
	  CONFIG: { debug: true }
	};
	QB.init(CREDENTIALS.appId, CREDENTIALS.authKey, CREDENTIALS.authSecret, CREDENTIALS.accountKey);
	//Get current session
	QB.getSession(function (error, session) {
		if(error == null){
			globalsession = session;
			
		}else{
			gs = session;
			QB.createSession(function(error, result) {
				
				var ploging = localStorage.getItem("previouslyloggedin");
				console.log(ploging);
				if(ploging == null){
					document.getElementById("l1").disabled = false; 
					document.getElementById("l2").disabled = false; 
					document.getElementById("logintype").style.display = 'block';
				}else{
					console.log(ploging);
					var logininfo = JSON.parse(ploging);
					document.getElementById("logintype").style.display = 'none';
					document.getElementById("login").value = logininfo.login;
					tocall = localStorage.getItem("tocall");
					document.getElementById("password").value = logininfo.password;
					loginUser();
				}
				
			});
		}
	})
		QB.webrtc.onCallListener = function(session, extension) {  
		console.log('session returned Start'); 
		console.log(session); 
		console.log('session returned End');
		gs = session;
		document.getElementById("usercall").innerHTML = 'Someone is calling you <button onclick="acceptCall()">Accept Call</button> <button onclick="rejectCall()">Reject Call</button>';
		console.log(gs);
	
	}

	QB.webrtc.onAcceptCallListener = function(session, userId, extension) { document.getElementById("usercall").innerHTML = 'You are on a call'; }

	QB.webrtc.onRejectCallListener = function(session, userId, extension) { document.getElementById("usercall").innerHTML = 'Call Rejected'; }

	QB.webrtc.onStopCallListener = function(session, userId, extension) { document.getElementById("usercall").innerHTML = 'Call stoped by you'; }

	QB.webrtc.onUpdateCallListener = function(session, userId, extension) { console.log(session) }

	QB.webrtc.onInvalidEventsListener = function(eventName, session, userId, userInfo) { document.getElementById("usercall").innerHTML = 'Error';}

	QB.webrtc.onUserNotAnswerListener = function(session, userId) {  document.getElementById("usercall").innerHTML = 'Call not answered'; }

	QB.webrtc.onRemoteStreamListener = function(session, userId, stream) {  console.log(session);}

	QB.webrtc.onSessionConnectionStateChangedListener = function(session, userId, connectionState) { document.getElementById("usercall").innerHTML = connectionState; }

	QB.webrtc.onSessionCloseListener = function(session) { console.log('Call session closed');}

	QB.webrtc.onCallStatsReport = function(session, userId, stats, error) { }
}

function logout(){
	localStorage.clear();
	location.reload();
}
function loginAs(utype){
	document.getElementById("logintype").style.display = "none";
	document.getElementById("loginform").style.display = "block";
	if(utype == 1){
		document.getElementById("login").value = 'tester';
		document.getElementById("password").value = 'password';
		tocall = 122265416;
	}else{
		document.getElementById("login").value = 'tester2';
		document.getElementById("password").value = 'password';
		
		tocall = 122265370;
	}

}

var callingauserext = {};
function loginUser(){
	var userName = document.getElementById("login").value;
	var userPassword = document.getElementById("password").value;
	var params = { login:userName, password: userPassword };
	
	var prelogin = JSON.stringify(params);
	
	console.log(prelogin);
	localStorage.setItem("previouslyloggedin", prelogin);
	if(userName == "tester"){
		tocall = 122265416;
	}else{
		tocall = 122265370;
	}
	localStorage.setItem("tocall", tocall);

	QB.createSession(params, function(error, result) {
		if(error == null){
			
			document.getElementById("loginform").style.display = "none";
			document.getElementById("dashboard").style.display = "block";
			
			let uid = result.user_id;
			document.getElementById("loggedinuserid").innerHTML = result.user_id;
			console.log(result);
			
			
			var userCredentials = {
			  userId: uid,
			  password: userPassword
			};

			QB.chat.connect(userCredentials, function(error, contactList) {
				if(error){
					
				}else{
					console.log("connected to chat server");
				}
				
			});
			
			
		}else{
			console.log(error.detail);
		}
	});
	


}


function videoCall(){

	var calleesIds = [tocall]; // Users' ids
	var sessionType = QB.webrtc.CallType.VIDEO; // AUDIO is also possible
	var additionalOptions = {};

	session = QB.webrtc.createNewSession(calleesIds, sessionType, null, additionalOptions);
	
	
	var mediaParams = {
	  audio: true,
	  video: true,
	  options: {
		muted: true,
		mirror: true,
	  },
	  elemId: "localVideoElem",
	};

	session.getUserMedia(mediaParams, function (error, stream) {
		
		
	  if (error) {
		  //if got error
	  } else {
			gstream = stream;
			session.attachMediaStream('myVideoElementId', gstream);
			var extension = {};
			session.call(extension, function(error) {
				document.getElementById("usercall").innerHTML = 'Calling user -'+tocall;
			});
	  }
	});
	
}
//ACTION FUNCTION
function rejectCall(ses){
	var extension = {};
	gs.reject(extension);
	document.getElementById("usercall").innerHTML = '';
}
function acceptCall(session){
	var extension = {};
	document.getElementById("usercall").innerHTML = 'Accepting..';
	console.log(gs);
	var extension = {};
	session = gs;
	gs.accept(extension);
	document.getElementById("usercall").innerHTML = 'Connecting';
}	

function opensearchUser(){
	if(globalsession == null){
		alert("Please login");
	}else{
		document.getElementById("dashboard").style.display = "none";
		document.getElementById("searchuser").style.display = "block";
	}
}

function searchUser(element){
	var nametoSearch = element.value
	var searchParams = {full_name: nametoSearch};
    
	QB.users.get(searchParams, function(error, result) {
		console.log(result);
		if(result != null){
			document.getElementById("searchresult").innerHTML = '';
			userlist = result.items;
			console.log(userlist);

			for (let i = 0; i < userlist.length; i++) {
				usersz = userlist[i];
				console.log(usersz.length);
				for (let j = 0; j < usersz.length; j++) {
					console.log(usersz[j]);
					document.getElementById("searchresult").innerHTML = '<p>'+usersz[j].full_name+'</p>';
				}
				j = 0;
			}
		}
	});
	
}
function registerUser(){
	var userName = document.getElementById("login").value;
	var userPassword = document.getElementById("password").value;
	var params = {
	  login: userName,
	  password: userPassword,
	  full_name: userName
	};

	QB.users.create(params, function(error, result) {
	  if (error) {
			console.log(error);
	  } else {
		  alert("Your account has been created successfully");
	  }
	});
}