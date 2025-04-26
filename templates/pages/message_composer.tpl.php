<p>Üzenet küldés</p>

<div>
    <form id="messageComposerForm" action="?page=messaging" method="POST">
        <div>
            <input type="hidden" name="username" value=""><br>
            <input required type="text" name="name" placeholder="teljes név" values=""><br>
            <input required type="email" name="email" placeholder="email cím"><br>
            <textarea required name="message" placeholder="üzenet..." cols=50 rows=20></textarea><br>
            <input type="submit" name="send" value="Küldés">
        </div>
    </form>
</div>
