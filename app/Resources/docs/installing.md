# Installing Overwatch
## Requirements
- PHP 5.4 or higher
- MySQL & the PDO-MySQL PHP extension, or any [other combination compatible with the Doctrine ORM](http://www.doctrine-project.org/2010/02/11/database-support-doctrine2.html)
- A web server to serve the frontend interface (such as Apache or Nginx)

##Installation
1. Download a copy of an Overwatch release [here](https://github.com/zsturgess/overwatch/releases/latest) (You should be downloading the copy that has a filename like `overwatch-VERSION.tar.gz`) and unpack the project in a location of your choosing.
2. Set up a database for overwatch to use. (Overwatch expects a MySQL database by default, although you can change the driver for doctrine in the next step)
3. Edit the details in the `app/config/parameters.yml` file, or alternatively provide them as environment variables prefixed with `OVERWATCH_` - for example `OVERWATCH_MAILER_FROM`
4. Run `php app/console doctrine:schema:create` to initialise the database.
5. Configure a web server, ensuring the document root is set to the web/ folder. (If you use nginx, a sample nginx configuration file is included in `app/Resources/docs/nginx.conf.sample`)

**Installing from source?**

If you are using the *Source code* download option, or are cloning the project using git, you may need to take these extra steps whilst installing:
- You may need to create the `app/config/parameters.yml` file based on the template `app/config/parameters.yml.dist`
- You will need to download [Composer](http://getcomposer.org/) and run `php composer.phar install` to install all the PHP dependencies between steps 3 and 4.

##Set-up
###Creating the first user
1. Run `php app/console fos:user:create --super-admin` to create the first user as a super administrator.
   **Note:** Overwatch has no concept of usernames, whatever you type will be overwritten with your e-mail address. If any commands request your username from this point, provide your e-mail address instead.
2. You should now be able to log into the Overwatch dashboard with the e-mail address and password you chose to configure the rest of your users, as well as your tests and groups.

###Running the tests
> If there is a warning on the Overwatch dashboard directing you here, it is likely that your system administrator has not scheduled the test runner as laid out below.

Tests are run with `php app/console overwatch:tests:run` and it is recommended to schedule it (crond on linux, or launchd on OSX). Some expectations (such as `toPing`) may require that the command be run with admin rights, so if you plan on using them ensure the task is scheduled to run in a way and by a user that runs it with admin rights. If Overwatch detects that the average age of the most recent test result is greater than 6 hours, a warning will be shown on the dashboard.

###Cleaning up results
Old results are cleaned up with `php app/console overwatch:results:cleanup`. By default, the command will perform no operation. You should pass the `--delete` and/or `--compress` options to configure what operations the command will apply.

####Deleting old results
If you want to delete all items that are older than a certain given age, use the `--delete` option. Any value that could be used to construct a PHP DateTime object is accepted.

Examples:
 - `php app/console overwatch:results:cleanup --delete="2015-09-01 05:00:00"` will delete all results older than the given timestamp
 - `php app/console overwatch:results:cleanup --delete="-6 months"` will delete all results older than 6 months
 - `php app/console overwatch:results:cleanup --delete="last year"` will delete all results older than the start of the current year

####Compressing old results
Overwatch can "compress" history by deleting test results that did not represent a change with the `--compress` option. Any value that could be used to construct a PHP DateTime object is accepted.

For example, a test history of: (1) PASS, (2) PASS, (3) PASS, (4) FAIL, (5) PASS
Would compress to: (4) FAIL, (5) PASS

Examples:
 - `php app/console overwatch:results:cleanup --compress="2015-09-01 05:00:00"` will compress all results older than the given timestamp
 - `php app/console overwatch:results:cleanup --compress="-3 months" --delete="last year"` will compress all results older than 3 months and delete all results older than the start of the current year

####Archiving old results
You can combine the `--delete` and/or `--compress` options with the `--archive` option. The `--archive` option takes no value.

When provided `--archive` will backup any test results into a text file stored at `app/logs/overwatch_archive_YYYYMMDDHHIISS.log` prior to deleting them.

Examples:
 - `php app/console overwatch:results:cleanup --archive --compress="2015-09-01 05:00:00"` will compress all results older than the given timestamp
 - `php app/console overwatch:results:cleanup --archive --compress="-3 months" --delete="last year"` will compress all results older than 3 months and delete all results older than the start of the current year
