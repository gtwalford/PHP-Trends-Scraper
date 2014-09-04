PHP Google Trends Scraper
--------------------------

Small project attempting to scrape the google trends page and retrieve csv for search. Once the csv has been retireved the data is parsed and returned.
**Note: If this is run frequently you will quickly exceed the quota limit

Quick Start
-----------
- In Cred.php file input Google Username and Password
- Update trends_scrape.php with desired search term
- Run `php trends_scrape.php`

TODO
----
- Setup to run at random intervals to avoid exceeding the quota limit
- Build advanced parsing functions
- Provide URLs for multiple date ranges
- Setup for storage
- Upgrade authorization to use OAuth2
