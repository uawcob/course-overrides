# Course Overrides

This laravel web application is designed to take override requests for class
registrations.

[![Build Status][1]][2] [![Codecov][3]][4] [![Code Climate][5]][6]

## Installation

Staff advisors and administrators must belong to a privileged security group in
active directory. Find the Shibboleth entitlement name that matches the group
and set the environment variable:

    OVERRIDE_ADMIN_ENTITLEMENT='urn:mace:uark.edu:ADGroups:Walton College:Security Groups:WCOB-WebAdministrators'

If you don't know the mapping, then you can find it in the `$_SERVER` variable
after authenticating.

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

![browser stack logo][8]

[1]:https://travis-ci.org/uawcob/course-overrides.svg?branch=master
[2]:https://travis-ci.org/uawcob/course-overrides
[3]:https://img.shields.io/codecov/c/github/uawcob/course-overrides/master.svg
[4]:https://codecov.io/gh/uawcob/course-overrides/branch/master
[5]:https://codeclimate.com/github/uawcob/course-overrides/badges/gpa.svg
[6]:https://codeclimate.com/github/uawcob/course-overrides
[7]:./tests/docker/MockApi/Dockerfile
[8]:./docs/images/browser-stack-logo.png
