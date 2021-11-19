
/*
=friends

*/

const friends = {
	dbug_mode:0,
	list:[],

	/*
	=friends.add
	adds friend to list

	añade elemento a la lista actual y lo dibuja en la pantalla
	PARAMETROS:
		REQUERIDOS:
			- friend => elemento a añadir ( friend )
		OPCIONALES:
			- position => posicion en donde insertar el elemento ( número )
			- view_archived => ver favoritos? ( true || false )
	*/
	add:(friend, position = 0)=>{
		let dbug = 0; // debug mode

		friends.list.splice(position, 0, new Friend(friend));
		if(friends.dbug_mode || dbug){c.log('NUEVA lista actual: ', friends.list)}
		// draw element on the screen
		friends.list[position].friend_UI('.multiplayer_list', position);

	},

  remove: async friend => {
		let dbug = 1; // debug mode
		if(friends.dbug_mode || dbug){c.log('Delete: ', friend)}

		let is_ok = await relations.delete(friend);
		if(friends.dbug_mode || dbug){c.log('server says-> ', is_ok)}

		let formData = new FormData();
		formData.append('userB_id', friend);
		// ajax2(formData, 'inc/delete_friend.inc.php').then(response => {
		// 	if(friends.dbug_mode || dbug){c.log('Response: ', response)}
		//
		// 	// response.forEach(friend=>{
		// 	// 	friends.add(friend, 0)
		// 	// })
		// })
  },

	/*
	=friends.load
	*/
	// TODO: hacer un filtro de priority
	load:(parent = false)=>{
		// c.log(parent.pky);
		let formData = new FormData();

		// formData.append('ppk', parent.element_id);
		// TODO: aca deberia enviar un token generado en el login
		// formData.append('user_id', accounts.logged[0].data.pky);


		ajax3(formData, 'inc/load_friends.inc.php').then(response => {
			c.log(response)
			response.forEach(friend=>{
				friends.add(friend, 0)
			})
		})
	},
}
// friends.load();





/*
=relations

this object will take care of handling user relations
*/
const relations = {
	create:( userB_email )=>{
		if(!userB_email){
			userB_email = d.querySelector('.multiplayer_add').value;
		}
		c.log(userB_email);
		let formData = new FormData();

		formData.append('userB_email', userB_email);
		// TODO: aca deberia enviar un token generado en el login
		// formData.append('user_id', accounts.logged[0].data.pky);


		ajax2(formData, 'inc/relate_users.inc.php').then(response => {
			c.log(response)
			if(response.status != '0'){
				notify(response.title, response.message)
			}else{
				friends.add(response.user[0], 0)
			}
		})
	},

  delete:async (userB_email)=>{
		// c.log(parent.pky);
		let formData = new FormData();
		formData.append('userB_email', userB_email);
		return await ajax3(formData, 'inc/unrelate_users.inc.php')
  },
}






// element class
// se crea el elemento dandole de comer "elementValues", que es un objecto
class Friend {
	constructor(v){
		// Esta parte define las propiedades del elemento como vienen del objeto v
		for(var k in v){Object.defineProperty(this,k,{enumerable: true,value:v[k]})}
	}
	friend_UI(parent_query, index, enter_with_simple_click){
		// Test to see if the browser supports the HTML template element by checking
		// for the presence of the template element's content attribute.
		if ('content' in d.createElement('template')) {
			let entry = { element:this, }

			// Instantiate the template
			// and the nodes you will control
			let draw = d.importNode(d.querySelector("#friend_template").content, true),
			name      = draw.querySelector(".friend_name"),
			trash_can = draw.querySelector('.friend_delete');

			// c.log(this)
			let remove_function = 'friends.remove("'+this.eml+'")';


			// Make your changes
			name.textContent = this.uid;
			trash_can.setAttribute('onclick', remove_function);

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
