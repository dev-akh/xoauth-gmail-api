<?php 
?>
<style>
    .container{
        padding:0px 10%;
        text-align:center;
    }
    .text-center{
        text-align:center;
    }
    .btn{
        border-width:1px;
        border-style:solid;
        border-radius:10%;
        padding:10px 20px;
        text-decoration:none;
        font-weight :bold;
    }
    .btn-primary{
        background: #2033FF;
        color:white;
    }
    .btn-success{
        background: #20BF33;
        color:white;
    }
    .form-group{
        display: inline-block;
        width:60%;
        text-align:left;
        padding:10px;
    }
    .form-group>label{
        width:300px;
        display: inline-block;
    }
    .form-group>input{
        width:100%;
        height:30px;
    }
</style>
<div class="container">
    <h3 class="text-center">Generate Refresh Token and Sending Mail</h3>
    <form action="/get_oauth_token.php?provider=Google" method="post">
        <div class="form-group">
            <label for="email">Email : </label>
            <input type="text" name="email" id="" placeholder="Enter Email">
        </div>
        <div class="form-group">
            <label for="clientid">Client ID : </label>
            <input type="text" name="clientId" id="" placeholder="Enter Client ID">
        </div>
        <div class="form-group">
            <label for="email">Client Secret : </label>
            <input type="text" name="clientSecret" id="" placeholder="Enter Client Secret">
        </div><br>
        <button type="submit" class="btn btn-primary" target="_blank">Generate</button><br><br>
    </form>
    
</div>
