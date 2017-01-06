# feedreader3
This a simple PHP RSS/Atom feed reader with both a PHP interface and a JQuery Mobile interface for mobile devices. 

Feeds go in feeds.txt, one per line. Edit the file, git push if you're in OpenShift, reload the page. 
Obviously, this could/should be protected by basic auth and HTTPS, Stanford WebAuth, or any other authentication mechanism you desire. 

With minor path changes, this has been deployed to AFS, OpenShift v2 (php-5.4 cartridge), and OpenShift v3 (php-5.6 image)


