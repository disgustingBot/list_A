<?php session_start(); ?>
<?php
	// version de List-A
	$version='5.0';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, user-scalable=no">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>List-A</title>
	<link rel="shortcut icon" href="img/lg.png" >
	<meta name=      "mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<!-- Mis estilos -->
	<link rel="stylesheet" type="text/css" href="css/main.css?v=<?= $version; ?>">
	<!-- <link rel="stylesheet" type="text/css" href="css/style.css?v=<?= $version; ?>"> -->






	<!-- TEMPLATES -->
	<!-- <div class="element" onclick="box.selectElement(this.id)" onfocusout="if(box.slct[0]){box.slct[0].sendEdit()}" tabindex="1"> -->
	<!-- <div class="element" onfocusout="if(box.slct[0]){box.slct[0].sendEdit()}" tabindex="1"> -->
	<!-- <div class="element" onfocusout="if(box.slct[0]){selection.sendEdit(selection.current[0])}" tabindex="1"> -->
	<template id="listElement">

		<div class="element" tabindex="1">
			<div class="element_color"></div>
			<p   class="element_count"></p>
			<p   class="element_title" contenteditable="false"></p>
			<p   class="element_date" contenteditable="false"></p>
			<p   class="element_short" contenteditable="false"></p>
			<p   class="element_texto" contenteditable="false"></p>
			<button class="element_navigate">
				<div id="element_navigate_dash1" class="element_navigate_dash"></div>
				<div id="element_navigate_dash2" class="element_navigate_dash"></div>
			</button>
		</div>
	</template>

	<template id="favsElement">
		<div class="mainMenuElement" tabindex="1">
			<div class="element_color"></div>
			<p class="element_title"></p>
			<p class="eNmr"></p>
		</div>
	</template>

	<template id="frndElement">
		<li class="friendListElement">
			<input class="friendListInput" type="checkbox" id="" name="" value="">
			<label for="" class="frndClr">
				<p class="frndTxt"></p>
			</label>
		</li>
	</template>

	<template id="cancelTemp">
		<!-- <div class="cancel" onclick="box.cancel()" tabindex="0"> -->
		<div class="cancel" tabindex="0">
			<svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512">
				<path fill="currentColor" d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"></path>
			</svg>
		</div>
	</template>








</head>
<body class="view_log button0">






	<view id="load" class="load"><div class="circle"></div></view>

	<!-- <div class="redDot test" onclick="accounts.log_out();"></div> -->

	<div class="alert" id="alert">
		<button class="btn_close" onclick="altClassFromSelector('visible', '.alert')">
			<div class="btn_close_bar"></div>
			<div class="btn_close_bar"></div>
		</button>
		<h4 class="alert_title">alert title</h4>
		<p class="alert_txt">alert text</p>
	</div>






	<view class="log">
		<h2 class="log_title">list<br><span class="log_titleA">A</span></h2>
		<!-- <div id="blockView"></div> -->
		<form class="log_form">
			<p class="log_message"></p>
			<!-- cool article -->
			<!-- https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#attr-fe-autocomplete-name%20exhaustive%20list%20of%20autocomplete/autofill%20tags%20for%20html%20form%20inputs -->
			<input class="log_input" id="log_input_mail" name="log" type="text"     placeholder="E-mail*"          autocomplete="username">
			<input class="log_input" id="log_input_pass" name="pwd" type="password" placeholder="Password*"        autocomplete="current-password">
			<input class="log_input" id="log_input_pas2" name="pw2" type="password" placeholder="Repeat password*">
			<input class="log_input" id="log_input_nick" name="uid" type="text"     placeholder="Nick name"       >
			<input class="log_input" id="log_input_name" name="fst" type="text"     placeholder="First name"      >
			<input class="log_input" id="log_input_last" name="lst" type="text"     placeholder="Last name"       >
			<p class="log_conditions">
				By registering to our site you accept the still unexisting
				<span>privacy policy</span> and <span>data handling.</span>
			</p>
		</form>

		<button class="btn" id="log_left_button" onclick="log.set_state(2)"></button>
		<button class="btn btn_special" id="log_right_button" onclick="log.set_state(1)"></button>
		<!-- <button class="btn btn_special" id="" onclick="accounts.log_in(d.getElementById('logInputMail').value,d.getElementById('logInputPass').value)">sign in</button> -->
	</view>



	<view class="main">
		<?php // echo json_encode($_SESSION); ?>

		<button class="burger" onclick="altClassFromSelector('main_menu_active', '.main')">
			<div class="burgerBar"></div>
			<div class="burgerBar"></div>
			<div class="burgerBar"></div>
		</button>

		<menu class="main_menu">
			<!-- TODO: account -->
			<!-- <figure id="mainMenuProfile" onclick="box.loadElements(box.base)"> -->
			<figure class="user_card" onclick="altClassFromSelector('alt','#user')">
				<svg class="user_card_pic" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"></path></svg>
				<figcaption class="user_card_caption">
					<h3 class="user_card_name"></h3>
					<p class="user_card_key"></p>
				</figcaption>

				<!-- <button class="mainMenuClose" onclick="altClassFromSelector('main_menu_active', '.main_menu')">
					<div class="mainMenuCloseBar"></div>
					<div class="mainMenuCloseBar"></div>
				</button> -->
			</figure>

			<div class="favorites"></div>

			<!-- TODO: Tags   -->
			<!-- TODO: Config -->

			<div tabindex="1" class="element" style="margin-top: auto;">
				<div class="element_color" style="background:var(--color6)"></div>
				<p class="element_title" onclick="accounts.log_out()">Logout</p>
				<!-- <p class="mainMenuElementNumber"></p> -->
			</div>
		</menu>



					<menu class="action_menu">
						<div class="action_menu_title">
							<h5>Action</h5>

							<button class="action_btn" onclick="altClassFromSelector('action_menu_active','.action_menu')">
								<div class="action_btn_dot"></div>
								<div class="action_btn_dot"></div>
								<div class="action_btn_dot"></div>
							</button>
							<!-- <button class="mainMenuClose" onclick="altClassFromSelector('active', '#secdMenu')">
								<div class="mainMenuCloseBar"></div>
								<div class="mainMenuCloseBar"></div>
							</button> -->

						</div>
						<div class="element title" onclick="altClassFromSelector('alt', '.selection_menu')">
							<!-- <div class="element_color"></div> -->
							<p   class="element_title" contenteditable="false">Selection</p>
						</div>
						<menu class="action_submenu selection_menu">
							<!-- <p class="action_submenu_title">Selection</p> -->

							<div class="element" onclick="selection.select_all()" tabindex="1">
								<!-- <div class="element_color"></div> -->
								<p   class="element_title" contenteditable="false">Select All</p>
							</div>
							<div class="element" onclick="selection.invert()" tabindex="1">
								<!-- <div class="element_color"></div> -->
								<p   class="element_title" contenteditable="false">Invert</p>
							</div>
							<div class="element" onclick="selection.clear()" tabindex="1">
								<!-- <div class="element_color"></div> -->
								<p   class="element_title" contenteditable="false">Clear</p>
							</div>

						</menu>
						<div class="element title" onclick="altClassFromSelector('alt', '.edit_menu')">
							<!-- <div class="element_color"></div> -->
							<p   class="element_title" contenteditable="false">Edit</p>
						</div>
						<menu class="action_submenu edit_menu">

							<!-- <div class="element" onclick="production.prepare_edit()"> -->
							<div class="element" onclick="main_button.setState(4)">
								<!-- <div class="element_color"></div> -->
								<p   class="element_title">Deep edit</p>
							</div>

							<!-- <div class="action_menu_option"><button class="action_menu_button" onclick="selection.enable_text_edit(selection.current[0])">Edit text</button></div> -->

							<div class="element" onclick="selection.edit('pty', 1)" tabindex="1">
								<div class="element_color" style="background:var(--clrPty1)"></div>
								<p class="element_title">Nice</p>
							</div>
							<div class="element" onclick="selection.edit('pty', 2)" tabindex="1">
								<div class="element_color" style="background:var(--clrPty2)"></div>
								<p class="element_title">忍者</p>
							</div>

							<div class="element" onclick="selection.edit('pty', 3)" tabindex="1">
								<div class="element_color" style="background:var(--clrPty3)"></div>
								<p class="element_title">L</p>
							</div>
							<div class="element" onclick="selection.edit('pty', 4)" tabindex="1">
								<div class="element_color" style="background:var(--clrPty4)"></div>
								<p class="element_title">G</p>
							</div>
							<div class="element" onclick="selection.edit('pty', 5)" tabindex="1">
								<div class="element_color" style="background:var(--clrPty5)"></div>
								<p class="element_title">B</p>
							</div>
							<div class="element" onclick="selection.edit('pty', 6)" tabindex="1">
								<div class="element_color" style="background:var(--clrPty6)"></div>
								<p class="element_title">T</p>
							</div>
							<div class="element" onclick="selection.edit('pty', 7)" tabindex="1">
								<div class="element_color" style="background:var(--clrPty7)"></div>
								<p class="element_title">Q</p>
							</div>
							<div class="element" onclick="selection.edit('pty', 8)" tabindex="1">
								<div class="element_color" style="background:var(--clrPty8)"></div>
								<p class="element_title">+</p>
							</div>
							<!-- <button for="amrSM" class="colrOption" onclick="selection.edit('pty', 1)"><span id="amrCirc" class="checkmark"></span><p class="colrOptP">Bolt  </p></button>
							<button for="rojSM" class="colrOption" onclick="selection.edit('pty', 2)"><span id="rojCirc" class="checkmark"></span><p class="colrOptP">Fire  </p></button>
							<button for="verSM" class="colrOption" onclick="selection.edit('pty', 3)"><span id="verCirc" class="checkmark"></span><p class="colrOptP">Gold  </p></button>
							<button for="azlSM" class="colrOption" onclick="selection.edit('pty', 4)"><span id="azlCirc" class="checkmark"></span><p class="colrOptP">Marine</p></button>
							<button for="blcSM" class="colrOption" onclick="selection.edit('pty', 5)"><span id="blcCirc" class="checkmark"></span><p class="colrOptP">Void  </p></button>
							<button for="njaSM" class="colrOption" onclick="selection.edit('pty', 6)"><span id="njaCirc" class="checkmark"></span><p class="colrOptP">Ninja </p></button> -->
						</menu>

						<div class="action_menu_option"><button class="action_menu_button" onclick="selection.current.forEach( element => { favorites.alternate( element ) } )">Favorite</button></div>
						<div class="action_menu_option"><button class="action_menu_button" onclick="selection.edit('arc', 1)">Archive </button></div>
						<div class="action_menu_option"><button class="action_menu_button" onclick="selection.delete()">Delete  </button></div>
					</menu>


		<section class="list">

			<div class="cancel" tabindex="0" onclick="selection.clear()">
				<svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512">
					<path fill="currentColor" d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"></path>
				</svg>
			</div>

			<div class="add_new">

				<!-- <div id="button0" class="btn_round button_zero active" tabindex="0" onclick="altClassFromSelector('alt', '.add_new')"> -->
				<div id="button0" class="btn_round button_zero active" tabindex="0" onclick="main_button.action()">
					<div class="mainButtonBar" id="mainButtonBar1"></div>
					<div class="mainButtonBar" id="mainButtonBar2"></div>
				</div>

				<!-- oninput="
				if(this.value){
					if(main_button.old){
						main_button.old=main_button.state;
					}
					main_button.setState(3);
				}else{
					main_button.setState(2);
				};" -->
				<!-- 日本語！！ -->
				<textarea
					class="add_new_text"
					type="text"
					placeholder="Title"
					autocomplete="off"
					oninput="main_button.state_sync();"
					onkeydown="if (this.clientHeight < this.scrollHeight) this.style.height=this.scrollHeight+'px';"></textarea>

				<!-- <span class="addNewButton" id="addNewFrnd">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"></path></svg>
					<input class="addNewFrndInput" type="number" name="friendId" value="">
				</span> -->

				<!-- <span class="addNewButton" id="addNewDate">
					<svg aria-hidden="true" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M400 64h-48V12c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v52H160V12c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v52H48C21.5 64 0 85.5 0 112v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V112c0-26.5-21.5-48-48-48zm-6 400H54c-3.3 0-6-2.7-6-6V160h352v298c0 3.3-2.7 6-6 6z"></path></svg>

					<div class="" id="datePicker">
						<input type="date" id="dateInput">
					</div>
				</span> -->

				<span class="add_new_button add_new_prty" tabindex="0">
					<svg aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M349.565 98.783C295.978 98.783 251.721 64 184.348 64c-24.955 0-47.309 4.384-68.045 12.013a55.947 55.947 0 0 0 3.586-23.562C118.117 24.015 94.806 1.206 66.338.048 34.345-1.254 8 24.296 8 56c0 19.026 9.497 35.825 24 45.945V488c0 13.255 10.745 24 24 24h16c13.255 0 24-10.745 24-24v-94.4c28.311-12.064 63.582-22.122 114.435-22.122 53.588 0 97.844 34.783 165.217 34.783 48.169 0 86.667-16.294 122.505-40.858C506.84 359.452 512 349.571 512 339.045v-243.1c0-23.393-24.269-38.87-45.485-29.016-34.338 15.948-76.454 31.854-116.95 31.854z"></path></svg>
				</span>

				<div class="add_new_colr">
					<label for="color_1" class="colrOption"><input type="radio" name="colr" id="color_1" class="colrOpt" value="1" checked><span class="checkmark bg_color_1"></span><p class="colrOptP">Nice  </p></label>
					<label for="color_2" class="colrOption"><input type="radio" name="colr" id="color_2" class="colrOpt" value="2"        ><span class="checkmark bg_color_2"></span><p class="colrOptP">忍者   </p></label>
					<label for="color_3" class="colrOption"><input type="radio" name="colr" id="color_3" class="colrOpt" value="3"        ><span class="checkmark bg_color_3"></span><p class="colrOptP">L</p></label>
					<label for="color_4" class="colrOption"><input type="radio" name="colr" id="color_4" class="colrOpt" value="4"        ><span class="checkmark bg_color_4"></span><p class="colrOptP">G</p></label>
					<label for="color_5" class="colrOption"><input type="radio" name="colr" id="color_5" class="colrOpt" value="5"        ><span class="checkmark bg_color_5"></span><p class="colrOptP">B</p></label>
					<label for="color_6" class="colrOption"><input type="radio" name="colr" id="color_6" class="colrOpt" value="6"        ><span class="checkmark bg_color_6"></span><p class="colrOptP">T</p></label>
					<label for="color_7" class="colrOption"><input type="radio" name="colr" id="color_7" class="colrOpt" value="6"        ><span class="checkmark bg_color_7"></span><p class="colrOptP">Q</p></label>
					<label for="color_8" class="colrOption"><input type="radio" name="colr" id="color_8" class="colrOpt" value="6"        ><span class="checkmark bg_color_8"></span><p class="colrOptP">+</p></label>
				</div>

				<!-- <span class="addNewButton" id="addNewSend">
					<svg aria-hidden="true" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg>
				</span> -->
			</div>
			<!-- ------  Get involved and point someone in the right direction  ------ -->
		</section>


				<button class="back_btn" onclick="history.go_back()">
					<div class="back_btn_bar back_btn_bar2"></div>
					<div class="back_btn_bar back_btn_bar1"></div>
				</button>



		<!-- <div class="add_new" onkeypress="return event.keyCode != 13;"> -->

	</view>









	<script type="text/javascript" src="js/main.js?v=<?= $version; ?>"></script>


		<script type="text/javascript">
			<?php if ($_SESSION) { ?>
				let session = <?php echo json_encode($_SESSION); ?>;
				// console.log(session)

				accounts.logged.push(session);


				user_base = JSON.parse(session.base);
				user_home = JSON.parse(session.home);


				accounts.update_card(session);
				favorites.draw(JSON.parse( session.home      ), 0);
				favorites.draw(JSON.parse( session.favorites ), 1);
				// favorites.draw(JSON.parse( session.groups    ), 2);
				favorites.draw(JSON.parse( session.friends   ), 3);
				favorites.load();
				home_entry      = { element:JSON.parse(session.home), }
				favorites_entry = { element:JSON.parse(session.favorites), }

				first_entry     = { element:JSON.parse(session.home), }
				history.go_to(first_entry)

				select_view('view_main button0');
			<?php } ?>
		</script>
</body>
</html>
