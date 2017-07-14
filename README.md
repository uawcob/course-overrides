# Course Overrides

This laravel web application is designed to take override requests for class
registrations.

[![Build Status][1]][2] [![Codecov][3]][4] [![Code Climate][5]][6]

## Setup

Familiarize yourself with [the laravel application installation process][10].

### Server Requirements

* PHP >= 7.0
* [composer][13]
* Shibboleth SP must be [installed][12] to authenticate University users.

### Installation

Clone this repository or download the zip archive.

    git clone https://github.com/uawcob/course-overrides.git

Point the server document root at the `public` folder.

Create the environment variables file from the template.

    cp .env.example .env

Set all the values in `.env` accordingly.

You may request API credentials for razorback courses and plans from
Mike Akerman in UITS, or someone from the UAConnect development team.

Staff advisors and administrators must belong to a privileged security group in
active directory. Find the Shibboleth entitlement name that matches the group
and set the environment variable:

    OVERRIDE_ADMIN_GROUP="GACL\WCOB-UGPO-OverrideRequestAdmins"
    OVERRIDE_ADMIN_ENTITLEMENT="urn:mace:uark.edu:ADGroups:Walton College:Security Groups:WCOB-UGPO-OverrideRequestAdmins"

If you don't know the mapping, then you can find it in the `$_SERVER` variable
after authenticating.

Enable the application environment for production.

    APP_ENV=production

It's recommended to use redis for the caching and session layer.
Pull the [docker][11] image and set the `host:6379:port` accordingly.

    docker pull redis
    docker run --name override-redis --publish 127.0.0.1:6379:6789 --detach redis

In this example, the variables would be set:

    CACHE_DRIVER=redis
    SESSION_DRIVER=redis
    REDIS_HOST=127.0.0.1
    REDIS_PASSWORD=null
    REDIS_PORT=6789

The database migrations include [a view][8] and [user permissions][9] that were
created exclusively for Microsoft SQL Server. If using a different DBMS, then
you can skip those migrations. The purpose of these migrations is to create an
administrative view with an editable column for notes on request processing.

Finally, there is a short [deploy script][14] to finish installation.

    ./deploy.bash

## Development

There is a [Dockerfile][7] included for testing with the Courses API.

    docker build -t razorbacks/override-mock-api tests/docker/MockApi/
    docker run --rm -d -p 8888:80 razorbacks/override-mock-api

Then set the environment variable for your endpoint.

    RAZORBACK_COURSES_API=http://localhost:8888

<p align="center">
    <a href="https://laravel.com/">
        <img src="https://laravel.com/assets/img/components/logo-laravel.svg" />
    </a>
</p>

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

[1]:https://travis-ci.org/uawcob/course-overrides.svg?branch=master
[2]:https://travis-ci.org/uawcob/course-overrides
[3]:https://img.shields.io/codecov/c/github/uawcob/course-overrides/master.svg
[4]:https://codecov.io/gh/uawcob/course-overrides/branch/master
[5]:https://codeclimate.com/github/uawcob/course-overrides/badges/gpa.svg
[6]:https://codeclimate.com/github/uawcob/course-overrides
[7]:./tests/docker/MockApi/Dockerfile
[8]:./database/migrations/2017_07_13_195711_create_view_requests.php
[9]:./database/migrations/2017_07_13_202224_add_user_permissions.php
[10]:https://laravel.com/docs/5.4#installation
[11]:https://www.docker.com/
[12]:https://github.com/razorbacks/ubuntu-authentication/tree/master/shibboleth
[13]:https://getcomposer.org/
[14]:./deploy.bash
