=== aaLogWP ===
Contributors: notorioushttp
Tags: logging, benchmarking
Requires at least: 3.0
Tested up to: 3.9.1
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Allows developers to log variables, see the call stack, and benchmark code; all to a logfile, so your page won't get polluted with log messages.

== Description ==

Allows developers to log variables, see the call stack, benchmark code; all to a logfile, so your page doesn't get polluted with log messages. Each log message records the date and time, IP address, requested page, and file and line the log message came from, as well as the information to be logged.

The plugin has an options page which allows you to randomize the cookie and logfile, for security purposes; as well as turning logging on and off for a given user. (Via cookie.)

Documentation for the aaLog class can be found at the [NotoriousWebmaster blog](http://www.notoriouswebmaster.com/2013/07/01/aalog-a-logging-class-for-php/).

Documentation for the aaLogWP plugin, which includes the aaLog class, can also be found at [NotoriousWebmaster blog](http://www.notoriouswebmaster.com/aalogwp-documentation/), though on a different page.

== Installation ==

1. Upload the `aalogwp` directory to the `/wp-content/plugins/` directory;
1. Create folder 'wp-content/uploads/aalogwp/';
1. Change the permissions to the new directory with `sudo chmod 0757 wp-content/uploads/aalogwp/`;
1. Activate the plugin through the 'Plugins' menu in WordPress;
1. Turn on logging in the Settings | aaLog Options page;
1. You may now use the `$oLog` object in your code to log your variables and so forth.

== Screenshots ==

1. The aaLog Options page, which allows the user to change the cookie and filenames.
2. A sample of the output produced by aaLog. Note the filename and line number where the call to $oLog was made.

== Changelog ==

= 1.0 (2014-06-21) =
* Initial commit.

= 1.0.1 (2014-06-23) =
* Moved output directory to uploads/aalogwp/.

= 1.0.2 (2014-07-06) =
* Fixed $logdir to $aLogdir. Showed an error on some PHP installations.
* Added banners with the log lady for the repo plugin page.
