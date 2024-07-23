<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<style>
    .modal-dialog {
        max-width: 800px;
        width: 400px;
    }
    .modal-header {
        background-color:  #cf3d3c;
        padding: 35px 0;
        text-align: center; 
        border-bottom: none; 
    }

    .modal-header h4 {
        margin: 0;
        font-size: 24px;
        color: #fff;
        display: inline-block; 
        vertical-align: middle;
        text-align:center;
    }

    .modal-header .close {
        font-size: 30px;
        color: #fff;
        position: absolute;
        right: 20px; 
        top: 10px;
    }

    .modal-body {
        padding: 40px 50px;
    }
    .custom-submit-btn {
            background-color: #cf3d3c !important; 
            height: 40px; 
            width: 200px; 
            border: 2px solid white;
            border-radius: 4px;
            font-size: 18px;
            color: white !important;
            display: block;
            margin: 0 auto;
        }
        .custom-submit-btn:hover {
            background-color: #b30000; 
            color: white !important;
        }
    .modal-footer {
        background-color: #f9f9f9;
        color: black; 
    }

    label {
        color: black;
    }

    .fas {
        color:  #cc0000;
    }

    .login-link {
        text-align: center;
    }
</style>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class="fas fa-sign-in-close"></i> &times;</button>

                <h4> Login Here</h4> 
            </div>
            <div class="modal-body">
                <form role="form">
                    <div class="form-group">
                        <input type="text" class="form-control" id="usrname" placeholder="Enter username">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="password" placeholder="Enter password">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block custom-submit-btn"> Login</button>
                        </form>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-danger btn-default pull-left" data-dismiss="modal"></i> Cancel</button>  -->
                <p style="color:black !important;">Not a member? <a href="#">Sign Up</a></p>
            
            </div>
        </div>
    </div>
</div>

<!-- JavaScript to trigger the login modal -->
<script>
    $(document).ready(function(){
        $("#loginLink").click(function(event){
            event.preventDefault();
            $("#loginModal").modal('show');
        });
    });
</script>
