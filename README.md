# No Stress! #

This is a moodle activity module that is used for mininature load test with
very specific stress patterns use to ensure that the course mod info cache
is not only working correctly but correctly under sustained load even while
being actively edited in a variety of ways.


Make a test course:

```sh
php public/admin/tool/generator/cli/maketestcourse.php --size=S --shortname=nostress --additionalmodules=nostress
```

Delete the test course

```
php admin/cli/delete_course.php --non-interactive --disablerecyclebin  --courseshortname=nostress
```

