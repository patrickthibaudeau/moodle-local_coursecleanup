# moodle-local_coursecleanup
The course cleanup tool is used to perform global changes to courses.

#Tools
Delete all courses in a category that have not been used. That is, it only has the Course announcements activity and no grade items.

Change role from role A to B in all courses within a category.

I developed this plugin because we have to keep our courses for at least 5 years. However, I noticed that many courses that were created are empty. In order to keep the system clean, I wanted to delete these courses. However, there are too many to do manually. And so, this tool makes my life much easier. 

I also use a session which is based on how our institution identifies the courses. You may want to remove this field or change it for your institution. If that is the case, you will need to change the following file/functions

index.php
amd/src/cleanup.js (remember to run grunt if you do)
locallib.php function local_coursecleanup_reset_role()

#Using the tool
To access the tool, click on Site administration and then the Courses tab. Then click on the Category course cleanup link
