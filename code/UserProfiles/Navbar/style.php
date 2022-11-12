<?php
function navstyle(){
?>
    <style>
        #side_nav{
        background: #2f6d8b;
        min-width: 25px;
        max-width: 250px;
        transition: all 0.3s;
        z-index: 2;
        }
        .sidebar{
        width : 200%;
        }

        .sidebar li.active{
        background: #eee;
        border-radius: 8px;
        }
        .sidebar li.active a, .sidebar li.active a:hover{
        color: #000;
        }
        .sidebar li a{
        color: #fff;
        font-size: large;
        }
        .sidebar li a:hover{
        background: #fff;
        color : black;
        
        }

        @media(min-width:0px){
            #side_nav{
                margin-left: -250px;
                position: fixed;
                min-height: 100vh;
                z-index: 2;   
            }
            #side_nav.active{
                margin-left: 0;
            }
        }
    </style>   
<?php
}
?>