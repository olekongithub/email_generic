# Generic Email Signup Plugin
Generic Corp is interested in capturing email addresses on their Wordpress sites and wants you and your team to build a plugin that allows content creators to pepper their posts with email signup widgets.

## Requirements:
- A content creator must be able to add a shortcode to any public facing page or post.
- This shortcode must have an input box, submit button, and checkbox designating whether or not a user wants to sign up for a secondary newsletter.
- Upon submit, the widget must use an ajax call and post a JSON object to the Wordpress backend.
- On the backend, the emails and options will be saved to a new database table.
- Once the email has been submitted, the widget should show a confirmation message or error message.
- Add svg logo before the form and change the color of it. 

## Your task:
Your team begins work on the plugin.  Your co-worker starts by creating the backend of the plugin.  He's going on vacation and asked you to help finish the plugin.  The current state of the plugin is as follows:
- The function and hook that registers the shortcode has been completed. Use `[ generic-email ]`
- The database table has been created.
- The AJAX endpoint has been created. The ajaxurl and template has been added to the template.  Please POST the payload to this endpoint.

Complete as much of the plugin as you can in **2 hours**.  You will **not** be penalized if you can not finish in time.  

Feel free to contact us with any questions.    
