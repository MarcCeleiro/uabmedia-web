//DIRECTO DE RADIO
peu_directe = document.getElementById("peudirecte");
function mover_directo_radio(){
	peu_directe.style.position=("fixed");
	peu_directe.style.bottom=("0px");
	peu_directe.style.left=("0px");
	peu_directe.style.right=("0px");
	
}

function devolver_posicion_radio(){
	peu_directe.style.position=("relative");
	peu_directe.style.bottom=("200px");
	
	
}
document.getElementById("play_btn").addEventListener("click", mover_directo_radio);
document.getElementById("pause_btn").addEventListener("click", devolver_posicion_radio);



		