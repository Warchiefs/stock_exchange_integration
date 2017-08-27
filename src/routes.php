<?php

Route::prefix('exchange/api')->group(function () {
	Route::any('/pairs', 'StockExchangeApiController@getAvailableQuotation');
	Route::any('/ticker', 'StockExchangeApiController@getInfoAboutPair');
	Route::any('/chart', 'StockExchangeApiController@getJsonByPair');
	Route::any('/trades', 'StockExchangeApiController@getTradeHistory');
});