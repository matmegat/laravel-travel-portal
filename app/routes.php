<?php

Route::get('/', 'HomeController@showMain');
Route::post('/home/flights/{search_id}/{trip_id}', 'HomeController@flightsTab');

Route::get('secure-{image}-image.png', 'HomeController@getSecureImage', ['image' => 'images']);

Route::group(['before' => 'auth.admin'], function () {
    Route::controller('admin/tours', 'ToursAdminController');
});

###########################
########## NEWS ###########
###########################

Route::get('news', ['as' => 'news', 'uses' => 'NewsController@listNews']);
Route::get('news/details/{id}',  'NewsController@details'); #the route is deprecated
Route::get('news/{year}/{slug}',  'NewsController@show')->where('year', '^\d{4}$');

Route::group(['before' => 'auth.news'], function () {
    Route::get('admin/news/add', 'NewsController@add');
    Route::post('admin/news/add-process',  'NewsController@addProcess');

    Route::get('admin/news/{id}/edit',  'NewsController@edit');
    Route::post('admin/news/{id}/edit-process',  'NewsController@editProcess');

    Route::get('admin/news/{id}/delete',  'NewsController@delete');

    Route::get('admin/news/{id}/restore',  'NewsController@restore');

    Route::get('admin/news/manage',  'NewsController@manage');
    Route::get('admin/news/manage-all',  'NewsController@manageAll');
});

###########################
######### AWARD ###########
###########################

Route::get('awards', ['as' => 'awards', 'uses' => 'AwardController@listAward']);
Route::get('award/{year}/{slug}',  'AwardController@show')->where('year', '^\d{4}$');

Route::group(['before' => 'auth.news'], function () {
    Route::get('admin/award/add', 'AwardAdminController@add');
    Route::post('admin/award/add-process',  'AwardAdminController@addProcess');

    Route::get('admin/award/{id}/edit',  'AwardAdminController@edit');
    Route::post('admin/award/{id}/edit-process',  'AwardAdminController@editProcess');

    Route::get('admin/award/{id}/delete',  'AwardAdminController@delete');

    Route::get('admin/award/{id}/restore',  'AwardAdminController@restore');

    Route::get('admin/award/manage',  'AwardAdminController@manage');
    Route::get('admin/award/manage-all',  'AwardAdminController@manageAll');
    Route::post('admin/award/save-settings',  'AwardAdminController@postSaveSettings');
});

###########################
######## SEARCH ###########
###########################

Route::get('search/tours', 'SearchController@tours');
Route::get('search/blogs', 'SearchController@blogs');
Route::get('search/pages', 'SearchController@pages');
Route::get('search/tour', 'SearchController@toursSearch');
Route::get('search/blog', 'SearchController@blogsSearch');
Route::get('search/page', 'SearchController@pagesSearch');
Route::get('page/redirect/{id}', 'SearchController@pageRedirect');
Route::get('search', 'SearchController@search');

###########################
########## USER ###########
###########################

Route::get('user/register', 'UserController@register');
Route::post('user/register-process', 'UserController@registerProcess');
Route::get('user/login', 'UserController@login');
Route::post('user/login-process', 'UserController@loginProcess');
Route::get('user/activate/{id}/{code}', 'UserController@activate');
Route::get('user/activated', 'UserController@activated');
Route::get('user/confirm', 'UserController@confirm');
Route::get('user/logout', 'UserController@logout');

Route::get('user/reset', 'UserController@reset');
Route::post('user/reset-process', 'UserController@resetProcess');
Route::get('user/reset/code/{id}/{code}', 'UserController@resetCode');
Route::post('user/reset/continue/{id}/{code}', 'UserController@resetContinue');
Route::get('user/reset/done', 'UserController@resetEmailed');

Route::group(['before' => 'auth.admin'], function () {
    Route::get('admin/user/create', 'UserController@create');
    Route::post('admin/user/create-process', 'UserController@createProcess');
    Route::get('admin/user/manage', 'UserController@manage');
    Route::get('admin/user/{id}/delete', 'UserController@delete');
    Route::get('admin/user/{id}/edit', 'UserController@edit');
});

Route::group(['before' => 'auth'], function () {
    Route::get('user/profile', 'UserController@profile');
    Route::post('user/profile/update-password/{id?}',  'UserController@updatePassword');
    Route::post('user/profile/save-profile/{id?}',  'UserController@saveProfile');
});

###########################
######### TRAVEL #########
###########################
Route::any('tours', ['as' => 'tours', 'uses' => 'ToursController@home']);
Route::get('tours', ['as' => 'tours', 'uses' => 'ToursController@home']);
Route::get('tours/view/{id}', 'ToursController@info');
Route::get('tours/view/{id}/book', 'ToursController@book');
Route::get('tours/bought', 'ToursController@orderSuccess');

Route::get('tours/products/{product}', 'ToursController@viewProduct');
Route::get('tours/products/{product}/book', 'ToursController@bookProduct');
Route::post('tours/products/{product}/order', 'ToursController@orderProduct');
Route::get('tours/products/{product}/bought/{order_id}', 'ToursController@boughtProduct');

Route::post('tours/confirmation', 'ToursController@order');

Route::any('tours/search', 'ToursController@search');

Route::get('tours/voucher/{voucher}', 'ToursController@voucher');

Route::get('tours/states/', 'ToursController@states');
Route::get('tours/regions/', 'ToursController@regions');

###########################
######### FLIGHTS #########
###########################

Route::get('flights', ['as' => 'flights', 'uses' => 'FlightsController@index']);
Route::get('flights/airports/{id?}', 'FlightsController@airports');
Route::get('flights/search', 'FlightsController@search');
Route::get('flights/results/{search_id}/{trip_id}', 'FlightsController@searchResults');
Route::any('flights/update/{search_id}/{trip_id}', 'FlightsController@updateResults');
Route::get('flights/redirect/{search_id}/{fare_id}/{trip_id}/{route}', 'FlightsController@redirectToSite');

###########################
######### HOTELS ##########
###########################

Route::get('hotels', ['as' => 'hotels', 'uses' => 'HotelsController@index']);
Route::get('hotels/search', 'HotelsController@search');
Route::get('hotels/location/{id?}', 'HotelsController@location');
Route::get('hotels/results/{search_id}', 'HotelsController@searchResults');
Route::get('hotels/details/{search_id}/{hotel_id}', 'HotelsController@hotelDetail');
Route::any('hotels/update/{search_id}', 'HotelsController@updateResults');
Route::get('hotels/redirect/{search_id}/{hotel_id}/{room_rate_id}', 'HotelsController@redirectToSite');

###########################
####### ECO TOURISM #######
###########################

Route::get('eco-tourism', ['as' => 'eco-tourism', 'uses' => 'EcoTourismController@index']);

###########################
######### Rezdy ##########
###########################

Route::get('/tours/{account}', ['as' => 'diving', 'uses' => 'TourRezdyController@tours']);
Route::get('/tour/{account}/{id}', ['uses' => 'TourRezdyController@tour']);
Route::get('/tour-availability/{account}/{id}/{date}', ['uses' => 'TourRezdyController@getTourAvailabilityDates']);
Route::get('/tour-available/{account}/{id}', ['uses' => 'TourRezdyController@tourAvailability']);
Route::get('/tour-book/{account}/{id}', ['uses' => 'TourRezdyController@book']);
Route::post('/tour-book/{account}/{id}', ['uses' => 'TourRezdyController@bookProcess']);
Route::get('/tour-book-success', ['uses' => 'TourRezdyController@success']);

Route::group(['before' => 'auth.admin'], function () {
    Route::get('admin', 'PageAdminController@manage');

    Route::get('admin/pages', 'PageAdminController@manage');
    Route::any('admin/pages/update-tour-process', 'PageAdminController@updateTourProcess');
    Route::get('admin/pages/{id}/edit', 'PageAdminController@edit');
    Route::post('admin/pages/{id}/edit-process', 'PageAdminController@editProcess');
    Route::get('admin/pages/{id}/remove-background', 'PageAdminController@removeBackground');
    Route::post('admin/pages/save-social', 'PageAdminController@saveSocial');
    Route::post('admin/pages/save-booking-info', 'PageAdminController@saveBookingInfo');
    Route::get('admin/pages/{id}/delete', 'PageAdminController@delete');
});

###########################
########## ABOUT ##########
###########################

Route::get('about', ['as' => 'about', 'uses' => 'AboutController@index']);

###########################
######## CONTACT ########
###########################

Route::get('contact', ['as' => 'contact', 'uses' => 'ContactController@index']);
Route::post('contact/send', 'ContactController@sendContactForm');
Route::group(['before' => 'auth.admin'], function () {
    Route::post('admin/contact/{id}/edit-process',  'ContactController@editProcess');
});

###########################
######## ADVICE ###########
###########################

Route::get('advice', ['as' => 'advice', 'uses' => 'AdviceController@index']);

###########################
######## SAFETY ###########
###########################

Route::get('safety', ['as' => 'safety', 'uses' => 'SafetyController@index']);

###########################
######## FAQ ###########
###########################

Route::get('faq', ['as' => 'faq', 'uses' => 'FaqController@index']);

###########################
######## Terms ###########
###########################

Route::get('terms', ['as' => 'terms', 'uses' => 'TermsController@index']);
