
<div class="form-container">
    <form method="POST" action="../controller/login_inc.php" >
        <h3 style="color: black;">Sign In</h3>

        <label for="username">Username</label>
        <input type="email" placeholder="Email or Phone" name = "email" id="username" required>

        <label for="password">Password</label>
        <input type="password" placeholder="Password" id="password"  name="pwd" required>

        <button class="Login-button" name="Login">Log In</button>
        <div class="social">
            <div class="go"><i class="fab fa-google"></i>  Google</div>
            <div class="fb"><i class="fab fa-facebook"></i>  Facebook</div>
        </div>
    </form>
</div>