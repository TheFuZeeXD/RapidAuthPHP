const windowContent = document.querySelector("#ContentWindowSection");


function resetSection() {
    const contentLogin = document.querySelector(".Screen");
    contentLogin.classList.add("fadeoutLogin");
        setTimeout(() => {contentLogin.remove();
            document.write = "Reset Password";
            const resetcontent = document.createElement("div");
            resetcontent.classList.add("Screen");
            resetcontent.innerHTML = `<div class="resetPasseword">
                <h2>Forgot password?</h2>
                <?php if (!empty($error_message)): ?>
                <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
                <?php endif; ?>
                <form action="auth/resetpassword/forgot_password.php" method="post">
                <input type="email" name="email" placeholder="mail" required><br>
                <h3>Password recovery is a process by which a user can regain access to their account if they have forgotten or lost their password.</h3> 
                <p onclick="loginSection()">I'll try to log in</p>
                <button type="submit">Reset</button>
                </form>
                </div>`;
            windowContent.append(resetcontent);

        },1500)
}

function loginSection() {
    const contentLogin = document.querySelector(".Screen");
    contentLogin.classList.add("fadeoutLogin");
        setTimeout(() => {contentLogin.remove();
            document.write = "Login";
            const resetcontent = document.createElement("div");
            resetcontent.classList.add("Screen");
            resetcontent.innerHTML = `<div class="LogIn">
               <h2>Login</h2>
               <?php if (!empty($error_message)): ?>
                <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
                <?php endif; ?>
                <form action="auth/authorization/login.php" method="post">
                <input type="text" name="username" placeholder="username" required><br>
                <input type="password" name="password" placeholder="password" required><br>
                <p onclick="resetSection()">Forgot password?</p>
                <button type="submit">Login</button>
                <h3 onclick="RegisterSection()">I don't have account</h3>     
                </form>
                </div>`;
            windowContent.append(resetcontent);

        },1500)
}

function RegisterSection() {
    const contentLogin = document.querySelector(".Screen");
    contentLogin.classList.add("fadeoutLogin");
        setTimeout(() => {contentLogin.remove();
            document.write = "Registration";
            const resetcontent = document.createElement("div");
            resetcontent.classList.add("Screen");
            resetcontent.innerHTML = `<div class="Register">
                <h2>Registration</h2>
                <?php if (!empty($error_message)): ?>
                <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
                <?php endif; ?>
                <form action="auth/registration/register.php" method="post">
                <input type="email" name="email" placeholder="enter mail" required><br>
                <input type="text" name="username" placeholder="enter login" required><br>
                <input type="password" name="password" placeholder="enter password" required><br>
                <p onclick="loginSection()">I have account</p>
                <button type="submit">Next</button>
                </form>
                </div>`;
            windowContent.append(resetcontent);

        },1500)
}
