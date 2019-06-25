d=document;w=window;c=console; // por comodidad, le daremos nombres amistosos (con amistosos quiero decir cortos) a las cosas
// TODO: hacer que el login este en la misma pagina html!!!!!!!!!!!!!
mB1=d.getElementById("mainButtonBar1").style;
mB2=d.getElementById("mainButtonBar2").style;
aNP=d.getElementById("addNewPrty").style;

mainButtonIsAPlus=1;
clr=5;

// HACER QUE AL APRETAR ENTER NO RECARGUE LA PAGINA -----------------------------------------------------------------------------------------------
// d.onkeydown = function(e){e=e||w.event;if(e.keyCode==13){if(!mainButtonIsAPlus){addNewElement()}}};
// al apretar "esc" se cancela el menu actual
d.onkeydown=function(e){e=e||w.event;if(e.keyCode==27){box.cancel();}};



// const date = new Date(2002, 01, 02);  // 2009-11-10
// const month = date.toLocaleString('es', { month: 'short' });
// console.log(month);


// Asi comienza nuestra historia,
w.addEventListener("load", function(){
	// Al arrivar en tu dispositivo, un paquete misterioso se abre
	// y una amistosa criatura amarilla se asoma,
	// te pide tus credenciales
	upk=readCookie("upk");uid=readCookie("uid");
	// y con ellas setea su inicio
	inbox = {upk: upk, ppk: 0, ttl: "Inbox", tdy: 0};
	today = {upk: upk, ppk: 0, ttl: "Today", tdy: 1};
	faves = {upk: upk, ppk: 1, ttl: "Faves", tdy: 0};
	// y te saluda:
	box.greet();
	d.getElementById("mainMenuProfileName").innerText = uid;
	// y prepara su espacio de trabajo
	box.loadElements(faves,0);
	box.loadElements(inbox,0);
	box.updateNummerOnMainMenu(inbox, "inboxAmount");
});


// parent class
box = {
	list: [],
	favs: [],
	hist: [],
	slct: [],

	greet: function(){c.log("greetings "+uid+", your id is: "+upk);},
	// greet: function(){c.log("greetings user: upk: "+upk+", uid: "+uid);},
	cancel: function(){
		if(!mainButtonIsAPlus){d.getElementById("mainButton").classList.toggle('check');d.getElementById("cancel").classList.toggle('highlight');}mainButtonIsAPlus=1;
		box.slct.forEach(function(v,i){d.getElementById(v.values.ord).classList.toggle('selected')});box.slct=[]; // UN-SELECT
	},

	newTitle : function(t){d.getElementById("title").innerText=t},
	clearList: function(){
		var a = d.querySelector("#list");
		box.cancel();
		box.list=[];d.getElementById("list").innerText="";
		a.insertBefore(d.importNode(d.querySelector("#cancelTemp").content, true), a.firstChild);
	},


	selectElement: function(id){var s=box.slct,f=1,t=s[0]?0:1;
		d.getElementById(id).classList.toggle('selected');
		s.forEach(function(v,i){if(v.values.ord==id){
			f=0;
			s.splice(i,1)
		}});if(f){s.push(box.list[id])}
		if(t||!s[0]){
			d.getElementById("mainButton").classList.toggle('check');
			d.getElementById("cancel").classList.toggle('highlight');
		}
		mainButtonIsAPlus=s[0]?0:1;
	},

	// esta funcion carga elementos de la base de datos en base a parametros,
	// el parametro h (por "history") es donde vienen los datos de busqueda
	// el parametro b (por "back") es opcional, dar 1 para ir hacia atras en el historial o nada para ir hacia adelante
	// GENERALIZAR EL LOAD ---------------------------------------------------------------------------------------------------------------------------------
	// AQUI CREA TODOS LOS ELEMENTOS VISUALES EN LA PAGINA
	handleHist:function(h,b){if(b==1){if(box.hist.length==1){return}box.hist.shift()}else{if(h.ppk==1){return}box.hist.unshift(h)}},

	loadElements: function(h,b){
		// aqui se maneja el historial
		box.handleHist(h, b);
		// aqui van los cambios en la PAGINA
		// aqui se deberian activar las animaciones?... quizas
		box.newTitle(h.ttl);
		box.clearList();
		var dataNames=["upk","ppk","tdy"],dataValues=[h.upk,h.ppk,h.tdy],i=0;
		postAjaxCall("inc/loadElements.inc.php",dataNames,dataValues).then(function(v){
			try{
				JSON.parse(v).forEach(function(e){
					if (h.ppk==1) {
						box.favs.push(new Element(e));box.favs[i].favsUI(e);
						// temp.ppk = box.favs[i].values.epk;
						// box.updateNummerOnMainMenu(temp, "amountFav"+box.favs[i].values.epk);
					}else if(e.arc==0){e.ord=i;box.list.push(new Element(e));box.list[i].listUI(e);i++}
				}); // aqui mete todos los elementos en el vector list
			}catch(err){c.log(err);c.log(v)}
		})
	},


	// esta funcion carga el numero junto a los elementos favoritos en el main menu
	// tal vez deberia ir en el elemento en si
	updateNummerOnMainMenu: function (e, id){
		var dataNames=["upk","ppk","tdy"],dataValues=[e.upk,e.ppk,0];
		postAjaxCall("inc/loadElements.inc.php", dataNames, dataValues).then(function(v){
			try {d.getElementById(id).innerHTML=JSON.parse(v).length;}catch(err){c.log(err);c.log(v)}
		})},


	selectColor: function(a){clr=a;aNP.color="var(--clrPty"+a+")"},

	// AGREGAR LA POSIBILIDAD DE QUE LOS ELEMENTOS SEAN PRODUCTOS, QUE TENGAN PRECIO Y CANTIDADES Y QUE SUMEN LOS COSTOS DE LOS HIJOS ----------------------
	addNewElement: function () {
		var dte=d.getElementById("dateInput").value,txt=d.getElementById('addNewText').value,i,
		url="inc/addElement.inc.php",dataNames=["txt","pty","dte","upk"],dataValues=[txt,clr,dte,upk];
		if (!txt) {return}
		postAjaxCall(url,dataNames,dataValues).then(function(v){
			// CREA EL ELEMENTO VISUAL AL RECIBIR OK DEL SERVIDOR
			try {newElement = new Element(JSON.parse(v));
				i=box.list.length;newElement.values.ord=i;newElement.values.epk=newElement.values.pky;
				box.list.push(newElement);box.list[i].listUI(box.list[i].values);
				d.getElementById("addNewText").value="";
				var parentData = [
					{tbl: "elementparent", col: "ppk", val: box.hist[0].ppk, epk: newElement.values.pky},
					{tbl: "userelements",  col: "upk", val: upk,             epk: newElement.values.pky}];
				parentData.forEach(function(e){newElement.altParent(e)});
			}catch(err){c.log(err);}
		});
	},

	// BUTTONS!
	button1: function(){if(!mainButtonIsAPlus){box.slct.forEach(function(v){v.check();d.getElementById(v.values.ord).focus()})}},
};




// element class
// se crea el elemento dandole de comer "elementValues", que es un objecto
function Element(v) {
	this.values = v;
	this.favorite = {tbl: "elementparent", col: "ppk", val: 1, epk: v.epk}

	this.listUI = function(v) {
		// Test to see if the browser supports the HTML template element by checking
		// for the presence of the template element's content attribute.
		if ('content' in document.createElement('template')) {
		  // Instantiate the template
		  // and the nodes you will control
		  var a=d.importNode(d.querySelector("#listElement").content,true),element=a.querySelector(".element"),eColor=a.querySelector(".eColor"),eTxt=a.querySelector(".eTxt"),eNav=a.querySelector(".eNavigate");
			// Make your changes
			if (v.tck==1){element.classList.add("ticked")}
			element.setAttribute("id", v.ord);
			element.setAttribute("tck",v.tck);
			eColor.style.background = "var(--clrPty"+v.pty+")";
			eTxt.textContent = v.txt;
			eNav.setAttribute("onclick", "box.loadElements({upk:"+upk+",ppk:'"+v.epk+"',ttl:'"+v.txt+"',tdy:0})");
		  // Insert it into the document in the right place
			d.querySelector("#list").insertBefore(a, d.getElementById("cancel"));
		} else { // Find another way to add the rows to the table because the HTML template element is not supported.
			c.log("ERROR: your browser does not support required features for the app")
		}
	}

	this.favsUI = function(v) {
		// Test to see if the browser supports the HTML template element by checking
		// for the presence of the template element's content attribute.
		if ('content' in d.createElement('template')) {
			// Instantiate the template
			// and the nodes you will control
			var a=d.importNode(d.querySelector("#favsElement").content,true),element=a.querySelector(".mainMenuElement"),eColor=a.querySelector(".eColor"),eTxt=a.querySelector(".eTxt"),eNmr=a.querySelector(".eNmr");
			// Make your changes
			element.setAttribute("id","fav"+v.epk);
			eNmr.setAttribute("id","amountFav"+v.epk);
			eColor.style.background="var(--clrPty"+v.pty+")";
			eTxt.textContent=v.txt;
			element.setAttribute("onclick","box.loadElements({upk:"+upk+",ppk:'"+v.epk+"',ttl:'"+v.txt+"',tdy:0})");
			// Insert it into the document in the right place
			var gSpot=d.querySelector("#favouritesContainer");
			gSpot.insertBefore(a, gSpot.firstChild);
		} else { // Find another way to add the rows to the table because the HTML template element is not supported.
			c.log("ERROR: your browser does not support required features for the app")
		}
	}

	this.editColr = function(a){this.editElement('pty',a,false);d.getElementById(this.values.ord).querySelector(".eColor").style.background="var(--clrPty"+a+")"}


	// ESTAS FUNCIONES HABILITA LA EDICION DE TEXTO ----------------------------------------------------------------------------------------------------------------
	this.editTxt  = function(){var i=this.values.ord,eTxt=d.getElementById(i).querySelector(".eTxt");box.cancel();box.selectElement(i);eTxt.setAttribute("contenteditable","true");eTxt.focus();}
	this.sendEdit = function(){var i=this.values.ord,eTxt=d.getElementById(i).querySelector(".eTxt");if(this.values.txt!=eTxt.textContent){this.editElement('txt', eTxt.innerText,0)}eTxt.setAttribute('contenteditable','false')}

	// ESTA FUNCION EDITA ELEMENTOS, QUIZAS LA PUEDO GENERALIZAR -------------------------------------------------------------------------------------------
	this.check = function(){
		var i=this.values.ord, state=d.getElementById(i).getAttribute("tck")==0?1:0,
		url="inc/editElement.inc.php",dataNames=["pky","col","val"],dataValues=[this.values.epk,"tck",state];
		postAjaxCall(url, dataNames, dataValues).then(function(){try {d.getElementById(i).setAttribute("tck",state);d.getElementById(i).classList.toggle("ticked");}catch(err){c.log(err);}})
	}

	// ESTA FUNCION EDITA ELEMENTOS, QUIZAS LA PUEDO GENERALIZAR MAS ---------------------------------------------------------------------------------------
	// PODER ASIGNARSE TAREAS ------------------------------------------------------------------------------------------------------------------------------
	this.editElement = function(col,val,del){
		// c.log("hola");
		c.log(col,val,del);
		var url="inc/editElement.inc.php",dataNames=["pky","col","val"],dataValues=[this.values.epk,col,val],i=this.values.ord;
		postAjaxCall(url,dataNames,dataValues).then(function(v){
			try {c.log(v);
				// box.loadFavorits(upk);
				if (del) {d.getElementById("list").removeChild(d.getElementById(i));}
			} catch(err) {c.log(err);}
		});
	},


	// la entrada p es por "parent"
	// la entrada f es por "favourite" y es opcional, debe ser 1 si se quiere hacer un elemento favorito
	this.altParent = function(p,f) {
		var v=this.values,e=d.getElementById(v.ord),favsUI=this.favsUI,eF=d.getElementById("fav"+p.epk);
		var url="inc/addParentToE.inc.php",dataNames=["tbl","col","val","epk"],dataValues=[p.tbl,p.col,p.val,p.epk];
		postAjaxCall(url, dataNames, dataValues).then(function(v){
			try {
				if(f&&v==1){favsUI({epk:p.epk,txt:e.innerText})}else if(f&&v==0){eF.remove()}
			}catch(err){c.log(err)}
		});
	}
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
		    if(req.status>=200&&req.status<300){resolve(req.response)
		    } else {
		        reject(Error(req.statusText));
		        console.log("ERROR")
		    }
		}; // handle network errors
		req.onerror = function() {
		    reject(Error("Network Error"));
		}; // make the request

		// prepare the data to be sent
		var data = dataNames[0] + "=" + dataValues[0];
		for (var i = 1; i < dataNames.length; i++) {
			data = data + "&" + dataNames[i] + "=" + dataValues[i];
		}

  		// console.log(data);
    	req.send(data);
	 });}
function logout() {postAjaxCall("inc/logout.inc.php",0,0).then(function(v){if(v=="ok"){eraseCookie("upk");eraseCookie("uid");w.location.replace("index.php");}else{console.log(v)}});}
function readCookie  (n){var m=n+"=",a=d.cookie.split(';');for(var i=0;i<a.length;i++){var c=a[i];while(c.charAt(0)==' ')c=c.substring(1,c.length);if(c.indexOf(m)==0)return c.substring(m.length,c.length);}return null;}
function eraseCookie (n){createCookie(n,"",-1)}
function createCookie(n,value,days){if(days){var date=new Date();date.setTime(date.getTime()+(days*24*60*60*1000));var expires="; expires="+date.toUTCString();}else var expires="";d.cookie=n+"="+value+expires+"; path=/";}
