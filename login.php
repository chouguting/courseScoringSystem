
<?php
include('header.php');?>

<header class="mdc-top-app-bar">
    <div class="mdc-top-app-bar__row">
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
            <button class="material-icons mdc-top-app-bar__action-item mdc-icon-button"  onclick=location.href="index.php">arrow_back</button>
            <span class="mdc-top-app-bar__title">用戶登入</span>
        </section>
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end" role="toolbar">
        </section>
    </div>
</header>

<center>

    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>

    <h3 class="black-text">用戶登入</h3>
    <div class="row">
        <form class="col s6 offset-s3">
            <div class="row">
                <div class="input-field col s12">
                    <textarea id="textarea1" class="materialize-textarea"></textarea>
                    <label for="textarea1">帳號</label>
                </div>
            </div>
        </form>
    </div>
    <div class="row">
        <form class="col s6 offset-s3">
            <div class="row">
                <div class="input-field col s12">
                    <textarea id="textarea1" class="materialize-textarea"></textarea>
                    <label for="textarea1">密碼</label>
                </div>
            </div>
        </form>
    </div>

    <a class="waves-effect waves-light btn-small margin5" onclick=location.href="courseList.php">用戶登入</a>
    <a class="waves-effect waves-light btn-small margin5" onclick="location.href='mipsEmulator.html';">忘記密碼</a>
    <a class="waves-effect waves-light btn-small margin5" onclick="location.href='mipsEmulator.html';">註冊</a>
</center>

<?php
include('footer.php');
?>


