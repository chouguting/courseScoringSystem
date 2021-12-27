
<?php
include('header.php');?>

<header class="mdc-top-app-bar">
    <div class="mdc-top-app-bar__row">
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
            <button class="material-icons mdc-top-app-bar__action-item mdc-icon-button"  onclick='history.back()'>arrow_back</button>
            <span class="mdc-top-app-bar__title">用戶註冊</span>
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

    <h3 class="black-text">用戶註冊</h3>
    <div class="row">
        <form class="col s6 offset-s3" action="registration.php" method="post">
            <div class="row">
                <div class="input-field col s12">
                    <textarea id="textarea1" class="materialize-textarea"  type="text" name="username"></textarea>
                    <label for="textarea1">帳號</label>
                </div>
                <div class="input-field col s12">
                    <textarea id="textarea1" class="materialize-textarea"  type="text" name="display_name"></textarea>
                    <label for="textarea1">用戶(顯示)名稱</label>
                </div>
                <div class="input-field col s12">
                    <textarea id="textarea1" class="materialize-textarea"  type="text" name="password"></textarea>
                    <label for="textarea1">密碼</label>
                </div>
                <div class="input-field col s12">
                    <textarea id="textarea1" class="materialize-textarea"  type="text" name="password_check"></textarea>
                    <label for="textarea1">再次確認密碼</label>
                </div>
            </div>
            <input class=" btn waves-effect waves-light btn-small margin5" type="submit"  name="submit" value="註冊">
                    
        </form>
    </div>


</center>

<?php
include('footer.php');
?>


