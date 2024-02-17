<?php

namespace App;

class Utilidades{

	public static function redirect($url){
		echo '<script>window.location.href="'.$url.'"</script>';
		die();
	}

	public static function alerta($mensagem){
		echo '<script>alert("'.$mensagem.'")</script>	';

	}

	public static function mensagem($status,$msg){
		echo '<script>

		document.addEventListener("DOMContentLoaded", function() {
            var msg = document.createElement("div");
			msg.classList.add("'.$status.'");
			msg.textContent = ("'.$msg.'");


			var divMensagens = document.querySelector("#divAlerta");
			divMensagens.appendChild(msg);
        });
		
		
		</script>	';
			
		

	}


	public static function mensagemEfeito($texto,$cor){
		
		echo '<script>
		document.addEventListener("DOMContentLoaded", function() {
			let id = Math.floor(Date.now() * Math.random()).toString();
			let msge = `<div id="msg-${id}" class="animated fadeInDown toast '. $cor.'">'.$texto.'</div>`;
	
			$("#container-mensagens").append(msge);
	
			setTimeout(() => {
				$(`#msg-${id}`).removeClass("fadeInDown");
				$(`#msg-${id}`).addClass("fadeOutUp");
				setTimeout(() => {
					$(`#msg-${id}`).remove();
				}, 800);
			}, 3500);
		});
	</script>	';
			
		

	}


}



?>