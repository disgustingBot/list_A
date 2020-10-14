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
	<template id="listElement">
		<!-- <div class="element" onfocusout="if(box.slct[0]){box.slct[0].sendEdit()}" tabindex="1"> -->

		<!-- <div class="element" onfocusout="if(box.slct[0]){selection.sendEdit(selection.current[0])}" tabindex="1"> -->
		<div class="element" onfocusout="selection.send_text_edit(selection.current[0])" tabindex="1">
			<div class="element_color"></div>
			<p   class="element_count"></p>
			<p   class="element_title" contenteditable="false"></p>
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
			<input class="log_input" id="logInputMail" name="eml" type="text"     placeholder="E-mail*"         >
			<input class="log_input" id="logInputPass" name="pwd" type="password" placeholder="Password*"       >
			<input class="log_input" id="logInputPas2" name="pw2" type="password" placeholder="Repeat password*">
			<input class="log_input" id="logInputNick" name="uid" type="text"     placeholder="Nick name"       >
			<input class="log_input" id="logInputName" name="fst" type="text"     placeholder="First name"      >
			<input class="log_input" id="logInputLast" name="lst" type="text"     placeholder="Last name"       >
			<p class="log_conditions">
				By registering to our site you accept the still unexisting
				<span>privacy policy</span> and <span>data handling.</span>
			</p>
		</form>

		<button class="btn" id="" onclick="accounts.create_user()">sign up</button>
		<button class="btn btn_special" id="" onclick="accounts.log_in(d.getElementById('logInputMail').value,d.getElementById('logInputPass').value)">sign in</button>
	</view>



	<view class="main">
		<menu class="main_menu">
			<!-- TODO: account -->
			<!-- <figure id="mainMenuProfile" onclick="box.loadElements(box.base)"> -->
			<figure class="user_card" onclick="altClassFromSelector('alt','#user')">
				<svg class="user_card_pic" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"></path></svg>
				<figcaption class="user_card_caption">
					<h3 class="user_card_name"></h3>
					<p class="user_card_key"></p>
				</figcaption>

				<button class="mainMenuClose" onclick="altClassFromSelector('active', '#mainMenu')">
					<div class="mainMenuCloseBar"></div>
					<div class="mainMenuCloseBar"></div>
				</button>
			</figure>

			<!-- TODO: aqui todos tendrian que ser hijos de favorites -->
			<div tabindex="1" class="element" onclick="history.go_to(home_entry)">
				<!-- <div class="element_color"></div> -->
				<p class="element_title">home</p>
				<p class="element_count">3</p>
			</div>
			<div tabindex="1" class="element" onclick="history.go_to(favorites_entry)">
				<!-- <div class="element_color"></div> -->
				<p class="element_title">favorites</p>
				<p class="element_count">3</p>
			</div>

			<div class="favorites"></div>

			<!-- <article class="element" tabindex="1">
				<div class="element_color"></div>
				<p   class="element_count"></p>
				<p   class="element_title" contenteditable="false">parent si yo tengo de repente un titulo muy muy largo, que se sale de la pantalla no deberia romper cosas</p>
				<p   class="element_short" contenteditable="false">Except</p>
				<p   class="element_texto" contenteditable="false">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla nec bibendum ipsum, et pretium orci. Nullam pulvinar rhoncus neque eu vehicula. Maecenas ut enim et mauris pretium commodo a ac justo. Donec tempor tincidunt urna a mollis.</p>
				<button class="element_navigate">
					<div id="element_navigate_dash1" class="element_navigate_dash"></div>
					<div id="element_navigate_dash2" class="element_navigate_dash"></div>
				</button>
			</article> -->

			<!-- <div tabindex="1" class="element" onclick="box.loadElements(tday)">
				<div id="favsCont"></div>
				<p class="element_title">today</p>
				<p class="eNmr" id="tdayNmr"></p>
			</div> -->

			<div tabindex="1" class="element" onclick="box.loadElements(grps)">
				<!-- <div class="element_color"></div> -->
				<p class="element_title">groups</p>
				<p class="element_count">3</p>
			</div>
			<div tabindex="1" class="element" onclick="box.loadElements(frnd)">
				<!-- <div class="element_color"></div> -->
				<p class="element_title">friends</p>
				<p class="eNmr" id="frndNmr"></p>
			</div>

<!-- TODO: Tags
			<div tabindex="1" class="mainMenuElement">
				<p class="mainMenuElementName">Tags</p>
				<p class="mainMenuElementNumber">9</p>
			</div>
-->
<!-- TODO: Config
			<div tabindex="1" class="mainMenuElement">
				<p class="mainMenuElementName">Config</p>
				<p class="mainMenuElementNumber"></p>
			</div>
-->
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
						<div class="action_menu_option"><button class="action_menu_button" onclick="selection.enable_text_edit(selection.current[0])">Edit text</button></div>

						<button for="amrSM" class="colrOption" onclick="selection.edit('pty', 1)"><span id="amrCirc" class="checkmark"></span><p class="colrOptP">Bolt  </p></button>
						<button for="rojSM" class="colrOption" onclick="selection.edit('pty', 2)"><span id="rojCirc" class="checkmark"></span><p class="colrOptP">Fire  </p></button>
						<button for="verSM" class="colrOption" onclick="selection.edit('pty', 3)"><span id="verCirc" class="checkmark"></span><p class="colrOptP">Gold  </p></button>
						<button for="azlSM" class="colrOption" onclick="selection.edit('pty', 4)"><span id="azlCirc" class="checkmark"></span><p class="colrOptP">Marine</p></button>
						<button for="blcSM" class="colrOption" onclick="selection.edit('pty', 5)"><span id="blcCirc" class="checkmark"></span><p class="colrOptP">Void  </p></button>
						<button for="njaSM" class="colrOption" onclick="selection.edit('pty', 6)"><span id="njaCirc" class="checkmark"></span><p class="colrOptP">Ninja </p></button>

						<div class="action_menu_option"><button class="action_menu_button" onclick="selection.current.forEach( element => { favorites.alternate( element ) } )">Favorite</button></div>
						<div class="action_menu_option"><button class="action_menu_button" onclick="selection.edit('arc', 1)">Archive </button></div>
						<!-- <div class="action_menu_option"><button class="action_menu_button" onclick="box.slct.forEach(function(v){v.editElement('del',1 ,1)});box.cancel()">Delete  </button></div> -->
						<div class="action_menu_option"><button class="action_menu_button" onclick="selection.delete()">Delete  </button></div>
					</menu>


		<section class="list">

			<div class="cancel" tabindex="0" onclick="selection.clear()">
				<svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512">
					<path fill="currentColor" d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"></path>
				</svg>
			</div>

			<!-- ------  Get involved and point someone in the right direction  ------ -->
		</section>


				<button class="back_btn" onclick="history.go_back()">
					<div class="back_btn_bar back_btn_bar2"></div>
					<div class="back_btn_bar back_btn_bar1"></div>
				</button>



		<!-- <div class="add_new" onkeypress="return event.keyCode != 13;"> -->
		<div class="add_new">

			<!-- <div id="button0" class="btn_round button_zero active" tabindex="0" onclick="altClassFromSelector('alt', '.add_new')"> -->
			<div id="button0" class="btn_round button_zero active" tabindex="0" onclick="main_button.action()">
				<div class="mainButtonBar" id="mainButtonBar1"></div>
				<div class="mainButtonBar" id="mainButtonBar2"></div>
			</div>

			<textarea
				class="add_new_text"
				type="text"
				placeholder="Write"
				autocomplete="off"
				oninput="
				if(this.value){
					if(main_button.old){
						main_button.old=main_button.state;
					}
					main_button.setState(3);
				}else{
					main_button.setState();
					d.querySelector('#button0').classList.remove('send');
				};"
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
				<label for="ver" class="colrOption"><input type="radio" name="colr" id="ver" class="colrOpt" value="1"        ><span id="amrCirc" class="checkmark"></span><p class="colrOptP">Bolt  </p></label>
				<label for="roj" class="colrOption"><input type="radio" name="colr" id="roj" class="colrOpt" value="2"        ><span id="rojCirc" class="checkmark"></span><p class="colrOptP">Fire  </p></label>
				<label for="amr" class="colrOption"><input type="radio" name="colr" id="amr" class="colrOpt" value="3"        ><span id="verCirc" class="checkmark"></span><p class="colrOptP">Gold  </p></label>
				<label for="azl" class="colrOption"><input type="radio" name="colr" id="azl" class="colrOpt" value="4"        ><span id="azlCirc" class="checkmark"></span><p class="colrOptP">Marine</p></label>
				<label for="blc" class="colrOption"><input type="radio" name="colr" id="blc" class="colrOpt" value="5" checked><span id="blcCirc" class="checkmark"></span><p class="colrOptP">Void  </p></label>
				<label for="nja" class="colrOption"><input type="radio" name="colr" id="nja" class="colrOpt" value="6"        ><span id="njaCirc" class="checkmark"></span><p class="colrOptP">Ninja </p></label>
			</div>

			<!-- <span class="addNewButton" id="addNewSend">
				<svg aria-hidden="true" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg>
			</span> -->
		</div>
	</view>









	<!-- <script type="text/javascript" src="js/custom.js?v=<?= $version; ?>"></script> -->
	<script type="text/javascript" src="js/main.js?v=<?= $version; ?>"></script>
</body>
</html>
