# Reporting a bug or a suggestion

Despite the care given to FreshRSS, it's still possible that bugs occur. The project is young and development is dynamic, so it can be corrected quickly. You might also have a feature in mind that doesn't yet exist. Regardless whether your idea seems silly, far-fetched, useless or too specific, please don't hesitate to propose it to us! "Ideas in the air" often find an attentive ear. It's new external perspectives that make the project evolve the most.

If you're convinced that you should be heard, here's how you can go about it.

## On GitHub

GitHub is the ideal platform to submit your requests. It allows us to discuss a problem or suggestion with others and it often generates new ideas. Let's not neglect this "social" aspect!

 1. [Go to the bug ticket manager](https://github.com/FreshRSS/FreshRSS/issues)
 2. Start by checking if a similar request hasn't already been made. If so, please feel free to add your voice to the request.
 3. If your request is new, [open a new bug ticket](https://github.com/FreshRSS/FreshRSS/issues/new)
 4. Finally, write your request. If you're fluent in English, it's the preferred language because it allows for discussion with the largest number of people.
 5. Please follow the tips below to make it easier to let your ticket be heard.
 
## Informal

Not everyone likes or uses GitHub for a variety of legitimate reasons. That is why you can also contact us in a more informal way.

* On [our Mattermost chat](https://framateam.org/signup_user_complete/?id=e2680d3e3128b9fac8fdb3003b0024ee)
* At events / meetings around Free Software
* Over a beer in a bar
* Etc.

## Tips

Here are some tips to help you present your bug report or suggestion:


* **Pay attention to spelling**. Even if it's not always easy, try your best!
* **Give an explicit title to your request**, even if it's a bit long. This not only helps us understand your request, but also to find your ticket later.
* **One request = one ticket.** You may have lots of ideas while being afraid to spam the bug manager: it doesn't matter. It's better to have a few too many tickets than too many requests in one. We'll close and consolidate requests when possible.
* If you report a bug, think about **providing us with the FreshRSS logs** (accessible in the FreshRSS `data/log/` folder) and the **PHP logs** (the location may vary by distribution, but consider searching in `/var/log/httpd` or `/var/log/apache`).
* If you can't find the log files, specify it in your ticket so we know you've already searched.
* Not all bugs require logs, but if you have any doubts, it is better to provide them to us. Logs are important and very useful for debugging!
* The logs may reveal confidential information, so **be careful not to disclose anything sensitive.**

In addition, when facing a bug, you're encouraged to follow this message format (from the [Sam & Max website](http://sametmax.com/template-de-demande-daide-en-informatique/):

### What's my goal?

Give the general context of what you were trying to do.

### What have I been trying to do?

Explain step by step what you have done so that we can reproduce the bug.

### What results have I achieved?

The bug: what you see that shouldn't have happened. Here you can provide the logs.

### What was the expected result?

So that we understand what you consider to be the problem.

### What are my circumstances?

Remember to give the following information if you know it:

 1. Which browser? Which version?
 2. Which server: Apache, Nginx? Which version?
 3. Which version of PHP?
 4. Which database: SQLite, MySQL, MariaDB, PostgreSQL? Which version?
 5. Which distribution runs on the server? And... which version?