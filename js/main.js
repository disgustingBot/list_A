d=document;w=window;c=console;
// trataré de dar nombres semanticos al resto de las cosas,
// estos 3 quedan asi porque me permiten trabajar mas rapido


// Asi comienza nuestra historia,
w.addEventListener("load",()=>{
	log.set_state(0);
	d.getElementById("load").style.top="-100vh";
});








// =SHORTCODES
// space opens the action menu
// delete goes back on the history
// escape clears the selection
// enter does main button action (green buton bottom left), in log screen does log_in
w.addEventListener('keydown', event =>{
	// c.log(event.keyCode);
	// space opens the action menu
	if (event.keyCode ==  32){
		if((main_button.state != 0 && main_button.state != 1) || d.querySelector('body').classList.contains('view_log')){return}
		altClassFromSelector('action_menu_active','.action_menu')
		event.preventDefault();
	}
	// delete goes back on the history
	if (event.keyCode ==  8){
		// if(d.querySelector('body').classList.contains('view_log'))
		if((main_button.state != 0 && main_button.state != 1) || d.querySelector('body').classList.contains('view_log')){return}
		history.go_back();
		event.preventDefault();
	}
	// escape clears the selection
	if (event.keyCode ==  27){
		selection.clear();
		d.querySelector('.action_menu').classList.remove('action_menu_active');
	}
	// enter does main button action (green buton bottom left), in log screen does log_in
	if (event.keyCode == 13 && !event.shiftKey) {
		if (d.querySelector('body').classList.contains('view_log')){
			// c.log('hi there')
			// accounts.log_in('mail@testing.com', 'pass')
			accounts.log_in(d.querySelector('#log_input_mail'), d.querySelector('#log_input_pass'));
		} else {
			main_button.action();
		}
    event.preventDefault();
  }
})







// color console
c.lof = (message, farbe = false)=>{
	if(farbe){c.log("%c" + message, "color:" + farbe);}
	else{c.log(message)}
};

random = array => array[Math.floor(Math.random() * array.length)]




/*
=altClassFromSelector

alternates a class from a selector of choice, for example:
<div class="someButton" onclick="altClassFromSelector('activ', '#navBar')"></div>
*/
const altClassFromSelector = ( clase, selector, dont_remove = false )=>{
  const x = d.querySelector(selector);
  // if there is a main class removes all other classes
  if(dont_remove){
    x.classList.forEach( item =>{
      if( dont_remove.findIndex( element => element == item) == -1 && item!=clase ){
        x.classList.remove(item);
      }
    });
  }

  if(x.classList.contains(clase)){
		if(dont_remove){
			if( dont_remove.findIndex( element => element == clase) == -1 ){
				x.classList.remove(clase)
			}
		} else {
			x.classList.remove(clase)
		}
  }else{
		if(clase){
			x.classList.add(clase)
		}
  }
}



const acordionar = query => {
  // var panel = this.nextElementSibling;
  var panel = document.querySelector(query);
  panel.classList.toggle("alt");

  if (panel.style.maxHeight) {
    panel.style.maxHeight = null;
    // panel.style.padding = "0";
  } else {
    panel.style.maxHeight = panel.scrollHeight + "px";
    // panel.style.padding = "20px";
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
			d.querySelector('.list .element_' + history.list[0].element.element_id).classList.remove('title')
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
		d.querySelector('.list .element_' + entry.element.element_id).classList.add('title')
	},


	/*
	=history.go_to

	navega a la direccion solicitada, añadiendola al historial
	*/
	go_to:(entry)=>{
		let dbug = 0; // debug mode
		if(history.dbug_mode || dbug){c.lof('comienza la funcion go_to de history handler', '#5FA')}
		if(history.dbug_mode || dbug){c.log('OLD history: ', history.list)}
		if(history.dbug_mode || dbug){c.log('OLD current list: ', list.current)}


		if(history.list[0]){
			d.querySelector('.list .element_' + history.list[0].element.element_id).classList.remove('title')
		}

		list.clear();
		selection.clear();
		// añade la entrada al historial
		history.list.splice(0, 0, entry);
		// carga elementos en la lista
		list.load(entry.element)

		if(history.dbug_mode || dbug){c.log('NEW current list: ', list.current)}
		if(history.dbug_mode || dbug){c.log('NEW history: ', history.list)}

		// TODO: aqui deberia agregar el elemento actual
		list.add(entry.element, 0)
		d.querySelector('.list .element_' + entry.element.element_id).classList.add('title')
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
	=favorites.children_count

	aqui contaremos cantidad de hijos y actualizaremos la pantalla
	*/
	children_count: element => {

		let is_on_the_list = favorites.current.findIndex(find => find.element_id === element.element_id) == -1 ? false : true;
		if( is_on_the_list ){
			let formData = new FormData();

			formData.append('ppk', element.element_id);

			ajax2(formData, 'inc/load_elements.inc.php').then(response => {

				let cant = response.filter(element=>element.tck==0)
				if(cant.length>0){d.querySelector('.favorites .element_' + element.element_id + ' .element_count').innerHTML=cant.length}
			})
		}
	},


	/*
	=favorites.alternate

	alterna el estado de favorito de un elemento. Si es favorito lo quita, si no lo
	es lo agrega
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

		let favs = JSON.parse(accounts.logged[0].favorites);

		let formData = new FormData();
		formData.append('epk', element.element_id);
		formData.append('ppk', favs.element_id);

		ajax2(formData, 'inc/alt_parent.inc.php').then(response => {
			if(favorites.dbug_mode || dbug){c.log('respuesta: ', response)}
			if(response.title!='Error'){
				if(favorites.dbug_mode || dbug){c.log('already related?: ', response.already_related)}
				if( response.already_related ){
					favorites.remove( element );
				} else {
					favorites.draw( element );
				}
			}

			// response.forEach(element => {
				// favorites.draw(element);
			// })
			if(favorites.dbug_mode || dbug){c.lof('finaliza la funcion alternate de favorites handler', '#F35')}
		})
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
	draw:(element, position = 2, view_archived = false)=>{
		let dbug = 0; // debug mode
		if(!element){return}
		if(favorites.dbug_mode || dbug){c.lof('comienza la funcion draw de favorites handler', '#5FA')}

		if(favorites.current.length < position){
			position = favorites.current.length;
		}

		if(favorites.dbug_mode || dbug){c.log('elemento a añadir: ', element)}
		if(favorites.dbug_mode || dbug){c.log('favorites actual: ', favorites.current)}

		// si el elemento no esta archivado se carga, sino se omite
		// TODO: hacer un selector de "cargar archivados=true/false"
		if( !( element.arc == 1 && view_archived == false ) ){
			// add element to current list
			favorites.current.splice(position, 0, new Element(element));
			if(favorites.dbug_mode || dbug){c.log('NUEVA favorites actual: ', favorites.current)}
			// draw element on the screen
			favorites.current[position].element_UI('.favorites', position, true);
			favorites.children_count(element);

			// favorites.children_count(element);
		}

		if(favorites.dbug_mode || dbug){c.lof('finaliza la funcion draw de favorites handler', '#F35')}
	},



	/*
	=favorites.remove

	remueve elemento de la lista actual y lo quita de la pantalla
	PARAMETROS:
		REQUERIDOS:
			- element => elemento a añadir ( element )
	*/
	remove:(element, position = favorites.current.length, view_archived = false)=>{
		let dbug = 0; // debug mode
		if(!element){return}
		if(favorites.dbug_mode || dbug){c.lof('comienza la funcion remove de favorites handler', '#5FA')}
		if(favorites.dbug_mode || dbug){c.log('elemento a remover: ', element)}
		if(favorites.dbug_mode || dbug){c.log('favorites actual: ', favorites.current)}


		// chequear si esta en la lista
		let is_on_the_list = favorites.current.findIndex(find => find.element_id === element.element_id) == -1 ? false : true;
		if( is_on_the_list ){
			if(favorites.dbug_mode || dbug){c.log('elemento está en la lista actual: ', favorites.current)}

			let index = favorites.current.findIndex(find => find.element_id === element.element_id);
			if(selection.dbug_mode || dbug){c.log('at index: ', index)}
			// quitar elemento de la lista
			favorites.current.splice(index, 1);
			// selection.select(element);
			let lista = d.querySelector('.favorites');
			lista.removeChild(lista.querySelector('.element_'+element.element_id));
		}

		if(favorites.dbug_mode || dbug){c.lof('finaliza la funcion remove de favorites handler', '#F35')}
	},

	/*
	=favorites.load

	carga elementos en la lista de favoritos del menu
	*/
	load:()=>{
		let dbug = 0; // debug mode
		if(favorites.dbug_mode || dbug){c.lof('comienza la funcion load de favorites handler', '#5FA')}
		let favs = JSON.parse(accounts.logged[0].favorites);
		// let favs = JSON.parse(accounts.logged);
		// let favs = accounts.logged;
		if(favorites.dbug_mode || dbug){c.log('elemento favoritos: ', favs)}


		let formData = new FormData();
		formData.append('ppk', favs.element_id);

		ajax2(formData, 'inc/load_elements.inc.php').then(response => {
			response.forEach(element => {
				favorites.draw(element);
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
	=select_all

	selecciona todos los elementos de la lista
	*/
	select_all:()=>{
		selection.clear();
		list.current.forEach( element => { selection.select(element) });
	},

	/*
	=invert

	invierte la seleccion actual, todo lo que no este seleccionado lo selecciona,
	todo lo que este seleccionado lo des-selecciona
	*/
	invert:()=>{ list.current.forEach( element => { selection.select(element) }); },



	/*
	=selection.select

	alterna el la seleccion de un elemento. al seleccionar, si el elemento esta en
	selection.current lo quitamos, y si no esta lo añadimos.

	PARAMETROS:
		- element (required)
	*/
	select:(select)=>{
		let dbug = 0; // debug mode
		if(selection.dbug_mode || dbug){c.lof('comienza la funcion select de selection handler', '#5FA')}

		// TODO: chequear si es un elemento valido
		if(d.querySelector('.list .element_' + select.element_id)){
			altClassFromSelector('selected', '.list .element_' + select.element_id);
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

		let is_empty = selection.current == 0 ? true : false;
		if(is_empty==0){
			// elegir estado de check
			main_button.setState(1);
		} else {
			// elegir estado de add new
			main_button.setState(0);
		}

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
		selection.edit('del', 1, 1)
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
				if(cant.length>0){d.querySelector('.list .element_' + element.element_id + ' .element_count').innerHTML=cant.length}
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
	add:(element, position = 1, view_archived = false)=>{
		let dbug = 0; // debug mode
		if(!element){return}
		if(list.dbug_mode || dbug){c.lof('comienza la funcion add de list handler', '#5FA')}
		if(list.dbug_mode || dbug){c.log('elemento a añadir: ', element)}
		if(list.dbug_mode || dbug){c.log('lista actual: ', list.current)}

		if(list.current.length < position){
			position = list.current.length;
		}



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
			let lista = d.querySelector('.list');
			lista.removeChild(lista.querySelector('.element_'+element.element_id));
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

			// let j=0;
			// if(response){
				response.forEach(element=>{

					// si el elemento no esta archivado se carga, sino se omite
					// TODO: hacer un selector de "cargar archivados=true/false"
					// if( !( element.arc == 1 && view_archived == false ) ){
						// element.ord=j;j++;
						list.add(element)
					// }
				})
			// }
		})
	},
}















/*
=factory


*/
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

		if(element[key] != value){

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
		}
	},
}









/*
=production

responsable del menu inferior de produccion de elementos y editar
metodos:
- abrir
- cerrar
- crear
- editar
*/
const production = {
	dbug_mode:false,
	editing:false,

	menu:d.querySelector('.add_new'),
	text:d.querySelector('.add_new_text'),

	/*
	=production.open

	abre el menu
	*/
	open:()=>{
		if(production.menu.classList.contains('open')){return}
		production.menu.classList.add('open')
		// d.querySelector('.colrOpt[value="5"]').checked = true;
		d.querySelector('.add_new_text').focus()
	},

	/*
	=production.close

	cierra el menu
	*/
	close:()=>{
		if(production.menu.classList.contains('open')){
			production.menu.classList.remove('open')
			production.editing = false;
		}
	},

	/*
	=production.create

	crea un nuevo elemento
	*/
	create:()=>{
		// let inputs=d.querySelector('.add_new').elements;
		let text = production.text.value;
		let color= d.querySelector('.colrOpt:checked') ? d.querySelector('.colrOpt:checked').value : 5;
		let date = '';
		let user = '';
		let base = JSON.parse(accounts.logged[0].base);
		let home = JSON.parse(accounts.logged[0].home);
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
		d.querySelector(".add_new_text").value="";
	},

	/*
	=production.prepare_edit

	prepara el menu production para editar elementos con todo el poder del menu
	de crear elementos
	*/
	prepare_edit:()=>{
		// cierra el menu action
		d.querySelector('.action_menu').classList.remove('action_menu_active');
		// SETEAR TODOS LOS PARAMETROS DE EDICION POSIBLES IGUAL A LOS ELEMENTOS SELECCIONADOS
		// es decir, si son todos iguales ponerlo en production menu, si no nada
		// sets the text in the text input
		if ( selection.current.every( element => element.txt === selection.current[0].txt ) ) {
			production.text.value = selection.current[0].txt
		} else {
			production.text.value = '';
		}
		// sets the color in the color selector
		if ( selection.current.every( element => element.pty === selection.current[0].pty ) ) {
			d.querySelector('.colrOpt[value="'+selection.current[0].pty+'"]').checked = true;
		} else {
			if(d.querySelector('.colrOpt:checked')){
				d.querySelector('.colrOpt:checked').checked = false;
			}
		}

		production.editing = true;
	},

	/*
	=production.deep_edit

	enviar los cambios como edit a factory solo si el usuario cambió algo y
	solo si son diferentes a lo que ya tiene el elemento
	*/
	deep_edit:()=>{
		selection.current.forEach( element => {
			if (production.text.value){
				factory.edit(element, 'txt', production.text.value)
			}
			if (d.querySelector('.colrOpt:checked')){
				factory.edit(element, 'pty', d.querySelector('.colrOpt:checked').value)
			}
			// c.log(element);
		})
		production.text.value = '';
		production.editing = false;
	},
}


/*
=main_button


*/
const main_button = {
	dbug_mode:false,
	state: 0,

	/*
	=main_button.style

	selecciona el estilo del boton verde de abajo a la derecha
	*/
	style: design => {
		altClassFromSelector(design, '.button_zero', ['btn_round', 'button_zero', 'active', design])
	},

	/*
	=main_button.state_sync

	sincroniza el estado actual del boton con el que deberia tener
	*/
	state_sync: () => {
		let dbug = 0; // debug mode
		if(main_button.dbug_mode || dbug){c.lof('comienza la funcion state_sync de main_button', '#5FA')}
		if(main_button.dbug_mode || dbug){c.log('queremos setear el boton al estado: ', main_button.state)}

		switch (main_button.state) {
			case 0:
				main_button.style('plus');
				production.close();
				break;
			case 1:
				main_button.style('check');
				production.close();
				break;
			case 2:
			case 3:
				if(d.querySelector('.add_new_text').value){
					if(production.editing){
						main_button.state = 4;
					} else {
						main_button.state = 3;
					}
					main_button.style('send');
				} else {
					main_button.style('close');
					main_button.state = 2;
				}
				production.open();
				break;
			case 4:
				if(!production.editing){
					production.prepare_edit();
				}
				main_button.style('send');
				production.open();
				break;
			default:
				main_button.setState(0);
				break;
		}
		if(main_button.dbug_mode || dbug){c.lof('finaliza la funcion state_sync de main_button', '#F35')}
	},


	// ESTADOS:
	// 0 = signo "+": abre y cierra el menu de nuevo elemento
	setState:(state = false)=>{
		let dbug = 0; // debug mode
		if(main_button.dbug_mode || dbug){c.lof('comienza la funcion setState de button Zero', '#5FA')}
		if(main_button.dbug_mode || dbug){c.log('queremos setear el boton al estado: ', state)}
		switch (state) {
			case 0:
				main_button.style('plus');
				production.close();
				break;
			case 1:
				main_button.style('check');
				production.close();
				break;
			case 2:
				main_button.style('close');
				production.open();
				break;
			case 3:
				main_button.style('send');
				production.open();
				break;
			case 4:
				production.prepare_edit();
				main_button.style('send');
				production.open();
				break;
			default:
				main_button.setState(0);
				break;
		}
		main_button.state=state

		if(main_button.dbug_mode || dbug){c.lof('finaliza la funcion setState de button Zero', '#F35')}
	},
	action:()=>{
		let is_empty = selection.current == 0 ? true : false;
		switch (main_button.state) {
			case 0:
				if(production.text.value){
					main_button.setState(3);
				} else {
					main_button.setState(2);
				}
				break;
			case 1:
				selection.current.forEach(element => {
					let new_tck = element.tck == 0 ? 1 : 0;
					factory.edit(element, 'tck', new_tck);
				})
				break;
			case 2:
				if(is_empty==0){
					main_button.setState(1);
				} else {
					main_button.setState(0);
				}
				break;
			case 3:
				production.create();
				main_button.setState(2);
				break;
			case 4:
				if(is_empty==0){
					main_button.setState(1);
				} else {
					main_button.setState(0);
				}
				production.deep_edit();
				break;
			default:
				main_button.setState(2);
				c.log('caso default de estado');
		}
	},
}






/*
=log Handler

Se encarga de manejar el estado del formulario de log in y log out
*/
const log = {
	state:0,
	old:0,

	/*
	=log.clear

	borra todos los datos entrados en el formulario hasta ahora
	*/
	clear:()=>{
		d.querySelector('#log_input_mail').value = '';
		d.querySelector('#log_input_pass').value = '';
		d.querySelector('#log_input_pas2').value = '';
		d.querySelector('#log_input_nick').value = '';
		d.querySelector('#log_input_name').value = '';
		d.querySelector('#log_input_last').value = '';
	},

	/*
	=log.message

	para morstrar mensajes al usuario
	*/
	message: (content, color) => {
		let log_message = d.querySelector('.log_message');
		log_message.innerText = content;
		log_message.style.color = color;
	},

	set_state: state => {

		var message = d.querySelector('.log_message');
		var log_screen   = d.querySelector('.log');
		var left_button  = d.querySelector('#log_left_button');
		var right_button = d.querySelector('#log_right_button');


		log.old = log.state ? log.state : log.old;
		log.state = state;


		switch (state) {
			case 0:
					log_screen.classList.remove('log_in');
					log_screen.classList.remove('log_out');
					left_button.innerText  = 'Sign Up';
					left_button.setAttribute('onclick', "log.set_state(2)")
					right_button.innerText = 'Sign In';
					right_button.setAttribute('onclick', "log.set_state(1)")
					log.message('Hi, welcome!', 'white');
				break;
			case 1:
					log_screen.classList.add('log_in');
					left_button.innerText  = 'Cancel';
					left_button.setAttribute('onclick', "log.set_state(0)")
					right_button.innerText = 'Enter';
					right_button.setAttribute('onclick', "accounts.log_in(d.querySelector('#log_input_mail').value,d.querySelector('#log_input_pass').value)")
					log.message('U have an account, u know what to do...', 'white');
					if(log.state != log.old){
						log.clear();
					}
				break;
			case 2:
					log_screen.classList.add('log_out');
					left_button.innerText  = 'Cancel';
					left_button.setAttribute('onclick', "log.set_state(0)")
					right_button.innerText = 'Create';
					right_button.setAttribute('onclick', "accounts.create_user(0)")
					log.message('First timer!... WOW', 'white');
					if(log.state != log.old){
						log.clear();
					}
				break;
			default:
		}
		// if( state == 0 ){
		// }
	},
}








/*
=accounts Handler:

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
const accounts = {
    debugMode:0,

		logged:[],



		/*
		=update_card

		para actualizar la info de la cuenta

		PARAMETROS:
			REQUERIDOS:
				- user => usuario que va a poner
		*/
		update_card: user => {
        // debug mode
        let debugMode = 0;
				if(accounts.debugMode || debugMode){c.lof('----------------------------\ncomienza la funcion update_card\n----------------------------', '#5FA')}
				if(accounts.debugMode || debugMode){c.log('user: ', user)}
        if(accounts.debugMode || debugMode){c.log('user: ', user.data.first_name)}

				if(user.data.first_name){
					d.querySelector('.user_card_name').innerHTML = user.data.first_name;
					d.querySelector('.user_card_key').innerHTML = '#' + user.data.pky;
				}



				if(accounts.debugMode || debugMode){c.lof('----------------------------\nfinaliza la funcion update_card\n----------------------------', '#F35')}
		},


    /*
    =accounts.log_in
		=log_in

    *Parameters:
        REQUIRED:
            .mail
            .password
    */
    // TODO: -make this multiple account compatible
    log_in:(mail, password)=>{
			if( !mail || !password ){
				log.message('At least write something...', 'red');
				return;
			}
        let formData = new FormData();

        formData.append('log', mail);
        formData.append('pwd', password);

        ajax2(formData, 'inc/log_in.inc.php').then(response => {
					if(response.title == 'Success'){
						accounts.logged.push(response);
						// notify(response.title, response.message);
						c.log(response)
						// c.log(accounts.logged);
						user_base = JSON.parse(response.base);
						user_home = JSON.parse(response.home);



						// TODO: aqui hay un problema
						// c.log(user_base);
						// c.log('home: ', user_home);
						// user_base.ppk = user_base.pky;

						accounts.update_card(response);
						// favorites.draw( response.home, 0);
						favorites.draw( JSON.parse(response.home     ), 0);
						favorites.draw( JSON.parse(response.favorites), 1);
						favorites.draw( JSON.parse(response.groups   ), 2);
						favorites.draw( JSON.parse(response.friends  ), 3);
						favorites.load();
						home_entry      = { element:JSON.parse(response.home), }
						favorites_entry = { element:JSON.parse(response.favorites), }

						first_entry     = { element:JSON.parse(response.home), }
						history.go_to(first_entry)

						select_view('view_main button0');
						log.message('YEEEEEY!!', 'red');

					} else {
						log.message(response.message, 'red');
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
        if(!mail){mail = d.querySelector('#log_input_mail').value}
        if(!user){user = mail}
        if(!name){name = random(names)}
        if(!last){last = random(lasts)}
        if(!pwd1){pwd1 = d.querySelector('#log_input_pass').value}
        if(!pwd2){pwd2 = d.querySelector('#log_input_pas2').value}


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
									log.message(response.message, 'red');
                })
            }else{
							log.message("Use a real mail, cmon...", 'red');
            }
        }else{
					log.message("passwords don't match", 'red');
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
	element_UI(parent_query, index, enter_with_simple_click){
		// Test to see if the browser supports the HTML template element by checking
		// for the presence of the template element's content attribute.
		if ('content' in d.createElement('template')) {
			let entry = { element:this, }

			// Instantiate the template
			// and the nodes you will control
			let draw = d.importNode(d.querySelector("#listElement").content, true),
			element = draw.querySelector(".element"),
			color   = draw.querySelector(".element_color"),
			count   = draw.querySelector(".element_count"),
			title   = draw.querySelector(".element_title"),
			buton   = draw.querySelector(".element_navigate");


			let date   = draw.querySelector(".element_date");
			let the_date = Date.parse(this.tsp)
			date.textContent = this.tsp;
			// c.log(Date.parse(this.tsp))



			// Make your changes
			if(this.tck==1){element.classList.add("ticked")}
			element.classList.add('list_element')
			element.classList.add('element_'+this.element_id)
			// element.setAttribute('id', 'list_element'+this.ord);

			// TODO: hacer que no aparezca todo el JSON del elemento en el HTML
			// let select = 'selection.select(list.current['+ position +'])';
			let select = 'selection.select('+JSON.stringify(this)+')';
			let enter = 'history.go_to('+JSON.stringify(entry)+')';
			buton.setAttribute('onclick', enter);

			// history.go(first_entry)
			// element.setAttribute('onclick', 'selection.select('+JSON.stringify(this)+')');
			// element.setAttribute('ondblclick', 'history.go_to('+JSON.stringify(entry)+')');
			if( enter_with_simple_click ){
				element.setAttribute('onclick', enter);

			} else {
				element.setAttribute('onclick', select);
				element.setAttribute('ondblclick', enter);
			}


			element.setAttribute('tck', this.tck);
			color.style.background = "var(--clrPty" + this.pty + ")";
			count.style.color = "var(--clrPty" + this.pty + ")";
			title.textContent = this.txt;
			// title.innerHTML = this.txt;
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
function delete_cookie(n){createCookie(n,"",-1)}
