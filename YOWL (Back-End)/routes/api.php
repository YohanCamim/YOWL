<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\FluxController;
use App\Http\Controllers\LikesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Public routes

// Users
Route::get('/users', [AuthController::class,'allUsers']);
// News 
Route::get('/news', [NewsController::class, 'index']);  // Global news //* Validé
Route::get('/news/{id}', [NewsController::class, 'show']); // Specific news //* Validé
Route::get('/news/search/{name}',[NewsController::class, 'search']); // Search news //* Validé
Route::get('/news/search/author/{text}/{id}',[NewsController::class, 'authorSearch']); // Search news of an author //*TODO Validé
Route::get('/news/author/{id}', [NewsController::class, 'getNewsAuthor']); // Get news of a certain author (author_id) //* Validé

// Flux
Route::get('/flux',[FluxController::class,'index']); // Flux général //* Validé
Route::get('/flux/{id}',[FluxController::class,'show']); // Flux spécifique //*TODO Validé
Route::get('/fluxNames',[FluxController::class, 'showFlux']); // Liste des flux name + id //*TODO Validé

// Comments

Route::get('/comments', [CommentsController::class, 'index']); // Global comments
Route::get('/comments/{id}', [CommentsController::class,'show']); // Specific Comment
Route::get('/comments/news/{id}',[CommentsController::class,'getCommentsNews']); // Get comments of a certain news //* Validé

// Register / Login
Route::post('/register', [AuthController::class,'register']); // Register //* Validé
Route::post('/login', [AuthController::class,'login']); // Login //* Validé

// Protected routes

Route::group(['middleware' => ['auth:sanctum']], function () {
	Route::post('/news', [NewsController::class, 'store']); // Create new news //* Validé
	Route::put('/news/{id}', [NewsController::class, 'update']); // Edit news
	Route::delete('/news/{id}', [NewsController::class, 'destroy']); // Delete a news //*TODO Validé

	Route::post('/logout', [AuthController::class,'logout']); // Log out //* Validé

	Route::post('/comments', [CommentsController::class, 'store']); // Create new comments //* Validé
	Route::delete('/comments/{id}',[CommentsController::class, 'destroy']); // Delete comments

	Route::post('/news/like/{id}',[LikesController::class, 'likeNews']); // Like / Dislike a news //* Validé
	Route::post('/comments/like/{id}',[LikesController::class, 'likeComments']); // Like / Dislike a comment //*TODO Validé

	Route::post('/news/isliked/{id}',[LikesController::class,'isLiked']); // Savoir si un utilisateur a liké //*TODO Validé
	Route::post('/news/liked',[LikesController::class, 'articleLiked']); // Savoir quel article un utilisateur a liké
	Route::post('/news/listLiked',[LikesController::class,'articlesLiked']); // Retourne tout les articles likés par l'utilisateur (Envoyer token)
	Route::post('/news/listDisliked',[LikesController::class,'articlesDisliked']);// Retourne tout les articles dislikés par l'utilisateur (Envoyer token)
});
