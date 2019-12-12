Laravel Route Guard
=================

This package adds the option to specifiy an auth guard on route level. 

What this means is that you can actually use the same auth routes but with different guards.

This is particularly useful when using a package like [stancl/tenancy](https://github.com/stancl/tenancy), where you have central routes and tenant routes (and also the reason why this package came to be). 

## Usage

You simple specify the guard in a `guard` route option.

Example from my own setup:

```
Route::group(['guard' => 'tenant'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', 'AuthController@login');

        Route::group(['middleware' => 'auth:tenant'], function () {
            Route::post('logout', 'AuthController@logout');
            Route::post('refresh', 'AuthController@refresh');
        });
    });
});
```

If no `guard` is specified, it will default to whatever is the default guard (usually the same as `config('auth.defaults.guard')`).
