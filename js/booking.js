//Covid 19 test global variable
var totalprice;
var distancetype;
var pack = 1;
var pcrDefaultprice = 170.00;
var rpcrDefaultprice = 300.00;
var artDefaultPrice = 50.00;
var selectedTest = null;
var walkInSelection = null;
var price = '{"art-default-price":"100.00", "pcr-default-price":"100.00", "art-default-price-walkin":"100.00", "homevisit-art-default-price":"100.00"}';

//Vaccination Globaal Variable
var selectedVaccine; 
var vtotalprice;
var isFree = false;

//Quarantin Global Variable
var selectedQPackage;
var qtotalprice;
var goxyPrice = 0.00;
var goxyrentalPrice = 0.00
var rehabPrice = 0;
//Code start here
function updateCoprateWellness(){
	var typeofservices = document.getElementById("typeofservices").value;
	var copack = document.getElementById("copack").value;
	var companyemail = document.getElementById("companyemail").value;
	var companyname = document.getElementById("companyname").value;
	
	var bookingdata = { service_type: typeofservices, service_pack: copack, company_name: companyname}
	if(typeofservices != "" && copack != "" && companyemail != "" && companyname != ""){
		document.getElementById("booking_data").value = JSON.stringify(bookingdata);
	}
}
function getQuarantineData(){
	
}
var oxyfirstcheck = "unchecked";
function rehabpackChange(){
	var rehabpack = document.getElementById("rehab_total_pack").value;
	if(selectRehabTime == 1){
		rehabtotalprice = rehabpack * rehabPrice;
		var packnameValue = '1 Month';
	}else if(selectRehabTime == 2){
		rehabtotalprice = rehabpack * rehabPrice;
		var packnameValue = '2 Month';
	}else if(selectRehabTime == 3){
		rehabtotalprice = rehabpack * rehabPrice;
		var packnameValue = '3 Month';
	}
	document.getElementById("rehab_total_price").value = rehabtotalprice;
	document.getElementById("final_total_price").value = rehabtotalprice;
	var bookingData = { pack: rehabpack, packname: packnameValue }
	document.getElementById("booking_data").value = JSON.stringify(bookingData);
	
}
function selectRehabOne(){
	var elem = document.getElementById("selectRehabOne");
    elem.classList.add("epink-bg-primary");
    elem.classList.add("text-white");
    var elem2 = document.getElementById("selectRehabTwo");
    elem2.classList.remove("epink-bg-primary");
    elem2.classList.remove("text-white");
    var elem3 = document.getElementById("selectRehabThree");
    elem3.classList.remove("epink-bg-primary");
    elem3.classList.remove("text-white");	
	selectRehabTime = 1;
	rehabPrice = 250;
	rehabpackChange();
}
function selectRehabTwo(){
	var elem = document.getElementById("selectRehabTwo");
    elem.classList.add("epink-bg-primary");
    elem.classList.add("text-white");
    var elem2 = document.getElementById("selectRehabOne");
    elem2.classList.remove("epink-bg-primary");
    elem2.classList.remove("text-white");
    var elem3 = document.getElementById("selectRehabThree");
    elem3.classList.remove("epink-bg-primary");
    elem3.classList.remove("text-white");	
	selectRehabTime = 2;
	rehabPrice = 500;
	rehabpackChange();
}
function selectRehabThree(){
	var elem = document.getElementById("selectRehabThree");
    elem.classList.add("epink-bg-primary");
    elem.classList.add("text-white");
    var elem2 = document.getElementById("selectRehabTwo");
    elem2.classList.remove("epink-bg-primary");
    elem2.classList.remove("text-white");
    var elem3 = document.getElementById("selectRehabOne");
    elem3.classList.remove("epink-bg-primary");
    elem3.classList.remove("text-white");	
	selectRehabTime = 3;
	rehabPrice = 750;
	rehabpackChange();
}
var oxyRentalData;
function getrentalPrice(){
	var litre = document.getElementById("renttanklitre").value;
	var duration = document.getElementById("tankrentalduration").value;
	var depo = 0.00;
	var rentalprice = 0.00;
	if(litre == "3 Litre"){
		depo = 700;
	}else if(litre == "5 Litre"){
		depo = 1125;
	}else if(litre == "10 Litre"){
		depo = 2250;
	}else{
		depo = 0;
	}
	
	if(duration == "1"){
		rentalprice = 100;
	}else if(duration == "2"){
		rentalprice = 200;
	}else if(duration == "3"){
		rentalprice = 300;
	}else{
		rentalprice = 0;
	}
	goxyrentalPrice = depo + rentalprice;
	var rentalData =  {};
	rentalData.litre = litre;
	rentalData.duration = duration;
	oxyRentalData = rentalData;
	qCheckPrice();
	document.getElementById("totalpriceforrental").value = goxyrentalPrice;
}
var Oxytankprice = {};
function setOxyprice(oxyprice){
	goxyPrice = oxyprice;
	if(oxyprice == 900){
		Oxytankprice.tank = "3 Litre";
	}else if(oxyprice == 1500){
		Oxytankprice.tank = "5 Litre";
	}else if(oxyprice == 3000){
		Oxytankprice.tank = "10 Litre";
	}
	qCheckPrice();
}
function openTankSaleoption(){
	if(oxyfirstcheck == "unchecked"){
		document.getElementById("tanksaleoption").style.display = "block";
		oxyfirstcheck = "checked";
		qCheckPrice();
	}else{
		goxyPrice = 0.00;
		document.getElementById("3litre").checked = false;
		document.getElementById("5litre").checked = false;
		document.getElementById("10litre").checked = false;
		document.getElementById("tanksaleoption").style.display = "none";
		oxyfirstcheck = "unchecked"; 
		qCheckPrice();
	}	
}

function openTankRentaloption(){
	if(oxyfirstcheck == "unchecked"){
		document.getElementById("rentaltanksaleoption").style.display = "block";
		oxyfirstcheck = "checked";
		qCheckPrice();
	}else{
		goxyPrice = 0.00;
		document.getElementById("rentaltanksaleoption").style.display = "none";
		oxyfirstcheck = "unchecked"; 
		qCheckPrice();
	}	
}

//Code start here
var rentaloxyfirstcheck = "unchecked";
function setOxyprice(oxyprice){
	goxyPrice = oxyprice;
	qCheckPrice();
}
function rentalopenTankSaleoption(){
	if(rentaloxyfirstcheck == "unchecked"){
		document.getElementById("rentaltanksaleoption").style.display = "block";
		oxyfirstcheck = "checked";
		qCheckPrice();
	}else{
		goxyPrice = 0.00;
		document.getElementById("3litre").checked = false;
		document.getElementById("5litre").checked = false;
		document.getElementById("10litre").checked = false;
		document.getElementById("tanksaleoption").style.display = "none";
		oxyfirstcheck = "unchecked"; 
		qCheckPrice();
	}	
}
function qCheckPrice(){
	var pricecheck = 0.00;
	if(selectedQPackage == "basic"){
		pricecheck = pricecheck + 299.00;
	}else if(selectedQPackage == "medium"){
		pricecheck = pricecheck + 499.00;
	}else if(selectedQPackage == "premium"){
		pricecheck = pricecheck + 999.00;
	}else if(selectedQPackage == ""){
		pricecheck = pricecheck + 0.00;
	}
	var totalPack = document.getElementById("qtotal_pack").value;
	pricecheck = totalPack * pricecheck;
	var addon = {};
	if(document.getElementById('Thermometer').checked){
        pricecheck = pricecheck + 80;
		addon.thermometer = true;
    }
	if(document.getElementById('Oximeter').checked){
        pricecheck = pricecheck + 55;
		addon.oximeter = true;
    }	
	if(document.getElementById('Spirometer').checked){
        pricecheck = pricecheck + 50;
		addon.Spirometer = true;
    }	
	if(document.getElementById('BPmachine').checked){
        pricecheck = pricecheck + 125;
		addon.BPmachine = true;
    }
	if(document.getElementById('RT-PCRTest').checked){
        pricecheck = pricecheck + 220;
		addon.RTPCRTest = true;
    }
	if(document.getElementById('RTK-AntigenTest').checked){
        pricecheck = pricecheck + 120;
		addon.RTKAntigenTest = true;
    }
	if(document.getElementById('Sanitizer').checked){
        pricecheck = pricecheck + 20;
		addon.RTKAntigenTest = true;
    }	
	if(document.getElementById('Immunebooster').checked){
        pricecheck = pricecheck + 100;
		addon.Immunebooster = true;
    }
	if(document.getElementById('Portableoxygeninhaler').checked){
        pricecheck = pricecheck + 250;
		addon.Portableoxygeninhaler = true;
    }
	if(document.getElementById('Homesanitization').checked){
        pricecheck = pricecheck + 350;
		addon.Homesanitization = true;
    }	
	if(document.getElementById('Healthscreeningtest').checked){
        pricecheck = pricecheck + 220;
		addon.Healthscreeningtest = true;
    }
	if(document.getElementById('OxygenTank').checked){
        pricecheck = pricecheck + goxyPrice;
		addon.OxygenTank = Oxytankprice;
    }
	if(document.getElementById('Oxygentankrental').checked){
        pricecheck = pricecheck + goxyrentalPrice;
		addon.Oxygentankrental = oxyRentalData;
		
    }
	document.getElementById("qtotal_price").value = pricecheck;
	qtotalprice = pricecheck;
	document.getElementById("final_total_price").value = qtotalprice;
	var address = document.getElementById("qaddress").value;
	var city = document.getElementById("qcity").value;
	var state = document.getElementById("qstate").value;
	var postcode = document.getElementById("qpostcode").value;
	var country = document.getElementById("qcountry").value;
	var fulladdress = address+', '+city+', '+postcode+', '+state+', '+country;
	var booking_date = { address: fulladdress, addondata: addon, selectedPackage:selectedQPackage  }
	document.getElementById("booking_data").value = JSON.stringify(booking_date);	
}
function qselectBasic(){
	
	var elem = document.getElementById("basicQ");
    elem.classList.add("epink-bg-primary");
    elem.classList.add("text-white");
    var elem2 = document.getElementById("mediumQ");
    elem2.classList.remove("epink-bg-primary");
    elem2.classList.remove("text-white");
    var elem3 = document.getElementById("premQ");
    elem3.classList.remove("epink-bg-primary");
    elem3.classList.remove("text-white");	
	selectedQPackage = "basic";
	qCheckPrice();
	
}

function qselectMedium(){
	
	var elem = document.getElementById("mediumQ");
    elem.classList.add("epink-bg-primary");
    elem.classList.add("text-white");
    var elem2 = document.getElementById("basicQ");
    elem2.classList.remove("epink-bg-primary");
    elem2.classList.remove("text-white");
    var elem3 = document.getElementById("premQ");
    elem3.classList.remove("epink-bg-primary");
    elem3.classList.remove("text-white");	
	selectedQPackage = "medium";
	qCheckPrice();
	
}

function qselectPrem(){
	
	var elem = document.getElementById("premQ");
    elem.classList.add("epink-bg-primary");
    elem.classList.add("text-white");
    var elem2 = document.getElementById("basicQ");
    elem2.classList.remove("epink-bg-primary");
    elem2.classList.remove("text-white");
    var elem3 = document.getElementById("mediumQ");
    elem3.classList.remove("epink-bg-primary");
    elem3.classList.remove("text-white");	
	selectedQPackage = "premium";
	qCheckPrice();
	
}

function qSelectWalkin(){
	var elem = document.getElementById("qselectWalkin");
    elem.classList.add("epink-bg-primary");
    elem.classList.add("text-white");
    var elem2 = document.getElementById("qselectHomepisit");
    elem2.classList.remove("epink-bg-primary");
    elem2.classList.remove("text-white");
	document.getElementById("qhomepisitaddress").style.display = "none";
	document.getElementById("qwalkingaddress").style.display = "block";
}

function qSelectHomepisit(){
	var elem = document.getElementById("qselectHomepisit");
    elem.classList.add("epink-bg-primary");
    elem.classList.add("text-white");
    var elem2 = document.getElementById("qselectWalkin");
    elem2.classList.remove("epink-bg-primary");
    elem2.classList.remove("text-white");
	document.getElementById("qhomepisitaddress").style.display = "block";
	document.getElementById("qwalkingaddress").style.display = "none";
}
function getPostVacData(){
	
	document.getElementById("")
	var PostVacData = {
		
	}
}
function pchangeStation(elem){
    var elemvalue = elem.value;
    if (elemvalue == "ePink HQ"){
        document.getElementById("pepinkaddress").innerHTML = '2nd Floor, Space U8, 1-03-02, mall, Persiaran Pasak Bumi, Bukit Jelutong, 40150 Shah Alam, Selangor';
        walkInSelection = '2nd Floor, Space U8, 1-03-02, mall, Persiaran Pasak Bumi, Bukit Jelutong, 40150 Shah Alam, Selangor';
    }else if(elemvalue == "ePink Partner"){
        document.getElementById("pepinkaddress").innerHTML = 'Not Set';
        walkInSelection = 'Not Set';
    }else{
        document.getElementById("pepinkaddress").innerHTML = 'Not Set';
        walkInSelection = 'Not Set';
    }
	antibodytestdata = {type: 'walkin', address: walkInSelection};
	document.getElementById("booking_data").value = JSON.stringify(antibodytestdata);
}
var antibodytestdata = {};
var postvaccinationpriceWalkin = 110;
var postvaccinationpriceHomevisit = 120;
var selectedCoprateservices = [];
function selectCoprateService(elemment, selectedservice){
	var picked = elemment;
	if(picked.classList.contains("epink-bg-primary") == false){
		picked.classList.add("epink-bg-primary");
		picked.classList.add("text-white");
		selectedCoprateservices.push(selectedservice);
		console.log(selectedCoprateservices);
	}else{
		picked.classList.remove("epink-bg-primary");
		picked.classList.remove("text-white");
		selectedCoprateservices.splice(selectedservice);
	
		
	}
	console.log(selectedCoprateservices);
	
   
}
function pSelectWalkin(){
	var elem = document.getElementById("pselectWalkin");
    elem.classList.add("epink-bg-primary");
    elem.classList.add("text-white");
    var elem2 = document.getElementById("pselectHomepisit");
    elem2.classList.remove("epink-bg-primary");
    elem2.classList.remove("text-white");
	document.getElementById("phomepisitaddress").style.display = "none";
	document.getElementById("pwalkingaddress").style.display = "block";
	document.getElementById("postvacprice").innerHTML = "RM "+postvaccinationpriceWalkin;
	document.getElementById("final_total_price").value = postvaccinationpriceWalkin
	zaddress = 'Not Set';
	antibodytestdata = {type: 'Walk In', address:zaddress };
}
function updatePostvacdata(){
		var vaddress = document.getElementById("paddress").value;
		var vcity = document.getElementById("pcity").value;
		var vpostcode = document.getElementById("ppostcode").value;
		var vstate = document.getElementById("pstate").value;
		var vcountry = document.getElementById("pcountry").value;
		vacaddress = vaddress+', '+vcity+', '+vstate+', '+vpostcode+','+vcountry;
		antibodytestdata = {type: 'Home Visit', address: vacaddress};
		document.getElementById("booking_data").value = JSON.stringify(antibodytestdata);
		
}
function pSelectHomepisit(){
	var elem = document.getElementById("pselectHomepisit");
    elem.classList.add("epink-bg-primary");
    elem.classList.add("text-white");
    var elem2 = document.getElementById("pselectWalkin");
    elem2.classList.remove("epink-bg-primary");
    elem2.classList.remove("text-white");
	document.getElementById("phomepisitaddress").style.display = "block";
	document.getElementById("pwalkingaddress").style.display = "none";
	document.getElementById("postvacprice").innerHTML = "RM "+postvaccinationpriceHomevisit;
	document.getElementById("final_total_price").value = postvaccinationpriceHomevisit;
}
var vacaddress;
function getVacData(){
	var pack = document.getElementById("vtotal_pack").value;
	if(vaccinelocation == "Home Visit"){
		var vaddress = document.getElementById("vaddress").value;
		var vcity = document.getElementById("vcity").value;
		var vpostcode = document.getElementById("vpostcode").value;
		var vstate = document.getElementById("vstate").value;
		var vcountry = document.getElementById("vcountry").value;
		vacaddress = vaddress+', '+vcity+', '+vpostcode+', '+vstate+', '+vcountry;
	}
	var vacData = { 
		typeofvac : selectedVaccine,
		packofvac : pack,
		locationtype : vaccinelocation,
		locationaddress : vacaddress,
	}
	document.getElementById("booking_data").value = JSON.stringify(vacData);
	vpackChange();
	document.getElementById("covidvaccination").style.display = "none";
	document.getElementById("bookingformmain").style.display = "block";
	document.getElementById("final_total_price").value = vtotalprice;
	document.getElementById("booking_type").value = 'COVID-19 Vaccination';
	
}
function vpackChange() {
    var pack = document.getElementById("vtotal_pack").value;
	
    if (selectedVaccine == "SINOVAC") {
		
        vtotalprice = pack * 109.00;
	
    } else if (selectedVaccine == "FreeSINOVAC") {
        vtotalprice = pack * 0.00;
    }else if(selectedVaccine == "PFIZER"){
		vtotalprice = pack * 0.00;
	}
    document.getElementById("vtotal_price").value = parseFloat(vtotalprice);
	document.getElementById("final_total_price").value = parseFloat(vtotalprice);
}
function vchangeStation(elem){
    var elemvalue = elem.value;
    if (elemvalue == "ePink HQ"){
        document.getElementById("vepinkaddress").innerHTML = '2nd Floor, Space U8, 1-03-02, mall, Persiaran Pasak Bumi, Bukit Jelutong, 40150 Shah Alam, Selangor';
        walkInSelection = '2nd Floor, Space U8, 1-03-02, mall, Persiaran Pasak Bumi, Bukit Jelutong, 40150 Shah Alam, Selangor';
    }else if(elemvalue == "ePink Partner"){
        document.getElementById("vepinkaddress").innerHTML = 'Not Set';
        walkInSelection = 'Not Set';
    }else{
        document.getElementById("vepinkaddress").innerHTML = 'Not Set';
        walkInSelection = 'Not Set';
    }
	vacaddress = walkInSelection;
}
var vaccinelocation;
function vSelectWalkin(){
	var elem = document.getElementById("vselectWalkin");
    elem.classList.add("epink-bg-primary");
    elem.classList.add("text-white");
    var elem2 = document.getElementById("vselectHomeVisit");
    elem2.classList.remove("epink-bg-primary");
    elem2.classList.remove("text-white");
	document.getElementById("vhomevisitaddress").style.display = "none";
	document.getElementById("vwalkingaddress").style.display = "block";
	vaccinelocation = 'Walk In';
}
function vSelectHomevisit(){
	var elem = document.getElementById("vselectHomeVisit");
    elem.classList.add("epink-bg-primary");
    elem.classList.add("text-white");
    var elem2 = document.getElementById("vselectWalkin");
    elem2.classList.remove("epink-bg-primary");
    elem2.classList.remove("text-white");
	document.getElementById("vhomevisitaddress").style.display = "block";
	document.getElementById("vwalkingaddress").style.display = "none";
	vaccinelocation = 'Home Visit';
	var vaddress = document.getElementById("vaddress").value;
	var vcity = document.getElementById("vcity").value;
	var vpostcode = document.getElementById("vpostcode").value;
	var vstate = document.getElementById("vstate").value;
	var vcountry = document.getElementById("vcountry").value;
	vacaddress = vaddress+', '+vcity+', '+vpostcode+', '+vstate+', '+vcountry;
}
function vSelectSINOVAC(){
	var elem = document.getElementById("sinovacSelected");
    elem.classList.add("epink-bg-primary");
    elem.classList.add("text-white");
    var elem2 = document.getElementById("sinovacFreeSelected");
    elem2.classList.remove("epink-bg-primary");
    elem2.classList.remove("text-white");
    var elem3 = document.getElementById("sinovacPFIZER");
    elem3.classList.remove("epink-bg-primary");
    elem3.classList.remove("text-white");
	selectedVaccine = "SINOVAC";
	vpackChange();

}

function vSelectFreeSINOVAC(){
	
	var elem = document.getElementById("sinovacFreeSelected");
    elem.classList.add("epink-bg-primary");
    elem.classList.add("text-white");
    var elem2 = document.getElementById("sinovacSelected");
    elem2.classList.remove("epink-bg-primary");
    elem2.classList.remove("text-white");
    var elem3 = document.getElementById("sinovacPFIZER");
    elem3.classList.remove("epink-bg-primary");
    elem3.classList.remove("text-white");	
	selectedVaccine = "FreeSINOVAC";
	vpackChange();
}

function vSelectPFIZER(){
	
	var elem = document.getElementById("sinovacPFIZER");
    elem.classList.add("epink-bg-primary");
    elem.classList.add("text-white");
    var elem2 = document.getElementById("sinovacSelected");
    elem2.classList.remove("epink-bg-primary");
    elem2.classList.remove("text-white");
    var elem3 = document.getElementById("sinovacFreeSelected");
    elem3.classList.remove("epink-bg-primary");
    elem3.classList.remove("text-white");	
	selectedVaccine = "PFIZER";
	vpackChange();
}


function finalizeOrder(){
	var datas = getAlldata();
	if(datas == false){
		document.getElementById("response").innerHTML = '<div class="card mb-5 mt-5 bg-danger text-white"><div class="card-body">Please complete the form</div></div>';
	}else{
		document.getElementById("booking_data").value = datas;
		document.getElementById("response").innerHTML = '';
		document.getElementById("covidtest").style.display = "none";
		document.getElementById("bookingformmain").style.display = "block";
	}
}
function getAlldata(){
    var fulladdress = null;
    var pack = document.getElementById("total_pack").value;
    var address = document.getElementById("address").value;
    var postcode = document.getElementById("postcode").value;
    var city = document.getElementById("city").value;
    var state = document.getElementById("state").value;
    var country = document.getElementById("country").value;
    var country = document.getElementById("country").value;
    var fulladdress = address + ', ' + city + ', ' + postcode + ', ' + state + ', ' + country;
	var canProceed;
	if(distancetype == "homevisit"){
		walkInSelection = fulladdress;
	}
    if (distancetype == null || walkInSelection == null) {
		document.getElementById("response").innerHTML = '<div class="card mb-5 mt-5 bg-danger text-white"><div class="card-body">Please complete the form</div></div>';
		topFunction();
		
    } else {
		document.getElementById("final_total_price").value = totalprice;
        var bookingData = {
            testType: selectedTest,
            testLocation: distancetype,
            testWalkinselection: walkInSelection,
            testTotalPrice: totalprice,
            testTotalPack: pack,
            testAddress: fulladdress
        }
		var data = JSON.stringify(bookingData);
		console.log(data);
		document.getElementById("booking_data").value = data;
		document.getElementById("response").innerHTML = '';
		document.getElementById("covidtest").style.display = "none";
		document.getElementById("bookingformmain").style.display = "block";		
    }
	

}

function packChange() {
    var pack = document.getElementById("total_pack").value;

    if (selectedTest == "PCR") {
        totalprice = pack * parseFloat(pcrDefaultprice);
    } else if (selectedTest == "ART") {
        totalprice = pack * parseFloat(artDefaultPrice);
    } else if(selectedTest == "RPCR"){
		 totalprice = pack * parseFloat(rpcrDefaultprice);
	}
    document.getElementById("total_price").value = parseFloat(totalprice);
}

function changeStation(elem) {
    var elemvalue = elem.value;
    if (elemvalue == "ePink HQ") {
        document.getElementById("epinkaddress").innerHTML = '2nd Floor, Space U8, 1-03-02, mall, Persiaran Pasak Bumi, Bukit Jelutong, 40150 Shah Alam, Selangor';
        walkInSelection = '2nd Floor, Space U8, 1-03-02, mall, Persiaran Pasak Bumi, Bukit Jelutong, 40150 Shah Alam, Selangor';
    } else if (elemvalue == "ePink Partner") {
        document.getElementById("epinkaddress").innerHTML = 'Not Set';
        walkInSelection = 'Not Set';
    } else {
        document.getElementById("epinkaddress").innerHTML = 'Not Set';
        walkInSelection = 'Not Set';
    }
}

function selectWalkin() {
    var elem = document.getElementById("selectWalkin");
    elem.classList.add("epink-bg-primary");
    elem.classList.add("text-white");
    var elem2 = document.getElementById("selectHomeVisit");
    elem2.classList.remove("epink-bg-primary");
    elem2.classList.remove("text-white");
    distancetype = "walkin";
    document.getElementById("homevisitaddress").style.display = "none";
    document.getElementById("walkingaddress").style.display = "block";
	document.getElementById("RPCRview").innerHTML ='<center><strong>Rapid PCR</strong><p>RM300.00</p></center>';
}

function selectHomevisit(place) {
	if(place == "S"){
		var elem = document.getElementById("selectHomeVisit");
		elem.classList.add("epink-bg-primary");
		elem.classList.add("text-white");
		
		var elem2 = document.getElementById("selectWalkin");
		elem2.classList.remove("epink-bg-primary");
		elem2.classList.remove("text-white");
		
		var elem2 = document.getElementById("selectHomeVisitN");
		elem2.classList.remove("epink-bg-primary");
		elem2.classList.remove("text-white");		
		
		distancetype = "homevisit";
		document.getElementById("homevisitaddress").style.display = "block";
		document.getElementById("walkingaddress").style.display = "none";
		artDefaultPrice = 80
		pcrDefaultprice = 280
		rpcrDefaultprice = 370
		document.getElementById("ARTview").innerHTML = '<center><strong>ART</strong><p>RM' + artDefaultPrice + '</p></center>';
		document.getElementById("PCRview").innerHTML = '<center><strong>PCR</strong><p>RM' + pcrDefaultprice + '</p></center>';
		document.getElementById("RPCRview").innerHTML = '<center><strong>Rapid PCR</strong><p>RM' + rpcrDefaultprice + '</p></center>';
		packChange();
	}else{
		var elem = document.getElementById("selectHomeVisit");
		elem.classList.remove("epink-bg-primary");
		elem.classList.remove("text-white");
		
		var elem2 = document.getElementById("selectWalkin");
		elem2.classList.remove("epink-bg-primary");
		elem2.classList.remove("text-white");
		
		var elem2 = document.getElementById("selectHomeVisitN");
		elem2.classList.add("epink-bg-primary");
		elem2.classList.add("text-white");		
		
		distancetype = "homevisit";
		document.getElementById("homevisitaddress").style.display = "block";
		document.getElementById("walkingaddress").style.display = "none";
		artDefaultPrice = 150
		pcrDefaultprice = 370
		rpcrDefaultprice = 450
		document.getElementById("ARTview").innerHTML = '<center><strong>ART</strong><p>RM' + artDefaultPrice + '</p></center>';
		document.getElementById("PCRview").innerHTML = '<center><strong>PCR</strong><p>RM' + pcrDefaultprice + '</p></center>';
		document.getElementById("RPCRview").innerHTML = '<center><strong>PCR</strong><p>RM' + rpcrDefaultprice + '</p></center>';
		packChange();
		
	}

}

function selecctPCR(elem) {
    selectedTest = "PCR";
    var elem = document.getElementById("pcrselected");
    elem.classList.add("epink-bg-primary");
    elem.classList.add("text-white");
    var elem2 = document.getElementById("artselected");
    elem2.classList.remove("epink-bg-primary");
    elem2.classList.remove("text-white");   
	var elem3 = document.getElementById("rpcrselected");
    elem3.classList.remove("epink-bg-primary");
    elem3.classList.remove("text-white");
    packChange();
}

function selecctRPCR(elem) {
    selectedTest = "RPCR";
    var elem = document.getElementById("pcrselected");
    elem.classList.remove("epink-bg-primary");
    elem.classList.remove("text-white");
    var elem2 = document.getElementById("artselected");
    elem2.classList.remove("epink-bg-primary");
    elem2.classList.remove("text-white");
	var elem3 = document.getElementById("rpcrselected");
    elem3.classList.add("epink-bg-primary");
    elem3.classList.add("text-white");
    packChange();
}

function selecctART(elem) {
    selectedTest = "ART";
    var elem = document.getElementById("pcrselected");
    elem.classList.remove("epink-bg-primary");
    elem.classList.remove("text-white");
    var elem2 = document.getElementById("artselected");
    elem2.classList.add("epink-bg-primary");
    elem2.classList.add("text-white");
	var elem3 = document.getElementById("rpcrselected");
    elem3.classList.remove("epink-bg-primary");
    elem3.classList.remove("text-white");
    packChange();
}

function updateFormData(elem, target) {
    var value = elem.value;
    localStorage.setItem(target, value);
}

function innitBookingpagedetail() {
    let name = localStorage.getItem("name");
    document.getElementById("name").value = name;
    let ic_passport = localStorage.getItem("ic_passport");
    document.getElementById("ic_passport").value = ic_passport;
    let email = localStorage.getItem("email");
    document.getElementById("email").value = email;
    let phone_number = localStorage.getItem("phone_number");
    let address = localStorage.getItem("address");
    document.getElementById("address").value = address;
    let city = localStorage.getItem("city");
    document.getElementById("city").value = city;
    let postcode = localStorage.getItem("postcode");
    document.getElementById("postcode").value = postcode;
    document.getElementById("phone_number").value = phone_number;
    document.getElementById("PCRview").innerHTML = '<center><strong>PCR</strong><p>RM' + pcrDefaultprice + '</p></center>';
    document.getElementById("RPCRview").innerHTML = '<center><strong>Rapid PCR</strong><p>RM' + rpcrDefaultprice + '</p></center>';
    document.getElementById("ARTview").innerHTML = '<center><strong>ART</strong><p>RM' + artDefaultPrice + '</p></center>';
	let vaddress = localStorage.getItem("vaddress");
    document.getElementById("vaddress").value = vaddress;
    let vcity = localStorage.getItem("vcity");
    document.getElementById("vcity").value = vcity;
    let vpostcode = localStorage.getItem("vpostcode");
    document.getElementById("vpostcode").value = vpostcode;
	let vstate = localStorage.getItem("vstate");
    document.getElementById("vstate").value = vstate;
	
	let qaddress = localStorage.getItem("qaddress");
    document.getElementById("qaddress").value = qaddress;
    let qcity = localStorage.getItem("qcity");
    document.getElementById("qcity").value = qcity;
    let qpostcode = localStorage.getItem("qpostcode");
    document.getElementById("qpostcode").value = qpostcode;
	let qstate = localStorage.getItem("qstate");
    document.getElementById("qstate").value = qstate;


}
innitBookingpagedetail();

/* function checkForm(event) {
    event.preventDefault();
	var bookingdata = getAlldata();
	if (bookingdata == false) {
		document.getElementById("response").innerHTML = '<div class="card mb-5 mt-5 bg-danger text-white"><div class="card-body">Please complete the form</div></div>';
		return false;
	}else{
		document.getElementById("booking_data").value = JSON.parse(bookingdata);
		document.forms['bookingformmain'].submit();
		return true;
	}
} */

function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}

