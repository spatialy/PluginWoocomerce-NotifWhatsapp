<?php

function woowa_statistic_view(){
	$view='';
	if (get_option('woowa_license')!='active') { return ('<br>please activate license code. click <a href="#license" data-toggle="tab" aria-expanded="true">here</a>');}
    $script = woowa_script_statistic_view();
    $view.='
	    <h3>Statistic : </h3>
	    <br><br>
	    <div style="float:right;">
		    <label for="daterange">Select date to show your data</label>
		    <br>
		    <input type="text" name="daterange" id="daterange" />
	    </div>
	    <div id="chart-container">
        	<canvas id="graphCanvas"></canvas>
	    </div>
	    ';
	    	$script;
	    	
	$view.='
	    	<div id="statistics_table">
	    		'. woowa_statistic_table_view() .'
	    	</div><br><br>
	    	';

    return $view.$script;
}