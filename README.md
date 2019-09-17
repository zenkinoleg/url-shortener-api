Url-shortener-api v1.0
======================


Regular Install
---------------
- git clone https://github.com/zenkinoleg/url-shortener-api.git
- composer install

Clean Install
-------------
- composer create-project symfony/skeleton .
- composer require symfony/orm-pack
- composer require jms/serializer-bundle
- composer require symfony/validator doctrine/annotations
- composer require symfony/maker-bundle --dev


Usage
-----

<dl>
	<dt>url: /</dt>
	<dd>description: About message.</dd>
	<dd>method: GET</dd>

	<dt>#url: /urls/{page}</dt>
	<dd>description: Get all records from a page.</dd>
	<dd>method: GET</dd>
	<dd>params: page - integer | optional | default = 1</dd>

	<dt>#url: /url</dt>
	<dd>description: Add new or return existing short url.</dd>
	<dd>method: POST</dd>
	<dd>data: url - string | required</dd>

	<dt>#url: /{short}</dt>
	<dd>description: Redirect short link to original address.</dd>
	<dd>method: GET</dd>
</dl>

Limitations
-----------
 - no correct url validation
 - cannot delete existing url
 - no unit tests
