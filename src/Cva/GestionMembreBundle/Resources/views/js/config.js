function insertAjoutBus() {

	$.get("ajoutBus",
	function(msg){
		$("#insertBus").html(msg);
	});
}

function insertEditBus(idBus) {

	$.get("editBus?idBus=" + idBus,
	function(msg){
		$("#insertBus").html(msg);
	});
}

function insertAjoutBung() {

	$.get("ajoutBung",
	function(msg){
		$("#insertBung").html(msg);
	});
}

function insertEditBung(idBung) {

	$.get("editBung?idBung=" + idBung,
	function(msg){
		$("#insertBung").html(msg);
	});
}