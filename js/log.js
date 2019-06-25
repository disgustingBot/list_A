d = document; w = window; c = console;
passwordsMatch = false;
mailInUse = false;
pw1 = d.getElementById("signUPInputPass");
pw2 = d.getElementById("signUPInputPas2");
mnu = d.getElementById("signUPInputMail");
function test() {console.log("test");}

function bringSignIn() {
	d.getElementById("loginForm").style.marginTop = "10px";
	d.getElementById("signUpTitle").style.marginTop = "0px";
}

// THIS PART CHECKS IF THE MAIL IS ALREADY TAKEN
mnu.addEventListener("input",function(e){// c.log(e);
	var dataNames  = ["tbl", "col", "val"], dataValues = ["users", "eml", this.value];
	postAjaxCall("inc/checkData.inc.php", dataNames, dataValues).then(function(value) {
		if(value>0){mnu.classList.add("error"); mailInUse = true}else{mnu.classList.remove("error"); mailInUse = false};
	});
});

// THIS PART CHECKS IF THE PASSWORDS MATCH
pw1.addEventListener("input",function(e){checkPass();if(passwordsMatch){pw1.classList.remove("error");pw2.classList.remove("error")}else{pw1.classList.add("error");pw2.classList.add("error")}});
pw2.addEventListener("input",function(e){checkPass();if(passwordsMatch){pw1.classList.remove("error");pw2.classList.remove("error")}else{pw1.classList.add("error");pw2.classList.add("error")}});
function checkPass() {passwordsMatch = pw1.value == pw2.value ? true : false;}

function loginButton() {
	c.log(d.getElementById('loginInputLog').value);
	if        (d.getElementById('loginInputLog').value == "") {
		       d.getElementById('loginInputLog').classList.add("loginInputError");
		       d.getElementById('errorMessage').innerHTML = "Hint: Red means error!";
	} else if (d.getElementById('loginInputPas').value == "") {
		       d.getElementById('loginInputPas').classList.add("loginInputError");
		       d.getElementById('errorMessage').innerHTML = "Hint: Red means error!";
	} else {
		login(d.getElementById('loginInputLog').value, d.getElementById('loginInputPas').value);
	}
}

// CREATE SOME ERROR HANDLERS: EMPTY FIELD, ETC ----------------------------------------------------------------------------------
// EXPLORAR POSIBILIDAD DE MANDAR MAIL A NEW USER PARA CONFIRMAR LA CUENTA -------------------------------------------------------
function newUser() {
	var dataNames  = ["uid", "fst", "lst", "eml", "pwd"];
	var dataValues = [
		d.getElementById('signUPInputNick').value,
		d.getElementById('signUPInputName').value,
		d.getElementById('signUPInputLast').value,
		d.getElementById('signUPInputMail').value,
		d.getElementById('signUPInputPass').value];
	var url = "inc/addUser.inc.php";
	if (passwordsMatch && !mailInUse) {
		postAjaxCall(url, dataNames, dataValues).then(function(value) {
			if (value=="ok") {
				c.log(dataValues);
				c.log(value);
				login(d.getElementById('signUPInputNick').value, d.getElementById('signUPInputPass').value);
			} else {c.log(value)}
		});} else {c.log("error, passmatch: "+passwordsMatch+" mail in use: "+mailInUse)}
}

function login(log, pas) {
	var dataNames  = ["log", "pwd"];
	var dataValues = [log, pas];
	c.log(dataValues);
	var url = "inc/login.inc.php";
	postAjaxCall(url, dataNames, dataValues).then(function(value) {
		session = JSON.parse(value);
		c.log(value);
		// if (value=="ok") {
		if (session.status=="ok") {
			// AQUI DEBERIA HACER EL INICIO DE SESION ----------------------------------------------------------------------------------
			createCookie("upk",session.u_pky,7);
			createCookie("uid",session.u_uid,7);
			w.location.href = "list.php";
		} else {c.log(value)}
	});
}

function postAjaxCall(url, dataNames, dataValues) {
	// return a new promise.
	return new Promise(function(resolve, reject) {
		// do the usual XHR stuff
		var req = new XMLHttpRequest();
		req.open('post', url);
		//NOW WE TELL THE SERVER WHAT FORMAT OF POST REQUEST WE ARE MAKING
		req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		req.onload = function() {
		    if (req.status >= 200 && req.status < 300) {
		        // console.log(req.response);
		        resolve(req.response);
		    } else {
		        reject(Error(req.statusText));
		        c.log("ERROR");
		        c.log(req.response);
		        c.log(req.status);
		    }
		}; // handle network errors
		req.onerror = function() {
		    reject(Error("Network Error"));
		}; // make the request

		// prepare the data to be sent
		var data = dataNames[0] + "=" + dataValues[0];
		for (var i = 1; i < dataNames.length; i++) {
			data = data + "&" + dataNames[i] + "=" + dataValues[i];
		} req.send(data);
	});
}


function createCookie(name,value,days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        var expires = "; expires="+date.toUTCString();
    }
    else var expires = "";
    d.cookie = name+"="+value+expires+"; path=/";
}
