issuetracker
============

Issuetracker is a fledgeling php web application for keeping track of issues persuant to real estate management companies and the housing associations under their care.

At the moment, it works relatively well, but it has a lot of holes in the capabilities:
   * users don't do anything
      * yet...
   * issues, issuetypes and issuetracking entries handle html entity quirks
      * used a simple nl2br() call on issuetracking recall, now nl are br
      * the strings should be safe, but requires a once-over
   * there's a lot of cleanup to do, old CSS to remove and so on
   * the database doesn't build itself properly, so expect to add values by hand to tables like status.
      * modify-xx.xx.xx.x.sql files should be run on top of the bare bones sql
      * utf8 not used everywhere, it needs to be

to install
==========

   * create database 'issuetracker' from supplied build/issuetracker.v0.1.sql file
   * create database user (default 'username' and 'password' will come via the build scripts, these should be changed)
   * tweak include/mysql.php for personal environment
   * run

to upgrade
==========

This might be a bit flakey, but to upgrade from a previous release, run the supplied build/build-*.sql files in order

environment
===========

This suite uses php, pdo, mysql and a webserver capable of running php. I use php-fpm with nginx, but it also functions completely fine under apache.

notes
=====

This suite uses the following technology:
   * bootstrap 3, supplied via maxcdn
   * medoo, supplied via file in include/
   * jquery 1.11.1, supplied via google's CDN
