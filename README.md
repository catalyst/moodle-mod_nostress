# No Stress! #

This is a moodle activity module that is used for mininature load test with
very specific stress patterns use to ensure that the course mod info cache
is not only working correctly but correctly under sustained load even while
being actively edited in a variety of ways.


Make a test course:


```sh
# Turn on guest access
php admin/cli/cfg.php --component=enrol_guest --name=status --set=0

# Make a test course
php public/admin/tool/generator/cli/maketestcourse.php --size=S --shortname=nostress --additionalmodules=nostress

# Do a small load to warm all caches and get a baseline for normal views
ab -c 1 -n 3 https://main.localhost/course/view.php?name=nostress

# Now set the delay to 100 ms
php admin/cli/cfg.php --component=mod_nostress --name=delay --set=100

# Load the course just once, this will take around 1.4 seconds (100 x 10 in delays)
php admin/cli/purge_caches.php --courses
ab -c 1 -n 1 https://main.localhost/course/view.php?name=nostress

# Load the course with lots of concurrency, this has a 90% of around 1.4 seconds BUT we'll get it much faster
php admin/cli/purge_caches.php --courses
ab -c 10 -n 10 https://main.localhost/course/view.php?name=nostress
```


```sh
# Delete the test course
php admin/cli/delete_course.php --non-interactive --disablerecyclebin  --courseshortname=nostress
```

