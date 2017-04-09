$(document).ready(function(){

			$("#change").click(function(){
				//$("#loading").html("processing...").addClass("loading");
				var btext = $(this);
				console.log(btext);
				$("#conn-info-form input").each(function(){
					var itm = $(this);
					if( btext.html() =="Unlock")
						itm.removeAttr('disabled');
					else
						itm.attr("disabled","");



				});
				btext.html(btext.html()=="Lock"?"Unlock":"Lock");
				//$("#loading").html("");
			});


			$("#conn-info-form").submit(function(){

					$("#loading").html("Saving database info...").addClass("loading").removeAttr("style");
					var request = $.ajax({
						type: 'POST',
						url: 'lib/savedbinfo.php',
						data:$(this).serialize()

					});


					request.done(function(response){
						console.log(response);
						
						if(response == "OK")
							$("#loading").html("Saved!").fadeOut(600,function(){});
						else	
							$("#loading").html("Error Occured!");


					});


					return false;
			});//end

			$("#check").click(function(){
				//$(this).html("Checking.....");
				$("#loading").addClass("loading").removeAttr("style");

				$.ajax('lib/check_con.php')
				.done(function(r){
					if(r=="OK")
						$("#check").html("Checked Connection [OK]");
					else
						$('#check').html("Checked Connection [ERROR]");

					//$("#loading").html("Done!").fadeOut(600,function(){});
					$("#loading").fadeOut(600,function(){});
				});
			});//end



			$('#get-table-list').click(function(){

				//$("#loading").html("Generating table list...").addClass("loading").removeAttr("style");
				$("#loading").addClass("loading").removeAttr("style");


				$.ajax('lib/fetch_table_list.php').done(function(r){
					$('#table-list-form').html(r);
					//$("#loading").html("Done!").fadeOut(600,function(){});
					$("#loading").fadeOut(600,function(){});
				});

			});//end

			$('#table-list-form').submit(function(){
					//$("#loading").html("Generating library...").addClass("loading").removeAttr("style");
					$("#loading").addClass("loading").removeAttr("style");
					$('#outputval').html('');

					$.ajax({
						type:'POST',
						url:'lib/generate_library.php',
						data: $(this).serialize()
						})
					.done(function(r){
						var outputwindow = $('textarea#outputval');
						outputwindow.html(r);
					});
					//$("#loading").html("Done!").fadeOut(600,function(){});
					$("#loading").fadeOut(600,function(){});
					$('#outputval').focus();
					return false;
			});

			


				

		});
