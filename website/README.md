# TKONSERVER
*AssaultCube analysis without modifying the server executable. Features high detail statistics.*

This is the website bit of the project, the actual end user interface. It has detailed statistical views and features a personal profile, rankings, totals, and a lot more.

I personally wanted the website to load fast and since the first design didn't support that strategy I was forced to store data in a different way, calculating totals every night so the whole log wouldn't be nescesary. (After a week loading times tripled because the log, which is loaded every time, was over 15 megabytes)

Totals are updating live though, but they do so by adding the current totals to the small daily log. (If you don't understand, don't worry it's not important at all :P)

Feel free to edit the user interface, send me some pull requests and I'll most likely accept them.

### The result can be viewed live at: [tkonserver.tk](http://tkonserver.tk)