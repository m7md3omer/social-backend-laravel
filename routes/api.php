<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {
    Route::post('/register', 'Api\AuthenticationController@register');
    Route::post('/login', 'Api\AuthenticationController@login');

    Route::group(['middleware' => ['auth:api']], function () {
        //get user
        Route::get('/users/{user}', 'Api\AuthenticationController@user');
        //profile
        Route::get('/profile', 'Api\ProfilesController@show');
        Route::post('/profile', 'Api\ProfilesController@update');
        //posts
        Route::apiResource('posts', 'Api\PostsController');
        Route::get('/users/{user}/posts', 'Api\PostsController@userPosts');
        Route::post('/posts/{post}/favorite', 'Api\FavoritesController@storePost');
        Route::post('/posts/{post}/un_favorite', 'Api\FavoritesController@destroyPost');
        //comments
        Route::get('/posts/{post}/comments', 'Api\CommentsController@index');
        Route::post('/posts/{post}/comments', 'Api\CommentsController@store');
        Route::put('comments/{comment}', 'Api\CommentsController@update');
        Route::delete('comments/{comment}', 'Api\CommentsController@destroy');
        Route::post('/comments/{comment}/favorite', 'Api\FavoritesController@storeComment');
        Route::post('/comments/{comment}/un_favorite', 'Api\FavoritesController@destroyComment');
        //notifications
        Route::get('/notifications', 'Api\NotificationsController@index');
        Route::post('/notifications/mark_read', 'Api\NotificationsController@markAllAsRead');
        //followers
        Route::post('/follow/{user}', 'Api\FollowersController@follow');
        Route::post('/un_follow/{user}', 'Api\FollowersController@unFollow');
        //categories
        Route::get('categories', 'Api\CategoriesController@index');
    });

    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });
});
