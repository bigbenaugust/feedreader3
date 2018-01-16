# feedreader3
This a simple PHP RSS/Atom feed reader with both a PHP interface and a JQuery Mobile interface for mobile devices. Most development happens on the JQM version of the page. 

There are four files that get used to build the JQM version of the page: 
1. feeds.txt - A list of RSS or Atom feeds. One per line, URL only.  
2. fortunes.txt - A list of sayings, etc, that go at the top of the page. One per line. 
3. weather.txt - A list of weather sites that builds the weather menu. 
4. links.txt - A list of bookmarks to go in the "Bookmarks" menu. 

The last two are in a csv format like so:

Nickname,http://www.address.com

Feeds are in feeds.txt, one per line. Edit the file, git commit, git push if you're in OpenShift, reload the page. 
Obviously, this could/should be protected by basic auth and HTTPS, Stanford WebAuth, or any other authentication mechanism you desire. 

With minor path changes, this has been deployed to AFS, OpenShift v2 (php-5.4 cartridge), and OpenShift v3 (php-5.6 image and php-7.0 image)
