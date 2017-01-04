<?php
/**
 * Routes - all standard Routes are defined here.
 *
 * @author David Carr - dave@daveismyname.com
 * @author Virgil-Adrian Teaca - virgil@giulianaeassociati.com
 * @version 3.0
 */


/** Define static routes. */

// The default Routing
Route::get('/',       'App\Controllers\Welcome@index');
Route::get('histoire',       'App\Controllers\Formulaire@ajout');
Route::post('histoire/ajout',       'App\Controllers\Formulaire@ajoutData');
Route::get('histoire{id}', 'App\Controllers\Welcome@histoire');
Route::get('aime{id}', 'App\Controllers\Welcome@aime');
Route::get('supprimerAime{id}',  'App\Controllers\Welcome@supprimerAime');
Route::post('ajoutCommentaire{id}', 'App\Controllers\Welcome@ajoutCommentaire');
/** End default Routes */

