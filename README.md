# Course Overrides

This laravel web application is designed to take override requests for class
registrations.

[![Build Status][1]][2] [![Codecov][3]][4] [![Code Climate][5]][6]

## Installation

Staff advisors and administrators must belong to a privileged security group in
active directory. Find the Shibboleth entitlement name that matches the group
and set the environment variable:

    OVERRIDE_ADMIN_GROUP="GACL\WCOB-UGPO-OverrideRequestAdmins"
    OVERRIDE_ADMIN_ENTITLEMENT="urn:mace:uark.edu:ADGroups:Walton College:Security Groups:WCOB-UGPO-OverrideRequestAdmins"

If you don't know the mapping, then you can find it in the `$_SERVER` variable
after authenticating.

The database migrations include [a view][8] and [user permissions][9] that were
created exclusively for Microsoft SQL Server. If using a different DBMS, then
you can skip those migrations. The purpose of these migrations is to create an
administrative view with an editable column for notes on request processing.

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
