<?php

	class Controller{

		private $model_response;

		public function __construct(){
			$this->model_response = null;
		}

		public function get_model_response(){
			return $this->model_response;
		}
		public function model($model){
			require_once MODELS . $model . ".php";
			return new $model();
		}

		public function view($view, $data = []){

			require_once INCLUDES . 'header.php';
			require_once INCLUDES . "response.php"; 
			require_once INCLUDES . "alerts.php";
			require_once VIEWS . $view . ".php";
			require_once INCLUDES . 'footer.php';
		}	

		public function view_static( $view, $data = array()){
			
			$template = file_get_contents( VIEWS . $view . ".php");

			foreach( $data as $index => $value){
				$template = str_replace( '['. $index . ']', $value, $template);
			}
			return utf8_decode($template);
		}
		
		public function view_nostyle($view, $data = []){
			require_once VIEWS . $view . ".php";
		}

        /*
		public function get_sidebar( $id_rol ){
			switch( $id_rol){

				case 1: return 	"sidebar/admin"; break;
				case 3: return 	"sidebar/usuario_final"; break;
				case 5: return 	"temporal/tmp_sidebar"; break;
				case 6: return 	"sidebar/director_zona"; break;
				case 7: return 	"sidebar/ceo"; break;
				case 8: return 	"sidebar/rh"; break;
				case 9: return 	"sidebar/reportes"; break;
				case 10: return "sidebar/ux"; break;
				case 1: return "sidebar/admin"; break;
				case 3: return "sidebar/usuario_final"; break;
				case 5: return "temporal/tmp_sidebar"; break;
				case 6: return "sidebar/director_zona"; break;
				case 7: return "sidebar/ceo"; break;
				case 8: return "sidebar/rh"; break;
				case 9: return "sidebar/reportes"; break;
			}
		}	
        */

		public function e404(){
			$this->view("404/index");
		}

		public function acceso_denegado( $mensajes = [] ){
			$this->view("403/index", $mensajes );
		}

        /*
        		public function helper($helper){
			require_once HELPERS . $helper . ".php";
			return new $helper();
		}*/

        /*¨
        		public function prueba_de_post($post, $modelo, $funcion, $mensajes = array(), $campos_no_requeridos = array() ){
			
			$helper = $this->helper("helpers");
			$data_response = [];

			$response = false;				
			

			if( $valida_form = $helper->empty_fields($post, $campos_no_requeridos) ){
				
				$data_response = $this->set_mensaje('danger', $mensajes, "Por favor completa los siguientes campos", $valida_form);
			}

			else{
					
				$this->model_response = ($this->model($modelo))->$funcion($post);

				if( $this->model_response ){
					$response = true;
					$data_response = $this->set_mensaje('success', $mensajes, "Acción completada correctamente");
				}
				else
					$data_response = $this->set_mensaje('warning', $mensajes, "Ocurrió un problema al procesar tu solicitud");	
			}

			$data_response["data_form"] = $post;
			$_SESSION["response"] = $data_response;
			return $response;
		}
*/


	
	}

?>