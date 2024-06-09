<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alert extends CI_Controller  {

	protected $CI;

	public function __construct()
	{	
		$this->CI =& get_instance();
	}

	function alertsuccess($text){
		$text = str_replace(array("\r", "\n"), '', $text);
		$text = '<script success type="text/javascript">
					$( document ).ready(function() {
					$.toast({
						heading: "INFORMATION",
						text: "'.$text.'",
						showHideTransition: "slide",
						icon: "success",
						position: "top-right",
						loaderBg: "#def7f0", 
						hideAfter: 2500,
					});
				});
			</script>';
		echo $text;
	}

	function alertdanger($text){
			$text = str_replace(array("\r", "\n"), '', $text);
		$text = '<script>
						$( document ).ready(function() {
						$.toast({
							heading: "INFORMATION",
							text: "'.$text.'",
							showHideTransition: "slide",
							icon: "error",
							position: "top-right",
							loaderBg: "#def7f0",
							hideAfter: 5000, 
						});
					});
				</script>';
			echo $text;
	}


}
