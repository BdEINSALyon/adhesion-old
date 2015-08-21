function checkAsso() {
	var numEtu = $("#numEtu").val();
	$.get("../api/is_member?numEtu="+numEtu,
		function(msg){
			if(msg.member){
				$("#result").html("<img src='http://www.offshoremarine.fr/images/validation.png' height='30' width='30'> ADHERENT");
			} else {
				$("#result").html("<img src='http://iconshow.me/media/images/Mixed/Free-Flat-UI-Icons/png/512/cross-24-512.png' height='30' width='30'> NON ADHERENT");

			}
		});
}