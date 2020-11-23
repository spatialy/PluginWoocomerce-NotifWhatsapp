<?php

function woowa_wizard_setup(){
	$view = woowa_wizard_setup_view();
	wp_die($view);
}