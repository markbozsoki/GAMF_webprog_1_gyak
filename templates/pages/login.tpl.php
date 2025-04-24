<div class="d-flex align-content-stretch flex-wrap align-items-top justify-content-center">
    <div class="mx-5 my-2 align-items-center justify-content-center">
        <form id="loginForm" action="?page=login&amp;login" method="POST">
            <fieldset>
                <legend>Bejlentkezés</legend>
                <input class="p-1 m-1" required type="text" name="username" placeholder="felhasználónév" autocomplete="on"><br>
                <input class="p-1 m-1" required type="password" name="current-password" placeholder="jelszó" autocomplete="on"><br>
                <input class="m-1" type="submit" name="login" value="Belépés">
            </fieldset>
        </form>
    </div>

    <div class="mx-5 my-2 align-items-center justify-content-center">
        <form id="registrationForm" action="?page=login&amp;register" method="POST">
            <fieldset>
                <legend>Regisztráció</legend>
                <input class="p-1 m-1" required type="text" name="surname" placeholder="vezetéknév"><br>
                <input class="p-1 m-1" required type="text" name="forename" placeholder="utónév"><br>
                <input class="p-1 m-1" required type="text" name="username" placeholder="felhasználónév" autocomplete="on"><br>
                <input class="p-1 m-1" required type="password" name="new-password" placeholder="jelszó" autocomplete="on"><br>
                <input class="m-1" type="submit" name="register" value="Regisztráció">
            </fieldset>
        </form>
    </div>
</div>
