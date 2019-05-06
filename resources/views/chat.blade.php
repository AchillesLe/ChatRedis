<!DOCTYPE html>
<html>
<head>
	<title>Chat App</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<style type="text/css">
		*,
		*::before,
		*::after {
		  box-sizing: border-box;
		}
		html,
		body {
		  height: 100%;
		}
		body {
		  background: linear-gradient(135deg, #044f48, #2a7561);
		  background-size: cover;
		  font-family: 'Open Sans', sans-serif;
		  font-size: 14px;
		  line-height: 1.3;
		  overflow: hidden;
		}
		.btn-back{
			padding: 10px 20px;
			cursor: pointer;
			color: #fff;
			text-decoration: none;
			position: relative;
			z-index: 999;
			display: inline-block;
			padding: 5px;
			border: 1px solid #fff;
			border-radius: 3px;
			background: #248a52;
			width: 100px;
			text-align: center;
		}
		.btn-back::before{
			content: "\f0a5";
			font-family: "Font Awesome 5 Free"
		}
	</style>
</head>
<body>
	<div id="app">
		<div class="back">
			<a href="/chatroom" class="btn-back">Back</a>
		</div>
		<chat-layout></chat-layout>
	</div>
	<script src="{{asset('js/app.js')}}"></script>
</body>
</html>