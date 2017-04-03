<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html>
<head>
	<script src="http://code.jquery.com/jquery-latest.min.js"></script>
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu">
	
	<style>
		div.block {
			padding: 0.5em;
			display: flex;
		}
		div, textarea, button, i {
			font-family: 'Ubuntu', sans-serif;
			font-size: 12pt;
		}
		.note {
			width: 100%;
			padding: 0.7em;
    		overflow: hidden;
			border: 0.1em solid;
			border-left: 0.2em solid;
		}
		div.note {
			overflow-wrap: break-word;
			white-space: pre-wrap;
			border-color: #0000CC;
		}
		div.note-loading { border-color: #CCCC00; }
		div.note-bad     { border-color: red; }
		textarea#new_note {
			resize: none;
			overflow: hidden;
		    outline: none;
			border-color: #00CC00;
			min-height: 2.4em;
			margin-bottom: 2em;
		}
		div.buttons {
			display: flex;
			flex-direction: column;
			padding-left: 0.4em;
		}
		.my_btn {
			font-size: 1.6em;
			height: 1.75em;
			width: 1.75em;
			border: none;
			color: white;
		}
		.fa:focus {
			filter: contrast(200%) brightness(75%);
			outline: none;
		}
		.fa:hover {
			filter: saturate(300%);
		}
		.fa-trash-o,
		.fa-times { background: #FF7777; }
		.fa-plus { background: #22DD22; }
		.fa-refresh { background: #8844FF; }
		.my-circle-backgr { background: #CCCC00;  }
		.fa-circle-o-notch  {  }
	</style>
	
	<title>Notes</title>
</head>

<body>
	<div class="block">
		<textarea id="new_note" class="note" placeholder="Новая заметка"></textarea>
		<div class="buttons">
			<button title="Добавить" id="submit" class="my_btn fa fa-plus"></button>
		</div>
	</div>

	<script type="text/javascript">
		$("textarea#new_note").on("input", function() {
		  	$(this).outerHeight("1em");
		  	$(this).outerHeight(this.scrollHeight);
		});
		$("textarea#new_note").trigger("input");
	</script>
	
	<div id="notes">
	</div>

	<script>
		var notes = <?php include "get_notes.php"; ?>;
		if (!notes)
			$("div#notes").html('<div id="NA" class="block" style="color:red">Сервер недоступен</div>');
		if (notes.length == 0)
			$("div#notes").html('<div id="empty" class="block" style="color:gray">Заметок пока нет</div>');
		if (!notes || notes.length == 0)
			var was_empty = true;

		for (var id in notes) {
			var content = notes[id];
			put_note(content, id);
		}

		function put_note(content, id) {
			if (was_empty) {
				was_empty = false;
				$("div#notes").html("");
			}

			var block = $( "<div>", { class:"block" } );
			block.append($( "<div>", { class:"note", text:content } ))
			block.append($ ("<div>", { class:"buttons" } ));

			if (id)
				set_ok(block, id);
			else
				set_loading(block);

			block.prependTo($("#notes"));
			return block;
		}

		function set_ok(block, id) {
			block.attr("id", "div"+id);
			block.children("div.note").attr("class", "note");
			block.children("div.buttons").html(
				'<button title="Удалить" class="delete my my_btn fa fa-trash-o"></button>');
		}

		function set_loading(block) {
			block.children("div.note").attr("class", "note note-loading");
			block.children("div.buttons").html(
				'<button title="Добавление..." class="my-circle-backgr my_btn"><i class="fa fa-circle-o-notch fa-spin"></i></button>');
		}

		function set_bad(block) {
			block.children("div.note").attr("class", "note note-bad");

			block.children("div.buttons").html(
			'<button title="Повторить попытку" class="retry my_btn fa fa-refresh"></button>' +
			'<button title="Отменить"" class="cancel my_btn fa fa-times"></button>');
		}

		function add_to_db(content, block) {
			var xhr = $.post( "add_note.php",
		    	{ "content" : content },
		    	function(id) {
		    		clearTimeout(stop);
		    		if (id) set_ok(block, id);
		    		else set_bad(block);
		    	}
		    );
			set_loading(block);
		    var stop = setTimeout(function() {
		    	xhr.abort();
		    	set_bad(block);
		    }, 5000);
		}

		$('textarea#new_note').keydown(function (e) {
		    if (e.ctrlKey && (e.keyCode == 10 || e.keyCode == 13)) {
		        $("#submit").trigger("click");
		    }
		});

		$("#submit").click(function(e) {
			e.preventDefault();

			var new_note = $("#new_note");
			var content = new_note.val();
			if (content == "") {
				new_note.attr("placeholder", "Введите текст заметки");
				setTimeout(function() {
					new_note.attr("placeholder", "Новая заметка")
				}, 1000);
				return;
			}
			new_note.val("");
			var block = put_note(content);
		    add_to_db(content, block);
		});

		$("body").on("click", "button.delete", function(e) {
			e.preventDefault();

			var block = this.parentNode.parentNode;
			var id = block.id.slice(3);
			$.post( "delete_note.php",
				{ "id" : id },
				function(success) {
					if (!success)
						return;
					block.remove();
				}
			);
		});

		$("body").on("click", "button.retry", function(e) {
			e.preventDefault();

			var block = $(this.parentNode.parentNode);
			var content = block.children("div.note").html();
			add_to_db(content, block);
		});

		$("body").on("click", "button.cancel", function(e) {
			e.preventDefault();

			var block = this.parentNode.parentNode;
			block.remove();
		});
	</script>
</body>
</html>