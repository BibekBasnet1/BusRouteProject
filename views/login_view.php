
<div class="form-container">
    <form method="POST" action="../controller/login_inc.php" >
        <h3 style="color: black;">Sign In</h3>
        <div class="image wrong-image-login"style="text-align: right;position: relative;top: 2.5rem;right:0">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: rotate(180deg);msFilter:progid:DXImageTransform.Microsoft.BasicImage(rotation=2);"><path d="M9.172 16.242 12 13.414l2.828 2.828 1.414-1.414L13.414 12l2.828-2.828-1.414-1.414L12 10.586 9.172 7.758 7.758 9.172 10.586 12l-2.828 2.828z"></path><path d="M12 22c5.514 0 10-4.486 10-10S17.514 2 12 2 2 6.486 2 12s4.486 10 10 10zm0-18c4.411 0 8 3.589 8 8s-3.589 8-8 8-8-3.589-8-8 3.589-8 8-8z"></path></svg>
        </div>

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

<script>
    let wrongBtn = document.querySelector(".wrong-image-login");
    let formElement = document.querySelector(".form-container");


    wrongBtn.addEventListener("click", function() {
        formElement.style.display = "none";
    });
</script>