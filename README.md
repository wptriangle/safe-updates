# Safe Updates

### Backstory
Recently, WordPress 5.3 came out which included quite a good number of outstanding improvements. I was excited and updated few of my installations only to find out that some of them ran into fatal errors.  Upon investigation, I discovered some plugins which were conflicting simply because they were not tested and incompatible with the update. I wondered, only if there was a plugin which could warn me about plugins or themes that might have not been tested, just before I tried to run updates.

Thus, I decided to build ***Safe Updates***, a small nifty WordPress plugin which lets you know if there are any plugin or theme on your installation that might have not been tested with the target WordPress version before you try to update.

### Use Cases
The use case of this plugin is very straight-forward. It just gives you an idea about untested plugins or themes that may be untested with the updated WordPress versions and helps you be cautious for conflicts and errors.

### Core Features
The core features of this plugin include:

1. Display active plugin(s) that might have not been tested with the target WordPress version.
2. Show if the current theme has not been tested with the target WordPress version.

### Notes
Some notes to consider while using this plugin:

1. The interface only shows up when a core update is available.
2. A plugin/theme author might choose **not to** disclose the WordPress version up to which it might have been tested up to. In such a case, a plugin/theme might still be incompatible with the targetted update, but ***Safe Updates*** might not show it if its author didn't disclose its tested up to version.
