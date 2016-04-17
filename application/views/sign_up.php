<legend><h1>{page_title}</h1></legend>

<form class="ui form" method="post" action="signup/sending">
    <div class="field">
        <label>User ID</label>
        <input type="text" name="userid" placeholder="User ID"  >
    </div>
    <div class="field">
        <label>Username</label>
        <input type="text" name="username" placeholder="Enter username for display">
    </div>
    <div class="field">
        <label>Password</label>
        <input type="password" name="password1" placeholder="Password">
    </div>
    <div class="field">
        <label>Password Confirmation</label>
        <input type="password" name="password2" placeholder="Password Confirmation">
    </div>
    <button class="ui button" type="submit">Submit</button>
    <div class="ui error message"><ul class="list"><li>Please put different values for each field</li></ul></div>
</form>