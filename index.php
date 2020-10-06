<?php session_start(); ?>
<?php
	// version de List-A
	$version='4.0';
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
		<div class="element" tabindex="1">
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
<body class="view_log">






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
		<button class="btn btn_special" id="" onclick="accounts.log_in(d.getElementById('signInputNick').value,d.getElementById('signInputPass').value)">sign in</button>
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
			<div tabindex="1" class="element" onclick="box.loadElements(home)">
				<div class="element_color"></div>
				<p class="element_title">home</p>
				<p class="element_count" id="homeNmr">3</p>
			</div>

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

			<div tabindex="1" class="mainMenuElement" onclick="box.loadElements(tday)">
				<p class="mainMenuElementName">today</p>
				<p class="eNmr" id="tdayNmr"></p>
			</div>
			<div id="favsCont"></div>
			<div tabindex="1" class="mainMenuElement" onclick="box.loadElements(grps)">
				<p class="mainMenuElementName">groups</p>
				<p class="eNmr" id="grpsNmr"></p>
			</div>
			<div tabindex="1" class="mainMenuElement" onclick="box.loadElements(frnd)">
				<p class="mainMenuElementName">friends</p>
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
			<div tabindex="1" class="mainMenuElement" style="margin-top: auto;">
				<p class="mainMenuElementName" onclick="accounts.log_out()">Logout</p>
				<!-- <p class="mainMenuElementNumber"></p> -->
			</div>
		</menu>


		<section id="list">
			<!-- <article class="element title" tabindex="1">
				<div class="element_color"></div>
				<p   class="element_count"></p>
				<p   class="element_title" contenteditable="false">parent si yo tengo de repente un titulo muy muy largo, que se sale de la pantalla no deberia romper cosas</p>
				<p   class="element_short" contenteditable="false">Except</p>
				<p   class="element_texto" contenteditable="false">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla nec bibendum ipsum, et pretium orci. Nullam pulvinar rhoncus neque eu vehicula. Maecenas ut enim et mauris pretium commodo a ac justo. Donec tempor tincidunt urna a mollis.</p>
				<button class="element_navigate">
					<div id="element_navigate_dash1" class="element_navigate_dash"></div>
					<div id="element_navigate_dash2" class="element_navigate_dash"></div>
				</button>
			</article>


			<article class="element" id="this" tabindex="1" onclick="altClassFromSelector('selected','#this')">
				<div class="element_color"></div>
				<p   class="element_count">2</p>
				<p   class="element_title" contenteditable="false">Titulo</p>
				<p   class="element_short" contenteditable="false">Except</p>
				<p   class="element_texto" contenteditable="false">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla nec bibendum ipsum, et pretium orci. Nullam pulvinar rhoncus neque eu vehicula. Maecenas ut enim et mauris pretium commodo a ac justo. Donec tempor tincidunt urna a mollis.</p>
				<button class="element_navigate">
					<div id="element_navigate_dash1" class="element_navigate_dash"></div>
					<div id="element_navigate_dash2" class="element_navigate_dash"></div>
				</button>
			</article>


			<article class="element" tabindex="1">
				<div class="element_color"></div>
				<p   class="element_count">2</p>
				<p   class="element_title" contenteditable="false">Titulo</p>
				<p   class="element_short" contenteditable="false">Except</p>
				<p   class="element_texto" contenteditable="false">Lorem ipsum dolor quam porro...</p>
				<button class="element_navigate">
					<div id="element_navigate_dash1" class="element_navigate_dash"></div>
					<div id="element_navigate_dash2" class="element_navigate_dash"></div>
				</button>
			</article> -->
			<div class="cancel" tabindex="0">
				<svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512">
					<path fill="currentColor" d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"></path>
				</svg>
			</div>

			<!-- ------  Get involved and Point someone in the right direction  ------ -->
		</section>
	</view>









	<!-- <script type="text/javascript" src="js/custom.js?v=<?= $version; ?>"></script> -->
	<script type="text/javascript" src="js/main.js?v=<?= $version; ?>"></script>
</body>
</html>
