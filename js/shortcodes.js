



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
		let is_user_writing = document.querySelector('input:focus')
		if (is_user_writing){return}
		if(document.querySelector('body').classList.contains('view_log')){return}
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
			accounts.log_in('mail@testing.com', 'pass')
			// accounts.log_in(d.querySelector('#log_input_mail'), d.querySelector('#log_input_pass'));
		} else {
			main_button.action();
		}
    event.preventDefault();
  }
})
