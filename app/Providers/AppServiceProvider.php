<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use \Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
       Schema::defaultStringLength(191);
		 
		  Validator::extend('missing_with', function ($attribute, $value, $parameters, $validator) {
            foreach($validator->getData() as $field => $v) {
                if (in_array($field, $parameters)) {
                    return false;
                }
            }

            return true;
        });

        Validator::replacer('missing_with', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':other', implode(',', $parameters), $message);
        });

        Validator::extend('uuid', function ($attribute, $value, $parameters, $validator) {
            return (bool) preg_match('/^[0-9a-f]{8}-([0-9a-f]{4}-){3}[0-9a-f]{12}$/', $value);
        });

        Validator::extend('tid', function ($attribute, $value, $parameters, $validator) {
            return (bool) preg_match('/^urn:tid:[0-9a-f]{8}-([0-9a-f]{4}-){3}[0-9a-f]{12}$/', $value);
        });

        if(env('REDIRECT_HTTPS'))
        {
            $url->forceSchema('https');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
