d=document;w=window;c=console;
// trataré de dar nombres semanticos al resto de las cosas,
// estos 3 quedan asi porque me permiten trabajar mas rapido


// Asi comienza nuestra historia,
w.addEventListener("load",()=>{
	// Al arrivar en tu dispositivo, un paquete misterioso se abre
	// y una amistosa criatura se asoma,
	// te pide tus credenciales
	// TODO: hacer un gif de carga
	// upk=readCookie("upk");
	// uid=readCookie("uid");
	// bse=parseInt(readCookie("bse"));
	// bse=JSON.parse(readCookie("bse"));
	// if(upk){box.setup(upk,uid,bse)}
	d.getElementById("load").style.top="-100vh";
});
// color console
c.lof = (message, farbe = false)=>{
	if(farbe){c.log("%c" + message, "color:" + farbe);}
	else{c.log(message)}
};

random = array => array[Math.floor(Math.random() * array.length)]




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











const select_view = view=>{d.querySelector("body").className=view}
/*
!list Handler

Encargado de manejar:
carga de elementos solicitados por el usuario
eliminacion de elementos innecesarios de la pantalla
*/
const list = {
	current:[],

	clear:()=>{
		let list = d.querySelector('#list');
		let to_remove = list.querySelectorAll('.element:not(.title)');
		to_remove.forEach( item => { item.remove() });

		list.current=[];
	},



	load:(parent = false)=>{ // c.log(h);
		let formData = new FormData();

		formData.append('ppk', parent.ppk);

		ajax2(formData, 'inc/load_elements.inc.php').then(response => {
			list.clear();

			let j=0;
			response.forEach(element=>{

				// si el elemento no esta archivado se carga, sino se omite
				// TODO: hacer un selector de "cargar archivados=true/false"
				if(element.arc==0){
					element.ord=j;
					list.current.push(new Element(element));
					list.current[j].listUI(element);
					j++;
				}
			})
		})
	},
}




















/*
!Account Handler:

Handles all account related:
-Registration
-Log in
-Log out
-Change pass
-Recover Pass
-Confirm account

?All for -Multiple accounts
*/
// TODO: -Change pass
// TODO: -Recover Pass
// TODO: -Confirm account
accounts = {
    debugMode:0,


    /*
    !general user log in

    *Parameters:
        REQUIRED:
            .mail
            .password
    */
    // TODO: -make this multiple account compatible
    log_in:(mail, password)=>{
        let formData = new FormData();

        formData.append('log', mail);
        formData.append('pwd', password);

        ajax2(formData, 'inc/log_in.inc.php').then(response => {
			// notify(response.title, response.message);
			// c.log(response)
			user_base = JSON.parse(response.u_bse);
			// TODO: aqui hay un problema
			c.log(user_base);
			user_base.ppk = user_base.pky;
			list.load(user_base);
			// list.load({ppk:767})
			select_view('view_main');
        })
    },


    /*
    !general user log out

    *Parameters:
        REQUIRED:
            .mail
    */
    // TODO: -make this multiple account compatible
	log_out: ()=>{
        let formData = new FormData();

        ajax2(formData, 'inc/log_out.inc.php').then(response => {
            // c.log(response)
            // notify(response.title, response.message);
			select_view('view_log');
			list.clear();
        })
    },




    /*
    !general user registration

    *Parameters:
        REQUIRED:
            .mail = account's mail
            .pwd1 = password
            .pwd2 = password double check
        OPTIONAL:
            .name = user name.      Defaults to random from names
            .last = user last name. Defaults to random from lasts
            .user = user nick name. Defaults to mail

    *Error if:
        .pwd1 and pwd2 are different
        .mail is not valid
        .mail already exists in data base
        .nickname already exists in data base

    TODO: check for problematic characters, ej: ', &, ", etc
    TODO: activate real time checkers
    TODO: hacer que si no se da una pass, genere una automaticamente
    */

    create_user:(mail, pwd1, pwd2, user = false, name = false, last = false)=>{
        // debug mode
        let debugMode = 1;
        if(accounts.debugMode || debugMode){c.lof('----------------------------\ncomienza la funcion register\n----------------------------', '#5FA')}

        const names = ["Peter", "Ada", "Tomm", "John", "Juan", "May", "Julio", "Summer", "Sofia", "Ralf", "Sama", "Mike", "Jule", "Kiki", "Marta"];
        const lasts = ["Moral", "Lovelace", "Anderson", "Curie", "Thomson", "Rutherford", "Heisenberg", "Einstein", "Gauss", "Newton", "Faraday", "Schrödinger"];

        // set back to defaults
        if(!mail){mail = d.querySelector('signInputMail').value}
        if(!user){user = mail}
        if(!name){name = random(names)}
        if(!last){last = random(lasts)}
        if(!pwd1){pwd1 = d.querySelector('signInputPass').value}
        if(!pwd2){pwd2 = d.querySelector('signInputPas2').value}


        if(accounts.debugMode || debugMode){c.log('mail:', mail)}
        if(accounts.debugMode || debugMode){c.log('user:', user)}
        if(accounts.debugMode || debugMode){c.log('name:', name)}
        if(accounts.debugMode || debugMode){c.log('last:', last)}
        if(accounts.debugMode || debugMode){c.log('pwd1:', pwd1)}
        if(accounts.debugMode || debugMode){c.log('pwd2:', pwd2)}

        // check for password match
        if(pwd1==pwd2){
            // check for mail format
            if(accounts.validateEmail(mail)){
                let formData = new FormData();

                formData.append('eml', mail);
                formData.append('uid', user);
                formData.append('fst', name);
                formData.append('lst', last);
                formData.append('pwd', pwd1);


                ajax2(formData, 'inc/addUser.inc.php').then(response => {
                    // c.log(response)
                    notify(response.title, response.message);
                })
            }else{
                notify('Error', "email field doesn't have a valid format");
            }
        }else{
            notify('Error', "passwords don't match");
        }
        if(accounts.debugMode || debugMode){c.lof('----------------------------\nfinaliza la funcion register\n----------------------------', '#F35')}
    },
	validateEmail: e=>{var re=/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;return re.test(String(e).toLowerCase())},
}

// c.log('registration state:', accounts.register('mail@testo.com', 'pass', 'pass'))


// accounts.create_user('mail@testing.com', 'pass', 'pass')
accounts.log_in('mail@testing.com', 'pass')






const notify = (title, message)=>{
    let sign = d.querySelector('#alert');
    sign.querySelector('.alert_title').innerText = title;
    sign.querySelector('.alert_txt').innerText = message;
    sign.classList.add('visible');
}


// notify ('testeos', 'aqui va el mensaje');





























// element class
// se crea el elemento dandole de comer "elementValues", que es un objecto
class Element {
	constructor(v){
		// TODO: quitar la propiedad "values" y reemplazar por nueva implementacion
		// this.values = v;
		// this.favorite = { tbl: "elementparent", col: "ppk", val: box.base.pky+2 , epk: v.epk };
		// Esta parte define las propiedades del elemento como vienen del objeto v
		for(var k in v){Object.defineProperty(this,k,{enumerable: true,value:v[k]})}
	}
	listUI(){
		// Test to see if the browser supports the HTML template element by checking
		// for the presence of the template element's content attribute.
		if ('content' in d.createElement('template')) {

			// Instantiate the template
			// and the nodes you will control
			var a = d.importNode(d.querySelector("#listElement").content, true),
			element = a.querySelector(".element"),
			color   = a.querySelector(".element_color"),
			count   = a.querySelector(".element_count"),
			title   = a.querySelector(".element_title"),
			buton   = a.querySelector(".element_navigate");
			// Make your changes
			if(this.tck==1){element.classList.add("ticked")}
			element.setAttribute('id', 'listElement'+this.ord);
			element.setAttribute('tck', this.tck);
			color.style.background = "var(--clrPty" + this.pty + ")";
			count.style.color = "var(--clrPty" + this.pty + ")";
			title.textContent = this.txt;
			// Insert it into the document in the right place
			d.querySelector("#list").insertBefore(a, d.querySelector(".cancel"));
		}
		else { // Find another way to add the rows to the table because the HTML template element is not supported.
			c.log("ERROR: your browser does not support required features for the app");
		}
	}
}











































// TODO: usar service workers para que ande offline
/*
!Console Color:
Outputs a console log with color as a second variable
*/
c.lof = (message, farbe = false)=>{
	if(farbe){c.log("%c" + message, "color:" + farbe);}
	else{c.log(message)}
};


async function ajax2(formData, url) {
	try{
		let response = await fetch(url, {
			method: 'POST',
			body: formData,
			// mode: 'no-cors',
		});
		return await response.json();
	}catch(err){
		console.error(err);
	}
}

async function ajax3(formData, url) {
	try{
		let response = await fetch(url, {
			method: 'POST',
			body: formData,
		});
	// return await response.json();
		return await response.text();
	}catch(err){
		console.error(err);
	}
}

// TODO: chequear codigo de cookie handling
function new_cookie (n,value,days){if(days){var date=new Date();date.setTime(date.getTime()+(days*24*60*60*1000));var expires="; expires="+date.toUTCString();}else var expires="";d.cookie=n+"="+value+expires+"; path=/";}
function read_cookie(n){var m=n+"=",a=d.cookie.split(';');for(var i=0;i<a.length;i++){var c=a[i];while(c.charAt(0)==' ')c=c.substring(1,c.length);if(c.indexOf(m)==0)return c.substring(m.length,c.length);}return null;}
function edit_cookie(n){createCookie(n,"",-1)}
