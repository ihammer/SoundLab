<!DOCTYPE html>
<html lang="en">
    
<head>
        <title>后台管理系统</title><meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="/css/bootstrap.min.css" />
		<link rel="stylesheet" href="/css/bootstrap-responsive.min.css" />
        <link rel="stylesheet" href="/css/matrix-login.css" />
        <link href="/font-awesome/css/font-awesome.css" rel="stylesheet" />
		<link href='http://fonts.useso.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
		

    </head>
    <body>
        <div id="loginbox">            
            <form id="loginform" class="form-vertical" action="">
				 <div class="control-group normal_text"> <h3>后台管理系统</h3></div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_lg"><i class="icon-user"></i></span><input id="userName" type="text" placeholder="Username" />
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_ly"><i class="icon-lock"></i></span><input id="userPwd" type="password" placeholder="Password" />
                        </div>
                    </div>
					<div class="controls">
						<span id="errMsg" style="float:right;padding-right:35px;line-height:40px;color:#d21818;"></span>
					</div>
                </div>
                <div class="form-actions">
                    <span class="pull-right"><a type="submit" id="loginButton" class="btn btn-success" /> Login</a></span>
                </div>
            </form>
        </div>
        <script src="/js/jquery.min.js"></script>  
        <script src="/js/matrix.login.js"></script> 
    </body>

</html>
