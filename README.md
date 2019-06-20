# housing-society
A small system for housing society to manage notices, events and bill payments

## Demo

The backend is deployed on heroku. [Click here](https://housing-society404.herokuapp.com/) to access APIs.

## URLs
All the URLS are **prefixed** with **/api/**. Ex: *https://housing-society404.herokuapp.com/api/some_path*

### List of URLs

| Domain | Method | URI                     | Name                     | Action                                            | Middleware                                         |
| ------ | ------ | ----------------------- | ------------------------ | ------------------------------------------------- | -------------------------------------------------- |
|        | POST   | api/auth/login          |                          | App\Http\Controllers\AuthController@login         | api,api-header                                     |
|        | POST   | api/auth/register       |                          | App\Http\Controllers\AuthController@register      | api,api-header                                     |
|        | GET    | HEAD                    | api/billing              |                                                   | App\Http\Controllers\BillingController@getUserBill | api,jwt-auth,api-header       |
|        | GET    | HEAD                    | api/billing/all          |                                                   | App\Http\Controllers\BillingController@getAll      | api,jwt-auth,api-header,admin |
|        | POST   | api/billing/new         |                          | App\Http\Controllers\BillingController@create     | api,jwt-auth,api-header,admin                      |
|        | DELETE | api/billing/{id}        |                          | App\Http\Controllers\BillingController@delete     | api,jwt-auth,api-header,admin                      |
|        | GET    | HEAD                    | api/billing/{id}         |                                                   | App\Http\Controllers\BillingController@get         | api,jwt-auth,api-header       |
|        | GET    | HEAD                    | api/billing/{id}/pay     |                                                   | App\Http\Controllers\BillingController@pay         | api,jwt-auth,api-header       |
|        | POST   | api/billing/{id}/update |                          | App\Http\Controllers\BillingController@update     | api,jwt-auth,api-header,admin                      |
|        | GET    | HEAD                    | api/event                |                                                   | App\Http\Controllers\EventController@getAll        | api,jwt-auth,api-header       |
|        | GET    | HEAD                    | api/event/expired        |                                                   | App\Http\Controllers\EventController@getAllExpired | api,jwt-auth,api-header       |
|        | POST   | api/event/new           |                          | App\Http\Controllers\EventController@create       | api,jwt-auth,api-header                            |
|        | GET    | HEAD                    | api/event/{id}           |                                                   | App\Http\Controllers\EventController@get           | api,jwt-auth,api-header       |
|        | DELETE | api/event/{id}          |                          | App\Http\Controllers\EventController@delete       | api,jwt-auth,api-header                            |
|        | POST   | api/event/{id}/register |                          | App\Http\Controllers\EventController@registerUser | api,jwt-auth,api-header                            |
|        | POST   | api/event/{id}/update   |                          | App\Http\Controllers\EventController@update       | api,jwt-auth,api-header                            |
|        | GET    | HEAD                    | api/notice               |                                                   | App\Http\Controllers\NoticeController@getAll       | api,jwt-auth,api-header       |
|        | POST   | api/notice/new          |                          | App\Http\Controllers\NoticeController@create      | api,jwt-auth,api-header,admin                      |
|        | DELETE | api/notice/{id}         |                          | App\Http\Controllers\NoticeController@delete      | api,jwt-auth,api-header,admin                      |
|        | GET    | HEAD                    | api/notice/{id}          |                                                   | App\Http\Controllers\NoticeController@get          | api,jwt-auth,api-header       |
|        | POST   | api/notice/{id}/update  |                          | App\Http\Controllers\NoticeController@update      | api,jwt-auth,api-header,admin                      |
|        | GET    | HEAD                    | api/user/all             |                                                   | App\Http\Controllers\UserController@getAll         | api,jwt-auth,api-header,admin |
|        | GET    | HEAD                    | api/user/me              |                                                   | App\Http\Controllers\UserController@getCurrentUser | api,jwt-auth,api-header       |
|        | POST   | api/user/me/update      |                          | App\Http\Controllers\UserController@update        | api,jwt-auth,api-header                            |
|        | GET    | HEAD                    | api/user/{id}            |                                                   | App\Http\Controllers\UserController@get            | api,jwt-auth,api-header,admin |
|        | GET    | HEAD                    | api/user/{id}/activate   |                                                   | App\Http\Controllers\UserController@activateUser   | api,jwt-auth,api-header,admin |
|        | GET    | HEAD                    | api/user/{id}/deactivate |                                                   | App\Http\Controllers\UserController@deactivateUser | api,jwt-auth,api-header,admin |
