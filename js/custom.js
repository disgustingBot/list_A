d=document;w=window;c=console; // por comodidad, le daremos nombres amistosos (con amistosos quiero decir cortos) a las cosas

aNP=d.getElementById("addNewPrty").style;
// box.buttons[0].state=0;
clr=5;

// HACER QUE AL APRETAR ENTER NO RECARGUE LA PAGINA -----------------------------------------------------------------------------------------------
// d.onkeydown = function(e){e=e||w.event;if(e.keyCode==13){if(!mainButtonIsAPlus){addNewElement()}}};
// al apretar "esc" se cancela el menu actual
d.onkeydown=e=>{e=e||w.event;if(e.keyCode==27){box.cancel()}}


// const date = new Date(2002, 01, 02);  // 2009-11-10
// const month = date.toLocaleString('es', { month: 'short' });
// console.log(month);


// Asi comienza nuestra historia,
w.addEventListener("load",()=>{
	// Al arrivar en tu dispositivo, un paquete misterioso se abre
	// y una amistosa criatura se asoma,
	// te pide tus credenciales
	// TODO: hacer un gif de carga
	upk=readCookie("upk");
	uid=readCookie("uid");
	// bse=parseInt(readCookie("bse"));
	bse=JSON.parse(readCookie("bse"));
	if(upk){box.setup(upk,uid,bse)}
	d.getElementById("load").style.top="-100vh";
});

// color console
c.lof = (message, farbe = false)=>{
	if(farbe){c.log("%c" + message, "color:" + farbe);}
	else{c.log(message)}
};

// alternates a class from a selector of choice zB.:
// <div class="someButton" onclick="altClassFromSelector('activ', '#navBar')"></div>
const altClassFromSelector=(clase,selector)=> {
  const x=d.querySelector(selector);
  if(x.classList.contains(clase)){
    x.classList.remove(clase)
  }else{
    x.classList.add(clase)
  }
}


// Actualmente genero una estructura de datos con triggers de MySQL, que si bien fue interesante
// de aprender, me va a servir mas hacer una estructura de datos y un mecanismo de copiado de
// templates




// COSAS QUE NO SE DONDE PONER:

//Accordion //Desplegable

// var acc = d.querySelectorAll("Accordion");
// var i;

const accordionSelector = (selector) => {
	var acc = d.querySelectorAll(selector);

	acc.forEach((item, i) => {
		item.classList.toggle("active");
		// var panel = this.nextElementSibling;
		if (item.style.maxHeight!=0) {
			item.style.maxHeight = null;
			// item.style.maxHeight = null;
			item.style.padding = "0 .5rem";
		} else {
			item.style.maxHeight = item.scrollHeight + 20 + "px";
			item.style.padding = ".5rem";
		}
	});
}










// parent class
box = {
	dbug:0, // debug mode
	base:{},
	list:[],
	favs:[],
	hist:[],
	slct:[],
	sufd:0, // sign up form display

	setup: (upk,uid,bse)=>{
		bse.epk=bse.pky;box.base=bse;
		// box.loadElements(box.base);
		// c.log(box.base);





		// c.log("cosos del setup: ",dataNames, dataValues);
		var dataNames=["upk","ppk","tdy"],dataValues=[bse.upk,bse.epk,0];
		postAjaxCall("inc/loadElements.inc.php", dataNames, dataValues).then(v=>{
			try{ // c.log(v)
				// d.getElementById(id).innerHTML=JSON.parse(v).length;
				JSON.parse(v).forEach(e=>{
					// c.log("hello");
					// c.log(e);

					// TODO: hacer que todos estos OBJETOS sean ELEMENTOS ... ;)
					if(e.stc==1){home=new Element(e);box.updateNofChilds(home, "#homeNmr");};
					// TODO: Hacer que cargue los numeros de TODAY
					if(e.stc==2){favs=e;};
					if(e.stc==3){grps=e;box.updateNofChilds(e, "#grpsNmr");};
					if(e.stc==4){frnd=e;box.updateNofChilds(e, "#frndNmr");};
				})
			}catch(err){
				c.log(err);c.log(v)
			}
			box.loadFavs();
			box.loadElements(home);
			box.slct[0] = home;
			// box.slct[0] = new Element(home);

			// c.log(box.slct)
		})







		bse.pky=parseInt(bse.pky, 10);
		// c.log(bse.pky);
		tday={upk:upk,ppk:bse.pky  ,ttl:"Today" ,tdy:1};


		d.querySelectorAll(".userBasicName").forEach(e=>{e.innerText=uid});
		d.querySelectorAll(".userBasicKey").forEach(e=>{e.innerText="#"+upk});
		// d.querySelector("#userKey").innerText="#"+upk;

		box.selectView("bMain");
		// TODO: mejorar la carga de cantidad de hijos por elemento
		// c.log("base: ",bse);


		d.addEventListener("keydown",e=>{if(e.which == 46){altClassFromSelector('active','#deleteConfirm')}})
	},






	// REGEX para filtrar mails
	validateEmail: e=>{var re=/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;return re.test(String(e).toLowerCase())},
	// TODO: EXPLORAR POSIBILIDAD DE MANDAR MAIL A NEW USER PARA CONFIRMAR LA CUENTA -------------------------------------------------------
	signUp : ()=>{
		var pwd=d.getElementById("signInputPass"),uid=d.getElementById("signInputNick"),fst=d.getElementById("signInputName"),lst=d.getElementById("signInputLast"),eml=d.getElementById("signInputMail"),pw2=d.getElementById("signInputPas2");
		if(box.sufd){// ERROR HANDLERS                    // check for form visibility
			if(uid.value!=""&&pwd.value!=""&&eml.value!=""){// check for empty fields
				if(pwd.value==pw2.value){                     // check for password match
					if(box.validateEmail(eml.value)){           // check for mail format
						var dataNames=["uid","fst","lst","eml","pwd"],dataValues=[uid.value,fst.value,lst.value,eml.value,pwd.value];
						postAjaxCall("inc/addUser.inc.php", dataNames, dataValues).then(v=>{//c.log(v)
							if(v!="mt"){                            // check for mail avaliability
								if(v=="ok"){box.signIn(uid.value,pwd.value)}else{}
							}else{eml.classList.add("taken")}
							eml.addEventListener("input",e=>{var dataNames=["tbl","col","val"],dataValues=["users","eml",this.value];postAjaxCall("inc/checkData.inc.php",dataNames,dataValues).then(v=>{if(v>0){eml.classList.add("taken")}else{eml.classList.remove("taken")}})});
						});
					}else{eml.classList.add("invld")}
					eml.addEventListener("input",e=>{if(box.validateEmail(eml.value)){eml.classList.remove("invld")}else{eml.classList.add("invld")}});
				}else{pw2.classList.add("empty")}
				pw2.addEventListener("input",e=>{passwordsMatch=pwd.value==pw2.value?1:0;if(passwordsMatch){pw2.classList.remove("empty")}else{pw2.classList.add("empty")}});
				pwd.addEventListener("input",e=>{passwordsMatch=pwd.value==pw2.value?1:0;if(passwordsMatch){pw2.classList.remove("empty")}else{pw2.classList.add("empty")}});
			}else{if(uid.value==""){uid.classList.add("empty")}if(pwd.value==""){pwd.classList.add("empty")}if(eml.value==""){eml.classList.add("empty")}}
			uid.addEventListener("input",e=>{if(uid.value==""){uid.classList.add("empty")}else{uid.classList.remove("empty")}});
			pwd.addEventListener("input",e=>{if(pwd.value==""){pwd.classList.add("empty")}else{pwd.classList.remove("empty")}});
			eml.addEventListener("input",e=>{if(eml.value==""){eml.classList.add("empty")}else{eml.classList.remove("empty")}});
		}else{d.querySelector("#signForm").style.marginBottom="0";uid.value="";pwd.value="";fst.tabIndex=1;lst.tabIndex=1;eml.tabIndex=1;pw2.tabIndex=1;box.sufd=1;uid.focus();}
	},
	signOut: ()=>{postAjaxCall("inc/logout.inc.php",0,0).then(v=>{if(v=="ok"){eraseCookie("upk");eraseCookie("uid");eraseCookie("bse");box.selectView('bLogin');box.clearList()}else{c.log(v)}})},
	signIn : (log,pas)=>{
		var pwd=d.getElementById("signInputPass"),uid=d.getElementById("signInputNick");
		var dataNames=["log","pwd"],dataValues=[log,pas];
		if(uid.value==""){
			uid.classList.add("empty")
		}else{
			if(pwd.value==""){
				pwd.classList.add("empty")
			}else{
				postAjaxCall("inc/login.inc.php",dataNames,dataValues).then(v=>{ // c.log(v);
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

	selectView: v=>{d.querySelector("body").className=v},

	greet : ()=>{c.log("greetings "+uid+", your id is: "+upk)},
	cancel: ()=>{
		let dbug = 0;
		if(box.dbug || dbug){c.lof('comienza la funcion Cancel', '#5FA')}

		// if(!mainButtonIsAPlus){
		// if(d.getElementById("button0").classList.contains('check')){
		if(box.buttons[0].state == 1){
			if(box.dbug || dbug){c.log('if main Button0 state is 1')}
			if(box.dbug || dbug){c.log('setState of button0 to what necesary')}
			// d.getElementById("button0").classList.toggle('check');
			if (box.buttons[0].old==1) {
				box.buttons[0].setState(0)
			} else {
				box.buttons[0].setState(box.buttons[0].old)
			}
			if(box.dbug || dbug){c.log('button0 state: ', box.buttons[0].state)}
			d.getElementById("cancel").classList.toggle('highlight');
		}

		// if(box.dbug || dbug){c.log('make mainButtonIsAPlus = 1')}
		// box.buttons[0].state=box.buttons[0].old;

		// deprecated I THINK
		// if(box.dbug || dbug){c.log('make mainButtonIsAPlus = 1')}
		// d.querySelector('#addNew').classList.remove('alt')
		// d.querySelector('#mainMenu').classList.remove('active')

		if(box.dbug || dbug){c.log('Unselect:')}
		box.slct.forEach(e=>{
			if (d.querySelector('#listElement'+e.ord)) {
				if(box.dbug || dbug){c.log(d.querySelector('#listElement'+e.ord))}
				d.getElementById('listElement'+e.ord).classList.toggle('selected')
			}
		});
		if(box.dbug || dbug){c.log('Give the selection the current element')}
		box.slct=[new Element(box.hist[0])]
		if(box.dbug || dbug){c.log(box.slct)}
		if(box.dbug || dbug){c.lof('finaliza la funcion Cancel', '#F35')}
	},

	newTitle : t=>{d.getElementById("title").innerText=t},
	clearList: ()=>{
		box.cancel();
		var a=d.querySelector("#list");
		box.list=[];
		d.getElementById("list").innerText="";
		a.insertBefore(d.importNode(d.querySelector("#cancelTemp").content, true),a.firstChild);
	},






	selectElement: id=>{
		let dbug = 0; // debug mode

		if(box.dbug || dbug){c.lof('comienza la funcion selectElement', '#5FA')}

		// security measurements
		if(!d.getElementById('listElement'+id)){return}

		if(box.dbug || dbug){c.log('inicializacion de variables')}
		let clicked=box.list[id],s=box.slct,found=0;
		if(box.dbug || dbug){
			c.log('box.slct: ', s);
			c.log('clicked: ', clicked);
			c.log('found: ', found)
		}

		// SELECT ARRAY HANDLING:
		if(box.dbug || dbug){
			c.log('check if list of selected includes clicked element:')
			c.log('select before: ', box.slct);
		}
		// at the beggining remove parent if exists
		if(box.slct[0].pky==box.hist[0].pky){
			box.slct.splice(box.slct.findIndex(x=>{x==box.hist[0]}),1)
		}
		// checks if element is already selected
		box.slct.forEach((v,i)=>{
			if(v.ord==id){found=1;box.slct.splice(i,1)} // if found, remove it
		});
		// if not, adds the eleement to the selected elements array
		if(!found){box.slct.push(box.list[id])}
		// finally if selection is empty, give it the parent element
		if(!box.slct[0]){
			box.slct.push(box.hist[0])
		}
		if(box.dbug || dbug){c.log('select after: ', box.slct)}
		// END OF ARRAY HANDLING


		// make visual changes
		if(box.dbug || dbug){c.lof('cambios visuales', '#FEA')}
		d.getElementById('listElement'+id).classList.toggle('selected');
		// cambios en otras partes de la app
		// mainButtonIsAPlus=(box.slct[0].pky!=box.hist[0].pky)?0:1;
		// box.buttons[0].state=(box.slct[0].pky!=box.hist[0].pky)?0:1;
		if(box.slct[0].pky==box.hist[0].pky){
			// box.buttons[0].state=0;
		// if(s.includes(box.hist[0])){
			// d.getElementById("button0").classList.remove('check');

			box.buttons[0].setState(0);
			d.getElementById("cancel").classList.remove('highlight');
		} else {
			// box.buttons[0].state=1;
			// d.getElementById("button0").classList.add('check');
			box.buttons[0].setState(1);
			d.getElementById("cancel").classList.add('highlight');
		}
		if(box.dbug || dbug){c.log('Button Zero state = ', box.buttons[0].state)}

		if(box.dbug || dbug){c.lof('finaliza la funcion selectElement', '#F35')}
	},




	// esta funcion carga elementos de la base de datos en base a parametros,
	// el parametro h (por "history") es donde vienen los datos de busqueda
	// el parametro b (por "back") es opcional, dar 1 para ir hacia atras en el historial o nada para ir hacia adelante
	// GENERALIZAR EL LOAD ---------------------------------------------------------------------------------------------------------------------------------
	// AQUI CREA TODOS LOS ELEMENTOS VISUALES EN LA PAGINA
	handleHist:(h,back = 0)=>{
		if(back){
			if(box.hist.length==1){return}
			box.hist.shift()
		}else{
			box.hist.unshift(h)
		}
	},
	loadElements:(h,b)=>{ // c.log(h);
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
			postAjaxCall("inc/loadElements.inc.php",dataNames,dataValues).then(v=>{
				try{var j=0;
					JSON.parse(v).forEach((e,i)=>{
						if(e.arc==0){
							e.ord=j;
							box.list.push(new Element(e));
							box.list[j].listUI(e);
							// c.log(e)
							// c.log('e.ord: ',e.ord)
							if(e.ord!=null){box.updateNofChilds(e,'#listElement'+e.ord+' .eChild');}
							j++;
						}
					}); // aqui mete todos los elementos en el vector list
				}catch(err){
					c.log(err);
					c.log(v);
				}
			})
		}
		// box.loadFavs();
	},

	loadFavs:()=>{var dataNames=["upk","ppk","tdy"],dataValues=[favs.upk,favs.epk,0];
		postAjaxCall("inc/loadElements.inc.php",dataNames,dataValues).then(v=>{
			d.getElementById("favsCont").innerText="";
			JSON.parse(v).forEach((e,i)=>{
				var temp={upk:upk,tdy:0};
				box.favs.push(new Element(e));box.favs[i].favsUI(e);
				temp.ppk=box.favs[i].epk;
				box.updateNofChilds(temp,"#amountFav"+box.favs[i].epk);
			})
		})
	},

	selectPrimaryButton: e=>{
		box.buttons.forEach((e,i)=>{
			d.getElementById("button"+i).classList.remove("active");
			d.querySelector("body").classList.remove("button" + i);
		})
		d.getElementById("button"+e.pbt).classList.add("active");
		d.querySelector("body").classList.add("button" + e.pbt);
	},

	// esta funcion carga el numero junto a los elementos favoritos en el main menu
	updateNofChilds:(e,selector)=>{
		// TODO: mejorar definicion de variable denro del if
		// tdy=(!e.tdy)?0:e.tdy;
		if(!e.tdy){tdy=0    }else{tdy=e.tdy}
		if(!e.epk){epk=e.ppk}else{epk=e.epk}
		var dataNames=["upk","ppk","tdy"],dataValues=[e.upk,epk,tdy];
		postAjaxCall("inc/loadElements.inc.php", dataNames, dataValues).then(v=>{
			cant=JSON.parse(v).filter(e=>e.tck==0)
			try{
				if(cant.length>0){d.querySelector(selector).innerHTML=cant.length}
			}
			// try{d.getElementById(id).innerHTML=cant.length}
			// try{d.getElementById(id).innerHTML=JSON.parse(v).length}
			catch(err){c.log(err);c.log(v)}
		})
	},

	selectColor: a=>{clr=a;aNP.color="var(--clrPty"+a+")"},

	// AGREGAR LA POSIBILIDAD DE QUE LOS ELEMENTOS SEAN PRODUCTOS, QUE TENGAN PRECIO Y CANTIDADES Y QUE SUMEN LOS COSTOS DE LOS HIJOS ----------------------
	addNewElement:(txt,pty,dte,upk,bse,ppk,grp)=>{
		// dte = '0000-00-00 00:00:00';
		// if(dte == ''){dte = null}
		// if(upk == ''){upk = null}
		// c.log(dte);
		var i,
		dataNames =["txt","pty","dte","upk","bse","ppk","grp"],
		dataValues=[ txt , pty , dte , upk , bse , ppk , grp ];
		if(!txt){return}
		d.getElementById("addNewText").value="";
		postAjaxCall("inc/addElement.inc.php",dataNames,dataValues).then(v=>{ // c.log(v);
			// CREA EL ELEMENTO VISUAL AL RECIBIR OK DEL SERVIDOR
			try{
				newElement = new Element(JSON.parse(v));
				i=box.list.length;
				newElement.ord=i;
				newElement.epk=newElement.pky;
				box.list.push(newElement);
				box.list[i].listUI(box.list[i].values);
				// ppk.forEach(e=>{newElement.altParent({tbl:"elementparent",col:"ppk",val:e,epk:newElement.pky})});
				// newElement.altParent({tbl: "elementparent", col: "ppk", val: ppk, epk: newElement.pky});
			}catch(err){c.log(err);c.log(v)}
		});
	},



	// BUTTONS!
	buttons:[
		{
			// ESTADOS:
			// 0 = signo "+": abre y cierra el menu de nuevo elemento
			old:false,
			state: 0,
			setState:(state = false)=>{
				let dbug = 0; // debug mode
				if(box.dbug || dbug){c.lof('comienza la funcion setState de button Zero', '#5FA')}
				if(box.dbug || dbug){c.log('queremos setear el boton al estado: ', state)}
				let addNew = d.querySelector('#addNew');
				let button = d.querySelector('#button0');
				if(state === false){state = box.buttons[0].old}
				switch (state) {
					case 0:
						button.classList.remove('send')
						button.classList.remove('check')
						button.classList.remove('close')
						addNew.classList.remove('alt')
						break;
					case 1:
						button.classList.remove('send')
						button.classList.add('check')
						button.classList.remove('close')
						addNew.classList.remove('alt')
						break;
					case 2:
						if (d.querySelector('#addNewText').value) {
							box.buttons[0].setState(3);
							return;
						}
						button.classList.remove('send')
						button.classList.remove('check')
						button.classList.add('close')
						addNew.classList.add('alt')
						break;
					case 3:
						button.classList.add('send')
						button.classList.remove('check')
						button.classList.remove('close')
						addNew.classList.add('alt')
						break;
					default:
						box.buttons[0].setState(0);
						break;
				}
				if (box.buttons[0].old!=box.buttons[0].state) {
					box.buttons[0].old=box.buttons[0].state;
				}
				if(box.dbug || dbug){c.log('old: ', box.buttons[0].old)}

				box.buttons[0].state=state

				if(box.dbug || dbug){c.lof('finaliza la funcion setState de button Zero', '#F35')}
			},
			action:()=>{
				switch (box.buttons[0].state) {
					case 0:
						// altClassFromSelector('alt', '#addNew')
						box.buttons[0].setState(2);
						break;
					case 1:
						box.slct.forEach(e=>{
							e.check();
							d.getElementById('listElement'+e.ord).focus()
							box.cancel();
						})
						break;
					case 2:
						// altClassFromSelector('alt', '#addNew');
						box.buttons[0].setState(0);
						break;
					case 3:
						var inputs=d.getElementById('addNew').elements;
						box.addNewElement(
						    inputs['addNewText'].value,
						    inputs['colr'].value,
						    inputs['dateInput'].value,
						    inputs['friendId'].value,
						    box.hist[0].bse,
						    box.hist[0].epk,
						    '',
						);
						// altClassFromSelector('alt', '#addNew');
						box.buttons[0].setState(2);
						break;
					default:
						c.log('caso default de estado');
				}
			},
		},
		()=>{
			d.querySelector(".newGroupFriendList").innerText="";
			postAjaxCall("inc/loadElements.inc.php",["upk","ppk","tdy"],[upk,frnd.epk,0]).then(v=>{
				try{let friends=JSON.parse(v);
					friends.forEach(f=>{f=new Element(f);f.frndUI(f)})
				}catch(err){c.log(err);c.log(v)}
			});box.selectView("bNewGroup");
		},
	],
	createGroup:()=>{
		var txt=d.getElementById('newGroupName').value;
		// TODO: notificar al usuario de campo requerido
		if(!txt){return}
		// Selecciona a todos los involucrados en el grupo
		let frndSelected=[];
		d.querySelectorAll(".friendListInput").forEach(e=>{if(e.checked){frndSelected.push(e.value)}})
		// Create group
		box.addNewElement(txt,6,"","",0,box.hist[0].epk,frndSelected);
		// Go back to main view after creating group
		box.selectView("bMain");
		// Empty the group name
		d.getElementById('newGroupName').value='';
	}
};












// element class
// se crea el elemento dandole de comer "elementValues", que es un objecto
class Element {
	constructor(v){
		// TODO: quitar la propiedad "values" y reemplazar por nueva implementacion
		this.values = v;
		this.favorite = { tbl: "elementparent", col: "ppk", val: box.base.pky+2 , epk: v.epk };
		// Esta parte define las propiedades del elemento como vienen del objeto v
		for(var k in v){Object.defineProperty(this,k,{enumerable: true,value:v[k]})}
	}
	listUI(v){
		// Test to see if the browser supports the HTML template element by checking
		// for the presence of the template element's content attribute.
		if ('content' in d.createElement('template')) {

			// Instantiate the template
			// and the nodes you will control
			var a = d.importNode(d.querySelector("#listElement").content, true),
			element = a.querySelector(".element"),
			eColor  = a.querySelector(".eColor"),
			eChild  = a.querySelector(".eChild"),
			eTxt    = a.querySelector(".eTxt"),
			eNav    = a.querySelector(".eNavigate");
			// Make your changes
			if(v.tck==1){element.classList.add("ticked")}
			element.setAttribute('id', 'listElement'+this.ord);
			element.setAttribute('tck', this.tck);
			element.setAttribute("onclick", "box.selectElement("+this.ord+")");
			element.setAttribute("ondblclick", "box.loadElements("+JSON.stringify(v)+")");
			eColor.style.background = "var(--clrPty" + this.pty + ")";
			eChild.style.color = "var(--clrPty" + this.pty + ")";
			eTxt.textContent = v.txt;
			eNav.setAttribute("onclick", "box.loadElements("+JSON.stringify(this)+")");
			// Insert it into the document in the right place
			d.querySelector("#list").insertBefore(a, d.getElementById("cancel"));
		}
		else { // Find another way to add the rows to the table because the HTML template element is not supported.
			c.log("ERROR: your browser does not support required features for the app");
		}
	}
	favsUI(v){
		// Instantiate the template
		// and the nodes you will control
		var a = d.importNode(d.querySelector("#favsElement").content, true),
		element = a.querySelector(".mainMenuElement"),
		eColor = a.querySelector(".eColor"),
		eTxt = a.querySelector(".eTxt"),
		eNmr = a.querySelector(".eNmr");
		// Make your changes
		element.setAttribute("id", "fav" + v.epk);
		eNmr.setAttribute("id", "amountFav" + v.epk);
		eColor.style.background = "var(--clrPty" + v.pty + ")";
		eTxt.textContent = v.txt;
		element.setAttribute("onclick", "box.loadElements("+JSON.stringify(this)+")");
		// Insert it into the document in the right place
		var gSpot = d.querySelector("#favsCont");
		gSpot.insertBefore(a, gSpot.firstChild);


	}
	frndUI(v){
		// Test to see if the browser supports the HTML template element by checking
		// for the presence of the template element's content attribute.
		if ('content' in d.createElement('template')) {
			// Instantiate the template
			// and the nodes you will control
			var a=d.importNode(d.querySelector("#frndElement").content, true),element=a.querySelector(".friendListElement"),input=a.querySelector(".friendListInput"),eColor=a.querySelector(".frndClr"),eTxt=a.querySelector(".frndTxt");
			// Make your changes
			// element.setAttribute("id", "frnd" + v.epk);
			input.setAttribute ("id" ,"frnd" +v.epk);
			input.setAttribute ("value",v.upk);
			eColor.setAttribute("for","frnd" +v.epk);
			eColor.style.color="var(--clrPty"+v.pty+")";
			eTxt.textContent=v.txt;
			// Insert it into the document in the right place
			var gSpot=d.querySelector(".newGroupFriendList");
			// gSpot.insertBefore(a, gSpot.firstChild);
			gSpot.appendChild(a);
		}
		else { // Find another way to add the rows to the table because the HTML template element is not supported.
			alert("ERROR: your browser does not support required features for the app");
		}
	}

	// la entrada p es por "parent"
	// la entrada f es por "favorite" y es opcional, debe ser 1 si se quiere hacer un elemento favorito
	altParent(p,f){ // c.log(this)
		// c.log(p,f);
		var v=this.values,
		e=d.getElementById("listElement"+v.ord),
		favsUI=this.favsUI,
		eF=d.getElementById("fav"+p.epk);
		c.log("v: ",v);
		c.log("e: ",e);
		var url="inc/addParentToE.inc.php",dataNames=["tbl","col","val","epk"],dataValues=[p.tbl,p.col,p.val,p.epk];
		postAjaxCall(url,dataNames,dataValues).then(v=>{c.log(p)
			try{
				if(f&&v==1){
					favsUI({epk:p.epk,txt:e.innerText});
					box.loadFavs();
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
	editElement(col,val,del){
		// c.log(col,val,del);
		var dataNames=["pky","col","val"],dataValues=[this.epk,col,val],i=this.ord;
		postAjaxCall("inc/editElement.inc.php", dataNames, dataValues).then(v=>{
			try {
				if(del){
					d.getElementById("list").removeChild(d.getElementById('listElement'+i));
				}
			}catch(err){c.log(err)}
		});
	}
	editColr (a) { // c.log(a)
		this.editElement('pty', a, false);
		if(this.ord){
			d.getElementById('listElement'+this.ord).querySelector(".eColor").style.background = "var(--clrPty" + a + ")";
		}
	}

	// ESTA FUNCION EDITA ELEMENTOS, QUIZAS LA PUEDO GENERALIZAR -------------------------------------------------------------------------------------------
	check () {
		var i = this.ord, state = d.getElementById('listElement'+i).getAttribute("tck") == 0 ? 1 : 0,
		dataNames=["pky","col","val"],dataValues=[this.epk,"tck",state];
		postAjaxCall("inc/editElement.inc.php",dataNames,dataValues).then(()=>{
		try {
			d.getElementById('listElement'+i).setAttribute("tck", state);
			d.getElementById('listElement'+i).classList.toggle("ticked");
		}
			catch (err) {
				c.log(err);
			}
		});
	}
	// ESTAS FUNCIONES HABILITA LA EDICION DE TEXTO ----------------------------------------------------------------------------------------------------------------
	editTxt(){var i=this.ord,eTxt=d.getElementById('listElement'+i).querySelector(".eTxt");box.cancel();box.selectElement(i);eTxt.setAttribute("contenteditable","true");eTxt.focus();};
	sendEdit(){
		var i=this.ord;
		if (i) {
			let eTxt=d.getElementById('listElement'+i).querySelector(".eTxt");
			if(this.txt!=eTxt.textContent){
				this.editElement('txt',eTxt.innerText,0);
			}
			eTxt.setAttribute('contenteditable','false');
		}
	}

}









function postAjaxCall(url,dataNames,dataValues){// return a new promise.
	return new Promise((resolve,reject)=>{// do the usual XHR stuff
		var req=new XMLHttpRequest();
		req.open('post',url);
		//NOW WE TELL THE SERVER WHAT FORMAT OF POST REQUEST WE ARE MAKING
		req.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		req.onload =()=>{if(req.status>=200&&req.status<300){resolve(req.response)}else{reject(Error(req.statusText));console.log("ERROR")}}
		req.onerror=()=>{reject(Error("Network Error"))}// handle network errors
		// prepare the data to be sent
		let data;
		for(var i=0;i<dataNames.length;i++){data=data+"&"+dataNames[i]+"="+dataValues[i]}
		// make the request
    req.send(data)
	})
}
function createCookie(n,value,days){if(days){var date=new Date();date.setTime(date.getTime()+(days*24*60*60*1000));var expires="; expires="+date.toUTCString();}else var expires="";d.cookie=n+"="+value+expires+"; path=/";}
function readCookie  (n){var m=n+"=",a=d.cookie.split(';');for(var i=0;i<a.length;i++){var c=a[i];while(c.charAt(0)==' ')c=c.substring(1,c.length);if(c.indexOf(m)==0)return c.substring(m.length,c.length);}return null;}
function eraseCookie (n){createCookie(n,"",-1)}
