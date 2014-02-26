This was a music lyric website developed for a TAFE assignment in 2009. The whole system uses JavaScript to dynamically load the pages and navigation throughout the site.\
I created the architecture, and it doesn't use a framework. It follows the MVC principal, by seperating the Business Classes (classes folder), View Layer (modules folder), and also Logic (processing).
The jQuery ajax invokes the scripts that are within the processing directory, which will then use the classes and / or display the modules.
The MySQL dump file is included. Upload to a directory, and change the database config settings within (script/classes/DB.class.php).

Kind regards,
Lance.