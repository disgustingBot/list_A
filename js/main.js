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
	accounts.log_in('mail@testing.com', 'pass')
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
const altClassFromSelector=(clase,selector) => {
    const x=d.querySelector(selector);
    if(x.classList.contains(clase)){
        x.classList.remove(clase)
    }else{
        x.classList.add(clase)
    }
}




/*
history

encargada de manejar el historial de navegacion,
lleva funciones como añadir al historial, ir hacia atras y adelante
*/
const history = {
	dbug_mode:0,
	list:[],

	go_back:()=>{
		if(history.list.length==1){return}

		// if(history.list[0]){
			d.querySelector('.element_' + history.list[0].element.element_id).classList.remove('title')
		// }
		list.clear();
		selection.clear();
		// añade la entrada al historial
		history.list.splice(0, 1)
		let entry = history.list[0]
		// carga elementos en la lista
		list.load(entry.element)

		// TODO: aqui deberia agregar el elemento actual
		list.add(entry.element, 0)
		d.querySelector('.element_' + entry.element.element_id).classList.add('title')
	},


	/*
	=go_to

	navega a la direccion solicitada, añadiendola al historial
	*/
	go_to:(entry)=>{
		let dbug = 0; // debug mode
		if(history.dbug_mode || dbug){c.lof('comienza la funcion go_to de history handler', '#5FA')}
		if(history.dbug_mode || dbug){c.log('OLD history: ', history.list)}
		if(history.dbug_mode || dbug){c.log('OLD current list: ', list.current)}


		if(history.list[0]){
			d.querySelector('.element_' + history.list[0].element.element_id).classList.remove('title')
		}

		list.clear();
		selection.clear();
		// añade la entrada al historial
		history.list.splice(0, 0, entry)
		// carga elementos en la lista
		list.load(entry.element)

		if(history.dbug_mode || dbug){c.log('NEW current list: ', list.current)}
		if(history.dbug_mode || dbug){c.log('NEW history: ', history.list)}

		// TODO: aqui deberia agregar el elemento actual
		list.add(entry.element, 0)
		d.querySelector('.element_' + entry.element.element_id).classList.add('title')
		if(selection.dbug_mode || dbug){c.lof('finaliza la funcion go_to de history handler', '#F35')}
	},

}


/*
=favorites

sera encargada de cargar y actualizar favoritos en la pantalla
*/
const favorites = {
	dbug_mode: 0,
	current: [],


	/*
	=favorites.alternate

	añade elemento a los favoritos y lo dibuja en la pantalla
	PARAMETROS:
		REQUERIDOS:
			- element => elemento a añadir ( element )
	*/
	alternate:(element)=>{
		let dbug = 0; // debug mode
		if(!element){return}
		if(favorites.dbug_mode || dbug){c.lof('comienza la funcion alternate de favorites handler', '#5FA')}
		if(favorites.dbug_mode || dbug){c.log('elemento a añadir: ', element)}
		if(favorites.dbug_mode || dbug){c.log('favorites actual: ', favorites.current)}


				let formData = new FormData();
				formData.append('epk', element.element_id);
				formData.append('ppk', favs.element_id);

				ajax2(formData, 'inc/alt_parent.inc.php').then(response => {
					response.forEach(element => {
						favorites.add(element);
					})
				})
			// favorites.children_count(element);

		if(favorites.dbug_mode || dbug){c.lof('finaliza la funcion alternate de favorites handler', '#F35')}
	},





	/*
	=favorites.draw

	añade elemento a la lista actual y lo dibuja en la pantalla
	PARAMETROS:
		REQUERIDOS:
			- element => elemento a añadir ( element )
		OPCIONALES:
			- position => posicion en donde insertar el elemento ( número )
			- view_archived => ver favoritos? ( true || false )
	*/
	draw:(element, position = favorites.current.length, view_archived = false)=>{
		let dbug = 0; // debug mode
		if(!element){return}
		if(favorites.dbug_mode || dbug){c.lof('comienza la funcion add de favorites handler', '#5FA')}
		if(favorites.dbug_mode || dbug){c.log('elemento a añadir: ', element)}
		if(favorites.dbug_mode || dbug){c.log('favorites actual: ', favorites.current)}

		// si el elemento no esta archivado se carga, sino se omite
		// TODO: hacer un selector de "cargar archivados=true/false"
		if( !( element.arc == 1 && view_archived == false ) ){
			// add element to current list
			favorites.current.splice(position, 0, new Element(element));
			if(favorites.dbug_mode || dbug){c.log('NUEVA favorites actual: ', favorites.current)}
			// draw element on the screen
			favorites.current[position].element_UI('.favorites', position);

			// favorites.children_count(element);
		}

		if(favorites.dbug_mode || dbug){c.lof('finaliza la funcion add de favorites handler', '#F35')}
	},

	/*
	=favorites.load

	carga elementos en la lista de favoritos del menu
	*/
	load:()=>{
		let dbug = 1; // debug mode
		if(favorites.dbug_mode || dbug){c.lof('comienza la funcion load de favorites handler', '#5FA')}
		let favs = JSON.parse(accounts.logged[0].favorites);
		// let favs = JSON.parse(accounts.logged);
		// let favs = accounts.logged;
		if(favorites.dbug_mode || dbug){c.log('elemento favoritos: ', favs)}


		let formData = new FormData();
		formData.append('ppk', favs.element_id);

		ajax2(formData, 'inc/load_elements.inc.php').then(response => {
			response.forEach(element => {
				favorites.add(element);
			})
		})

		if(favorites.dbug_mode || dbug){c.lof('finaliza la funcion load de favorites handler', '#F35')}
	},
}



/*
=selection Handler

Encargado de llevar cuenta de la seleccion.
- agregar elementos a seleccion
- quitar elementos de la seleccion
- vaciar seleccion
- seleccionar todo

*/
const selection = {
	dbug_mode: 0,
	current: [],



	/*
	funcion select

	alterna el la seleccion de un elemento. al seleccionar, si el elemento esta en
	selection.current lo quitamos, y si no esta lo añadimos.

	PARAMETROS:
		- element (required)
	*/
	select:(select)=>{
		let dbug = 0; // debug mode
		if(selection.dbug_mode || dbug){c.lof('comienza la funcion select de selection handler', '#5FA')}

		// TODO: chequear si es un elemento valido
		if(d.querySelector('.element_' + select.element_id)){
			altClassFromSelector('selected', '.element_' + select.element_id);
		}

		// buscar elemento en selection.current
		if(selection.dbug_mode || dbug){c.log('current selection: ', selection.current)}
		if(selection.dbug_mode || dbug){c.log('elemento a comparar: ', select.element_id)}

		let already_selected = selection.current.findIndex(element => element.element_id === select.element_id) == -1 ? false : true;
		if(selection.dbug_mode || dbug){c.log('already selected: ', already_selected)}

		if(already_selected){
			let index = selection.current.findIndex(element => element.element_id === select.element_id);
			if(selection.dbug_mode || dbug){c.log('at index: ', index)}
			// quitar elemento de la seleccion
			selection.current.splice(index, 1);
		} else {
			//agregar elemento a la seleccion
			selection.current.splice(0, 0, select);
		}

		selection.button_hook();



		// c.log(selection.current);


		// c.log(element.element_id);
		// c.log(selection.current);

		if(selection.dbug_mode || dbug){c.log('NEW current selection: ', selection.current)}
		if(selection.dbug_mode || dbug){c.lof('finaliza la funcion select de selection handler', '#F35')}
	},

	/*
	clear selection

	vacía la seleccion actual
	*/
	clear:()=>{
		let dbug = 0; // debug mode
		if(selection.current.length == 0){return}
		if(selection.dbug_mode || dbug){c.lof('comienza la funcion clear de selection handler', '#5FA')}
		if(selection.dbug_mode || dbug){c.log('current selection: ', selection.current)}

		while(selection.current.length != 0){
			selection.select(selection.current[0]);
		}

		if(selection.dbug_mode || dbug){c.log('NEW current selection: ', selection.current)}
		if(selection.dbug_mode || dbug){c.lof('finaliza la funcion clear de selection handler', '#F35')}
	},

	/*
	edit

	edita la seleccion, poniendole a toda ella el par key = value
	PARAMETROS:
		REQUERIDOS:
			- key => nombre de la columna a editar
			- value => nuevo valor
	*/
	edit:(key, value, remove = false)=>{
		selection.current.forEach( element => {
			factory.edit(element, key, value, remove);
		})
	},

	/*
	delete

	elimina todos los elementos de la seleccion actual
	*/
	delete:()=>{
		selection.edit('del', 1)
	},

	/*
	funcion button hook

	si la seleccion actual esta vacia pone la cruz en el boton, sino pone el check
	*/
	button_hook:()=>{
		let dbug = 0; // debug mode
		if(selection.dbug_mode || dbug){c.lof('comienza la funcion button_hook de selection handler', '#5FA')}
		if(selection.dbug_mode || dbug){c.log('current selection: ', selection.current)}
		let is_empty = selection.current == 0 ? true : false;
		if(selection.dbug_mode || dbug){c.log('esta vacia: ', is_empty)}
		if(is_empty==0){
			// elegir estado de check
			main_button.setState(1);
		} else {
			// elegir estado de add new
			main_button.setState(0);
		}
		if(selection.dbug_mode || dbug){c.lof('finaliza la funcion button_hook de selection handler', '#F35')}
	},
}
















const select_view = view => { d.querySelector("body").className = view }
/*
=list Handler

Encargado de manejar la lista de elementos actual
- carga elementos con ciertos criterios
- añade elementos a lista actual
- elimina elementos de la lista actual
- vacia la lista


eliminacion de elementos innecesarios de la pantalla
*/
const list = {
	dbug_mode:0,
	current:[],

	/*
	=list.children_count

	aqui contaremos cantidad de hijos y actualizaremos la pantalla
	*/
	children_count: element => {

		let is_on_the_list = list.current.findIndex(find => find.element_id === element.element_id) == -1 ? false : true;
		if( is_on_the_list ){
			let formData = new FormData();

			formData.append('ppk', element.element_id);

			ajax2(formData, 'inc/load_elements.inc.php').then(response => {

				let cant = response.filter(element=>element.tck==0)
				if(cant.length>0){d.querySelector('.element_' + element.element_id + ' .element_count').innerHTML=cant.length}
			})
		}
	},

	/*
	clear

	vacía la lista actual dejandola vacia. Se encarga tambien de quitar elementos
	de la pantalla

	No necesita parametros
	*/
	clear:()=>{
		// let list = d.querySelector('.list');
		// let to_remove = list.querySelectorAll('.element:not(.title)');
		// to_remove.forEach( item => { item.remove() });
		//
		// list.current=[];

		let to_delete = [...list.current];
		to_delete.forEach(element => {
			list.remove(element);
		});
	},

	/*
	adds element to list

	añade elemento a la lista actual y lo dibuja en la pantalla
	PARAMETROS:
		REQUERIDOS:
			- element => elemento a añadir ( element )
		OPCIONALES:
			- position => posicion en donde insertar el elemento ( número )
			- view_archived => ver favoritos? ( true || false )
	*/
	add:(element, position = list.current.length, view_archived = false)=>{
		let dbug = 0; // debug mode
		if(!element){return}
		if(list.dbug_mode || dbug){c.lof('comienza la funcion add de list handler', '#5FA')}
		if(list.dbug_mode || dbug){c.log('elemento a añadir: ', element)}
		if(list.dbug_mode || dbug){c.log('lista actual: ', list.current)}



		// si el elemento no esta archivado se carga, sino se omite
		// TODO: hacer un selector de "cargar archivados=true/false"
		if( !( element.arc == 1 && view_archived == false ) ){
			// add element to current list
			list.current.splice(position, 0, new Element(element));
			if(list.dbug_mode || dbug){c.log('NUEVA lista actual: ', list.current)}
			// draw element on the screen
			list.current[position].element_UI('.list', position);

			list.children_count(element);
		}




		if(list.dbug_mode || dbug){c.lof('finaliza la funcion add de list handler', '#F35')}
	},



	/*
	update element

	actualiza el dibujo del elemento seleccionado
	PARAMETROS:
		- element => elemento a actualizar (requerido)
	*/
	update:(element)=>{
		let dbug = 0; // debug mode
		if(!element){return}
		if(list.dbug_mode || dbug){c.lof('comienza la funcion update de list handler', '#5FA')}
		if(list.dbug_mode || dbug){c.log('elemento a actualizar: ', element)}
		// if(list.dbug_mode || dbug){c.log('lista actual: ', list.current)}

		// chequear si esta en la lista
		// si está actualizar, si no no hacer nada
		let is_on_the_list = list.current.findIndex(find => find.element_id === element.element_id) == -1 ? false : true;
		if(list.dbug_mode || dbug){c.log('elemento está en la lista actual: ', is_on_the_list)}
		if( is_on_the_list ){
			let index = list.current.findIndex(find => find.element_id === element.element_id);
			if(selection.dbug_mode || dbug){c.log('at index: ', index)}
			// c.log(list.current[index].tck)
			// c.log(element.tck)
			let they_are_different = list.current[index] == element ? false : true;
			if(selection.dbug_mode || dbug){c.log('necesito actualizar: ', they_are_different)}
			if( they_are_different ){
				// d.querySelector(".list").removeChild(d.querySelector('.element_'+element.element_id));
				// list.current.splice(index, 1, new Element(element));

				// TODO: ahora el tema es que al eliminar y volver a crear me quita tambien la seleccion
				list.remove(element)
				list.add(element, index)
				selection.select(element)
			}
		}


		if(list.dbug_mode || dbug){c.lof('finaliza la funcion update de list handler', '#F35')}
	},



	/*
	remove element from list

	quita el elemento de la lista actual, lo remueve de la pantalla
	y de la seleccion actual

	PARAMETROS:
		- element => elemento a remover (requerido)
	*/
	remove:(element)=>{
		let dbug = 0; // debug mode
		if(!element){return}
		if(list.dbug_mode || dbug){c.lof('comienza la funcion delete de list handler', '#5FA')}
		if(list.dbug_mode || dbug){c.log('elemento a eliminar: ', element)}

		// chequear si esta en la lista
		let is_on_the_list = list.current.findIndex(find => find.element_id === element.element_id) == -1 ? false : true;
		if( is_on_the_list ){
			if(list.dbug_mode || dbug){c.log('elemento está en la lista actual: ', list.current)}

			let index = list.current.findIndex(find => find.element_id === element.element_id);
			if(selection.dbug_mode || dbug){c.log('at index: ', index)}
			// quitar elemento de la lista
			list.current.splice(index, 1);
			selection.select(element);
			d.querySelector(".list").removeChild(d.querySelector('.element_'+element.element_id));
		}
		// si esta en la lista eliminarlo
		// si no, no hacer nada

		if(list.dbug_mode || dbug){c.log('NUEVA lista actual: ', list.current)}

		if(list.dbug_mode || dbug){c.lof('finaliza la funcion delete de list handler', '#F35')}
	},



	// TODO: hacer un filtro de priority
	load:(parent = false)=>{
		// c.log(parent.pky);
		let formData = new FormData();

		formData.append('ppk', parent.element_id);

		ajax2(formData, 'inc/load_elements.inc.php').then(response => {
			// c.log(response);
			// list.clear();

			let j=0;
			// if(response){
				response.forEach(element=>{

					// si el elemento no esta archivado se carga, sino se omite
					// TODO: hacer un selector de "cargar archivados=true/false"
					// if( !( element.arc == 1 && view_archived == false ) ){
						element.ord=j;j++;
						list.add(element)
					// }
				})
			// }
		})
	},
}
















const factory = {

	// AGREGAR LA POSIBILIDAD DE QUE LOS ELEMENTOS SEAN PRODUCTOS, QUE TENGAN PRECIO Y CANTIDADES Y QUE SUMEN LOS COSTOS DE LOS HIJOS ----------------------
	/*
	funcion principal de la fabrica de elementos

	PARAMETROS:
		REQUERIDOS:
			- text (TODO: cambiar a title, agregar excerpt y descripcion)
			- base => id de la base a la que se asigna el elemento
			- parent => id del padre del elemento
		OPCIONALES:
			- priority => utilizado actualmente como color
			- date => no conectado, hace falta filtros para que tenga sentido
			- user => esto esta hecho para guardar amigos, pero deberia estar hecho de otra forma
			- group => TODO: ver que hace esto
	*/
	create:(text,priority,date,user,base,parent,group)=>{
		let dbug = 0; // debug mode
		if(list.dbug_mode || dbug){c.lof('comienza la funcion create de factory', '#5FA')}

		if(!text){return}
		if(list.dbug_mode || dbug){c.lof('texto (futuro title): ', '#5AF')}
		if(list.dbug_mode || dbug){c.log( text )}
		if(list.dbug_mode || dbug){c.lof('priority (color): ', '#5AF')}
		if(list.dbug_mode || dbug){c.log( priority )}
		if(list.dbug_mode || dbug){c.lof('fecha (no conectado): ', '#5AF')}
		if(list.dbug_mode || dbug){c.log( date )}
		if(list.dbug_mode || dbug){c.lof('user: ', '#5AF')}
		if(list.dbug_mode || dbug){c.log( user )}
		if(list.dbug_mode || dbug){c.lof('base: ', '#5AF')}
		if(list.dbug_mode || dbug){c.log( base )}
		if(list.dbug_mode || dbug){c.lof('parent: ', '#5AF')}
		if(list.dbug_mode || dbug){c.log( parent )}
		if(list.dbug_mode || dbug){c.lof('group: ', '#5AF')}
		if(list.dbug_mode || dbug){c.log( group )}
		// dte = '0000-00-00 00:00:00';
		// if(dte == ''){dte = null}
		// if(upk == ''){upk = null}
		// c.log(dte);
    let formData = new FormData();

		formData.append('text', text);
		formData.append('priority', priority);
		formData.append('date', date);
		formData.append('user', user);
		formData.append('base', base);
    formData.append('parent', parent);
		formData.append('group', group);

    ajax2(formData, 'inc/create_element.inc.php').then(response => {
			if(list.dbug_mode || dbug){c.log('respuesta: ', response)}
			if(list.dbug_mode || dbug){c.log('elemento a añadir: ', response.element)}
			list.add(response.element);
			if(list.dbug_mode || dbug){c.lof('finaliza la funcion create de factory', '#F35')}
		});
	},

	/*
	delete

	elimina elementos de la lista de forma permanente (still on database)
	es un caso particular de la funcion mas general 'edit'

	PARAMETROS:
		- element => elemento a eliminar (required)
	*/
	delete: element => {
		let dbug = 0; // debug mode
		if(list.dbug_mode || dbug){c.lof('comienza la funcion delete de factory', '#5FA')}

		factory.edit(element,'del',1, true);

		if(list.dbug_mode || dbug){c.lof('finaliza la funcion delete de factory', '#F35')}
	},

	/*
	edit

	encargada de editar info de elementos en la base de datos y re dibujar
	elemento en la pantalla

	PARAMETROS:
		REQUERIDOS:
			- element => elemento a editar
			- key => nombre de la columna a editar
			- value => nuevo valor a guardar
		OPCIONALES:
			- remove => si es true se elimina el elemento de la lista
	*/
	edit: (element, key, value, remove = false) => {
		let dbug = 0; // debug mode
		if(list.dbug_mode || dbug){c.lof('comienza la funcion edit de factory', '#5FA')}


		let formData = new FormData();

		formData.append('element_id', element.element_id);
		formData.append('key', key);
		formData.append('value', value);

		ajax2(formData, 'inc/edit_element.inc.php').then(response => {
			// c.log(response)
			if( remove ){
				if(list.dbug_mode || dbug){c.lof('remover elemento de la pantalla', '#5AF')}
				list.remove(element);
				// d.querySelector(".list").removeChild(d.querySelector('.element_'+element.element_id));
			} else {
				if(list.dbug_mode || dbug){c.lof('actualizar elemento en la pantalla', '#5AF')}
				// response.element.element_id = response.element.element_id;
				// c.log(response.element);
				if(list.dbug_mode || dbug){c.log('Nuevo elemento', response.element)}
				list.update(response.element);
			}
			if(list.dbug_mode || dbug){c.lof('finaliza la funcion edit de factory', '#F35')}
		})
	},
}

















const main_button = {
	dbug_mode:false,
	// ESTADOS:
	// 0 = signo "+": abre y cierra el menu de nuevo elemento
	old:false,
	state: 0,
	setState:(state = false)=>{
		let dbug = 0; // debug mode
		if(main_button.dbug_mode || dbug){c.lof('comienza la funcion setState de button Zero', '#5FA')}
		if(main_button.dbug_mode || dbug){c.log('queremos setear el boton al estado: ', state)}
		let addNew = d.querySelector('.add_new');
		let button = d.querySelector('.button_zero');
		if(state === false){state = main_button.old}
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
				if (d.querySelector('.add_new_text').value) {
					main_button.setState(3);
					return;
				}
				button.classList.remove('send')
				button.classList.remove('check')
				button.classList.add('close')
				addNew.classList.add('alt')
				d.querySelector('.add_new_text').focus()
				break;
			case 3:
				button.classList.add('send')
				button.classList.remove('check')
				button.classList.remove('close')
				addNew.classList.add('alt')
				d.querySelector('.add_new_text').focus()
				break;
			default:
				main_button.setState(0);
				break;
		}
		if (main_button.old!=main_button.state) {
			main_button.old=main_button.state;
		}
		if(main_button.dbug_mode || dbug){c.log('old: ', main_button.old)}

		main_button.state=state

		if(main_button.dbug_mode || dbug){c.lof('finaliza la funcion setState de button Zero', '#F35')}
	},
	action:()=>{
		switch (main_button.state) {
			case 0:
				// altClassFromSelector('alt', '#addNew')
				main_button.setState(2);
				break;
			case 1:
				selection.current.forEach(element => {
					let new_state = d.querySelector('.element_'+element.element_id).getAttribute("tck") == 0 ? 1 : 0;
					factory.edit(element, 'tck', new_state);
				})
				break;
			case 2:
				// altClassFromSelector('alt', '#addNew');
				main_button.setState(0);
				break;
			case 3:
				let inputs=d.querySelector('.add_new').elements;
				let text=d.querySelector('.add_new_text').value;
				let color=d.querySelector('.colrOpt:checked').value;
				let date = '';
				let user = '';
				let base = JSON.parse(accounts.logged[0].base);
				let home = JSON.parse(accounts.logged[0].home);
				// c.log(text);
				// c.log(color);
				// c.log(base.bse);
				// c.log(base.pky);
				factory.create(
						text,
						color,
						date,
						user,
						base.element_id,
						// TODO: cambiar home.pky por el elemento actual
						history.list[0].element.element_id,
						// create:(text,priority,date,user,base,parent,group)
						'',
				);
				// altClassFromSelector('alt', '#addNew');
				main_button.setState(2);
				d.querySelector(".add_new_text").value="";
				break;
			default:
				c.log('caso default de estado');
		}
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

		logged:[],


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
					if(response.title == 'Success'){
						accounts.logged.push(response);
						// notify(response.title, response.message);
						// c.log(response)
						// c.log(accounts.logged);
						user_base = JSON.parse(response.base);
						user_home = JSON.parse(response.home);



						// TODO: aqui hay un problema
						// c.log(user_base);
						// c.log('home: ', user_home);
						// user_base.ppk = user_base.pky;

						favorites.load();

						first_entry = { element:user_home, }
						history.go_to(first_entry)
						// list.load(user_home);
						// list.load({ppk:767})
						select_view('view_main button0');

					}
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
					accounts.logged = [];
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
		// this.favorite = { tbl: "elementparent", col: "ppk", val: box.base.pky+2 , element_id: v.element_id };
		// Esta parte define las propiedades del elemento como vienen del objeto v
		for(var k in v){Object.defineProperty(this,k,{enumerable: true,value:v[k]})}
	}
	element_UI(parent_query, index){
		// Test to see if the browser supports the HTML template element by checking
		// for the presence of the template element's content attribute.
		if ('content' in d.createElement('template')) {

			// Instantiate the template
			// and the nodes you will control
			var draw = d.importNode(d.querySelector("#listElement").content, true),
			element = draw.querySelector(".element"),
			color   = draw.querySelector(".element_color"),
			count   = draw.querySelector(".element_count"),
			title   = draw.querySelector(".element_title"),
			buton   = draw.querySelector(".element_navigate");
			// Make your changes
			if(this.tck==1){element.classList.add("ticked")}
			element.classList.add('list_element')
			element.classList.add('element_'+this.element_id)
			// element.setAttribute('id', 'list_element'+this.ord);
			element.setAttribute('onclick', 'selection.select('+JSON.stringify(this)+')');

			let entry = {
				element:this,
			}
			// history.go(first_entry)
			element.setAttribute('ondblclick', 'history.go_to('+JSON.stringify(entry)+')');


			element.setAttribute('tck', this.tck);
			color.style.background = "var(--clrPty" + this.pty + ")";
			count.style.color = "var(--clrPty" + this.pty + ")";
			title.textContent = this.txt;
			// Insert it into the document in the right place
			let parent = d.querySelector( parent_query );
			parent.insertBefore(draw, parent.children[ index ]);
			// d.querySelector(".list").insertBefore(a, d.querySelector(".cancel"));
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
function get_cookie (n){var m=n+"=",a=d.cookie.split(';');for(var i=0;i<a.length;i++){var c=a[i];while(c.charAt(0)==' ')c=c.substring(1,c.length);if(c.indexOf(m)==0)return c.substring(m.length,c.length);}return null;}
function edit_cookie(n){createCookie(n,"",-1)}
