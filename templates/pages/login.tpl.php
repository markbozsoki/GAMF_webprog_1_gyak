<div>
    <form action="?page=login&amp;login" method="POST">
        <fieldset>
            <legend>Bejlentkezés</legend>
            <input required type="text" name="username" placeholder="felhasználónév" autocomplete="on"><br>
            <input required type="password" name="current-password" placeholder="jelszó" autocomplete="on"><br>
            <input type="submit" name="login" value="Belépés">
        </fieldset>
    </form>
</div>

<div>
    <form action="?page=login&amp;register" method="POST">
        <fieldset>
            <legend>Regisztráció</legend>
            <input required type="text" name="surname" placeholder="vezetéknév"><br>
            <input required type="text" name="forename" placeholder="utónév"><br>
            <input required type="text" name="username" placeholder="felhasználónév" autocomplete="on"><br>
            <input required type="password" name="new-password" placeholder="jelszó" autocomplete="on"><br>
            <input type="submit" name="register" value="Regisztráció">
        </fieldset>
    </form>
</div>