<style>
.header-main
{
    width:100%; display:block; padding:0px; margin:0px; height:120px;
    background: -webkit-linear-gradient(left, #F2633A , #E3243F); /* For Safari 5.1 to 6.0 */
    background: -o-linear-gradient(right, #F2633A, #E3243F); /* For Opera 11.1 to 12.0 */
    background: -moz-linear-gradient(right, #F2633A, #E3243F); /* For Firefox 3.6 to 15 */
    background: linear-gradient(to right, #F2633A , #E3243F); /* Standard syntax */
}
.header-main .logo-area
{
    display:inline-block; padding-top:35px; padding-bottom:0px; width:200px;
}
.header-main .last-logo-area
{
    display:inline-block; padding-top:0px; padding-bottom:0px; width:200px;
}
.header-main .navs-area
{
    display:inline-block; vertical-align:top; width:760px; border:solid 0px #000;
}
.header-main .navs-area ul
{
    list-style:none; padding:0px; margin:0px; width:100%; display:inline-block; text-align:right;
}
.header-main .navs-area ul li
{
    display:inline-block; vertical-align:middle; margin:0px 70px 0px 0px; position:relative;
}

.header-main .navs-area a
{
    font-family:'Raleway'; font-size:20px; color:#fff; line-height:20px; padding:75px 25px 25px 25px; display:inline-block; text-decoration:none; background:none;
}
.header-main .logged-nav
{
    margin-left:0px;
}
.header-main .navs-area ul.logged
{
}
.header-main .navs-area ul.logged li
{
     margin:0px 20px 0px 0px;
}
.header-main .navs-area a.user
{
    /*background:url(../images/user_drop.png) no-repeat right 105px; padding-right:40px;*/
}
.header-main .navs-area .udrop
{
    position:absolute; top:110px; right:0px; background:#fff; z-index:10; display:none; border:solid 1px #ccc; text-align:left;
}
.header-main .navs-area .a.user img
{
    float:right; padding-left:10px;
}
.header-main .navs-area .udrop a
{
    width:150px; display:block; color:#2c2c2c; padding:10px; margin:0px; font-size:16px; border-bottom:solid 1px #ccc;
}
.header-main .navs-area .udrop a.last
{
    border:0px;
}
.header-main .navs-area .udrop a:hover
{
    color:#fff;
}
.header-main .navs-area a.user:hover
{
    background:url(../images/user_drop.png) no-repeat 175px 105px #313131;
}
.header-main .navs-area a:hover
{
    background:#313131;
}
.header-main .navs-area a.sel
{
    background:#313131;
}
.header-main .logo-area {
  display: inline-block;
padding-top: 0px!important;
padding-bottom: 0px;
width: 169px;
}

</style>
<div class="header-main col-lg-12 col-sm-12 col-md-12" >
    <div class="container">
        <div class="logo-area">
            <a  href="<?php echo URL::to('/student'); ?>"><img src="<?php echo URL::to('/'); ?>/public/img/logo.png" height="70px" width="100px"></a>
        </div>
        <div class="logo-area">
            <a  href="<?php echo URL::to('/student'); ?>"><img src="<?php echo URL::to('/'); ?>/public/img/header logo.png" height="120px" width="300px"></a>
        </div>
        <div class="navs-area">
                 @if(Auth::check())
                <ul class="logged">
                <li>
                    <a href="<?php echo URL::to('/student') ?>" ><strong>Instruction</strong></a> 
                </li>
                <li>
                    <a href="<?php echo URL::to('/student/test/start') ?>" ><strong>Start Test</strong></a> 
                </li>
               
                <li class="last">
                    <a href="#" id="usr-det-link"><strong>{{ucfirst(Auth::user()->displayName)}}</strong><img src="<?php echo URL::to('/'); ?>/public/img/user_drop.png" id="udet-down" /><img src="<?php echo URL::to('/'); ?>/public/img/user_drop1.png" style="display:none;" id="udet-up" /></a>
                    <div class="udrop">
                        <a href="<?php echo URL::to('/account/change-password') ?>">Change Password</a>
                        <a href="<?php echo URL::to('/account/logout') ?>" class="last">Log Out</a>
                    </div>
                </li>
               
                </li>
                </ul>
                @else
                <ul>
                <li><a href="<?php echo URL::to('/student') ?>">Instruction</a></li>
                <li><a href="<?php echo URL::to('/account/login') ?>"><strong>Login</strong></a></li>
                <li class="last"><a href="<?php echo URL::to('/account/create') ?>">SignUp</strong></a></li>
                </ul>
                @endif
                
            </ul>
        </div>
     </div>  
  
       
</div>