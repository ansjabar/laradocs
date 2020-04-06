<h2 align="center">
    LaraDocs
</h2>


<h6 align="center">
    Generate beautiful documentation for your Laravel applications with DocBlocks..
</h6>


# LaraDocs

**LaraDocs** is simply a code-driven package provides an easy way to create beautiful documentation for your product or application inside your Laravel app.





## Getting Started

☝️ Install the package via composer.

    composer require ansjabar/laradocs

✌️ Run the following command to publish assets and config file `laraadoc.php`


    php artisan vendor:publish --provider="AnsJabar\LaraDocs\LaraDocsServiceProvider"

✌️ Run the following command to generate docs

	php artisan laradocs:generate

Visit your app domain with `/laradocs` endpoint. That's it.

## Usage Example

	<?php

	/**
	 * @title User Management
	 * @description This is user management group description
	 */
	class UserController
	{
		/**
		 * @title Login
		 * @description Login description goes here
		 * @method GET
		 * @queryParams param1 required Number param description
		 * @queryParams param2 optional Number param description
		 * @dataParams param1 required Number param description
		 * @dataParams param2 optional Number param description
		 * @headers header1 required Number param description
		 * @headers header2 optional String param description
		 * @successData {"name":"John", "age":31, "city":"New York"}
		 * @failureErrors {"message":"Something went wront"}
		 */
		public function login()
		{

		}
	}

#### Note
This package will parse all routes files mapped in `RouteServiceProvider.php`. Closure routes are ignored. 

## License

This package is licensed under the MIT License - see the [LICENSE.md](LICENSE) file for details.
