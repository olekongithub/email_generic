<!-- Feel free to change any of this -->
<script type="text/javascript">

  // The ajax endpoint information and payload schema
  var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
  var action = "generic_email_submit";
  var payload = {
     "email": "",
     "secondary_optin": false,
  }

  function email_submit_success(){
    document.getElementById('submit').value = 'Thank you!';
    document.getElementById('submit').disabled = true;
    document.getElementById('email_error').innerHTML = '';
  }

  function email_submit_error(){
    document.getElementById('email_error').innerHTML = 'Error inputting your email, please try again.';
  }

  function email_signup(){
    payload.email = document.getElementById('email').value;
    payload.secondary_optin = document.getElementById('secondary_optin').checked;
    // console.log(payload);
    var json = JSON.stringify(payload);
    jQuery.ajax({
      url: ajaxurl,
      type: "POST",
      data: json,
      contentType: "application/json",
      complete: function(data, status) {
        // console.log(data, status);
        if (status == "success") {
          email_submit_success();
        }
        else {
          email_submit_error();
        }
      }
    });

  }

</script>

<div class="generic-email-widget">
  <h1>Join Our Mailing List!</h1>
  Email: <input type="text" id="email">
  <span id="email_error"></span>
  <br>
  Signup For Our Newsletter: <input type="checkbox" id="secondary_optin">
  <br>
  <input type="button" id="submit" onclick="email_signup()" value="Sign Up!">
<div>
