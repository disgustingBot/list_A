d=document;w=window;c=console; // por comodidad, le daremos nombres amistosos (con amistosos quiero decir cortos) a las cosas

aNP=d.getElementById("addNewPrty").style;
mainButtonIsAPlus=1;
clr=5;

// HACER QUE AL APRETAR ENTER NO RECARGUE LA PAGINA -----------------------------------------------------------------------------------------------
// d.onkeydown = function(e){e=e||w.event;if(e.keyCode==13){if(!mainButtonIsAPlus){addNewElement()}}};
// al apretar "esc" se cancela el menu actual
d.onkeydown=function(e){e=e||w.event;if(e.keyCode==27){box.cancel()}};

// const date = new Date(2002, 01, 02);  // 2009-11-10
// const month = date.toLocaleString('es', { month: 'short' });
// console.log(month);


// Asi comienza nuestra historia,
w.addEventListener("load", function(){
	// Al arrivar en tu dispositivo, un paquete misterioso se abre
	// y una amistosa criatura se asoma,
	// te pide tus credenciales
	// TODO: hacer un gif de carga
	upk=readCookie("upk");
	uid=readCookie("uid");
	// bse=parseInt(readCookie("bse"));
	bse=JSON.parse(readCookie("bse"));
	if(upk){box.setup(upk,uid,bse)}
	d.getElementById("load").style.top="-200vw";
});







// Actualmente genero una estructura de datos con triggers de MySQL, que si bien fue interesante
// de aprender, me va a servir mas hacer una estructura de datos y un mecanismo de copiado de
// templates














// parent class
box = {
	base:{},
	list: [],
	favs: [],
	hist: [],
	slct: [],
	sufd: 0, //sign up form display

	setup: function(upk,uid,bse){
		bse.epk=bse.pky;box.base=bse;
		// box.loadElements(box.base);
		// c.log(box.base);





		// c.log("cosos del setup: ",dataNames, dataValues);
		var dataNames=["upk","ppk","tdy"],dataValues=[bse.upk,bse.epk,0];
		postAjaxCall("inc/loadElements.inc.php", dataNames, dataValues).then(function(v){
			try{
				// d.getElementById(id).innerHTML=JSON.parse(v).length;
				JSON.parse(v).forEach(function(e){
					// c.log("hello");
					if(e.stc==1){home=e;box.updateNofChilds(e, "homeNmr");};
					if(e.stc==2){favs=e;};
				})
			}catch(err){
				c.log(err);c.log(v)
			}
					box.loadElements(favs);
					box.loadElements(home);
		})







		box.list.forEach(function(e,i){c.log("papa")});

		bse.pky=parseInt(bse.pky, 10);
		// c.log(bse.pky);
		// base={upk:upk,ppk:bse.pky  ,ttl:"Base"  ,tdy:0};
		tday={upk:upk,ppk:bse.pky  ,ttl:"Today" ,tdy:1};
		// home={upk:upk,ppk:bse.pky+1,ttl:"Home"  ,tdy:0};
		// favs={upk:upk,ppk:bse.pky+2,ttl:"Favs"  ,tdy:0};
		grps={upk:upk,ppk:bse.pky+3,ttl:"Groups",tdy:0};

		// box.loadElements(favs);
		// box.loadElements(home);

		d.querySelector("#userName").innerText=uid;
		d.querySelector("#userKey").innerText="#"+upk;
		// d.querySelector("body").classList.add('bMain');
		box.selectView("bMain");
		// TODO: mejorar la carga de cantidad de hijos por elemento
		// c.log("base: ",bse);
		// box.updateNofChilds(home, "homeNmr");
		// box.updateNofChilds(tday, "tdayNmr");
	},

	// REGEX para filtrar mails
	validateEmail: function(e){var re=/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;return re.test(String(e).toLowerCase())},
	// TODO: EXPLORAR POSIBILIDAD DE MANDAR MAIL A NEW USER PARA CONFIRMAR LA CUENTA -------------------------------------------------------
	signUp : function(){
		var pwd=d.getElementById("signInputPass"),uid=d.getElementById("signInputNick"),fst=d.getElementById("signInputName"),lst=d.getElementById("signInputLast"),eml=d.getElementById("signInputMail"),pw2=d.getElementById("signInputPas2");
		if(box.sufd){// ERROR HANDLERS                    // check for form visibility
			if(uid.value!=""&&pwd.value!=""&&eml.value!=""){// check for empty fields
				if(pwd.value==pw2.value){                     // check for password match
					if(box.validateEmail(eml.value)){           // check for mail format
						var dataNames=["uid","fst","lst","eml","pwd"],dataValues=[uid.value,fst.value,lst.value,eml.value,pwd.value];
						postAjaxCall("inc/addUser.inc.php", dataNames, dataValues).then(function(v){//c.log(v)
							if(v!="mt"){                            // check for mail avaliability
								if(v=="ok"){box.signIn(uid.value,pwd.value)}else{}
							}else{eml.classList.add("taken")}
							eml.addEventListener("input",function(e){var dataNames=["tbl","col","val"],dataValues=["users","eml",this.value];postAjaxCall("inc/checkData.inc.php",dataNames,dataValues).then(function(v){if(v>0){eml.classList.add("taken")}else{eml.classList.remove("taken")}})});
						});
					}else{eml.classList.add("invld")}
					eml.addEventListener("input",function(e){if(box.validateEmail(eml.value)){eml.classList.remove("invld")}else{eml.classList.add("invld")}});
				}else{pw2.classList.add("empty")}
				pw2.addEventListener("input",function(e){passwordsMatch=pwd.value==pw2.value?1:0;if(passwordsMatch){pw2.classList.remove("empty")}else{pw2.classList.add("empty")}});
				pwd.addEventListener("input",function(e){passwordsMatch=pwd.value==pw2.value?1:0;if(passwordsMatch){pw2.classList.remove("empty")}else{pw2.classList.add("empty")}});
			}else{if(uid.value==""){uid.classList.add("empty")}if(pwd.value==""){pwd.classList.add("empty")}if(eml.value==""){eml.classList.add("empty")}}
			uid.addEventListener("input",function(e){if(uid.value==""){uid.classList.add("empty")}else{uid.classList.remove("empty")}});
			pwd.addEventListener("input",function(e){if(pwd.value==""){pwd.classList.add("empty")}else{pwd.classList.remove("empty")}});
			eml.addEventListener("input",function(e){if(eml.value==""){eml.classList.add("empty")}else{eml.classList.remove("empty")}});
		}else{d.querySelector("#signForm").style.marginBottom="0";uid.value="";pwd.value="";fst.tabIndex=1;lst.tabIndex=1;eml.tabIndex=1;pw2.tabIndex=1;box.sufd=1;uid.focus();}
	},
	signOut: function(){postAjaxCall("inc/logout.inc.php",0,0).then(function(v){if(v=="ok"){eraseCookie("upk");eraseCookie("uid");eraseCookie("bse");box.selectView('bLogin');box.clearList()}else{c.log(v)}})},
	signIn : function(log,pas){
		var pwd=d.getElementById("signInputPass"),uid=d.getElementById("signInputNick");
		var dataNames=["log","pwd"],dataValues=[log,pas];
		if(uid.value==""){
			uid.classList.add("empty")
		}else{
			if(pwd.value==""){
				pwd.classList.add("empty")
			}else{
				postAjaxCall("inc/login.inc.php",dataNames,dataValues).then(
					function(v){ // c.log(v);
						session=JSON.parse(v);
						//c.log("session:");
						//c.log(JSON.parse(session.u_bse));
						if(session.status=="ok"){// c.log(JSON.parse(session.u_bse).pky);
							upk=session.u_pky,
							uid=session.u_uid,
							bse=session.u_bse;
							createCookie("upk",upk);
							createCookie("uid",uid);
							createCookie("bse",bse);
							box.setup(upk,uid,JSON.parse(session.u_bse))
						}else{
							c.log(v)
						}
					}
				)
			}
		}
	},

	selectView: function(view){d.querySelector("body").className="";d.querySelector("body").classList.add(view)},

	greet : function(){c.log("greetings "+uid+", your id is: "+upk)},
	cancel: function(){if(!mainButtonIsAPlus){d.getElementById("button0").classList.toggle('check');d.getElementById("cancel").classList.toggle('highlight');}mainButtonIsAPlus=1;box.slct.forEach(function(v,i){d.getElementById(v.ord).classList.toggle('selected')});box.slct=[];},

	newTitle : function(t){d.getElementById("title").innerText=t},
	clearList: function(){box.cancel();var a=d.querySelector("#list");box.list=[];d.getElementById("list").innerText="";a.insertBefore(d.importNode(d.querySelector("#cancelTemp").content, true),a.firstChild);},

	selectElement: function(id){if(!d.getElementById(id)){return}
		var s=box.slct,f=1,t=s[0]?0:1;
		d.getElementById(id).classList.toggle('selected');
		s.forEach(function(v,i){if(v.ord==id){f=0;s.splice(i,1)}});
		if(f){s.push(box.list[id])}
		if(t||!s[0]){
			d.getElementById("button0").classList.toggle('check');
			d.getElementById("cancel").classList.toggle('highlight');
		}
		mainButtonIsAPlus=s[0]?0:1;
	},

	// esta funcion carga elementos de la base de datos en base a parametros,
	// el parametro h (por "history") es donde vienen los datos de busqueda
	// el parametro b (por "back") es opcional, dar 1 para ir hacia atras en el historial o nada para ir hacia adelante
	// GENERALIZAR EL LOAD ---------------------------------------------------------------------------------------------------------------------------------
	// AQUI CREA TODOS LOS ELEMENTOS VISUALES EN LA PAGINA
	handleHist  : function(h,b){ // c.log(h);
		if(b==1){
			if(box.hist.length==1){return}
			box.hist.shift()
		}else{
			if(h.epk==box.base.pky+2){return}
			box.hist.unshift(h)
		}
	},
	loadElements: function(h,b){ // c.log(h);
		box.handleHist(h,b);// aqui se maneja el historial
		if(h){
			// !aqui van los cambios en la PAGINA
			// ?aqui se deberian activar las animaciones?... quizas
			// TODO: poner animaciones
			box.selectPrimaryButton(h);
			box.newTitle(h.txt);
			box.clearList();
			if(!h.tdy){h.tdy=0}
			var dataNames=["upk","ppk","tdy"],dataValues=[h.upk,h.epk,h.tdy],i=0;
			// c.log(dataNames, dataValues);
			// var dataNames=["upk","ppk","tdy"],dataValues=[h.upk,h.ppk,h.tdy],i=0;
			postAjaxCall("inc/loadElements.inc.php",dataNames,dataValues).then(function(v){
				try{var j=0;
					if(h.epk==box.base.pky+2){d.getElementById("favsCont").innerText=""}
					JSON.parse(v).forEach(function(e,i){
						if(h.epk==box.base.pky+2){var temp={upk:upk,tdy:0};
							box.favs.push(new Element(e));box.favs[i].favsUI(e);
							temp.ppk=box.favs[i].epk;
							box.updateNofChilds(temp,"amountFav"+box.favs[i].epk);
						}else if(e.arc==0){
							e.ord=j;
							box.list.push(new Element(e));
							box.list[j].listUI(e);
							j++;
						}
					}); // aqui mete todos los elementos en el vector list
				}catch(err){c.log(err);c.log(v)}
			})
		}
	},
	selectView: function(view){d.querySelector("body").className="";d.querySelector("body").classList.add(view)},

	selectPrimaryButton: function(e){
		for (var i = 0; i < box.buttons.length; i++) {
			d.getElementById("button"+i).classList.remove("active");
		}
		c.log(e.pbt);
		d.getElementById("button"+e.pbt).classList.add("active");
	},

	// esta funcion carga el numero junto a los elementos favoritos en el main menu
	updateNofChilds: function(e,id){
		var dataNames=["upk","ppk","tdy"],dataValues=[e.upk,e.ppk,e.tdy];
		postAjaxCall("inc/loadElements.inc.php", dataNames, dataValues).then(function(v){
			try{
				d.getElementById(id).innerHTML=JSON.parse(v).length;
			}catch(err){
				c.log(err);c.log(v)
			}
		})
	},

	selectColor: function(a){clr=a;aNP.color="var(--clrPty"+a+")"},

	// AGREGAR LA POSIBILIDAD DE QUE LOS ELEMENTOS SEAN PRODUCTOS, QUE TENGAN PRECIO Y CANTIDADES Y QUE SUMEN LOS COSTOS DE LOS HIJOS ----------------------
	addNewElement: function () {
		var dte=d.getElementById("dateInput").value,txt=d.getElementById('addNewText').value,i,
		url="inc/addElement.inc.php",dataNames=["txt","pty","dte","upk","bse"],dataValues=[txt,clr,dte,upk,bse.pky];
		if(!txt){return}
		c.log(dataValues);
		postAjaxCall(url,dataNames,dataValues).then(function(v){
			// CREA EL ELEMENTO VISUAL AL RECIBIR OK DEL SERVIDOR
			try {newElement = new Element(JSON.parse(v));
				i=box.list.length;newElement.ord=i;newElement.epk=newElement.pky;
				box.list.push(newElement);box.list[i].listUI(box.list[i].values);
				d.getElementById("addNewText").value="";
				// var parentData = [
				// 	{tbl: "elementparent", col: "ppk", val: box.hist[0].ppk, epk: newElement.pky},
				// 	{tbl: "userelements",  col: "upk", val: upk,             epk: newElement.pky}];
				// c.log(parentData);
				// parentData.forEach(function(e){newElement.altParent(e)});
				newElement.altParent({tbl: "elementparent", col: "ppk", val: box.hist[0].epk, epk: newElement.pky});
			}catch(err){c.log(err);c.log(v)}
		});
	},

	// BUTTONS!
	buttons:[
		function(){
			if(!mainButtonIsAPlus){
				box.slct.forEach(function(v){
					v.check();
					d.getElementById(v.ord).focus()
				})
			}
		},
		function(){
			c.log("create a new group");
			box.selectView("bNewGroup");

		},
	],
	createGroup: function() {
		c.log("this is the new group");
	}
};















// element class
// se crea el elemento dandole de comer "elementValues", que es un objecto
class Element {
	constructor(v) {
		// TODO: quitar la propiedad "values" y reemplazar por nueva implementacion
		this.values = v;
		this.favorite = { tbl: "elementparent", col: "ppk", val: box.base.pky+2 , epk: v.epk };
		// Esta parte define las propiedades del elemento como vienen del objeto v
		for(var k in v){Object.defineProperty(this,k,{enumerable: true,value:v[k]})}
		// for(var k in v){if(v.hasOwnProperty(k)){Object.defineProperty(this,k,{value:v[k]})}}
	}
	listUI(v){
		// Test to see if the browser supports the HTML template element by checking
		// for the presence of the template element's content attribute.
		if ('content' in document.createElement('template')) {
			// Instantiate the template
			// and the nodes you will control
			var a = d.importNode(d.querySelector("#listElement").content, true), element = a.querySelector(".element"), eColor = a.querySelector(".eColor"), eTxt = a.querySelector(".eTxt"), eNav = a.querySelector(".eNavigate");
			// Make your changes
			if (v.tck == 1) {
				element.classList.add("ticked");
			}
			element.setAttribute("id", this.ord);
			element.setAttribute("tck", this.tck);
			// element.setAttribute("ondblclick", "box.loadElements({upk:" + upk + ",ppk:'" + v.epk + "',ttl:'" + v.txt + "',tdy:0})");
			eColor.style.background = "var(--clrPty" + this.pty + ")";
			eTxt.textContent = v.txt;
			// let r=this;
			// c.log(JSON.stringify(this));
			// c.log(JSON.parse(JSON.stringify(this)));
			// eNav.setAttribute("onclick", "box.loadElements({upk:" + upk + ",ppk:'" + v.epk + "',ttl:'" + v.txt + "',tdy:0})");
			// eNav.setAttribute("onclick", "box.loadElements({"+JSON.stringify(this)+",tdy:0})");
			eNav.setAttribute("onclick", "box.loadElements("+JSON.stringify(this)+")");
			// eNav.setAttribute("onclick", "c.log("+JSON.stringify(this)+")");
			// Insert it into the document in the right place
			d.querySelector("#list").insertBefore(a, d.getElementById("cancel"));
		}
		else { // Find another way to add the rows to the table because the HTML template element is not supported.
			c.log("ERROR: your browser does not support required features for the app");
		}
	}
	favsUI(v){
		// Test to see if the browser supports the HTML template element by checking
		// for the presence of the template element's content attribute.
		if ('content' in d.createElement('template')) {
			// Instantiate the template
			// and the nodes you will control
			var a = d.importNode(d.querySelector("#favsElement").content, true), element = a.querySelector(".mainMenuElement"), eColor = a.querySelector(".eColor"), eTxt = a.querySelector(".eTxt"), eNmr = a.querySelector(".eNmr");
			// Make your changes
			element.setAttribute("id", "fav" + v.epk);
			eNmr.setAttribute("id", "amountFav" + v.epk);
			eColor.style.background = "var(--clrPty" + v.pty + ")";
			eTxt.textContent = v.txt;
			// element.setAttribute("onclick", "box.loadElements({upk:" + upk + ",ppk:'" + v.epk + "',ttl:'" + v.txt + "',tdy:0})");
			element.setAttribute("onclick", "box.loadElements("+JSON.stringify(this)+")");
			// Insert it into the document in the right place
			var gSpot = d.querySelector("#favsCont");
			gSpot.insertBefore(a, gSpot.firstChild);
		}
		else { // Find another way to add the rows to the table because the HTML template element is not supported.
			c.log("ERROR: your browser does not support required features for the app");
		}
	}

	// la entrada p es por "parent"
	// la entrada f es por "favorite" y es opcional, debe ser 1 si se quiere hacer un elemento favorito
	altParent(p,f){
		c.log(p,f);
		var v=this.values,e=d.getElementById(v.ord),favsUI=this.favsUI,eF=d.getElementById("fav"+p.epk);
		var url="inc/addParentToE.inc.php",dataNames=["tbl","col","val","epk"],dataValues=[p.tbl,p.col,p.val,p.epk];
		postAjaxCall(url,dataNames,dataValues).then(function(v){
			try{
				if(f&&v==1){
					favsUI({epk:p.epk,txt:e.innerText});
				}
				else if(f&&v==0){
					eF.remove();
				}
			}
			catch(err){
				c.log(err);
			}
		})
	}

	// ESTA FUNCION EDITA ELEMENTOS, QUIZAS LA PUEDO GENERALIZAR MAS ---------------------------------------------------------------------------------------
	// PODER ASIGNARSE TAREAS ------------------------------------------------------------------------------------------------------------------------------
	editElement (col, val, del) {
		// c.log(col,val,del);
		var dataNames = ["pky", "col", "val"], dataValues = [this.values.epk, col, val], i = this.values.ord;
		postAjaxCall("inc/editElement.inc.php", dataNames, dataValues).then(function (v) {
		try {
			if (del) {
				d.getElementById("list").removeChild(d.getElementById(i));
			}
		}
			catch (err) {
				c.log(err);
			}
		});
	}

	// ESTA FUNCION EDITA ELEMENTOS, QUIZAS LA PUEDO GENERALIZAR -------------------------------------------------------------------------------------------
	check () {
		var i = this.ord, state = d.getElementById(i).getAttribute("tck") == 0 ? 1 : 0, url = "inc/editElement.inc.php", dataNames = ["pky", "col", "val"], dataValues = [this.epk, "tck", state];
		postAjaxCall(url, dataNames, dataValues).then(function () {
		try {
			d.getElementById(i).setAttribute("tck", state);
			d.getElementById(i).classList.toggle("ticked");
		}
			catch (err) {
				c.log(err);
			}
		});
	}
	// ESTAS FUNCIONES HABILITA LA EDICION DE TEXTO ----------------------------------------------------------------------------------------------------------------
	editTxt () { var i = this.ord, eTxt = d.getElementById(i).querySelector(".eTxt"); box.cancel(); box.selectElement(i); eTxt.setAttribute("contenteditable", "true"); eTxt.focus(); };
	sendEdit () {
		var i = this.ord, eTxt = d.getElementById(i).querySelector(".eTxt"); if (this.txt != eTxt.textContent) {
			this.editElement('txt', eTxt.innerText, 0);
		} eTxt.setAttribute('contenteditable', 'false');
	}
	editColr (a) { this.editElement('pty', a, false); d.getElementById(this.ord).querySelector(".eColor").style.background = "var(--clrPty" + a + ")"; };

}












function postAjaxCall(url,dataNames,dataValues){// return a new promise.
	return new Promise(function(resolve, reject) {// do the usual XHR stuff
		var req=new XMLHttpRequest();
		req.open('post',url);
		//NOW WE TELL THE SERVER WHAT FORMAT OF POST REQUEST WE ARE MAKING
		req.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		req.onload =function(){if(req.status>=200&&req.status<300){resolve(req.response)}else{reject(Error(req.statusText));console.log("ERROR")}}
		req.onerror=function(){reject(Error("Network Error"))}// handle network errors
		// make the request
		// prepare the data to be sent
		var data=dataNames[0]+"="+dataValues[0];
		for(var i=1;i<dataNames.length;i++){data=data+"&"+dataNames[i]+"="+dataValues[i]}
    req.send(data)
	})
}
function createCookie(n,value,days){if(days){var date=new Date();date.setTime(date.getTime()+(days*24*60*60*1000));var expires="; expires="+date.toUTCString();}else var expires="";d.cookie=n+"="+value+expires+"; path=/";}
function readCookie  (n){var m=n+"=",a=d.cookie.split(';');for(var i=0;i<a.length;i++){var c=a[i];while(c.charAt(0)==' ')c=c.substring(1,c.length);if(c.indexOf(m)==0)return c.substring(m.length,c.length);}return null;}
function eraseCookie (n){createCookie(n,"",-1)}
