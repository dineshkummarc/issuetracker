issuetracker
============

Issuetracker is a fledgeling php web application for keeping track of issues persuant to real estate management companies and the housing associations under their care

to install
==========

create database 'issuetracker' from supplied build/issuetracker.sql file

create database user (default 'username' and 'password', these should be changed)

tweak for personal environment

run

environment
===========

This suite uses php, pdo, medoo, mysql and a webserver capable of running php. I use php-fpm with nginx, but it also functions
completely fine under apache.

notes
=====

users table doesn't do anything yet

requires a css framework - I was using cascade, but will probably change to something else like pure. Right now that means the build
is broken as it's been removed.

All of this is pre-alpha, but it should work with a bit of TLC. It's not actually useful yet, but it will be.

