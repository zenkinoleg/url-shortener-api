Url-shortener-api v1.0
======================


Regular Install
---------------
- git clone
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

# url: /
description: About message.
method: GET

#url: /urls/{page}
description: Get all records from a page.
method: GET
params: page - integer | optional | default = 1

#url: /url
description: Add new or return existing short url.
method: POST
data: url - string | required

#url: /{short}
description: Redirect short link to original address.
method: GET


Limitations
-----------
 - no correct url validation
 - cannot delete existing url
