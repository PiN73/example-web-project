<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html>
<head>
	<script src="http://code.jquery.com/jquery-latest.min.js"></script>
	
	<style>
		textarea#new_note,
		#notes {
			width: 400px;
		}
		div.block {
			padding: 8px 0px;
			display: flex;
			justify-content: space-between;
			align-items: flex-start;
		}
		div.note {
			width: 80%;
			border: solid 1px;
			overflow-wrap: break-word;
		}
	</style>
	
	<title>Notes</title>
</head>

<body>
	<textarea id="new_note" class="note" placeholder="Новая заметка"></textarea>
	<br>
	<button id="submit">Добавить</button>

	<script>
		$("#submit").click(function(e) {
			e.preventDefault();

			var new_note = $("#new_note");
			var content = new_note.val();
			if (content == "") return;

		    $.post( "add_note.php",
		    	{ "content" : content },
		    	function(id) {
		    		if (!id) // error
		    			return;
		    		add_note(content, id);
		    		new_note.val("");
		    	}
		    );
		});
	</script>

	<div id="notes">
		<?php include "put_notes.php"; ?>
	</div>

	<script type="text/javascript">
		function add_note(content, id) {
			var block = $( "<div>", { class:"block", id:"div"+id } )
			.append($( "<div>", { class:"note", text:content } ))
			.append($( "<button>", { class:"delete", text:"Удалить" } ))
			.append("<br>");

			block.prependTo($("#notes"));
		}

		$("body").on("click", "button.delete", function(e) {
			e.preventDefault();

			var id = this.parentNode.id.slice(3);
			$.post( "delete_note.php",
				{ "id" : id },
				function(success) {
					if (!success)
						return;
					$("#div" + id).remove();
				}
			);
		});
	</script>
</body>
</html>