<?php

function lang($phrase)
{
    static $lang= array(
    	//dashboard page
        'HOME_ADMIN'=>'Home',
        'CATEGORIES'=>'Categories',
        'ITEMS'=>'Items',
        'STATISTICS'=>'Statistics',
        'LOGS'=>'Logs',
        'MEMBERS'=>'Members',
        'COMMENTS'=>'Comments'
        
        
    );
        return $lang[$phrase] ;
}

?>