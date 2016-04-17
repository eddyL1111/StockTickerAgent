<legend><h1>{page_title}</h1></legend>

<form class="ui form" method="post" action="">
    <div class="field">
        <label>Team</label>
        <input type="text" name="userid" placeholder="Enter team ID"  >
    </div>
    <div class="field">
        <label>Name</label>
        <input type="text" name="username" placeholder="Enter team name">
    </div>
    <div class="field">
        <label>Password</label>
        <input type="password" name="password" placeholder="Password">
    </div>
    
    <button class="ui button" type="submit">Connect</button>
    <div class="ui error message"><ul class="list"><li>Please put different values for each field</li></ul></div>
</form>

<br/>
<p>Note: Different page should display if successfully connected.
    <br/> -Check server status.
    <br/> -Password was incorrect.
</p>


