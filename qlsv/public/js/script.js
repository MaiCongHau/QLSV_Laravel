$("#student_id").change(function(event) {
	/* Act on the event */
	var student_id = $(this).val();
	

	$("#subject_id").children().not(":first-child").remove();
	if (student_id=="") {
		return;
	}
	$("#load").html("Loading...");
	var url = $(this).attr("url");
	// http://qlsv.lavarel.com/students/pattern/subjects/unregistered
	// thay thằng pattern bằng student_id
	var url_temp =url.replace("pattern",student_id);

	$.ajax({
		url:url_temp,
	})
	
	.done(function(data) {	
		var subjects = JSON.parse(data);
		// thằng subjects này sẽ trả các Object
		$(subjects).each(function(index, el) {
			// .each với mỗi Object nó sẽ có key và value, thì ta chỉ cần dùng thằng el truyền key vô là dc
			var option = "<option value='" + el.id + "'>" + el.id + " - "+  el.name+ "</option>";
			$("#subject_id").append(option)
		});
		$("#load").empty();
		console.log("success");
	})

	.fail(function() {
		console.log("error");
	})
	.always(function() {
		console.log("complete");
	});
	
});


$(".delete").click(function(event) {
	/* Act on the event */
	var form = $(this).attr("url");
	$("#modalDeletingConfirmation form").attr("action",form)
	$("#modalDeletingConfirmation").modal("show");
});